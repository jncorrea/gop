<?php 
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
session_start();
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
extract($_GET);
 ?>
<table class="table table-striped" >
  <?php
  $miconexion->consulta("select g.nombre_grupo, m.nombres, m.apellidos, gm.id_user, m.avatar, g.id_user, gm.estado_conec, m.email, gm.fecha_inv, m.sexo, m.user 
    from grupos g, user_grupo gm, usuarios m 
    where g.id_grupo=gm.id_grupo and gm.id_user = m.id_user and gm.id_grupo='".$id."' 
    UNION select g.nombre_grupo, m.nombres, m.apellidos, n.id_user, m.avatar, g.id_user, n.tipo, m.email, n.fecha_not, m.sexo, m.user 
    from grupos g, notificaciones n, usuarios m where g.id_grupo=n.id_grupo and n.id_user = m.id_user and n.id_grupo='".$id."' and n.tipo='solicitud'");
  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    $lista3=$miconexion->consulta_lista();
      echo "<tr>";
      if ($lista3[4]==""){
        if ($lista3[9]=="Femenino") {
          echo '<td style="width:40px;"><img class="img-circle" style="width:40px; height:40px;" src="../assets/img/user_femenino.png"/></td>';
        }else{
          echo '<td style="width:40px;"><img class="img-circle" style="width:40px; height:40px;" src="../assets/img/user_masculino.png"/></td>';
        }
     }else{
        echo "<td style='width:40px;'><img class='img-circle' style='width:40px; height:40px;' src='images/".$lista3[10]."/".$lista3[4]."'></td>";
      }
      if ($lista3[3]==$lista3[5]) {
        echo  "<td style='font-size: 9px;'><span style='font-size: 11px; color: #006064; font-weight: bold;'>".strtoupper($lista3[1]." ".$lista3[2])."</span> <strong>(Administrador)</strong><br>".$lista3[7]."<br> Miembro desde ".date('d-m-Y',strtotime($lista3[8]))."</td>";
        echo "<td style='width:19.43px;'></td>";
      }else{
      if ($lista3[6]=='solicitud') {
        echo  "<td style='font-size: 9px;'><span style='font-size: 11px; color: #006064; font-weight: bold;'>".strtoupper($lista3[1]." ".$lista3[2])."</span><br>".$lista3[7]." (Invitado)<br> Invitado el ".date('d-m-Y',strtotime($lista3[8]))."</td>";
        echo "<td style='width:19.43px;'></td>";
      }else{
        if ($lista3[5]==$_SESSION['id']){ 
        echo  "<td style='font-size: 9px;'><span style='font-size: 11px; color: #006064; font-weight: bold;'>".strtoupper($lista3[1]." ".$lista3[2])."</span><br>".$lista3[7]."<br> Miembro desde ".date('d-m-Y',strtotime($lista3[8]))."</td>";
        echo '<td class="btn-group pull-right" style="padding-left:0px; padding-right:10px;">
            <button aria-expanded="false" style="width:100%; display:inline-block; background-color:transparent; margin: 0;padding: 0;"  type="button" class="btn btn-xs dropdown-toggle hover-initialized" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
            <i style="font-size:14px;" class="icon-cog"></i>
            </button>';?>
            <ul class="dropdown-menu pull-right" role="menu">
              <li>
                <a onclick="actualizar_notificacion('8','<?php echo $id ?>','<?php echo $lista3[3] ?>')" style="width:100%; display:inline-block; font-size:11px;" class="btn btn-default">
                  Nombrar Administrador
                </a>
              </li>
              <li>
                <a onclick="actualizar_notificacion('7','<?php echo $id ?>','<?php echo $lista3[3] ?>')"  style="width:100%; display:inline-block; font-size:11px;" class="btn btn-default">
                  Eliminar del grupo
                </a>
              </li>
            </ul>
          <div id="respuesta"></div>
        </td><?php 
        }else{
          echo  "<td style='font-size: 9px;'><span style='font-size: 11px; color: #006064; font-weight: bold;'>".strtoupper($lista3[1]." ".$lista3[2])."</span><br>".$lista3[7]."</td>";
          echo "<td style='width:19.43px;'></td>";
        }
      }
    }
      echo "</tr>";
    }
   ?>            
</table>