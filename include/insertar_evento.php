<?php 
    extract($_POST);
    date_default_timezone_set('America/Guayaquil'); 
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
    session_start();
    global $dias;
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
    $insert;
    if ($_POST['nombre_partido']=='' || $_POST['id_grupo']=='' || $_POST['id_centro']=='' || $_POST['fecha_partido']=='' || $_POST['hora_partido']=='') {
        echo '<script> 
                $container = $("#container_notify").notify();  
                create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"* Campos Requeridos", imagen:"../assets/img/alert.png"}); 
            </script>';
    }else{
        $miconexion->consulta('select tiempo_alquiler from centros_deportivos where id_centro = "'.$_POST['id_centro'].'" ');        
        $tiempo_alquiler=$miconexion->consulta_lista();
        $Hora = strtotime($_POST['hora_partido']) + (60 *60 * $tiempo_alquiler[0]);
        $hora_fin = "".date('H:i:s',$Hora);
        $centro = $_POST['id_centro'];
        $fecha_partido = $_POST['fecha_partido'];
        $hora_partido = $_POST['hora_partido'];
        $sql = 'select count(*) from horarios_centros hc, partidos p 
        where  hc.id_centro = p.id_centro and p.id_centro="'.$centro.'" and p.fecha_partido = "'.$fecha_partido.'" 
        AND 
        ("'.$hora_partido.'" >= p.hora_partido AND "'.$hora_partido.'" < p.hora_fin)
         OR 
        ("'.$hora_fin.'" >= p.hora_partido AND "'.$hora_fin.'" < p.hora_fin)
         OR
        (p.hora_partido > "'.$hora_partido.'" AND p.hora_partido < "'.$hora_fin.'")';
        if($miconexion->consulta($sql)){
            $compr=$miconexion->consulta_lista();
            if ($compr[0]=="0") {
                $dias= array("0"=>'Domingo',"1"=>'Lunes',"2"=>'Martes',"3"=>'Miercoles',"4"=>'Jueves',"5"=>'Viernes',"6"=>'Sabado');
                $i = strtotime($_POST['fecha_partido']); 
                $dia_fecha = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i),date("d",$i), date("Y",$i)) , 0 );
                $miconexion->consulta('select count(*) from horarios_centros where  id_centro="'.$centro.'" and dia="'.$dias[$dia_fecha].'" and 
                                    ("'.$hora_partido.'" >= hora_inicio AND "'.$hora_partido.'" < hora_fin)
                                     AND 
                                    ("'.$hora_fin.'" >= hora_inicio AND "'.$hora_fin.'" < hora_fin)');    
                $compr=$miconexion->consulta_lista();
            if ($compr[0]!="0") {
                $col[count($col)] = "hora_fin";
                $val[count($val)] = $hora_fin;
                $col[count($col)] = "id_user";
                $val[count($val)] = $_SESSION['id'];
                    $sql=$miconexion->ingresar_sql($bd,$col,$val);
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
                            $.get("../datos/cargarSolicitudes.php");
                            $container = $("#container_notify").notify();    
                            create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Partido Creado con &eacute;xito", imagen:"../assets/img/check.png"});
                            location.href = "perfil.php?op=alineacion&id='.$id[0].'";
                            </script>';
                    }else{
                        echo '<script>
                            $container = $("#container_notify").notify();  
                            create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"'.$sql.'", imagen:"../assets/img/alert.png"}); 
                        </script>';
                	}
                }else{
                    echo "<script>leer_horarios(); document.getElementById('error').innerHTML = 'Lo sentimos, este horario no esta planificado por el centro deportivo, por favor revisa el calendario e intetalo nuevamente.';</script>";
                }                    
            }else{
                echo "<script>leer_horarios(); document.getElementById('error').innerHTML = 'Lo sentimos, este horario ya no se ecuentra disponible, por favor revisa el calendario e intetalo nuevamente.';</script>";
            } 
        }else{
           echo '<script>
                $container = $("#container_notify").notify();  
                create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Ocurrio algo. <br>Por favor intenta nuevamente.", imagen:"../assets/img/alert.png"}); 
            </script>';
                
        }
    }
?>