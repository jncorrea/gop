<?php
	$miconexion->consulta("select * from campeonatos where id_campeonato ='".$id."' ");                 
	$campeonato=$miconexion->consulta_lista();
?>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="perfil.php">Home</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="perfil.php?op=listar_partidos">Mis Campeonatos</a>
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
		    			<a data-toggle="modal" href="#edit_partido" title="Editar Partido" style="z-index:4; font-size:15px;"><i style="font-size:130%" class="icon-pencil"></i></a>					
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
					                <th width="30"> Opciones </th>
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
					                        <div class="dashboard-stat2 col-lg-4 col-md-4 col-sm-4 col-xs-5 user-info" style="border: 1px solid #dddddd;">
					                            <div class="display">
					                                <div class="number">
					                                    
					                                    <?php 
					                                        $fecha_p = date("Y-m-d H:i:s", strtotime($partidos[4]." ".$partidos[5]."-0500"));
					                                        if ($fecha_p > date("Y-m-d H:i:S", time()) ){
					                                     ?>
					                                        <icon title="Por Jugar" class ='icon-circle' style = "color : #D8BD2A; Font-size: 11px;"></icon> <small title="<?php echo $partidos[1]; ?>"><?php echo nombres($partidos[1],13) ?></small><br><small style="font-size:80%;"><?php echo $fecha." ".$hora; ?></small>
					                                    <?php }else{ ?>
					                                        <icon title="Jugado" class ='icon-circle' style = "color : #4CAF50; Font-size: 11px;"></icon> <small title="<?php echo $partidos[1]; ?>"><?php echo nombres($partidos[1],13) ?></small><br><small style="font-size:80%;"><?php echo $fecha." ".$hora; ?></small> 
					                                    <?php } ?>                                
					                                </div>
					                                <div class="icon">
					                                    <span class="icon-pencil"></span>
					                                </div>
					                            </div>
					                            <div class="progress-info">
					                                <div class="row list-separated profile-stat" style="text-align:center;">
					                                    <div class="col-md-5 col-sm-4 col-xs-6">
					                                        <small title="<?php echo $grupos[$partidos[2]]; ?>" style="font-size:80%;"><?php echo nombres($grupos[$partidos[2]],8); ?> </small>
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
					                                    <div class="col-md-5 col-sm-4 col-xs-6">
					                                        <small title="<?php echo $grupos[$partidos[3]]; ?>" style="font-size:80%;"><?php echo nombres($grupos[$partidos[3]],8); ?></small>
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
					                        </div> 
					                    <?php } ?>
					                </td>
					                <td>
					                    <a class="btn green-haze" onclick="set_etapa('<?php echo $etapas[$i]; ?>')" data-toggle="modal" href="perfil.php?op=campeonato&id=<?php echo $id; ?>&e=<?php echo $etapas[$i]; ?>&num=<?php echo $i; ?>#nuevo_partido" title="Nuevo Partido" style="background:#4CAF50; float: right; border-radius: 50% !important; margin-right:20px;"><i class="icon-plus"></i></a>                    
					                </td>                    
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
					          <div class="form-group">
					            <label for="equipoA" class="col-xs-12 col-sm-2 control-label">Equipos:</label>
					            <div class="col-xs-5 col-sm-4">
					                <select style="border-radius:5px;" id="equipoA" name="equipo_a" class="form-control">
					                    <?php 
					                        if ($_GET['num'] == 0) {
					                            $miconexion->consulta("select g.id_grupo, g.nombre_grupo from grupos_campeonato c, grupos g where c.id_grupo = g.id_grupo and c.id_campeonato=".$id);
					                            $miconexion->opciones(0);
					                            echo "<option>".$_GET['num']."</option>";

					                        }else if ($_GET['num'] >= 1){
					                            echo "<option>genialll</option>";
					                            /*$miconexion->consulta("select p.equipo_a, p.equipo_b, p.res_a, p.res_b from etapa_partidos ep, partidos p where ep.id_partido = p.id_partido and id_etapa = ".(@$_GET['e']-1));
					                            $grupos_ganadores = $miconexion->consulta_lista();
					                            $x=0;
					                            $ganador;
					                            for ($j=0; $j < $miconexion->numregistros(); $j++) { 
					                                if ($grupos_ganadores[2]>$grupos_ganadores[3]) {
					                                    # code...
					                                    $ganador[$x] = $grupos_ganadores[0];
					                                    $x++;
					                                }else if(($grupos_ganadores[3]>$grupos_ganadores[2])){
					                                    $ganador[$x] = $grupos_ganadores[0];
					                                    $x++;
					                                }
					                            }
					                            for ($i=0; $i <count(@$ganador) ; $i++) { 
					                                echo "<option>".@$ganador[$i]."</option>";
					                            }*/
					                        }
					                    ?>
					                </select>
					            </div>
					            <label for="equipoB" class="col-xs-1 col-sm-1 control-label">vs. </label>
					            <div class="col-xs-5 col-sm-4">
					                <select style="border-radius:5px;" id="equipoB" name="equipo_b" class="form-control">
					                    <?php 
					                        $miconexion->consulta("select g.id_grupo, g.nombre_grupo from grupos_campeonato c, grupos g where c.id_grupo = g.id_grupo and c.id_campeonato=".$id);
					                        $miconexion->opciones(0);
					                    ?>
					                </select>
					            <input type="hidden" id="id_etapa" name="etapa">
					            </div>
					          </div>               
					          <div id="respuesta"></div>
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
				</div>
				<div class="tab-pane" id="tab_1_3">
					<div class="row">
					<?php 
						$miconexion->consulta("select c.id_grupo, g.nombre_grupo, g.logo from grupos_campeonato c, grupos g where c.id_grupo = g.id_grupo and c.id_campeonato = $id");
						for ($i=0; $i < $miconexion->numregistros(); $i++) { 
					        $grupos_participantes=$miconexion->consulta_lista();
					 ?>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 user-info" style="height:90px; font-size:85%;">
							<?php if ($grupos_participantes[2]==""){
									echo '<img alt="" src="../assets/img/soccer1.png" style="width:50px; height:50px;" class="img-responsive img-circle">';
					        }else{ ?>
								<img alt="" src="<?php echo 'images/grupos/'.$grupos_participantes[0].''.$grupos_participantes[2] ?>" style="width:50px; height:50px;" class="img-responsive img-circle">								
							<?php } ?>
							<div class="details">
								<div>
									<a href="javascript:;">
									<?php echo  strtoupper($grupos_participantes[1])?> </a>
									<p>
										<?php if ("1"=="1"){ ?>
											<span class="label label-sm label-success">
											Confirmado </span>
										<?php }else if ("0"=="solicitud"){ ?>
											<span class="label label-sm label-danger">
											Pendiente </span>
										<?php }?>
									</p>
								</div>
								<div>
								</div>
							</div>
						</div>
					<?php } ?>				
					</div>	
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
			      echo "<input type='hidden' name='id_partido' value=".$id.">";
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

		<?php  $comen = 'a'; include("comentarios.php");  ?>
	</div>
</div>

	<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
		<h4>USUARIOS CONECTADOS</h4>
		<ul style="color:#ffff; list-style: none; padding:0px;">
		<div id = "col_chat"></div>
		</ul>
	</div>
</div>

<div class="modal fade" id="edit_partido" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	 <div class="modal-content">
	  <div class="modal-header">
	   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	   <h4 class="modal-title">Editar Partido</h4>
	  </div>
	  <div class="modal-body">
	    <?php include("editar_evento.php"); ?>
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

<script>	
	function comprobar_cambios(){
		if ($('#cambios').val()!="") {
			document.location.href = document.location.href;
		};
	}
	function limpiar_cambios(){
		document.getElementById("cambios").value = "";
	}
    function set_etapa(etapa){
        document.getElementById("id_etapa").value=etapa;
    }
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
