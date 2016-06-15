<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class MODcertificados extends CI_Model {

	    function __construct(){        
	        parent::__construct();
	        $this->load->library("danecrypt");	   
	    }
            
	    /**
	     * Obtiene estado del usuario. ACTIVO o RETIRADO
	     * @author BMOTTAG
	     * @since  14/02/2016
	     */
	    function obtenerEstadoById($idUsuario){
                    $SQL = "SELECT ESTADO
                            FROM RH.V_INFOFUNCIONARIOS VM
                            INNER JOIN CERT_USUARIO U ON U.NUM_IDENT = VM.NUMERO_IDENTIFICACION
                            WHERE U.ID_USUARIO = $idUsuario";
                    $query = $this->db->query($SQL);

                    $row = $query->row();
                    $estado = $row->ESTADO;                         

                    $this->db->close();
                    return $estado;
                    
	    }            
            
	    /**
	     * Lista de tipo de certificaciones 
	     * @author BMOTTAG
	     * @since  02/03/2016
	     */
	    function obtenertiposcer(){
                    $tipocer = array();
                    $sql = "SELECT * FROM CERT_TIPO_CERTIFICADO WHERE ESTADO = 1 ORDER BY ID_TIPO_CERTIFICADO";
                    $query = $this->db->query($sql);

                    $i=0;
                    if ($query->num_rows() > 0)
                    {
                            foreach ($query->result() as $row)
                            {
                                    $tipocer[$i]["ID_TIPO"] = $row->ID_TIPO_CERTIFICADO;
                                    $tipocer[$i]["TIPO_CERTIFICADO"] = $row->TIPO_CERTIFICADO;
                                    $i++;
                            }

                    }
                    $this->db->close();

                    return $tipocer;
	    }
	    
	    /**
	     * Valida que la solicitud radicada no exista en estado de pendiente 
	     * @author Angela Liliana Rodriguez Mahecha
	     * @since  Julio 01 / 2015
	     */
	    public function existesolicitud($usu, $tipocer){
                    $result = false;
                    $sql = "SELECT * FROM CERT_FORM_CERTIFICADOS WHERE ID_USUARIO = '$usu' AND ID_TIPO_CERTIFICADO='$tipocer' AND ESTADO='1'";
                    $query = $this->db->query($sql);
                    if ($query->num_rows() > 0){
                            $result = true;
                    }
                    $this->db->close();
                    return $result;
	    }
            
	    /**
	     * Validar si el certificado se genera automaticamente o no
	     * @author BMOTTAG
	     * @since  11/03/2016
	     */            
	    function verificarDescarga($tipocer){

                    $sql = "SELECT AUTOMATICO FROM CERT_TIPO_CERTIFICADO WHERE ID_TIPO_CERTIFICADO = $tipocer";
                    $query = $this->db->query($sql);

                    $row = $query->row();
                    $automatico = $row->AUTOMATICO;                         

                    $this->db->close();
                    return $automatico;
                    
	    }            
	    
	    /**
	     * Inserta - Agrega la solicitud del certificado
	     * @author Angela Liliana Rodriguez Mahecha
	     * @since  Julio 01 / 2015
	     */
	    public function agregarCertificado($estado){
	    	$result = false;

                $codigo = $this->danecrypt->generarPassword();
                $codigo = $this->danecrypt->decode($codigo);
                
                $idusuario = $this->session->userdata("id");
		$tipocer = $this->input->post("tipo_certi");
                $entidad = strtoupper($this->input->post("txtEntidad"));

                
                $salario = $this->input->post("salario")?1:0;
                $nit = $this->input->post("nit")?1:0;
                $encargo = $this->input->post("encargo")?1:0;
                
	    	$sql = "INSERT INTO CERT_FORM_CERTIFICADOS (ID_CERTIFICADO, ID_USUARIO, ID_TIPO_CERTIFICADO, ESTADO, FECHA_RADICADO, SALARIO, NIT, ENCARGO, ENTIDAD, CODIGO_VALIDACION)
	    	VALUES (SEQ_FROM_CERTIFICADOS.Nextval, '$idusuario', '$tipocer', '$estado', SYSDATE, '$salario', '$nit', '$encargo', '$entidad', '$codigo')";
	    	$query = $this->db->query($sql);
	    	if ($query){
			$sql = 'SELECT MAX(ID_CERTIFICADO) "MAX" FROM CERT_FORM_CERTIFICADOS';
			$query = $this->db->query($sql);
			$row = $query->row();
			$idRegistro = $row->MAX;
    
                        $result = $idRegistro;
	    	}
	    	$this->db->close();
	    	return $result;
	    }
	    
	    /**
	     * Obtiene los datos del usuario filtro por cedula guardada en sesion
	     * @author BMOTTAG
	     * @since  07/03/2016
	     */
	    public function obtenerDatosUsuario(){

                    $cedula = $this->session->userdata("cedula");
                
                    $consulta = "to_char(VM.FECHA_INGRESO,'dd " .  '"de " fmmonth " de " yyyy' . "')";

                    $SQL = "SELECT $consulta FECHA, VM.NOMBRES, VM.PRIMER_APELLIDO, VM.SEGUNDO_APELLIDO, VM.CARGO_NOM, VM.CARGO_ACTUAL, 
                            VM.SEXO, VM.NUMERO_IDENTIFICACION, VM.TIPONOMBRAMIENTO, VM.DESCCARGO,  VM.DESCCARGO_ACTUAL, VM.ASIGNACION_BASICA_ACTUAL
                            FROM RH.VM_REPCONSPLANTA VM
                            WHERE VM.NUMERO_IDENTIFICACION= $cedula";
                    $query = $this->db->query($SQL);

                    if($query->num_rows() >= 1){
                            return $query->row_array();
                    }else return false;                  
	    }
            
	    /**
	     * Obtiene los datos del usuario RETIRADO filtro por cedula guardada en sesion
	     * @author BMOTTAG
	     * @since  07/03/2016
	     */
	    public function obtenerDatosUsuarioRetirado(){

                    $cedula = $this->session->userdata("cedula");
                
                    $consulta = "to_char(VM.FECHA_INGRESO,'dd " .  '"de " fmmonth " de " yyyy' . "') FECHA, ";
                    $consulta .= "to_char(VM.FECHA_RETIRO,'dd " .  '"de " fmmonth " de " yyyy' . "') FECHA_RETIRO";

                    $SQL = "SELECT $consulta, VM.NOMBRES, VM.PRIMER_APELLIDO, VM.SEGUNDO_APELLIDO, 
                            VM.SEXO, VM.NUMERO_IDENTIFICACION, VM.DESCCARGO, VM.CARGO_NOM
                            FROM RH.VM_REPRETIRADOS VM
                            WHERE VM.NUMERO_IDENTIFICACION= $cedula";
                    $query = $this->db->query($SQL);

                    if($query->num_rows() >= 1){
                            return $query->row_array();
                    }else{ return false; }               
	    }     
            
	    /**
	     * Obtiene los datos del usuario filtro por id del usuario
	     * @author BMOTTAG
	     * @since  08/03/2016
	     */
	    public function obtenerDatosUsuarioById($idUsuario){
                
                    $consulta = "to_char(VM.FECHA_INGRESO,'dd " .  '"de " fmmonth " de " yyyy' . "')";

                    $SQL = "SELECT $consulta FECHA, VM.NOMBRES, VM.PRIMER_APELLIDO, VM.SEGUNDO_APELLIDO, VM.CARGO_NOM, VM.CARGO_ACTUAL, 
                            VM.SEXO, VM.NUMERO_IDENTIFICACION, VM.TIPONOMBRAMIENTO, VM.DESCCARGO, VM.DESCCARGO_ACTUAL, VM.ASIGNACION_BASICA_ACTUAL
                            FROM RH.VM_REPCONSPLANTA VM
                            INNER JOIN CERT_USUARIO U ON U.NUM_IDENT = VM.NUMERO_IDENTIFICACION
                            WHERE U.ID_USUARIO = $idUsuario";
                    $query = $this->db->query($SQL);

                    if($query->num_rows() >= 1){
                            return $query->row_array();
                    }else return false;                
                    
	    }            
            
	    /**
	     * Obtiene los datos del certificado filtro por id Certificado
	     * @author BMOTTAG
	     * @since  08/03/2016
	     */
	    public function obtenerDatosCertificado($idCertificado){
                
                    $consulta = "to_char(FECHA_RADICADO,'dd " .  '"de " fmmonth " de " yyyy' . "')";

                    $SQL = "SELECT C.ID_CERTIFICADO, C.ID_USUARIO, C.SALARIO, C.NIT, C.ENCARGO, C.ENTIDAD, C.CODIGO_VALIDACION, 
                            $consulta FECHA, U.NUM_IDENT, U.NOMBRES, U.APELLIDOS, U.CORREO, T.TIPO_CERTIFICADO
                            FROM CERT_FORM_CERTIFICADOS C
                            INNER JOIN CERT_USUARIO U ON U.ID_USUARIO = C.ID_USUARIO
                            INNER JOIN CERT_TIPO_CERTIFICADO T ON T.ID_TIPO_CERTIFICADO = C.ID_TIPO_CERTIFICADO
                            WHERE C.ID_CERTIFICADO = $idCertificado";
                    $query = $this->db->query($SQL);

                    if($query->num_rows() >= 1){
                            return $query->row_array();
                    }else return false;	                

	    }       
            
	    /**
	     * Obtiene los datos del certificado filtro por id Certificado
	     * @author BMOTTAG
	     * @since  08/03/2016
	     */
	    public function obtenerParametricas(){
                
                    $sql = 'SELECT * FROM CERT_PARAMETRICAS';
                    $query = $this->db->query($sql);
                    return $query->result_array();

	    }              
	    
	    
	}
