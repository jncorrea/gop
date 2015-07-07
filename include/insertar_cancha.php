<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");

	$bd= $_POST['bd'];
	echo "la base es".$bd;


	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=0; $i <count($_POST)-1; $i++) {
			$lista[$i]=array_values($_POST)[$i];
	}
	//$fecha=array_values($_POST)[2];
	//$hora=array_values($_POST)[3];
	//echo "fecha:".$fecha;
	//echo "hora:".$hora;

	
	//$c = $fecha . " ".$hora;
	//echo "valorrr <br>".$c;
	
	
    $sql=$miconexion->sql_ingresar($bd,$lista);
    echo "valor de sql".$sql;
    
    if($miconexion->consulta($sql)){
					//echo ' <script language="javascript">alert ("Cancha creada con \u00e9xito");</script> ';
					//echo "<script>location.href='../perfiles/perfil.php'</script>";
    				header("Location: ../perfiles/perfil.php?ms=canchasi");
				}else{
					//echo ' <script language="javascript">alert("No se ha podido crear cancha, Intente nuevamente");</script> ';
					header("Location: ../perfiles/perfil.php?ms=canchano");
					//echo "<script>location.href='../perfiles/perfil.php?op=eventos'</script>";

				}
  

?>