  <?php 
header('Content-Type: text/html; charset=ISO-8859-1');
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
session_start();
extract($_GET);

global $ahora;                  
$ahora = date("Y-m-d H:i:s", time());

?>

<h3 class="page-title">
     INFORMACI&Oacute;N<small> Partidos</small>
</h3>
		
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#col_listar_partidos" data-toggle="tab" aria-expanded="true">
				Mis Partidos </a>
			</li>
			
		</ul>

		<div class="portlet light">
			
		<div class="portlet-body">
			<!--BEGIN TABS-->

			<div class="tab-content">
			<div class="tab-pane active" id="tab_1_partidos">
					
				<div class="row">		
				<div class="col-md-6 col-sm-6">

					<div class="portlet-title">
						<div class="caption">
							<strong>PARTIDOS POR JUGAR</strong> 
						</div>
					</div>

					<?php 
					
					$miconexion->consulta("select p.id_grupo, p.id_partido, p.fecha_partido, p.hora_partido, p.estado_partido, p.nombre_partido, p.id_centro
        		FROM partidos p, alineacion a
        		WHERE p.id_partido = a.id_partido and a.id_user ='".$_SESSION['id']."' and a.estado_alineacion != '2'  and p.fecha_partido>='".$ahora."'  ORDER BY p.fecha_partido ASC");
					//En este for se almacena todos los id de los centros deportivos
					for ($i=0; $i <$miconexion->numregistros(); $i++) {
						@$lista_id_centros=$miconexion->consulta_lista();  
						@$ids_centros[$i]=$lista_id_centros[6];
					}
					//for para obtener los nombres de los centros
					for ($i=0; $i <count(@$ids_centros) ; $i++) { 
						$miconexion->consulta("select centro_deportivo from centros_deportivos where id_centro='".@$ids_centros[$i]."'");
						@$lista_nombre_centros=$miconexion->consulta_lista();
						@$nombres_centros[$i]=$lista_nombre_centros[0];
					}
					
					$miconexion->consulta("select p.id_grupo, p.id_partido, p.fecha_partido, p.hora_partido, p.estado_partido, p.nombre_partido, p.id_centro
        		FROM partidos p, alineacion a
        		WHERE p.id_partido = a.id_partido and a.id_user ='".$_SESSION['id']."' and a.estado_alineacion != '2'  and p.fecha_partido>='".$ahora."'  ORDER BY p.fecha_partido ASC");
					
					if ($miconexion->numregistros()==0) {
						echo "<br> <h4> Actualmente no existen partidos por jugar. </h4>";
					}else{
						echo '<table class="table table-hover">';

						for ($i=0; $i <$miconexion->numregistros(); $i++) {
						$lista_partidos=$miconexion->consulta_lista(); 						
					?>					
					<table class="table table-hover">
			            <?php
			            //SUB-CONSULTAS 
			            $estado="";
			            if ($lista_partidos[4]==0) {
			            	$estado="Cancelado";
			            	
			            }else{
			            	$estado="Activo";
			            }
			                 echo "<tr >";			                 
				              echo "<td style='width:40px;'><img class='img-circle' style='width:30px; height:30px;' src='../assets/img/pupos.png'> <br> </td>";
			                  echo  "<td style='font-size: 12px;'><br>
			                  			<a href='perfil.php?op=alineacion&id=".$lista_partidos[1]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($lista_partidos[5])."</span></a>
			                  			&nbsp; &nbsp;<br>
			                  			Fecha: ".date('d-m-Y',strtotime($lista_partidos[2]))."<br>
			                  			Centro Deportivo: ".$nombres_centros[$i]."
			                  			<br>Estado: ".$estado." </td>";		              
			                echo "</tr>";
			        	 }
			        }			              

			             ?>  			                       
			        </table>
			    </div>			

				<div class="col-md-6 col-sm-6">

					<div class="portlet-title">
						<div class="caption">
							<strong>PARTIDOS JUGADOS</strong> 
					</div>
										
					</div>

					<?php 
						
					
					$miconexion->consulta("select p.id_grupo, p.id_partido, p.fecha_partido, p.hora_partido, p.estado_partido, p.nombre_partido, p.id_centro
        		FROM partidos p, alineacion a
        		WHERE p.id_partido = a.id_partido and a.id_user ='".$_SESSION['id']."'  and p.fecha_partido<'".$ahora."'  ORDER BY p.fecha_partido ASC");

					for ($i=0; $i <$miconexion->numregistros(); $i++) {
						@$lista_id_centros=$miconexion->consulta_lista();  
						@$ids_centros[$i]=@$lista_id_centros[6];
					}
					//for para obtener los nombres de los centros
					for ($i=0; $i <count(@$ids_centros) ; $i++) { 
						$miconexion->consulta("select centro_deportivo from centros_deportivos where id_centro='".$ids_centros[$i]."'");
						@$lista_nombre_centros=$miconexion->consulta_lista();
						@$nombres_centros[$i]=$lista_nombre_centros[0];
					}

					$miconexion->consulta("select p.id_grupo, p.id_partido, p.fecha_partido, p.hora_partido, p.estado_partido, p.nombre_partido, p.equipo_a, p.equipo_b, p.res_a, res_b
        		FROM partidos p, alineacion a
        		WHERE p.id_partido = a.id_partido and a.id_user ='".$_SESSION['id']."'  and p.fecha_partido<'".$ahora."'  ORDER BY p.fecha_partido ASC");


					
					if ($miconexion->numregistros()==0) {
						echo "<br><h4> Actualmente no se registran partidos jugados. </h4>";
					}else{
						echo '<table class="table table-hover">';

						for ($i=0; $i <$miconexion->numregistros(); $i++) {
						$lista_partidos=$miconexion->consulta_lista(); 						
					

					?>					
					<table class="table table-hover">
			            <?php
			            if ($lista_partidos[8]=="") {
			            	$res_A="Sin registrar";
			            }else{
			            	$res_A=$lista_partidos[8];
			            }
			            if ($lista_partidos[9]=="") {
			            	$res_B="Sin registrar";
			            }else{
			            	$res_B=$lista_partidos[9];
			            }
			                echo "<tr >";			                 
				              echo "<td style='width:40px;'><img class='img-circle' style='width:30px; height:30px;' src='../assets/img/pupos.png'> <br> </td>";
			                  echo  "<td style='font-size: 12px;'><br>
			                  			<a href='perfil.php?op=alineacion&id=".$lista_partidos[1]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($lista_partidos[5])."</span></a>
			                  			&nbsp; &nbsp;<br>
			                  			Fecha: ".date('d-m-Y',strtotime($lista_partidos[2]))."
			                  			<br>Centro Deportivo: ".$nombres_centros[$i]."
			                  			<br>Resultados: <br> ".$lista_partidos[6]." : ".$res_A." <br> ".$lista_partidos[7]." : ".$res_B."  </td>";		              
			                echo "</tr>";
			        	 }
			        }

			              

			             ?>  

			                       
			        </table>
			    </div>				
				
				</div>	
			</div>				
			
			</div>
			<!--END TABS-->
		</div>
</div> 

