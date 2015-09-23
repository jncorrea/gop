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
					<?php
					//consulta para obtener si tiene partidos el usuario
					$num_grupos=0;
					 $miconexion->consulta("select id_grupo from user_grupo where id_user='".$_SESSION['id']."' ");
					$num_grupos=$miconexion->numregistros();
					if ($num_grupos==0) {
					?>
						<a href="#" onclick="mensaje_grupos();">
						<div class="col-lg-6 col-md-6 col-sm-6 mb">
								<div class="content-panel pn">
									<div id="profile-01">
										<h3>Reune, Juega y Organiza</h3>									
									</div>
									<div class="profile-01 centered">
										<p><a style="color:white"  href="#" onclick="mensaje_grupos();">MIS GRUPOS</a></p>
									</div>								
									</div>
							</div>
						</a>
					<?php
					}else{
					?>				
						<a href="perfil.php?op=listar_grupos">
						<div class="col-lg-6 col-md-6 col-sm-6 mb">
								<div class="content-panel pn">
									<div id="profile-01">
										<h3>Reune, Juega y Organiza</h3>										
									</div>
									<div class="profile-01 centered">
										<p><a style="color:white"  href="perfil.php?op=listar_grupos">MIS GRUPOS</a></p>
									</div>									
								</div>
							</div>
						</a>

					<?php
					}
					?>

					<?php
					//consulta para obtener si tiene partidos el usuario
					$num_partidos=0;
					$miconexion->consulta("select p.nombre_partido FROM partidos p, alineacion a WHERE p.id_partido = a.id_partido and a.id_user ='".$_SESSION['id']."' ");
					$num_partidos=$miconexion->numregistros();
					if ($num_partidos==0) {
					?>
						<a href="#" onclick="mensaje_partidos();">
						<div class="col-lg-6 col-md-6 col-sm-6 mb">
								<div class="content-panel pn">
									<div id="blog-bg">
										<div class="badge badge-popular"></div>
										<div class="blog-title"><a style="color:white;font-size: 23px; text-align:center;" href="#" onclick="mensaje_partidos();">MIS PARTIDOS</a></div>
									</div>

								</div>
							</div>
						</a>
					<?php
					}else{

					?>				
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
					<?php
					}
					?>											

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
                      		}else{
                      			echo "<img style='width:40px; height:40px;' src='../assets/img/user_masculino.png'/>";
                      		}
                      	}
                      	echo "</div> </div>
                      	<div class='details'>";
                      	if ($notificaciones[8]!="") {
                      		
                      		?>
                      		<div style='text-align:justify;padding-left:10px;display:inline-block;'><?php echo tiempo_transcurrido($notificaciones[6]) ?> <br>
                      		<?php
                      		echo "<strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$grupos[$notificaciones[8]]."</strong></div>";
                      	}else{                    		

                      		?>
                      		<div style='text-align:justify;padding-left:10px;display:inline-block;'><?php echo tiempo_transcurrido($notificaciones[6]) ?> <br> 
                     	<?php
                     	echo "<strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$partidos[$notificaciones[9]]."</strong></div>";
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

<?php
function tiempo_transcurrido( $date ){
    if( empty($date)){ return "No hay Fecha";}

    $periods = array("segundo", "minuto", "hora", "dia", "semana", "mes", "a&ntilde;o", "decada");
    $lengths = array("60","60","24","7","4.35","12","10");
    $now = time();
    $unix_date = strtotime( $date );
    if( empty( $unix_date ) )// check validity of date
    {
        return "Fecha inv&aacute;lida";
    }    
    if( $now > $unix_date ){ // is it future date or past date

        $difference = $now - $unix_date;
    }else {
        $difference = $unix_date - $now;
    }
    for( $j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++ ){
        $difference /= $lengths[$j];
    }
    $difference = round( $difference );
    if( $difference != 1 ){ $periods[$j].= "s"; }

    return "Hace $difference $periods[$j] ";
}
?>

<script>
  function mensaje_partidos(){
    $container = $("#container_notify").notify();  
    create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"No existen Partidos.", imagen:"../assets/img/alert.png"});  
  }

  function mensaje_grupos(){
    $container = $("#container_notify").notify();  
    create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"No existen Grupos.", imagen:"../assets/img/alert.png"});  
  }

</script>