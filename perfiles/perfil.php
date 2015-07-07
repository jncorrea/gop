<?php 
session_start();
if (!$_SESSION){
  echo '<script>alert("Por favor debe iniciar sesión")</script>'; 
  header("Location: ../index.php?mn=1");

}
header('Content-Type: text/html; charset=ISO-8859-1');
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
extract($_GET);
if(@$op==''){$op="perfil";}
  global $lista;
  global $cont;
  global $persona;
  global $l;
  $miconexion->consulta("select * from miembros where email = '".$_SESSION["email"]."' ");
  $cont = $miconexion->numcampos();
  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    $lista=$miconexion->consulta_lista();
  }
  if (@$act==1) {
 	 $miconexion->consulta("delete from grupos_miembros where id_grupo = '".$id."' ");
 	 $miconexion->consulta("delete from grupos where id_grupo = '".$id."' ");
  }elseif(@$act==2){
   $miconexion->consulta("update grupos_miembros set estado=1 where id_grupo = '".$id."' ");    
  }elseif(@$act==3){
   $miconexion->consulta("delete from grupos_miembros where id_grupo = '".$id."' ");    
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gather, Organize and Play</title>
	<link rel="shortcut icon" type="image/ico" href="../assets/img/ball.png">
	<link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/css/gop.css" rel="stylesheet">
	<link rel="stylesheet" href="../assets/css/animations.css" type="text/css">
	<!--BUSCAR PERSONA-->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>	
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.2/jquery.ui.touch-punch.min.js"></script>
	<style>
        .column {
		    width: 80px;
		    height: 65px;
		    float: left;
		    padding-bottom: 10px;

		}
		.jugadores{
		  width: 10.9%;
		  height: 65px;
		  float: left;
		  background-image: url("../assets/img/jugador.png")!important;
		  background-repeat: no-repeat;
		  background-position: center center;
		  background-size: 100% 100%;
		  margin-left: 1.5%;
		  margin-top: 1.5%;
		}
        .portlet { margin: 0 1em 1em 0; }
        .portlet-header { margin: 0.3em; padding-bottom: 4px; padding-left: 0.2em; }
        .portlet-header .ui-icon { float: right; }
        .portlet-content { padding: 0.4em; }
        .ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
        .ui-sortable-placeholder * { visibility: hidden; }
    </style>
	<script>
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
<body style="background-image: url(../assets/img/soccer3.png); background-size: 100%;">
	<!--- MENU -->
	<header>
		<div class="row"></div>
			<div class="img col-xs-6 col-sm-4 col-md-4 col-lg-3">
				<img src="../assets/img/logo.png" alt="">
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
			          <ul class="nav navbar-nav" style="font-family:arial;">
			            <li style="font-size:13px;">
		                  	<?php 
		                  		$nick = split('@',$_SESSION["email"]);
								if ($lista[6]==""){
									echo '<img src="../assets/img/user.jpg" alt="Avatar" style="width:8%; margin-right:0.5em;" class="img-circle">';
								}else{
									echo "<img src='images/".$_SESSION["email"]."/".$lista[6]."' style='width:8%; margin-right:0.5em;' class='img-circle'>";
								}
							echo $nick[0]; ?><a title="Log out" style="font-size:16px; display: inline-block;" href="../login/salir.php"> <span class="glyphicon glyphicon-log-out"></span></a>
		                </li>
			          </ul>
			        </div>
			      </div>
			    </nav>
			</div>
		</div>		
	</header>
	<!--- FIN MENU -->
	<!--- CONTENIDO -->
	<section id="content" style="background: rgba(23,11,59,0.1);">
		<div class="row">
			<!--- BLOQUE IZQUIERDA -->
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
				<div class="row infor" style="width: 100%;">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="edit">
							<a title="Editar Perfil" href="perfil.php?op=configurar" style="z-index:4;"><span class="glyphicon glyphicon-pencil"></span></a>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-5" style="padding-right:0; padding-left:0;">
								<?php 
									if ($lista[6]==""){
										echo '<img src="../assets/img/user.jpg" alt="Avatar" class="img-circle" style="width:100%; height: 110px;">';
									}else{
										echo "<img src='images/".$_SESSION["email"]."/".$lista[6]."' class='img-circle' style='width:100%; height: 110px;'>";
									}
								?>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
								<p style="font-size:14px; font-weight: bold;"><?php echo $lista[2]." ".$lista[3]; ?></p>
								<p style="font-size:12px;"><?php echo $lista[0]?></p>
								<p style="font-size:12px;">Celular: <?php echo $lista[4]?></p>
								<p style="font-size:12px;">Posici&oacute;n: <?php echo $lista[5]?></p>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="account" id="account">
				          <ul id="progressbar-account"> 
				            <h4 style="font: bold 90%">Avance del Perfil</h4>
				            <li id="box1">25%</li>          
				            <li id="box2">50%</li>
				            <li id="box3">75%</li>
				            <li id="box4">100%</li>
				          </ul> 
				          <?php 
				            $porcentaje = 0;
				            for ($i=0; $i < $cont; $i++) { 
				              if ($lista[$i]!="") {
				                $porcentaje = $porcentaje + 14;
				              }
				            }
				            if ($porcentaje>25) {
				              echo "<script>
				                      $('li#box1').addClass('active-box');
				                    </script>";
				            }
				            if ($porcentaje>50) {
				              echo "<script>
				                      $('li#box2').addClass('active-box');
				                    </script>";
				            }
				            if ($porcentaje>75) {
				               echo "<script>
				                      $('li#box3').addClass('active-box');
				                    </script>";
				            }if ($porcentaje >= 98){
				               echo "<script>
				                    $('li#box4').addClass('active-box');
		                        	document.getElementById('account').hidden=true;                     
				                    </script>";
				            }
				           ?> 
				        </div>
					</div>
				</div>
				<div class="row infor" style="width: 100%;">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h4>Mis Partidos
				        <a title="Crear Partido" style="font-size:20px;" href="perfil.php?op=evento">
				        <span class="glyphicon glyphicon-plus"></span></a>  
				        <a href="#" style="position: absolute; top: 0; left: 90%;">
				        	<span id="min" class="glyphicon glyphicon-minus" onclick="mostrar('tabla_partidos'); return false"></span></a> 	          
			          	</h4>	
			          	<table class="table table-striped" id="tabla_partidos">  
			            	<?php
			            	$miconexion->consulta("select p.id_grupo, p.id_partido, p.fecha 
			            		FROM partidos p, grupos_miembros gm 
			            		WHERE p.id_grupo = gm.id_grupo and gm.email ='".$_SESSION["email"]."' ");		            	
			            	$cont = $miconexion->numcampos();
			            	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
				                $partidos=$miconexion->consulta_lista();
				                echo "<tr>";
				                $time=strtotime($partidos[2]);
				                $fecha = date("d M Y H:i",$time);
				                echo 	"<td>".$fecha."</td>";
				                echo 	"<td style='padding:0px; margin:auto;'><a href='perfil.php?op=alineacion&id=".$partidos[1]."'><img style='width:90%; height:60%;' src='../assets/img/campo.png'></a></td>";
				                echo 	"<td style='padding:0px; margin:auto;'><a href='perfil.php?op=grupos&id=".$partidos[0]."'><img style='width:80%; height:60%;' src='../assets/img/grupo.png'></a></td>";
				                echo 	"<td style='padding:0px; margin:auto;'><a href='perfil.php?op=editar_evento&id=".$partidos[1]."'><img style='width:60%; height:60%;' src='../assets/img/icon.png'></a></td>";				                
				                echo "</tr>"; 
			            	}
			               ?>            
			            </table>		          	
					</div>
				</div>
				<div class="row infor" style="width: 100%;">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">				
						<h4>Mis Grupos
				        <a title="Crear Grupo" style="font-size:20px;" href="#" onclick="mostrar('crearGrupo'); return false" >
				        <span class="glyphicon glyphicon-plus" ></span></a>
				        <a href="#" style="position: absolute; top: 0; left: 90%;">
				        	<span id="min" class="glyphicon glyphicon-minus" onclick="mostrar('tabla_grupos'); return false"></span></a>
				       	</h4>
			          	<div id="crearGrupo" style="display:none;">
				            <form method="post" action="../include/insertarGrupo.php"class="form-horizontal" id="form_grupo">
				              <div class="form-horizontal" style="display:inline-block;">
				                  <input type="hidden" class="form-control" id="bd" name="bd" value="grupos">
				                  <input style="width:78%; display:inline-block;" type="text" class="form-control" id="grupo" name="grupo" placeholder="Nombre del Grupo..">
				                  <?php 
				                    echo '<input type="hidden" class="form-control" id="owner" name="owner" value="'.$_SESSION["email"].'">'; 
				                   ?>
				                  <button id="crear_grupo" style="width:20%; display:inline-block;" disabled="false" type="submit" class="btn btn-default">Crear</button>
				                   <div id="resultado"></div>
				              </div>
				            </form>
		          		</div>
			          	<table class="table table-striped" id="tabla_grupos">  
			            	<?php
			            	$miconexion->consulta("select g.nombre_grupo, g.id_grupo, g.owner, gm.email from grupos g, grupos_miembros gm where g.id_grupo=gm.id_grupo and gm.email='".$_SESSION["email"]."' ");
			            	$cont = $miconexion->numcampos();
			            	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
				                $lista2=$miconexion->consulta_lista();
				                echo "<tr>";
				                if ($lista2[2]==$lista2[3]) {
				                	echo 	"<td style='width:15px;'><a style='font-size:15px;' href='perfil.php?act=1&id=".$lista2[1]."' onclick='return confirmar()'>
				                	<span class='glyphicon glyphicon-remove-circle'></span></a></td>";
				                }else{
				                	echo 	"<td></td>";                	
				                }
				                echo 	"<td>".$lista2[0]."</td>";
				                echo 	"<td><a href='perfil.php?op=grupos&id=".$lista2[1]."'><span class='glyphicon glyphicon-user'></span></a></td>";
				                echo "</tr>"; 
			            	}
			               ?>            
			            </table>
					</div>	
				</div>
			</div>
			<!--- BLOQUE CENTRAL -->
			
				<?php 
		        switch ($op) {
		          case 'configurar':
		          	?>
		          	<div class="infor col-xs-12 col-sm-12 col-md-6 col-lg-5">
		          	<?php 
		            include("configurar.php");
		            ?>
					</div>
					<div class="infor col-xs-6 col-md-3" style="margin-left:0;">
						<?php 
			            	include("notificaciones.php");              
			             ?>
					</div>
		            <?php
		            break;

		          case 'grupos':
		          	?>
		          	<div class="infor col-xs-12 col-sm-12 col-md-6 col-lg-5">
		          	<?php 
		            include("grupos.php");
		            ?>
					</div>
					<div class="infor col-xs-6 col-md-3" style="margin-left:0;">
						<?php 
			            	include("notificaciones.php");              
			             ?>
					</div>
		            <?php
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
		          default:
		          	?>
		          	<div class="infor col-xs-12 col-sm-12 col-md-6 col-lg-5">
					</div>
					<div class="infor col-xs-6 col-md-3" style="margin-left:0;">
						<?php include("notificaciones.php"); ?>
					</div>
		            <?php
		            break;
		        }
		        ?>
		</div>
	</section>
	<!--- FIN CONTENIDO -->
	<footer>
		<?php include("../static/footer.php"); ?>
	</footer>
		<script type="application/javascript">
	
	////////////////COMPROBAR GRUPOS////////////
	$(document).ready(function(){
                         
      var consulta;
             
      //hacemos focus
      $("#grupo").focus();
                                                 
      //comprobamos si se pulsa una tecla
      $("#grupo").keyup(function(e){
             //obtenemos el texto introducido en el campo
             consulta = $("#grupo").val();
                                      
             //hace la búsqueda
             $("#resultado").delay(1000).queue(function(n) {      
                                           
                  //$("#resultado").html('<img src="../assets/img/loader.gif" />');
                                           
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
				                var mensaje= document.getElementById("resultado").innerText;
				                if(mensaje==""){
				                	document.getElementById('crear_grupo').disabled=true;
				                }else if (mensaje=="Disponible") {
				                	document.getElementById('crear_grupo').disabled=false;
				                }else if(mensaje=="El grupo ya existe"){
				                	document.getElementById('crear_grupo').disabled=true;
				                };                             
                          }                         
                  });
                              
             });
                                
      });
                          
});
	
	function confirmar()
	{
		if(confirm('¿Esta seguro de eliminar el grupo?'))
			return true;
		else
			return false;
	}
	function mostrar(id) {
        obj = document.getElementById(id);
        obj.style.display = (obj.style.display == 'none') ? '' : 'none';    
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
</body>
</html>
<script src='../assets/js/css3-animate-it.js'></script>