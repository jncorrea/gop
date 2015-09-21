<?php

    extract($_POST);

    session_start();
    include("../static/clase_mysql.php");
    include("../static/site_config.php");
    $miconexion = new clase_mysql;
    $miconexion->conectar($db_name,$db_host, $db_user,$db_password);
    $id=$_POST['id'];
    $cont;
    $miconexion->consulta("SELECT id_user from usuarios where id_user NOT IN (SELECT id_user from alineacion where id_partido = ".$id." UNION SELECT id_user from notificaciones where ID_PARTIDO = ".$id.")");               
    for ($i=0; $i < $miconexion->numregistros(); $i++) { 
        $list=$miconexion->consulta_lista();            
        if ($list[0]!=$_SESSION["id"]) {
            $insert[$i] = "insert into notificaciones (id_user, id_partido, fecha_not, visto, responsable, tipo, mensaje) 
                            values ('".$list[0]."','".$id."','".date('Y-m-d H:i:s', time())."','0','".$_SESSION['id']."','sugerencia',' ha ofertado cupos para jugar en el partido ')";
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
            $container = $("#container_notify").notify();    
            create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Se han ofertado cupos.", imagen:"../assets/img/check.png"});
            </script>';
    }else{
        echo '<script>
            $container = $("#container_notify").notify();  
            create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"No se ha podido ofertar Cupos <br> Posiblemente no hay usuarios disponibles <br> para invitar :(", imagen:"../assets/img/alert.png"}); 
        </script>';
    }
?>

