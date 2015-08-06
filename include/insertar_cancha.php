<?php 
    extract($_POST);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	session_start();
	$admin=$_SESSION['email'];
	$bd= $_POST['bd'];

	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$lista="";
	for ($i=0; $i <count($_POST)-1; $i++) {
			$lista[$i]=array_values($_POST)[$i];
			
	}
	//echo "<br> valor de i".$i;
	
	//el usuario logueado se ingresa como admiistrador de una cancha $admin=$_SESSION['email'];
	$lista[$i]=$admin;
		
    $sql=$miconexion->sql_ingresar($bd,$lista);
   // echo "SQL:".$sql;
	if($miconexion->consulta($sql)){
		echo '<script>
            location.href = "perfil.php?op=canchas";
            $container = $("#container_notify_ok").notify();    
            create("default", { title:" Notificaci&oacute;n", text:"Partido Creado con &eacute;xito"});
            </script>';
	}else{
		echo '<script>
            $container = $("#container_notify_bad").notify();   
            create("default", { title:"Alerta", text:"Error al Crear el Cancha <br> Por favor intente nuevamente."}); 
        </script>';
	}
?>