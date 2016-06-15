<?php defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	 * Controlador para el módulo de Vivienda
	 * @since  22/09/2015	   
	 * @author dmdiazf
	 */

	class Login extends MX_Controller {
	
		public function __construct(){		
			parent::__construct();
			$this->load->library("danecrypt");
			$this->load->library("email");			
		}
	
		/**
		 * Muestra la pagina login
		 * @author dmdiazf
		 * @since  10/11/2015
		 */
		public function index(){

			$data["view"] = "login";
			$this->load->view("layout",$data);
		}
		
		/**
		 * Validacion y autenticacion de usuarios
		 * @author dmdiazf	
		 * @since  10/11/2015
		 */		
		public function userAuth(){			
			header("Content-Type: application/json; charset=utf-8");
			$data = array();						
			$this->load->model("usuario");
			$login = str_replace(array("<",">","[","]","^","'"),"",$this->input->post("txtUsuario"));
			$password = str_replace(array("<",">","[","]","^","'"),"",$this->input->post("txtPassword"));
			

                        if ($this->usuario->validarUsuarioCRYPT($login, $password)){

                                $data["result"] = true;
                                $data["message"] = "";
                                
                                if($this->session->userdata("rol")){
                                    $data["url"] = base_url() . "admin";
                                }else{
                                    $data["url"] = base_url() . "certificados";
                                }
                         }
                         else{
                                $data["result"] = false;
                                $data["url"] = base_url() . "login";
                                $data["message"] = utf8_encode("<strong>Usuario y/o contrase&ntilde;a errados.</strong> Intente nuevamente.");
                         }


			echo json_encode($data);
		}
                
                
                
		/**
		 * Validacion codigo de validacion
		 * @author bmottag	
		 * @since  07/03/2016
		 */		
		public function validarCodigo(){			
			header("Content-Type: application/json; charset=utf-8");
			$data = array();						
			$this->load->model("usuario");
			$txtCodigoValidacion = str_replace(array("<",">","[","]","^","'"),"",$this->input->post("txtCodigoValidacion"));

                        $tamañoID = strlen($txtCodigoValidacion) - 10;
                        $codigo =  substr($txtCodigoValidacion,-10); 
                        $idCertificado =  substr($txtCodigoValidacion,0, $tamañoID); 
                        
                        $data["result"] = false;
                        $data["url"] = base_url() . "login";
                        $data["message"] = utf8_encode("<strong>Error.</strong> El c&oacute;digo de validaci&oacute;n es inv&aacute;lido.");                        
                        
                        if(is_numeric($idCertificado )){
                                if ($this->usuario->validarCodigo($idCertificado, $codigo)){
                                        $data["result"] = true;
                                        $data["url"] = base_url() . "certificados/codigoValidacion";
                                        $data["message"] = "";
                                }
                        }

			echo json_encode($data);
		}                
		

		/**
		 * Muestra formulario para recordatorio de contraseña
		 * @author dmdiazf
		 * @since 10/11/2015
		 */
		public function reminder(){
			$data["header"] = "/template/navbar2";
			$data["view"] = "reminder";
			$this->load->view("layout",$data);
		}
		
		/**
		 * Envio de correos para recordatorio de contraseña
		 * @author dmdiazf
		 * @since  10/11/2015
		 */
		public function olvido(){
			$this->load->model("usuario");			
			$arrayMeses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");			
			$arrayDias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
			$email = $this->input->post("txtReminder");
			$usuario = $this->usuario->recordarEmail($email);
                        
			if (count($usuario) > 0){
				$config = array(
					"protocol" => "smtp",
					"smtp_host" => "192.168.1.98",
					"smtp_port" => 25,
					"smtp_crypto" => "tls",
					"smtp_user" => "aplicaciones@dane.gov.co",
					"smtp_pass" => "Ou67UtapW3v",
					"mailtype" => "html",
					"charset" => "utf-8",
					"newline" => "\r\n"
				);
				
				$this->email->initialize($config);
				$data["usuario"] = $email;
				$data["password"] = $usuario["password"];
				$data["fecha"] = $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y');

				$this->email->from("aplicaciones@dane.gov.co", "Sistema Integrado de Gestión Humana");
				$this->email->to($email);
				$this->email->subject("Recordatorio de Contraseña / Certificaciones - DANE");
				$html = $this->load->view("mailrec",$data,true);
				$this->email->message($html);
				//var_dump($this->email->print_debugger());
				if ($this->email->send()){					
					$data["header"] = "/template/navbar2";
					$data["view"] = "login";
					$data["enviado"] = true;
					$data["mensaje"] = "<strong>Mensaje Enviado.</strong> Su contrase&ntilde;a ha sido enviada a la direcci&oacute;n de correo indicada.";
					$this->load->view("layout",$data);
				}
			}
			else{
				$data["header"] = "/template/navbar2";
				$data["view"] = "login";
				$data["enviado"] = false;
				$data["mensaje"] = "<strong>No se ha podido enviar el mensaje.</strong> La direcci&oacute;n de correo electr&oacute;nico indicada no existe en nuestra base de datos.";
				$this->load->view("layout",$data);					
			}
		}
		
		
		/**
		 * Cierra la sesion y sale del aplicativo
		 * @author dmdiazf
		 * @since  22/10/2015
		 */
		public function salir(){
			$this->session->sess_destroy();
			redirect("/","location",301);
		}
		
		/*** ELIMINAR ESTE METODO ***/
		public function test(){
			$password = "Msanchez16";
			$test = $this->danecrypt->encode($password);
			
			/*$password = "gQcyNw8t5OCPDWfHHpvjqkvJZEyy4aE-cmvbNM7XuVQ";
			$test = $this->danecrypt->decode($password);
			*/
			var_dump($test);
		}
				
	}//EOC
