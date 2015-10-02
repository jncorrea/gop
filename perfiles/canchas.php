<link href='../assets/css/fullcalendar.css' rel='stylesheet' />
<link href='../assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='../assets/js/moment.min.js'></script>
<script src='../assets/js/fullcalendar.min.js'></script>
<script src='../assets/js/es.js'></script>
<script>
function generar_horarios() {
centro = "<?php echo $id; ?>";
$.ajax({
type: "POST",
url: "../datos/cargarCalendarioCentros.php",
data: "fecha="+fecha+"&centro="+centro,
dataType: "html",
error: function(){
alert("error petición ajax");
},
success: function(data){
mostrar_calendario(JSON.parse(data));
}
});
}
function mostrar_calendario(datos) {
$('#calendar_centros').fullCalendar({
header: {
left: 'prev,next today',
center: 'title',
right: 'month,agendaWeek,agendaDay'
},
minTime: min,
maxTime: max,
defaultDate: new Date(),
editable: false,
events: datos,
eventClick: function(calEvent, jsEvent, view) {
user = calEvent.user;
id_partido = calEvent.id;
estado = calEvent.estado;
if (estado == "1") {
document.getElementById("accion").innerHTML = '<a data-toggle="modal" href="#cancelar_reserva" class="btn green-haze" data-dismiss="modal" style="background:#CA2F37;">Cancelar Reserva</a>';
}else if(estado == "2"){
document.getElementById("accion").innerHTML = '<a data-toggle="modal" href="#rechazar_reserva" class="btn green-haze" data-dismiss="modal" style="background:#CA2F37;">Rechazar Reserva</a> <a data-toggle="modal" class="btn green-haze" data-dismiss="modal" style="background:#4CAF50;" onclick="actualizar_notificacion(25, id_partido, user);" >Aceptar Reserva</a>';
}else if(estado == "3"){
document.getElementById("accion_reserva").innerHTML = '<a data-toggle="modal" href="#bad_reserva" class="btn green-haze" data-dismiss="modal" style="background:#CA2F37;">Cancelar Reserva</a>';
}else if(estado == "4"){
document.getElementById("accion_reserva").innerHTML = '<a data-toggle="modal" class="btn green-haze" data-dismiss="modal" style="background:#4CAF50;" onclick="actualizar_notificacion(25, id_partido, user);" >Aceptar Reserva</a>';
};
if (estado == "1" || estado=="2") {
$('#ver_partido').trigger('click');
}else{
$('#ver_reserva').trigger('click');
};
}
});
}
</script>
<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="perfil.php">Home</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="perfil.php?op=canchas">Centros Deportivos</a>
		</li>
	</ul>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
		<h3 class="page-title">
		Centros Deportivos <small>Informaci&oacute;n</small>
		</h3>
		<div class="clearfix">
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<?php
				if (@$x=='nuevo') {
				?>
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bubble font-red-sunglo"></i>
							<span class="caption-subject bold uppercase" style="color: #006064;">
								NUEVA CANCHA
							</span>
							<br><span style="color: red; font-size:11px; padding:10px;">
								* Campos requeridos
							</span>
						</div>
					</div>
					<div class="portlet-body" id="chats">
						<div class="tab-content">
							<!-- CANCHA INFO TAB -->
							<form method="post" id="form_crear_cancha" enctype="multipart/form-data" class="form-group">
								<input type="hidden" name="bd" value="1">
								<div class="form-group">
									<label for="mail" class="control-label"><span style="color:red;">* </span>Nombre:</label>
									<input type="text" class="form-control" name="centro_deportivo"  placeholder="Ingrese Nombre de la cancha" required >
								</div>
								<div class="form-group">
									<label for="mail" class="control-label">Ciudad:</label>
									<select style="border-radius:5px;" name="ciudad" class="form-control">
										<option value="0" disabled="true">---Seleccione una ciudad---</option>
										<?php
										$miconexion->consulta("Select pr.id, pr.nombre, p.nombre from pais p, provincia pr where p.nombre ='Ecuador' and pr.pais = p.id");
										$miconexion->op_seleccionada(0, 1806);
										?>
									</select>
								</div>
								<div class="form-group">
									<label for="mail" class="control-label">Direcci&oacute;n:</label>
									<input type="text" class="form-control" name="direccion" placeholder="Ingrese direcci&oacute;n" >
								</div>
								<div class="form-group" style = "margin-left: -15px;">
									<div class="col-xs-12 col-sm-8">
										<label for="mail" class="control-label">Coordenandas:</label>
									</div>
									<div class="col-xs-12 col-sm-4" style="text-align:right;">
										<a style="font-size:12px;" href="#" onclick="get_pos()" id="mycoo">Obt&eacute;n tu ubicaci&oacute;n <i style= "font-size: 20px;" class="icon-map-marker" title="Obtener mis coordenadas"></i></a>
									</div>
								</div>
								<div class="form-group" style = "">
									<div class="col-xs-5 col-sm-5">
										<input type="text" class="form-control" id="latitud" name="latitud" placeholder="Latitud">
									</div>
									<div  class="col-sm-1 col-xs-1 control-label">
										<label for="horaFin"> - </label>
									</div>
									<div class="col-xs-5 col-sm-6">
										<input type="text" class="form-control" id="longitud" name="longitud" placeholder="Longitud">
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="form-group">
									<label for="mail" class="control-label">Tel&eacute;fono:</label>
									<input type="text" class="form-control" name="telef_centro" placeholder="(07)2555555 ext 134">
								</div>
								<div class="form-group">
									<label for="mail" class="control-label"><span style="color:red;">* </span>Tiempo de alquiler:</label>
									<input type="number" class="form-control" name="tiempo_alquiler" placeholder="1 hora(s)" min="1" max="16">
								</div>
								<div class="form-group">
									<label for="mail" class="control-label">Costo:</label>
									<input type="number" class="form-control" name="costo" placeholder="Ingrese el costo">
								</div>
								<div class="form-group">
									<label for="mail" class="control-label"><span style="color:red;">* </span> N&uacute;mero de Jugadores:</label>
									<input type="number" class="form-control" name="num_jugadores" placeholder="0" min="1">
								</div>
								<div class="form-group">
									<label class="control-label">Informaci&oacute;n adicional:</label>
									<textarea class="form-control" name="informacion" placeholder="Informacion adicional..."> </textarea>
								</div>
								<div class="form-group">
									<label for="mail" class="control-label">Foto del centro:</label>
									<input type="file" class="form-control" name="foto_centro" >
								</div>
								<div class="form-group">
									<div class="margiv-top-10">
										<button type="button" class="btn green-haze" onclick='enviar_form("../include/insertar_cancha.php","form_crear_cancha");' style="background:#4CAF50;">Guardar y Continuar</button>
									</div>
								</div>
							</form>
							<!-- END CANCHA INFO TAB -->
						</div>
					</div>
				</div>
				<?php }else if(@$x=='horario'){
				?>
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bubble font-red-sunglo"></i>
							<span class="caption-subject bold uppercase" style="color: #006064;">
								HORARIOS DE ATENCI&Oacute;N
							</span>
							<br><span style="color: red; font-size:11px; padding:10px;">
								* Campos requeridos <br>
								<div id="advertencia" style="display:none;">
									Estimado usuario, debe establecer al menos un horario para que su centro pueda estar disponible para reservas, en caso de no hacerlo en este momento puede editar su centro en un futuro.
								</div>
							</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="tab-content">
							<!-- CANCHA INFO TAB -->
							<form method="post" id="form_crear_horario" enctype="multipart/form-data" class="form-group">
								<input type="hidden" name="bd" value="2">
								<input type="hidden" name="i" value="<?php echo $_GET['id'] ?>">
								<div class="form-group" id="dias">
									<label for="dia" class="control-label"><span style="color:red;">* </span>D&iacute;a:</label>
									<select style="border-radius:5px;" class="form-control" name="dia" id="dia" onchange="horario(1);">
									<optgroup label="Seleccione un d&iacute;a"></optgroup>
									<option value="Todos">Todos los d&iacute;as (Lunes a Domingo)</option>
									<option value="Domingo">Domingo</option>
									<option value="Lunes">Lunes</option>
									<option value="Martes">Martes</option>
									<option value="Miercoles">Miercoles</option>
									<option value="Jueves">Jueves</option>
									<option value="Viernes">Viernes</option>
									<option value="Sabado">Sabado</option>
								</select>
							</div>
							<div id="res_horario"></div>
							<div class="form-group">
								<label for="hora_inicio"><span style="color:red;">* </span>Hora de Inicio: </label>
								<input type="text" class="time form-control" id="horaIni" name="hora_inicio" data-scroll-default="07:00:00" placeholder="07:00:00" required>
							</div>
							<div class="form-group">
								<label for="hora_fin"><span style="color:red;">* </span>Hora Fin: </label>
								<input type="text" class="time form-control" id="horaFin" name="hora_fin" data-scroll-default="23:00:00" placeholder="23:00:00" required>
							</div>
							<div class="form-group" style="padding-bottom:60px;">
								<div class="margiv-top-10">
									<button type="button" class="btn green-haze" onclick='enviar_form("../include/insertar_cancha.php","form_crear_horario");' style="background:#01579B; float: right; border-radius: 50% !important; margin-right:20px;" title="A&ntilde;adir horario"><i class="icon-plus"></i></button>
								</div>
							</div>
							<script>
								$(function() {
									$('#horaIni').timepicker({ 'timeFormat': 'H:i:s' });
									$('#horaFin').timepicker({ 'timeFormat': 'H:i:s' });
								});
							</script>
							<script>
								$(function() {
									$('#basicExample1').timepicker();
								});
							</script>
						</form>
						<!-- END CANCHA INFO TAB -->
						<div id="col_tabla_horario"></div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="edit" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Editar Horario</h4>
						</div>
						<div class="modal-body">
							<form method="post" id="form_editar_horario" enctype="multipart/form-data" class="form-group">
								<input type="hidden" name="bd" value="3">
								<input type="hidden" name="centro" value="<?php echo $id ?>">
								<input type="hidden" name="id_horario" id="horarioEdit">
								<div class="form-group" id="dias">
									<label for="dia" class="control-label" id="diaEdit"></label>
								</div>
								<div id="res_horario"></div>
								<div class="form-group">
									<label for="hora_inicio">Hora de Inicio: </label>
									<input style="z-index: 100000;" type="text" class="time form-control" id="horaIniEdit" name="hora_inicio" data-scroll-default="07:00:00" placeholder="07:00:00" required>
								</div>
								<div class="form-group">
									<label for="hora_fin">Hora Fin: </label>
									<input style="z-index: 100000;" type="text" class="time form-control" id="horaFinEdit" name="hora_fin" data-scroll-default="23:00:00" placeholder="23:00:00" required>
								</div>
								<script>
								$(function() {
								$('#horaIniEdit').timepicker({ 'timeFormat': 'H:i:s', template: 'modal' });
								$('#horaFinEdit').timepicker({ 'timeFormat': 'H:i:s', template: 'modal' });
								});
								</script>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
							<button type="button" class="btn green-haze" onclick='enviar_form("../include/insertar_cancha.php","form_editar_horario");'>Guardar Cambios</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<?php
			}elseif(@$x=='calendar'){
				$miconexion->consulta("Select * from centros_deportivos where id_centro = ".@$id);
				$calendario = $miconexion->consulta_lista();
			?>
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-bubble font-red-sunglo"></i>
						<span class="caption-subject bold uppercase" style="color: #006064;">
							<?php echo strtoupper($calendario[2]) ?>
						</span>
					</div>
					<div class="caption" style="float:right;">
						<a href="perfil.php?op=canchas&id=<?php echo $id ?>" style="z-index:4;font-size:15px; color: #006064; padding-left: 30px;;" title="Ver cancha"><i style="font-size:130%" class=" icon-map-marker"></i></a>
					</div>
				</div>
				<div class="portlet-title" style="font-size:50%;">
					<div class="caption" style="font-size:200%;">
						<ul>
							<li style="color:#4CAF50; list-style-type: square;">Horas Disponibles</li>
							<li style="color:#A2A42C; list-style-type: square;">Reservas Pendientes</li>
							<li style="color:#D2383C; list-style-type: square;">Reservas Aceptadas</li>
						</ul>
					</div>
					<div class="btn-group pull-right caption" style="font-size:170%;">
						<button aria-expanded="false" style="width:100%; display:inline-block; margin-bottom:1%;"  type="button" class="btn btn-sm btn-success dropdown-toggle hover-initialized" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
						<i class="icon-cogs "></i> Herramientas <i class="icon-angle-down"></i>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li>
								<a data-toggle="modal" href='#crear_reserva' style="z-index:4; width:100%; display:inline-block; margin-bottom:1%;" class="btn btn-default">
									Crear Reserva  <i class=" icon-calendar-empty"></i>
								</a>
							</li>
							<li>
								<a class="btn btn-default" onclick="calendario_centro();" style="width:100%; display:inline-block; margin-bottom:1%; cursor:pointer; cursor: hand;">Actualizar Calendario <i class=" icon-refresh"></i></a>
							</a>
						</li>
					</ul>
				</div>
				<div class="caption" style="float:right;">
				</div>
			</div>
			
			<div class="portlet-body">
				<div id='calendar_centros'></div>
			</div>
		</div>
		<?php } else {?>
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject bold uppercase" style="color: #006064;">
						<?php
						if (@$id==0) {
							echo "CENTROS DEPORTIVOS";
						}else{
							$miconexion->consulta("select * from centros_deportivos where id_centro = '".$id."'");
							$centro=$miconexion->consulta_lista();
							echo $centro[2];
							$dias=['','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];
							$dia = date("N", time());
							$hora = date("H:i:s", time());
							$estado = 0;
							$miconexion->consulta("select * from horarios_centros where id_centro = '".$id."' and dia = '".$dias[$dia]."'");
							for ($j=0; $j < $miconexion->numregistros(); $j++) {
								$horario = $miconexion->consulta_lista();
								if (($hora >= $horario[3]) AND ($hora<=$horario[4])) {
									$estado = 1;
								}
							}
							if ($estado == 1) {
								echo ' (<i class="icon-time" style="color:#4CAF50; font-size:14px;"><span style="color: #006064;  font-size:10px; text-transform: lowercase;"> actualmente Se encuentra abierto <span></i>)';
								}else if ($estado == 0) {
									echo ' (<i class="icon-time" style="color:#006064; font-size:14px;"><span style="color: #006064; font-size:10px; text-transform: lowercase;"> actualmente se encuentra cerrado <span></i>)';
									}
									$admin=$_SESSION['id'];
									if (@$centro[1]==$admin) {
								?>
								<a title="Calendario de reservas" href="perfil.php?op=canchas&x=calendar&id=<?php echo $id ?>"  onblur="calendario_centro();" style="z-index:4;font-size:15px;"><i style="font-size:130%" class="icon-calendar-empty"></i></a>
								<a title="Editar Cancha" href="perfil.php?op=editar_cancha&id=<?php echo $id ?>" style="z-index:4;font-size:15px;"><i style="font-size:130%" class="icon-pencil"></i></a>
								<?php }
								}?>
							</span>
						</div>
						<div class="caption" style="float:right;">
							<?php
							$miconexion->consulta("select * from centros_favoritos where id_centro = '".@$id."' and id_user = '".$_SESSION['id']."'");
							$num = $miconexion->numregistros();
							if(@$id!=0){
							if($num != 0) { ?> <!--Caso favorito-->
							<i id="centro_favorito" class="icon-star" title="Quitar como Favorito" style="color:#FFC400; font-size: 20px; cursor: pointer;" onclick = "actualizar_notificacion('9','<?php echo $id; ?>','<?php echo $_SESSION['id']; ?>');"></i>
							<?php }else{ ?> <!--Caso no favorito-->
							<i id="centro_favorito" class="icon-star-empty" title="Marcar como Favorito" style="font-size: 20px; cursor: pointer;" onclick = "actualizar_notificacion('10','<?php echo $id; ?>','<?php echo $_SESSION['id']; ?>');"></i>
							<?php }
							}?>
							<div id="respuesta"></div>
						</div>
					</div>
					<div class="portlet-body" id="chats">
						<?php if (@$id==0) {
							echo '<div class="scroller" style="height: 441px;" data-always-visible="1" data-rail-visible1="1">
												<div id="cancha_map" style="width:100%; height: 441px;">
																</div>';
							}else{
								echo '<div class="scroller" style="height: 941px;" data-always-visible="1" data-rail-visible1="1">
																		<div id="cancha_map" style="width:100%; height: 441px;">
									</div>
									<div style="width:100%; height: 100px; padding-top: 2em; font-size:13px;">
											<h3 style="font-size:14px; color:#4CAF50; font-weight: bold;">INFORMACI&Oacute;N</h3>';
											$miconexion->consulta("select c.direccion, p.nombre, pa.nombre, u.nombres, u.apellidos, u.email, c.telef_centro, c.tiempo_alquiler,
											c.costo, c.num_jugadores, c.informacion FROM centros_deportivos c, usuarios u, provincia p, pais pa
											where c.id_user = u.id_user and pa.id = p.pais AND c.ciudad = p.id AND c.id_centro = '".@$id."'");
											$centro=$miconexion->consulta_lista();
											$cont = 0;
											@$cont = $miconexion->numregistros();
											echo "<div class='table-responsive'><table class='table'>
												<tbody>";
													echo '<tr><td><strong>Direcci&oacute;n </strong></td><td>'.$centro[0].' ('.$centro[1].', '.$centro[2].')</td></tr>';
													echo '<tr><td><strong>Contactos </strong></td><td>'.$centro[3].' '.$centro[4].' <br>'.$centro[5].'<br>'.$centro[6].'</td></tr>';
													echo '<tr><td><strong>Costo por '.number_format($centro[7], 0).' hora(s) </strong></td><td> $'.number_format($centro[8], 2).'</td></tr>';
																						echo '<tr><td><strong>Recomendaci&oacute;n por partido </strong></td><td>'.number_format($centro[9], 0).' jugadores</td></tr>';
													if ($centro[10] != Null) {
														echo '<tr><td><strong>Informaci&oacute;n adicional</strong></td><td>'.$centro[10].'</td></tr>';
													}
													
													$miconexion->consulta("select dia, hora_inicio, hora_fin FROM horarios_centros where id_centro = '".@$_GET['id']."' order by hora_inicio");
													$horario_centro=$miconexion->consulta_lista();
													if ($miconexion->numregistros() == 0) {
														echo '<tr><td><strong>Horarios de Atenci&oacute;n</strong></td>';
														echo'<td>No se indicado un horario de atenci&oacute;n</td></tr>';
													}else {
														echo '<tr>
																	<td colspan="2" style="text-align: center;"><strong>Horario de Atenci&oacute;n</strong></td>
															</tr>';
														$d=0; $l =0; $m = 0; $mi = 0; $j=0; $v =0; $s =0;
														for ($n=0; $n <@$miconexion->numregistros(); $n++) {
															if ($horario_centro[0]=="Domingo") {
																$domingo[$d] = array($horario_centro[0], $horario_centro[1], $horario_centro[2]);
																$d++;
															}if ($horario_centro[0]=="Lunes") {
																$lunes[$l] = array($horario_centro[0], $horario_centro[1], $horario_centro[2]);
																$l++;
															}if ($horario_centro[0]=="Martes") {
																$martes[$m] = array($horario_centro[0], $horario_centro[1], $horario_centro[2]);
																$m++;
															}if ($horario_centro[0]=="Miercoles") {
																$miercoles[$mi] = array($horario_centro[0], $horario_centro[1], $horario_centro[2]);
																$mi++;
															}if ($horario_centro[0]=="Jueves") {
																$jueves[$j] = array($horario_centro[0], $horario_centro[1], $horario_centro[2]);
																$j++;
															}if ($horario_centro[0]=="Viernes") {
																$viernes[$v] = array($horario_centro[0], $horario_centro[1], $horario_centro[2]);
																$v++;
															}if ($horario_centro[0]=="Sabado") {
																$sabado[$s] = array($horario_centro[0], $horario_centro[1], $horario_centro[2]);
																$s++;
															}
															$horario_centro=$miconexion->consulta_lista();
														}
														horario_aten(@$domingo);
														horario_aten(@$lunes);
														horario_aten(@$martes);
														horario_aten(@$miercoles);
														horario_aten(@$jueves);
														horario_aten(@$viernes);
														horario_aten(@$sabado);
													}
												echo "</tbody>
												</table></div>";
									echo '</div>';
								};
								?>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div id="alerta"></div>
		<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
			<h4>USUARIOS CONECTADOS</h4>
			<ul style="color:#ffff; list-style: none; padding:0px;">
				<div id = "col_chat"></div>
			</ul>
		</div>
	</div>
	<a data-toggle="modal" href="#info_partido" id="ver_partido" style="z-index:4; font-size:15px;" onclick="actualizar_notificacion(22,id_partido);"></a>
	<div class="modal fade" id="info_partido" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title" id="nom_partido">Info Partido</h4>
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
					<a type="button" id ="accion"></a>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<a data-toggle="modal" href="#info_reserva" id="ver_reserva" style="z-index:4; font-size:15px;" onclick="actualizar_notificacion(27,id_partido);"></a>
	<div class="modal fade" id="info_reserva" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title" id="nom_partido">Info. Reserva</h4>
				</div>
				<div class="modal-body">
					<div class="row static-info">
						<div class="col-md-5 value">
							Motivo:
						</div>
						<div class="col-md-7 name" id="motivo"></div>
					</div>
					<div class="row static-info">
						<div class="col-md-5 value">
							Fecha:
						</div>
						<div class="col-md-7 name" id="fecha_reserva"></div>
					</div>
					<div class="row static-info">
						<div class="col-md-5 value">
							Hora:
						</div>
						<div class="col-md-7 name" id="hora_reserva"></div>
					</div>
					<div class="row static-info">
						<div class="col-md-5 value">
							Estado:
						</div>
						<div class="col-md-7 name" id="estado_reserva"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
					<a type="button" id ="accion_reserva"></a>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<div class="modal fade" id="cancelar_reserva" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title" id="nom_partido">Cancelar Reserva</h4>
				</div>
				<div class="modal-body">
					Est&aacute; seguro de cancelar esta reserva?
					<br>
					<p style="font-size:90%;">
						Se notificara al due&ntilde;o del partido de esta cancelaci&oacute;n.
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
					<a data-toggle="modal" href="#cancelar_reserva" class="btn green-haze" style="background:#C42E35;" onclick="actualizar_notificacion(23,id_partido,user);">Aceptar</a>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<div class="modal fade" id="bad_reserva" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Cancelar Reserva</h4>
				</div>
				<div class="modal-body">
					Est&aacute; seguro de cancelar esta reserva?
				</div>
				<div class="modal-footer">
					<button type="button" id="cerrar_reserva" class="btn default" data-dismiss="modal">Cerrar</button>
					<a data-toggle="modal" class="btn green-haze" style="background:#C42E35;" onclick="actualizar_notificacion(28,id_partido);">Aceptar</a>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<div class="modal fade" id="rechazar_reserva" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Rechazar Reserva</h4>
				</div>
				<div class="modal-body">
					Est&aacute; seguro de rechazar esta reserva?
				</div>
				<div class="modal-footer">
					<button type="button" id="cerrar_rechazar_reserva" class="btn default" data-dismiss="modal">Cerrar</button>
					<a data-toggle="modal" class="btn green-haze" data-dismiss="modal" style="background:#C42E35;" onclick="actualizar_notificacion(29,id_partido,user);">Aceptar</a>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<div class="modal fade" id="crear_reserva" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Crear Reserva</h4>
				</div>
				<div class="modal-body">
					<?php include("crear_reserva.php"); ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" id="cerrar_crear_reserva" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/insertar_reserva.php","form_crear_reserva");'>Crear Reserva</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<script>
	horario(1);
	function horario(op, n_dia, id_horario){
	if (op==1) {
	dia = $("#dia").val();
	}else{
	dia = n_dia;
	};
	
	centro = "<?php echo @$_GET['id']; ?>";
	$.ajax({
	type: "POST",
	url: "../include/disponibilidad.php",
	data: "dia="+dia+"&centro="+centro+"&op="+op+"&id_horario="+id_horario,
	dataType: "html",
	error: function(){
	alert("error petición ajax");
	},
	success: function(data){
	$("#res_horario").html(data);
	n();
	}
	});
	}
	function calendario_centro(){
	$('#calendar_centros').fullCalendar('destroy');
	centro = "<?php echo $id ?>";
	fecha = new Date;
	$.ajax({
	type: "POST",
	url: "../include/disponibilidad.php",
	data: "fecha="+fecha+"&centro="+centro+"&op=4",
	dataType: "html",
	error: function(){
	alert("error petición ajax");
	},
	success: function(data){
	$("#alerta").html(data);
	}
	});
	}
	calendario_centro();
	</script>
	<?php
		function horario_aten($array){
			for ($i=0; $i < count($array); $i++) {
				if ($i==0) {
					echo '
					<tr>
							<td rowspan = "'.count($array).'" style="text-align:left; vertical-align: middle;"><strong>'.$array[$i][0].'</strong></td>
							<td>'.$array[$i][1].' - '.$array[$i][2].'</td>
						';
					echo'</tr>';
				}else {
					echo '<tr>
							<td>'.$array[$i][1].' - '.$array[$i][2].'</td>';
					echo'</tr>';
				}
			}
		}
	?>
	<!-- END DASHBOARD STATS -->