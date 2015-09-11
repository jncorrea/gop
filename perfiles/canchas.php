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
				<div class="col-md-3 col-sm-3">
					<!-- BEGIN PORTLET-->
					<div class="portlet light ">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-bubble font-red-sunglo"></i>
								<span class="caption-subject bold uppercase" style="font-size:12px; color:#4CAF50;">Centros Deportivos Disponibles</span>
							</div>
						</div>
						<div class="portlet-body" id="chats">
							<div class="scroller" style="height: 441px;" data-always-visible="1" data-rail-visible1="1">
								<ul id="cancha" style="padding-left:0; font-size:14px;">
									<li style="list-style: none; text-align:left;">
										<a href="perfil.php?op=canchas&x=nuevo">
											<i class="icon-plus" style="padding: 10px 15px; font-size:18px;"></i>
											<span class="title">Nueva Cancha</span>
										</a>
									</li>
									<li style="list-style: none; text-align:left;">
										<a href="perfil.php?op=canchas">
											<i class="icon-map-marker" style="padding: 10px 15px; font-size:18px;"></i>
											<span class="title">Todas</span>
										</a>
									</li>
									<?php 
									$miconexion->consulta("select * from centros_deportivos");
									for ($i=0; $i < $miconexion->numregistros(); $i++) { 
										$lista=$miconexion->consulta_lista();
										echo '<li style="list-style: none; text-align:left;">
										<a href="perfil.php?op=canchas&id='.$lista[0].'">
											<i class="icon-map-marker" style="padding: 10px 15px; font-size:18px;"></i>
											<span class="title">'.$lista[2].'</span>
										</a>
									</li>';
								}
								?>
							</ul>
						</div>
					</div>
				</div>
				<!-- END PORTLET-->
			</div>
			<div class="col-md-9 col-sm-9">
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
								<input type="hidden" name="bd" value="centros_deportivos">
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
										$miconexion->opciones(1);
										?>
									</select>
								</div>
								<div class="form-group">
									<label for="mail" class="control-label">Direcci&oacute;n:</label>
									<input type="text" class="form-control" name="direccion" placeholder="Ingrese direcci&oacute;n" >            
								</div>
								<div class="form-group" style = "margin-left: -15px;">
									<div class="col-xs-8 col-sm-8">
										<label for="mail" class="control-label">Coordenandas:</label>
									</div>
									<div class="col-xs-4 col-sm-4" style="text-align:right;">
										<a href="#" onclick="get_pos()" id="mycoo"><i class="icon-map-marker" title="Obtener mis coordenadas"></i></a>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="form-group" style = "margin-top: -15px; margin-left: -15px; margin-right: -15px; margin-bottom: 15px; ">
									<div class="col-xs-5 col-sm-5">
										<input type="text" class="form-control" id="latitud" name="latitud" placeholder="Latitud">
									</div>
									<label for="horaFin" class="col-sm-1 col-xs-1 control-label"> - </label>
									<div class="col-xs-6 col-sm-6">
										<input type="text" class="form-control" id="longitud" name="longitud" placeholder="Longitud">
									</div>
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
								* Campos requeridos
							</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="tab-content">	
							<!-- CANCHA INFO TAB -->
							<form method="post" id="form_crear_horario" enctype="multipart/form-data" class="form-group">
								<input type="hidden" name="bd" value="2">
								<input type="hidden" name="i" value="<?php echo $_GET['i'] ?>">
								<div class="form-group">
									<div class="task-checkbox">
										<div class="checker">
											<span>
												<input type="checkbox" class="liChild" checked value="1" onchange="mostrar('dias');" name="todos"> Establecer el mismo horario para todos los dias (Lunes a Domingo)
											</span>
										</div>
									</div>
								</div>
								<div class="form-group" id="dias" style="display: none;">
									<label for="dia" class="control-label">D&iacute;a:</label>
									<select style="border-radius:5px;" class="form-control" name="dia">
										<optgroup label="Seleccione un d&iacute;a"></optgroup>
										<option value="Domingo">Domingo</option>
										<option value="Lunes">Lunes</option>
										<option value="Martes">Martes</option>
										<option value="Miercoles">Miercoles</option>
										<option value="Jueves">Jueves</option>
										<option value="Viernes">Viernes</option>
										<option value="Sabado">Sabado</option>
									</select>
								</div>
								<div class="form-group">
									<label for="hora_inicio">Hora de Inicio: </label>
									<input type="text" class="time form-control" id="horaIni" name="hora_inicio" data-scroll-default="07:00:00" placeholder="07:00:00" required>
								</div>
								<div class="form-group">
									<label for="hora_fin">Hora Fin: </label>
									<input type="text" class="time form-control" id="horaFin" name="hora_fin" data-scroll-default="23:00:00" placeholder="23:00:00" required>
								</div>
								<div class="form-group" style="padding-bottom:60px;">
									<div class="margiv-top-10">
										<button type="button" class="btn green-haze" onclick='enviar_form("../include/insertar_cancha.php","form_crear_horario");' style="background:#4CAF50; float: right;"><i class="icon-plus"> A&ntilde;adir horario</i></button>
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
				<?php
				}else{?>
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject bold uppercase" style="color: #006064;">
								<?php
								if (@$id==0) {
									echo "CENTROS DEPORTIVOS";
								}else{
									$miconexion->consulta("select * from centros_deportivos where id_centro = '".$id."'");
									$lista=$miconexion->consulta_lista();
									echo $lista[2];
									$dias=['','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];
									$dia = date("N", time());
									$hora = date("H:i:s", time());
									$estado = 0;
									$miconexion->consulta("select * from horarios_centros where id_centro = '".$id."' and (dia = '".$dias[$dia]."' OR dia = 'Todos')");
									for ($j=0; $j < $miconexion->numregistros(); $j++) { 
										$horario = $miconexion->consulta_lista();
										if (($hora >= $horario[3]) AND ($hora<=$horario[4])) {
											$estado = 1;
										}
									}
									if ($estado == 1) {
										echo ' (<i class="icon-circle" style="color:#4CAF50; font-size:11px;"><span style="color: #006064;  text-transform: capitalize;"> Abierto <span></i>)';
									}else if ($estado == 0) {
										echo ' (<i class="icon-circle-blank" style="color:#006064; font-size:11px;"><span style="color: #006064;  text-transform: capitalize;"> Cerrado <span></i>)';
									}
									$admin=$_SESSION['id'];
									if (@$lista[1]==$admin) {
										?>									
										<a title="Administrar Reservas" href="#" style="z-index:4;font-size:15px;"><i style="font-size:130%" class="icon-calendar-empty"></i></a>
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
								echo '<div class="scroller" style="height: 341px;" data-always-visible="1" data-rail-visible1="1">
								<div id="cancha_map" style="width:100%; height: 341px;">								
								</div>';								
							}else{
								echo '<div class="scroller" style="height: 641px;" data-always-visible="1" data-rail-visible1="1">
								<div id="cancha_map" style="width:100%; height: 341px;">								
								</div>
								<div style="width:100%; height: 100px; padding-top: 2em; font-size:13px;">
									<h3 style="font-size:14px; color:#4CAF50; font-weight: bold;">INFORMACI&Oacute;N</h3>
									<span style="color: #006064; float: right; text-align: right; margin-top: -20px; padding-right:90px;">
										6 <i class="icon-thumbs-up-alt" title="Me gusta"></i>
									</span>
									<span style="color: #006064; float: right; text-align: right; margin-top: -20px; padding-right:30px;">
										6 <i class="icon-thumbs-down-alt" title="No me gusta"></i>
									</span>';
									$miconexion->consulta("select c.*, u.*, pr.nombre, p.nombre from centros_deportivos c, usuarios u, provincia pr, pais p where c.id_centro = '".$id."' AND c.id_user = u.id_user and c.ciudad = pr.id and pr.pais = p.id");
									$lista=$miconexion->consulta_lista();
									echo "<table class='table'>
									<tbody>";
										echo '<tr>
										<td><strong>Direcci&oacute;n: </strong></td><td>'.$lista[5].' ('.$lista[28].', '.$lista[29].')</td>
									</tr>';
									echo '<tr><td><strong>Contactos: </strong></td><td>'.$lista[18].' '.$lista[19].' ('.$lista[15].')</td></tr>';
									echo '<tr><td><strong>Tel&eacute;fono: </strong></td><td>'.$lista[8].'</td></tr>';
									echo '<tr><td><strong>Horario de atenci&oacute;n: </strong></td><td></td></tr>';
									echo '<tr><td><strong>Jugadores permitidos: </strong></td><td>'.$lista[13].'</td></tr>';
									echo '<tr><td><strong>Costo por '.$lista[11].' hora(s): </strong></td><td> $'.$lista[12].'</td></tr>';
									echo "</tbody>
								</table>";
								echo '</div>';
							};?>							
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
		<h4>USUARIOS CONECTADOS</h4>
		<ul style="color:#ffff; list-style: none; padding:0px;">
			<div id = "col_chat"></div>
		</ul>
	</div>
</div>
	<!-- END DASHBOARD STATS -->