<?php defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	 * Controlador para el módulo de IERedirect
	 * Se redirecciona a los usuarios que utilizan Internet Explorer a otra página para que utilicen otro tipo de navegador.
	 * @since  22/09/2015	   
	 * @author dmdiazf
	 */

	class IERedirect extends MX_Controller {
	
		public function __construct(){		
			parent::__construct();			
		}
	
		public function index(){	
			$data["header"] = "/template/navbar2";
			$data["view"] = "ieredirect";
			$this->load->view("layout",$data);		
		}
	
		
	}//EOC
