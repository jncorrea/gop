<?php 
    extract($_GET);
    
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);	
	for ($i=0; $i <count($_GET) ; $i++) {
			$list[$i]=array_values($_GET)[$i];
	}
	$sql=$miconexion->sql_ingresar1('miembros',$list);
	$miconexion->consulta($sql);
	session_start();
	$_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s");
	$_SESSION['email'] = $list[0];
	$_SESSION['usuario'] = $list[1];
	$miconexion->consulta("update miembros set estado=1 where email = '".$_SESSION['email']."'");  
	$miconexion->consulta("select * from temp where email_temp = '".$list[0]."'");
	$email;
	$flag = $miconexion->numregistros();
	$sql1;
	if ($flag>0) {
		for ($i=0; $i < $flag; $i++) {
			$lista=$miconexion->consulta_lista();
			$x= "insert into grupos_miembros values ('".$lista[1]."','".$lista[2]."','0')";
			$sql1[$i] =$x;
			$email=$lista[1];
		}
		for ($j=0; $j <$flag; $j++) { 
			$miconexion->consulta($sql1[$j]);
		}
		$miconexion->consulta("delete from temp where email_temp = '".$email."'");
	}
    echo '<script>alert("Usuario Registrado con exito")</script>';
    echo "<script>location.href='../perfiles/perfil.php'</script>";
?>