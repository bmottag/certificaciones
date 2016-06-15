<?php defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	 * Controlador para el modulo de Hogar
	 * @since  22/09/2015	   
	 * @author Angela Rodriguez
	 */

	class registrese extends MX_Controller {
	
		public function __construct(){		
			parent::__construct();		
		//	$this->load->library("validarsesion");	
			$this->load->library("danecrypt");
		}
	
		public function index(){	
			$this->load->model("modregistrese");			
			$data["header"] = "/template/navbar2";
                        $data["view"] = "nuevousuario";
			$this->load->view("layout",$data);
		}
		
		
		/**
		 * busca los municipios de un departamento determinado.
		 * @author Angela Liliana Rodriguez Mahecha
		 * @since  Junio 26 / 2015
		 */
			
		public function busca(){
			//echo "jajkajkjaf";
			$data = array();
			$depto=$this->input->post("coddepto");
			$this->load->model("modregistrese");	
			$mpios =$this->modregistrese->nomdempios($depto);
		
			//var_dump ($mpios);
			echo "<label >Municipio<font color='red'><b>*</b></font></label>
	    				<label><select  id='Municipio' name='Municipio' onChange='cambiadepto();'>
							<option value='-'>Seleccione...</option>";
			for ($i=0; $i<count($mpios); $i++){
				echo "<option  value='".$mpios[$i]["id"]."'>".$mpios[$i]["nombre"]."</option>";
			}
			echo "</select></label>";
		}
		/**
		 * grilla de  las personas reseidentes del hogar
		 * @since  26/10/2015
		 * @author Liliana Ramirez
		 */
		public function jsonQueryper(){
			
			$data["formulario"] = $formulario = $this->session->userdata("numform");
			$this->load->model("modregistrese");
			$test = $this->modregistrese->GridPerHogar($formulario);
			echo json_encode($test);
		}
		
		/**
		 * grilla de  las personas reseidentes del hogar
		 * @since  26/10/2015
		 * @author Liliana Ramirez
		 */
		public function verifnom(){
				
			$data["formulario"] = $formulario = $this->session->userdata("numform");
			$this->load->model("modregistrese");
			$test = $this->modregistrese->obtenernombre($formulario);
			echo $test;
		}
		
		/**
		 * grilla de  las personas reseidentes del hogar
		 * @since  26/10/2015
		 * @author Liliana Ramirez
		 */
		public function verifcorreo(){
		
			$data["formulario"] = $formulario = $this->session->userdata("numform");
			$this->load->model("modregistrese");
			$test = $this->modregistrese->obtenercorreo($formulario);
			echo $test;
		}
		
		
		/**
		 * grilla de  las personas reseidentes del hogar
		 * @since  26/10/2015
		 * @author Liliana Ramirez
		 */
		public function verifclave(){
		
			$data["formulario"] = $formulario = $this->session->userdata("numform");
			$this->load->model("modregistrese");
			$test = $this->modregistrese->obtenerclave($formulario);
			echo $test;
		}
		
		
		/**
		 * grilla de  las personas reseidentes del hogar
		 * @since  26/10/2015
		 * @author Liliana Ramirez
		 */
		public function jsonQueryEditper(){
				
			$_POST['formulario'] = $formulario = $this->session->userdata("numform");
			$this->load->model("modregistrese");
				
			if ($_POST['oper']=="add")
			{
				$verifica = $this->modregistrese->verificaExisteCC($_POST);
				//echo "varifica=".$verifica;
				if ($verifica == 1)
				{
					//echo "falla";
					echo "1";
				}
				else
				{
						
					$guarda = $this->modregistrese->GuardaPerHogar($_POST);
					if ($guarda == 0 )
					{
						echo "2";
					}
					else if  ($guarda== 1 )
					{
						echo "3";
					}
						
				}
			}
			else if ($_POST['oper']=="edit")
			{
				$verifica = $this->modregistrese->verificaExisteCCmodificar($_POST);
				if ($verifica == 1)
				{
					//echo "falla";
					echo "1";
				}
				else
				{
					$actualizo = $this->modregistrese->EditaPerHogar($_POST);
					if ($actualizo == 0 )
					{
						echo "2";
					}
					else if  ($actualizo== 1 )
					{
						echo "3";
					}
				}
			}
			else
			{
				$elimino = $this->modregistrese->EliminarPerHogar($_POST);
				if ($elimino == 0 )
				{
					echo "2";
				}
				else if  ($elimino== 1 )
				{
					echo "3";
				}
			}
		}
		
		
		/**
		 * Agrega las personas fallecidas y pinta la tabla
		 * @since  27/10/2015
		 * @author Angela Rodriguez
		 */
		public function guardarRegistrese(){
			$this->load->model("modregistrese");
			$datos=$this->input->post();
			$index=$this->input->post('index');
			$respuesta="";
			
			//var_dump ($datos);
				
			if ($index==1)
			{
				$this->modregistrese->guardarnoacpto($datos);
			} 
			else if ($index==2)
			{
				$result=$this->modregistrese->agregarpreinscripcion($datos);
				
				if ($result==false){
					return false;
				}
				else 
				{
					
					$nro_form  = $formulario = $this->session->userdata("numform");
					$correo = $this->modregistrese->obtenercorreo($formulario);
					$this->load->library("email");
					$config = array(
							'protocol' => 'smtp',
							'smtp_host' => '192.168.1.98',
							'smtp_port' => 25,
							'smtp_crypto' => 'tls',
							'smtp_user' => 'aplicaciones@dane.gov.co',
							'smtp_pass' => 'Ou67UtapW3v',
							'mailtype' => 'html',
							'charset' => 'utf-8',
							'newline' => "\r\n"
					);
						
					$arrayCert = array(
					
							//'1' => 'lramirezp@dane.gov.co',
							'1' => $correo
					);
					
						
					for ($i=1; $i<=count($arrayCert); $i++){
						$this->email->initialize($config);
						$data['datos']=$this->modregistrese->obtenersuccess1($nro_form);
						$this->email->from("aplicaciones@dane.gov.co", "DANE - eCenso ");
						$this->email->to($arrayCert[$i]);
						$this->email->subject("Inscripcion al eCenso");
						$html = $this->load->view("enviocorreo1",$data,true);
							
						$this->email->message($html);
						$bool = $this->email->send();
						//if ($bool){
						//	$this->certificados->actualizarNotificacionCertificado($arrayCert[$i]);
						//}
					}
					//var_dump ($arrayCert);
					//var_dump($this->email->print_debugger());
					
					return true;
				}
			}
			else if ($index==3)
			{
				$result=$this->modregistrese->actualizatotperso($datos);
				if ($result==false){
					return false;
				}
				else
				{
					
					$nro_form  = $formulario = $this->session->userdata("numform");
					$correo = $this->modregistrese->obtenercorreo($formulario);
					$this->load->library("email");
					$config = array(
							'protocol' => 'smtp',
							'smtp_host' => '192.168.1.98',
							'smtp_port' => 25,
							'smtp_crypto' => 'tls',
							'smtp_user' => 'aplicaciones@dane.gov.co',
							'smtp_pass' => 'Ou67UtapW3v',
							'mailtype' => 'html',
							'charset' => 'utf-8',
							'newline' => "\r\n"
					);
					
					$arrayCert = array(
								
							//'1' => 'lramirezp@dane.gov.co',
							'1' => $correo
					);
						
					
					for ($i=1; $i<=count($arrayCert); $i++){
						$this->email->initialize($config);
						$data['datos']=$this->modregistrese->obtenersuccess1($nro_form);
						$this->email->from("aplicaciones@dane.gov.co", "DANE - eCenso ");
						$this->email->to($arrayCert[$i]);
						$this->email->subject("Inscripcion al eCenso");
						$html = $this->load->view("finalizar1",$data,true);
							
						$this->email->message($html);
						$bool = $this->email->send();
						//if ($bool){
						//	$this->certificados->actualizarNotificacionCertificado($arrayCert[$i]);
						//}
					}
					//var_dump ($arrayCert);
					//var_dump($this->email->print_debugger());
					
					return true;
				}
				//$datos=$this->modregistrese->obtenersuccess($formulario);
				//echo "numero".$this->session->userdata("numform");
			}
			else if ($index==4)
			{
				$result=$this->modregistrese->actualizaubicacion($datos);
				if ($result==false){
					return false;
				}
				else
				{
					return true;
				}
				//$datos=$this->modregistrese->obtenersuccess($formulario);
				//echo "numero".$this->session->userdata("numform");
			}
		}
                
                
                /**
                 * Crea los usuarios en la B.D. luego de verificar que se trata de usuarios PERNO ó SICO válidos
                 * @author Daniel M. Díaz
                 * @since  22/06/2015
                 */
                public function crearUsuario(){
                        header('Content-Type: application/json');
                        $this->load->model("modregistrese");
                        $data = array();

                        $numident = $this->input->post("txtIdentificacion");
                        $telefono = $this->input->post("txtTelefono");
                        $extension = $this->input->post("txtExtension");
                        $email = $this->input->post("txtEmail");

                        $result = $this->modregistrese->existeCC($numident);//verificar cedula

                        if($result)
                        {
                                $data["result"] = "error";
                                $data["mensaje"] = "El número de identificación ya se encuentra registrado. Ingrese con su usuario y contraseña.";
                        }
                        else
                        {
				$login = $this->modregistrese->existeLogin($email);//verificar correo
				if($login)
				{
					$data["result"] = "error";
                                        $data["mensaje"] = "El correo electrónico ya se encuentra registrado.";
				}
				else
				{
                                        //Validar que el usuario se encuentre en PERNO
                                        $perno = $this->modregistrese->validarUsuarioPERNO($numident); 
                                    
                                        if ($perno["valid"]){
                                                $nombres = $perno["nom_usuario"];
                                                $apellidos = $perno["ape_usuario"];

                                                $result = $this->modregistrese->addUsuario($numident, $nombres, $apellidos, $telefono, $extension, $email);
                                                if ($result){
                                                        
                                                        $envioCorreo = $this->mailRecordar();
                                                        $data["result"] = true;
                                                }
                                                else{
                                                        $data["result"] = false;
                                                }	    			
                                        }else{
                                                $data["result"] = "error";
                                                $data["mensaje"] = "No se ha podido crear el usuario. Verifique el número de identificación ingresado o comuníquese con el área de Gestión Humana.";
                                        }	                        
				}
			}			
			echo json_encode($data);	                

                }                
		
                
	    /**
	     * Envia correos de recordatorio de login y contraseña
	     * @author Daniel M. Díaz
	     * @since  22/06/2015
	     */
	    public function mailRecordar(){
                
                    $this->load->library("email");

                    $email = $this->input->post("txtEmail");
                    $numident = $this->input->post("txtIdentificacion");
                    $data = $this->modregistrese->buscarUsuario($numident);
                    
                    $config = array(
                            'protocol' => 'smtp',
                            'smtp_host' => '192.168.1.98',
                            'smtp_port' => 25,
                            'smtp_crypto' => 'tls',
                            'smtp_user' => 'aplicaciones@dane.gov.co',
                            'smtp_pass' => 'Ou67UtapW3v',
                            'mailtype' => 'html',
                            'charset' => 'utf-8',
                            'newline' => "\r\n"
                    );	    	
                    $this->email->initialize($config);	    	
                    $this->email->from("aplicaciones@dane.gov.co", "Sistema de Certificaciones - DANE");
                    $this->email->to($email);
                    $this->email->subject("Registro Sistema de Certificaciones del DANE");
                    $html = $this->load->view("enviocorreo1",$data,true);
                    $this->email->message($html);
                    $this->email->send();
	    	
                    return true;
	    }                
		
		
		/**
		 * Agrega las personas fallecidas y pinta la tabla
		 * @since  27/10/2015
		 * @author Angela Rodriguez
		 */
		public function verificarcc(){
			$this->load->model("modregistrese");
			//var_dump ($this->input->post());
			$datos=$this->input->post();
			$result=$this->modregistrese->verificaced($datos);
			if ($result==false){
				echo "existe";
			}
			else 
			{
				echo "nnnexiste";
			}
		}
		
		/**
		 * Agrega las personas fallecidas y pinta la tabla
		 * @since  27/10/2015
		 * @author Angela Rodriguez
		 */
		public function verificarcompletos(){
			$this->load->model("modregistrese");
			//var_dump ($this->input->post());
			$datos=$this->input->post();
			$nro_form  = $formulario = $this->session->userdata("numform");
			$result=$this->modregistrese->verificacompletos($nro_form);

			echo $result;
		}
		

		/**
		 * Agrega las personas fallecidas y pinta la tabla
		 * @since  27/10/2015
		 * @author Angela Rodriguez
		 */
		public function cargatipodoc(){
				
			$code = "";
			//var_dump($_GET);
			switch ($_GET["aCrear"])
			{
				case "C4P43_TIPO_DOC":
					$ComboBox["1"]="Registro civil de nacimiento";
					$ComboBox["2"]="Tarjeta de identidad";
					$ComboBox["3"]="C&eacute;dula de ciudadan&iacute;a";
					$ComboBox["4"]="C&eacute;dula de extranjer&iacute;a";
					$ComboBox["5"]="No tiene documento de identidad";
					break;
				case "C4P49_PARENTESCO":
					$ComboBox["1"]="Si";
					$ComboBox["99"]="No";
					break;
				case "C4P45_SEXO":
					$ComboBox["1"]="Hombre";
					$ComboBox["2"]="Mujer";
					break;
		
			}
			echo "<option value=''>Seleccione</option>";
			foreach($ComboBox as $key=>$value)
			{
				$sel="";
				echo "<option $sel value='$key'>$value</option>";
			}
				
			//echo "<br>".$sql;
			//echo "<br>".$sql."-->REGISTROS".$num_total_registros."<br><br>";
			//print_r($ComboBox);
				
		}
		
		public function buscamail()
		{
			header("Content-Type: text/plain; charset=utf-8");//Para evitar problemas de acentos
			$this->load->model("modregistrese");
			$data = array();
			$data['txtcorreo']=$txtcorreo = $this->input->post("email");
			$data["controller"] = "login";
				
		
			$verificarmail=$this->modregistrese->buscarmail($txtcorreo);
			if ($verificarmail==true){
				echo "nada";
			}
			else
			{
				echo "siexiste";
			}
		}
		
		public function video()
		{
			$data["nomenu"] = true;
			$data["view"] = "tutorial";
			$this->load->view("layout",$data);
		}
		
		
		public function termicondi()
		{
			$data["nomenu"] = true;
			$data["view"] = "registreseterminos";
			$this->load->view("layout",$data);
		}
		
	}//EOC
