<?php
	extract($_GET);
	include("static/site_config.php");
	include ("static/clase_mysql.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	date_default_timezone_set('America/Guayaquil');
	error_reporting(0);
	session_start();
	if (@$_GET['i']!="") {
		@$_SESSION['grupo']=@$_GET['i'];
	}
	if (@$_SESSION['logeado'] == 'SI') {
		header("Location: perfiles/perfil.php");
	}
?>
<!DOCTYPE html>
<html lang="es" onclick="limpiar();">
	<head>
		<script type="text/javascript" src="assets/lib/alertify.js"></script>
		<link rel="stylesheet" href="assets/themes/alertify.core.css" />
		<link rel="stylesheet" href="assets/themes/alertify.default.css"/>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="theme-color" content="#2b3643">
		<title>Gather, Organize and Play</title>
		<link rel="shortcut icon" type="image/ico" href="assets/img/ball.png">
		<link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
		<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="assets/css/animations.css" type="text/css">
		<link href="assets/css/gop.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script>
		$(document).ready(function() {
			$("#captcha").load("include/cargarCaptcha.php");
		});
		function cargar(){
			$("#captcha").load("include/cargarCaptcha.php");
		}
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
		<header style="border-bottom: #0b1121 solid 4px;">
			<div class="row"></div>
			<div class="img col-xs-5 col-sm-3 col-md-3 col-lg-3">
				<img src="assets/img/logo-wasisport.png" alt="<h1 style='color:red';>LOGO</h1>" style="padding-top: 1em;">
			</div>
			<div class="col-xs-5 col-sm-7 col-md-8 col-lg-9">
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
						<div id="navbar" class="navbar-collapse collapse" style="float:right;">
							<ul class="nav navbar-nav">
								<li><a data-toggle="modal" href="#login-page">Reg&iacute;strate</a></li>
								<li><a data-toggle="modal" href="#myModal">Ingresa</a></li>
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
		      <img src="assets/img/fondo2.jpg" alt="Bienvenido" class="img-carousel">
		      
		      <div class="carousel-caption animated bounceIn"><h4 id="mensaje" style="font-size:18%; color:red;"></h4>Bienvenido</div>
		    </div>
		    <div class="item">
		      <img src="assets/img/fondo1.jpg" alt="Bienvenido" class="img-carousel">
		      <div class="carousel-caption animated bounceIn">Bienvenido</div>
		    </div>
		    <div class="item">
		      <img src="assets/img/fondo.jpg" alt="Bienvenido" class="img-carousel">
		      <div class="carousel-caption animated bounceIn">Bienvenido</div>
		    </div>
		  </div>
		  <!-- Controls -->
		  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="icon-caret-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
		    <span class="icon-caret-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
	</section>
	<!--- fIN CAROUSEL DE IMAGENES -->
	<!--- MODAL LOG IN -->
	<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
		<div class="modal-dialog login">
			<div class="container">
				<form class="form-login" id="formulario_login" action="" method="post" onclick="limpiar();">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="form-login-heading">Iniciar Sesi&oacute;n </h4>
					</div>
					<div class="login-wrap">
						<input name="user"  type="text" class="form-control" placeholder="User o Email"  autofocus required/>
						<br>
						<input name="pass" type="password" class="form-control" placeholder="Password" required/>
						<a id="change" data-toggle="modal" href="#" onclick="cerrar()"> Olvidaste tu contrase&ntilde;a?. </a>
						<br>
						<div style=" text-align:center; color:red;" id="respuesta1"></div>
						<br>
						<span onclick='enviar_form("login/validar.php","formulario_login",1);' class="btn btn-theme btn-block"><i class="icon-lock"></i> Iniciar Sesi&oacute;n</span>
						<hr>
						<div class="registration">
							A&uacute;n no te haz registrado, Crea tu cuenta Ahora!?<br/>
							<a id="signup" data-toggle="modal" href="#" onclick="cerrar()"> Crear Cuenta. </a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--- FIN MODAL LOG IN -->
	<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="changePass" class="modal fade">
		<div class="modal-dialog login">
			<div class="container">
				<form class="form-login" action="" method="post" id="formulario_recuperar" onclick="limpiar();">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="form-login-heading">Nueva Contrase&ntilde;a</h4>
					</div>
					<div class="login-wrap">
						<input name="mail"  type="email" class="form-control" placeholder="Email" required/>
						<div id="respuesta2"></div>
						<br>
						<span onclick='enviar_form("include/recuperar.php","formulario_recuperar",2);' class="btn btn-theme btn-block"><i class="icon-lock"></i> Recuperar</span>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--- MODAL SIGN UP -->
	<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="login-page" class="modal fade">
		<div class="modal-dialog register" style="margin-top:0px;">
			<div class="container">
				<?php if(!isset($status)): ?>
				<form class="form-login" action="" method="post" id="formulario_registrarse" onclick="limpiar();">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="form-login-heading">Registro de Usuarios </h4>
					</div>
					<div class="login-wrap">
						<label for="usuario" style="color: #8D8D8D; font-family:arial; font-weight: normal;">Usuario (<span id="req-usuario" class="requisites <?php echo $usuario ?>">Debe contener <b> s&oacute;lo </b> letras y n&uacute;meros, m&iacute;nimo 4 letras</span>):</label>
						<input tabindex="1" name="usuario" id="usuario" type="text" class="form-control" placeholder="luis01"value="<?php echo $usuarioValue ?>" />
						<br>
						<label for="email" style="color: #8D8D8D; font-family:arial; font-weight: normal;">E-mail (<span id="req-email" class="requisites <?php echo $email ?>">Un e-mail v&aacute;lido </span>):</label>
						<input tabindex="2" name="email" id="email" type="text" class="form-control"  value="<?php echo $emailValue ?>" />
						<br>
						<label for="password1" style="color: #8D8D8D; font-family:arial; font-weight: normal;">Contrase&ntilde;a (<span id="req-password1" class="requisites <?php echo $password1 ?>">M&iacute;nimo 5 caracteres, m&aacute;ximo 14</span>):</label>
						<input tabindex="3" name="password1" id="password1" type="password" class="form-control" class="text <?php echo $password1 ?>" value="" />
						<br>
						<label for="password2" style="color: #8D8D8D; font-family:arial; font-weight: normal;">Repetir Contrase&ntilde;a (<span id="req-password2" class="requisites <?php echo $password2 ?>">Debe ser igual a la anterior</span>):</label>
						<input tabindex="4" name="password2" id="password2" type="password" class="form-control" class="text <?php echo $password2 ?>" value="" />
						<br>
						<div id="captcha"></div>
						<br>
						<div style="text-align:center; color:red;" id="respuesta3"></div>
						<span onclick='enviar_form("include/insertar.php","formulario_registrarse",3);' class="btn btn-theme btn-block">Registrarse<span>
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
	<footer>
		<?php include("static/footer.php"); ?>
	</footer>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/gop.js"></script>
	<?php
	extract($_GET);
	switch($_GET['mensaje']) {
		case '1':
	echo "<script language='javascript'> document.getElementById('mensaje').innerHTML='Su Sesi&oacute;n ha expirado, por favor vuelva e entrar.';
	</script>";
	break;
	}
	?>
	<script>
	function enviar_form(pagina, form, num){
			var formData = new FormData($("form#"+form)[0]);
		$.ajax({
			url: pagina,
			type: 'POST',
			dataType: 'html',
			data:formData,
			cache: false,
	contentType: false,
	processData: false,
		})
		.done(function(data) {
			switch(num){
				case 1:
					$("#respuesta1").html(data);
				break;
				case 2:
					$("#respuesta2").html(data);
				break;
				case 3:
					$("#respuesta3").html(data);
				break;
			}
		})
	}
	function limpiar(){
		document.getElementById('respuesta1').innerHTML='';
		document.getElementById('respuesta2').innerHTML='';
		document.getElementById('respuesta3').innerHTML='';
		document.getElementById('mensaje').innerHTML='';
	}
	</script>
</body>
</html>
<script src='assets/js/css3-animate-it.js'></script>