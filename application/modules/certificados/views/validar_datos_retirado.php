<div class="container">
	<div class="page-header">
            <h2>Datos generado con el c&oacute;digo de validaci&oacute;n:   
                <button class="btn btn-primary" type="button">
                    <?php echo $codigo = $certificado["ID_CERTIFICADO"] . $certificado["CODIGO_VALIDACION"]; ?>
                </button>
            </h2> 
	</div>
        <div class="well">
            <div class="row" align="center">
                <div class="col-md-10 col-md-offset-1"> 
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
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">

            <p>
            <?php 
                $nombre  =  $usuario["NOMBRES"].' '.$usuario["PRIMER_APELLIDO"].' '.$usuario["SEGUNDO_APELLIDO"];
                //Ajustar codigo y cargo anterior
                $length = strrpos($usuario["CARGO_NOM"]," ");
                $newValue = explode( "-" , substr($usuario["CARGO_NOM"],$length));
                $codigo = $newValue[0];  
                $grado = $newValue[1];
                
                $genero = "el se&ntilde;or(a) ";
                if($usuario["SEXO"] === "F" ){
                    $genero = "la se&ntilde;ora";
                    $ident = "indentifcada";
                }elseif ($usuario["SEXO"] === "M") {
                    $genero = "el se&ntilde;or ";
                    $ident = "indentifcado";
                }

            ?>
                Que <?php echo $genero; ?> <?php echo $nombre?>, <?php echo $ident; ?> con c&eacute;dula de ciudadan&iacute;a No. <?php echo number_format($usuario["NUMERO_IDENTIFICACION"]); ?>, 
                prest&oacute; sus servicios a este Departamento entre el <?php echo $usuario["FECHA"];  ?> y hasta el <?php echo $usuario["FECHA"];  ?>.
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
            </div>
            <div class="row" align="center">
                <div class="col-md-10 col-md-offset-1">
                    <h3><img src='../images/firma_coordinador.png' ><br><?php echo $parametricas[0]["VALOR"]; ?></h3>            
                </div>
            </div>
        </div>
</div>