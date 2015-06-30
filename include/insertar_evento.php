<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");

	$bd= $_POST['base'];
	echo "la base es".$bd;


	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=0; $i <count($_POST)-1; $i++) {
			$lista[$i]=array_values($_POST)[$i];
	}
	//$miconexion->consulta("insert into docentes values('".$lista[0]."','".$lista[1]."','".$lista[2]."','".$lista[3]."','".$lista[4]."','".$lista[5]."','".$lista[6]."')");
    $sql=$miconexion->sql_ingresar2($bd,$lista);
    echo "valor de sql".$sql;
    
    if($miconexion->consulta($sql)){
					echo ' <script language="javascript">alert ("Su evento ha sido creado con \u00e9xito");</script> ';
					echo "<script>location.href='../perfiles/perfil.php'</script>";
				}else{
					echo ' <script language="javascript">alert("No se ha podido crear el evento, Intente nuevamente");</script> ';
					//echo "<script>location.href='../perfiles/perfil.php?op=eventos'</script>";

				}
?>