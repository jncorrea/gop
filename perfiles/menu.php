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
         document.getElementById('btn_crear_grupo').disabled=true;    
                                       
                $.ajax({
                  type: "POST",
                  url: "../include/comprobar.php",
                  data: "b="+consulta,
                  dataType: "html",
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
      <a title="Crear Grupo" style='font-size:15px; display: inline-block; padding-right:5px;' data-toggle="modal" href="#crear_grupo" >
          <i class="icon-plus"></i> Crear Grupo</a>
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
                  <a style='font-size:15px; display: inline-block; padding-right:5px;' onclick="actualizar_notificacion(34,<?php echo $lista2[1]; ?>);" data-toggle="modal" href="#bad_grupo" ><i title='Eliminar Grupo' class='icon-remove'></i></a>
                
                  
                  <?php
                  $longitud=strlen($lista2[0]);                  
                  echo  "<a title='".$lista2[0]."' style='display: inline-block; padding-left:0px;' href='perfil.php?op=grupos&id=".$lista2[1]."'>";
                  if ($longitud>16) {
                    echo  "<i class='icon-group'></i> ".substr($lista2[0], 0, 12)."..</a>";                  

                  }else{
                    echo  "<i class='icon-group'></i> ".$lista2[0]."</a>";
                  }
                  
                  
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
  $num_grupos=$num[0];
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
          if ($num_grupos>0) {            
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
        $veces = $miconexion->numregistros();
        if ($veces > 4) {
          $veces = 4;
        }
       for ($i=0; $i < $veces; $i++) { 
          $centros=$miconexion->consulta_lista();
          echo "<li>";               
          echo  "<a href='perfil.php?op=canchas&id=".$centros[0]."'>
                <i class='icon-map-marker'></i>
                ".$centros[1]."                        
              </a>";                        
          echo "</li>";
        }
      }
      if (@$veces>0) {
        ?>
        <li>
          
          <a title="Ver Todos mis Centros Favoritos" style='padding-left:15px;' href="perfil.php?op=configurar&opcion=favoritos" >
            <i class="icon-star"></i> Ver Todos</a>
        </li>

        <?php
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

<!--- LISTA MIS CAMPEONATOS -->
  
<li>
  <a href="javascript:;">
  <i class="icon-tasks"></i>
  <span class="title">Mis Campeonatos</span>
  <span class="arrow "></span>
  </a>
  <ul class="sub-menu">
    <li>
          <a data-toggle="modal" href="#crear_campeonato" title="Crear un Campeonato" style='z-index:4; font-size:15px; display: inline-block; padding-right:5px;'>

          <i class="icon-plus"></i> Crear Campeonato</a>          
    </li>
    <?php
        //// declarar variables 
       
        $limite_camp=0;
        
        $miconexion->consulta("select id_campeonato, nombre_campeonato, id_user from campeonatos where id_user=".$_SESSION['id']." union select distinct gc.id_campeonato, c.nombre_campeonato, c.id_user from grupos_campeonato gc, campeonatos c where gc.id_grupo in (select id_grupo from user_grupo where id_user=".$_SESSION['id'].") and gc.id_campeonato not in (select id_campeonato from campeonatos where id_user=".$_SESSION['id'].") and c.id_campeonato=gc.id_campeonato");

        $limite_camp=$miconexion->numregistros();
        if ($limite_camp==0) {
            echo "<li><a>A&uacute;n No Tienes Campeonatos</a></li>";
        }else{
          if ($miconexion->numregistros()>4) {
            $limite_camp=4;
          }else{
            $limite_camp=$miconexion->numregistros();

          }
          for ($i=0; $i <$limite_camp; $i++) { 
                $lista3=$miconexion->consulta_lista();
                echo "<li>";

                if ($lista3[2]==$_SESSION['id']) {
                  echo "<a style='font-size:15px; display: inline-block; padding-right:5px;' onclick='actualizar_notificacion(39,$lista3[0]);' data-toggle='modal' href='#bad_campeonato' ><i title='Eliminar Campeonato' class='icon-remove'></i></a>";
                }else{
                  echo  "<a style='font-size:15px; display: inline-block; padding-right:25px;' href='perfil.php?op=campeonato&id=".$lista3[0]."'>";
                }
                
                  ?>
                  <?php
                  $longitud=strlen($lista3[1]);                  
                  echo  "<a title='".$lista3[1]."' style='display: inline-block; padding-left:0px;' href='perfil.php?op=campeonato&id=".$lista3[0]."'>";
                  if ($longitud>16) {
                    echo  "<i class='icon-tasks'></i> ".substr($lista3[1], 0, 12)."..</a>";                  

                  }else{
                    echo  "<i class='icon-tasks'></i> ".$lista3[1]."</a>";
                  }
                echo "</li>"; 
          }

          

          ?>
          <br>        
        <li>
          
          <a title="Ver Todos mis Campeonatos" style='' href="perfil.php?op=listar_campeonatos" >
            <i class="icon-tasks"></i> Ver Todos</a>
        </li>
          <?php
        }        
        ?> 
        
  </ul>
</li>
   

<?php include("sugerencias.php"); ?>

<li>
  <a href="javascript:;">
  <i class="icon-question"></i>
  <span class="title">Ayuda</span>
  <span class="arrow "></span>
  </a>
  <ul class="sub-menu">
    <li>
      <a onclick="mostrar_opciones(1);" data-toggle="modal" href="#servicios" title="Servicios" style='z-index:4; font-size:15px; display: inline-block; padding-right:5px;'>
      <i class="icon-tags"></i> Servicios</a>          
    </li>
    <li>
      <a data-toggle="modal" href="#contacto" title="Contacto" style='z-index:4; font-size:15px; display: inline-block; padding-right:5px;'>
      <i class="icon-comments"></i> Cont&aacute;ctanos</a>          
    </li>
    <li>
      <a data-toggle="modal" href="#acerca-de" title="Acerca de" style='z-index:4; font-size:15px; display: inline-block; padding-right:5px;'>
      <i class="icon-exclamation"></i> Acerca de</a>          
    </li>
  </ul>
</li>


