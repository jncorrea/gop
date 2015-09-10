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
		</tbody>
	</table>		
</div>