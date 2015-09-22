  <?php 


header('Content-Type: text/html; charset=ISO-8859-1');
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
date_default_timezone_set('America/Guayaquil');
session_start();
extract($_GET);

date_default_timezone_set('America/Guayaquil');

$hoy = date("Y-m-d H:i:s", time());
?>

<h3 class="page-title">
    &#62;&#62; INICIO<small> </small>
</h3>
		
		<div class="portlet light">
			
		<div class="portlet-body">
			 
                   
          	<div class="row mt">
          		<div class="col-lg-12">
          		
					<div class="row">
						<! -- TODO PANEL -->

					<a href="perfil.php?op=listar_grupos">

					<div class="col-lg-6 col-md-6 col-sm-6 mb">
							<div class="content-panel pn">
								<div id="profile-01">
									<h3>Reune, Juega y Organiza</h3>
									
								</div>
								<div class="profile-01 centered">
									<p><a style="color:white"  href="perfil.php?op=listar_grupos">MIS GRUPOS</a></p>

								</div>
								
							</div><! --/content-panel -->
						</div>
						</a>

					<a href="perfil.php?op=listar_partidos">
					<div class="col-lg-6 col-md-6 col-sm-6 mb">
							<div class="content-panel pn">
								<div id="blog-bg">
									<div class="badge badge-popular"></div>
									<div class="blog-title"><a style="color:white;font-size: 23px; text-align:center;" href="perfil.php?op=listar_partidos">MIS PARTIDOS</a></div>
								</div>

							</div>
						</div>
					</a>											

						<!--/ col-md-4 -->
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 ds">					  	                 
					<h3>&Uacute;LTMAS NOTICIAS</h3>

					<?php
					$miconexion->consulta("select id_grupo, nombre_grupo FROM grupos");
						for ($i=0; $i < $miconexion->numregistros(); $i++) { 
						  $datos=$miconexion->consulta_lista();
						  $grupos[$datos[0]]=$datos[1]; 
						}
					$miconexion->consulta("select id_partido, nombre_partido FROM partidos");
						for ($i=0; $i < $miconexion->numregistros(); $i++) { 
						  $datos=$miconexion->consulta_lista();
						  $partidos[$datos[0]]=$datos[1]; 
						}

					 $miconexion->consulta("select u.user, u.avatar, u.sexo, n.responsable ,n.id_user, n.mensaje, n.fecha_not, n.visto, n.id_grupo, n.id_partido, n.id_noti FROM notificaciones n, usuarios u where n.responsable = u.id_user and n.id_user = '".$_SESSION['id']."'");
			          for ($i=0; $i < $miconexion->numregistros(); $i++) { 
			            $notificaciones=$miconexion->consulta_lista();             
			            echo "<div class='desc'>
                      	<div class='thumb'>";
                      	echo "<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;display:inline-block;'>" ;
                      	
                      	if ($notificaciones[1]!="") {
                      		echo "<img style='width:40px; height:40px;' src='images/".$notificaciones[0].$notificaciones[1]."'/>";
                      	}else{
                      		if ($notificaciones[2]=="Femenino") {
                      			echo "<img style='width:40px; height:40px;' src='../assets/img/user_femenino.png'/>";
                      		}elseif ($notificaciones[2]=="Masculino") {
                      			echo "<img style='width:40px; height:40px;' src='../assets/img/user_masculino.png'/>";
                      		}
                      	}
                      	echo "</div> </div>
                      	<div class='details'>";
                      	if ($notificaciones[8]!="") {
                      		echo "<div style='text-align:justify;padding-left:10px;display:inline-block;'>Hace 1 dia: <br> <strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$grupos[$notificaciones[8]]."</strong></div>";
                      	}else{
                      		echo "<div style='text-align:justify;padding-left:10px;display:inline-block;'>Hace 1 dia: <br> <strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$partidos[$notificaciones[9]]."</strong></div>";
                      	
                      	}
                      	echo "</div>
                      </div>";	
			          } 
					
					?>					
					  
                  </div>
							
	                      	</div>
                      	</div><!-- /col-md-4-->
  
                    </div><!-- /END CHART - 4TH ROW OF PANELS -->
                 
          		</div>
          	</div>

		</div>
</div> 

