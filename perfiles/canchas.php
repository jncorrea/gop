<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="perfil.php">Home</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="perfil.php?op=canchas">Canchas</a>
		</li>
	</ul>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
		<h3 class="page-title">
			Canchas <small>Localizaci&oacute;n</small>
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
							<span class="caption-subject bold uppercase" style="font-size:12px; color:#4CAF50;">Canchas Disponibles</span>
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
								</div>
							</div>
							<div class="portlet-body" id="chats">
								<div class="tab-content">	
									<!-- CANCHA INFO TAB -->
									<form method="post" id="form_crear_cancha" enctype="multipart/form-data" class="form-group">
									  <div class="form-group">
									    <label for="mail" class="control-label">Nombre:</label>
									      <input type="text" class="form-control" name="centro_deportivo"  placeholder="Ingrese Nombre de la cancha" required >
									  </div>
									  <div class="form-group">
									    <label for="mail" class="control-label">Ciudad:</label>
									      <input type="text" class="form-control" name="ciudad"  placeholder="Loja, Ecuador" >
									  </div>
									  <div class="form-group">
									    <label for="mail" class="control-label">Foto del centro:</label>
									      <input type="file" class="form-control" name="foto_centro" >
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
									    <label for="Horario" class="control-label">Horario de Atenci&oacute;n:</label>
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
									    <label for="mail" class="control-label">Tiempo de alquiler:</label>
									      <input type="number" class="form-control" name="tiempo_alquiler" placeholder="1 hora(s)" min="1" max="16">
									  </div>
									  <div class="form-group">
									    <label for="mail" class="control-label">Costo:</label>
									      <input type="number" class="form-control" name="costo" placeholder="Ingrese el costo">
									  </div>									  									  
									  <div class="form-group">
									    <label for="mail" class="control-label">N&uacute;mero de Jugadores:</label>
									      <input type="number" class="form-control" name="num_jugadores" placeholder="0" min="1">
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
								            
									  
									  <input type="hidden" name="bd" value="centros_deportivos">
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
										<?php if (@$id==0) {
											$miconexion->consulta("select MAX(id_centro) from centros_deportivos");
											$cancha = $miconexion->consulta_lista();
											$id = $cancha[0];
											$miconexion->consulta("select * from centros_deportivos where id_centro = '".$id."'");
											for ($i=0; $i < $miconexion->numregistros(); $i++) { 
											    $lista=$miconexion->consulta_lista();
											    echo $lista[2];
											}
										}else{
											$miconexion->consulta("select * from centros_deportivos where id_centro = '".$id."'");
											for ($i=0; $i < $miconexion->numregistros(); $i++) { 
											    $lista=$miconexion->consulta_lista();
											    echo $lista[2];
											    					  						
											}
										}
									 $admin=$_SESSION['id'];
									if (@$lista[1]==$admin) {
										?>									
										<a title="Editar Cancha" href="perfil.php?op=editar_cancha&id=<?php echo $id ?>" style="z-index:4;font-size:15px;"><i style="font-size:130%" class="icon-pencil"></i></a>
								<?php
									}
									?>
										
									</span>
								</div>
							</div>
							<div class="portlet-body" id="chats">
								<?php if (@$id==0) {
									echo '<div class="scroller" style="height: 341px;" data-always-visible="1" data-rail-visible1="1">
									<div id="cancha_map" style="width:100%; height: 341px;">								
									</div>';								
									}else{
										echo '<div class="scroller" style="height: 541px;" data-always-visible="1" data-rail-visible1="1">
									<div id="cancha_map" style="width:100%; height: 341px;">								
									</div>
										<div style="width:100%; height: 100px; padding-top: 2em;">
											<h3 style="font-size:14px; color:#4CAF50; font-weight: bold;">INFORMACI&Oacute;N</h3>';
											$miconexion->consulta("select * from centros_deportivos where id_centro = '".$id."'");
											for ($i=0; $i < $miconexion->numregistros(); $i++) { 
											    $lista=$miconexion->consulta_lista();
											    echo '<hr><strong>Direcci&oacute;n: </strong>'.$lista[5].'<br>';
											    echo '<strong>Jugadores permitidos: </strong>'.$lista[13].'<br>';
											    echo '<strong>Costo: </strong> $'.$lista[13];
											}
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