<?php
    include("../static/clase_mysql.php");
    include("../static/site_config.php");
    $miconexion = new clase_mysql;
    $miconexion->conectar($db_name,$db_host, $db_user,$db_password);
    $q = strtolower($_GET["term"]);
    if (!$q) return;
    $datos = array();

    $miconexion->consulta("select email, nombres, apellidos, avatar, id_user, sexo, user
                        FROM usuarios
                        WHERE email LIKE '%$q%'
                        OR nombres LIKE '%$q%'
                        OR apellidos LIKE '%$q%'");
    for ($i=0; $i < $miconexion->numregistros(); $i++) {
        $lista=$miconexion->consulta_lista();
        $new_row['label']=htmlentities(stripslashes($lista[0]));
        $new_row['value']=htmlentities(stripslashes($lista[4]));
        $new_row['descripcion']=htmlentities(stripslashes($lista[1]." ".$lista[2]));
        if ($lista[3]=="") {
            if ($lista[5]=="Masculino"){
                $new_row['avatar']=htmlentities(stripslashes("../assets/img/user_masculino.png"));                
            }else{
                $new_row['avatar']=htmlentities(stripslashes("../assets/img/user_femenino.png"));
            }
        }else{
            $new_row['avatar']=htmlentities(stripslashes("images/".$lista[6]."/".$lista[3]));
        }
        $row_set[] = $new_row; //build an array*/
    }
    echo json_encode($row_set); //format the array into json data
  
?>