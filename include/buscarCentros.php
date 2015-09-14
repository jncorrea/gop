<?php
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
	$miconexion = new clase_mysql;
	$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	$q = strtolower($_GET["term"]);
	if (!$q) return;
    $datos = array();

    $miconexion->consulta("SELECT centro_deportivo,id_centro, ciudad, foto_centro, id_user FROM `centros_deportivos`
						WHERE centro_deportivo LIKE '%$q%'
						OR ciudad LIKE '%$q%'
						");
    for ($i=0; $i < $miconexion->numregistros(); $i++) {
    	$lista=$miconexion->consulta_lista();
    	$new_row['label']=utf8_decode($lista[0]);
        $new_row['value']=htmlentities(stripslashes($lista[1]));
        
        $miconexion->consulta("SELECT nombre FROM `provincia`
                        WHERE id='$lista[2]'
                        ");

        $lista_provincia=$miconexion->consulta_lista();
        $new_row['descripcion']=htmlentities(stripslashes($lista_provincia[0]));

        if ($lista[3]=="") {
        	$new_row['avatar']=htmlentities(stripslashes("../assets/img/sin_imagen.jpg"));
        }else{
            $new_row['avatar']=htmlentities(stripslashes("../perfiles/images/centros/".$lista[1]."/".$lista[3]));// Aún no existe imagen guardada
        	//$new_row['avatar']=htmlentities(stripslashes("images/".$lista[0]."/".$lista[3])); //aun no se agrega porque no existe ruta de imagen
        }
        $row_set[] = $new_row; //build an array*/
	}
    echo json_encode($row_set); //format the array into json data

  
?>