<?php defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	 * Controlador para el módulo de administracion
	 * @since  15/03/2016
	 * @author BMOTTAG
	 */

	class Admin extends MX_Controller {
	
		public function __construct(){		
			parent::__construct();
                        $this->load->library("validarsesion");
			$this->load->library("danecrypt");
			$this->load->library("email");			
		}
	
		/**
		 * Menu del administrador
		 * @author BMOTTAG
		 * @since  15/03/2016
		 */
		public function index(){
			$data["header"] = "/template/navbar_admin";
			$data["view"] = "inicio";
			$this->load->view("layout",$data);
		}
		
		/**
		 * Muestra el formulario para realizar la búsqueda de usuarios 
		 * @author BMOTTAG	
		 * @since  15/03/2016
		 */	
		public function pendientes(){
			$data["header"] = "/template/navbar_admin";
			$data["view"] = "certPendientes";
			$this->load->view("layout",$data);	
		}
		
		/**
		 * Obtiene datos en formato JSON para llenar el grid de tabla certificaciones pendientes
		 * @author BMOTTAG
		 * @since  15/03/2016
		 */
		public function busquedaCertificacionesAJAX($txtNroId,$txtNombre,$txtApellido){
			$this->load->library("validarsesion");
			header("Content-Type: text/plain; charset=utf-8");
			
			// Para decodificar caracteres especiales
			$txtNroId=urldecode($txtNroId);
			$txtNombre=urldecode($txtNombre);
			$txtApellido=urldecode($txtApellido);
			
			$this->load->model("modadmin");
			$lista = $this->modadmin->busquedaCertificados($txtNroId,$txtNombre,$txtApellido);
			echo json_encode($lista);
		}

		/**
		 * Valida si hay sesion activa
		 * @author BMOTTAG
		 * @since  15/03/2016
		 */
		public function validaSesion(){
			$this->load->library("validarsesion");
			header("Content-Type: text/plain; charset=utf-8");
			$usuario=$this->session->userdata("id");
			//print_r($this->session->all_userdata() );
			if ( empty ($usuario ))
				echo 'Error';
			else
				echo '-ok-';
		}
                
                /**
                 * Formulario para editar el estado de las certificaciones
                 * @author BMOTTAG
                 * @since  15/03/2016
                 */
                public function editarEstado($idCertificado){

                        $data["header"] = "/template/navbar_admin";

                        $this->load->model("modadmin");
                        $data["idCertificado"] = $idCertificado;
                        $data["view"] = "form_estado";
                        $data["certificado"] = $this->modadmin->datosCertificado($idCertificado);

                        $this->load->view("layout",$data);		
                } 

                /**
                 * Actualiza estado de la solcicitud
                 * @author BMOTTAG
                 * @since  17/03/2016
                 */
                 public function updateEstado(){
                        header('Content-Type: application/json');
                        $this->load->model("modadmin");
                        $data = array();

                        if($this->modadmin->updateEstado($_POST) )
                        {	
                                $data["result"] = true;
                                $data["formulario"] = $_POST["idCertificado"];
                        }
                        else{
                                $data["result"] = false;
                        }

                        echo json_encode($data);				
                }                

		/**
		 * Muestra busqueda por fechas 
		 * @author BMOTTAG	
		 * @since  17/03/2016
		 */	
		public function reporte(){
			$data["header"] = "/template/navbar_admin";
			$data["view"] = "reporte";
			$this->load->view("layout",$data);	
		}                

		/**
		 * Obtiene datos en formato JSON para llenar el grid de tabla certificaciones por peridodo
		 * @author BMOTTAG
		 * @since  15/03/2016
		 */
		public function busquedaCertificacionesFechaAJAX($fechaIni,$fechaFin){
			$this->load->library("validarsesion");
			header("Content-Type: text/plain; charset=utf-8");
			
			// Para decodificar caracteres especiales
			$fechaIni=urldecode($fechaIni);
			$fechaFin=urldecode($fechaFin);

			
			$this->load->model("modadmin");
			$lista = $this->modadmin->busquedaCertificadosbyFecha($fechaIni,$fechaFin);
			echo json_encode($lista);
		}

                /**
                 * Formulario para actualozar los datos parametricos del sistema
                 * @author bmottag
                 * @since  19/04/2016
                 */
                public function parametricas(){
                        $this->load->model("modadmin");
                        $data["parametricas"] = $this->modadmin->get_parametricas();
                        $data["header"] = "/template/navbar_admin";
                        $data["view"] = "form_parametricas";
                        $this->load->view("layout",$data);
                }

                /**
                 * Actualiza datos parametridcon en la B.D.
                 * @author bmottag
                 * @since  19/04/2016
                 */
                public function updateParams(){
                        header('Content-Type: application/json');
                        $this->load->model("modadmin");
                        
                        $params[1] = $this->input->post("txtCoordinador");
                        $params[2] = $this->input->post("sexo");
                        $params[3] = $this->input->post("txtEmail");                        

                        $result = $this->modadmin->updateParams($params);
                        if ($result){
                                $data["result"] = true;
                        }
                        else{
                                $data["result"] = false;
                        }	    			
	                        
			echo json_encode($data);	                
                } 

                /**
                 * Formulario para actualizar correo electronico o contraseña del usuario
                 * @author bmottag
                 * @since  20/04/2016
                 */
                public function usuario(){
                        $this->load->model("modadmin");
                        $data["parametricas"] = $this->modadmin->get_parametricas();
                        $data["header"] = "/template/navbar_admin";
                        $data["view"] = "form_buscar_usuario";
                        $this->load->view("layout",$data);
                }
                
                /**
                 * Busca el funcionario al cual se le va a generar la novedad .
                 * @since 06/08/2015
                 */
                public function buscafuncionario(){
                    header("Content-Type: text/plain; charset=utf-8");//Para evitar problemas de acentos
                    $this->load->model("modadmin");
                    $data = array();
                    $cedula = $this->input->post("cedula");

                    $data=$this->modadmin->existeusuario($cedula);
                    //echo $cedula;
                    //var_dump ($data);
                    if ($data==false)
                    {
                            echo "<br/><label for='txtNombres'>El usuario no existe</label>";
                    }
                            else 
                            {
                                    $this->load->view("form_datos_usuario",$data);

                            } 
                }
                
                /**
                 * Actualiza datos parametridcon en la B.D.
                 * @author bmottag
                 * @since  25/04/2016
                 */
                public function updateUser(){
                        header('Content-Type: application/json');
                        $this->load->model("modadmin");

                        $result = $this->modadmin->updateUser();
                        if ($result){ $data["result"] = true; }
                        else{ $data["result"] = false; }	    			
	                        
			echo json_encode($data);	                
                } 


				
	}
