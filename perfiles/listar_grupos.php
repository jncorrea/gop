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
					</div>

					<?php 
					$miconexion->consulta("select * from grupos where id_user='".$_SESSION['id']."'");
					$nom=$miconexion->consulta_lista();
					for ($i=0; $i < $miconexion->numregistros(); $i++) { 
					    $grupo=$miconexion->consulta_lista();
					       if ($miconexion->numregistros()==0) {
					       	echo "<h3>No hay Grupos</h3>";
					      	# code...
					        }else{  							
					}
					}
					?>
					<div class="table-responsive">
					<table class="table table-hover">

			            <?php
			            $miconexion->consulta("select * from grupos where id_user='".$_SESSION['id']."'");
			            for ($i=0; $i < $miconexion->numregistros(); $i++) { 
			              $grupo=$miconexion->consulta_lista();

			                echo "<tr >";

			               if ($grupo[3]=="") {
			               	echo "<td style='width:100px;'><img class='img-responsivee' style='width:80px; height:80px;' src='../assets/img/soccer1.png'> <br> </td>";
			               }else{
			               	 echo "<td style='width:100px;'><img class='img-responsivee' style='width:80px; height:80px;' src='images/grupos/".$grupo[0]."/".$grupo[3]."'> <br> </td>";
			               }
			               			               
			                  echo  "<td style='font-size: 14px;'><a href='perfil.php?op=grupos&id=".$grupo[0]."'><span style='font-size: 11px; font-weight: bold;'>".strtoupper($grupo[2])." &nbsp; &nbsp; <i  class='icon-user'> 5 Integrantes</i> </span><br> </a> <br> Fecha de Creacion : ".date('d-m-Y',strtotime($grupo[4]))."</td>";
   
			                  echo "<td style='width:9.43px;'></td>";


			              
			                echo "</tr>";

			              }
			             ?>  

			                       
			        </table>
			    </div>
				</div>

				<div class="col-md-6 col-sm-6">

					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bubble font-red-sunglo"></i><strong>GRUPOS A LOS QUE PERTENECES :</strong> 
					</div>
					<hr>					
					</div>

					<?php 
					$miconexion->consulta("select * from grupos where id_user='".$_SESSION['id']."'");
					$nom=$miconexion->consulta_lista();
					for ($i=0; $i < $miconexion->numregistros(); $i++) { 
					    $grupo=$miconexion->consulta_lista();
					       if ($miconexion->numregistros()==0) {
					       	echo "<h3>No hay Grupos</h3>";
					      	# code...
					        }else{						
					}
					}
					?>
					<div class="table-responsive">
					<table class="table table-hover">

			            <?php
			            $miconexion->consulta("select distinct g.id_grupo, g.id_user, g.nombre_grupo, g.logo, u.nombres, u.apellidos from user_grupo ug, grupos g, usuarios u where ug.id_user<>g.id_user and g.id_user=u.id_user and ug.id_user='".$_SESSION['id']."'");
			            for ($i=0; $i < $miconexion->numregistros(); $i++) { 
			              $grupo=$miconexion->consulta_lista();
			                echo "<tr >";

			               if ($grupo[3]=="") {
			               	echo "<td style='width:100px;'><img class='img-responsivee' style='width:80px; height:80px;' src='../assets/img/soccer1.png'> <br> </td>";
			               }else{
			               	 echo "<td style='width:100px;'><img class='img-responsivee' style='width:80px; height:80px;' src='images/grupos/".$grupo[0]."/".$grupo[3]."'> <br> </td>";
			               }
			               
			                  echo  "<td style='font-size: 14px;'><a href='perfil.php?op=grupos&id=".$grupo[0]."'><span style='font-size: 11px; font-weight: bold;'>".strtoupper($grupo[2])."&nbsp; &nbsp; <i  class='icon-user'> 3 Integrantes</i></span><br> </a> <br> Administrado Por : ".$grupo[5]."</td>";
   
			                  echo "<td style='width:9.43px;'></td>";


			              
			                echo "</tr>";

			              }
			             ?>  

			                       
			        </table>
			    </div>

				</div>
				
				</div>	
			</div>				
			
			</div>
			<!--END TABS-->
		</div>
</div> 

