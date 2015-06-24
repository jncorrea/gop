<?php  
    extract($_POST);
	$nombre_archivo = $_FILES['avatar']['name'];  
	$tipo_archivo = $_FILES['avatar']['type']; 
    $bd="miembros";
    $num= (count($_POST)+1);
	include("../static/clase_mysql.php");
	include("../static/site_config.php");	
	$tipo = split('image/', $tipo_archivo);
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	for ($i=0; $i <count($_POST); $i++) {		
		$list[$i] = array_values($_POST)[$i];
		$columnas[$i]= array_keys($_POST)[$i];
	}
	if ($_FILES['avatar']['name'] == "") {
		$sql=$miconexion->sql_actualizar($bd,$list,$columnas);
	    $miconexion->consulta($sql);
	    echo "<script>alert('Datos Guardados')</script>";
	    echo "<script>location.href='../perfiles/perfil.php?op=configurar'</script>";
	}else{
		if ((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png"))) {			
			$list[count($_POST)] = "user.".$tipo[1];
			$columnas[count($_POST)] = array_keys($_FILES)[0];
			$carpeta = "../perfiles/images/".$list[0];
			if (!file_exists($carpeta)) {
			    mkdir($carpeta, 0777);
			}
			if (move_uploaded_file($_FILES['avatar']['tmp_name'],"../perfiles/images/".$list[0]."/user.".$tipo[1])){  
			    $sql=$miconexion->sql_actualizar($bd,$list,$columnas);
			    $miconexion->consulta($sql);
			    echo "<script>alert('Datos Guardados')</script>";
			    echo "<script>location.href='../perfiles/perfil.php?op=configurar'</script>";
		    }else{ 
		        echo "
				<script language='javascript'> 
		        	alert('Error al guardar. Por favor intentelo nuevamente');
		    		location.href='javascript:window.history.go(-1);'
		   		</script>"; 
		    }
		}else{
			echo "
			<script language='javascript'> 
	        	alert('Su avatar debe tener alguna de las siguientes extensiones: .gif .jpg .png .jpeg');
	    		location.href='javascript:window.history.go(-1);'
	   		 </script>
			";
		}
	}
?>