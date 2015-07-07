<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");

	$bd= $_POST['bd'];
	echo "la base es".$bd;


	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=0; $i <2; $i++) {
			$lista[$i]=array_values($_POST)[$i];
	}
	$fecha=array_values($_POST)[2];
	$hora=array_values($_POST)[3];
	echo "fecha:".$fecha;
	echo "hora:".$hora;

	$c = $fecha . " ".$hora;
	echo "valorrr <br>".$c;

	$lista[2]=$c;

	for ($i=4; $i <9; $i++) {
			$lista[$i-1]=array_values($_POST)[$i];
	}

    $sql=$miconexion->sql_ingresar($bd,$lista);
    //echo "valor de sql".$sql;
    
    if($miconexion->consulta($sql)){
					//echo ' <script language="javascript">alert ("Su Partido ha sido creado con \u00e9xito");</script> ';
					//echo "<script>location.href='../perfiles/perfil.php'</script>";
					header("Location: ../perfiles/perfil.php?ms=eventosi");
				}else{
					header("Location: ../perfiles/perfil.php?ms=eventono");
					//echo ' <script language="javascript">alert("No se ha podido crear el partido, Intente nuevamente");</script> ';
					//echo "<script>location.href='../perfiles/perfil.php?op=eventos'</script>";

				}
?>