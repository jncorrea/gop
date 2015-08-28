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
									    	<option value="0">---Seleccione una ciudad---</option>
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
									  <div class="form-group">
									    <label for="mail" class="control-label">Latitud:</label>
									      <input type="text" class="form-control" name="latitud" placeholder="Ingrese latitud">
									  </div>
									  <div class="form-group">
									    <label for="mail" class="control-label">Longitud:</label>
									    <input type="text" class="form-control" name="longitud" placeholder="Ingrese longitud">
									  </div>
									  <div class="form-group">
									    <label for="mail" class="control-label">Tel&eacute;fono:</label>
									    <input type="text" class="form-control" name="telef_centro" placeholder="(07)2555555 ext 134">
									  </div>
									  <div class="form-group">
									    <label for="Horario" class="control-label"><span style="color:red;">* </span>Horario de Atenci&oacute;n:</label>
									  </div>									  
									  <div class="form-group" style = "margin-top: -15px; margin-left: -15px; margin-right: -15px;">
									    <div class="col-xs-5 col-sm-5">
									      <input type="text" class="time form-control" id="timeformatExample1" name="hora_inicio" data-scroll-default="07:00:00" placeholder="07:00:00" required>
									    </div>
									    <label for="horaFin" class="col-sm-1 col-xs-2 control-label">hasta </label>
									    <div class="col-xs-5 col-sm-6">
									      <input type="text" class="time form-control" id="timeformatExample2" name="hora_fin" data-scroll-default="23:30:00" placeholder="00:00:00" required/>
									    </div>
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
									    <label for="mail" class="control-label">Foto del centro:</label>
									      <input type="file" class="form-control" name="foto_centro" >
									  </div>
										 <script>
							                $(function() {
							                    $('#timeformatExample1').timepicker({ 'timeFormat': 'H:i:s' });
							                    $('#timeformatExample2').timepicker({ 'timeFormat': 'H:i:s' });
							                });
							            </script>
							            <script>
							                $(function() {
							                    $('#basicExample1').timepicker();
							                });
							            </script>							            
									  
									  <div class="form-group">
									    <div class="margiv-top-10">
									      <button type="button" class="btn green-haze" onclick='enviar_form("../include/insertar_cancha.php","form_crear_cancha");' style="background:#4CAF50;">Guardar Cambios</button>
									    </div>
									  </div>           
									</form>
									<!-- END CANCHA INFO TAB -->		
								</div>
							</div>
						</div>
					<?php }else{?>
						<div class="portlet light ">
							<div class="portlet-title">
								<div class="caption">
									<i class="icon-bubble font-red-sunglo"></i>
									<span class="caption-subject bold uppercase" style="color: #006064;">
										<?php
										if (@$id==0) {
											echo "CENTROS DEPORTIVOS";
										}else{
											$miconexion->consulta("select * from centros_deportivos where id_centro = '".$id."'");
											for ($i=0; $i < $miconexion->numregistros(); $i++) { 
											    $lista=$miconexion->consulta_lista();
											    echo $lista[2];
											    					  						
											}
											$admin=$_SESSION['id'];
											if (@$lista[1]==$admin) {
												?>									
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
											<i id="centro_favorito" class="icon-star" title="No Favorito" style="color:#FFC400; font-size: 20px; cursor: pointer;" onclick = "actualizar_notificacion('9','<?php echo $id; ?>','<?php echo $_SESSION['id']; ?>');"></i>
											<?php }else{ ?> <!--Caso no favorito-->
											<i id="centro_favorito" class="icon-star-empty" title="Favorito" style="font-size: 20px; cursor: pointer;" onclick = "actualizar_notificacion('10','<?php echo $id; ?>','<?php echo $_SESSION['id']; ?>');"></i>
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
											$miconexion->consulta("select * from centros_deportivos c, usuarios u where c.id_centro = '".$id."' AND c.id_user = u.id_user");
										    $lista=$miconexion->consulta_lista();
											echo "<table class='table'>
													<tbody>";
											echo '<tr>
													<td><strong>Direcci&oacute;n: </strong></td><td>'.$lista[5].' ('.$lista[3].')</td>
												</tr>';
										    echo '<tr><td><strong>Contactos: </strong></td><td>'.$lista[18].' '.$lista[19].' ('.$lista[15].')</td></tr>';
										    echo '<tr><td><strong>Tel&eacute;fono: </strong></td><td>'.$lista[8].'</td></tr>';
										    echo '<tr><td><strong>Horario de atenci&oacute;n: </strong></td><td>'.$lista[9].' - '.$lista[10].'</td></tr>';
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