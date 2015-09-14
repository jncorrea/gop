<?php
	$miconexion->consulta("select p.fecha_partido, p.equipo_a, p.equipo_b, c.centro_deportivo, c.direccion, p.res_a, p.res_b,
  	p.id_grupo, p.id_centro, p.hora_partido, p.nombre_partido, p.descripcion_partido, g.nombre_grupo, g.id_user
    from partidos p, centros_deportivos c, grupos g
    where c.id_centro = p.id_centro and g.id_grupo = p.id_grupo and id_partido ='".$id."' ");                 
	$cont = $miconexion->numcampos();
	global $partidos1;
	$partidos1=$miconexion->consulta_lista();
	global $grupo;
	$grupo=$partidos1[7];
	global $cancha;
	$cancha=$partidos1[8];
	$time=strtotime($partidos1[0]);
	global $fecha;
	$fecha = date("d M Y",$time);
	global $hora;
	$hora = date("H:i",strtotime($partidos1[9]));
?>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="perfil.php">Home</a>
			<i class="icon-angle-right"></i>
		</li>
		<li>
			<a href="#">Mis Partidos</a>
			<i class="icon-angle-right"></i>			
		</li>
		<li>
			<a href="#"><?php echo $partidos1[10] ?></a>		
		</li>
	</ul>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
		<h3 class="page-title">
			Partidos <small>Alineaci&oacute;n</small>
		</h3>
	<div class="clearfix">
	</div>
	<div class="portlet light" id="print">
		<div class="portlet-title tabbable-line">
			<div class="caption" style="margin-left:10%;">
		      	<h3 style="text-align:center; margin:0px;"><img style="width:35px; height:35px;" src="../assets/img/pupos.png" class="pupos"><?php echo "  Fecha ".$fecha ." - ".$hora?>
					<?php if ($partidos1[13]==$_SESSION['id']){ ?>
		    			<a title="Editar Partido" href="perfil.php?op=editar_evento&id=<?php echo $id ?>" style="z-index:4; font-size:15px;"><i style="font-size:130%" class="icon-pencil"></i></a>					
					<?php } ?>
			    </h3>
			</div>
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab_1_1" data-toggle="tab" aria-expanded="true">
				Alineaci&oacute;n </a>
			</li>
			<li class="">
				<a href="#tab_1_2" data-toggle="tab" aria-expanded="false">
				M&aacute;s Informaci&oacute;n </a>
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
					<div class="col-md-9 col-sm-9">
						  <table style="width:100%; text-align:center;">
						    <tr>
						      <td>
						        <h3 style="color:#4337B3; font-size:170%;"><?php echo $partidos1[1]." - ".$partidos1[5] ?></h3>
						      </td>
						      <td>
						        <h3 style="color:#EA2E40; font-size:170%;"><?php echo $partidos1[2]." - ".$partidos1[6] ?></h3>  
						      </td>
						    </tr>
						  </table>
						<div class ="cancha">
						  <?php 
						    for ($i=1; $i <= 40; $i++) { 
						      echo "<div class='jugadores'><div id='".$i."' class='column ui-sortable'>";
						      echo "</div></div>";
						    }
						   ?>  
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">					
					  <form method="POST" enctype="multipart/form-data" action="" id="myForm">
					      <input type="hidden" name="id_partido" value="<?php echo $id ?>" />
					      <input type="hidden" name="fecha" value="<?php echo $fecha ?>" />
					      <input type="hidden" name="lugar" value="<?php echo $partidos1[3] ?>" />
					      <input type="hidden" name="direccion" value="<?php echo $partidos1[4] ?>" />
					      <input type="hidden" name="img_val" id="img_val" value="" />
					  </form>
					  <h3 style="text-align:center;">INTEGRANTES</h3><hr> 	
					  <?php
					    $miconexion->consulta("select u.email, u.nombres, u.apellidos, u.avatar, u.id_user
					      FROM usuarios u, alineacion a
					      WHERE u.id_user = a.id_user and a.id_partido = $id and a.estado_alineacion=1");
					      echo '<form method="post" action="" class="form-horizontal" id="form_ubicacion">';
					      echo '<input type="hidden" class="form-control" name="id_partido" value="'.$id.'">' ;        
					      echo '<input type="hidden" class="form-control" name="equipoA" value="'.$partidos1[1].'">' ;        
					      echo '<input type="hidden" class="form-control" name="equipoB" value="'.$partidos1[2].'">' ;        
					      for ($i=0; $i < $miconexion->numregistros(); $i++) { 
					        $posicion=$miconexion->consulta_lista();
					        echo '<input type="hidden" class="form-control" name="'.$i.$posicion[0].'" value="'.$posicion[4].'">' ;
					        echo '<input type="hidden" class="form-control" name="'.$posicion[4].'" id="in'.$i.'" value="">' ;
					      }   
            				echo "<input type='hidden' name='fecha_actual' id='fecha_alineacion'>";					      
					      echo '</form>';
					    ?>
					      <button onclick="ubicar('../include/posiciones_cancha.php','form_ubicacion');" style="width:100%; display:inline-block; margin-bottom:1%;" type="submit" class="btn btn-default">
					      Guardar Alineaci&oacute;n</button>
					    <div class="btn-group pull-right">
							<button aria-expanded="false" style="width:100%; display:inline-block; margin-bottom:1%;"  type="button" class="btn btn-sm btn-success dropdown-toggle hover-initialized" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
							<i class="icon-cogs "></i> <i class="icon-angle-down"></i>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li>
									<button type="submit" onclick="capturar('../include/notificar_partido.php','myForm');" style="width:100%; display:inline-block; margin-bottom:1%;" class="btn btn-default">
								    Notificar <i class="icon-envelope"></i>
								  </button>
	  								<div id="respuesta"></div>
								</li>
								<li>
									<form method="post" action="" id="form_insertar_ofertas" enctype="multipart/form-data">
									<?php echo "<input type='hidden' name='id' value='".$id."'>"; ?>
									</form>
									<button type="submit" onclick='enviar_form("../include/insertar_oferta.php","form_insertar_ofertas");' class="btn btn-default" style="width:100%; display:inline-block; margin-bottom:1%;">Ofertar Cupos					   
									<i class="icon-thumbs-up"></i></button>
	  								<div id="respuesta"></div>
								</li>
								<li>
									<a href='perfil.php?op=grupos&id=<?php echo $grupo ?>' style="width:100%; display:inline-block; margin-bottom:1%;" class="btn btn-default">
								    Ver Grupo  <i class=" icon-group"></i>
								  </a>
								</li>
								<li>
									<a href='perfil.php?op=canchas&id=<?php echo $cancha ?>'  style="width:100%; display:inline-block; margin-bottom:1%;" class="btn btn-default">
								    Ver Cancha <i class="icon-map-marker "></i>
								  </a>
								</li>
							</ul>
						</div>
					    <?php
					    $miconexion->consulta("select u.email, u.nombres, u.apellidos, u.avatar, a.posicion_event, u.sexo, u.user
					      FROM usuarios u, alineacion a 
					      WHERE u.id_user = a.id_user and a.id_partido = $id and a.estado_alineacion = 1");
					      for ($i=0; $i < $miconexion->numregistros(); $i++) { 
					        $alineacion=$miconexion->consulta_lista();
					        echo '<div class="column ui-sortable">' ;
					        if ($alineacion[3]==""){
					        	if ($alineacion[5]=="Femenino") {
									echo "<img title='".$alineacion[0]."' class='jugador_img' src='../assets/img/user_femenino.png' 
					          		id='div".$i."' alt='".$alineacion[0]."'>";
								}else{
									echo "<img title='".$alineacion[0]."' class='jugador_img' src='../assets/img/user_masculino.png' 
					          		id='div".$i."' alt='".$alineacion[0]."'>";
					          	}
					        }else{
					          echo "<img title='".$alineacion[0]."' class='jugador_img' src='images/".$alineacion[6]."/".$alineacion[3]."' 
					          id='div".$i."' alt='".$alineacion[0]."'>";        
					        }
					        echo '</div>';
					        if ($alineacion[4]!="") {
					          echo "<script>";
					          echo "$('#div$i').appendTo('#$alineacion[4]')";
					          echo "</script>";
					        }
					        $persona[$i] = $alineacion[0];
					      }  
					        echo '<div class="column ui-sortable"></div>' ;    
					   ?>
					</div>
				</div>
				<div class="tab-pane" id="tab_1_2">
					<div class="portlet green-meadow box">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs"></i>Informaci&oacute;n del Partido
							</div>
							<div class="actions">
								<?php if ($partidos1[13]==$_SESSION['id']){ ?>
									<a href="perfil.php?op=editar_evento&id=<?php echo $id ?>" class="btn btn-default btn-sm">
									<i class="fa fa-pencil"></i> Editar </a>
								<?php } ?>
							</div>
						</div>
						<div class="portlet-body">
							<div class="row static-info">
								<div class="col-md-5 value">
									 Nombre del Partido:
								</div>
								<div class="col-md-7 name">
									<?php echo $partidos1[10];?>
								</div>
							</div>
							<div class="row static-info">
								<div class="col-md-5 value">
									Descripci&oacute;n del Partido:
								</div>
								<div class="col-md-7 name">
									<?php echo $partidos1[11];?>
								</div>
							</div>
							<div class="row static-info">
								<div class="col-md-5 value">
									Grupo:
								</div>
								<div class="col-md-7 name">
									<?php echo $partidos1[12];?>
								</div>
							</div>
							<div class="row static-info">
								<div class="col-md-5 value">
									Cancha:
								</div>
								<div class="col-md-7 name">
									<?php echo $partidos1[3];?>
								</div>
							</div>
							<div class="row static-info">
								<div class="col-md-5 value">
									Fecha:
								</div>
								<div class="col-md-7 name">
									<?php echo $fecha?>
								</div>
							</div>
							<div class="row static-info">
								<div class="col-md-5 value">
									Hora:
								</div>
								<div class="col-md-7 name">
									<?php echo $hora?>
								</div>
							</div>
							<div class="row static-info">
								<div class="col-md-5 value">
									Equipos:
								</div>
								<div class="col-md-7 name">
									<?php echo $partidos1[1]."<strong> vs </strong>".$partidos1[2]?>
								</div>
							</div>
							<div class="row static-info">
								<div class="col-md-5 value">
									Resultados:
								</div>
								<div class="col-md-7 name">
									<?php echo $partidos1[5]."<strong> - </strong>".$partidos1[6]?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab_1_3">
					<div class="row">
					<?php 
						$miconexion->consulta("select u.email, u.nombres, u.apellidos, u.avatar, a.posicion_event, a.fecha_alineacion, u.user, a.estado_alineacion, u.posicion, u.sexo
					      FROM usuarios u, alineacion a 
					      WHERE u.id_user = a.id_user and a.id_partido = $id");
						for ($i=0; $i < $miconexion->numregistros(); $i++) { 
					        $participantes=$miconexion->consulta_lista();
					 ?>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 user-info" style="height:90px; font-size:85%;">
							<?php if ($participantes[3]==""){ 
								if ($participantes[9]=="Femenino") {
									echo '<img alt="" src="../assets/img/user_femenino.png" style="width:20%; heigth:50px;" class="img-responsive">';
								}else{
									echo '<img alt="" src="../assets/img/user_masculino.png" style="width:20%; heigth:50px;" class="img-responsive">';
					          	}
					        }else{ ?>
								<img alt="" src="<?php echo 'images/'.$participantes[6].'/'.$participantes[3] ?>" style="width:20%; heigth:50px;" class="img-responsive">								
							<?php } ?>
							<div class="details">
								<div>
									<a href="javascript:;">
									<?php echo $participantes[1]." ".$participantes[2] ?> </a>
									<p><?php echo $participantes[6]?>
										<?php if ($participantes[7]=="1"){ ?>
											<span class="label label-sm label-success">
											Confirmado </span>
										<?php }else{ ?>
											<span class="label label-sm label-danger">
											Pendiente </span>
										<?php }?>
									<br><?php echo $participantes[8]?> </p>
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
			    <a href="#" class="col-sm-2 control-label" style="margin:0px; padding:0px;"> 
			      <?php
			      if ($lista[10]=="") {
			        if ($participantes[9]=="Femenino") {
			        	echo '<img class="avatar" style="width:55px; height:55px; display:inline-block;" src="../assets/img/user_femenino.png"/></a>';
					}else{
			        	echo "<img class='avatar' src='../assets/img/user_masculino.png' style='width:55px; height:55px; display:inline-block;' > </a> ";
		          	}
			      }else{
			       echo '<img class="avatar" style="width:55px; height:55px; display:inline-block;" src="../assets/img/user_masculino.png"/></a>';
					}
			      ?>      
			    <div class="col-sm-9">
			      <textarea id="text_comentario" style="display:inline-block;" class="form-control" style="width:100%;" name="comentario" placeholder="Ingrese su comentario.." required></textarea>      
			    </div>
			  </div>
			</form>
			  <div class="form-group">
			    <div class="col-sm-offset-2 col-sm-9" style="margin-bottom:2%;">
				<button type="submit" class="btn btn-default" style= "float:right;" onclick='enviar_form("../include/insertar_comentario.php","form_comentarios");'>Enviar Comentario</button>
			    </div>
			  </div>
			  <br>
			<ul id="respuesta"></ul>				
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
