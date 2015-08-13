<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);

	session_start();
	$email=$_SESSION['email'];
	
	@$centros=$_POST['centro'];
	@$deportes=$_POST['deporte'];
	$cont=0;
	$miconexion->consulta("select id_user from usuarios where EMAIL='".$email."'");
	$usuarios=$miconexion->consulta_lista();

	$miconexion->consulta("select centro_deportivo from centros_deportivos");
	$cont=$miconexion->numregistros();
	
	for ($i=0; $i<$cont ; $i++) {
		$sql="";
		//echo "<br> Centro:".$centros[$i];
		if (@!$centros[$i]) {
			//si la casilla no se activo
		}else{
			$sql="insert into centros_favoritos values ('','".$centros[$i]."','".$usuarios[0]."'); ";
			//echo "<br> SQL centros: ".$sql;
			$miconexion->consulta("select * from centros_favoritos where ID_CENTRO='".$centros[$i]."' and ID_USER='".$usuarios[0]."'");
			if ($miconexion->numregistros()>0) {
				//echo "<br>YA EXISTE";
			}else{
				$miconexion->consulta($sql);

			}			
		}
		
	}
//DEPORTES FAVORITOS
	$miconexion->consulta("select deporte from deportes");
	$cont=$miconexion->numregistros();

	for ($i=0; $i<$cont; $i++) { 
		$sql="";
		if (@!$deportes[$i]){
			//Si la casilla no se activo
		}else{
			$sql="insert into deportes_favoritos values ('','".$deportes[$i]."','".$usuarios[0]."'); ";
			echo "<br> SQL: ",$sql;
			$miconexion->consulta("select * from deportes_favoritos where ID_DEPORTE='".$deportes[$i]."' and ID_USER='".$usuarios[0]."'");
			if ($miconexion->numregistros()>0) {
				//echo "<br>YA EXISTE";
			}else{
				$miconexion->consulta($sql);

			}
			
		}
	}

?>