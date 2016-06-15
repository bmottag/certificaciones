<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/***
	 * Modelo para obtencion de datos del modulo de hogar 
	 * @author Angela Rodriguez
	 * @since  20/10/2015	 
	 ***/

class MODRegistrese extends CI_Model {

	function __construct(){
		parent::__construct();
                $this->load->library("danecrypt");
	}
        
	    /**
	     * Valido los datos del usuario contra el sistema PERNO.
	     * Si el usuario se encuentra en el sistema, debo actualizar los datos de la tabla de usuarios
	     * @author Daniel M. Díaz
	     * @since  19/06/2015
	     */ 
	    public function validarUsuarioPERNO($numid){
	    	$perno = array();
	    	$perno["valid"] = false;
	    	$sql = "SELECT numero_identificacion, nombres, primer_apellido, segundo_apellido, correo, 
	    	               dependencia, territorial, cod_dependencia, cod_territorial, estado
					FROM rh.v_infofuncionarios 
					WHERE numero_identificacion = '$numid'";	    	    	
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){
	    		foreach($query->result() as $row){	    			
	    			$perno["valid"] = true;
	    			$perno["num_ident"] = $row->NUMERO_IDENTIFICACION;
	    			$perno["nom_usuario"] = $row->NOMBRES;
	    			$perno["ape_usuario"] = $row->PRIMER_APELLIDO." ".$row->SEGUNDO_APELLIDO;
	    			$perno["mail_usuario"] = $row->CORREO;
	    			$perno["dep_usuario"] = $row->DEPENDENCIA;
	    			$perno["terr_usuario"] = $row->TERRITORIAL;	
	    			$perno["cod_dep_usuario"] = $row->COD_DEPENDENCIA;
	    			$perno["cod_terr_usuario"] = $row->COD_TERRITORIAL;
                                $perno["estado"] = $row->ESTADO;
	    		}
	    	}
	    	$this->db->close();
	    	return $perno;
	    }        
	    /**
	     * Valida que el login de usuario no exista, o no se haya creado en la tabla de usuarios
	     * @author Daniel M. Díaz
	     * @since  22/06/2015 
	     */
	    public function existeLogin($email){
	    	$result = false;
	    	$sql = "SELECT * FROM CERT_USUARIO WHERE CORREO = '$email'";
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){
	    		$result = true;
	    	}
	    	$this->db->close();
	    	return $result;
	    }

        
	    /**
	     * Valida que la CC de usuario no exista, o no se haya creado en la tabla de usuarios
	     * @since  9/11/2015 
	     */
	    public function existeCC($cc){
	    	$result = false;
	    	$sql = "SELECT * FROM CERT_USUARIO WHERE NUM_IDENT = '$cc'";
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){
	    		$result = true;
	    	}
	    	$this->db->close();
	    	return $result;
	    } 
            
            
	    /**
	     * Realiza la Búsqueda de un usuario y contraseña a partir del email
	     * @author Daniel M. Díaz
	     * @since  22/06/2015
	     */
	    public function buscarUsuario($cc){
	    	$user["found"] = false;
	    	$sql = "SELECT * FROM CERT_USUARIO WHERE NUM_IDENT = '$cc'";	    	
	    	$query = $this->db->query($sql);
	    	if ($query->num_rows() > 0){
	    		foreach($query->result() as $row){
		    		$user["found"] = true;
		    		$user["nombres"] = $row->NOMBRES;
		    		$user["apellidos"] = $row->APELLIDOS;
		    		$user["clave"] = $this->danecrypt->decode($row->CLAVE);
		    		$user["correo"] = $row->CORREO;
	    		}	
	    	}
	    	$this->db->close();
	    	return $user;
	    }            
        
        
	/**
	 * Actualiza informacion de usuario
	 * @author hhchavezv
	 * @since  2015ene14
	 */
	public function addUsuario($numident, $nombres, $apellidos, $telefono, $extension, $email)
	{
		$password = $this->danecrypt->generarPassword();
                $passwordNormal = $this->danecrypt->decode($password);
                $sql = "INSERT INTO CERT_USUARIO
			(ID_USUARIO, NUM_IDENT,  NOMBRES, APELLIDOS, TELEFONO, EXTENSION, CORREO, CLAVE)
			VALUES (SEQ_CERT_USUARIOS.Nextval, ".$numident.", '".strtoupper($nombres)."', '".strtoupper($apellidos)."','".$telefono."', '".$extension."', '".$email."', '$password')";
		$query = $this->db->query($sql);		
		
		if ($query)
		{
			$res= $passwordNormal;
		}else		
		{
			$res= FALSE;			
			echo "Error al guardar. Intente nuevamente o actualice la p&aacute;gina.";
		}
	
		
		$this->db->close();
    	return $res;
		
	}        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

	/**
	 * Inserta - Guarda la preinscripcion
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero  2016
	 */
	public function agregarpreinscripcion($datos){
		
		if ($datos['txttipodto']==99)
		{
			$datos['txttipodto']=$datos['txttipodto2'];
		}
		if ($datos['txttipodto']==1)
		{
			$txtnumdocumento=$datos['txtnumdocumentoreg'];
		}
		else if ($datos['txttipodto']==2)
		{
			$txtnumdocumento=$datos['txtnumdocumentotar'];
		}
		else if ($datos['txttipodto']==3)
		{
			$txtnumdocumento=$datos['txtnumdocumentocc'];
		}
		else if ($datos['txttipodto']==4)
		{
			$txtnumdocumento=$datos['txtnumdocumentoce'];
		}
		
	
			$sqlverinum="SELECT MAX(NRO_ENCUESTA_FORM) AS NUMERO FROM CNPV_ADMIN_CONTROL ";
			$resverinum = $this->db->query($sqlverinum);
			$valinumform=$resverinum->num_rows();
			if ($valinumform>0)
			{
				foreach($resverinum->result() as $row)
				{
					$actual = $row->NUMERO;
					if ($actual==0)
					{
						$formulario =900000000;
					}
					else
					{
						$formulario = $actual+1;
					}
				}
			}
			else
			{
				$formulario =900000000;
			}
				
			$sqlcontrol = "INSERT INTO CNPV_ADMIN_CONTROL (NRO_ENCUESTA_FORM, SEC_PREREG, FEC_INIPREREG, FK_ESTADO, FK_DEPTO, FK_MPIO)
			VALUES ($formulario,'1', SYSDATE, '1', '0', '0')";
			$query = $this->db->query($sqlcontrol);
	
			$sql = "INSERT INTO CNP_PREREGISTRO(DIRECTORIO, PRIMER_NOMBRE, SEGUNDO_NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO,C4P40_TIPO_DOC, CEDULA, CORREO_ELECTRONICO, INDICATIVO, TEL_FIJO, TEL_CELULAR, CONTRASENA, NRO_ENCUESTA_FORM)
			VALUES (SEQ_FORM_PREREGISTRO.Nextval,'".$datos['txtnombreuno']."', '".$datos['txtnombredos']."', '".$datos['txtapellidouno']."', '".$datos['txtapellidodos']."', '".$datos['txttipodto']."','".$txtnumdocumento."', '".$datos['txtcorreo']."', '".$datos['txtindicativo']."','".$datos['txtTelF']."', '".$datos['txtTelM']."', '".$datos['txtcontras']."', '".$formulario."' )";
			$query = $this->db->query($sql);
				
	
			$ins="INSERT INTO CNP_PREREGISTRO_PERSONAS(DIRECTORIO, C4P40_TIPO_DOC, C4P41_SABE_DOC, C4P39A_1ER_NOMBRE, C4P39AA_2DO_NOMBRE, C4P39B_1ER_APELLIDO, C4P39BB_2DO_APELLIDO, C4P44_EDAD, C4P42_SEXO, JEFE, NRO_ENCUESTA_FORM, COMPLETO, C4P41_NRO_PER)
			VALUES (SEQ_PREREGISTRO_PERSONAS.Nextval, '".$datos['txttipodto']."', '".$txtnumdocumento."',  '".$datos['txtnombreuno']."', '".$datos['txtnombredos']."', '".$datos['txtapellidouno']."', '".$datos['txtapellidodos']."', '".$datos['edad']."' , '".$datos['txtsexo']."', '2', '".$formulario."', '1', '1')";
			$ejeins = $this->db->query($ins);
			$result = true;
	
			
			/*INSERTA LA TABLA DE VIVIENDA*/
			$sqlvivi="INSERT INTO CNPV_VIVIENDA (C0I1_ENCUESTA)
			 VALUES (".$formulario.")";
			$query = $this->db->query($sqlvivi);
			//echo "<br>vivienda<br>".$sqlvivi;
			
			/*INSERTA LA TABLA DE HOGAR*/
			$sqlhog="INSERT INTO CNPV_HOGAR (C0I1_ENCUESTA, C3H24_NROHOG, C3H_TOT_PER)
			 VALUES (".$formulario.", '1', '1')";
			$query = $this->db->query($sqlhog);
			//echo "<br>hogar<br>".$sqlhog;
			
			$sql = "INSERT INTO CNPV_PERSONA_RESIDENTE
			(C0I1_ENCUESTA, C3R24_NROHOG, C3R38A_NRO_RESI, C3R38B1_1NOMBRE,  C3R38B2_2NOMBRE, C3R38C1_1APELLIDO, C3R38C2_2APELLIDO)
			VALUES ('".$formulario."', '1', '1', '".$datos['txtnombreuno']."', '".$datos['txtnombredos']."', '".$datos['txtapellidouno']."', '".$datos['txtapellidodos']."')";
			$query = $this->db->query($sql);
			
			
			$sql = "INSERT INTO CNPV_PERSONA_HOGAR
			(C0I1_ENCUESTA, C3P24_NROHOG, C4P41_NRO_PER, C4P42A_1ER_NOMBRE,  C4P42B_1ER_APELLIDO, C4P43_TIPO_DOC, C4P44_NRO_DOC, C4P45_SEXO, C4P47_EDAD, C4P49_PARENTESCO, C4P46A_DIA_NAC, C4P46B_MES_NAC, C4P46C_ANO_NAC)
			VALUES ('".$formulario."', '1', '1', '".$datos['txtnombreuno']."', '".$datos['txtapellidouno']."', '".$datos['txttipodto']."', '".$txtnumdocumento."', '".$datos['txtsexo']."', '".$datos['edad']."', '',  '".$datos['dia_nac']."', '".$datos['mes_nac']."','".$datos['ano_nac']."')";
			$query = $this->db->query($sql);
			
			/*INSERTA LA TABLA DE USUARIOS*/
			$password = $this->danecrypt->encode($datos['txtcontras']);
			$sqlusua="INSERT INTO CNP_ADMIN_USUARIOS (ID_USUARIOS, USUARIO, CLAVE, TIPO_USUARIO, ESTADO, FECHA_CREACION, FECHA_EXPIRACION, NRO_ENCUESTA_FORM) 
					VALUES (SEQ_ADMIN_USUARIOS.Nextval, '".$datos['txtcorreo']."', '".$password."', 'F', '1', SYSDATE, '15/05/2015', ".$formulario.")";
			$query = $this->db->query($sqlusua);
			//echo "<br>usuarios<br>".$sqlusua;
			
			$sessionData = array("numform" => $formulario);
			$this->session->set_userdata($sessionData);
			//$this->session->userdata("numform")=$formulario;
			
		$this->db->close();
		return $result;
	}
	 
	
	
	

	/**
	 * Actualizar los datos Personales y asigno usuario y clave para el ingreso
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero / 2016
	 */
	public function actualizaPreinscripcion($datos){
		$formulario=$this->session->userdata("numform");
		$sql = "UPDATE CNP_PREREGISTRO
				SET PRIMER_NOMBRE= '".$datos['txtnombreuno']."', SEGUNDO_NOMBRE='".$datos['txtnombredos']."', PRIMER_APELLIDO='".$datos['txtapellidouno']."', SEGUNDO_APELLIDO='".$datos['txtapellidodos']."', INDICATIVO='".$datos['txtindicativo']."', TEL_FIJO='".$datos['txtTelF']."', TEL_CELULAR='".$datos['txtTelM']."', CONTRASENA='".$datos['txtcontras']."'
				WHERE  NRO_ENCUESTA_FORM='".$formulario."' ";
		$query = $this->db->query($sql);
	
	
		$ins="UPDATE CNP_PREREGISTRO_PERSONAS
			SET C4P39A_1ER_NOMBRE='".$datos['txtnombreuno']."', C4P39AA_2DO_NOMBRE='".$datos['txtnombredos']."', C4P39B_1ER_APELLIDO='".$datos['txtapellidouno']."', C4P39BB_2DO_APELLIDO='".$datos['txtapellidodos']."'
			WHERE NRO_ENCUESTA_FORM='".$formulario."' ";
		$ejeins = $this->db->query($ins);
		$result = true;
	
		/*INSERTA LA TABLA DE USUARIOS*/
		$password = $this->danecrypt->encode($datos['txtcontras']);
		$sqlusua="UPDATE CNP_ADMIN_USUARIOS
				 SET CLAVE='".$password."'
				 WHERE NRO_ENCUESTA_FORM='".$formulario."' ";
		$query = $this->db->query($sqlusua);
		$sqlusua;
			
		$this->db->close();
		return $result;
	}
	
	
	/**
	 * Actualiza el total de personas de un hogar 
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero  / 2016
	 */
	public function actualizatotperso($datos){
		$formulario=$this->session->userdata("numform");
		$sql = "UPDATE CNP_PREREGISTRO
				SET C3H_TOT_PER= '".$datos['canti']."', 
					FECHAFIN = SYSDATE
				WHERE  NRO_ENCUESTA_FORM='".$formulario."' ";
		$query = $this->db->query($sql);
		
		$sql = "UPDATE CNPV_HOGAR
				SET C3H_TOT_PER= '".$datos['canti']."'
				WHERE  C0I1_ENCUESTA='".$formulario."' ";
		$query = $this->db->query($sql);
				
		$result = true;
		$sql = "UPDATE CNPV_ADMIN_CONTROL SET SEC_HOGAR=1, FK_ESTADO=5, SEC_PREREG=2, FEC_FINPREREG=SYSDATE WHERE NRO_ENCUESTA_FORM='".$formulario."'";
		$query = $this->db->query($sql);
	
		$this->db->close();
		return $result;
	}
	
	
	/**
	 * Actualiza los datos de ubicacion del formulario
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero / 2016
	 */
	public function actualizaubicacion($datos){
		$result = false;
		$var=0;
		$formulario=$this->session->userdata("numform");
		//var_dump ($datos);
		if (!isset($datos['clase']))
		{
			$datos['clase']='';
		}
		if (!isset($datos['territo']))
		{
			$datos['territo']='';
		}
		if (!isset($datos['resgterrit']))
		{
			$datos['resgterrit']='';
		}
		
		
		$sql = "UPDATE CNP_PREREGISTRO
				SET C1I1_DPTO= '".$datos['Departamento']."',
					C1I2_MPIO= '".$datos['Municipio']."', 
					C1IV10_DIR= '".$datos['txtdireccion']."', 
					CLASE= '".$datos['clase']."', 
					LOCALIDAD_COMUNA= '".$datos['txtlocalidad']."',
					CENTRO_POBLADO= '".$datos['txtpoblado']."',
					BARRIO_CORREGI_VEREDA= '".$datos['txtbarrio']."',
					TERRITORIALIDAD_ETNICA= '".$datos['territo']."',
					NOM_RESGUARDO_INDIGENA= '".$datos['txtresgu']."',
					NOM_COMUNIDAD_NEGRA= '".$datos['txtnomcomu']."',
					COMUNIDAD_VEREDA_RANCHERIA= '".$datos['resgterrit']."',
					NOM_COMUNIDAD_VEREDA_RANCHERIA= '".$datos['txtnom']."'
				WHERE  NRO_ENCUESTA_FORM='".$formulario."' ";
		$query = $this->db->query($sql);
		if ($query)
			$var=1;
	
		$sql = "UPDATE CNPV_VIVIENDA
				SET C1I1_DPTO= '".$datos['Departamento']."',
					C1I2_MPIO= '".$datos['Municipio']."',
					C1IV10_DIR= '".$datos['txtdireccion']."',
					C1I3_CLASE= '".$datos['clase']."'
				WHERE  C0I1_ENCUESTA='".$formulario."' ";
		$query = $this->db->query($sql);
		if ($query)
			$var=2;
		
		if ($var==2)
		{
			$reult=true;
			/*HACE EL UPDATE DE LA TABLA DE CONTROL*/
			$sql = "UPDATE CNPV_ADMIN_CONTROL SET SEC_VIVI=1, FK_ESTADO=2, FK_DEPTO='".$datos['Departamento']."', FK_MPIO='".$datos['Municipio']."' WHERE NRO_ENCUESTA_FORM='".$formulario."'";
			$query = $this->db->query($sql);
			//echo "<br>CONTROL<br>".$sql;
		}
		
		$this->db->close();
		return $result;
	}
	
	/**
	 * verifica que no exista la cedula de la persona que esta ingresando la informacion del fomulario
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero / 2016
	 */
	public function verificaced($datos){
		//var_dump ($datos);
		$result=true;
		
		$sql1="select * from  CNP_PREREGISTRO where C4P40_TIPO_DOC='".$datos['tipo']."' and CEDULA='".$datos['cc']."'";
		$query = $this->db->query($sql1);
		$validapadre=$query->num_rows();
			
		$sql2="select * from  CNP_PREREGISTRO_PERSONAS where C4P40_TIPO_DOC='".$datos['tipo']."' and C4P41_SABE_DOC='".$datos['cc']."'";
		$query = $this->db->query($sql2);
		$validahijo=$query->num_rows();
			
		if ($validapadre> 0 || $validahijo>0)
		{
			$result = false;
		}
		return $result;
		
	}
	
	/**
	 * Funcion para verificar que todos los datos de todos los integrantes del hogar esten completos
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero  / 2016
	 */
	public function verificacompletos($dato){
		//var_dump ($datos);
		$result=0;
	
		$sql1="select SUM(COMPLETO) AS COMPLETOS from  CNP_PREREGISTRO_PERSONAS
		where NRO_ENCUESTA_FORM='".$dato."'";
		$query = $this->db->query($sql1);
		$validapadre=$query->num_rows();

		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$result = $row->COMPLETOS;
			}
		};
			
		return $result;
	
	}
	
	/**
	 * grilla personas del hogar
	 * @author Angela Rodriguez
	 * @since  Enero / 2016
	 */
	public function GridPerHogar($formulario){
		$data = array();
		//$formulario="900000159";
		$sql = "SELECT  C4P40_TIPO_DOC, C4P41_NRO_PER,
					C4P41_SABE_DOC,
					C4P39A_1ER_NOMBRE,
					C4P39AA_2DO_NOMBRE,
					C4P39B_1ER_APELLIDO,
					C4P39BB_2DO_APELLIDO,
					C4P44_EDAD,
					C4P42_SEXO,
					JEFE,  
					SUM(NVL(case JEFE when 1 then 1 else 0 end, 0)) OVER () AS EXISTE, 
					SUM(NVL (completo, 0)) OVER () AS COMPLETO
					FROM CNP_PREREGISTRO_PERSONAS
					WHERE NRO_ENCUESTA_FORM='".$formulario."'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			$i = 0;
			$existe=0;
			foreach($query->result() as $row){
				$data[$i]["EXISTE"] = $row->EXISTE;
				$data[$i]['COMPLETO']=$row->COMPLETO;
				$data[$i]["C4P41_NRO_PER"] = $row->C4P41_NRO_PER;
				$data[$i]["C4P42A_1ER_NOMBRE"] = $row->C4P39A_1ER_NOMBRE;
				$data[$i]["C3R38B2_2NOMBRE"] = $row->C4P39AA_2DO_NOMBRE;
				$data[$i]["C4P42B_1ER_APELLIDO"] = $row->C4P39B_1ER_APELLIDO;
				$data[$i]["C3R38C2_2APELLIDO"] = $row->C4P39BB_2DO_APELLIDO;
				 
				if ($row->C4P40_TIPO_DOC==1)
				{
					$data[$i]['C4P43_TIPO_DOC_DES']  = "RC";
				}
				else if ($row->C4P40_TIPO_DOC==2)
				{
					$data[$i]['C4P43_TIPO_DOC_DES']  = "TI";
				}
				else if ($row->C4P40_TIPO_DOC==3)
				{
					$data[$i]['C4P43_TIPO_DOC_DES']  = "CC";
				}
				else if ($row->C4P40_TIPO_DOC==4)
				{
					$data[$i]['C4P43_TIPO_DOC_DES']  = "CE";
				}
				else if ($row->C4P40_TIPO_DOC==5)
				{
					$data[$i]['C4P43_TIPO_DOC_DES']  = "NT";
				}
				$data[$i]["C4P43_TIPO_DOC"] = $row->C4P40_TIPO_DOC;
				$data[$i]["C4P44_NRO_DOC"] = $row->C4P41_SABE_DOC;
				$data[$i]["C4P47_EDAD"] = $row->C4P44_EDAD;
				$data[$i]["C4P45_SEXO"] = $row->C4P42_SEXO;
				if ($row->C4P42_SEXO==1)
				{
					$data[$i]['C4P45_SEXO_DES']  = "Hombre";
				}
				else if ($row->C4P42_SEXO==2)
				{
					$data[$i]['C4P45_SEXO_DES']  = "Mujer";
				}
				else
				{
					$data[$i]['C4P45_SEXO_DES']  = "";
					 
				}
				 
				if ($row->JEFE==1)
				{
					$data[$i]['C4P49_PARENTESCO_DES']  = "S&iacute;";
	
				}
				else
				{
					$data[$i]['C4P49_PARENTESCO_DES']  = "No";
	
				}
				$data[$i]['C4P49_PARENTESCO']=$row->JEFE;
				
				 
				$i++;
			}
	
		}
		$this->db->close();
		return $data;
	}
	
	
	/**
	 * obtiene todos los datos del preregistro
	 * @author Liliana Ramirez Pedraza
	 * @since  Agosto 18 / 2015
	 */
	public function obtenernombre($formulario)
	{
		$result = false;
		$sql = "SELECT * FROM CNP_PREREGISTRO WHERE NRO_ENCUESTA_FORM='$formulario'";
		$query = $this->db->query($sql);
	
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$result   = $row->PRIMER_NOMBRE." ".$row->SEGUNDO_NOMBRE ." ". $row->PRIMER_APELLIDO . " ". $row->SEGUNDO_APELLIDO;
			}
		}
		$this->db->close();
		return $result;
	}
	
	
	/**
	 * obtiene todos los datos del preregistro
	 * @author Liliana Ramirez Pedraza
	 * @since  Agosto 18 / 2015
	 */
	public function obtenersuccess1($formu)
	{
		$sql = "SELECT * FROM CNP_PREREGISTRO WHERE NRO_ENCUESTA_FORM='$formu'";
			
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$result['PRIMER_NOMBRE']   = utf8_decode($row->PRIMER_NOMBRE);
				$result['SEGUNDO_NOMBRE']  = utf8_decode($row->SEGUNDO_NOMBRE);
				$result['PRIMER_APELLIDO'] = utf8_decode($row->PRIMER_APELLIDO);
				$result['SEGUNDO_APELLIDO']= utf8_decode($row->SEGUNDO_APELLIDO);
				$result['CORREO_ELECTRONICO']      = $row->CORREO_ELECTRONICO;
				$result['CONTRASENA'] = utf8_decode($row->CONTRASENA);
			}
		}
		$this->db->close();
		return $result;
	}
		
	
	/**
	 * obtiene todos los datos del preregistro
	 * @author Liliana Ramirez Pedraza
	 * @since  Agosto 18 / 2015
	 */
	public function obtenercorreo($formulario)
	{
		$result = false;
		$sql = "SELECT * FROM CNP_ADMIN_USUARIOS
		 WHERE NRO_ENCUESTA_FORM='$formulario'";
		$query = $this->db->query($sql);
	
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				
				$result   = $row->USUARIO;
			}
		}
		//echo "<br>eeeeeeeee".$result;
		$this->db->close();
		return $result;
	}
	
	/**
	 * obtiene todos los datos del preregistro
	 * @author Liliana Ramirez Pedraza
	 * @since  Agosto 18 / 2015
	 */
	public function obtenerclave($formulario)
	{
		$result = false;
		$sql = "SELECT * FROM CNP_PREREGISTRO WHERE NRO_ENCUESTA_FORM='$formulario'";
		$query = $this->db->query($sql);
	
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
	
				$result   = $row->CONTRASENA;
			}
		}
		$this->db->close();
		return $result;
	}
	
	
	
	/**
	 * verifica que no exista la cedula de las personas integrantes del hogar 
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero / 2016
	 */
	public function verificaExisteCC($datos){
		$existe=0;
		if ($datos['C4P43_TIPO_DOC']==5)
		{
			$existe=0;
		}
		else
		{
			$sqlver ="SELECT * FROM CNPV_PERSONA_HOGAR 
					WHERE C4P43_TIPO_DOC='".$datos['C4P43_TIPO_DOC']."' AND C4P44_NRO_DOC='".$datos['C4P44_NRO_DOC']."'";
			$query = $this->db->query($sqlver);
			if ($query->num_rows() > 0){
				$existe=1;
			}
			else
			{
				$existe=0;
			}
		}
		$this->db->close();
		return  $existe;
	}
	
	
	
	/**
	 * inserta en la tabla de pre_registo personas y en personas_recidentes y en personas_hogar
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero / 2016
	 */
	public function GuardaPerHogar($datos){
		//var_dump ($datos);
		$existe=0;
		
		$sqlver ="SELECT MAX(C4P41_NRO_PER) AS C4P41_NRO_PER  FROM CNP_PREREGISTRO_PERSONAS
                WHERE
                NRO_ENCUESTA_FORM= '".$datos['formulario']."' ";
		$query = $this->db->query($sqlver);
		
		if ($query->num_rows() > 0){
			foreach($query->result() as $row)
			{
				$consecutivo=$row -> C4P41_NRO_PER+1;
			}
		}
	
		echo "<br>primera ".$sql = "INSERT INTO CNP_PREREGISTRO_PERSONAS
				(DIRECTORIO, C4P40_TIPO_DOC,  C4P41_SABE_DOC, C4P39A_1ER_NOMBRE, C4P39AA_2DO_NOMBRE, C4P39B_1ER_APELLIDO, C4P39BB_2DO_APELLIDO, C4P44_EDAD, C4P42_SEXO, JEFE, NRO_ENCUESTA_FORM, COMPLETO, C4P41_NRO_PER)
				VALUES (SEQ_PREREGISTRO_PERSONAS.Nextval, '".$datos['C4P43_TIPO_DOC']."','".$datos['C4P44_NRO_DOC']."', '".$datos['C4P42A_1ER_NOMBRE']."', '".$datos['C3R38B2_2NOMBRE']."', '".$datos['C4P42B_1ER_APELLIDO']."', '".$datos['C3R38C2_2APELLIDO']."' , '".$datos['C4P47_EDAD']."' , '".$datos['C4P45_SEXO']."','".$datos['C4P49_PARENTESCO']."', '".$datos['formulario']."', '1', $consecutivo)";
		$query = $this->db->query($sql);
	
		
		echo "<br>segunda ".$sql = "INSERT INTO CNPV_PERSONA_HOGAR
			(C0I1_ENCUESTA, C3P24_NROHOG, C4P41_NRO_PER, C4P42A_1ER_NOMBRE,  C4P42B_1ER_APELLIDO, C4P43_TIPO_DOC, C4P44_NRO_DOC, C4P45_SEXO, C4P47_EDAD, C4P49_PARENTESCO)
			VALUES ('".$datos['formulario']."', '1', '".$consecutivo."', '".$datos['C4P42A_1ER_NOMBRE']."', '".$datos['C4P42B_1ER_APELLIDO']."', '".$datos['C4P43_TIPO_DOC']."', '".$datos['C4P44_NRO_DOC']."', '".$datos['C4P45_SEXO']."', '".$datos['C4P47_EDAD']."', '".$datos['C4P49_PARENTESCO']."')";
		$query = $this->db->query($sql);
	
		
		echo "<br>tercera ".$sql = "INSERT INTO CNPV_PERSONA_RESIDENTE
			(C0I1_ENCUESTA, C3R24_NROHOG, C3R38A_NRO_RESI, C3R38B1_1NOMBRE,  C3R38B2_2NOMBRE, C3R38C1_1APELLIDO, C3R38C2_2APELLIDO)
			VALUES ('".$datos['formulario']."', '1', '".$consecutivo."', '".$datos['C4P42A_1ER_NOMBRE']."', '".$datos['C3R38B2_2NOMBRE']."', '".$datos['C4P42B_1ER_APELLIDO']."', '".$datos['C3R38C2_2APELLIDO']."')";
		$query = $this->db->query($sql);
		
		if ($query)
		{
			$existe=1;
		}
	
		return $existe;
	
	}
	
	/**
	 * verifica si existe la cc de la persona que estan modificando
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero / 2016
	 */
	public function verificaExisteCCmodificar($datos){
		$existe=0;
		/*echo "aquii";
			var_dump ($datos);
		echo "fin datos";*/
		if ($datos['C4P43_TIPO_DOC']==5)
		{
			$existe=0;
		}
		else
		{
			$sqlver ="SELECT * FROM CNPV_PERSONA_HOGAR
					 WHERE C4P43_TIPO_DOC='".$datos['C4P43_TIPO_DOC']."' AND C4P44_NRO_DOC='".$datos['C4P44_NRO_DOC']."' and C4P41_NRO_PER!='".$datos['id']."'";
			$query = $this->db->query($sqlver);
			if ($query->num_rows() > 0){
				$existe=1;
			}
			else
			{
				$existe=0;
			}
		}
		$this->db->close();
		return  $existe;
	}
	
	/**
	 * Actualiza los datos de la persona del hogar en las tres tablas  
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero / 2016
	 */
	public function EditaPerHogar($datos){
		//var_dump ($datos);
		$existe=0;
	
		$sql = "UPDATE CNP_PREREGISTRO_PERSONAS SET
				C4P39A_1ER_NOMBRE= '".$datos['C4P42A_1ER_NOMBRE']."', C4P39AA_2DO_NOMBRE= '".$datos['C3R38B2_2NOMBRE']."', C4P39B_1ER_APELLIDO= '".$datos['C4P42B_1ER_APELLIDO']."', C4P39BB_2DO_APELLIDO= '".$datos['C3R38C2_2APELLIDO']."',  C4P40_TIPO_DOC='".$datos['C4P43_TIPO_DOC']."', C4P41_SABE_DOC='".$datos['C4P44_NRO_DOC']."', C4P42_SEXO='".$datos['C4P45_SEXO']."', C4P44_EDAD='".$datos['C4P47_EDAD']."', JEFE='".$datos['C4P49_PARENTESCO']."', COMPLETO='1'
				WHERE NRO_ENCUESTA_FORM= '".$datos['formulario']."'  AND  C4P41_NRO_PER = '".$datos['C4P41_NRO_PER']."'";
		$query = $this->db->query($sql);
		if ($query)
		{
			$existe=2;
		}
		
		if ($datos['C4P41_NRO_PER']==1)
		{
			$sql = "UPDATE CNP_PREREGISTRO SET
				PRIMER_NOMBRE= '".$datos['C4P42A_1ER_NOMBRE']."', SEGUNDO_NOMBRE= '".$datos['C3R38B2_2NOMBRE']."', PRIMER_APELLIDO= '".$datos['C4P42B_1ER_APELLIDO']."', SEGUNDO_APELLIDO= '".$datos['C3R38C2_2APELLIDO']."',  C4P40_TIPO_DOC='".$datos['C4P43_TIPO_DOC']."', CEDULA='".$datos['C4P44_NRO_DOC']."'
				WHERE NRO_ENCUESTA_FORM= '".$datos['formulario']."' ";
			$query = $this->db->query($sql);
		}
		
		$sql = "UPDATE CNPV_PERSONA_HOGAR SET
				C4P42A_1ER_NOMBRE= '".$datos['C4P42A_1ER_NOMBRE']."', C4P42B_1ER_APELLIDO= '".$datos['C4P42B_1ER_APELLIDO']."', C4P43_TIPO_DOC='".$datos['C4P43_TIPO_DOC']."', C4P44_NRO_DOC='".$datos['C4P44_NRO_DOC']."', C4P45_SEXO='".$datos['C4P45_SEXO']."', C4P47_EDAD='".$datos['C4P47_EDAD']."', C4P49_PARENTESCO='".$datos['C4P49_PARENTESCO']."'
				WHERE C0I1_ENCUESTA= '".$datos['formulario']."'  AND  C4P41_NRO_PER = '".$datos['C4P41_NRO_PER']."'";
		$query = $this->db->query($sql);
		if ($query)
		{
			$existe=3;
		}
		
		$sql = "UPDATE CNPV_PERSONA_RESIDENTE SET
				C3R38B1_1NOMBRE= '".$datos['C4P42A_1ER_NOMBRE']."', C3R38B2_2NOMBRE= '".$datos['C3R38B2_2NOMBRE']."', C3R38C1_1APELLIDO= '".$datos['C4P42B_1ER_APELLIDO']."', C3R38C2_2APELLIDO= '".$datos['C3R38C2_2APELLIDO']."'
				WHERE C0I1_ENCUESTA= '".$datos['formulario']."'  AND  C3R38A_NRO_RESI = '".$datos['C4P41_NRO_PER']."'";
		$query = $this->db->query($sql);
		if ($query)
		{
			$existe=4;
		}
		
		if ($existe==4)
		{
			$existe=1;
		}
	
		return $existe;
	}
	
	/**
	 * Elimina la persona integrante del hogar en las tres tablas  
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero / 2016
	 */
	public function EliminarPerHogar($datos){
		//var_dump ($datos);
		$existe=0;
	
		$sql = "DELETE FROM CNP_PREREGISTRO_PERSONAS
				WHERE 
				NRO_ENCUESTA_FORM= '".$datos['formulario']."' AND  C4P41_NRO_PER = '".$datos['id']."'";
		$query = $this->db->query($sql);
		if ($query)
		{
			$existe=2;
		}
		
		
		$sql = "DELETE FROM CNPV_PERSONA_RESIDENTE
				WHERE 
				C0I1_ENCUESTA= '".$datos['formulario']."' AND  C3R38A_NRO_RESI = '".$datos['id']."'";
		$query = $this->db->query($sql);
		if ($query)
		{
			$existe=3;
		} 
		
		
		$sql = "DELETE FROM CNPV_PERSONA_HOGAR
				WHERE
				C0I1_ENCUESTA= '".$datos['formulario']."' AND  C4P41_NRO_PER = '".$datos['id']."'";
		$query = $this->db->query($sql);
		if ($query)
		{
			$existe=3;
		}
		
		
		if ($query)
		{
			$existe=1;
		}
	
		return $existe;
	
	}
	
	
	/**
	 * guarda el registro cuando la persona dice que no acepta
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero / 2016
	 */
	public function guardarnoacpto($data){

		$opcion = $data['radioOpcion'];
		$txtObs = $data['txtObs'];

		$sqlverinum="SELECT MAX(NRO_ENCUESTA_FORM) AS NUMERO FROM CNPV_ADMIN_CONTROL ";
		$resverinum = $this->db->query($sqlverinum);
		$valinumform=$resverinum->num_rows();
		if ($valinumform>0)
		{
			foreach($resverinum->result() as $row)
			{
				$actual = $row->NUMERO;
				if ($actual==0)
				{
					$formulario =900000000;
				}
				else
				{
					$formulario = $actual+1;
				}
			}
		}
		else
		{
			$formulario =900000000;
		}
	
		$sqlcontrol = "INSERT INTO CNPV_ADMIN_CONTROL (NRO_ENCUESTA_FORM, SEC_PREREG, FEC_INIPREREG, FEC_FINPREREG, FK_ESTADO, FK_DEPTO, FK_MPIO)
				VALUES (".$formulario.",'0', SYSDATE, SYSDATE, '0', '0', '0')";
		$query = $this->db->query($sqlcontrol);
	
		$sql = "INSERT INTO CNP_NOACEPTO(DIRECTORIO, OPCION, OBS,NRO_ENCUESTA_FORM)
		VALUES (SEQ_FORM_NOACEPTO.Nextval,'$opcion',  '$txtObs', '$formulario' )";
		$query = $this->db->query($sql);
		$result = true;
		$this->db->close();
	}
	
	
	/**
	 * verifica que no exista el mail para insertar el registro
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero / 2016
	 */
	public function buscarmail($txtcorreo){
		$result = true;
		$sql1="select * from  CNP_PREREGISTRO where CORREO_ELECTRONICO='".$txtcorreo."'";
		$query = $this->db->query($sql1);
		$validamail=$query->num_rows();
			
		if ($validamail> 0 )
		{
			$result = false;
		}
			
		$this->db->close();
		return $result;
	}
	
	
	/**
	 * Busca las opciones del departamento para los combos
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero / 2016
	 */
	function nomdepartamentos()
	{
		$data = false;
		$sql = "SELECT distinct C_DPTO, DPTO FROM CNPV_DIVIPOLA ORDER BY DPTO";
		$query = $this->db->query($sql);
		$i=0;
		if ($query->num_rows() > 0)
		{
			$data = array();
			foreach ($query->result() as $row)
			{
				$data[$i]["id"]=$row->C_DPTO;
				$data[$i]["nombre"]= $row->DPTO;
				$i++;
			}
		}
		//print_r ($data);
		 
		$this->db->close();
		return $data;
	}
	
	/**
	 * Busca las opciones del municipio segun el codigo del departamento para los combos
	 * @author Angela Liliana Rodriguez Mahecha
	 * @since  Enero / 2016
	 */
	function nomdempios($coddepto)
	{
		$data = false;
		$sql = "SELECT C_MPIO, MPIO FROM CNPV_DIVIPOLA WHERE C_DPTO='".$coddepto."'ORDER BY MPIO ";
		$query = $this->db->query($sql);
		$i=0;
		if ($query->num_rows() > 0)
		{
			$data = array();
			foreach ($query->result() as $row)
			{
				$data[$i]["id"]=$row->C_MPIO;
				$data[$i]["nombre"]= $row->MPIO;
				$i++;
			}
		}
		//print_r ($data);
		 
		$this->db->close();
		return $data;
	}
	
}//EOC