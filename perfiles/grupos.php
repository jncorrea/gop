<?php
$miconexion->consulta("select * from grupos g
where g.id_grupo='".$id."'");
$nom=$miconexion->consulta_lista();
$hoy = date("Y-m-d H:i:s", time());
?>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
<h3 class="page-title">
<?php echo strtoupper($nom[2]); ?><small> Informaci&oacute;n del Grupo</small>
</h3>
<div class="portlet light" style="height:1100px;">
  <div class="portlet-title tabbable-line">
    <ul class="nav nav-tabs">
      <li class="active">
        <a href="#home_grupo" data-toggle="tab" aria-expanded="true">
        <i class="icon-home"></i></a>
      </li>
      <li class="">
        <a href="#miembros" data-toggle="tab" aria-expanded="false">
        Miembros</a>
      </li>
      <li class="">
        <a href="#partidos" data-toggle="tab" aria-expanded="false">
        Partidos</a>
      </li>
    </ul>
  </div>
  <div class="portlet-body">
    <div class ="row">
      <div class ="col-lg-12 col-md-12 col-xs-12" style="padding-bottom: 20px;">
        <?php
        if ($nom[3]=="") {
        ?>
        <img id="img_grupo" style="width:100%; height: 300px;" src="../assets/img/soccer1.png" alt="">
        <?php
        } else {
        ?>
        <img id="img_grupo" style="width:100%; height: 300px;" src=<?php echo "'images/grupos/".$id."/".$nom[3]."'"; ?> alt="">
        <?php } ?>
      </div>
    </div>
    <?php if ($nom[1]==$_SESSION['id']):
    date_default_timezone_set('America/Guayaquil');
    $fecha=date("Y-m-d H:i:s", time());
    
    ?>
    <button id="guardar_img" type="button" class="btn green-haze" style="font-size:95%; padding:5px; background:#4CAF50; display:none;" onclick='enviar_form("../include/actualizar_perfil.php","form_act_img")'>Guardar Cambios</button>
    <a id="cancelar_img" class="btn red" style="display:none; font-size:95%; padding:5px; " href="">Cancelar</a>
    <div class="upload_wrapper" style="float: right;margin-top:-70px;margin-right: 30px;" id="up0">
      <img src="../assets/img/camara.png" style="height:30px;" alt="Cambiar imagen"/>
      <form method="post" action="" id="form_act_img" enctype="multipart/form-data">
        <input name="bd" type="hidden" value="grupos"/>
        <input name="id_grupo" type="hidden" value="<?php echo $id; ?>"/>
        <input name="ultima_modificacion" type="hidden" value="<?php echo $fecha;?>"/>
        <input style="width: 100px;height:100px;" id="uploadbtn4" name="logo" type="file" class="upload" title="Cambiar imagen"  accept="image/png, image/gif, image/jpg, image/jpeg"/>
      </form>
    </div>
    <?php endif ?>
    <div style="float:right;">
      <a  class="btn red" style="font-size:12px; border-radius: 10px !important;" onclick="actualizar_notificacion('6','<?php echo $id ?>')"> Abandonar Grupo</a>
    </div>
    <div class="clear-fix"></div>
    <div class="tab-content">
      <div class="tab-pane active" id="home_grupo">
        <div class='' style="padding-top:70px; padding-right: 15px; padding-left: 15px;">
          <form method="post" action="" enctype="multipart/form-data" class="form-horizontal" id="form_comentarios">
            <?php
            $miconexion->consulta("select  avatar, sexo from usuarios where id_user=".$_SESSION["id"]);
            $avatar=$miconexion->consulta_lista();
            date_default_timezone_set('America/Lima');
            echo "<input type='hidden' name='bd' value='comentarios'>";
            echo "<input type='hidden' name='id_user' value='".$_SESSION["id"]."'>";
            echo "<input type='hidden' name='id_grupo' value=".$id.">";
            echo "<input type='hidden' name='fecha_publicacion' id='fecha_actual'>";
            ?>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin:0px; padding:0px;">
              <?php
              if ($avatar[0]=="") {
              if ($avatar[1]=="Femenino") {
              echo '<img class="img-circle" style="width:55px; height:55px; display:inline-block;" src="../assets/img/user_femenino.png"/>';
              }else{
              echo '<img class="img-circle" style="width:55px; height:55px; display:inline-block;" src="../assets/img/user_masculino.png"/>';
              }
              }else{
              echo "<img class='img-circle' src='images/".$_SESSION["user"]."/".$avatar[0]."' style='width:55px; height:55px; display:inline-block;' > ";
              }
              ?>
            </div>
            <div class='col-lg-10 col-md-10 col-sm-10 col-xs-10'>
              <textarea id="text_comentario" style="display:inline-block;" class="form-control" style="width:100%;" name="comentario" placeholder="Ingrese su comentario.." required></textarea>
              <output id="img_comentario" style="text-align: center;"></output>                 
            </div>
            <div  class="form-group">
              <div class="upload_wrapper" style="float: right; margin-right: 30px;" id="up0">
                <img src="../assets/img/comen.png" style="height:30px;" alt="Adjuntar imagen"/>
                <input style="width: 100px;height:100px;" id="imagen_comentario" name="image" type="file" class="upload" title="Adjuntar imagen"  accept="image/png, image/gif, image/jpg, image/jpeg"/>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-9">
                <button type="button" class="btn green-haze" style= "float:right; background:#4CAF50; border-radius: 10px !important;" onclick='enviar_form("../include/insertar_comentario.php","form_comentarios");'>Comentar</button>
              </div>
            </div>
          <ul id="respuesta"></ul>
        </form>
      </div>
      <?php $comen = 'g'; include("comentarios.php");  ?>
    </div>
    <div class="tab-pane" id="miembros">
      <div class="col-xs-12 col-md-12">
        <?php if ($nom[1]==$_SESSION['id']):
        $grupo = md5($id); ?>
        <h3>Invitar <a title="A&ntilde;adir miembro" href="#" onclick="mostrar('invite'); return false" style="color: #5b9bd1; !important">
        <i class="icon-plus-sign" style="font-size:20px;"></i></a>
        <a href='#' onclick="FacebookInviteFriends('<?php echo $grupo ?>');" title="Invitar amigos por facebook"><i class="icon-facebook-sign" style="font-size:20px; color: #5b9bd1 !important;"></i></a>
        </h3>
        <div id="invite" style="display:none;">
          <form method="post" id="form_invitar_miembro" action="#" class="form-horizontal" autocomplete="off" style="display:inline-block;">
            <div class="form-horizontal" style="display:inline-block;">
              <input type="hidden" class="form-control" id="bd" name="bd" value="user_grupo">
              <input style="width:100%; display:inline-block;" type="text" class="form-control" id="persona" name="persona" placeholder="Buscar...">
              <input type="hidden" class="form-control" id="id_persona" name="id_persona" value="">
              <?php
              echo '<input type="hidden" id="id_grupo" name="id_grupo" value="'.$nom[0].'">';
              ?>
              <input type="hidden" id="fecha_invitar" name="fecha_actual" value="">
            </div>
          </form>
          <div class="form-horizontal" style="display:inline-block;">
            <button title="Invitar" type="submit" onclick='cargar_fecha_grupo(); enviar_form("../include/insertarMiembro.php","form_invitar_miembro"); ' style="width:100%; display:inline-block;" class="btn btn-default"><i class="icon-plus-sign"></i></button>
            <div id="respuesta"></div>
          </div>
        </div>
        <?php endif ?>
        <output id="list" style="text-align: center;"></output>
        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 ' style="padding-top:30px; padding-left: 2px;">
          <div class="scroller" id="col_miembros" style="height: 540px;" data-always-visible="1" data-rail-visible1="1">
          </div>
        </div>

      </div>
    </div>
    <div class="tab-pane" id="partidos">
      <div class="row"  style="padding-top:70px; padding-right: 15px; padding-left: 15px;">
        <div class="scroller" style="height: 540px;" data-always-visible="1" data-rail-visible1="1">   
          <?php include("partidos_g.php"); ?>       
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="modal fade" id="eliminar_partido" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="">Eliminar Partido</h4>
      </div>
      <div class="modal-body">
        Est&aacute; seguro de eliminar este partido?
        <br>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="del">
        <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
        <a data-toggle="modal" href="#" class="btn green-haze" style="background:#C42E35;" data-dismiss="modal" onclick="borrar(<?php echo $id ?>);">Aceptar</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="infor_partido" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Informaci&oacute;n del Partido <span id="nom_partido"></span></h4>
      </div>
      <div class="modal-body">
          <div class="row static-info">
            <div class="col-md-5 value">
              Responsable:
            </div>
            <div class="col-md-7 name" id="responsable"></div>
          </div>
          <div class="row static-info">
            <div class="col-md-5 value">
              Grupo:
            </div>
            <div class="col-md-7 name" id="grupo_partido"></div>
          </div>
          <div class="row static-info">
            <div class="col-md-5 value">
              Fecha:
            </div>
            <div class="col-md-7 name" id="fecha"></div>
          </div>
          <div class="row static-info">
            <div class="col-md-5 value">
              Hora:
            </div>
            <div class="col-md-7 name" id="hora"></div>
          </div>
          <div class="row static-info">
            <div class="col-md-5 value">
              Estado:
            </div>
            <div class="col-md-7 name" id="estado"></div>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div> 
<script>
function eliminar(partido){
document.getElementById("del").value=partido;
}
function borrar(id){
actualizar_notificacion(24,$('#del').val(), id);
}
function cargar_fecha_grupo(){
var d = new Date();
document.getElementById("fecha_invitar").value = d.getFullYear() + "-" + (d.getMonth() +1) + "-" + d.getDate()+ ' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
}
function archivo(evt) {
var files = evt.target.files; // FileList object
//Obtenemos la imagen del campo "file".
for (var i = 0, f; f = files[i]; i++) {
//Solo admitimos imágenes.
if (!f.type.match('image.*')) {
continue;
}
var reader = new FileReader();
reader.onload = (function(theFile) {
return function(e) {
// Creamos la imagen.
document.getElementById('img_grupo').src = e.target.result;
document.getElementById('guardar_img').style.display = '';
document.getElementById('cancelar_img').style.display = '';
//document.getElementById("list").innerHTML = ['<img style="width: 120px; height: 120px; border: 1px solid #000;" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
};
})(f);
reader.readAsDataURL(f);
}
}
document.getElementById('uploadbtn4').addEventListener('change', archivo, false);
</script>