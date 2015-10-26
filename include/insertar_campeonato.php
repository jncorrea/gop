<?php 
    extract($_POST);
    date_default_timezone_set('America/Guayaquil'); 
	include("../static/clase_mysql.php");
	include("../static/site_config.php");
    session_start();
    
    date_default_timezone_set('America/Guayaquil');
    $hoy = date("Y-m-d H:i:s", time());
    $id_mi_campeonato=0;

    global $dias;
	@$miconexion = new clase_mysql;
	@$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
    $bd=utf8_decode(array_values($_POST)[0]);
    $flag_nombre=0;
    switch ($bd) {
        case '1':
            $bd="campeonatos";
            //Consulta para verificar qu no se haya registrado anteriormente el mmismo nombre de campeonato.
            $miconexion->consulta("select id_campeonato from campeonatos where nombre_campeonato='".$_POST['nombre_campeonato']."'");
            $flag_nombre=$miconexion->numregistros();

            if ($_POST['nombre_campeonato']=='' || $_POST['etapas']=='' ) {
                echo '<script> 
                $container = $("#container_notify").notify();
               create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"* Campos Requeridos", imagen:"../assets/img/alert.png"}); 
                </script>';      
            }elseif($flag_nombre!=0){
                echo '<script> 
                $container = $("#container_notify").notify();  
               create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:" Este nombre de campeonato ya ha sido registrado", imagen:"../assets/img/alert.png"}); 
                </script>';
            }else{

                for ($i=1; $i <count($_POST); $i++) {
                    if ($i==1) {        
                        @$val[$i-1]=$_SESSION['id'];
                        @$nombres[$i-1]= 'id_user';
                    }else{
                        @$val[$i-1] = utf8_decode(array_values($_POST)[$i-1]);
                        @$nombres[$i-1]= array_keys($_POST)[$i-1];
                    }   
                }

                $sql=$miconexion->ingresar_sql($bd,$nombres,$val);
                if($miconexion->consulta($sql)){
                    $miconexion->consulta("select id_campeonato from campeonatos where nombre_campeonato='".$val[1]."' and id_user=".$_SESSION['id']."");
                    $id_mi_campeonato=$miconexion->consulta_lista()[0];        
                    $campo_etapa=array_keys($_POST)[4];
                    $num_etapa=utf8_decode(array_values($_POST)[4]);
                    if ($id_mi_campeonato>0) {
                        for ($i=1; $i <=$num_etapa ; $i++) { 
                            $miconexion->consulta("insert into etapas (id_campeonato, etapa) VALUES (".$id_mi_campeonato.",'Etapa ".$i."')");
                        }
                        
                    }
                    echo '<script>
                    $("#cerrar_crearCampeonato").trigger("click"); 
                    $container = $("#container_notify").notify();  
                    create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Campeonato Creado.", imagen:"../assets/img/check.png"});
                    location.href = "perfil.php?op=campeonato&id='.$id_mi_campeonato.'";
                    </script>';
                }else{
                    echo '<script>
                    $container = $("#container_notify").notify();  
                    create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Ocurrio algo, por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
                    </script>';

                }
            }    
            
            break;
        case '2':
            $bd="campeonatos";
            for ($i=1; $i <count($_POST); $i++) {
                @$val[$i-1] = utf8_decode(array_values($_POST)[$i]);
                @$nombres[$i-1]= array_keys($_POST)[$i];
            }
            if ($_POST['nombre_campeonato']=="") {
                echo '<script>
                        $container = $("#container_notify").notify();  
                        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"* Campos Requeridos.", imagen:"../assets/img/alert.png"}); 
                        </script>';
            }else{                
                $miconexion->consulta("select id_campeonato from campeonatos where nombre_campeonato='".$_POST['nombre_campeonato']."' and id_campeonato != ".$_POST['id_campeonato']);
                $flag_nombre=$miconexion->numregistros();
                if ($flag_nombre != 0) {
                    echo '<script>
                        $container = $("#container_notify").notify();  
                        create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"El nombre del campeonato ya existe.", imagen:"../assets/img/alert.png"}); 
                        </script>';
                }else{                    
                    $sql=$miconexion->sql_actualizar($bd,$val,$nombres);
                    if ($miconexion->consulta($sql)) {
                        echo '<script>
                            $container = $("#container_notify").notify();  
                            create("default", { color:"background:rgba(16,122,43,0.8);", enlace:"#" ,title:"Notificaci&oacute;n", text:"Campeonato Editado.", imagen:"../assets/img/check.png"});
                            location.href = location.href;
                            </script>';
                    }else{
                        echo '<script>
                            $container = $("#container_notify").notify();  
                            create("default", { color:"background:rgba(218,26,26,0.8);", enlace:"#" ,title:"Alerta", text:"Ocurrio algo, por favor intente nuevamente.", imagen:"../assets/img/alert.png"}); 
                            </script>';
                    }
                }
            }
            break;
    }
    
?>