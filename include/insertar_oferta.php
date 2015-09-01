<?php

extract($_POST);

session_start();
include("../static/clase_mysql.php");
include("../static/site_config.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
$id=$_POST['id'];
$cont;
//echo "valor de id".$id;
$miconexion->consulta("select id_grupo from partidos where id_partido=".$id);
        $id_grupo=$miconexion->consulta_lista();
    $miconexion->consulta("select distinct id_user from user_grupo where id_grupo <> ".$id_grupo." and id_user <> '".$_SESSION["id"]."'");
                        
        for ($i=0; $i < $miconexion->numregistros(); $i++) { 
            $list=$miconexion->consulta_lista();            
            if ($list[0]!=$_SESSION["id"]) {
                $insert[$i]="insert into alineacion (id_partido, id_user, estado_alineacion) values ('".$id."','".$list[0]."','2')";
            }
        }

    for ($i=0; $i < count($insert); $i++) { 
            
        if ($miconexion->consulta($insert[$i])) {
            $cont = 1;
        }else{
            $cont = 0;
        }
    }
 
    if ($cont==1) {
        echo '<script>
            $container = $("#container_notify_ok").notify();    
            create("default", { title:" Notificaci&oacute;n", text:"Se han ofertado cupos.."});
            </script>';
    }else{
        echo '<script>
            $container = $("#container_notify_bad").notify();   
            create("default", { title:" Notificaci&oacute;n", text:"Error al Ofertar Cupos <br> Por favor intente nuevamente."}); 
        </script>';
    }
?>

