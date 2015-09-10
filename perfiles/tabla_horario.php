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
		$miconexion->consulta("select * from horarios_centros where id_centro = '".$_GET['i']."' ORDER BY HORA_INICIO");
	 ?>
	<table class="table table-bordered table-hover" style="font-size: 11px; text-align:left;">
		<thead>
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
		for ($i=0; $i <$miconexion->numregistros(); $i++) {
			$dia=$miconexion->consulta_lista();
			if ($dia[2]=="Todos") {
				$todos[$t] = array('Lunes - Domingo', $dia[3], $dia[4]);
				$t++;
			}if ($dia[2]=="Domingo") {
				$domingo[$d] = array($dia[2], $dia[3], $dia[4]);
				$d++;
			}if ($dia[2]=="Lunes") {
				$lunes[$l] = array($dia[2], $dia[3], $dia[4]);
				$l++;
			}if ($dia[2]=="Martes") {
				$martes[$m] = array($dia[2], $dia[3], $dia[4]);
				$m++;
			}if ($dia[2]=="Miercoles") {
				$miercoles[$mi] = array($dia[2], $dia[3], $dia[4]);
				$mi++;
			}if ($dia[2]=="Jueves") {
				$jueves[$j] = array($dia[2], $dia[3], $dia[4]);
				$j++;
			}if ($dia[2]=="Viernes") {
				$viernes[$v] = array($dia[2], $dia[3], $dia[4]);
				$v++;
			}if ($dia[2]=="Sabado") {
				$sabado[$s] = array($dia[2], $dia[3], $dia[4]);
				$s++;
			}
		}
		$miconexion->tabla_horario(@$todos);
		$miconexion->tabla_horario(@$domingo);
		$miconexion->tabla_horario(@$lunes);
		$miconexion->tabla_horario(@$martes);
		$miconexion->tabla_horario(@$miercoles);
		$miconexion->tabla_horario(@$jueves);
		$miconexion->tabla_horario(@$viernes);
		$miconexion->tabla_horario(@$sabado);
		?>
		</tbody>
	</table>		
</div>
