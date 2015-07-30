<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="perfil.php">Home</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="#">Mi Perfil</a>
		</li>
	</ul>	
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
		<h3 class="page-title">
			Mi Perfil <small>Configurar</small>
		</h3>
		<div class="clearfix">
		</div>
		<div class="row">
			<div class="col-md-4 col-sm-4">
				<!-- BEGIN PORTLET-->
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bubble font-red-sunglo"></i>
							<span class="caption-subject bold uppercase" style="font-size:12px; color:#4CAF50;">Mi Perfil</span>
						</div>
					</div>
					<div class="portlet-body" id="chats">
						<div style="height: 441px;" data-always-visible="1" data-rail-visible1="1">
							<div class="portlet light profile-sidebar-portlet" style="border:0px;">
								<!-- SIDEBAR USERPIC -->
								<div class="profile-userpic" align=center>								
									<?php 
										if ($lista[7]==""){
							              echo '<img alt="Avatar" class="img-responsive img-circle" src="../assets/img/user.png"/>';
							            }else{
							              echo "<img alt='Avatar' class='img-responsive img-circle' src='images/".$_SESSION['email']."/".$lista[7]."'>";
							            }
									 ?>
								</div>
								<!-- END SIDEBAR USERPIC -->
								<!-- SIDEBAR USER TITLE -->
								<div class="profile-usertitle">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:1em;">
										<p style="font-size:14px; font-weight: bold; text-transform:uppercase; color:#006064; text-align:center;">
											<?php echo $lista[3]." ".$lista[4]; ?></p>
										<p style="font-size:12px;"><?php echo $lista[0]?></p>
										<p style="font-size:12px;"><strong>Celular:</strong> <?php echo $lista[5]?></p>
										<p style="font-size:12px;"><strong>Posici&oacute;n:</strong> <?php echo $lista[6]?></p>

										<div class="account" id="account">
								        <ul id="progressbar-account"> 
								            <h4 style="font: bold 90%">Avance del Perfil</h4>
								            <li id="box1">25%</li>          
								            <li id="box2">50%</li>
								            <li id="box3">75%</li>
								            <li id="box4">100%</li>
								        </ul> 
								          <?php 
								          	$valor = intval(100/$cont);
								          	$limit = $valor * $cont;
								            $porcentaje = 0;
								            for ($i=0; $i < $cont; $i++) { 
								              if ($lista[$i]!="") {
								                $porcentaje = $porcentaje + $valor;
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
								            }if ($porcentaje >= $limit){
								               echo "<script>
								                    $('li#box4').addClass('active-box');
						                        	document.getElementById('account').hidden=true;                     
								                    </script>";
								            }
								           ?> 
								        </div>
									</div>
								</div>
								<!-- END SIDEBAR USER TITLE -->
							</div>
						</div>
					</div>
				</div>
				<!-- END PORTLET-->
			</div>
			<div class="col-md-8 col-sm-8">
				<div class="profile-content">
					<div class="row">
						<div class="col-md-12">
							<div class="portlet light">
								<div class="portlet-title tabbable-line">
									<div class="caption caption-md">
										<i class="icon-globe theme-font hide"></i>
										<span class="caption-subject font-blue-madison bold uppercase">Mis Datos</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="tab-content">
										<!-- PERSONAL INFO TAB -->
										<form method="post" action="../include/actualizar_perfil.php" enctype="multipart/form-data" class="form-group">
										  <div class="form-group">
										    <label class="control-label" for="mail">Email</label>
										    <input type="email" class="form-control" id="mail" name="email" value="<?php echo $lista[0] ?>" readonly>
										  </div>
										  <div class="form-group">
										    <label class="control-label" for="pass">Password</label>											    
										    <input type="password" class="form-control" id="pass" name="pass" value="<?php echo $lista[1] ?>" placeholder="************" required>
										  </div>
										  <div class="form-group">
										    <label class="control-label" for="user">Usuario</label>											   
										    <input type="text" class="form-control" id="user" name="user" value="<?php echo $lista[2] ?>" readonly>										
										  </div>
										  <div class="form-group">
										    <label class="control-label" for="nombres">Nombres</label>		
										    <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $lista[3] ?>" placeholder="Nombres">				
										  </div>
										  <div class="form-group">
										    <label class="control-label" for="apellidos">Apellidos</label>		
										    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $lista[4] ?>" placeholder="Apellidos">				
										  </div>
										  <div class="form-group">
										    <label class="control-label" for="celular">Celular</label>
											<input type="text" class="form-control" id="celular" name="celular" value="<?php echo $lista[5] ?>" placeholder="Celular">
										  </div>
										  <div class="form-group">
										    <label class="control-label" for="posicion">Posici&oacute;n</label>		
										    <input type="text" class="form-control" id="posicion" name="posicion" value="<?php echo $lista[6] ?>" placeholder="Posici&oacute;n">
										 </div>
										  <div class="form-group">
										    <label class="control-label" for="avatar">Avatar</label>		
										    <input style="height: 0%;" type="file" class="form-control" id="avatar" name="avatar" accept="image/png, image/gif, image/jpg">
										    <output id="list" style="text-align: center;"></output>				
										  </div>
										  <div class="form-group">
										    <div class="margiv-top-10">
										      <button type="submit" class="btn green-haze" style="background:#4CAF50;">Guardar Cambios</button>
										    </div>
										  </div>											  
										</form>
										<!-- END PERSONAL INFO TAB -->											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
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