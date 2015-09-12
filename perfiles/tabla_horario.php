<?php 
  include("../static/site_config.php"); 
  include ("../static/clase_mysql.php");
  extract($_GET);
  session_start();
  $miconexion = new clase_mysql;
  $miconexion->conectar($db_name,$db_host, $db_user,$db_password); 
?>
<div class="tab-content">
	<?php 
		$miconexion->consulta("select * from centros_deportivos where id_centro = '".@$_GET['i']."'");
		@$nombre = $miconexion->consulta_lista();
		$miconexion->consulta("select * from horarios_centros where id_centro = '".@$_GET['i']."' ORDER BY HORA_INICIO");
	 ?>
	<table class="table table-bordered table-hover" style="font-size: 11px; text-align:left;">
		<thead>
			<tr>
				<th colspan="4" style="text-align: center;"><?php echo strtoupper(@$nombre[2]) ?></th>
			</tr>
			<tr style="font-size: 11px;">
				<th>Dia</th>
				<th>Horario de Atencion</th>
				<th>Editar</th>
				<th>Eliminar</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$t = 0; $d=0; $l =0; $m = 0; $mi = 0; $j=0; $v =0; $s =0; 
		for ($i=0; $i <@$miconexion->numregistros(); $i++) {
			$dia=$miconexion->consulta_lista();
			if ($dia[2]=="Todos") {
				$todos[$t] = array('Lunes - Domingo', $dia[3], $dia[4], @$_GET['i'], $dia[0]);
				$t++;
			}if ($dia[2]=="Domingo") {
				$domingo[$d] = array($dia[2], $dia[3], $dia[4], @$_GET['i'], $dia[0]);
				$d++;
			}if ($dia[2]=="Lunes") {
				$lunes[$l] = array($dia[2], $dia[3], $dia[4], @$_GET['i'], $dia[0]);
				$l++;
			}if ($dia[2]=="Martes") {
				$martes[$m] = array($dia[2], $dia[3], $dia[4], @$_GET['i'], $dia[0]);
				$m++;
			}if ($dia[2]=="Miercoles") {
				$miercoles[$mi] = array($dia[2], $dia[3], $dia[4], @$_GET['i'], $dia[0]);
				$mi++;
			}if ($dia[2]=="Jueves") {
				$jueves[$j] = array($dia[2], $dia[3], $dia[4], @$_GET['i'], $dia[0]);
				$j++;
			}if ($dia[2]=="Viernes") {
				$viernes[$v] = array($dia[2], $dia[3], $dia[4], @$_GET['i'], $dia[0]);
				$v++;
			}if ($dia[2]=="Sabado") {
				$sabado[$s] = array($dia[2], $dia[3], $dia[4], @$_GET['i'], $dia[0]);
				$s++;
			}
		}
		tabla_horario(@$todos);
		tabla_horario(@$domingo);
		tabla_horario(@$lunes);
		tabla_horario(@$martes);
		tabla_horario(@$miercoles);
		tabla_horario(@$jueves);
		tabla_horario(@$viernes);
		tabla_horario(@$sabado);

		function tabla_horario($array){
		for ($i=0; $i < count($array); $i++) { 
			if ($i==0) {
				echo '
				<tr>
					<td rowspan = "'.count($array).'" style="text-align:center; vertical-align: middle;">'.$array[$i][0].'</td>
					<td>'.$array[$i][1].' - '.$array[$i][2].'</td>
					<td style="text-align:center; vertical-align: middle;"><a href="#" title="Editar"><i class="icon-pencil"></i></a></td>
				';
				?> 
					<td style="text-align:center; vertical-align: middle;"><a onclick="actualizar_notificacion('15','<?php echo $array[$i][3] ?>','<?php echo $array[$i][4] ?>');" href="#" title="Eliminar"><i class="icon-remove"></i></a></td>
					
				<?php
				echo'</tr>';
			}else {
				echo '
				<tr>
					<td>'.$array[$i][1].' - '.$array[$i][2].'</td>
					<td style="text-align:center; vertical-align: middle;"><a href="#" title="Editar"><i class="icon-pencil"></i></a></td>
				';
				?> 
					<td style="text-align:center; vertical-align: middle;"><a onclick="actualizar_notificacion('15','<?php echo $array[$i][3] ?>','<?php echo $array[$i][4] ?>');" href="#" title="Eliminar"><i class="icon-remove"></i></a></td>
					
				<?php
				echo'</tr>';
			}
		}
	}

		?>
		</tbody>
	</table>		
</div>
