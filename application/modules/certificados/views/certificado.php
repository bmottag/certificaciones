<html>
<head>
<title>certificado</title>

<style type="text/css">
   div.special { margin: auto; width:83%; text-align: justify; padding: 0 0 35px; }

      
    body{
        height:100%; margin:0;
        font-family:12px Helvetica, Arial, sans-serif;
        background: #ffffff;
    }              

    h3{
       font-size:14pt;
       text-align:center;
       padding:0 0 15px;
    }     

    #conteiner{min-height:100%; }

    #content {
        margin:0 auto;
        position: relative;
        margin-bottom:702px;
    }            

    #cabecera{
        height: 130px;
        width: auto;
        padding:10px;
    }
    
    #codigo{
       font-size:8pt;
       text-align:Left;
       padding:0 0 0 30px;
    } 
    
    #footer {
        width: auto;
        height: 106px;
        padding: 20px 0;

        margin-top:-200px;
        -webkit-box-sizing:border-box;
        -moz-box-sizing:border-box;
        box-sizing:border-box;

    }        
</style>
</head>
<body >

<div id="cabecera">
    <img src="<?php echo $parametricas[3]["VALOR"] . 'top_cert.png'?>" />
</div>   
    
<div id="conteiner">
    <div id="content">
        <h3>
            <?php 
                if($parametricas[1]["VALOR"] == "F"){
                    echo "LA COORDINADORA ";
                }elseif($parametricas[1]["VALOR"] == "M"){
                    echo "EL COORDINADOR ";
                }
            ?>
            DEL &Aacute;REA DE GESTI&Oacute;N HUMANA
        </h3>

        <h3>HACE CONSTAR</h3>
  
        <div class="special">
            <p>
            <?php 
                $nombre  =  utf8_decode($usuario["NOMBRES"]).' '.utf8_decode($usuario["PRIMER_APELLIDO"]).' '.utf8_decode($usuario["SEGUNDO_APELLIDO"]);
                //Ajustar codigo y cargo anterior
                $length = strrpos($usuario["CARGO_NOM"]," ");
                $newValue = explode( "-" , substr($usuario["CARGO_NOM"],$length));
                $codigo = $newValue[0];  
                $grado = $newValue[1];
                //Ajustar codigo y cargo actual
                $length2 = strrpos($usuario["CARGO_ACTUAL"]," ");
                $newValue2 = explode( "-" , substr($usuario["CARGO_ACTUAL"],$length));
                $codigo2 = $newValue2[0];  
                $grado2 = $newValue2[1]; 
                
                $genero = "el se&ntilde;or(a)";
                if($usuario["SEXO"] === "F" ){
                    $genero = "la se&ntilde;ora ";
                    $ident = "indentificada";
                    $vinculado = "vinculada";
                }elseif ($usuario["SEXO"] === "M") {
                    $genero = "el se&ntilde;or ";
                    $ident = "indentificado";
                    $vinculado = "vinculado";
                }
            ?>
                Que <?php echo $genero; ?> <?php echo $nombre?>, <?php echo $ident; ?> con c&eacute;dula de ciudadan&iacute;a No. <?php echo number_format($usuario["NUMERO_IDENTIFICACION"]); ?>, 
                presta sus servicios a este Departamento desde el <?php echo $usuario["FECHA"];  ?>.
            </p>

            
            
            <?php 
                $contenido = "";
                if($certificado["ENCARGO"] && $usuario["TIPONOMBRAMIENTO"] == "PROPIEDAD" && $usuario["CARGO_NOM"] != $usuario["CARGO_ACTUAL"] ){ 
                    $contenido = "<p>
                                    Que actualmente se encuentra " . $vinculado . " a la Planta de Personal del DANE, 
                                    en Carrera Administrativa como  titular  del  cargo ";
                    $contenido.= $usuario["DESCCARGO"];  
                    $contenido.= " C&oacute;digo " . $codigo . " Grado " . $grado;
                    $contenido.= " y actualmente se desempe&ntilde;a en calidad de encargo de ";
                    $contenido.= $usuario["DESCCARGO_ACTUAL"];
                    $contenido.= " C&oacute;digo " . $codigo2 . " Grado " . $grado2;

                    if($certificado["SALARIO"]){ 
                        $contenido.= ", con una asignaci&oacute;n b&aacute;sica mensual de $" . number_format($usuario["ASIGNACION_BASICA_ACTUAL"]);
                    }
                    $contenido.=".</p>";
                 }else{ 
                    $contenido = "<p>
                                    Que actualmente se encuentra " . $vinculado . " a la Planta de Personal del DANE, 
                                    en el cargo de ";
                    $contenido.= $usuario["DESCCARGO_ACTUAL"];
                    $contenido.= " C&oacute;digo " . $codigo2 . " Grado " . $grado2; 

                    if($usuario["TIPONOMBRAMIENTO"] == "PROPIEDADaaa"){ 
                        $contenido.= ", en Carrera Administrativa";
                    }elseif($usuario["TIPONOMBRAMIENTO"] == "PROVISIONAL"){ 
                        $contenido.= ", en Nombramiento Provisional";
                    }elseif($usuario["TIPONOMBRAMIENTO"] == "LIBRE NOMBRAMIENTO Y REMOCION"){ 
                        $contenido.= ", en Libre Nombramiento y Remoci&oacute;n";
                    }
                    if($certificado["SALARIO"]){ 
                        $contenido.= ", con una asignaci&oacute;n b&aacute;sica mensual de $" . number_format($usuario["ASIGNACION_BASICA_ACTUAL"]);
                    }                    
                    $contenido.=".</p>";
                 }
                 echo $contenido;
             ?>            
            
            
            
            
            <?php if($certificado["NIT"]){ ?>
            <p>
                Que el Departamento Administrativo Nacional de Estad&iacute;stica,  se identifica con el NIT No. 899999027-8.
            </p>
            <?php } ?>
            <p>
                La presente se expide en la ciudad de Bogot&aacute;, el <?php echo $certificado["FECHA"]; ?>, con destino
                <?php
                    $destino = " al interesado.";
                    if($certificado["ENTIDAD"]){
                        $destino = $certificado["ENTIDAD"] . ".";   
                    }
                    echo $destino; 
                ?>
            </p>
        </div>

        <h3>
            <img src="<?php echo $parametricas[3]["VALOR"] . 'firma_coordinador.png'?>" /><br>
            <?php echo $parametricas[0]["VALOR"]; ?>
        </h3>
    </div> 
</div>
    
<div id="footer">
    <div id="codigo">
        Codigo de validaci&oacute;n: 
        <?php echo $certificado["ID_CERTIFICADO"] . $certificado["CODIGO_VALIDACION"]; ?>
    </div>
    <img src="<?php echo $parametricas[3]["VALOR"] . 'footer_cert.png'?>" />
</div>  


</body>
</html>