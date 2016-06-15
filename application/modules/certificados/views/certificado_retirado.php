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
        position: fixed;
        bottom: 0;        
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
                
                //genero del usuario
                $genero = "el se&ntilde;or(a) ";
                if($usuario["SEXO"] === "F" ){
                    $genero = "la se&ntilde;ora ";
                    $ident = "indentificada";
                }elseif ($usuario["SEXO"] === "M") {
                    $genero = "el se&ntilde;or";
                    $ident = "indentificado";
                }
                
            ?>
                Que <?php echo $genero; ?> <?php echo $nombre?>, <?php echo $ident; ?> con c&eacute;dula de ciudadan&iacute;a No. <?php echo number_format($usuario["NUMERO_IDENTIFICACION"]); ?>, 
                prest&oacute; sus servicios a este Departamento entre el <?php echo $usuario["FECHA"];  ?> y hasta el <?php echo $usuario["FECHA_RETIRO"];  ?>.
            </p>

            
            
            <?php 
                $contenido = "<p>Que en el momento de su retiro, desempe&ntilde;aba en la Planta de Personal del DANE el cargo de ";
                $contenido.= $usuario["DESCCARGO"];
                $contenido.= " C&oacute;digo " . $codigo . " Grado " . $grado; 
                $contenido.=".</p>";
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
        <?php echo $codigo = $certificado["ID_CERTIFICADO"] . $certificado["CODIGO_VALIDACION"]; ?>
    </div>
    <img src="<?php echo $parametricas[3]["VALOR"] . 'footer_cert.png'?>" />
</div>  


</body>
</html>