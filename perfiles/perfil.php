<?php 
header('Content-Type: text/html; charset=ISO-8859-1');
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
session_start();
if (!$_SESSION){
  echo '<script>alert("Por favor debe iniciar sesión")</script>'; 
  header("Location: ../index.php?mn=1");
}else{
	$fechaGuardada = $_SESSION["ultimoAcceso"];
	$ahora = date("Y-n-j H:i:s");
	$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
	//comparamos el tiempo transcurrido
	if($tiempo_transcurrido >= 1500) {
		//si pasaron 10 minutos o más
		$miconexion->consulta("update miembros set estado=0 where email = '".$_SESSION['email']."'");  
		session_destroy(); // destruyo la sesión
		header("Location: ../index.php?mensaje=3"); //envío al usuario a la pag. de autenticación
		//sino, actualizo la fecha de la sesión
	}else {
		$_SESSION["ultimoAcceso"] = $ahora;
	}
}
extract($_GET);
if(@$op==''){$op="perfil";}
  global $lista;
  global $cont;
  global $persona;
  global $l;
  $miconexion->consulta("select * from miembros where email = '".$_SESSION['email']."' ");
  $cont = $miconexion->numcampos();
  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    $lista=$miconexion->consulta_lista();
  }
  if (@$act==1) {
 	 $miconexion->consulta("delete from grupos_miembros where id_grupo = '".$id."' ");
 	 $miconexion->consulta("delete from grupos where id_grupo = '".$id."' ");
  }elseif(@$act==2){
   $miconexion->consulta("update grupos_miembros set estado=1 where id_grupo = '".$id."' and email = '".$_SESSION['email']."'");    
  }elseif(@$act==3){
   $miconexion->consulta("delete from grupos_miembros where id_grupo = '".$id."'  and email = '".$_SESSION['email']."'");    
  }elseif(@$act==4){
   	$miconexion->consulta("update convocatoria set estado=1 where id_convocatoria = '".$id."' and email = '".$_SESSION['email']."'");  
  }elseif(@$act==5){
  	$miconexion->consulta("delete from convocatoria where id_convocatoria = '".$id."' and email = '".$_SESSION['email']."'");  
  }elseif(@$act==6){
   	$miconexion->consulta("update convocatoria set estado=1 where id_convocatoria = '".$idc."' and email = '".$_SESSION['email']."'");  
  }elseif(@$act==7){
  	$miconexion->consulta("delete from convocatoria where id_convocatoria = '".$idc."' and email = '".$_SESSION['email']."'");  
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>Gather, Organize and Play</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" type="image/ico" href="assets/img/ball.png">
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
<link href="../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="../assets/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="../assets/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="../assets/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="../assets/css/darkblue.css" rel="stylesheet" type="text/css"/>
<link type="text/css" rel="stylesheet" media="all" href="../assets/css/chat.css" />	
<!-- END THEME STYLES -->

</head>
<body class="page-header-fixed page-quick-sidebar-over-content page-container-bg-solid">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="index.html">
			<img src="../assets/img/logo.png" alt="logo" class="logo-default" style="width: 155px; margin-top: 0px;"/>
			</a>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="top-menu">
			<ul class="nav navbar-nav pull-right">
	        <!-- BEGIN NOTIFICATION DROPDOWN -->
	        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
	        <?php include('notificaciones.php'); ?>
	        <!-- END NOTIFICATION DROPDOWN -->
	        <!-- BEGIN USER LOGIN DROPDOWN -->
	        <li class="dropdown dropdown-user">
	          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
	          <?php 
	            if ($lista[7]==""){
	              echo '<img alt="Avatar" class="img-circle" src="../assets/img/user.png"/>';
	            }else{
	              echo "<img alt='Avatar' class='img-circle' src='images/esquezada1@utpl.edu.ec/".$lista[7]."'>";
	            }
	          echo '<span class="username username-hide-on-mobile">'.$lista[2].'</span>'; ?>
	          <i class="fa fa-angle-down"></i>
	          </a>
	          <ul class="dropdown-menu dropdown-menu-default">
	            <li>
	              <a href="extra_profile.html">
	              <i class="icon-user"></i> My Profile </a>
	            </li>
	            <li>
	              <a href="page_calendar.html">
	              <i class="icon-calendar"></i> My Calendar </a>
	            </li>
	            <li class="divider">
	            </li>
	            <li>
	              <a href="../login/salir.php">
	              <i class="icon-key"></i> Log Out </a>
	            </li>
	          </ul>
	        </li>
	        <!-- END USER LOGIN DROPDOWN -->
	        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
	        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
	        <li class="dropdown dropdown-quick-sidebar-toggler">
	          <a href="../login/salir.php" class="dropdown-toggle">
	          <i class="icon-signout"></i>
	          </a>
	        </li>
	        <!-- END QUICK SIDEBAR TOGGLER -->
	      </ul>
		</div>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- END SIDEBAR TOGGLER BUTTON -->
				</li>
				<li class="start active open">
					<a href="javascript:;">
					<i class="icon-home"></i>
					<span class="title">Home</span>
					<span class="selected"></span>
					<span class="open"></span>
					</a>
				</li>
				<li>
					<a href="javascript:;">
					<i class="icon-group"></i>
					<span class="title">My Groups</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<?php
			            	$miconexion->consulta("select g.nombre_grupo, g.id_grupo, g.owner, gm.email from grupos g, grupos_miembros gm where g.id_grupo=gm.id_grupo and gm.email='".$_SESSION['email']."'");
			            	$cont = $miconexion->numcampos();
			            	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
				                $lista2=$miconexion->consulta_lista();
				                echo "<li>";
				                if ($lista2[2]==$lista2[3]) {
				                	echo 	"<a style='font-size:15px; display: inline-block; padding-right:5px;' href='perfil.php?act=1&id=".$lista2[1]."' onclick='return confirmar()'>
				                	<i title='Eliminar Grupo' class='icon-remove'></i></a>";
				                	echo 	"<a style='display: inline-block; padding-left:0;' href='perfil.php?op=grupos&id=".$lista2[1]."'>";
				                	echo 	"<i class='icon-group'></i>".$lista2[0]."</a>";
				                }else{
				                	echo 	"<a style='display: inline-block; padding-left:66px;' href='perfil.php?op=grupos&id=".$lista2[1]."'>";
				                	echo 	"<i class='icon-group'></i>".$lista2[0]."</a>";
				            	}				                
				                echo "</li>"; 
			            	}
			            ?> 
					</ul>
				</li>
				<li>
					<a href="javascript:;">
					<i class="icon-gamepad"></i>
					<span class="title">My Games</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<?php
			            	$miconexion->consulta("select p.id_grupo, p.id_partido, p.fecha, p.estado 
			            		FROM partidos p, convocatoria c
			            		WHERE p.id_partido = c.id_partido and c.email ='".$_SESSION['email']."' and c.estado != 2");		            	
			            	$cont = $miconexion->numcampos();
			            	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
				                $partidos=$miconexion->consulta_lista();
				                if ($partidos[3]=='1') {
				                	echo "<li>";
					                $time=strtotime($partidos[2]);
					                $fecha = date("d M Y H:i",$time);
					                echo 	"<a href='perfil.php?op=alineacion&id=".$partidos[1]."'>
					                			<i class='icon-gamepad'></i>
					                			".$fecha."
					                		</a>";				                
					                echo "</li>"; 
				                }
			            	}
			               ?>   
					</ul>
				</li>
				<li>
					<a href="#canchas">
					<i class="icon-map-marker"></i>
					<span class="title">Canchas</span>
					</a>
				</li>
				<li class="heading">
					<h3 class="uppercase">Suggestions</h3>
				</li>
				<li>
					<a href="javascript:;">
						<i class="icon-calendar"></i>
						<span class="title">Mañana juegan en la pampita a las 10 am, quieres ir?</span>
					</a>
				</li>
				<li>
					<a href="javascript:;">
						<i class="icon-calendar"></i>
						<span class="title">Mañana juegan en la pampita a las 10 am, quieres ir?</span>
					</a>
				</li>
				<li>
					<a href="javascript:;">
						<i class="icon-calendar"></i>
						<span class="title">Mañana juegan en la pampita a las 10 am, quieres ir?</span>
					</a>
				</li>
				<li>
					<a href="javascript:;">
						<i class="icon-calendar"></i>
						<span class="title">Mañana juegan en la pampita a las 10 am, quieres ir?</span>
					</a>
				</li>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content" style="background-color: #F1F8E9;">
			<!-- BEGIN PAGE HEADER-->
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="index.html">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Canchas</a>
					</li>
				</ul>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN DASHBOARD STATS -->
			<div class="row">
				<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
					<h3 class="page-title">
						Canchas <small>Localizaci&oacute;n</small>
					</h3>
					<div class="clearfix">
					</div>
					<div class="row">
						<div class="col-md-3 col-sm-3">
							<!-- BEGIN PORTLET-->
							<div class="portlet light ">
								<div class="portlet-title">
									<div class="caption">
										<i class="icon-bubble font-red-sunglo"></i>
										<span class="caption-subject bold uppercase" style="font-size:12px; color:#4CAF50;">Canchas Disponibles</span>
									</div>
								</div>
								<div class="portlet-body" id="chats">
									<div class="scroller" style="height: 341px;" data-always-visible="1" data-rail-visible1="1">
										<ul>
											<li>
												<a href="#">Cancha 1</a>
											</li>
											<li>
												<a href="#">Cancha 1</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<!-- END PORTLET-->
						</div>
						<div class="col-md-9 col-sm-9">
							<div class="portlet light ">
								<div class="portlet-title">
									<div class="caption">
										<i class="icon-bubble font-red-sunglo"></i>
										<span class="caption-subject bold uppercase" style="color: #006064;">TODAS LAS CANCHAS</span>
									</div>
								</div>
								<div class="portlet-body" id="chats">
									<div class="scroller" style="height: 341px;" data-always-visible="1" data-rail-visible1="1">
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="chat page-sidebar-menu col-lg-2 col-md-2" style="border-left: 1px solid #EEEEEE;">
					<h4>USUARIOS CONECTADOS</h4>
					<ul style="color:#ffff; list-style: none; padding:0px;">
						<?php include("col_chat.php"); ?>
					</ul>
				</div>
			</div>
			<!-- END DASHBOARD STATS -->
			
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		 2015 &copy; by jncorrea, esquezada and migranda.
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<script src="../assets/plugins/jquery.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="../assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="../assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="../assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../assets/js/metronic.js" type="text/javascript"></script>
<script src="../assets/js/layout.js" type="text/javascript"></script>
<script src="../assets/js/quick-sidebar.js" type="text/javascript"></script>
<script src="../assets/js/demo.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="../assets/js/chat.js"></script>
<script>
jQuery(document).ready(function() {
	Metronic.init();
   Layout.init(); // init layout
   QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   Index.init();
   Index.initChat()
	 	///////////////////////CHAT////////////////
	 	 $("#col_chat").load("col_chat.php");
	   var refreshId = setInterval(function() {
	      $("#col_chat").load('col_chat.php?randval='+ Math.random());
	   }, 9000);
	   $.ajaxSetup({ cache: false });
	});
	////////////////////////////////////////////////////////
});
</script>
<!-- END JAVASCRIPTS -->
</body>

<!-- END BODY -->
</html>