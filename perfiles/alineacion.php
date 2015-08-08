<?php
  $miconexion->consulta("select p.fecha, p.nomequipoa, p.nomequipob, c.nombre_cancha, c.direccion_cancha, p.resequipoa, p.resequipob,
  	p.id_grupo, p.id_cancha, p.hora
    from partidos p, canchas c 
    where c.id_cancha = p.id_cancha and id_partido ='".$id."' ");                 
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
			<a href="#"><?php echo $fecha ." - ".$hora ?></a>		
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
				<div class="portlet light ">
		<div class="row">
			<div class="col-md-9 col-sm-9" id="print">
					  <div style="width:100%; margin-bottom:1em;">
					    <div style="width:90%; display:inline-block; text-align:center;">
<<<<<<< HEAD
					      <h3 style="text-align:center; margin:0px;"><img src="../assets/img/pupos.png" class="pupos"><?php echo "  Fecha ".$fecha ?>
					        <a title="Editar Partido" href="perfil.php?op=editar_evento&id=<?php echo $id ?>" style="z-index:4; font-size:15px;"><i style="font-size:130%" class="icon-pencil"></i></a>
=======
					      <h3 style="text-align:center; margin:0px;"><img src="../assets/img/pupos.png" class="pupos"><?php echo "  Fecha ".$fecha ." - ".$hora?>
					        <a title="Editar Perfil" href="perfil.php?op=editar_evento&id=<?php echo $id ?>" style="z-index:4; font-size:15px;"><i style="font-size:130%" class="icon-pencil"></i></a>
>>>>>>> 5f1c6e0a710ec2c883da88c7f351c9855e824f9f
					      </h3>
					    </div>
					  </div>
					  <hr style="padding:0%; margin:1%">
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
				  <h3 style="text-align:center; margin-bottom:1.4em;">INTEGRANTES</h3><hr> 	
				  <?php
				    $miconexion->consulta("select m.email, m.nombres, m.apellidos, m.avatar
				      FROM miembros m, convocatoria c
				      WHERE c.email = m.email and c.id_partido = $id and c.estado=1");
				      echo '<form method="post" action="" class="form-horizontal" id="form_ubicacion">';
				      echo '<input type="hidden" class="form-control" name="id_partido" value="'.$id.'">' ;        
				      echo '<input type="hidden" class="form-control" name="equipoA" value="'.$partidos1[1].'">' ;        
				      echo '<input type="hidden" class="form-control" name="equipoB" value="'.$partidos1[2].'">' ;        
				      for ($i=0; $i < $miconexion->numregistros(); $i++) { 
				        $posicion=$miconexion->consulta_lista();
				        echo '<input type="hidden" class="form-control" name="'.$i.$posicion[0].'" value="'.$posicion[0].'">' ;
				        echo '<input type="hidden" class="form-control" name="'.$posicion[0].'" id="in'.$i.'" value="">' ;
				      }   
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
				    $miconexion->consulta("select m.email, m.nombres, m.apellidos, m.avatar, c.posicion
				      FROM miembros m, convocatoria c 
				      WHERE c.email = m.email and c.id_partido = $id and c.estado = 1");
				      for ($i=0; $i < $miconexion->numregistros(); $i++) { 
				        $alineacion=$miconexion->consulta_lista();
				        echo '<div class="column ui-sortable">' ;
				        if ($alineacion[3]==""){
				          echo "<img title='".$alineacion[0]."' class='jugador_img' src='../assets/img/user.png' 
				          id='div".$i."' alt='".$alineacion[0]."'>";
				        }else{
				          echo "<img title='".$alineacion[0]."' class='jugador_img' src='images/".$alineacion[0]."/".$alineacion[3]."' 
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
		</div>
	<div class="clear-fix"></div>
	<div class="col-lg-12 col-md-12 col-sm-12 col xs-12">
		<!-- BEGIN PORTLET -->
		<div class="portlet light">
			<div class="portlet-title">
				<!-- -->
					<form method="post" action="" enctype="multipart/form-data" class="form-horizontal" id="form_comentarios">
					<?php
					      date_default_timezone_set('America/Lima');
					      $fecha_actual=strftime("%Y-%m-%d %H:%M:%S");					      
					      echo "<input type='hidden' name='bd' value='comentarios'>";
					      echo "<input type='hidden' name='email' value='".$_SESSION["email"]."'>";
					      echo "<input type='hidden' name='id_partido' value=".$id.">";
					      echo "<input type='hidden' name='fecha' value='".$fecha_actual."'>";
					?>
					  <div class="form-group">    
					    <a href="#" class="col-sm-2 control-label" style="margin:0px; padding:0px;"> 
					      <?php
					      if ($lista[7]=="") {
					        echo "<img class='avatar' src='../assets/img/user.png' style='width:55px; height:55px; display:inline-block;' > </a> ";
					      }else{
					        echo "<img class='avatar' src='images/".$_SESSION["email"]."/".$lista[7]."' style='width:55px; height:55px; display:inline-block;' > </a> ";
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
			<div class="portlet-body" id="bloc_comentarios"></div>
		</div>
	</div>
</div>

	<div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
		<h4>USUARIOS CONECTADOS</h4>
		<ul style="color:#ffff; list-style: none; padding:0px;">
		<div id = "col_chat"></div>
		</ul>
	</div>
</div>

<script>	
$(document).ready(function() {
	$("#bloc_comentarios").load("comentarios.php");
		var refreshId = setInterval(function() {
	    $("#bloc_comentarios").load('comentarios.php?randval=&'+ Math.random()+"&id=<?php echo $id ?>");
	   }, 2000);
	   $.ajaxSetup({ cache: false });
});
</script>