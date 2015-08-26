
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="perfil.php">Home</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="perfil.php?op=configurar">Mi Perfil</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="#">Cambiar contrase&ntilde;a</a>
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
										if ($lista[12]==""){
							              echo '<img alt="Avatar" class="img-responsive img-circle" src="../assets/img/user.png"/>';
							            }else{
							              echo "<img alt='Avatar' class='img-responsive img-circle' src='images/".$_SESSION['email']."/".$lista[12]."'>";
							            }
									 ?>
								</div>
								<!-- END SIDEBAR USERPIC -->
								<!-- SIDEBAR USER TITLE -->
								<div class="profile-usertitle">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:1em;">
										<p style="font-size:14px; font-weight: bold; text-transform:uppercase; color:#006064; text-align:center;">
											<?php echo $lista[4]." ".$lista[5]; ?></p>
										<p style="font-size:12px;"><?php echo $lista[1]?></p>
										<p style="font-size:12px;"><strong>Celular:</strong> <?php echo $lista[8]?></p>
										<p style="font-size:12px;"><strong>Posici&oacute;n:</strong> <?php echo $lista[7]?></p>

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
										<span class="caption-subject font-blue-madison bold uppercase">Actualizar Contrase&ntilde;a</span>
							        </div>
								</div>
								<div class="portlet-body">
									<div class="tab-content">
										<!-- PERSONAL INFO TAB -->
										<form method="post" id="form_cambpass" action="" enctype="multipart/form-data" class="form-group">
										  
										  <div class="form-group">
										    <label class="control-label" for="pass">Actual: </label>											    
										    <input type="password" class="form-control" id="pass" name="pass_actual" placeholder='Ingresa tu contrase&ntilde;a actual '>
										  </div>

										  <div class="form-group">
										    <label class="control-label" for="pass">Nueva: </label>											    
										    <input type="password" class="form-control" id="pass" name="pass_nueva1" placeholder='Piensa una nueva contrase&ntilde;a ' >
										  </div>

										  <div class="form-group">
										    <label class="control-label" for="pass">Vuelve a escribir la nueva contrase&ntilde;a : </label>											    
										    <input type="password" class="form-control" id="pass" name="pass_nueva2" placeholder='Vuelve a escribir la nueva contrase&ntilde;a '>
										  </div>
										  <div class="form-group">
										    <div class="margiv-top-10">
										    	<div id="respuesta" style="color:red;"></div>
										    	<span class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/validar_password.php","form_cambpass")'>Guardar Cambios</span>
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