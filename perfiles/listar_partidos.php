<?php
	date_default_timezone_set('America/Guayaquil');
	$hoy = date("Y-m-d H:i:s", time());
?>

<h3 class="page-title">
INFORMACI&Oacute;N<small> Partidos</small>
</h3>
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#col_listar_partidos" data-toggle="tab" aria-expanded="true">
		Mis Partidos </a>
	</li>
</ul>
<div class="portlet light">
	<div class="portlet-body">
		<!--BEGIN TABS-->
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1_partidos">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="portlet-title">
							<div class="caption">
								<strong>PARTIDOS POR JUGAR</strong>
							</div>
						</div>
						<?php
						//leer el json para obtener la fecha en la que vencen las reservas por confirmar.
						$datos_reservas = file_get_contents("../datos/tiempoEsperaPartidos.json");
						$json_reservas = json_decode($datos_reservas, true);
						$estado_reseva="";
					    
					    //consulta para obtener los centro deportivos
					    $num_resultados_por_jugar=0;
						$miconexion->consulta("select distinct p.id_partido, p.id_centro, p.nombre_partido, p.fecha_partido, p.hora_partido, p.hora_fin, p.estado_partido, p.id_user
        		FROM partidos p, alineacion a
        		WHERE p.id_partido = a.id_partido and a.id_user ='".$_SESSION['id']."' and TIMESTAMP(p.fecha_partido, p.hora_partido) >='".$hoy."'  ORDER BY TIMESTAMP(p.fecha_partido, p.hora_partido) ASC");
						//En este for se almacena todos los id de los centros deportivos
					$num_resultados_por_jugar=$miconexion->numregistros();
					if ($num_resultados_por_jugar>0) {
						for ($i=0; $i <$num_resultados_por_jugar; $i++) {
						$lista_id_centros=$miconexion->consulta_lista();  
						$ids_centros[$i]=$lista_id_centros[1];
					}
					//for para obtener los nombres de los centros
					for ($i=0; $i <count($ids_centros) ; $i++) { 
						$miconexion->consulta("select centro_deportivo from centros_deportivos where id_centro='".$ids_centros[$i]."'");
						$lista_nombre_centros=$miconexion->consulta_lista();
						$nombres_centros[$i]=$lista_nombre_centros[0];
					}
					}					

						$miconexion->consulta("select distinct p.id_partido, p.id_centro, p.nombre_partido, p.fecha_partido, p.hora_partido, p.hora_fin, p.estado_partido, p.id_user
        		FROM partidos p, alineacion a
        		WHERE p.id_partido = a.id_partido and a.id_user ='".$_SESSION['id']."' and TIMESTAMP(p.fecha_partido, p.hora_partido) >='".$hoy."'  ORDER BY TIMESTAMP(p.fecha_partido, p.hora_partido) ASC");
						$num_resultados_por_jugar=$miconexion->numregistros();

						if ($num_resultados_por_jugar==0) {
							echo "<br> <h4> Actualmente no existen partidos por jugar</h4>";
						}else{
							echo '<table class="table table-hover">';
							for ($i=0; $i <$num_resultados_por_jugar; $i++) {
								$grupo_partidos=$miconexion->consulta_lista();
								$estado="";
								$href="";
								if ($grupo_partidos[6]==1) {
									$estado="<strong style='color:#4CAF50;'>Activo</strong>";
									$href = "<a href='perfil.php?op=alineacion&id=".$grupo_partidos[0]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($grupo_partidos[2])."</span></a>";
									$estado_reseva="";
								}else if ($grupo_partidos[6]==0){
									$estado="<strong style='color:#D2383C;'>Cancelado</strong>";
									$href = "<a href='perfil.php?op=alineacion&id=".$grupo_partidos[0]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($grupo_partidos[2])."</span></a>";
									$estado_reseva="";
								} else if ($grupo_partidos[6]==2){
									$estado="<strong style='color:#A2A42C;'>Reserva Pendiente</strong>";
									$href = "<a data-toggle='modal' href='#infor_partido' onclick='actualizar_notificacion(31,".$grupo_partidos[0].");'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($grupo_partidos[2])."</span></a>";
									for ($r=0; $r <count($json_reservas); $r++) {
										if (@$json_reservas[$r]['id_partido']==$grupo_partidos[0]) {
											$estado_reseva= substr($json_reservas[$r]['fecha_expira'], 0, -5);
										}
									}

								} else if ($grupo_partidos[6]==3){
									$estado="<strong style='color:#D2383C;'>Reserva Rechazada</strong>";
									$href = "<a onclick='actualizar_notificacion(33,$grupo_partidos[0]);'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($grupo_partidos[2])."</span></a>";									
									$estado_reseva="";
								}
								echo "<tr >";
								if ($grupo_partidos[7]==$_SESSION['id']) {
									echo '<td class="btn-group pull-right" style="padding-left:0px; padding-right:10px;">';
									?>
									<a title="Eliminar partido" data-toggle="modal" onclick="eliminar(<?php echo $grupo_partidos[0] ?>);" href="#eliminar_partido" style="display:inline-block; background-color:transparent; margin: 0;padding: 0;">
										<i style="font-size:14px;" class="icon-remove"></i>
									</a>
									<?php 
								}else{
									echo "<td style='width:19.43px;'></td>";
									}

									if ($nombres_centros[$i]=="") {
										$nombres_centros[$i]="No se ha asignado ning&uacute;n centro deportivo.";
									}
									echo "<td style='width:40px; vertical-align:middle;'><img class='img-circle' style='width:30px; height:30px;' src='../assets/img/pupos.png'> <br> </td>";
									echo  "<td style='font-size: 12px;'><br>
										".$href."
										&nbsp; &nbsp;<br>
										Fecha: ".date('d-m-Y',strtotime($grupo_partidos[3]))."<br> Hora: ".$grupo_partidos[4]."<br>
										Centro Deportivo: ".$nombres_centros[$i]."
									<br>Estado: ".$estado."<br>";
									if ($estado_reseva!="") {
										echo "Su reserva expira: ".$estado_reseva;
									}
									
									echo "</td>";

									echo "</tr>";
								}
							}
							?>
							</table>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="portlet-title">
								<div class="caption">
									<strong>PARTIDOS JUGADOS</strong>
								</div>
							</div>
							<?php
							$num_resultados_jugados=0;
							$miconexion->consulta("select distinct p.id_partido, p.id_centro, p.nombre_partido, p.fecha_partido, p.hora_partido, p.hora_fin, p.equipo_a,
							p.equipo_b, p.res_a, p.res_b, p.id_campeonato from partidos p, alineacion a
							WHERE p.id_partido = a.id_partido and a.id_user ='".$_SESSION['id']."' and TIMESTAMP(p.fecha_partido, p.hora_partido) <'".$hoy."'
							ORDER BY TIMESTAMP(p.fecha_partido, p.hora_partido) ASC");
							$num_resultados_jugados=$miconexion->numregistros();

							
							if ($num_resultados_jugados>0) {
								for ($i=0; $i <$miconexion->numregistros(); $i++) {
								$lista_id_centros=$miconexion->consulta_lista();  
								$ids_centros[$i]=$lista_id_centros[1];
								$matriz[$i]['id_equipo_a']=$lista_id_centros[6];
								$matriz[$i]['id_equipo_b']=$lista_id_centros[7];
								}
								//for para obtener los nombres de los centros
								for ($i=0; $i <count($ids_centros) ; $i++) { 
									$miconexion->consulta("select centro_deportivo from centros_deportivos where id_centro='".$ids_centros[$i]."'");
									$lista_nombre_centros=$miconexion->consulta_lista();
									$nombres_centros[$i]=$lista_nombre_centros[0];
								}
								for ($i=0; $i <count($matriz) ; $i++) { 
									$miconexion->consulta("select nombre_grupo from grupos where id_grupo=".$matriz[$i]['id_equipo_a']."");
									@$lista_nombre_grupos=$miconexion->consulta_lista();
									$matriz_nombres[$i]['nombre_equipo_a']=$lista_nombre_grupos[0];
								}
								for ($i=0; $i <count($matriz) ; $i++) { 
									$miconexion->consulta("select nombre_grupo from grupos where id_grupo=".$matriz[$i]['id_equipo_b']."");
									@$lista_nombre_grupos=$miconexion->consulta_lista();
									$matriz_nombres[$i]['nombre_equipo_b']=$lista_nombre_grupos[0];
								}
							}
							

							$miconexion->consulta("select distinct p.id_partido, p.id_centro, p.nombre_partido, p.fecha_partido, p.hora_partido, p.hora_fin, p.equipo_a,
							p.equipo_b, p.res_a, p.res_b, p.id_campeonato from partidos p, alineacion a
							WHERE p.id_partido = a.id_partido and a.id_user ='".$_SESSION['id']."' and TIMESTAMP(p.fecha_partido, p.hora_partido) <'".$hoy."'
							ORDER BY TIMESTAMP(p.fecha_partido, p.hora_partido) ASC");

							$num_resultados_jugados=$miconexion->numregistros();
							
							if ($num_resultados_jugados==0) {
								echo "<br><h4> No se registran partidos jugados </h4>";
							}else{
								echo '<table class="table table-hover">';
								for ($i=0; $i <$num_resultados_jugados; $i++) {
									$partidos_jugados=$miconexion->consulta_lista();
									if ($partidos_jugados[8]=="") {
										$res_A="-";
									}else{
										$res_A=$partidos_jugados[8];
									}
									if ($partidos_jugados[9]=="") {
										$res_B="-";
									}else{
										$res_B=$partidos_jugados[9];
									}
									if ($nombres_centros[$i]=="") {
										$nombres_centros[$i]="No se ha asignado ning&uacute;n centro deportivo.";
									}
									echo "<tr >";
										echo "<td style='width:40px; vertical-align:middle;'><img class='img-circle' style='width:30px; height:30px;' src='../assets/img/pupos.png'> <br> </td>";
										echo  "<td style='font-size: 12px;'><br>
											<a href='perfil.php?op=alineacion&id=".$partidos_jugados[0]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($partidos_jugados[2])."</span></a>
											&nbsp; &nbsp;<br>
											Fecha: ".date('d-m-Y',strtotime($partidos_jugados[3]))."
											<br>Hora : ".$partidos_jugados[4]."
											<br>Centro Deportivo: ".$nombres_centros[$i]."";
							
									if ($partidos_jugados[10]=="") {
											echo "<br>".$partidos_jugados[6]." ( ".$res_A." ) vs. ".$partidos_jugados[7]." ( ".$res_B." ) </td>";
										}else{
											echo "<br>".$matriz_nombres[$i]['nombre_equipo_a']." ( ".$res_A." ) vs. ".$matriz_nombres[$i]['nombre_equipo_b']." ( ".$res_B." ) </td>";
										}
									echo "</tr>";

									}
								}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!--END TABS-->
		</div>
	</div>

<div class="modal fade" id="infor_partido" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Informaci&oacute;n del Partido <span id="nom_partido"></span></h4>
			</div>
			<div class="modal-body">
					<div class="row static-info">
						<div class="col-md-5 value">
							Responsable:
						</div>
						<div class="col-md-7 name" id="responsable"></div>
					</div>
					<div class="row static-info">
						<div class="col-md-5 value">
							Grupo:
						</div>
						<div class="col-md-7 name" id="grupo_partido"></div>
					</div>
					<div class="row static-info">
						<div class="col-md-5 value">
							Fecha:
						</div>
						<div class="col-md-7 name" id="fecha"></div>
					</div>
					<div class="row static-info">
						<div class="col-md-5 value">
							Hora:
						</div>
						<div class="col-md-7 name" id="hora"></div>
					</div>
					<div class="row static-info">
						<div class="col-md-5 value">
							Estado:
						</div>
						<div class="col-md-7 name" id="estado"></div>
					</div>
				</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div> 
<div class="modal fade" id="eliminar_partido" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="">Eliminar Partido</h4>
      </div>
      <div class="modal-body">
        Est&aacute; seguro de eliminar este partido?
        <br>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="del">
        <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
        <a data-toggle="modal" href="#" class="btn green-haze" style="background:#C42E35;" data-dismiss="modal" onclick="borrar();">Aceptar</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<a data-toggle='modal' href='#editar_partido' id='lanzar_editar_partido'></a>
<div class="modal fade" id="editar_partido" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	 <div class="modal-content">
	  <div class="modal-header">
	   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	   <h4 class="modal-title">Editar Partido</h4>
	  </div>
	  <div class="modal-body">
	    <?php $editar_cancelado="editar"; include("editar_evento.php"); ?>
	  </div>
	  <div class="modal-footer">
	   <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/actualizar_evento.php","form_editar_evento");'>Guardar</button>
	  </div>
	 </div>
	</div>
</div> 

<script>
function eliminar(partido){
document.getElementById("del").value=partido;
}
function borrar(){
actualizar_notificacion(26,$('#del').val());
}
function partido(partido){
	id = partido;
	alert(id);
	$.get("editar_evento.php",{ id: partido});	
	$("#lanzar_editar").trigger("click");
}
<?php 
	function identificador($iden){
		$id=$iden;
	}
 ?>
</script>