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
<?php if (isset($nomenu)){ ?>            
      <div id="navbar" class="collapse navbar-collapse navbar-right">
        	<ul class="nav navbar-nav">
                    <li class="active"><a href="<?php echo site_url("/login/salir"); ?>">Salir</a></li>
          	</ul>
        </div><!--/.nav-collapse -->
<?php } ?>        
		<div class="row" id="colorbar">
			<div class="row col-md-offset-4 col-md-5 hidden-xs" id="color_container">
				<div id="color1"></div>
				<div id="color2"></div>
				<div id="color3"></div>
				<div id="color4"></div>
				<div id="color5"></div>
				<div id="color6"></div>
			</div>
		</div>        		
		<div class="clearfix"></div>
		
	</div>
</nav>