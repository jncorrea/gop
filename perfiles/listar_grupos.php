  <?php 

extract($_GET);

?>

<h3 class="page-title">
     INFORMACI&Oacute;N<small>  Grupos</small>
</h3>

		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab_1_todos" data-toggle="tab" aria-expanded="true">
				Mis Grupos </a>
			</li>
			
		</ul>
<div class="portlet light">

		<div class="portlet-body">
			<!--BEGIN TABS-->

			<div class="tab-content">
			<div class="tab-pane active" id="tab_1_todos">
					
				<div class="row">		
				<div class="col-md-6 col-sm-6">

					<div class="portlet-title">
						<div class="caption">
							<strong>GRUPOS QUE ADMINISTRAS</strong> 
						</div>
					<br>					
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
	<div class="tab-pane" id="listar_grupos">
      <div class="row"  style="padding-top:20px; padding-right: 10px; padding-left: 10px;">
        <div class="scroller" style="height: px" data-always-visible="1" data-rail-visible1="1">   
          <table class="table table-hover">

			            <?php
			            $miconexion->consulta("select * from grupos where id_user='".$_SESSION['id']."'");
			            for ($i=0; $i < $miconexion->numregistros(); $i++) { 
			              $grupo=$miconexion->consulta_lista();

			                echo "<tr >";
			                echo '<td class="btn-group pull-right" style="padding-left:2px; padding-right:10px;">';
		                  ?>
		                  <a title="Eliminar Grupo" data-toggle="modal" onclick="eliminar(<?php echo $grupo[0] ?>);" href="#eliminar_grupo" style="display:inline-block; background-color:transparent; margin: 0;padding: 0;">
		                    <i style="font-size:14px;" class="icon-remove"></i>
		                  </a>
		                  <?php

			               if ($grupo[3]=="") {
			               	echo "<td style='width:70px;'><img class='img-circle' style='width:60px; height:60px;' src='../assets/img/soccer1.png'> <br> </td>";
			               }else{
			               	 echo "<td style='width:70px;'><img class='img-circle' style='width:60px; height:60px;' src='images/grupos/".$grupo[0]."/".$grupo[3]."'> <br> </td>";
			               }
			               			               
			                  echo  "<td style='font-size: 10px;'><br>
			                  			<a href='perfil.php?op=grupos&id=".$grupo[0]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($grupo[2])."</span></a>
			                  			&nbsp; &nbsp; ( <i class='icon-user'></i>  ".$datos[$i]." Miembros)<br>
			                  			Creado: ".date('d-m-Y',strtotime($grupo[4]))."</td>";
		              
			                echo "</tr>";

			              }
			             ?>  

			                       
			        </table>               
        </div>
      </div>
    </div>
					
			    </div>
				

				<div class="col-md-6 col-sm-6">

					<div class="portlet-title">
						<div class="caption">
							<strong>GRUPOS A LOS QUE PERTENECES</strong> 
					</div>
					<br>					
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
	<div class="tab-pane" id="listar_grupos_otros">
      <div class="row"  style="padding-top:20px; padding-right: 10px; padding-left: 10px;">
        <div class="scroller" style="height: px" data-always-visible="1" data-rail-visible1="1">   
        	<table class="table table-hover">

			            <?php
			          $miconexion->consulta("select ug.id_grupo, g.nombre_grupo, g.logo, ug.fecha_inv, u.nombres, u.apellidos, u.user from user_grupo ug, grupos g, usuarios u where g.id_grupo=ug.id_grupo and ug.estado_conec='1' and  ug.id_user='".$_SESSION['id']."' and u.id_user=g.id_user and ug.id_grupo not in (select g.id_grupo from grupos g where g.id_user='".$_SESSION['id']."')");

			            for ($i=0; $i < $miconexion->numregistros(); $i++) { 
			              $otros_grupos=$miconexion->consulta_lista();
			               echo "<tr >";
			                
			               if ($otros_grupos[2]=="") {
			               	echo "<td style='width:70px;'><img class='img-circle' style='width:60px; height:60px;' src='../assets/img/soccer1.png'> <br> </td>";
			               }else{
			               	 echo "<td style='width:70px;'><img class='img-circle' style='width:60px; height:60px;' src='images/grupos/".$otros_grupos[0]."/".$otros_grupos[2]."'> <br> </td>";
			               }
			               if ($otros_grupos[4]!="") {

			               	 echo  "<td style='font-size: 10px; align:justify' >
			                  		<a href='perfil.php?op=grupos&id=".$otros_grupos[0]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($otros_grupos[1])."</span></a>
			                  			&nbsp; &nbsp; ( <i class='icon-user'></i>  ".$b[$i]." Miembros)<br>
			                  		Miembro desde ".date('d-m-Y',strtotime($otros_grupos[3]))."<br>
			                  		Administrado por: ".$otros_grupos[4]." ".$otros_grupos[5]."</td>";
			                echo "</tr>";

			               }else{
			               	 echo  "<td style='font-size: 10px; align:justify' >
			                  		<a href='perfil.php?op=grupos&id=".$otros_grupos[0]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($otros_grupos[1])."</span></a>
			                  			&nbsp; &nbsp; ( <i class='icon-user'></i>  ".$b[$i]." Miembros)<br>
			                  		Miembro desde ".date('d-m-Y',strtotime($otros_grupos[3]))."<br>
			                  		Administrado por: ".$otros_grupos[6]."</td>";
			                echo "</tr>";
			               }		               			               
			              }
			             ?> 			             
			        </table>                       
        </div>
      </div>
    </div>
			    
				</div>
				
				</div>	
			</div>				
			
			</div>
			<!--END TABS-->
		</div>
</div> 
<div class="modal fade" id="eliminar_grupo" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="">Eliminar Grupo</h4>
      </div>
      <div class="modal-body">
        Est&aacute; seguro de eliminar este grupo?
        <br>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="del">
        <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
        <a data-toggle="modal" href="#" class="btn green-haze" style="background:#C42E35;" data-dismiss="modal" onclick="borrar_grupo(<?php echo $grupo[0] ?>);">Aceptar</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script>
	
	function borrar_grupo(id){
actualizar_notificacion(1, id);
}

</script>


