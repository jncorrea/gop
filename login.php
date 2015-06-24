
<?php
	include("include/validar_form.php");

 extract($_GET);
     if (@$mensaje==1) {
        echo '<script language="javascript">alert("Por favor, Ingrese usuario y contraseña correctos");</script> ';
         # code...
     }
 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Gestión de Cancha Online</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap1.css" rel="stylesheet">

    <link href="assets/css/style1.css" rel="stylesheet">
    <link href="assets/css/style-responsive1.css" rel="stylesheet">

  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">

		      <form class="form-login" action="include/validar.php" method="post">
		      	<div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          
		                          <h4 class="form-login-heading">PÁGINA PRINCIPAL</h4>

		                      </div>

		        

		        <div class="login-wrap">

		            <label class="checkbox">
		                <span class="pull-right">
		                    <a data-toggle="modal" href="login.php#myModal"> Inniciar Sesión </a>
		                    <br>
		                    <a  href="register.php"> Crear Cuenta </a>
		                    <br>

		                </span>
		            </label>
		            <hr>
		
		        </div>

		      </form>

		      <!-- Modal -->
		          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
		              <div class="modal-dialog">
		                  <div class="container">

		                      <form class="form-login" action="include/validar.php" method="post">
		                      	<div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          
		                          <h4 class="form-login-heading">Iniciar Sesión </h4>

		                      </div>
		        
		        <div class="login-wrap">

		            <input name="user"  type="text" class="form-control" placeholder="User ID"  autofocus/>
		            <br>
		            <input name="pass" type="password" class="form-control" placeholder="Password" />
		            <br>
		            <button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i> Iniciar Sesión</button>
		            <hr>
		            
		            <div class="login-social-link centered">
		            
		            </div>
		            <div class="registration">
		                Aún no te haz registrado, Crea tu cuenta Ahora!?<br/>
		                
		                <a href="register.php"> Crear Cuenta. </a>
		            </div>
		        </div>
		      </form>
		              </div>
		          </div>
		          <!-- modal -->
	  	</div>
	  	 <!-- Modal -->
		          

	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery1.js"></script>
    <script src="assets/js/bootstrap1.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.jpg", {speed: 500});
    </script>


  </body>
</html>
