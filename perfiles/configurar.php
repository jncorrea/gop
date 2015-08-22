<?php 
	include("../static/site_config.php"); 
	include ("../static/clase_mysql.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	session_start();
	$miconexion->consulta("select * from usuarios where email = '".$_SESSION['email']."' ");
	$cont = $miconexion->numcampos();
	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
		$lista=$miconexion->consulta_lista();
	}

	 $miconexion->consulta("select id_user from usuarios where email = '".$_SESSION['email']."' ");
	$usuario_id=$miconexion->consulta_lista();

?>
<!-- BEGIN DASHBOARD STATS -->
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
								if ($lista[10]==""){
					              echo '<img alt="Avatar" class="img-responsive img-circle" src="../assets/img/user.png"/>';
					            }else{
					              echo "<img alt='Avatar' class='img-responsive img-circle' src='images/".$_SESSION['email']."/".$lista[10]."'>";
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
						          	echo "limite ".$limit;
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

						                   
						            }
						            if ($porcentaje>=91) {
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

					<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab_1_1" data-toggle="tab" aria-expanded="true">
				Mis Datos  </a>
			</li>
			<li class="">
				<a href="#tab_1_2" data-toggle="tab" aria-expanded="false">
				Mis Favoritos </a>
			</li>
			<li class="">
				<a href="#tab_1_3" data-toggle="tab" aria-expanded="false">
				Otros </a>
			</li>
		</ul>

		<div class="portlet-body">
			<!--BEGIN TABS-->
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1_1">

					<div class="portlet light">
						
						<div class="portlet-body">
							<div class="tab-content">
								<!-- PERSONAL INFO TAB -->
								<form method="post" action="" id="form_perfil" enctype="multipart/form-data" class="form-group">
            						<input name="bd" type="hidden" value="usuarios"/>									
								  <div class="form-group">
								  	<label class="control-label" for="pass">Cambiar Contrase&ntilde;a<a title="Editar Contrase&ntilde;a" href="perfil.php?op=configurar_pass" style="z-index:4; font-size:15px;"><i style="font-size:130%" class="icon-pencil"></i></a> </label>											    
								  </div>
								  <div class="form-group">
								    <label class="control-label" for="mail">Email</label>
								    <input type="email" class="form-control" id="mail" name="email" value="<?php echo $lista[1] ?>" readonly>
								  </div>
								  <div class="form-group">
								    <label class="control-label" for="user">Usuario</label>											   
								    <input type="text" class="form-control" id="user" name="user" value="<?php echo $lista[3] ?>" readonly>										
								  </div>
								  <div class="form-group">
								    <label class="control-label" for="nombres">Nombres</label>		
								    <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $lista[4] ?>" placeholder="Nombres">				
								  </div>
								  <div class="form-group">
								    <label class="control-label" for="apellidos">Apellidos</label>		
								    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $lista[5] ?>" placeholder="Apellidos">				
								  </div>

								  <?php
								  @$fecha_n="";
								  @$dia_n="";
								  @$mes_n="";
								  @$anio_n="";

								  @$fecha_n=split('-', $lista[6]);
								  
								  @$dia_n=$fecha_n[2];
								  @$mes_n=$fecha_n[1];
								  @$anio_n=$fecha_n[0];
								  
								  ?>


								  <div class="form-group">
										    <label class="control-label" for="apellidos">Fecha de Nacimiento: </label>
										    <div >

										    	<select name="nacimiento">
										<?php
											for($d=1;$d<=31;$d++)
											{
												if($d<10)
													$dd = "0" . $d;
												else
													$dd = $d;

												if ($d==$dia_n) {

												
													echo "<option selected value='$dd'>$dd</option>";
												
												# code...
												}else{
													echo "<option value='$dd'>$dd</option>";
												}


												
											}
										?>
									</select>
									<select name="mess">
									<?php
										for($m = 1; $m<=12; $m++)
										{
											if($m<10)
												$me = "0" . $m;
											else
												$me = $m;
											switch($me)
											{
												case "01": $mes = "Enero"; break;
												case "02": $mes = "Febrero"; break;
												case "03": $mes = "Marzo"; break;
												case "04": $mes = "Abril"; break;
												case "05": $mes = "Mayo"; break;
												case "06": $mes = "Junio"; break;
												case "07": $mes = "Julio"; break;
												case "08": $mes = "Agosto"; break;
												case "09": $mes = "Septiembre"; break;
												case "10": $mes = "Octubre"; break;
												case "11": $mes = "Noviembre"; break;
												case "12": $mes = "Diciembre"; break;			
											}
											if ($me==$mes_n) {

												echo "<option selected value='$me'>$mes</option>";
												
												# code...
											}else{
												echo "<option value='$me'>$mes</option>";
											}
											
										}
									?>
									</select> <select name="anio">
										<?php
											$tope = date("Y");
											$edad_max = 75;
											$edad_min = 13;
											for($a= $tope - $edad_max; $a<=$tope - $edad_min; $a++)
												if ($a==$anio_n) {
													echo "<option selected value='$a'>$a</option>"; 
													# code...
												}else{
													echo "<option value='$a'>$a</option>"; 

												}
												
										?>
									</select>
										      
										    </div>
								</div>

								  <div class="form-group">
										    <label class="control-label" for="apellidos">Posici&oacute;n </label>
										    <div >
										      <select style="border-radius:5px;" name="posicion" class="form-control">
										      <?php 
										          echo "<option value='Delantero/a'> Delantero/a </option>";
										          echo "<option value='Mediocampista'> Mediocampista </option>";
										          echo "<option value='Defenza'> Defenza </option>";
										          echo "<option value='Arquero/a'> Arquero/a </option>";
										      ?>
										     </select>
										    </div>
										  </div>



								  <div class="form-group">
								    <label class="control-label" for="celular">Celular</label>
									<input type="number" class="form-control" id="celular" name="celular" value="<?php echo $lista[8] ?>" placeholder="Celular">
								  </div>

								  <div class="form-group">
								    <label class="control-label" for="celular">Tel&eacute;fono</label>
									<input type="number" class="form-control" id="celular" name="telefono" value="<?php echo $lista[9] ?>" placeholder="Celular">
								  </div>

								  
								  <div class="form-group">
								    <label class="control-label" for="avatar">Avatar</label>		
								    <input style="height: 0%;" type="file" class="form-control" id="avatar" name="avatar" accept="image/png, image/gif, image/jpg, image/jpeg">
								    <output id="list" style="text-align: center;"></output>				
								  </div>
								</form>
								<div class="form-group">
									<div class="margiv-top-10">
							    		<button type="submit" class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/actualizar_perfil.php","form_perfil")'>Guardar Cambios</button>
							    	</div>
								</div>
								<ul id="respuesta"></ul>
								<!-- END PERSONAL INFO TAB -->											
							</div>


						</div>
					</div>

						</div>

						<div class="tab-pane" id="tab_1_2">
					        <div class="portlet light">
								<div class="portlet-title tabbable-line">
									<div class="caption caption-md">
										<i class="icon-globe theme-font hide"></i>
										<span class="caption-subject font-blue-madison bold uppercase">ESCOGE TUS CENTROS FAVORITOS</span>
									
							        
									</div>
								</div>
								<div class="portlet-body">
									<div class="tab-content">
										<!-- PERSONAL INFO TAB -->
										
										 <form method="post" action="" id="form_fav" enctype="multipart/form-data" class="form-group"> 
										  
										  <div class="form-group">
										    <label for="cancha" class="col-sm-2 control-label"> Centros Favoritos </label>
										    <div class="col-sm-9">
										       
										

												 <?php 
											          $a= $miconexion->consulta("select * from centros_deportivos");
											          
											          $i=0;
														while ($opcion = mysql_fetch_array($a)) {

															
															$miconexion->consulta("select * from centros_favoritos where ID_CENTRO='".$opcion[0]."' and ID_USER='".$usuario_id[0]."'");

															if ($miconexion->numregistros()>0) {
																	
																	echo "<input type='checkbox' name='centro[$i]' checked value='".$opcion[0]."' > ".$opcion[2]."<br> ";
																}else{
																	echo "<input type='checkbox' name='centro[$i]'  value='".$opcion[0]."' > ".$opcion[2]."<br> ";

																}
												    		
												    		$i++;
														}
											          
												 ?>
													<hr>
												
										    </div>
										    
										  </div>


										  <div class="form-group">
										    <label for="cancha" class="col-sm-2 control-label"> Deportes Favoritos </label>
										    <div class="col-sm-9">
										       
												<?php 
											          $a= $miconexion->consulta("select * from deportes");
											          //$miconexion->opciones_multiples();
											          $i=0;
														while ($opcion = mysql_fetch_array($a)) {

															$miconexion->consulta("select * from deportes_favoritos where ID_DEPORTE='".$opcion[0]."' and ID_USER='".$usuario_id[0]."'");

															if ($miconexion->numregistros()>0) {
																	echo "<input type='checkbox' name='deporte[$i]' checked value='".$opcion[0]."' > ".$opcion[1]."<br> ";
																}else{
																	echo "<input type='checkbox' name='deporte[$i]'  value='".$opcion[0]."' > ".$opcion[1]."<br> ";

																}
												    		
												    		$i++;
														}
											          
												 ?> 
												
										    </div>
										  </div>


										  											  
										</form>

										<div class="form-group">
									<div class="margiv-top-10">
								    	<button type="submit" class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/insertar_favoritos.php","form_fav")'>Guardar</button>
								    </div>
								  </div>
								<ul id="respuesta"></ul>

										<!-- END PERSONAL INFO TAB -->											
									</div>
								</div>
							</div>
				</div>

			</div>
			<!--END TABS-->
		</div>

				</div>
			</div>
		</div>
	</div>
</div>

<script>	
    function archivo(evt) {
      var files = evt.target.files; // FileList object       
        //Obtenemos la imagen del campo "file". 
    for (var i = 0, f; f = files[i]; i++) {         
        //Solo admitimos imágenes.
        if (!f.type.match('image.*')) {
            continue;
        }
        var reader = new FileReader();
            reader.onload = (function(theFile) {
            return function(e) {
            // Creamos la imagen.
                document.getElementById("list").innerHTML = ['<img style="width: 120px; height: 120px; border: 1px solid #000;" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
            };
           })(f);
           reader.readAsDataURL(f);
    	}
    }  
    document.getElementById('avatar').addEventListener('change', archivo, false);
</script>


