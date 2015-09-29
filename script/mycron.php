
<?php
$link = mysql_connect('127.0.0.1', 'root', '') or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('gop') or die('No se pudo seleccionar la base de datos');

date_default_timezone_set('America/Guayaquil');
$hoy = date("Y-m-d H:i:s", time());

$query= "select id_partido from partidos where fecha_limite_acep <'".$hoy."' and estado_partido=2";
$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
$j=0;
$temp[0]="";
while ($line=mysql_fetch_array($result, MYSQL_ASSOC)) {
	foreach ($line as $col_value ){
		//echo "el valor obtenido es: ".$col_value;
		$temp[$j]=$col_value;
		$j++;
	}
}

for ($i=0; $i <count($temp) ; $i++) {
$query= "update partidos set estado_partido=0 where id_partido=".$temp[$i];
$result = mysql_query($query);
//echo "<br> ok";
}

?>