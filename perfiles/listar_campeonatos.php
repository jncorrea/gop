  <?php 
  include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);

session_start();

date_default_timezone_set('America/Guayaquil');
extract($_GET);

?>

<h3 class="page-title">
     INFORMACI&Oacute;N<small>  Campeonatos</small>
</h3>

		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab_1_todos" data-toggle="tab" aria-expanded="true">
				Mis Campeonatos </a>
			</li>
			
		</ul>
<div class="portlet light">

		<div class="portlet-body">
			<!--BEGIN TABS-->

			<div class="tab-content">
			<div class="tab-pane active" id="tab_1_camp">
					
				<div class="row">		
				<div class="col-md-6 col-sm-6">

					<div class="portlet-title">
						<div class="caption">
							<strong>CAMPEONATOS QUE ADMINISTRAS</strong> 
						</div>
					<br>					
					</div>

					<?php 
					@$contador[0]="";
					$miconexion->consulta("select * from campeonatos where id_user='".$_SESSION['id']."'");
					
					if ($miconexion->numregistros()==0) {
						echo "<h4> A&uacute;n no administras un campeonato</h4>";
					}else{
						
						$nom=$miconexion->consulta_lista();
						for ($i=0; $i < $miconexion->numregistros(); $i++) { 
						    $campeonato=$miconexion->consulta_lista();
						}						

					?>
	<div class="tab-pane" id="listar_campeonatos_c">
      <div class="row"  style="padding-top:20px; padding-right: 2px; padding-left: 2px;">
        <div class="scroller" style="height: px" data-always-visible="1" data-rail-visible1="1">   
          <table class="table table-hover">

			            <?php
			            $miconexion->consulta("select * from campeonatos where id_user='".$_SESSION['id']."'");
			            for ($i=0; $i < $miconexion->numregistros(); $i++) { 
			              $campeonato=$miconexion->consulta_lista();

			                echo "<tr >";
			                echo '<td class="btn-group pull-right" style="padding-left:2px; padding-right:10px;">';
		                  ?>
		                  <a title="Eliminar Campeonato" data-toggle="modal" onclick="eliminar(<?php echo $campeonato[0] ?>);" href="#eliminar_campeonato" style="display:inline-block; background-color:transparent; margin: 0;padding: 0;">
		                    <i style="font-size:14px;" class="icon-remove"></i>
		                  </a>
		                  <?php

			                echo "<td style='width:70px;'><img class='img-circle' style='width:50px; height:50px;' src='../assets/img/trofeo.png'> <br> </td>";
			                echo  "<td style='font-size: 10px;'><br>
			                  			<a href='perfil.php?op=campeonato&id=".$campeonato[0]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($campeonato[1])."</span></a>
			                  			<br> 
			                  			</td>";		              
			                echo "</tr>";
			              }
			             ?>  

			        </table>               
        </div>
      </div>
    </div>

    <?php
	}
    ?>
					
			    </div>				
				<div class="col-md-6 col-sm-6">
					<div class="portlet-title">
						<div class="caption">
							<strong>CAMPEONATOS A LOS QUE PERTENECES</strong> 
					</div>
					<br>					
					</div>

					<?php 
					$miconexion->consulta("select distinct id_campeonato from grupos_campeonato where id_grupo in (select id_grupo from user_grupo where id_user=".$_SESSION['id'].") and id_campeonato not in (select id_campeonato from campeonatos where id_user=".$_SESSION['id'].")");
					$num_campeonatos=$miconexion->numregistros();					
					if ($num_campeonatos==0) {
						echo "<h4> A&uacute;n no Perteneces a otros Campeonatos</h4>";
					}else{
						for ($i=0; $i <$num_campeonatos ; $i++) {
							$lista_campeonatos_=$miconexion->consulta_lista(); 
							$otros_campeonatos[$i]=$lista_campeonatos_[0];							
						}										
					?>
	<div class="tab-pane" id="listar_campeonatos_otros">
      <div class="row"  style="padding-top:20px; padding-right: 10px; padding-left: 10px;">
        <div class="scroller" style="height: px" data-always-visible="1" data-rail-visible1="1">   
        	<table class="table table-hover">

			<?php			          
			for ($i=0; $i < $num_campeonatos; $i++) { 
			    $miconexion->consulta("select c.nombre_campeonato, u.user, u.email, u.nombres, u.apellidos from campeonatos c, usuarios u where c.id_campeonato=".$otros_campeonatos[$i]." and c.id_user=u.id_user");
			    $informacion_campeonato=$miconexion->consulta_lista();
			    echo "<tr >";			                
			    echo "<td style='width:70px;'><img class='img-circle' style='width:60px; height:60px;' src='../assets/img/trofeo.png'> <br> </td>";			               
			    echo  "<td style='font-size: 10px; align:justify' >
			    	<a href='perfil.php?op=campeonato&id=".$otros_campeonatos[$i]."'><span style='font-size: 13px; color: #006064; font-weight: bold;'>".strtoupper($informacion_campeonato[0])."</span></a>
			        	<br><h5>Campeonato Administrado por Administrado por: ".$informacion_campeonato[1]." <br>
			        	".$informacion_campeonato[2]." <br> ".$informacion_campeonato[3]." ".$informacion_campeonato[4]."</h5></td>";
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
<div class="modal fade" id="eliminar_campeonato" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="">Eliminar Campeonato</h4>
      </div>
      <div class="modal-body">
        Est&aacute; seguro de eliminar este campeonato?
        <br>
			<p style="font-size:90%;">
			Se eliminaran todos los datos asociados con este campeonato, como etapas y sus partidos.
			</p>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="del">
        <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
        <a data-toggle="modal" href="#" class="btn green-haze" style="background:#C42E35;" data-dismiss="modal" onclick="borrar_campeonato(<?php echo $campeonato[0] ?>);">Aceptar</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script>
	
	function borrar_campeonato(id){
actualizar_notificacion(38, id);
}

</script>


