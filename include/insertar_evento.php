<?php 
echo '$container = $("#container_notify").notify();    
                create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"llega.", imagen:"../assets/img/check.png"});';
    extract($_POST);
    date_default_timezone_set('America/Guayaquil'); 
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
    session_start();
    
    date_default_timezone_set('America/Guayaquil');
    $hoy = date("Y-m-d H:i:s", time());

    global $dias;
	@$miconexion = new clase_mysql;
	@$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
	@$val="";
    @$col="";
	@$list;
    $insert;
    switch ($_POST['bd']) {
        case '0':
        	for ($i=1; $i <count($_POST); $i++) {
                if ($i == 4) {
                    $val[$i-1]=date("Y-m-d",strtotime(array_values($_POST)[$i]));
                }else{
        		  $val[$i-1]=utf8_decode(array_values($_POST)[$i]);            
                }
                $col[$i-1]=array_keys($_POST)[$i];
            }	
            $bd="partidos";
            if ($_POST['nombre_partido']=='' || $_POST['id_grupo']=='' || $_POST['fecha_partido']=='' || $_POST['hora_partido']=='') {
                echo '<script> 
                        $container = $("#container_notify").notify();  
                        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"* Campos Requeridos", imagen:"../assets/img/alert.png"}); 
                    </script>';      
            }else{
                $fecha_p = date("Y-m-d H:i:s", strtotime($_POST['fecha_partido']." ".$_POST['hora_partido']));
                if ($fecha_p > date("Y-m-d H:i:S", time()) ){ 
                        $col[count($col)] = "estado_partido";
                        $val[count($val)] = "1";
                        $col[count($col)] = "hora_fin";
                        $val[count($val)] = $hora_fin;
                        $col[count($col)] = "id_user";
                        $val[count($val)] = $_SESSION['id'];
                        //insertar fecha creacion
                        $col[count($col)]="fecha_creacion";
                        $val[count($val)]=$hoy;

                        $sql=$miconexion->ingresar_sql($bd,$col,$val);
                        if($miconexion->consulta($sql)){
                            $miconexion->consulta("select MAX(id_partido) AS id FROM partidos where id_user = '".$_SESSION['id']."'");
                            $id = $miconexion->consulta_lista();                                         
                            $sql = "insert into alineacion values ('','".$id[0]."','".$_SESSION['id']."','','','','".date('Y-m-d H:i:s', time())."','1')";
                            if ($miconexion->consulta($sql)) {
                                $sql = "insert into notificaciones (id_user, id_partido, fecha_not, visto, responsable, tipo, mensaje) 
                                        values ('".$tiempo_alquiler[1]."','".$id[0]."','".date('Y-m-d H:i:s', time())."','0','".$_SESSION['id']."','cambios',' ha solicitado reservar el ".$_POST['fecha_partido']." a las ".date('g:i a', strtotime($_POST['hora_partido']))." para el partido')";
                                $miconexion->consulta($sql);
                                echo '<script>
                                    $.get("../datos/cargarNotificaciones.php");
                                    $.get("../datos/cargarTiempoEsperaPartidos.php");
                                    $.get("../perfiles/crear_evento.php");
                                    $("#cerrar_crearPartido").trigger("click");
                                    $container = $("#container_notify").notify();    
                                    create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Partido Creado .", imagen:"../assets/img/check.png"});
                                    send(1);
                                    location.href = "perfil.php?op=alineacion&id='.$id[0].'";
                                    </script>';
                            }else{
                                echo '<script>
                                $container = $("#container_notify").notify();  
                                create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Ocurrio algo, por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
                            </script>';
                            }
                        }else{
                            echo '<script>
                                $container = $("#container_notify").notify();  
                                create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Ocurrio algo, por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
                            </script>';
                        }
                }else{
                    echo '<script>
                            $container = $("#container_notify").notify();  
                            create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"La fecha del partido no puede ser menor a la actual.", imagen:"../assets/img/alert.png"}); 
                        </script>';  
                }
            }
        break;
        
        case '1':
            for ($i=1; $i <count($_POST); $i++) {
                if ($i == 5) {
                    $val[$i-1]=date("Y-m-d",strtotime(array_values($_POST)[$i]));
                }else{
                  $val[$i-1]=utf8_decode(array_values($_POST)[$i]);            
                }
                $col[$i-1]=array_keys($_POST)[$i];
            }   
            $bd="partidos";            
            if ($_POST['nombre_partido']=='' || $_POST['id_grupo']=='' || $_POST['id_centro']=='' || $_POST['fecha_partido']=='' || $_POST['hora_partido']=='') {
                echo '<script> 
                        $container = $("#container_notify").notify();  
                        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"* Campos Requeridos", imagen:"../assets/img/alert.png"}); 
                    </script>';      
            }else{
                $fecha_p = date("Y-m-d H:i:s", strtotime($_POST['fecha_partido']." ".$_POST['hora_partido']));
                if ($fecha_p > date("Y-m-d H:i:S", time()) ){
                    $miconexion->consulta('select tiempo_alquiler, id_user from centros_deportivos where id_centro = "'.$_POST['id_centro'].'" ');        
                    $tiempo_alquiler=$miconexion->consulta_lista();
                    $Hora = strtotime($_POST['hora_partido']) + (60 *60 * $tiempo_alquiler[0]);
                    $hora_fin = "".date('H:i:s',$Hora);
                    $centro = $_POST['id_centro'];
                    $fecha_partido = $_POST['fecha_partido'];
                    $hora_partido = $_POST['hora_partido'];
                    $sql = 'select count(*) from partidos where id_centro="'.$centro.'" and (estado_partido != 0 OR estado_partido != 3) and FECHA_PARTIDO = "'.$fecha_partido.'" and 
                    ((("'.$hora_partido.'" >= hora_partido and  "'.$hora_partido.'" < hora_fin) and ("'.$hora_fin.'"  > hora_partido and "'.$hora_fin.'"  >= hora_fin)) 
                    or (("'.$hora_partido.'" <= hora_partido and  "'.$hora_partido.'" > hora_fin) and ("'.$hora_fin.'" > hora_partido and "'.$hora_fin.'"  <= hora_fin)) 
                    or (hora_partido > "'.$hora_partido.'" AND hora_partido < "'.$hora_fin.'" ))';
                    if($miconexion->consulta($sql)){
                        $compr=$miconexion->consulta_lista();
                        if ($compr[0]=="0") {
                            $sql = 'select count(*) from reservas where id_centro="'.$centro.'" and (id_grupo!="'.$_POST['id_grupo'].'" or email="'.$_SESSION['email'].'") and fecha_reserva = "'.$fecha_partido.'" and 
                            ((("'.$hora_partido.'" >= hora_inicio and  "'.$hora_partido.'" < hora_fin) and ("'.$hora_fin.'"  > hora_inicio and "'.$hora_fin.'"  >= hora_fin)) 
                            or (("'.$hora_partido.'" <= hora_inicio and  "'.$hora_partido.'" > hora_fin) and ("'.$hora_fin.'" > hora_inicio and "'.$hora_fin.'"  <= hora_fin)) 
                            or (hora_inicio > "'.$hora_partido.'" AND hora_inicio < "'.$hora_fin.'" ))';
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
                                        $col[count($col)] = "estado_partido";
                                        $val[count($val)] = "2";
                                        $col[count($col)] = "hora_fin";
                                        $val[count($val)] = $hora_fin;
                                        $col[count($col)] = "id_user";
                                        $val[count($val)] = $_SESSION['id'];
                                        //insertar fecha creacion
                                        $col[count($col)]="fecha_creacion";
                                        $val[count($val)]=$hoy;

                                        $sql=$miconexion->ingresar_sql($bd,$col,$val);
                                        if($miconexion->consulta($sql)){
                                            $miconexion->consulta("select MAX(id_partido) AS id FROM partidos where id_user = '".$_SESSION['id']."'");
                                            $id = $miconexion->consulta_lista();                                         
                                            $sql = "insert into alineacion values ('','".$id[0]."','".$_SESSION['id']."','','','','".date('Y-m-d H:i:s', time())."','1')";
                                            if ($miconexion->consulta($sql)) {
                                                $sql = "insert into notificaciones (id_user, id_partido, fecha_not, visto, responsable, tipo, mensaje) 
                                                        values ('".$tiempo_alquiler[1]."','".$id[0]."','".date('Y-m-d H:i:s', time())."','0','".$_SESSION['id']."','cambios',' ha solicitado reservar el ".$_POST['fecha_partido']." a las ".date('g:i a', strtotime($_POST['hora_partido']))." para el partido')";
                                                $miconexion->consulta($sql);
                                                echo '<script>
                                                    $.get("../datos/cargarNotificaciones.php");
                                                    $.get("../datos/cargarTiempoEsperaPartidos.php");
                                                    $.get("../perfiles/crear_evento.php");
                                                    $("#cerrar_crearPartido").trigger("click");
                                                    $container = $("#container_notify").notify();    
                                                    create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Partido Creado <br> Miralo en tus partidos.", imagen:"../assets/img/check.png"});
                                                    send(1);
                                                    </script>';
                                            }else{
                                                echo '<script>
                                                $container = $("#container_notify").notify();  
                                                create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Ocurrio algo, por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
                                            </script>';
                                            }
                                        }else{
                                            echo '<script>
                                                $container = $("#container_notify").notify();  
                                                create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Ocurrio algo, por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
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
                        }else{
                            echo "<script>leer_horarios(); document.getElementById('error').innerHTML = 'Lo sentimos, este horario ya no se ecuentra disponible, por favor revisa el calendario e intetalo nuevamente.';</script>";
                        } 
                    }else{
                       echo '<script>
                            $container = $("#container_notify").notify();  
                            create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Ocurrio algo. <br>Por favor intenta nuevamente.", imagen:"../assets/img/alert.png"}); 
                        </script>';                    
                    }
                }else{
                    echo '<script>
                            $container = $("#container_notify").notify();  
                            create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"La fecha del partido no puede ser menor a la actual.", imagen:"../assets/img/alert.png"}); 
                        </script>';  
                }
            }
        break;
    }
?>