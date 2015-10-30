  <?php 
if (@$_SESSION['mi_primer_acceso']=="hoy"){  
  echo "<script>location.href = 'perfil.php?op=configurar';</script>";
}

extract($_GET);

date_default_timezone_set('America/Guayaquil');

$hoy = date("Y-m-d H:i:s", time());
?>

<h3 class="page-title">
<small> </small>
</h3>
<div class="portlet light">
	<div class="portlet-body">
		<div class="row mt">
			<div class="col-lg-12">
				<div class="row">
					<?php
					//consulta para obtener si tiene partidos el usuario
					$num_grupos=0;
					$miconexion->consulta("select g.nombre_grupo, g.id_grupo from grupos g, user_grupo gm where g.id_grupo=gm.id_grupo and gm.id_user='".$_SESSION['id']."' ");
					$num_grupos=$miconexion->numregistros();
					if ($num_grupos==0) {
					?>
					<a href="#" onclick="mensaje_grupos();">
						<div class="col-lg-6 col-md-6 col-sm-6 mb">
							<div class="content-panel pn">
								<div id="profile-01">
								</div>
								<div class="profile-01 centered">
									<p><a style="color:white"  href="#" onclick="mensaje_grupos();">MIS GRUPOS</a></p>
								</div>
							</div>
						</div>
					</a>
					<?php
					}else{
						if ($num_grupos>=4) {
							$num_grupos=4;
							
						}
					?>
					<a href="perfil.php?op=listar_grupos">
						<div class="col-lg-6 col-md-6 col-sm-6 mb">
							<div class="content-panel pn">
								<div id="profile-01">
								</div>
								<div class="blog-title">
									<?php
									for ($i=0; $i <$num_grupos ; $i++) {
									$ultimos_grupos=$miconexion->consulta_lista();
										echo '<a style="color:white;font-size: 30px; text-align:center;" href="perfil.php?op=grupos&id='.$ultimos_grupos[1].'"> <i class="icon-group">  '.strtoupper($ultimos_grupos[0]).' </i> </a> <br>';
									}
									?>
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
					$miconexion->consulta("select p.id_partido, p.nombre_partido FROM partidos p, alineacion a WHERE p.id_partido = a.id_partido and a.id_user ='".$_SESSION['id']."' ");
					$num_partidos_cualquier_estado=$miconexion->numregistros();
					$miconexion->consulta("select p.id_partido, p.nombre_partido FROM partidos p, alineacion a WHERE p.id_partido = a.id_partido and a.id_user ='".$_SESSION['id']."' and p.estado_partido ='1' ");
					$num_partidos=$miconexion->numregistros();
					if ($num_partidos>=4) {
						$num_partidos=4;
						# code...
					}
					if ($num_partidos_cualquier_estado==0) {
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
									<div class="profile-01 centered">
										<p><a style="color:white"  href="perfil.php?op=listar_partidos">MIS PARTIDOS</a></p>
									</div>
									<div class="blog-title-2">
										<?php
										for ($i=0; $i <$num_partidos ; $i++) {
											$ultimos_partidos=$miconexion->consulta_lista();
											echo '<a style="color:white;font-size: 25px; text-align:center;" href="perfil.php?op=alineacion&id='.$ultimos_partidos[0].'"> <i class="icon-gamepad"> '.strtoupper($ultimos_partidos[1]).'</i> </a> <br>';
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</a>
					<?php
					}
					?>
					<!--/ col-md-4 -->
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 ds" >
					<h3>&Uacute;LTIMAS NOTIFICACIONES</h3>
					<?php
					// echo '<img class="img-circle" style="width:55px; height:55px; display:inline-block; " src="../assets/img/no_data.png"/>';
					?>
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

					$miconexion->consulta("select id_campeonato, nombre_campeonato FROM campeonatos");
					for ($i=0; $i < $miconexion->numregistros(); $i++) { 
					  $datos=$miconexion->consulta_lista();
					  $campeonato[$datos[0]]=$datos[1]; 
					}

					$miconexion->consulta("select u.user, u.avatar, u.sexo, n.responsable ,n.id_user, n.mensaje, n.fecha_not, n.visto, n.id_grupo, n.id_partido, n.id_noti, n.tipo, n.id_campeonato FROM notificaciones n, usuarios u where n.responsable = u.id_user and n.id_user = '".$_SESSION['id']."' ORDER BY n.fecha_not DESC");
					$cont_noticias=$miconexion->numregistros();
					if ($cont_noticias==0) {
					echo '<br> <div class="col-lg-4 col-md-1 col-sm-1 col-xs-1"></div><div class="col-lg-8 col-md-6 col-sm-6 col-xs-6"><img class="img-circle" style="width:55px; height:55px; display:inline-block; " src="../assets/img/no_data.png"/> No hay noticias</div>';
					}else{


					for ($i=0; $i < $cont_noticias; $i++) {
					$notificaciones=$miconexion->consulta_lista();
					echo "<div class='desc'>
							<div class='thumb'>";
								echo "<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' style='padding-left:0px;display:inline-block;'>" ;
									
								if ($notificaciones[11]=="reserva_expirada") {
									echo "<img style='width:40px; height:45px;' src='../assets/img/denegado.png'/>";
								}else{
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
								}
								echo "</div> </div>
								<div class='details'>";
								if ($notificaciones[11]=="reserva_expirada") {
									?>
										<div style='text-align:justify;padding-left:8px;display:inline-block;'><?php //echo tiempo1_transcurrido($notificaciones[6]) <br> ?>
											<?php
										echo "<strong> ".strtoupper($partidos[$notificaciones[9]])."<br> </strong><h5 style='color:black; font-size: 12px; ;'>".utf8_decode($notificaciones[5])."</h5></div>";
										echo "</div>";
								
								}else{

								
								if ($notificaciones[0]==$_SESSION['user']) {
										$notificaciones[0]="Usted";
									}
									if ($notificaciones[8]!="") {
										
										?>
										<div style='text-align:justify;padding-left:10px;display:inline-block;'><?php echo tiempo_transcurrido($notificaciones[6]) ?> <br>
											<?php
										echo "<strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$grupos[$notificaciones[8]]."</strong></div>";
									}elseif ($notificaciones[9]!=="") {
																				
										?>
										<div style='text-align:justify;padding-left:10px;display:inline-block;'><?php echo tiempo_transcurrido($notificaciones[6]) ?> <br>
											<?php
										echo "<strong> ".$notificaciones[0]." </strong>".utf8_decode($notificaciones[5])." <strong>".$partidos[$notificaciones[9]]."</strong></div>";
									}
										echo "</div>";

									}
									echo "</div>";
									}
									}
									?>
					</div>
					
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