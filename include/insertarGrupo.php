<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=1; $i <count($_POST); $i++) {
			$lista[$i-1]=array_values($_POST)[$i];
	}
	$sql = $miconexion->sql_ingresar($_POST['bd'],$lista);
    $miconexion->consulta($sql);
    $miconexion->consulta("select id_grupo from grupos where nombre_grupo='$lista[0]'");
    for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $grupo=$miconexion->consulta_lista();
    }
    $miconexion->consulta("insert into grupos_miembros values('".$lista[1]."','".$grupo[0]."')");  
    echo '<script>alert("Grupo Creado")</script>';
    echo "<script>location.href='../perfiles/perfil.php'</script>";
?>