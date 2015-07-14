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
	$sql=$miconexion->sql_ingresar($_POST['bd'],$lista);
     echo "sql".$sql; 
    
    /*if($miconexion->consulta($sql)){

    	echo '<script>alert("Comentario Registrado")</script>';
    	echo "<script>location.href='../perfiles/perfil.php?op=alineacion'</script>";

    }else{
    	echo '<script>alert("Nos e ha podido registrar comentario")</script>';
    	echo "<script>location.href='../perfiles/perfil.php?op=alineacion'</script>";
    }*/
    
   ?>