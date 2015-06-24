<?php

	include("validar_form.php");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="es-ES">


  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Registro de Usuarios</title>
    
    <link rel="stylesheet" href="../assets/css/main1.css" type="text/css" media="screen" />
    <link href="../assets/css/stylee.css" rel="stylesheet">
  </head>

  <body>


      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
	  	
	  	<?php if(!isset($status)): ?>
		      <form class="form-login" action="register.php" method="post">
		        <h2 class="form-login-heading">Registro de Usuarios</h2>
		        <div class="login-wrap">
					
				<label for="email">E-mail (<span id="req-email" class="requisites <?php echo $email ?>">Un e-mail válido por favor</span>):</label>
        <input tabindex="4" name="email" id="email" type="text" class="form-control" value="<?php echo $emailValue ?>" />
				<br>
        <label for="password1">Contraseña (<span id="req-password1" class="requisites <?php echo $password1 ?>">Mínimo 5 caracteres, máximo 12 caracteres, letras y números</span>):</label>
				<input tabindex="2" name="password1" id="password1" type="password" class="form-control" class="text <?php echo $password1 ?>" value="" />
				<br>
        <label for="password2">Repetir Contraseña (<span id="req-password2" class="requisites <?php echo $password2 ?>">Debe ser igual a la anterior</span>):</label>
				<input tabindex="3" name="password2" id="password2" type="password" class="form-control" class="text <?php echo $password2 ?>" value="" />
				<br>
        

				<div>
					<input class="btn btn-theme btn-block" tabindex="6" name="send" id="send" type="submit" class="submit" value="Registrarse" />
				</div>


		
		        </div>		
		      </form>

		      <?php 
			extract($_GET);
			     if (@$status==1) {
			        echo "ingresar datos en bd";
			         # code...
			     }
			 ?>				
			<?php endif; ?>	  	
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery1.js"></script>
    <script src="../assets/js/bootstrap1.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="../assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("../assets/img/login-bg.jpg", {speed: 500});
    </script>

    <script type="text/javascript" src="../assets/js/jquery.js"></script> 
	<script type="text/javascript" src="../assets/js/main.js"></script>


  </body>
  </html>

