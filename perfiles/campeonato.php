<?php
	$miconexion->consulta("select * from campeonatos where id_campeonato ='".$id."' ");                 
	$campeonato=$miconexion->consulta_lista();
?>
<link href="../assets/css/table-responsive.css" rel="stylesheet">

<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="perfil.php">Home</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="perfil.php?op=listar_campeonatos">Mis Campeonatos</a>
			<i class="icon-angle-right"></i>			
		</li>
		<li>
			<a href="#"><?php echo $campeonato[1] ?></a>		
		</li>
	</ul>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
		<h3 class="page-title">
			<?php echo "Campeonatos " //$campeonato[1] ?> <small>Organizaci&oacute;n</small>
		</h3>
	<div class="clearfix">
	</div>
	<div class="portlet light" id="print">
		<div class="portlet-title tabbable-line">
			<div class="caption" style="margin-left:10%;">
		      	<h3 style="text-align:center; margin:0px;"><img style="width:40px; height:40px;" src="../assets/img/trofeo.png" class="pupos"> <?php echo $campeonato[1]?>
					<?php if ($campeonato[4]==$_SESSION['id']){ ?>
		    			<a data-toggle="modal" href="#edit_campeonato" title="Editar Campeonato" style="z-index:4; font-size:15px;"><i style="font-size:130%" class="icon-pencil"></i></a>					
					<?php } ?>
			    </h3>
			</div>
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab_1_1" data-toggle="tab" aria-expanded="true">
				Organizaci&oacute;n </a>
			</li>
			<li class="">
				<a href="#tab_1_2" data-toggle="tab" aria-expanded="false">
				Tabla de Posiciones </a>
			</li>
			<li class="">
				<a href="#tab_1_3" data-toggle="tab" aria-expanded="false">
				Participantes </a>
			</li>
		</ul>
		</div>
		<div class="portlet-body">
			<!--BEGIN TABS-->
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1_1">
					<?php    
					    $miconexion->consulta("select id_grupo, nombre_grupo, logo from grupos");            
					    for ($i=0; $i < $miconexion->numregistros(); $i++) { 
					        $datos=$miconexion->consulta_lista();
					        $grupos[$datos[0]]=$datos[1];
					        $grupos_img[$datos[0]]=$datos[2];
					    }
					?>
					<div class="table-scrollable">
					    <table class="table table-hover table-light">
					        <thead>
					            <tr>
					                <th width="10" > # </th>
					                <th> Partidos </th>
					                <?php if ($_SESSION['id'] == $campeonato[4]) {
					                	echo '<th width="5" > Nuevo </th>';
					                } 
					                 ?>
					            </tr>
					        </thead>
					        <tbody>
					            <?php                
					                $miconexion->consulta("select id_etapa, etapa FROM etapas WHERE id_campeonato = ".$id);
					                for ($i=0; $i < $miconexion->numregistros(); $i++) { 
					                    $datos=$miconexion->consulta_lista();
					                    $etapas[$i]=$datos[0];
					                }
					                for ($i=0; $i < count($etapas); $i++) {    
					            ?>
					            <tr>
					                <td> <?php echo "Etapa".($i+1) ?> </td>
					                <td>
					                    <?php 
					                        $miconexion->consulta("select p.id_partido, p.nombre_partido, p.equipo_a, p.equipo_b, p.fecha_partido, p.hora_partido, p.res_a, p.res_b from partidos p, etapa_partidos ep where p.id_partido = ep.id_partido and ep.id_etapa = ".$etapas[$i]);
					                        for ($j=0; $j < $miconexion->numregistros(); $j++) { 
					                            $partidos=$miconexion->consulta_lista();
					                            $fecha = date("d M Y",strtotime($partidos[4]));
					                            $hora = date("H:i",strtotime($partidos[5]));
					                     ?>                    
					                        <div class="dashboard-stat2 col-lg-4 col-md-4 col-sm-4 col-xs-12 user-info" style="border: 1px solid #dddddd; padding-bottom: 1px;">
					                            <div class="display">
					                                <div class="number">
					                                    
					                                    <?php 
					                                        $fecha_p = date("Y-m-d H:i:s", strtotime($partidos[4]." ".$partidos[5]."-0500"));
					                                        if ($fecha_p > date("Y-m-d H:i:S", time()) ){
					                                     ?>
					                                        <icon title="Por Jugar" class ='icon-circle' style = "color : #D8BD2A; Font-size: 11px;"></icon> <small title="<?php echo $partidos[1]; ?>"><?php echo nombres($partidos[1],13) ?></small><br><small style="font-size:70%;"><?php echo $fecha." ".$hora; ?></small>
					                                    <?php }else{ ?>
					                                        <icon title="Jugado" class ='icon-circle' style = "color : #4CAF50; Font-size: 11px;"></icon> <small title="<?php echo $partidos[1]; ?>"><?php echo nombres($partidos[1],13) ?></small><br><small style="font-size:70%;"><?php echo $fecha." ".$hora; ?></small> 
					                                    <?php } ?>                                
					                                </div>
					                                <div class="icon">
					                                	<?php if ($campeonato[4]==$_SESSION['id']) { ?>
					                                    	<a title="Editar Partido" onclick='actualizar_notificacion(35,<?php echo $partidos[0]; ?>);'><span class="icon-pencil"></span></a>
					                                	<?php }else{ ?>
					                                    	<a title="M&aacute;s Informaci&oacute;n" data-toggle="modal" href="#ver_partido_campeonato"  onclick='actualizar_notificacion(40,<?php echo $partidos[0]; ?>);'><span class="icon-eye-open"></span></a>
					                                	<?php } ?>
					                                </div>
					                            </div>
					                            <div class="progress-info">
					                                <div class="row list-separated profile-stat" style="text-align:center;">
					                                    <div class="col-md-5 col-sm-4 col-xs-4">
					                                        <small title="<?php echo $grupos[$partidos[2]]; ?>" style="font-size:75%;"><?php echo nombres($grupos[$partidos[2]],8); ?> </small>
					                                        <p>(<?php if ($partidos[6]=="" || $partidos[6]==null) {
					                                        	echo "-"; 
					                                        }else{
					                                        	echo $partidos[6]; 					                                        	
					                                        }?>)</p>
					                                        <?php 
					                                            if ($grupos_img[$partidos[2]]=="") { ?>
					                                                <img class='img-circle' style='margin-left:10%; width:60px; height:60px;' src='../assets/img/soccer1.png'>
					                                            <?php }else{ ?>
					                                                <img class='img-circle' style='margin-left:10%; width:60px; height:60px;' src='<?php echo "images/grupos/"."$partidos[2]".$grupos_img[$partidos[2]] ?>'>
					                                        <?php } ?>
					                                    </div>
					                                    <div class="col-md-2 col-sm-2 col-xs-2">
					                                        <br>VS                                        
					                                    </div>
					                                    <div class="col-md-5 col-sm-4 col-xs-4">
					                                        <small title="<?php echo $grupos[$partidos[3]]; ?>" style="font-size:75%;"><?php echo nombres($grupos[$partidos[3]],8); ?></small>
					                                        <p>(<?php if ($partidos[7]=="" || $partidos[7]==null) {
					                                        	echo "-"; 
					                                        }else{
					                                        	echo $partidos[7]; 					                                        	
					                                        }?>)</p>
					                                        <?php 
					                                            if ($grupos_img[$partidos[3]]=="") { ?>
					                                                <img class='img-circle' style='margin-left:10%; width:60px; height:60px;' src='../assets/img/soccer1.png'>
					                                            <?php }else{ ?>
					                                                <img class='img-circle' style='margin-left:10%; width:60px; height:60px;' src='<?php echo "images/grupos/"."$partidos[3]".$grupos_img[$partidos[3]] ?>'>
					                                        <?php } ?>
					                                    </div>
					                                </div>
					                            </div>
					                            <?php if ($_SESSION['id'] == $campeonato[4]) { ?>
									                <div class="display">
						                                <div class="icon">
						                                    <a title="Eliminar Partido" data-toggle="modal" onclick="eliminar(<?php echo $partidos[0]; ?>);" href="#eliminar_partido"><span class="icon-remove"></span></a>
						                                </div>
						                            </div>									                                   
								                <?php } ?>
					                        </div> 
					                    <?php } ?>
					                </td>
					                <?php if ($_SESSION['id'] == $campeonato[4]) { ?>
						                <td>
						                	<?php if ($campeonato[3]=="contra_todos") { ?>
						                    	<a class="btn green-haze" onclick="set_etapa('<?php echo $etapas[$i]; ?>')" data-toggle="modal" href="#nuevo_partido" title="Nuevo Partido" style="background:#4CAF50; float: right; border-radius: 50% !important; margin-right:20px;"><i class="icon-plus"></i></a>                    
						                	<?php } elseif ($campeonato[3]=="eliminatoria"){ ?>
						                    	<a class="btn green-haze" onclick="set_etapa_eliminatoria(<?php echo $etapas[$i]; ?>,'<?php echo $i; ?>');" data-toggle="modal" href="#nuevo_partido" title="Nuevo Partido" style="background:#4CAF50; float: right; border-radius: 50% !important; margin-right:20px;"><i class="icon-plus"></i></a>                    
						                	<?php } ?>
						                </td>                    
					                <?php } ?>
					            </tr>
					            <?php }  ?>
					        </tbody>
					    </table>
					</div>

					<div class="modal fade" id="nuevo_partido" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
					    <div class="modal-dialog">
					     <div class="modal-content">
					      <div class="modal-header">
					       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					       <h4 class="modal-title">Nuevo Partido</h4>
					      </div>
					      <div class="modal-body">
					        <div class="portlet-title">
					          <div class="caption">
					            <i class="icon-bubble font-red-sunglo"></i>
					            <span style="color: red; font-size:11px; padding:10px;">
					              * Campos requeridos
					            </span>
					          </div>
					        </div>
					        <hr>
					        <form  method="post" action="" id="form_nuevo_evento" enctype="multipart/form-data" class="form-horizontal">
					          <input type="hidden" name="bd" value="2">
					          <div class="form-group">
					            <label for="Nombre_Partido" class="col-xs-12 col-sm-2 control-label" required><span style="color:red;">* </span>Nombre del Partido:</label>
					            <div class="col-sm-9" style="padding-top:12px;">
					              <input type="text" class="form-control" id="nombre" name="nombre_partido" placeholder="Da un nombre al partido..">
					            </div>
					          </div>
					          <div class="form-group">
					            <label for="Descripcion" class="col-xs-12 col-sm-2 control-label">Descripci&oacute;n:</label>
					            <div class="col-sm-9">
					              <textarea type="text" class="form-control" id="descripcion" name="descripcion_partido" placeholder="Describe tu partido.."></textarea>
					            </div>
					          </div>
					            <div class="form-group">
					              <label for="Fecha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Cuando: </label>
					              <div class="col-xs-12 col-sm-4" id="datepairExample">
					                <input type="text" class="date start form-control" id="dateformatExample" name="fecha_partido" placeholder="yyyy-mm-dd" min="08-10-2015" required />
					              </div>
					              <label for="Hora" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Hora: </label>
					              <div class="col-xs-12 col-sm-3">
					                <input type="text" class="time start form-control" id="timeformatExample" name="hora_partido" data-scroll-default="12:00:00" placeholder="00:00:00" required/>
					              </div>
					              <div id="alerta"></div>
					            </div>   
					            <div id="error" style="margin-left:5%; color:red; font-size:90%;"></div>
					            <br>
					            <article>                      
					            <script>     
					                $('#datepairExample .date').datepicker({
					                    'format': 'yyyy-m-d',
					                    'autoclose': true,                        
					                });
					                $(function() {
					                    $( "#dateformatExample" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
					                    $( "#dateformatExample" ).datepicker( "option", "yearRange", "-99:+0" );
					                    $( "#dateformatExample" ).datepicker( "option", "minDate", "+0m +0d" );
					                    $( "#dateformatExample" ).datepicker('setDate', new Date());
					                });           
					            </script> 
					            <script>
					                $(function() {
					                  $('#timeformatExample').timepicker({ 'timeFormat': 'H:i:s'});
					                });
					            </script>
					          </article>          
					          <div class="form-group" id="Equipos">
					            <label for="equipoA" class="col-xs-12 col-sm-2 control-label">Equipos:</label>
					            <div class="col-xs-5 col-sm-4" id="listado_EquiposA">
					                <select style="border-radius:5px;" id="equipoA" name="equipo_a" class="form-control">
					                    <?php if ($campeonato[3]=="contra_todos") {
					                    	$miconexion->consulta("select g.id_grupo, g.nombre_grupo from grupos_campeonato c, grupos g where c.id_grupo = g.id_grupo and c.id_campeonato=".$id);
					                        $miconexion->opciones(0);
					                     }elseif ($campeonato[3]=="eliminatoria"){ 
					                     	$miconexion->consulta("select p.id_partido, p.equipo_a, p.equipo_b from etapas e, etapa_partidos ep, partidos p 
					                     							where e.id_etapa = ep.id_etapa and e.id_campeonato = ".$id." and e.etapa = '1' 
					                     							and p.id_partido = ep.id_partido");
					                     	$a = 0;
					                     	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
									          @$partidos=$miconexion->consulta_lista();
									          @$grupos_partido[$a] = $partidos[1];
									          @$grupos_partido[$a+1] = $partidos[2];
									          $a=$a+2;									          
									    	}
									    	$miconexion->consulta("select c.id_grupo, g.nombre_grupo from grupos_campeonato c, grupos g where g.id_grupo = c.id_grupo and id_campeonato = ".$id);
					                     	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
									          $grupo=$miconexion->consulta_lista();
									          $bandera = 0;
									          for ($j=0; $j < count(@$grupos_partido); $j++) {
									        	if (@$grupo[0]==@$grupos_partido[$j]) {
									        		$bandera =1;
									        	}
									          }
									          if ($bandera !=1) {
									          		echo "<option value='".@$grupo[0]."'>".$grupo[1]."</option>";
									          	}	
									    	}
									    } ?>
					                </select>
					            </div>
					            <label for="equipoB" class="col-xs-1 col-sm-1 control-label">vs. </label>
					            <div class="col-xs-5 col-sm-4" id="listado_EquiposB">
					                <select style="border-radius:5px;" id="equipoB" name="equipo_b" class="form-control">
					                    <?php if ($campeonato[3]=="contra_todos") {
					                    	$miconexion->consulta("select g.id_grupo, g.nombre_grupo from grupos_campeonato c, grupos g where c.id_grupo = g.id_grupo and c.id_campeonato=".$id);
					                        $miconexion->opciones(0);
					                    }elseif ($campeonato[3]=="eliminatoria"){ 
					                    	$miconexion->consulta("select p.id_partido, p.equipo_a, p.equipo_b from etapas e, etapa_partidos ep, partidos p 
					                     							where e.id_etapa = ep.id_etapa and e.id_campeonato = ".$id." and e.etapa = '1' 
					                     							and p.id_partido = ep.id_partido");
					                     	$a = 0;
					                     	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
									          @$partidos=$miconexion->consulta_lista();
									          @$grupos_partido[$a] = $partidos[1];
									          @$grupos_partido[$a+1] = $partidos[2];
									          $a=$a+2;									          
									    	}
									    	$miconexion->consulta("select c.id_grupo, g.nombre_grupo from grupos_campeonato c, grupos g where g.id_grupo = c.id_grupo and id_campeonato = ".$id);
					                     	for ($i=0; $i < $miconexion->numregistros(); $i++) { 
									          $grupo=$miconexion->consulta_lista();
									          $bandera = 0;
									          for ($j=0; $j < count(@$grupos_partido); $j++) {
									        	if (@$grupo[0]==@$grupos_partido[$j]) {
									        		$bandera =1;
									        	}
									          }
									          if ($bandera !=1) {
									          		echo "<option value='".@$grupo[0]."'>".$grupo[1]."</option>";
									          	}	
									    	}
					                    } ?>
					                </select>
					            </div>
					          </div>               
					          <div id="respuesta"></div>
					                <input type="hidden" name="id_campeonato" value="<?php echo $id; ?>">
					            <input type="hidden" id="id_etapa" name="etapa">
					        </form>
					      </div>
					      <div class="modal-footer">
					       <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
					        <button type="button" class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/insertar_evento.php","form_nuevo_evento");'>Guardar</button>
					      </div>
					     </div>
					     <!-- /.modal-content -->
					    </div>
					    <!-- /.modal-dialog -->
					</div>
				</div>
				<div class="tab-pane" id="tab_1_2">
					<?php
					include('tabla_posiciones.php');
					?>
				</div>
				<div class="tab-pane" id="tab_1_3">
					<?php include("participantes.php"); ?>
				</div>
			</div>
			<!--END TABS-->
		</div>
	</div>
	<div class="clear-fix"></div>
		<!-- BEGIN PORTLET -->
	<div class="portlet light">
		<div class="portlet-title">
			<!-- -->
			<form method="post" action="" enctype="multipart/form-data" class="form-horizontal" id="form_comentarios">
			<?php
			      date_default_timezone_set('America/Lima');				      
			      echo "<input type='hidden' name='bd' value='comentarios'>";
			      echo "<input type='hidden' name='id_user' value='".$_SESSION["id"]."'>";
			      echo "<input type='hidden' name='id_campeonato' value=".$id.">";
			      echo "<input type='hidden' name='fecha_publicacion' id='fecha_actual'>";
			?>
			  <div class="form-group">    
			    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin:0px; padding:0px;">  
			      <?php 
			      $miconexion->consulta("select user, avatar, sexo from usuarios where id_user=".$_SESSION['id']);
				    $participantes=$miconexion->consulta_lista();
			      if ($participantes[1]==""){ 
					if ($participantes[2]=="Femenino") {
						echo '<img class="avatar img-circle" style="width:55px; height:55px; display:inline-block;" src="../assets/img/user_femenino.png" style="width:20%; heigth:50px;" class="img-responsive"></div>';
					}else{
						echo '<img class="avatar img-circle" style="width:55px; height:55px; display:inline-block;" src="../assets/img/user_masculino.png" style="width:20%; heigth:50px;" class="img-responsive"></div>';
		          	}
		        }else{ ?>
					<img class="avatar img-circle" style="width:55px; height:55px; display:inline-block;" src="<?php echo 'images/'.$participantes[0].'/'.$participantes[1] ?>"></div>								
				<?php } ?>     
			    <div class='col-lg-10 col-md-10 col-sm-10 col-xs-10'>
			      <textarea id="text_comentario" style="display:inline-block;" class="form-control" style="width:100%;" name="comentario" placeholder="Ingrese su comentario.." required></textarea>      
			    	<output id="img_comentario" style="text-align: center;"></output> 
			    </div>
			  </div>			  
                <div  class="form-group">
                  <div class="upload_wrapper" style="float: right; margin-right: 30px;" id="up0">
                    <img src="../assets/img/comen.png" style="height:30px;" alt="Adjuntar imagen"/>
                    <input style="width: 100px;height:100px;" id="imagen_comentario" name="image" type="file" class="upload" title="Adjuntar imagen"  accept="image/png, image/gif, image/jpg, image/jpeg"/>
                  </div>
                </div>
			  <div class="form-group">
			    <div class="col-sm-offset-2 col-sm-9">
				<button type="button" class="btn green-haze" style= "float:right; background:#4CAF50; border-radius: 10px !important;" onclick='enviar_form("../include/insertar_comentario.php","form_comentarios");'>Comentar</button>
			    </div>
			  </div>
			  <br>
			<ul id="respuesta"></ul>				
			</form>
		</div>

		<?php  $comen = 'c'; include("comentarios.php");  ?>
	</div>
</div>

	<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
		<h4>USUARIOS CONECTADOS</h4>
		<ul style="color:#ffff; list-style: none; padding:0px;">
		<div id = "col_chat"></div>
		</ul>
	</div>
</div>

<a data-toggle="modal" href="#edit_partido_campeonato" id="lanzar_EditarPartido"></a>
<div class="modal fade" id="edit_partido_campeonato" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	 <div class="modal-content">
	  <div class="modal-header">
	   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	   <h4 class="modal-title">Editar Partido</h4>
	  </div>
	  <div class="modal-body">
	    <?php $editar_cancelado="campeonato_partido"; include("editar_evento.php"); ?>
	  </div>
	  <div class="modal-footer">
	   <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/actualizar_evento.php","form_editar_evento"); limpiar_cambios();'>Guardar</button>
	  </div>
	 </div>
	 <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<a data-toggle="modal" href="#edit_campeonato_marcador" id="lanzar_EditarMarcador"></a>
<div class="modal fade" id="edit_campeonato_marcador" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	 <div class="modal-content">
	  <div class="modal-header">
	   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	   <h4 class="modal-title">Resultados</h4>
	  </div>
	  <div class="modal-body">
	    <?php $editar_cancelado="campeonato_marcador"; include("editar_evento.php"); ?>
	  </div>
	  <div class="modal-footer">
	   <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/actualizar_evento.php","form_editar_marcador"); limpiar_cambios();'>Guardar</button>
	  </div>
	 </div>
	 <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="ver_partido_campeonato" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	 <div class="modal-content">
	  <div class="modal-header">
	   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	   <h4 class="modal-title">Mas informaci&oacute;n</h4>
	  </div>
	  <div class="modal-body">
		<div class="row static-info">
			<div class="col-md-5 value">
					 Nombre del Partido:
				</div>
				<div class="col-md-7 name" id="nom_part">
				</div>
			</div>
			<div class="row static-info">
				<div class="col-md-5 value">
					Descripci&oacute;n del Partido:
				</div>
				<div class="col-md-7 name" id="descr_part">
				</div>
			</div>
			<div class="row static-info">
				<div class="col-md-5 value">
					Fecha:
				</div>
				<div class="col-md-7 name" id="fecha_part">
				</div>
			</div>
			<div class="row static-info">
				<div class="col-md-5 value">
					Equipos:
				</div>
				<div class="col-md-7 name" id="equipos_part">
				</div>
			</div>
			<div class="row static-info">
				<div class="col-md-5 value">
					Resultados:
				</div>
				<div class="col-md-7 name" id="res_part">
				</div>
			</div>
	  </div>
	  <div class="modal-footer">
	   <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
	  </div>
	 </div>
	 <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="edit_campeonato" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	 <div class="modal-content">
	  <div class="modal-header">
	   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	   <h4 class="modal-title">Editar Campeonato</h4>
	  </div>
	  <div class="modal-body">
	    <div class="portlet-title">
		  <div class="caption">
		    <i class="icon-bubble font-red-sunglo"></i>
		    <span style="color: red; font-size:11px; padding:10px;" id="mensaje_crear">
		      * Campos requeridos <br>
		    </span>
		  </div>
		</div>
		<div class="portlet-body" id="chats">
		  <div class="tab-content">
		  <div class="tab-pane active" id="general_c">
		    <!-- CANCHA INFO TAB -->
		    <form  method="post" action="" id="form_editar_campeonato" enctype="multipart/form-data" class="form-horizontal">
		      <input type="hidden" name="bd" value="2" id="compr_campeonato">
		      <div class="form-group">
		        <label for="nombre_campeonato" class="col-xs-12 col-sm-2 control-label" required><span style="color:red;">* </span>Nombre del Campeonato:</label>
		        <div class="col-sm-9" style="padding-top:12px;">
		        	<input type="hidden" name="id_campeonato" value="<?php echo $id; ?>">
		        	<input type="text" class="form-control" id="nombre_campeonato" name="nombre_campeonato" value="<?php echo $campeonato[1]; ?>" onchange="detectar_cambios_campeonato('nombre_campeonato')">
		        </div>
		      </div>
		      <div class="form-group">
		        <label for="Descripcion_c" class="col-xs-12 col-sm-2 control-label">Descripci&oacute;n:</label>
		        <div class="col-sm-9">
		        	<textarea type="text" class="form-control" id="descripcion_c" name="descripcion" placeholder="Describe el campeonato (Opcional) "  onchange="detectar_cambios_campeonato('descripcion')"><?php echo $campeonato[2]; ?></textarea>
	        		<br>
	        		<input type="checkbox" id="asignar_centroCampeonato" onchange="asignarCentroCampeonato(); detectar_cambios_campeonato('id_centro');"> Establecer un centro deportivo para el desarrollo del campeonato.
		        </div>
		      </div>
		      <div class="form-group" id="elegir_Centro">
	    		<label for="cancha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;"></span>Lugar: </label>
		          <div class="col-sm-9">
		            <select style="border-radius:5px;" id="id_centro" name="id_centro" class="form-control">
		            <?php 
		                $miconexion->consulta("select distinct(cd.id_centro), cd.centro_deportivo, cd.tiempo_alquiler from centros_deportivos cd, horarios_centros hc where cd.id_centro = hc.id_centro");
		                $miconexion->opciones(0);
		            ?>
		           </select>
		        </div>
		      </div>
		      <div class="form-group">
	    		<label for="cancha" class="col-xs-12 col-sm-12 control-label"><span style="color:red; font-size:85%;" id="mensaje_centro_campeonato"></span></label>
		      </div> 
		      <input type="hidden" name="cambios" id="cambios_campeonato">
		    </form>
		    <!-- END CANCHA INFO TAB --> 
		  </div>
		  <!-- BEGIN CANCHA HORARIO TAB --> 
		  
		  <!-- END CANCHA HORARIO TAB --> 
		  </div>
		</div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
    	<button type="button" class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/insertar_campeonato.php","form_editar_campeonato"); limpiar_cambios();'>Guardar</button>
	  </div>
	 </div>
	 <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="eliminar_partido" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="">Eliminar Partido</h4>
      </div>
      <div class="modal-body">
        Est&aacute; seguro de eliminar este partido?
        <br>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="del">
        <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
        <a data-toggle="modal" href="#" class="btn green-haze" style="background:#C42E35;" data-dismiss="modal" onclick="borrar();">Aceptar</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<input type="hidden" id="del">
<script>	
	function eliminar(partido){
		document.getElementById("del").value=partido;
	}
	function borrar(){
		actualizar_notificacion(26,$('#del').val());
	}
	function limpiar_cambios(){
		document.getElementById("cambios").value = "";
	}
    function set_etapa(etapa){
        document.getElementById("id_etapa").value=etapa;
    }
    var equipos_orig = $("#Equipos").clone();
    function set_etapa_eliminatoria(etapa, actual){
        document.getElementById("id_etapa").value=etapa;
        if (actual!=0 || actual!="0") {
        	actualizar_notificacion(41, "<?php echo $id; ?>", actual);
        }else{
        	document.getElementById("Equipos").innerHTML="";
        	equipos_orig.appendTo("#Equipos");
        	$('select').select2();
        };
        document.getElementById("id_etapa").value=etapa;
    }
    var cambios_campeonato = new Array();
	function detectar_cambios_campeonato(input){
	    var compr = 0;
	    for (var i = 0; i < cambios_campeonato.length+1; i++) {
	      if (cambios_campeonato[i]==input) {
	        compr++;
	      };        
	    };
	    if (compr==0) {
	      cambios_campeonato.push(input);
	    };
	    document.getElementById("cambios_campeonato").value = cambios_campeonato;
	}
    var elegir_centros = $( "#elegir_Centro" ).clone();
    function asignarCentroCampeonato(){
    	if ($('#asignar_centroCampeonato:checked').val()) {
    		elegir_centros.appendTo("#elegir_Centro");
    		$('select').select2();
    		document.getElementById("mensaje_centro_campeonato").innerHTML="Estimado usuario, todos los partidos del campeonato se actualizaran con este centro deportivo.";
    	}else{
    		document.getElementById("elegir_Centro").innerHTML="";
    		document.getElementById("mensaje_centro_campeonato").innerHTML="";
    	};
    }
    asignarCentroCampeonato();

</script>
<?php 
    function nombres($nombre, $limit){
        $mostrar ="";
        for ($i=0; $i < strlen($nombre); $i++) {
            $mostrar.=$nombre[$i];
            if ($i-1==$limit) {
                $mostrar.="..";
                break;
            }
        }
        return $mostrar;
    }
 ?>
