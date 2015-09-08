  <?php 
header('Content-Type: text/html; charset=ISO-8859-1');
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
session_start();
extract($_GET);

?>

<div class="portlet light">
		
		

		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab_1_todos" data-toggle="tab" aria-expanded="true">
				Mis Grupos </a>
			</li>
			
		</ul>

		<div class="portlet-body">
			<!--BEGIN TABS-->

			<div class="tab-content">
			<div class="tab-pane active" id="tab_1_todos">
					<div class="row">
						
					<div class="col-md-6 col-sm-6">

						<div class="portlet-title">
								<div class="caption">
									<i class="icon-bubble font-red-sunglo"></i><strong>GRUPOS QUE ADMINISTRAS:</strong> 
									
								</div>
								<hr>
								
								<?php 
						$miconexion->consulta("select * from grupos where id_user='".$_SESSION['id']."'");
							  $nom=$miconexion->consulta_lista();
						for ($i=0; $i < $miconexion->numregistros(); $i++) { 
					        $grupo=$miconexion->consulta_lista();
					        if ($miconexion->numregistros()==0) {
					        	echo "<h3>No hay Grupos</h3>";
					        	# code...
					        }
					 ?>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 user-info" style="height:90px; font-size:85%;">
							
							<?php if ($grupo[3]==""){ 

									echo ' <img align=center id="img_grupo" src="../assets/img/soccer1.png" alt="" style="width:90%; heigth:50px;" class="img-responsive"> ';
					          	
					        }else{ ?>
								<img align=center alt="" src=<?php echo "'images/grupos/".$grupo[0]."/".$grupo[3]."'"; ?>  style=" width:80%; heigth:50px;" class="img-responsive">	
								 
								 
							<?php } ?>
							<a href=""> <h4 style="text-align:center" > <?php echo $grupo[2] ?> </h4> </a>
							<div class="details">
																	
									<?php //echo $grupo[2] ?> </a>
									<p>	<span class="label label-sm label-success">
											Fecha de creaci&oacute;n: </span>

									<br><?php echo $grupo[4]?> </p>
								
								
							</div>

							
						</div>
					<?php } ?>

						</div>

					</div>



					<div class="col-md-6 col-sm-6">

						<div class="portlet-title">
								<div class="caption">
									<i class="icon-bubble font-red-sunglo"></i><strong>GRUPOS A LOS QUE PERTENECES: </strong></span>
									
								</div>
								<hr>
								
								<?php 
						$miconexion->consulta("select * from grupos where id_user='".$_SESSION['id']."'");
							  $nom=$miconexion->consulta_lista();
						for ($i=0; $i < $miconexion->numregistros(); $i++) { 
					        $grupo=$miconexion->consulta_lista();

					        if ($miconexion->numregistros()==0) {
					        	echo "<h3>No hay Grupos</h3>";
					        	# code...
					        }
					        

					 ?>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 user-info" style="height:90px; font-size:85%;">
							
							<?php if ($grupo[3]==""){ 

									echo ' <img align=center id="img_grupo" src="../assets/img/soccer1.png" alt="" style="width:90%; heigth:50px;" class="img-responsive"> ';
					          	
					        }else{ ?>
								<img align=center alt="" src=<?php echo "'images/grupos/".$grupo[0]."/".$grupo[3]."'"; ?>  style=" width:80%; heigth:50px;" class="img-responsive">	
								 
								 
         
         

								

							<?php } ?>
							<a href=""> <h4  > <?php echo $grupo[2] ?> </h4> </a>
							<div class="details">
																	
									<?php //echo $grupo[2] ?> </a>
									<p>	<span class="label label-sm label-success">
											Fecha de creaci&oacute;n: </span>

									<br><?php echo $grupo[4]?> </p>
								
								
							</div>

							
						</div>
					<?php } ?>

						</div>

					</div>


					
					</div>	
			</div>
			
				
			
			</div>
			<!--END TABS-->
			</div>
		</div> 

