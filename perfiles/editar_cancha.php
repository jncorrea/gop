  <?php 
  global $lista_evento;
  $miconexion->consulta("select * from centros_deportivos where id_centro= '".@$id."'");  
  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    $lista_evento=$miconexion->consulta_lista();
  }
  ?>
  <!-- END PAGE HEADER-->
  <!-- BEGIN DASHBOARD STATS -->
  <h3 class="page-title">
    <?php echo strtoupper($lista_evento[2]) ?> <small>Editar Centro</small>
  </h3>
  <div class="clearfix">
  </div>
  <div class="row">
    <div class="col-md-3 col-sm-3">
      <!-- BEGIN PORTLET-->
      <div class="portlet light ">
        <div class="portlet-title">
          <div class="caption">
            <span class="caption-subject bold uppercase" style="font-size:12px; color:#4CAF50;">Mis Centros Deportivos</span>
          </div>
        </div>
        <div class="portlet-body" id="chats">
          <div class="scroller" style="height: 441px;" data-always-visible="1" data-rail-visible1="1">
            <ul id="cancha" style="padding-left:0; font-size:14px;">
              <?php 
              $miconexion->consulta("select * from centros_deportivos where id_user = '".$_SESSION['id']."'");
              for ($i=0; $i < $miconexion->numregistros(); $i++) { 
                $lista=$miconexion->consulta_lista();
                echo '<li style="list-style: none; text-align:left;">
                <a href="perfil.php?op=editar_cancha&id='.$lista[0].'">
                  <i class="icon-map-marker" style="padding: 10px 15px; font-size:18px;"></i>
                  <span class="title">'.$lista[2].'</span>
                </a>
              </li>';
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
    <!-- END PORTLET-->
  </div>
  <div class="col-md-9 col-sm-9">
    <div class="portlet light ">
      <div class="portlet-title tabbable-line">
        <div class="caption">
          <span class="caption-subject bold uppercase" style="color: #006064;">
            <?php echo $lista_evento[2]; ?>
            </span>
            <br><span style="color: red; font-size:11px; padding:10px;">
            * Campos requeridos
          </span>
        </div>
        <div class="caption" style="float:right;">
            <a href="perfil.php?op=canchas&id=<?php echo $id ?>" style="z-index:4;font-size:15px; color: #006064; padding-left: 30px;;" title="Ver cancha"><i style="font-size:130%" class=" icon-eye-open"></i></a>
        </div>
        <ul class="nav nav-tabs">
          <li class="active">
            <a href="#info" data-toggle="tab" aria-expanded="true">
            Informaci&oacute;n </a>
          </li>
          <li class="">
            <a href="#horario" data-toggle="tab" aria-expanded="false">
            Horario de Atenci&oacute;n </a>
          </li>
        </ul>
      </div>
      <div class="portlet-body">
        <div class="tab-content">
          <div class="tab-pane active" id="info">
            <!-- CANCHA INFO TAB -->
            <form method="post" id="form_editar_evento" enctype="multipart/form-data" class="form-group">
              <input type="hidden" name="bd" value="1">
              <input type="hidden" name="id_centro" value="<?php echo @$id ?>">
                <div class="form-group">
                  <label for="mail" class="control-label"><span style="color:red;">* </span>Nombre:</label>
                  <input type="text" class="form-control" name="centro_deportivo"  value="<?php echo $lista_evento[2] ?>"placeholder="Ingrese Nombre de la cancha" required >
                </div>
                <div class="form-group">
                  <label for="mail" class="control-label">Ciudad:</label>
                  <select style="border-radius:5px;" name="ciudad" class="form-control">
                    <optgroup label="Seleccione una ciudad"></optgroup>
                    <?php 
                    $miconexion->consulta("Select pr.id, pr.nombre, p.nombre from pais p, provincia pr where p.nombre ='Ecuador' and pr.pais = p.id");
                    $miconexion->op_seleccionada(0, $lista_evento[3]);
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="mail" class="control-label">Direcci&oacute;n:</label>
                  <input type="text" class="form-control" name="direccion" value="<?php echo $lista_evento[5] ?>" placeholder="Ingrese direcci&oacute;n" >            
                </div>
                <div class="form-group" style = "margin-left: -15px;">
                  <div class="col-xs-8 col-sm-8">
                    <label for="mail" class="control-label">Coordenandas:</label>
                  </div>
                  <div class="col-xs-4 col-sm-4" style="text-align:right;">
                    <a style="font-size:12px;" href="#" onclick="get_pos()" id="mycoo">Obt&eacute;n tu ubicaci&oacute;n <i style= "font-size: 20px;" class="icon-map-marker" title="Obtener mis coordenadas"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="form-group" style = "margin-top: -15px; margin-left: -15px; margin-right: -15px; margin-bottom: 15px; ">
                  <div class="col-xs-5 col-sm-5">
                    <input type="text" class="form-control" id="latitud" name="latitud" value="<?php echo $lista_evento[6] ?>" placeholder="Latitud">
                  </div>
                  <label for="horaFin" class="col-sm-1 col-xs-1 control-label"> - </label>
                  <div class="col-xs-6 col-sm-6">
                    <input type="text" class="form-control" id="longitud" name="longitud" value="<?php echo $lista_evento[7] ?>" placeholder="Longitud">
                  </div>
                </div>
                <div class="form-group">
                  <label for="mail" class="control-label">Tel&eacute;fono:</label>
                  <input type="text" class="form-control" name="telef_centro" value="<?php echo $lista_evento[8] ?>"placeholder="(07)2555555 ext 134">
                </div>
                <div class="form-group">
                  <label for="mail" class="control-label"><span style="color:red;">* </span>Tiempo de alquiler:</label>
                  <input type="number" class="form-control" name="tiempo_alquiler" value="<?php echo $lista_evento[9] ?>" placeholder="1 hora(s)" min="1" max="16">
                </div>
                <div class="form-group">
                  <label for="mail" class="control-label">Costo:</label>
                  <input type="number" class="form-control" name="costo" value="<?php echo $lista_evento[10] ?>" placeholder="Ingrese el costo">
                </div>                                        
                <div class="form-group">
                  <label for="mail" class="control-label"><span style="color:red;">* </span> N&uacute;mero de Jugadores:</label>
                  <input type="number" class="form-control" name="num_jugadores" value="<?php echo $lista_evento[11] ?>" placeholder="0" min="1">
                </div>
                <div class="form-group">
                  <label class="control-label">Informaci&oacute;n adicional:</label>
                  <textarea class="form-control" name="informacion"  value="<?php echo $lista_evento[12] ?>" placeholder="Informacion adicional..."> </textarea>
                </div>
                <div class="form-group">
                  <label for="mail" class="control-label">Foto del centro:</label>
                  <input type="file" class="form-control" name="foto_centro" >
                </div>                             
            </form>
            <div class="form-group" style ="padding-bottom:40px;">
              <div class="margin-top-10" style="width:49%; float:left; padding-left:10%;">
                <button type="submit" onclick='enviar_form("../include/actualizar_perfil.php","form_editar_evento")' class="btn green-haze" style="background:#4CAF50;">Guardar Cambios</button>
              </div>                      
              <div class="margin-top-10" style="width:39%; float: right;">
                <a href="perfil.php?op=canchas&id=<?php echo $lista_evento[0] ?>" class="btn green-haze" style="background:#F3565D;"> Regresar</a>
              </div>
            </div>           
            <div id="respuesta"></div>
            <!-- END CANCHA INFO TAB --> 
          </div>
          <!-- BEGIN CANCHA HORARIO TAB --> 
          <div class="tab-pane" id="horario">
          <!-- CANCHA INFO TAB -->
              <form method="post" id="form_crear_horario" enctype="multipart/form-data" class="form-group">
                <input type="hidden" name="bd" value="2">
                <input type="hidden" name="i" value="<?php echo $id ?>">
                <div class="form-group" id="dias">
                  <label for="dia" class="control-label">D&iacute;a:</label>
                  <select style="border-radius:5px;" class="form-control" name="dia" id="dia" onchange="horario(1);">
                    <optgroup label="Seleccione un d&iacute;a"></optgroup>
                    <option value="Todos">Todos los d&iacute;as (Lunes a Domingo)</option>
                    <option value="Domingo">Domingo</option>
                    <option value="Lunes">Lunes</option>
                    <option value="Martes">Martes</option>
                    <option value="Miercoles">Miercoles</option>
                    <option value="Jueves">Jueves</option>
                    <option value="Viernes">Viernes</option>
                    <option value="Sabado">Sabado</option>
                  </select>
                </div>
                <div id="res_horario"></div>
                <div class="form-group">
                  <label for="hora_inicio">Hora de Inicio: </label>
                  <input type="text" class="time form-control" id="horaIni" name="hora_inicio" data-scroll-default="07:00:00" placeholder="07:00:00" required>
                </div>
                <div class="form-group">
                  <label for="hora_fin">Hora Fin: </label>
                  <input type="text" class="time form-control" id="horaFin" name="hora_fin" data-scroll-default="23:00:00" placeholder="23:00:00" required>
                </div>
                <div class="form-group" style="padding-bottom:60px;">
                  <div class="margiv-top-10">
                    <button type="button" class="btn green-haze" onclick='enviar_form("../include/insertar_cancha.php","form_crear_horario");' style="background:#01579B; float: right; border-radius: 50% !important; margin-right:20px;" title="A&ntilde;adir horario"><i class="icon-plus"></i></button>
                  </div>
                </div>
                <script>
                  $(function() {
                    $('#horaIni').timepicker({ 'timeFormat': 'H:i:s' });
                    $('#horaFin').timepicker({ 'timeFormat': 'H:i:s' });
                  });
                </script>          
              </form>
              <div id="col_tabla_horario"></div>
              <div style="padding-top:5px; float:right;">
                  <a href="perfil.php?op=canchas&id=<?php echo @$_GET['id'] ?>" class="btn green-haze" style="background:#4CAF50;"><i class="icon-ok"> Finalizar</i></a>
              </div>
          </div>
          <!-- END CANCHA HORARIO TAB --> 
        </div>
      </div>
    </div>
  </div>
</div>

  <div class="modal fade" id="edit" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
     <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
       <h4 class="modal-title">Editar Horario</h4>
      </div>
      <div class="modal-body">
        <form method="post" id="form_editar_horario" enctype="multipart/form-data" class="form-group">
            <input type="hidden" name="bd" value="3">
            <input type="hidden" name="centro" value="<?php echo $id ?>">
            <input type="hidden" name="id_horario" id="horarioEdit">
            <div class="form-group" id="dias">
            <label for="dia" class="control-label" id="diaEdit"></label>                  
            </div>
            <div id="res_horario"></div>
            <div class="form-group">
              <label for="hora_inicio">Hora de Inicio: </label>
              <input style="z-index: 100000;" type="text" class="time form-control" id="horaIniEdit" name="hora_inicio" data-scroll-default="07:00:00" placeholder="07:00:00" required>
            </div>
            <div class="form-group">
              <label for="hora_fin">Hora Fin: </label>
              <input style="z-index: 100000;" type="text" class="time form-control" id="horaFinEdit" name="hora_fin" data-scroll-default="23:00:00" placeholder="23:00:00" required>
            </div>
            <script>
              $(function() {
                $('#horaIniEdit').timepicker({ 'timeFormat': 'H:i:s', template: 'modal' });
                $('#horaFinEdit').timepicker({ 'timeFormat': 'H:i:s', template: 'modal' });
              });
            </script>          
          </form>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
       <button type="button" class="btn green-haze" onclick='enviar_form("../include/insertar_cancha.php","form_editar_horario");'>Guardar Cambios</button>
      </div>
     </div>
     <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
   </div> 

<script>
horario(1);
function horario(op, n_dia, id_horario){
if (op==1) {
  dia = $("#dia").val();
}else{
  dia = n_dia;
};   
  
  centro = "<?php echo @$_GET['id']; ?>";
    $.ajax({
      type: "POST",
      url: "../include/disponibilidad.php",
      data: "dia="+dia+"&centro="+centro+"&op="+op+"&id_horario="+id_horario,
      dataType: "html",
      error: function(){
        alert("error petición ajax");
      },
      success: function(data){     
        $("#res_horario").html(data);
        n();
      }                         
    });         
}
</script>
<?php 
  function horario_aten($array){
    for ($i=0; $i < count($array); $i++) { 
      if ($i==0) {
        echo '
        <tr>
          <td rowspan = "'.count($array).'" style="text-align:left; vertical-align: middle;"><strong>'.$array[$i][0].'</strong></td>
          <td>'.$array[$i][1].' - '.$array[$i][2].'</td>
        ';
        echo'</tr>';
      }else {
        echo '<tr>
          <td>'.$array[$i][1].' - '.$array[$i][2].'</td>';
        echo'</tr>';
      }
    }
  }
?>