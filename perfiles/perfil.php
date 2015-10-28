<?php 
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
date_default_timezone_set('America/Guayaquil');
session_start();
if (!$_SESSION){
  echo '<script>alert("Por favor debe iniciar sesión")</script>'; 
  header("Location: ../index.php?mn=1");
}else{
	$fechaGuardada = $_SESSION["ultimoAcceso"];	
	global $ahora;
	$ahora = date("Y-m-d H:i:s", time());
	$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
	//comparamos el tiempo transcurrido
	if($tiempo_transcurrido >= 1500) {
		//si pasaron 10 minutos o másf
		$session_id = $_SESSION['id'];
		$miconexion->consulta("update usuarios set estado='0' where id_user = '".$session_id."'");
		session_unset();  
		session_destroy(); // destruyo la sesión
		header("Location: ../index.php?mensaje=1"); //envío al usuario a la pag. de autenticación
		//sino, actualizo la fecha de la sesión
	}else {
		$_SESSION["ultimoAcceso"] = $ahora;
	}
}	
extract($_GET);
$bandera = 0;
$miconexion->consulta("Select id_grupo, id_user from grupos");
for ($j=0; $j < @$miconexion->numregistros(); $j++) { 
	@$grupo = $miconexion->consulta_lista();
	@$grupo_e = md5($grupo[0]);
	if (@$_SESSION['grupo']==@$grupo_e) {
		$miconexion->consulta('select * from user_grupo where id_user = "'.$_SESSION['id'].'" and id_grupo = "'.$grupo[0].'"');
		if ($miconexion->numregistros() == 0) {
			$miconexion->consulta("insert into notificaciones (id_user, id_grupo, fecha_not, visto, responsable, tipo, mensaje) values('".$_SESSION['id']."','".$grupo[0]."','".date("Y-m-d H:i:s", time())."','0','".$grupo[1]."','solicitud',' te ha invitado a formar parte del grupo')");
			$_SESSION['grupo']='';
		}
	}
}
if(@$op==''){$op="perfil";}
if(@$id==''){$id=0;}
  global $lista;
  global $cont;
  global $persona;
  global $l;
  
  $miconexion->consulta("select id_user from usuarios where user = '".$_SESSION['user']."' ");
	$usuarios=$miconexion->consulta_lista();

  $miconexion->consulta("select * from usuarios where user = '".$_SESSION['user']."' ");
  $cont = $miconexion->numcampos();
  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    $lista=$miconexion->consulta_lista();
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Gather, Organize and Play</title>

<!-- nuevos estilos -->
<link href="../assets/css/bootstrap.css" rel="stylesheet">
<link href="../assets/css/style_inicio.css" rel="stylesheet">

<meta name="theme-color" content="#2b3643">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/ico" href="../assets/img/ball.png">
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
<link href="../assets/css/style-gop.css" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="../assets/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="../assets/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="../assets/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="../assets/css/darkblue.css" rel="stylesheet" type="text/css"/>
<link type="text/css" rel="stylesheet" media="all" href="../assets/css/chat.css" />	
<link href="../assets/css/ui.notify.css" type="text/css" rel="stylesheet" />

<!-- END THEME STYLES -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>	
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.2/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="../assets/js/html2canvas.js"></script>
<script type="text/javascript" src="../assets/js/jquery.plugin.html2canvas.js"></script>
<script type="text/javascript" src="../assets/js/chat.js"></script>
<script type="text/javascript" src="../assets/js/jquery.notify.min.js"></script>
<script type="text/javascript" src="../assets/js/alert-dialog.js"></script>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript" src="../assets/js/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/css/jquery.timepicker.css" />
<link href='../assets/css/fullcalendar.css' rel='stylesheet' />
<link href='../assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='../assets/js/moment.min.js'></script>
<script src='../assets/js/fullcalendar.min.js'></script>
<script src='../assets/js/es.js'></script>
<script src="../assets/js/select2.min.js"></script>
<link rel="stylesheet" href="../assets/css/select2.css">
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1120289791332697',
      xfbml      : true,
      version    : 'v2.4'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

  function FacebookInviteFriends(a)
	{
		var device = navigator.userAgent

if (device.match(/Iphone/i)|| device.match(/Ipod/i)|| 
	device.match(/Android/i)|| device.match(/J2ME/i)|| 
	device.match(/BlackBerry/i)|| device.match(/iPhone|iPad|iPod/i)|| 
	device.match(/Opera Mini/i)|| device.match(/IEMobile/i)|| 
	device.match(/Mobile/i)|| device.match(/Windows Phone/i)|| 
	device.match(/windows mobile/i)|| device.match(/windows ce/i)|| 
	device.match(/webOS/i)|| device.match(/palm/i)|| 
	device.match(/bada/i)|| device.match(/series60/i)|| 
	device.match(/nokia/i)|| device.match(/symbian/i)|| 
	device.match(/HTC/i)){ 
	window.location = "http://m.facebook.com/dialog/send?app_id=1120289791332697&link=http://loxatec.com/gop/index.php?i="+a+"&display=touch";
} else{
	FB.ui({ method: 'send', 
			link: 'http://loxatec.com/gop/index.php?i='+a,
			picture: 'picture',
			description: 'description'});
	}
}
</script>

<style>
   .upload_wrapper {
  position: relative;
  overflow: hidden;
  cursor: pointer;
  //margin: 10px;
}
.upload_wrapper input.upload {
  position: absolute;
  top: 0;
  right: 0;
  margin-top: -20px;
  padding: 0;
  font-size: 20px;
  cursor: pointer;
  opacity: 0;
  filter: alpha(opacity=0);
}


    .column {
	    width: 80px;
	    height: 65px;
	    float: left;
	    padding-bottom: 10px;

	}
	.jugadores{
	  width: 10.9%;
	  height: 60px;
	  float: left;
	  background-image: url("../assets/img/jugador.png")!important;
	  background-repeat: no-repeat;
	  background-position: center center;
	  background-size: 100% 100%;
	  margin-left: 1.5%;
	  margin-top: 2%;
	}
    .portlet { margin: 0 1em 1em 0; }
    .portlet-header { margin: 0.3em; padding-bottom: 4px; padding-left: 0.2em; }
    .portlet-header .ui-icon { float: right; }
    .portlet-content { padding: 0.4em; }
    .ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
    .ui-sortable-placeholder * { visibility: hidden; }
 
</style>
<script>
function create( template, vars, opts ){
	return $container.notify("create", template, vars, opts);
}
///////////////////////////////////////////////////////////////////////
function mostrar(id) {
    obj = document.getElementById(id);
    obj.style.display = (obj.style.display == 'none') ? '' : 'none';    
}
/*if (screen.width<=990) {
	$('.page-sidebar-closed').remove();
	//$('body').removeClass("page-sidebar-closed");
	//document.getElementById("body").className = "";
	//document.getElementById("body").className = "page-header-fixed page-header-fixed-mobile page-quick-sidebar-over-content page-container-bg-solid";
}*/
$(document).ready(function() {
	if ($(window).width() < 991) {
	    $('#body').removeClass("page-sidebar-closed");
	}else{
		$('#body').addClass("page-sidebar-closed");
	}
	$('select').select2();
	////////cargar divs//////////////
	$("#menu_izquierdo").load("menu.php");
	$("#col_perfil").load("configurar.php");
	$("#col_inicio").load("pagina_inicio.php");
	$("#col_tabla_horario").load("tabla_horario.php?id=<?php echo $id; ?>");
	$("#col_listar_grupos").load("listar_grupos.php");
	$("#col_miembros").load("miembros.php?id=<?php echo $id; ?>");
	$("#col_listar_campeonatos").load("listar_campeonatos.php");

	////////recargar divs/////////////
   $("#col_chat").load("col_chat.php");
   var refreshId = setInterval(function() {
      $("#col_chat").load('col_chat.php?randval='+ Math.random());
   }, 3000);
   $.ajaxSetup({ cache: false });

    $( "#persona" ).autocomplete({
    minLength: 0,
    source: '../include/buscarPersona.php',
    focus: function( event, ui ) {
      $( "#persona" ).val( ui.item.label );
      return false;
    },
    select: function( event, ui ) {
      $( "#persona" ).val( ui.item.label );
      $( "#id_persona" ).val( ui.item.value );

      return false;
    }
  })
  .autocomplete( "instance" )._renderItem = function( ul, item ) {
    return $( "<li>" )
      .append( "<a>" +"<img padding: 0px; style='width:35px; height:35px; display:inline-block;' src='"+item.avatar+"'></img>"+
        "<div style='line-height: 12px; display:inline-block; font-size: 80%; padding-left:5px;'><strong>"+
        item.descripcion + "</strong><p style='font-size: 90%;'>" + item.label + "</p></div></a>" )
      .appendTo( ul );
  };
});
///////////////////////////////////////
$('#widget').draggable();
        $(function() {
          $( ".column" ).sortable({
            connectWith: ".column"
          });

          $( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
            .find( ".portlet-header" )
              .addClass( "ui-widget-header ui-corner-all" )
              .prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
              .end()
            .find( ".portlet-content" );            
          	
          $( ".portlet-header .ui-icon" ).click(function() {
            $( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
            $( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle();            
          });

          $( ".column" ).disableSelection();

          
        });
		////////////////BUSCAR MIEMBROS/////////////
/////////////////////RECARGAR DIVS////////////////////////////////////

	//////////////////////////////////////////////
	</script>

</head>
<body id='body' class="page-header-fixed page-header-fixed-mobile page-quick-sidebar-over-content page-container-bg-solid page-sidebar-closed">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="perfil.php">
			<img src="../assets/img/logo.png" alt="logo" class="logo-default" style="width: 155px; margin-top: 0px;"/>
			</a>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="top-menu" style="padding-right: 2em;">
			<ul class="nav navbar-nav pull-right">
				<!-- NOTIFICACIONES -->
				<li class="dropdown dropdown-extended dropdown-notification">
					<?php include("solicitudes.php");  ?>
				</li>
				<li class="dropdown dropdown-extended dropdown-notification">
					<?php include("notificaciones.php");  ?>					
				</li>
		        <!-- END NOTIFICATION DROPDOWN -->
		        <!-- BEGIN USER LOGIN DROPDOWN -->
		        <li class="dropdown dropdown-user">
		          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
		          <?php 
		            if ($lista[11]==""){
		            	if ($lista[7]=="Femenino") {
							echo '<img alt="Avatar" class="img-responsive img-circle" src="../assets/img/user_femenino.png"/>';
						}else{
							echo '<img alt="Avatar" class="img-responsive img-circle" src="../assets/img/user_masculino.png"/>';
						}
		            }else{
		              echo "<img alt='Avatar' class='img-circle' src='images/".$_SESSION['user']."/".$lista[11]."'>";
		            }
		          echo '<span class="username username-hide-on-mobile">'.$_SESSION['user'].'</span>'; ?>
		          <i class="icon-angle-down"></i>
		          </a>
		          <ul class="dropdown-menu dropdown-menu-default">		            
		            <li>
		              <a href="perfil.php?op=configurar">
		              <i class="icon-user"></i> Mi Perfil </a>
		            </li>
		            <li class="divider">
		            </li>
		            <li>
		              <a href="../login/salir.php">
		              <i class="icon-key"></i> Cerrar Sesi&oacute;n </a>
		            </li>
		          </ul>
		        </li>
		        <!-- END USER LOGIN DROPDOWN -->
		        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
		        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
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
<div class="page-container" >
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<div style="position: fixed; z-index: 5;" class="page-sidebar navbar-collapse collapse closed">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu page-sidebar-menu-closed" id="menu_izquierdo" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content" style="background-color: #F1F8E9; z-index: 100000 !important; position: absolute;">
			<div id="container_notify" style="display:none; z-index: 100000 !important;  top: 50px; ">		
				<div id="default" style="#{color}">
					<a class="ui-notify-close ui-notify-cross" href="#">x</a>
					<a href="#{enlace}" style='text-decoration:none;' onclick="#{accion}">						
						<div style="float:left;margin:0 10px 0 0"><img style="width:40px; heigth:40px;" src="#{imagen}" alt="notificacion" /></div>
						<h1>#{title}</h1>
						<p>#{text}</p>
					</a>
				</div>  
			</div>
			<?php 

		        switch ($op) {
		          case 'configurar':?>
					<div class="page-bar">
						<ul class="page-breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="perfil.php">Home</a>
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a href="#">Mi Perfil</a>
							</li>
						</ul>	
					</div>
					<div class="row">	
						<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" id="col_perfil"></div>
						<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
							<h4>USUARIOS CONECTADOS</h4>
							<ul style="color:#ffff; list-style: none; padding:0px;">
								<div id = "col_chat"></div>
							</ul>
						</div>
					</div>
		        <?php 
		            break;
		          
		          case 'configurar_pass':
		          	$matriz_completa ="";

		          	extract($_GET);

					$miarray = @$_GET['a'];
					$array_para_recibir_via_url = stripslashes($miarray);
					$array_para_recibir_via_url = urldecode($array_para_recibir_via_url );
					$matriz_completa = unserialize($array_para_recibir_via_url);         
					 
				
					include("configurar_pass.php");

		            break;
		          case 'grupos':

		          	$miconexion->consulta("select count(*) from user_grupo 
					  where id_grupo='".$id."' and id_user = '".$_SESSION['id']."'");
					  @$access = $miconexion->consulta_lista();
		          	if (@$access[0]==0) {
		          	?> 
						<div class="page-bar">
							<ul class="page-breadcrumb">
								<li>
									<i class="icon-home"></i>
									<a href="perfil.php">Home</a>
									<i class="icon-angle-right"></i>
								</li>
								<li>
									<a href="perfil.php?op=listar_grupos">Mis Grupos</a>
								</li>
							</ul>	
						</div>
						<div class="row">	
							<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
								<h3 class="page-title">
							      Ninguna informaci&oacute;n disponible 
							    </h3>					
							</div>
							<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
								<h4>USUARIOS CONECTADOS</h4>
								<ul style="color:#ffff; list-style: none; padding:0px;">
									<div id = "col_chat"></div>
								</ul>
							</div>
						</div>
		          	<?php
		          	}else{
						$miconexion->consulta("select * from grupos g
						  where g.id_grupo='".$id."'");
						  $nom=$miconexion->consulta_lista();
			           ?>
					<div class="page-bar">
						<ul class="page-breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="perfil.php">Home</a>
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a href="perfil.php?op=listar_grupos">Mis Grupos</a>
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a href=<?php echo "'perfil.php?op=grupos&id=".$id."'"; ?> > <?php echo $nom[2]; ?></a>
							</li>
						</ul>	
					</div>
					<div class="row">	
						<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
							<?php include("grupos.php"); ?>							
						</div>
						<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
							<h4>USUARIOS CONECTADOS</h4>
							<ul style="color:#ffff; list-style: none; padding:0px;">
								<div id = "col_chat"></div>
							</ul>
						</div>
					</div>
<!-- END PAGE HEADER-->
		        <?php		          		
		          	} 
		            break;
		          case 'alineacion':

		          	$miconexion->consulta("select count(*) from alineacion 
					  where id_partido='".$id."' and id_user = '".$_SESSION['id']."'");
					  @$access = $miconexion->consulta_lista();
		          	if (@$access[0]==0) {
		          	?> 
						<div class="page-bar">
							<ul class="page-breadcrumb">
								<li>
									<i class="icon-home"></i>
									<a href="perfil.php">Home</a>
									<i class="icon-angle-right"></i>
								</li>
								<li>
									<a href="perfil.php?op=listar_partidos">Mis Partidos</a>		
								</li>
							</ul>	
						</div>
						<div class="row">	
							<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
								<h3 class="page-title">
							      Ninguna informaci&oacute;n disponible 
							    </h3>					
							</div>
							<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
								<h4>USUARIOS CONECTADOS</h4>
								<ul style="color:#ffff; list-style: none; padding:0px;">
									<div id = "col_chat"></div>
								</ul>
							</div>
						</div>
		          	<?php
		          	}else{
			            include("alineacion.php");
			        }
			            break;

		           case 'crear_evento':
		        		$miconexion->consulta("select * from centros_deportivos");  
						for ($i=0; $i < $miconexion->numregistros(); $i++) { 
							$lista_canchas=$miconexion->consulta_lista();
						}
						include("crear_evento.php");
		            break;

	              case 'canchas':
	              if ($id==0) {
	              	include('canchas.php');
	              }else{
	              	$miconexion->consulta("select count(*) from centros_deportivos 
					  where id_centro='".$id."'");
					  @$access = $miconexion->consulta_lista();
		          	if (@$access[0]==0) {
		          	?> 
						<div class="page-bar">
							<ul class="page-breadcrumb">
								<li>
									<i class="icon-home"></i>
									<a href="perfil.php">Home</a>
								</li>
							</ul>	
						</div>
						<div class="row">	
							<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
								<h3 class="page-title">
									<?php if ($id==""){ ?>
							      		Ninguna informaci&oacute;n disponible 										
									<?php }else{
			            				include('canchas.php');
									}?>
							    </h3>					
							</div>
							<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
								<h4>USUARIOS CONECTADOS</h4>
								<ul style="color:#ffff; list-style: none; padding:0px;">
									<div id = "col_chat"></div>
								</ul>
							</div>
						</div>
		          	<?php
		          	}else{
			            include('canchas.php');
			        }
			    	}
	              break;
		          case 'editar_evento':
		          $miconexion->consulta("select count(*) from partidos 
					  where id_partido='".$id."' and id_user = '".$_SESSION['id']."'");
					  @$access = $miconexion->consulta_lista();
		          	if (@$access[0]==0) {
		          	?> 
						<div class="page-bar">
							<ul class="page-breadcrumb">
								<li>
									<i class="icon-home"></i>
									<a href="perfil.php">Home</a>
									<i class="icon-angle-right"></i>
								</li>
								<li>
									<a href="#">Editar Partido</a>		
								</li>
							</ul>	
						</div>
						<div class="row">	
							<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
								<h3 class="page-title">
							      Ninguna informaci&oacute;n disponible 
							    </h3>					
							</div>
							<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
								<h4>USUARIOS CONECTADOS</h4>
								<ul style="color:#ffff; list-style: none; padding:0px;">
									<div id = "col_chat"></div>
								</ul>
							</div>
						</div>
		          	<?php
		          	}else{
		          ?>
		          	<div class="page-bar">
					  <ul class="page-breadcrumb">
					    <li>
					      <i class="icon-home"></i>
					      <a href="perfil.php">Home</a>
					      <i class="icon-angle-right"></i>
					    </li>
					    <li>
					      <a href="#">Editar Partido</a>
					    </li>
					  </ul>
					</div>
					<div class="row">
						<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12"> <?php include("editar_evento.php"); ?></div>
						<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
							<h4>USUARIOS CONECTADOS</h4>
							<ul style="color:#ffff; list-style: none; padding:0px;">
								<div id = "col_chat"></div>
							</ul>
						</div>
					</div>
					<?php
					} 
		            break;
		            	
		            case 'editar_cancha':
		            	$miconexion->consulta("select count(*) from centros_deportivos 
					  where id_centro='".$id."' and id_user = '".$_SESSION['id']."'");
					  @$access = $miconexion->consulta_lista();
		          	if (@$access[0]==0) {
		          	?> 
						<div class="page-bar">
							<ul class="page-breadcrumb">
								<li>
									<i class="icon-home"></i>
									<a href="perfil.php">Home</a>
									<i class="icon-angle-right"></i>
								</li>
								<li>
									<a href="#">Editar Centro Deportivo</a>		
								</li>
							</ul>	
						</div>
						<div class="row">	
							<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
								<h3 class="page-title">
							      Ninguna informaci&oacute;n disponible 
							    </h3>					
							</div>
							<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
								<h4>USUARIOS CONECTADOS</h4>
								<ul style="color:#ffff; list-style: none; padding:0px;">
									<div id = "col_chat"></div>
								</ul>
							</div>
						</div>
		          	<?php
		          	}else{
		            ?>
		          	<div class="page-bar">
					  <ul class="page-breadcrumb">
					    <li>
					      <i class="icon-home"></i>
					      <a href="perfil.php">Home</a>
					      <i class="icon-angle-right"></i>
					    </li>
					    <li>
					      <a href="#">Editar Centro Deportivo</a>
					    </li>
					  </ul>
					</div>
					<div class="row">
						<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
							<?php include("editar_cancha.php"); ?>							
						</div>
						<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
							<h4>USUARIOS CONECTADOS</h4>
							<ul style="color:#ffff; list-style: none; padding:0px;">
								<div id = "col_chat"></div>
							</ul>
						</div>
					</div>
					<?php 
					}
		            break;
		            case 'listar_grupos':?>
		          	<div class="page-bar">
					  <ul class="page-breadcrumb">
					    <li>
					      <i class="icon-home"></i>
					      <a href="perfil.php">Home</a>
					      <i class="icon-angle-right"></i>
					    </li>
					    <li>
					      <a href="#">Mis Grupos</a>
					    </li>
					  </ul>
					</div>
					<div class="row">
						<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" id="col_listar_grupos"></div>
						<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
							<h4>USUARIOS CONECTADOS</h4>
							<ul style="color:#ffff; list-style: none; padding:0px;">
								<div id = "col_chat"></div>
							</ul>
						</div>
					</div>					
					<?php 
		            break;
		            case 'listar_partidos':?>
		          	<div class="page-bar">
					  <ul class="page-breadcrumb">
					    <li>
					      <i class="icon-home"></i>
					      <a href="perfil.php">Home</a>
					      <i class="icon-angle-right"></i>
					    </li>
					    <li>
					      <a href="#">Mis Partidos</a>
					    </li>
					  </ul>
					</div>
					<div class="row">
						<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12"><?php include("listar_partidos.php"); ?></div>
						<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
							<h4>USUARIOS CONECTADOS</h4>
							<ul style="color:#ffff; list-style: none; padding:0px;">
								<div id = "col_chat"></div>
							</ul>
						</div>
					</div>
					<?php 
		            break;
		            case 'campeonato':

		          	$miconexion->consulta("select count(*) from campeonatos 
					  where id_campeonato='".$id."' and id_user = '".$_SESSION['id']."'");
					  @$access = $miconexion->consulta_lista();
		          	if (@$access[0]==0) {
		          	?> 
						<div class="page-bar">
							<ul class="page-breadcrumb">
								<li>
									<i class="icon-home"></i>
									<a href="perfil.php">Home</a>
									<i class="icon-angle-right"></i>
								</li>
								<li>
									<a href="perfil.php?op=listar_partidos">Mis Partidos</a>		
								</li>
							</ul>	
						</div>
						<div class="row">	
							<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
								<h3 class="page-title">
							      Ninguna informaci&oacute;n disponible 
							    </h3>					
							</div>
							<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
								<h4>USUARIOS CONECTADOS</h4>
								<ul style="color:#ffff; list-style: none; padding:0px;">
									<div id = "col_chat"></div>
								</ul>
							</div>
						</div>
		          	<?php
		          	}else{
			            include("campeonato.php");
			        }
			            break;
		          default:?>
		          	<div class="page-bar">
						<ul class="page-breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="perfil.php">Home</a>
							</li>
						</ul>	
					</div>
					<div class="row">	
						<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12"><?php include("pagina_inicio.php"); ?></div>
						<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
							<h4>USUARIOS CONECTADOS</h4>
							<ul style="color:#ffff; list-style: none; padding:0px;">
								<div id = "col_chat"></div>
							</ul>
						</div>
					</div>
					<?php 
		            break;
		            case 'listar_campeonatos':?>
		          	<div class="page-bar">
					  <ul class="page-breadcrumb">
					    <li>
					      <i class="icon-home"></i>
					      <a href="perfil.php">Home</a>
					      <i class="icon-angle-right"></i>
					    </li>
					    <li>
					      <a href="#">Mis Campeonatos</a>
					    </li>
					  </ul>
					</div>
					<div class="row">
						<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" id="col_listar_campeonatos"></div>
						<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
							<h4>USUARIOS CONECTADOS</h4>
							<ul style="color:#ffff; list-style: none; padding:0px;">
								<div id = "col_chat"></div>
							</ul>
						</div>
					</div>					
					<?php 
		            break;
		        }
		        ?>			
		</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		<?php include("../static/footer.php") ?>
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>

<div class="modal fade" id="crear_partido" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
     <h4 class="modal-title">Crear Partido</h4>
    </div>
    <div class="modal-body">
      <?php include("crear_evento.php"); ?>
    </div>
    <div class="modal-footer">
    	<button type="button" class="btn default" data-dismiss="modal" id="cerrar_crearPartido">Cerrar</button>
    	<button type="button" class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/insertar_evento.php","form_crear_evento");'>Crear Partido</button>
    </div>
   </div>
   <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- MODAL PARA CREAR campeonato CON INCLUDE del archivo crearcampeonato.php-->
<div class="modal fade" id="crear_campeonato" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
     <h4 class="modal-title">Crear Campeonato</h4>
    </div>
    <div class="modal-body">
      <?php include("crear_campeonato.php"); ?>
    </div>
    <div class="modal-footer">
    	<button type="button" class="btn default" data-dismiss="modal" id="cerrar_crearCampeonato">Cerrar</button>
    	<button type="button" class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/insertar_campeonato.php","form_crear_campeonato");'>Crear Campeonato</button>
    </div>
   </div>
   <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="crear_grupo" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
     <h4 class="modal-title">Crear Grupo</h4>
    </div>
    <div class="modal-body">
	    <form method="post" action=""class="form-horizontal" id="form_grupo" style="display:inline-block; width:65%;">
	      <div class="form-horizontal" style="display:inline-block; padding-left:10px; width:100%;">
	          <input type="hidden" class="form-control" id="bd" name="bd" value="grupos">
	          <?php 
	            echo '<input type="hidden" class="form-control" id="owner" name="owner" value="'.$_SESSION["id"].'">'; 
	           ?>
	          <input style="width:100%; display:inline-block;" type="text" class="form-control" id="grupo" name="grupo" placeholder="Grupo..">
            	<div id="resultado"></div>
	      </div>
	    </form>
    </div>
    <div class="modal-footer">
    	<button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
    	<button type="button" class="btn green-haze" style="background:#4CAF50;" id="btn_crear_grupo" onclick='enviar_form("../include/insertarGrupo.php","form_grupo");'>Crear Grupo</button>
    </div>
   </div>
   <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div> 

<div class="modal fade" id="bad_grupo" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Eliminar Grupo</h4>
			</div>
			<div class="modal-body">
				Est&aacute; seguro de eliminar este grupo?
				<br>
				<p style="font-size:90%;">
					Se eliminaran todos los datos asociados con este grupo, como amigos y partidos.
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" id="cerrar_bad_grupo" class="btn default" data-dismiss="modal">Cerrar</button>
				<a data-toggle="modal" class="btn green-haze" style="background:#C42E35;" onclick="actualizar_notificacion(1, grupo_del);">Eliminar</a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="bad_campeonato" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Eliminar Campeonato</h4>
			</div>
			<div class="modal-body">
				Est&aacute; seguro de eliminar este campeonato?
				<br>
				<p style="font-size:90%;">
					Se eliminaran todos los datos asociados con este campeonato, como etapas y sus partidos.
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" id="cerrar_bad_campeonato" class="btn default" data-dismiss="modal">Cerrar</button>
				<a data-toggle="modal" class="btn green-haze" style="background:#C42E35;" onclick="actualizar_notificacion(38, campeonato_del);">Eliminar</a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<input type="hidden" id="getCiudad">
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&callback=get_loc"></script>
<!-- BEGIN CORE PLUGINS -->


<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="../assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="../assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../assets/js/metronic.js" type="text/javascript"></script>
<script src="../assets/js/layout.js" type="text/javascript"></script>
<script src="../assets/js/quick-sidebar.js" type="text/javascript"></script>
<script src="../assets/js/demo.js" type="text/javascript"></script>
  <script type="text/javascript" src="../assets/js/fancywebsocket.js"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {
	Metronic.init();
   Layout.init(); // init layout
	////////////////////////////////////////////////////////
   QuickSidebar.init(); // init quick sidebar
	Demo.init(); // init demo features
	Index.init();
   Index.initChat(); 
});
function myposition(position){
	var mylat = position.coords.latitude;
	var mylon = position.coords.longitude;
	document.getElementById("latitud").value = mylat;
	document.getElementById("longitud").value = mylon;
}
function get_pos() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(myposition);
	}else{
		alert('Este navegador es algo antiguo, actualiza para usar el API de localización');                  
	}
}
var map;
var directionsDisplay = null;
var directionsService = null;
function get_loc() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(coordenadas, geoNO );
	}else{
		alert('Este navegador es algo antiguo, actualiza para usar el API de localización');                  
	}
}
function coordenadas(position) {
	var mylat = position.coords.latitude;
	var mylon = position.coords.longitude;
	$.ajax({
      dataType: "json",
      url: "http://nominatim.openstreetmap.org/reverse",
      type: "get",
      data: {format: "json", lat:mylat, lon:mylon},
      success: function(data){
        document.getElementById("getCiudad").value = data.address.state;
        cargar_mapas(position);
    	}
    });
}

function cargar_mapas(position){
	<?php if (@$id!=0) {
		$miconexion->consulta("select * from centros_deportivos where id_centro = '".$id."'");
		if ($lista[6]!="" and $lista[7]!="") {
			$lista=$miconexion->consulta_lista();
			?>
			var lat = "<?php echo $lista[6] ?>";
			var lng = "<?php echo $lista[7] ?>";
			var name = "<?php echo ucwords($lista[2]) ?>";
			var add = "<?php echo $lista[5] ?>";
			var img = "<?php 
			if ($lista[4]=="") {
				echo '../assets/img/soccer3.png';
			}else{
				echo 'images/centros/'.$lista[0].$lista[4];
			}
			?>";
			var myLatlng = new google.maps.LatLng(lat,lng);
			var mapOptions = {
				zoom: 14,
				center: myLatlng,
				styles: [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]}]
			}
			map = new google.maps.Map(document.getElementById('cancha_map'), mapOptions);
			directionsDisplay = new google.maps.DirectionsRenderer({
				suppressMarkers: true,
			});
			directionsService = new google.maps.DirectionsService();
			var marcador = new google.maps.LatLng(lat,lng);
			var marker = new google.maps.Marker({
				position: marcador,
				map: map,
				title: name,
				icon:'../assets/img/google.png'
			});
			google.maps.event.addListener(marker, 'click', function(){
				var popup = new google.maps.InfoWindow({
					maxWidth: 150
				});
				var note = '<div><h6 class="bold uppercase" style="color:#4CAF50; text-align:center; font-weight:bold;">'+name+'<h6><img src="'+img+'" style="width:150px; height:auto;"><p>'+add+'</p></div>';
				popup.setContent(note);
				popup.open(map, this);
			});
			var mylat = position.coords.latitude;
			var mylon = position.coords.longitude;
			var marcador = new google.maps.LatLng(mylat,mylon);
			var marker = new google.maps.Marker({
				position: marcador,
				map: map,
				title: "Usted est\u00e1 aqui",
				icon:'../assets/img/aqui.png'
			});
			var start = new google.maps.LatLng(mylat,mylon);
			var end = new google.maps.LatLng(lat,lng);
			if(!start || !end){
				alert("Start and End addresses are required");
				return;
			}
			var request = {
				origin: start,
				destination: end,
				travelMode: google.maps.TravelMode.DRIVING,
				provideRouteAlternatives: true
			};
			directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setMap(map);
					directionsDisplay.setDirections(response);
				} else {
					$container = $("#container_notify").notify();  
        			create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"No existe una ubicaci\u00f3n geogr\u00e1fica <br> v\u00e1lida del centro deportivo", imagen:"../assets/img/alert.png"}); 
				}
			});
			<?php
		}else{?>
			var myLatlng = new google.maps.LatLng(-4.0075952, -79.2083788);
			var mapOptions = {
				zoom: 15,
				center: myLatlng,
				styles: [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]}]
			}
			var map = new google.maps.Map(document.getElementById('cancha_map'), mapOptions);
			<?php
		}
	}else if(@$id==0){
		$miconexion->consulta("select c.*, p.nombre from centros_deportivos c, provincia p where c.ciudad = p.id and c.latitud IS NOT NULL and c.longitud IS NOT NULL");
		?>
		var mylat = position.coords.latitude;
		var mylon = position.coords.longitude;
		var myLatlng = new google.maps.LatLng(mylat,mylon);
		var mapOptions = {
			zoom: 12,
			center: myLatlng,
			styles: [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]}]
		}
		var map = new google.maps.Map(document.getElementById('cancha_map'), mapOptions);
		var infowindow = new google.maps.InfoWindow({
			maxWidth: 150
		});
		var markers = new Array();
		var note = new Array();
		var getCity = document.getElementById("getCiudad").value;
		<?php
		for ($i=0; $i < $miconexion->numregistros(); $i++) { 
			$all=$miconexion->consulta_lista();
			?>
			var ciudad = "<?php echo $all[13] ?>";
			ciudad = 'Provincia de ' + ciudad;
			var ciudad2 = 'Provincia del ' + "<?php echo $all[13] ?>";
			if (ciudad == getCity || ciudad2 == getCity) {
				var lat = "<?php echo $all[6] ?>";
				var lng = "<?php echo $all[7] ?>";
				var id = "<?php echo $all[1] ?>";
				var name = "<?php echo ucwords($all[2])?>";
				var add = "<?php echo $all[5] ?>";
				var img = "<?php 
				if ($all[4]=="") {
					echo '../assets/img/soccer3.png';
				}else{
					echo 'images/centros/'.$all[0].$all[4];
				}
				?>";
				var marcador = new google.maps.LatLng(lat,lng);
				var marker = new google.maps.Marker({
					position: marcador,
					map: map,
					title: name,
					icon:'../assets/img/google.png'
				});
				// Set an attribute on the marker, it can be named whatever...
				marker.html='<div><a href="perfil.php?op=canchas&id='+id+'"><h6 class="bold uppercase" style="color:#4CAF50; text-align:center; font-weight:bold;">'+name+'<h6></a><img src="'+img+'" style="width:150px; height:auto;"><p>'+add+'</p></div>';
				markers.push(marker);
				google.maps.event.addListener(marker, 'click', function(){
					// Set the content of the InfoBubble or InfoWindow
					// They both have a function called setContent
					infowindow.setContent(this.html);
					infowindow.open(map, this);
				});	
			};		
		<?php
		}
	}
	?>
}

function geoNO(err) {
	<?php if (@$id!=0) {
		$miconexion->consulta("select * from centros_deportivos where id_centro = '".$id."'");
		if ($lista[6]!="" and $lista[7]!="") {
			$lista=$miconexion->consulta_lista();
			?>
			var lat = "<?php echo $lista[6] ?>";
			var lng = "<?php echo $lista[7] ?>";
			var name = "<?php echo ucwords($lista[2]) ?>";
			var add = "<?php echo $lista[5] ?>";
			var img = "<?php 
			if ($lista[4]=="") {
				echo '../assets/img/soccer3.png';
			}else{
				echo 'images/centros/'.$lista[0].$lista[4];
			}
			?>";
			var myLatlng = new google.maps.LatLng(lat,lng);
			var mapOptions = {
				zoom: 14,
				center: myLatlng,
				styles: [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]}]
			}
			map = new google.maps.Map(document.getElementById('cancha_map'), mapOptions);
			var marcador = new google.maps.LatLng(lat,lng);
			var marker = new google.maps.Marker({
				position: marcador,
				map: map,
				title: name,
				icon:'../assets/img/google.png'
			});
			google.maps.event.addListener(marker, 'click', function(){
				var popup = new google.maps.InfoWindow({
					maxWidth: 150
				});
				var note = '<div><h6 class="bold uppercase" style="color:#4CAF50; text-align:center; font-weight:bold;">'+name+'<h6><img src="'+img+'" style="width:150px; height:auto;"><p>'+add+'</p></div>';
				popup.setContent(note);
				popup.open(map, this);
			});
			<?php
		}else{?>
			var myLatlng = new google.maps.LatLng(-4.0075952, -79.2083788);
			var mapOptions = {
				zoom: 15,
				center: myLatlng,
				styles: [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]}]
			}
			var map = new google.maps.Map(document.getElementById('cancha_map'), mapOptions);
			<?php
		}
	}else if(@$id==0){
		$miconexion->consulta("select * from centros_deportivos where latitud IS NOT NULL and longitud IS NOT NULL");
		?>
		var myLatlng = new google.maps.LatLng(-4.0075952, -79.2083788);
		var mapOptions = {
			zoom: 12,
			center: myLatlng,
			styles: [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]}]
		}
		var map = new google.maps.Map(document.getElementById('cancha_map'), mapOptions);
		var infowindow = new google.maps.InfoWindow({
			maxWidth: 150
		});
		var markers = new Array();
		var note = new Array();
		<?php
		for ($i=0; $i < $miconexion->numregistros(); $i++) { 
			$all=$miconexion->consulta_lista();
			?>
			var lat = "<?php echo $all[6] ?>";
			var lng = "<?php echo $all[7] ?>";
			var id = "<?php echo $all[1] ?>";
			var name = "<?php echo ucwords($all[2]) ?>";
			var add = "<?php echo $all[5] ?>";
			var img = "<?php 
			if ($all[4]=="") {
				echo '../assets/img/soccer3.png';
			}else{
				echo 'images/centros/'.$all[0].$all[4];
			}
			?>";
			var marcador = new google.maps.LatLng(lat,lng);
			var marker = new google.maps.Marker({
				position: marcador,
				map: map,
				title: name,
				icon:'../assets/img/google.png'
			});
			// Set an attribute on the marker, it can be named whatever...
			marker.html='<div><a href="perfil.php?op=canchas&id='+id+'"><h6 class="bold uppercase" style="color:#4CAF50; text-align:center; font-weight:bold;">'+name+'</h6></a><img src="'+img+'" style="width:150px; height:auto;"><p>'+add+'</p></div>';
			markers.push(marker);
			google.maps.event.addListener(marker, 'click', function(){
			// Set the content of the InfoBubble or InfoWindow
			// They both have a function called setContent
			infowindow.setContent(this.html);
			infowindow.open(map, this);
		});
	<?php
		}
	}
	?>
}
</script>
<script type="application/javascript">
	function actualizar_notificacion(acto, ident, usu, date, grupo){
		var d = new Date(); 		
		var fecha = d.getFullYear() + "-" + (d.getMonth() +1) + "-" + d.getDate()+ ' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
		if (acto == "25") {
			fecha = date;
		};
		$.get("../include/actualizar_notificaciones.php",
		{ act: acto, id: ident, usm: usu, fecha:fecha, grupo:grupo
		}, function(data){
  			$("#respuesta").html(data);
		});	
	}
	function enviar_form(pagina, form){	
		if (form=="form_comentarios") {
			var d = new Date(); 		
			document.getElementById("fecha_actual").value = d.getFullYear() + "-" + (d.getMonth() +1) + "-" + d.getDate()+ ' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
		};
		var formData = new FormData($("form#"+form)[0]);
		$.ajax({
			url: pagina,//Url a donde enviaremos los datos
			type: 'POST',// Tipo de envio 
			dataType: 'html', //Tipo de Respuesta
			data:formData, //Serializamos el formulario
			cache: false,
            contentType: false,
            processData: false,
		})
		.done(function(data) {//Cuando nuestra función finalice, recuperamos la respuesta
			$("#respuesta").html(data); //Colocamos la respuesta en nuestro espacio maquetado.	
		})
	}
	////////////////COMPROBAR GRUPOS////////////
	function capturar(pagina, form){
		 $('#print').html2canvas({
        onrendered: function (canvas) {
            //Set hidden field's value to image data (base-64 string)
            $('#img_val').val(canvas.toDataURL("image/png"));
            //Submit the form manually
            var formData = new FormData($("form#"+form)[0]);	
			$.ajax({
				url: pagina,//Url a donde enviaremos los datos
				type: 'POST',// Tipo de envio 
				dataType: 'html', //Tipo de Respuesta
				data:formData, //Serializamos el formulario
				cache: false,
	            contentType: false,
	            processData: false,
			})
			.done(function(data) {//Cuando nuestra función finalice, recuperamos la respuesta
				$("#respuesta").html(data); //Colocamos la respuesta en nuestro espacio maquetado.	
			})
        	}
   		});
	}
    function ubicar(pagina, form){
    	var d = new Date(); 		
			document.getElementById("fecha_alineacion").value = d.getFullYear() + "-" + (d.getMonth() +1) + "-" + d.getDate()+ ' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    	var count = "<?php echo count($persona) ?>";
    	for (var i = 0; i < count; i++) { 
    		email = document.getElementById('div'+i);
    		document.getElementById('in'+i).value = $(email).parent().attr('id');
    	};
    	var formData = new FormData($("form#"+form)[0]);	
			$.ajax({
				url: pagina,//Url a donde enviaremos los datos
				type: 'POST',// Tipo de envio 
				dataType: 'html', //Tipo de Respuesta
				data:formData, //Serializamos el formulario
				cache: false,
	            contentType: false,
	            processData: false,
			})
			.done(function(data) {//Cuando nuestra función finalice, recuperamos la respuesta
				$("#respuesta").html(data); //Colocamos la respuesta en nuestro espacio maquetado.	
			})
    }

var fecha_actual_notificaciones = new Date();
var fecha_actual_solicitudes = new Date();
var fecha_actual_sugerencias = new Date();
var contador=0;
var contador_solicitudes=0;
var contador_sugerencias=0;
var user_notificaciones = "<?php echo $_SESSION['id'] ?>";
cargar_sugerencias();
//cargar_comen_grupos();
//cargar_comen_partidos();
//cargar_notificaciones_alineacion();
//cargar_notificaciones_grupos();
//cargar_solicitudes_grupos();
//cargar_solicitudes_partidos();
$container = $("#container_notify").notify();	

function cargar_comen_grupos() 
{ 
  $.ajax({
  async:  true, 
    type: "POST",
    url: "../datos/notcomen_grupos.json",
    data: "",
  dataType:"html",
    success: function(data)
  { 
    mostrar_notificaciones(data, "grupos");   
    //setTimeout('cargar_comen_grupos()',4000);          
    }
  }); 
}
function cargar_comen_partidos() 
{
  $.ajax({
  async:  true, 
    type: "POST",
    url: "../datos/notcomen_partidos.json",
    data: "",
  dataType:"html",
    success: function(data)
  { 
    mostrar_notificaciones(data, "partidos");
    //setTimeout('cargar_comen_partidos()',3000);          
    }
  });    
}

function cargar_notificaciones_alineacion() 
{
  $.ajax({
  async:  true, 
    type: "POST",
    url: "../datos/not_cambiosPartidos.json",
    data: "",
  dataType:"html",
    success: function(data)
  { 
    mostrar_notificaciones(data, "partidos");
    //setTimeout('cargar_notificaciones_alineacion()',3500);          
    }
  });    
}

function cargar_notificaciones_grupos() 
{
  $.ajax({
  async:  true, 
    type: "POST",
    url: "../datos/not_cambiosGrupos.json",
    data: "",
  dataType:"html",
    success: function(data)
  { 
    mostrar_notificaciones(data, "grupos");
    //setTimeout('cargar_notificaciones_grupos()',2500);          
    }
  });    
}

function cargar_solicitudes_grupos() 
{
  $.ajax({
  async:  true, 
    type: "POST",
    url: "../datos/not_solicitudesGrupos.json",
    data: "",
  dataType:"html",
    success: function(data)
  { 
    mostrar_solicitudes(data, "grupos");
    //setTimeout('cargar_solicitudes_grupos()',1500);          
    }
  });    
}

function cargar_solicitudes_partidos() 
{
  $.ajax({
  async:  true, 
    type: "POST",
    url: "../datos/not_solicitudesPartidos.json",
    data: "",
  dataType:"html",
    success: function(data)
  { 
    mostrar_solicitudes(data, "partidos");
    //setTimeout('cargar_solicitudes_partidos()',1000);          
    }
  });    
}

function cargar_sugerencias() 
{
  $.ajax({
  async:  true, 
    type: "POST",
    url: "../datos/not_sugerenciaPartidos.json",
    data: "",
  dataType:"html",
    success: function(data)
  { 
    mostrar_sugerencias(data);
    setTimeout('cargar_sugerencias()',500);          
    }
  });    
}

function mostrar_notificaciones(data, opcion){
	contador = 0;
	cont_notifi = parseInt(document.getElementById("contador1").innerHTML);
	var json = JSON.parse(data);
	var newItem = document.createElement("li");
    for (var i = 0; i < json.length; i++) {
      if (json[i].id_user==user_notificaciones) {
        fecha_not = Date.parse(json[i].fecha_not);
        if (fecha_not >= fecha_actual_notificaciones) {
          if (json[i].avatar=="") {
            if(json[i].sexo=="Masculino"){
            	if (opcion=="grupos") {
					create("default", { color:"background:rgba(41,23,210,0.8);", accion:"actualizar_notificacion(17,"+json[i].id_noti+")", enlace:"perfil.php?op=grupos&id="+json[i].id_grupo ,title:"Notificaci&oacute;n", text:"<strong>"+json[i].user+"</strong> "+json[i].mensaje+" <strong>"+json[i].nom_grupo+"</strong>", imagen:"../assets/img/user_masculino.png"});             		
			    	var textnode = newItem.innerHTML +="<a href='perfil.php?op=grupos&id="+json[i].id_grupo+"' onclick='actualizar_notificacion(17,"+json[i].id_noti+")' style='text-decoration:none;'>"
			            +"<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>"
			            +"<img style='width:30px; height:30px;' src='../assets/img/user_masculino.png'/></div>"
		                +"<div style='text-align:justify;'><strong> "+json[i].user+" </strong> "
		                +json[i].mensaje 
		                +" <strong> "+json[i].nom_grupo+"</strong>"
		                +"</div>"
		                +"</a>";			            
			        var list = document.getElementById("list_notifi");
			        list.insertBefore(newItem, list.childNodes[0]);
			        var total = cont_notifi + 1;
			        document.getElementById("contador1").innerHTML=""+total;
            	}else if (opcion=="partidos"){
					create("default", { color:"background:rgba(41,23,210,0.8);", accion:"actualizar_notificacion(17,"+json[i].id_noti+")", enlace:"perfil.php?op=alineacion&id="+json[i].id_partido ,title:"Notificaci&oacute;n", text:"<strong>"+json[i].user+"</strong> "+json[i].mensaje+" <strong>"+json[i].nom_partido+"</strong>", imagen:"../assets/img/user_masculino.png"}); 
			        var textnode = newItem.innerHTML +="<a href='perfil.php?op=alineacion&id="+json[i].id_partido+"' onclick='actualizar_notificacion(17,"+json[i].id_noti+")' style='text-decoration:none;'>"
			            +"<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>"
			            +"<img style='width:30px; height:30px;' src='../assets/img/user_masculino.png'/></div>"
		                +"<div style='text-align:justify;'><strong> "+json[i].user+" </strong> "
		                +json[i].mensaje 
		                +" <strong> "+json[i].nom_partido+"</strong>"
		                +"</div>"
		                +"</a>";			            
			        var list = document.getElementById("list_notifi");
			        list.insertBefore(newItem, list.childNodes[0]);
			        var total = cont_notifi + 1;
			        document.getElementById("contador1").innerHTML=""+total;
            	};
            }else{
            	if (opcion=="grupos") {
					create("default", { color:"background:rgba(41,23,210,0.8);", accion:"actualizar_notificacion(17,"+json[i].id_noti+")", enlace:"perfil.php?op=grupos&id="+json[i].id_grupo ,title:"Notificaci&oacute;n", text:"<strong>"+json[i].user+"</strong> "+json[i].mensaje+" <strong>"+json[i].nom_grupo+"</strong>", imagen:"../assets/img/user_femenino.png"}); 
			        var textnode = newItem.innerHTML +="<a  href='perfil.php?op=grupos&id="+json[i].id_grupo+"' onclick='actualizar_notificacion(17,"+json[i].id_noti+")' style='text-decoration:none;'>"
			            +"<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>"
			            +"<img style='width:30px; height:30px;' src='../assets/img/user_femenino.png'/></div>"
		                +"<div style='text-align:justify;'><strong> "+json[i].user+" </strong> "
		                +json[i].mensaje 
		                +" <strong> "+json[i].nom_grupo+"</strong>"
		                +"</div>"
		                +"</a>";
			        var list = document.getElementById("list_notifi");
			        list.insertBefore(newItem, list.childNodes[0]);
			        var total = cont_notifi + 1;
			        document.getElementById("contador1").innerHTML=""+total;
            	}else if (opcion=="partidos"){
					create("default", { color:"background:rgba(41,23,210,0.8);", accion:"actualizar_notificacion(17,"+json[i].id_noti+")", enlace:"perfil.php?op=alineacion&id="+json[i].id_partido ,title:"Notificaci&oacute;n", text:"<strong>"+json[i].user+"</strong> "+json[i].mensaje+" <strong>"+json[i].nom_partido+"</strong>", imagen:"../assets/img/user_femenino.png"}); 
			        var textnode = newItem.innerHTML +="<a href='perfil.php?op=alineacion&id="+json[i].id_partido+"' onclick='actualizar_notificacion(17,"+json[i].id_noti+")' style='text-decoration:none;'>"
			            +"<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>"
			            +"<img style='width:30px; height:30px;' src='../assets/img/user_femenino.png'/></div>"
		                +"<div style='text-align:justify;'><strong> "+json[i].user+" </strong> "
		                +json[i].mensaje 
		                +" <strong> "+json[i].nom_partido+"</strong>"
		                +"</div>"
		                +"</a>";			            
			        var list = document.getElementById("list_notifi");
			        list.insertBefore(newItem, list.childNodes[0]);
			        var total = cont_notifi + 1;
			        document.getElementById("contador1").innerHTML=""+total;
            	};
            };
          }else{
        	if (opcion=="grupos") {
				create("default", { color:"background:rgba(41,23,210,0.8);", accion:"actualizar_notificacion(17,"+json[i].id_noti+")", enlace:"perfil.php?op=grupos&id="+json[i].id_grupo ,title:"Notificaci&oacute;n", text:"<strong>"+json[i].user+"</strong> "+json[i].mensaje+" <strong>"+json[i].nom_grupo+"</strong>", imagen:"images/"+json[i].user+"/"+json[i].avatar}); 
		        var textnode = newItem.innerHTML +="<a href='perfil.php?op=grupos&id="+json[i].id_grupo+"' onclick='actualizar_notificacion(17,"+json[i].id_noti+")' style='text-decoration:none;'>"
		            +"<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>"
		            +"<img style='width:30px; height:30px;' src='images/"+json[i].user+"/"+json[i].avatar+"'/></div>"
	                +"<div style='text-align:justify;'><strong> "+json[i].user+" </strong>"
	                +json[i].mensaje 
	                +"<strong> "+json[i].nom_grupo+"</strong>"
	                +"</div>"
	                +"</a>";			            
		        var list = document.getElementById("list_notifi");
		        list.insertBefore(newItem, list.childNodes[0]);
		        var total = cont_notifi + 1;
		        document.getElementById("contador1").innerHTML=""+total;
      		}else if (opcion=="partidos"){
				create("default", { color:"background:rgba(41,23,210,0.8);", accion:"actualizar_notificacion(17,"+json[i].id_noti+")", enlace:"perfil.php?op=alineacion&id="+json[i].id_partido ,title:"Notificaci&oacute;n", text:"<strong>"+json[i].user+"</strong> "+json[i].mensaje+" <strong>"+json[i].nom_partido+"</strong>", imagen:"images/"+json[i].user+"/"+json[i].avatar}); 
		        var textnode = newItem.innerHTML +="<a href='perfil.php?op=alineacion&id="+json[i].id_partido+"' onclick='actualizar_notificacion(17,"+json[i].id_noti+")' style='text-decoration:none;'>"
		            +"<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>"
		            +"<img style='width:30px; height:30px;' src='images/"+json[i].user+"/"+json[i].avatar+"'/></div>"
	                +"<div style='text-align:justify;'><strong> "+json[i].user+" </strong> "
	                +json[i].mensaje 
	                +" <strong> "+json[i].nom_partido+"</strong>"
	                +"</div>"
	                +"</a>";			            
		        var list = document.getElementById("list_notifi");
		        list.insertBefore(newItem, list.childNodes[0]);
		        var total = cont_notifi + 1;
		        document.getElementById("contador1").innerHTML=""+total;
        	};
          };
          contador++;
        };
      };
    };
    if (contador>0) {
      fecha_actual_notificaciones = new Date();
    };
}

function mostrar_solicitudes(data, opcion){
	contador_solicitudes = 0;
	act = 20;
    act2 = 21;
	cont_solicitud = parseInt(document.getElementById("solicitud1").innerHTML);
	var json = JSON.parse(data);
	var newItem = document.createElement("li");
    for (var i = 0; i < json.length; i++) {
      if (json[i].id_user==user_notificaciones) {
        fecha_not = Date.parse(json[i].fecha_not);
        if (fecha_not >= fecha_actual_solicitudes) {
          if (json[i].avatar=="") {
            if(json[i].sexo=="Masculino"){
            	if (opcion=="grupos") {
					create("default", { color:"background:rgba(41,23,210,0.8);", title:"Solicitud", text:"<strong>"+json[i].user+"</strong> "+json[i].mensaje+" <strong>"+json[i].nom_grupo+"</strong>", imagen:"../assets/img/user_masculino.png"});             		
		            var textnode = newItem.innerHTML +="<a href='javascript:;'>"
		                +"<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>"
		                +"<img style='width:30px; height:30px;' src='../assets/img/user_masculino.png'/>"
		                +"</div>"
		                +"<div style='text-align:justify;'>"
		                +"<strong> "+json[i].user+" </strong> "+json[i].mensaje+" <strong>"+json[i].nom_grupo+"</strong>"
		                +"</div>"
		                +"<br>"
		                +"<span class='details' >"
		                +"<span class='label label-sm label-icon label-success' onclick='actualizar_notificacion("+act+","+json[i].id_noti+");'>"
		                +"<i class='icon-ok'></i>"
		                +"</span>"
		                +"<span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion("+act2+","+json[i].id_noti+");'>"
		                +"<i class='icon-remove'></i>"
		                +"</span>"
		                +"</span>"
		                +"</a>";			            
			        var list = document.getElementById("list_solicitud");
			        list.insertBefore(newItem, list.childNodes[0]);
			        var total = cont_solicitud + 1;
			        document.getElementById("solicitud1").innerHTML=""+total;
            	}else if (opcion=="partidos"){
					create("default", { color:"background:rgba(41,23,210,0.8);", title:"Solicitud", text:"<strong>"+json[i].user+"</strong> "+json[i].mensaje+" <strong>"+json[i].nom_partido+"</strong>", imagen:"../assets/img/user_masculino.png"}); 
			        var textnode = newItem.innerHTML +="<a href='javascript:;'>"
		                +"<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>"
		                +"<img style='width:30px; height:30px;' src='../assets/img/user_masculino.png'/>"
		                +"</div>"
		                +"<div style='text-align:justify;'>"
		                +"<strong> "+json[i].user+" </strong> "+json[i].mensaje+" <strong>"+json[i].nom_partido+"</strong>"
		                +"</div>"
		                +"<br>"
		                +"<span class='details' >"
		                +"<span class='label label-sm label-icon label-success' onclick='actualizar_notificacion("+act+","+json[i].id_noti+");'>"
		                +"<i class='icon-ok'></i>"
		                +"</span>"
		                +"<span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion("+act2+","+json[i].id_noti+");'>"
		                +"<i class='icon-remove'></i>"
		                +"</span>"
		                +"</span>"
		                +"</a>";				            
			        var list = document.getElementById("list_solicitud");
			        list.insertBefore(newItem, list.childNodes[0]);
			        var total = cont_solicitud + 1;
			        document.getElementById("solicitud1").innerHTML=""+total;
            	};
            }else{
            	if (opcion=="grupos") {
					create("default", { color:"background:rgba(41,23,210,0.8);", title:"Solicitud", text:"<strong>"+json[i].user+"</strong> "+json[i].mensaje+" <strong>"+json[i].nom_grupo+"</strong>", imagen:"../assets/img/user_femenino.png"});             		
		            var textnode = newItem.innerHTML +="<a href='javascript:;'>"
		                +"<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>"
		                +"<img style='width:30px; height:30px;' src='../assets/img/user_femenino.png'/>"
		                +"</div>"
		                +"<div style='text-align:justify;'>"
		                +"<strong> "+json[i].user+" </strong> "+json[i].mensaje+" <strong>"+json[i].nom_grupo+"</strong>"
		                +"</div>"
		                +"<br>"
		                +"<span class='details' >"
		                +"<span class='label label-sm label-icon label-success' onclick='actualizar_notificacion("+act+","+json[i].id_noti+");'>"
		                +"<i class='icon-ok'></i>"
		                +"</span>"
		                +"<span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion("+act2+","+json[i].id_noti+");'>"
		                +"<i class='icon-remove'></i>"
		                +"</span>"
		                +"</span>"
		                +"</a>";
			        var list = document.getElementById("list_solicitud");
			        list.insertBefore(newItem, list.childNodes[0]);
			        var total = cont_solicitud + 1;
			        document.getElementById("solicitud1").innerHTML=""+total;
            	}else if (opcion=="partidos"){
					create("default", { color:"background:rgba(41,23,210,0.8);", title:"Solicitud", text:"<strong>"+json[i].user+"</strong> "+json[i].mensaje+" <strong>"+json[i].nom_partido+"</strong>", imagen:"../assets/img/user_femenino.png"}); 
			        var textnode = newItem.innerHTML +="<a href='javascript:;'>"
		                +"<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>"
		                +"<img style='width:30px; height:30px;' src='../assets/img/user_femenino.png'/>"
		                +"</div>"
		                +"<div style='text-align:justify;'>"
		                +"<strong> "+json[i].user+" </strong> "+json[i].mensaje+" <strong>"+json[i].nom_partido+"</strong>"
		                +"</div>"
		                +"<br>"
		                +"<span class='details' >"
		                +"<span class='label label-sm label-icon label-success' onclick='actualizar_notificacion("+act+","+json[i].id_noti+");'>"
		                +"<i class='icon-ok'></i>"
		                +"</span>"
		                +"<span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion("+act2+","+json[i].id_noti+");'>"
		                +"<i class='icon-remove'></i>"
		                +"</span>"
		                +"</span>"
		                +"</a>";			            
			        var list = document.getElementById("list_solicitud");
			        list.insertBefore(newItem, list.childNodes[0]);
			        var total = cont_solicitud + 1;
			        document.getElementById("solicitud1").innerHTML=""+total;
            	};
            };
          }else{
        	if (opcion=="grupos") {
	            create("default", { color:"background:rgba(41,23,210,0.8);", title:"Solicitud", text:"<strong>"+json[i].user+"</strong> "+json[i].mensaje+" <strong>"+json[i].nom_grupo+"</strong>", imagen:"images/"+json[i].user+"/"+json[i].avatar});             		
		            var textnode = newItem.innerHTML +="<a href='javascript:;'>"
		                +"<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>"
		                +"<img style='width:30px; height:30px;' src='images/"+json[i].user+"/"+json[i].avatar+"'/>"
		                +"</div>"
		                +"<div style='text-align:justify;'>"
		                +"<strong> "+json[i].user+" </strong> "+json[i].mensaje+" <strong>"+json[i].nom_grupo+"</strong>"
		                +"</div>"
		                +"<br>"
		                +"<span class='details' >"
		                +"<span class='label label-sm label-icon label-success' onclick='actualizar_notificacion("+act+","+json[i].id_noti+");'>"
		                +"<i class='icon-ok'></i>"
		                +"</span>"
		                +"<span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion("+act2+","+json[i].id_noti+");'>"
		                +"<i class='icon-remove'></i>"
		                +"</span>"
		                +"</span>"
		                +"</a>";			            
		        var list = document.getElementById("list_solicitud");
		        list.insertBefore(newItem, list.childNodes[0]);
		        var total = cont_solicitud + 1;
		        document.getElementById("solicitud1").innerHTML=""+total;
      		}else if (opcion=="partidos"){
				create("default", { color:"background:rgba(41,23,210,0.8);", title:"Solicitud", text:"<strong>"+json[i].user+"</strong> "+json[i].mensaje+" <strong>"+json[i].nom_partido+"</strong>", imagen:"images/"+json[i].user+"/"+json[i].avatar}); 
			        var textnode = newItem.innerHTML +="<a href='javascript:;'>"
		                +"<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;'>"
		                +"<img style='width:30px; height:30px;' src='images/"+json[i].user+"/"+json[i].avatar+"'/>"
		                +"</div>"
		                +"<div style='text-align:justify;'>"
		                +"<strong> "+json[i].user+" </strong> "+json[i].mensaje+" <strong>"+json[i].nom_partido+"</strong>"
		                +"</div>"
		                +"<br>"
		                +"<span class='details' >"
		                +"<span class='label label-sm label-icon label-success' onclick='actualizar_notificacion("+act+","+json[i].id_noti+");'>"
		                +"<i class='icon-ok'></i>"
		                +"</span>"
		                +"<span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion("+act2+","+json[i].id_noti+");'>"
		                +"<i class='icon-remove'></i>"
		                +"</span>"
		                +"</span>"
		                +"</a>";			            
		        var list = document.getElementById("list_solicitud");
		        list.insertBefore(newItem, list.childNodes[0]);
		        var total = cont_solicitud + 1;
		        document.getElementById("solicitud1").innerHTML=""+total;
        	};
          };
          contador_solicitudes++;
        };
      };
    };
    if (contador_solicitudes>0) {
      fecha_actual_solicitudes = new Date();
    };
}

function mostrar_sugerencias(data){
	contador_sugerencias = 0;
	var json = JSON.parse(data);
	var newItem = document.createElement("li");
    for (var i = 0; i < json.length; i++) {
      if (json[i].id_user==user_notificaciones) {
        fecha_not = Date.parse(json[i].fecha_not);
        if (fecha_not >= fecha_actual_sugerencias) {        
	        var textnode = newItem.innerHTML +="<a href='javascript:;'>"
		    +"<span class='title'>"
		    +json[i].user+" ha ofertado cupos para el partido "+json[i].nom_partido+" a jugarse el "+json[i].fecha+" a las "+json[i].hora_ini+" - "+json[i].hora_fin+" en "+json[i].centro+". Aceptas?<br>"
		    +"<span class='label label-sm label-icon label-success' onclick='actualizar_notificacion(4,"+json[i].nom_partido+");'>"
		    +"<i class='icon-ok'></i>"
		    +"</span>"
		    +"<span class='label label-sm label-icon label-danger' onclick='actualizar_notificacion(5,"+json[i].id_noti+");'>"
		    +"<i class='icon-remove'></i>"
		    +"</span></span></a>";

	        var list = document.getElementById("list_sugerencias");
	        list.insertBefore(newItem, list.childNodes[0]);            
          contador_sugerencias++;
        };
      };
    };
    if (contador_sugerencias>0) {
      fecha_actual_sugerencias = new Date();
    };
}

function eliminar_reservasVencidas(data){
	var fecha_hoy= new Date();
	$.ajax({
	  async:  true, 
	    type: "POST",
	    url: "../datos/tiempoEsperaPartidos.json",
	    data: "",
	  dataType:"html",
	    success: function(data)
	  { 
		var json = JSON.parse(data);
	    for (var i = 0; i < json.length; i++) {
	    	var fecha_expira = Date.parse(json[i].fecha_expira);    
	    	if (fecha_hoy > fecha_expira) {    	
	    		actualizar_notificacion(30,json[i].id_partido,json[i].id_user);     	 
	       };
	    };    
	    setTimeout('eliminar_reservasVencidas()',15000);          
	    }
	  }); 
}

eliminar_reservasVencidas();
</script>

<!-- END JAVASCRIPTS -->
</body>

<!-- END BODY -->
</html>