<div class="container">
    <div class="row">
        <div class="col-md-11"> 
            <div class="row">
                <div class="col-md-10">
                    <div class="radio">
                        <label>
                            Se&ntilde;or(a):<br/>
                            <b>Administrador</b><br/>                                                        

                        </label>
                    </div>
                </div>
            </div>	
            <br/><br/>
            <div class="row">
                <div class="col-md-10">
                    <div class="radio">
                        <label> 
                            A continuaci&oacute;n encuentra los datos de la nueva solicitud de certificación laboral: 
                        </label>
                    </div>
                </div>
            </div>



            <br/><br/>                                


            <div class="row">
                <div class="col-md-3">
                    <b> Usuario : &nbsp;&nbsp;  </b>
                </div>
                <div class="col-md-3">
                    <?php echo $certificado["NOMBRES"] ." ".$certificado["APELLIDOS"]; ?>
                </div>                
            </div>
            <div class="row">
                <div class="col-md-3">
                    <b> N&uacute;mero Identificaci&oacute;n : &nbsp;&nbsp;  </b> 
                </div>
                <div class="col-md-3">
                    <?php echo $certificado["NUM_IDENT"]; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <b> Tipo de Certificaci&oacute;n : &nbsp;&nbsp;  </b> 
                </div>
                <div class="col-md-3">
                    <?php echo $certificado["TIPO_CERTIFICADO"]; ?>
                </div>
            </div>
            <?php if($certificado["SALARIO"] || $certificado["NIT"] || $certificado["ENCARGO"]){ ?>
            <div class="row">
                <div class="col-md-3">
                    <b> Datos adicionales : &nbsp;&nbsp;  </b> 
                </div>
                <div class="col-md-3">
                    <?php 
                        if($certificado["SALARIO"]){ 
                            echo "Con Salario<br>";
                        }
                        if($certificado["NIT"]){ 
                            echo "Con Número del NIT del DANE<br>";
                        }
                        if($certificado["ENCARGO"]){ 
                            echo "Con Encargo si lo tiene";
                        }                        
                    ?>
                </div>
            </div>            
            <?php } ?>
                       
            <div class="row">
                <div class="col-md-3">
                    <b> Correo : &nbsp;&nbsp;  </b> 
                </div>
                <div class="col-md-3">
                    <?php echo $certificado["CORREO"]; ?>
                </div>
            </div>              

            <br/><br/>
            <div class="row">
                <div class="col-md-10">
                    <div class="radio">
                        <label> 
                            Una vez genere el certificado, 
                            enviarlo por correo electr&oacute;nico al usuario y actualizar el estado de la solcitud en el aplicativo.
                        </label>
                    </div>
                </div>
            </div>                        
            <br/><br/>
            <p>Gracias por utilizar el Sistema de Gesti&oacute;n Humana. </p>


        </div>
    </div>