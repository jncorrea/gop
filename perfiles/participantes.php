<?php 
	$miconexion->consulta("select * from campeonatos
	where id_campeonato='".$id."'");
	$camp=$miconexion->consulta_lista();
?>
<div class="row">
	<div class="col-xs-12 col-md-12">
        <?php if ($camp[4]==$_SESSION['id']):
        $grupo = md5($id); ?>
        <h3>Invitar Grupos <a title="A&ntilde;adir grupos" href="#" onclick="mostrar('participante'); return false" style="color: #5b9bd1; !important">
        <i class="icon-plus-sign" style="font-size:20px;"></i></a>
        </h3>
        <div id="participante" style="display:none;">
          <form method="post" id="form_invitar_grupo" action="#" class="form-horizontal" autocomplete="off" style="display:inline-block;">
            <div class="form-horizontal" style="display:inline-block;">
	            <select name="id_grupo" class="form-control">
	            	<option value='0'>Busque el grupo a invitar</option>
	                <?php 
                        $miconexion->consulta("select id_grupo, nombre_grupo 
                        	from grupos");
                        $miconexion->opciones(0);
	                ?>
	            </select>
              <?php
              echo '<input type="hidden" id="id_campeonato" name="id_campeonato" value="'.$camp[0].'">';
              ?>
            </div>
          </form>
          <div class="form-horizontal" style="display:inline-block;">
            <button title="Invitar" type="submit" onclick='enviar_form("../include/invitarGrupo.php","form_invitar_grupo"); ' style="width:100%; display:inline-block;" class="btn btn-default"><i class="icon-plus-sign"></i></button>
            <div id="respuesta"></div>
          </div>
        </div>
        <?php endif ?>
        <br>
	</div>
<?php 
	$miconexion->consulta("select c.id_grupo, g.nombre_grupo, g.logo, g.logo from grupos_campeonato c, grupos g 
							where c.id_grupo = g.id_grupo and c.id_campeonato = $id
							UNION select g.id_grupo, g.nombre_grupo, g.logo, n.tipo from notificaciones n, grupos g 
							where n.id_grupo = g.id_grupo and n.id_campeonato = $id and n.tipo='solicitud'");
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
				<h5>
				<?php echo  strtoupper($grupos_participantes[1])?> </h5>
				<p>
					<?php if ($grupos_participantes[3]=="solicitud"){ ?>
						<span class="label label-sm label-danger">
						Pendiente </span>
					<?php }else{ ?>
						<span class="label label-sm label-success">
						Confirmado </span>
					<?php }?>
				</p>
			</div>
			<div>
			</div>
		</div>
	</div>
<?php } ?>				
</div>	