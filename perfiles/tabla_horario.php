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
		$miconexion->consulta("select * from horarios_centros where id_centro = '".$_GET['i']."'");
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
		$semana = array(array("Todos",0),array("Domingo",0),array("Lunes",0),array("Martes",0),array("Miercoles",0),array("Jueves",0),array("Viernes",0),array("Sabado",0));
		for ($i=0; $i <$miconexion->numregistros(); $i++) {
			$dia=$miconexion->consulta_lista();
			$dia_f[$i][0]=$dia[0];
			$dia_f[$i][1]=$dia[1];
			$dia_f[$i][2]=$dia[2];
			$dia_f[$i][3]=$dia[3];
			$dia_f[$i][4]=$dia[4];
			if ($dia[2]=="Todos") {
				$semana[0][1]++;
			}if ($dia[2]=="Domingo") {
				$semana[1][1]++;
			}if ($dia[2]=="Lunes") {
				$semana[2][1]++;
			}if ($dia[2]=="Martes") {
				$semana[3][1]++;
			}if ($dia[2]=="Miercoles") {
				$semana[4][1]++;
			}if ($dia[2]=="Jueves") {
				$semana[5][1]++;
			}if ($dia[2]=="Viernes") {
				$semana[6][1]++;
			}if ($dia[2]=="Sabado") {
				$semana[7][1]++;
			}
		}
		?>
			<tr>
				<td rowspan="3" style="text-align:center; vertical-align: middle;">Lunes - Domingo</td>
				<td>07:30 - 12:30</td>
				<td style="text-align:center; vertical-align: middle;"><a href='#' title="Editar"><i class='icon-pencil'></i></a></td>
				<td style="text-align:center; vertical-align: middle;"><a href='#' title="Eliminar"><i class='icon-remove'></i></a></td>
			</tr>
			<tr>											
				<td>15:00 - 24:00</td>
				<td style="text-align:center; vertical-align: middle;"><a href='#' title="Editar"><i class='icon-pencil'></i></a></td>
				<td style="text-align:center; vertical-align: middle;"><a href='#' title="Eliminar"><i class='icon-remove'></i></a></td>
			</tr>
			<tr>											
				<td>15:00 - 24:00</td>
				<td style="text-align:center; vertical-align: middle;"><a href='#' title="Editar"><i class='icon-pencil'></i></a></td>
				<td style="text-align:center; vertical-align: middle;"><a href='#' title="Eliminar"><i class='icon-remove'></i></a></td>
			</tr>
		</tbody>
	</table>		
</div>