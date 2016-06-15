<?php defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	 * Controlador para certificaciones
	 * @since  25/02/2016
	 * @author BMOTTAG
	 */

	class Certificados extends MX_Controller {
	
		public function __construct(){		
			parent::__construct();
			$this->load->library("validarsesion");
			$this->load->library("html2pdf");
		}
	
		public function index(){
                    //var_dump($this->session->userdata());exit;
                        if($this->session->userdata("rol")){
                            $data["header"] = "/template/navbar_admin";
                        }
                        $data["userId"] = $this->session->userdata("id");
                        $data["identifica"] = $this->session->userdata("cedula");
                        $data["nombres"] = $this->session->userdata("nombre");
                        $data["apellidos"] = $this->session->userdata("apellidos");
                        $data["estado"] = $this->session->userdata("estado");
                        $this->load->model("modcertificados");
                        $data["tiposcerti"]=$this->modcertificados->obtenertiposcer();//Lista tipo de certificaciones
                        
                        $data["nomenu"] = true;
			$data["view"] = "form_certificado";
			$this->load->view("layout",$data);
			
		}
                
                
		public function codigoValidacion(){
                        $data["nomenu"] = true;
                        $idCertificado = $this->session->userdata("idCertificado");
                        $this->load->model("modcertificados");
                        $data["parametricas"] = $this->modcertificados->obtenerParametricas();
                        $data["certificado"]=$this->modcertificados->obtenerDatosCertificado($idCertificado);
                        $idUsuario = $data["certificado"]["ID_USUARIO"];
                        //verificar estado del suaurio 
                        $estado = $this->modcertificados->obtenerEstadoById($idUsuario);
                         
                        if($estado == "ACTIVO"){
                            $data["usuario"] = $this->modcertificados->obtenerDatosUsuarioById($idUsuario);
                            $data["view"] = "validar_datos";
                        }elseif($estado == "RETIRADO"){ 
                            $data["usuario"] = $this->modcertificados->obtenerDatosUsuarioRetirado();
                            $data["view"] = "validar_datos_retirado";
                        }else{
                            $html = "El usuario tiene un estado que no se reconoce por el sistema.";
                        }                        
			
			$this->load->view("layout",$data);
			
		}                
                
	    /**
	     * Guarda la solicitud del certificado.
	     * @author Angela Liliana Rodriguez Mahecha
	     * @since  Junio 26 / 2015
	     */
	    public function GenerarSolicitud(){
                    header('Content-Type: application/json');
                    $this->load->model("modcertificados");
                    $data = array();
                    $idusuario = $this->session->userdata("id");
                    $tipocer = $this->input->post("tipo_certi");
                    
                    //DEPENDIENDO SI ES UN CERTIFICADO AUTOMATICO O NO , COLOCO EL ESTADO DEL CERTIFICADO
                    $automatico = $this->modcertificados->verificarDescarga($tipocer);
                    $estado = $automatico==1?2:1;
                        
                    //veririfcar si ya genero una certificacion 
                    $result = $this->modcertificados->existesolicitud($idusuario, $tipocer);

                    if($result)
                    {
                            $data["result"] = "error";
                            $data["mensaje"] = "La solicitud de este certificado ya se encuentra en proceso.";
                    }
                    else
                    {
                            $idCertificado = $this->modcertificados->agregarCertificado($estado);
                                
                            if($idCertificado)
                            {
                                    //dependiendo si se genera automaticamente la certificacion o no, se muestra mensaje
                                    $data["result"] = true;
                                    if($automatico==1){
                                        $data["mensaje"] = "<h3><a href='certificados/generaPDF/$idCertificado'><img src='./images/pdf.png' >&nbsp;Descargar Certificación </a></h3>";
                                    }else{
                                        $envioCorreo = $this->mailRecordar($idCertificado);
                                        $data["mensaje"] = "<h3>Se envió correo al administrador para que genere la certificación.</h3>";
                                    }
                                    
                            }
                            else
                            {
                                    $data["result"] = "error";
                                    $data["mensaje"] = "No se ha podido generar la solicitud de certificado en el sistema, por favor consulte al administrador.";
                
                            }
                    }			
                    echo json_encode($data);                
                	    	
	    }                
                

		/**
		 * Método para descargar el PDF del certificado
		 * @author BMOTTAG
		 * @since 25/02/2015
		 */
		public function generaPDF($idCertificado){	
			date_default_timezone_set('America/Bogota');
                        $data = array();
                        
                        $this->load->model("modcertificados");
                        $data["parametricas"] = $this->modcertificados->obtenerParametricas();
                        $data["certificado"] = $this->modcertificados->obtenerDatosCertificado($idCertificado);
			
			$this->html2pdf->folder('./assets/pdfs/');
			$this->html2pdf->filename("certificado.pdf");
			$this->html2pdf->paper('letter', 'portrait');

                        $estado = $this->session->userdata("estado");
                        if($estado == "ACTIVO"){
                            $data["usuario"] = $this->modcertificados->obtenerDatosUsuario();
                            $html = $this->load->view("certificado",$data,true);
                        }elseif($estado == "RETIRADO"){ 
                            $data["usuario"] = $this->modcertificados->obtenerDatosUsuarioRetirado();
                            $html = $this->load->view("certificado_retirado",$data,true);
                        }else{
                            $html = "El usuario tiene un estado que no se reconoce por el sistema.";
                        }
                        //echo $html;
			$this->html2pdf->html($html);
			$this->html2pdf->create("download");

		}
                             
		
	    /**
	     * Envia correos de recordatorio de login y contraseña
	     * @author BMOTTAG
	     * @since  25/02/2016
	     */
	    public function mailRecordar($idCertificado){
                
                    $this->load->library("email");
                    
                    $data["parametricas"] = $this->modcertificados->obtenerParametricas();
                    $data["certificado"] = $this->modcertificados->obtenerDatosCertificado($idCertificado);
                    
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

                    $arrayCert[1] = array(
                                    'correo' => $data["certificado"]["CORREO"],
                                    'vista' => "correo_user"
                    );
                    
                    $arrayCert[2] = array(
                                    'correo' => $data["parametricas"][2]["VALOR"],
                                    'vista' => "correo_admin"
                    );                   

                    for ($i=1; $i<=count($arrayCert); $i++){
                            $this->email->initialize($config);
                            $this->email->from("aplicaciones@dane.gov.co", "Sistema de Certificaciones - DANE");
                            $this->email->to($arrayCert[$i]["correo"]);
                            $this->email->subject("Nueva solicitud de Certificación");
                            $html = $this->load->view($arrayCert[$i]["vista"],$data,true);

                            $this->email->message($html);
                            $this->email->send();
                    }                    
 	
                    return true;
	    }  
		
		
	}