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