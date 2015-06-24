<?php 
    extract($_GET);
    
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	

	
	for ($i=0; $i <count($_GET) ; $i++) {
			$list[$i]=array_values($_GET)[$i];

			//echo "<br> valoressss".$list[$i];
	}
	//$miconexion->consulta("insert into docentes values('".$lista[0]."','".$lista[1]."','".$lista[2]."','".$lista[3]."','".$lista[4]."','".$lista[5]."','".$lista[6]."')");
    $sql=$miconexion->sql_ingresar1('miembros',$list);
    //echo "<br> La sentencias es ".$sql;
    //echo $sql;
    $miconexion->consulta($sql);
    echo '<script>alert("Usuario Registrado con exito")</script>';
    echo "<script>location.href='../perfiles/perfil.php'</script>";
?>