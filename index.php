<?php 
	require("login/validar_form.php");
	extract($_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<script src="/path/to/jquery.js" type="text/javascript"></script>
<script src="/path/to/jquery.ui.draggable.js" type="text/javascript"></script>

<script src="/path/to/jquery.alerts.js" type="text/javascript"></script>
<link href="/path/to/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />

<script type="text/javascript" src="assets/lib/alertify.js"></script>
		<link rel="stylesheet" href="assets/themes/alertify.core.css" />
		<link rel="stylesheet" href="assets/themes/alertify.default.css" />


	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gather, Organize and Play</title>
	<link rel="shortcut icon" type="image/ico" href="assets/img/ball.png">
	<link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/gop.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/animations.css" type="text/css">
	<script>
		
			function alerta(){
				//un alert
				alertify.alert("<b>Por favor Iniciar Sesion, para continuar..", function () {
					location.href = 'index.php';
				});
			}			
			
			function error(){
				alertify.error("<b>Por favor Iniciar Sesion, para continuar.."); 
				return false; 
			}
		</script>

</head>
<body>

	<!--- MENU -->
	<header>
		<div class="row"></div>
			<div class="img col-xs-6 col-sm-4 col-md-4 col-lg-3">
				<img src="assets/img/logo.png" alt="">
			</div>
			<div class="col-xs-6 col-sm-8 col-md-8 col-lg-9">
				<nav class="navbar navbar-inverse navbar-static-top" style="margin-top: 15px;">
			      <div class="container">
			        <div class="navbar-header">
			          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			            <span class="sr-only">Toggle navigation</span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			          </button>
			        </div>
			        <div id="navbar" class="navbar-collapse collapse">
			          <ul class="nav navbar-nav">
			            <li class="active"><a href="index.php">INICIO</a></li>
			            <li><a data-toggle="modal" href="#login-page">Sign up</a></li>
			            <li><a data-toggle="modal" href="#myModal">Log in</a></li>
			          </ul>
			        </div>
			      </div>
			    </nav>
			</div>
		</div>		
	</header>
	<!--- FIN MENU -->
	<!--- CAROUSEL DE IMAGENES -->
	<section>
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		    <li data-target="#myCarousel" data-slide-to="1"></li>
		    <li data-target="#myCarousel" data-slide-to="2"></li>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner animatedParent" data-appear-top-offset='-300' role="listbox">
		    <div class="item active">
		      <img src="assets/img/soccer1.png" alt="Bienvenido" class="img-carousel">
		      <div class="carousel-caption animated bounceIn">Bienvenido</div>
		    </div>
		    <div class="item">
		      <img src="assets/img/soccer2.png" alt="Bienvenido" class="img-carousel">
		      <div class="carousel-caption animated bounceIn">Bienvenido</div>
		    </div>
		    <div class="item">
		      <img src="assets/img/soccer3.png" alt="Bienvenido" class="img-carousel">
		      <div class="carousel-caption animated bounceIn">Bienvenido</div>
		    </div>
		  </div>
		  <!-- Controls -->
		  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
	</section>
	<!--- fIN CAROUSEL DE IMAGENES -->
	<!--- MODAL LOG IN -->
	<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog login">
            <div class="container">
                <form class="form-login" action="login/validar.php" method="post">
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
			            <div class="registration">
			                Aún no te haz registrado, Crea tu cuenta Ahora!?<br/>		                
			                <a id="signup" data-toggle="modal" href="#" onclick="cerrar()"> Crear Cuenta. </a>
			            </div>
			        </div>
			    </form>
			</div>
    	</div>
	</div>
    <!--- FIN MODAL LOG IN -->
    <!--- MODAL SIGN UP -->
	<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="login-page" class="modal fade">
        <div class="modal-dialog register">
            <div class="container">
                <?php if(!isset($status)): ?>
			  	<form class="form-login" action="index.php" method="post">
			  		<div class="modal-header">
                    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    	<h4 class="form-login-heading">Registro de Usuarios </h4>
                  	</div>
			  		<div class="login-wrap">
			  			<label for="email" style="color: #8D8D8D; font-family:arial; font-weight: normal;">E-mail (<span id="req-email" class="requisites <?php echo $email ?>">Un e-mail válido por favor</span>):</label>
			  			<input tabindex="4" name="email" id="email" type="text" class="form-control" value="<?php echo $emailValue ?>" />
						<br>
						<label for="password1" style="color: #8D8D8D; font-family:arial; font-weight: normal;">Contraseña (<span id="req-password1" class="requisites <?php echo $password1 ?>">Mínimo 5 caracteres, máximo 12 caracteres, letras y números</span>):</label>
						<input tabindex="2" name="password1" id="password1" type="password" class="form-control" class="text <?php echo $password1 ?>" value="" />
						<br>
						<label for="password2" style="color: #8D8D8D; font-family:arial; font-weight: normal;">Repetir Contraseña (<span id="req-password2" class="requisites <?php echo $password2 ?>">Debe ser igual a la anterior</span>):</label>
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
					}?>				
				<?php endif; ?>
			</div>
    	</div>
	</div>
    <!--- FIN MODAL SIGN UP -->
	<!--- TUTORIAL REUNE, ORGANIZA Y JUEGA -->
	<section class="content animatedParent" style="background:url(assets/img/slider.png);">
		<div class="fondo">
			<section class="animated bounceInLeft">
				<a href="#"><img src="assets/img/ball.png" alt="SoccerBall"></a>
				<p>Reune</p>
			</section>
			<section class="animated bounceInUp">
				<a href="#"><img src="assets/img/ball.png" alt="SoccerBall"></a>
				<p>Organiza</p>
			</section>
			<section class="animated bounceInRight">
				<a href="#"><img src="assets/img/ball.png" alt="SoccerBall"></a>
				<p>Juega</p>
			</section>
		</div>
	</section>
	<!--- FIN TUTORIAL REUNE, ORGANIZA Y JUEGA -->
	<!--- GOOGLE MAPS -->
	<section id="map">
	</section>
	<!--- FIN GOOGLE MAPS -->
	<footer>
		<?php include("static/footer.php"); ?>
	</footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/gop.js"></script>

	<?php
	extract($_GET);
	switch($_GET['mensaje']) {
case '1':

		echo "<script language='javascript'> alertify.alert('<b>Por favor Verifique Usuario y Contrase&ntilde;a..', function () {
					location.href = 'index.php';
				});
</script>";

break;
case '2':

		echo "<script language='javascript'> alertify.alert('<b>Por favor Iniciar Sesi&oacute;n, para continuar..', function () {
					location.href = 'index.php';
				});
</script>";

break;

case '3':

		echo "<script language='javascript'> alertify.alert('<b>Tu Sesi&oacute;n a expirado por favor vuelve a entrar..', function () {
					location.href = 'index.php';
				});
</script>";

break;
					
	default:
	break;
	}

	?>
</body>
</html>
<script src='assets/js/css3-animate-it.js'></script>