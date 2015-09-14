  <?php 
header('Content-Type: text/html; charset=ISO-8859-1');
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
session_start();
extract($_GET);

?>

<<<<<<< HEAD
=======
<h3 class="page-title">
     INFORMACI&Oacute;N<small> Mis Grupos</small>
</h3>

>>>>>>> dba83555b3872bf16a9303d84ed5309309f6623d
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
<<<<<<< HEAD
							<i class="icon-bubble font-red-sunglo"></i><strong>GRUPOS QUE ADMINISTRAS:</strong> 
					</div>
					<hr>					
=======
							<strong>GRUPOS QUE ADMINISTRAS</strong> 
						</div>
					<br>					
>>>>>>> dba83555b3872bf16a9303d84ed5309309f6623d
					</div>

					<?php 
					@$contador[0]="";
					$miconexion->consulta("select * from grupos where id_user='".$_SESSION['id']."'");
					
					if ($miconexion->numregistros()==0) {
						echo "<h4> A&uacute;n no administras un grupo</h4>";
					}else{

						for ($i=0; $i <$miconexion->numregistros(); $i++) {
						$mi_lista_grupos=$miconexion->consulta_lista(); 
						@$contador[$i]=$mi_lista_grupos[0];
						}

						for ($i=0; $i <count(@$contador) ; $i++) { 
							$miconexion->consulta("select * from user_grupo where id_grupo='".@$contador[$i]."'");
				            $datos[$i]=$miconexion->numregistros();
						}

						$nom=$miconexion->consulta_lista();
						for ($i=0; $i < $miconexion->numregistros(); $i++) { 
						    $grupo=$miconexion->consulta_lista();
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
<<<<<<< HEAD
			               	echo "<td style='width:100px;'><img class='img-responsivee' style='width:80px; height:80px;' src='../assets/img/soccer1.png'> <br> </td>";
			               }else{
			               	 echo "<td style='width:100px;'><img class='img-responsivee' style='width:80px; height:80px;' src='images/grupos/".$grupo[0]."/".$grupo[3]."'> <br> </td>";
			               }
			               			               
			                  echo  "<td style='font-size: 14px;'><a href='perfil.php?op=grupos&id=".$grupo[0]."'><span style='font-size: 11px; font-weight: bold;'>".strtoupper($grupo[2])." &nbsp; &nbsp; <i  class='icon-user'> ".$datos[$i]." Integrantes</i> </span><br> </a> <br> Fecha de Creacion : ".date('d-m-Y',strtotime($grupo[4]))."</td>";
   
			                  echo "<td style='width:9.43px;'></td>";


			              
=======
			               	echo "<td style='width:70px;'><img class='img-circle' style='width:60px; height:60px;' src='../assets/img/soccer1.png'> <br> </td>";
			               }else{
			               	 echo "<td style='width:70px;'><img class='img-circle' style='width:60px; height:60px;' src='images/grupos/".$grupo[0]."/".$grupo[3]."'> <br> </td>";
			               }
			               			               
			                  echo  "<td style='font-size: 10px;'><br>
			                  			<a href='perfil.php?op=grupos&id=".$grupo[0]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($grupo[2])."</span></a>
			                  			&nbsp; &nbsp; ( <i class='icon-user'></i>  ".$datos[$i]." Miembros)<br>
			                  			Creado: ".date('d-m-Y',strtotime($grupo[4]))."</td>";
		              
>>>>>>> dba83555b3872bf16a9303d84ed5309309f6623d
			                echo "</tr>";

			              }
			             ?>  

			                       
			        </table>
			    </div>
				</div>

				<div class="col-md-6 col-sm-6">

					<div class="portlet-title">
						<div class="caption">
							<strong>GRUPOS A LOS QUE PERTENECES</strong> 
					</div>
					<hr>					
					</div>

					<?php 
					$miconexion->consulta("select ug.id_grupo, g.nombre_grupo, g.logo, ug.fecha_inv, u.nombres, u.apellidos from user_grupo ug, grupos g, usuarios u where g.id_grupo=ug.id_grupo and ug.estado_conec='1' and  ug.id_user='".$_SESSION['id']."' and u.id_user=g.id_user and ug.id_grupo not in (select g.id_grupo from grupos g where g.id_user='".$_SESSION['id']."')");
					$count[0]=0;
					
					for ($i=0; $i <$miconexion->numregistros(); $i++) {
						$mi_lista=$miconexion->consulta_lista(); 
						$count[$i]=$mi_lista[0];


					}
					for ($i=0; $i <count($count) ; $i++) { 

						$miconexion->consulta("select * from user_grupo where id_grupo='".$count[$i]."'");
			            $b[$i]=$miconexion->numregistros();
			            						
					}
					
					
					if ($miconexion->numregistros()==0) {
						echo "<h4> A&uacute;n no Perteneces a otros Grupos</h4>";
					}
										
					?>
					<div class="table-responsive">
					<table class="table table-hover">

			            <?php
			          $miconexion->consulta("select ug.id_grupo, g.nombre_grupo, g.logo, ug.fecha_inv, u.nombres, u.apellidos from user_grupo ug, grupos g, usuarios u where g.id_grupo=ug.id_grupo and ug.estado_conec='1' and  ug.id_user='".$_SESSION['id']."' and u.id_user=g.id_user and ug.id_grupo not in (select g.id_grupo from grupos g where g.id_user='".$_SESSION['id']."')");

			            for ($i=0; $i < $miconexion->numregistros(); $i++) { 
			              $otros_grupos=$miconexion->consulta_lista();
			              //$miconexion->consulta("select count(id_grupo) from user_grupo where id_grupo='".$otros_grupos[0]."'  ");
			              //echo "<br> num: ".$otros_grupos[0];

			                echo "<tr >";
			                
			               if ($otros_grupos[2]=="") {
<<<<<<< HEAD
			               	echo "<td style='width:100px;'><img class='img-responsivee' style='width:80px; height:80px;' src='../assets/img/soccer1.png'> <br> </td>";
			               }else{
			               	 echo "<td style='width:100px;'><img class='img-responsivee' style='width:80px; height:80px;' src='images/grupos/".$otros_grupos[0]."/".$otros_grupos[2]."'> <br> </td>";
			               }
			               			               
			                  echo  "<td style='font-size: 14px;'><a href='perfil.php?op=grupos&id=".$otros_grupos[0]."'><span style='font-size: 11px; font-weight: bold;'>".strtoupper($otros_grupos[1])." &nbsp; &nbsp; <i  class='icon-user'> ".$b[$i]." Integrantes</i> </span><br> </a> <br> Miembro desde : ".date('d-m-Y',strtotime($otros_grupos[3]))."<br> Administrado Por : ".$otros_grupos[4]." ".$otros_grupos[5]."</td>";
   
			                  echo "<td style='width:9.43px;'></td>";

=======
			               	echo "<td style='width:70px;'><img class='img-circle' style='width:60px; height:60px;' src='../assets/img/soccer1.png'> <br> </td>";
			               }else{
			               	 echo "<td style='width:70px;'><img class='img-circle' style='width:60px; height:60px;' src='images/grupos/".$otros_grupos[0]."/".$otros_grupos[2]."'> <br> </td>";
			               }
			               			               
			                  echo  "<td style='font-size: 10px; align:justify' >
			                  		<a href='perfil.php?op=grupos&id=".$otros_grupos[0]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($otros_grupos[1])."</span></a>
			                  			&nbsp; &nbsp; ( <i class='icon-user'></i>  ".$b[$i]." Miembros)<br>
			                  		Miembro desde ".date('d-m-Y',strtotime($otros_grupos[3]))."<br>
			                  		Administrado por ".$otros_grupos[4]." ".$otros_grupos[5]."</td>";
>>>>>>> dba83555b3872bf16a9303d84ed5309309f6623d
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

