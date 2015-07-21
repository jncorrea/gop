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
<link href="../assets/css/gop.css" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
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

<style>
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
///////////////////////////////////////////////////////////////////////
function mostrar(id) {
    obj = document.getElementById(id);
    obj.style.display = (obj.style.display == 'none') ? '' : 'none';    
}
/////////////////////RECARGAR DIVS////////////////////////////////////
 $(document).ready(function() {

 $('input[type="submit"]').attr('disabled','disabled');

 $('input[type="text"]').keypress(function(){

        if($(this).val() != ''){

           $('input[type="submit"]').removeAttr('disabled');

       }

 });
 	/////////////////////////////////////////////////////////////
 	var consulta;
         
  //hacemos focus
  $("#grupo").focus();
                                             
  //comprobamos si se pulsa una tecla
  $("#grupo").keyup(function(e){
         //obtenemos el texto introducido en el campo
         consulta = $("#grupo").val();
                                  
         //hace la búsqueda
         $("#resultado").delay(1000).queue(function(n) {  
         document.getElementById('crear_grupo').disabled=true;    
                                       
                $.ajax({
                  type: "POST",
                  url: "../include/comprobar.php",
                  data: "b="+consulta,
                  dataType: "html",
                  error: function(){
                        alert("error petición ajax");
                  },
                  success: function(data){                                                      
                        $("#resultado").html(data);
                        n();    
                        
		                /*var mensaje= document.getElementById("resultado").innerText;
		                if(mensaje==""){
		                	document.getElementById('crear_grupo').disabled=true;
		                }else if (mensaje=="Disponible") {
		                	document.getElementById('crear_grupo').disabled=false;
		                }else if(mensaje=="El grupo ya existe"){
		                	document.getElementById('crear_grupo').disabled=true;
		                };     */                        
                }                         
            });
                          
        });
                            
  });
 	///////////////////////////////////////
 	 $("#col_chat").load("col_chat.php");
   var refreshId = setInterval(function() {
      $("#col_chat").load('col_chat.php?randval='+ Math.random());
   }, 9000);
   $.ajaxSetup({ cache: false });
});
////////////////////////////////////////////////////////
$('#widget').draggable();
	///////////////////////////////////////////////
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
	$(function() {
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
	//////////////////////////////////////////////
	</script>

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
	              echo "<img alt='Avatar' class='img-circle' src='images/".$_SESSION['email']."/".$lista[7]."'>";
	            }
	          echo '<span class="username username-hide-on-mobile">'.$lista[2].'</span>'; ?>
	          <i class="fa fa-angle-down"></i>
	          </a>
	          <ul class="dropdown-menu dropdown-menu-default">
	            <li>
	              <a href="perfil.php?op=configurar">
	              <i class="icon-user"></i> Mi Perfil </a>
	            </li>
	            <li>
	              <a href="page_calendar.html">
	              <i class="icon-calendar"></i> Mi Calendario</a>
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
					<span class="title">Mis Grupos</span>
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
					<span class="title">Mis Partidos</span>
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
					<a href="perfil.php?op=canchas">
					<i class="icon-map-marker"></i>
					<span class="title">Canchas</span>
					</a>
				</li>
				<li class="heading">
					<h3 class="uppercase">Suggerencias</h3>
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
			<?php 
		        switch ($op) {
		          case 'configurar':
		            include("configurar2.php");
		            break;

		          case 'grupos':
		            include("grupos.php");
		            break;
		          case 'evento':
		          	?>
		          	<div class="infor col-xs-12 col-sm-12 col-md-6 col-lg-5">
		          	<?php 
		            include("crear_evento.php");
		            ?>
					</div>
					<div class="infor col-xs-6 col-md-3" style="margin-left:0;">
						<?php 
			            	include("notificaciones.php");              
			             ?>
					</div>
		            <?php
		            break;
		          case 'alineacion':
		            include("alineacion.php");
		            break;
		           case 'cancha':
			           ?>
			          	<div class="infor col-xs-12 col-sm-12 col-md-6 col-lg-5">
			          	<?php 
		        		$miconexion->consulta("select * from canchas");  
					  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
					    $lista_canchas=$miconexion->consulta_lista();
					  }
			            include("../perfiles/crear_cancha.php");
			            ?>
						</div>
					<div class="infor col-xs-6 col-md-3" style="margin-left:0;">
						<?php include("notificaciones.php"); ?>
					</div>
		            <?php
		            break;

		          case 'editar_evento':
		          	?>
		          	<div class="infor col-xs-12 col-sm-12 col-md-6 col-lg-5">
			          	<?php 
			        	extract($_GET);
			        	$miconexion->consulta("select * from partidos where id_partido= '".$id."' ");  
						for ($i=0; $i < $miconexion->numregistros(); $i++) { 
							$lista_evento=$miconexion->consulta_lista();
						}
		                include("../include/editar_evento.php");
		                ?>
					</div>					
					<div class="infor col-xs-6 col-md-3" style="margin-left:0;">
						<?php include("notificaciones.php"); ?>
					</div>
		            <?php
	                break;
	              case 'canchas':
	              	include('canchas.php');
	              break;
		          default:
		          	?>
		          	<div class="infor col-xs-12 col-sm-12 col-md-6 col-lg-5">
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
						      <img src="../assets/img/reune.png" alt="Reune" class="img-carousel">
						      <div class="carousel-caption animated bounceIn">Reune</div>
						    </div>
						    <div class="item">
						      <img src="../assets/img/organiza.png" alt="Organiza" class="img-carousel">
						      <div class="carousel-caption animated bounceIn">Organiza</div>
						    </div>
						    <div class="item">
						      <img src="../assets/img/juega.png" alt="Juega" class="img-carousel">
						      <div class="carousel-caption animated bounceIn">Juega</div>
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
					</div>
		            <?php
		            break;
		        }
		        ?>			
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
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&callback=initialize"></script>
<!-- BEGIN CORE PLUGINS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="../assets/js/chat.js"></script>
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
<script>
jQuery(document).ready(function() {
	Metronic.init();
   Layout.init(); // init layout
	////////////////////////////////////////////////////////
   QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   Index.init();
   Index.initChat()
});
function initialize() {
	//var myLatlng = new google.maps.LatLng(-2.524406, -78.929772);
	var myLatlng = new google.maps.LatLng(-4.0075952,-79.2083788);
	var mapOptions = {
		zoom: 10,
		center: myLatlng,
		styles: [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]}]
	}
	var map = new google.maps.Map(document.getElementById('cancha_map'), mapOptions);
	//var marcador = new google.maps.LatLng({{a.latitud}}, {{a.longitud}});
	var marcador = new google.maps.LatLng(-3.977599,-79.202093);
	var marker = new google.maps.Marker({
		position: marcador,
		map: map,
		title: 'La pampita',
		icon:'../assets/img/google.png'
	});
}
</script>
<script type="application/javascript">
	
	////////////////COMPROBAR GRUPOS////////////
	function capturar(){
		 $('#print').html2canvas({
        onrendered: function (canvas) {
            //Set hidden field's value to image data (base-64 string)
            $('#img_val').val(canvas.toDataURL("image/png"));
            //Submit the form manually
            document.getElementById("myForm").submit();
        	}
   		});
	}
	function confirmar(){
		if(confirm('¿Esta seguro de eliminar el grupo?'))
			return true;
		else
			return false;
	}
    function ubicar(){
    	var count = "<?php echo count($persona) ?>";
    	for (var i = 0; i < count; i++) { 
    		email = document.getElementById('div'+i);
    		document.getElementById('in'+i).value = $(email).parent().attr('id');
    	};
    }
      function archivo(evt) {
      var files = evt.target.files; // FileList object       
        //Obtenemos la imagen del campo "file". 
      for (var i = 0, f; f = files[i]; i++) {         
           //Solo admitimos imágenes.
           if (!f.type.match('image.*')) {
                continue;
           }
           var reader = new FileReader();
           
           reader.onload = (function(theFile) {
               return function(e) {
               // Creamos la imagen.
                      document.getElementById("list").innerHTML = ['<img style="width: 120px; height: 120px; border: 1px solid #000;" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
               };
           })(f);
           reader.readAsDataURL(f);
        }
      }  
      document.getElementById('avatar').addEventListener('change', archivo, false);
    </script>
<!-- END JAVASCRIPTS -->
</body>

<!-- END BODY -->
</html>