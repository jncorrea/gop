<?php 
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
session_start();
date_default_timezone_set('America/Guayaquil');

global $ahora;                  
$ahora = date("Y-m-d H:i:s", time());

?>
<script>
   var consulta;
         
  //hacemos focus
  $("#grupo").focus();
                                             
  //comprobamos si se pulsa una tecla
  $("#grupo").keyup(function(e){
         //obtenemos el texto introducido en el campo
         consulta = $("#grupo").val();
                                  
         //hace la búsqueda
         $("#resultado").delay(1000).queue(function(n) {  
         document.getElementById('crear_grupo').disabled=true;    
                                       
                $.ajax({
                  type: "POST",
                  url: "../include/comprobar.php",
                  data: "b="+consulta,
                  dataType: "html",
                  error: function(){
                        alert("error petición ajax");
                  },
                  success: function(data){     
                        $("#resultado").html(data);
                        n();
                	}                         
            });
                          
        });
                            
  });
</script>
<li class="sidebar-toggler-wrapper">
	<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
	<div class="sidebar-toggler">
	</div>
	<!-- END SIDEBAR TOGGLER BUTTON -->
</li>
<li>
	<a href="perfil.php">
		<i class="icon-home"></i>
		<span class="title">Home</span>
	</a>
</li>
<li>
	<a href="javascript:;">
	<i class="icon-group"></i>
	<span class="title">Mis Grupos</span>
	<span class="arrow "></span>
	</a>
	<ul class="sub-menu">
    <li>
      <a title="Crear Grupo" style='font-size:15px; display: inline-block; padding-right:5px;' href="#" onclick="mostrar('crearGrupo'); return false" >
          <i class="icon-plus"></i> Crear Grupo</a>
          <div id="crearGrupo" style="display:none;">
            <form method="post" action=""class="form-horizontal" id="form_grupo" style="display:inline-block; width:65%;">
              <div class="form-horizontal" style="display:inline-block; padding-left:10px; width:100%;">
                  <input type="hidden" class="form-control" id="bd" name="bd" value="grupos">
                  <?php 
                    echo '<input type="hidden" class="form-control" id="owner" name="owner" value="'.$_SESSION["id"].'">'; 
                   ?>
                  <input style="width:100%; display:inline-block;" type="text" class="form-control" id="grupo" name="grupo" placeholder="Grupo..">
              </div>
            </form>
            <div class="form-horizontal" style="display:inline-block; width:30%;">
              <input  onclick='enviar_form("../include/insertarGrupo.php","form_grupo");' id="crear_grupo" style="width:100%; display:inline-block; text-align:center;" disabled="false" type="submit" class="btn btn-default" value="Crear">
            </div>
            <div id="resultado"></div>
      </div>
    </li>
		<?php
        //// declarar variables 
       
        $limite=0;
        
      	$miconexion->consulta("select g.nombre_grupo, g.id_grupo, g.id_user, gm.id_user from grupos g, user_grupo gm where g.id_grupo=gm.id_grupo and gm.id_user='".$_SESSION['id']."' ORDER BY g.ultima_modificacion DESC");
      	$cont = $miconexion->numcampos();
        
        $limite=$miconexion->numregistros();
        if ($limite==0) {
            echo "<li><a>A&uacute;n No Tienes Grupos</a></li>";
        }else{
          if ($miconexion->numregistros()>4) {
            $limite=4;
            # code...
          }else{
            $limite=$miconexion->numregistros();

          }
        	for ($i=0; $i <$limite; $i++) { 
                $lista2=$miconexion->consulta_lista();
                echo "<li>";
                if ($lista2[2]==$lista2[3]) {?>
                  <a style='font-size:15px; display: inline-block; padding-right:5px;' href="javascript:VentanaConfirmacionModal('Estas seguro de eliminar este grupo ?','MensajeConfirmacion(1,<?php echo $lista2[1]; ?>)')"><i title='Eliminar Grupo' class='icon-remove'></i></a>
                <div id="FndYnnovaAlertas"></div>

                 
                  <?php
                  
                  echo  "<a style='display: inline-block; padding-left:0px;' href='perfil.php?op=grupos&id=".$lista2[1]."'>";
                  echo  "<i class='icon-group'></i> ".$lista2[0]."</a>";
                }else{
                  echo  "<a style='display: inline-block; padding-left:66px;' href='perfil.php?op=grupos&id=".$lista2[1]."'>";
                  echo  "<i class='icon-group'></i> ".$lista2[0]."</a>";
              }                       
                echo "</li>"; 
          }

          ?>
          <br>        
        <li>
          
          <a title="Ver Todos mis Grupos" style='' href="perfil.php?op=listar_grupos" >
            <i class="icon-group"></i> Ver Todos</a>
        </li>
          <?php
        }        
        ?> 
        <div id="respuesta"></div>
	</ul>
</li>
<?php 
  $miconexion->consulta("select count(*) from user_grupo where id_user='".$_SESSION['id']."'");
  $num = $miconexion->consulta_lista();
  $miconexion->consulta("select count(*) from alineacion where id_user='".$_SESSION['id']."'");
  $part = $num[0] + $miconexion->consulta_lista()[0];
  if ($part>0) {
  ?>
  <li>
  <a href="javascript:;">
  <i class="icon-gamepad"></i>
  <span class="title">Mis Partidos</span>
  <span class="arrow "></span>
  </a>
  <ul class="sub-menu">
    <li>
      <?php 
          if ($num>0) {
       ?>
          <a data-toggle="modal" href="#crear_partido" title="Crear Partido" style='z-index:4; font-size:15px; display: inline-block; padding-right:5px;'>
          <i class="icon-plus"></i> Crear Partido</a>
      <?php 
          }
       ?>
    </li>
    <?php
          $miconexion->consulta("select p.id_grupo, p.id_partido, p.fecha_partido, p.hora_partido, p.estado_partido, p.nombre_partido
            FROM partidos p, alineacion a
            WHERE p.id_partido = a.id_partido and a.id_user ='".$_SESSION['id']."' and p.estado_partido = '1'  and TIMESTAMP(p.fecha_partido, p.hora_partido) >='".$ahora."'  ORDER BY p.fecha_partido, p.hora_partido ASC");                 
            
                  
          $limite_partidos=0;
          $limite_partidos=$miconexion->numregistros();
          if ($limite_partidos==0) {
            echo "<li><a>No existen Partidos por jugar.</a></li>";
          }else{
            if ($miconexion->numregistros()>4) {
            $limite=4;
            # code...
            }else{
              $limite=$miconexion->numregistros();
            }
              for ($i=0; $i < $limite; $i++) { 
                $partidos=$miconexion->consulta_lista();
                if ($partidos[4]!='0') {
                  echo "<li>";
                  $time=$partidos[2];
                  $hora=$partidos[3];                  
                  echo  "<a title='".$time." - ".$hora."' href='perfil.php?op=alineacion&id=".$partidos[1]."'>
                        <i class='icon-gamepad'></i>
                        ".$partidos[5]."                        
                      </a>";                        
                  echo "</li>"; 
                }
              }
            
           }
           $miconexion->consulta("select count(*) FROM partidos p, alineacion a WHERE p.id_partido = a.id_partido and a.id_user  ='".$_SESSION['id']."'");
           $mis_partidos_porjugar=$miconexion->consulta_lista();
           $mis_partidos_porjugar=$mis_partidos_porjugar[0];
           
           $miconexion->consulta("select count(*) from partidos p, alineacion a
              WHERE p.id_partido = a.id_partido and a.id_user ='".$_SESSION['id']."' and TIMESTAMP(p.fecha_partido, p.hora_partido) <'".$ahora."'
              ORDER BY p.fecha_partido ASC");
           $mis_partidos_jugados=$miconexion->consulta_lista();
           $mis_partidos_jugados=$mis_partidos_jugados[0];

           if ($mis_partidos_porjugar!= 0 or $mis_partidos_jugados!=0) {

            echo "<br><li>";
              echo '<a title="Ver Todos mis Partidos" style="padding-left:15px;" href="perfil.php?op=listar_partidos" >
              <i class="icon-gamepad" style=""></i> Ver Todos</a></li>';
              echo "</li>";
             
           }
                  
        
           ?>
           <br>        
        <li>      
  </ul>
</li>
<?php } ?>
<li>
	<a href="javascript:;">
	<i class="icon-map-marker"></i>
	<span class="title">Centros Deportivos</span>
  <span class="arrow "></span>
	</a>
  <ul class="sub-menu">
    <li>
      <a href="perfil.php?op=canchas&x=nuevo" title="Crear Centro Deportivo" style='z-index:4; font-size:15px; display: inline-block; padding-right:5px;'>
      <i class="icon-plus"></i> Nuevo Centro</a>
    </li>
    <li>
      <a href="perfil.php?op=canchas" style='z-index:4; font-size:15px; display: inline-block; padding-right:5px;'>
      <i class="icon-map-marker"></i> Centros de mi ciudad</a>
    </li>
    <?php
      $miconexion->consulta("select c.id_centro, c.centro_deportivo from centros_deportivos c, centros_favoritos cf
        where c.id_centro = cf.id_centro and cf. id_user = '".$_SESSION['id']."' ORDER BY RAND()");                 
      if ($miconexion->numregistros()==0) {
      }else{
        echo '<li class="heading">
                <h3 class="uppercase" style="z-index:4; font-size:13px; color: #b4bcc8; padding-left:10px;">Mis Centros Favoritos</h3>
              </li>';
       for ($i=0; $i < 4; $i++) { 
          $centros=$miconexion->consulta_lista();
          echo "<li>";               
          echo  "<a href='perfil.php?op=canchas&id=".$centros[0]."'>
                <i class='icon-map-marker'></i>
                ".$centros[1]."                        
              </a>";                        
          echo "</li>";
        }
      }
       ?>
  </ul>
</li>
<?php
  $miconexion->consulta("select id_centro, centro_deportivo from centros_deportivos where id_user ='".$_SESSION['id']."'");
  if ($miconexion->numregistros()>0) {
  ?>
  <li>
    <a href="perfil.php?op=canchas">
      <i class="icon-suitcase"></i>
      <span class="title">Mis Centros Deportivos</span>
      <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
  <?php 
    for ($i=0; $i < $miconexion->numregistros(); $i++) { 
      $mis_centros=$miconexion->consulta_lista();
        echo "<li>";                 
        echo  "<a href='perfil.php?op=canchas&id=".$mis_centros[0]."'>
              <i class='icon-map-marker'></i>
              ".$mis_centros[1]."                        
            </a>";                        
        echo "</li>";        
    }
  ?>
    </ul>
  </li>
  <?php
  }                       
?>
<?php include("sugerencias.php"); ?>

<script type="text/javascript">


function MensajeConfirmacion(act, ident){
  
  $.get("../include/actualizar_notificaciones.php",
    { act: act, id: ident
    }, function(data){
        $("#respuesta").html(data);
    }); 

}

</script>

