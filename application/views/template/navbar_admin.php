<nav class="navbar navbar-default navbar-fixed-top" style="z-index: 20000">
    <div class="container-fluid"  id="login-navbar">
        <div class="row">
            <div class="navbar-header col-xs-12 col-sm-12 col-md-6 col-md-offset-1 col-lg-7 col-md-offset-1">
                <img src="<?php echo base_url("images/logo.png"); ?>"> 
            </div>
            <div class="tituloForm col-xs-12 col-sm-12 col-md-5 col-lg-4">
                <h2>&nbsp;&nbsp;Certificaciones <strong>DANE</strong></h2>
            </div>
        </div>

        <div id="navbar" class="collapse navbar-collapse navbar-right">
            <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo site_url("admin/"); ?>">Inicio</a></li>
                <li class="active"><a href="<?php echo site_url("admin/pendientes"); ?>">Solicitudes Pendientes</a></li>
                <li class="active"><a href="<?php echo site_url("admin/reporte"); ?>">Reporte</a></li>
                <li class="active"><a href="<?php echo site_url("admin/usuario"); ?>">Datos Usuario</a></li>
                <li class="active"><a href="<?php echo site_url("admin/parametricas"); ?>">Param&eacute;tricas</a></li>
                <li class="active"><a href="<?php echo site_url("certificados"); ?>">Solicitar Certificaci&oacute;n</a></li>
                <li class="active"><a href="<?php echo site_url("/login/salir"); ?>">Salir</a></li>
            </ul>
        </div><!--/.nav-collapse -->

        <div class="clearfix"></div>
    </div>
</nav>