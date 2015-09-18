<?php 
    extract($_POST);
    date_default_timezone_set('America/Guayaquil'); 
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
    session_start();
	@$bd= $_POST['bd'];
	@$miconexion = new clase_mysql;
	@$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	@$val="";
    @$col="";
	@$list;
	for ($i=1; $i <count($_POST); $i++) {
        if ($i == 5) {
            $val[$i-1]=date("Y-m-d",strtotime(array_values($_POST)[$i]));
        }else{
		  $val[$i-1]=utf8_decode(array_values($_POST)[$i]);            
        }
        $col[$i-1]=array_keys($_POST)[$i];
    }	
    $sql=$miconexion->ingresar_sql($bd,$col,$val);
    $insert;
    if ($_POST['nombre_partido']=='' || $_POST['id_grupo']=='' || $_POST['id_centro']==''&&$_POST['fecha_partido']&&$_POST['hora_partido']) {
        echo '<script> 
                $container = $("#container_notify").notify();  
                create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"* Campos requeridos", imagen:"../assets/img/alert.png"}); 
            </script>';
    }else{
        if($miconexion->consulta($sql)){
            $miconexion->consulta("select MAX(id_partido) AS id FROM partidos");
            $id=$miconexion->consulta_lista();
            $miconexion->consulta("select id_user FROM user_grupo where id_grupo='".$_POST['id_grupo']."'");
            for ($i=0; $i < $miconexion->numregistros(); $i++) { 
                $list=$miconexion->consulta_lista();
                if ($list[0]==$_SESSION['id']) {                
                    $insert[$i]="insert into alineacion values ('','".$id[0]."','".$list[0]."','','','','".date('Y-m-d H:i:s', time())."','1')";
                }else{
                    $insert[$i] = "insert into notificaciones (id_user, id_partido, fecha_not, visto, responsable, tipo, mensaje) 
                                    values ('".$list[0]."','".$id[0]."','".date('Y-m-d H:i:s', time())."','0','".$_SESSION['id']."','solicitud',' te ha invitado a jugar el ".$_POST['fecha_partido']." a las ".date('g:i a', strtotime($_POST['hora_partido']))." en el partido')";
                }
            }
            
            for ($i=0; $i < count($insert); $i++) { 
                $miconexion->consulta($insert[$i]);
            }
            echo '<script>
                $container = $("#container_notify").notify();    
                create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Partido Creado con &eacute;xito", imagen:"../assets/img/check.png"});
                location.href = "perfil.php?op=alineacion&id='.$id[0].'";
                </script>';
        }else{
            echo '<script>
                $container = $("#container_notify").notify();  
                create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"No se pudo crear tu partido. <br>Intenta nuevamente.", imagen:"../assets/img/alert.png"}); 
            </script>';
    	}
    }
?>