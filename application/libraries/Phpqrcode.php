<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class PHPQRCode {
		
		var $height = null; //Alto de la imagen
		var $width = null;  //Ancho de la imagen
		var $code = null;   //Codigo del usuario para generar la imagen
		var $link = null;   //Direccion URL a dónde se dirige la imagen.
		
		/**
		 * Constructor de la clase PHPQRCode
		 * Carga las librerias requeridas para la generacion de imágenes de Códigos QR.
		 * @author dmdiazf
		 * @since  22/10/2015
		 */
		function __construct() {
			require_once("phpqrcode/qrlib.php");
		}
				
		/**
		 * Setter para el code de la imagen QR
		 * @author dmdiazf
		 * @since  22/10/2015
		 */
		public function setCode($code){
			$this->code = $code;
		}
		
		/**
		 * Setter para el link de la imagen QR
		 * @author dmdiazf
		 * @since  22/10/2015
		 */
		public function setLink($link){
			$this->link = $link;
		}
		
		/**
		 * Genera la imagen del código QR a partir de los datos que se reciben por parámetro.
		 * @author dmdiazf
		 * @since  22/10/2015
		 */
		public function generateQRImage($code){
			ob_start("callback");
			$this->link = $this->link . "/" . $code;
			$debugLog = ob_get_contents();
			ob_end_clean();
			QRcode::png($this->link);
		}
		
		
		/**
		 * Retorna el HTML que incluye la imagen en la vista del aplicativo
		 * @author dmdiazf
		 * @since  22/10/2015
		 */
    	public function getQRImage($code){ 
    		$imgpath = base_url("inicio/qrcode/$code");
    		return "<img src=\"$imgpath\"/>";
    	}
	}

/* End of file PHPQRCode.php */