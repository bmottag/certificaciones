<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Modelo administrar estado de las certificaciones
	 * @author BMOTTAG
	 * @since  15/03/2016
	 **/

class MODadmin extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->library("danecrypt");
	}

	
	/**
	 * Busqueda de certificados pendientes
	 * @author BMOTTAG
	 * @since  15/03/2016
	 */
	public function busquedaCertificados($txtNroId,$txtNombre,$txtApellido){
                    $usuarios = array();
                    $sql = "SELECT C.ID_CERTIFICADO, C.ID_USUARIO, C.SALARIO, C.NIT, C.ENCARGO, C.ENTIDAD, C.CODIGO_VALIDACION, C.FECHA_RADICADO,
                            U.NUM_IDENT, U.NOMBRES, U.APELLIDOS, U.CORREO, T.TIPO_CERTIFICADO
                            FROM CERT_FORM_CERTIFICADOS C
                            INNER JOIN CERT_USUARIO U ON U.ID_USUARIO = C.ID_USUARIO
                            INNER JOIN CERT_TIPO_CERTIFICADO T ON T.ID_TIPO_CERTIFICADO = C.ID_TIPO_CERTIFICADO
                            WHERE C.ESTADO = 1 ";
                     
			if ($txtNroId!='-' && $txtNroId!='0'){
				$sql .= "AND U.NUM_IDENT = '$txtNroId' ";
			}
			if ($txtNombre!='-'){
				$sql .= "AND LOWER(U.NOMBRES) LIKE LOWER('%$txtNombre%') ";
			}
			if ($txtApellido!='-'){
				$sql .= "AND LOWER(U.APELLIDOS) LIKE LOWER('%$txtApellido%') ";
			}                        
                        
			$sql.=" ORDER BY ID_CERTIFICADO ASC ";
			//echo $sql;
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){
				$i = 0;
				foreach($query->result() as $row){
                                        $usuarios[$i]["txtNroId"] = $row->NUM_IDENT;	
                                        $usuarios[$i]["txtNombre"] = $row->NOMBRES . ' ' . $row->APELLIDOS ;
                                        $usuarios[$i]["txtEmail"] = $row->CORREO;
					$usuarios[$i]["txtTipoCert"] = $row->TIPO_CERTIFICADO;					
					$usuarios[$i]["txtFecha"] = $row->FECHA_RADICADO;
					$usuarios[$i]["txtSalario"] = $row->SALARIO;
					$usuarios[$i]["txtNit"] = $row->NIT;
                                        $usuarios[$i]["txtEntidad"] = $row->ENTIDAD;
					$usuarios[$i]["opc"] = '<a href="'.site_url("/admin/editarEstado/$row->ID_CERTIFICADO").'">Radicado</a>';

				
					$i++;
				}
			}
			$this->db->close();
			return $usuarios;
		}
                
            /**
             * Busqueda de certificados pendientes
             * @author BMOTTAG
             * @since  15/03/2016
             */
            public function busquedaCertificadosbyFecha($fechaIni,$fechaFin){
                    $usuarios = array();

                    $sql = "SELECT C.ID_CERTIFICADO, C.ID_USUARIO, C.SALARIO, C.NIT, C.ENCARGO, C.ENTIDAD, C.CODIGO_VALIDACION, C.FECHA_RADICADO,
                            U.NUM_IDENT, U.NOMBRES, U.APELLIDOS, U.CORREO, T.TIPO_CERTIFICADO, E.DESCRIPCION ESTADO
                            FROM CERT_FORM_CERTIFICADOS C
                            INNER JOIN CERT_USUARIO U ON U.ID_USUARIO = C.ID_USUARIO
                            INNER JOIN CERT_TIPO_CERTIFICADO T ON T.ID_TIPO_CERTIFICADO = C.ID_TIPO_CERTIFICADO
                            INNER JOIN CERT_ESTADOS E ON E.ID_ESTADO = C.ESTADO
                            WHERE 1 = 1 ";
                     
                    if ($fechaIni!='-' && $fechaIni!='0' && $fechaFin!='-' && $fechaFin!='0'){
                        $fechaFin = $fechaFin . ' 23:59:59';
                        $sql .= "AND C.FECHA_RADICADO BETWEEN TO_DATE ('$fechaIni', 'dd/mm/yy') AND TO_DATE ('$fechaFin', 'dd/mm/yyyy hh24:mi:ss') ";
                    }else{
                        $month = date('m');
                        $year = date('Y');
                        $fecha = date('d-m-Y', mktime(0,0,0, $month, 1, $year));                            
                        $sql .= "AND C.FECHA_RADICADO >= TO_DATE('$fecha', 'dd/mm/yy') ";
                    }

                    $sql.=" ORDER BY ID_CERTIFICADO ASC ";
                    //echo $sql;
                    $query = $this->db->query($sql);
                    if ($query->num_rows() > 0){
                            $i = 0;
                            foreach($query->result() as $row){
                                    $usuarios[$i]["txtNroId"] = $row->NUM_IDENT;	
                                    $usuarios[$i]["txtNombre"] = $row->NOMBRES . ' ' . $row->APELLIDOS ;
                                    $usuarios[$i]["txtEmail"] = $row->CORREO;
                                    $usuarios[$i]["txtTipoCert"] = $row->TIPO_CERTIFICADO;					
                                    $usuarios[$i]["txtFecha"] = $row->FECHA_RADICADO;
                                    $usuarios[$i]["txtSalario"] = $row->SALARIO;
                                    $usuarios[$i]["txtNit"] = $row->NIT;
                                    $usuarios[$i]["txtEntidad"] = $row->ENTIDAD;
                                    $usuarios[$i]["txtFecha"] = $row->FECHA_RADICADO;
                                    $usuarios[$i]["txtEstado"] = $row->ESTADO;
                                    $i++;
                            }
                    }
                    $this->db->close();
                    return $usuarios;
            }                
	
            /**
             * Obtiene datso de un certificado especifico
             * @author BMOTTAG
             * @since  15/03/2016
             */	
            public function datosCertificado($idCertificado){
		
                    $data = array();
                    $sql = "SELECT C.ID_CERTIFICADO, C.ID_USUARIO, C.SALARIO, C.NIT, C.ENCARGO, C.ENTIDAD, C.CODIGO_VALIDACION, C.FECHA_RADICADO,
                            U.NUM_IDENT, U.NOMBRES, U.APELLIDOS, U.CORREO, T.TIPO_CERTIFICADO
                            FROM CERT_FORM_CERTIFICADOS C
                            INNER JOIN CERT_USUARIO U ON U.ID_USUARIO = C.ID_USUARIO
                            INNER JOIN CERT_TIPO_CERTIFICADO T ON T.ID_TIPO_CERTIFICADO = C.ID_TIPO_CERTIFICADO
                            WHERE C.ID_CERTIFICADO = '$idCertificado'";
				 
                    $query = $this->db->query($sql);
                    
                    if($query->num_rows() > 0){
                            return $query->row_array();
                    }else return false;	 

            }
		
            /**
             * Actualiza estado de la solcitud
             * @author BMOTTAG
             * @since  17/03/2016
             */
            public function updateEstado()
            {
                    $idCertificado = $this->input->post('idCertificado');
                    $estado = $this->input->post('estado');
                    $observacion = $this->input->post('observacion');

                    $sql = "UPDATE CERT_FORM_CERTIFICADOS 
                                        SET ESTADO = $estado,
                                        FECHA_GENERADO = SYSDATE,
                                        OBSERVACIONES = '$observacion'
                                        WHERE ID_CERTIFICADO = $idCertificado";

                    $query = $this->db->query($sql);		

                    if($query){ return true; }
                    else{ return false; }
            }
            
	    /**
	     * Obtiene los datos parametricos del sistema
	     * @author BMOTTAG
	     * @since  19/04/2016
	     */
	    public function get_parametricas(){
                    $sql = 'SELECT * FROM CERT_PARAMETRICAS';
                    $query = $this->db->query($sql);
                    return $query->result_array();

	    }              
	
            /**
             * Actualiza datos parametricos
             * @author BMOTTAG
             * @since  19/04/2016
             */
            public function updateParams($datos)
            {
                    for ($i=1; $i<=count($datos); $i++){ 
                            $sql = "UPDATE CERT_PARAMETRICAS 
                                        SET VALOR = '$datos[$i]'
                                        WHERE ID_PARAMETRICA = $i";
                            $query = $this->db->query($sql);                
                    }
                    if($query){ return true; }
                    else{ return false; }
            }
            
	    /**
	     * Busca si la cedula que estan ingresando existe en funcionarios de planta
	     * @author Angela Liliana Rodriguez Mahecha
	     * @since  Julio 07 / 2015
	     */
	    function existeusuario($cedula)
	    {
                    $data = false;
                    $sql = "SELECT * FROM CERT_USUARIO
                            WHERE NUM_IDENT='".$cedula."'";
                    $query = $this->db->query($sql);
                    if ($query->num_rows() > 0)
                    {
                            foreach ($query->result() as $row)
                            {
                                    $data = array();
                                    $data["identifica"] = $row->NUM_IDENT;
                                    $data["nombres"] = $row->NOMBRES ." ". $row->APELLIDOS;
                                    $data["correo"] = $row->CORREO;
                                    $data["idUser"] = $row->ID_USUARIO;
                            }

                    }
                    $this->db->close();
                    return $data;
	    }

            /**
             * Actualiza datos datos del usuario
             * @author BMOTTAG
             * @since  25/04/2016
             */
            public function updateUser()
            {
                    $idUsuario = $this->input->post("idUsuario");
                    $correo = $this->input->post("txtEmail"); 
                    
                    $sql = "UPDATE CERT_USUARIO 
                                SET CORREO = '$correo'
                                WHERE ID_USUARIO = $idUsuario";
                    $query = $this->db->query($sql);                
                    
                    if($query){ return true; }
                    else{ return false; }
            }

            
}