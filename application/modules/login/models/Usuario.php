<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Modelo para la validación de ingreso de usuarios al aplicativo  
	 * @author DMDiazF
	 * @since  13/10/2015	 
	 **/

class Usuario extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->library("danecrypt");
	}
	
	
	/**
	 * Valida que la fecha de ingreso del usuario esté dentro de los límites de inicio / cierre de la encuesta
	 * En caso de no estarlo lo redirecciona al módulo de cierre y le informa que la encuesta ya ha sido cerrada
	 * @author dmdiazf
	 * @since  20/01/2016
	 */
	public function validaCierreFechas($inicio, $fin){
		$result = false;
		$sql = "SELECT CASE(DUMMY)
         				WHEN 'X' THEN 1
         				ELSE 0
       			END result  
				FROM dual
				WHERE SYSDATE BETWEEN TO_DATE('$inicio','yyyy-mm-dd') AND TO_DATE('$fin','yyyy-mm-dd')";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			$row = $query->row();
			if ($row->RESULT == 1){
				$result = true;
			}
		}
		$this->db->close();
		return $result;
	}
	
	
	
	
	/**
	 * Valida que el login / contraseña de un usuario sea auténtico y que se encuentre registrado en la base de datos
	 * Contraseña Sin Encriptar
	 * @author DMDiazF
	 * @since  13/10/2015
	 **/
	public function validarUsuario($login, $password){
		$result = false;
		$sql = "SELECT *
		        FROM cnp_admin_usuarios
		        WHERE usuario = '$login'
		        AND estado = 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				if (strcmp($row->CLAVE, $password)===0){					
					$sessionData = array("auth" => "OK",
										 "id" => $row->ID_USUARIOS,
										 "usuario" => $row->USUARIO,
										 "clave" => $row->CLAVE,
										 "tipo_usuario" => $row->TIPO_USUARIO,
										 "estado" => $row->ESTADO,
										 "fecha_creacion" => $row->FECHA_CREACION,
										 "fecha_expiracion" => $row->FECHA_EXPIRACION,
										 "numform" => $row->NRO_ENCUESTA_FORM,
										 "visita" => $visita);					
					$this->session->set_userdata($sessionData);
					$result = true;
				}
			}
		}
		$this->db->close();
		return $result;
	}
	
	/**
	 * Valida que el login / contraseña de un usuario sea auténtico y que se encuentre registrado en la base de datos
	 * Contraseña Encriptada
	 * @author DMDiazF	
	 * @since  13/10/2015
	 **/
	public function validarUsuarioCRYPT($login, $password){		
	    	$result = false;
	    	$login = str_replace(array("<",">","[","]","*","^","'","="),"",$login);   
	    	$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$password); 
	    	$sql = "SELECT * FROM CERT_USUARIO WHERE LOWER(CORREO) = LOWER('$login')";
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){	    		
	    		$encrypt = $this->danecrypt->encode($passwd);
	    		foreach($query->result() as $row){
                            
                            
                            $cedula = utf8_decode($row->NUM_IDENT);
                            //verifocar si es usuario activo o retirado
                            $sql = "SELECT ESTADO FROM RH.V_INFOFUNCIONARIOS WHERE NUMERO_IDENTIFICACION = '$cedula'";
                            $query = $this->db->query($sql);  
                            $fila = $query->row();
                            $estado = $fila->ESTADO;                             
                            
	    			if (strcmp($row->CLAVE, $encrypt)===0){
					$sessionData = array("auth" => "OK",
                                                            "id" => $row->ID_USUARIO,
                                                            "cedula" => $cedula,                
                                                            "nombre" => $row->NOMBRES,
                                                            "apellidos" => $row->APELLIDOS,
                                                            "mail_usuario" => $row->CORREO,
                                                            "estado" => $estado,
                                                            "rol" => $row->TIPO_USUARIO
                                                            );
					$this->session->set_userdata($sessionData);
					$result = true;                                    
	    			}	    			
	    		}
	    	}
	    	$this->db->close();	    	
	    	return $result;

	}
        
	/**
	 * Valida que el login / contraseña de un usuario sea auténtico y que se encuentre registrado en la base de datos
	 * Contraseña Encriptada
	 * @author DMDiazF	
	 * @since  13/10/2015
	 **/
	public function validarCodigo($idCertificado, $codigo){		
	    	$result = false;

	    	$sql = "SELECT * FROM CERT_FORM_CERTIFICADOS WHERE ID_CERTIFICADO = $idCertificado";
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){	    		
	    		foreach($query->result() as $row){
	    			if (strcmp($row->CODIGO_VALIDACION, $codigo)===0){
					$sessionData = array("auth" => "OK",
                                                            "idCertificado" => $idCertificado);
					$this->session->set_userdata($sessionData);
					$result = true;                                    
	    			}	    			
	    		}
	    	}
	    	$this->db->close();	    	
	    	return $result;

	}        
	
	/**
	 * Luego de que el usuario y contraseña han sido validados, se redirecciona al usuario a cada módulo que corresponde según el rol de usuario.
	 * @author DMDiazF
	 * @since  13/10/2015
	 */
	public function redireccionarUsuario(){
		$rol = $this->session->userdata("tipo_usuario");
		switch($rol){
			case 'F': //Fuente
					  $controller = "inicio";
					  break;
			default:  //Login
					  $controller = "login";
					  break;				  
		}
		redirect($controller,"location",301);			
	}
	
	/**
	 * Función para recordar el usuario y la contraseña de acceso al aplicativo.
	 * @author DMDiazF
	 * @since  13/10/2015
	 */
	public function recordarEmail($email){
		$data = array();
		$sql = "SELECT *
			FROM CERT_USUARIO
			WHERE LOWER(correo) = LOWER('$email')";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data["usuario"] = strtolower($row->NOMBRES);
				$data["password"] = $this->danecrypt->decode($row->CLAVE);
			}
		}
		$this->db->close();
		return $data;
	}
	
	
	/**
	 * Obtiene los nombres del usuario a partir del usuario (email)
	 * @author dmdiazf
	 * @since  28/10/2015	  
	 */
	public function obtenerDatosUsuario($email){
		$user = array();
		$sql = "SELECT P.primer_nombre, P.segundo_nombre, P.primer_apellido, P.segundo_apellido
				FROM cnp_preregistro P, cnp_admin_usuarios U
				WHERE P.nro_encuesta_form = U.nro_encuesta_form
				AND U.usuario = '$email'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$user["pnombre"] = $row->PRIMER_NOMBRE; 
				$user["snombre"] = $row->SEGUNDO_NOMBRE; 
				$user["papellido"] = $row->PRIMER_APELLIDO; 
				$user["sapellido"] = $row->SEGUNDO_APELLIDO;
			}
		}
		$this->db->close();
		return $user;
	}
	
	
	/**
	 * Inserta el registro de la visita en la tabla de visitas
	 * @author dmdiazf
	 * @since  28/10/2015
	 */
	public function guardarRegistroVisita($datosRegistro){
		$result = false;
		if ($this->db->insert("CNPV_RESULTADOS_ENTREVISTA", $datosRegistro)){
			$result = true;
		}
		$this->db->close();
		return $result;
	}
	
	
	/**
	 * Obtiene el numero de la visita que está realizando el usuario.
	 * @author Daniel M. Díaz
	 * @since  28/10/2015
	 */
	private function obtenerNumeroVisita($nro_form){
		$visita = 0;
		$sql = "SELECT COUNT(*) AS total
				FROM cnpv_resultados_entrevista
				WHERE c0i1_encuesta = $nro_form";		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){			
			foreach($query->result() as $row){
				$visita = $row->TOTAL + 1;				
			}
		}
		$this->db->close();
		return $visita;
	}
	
	/**
	 * Actualiza la tabla de resultados de la entrevista con la fecha... hora... de salida
	 * @author dmdiazf	
	 * @since  28/10/2015
	 */
	public function registroSalida($visita, $num_form){
		$estadoVisita = $this->obtenerEstadoVisitaFormulario($num_form);
		$data = array(
			"CC_HH_FIN" => date("G"),
			"CC_MM_FIN" => date("i"),
			"CC_RES_ENT" => $estadoVisita				
		);		
		$this->db->where("C0I1_ENCUESTA", $num_form);
		$this->db->where("CC_NRO_VIS", $visita);
		$this->db->update("CNPV_RESULTADOS_ENTREVISTA", $data);
	}
	
	/**
	 * Obtiene el estado general de diligenciamiento del formulario para indicar si el formulario completo diligenciado fue completo o incompleto
	 * @author dmdiazf
	 * @since  28/10/2015
	 */
	private function obtenerEstadoVisitaFormulario($num_form){
		$estado = 2; //La encuesta está incompleta. VALOR POR DEFECTO
		$sql = "SELECT sec_prereg, sec_vivi, sec_hogar, sec_pers
				FROM cnpv_admin_control
				WHERE nro_encuesta_form = $num_form";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			$row = $query->row();
			if (($row->SEC_PREREG==2)&&($row->SEC_VIVI==2)&&($row->SEC_HOGAR==2)&&($row->SEC_PERS==2)){
				$estado = 1; //La encuesta está completa
			}
		}
		$this->db->close();
		return $estado;
	}
	

}//EOC
