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
					<?php if ($campeonato[3]=='contra_todos') {
						include('contra_todos.php');
					}elseif ($campeonato[3]=='eliminatoria') {
						include('eliminatoria.php');
					} ?>
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
									echo '<img alt="" src="../assets/img/soccer1.png" style="width:50px; heigth:50px;" class="img-responsive img-circle">';
					        }else{ ?>
								<img alt="" src="<?php echo 'images/grupos/'.$grupos_participantes[0].''.$grupos_participantes[2] ?>" style="width:50px; heigth:50px;" class="img-responsive img-circle">								
							<?php } ?>
							<div class="details">
								<div>
									<a href="javascript:;">
									<?php echo $grupos_participantes[1]?> </a>
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
</script>
