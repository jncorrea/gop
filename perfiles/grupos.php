  <?php 
header('Content-Type: text/html; charset=ISO-8859-1');
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
session_start();
extract($_GET);
$miconexion->consulta("select * from grupos g
  where g.id_grupo='".$id."'");
  $nom=$miconexion->consulta_lista();
?>
  <script>


      $( "#persona" ).autocomplete({
    minLength: 0,
    source: '../include/buscarPersona.php',
    focus: function( event, ui ) {
      $( "#persona" ).val( ui.item.label );
      return false;
    },
    select: function( event, ui ) {
      $( "#persona" ).val( ui.item.label );
      $( "#id_persona" ).val( ui.item.value );

      return false;
    }
  })
  .autocomplete( "instance" )._renderItem = function( ul, item ) {
    return $( "<li>" )
      .append( "<a>" +"<img padding: 0px; style='width:35px; height:35px; display:inline-block;' src='"+item.avatar+"'></img>"+
        "<div style='line-height: 12px; display:inline-block; font-size: 80%; padding-left:5px;'><strong>"+
        item.descripcion + "</strong><p style='font-size: 90%;'>" + item.label + "</p></div></a>" )
      .appendTo( ul );
  };
  </script>
  <style>
   .upload_wrapper {
  position: relative;
  overflow: hidden;
  cursor: pointer;
  //margin: 10px;
}
.upload_wrapper input.upload {
  position: absolute;
  top: 0;
  right: 0;
  margin-top: -20px;
  padding: 0;
  font-size: 20px;
  cursor: pointer;
  opacity: 0;
  filter: alpha(opacity=0);
}
  </style>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
    <h3 class="page-title">
      <?php echo strtoupper($nom[2]); ?><small> Informaci&oacute;n del Grupo</small>
    </h3>
    <div class="portlet light" style="height:850px;">
      <div class ="row">
        <div class ="col-lg-12 col-md-12 col-xs-12" style="padding-bottom: 20px;">
          <?php 
            if ($nom[3]=="") {
          ?> 
            <img style="width:100%; height: 300px;" src="../assets/img/soccer1.png" alt="">
          <?php
            } else {
           ?>
            <img style="width:100%; height: 300px;" src=<?php echo "'images/grupos/".$nom[3]."'"; ?> alt="">
          <?php } ?>
        </div>        
      </div>
      <?php if ($nom[1]==$_SESSION['id']): ?>
        <div class="upload_wrapper" style="float: right;margin-top:-70px;margin-right: 30px;" id="up0">
          <img src="../assets/img/camara.png" style="height:30px;" alt="Cambiar imagen"/>
          <input  style="width: 100px;height:100px;" id="uploadbtn4" name="pic[]" type="file" class="upload" title="Cambiar imagen"/>
        </div>
      <?php endif ?>
      <div style="float:right;">
        <a  class="btn red" onclick="actualizar_notificacion('6','<?php echo $id ?>')"> Abandonar Grupo..</a> 
      </div>
      <div class="col-xs-12 col-md-12">
      <?php if ($nom[1]==$_SESSION['id']): ?>        
          <h3>Invitar <a title="A&ntilde;adir miembro" style="font-size:20px;" href="#" onclick="mostrar('invite'); return false" >
            <i class="icon-plus-sign"></i></a>
          </h3>
          <div id="invite" style="display:none;">
            <form method="post" id="form_invitar_miembro" action="" class="form-horizontal" autocomplete="off" style="display:inline-block;">
              <div class="form-horizontal" style="display:inline-block;">
                <input type="hidden" class="form-control" id="bd" name="bd" value="user_grupo">
                <input style="width:100%; display:inline-block;" type="text" class="form-control" id="persona" name="persona" placeholder="Buscar...">
                <input type="hidden" class="form-control" id="id_persona" name="id_persona" value="">
                <?php 
                  echo '<input type="hidden" class="form-control" id="id_grupo" name="id_grupo" value="'.$nom[0].'">'; 
                 ?>
              </div>
            </form>
            <div class="form-horizontal" style="display:inline-block;">
              <button type="submit" onclick='enviar_form("../include/insertarMiembro.php","form_invitar_miembro");' style="width:100%; display:inline-block;" class="btn btn-default"><i class="icon-plus-sign"></i></button>
              <div id="respuesta"></div>
            </div>
          </div>
      <?php endif ?>         

      <div class="row" style="padding-top:20px;">
        <div class='col-lg-4 col-md-4 col-sm-6 col-xs-12'>
          <table class="table table-striped">
            <?php
            $miconexion->consulta("select g.nombre_grupo, m.nombres, m.apellidos, gm.id_user, m.avatar, g.id_user, gm.estado_conec, m.email, gm.fecha_inv 
              from grupos g, user_grupo gm, usuarios m 
              where g.id_grupo=gm.id_grupo and gm.id_user = m.id_user and gm.id_grupo='".$id."' order by g.id_user=gm.id_user desc");
            for ($i=0; $i < $miconexion->numregistros(); $i++) { 
              $lista3=$miconexion->consulta_lista();
                echo "<tr>";
                if ($lista3[4]==""){
                  echo '<td style="width:40px;"><img class="img-circle" style="width:40px; height:40px;" src="../assets/img/user.png" alt="Avatar"></td>';
                }else{
                  echo "<td style='width:40px;'><img class='img-circle' style='width:40px; height:40px;' src='images/".$lista3[7]."/".$lista3[4]."'></td>";
                }
                if ($lista3[3]==$lista3[5]) {
                  echo  "<td style='font-size: 9px;'><span style='font-size: 11px; color: #006064; font-weight: bold;'>".strtoupper($lista3[1]." ".$lista3[2])."</span> <strong>(Administrador)</strong><br>".$lista3[7]."<br> Invitado el ".date('d-m-Y',strtotime($lista3[8]))."</td>";
                  echo "<td style='width:19.43px;'></td>";
                }else{
                if ($lista3[6]=='0') {
                  echo  "<td style='font-size: 9px;'><span style='font-size: 11px; color: #006064; font-weight: bold;'>".strtoupper($lista3[1]." ".$lista3[2])."</span><br>".$lista3[7]." (Invitado)<br> Invitado el ".date('d-m-Y',strtotime($lista3[8]))."</td>";
                  echo "<td style='width:19.43px;'></td>";
                }else{
                  if ($lista3[5]==$_SESSION['id']){ 
                  echo  "<td style='font-size: 9px;'><span style='font-size: 11px; color: #006064; font-weight: bold;'>".strtoupper($lista3[1]." ".$lista3[2])."</span><br>".$lista3[7]."<br> Invitado el ".date('d-m-Y',strtotime($lista3[8]))."</td>";
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
        </div>
        <div class='col-lg-8 col-md-8 col-sm-6 col-xs-12'>
          <form method="post" action="" enctype="multipart/form-data" class="form-horizontal" id="form_comentarios">
          <?php
            $miconexion->consulta("select  avatar from usuarios where id_user=".$_SESSION["id"]);
            $avatar=$miconexion->consulta_lista();    
            date_default_timezone_set('America/Lima');              
            echo "<input type='hidden' name='bd' value='comentarios'>";
            echo "<input type='hidden' name='id_user' value='".$_SESSION["id"]."'>";
            echo "<input type='hidden' name='id_grupo' value=".$id.">";
            echo "<input type='hidden' name='fecha_publicacion' value='".date("Y-m-d H:i:s", time())."'>";
          ?>
            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>     
                <?php
                if ($avatar[0]=="") {
                  echo "<img class='avatar' src='../assets/img/user.png' style='width:55px; height:55px; display:inline-block;' >  ";
                }else{
                  echo "<img class='avatar' src='images/".$_SESSION["email"]."/".$avatar[0]."' style='width:55px; height:55px; display:inline-block;' > ";
                }
                ?>      
            </div>
            <div class='col-lg-10 col-md-10 col-sm-10 col-xs-10'>
                <textarea id="text_comentario" style="display:inline-block;" class="form-control" style="width:100%;" name="comentario" placeholder="Ingrese su comentario.." required></textarea>      
              </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-9">
            <button type="button" class="btn btn-default" style= "float:right;" onclick='enviar_form("../include/insertar_comentario.php","form_comentarios");'>Enviar Comentario</button>
              </div>
            </div>
            <ul id="respuesta"></ul>
          </form>
          <div class="portlet-body" id="bloc_comentarios_grupos"></div>
        </div>          
      </div>
    </div>
  </div>

