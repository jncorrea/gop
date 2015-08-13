<?php 
    extract($_POST);
    date_default_timezone_set('America/Guayaquil'); 
	include("../static/clase_mysql.php");
	include("../static/site_config.php");

	@$bd= $_POST['bd'];
	@$miconexion = new clase_mysql;
	@$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	@$val="";
    @$col="";
	@$list;
	for ($i=0; $i <count($_POST)-2; $i++) {
        if ($i == 2) {
            $val[$i]=date("Y-m-d",strtotime(array_values($_POST)[$i]));
        }else{
		  $val[$i]=utf8_decode(array_values($_POST)[$i]);            
        }
	}
    for ($i=0; $i <count($_POST)-2; $i++) {
          $col[$i]=array_keys($_POST)[$i];
    }	
    $sql=$miconexion->ingresar_sql($bd,$col,$val);
    $insert;
    if($miconexion->consulta($sql)){
        $miconexion->consulta("select MAX(id_partido) AS id FROM partidos");
        $id=$miconexion->consulta_lista();
        $miconexion->consulta("select id_user FROM user_grupo where id_grupo='".array_values($_POST)[0]."'");
        for ($i=0; $i < $miconexion->numregistros(); $i++) { 
            $list=$miconexion->consulta_lista();
            if ($list[0]==$_POST['id_user']) {
                $insert[$i]="insert into alineacion values ('','".$id[0]."','".$list[0]."','','','','".date('Y-m-d H:i:s', time())."','1')";
            }else{
                $insert[$i]="insert into alineacion values ('','".$id[0]."','".$list[0]."','','','','".date('Y-m-d H:i:s', time())."','0')";
            }
        }
        
        for ($i=0; $i < count($insert); $i++) { 
            $miconexion->consulta($insert[$i]);
        }
        echo '<script>
            $container = $("#container_notify_ok").notify();    
            create("default", { title:" Notificaci&oacute;n", text:"Partido Creado con &eacute;xito"});
            location.href = "perfil.php?op=alineacion&id='.$id[0].'";
            </script>';
    }else{
        echo '<script>
            $container = $("#container_notify_bad").notify();   
            create("default", { title:"Alerta", text:"Error al Crear el Partido <br> Por favor intente nuevamente."}); 
        </script>';
	}
?>