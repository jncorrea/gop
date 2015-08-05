<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="perfil.php">Home</a>
			<i class="fa fa-angle-right"></i>
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
									$miconexion->consulta("select * from canchas");
									for ($i=0; $i < $miconexion->numregistros(); $i++) { 
									    $lista=$miconexion->consulta_lista();
									    echo '<li style="list-style: none; text-align:left;">
												<a href="perfil.php?op=canchas&id='.$lista[0].'">
													<i class="icon-map-marker" style="padding: 10px 15px; font-size:18px;"></i>
													<span class="title">'.$lista[1].'</span>
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
									<form method="post" action="../include/insertar_cancha.php" enctype="multipart/form-data" class="form-group">
									  <div class="form-group">
									    <label for="mail" class="control-label">Nombre:</label>
									      <input type="text" class="form-control" id="mail" name="nombre"  placeholder="Ingrese Nombre de la cancha" required >
									  </div>

									  <div class="form-group">
									    <label for="mail" class="control-label">Direcci&oacute;n:</label>
									      <input type="text" class="form-control" id="mail" name="direccion" placeholder="Ingrese direcci&oacute;n" >            
									  </div>
									  <div class="form-group">
									    <label for="mail" class="control-label">N&uacute;mero de Jugadores:</label>
									      <input type="number" class="form-control" id="mail" name="nmaximo" placeholder="0" min="1">
									  </div>

									  <div class="form-group">
									    <label for="mail" class="control-label">Latitud:</label>
									      <input type="number" class="form-control" id="mail" name="latitud" placeholder="Ingrese latitud">
									  </div>

									  <div class="form-group">
									    <label for="mail" class="control-label">Longitud:</label>
									    <input type="number" class="form-control" id="mail" name="longitud" placeholder="Ingrese longitud">
									  </div>

									  <div class="form-group">
									    <label for="mail" class="control-label">Costo:</label>
									      <input type="number" class="form-control" id="mail" name="costo" placeholder="Ingrese el costo">
									  </div>

									  									  
										 <div class="form-group">
											    <label for="equipoA" class="col-xs-12 col-sm-10 control-label">Horario de Atencion</label>
											    <label for="equipoB" class="col-xs-3 col-sm-0 control-label">Desde: </label>
											    <div class="col-xs-1 col-sm-2">
											      
											      <input type="text" class="time" id="timeformatExample1" name="hora_inicio" data-scroll-default="09:00:00" required/> 
											    </div>
											    <label for="equipoB" class="col-xs-8 col-sm-0 control-label">Hasta: </label>
											    <div class="col-xs-0 col-sm-12">
											      <input type="text" class="time" id="timeformatExample2" name="hora_fin" data-scroll-default="23:30:00" required/>
											    </div>
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

									  
									  <input type="hidden" name="bd" value="canchas">
									  <div class="form-group">
									    <div class="margiv-top-10">
									      <button type="submit" class="btn green-haze" style="background:#4CAF50;">Guardar Cambios</button>
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
											$miconexion->consulta("select MAX(id_cancha) from canchas");
											$cancha = $miconexion->consulta_lista();
											$id = $cancha[0];
											$miconexion->consulta("select * from canchas where id_cancha = '".$id."'");
											for ($i=0; $i < $miconexion->numregistros(); $i++) { 
											    $lista=$miconexion->consulta_lista();
											    echo $lista[1];
											}
										}else{
											$miconexion->consulta("select * from canchas where id_cancha = '".$id."'");
											for ($i=0; $i < $miconexion->numregistros(); $i++) { 
											    $lista=$miconexion->consulta_lista();
											    echo $lista[1];
											}
										}?>
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
											$miconexion->consulta("select * from canchas where id_cancha = '".$id."'");
											for ($i=0; $i < $miconexion->numregistros(); $i++) { 
											    $lista=$miconexion->consulta_lista();
											    echo '<hr><strong>Direcci&oacute;n: </strong>'.$lista[2].'<br>';
											    echo '<strong>Jugadores permitidos: </strong>'.$lista[3].'<br>';
											    echo '<strong>Costo: </strong> $'.$lista[6];
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