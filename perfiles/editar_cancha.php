  <?php 
  header('Content-Type: text/html; charset=ISO-8859-1');
  include("../static/site_config.php"); 
  include ("../static/clase_mysql.php");
  $miconexion = new clase_mysql;
  $miconexion->conectar($db_name,$db_host, $db_user,$db_password);
  session_start();
  extract($_GET);

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
              <input type="hidden" name="bd" value="centros_deportivos">
              <input type="hidden" name="id_centro" value="<?php echo @$id ?>">
              <div class="form-group">
                <label for="mail" class="control-label">Nombre:</label>
                <input type="text" class="form-control" name="centro_deportivo"  value="<?php echo $lista_evento[2] ?>" required >
              </div>
              <div class="form-group">
                <label for="mail" class="control-label">Ciudad:</label>
                <input type="text" class="form-control" name="ciudad"  value="<?php echo $lista_evento[3] ?>" >
              </div>
              <div class="form-group">
                <label for="mail" class="control-label">Direcci&oacute;n:</label>
                <input type="text" class="form-control" name="direccion" value="<?php echo $lista_evento[5] ?>" >            
              </div>
              <div class="form-group">
                <label for="mail" class="control-label">Latitud:</label>
                <input type="text" class="form-control" name="latitud" value="<?php echo $lista_evento[6] ?>">
              </div>
              <div class="form-group">
                <label for="mail" class="control-label">Longitud:</label>
                <input type="text" class="form-control" name="longitud" value="<?php echo $lista_evento[7] ?>">
              </div>
              <div class="form-group">
                <label for="mail" class="control-label">Tel&eacute;fono:</label>
                <input type="text" class="form-control" name="telef_centro" value="<?php echo $lista_evento[8] ?>">
              </div>
              <div class="form-group">
                <label for="Horario" class="control-label">Horario de Atenci&oacute;n:</label>
              </div>                    
              <div class="form-group" style = "margin-top: -15px; margin-left: -15px; margin-right: -15px;">
                <div class="col-xs-5 col-sm-5">
                  <input type="text" class="time form-control" id="timeformatExample1" name="hora_inicio" data-scroll-default="<?php echo $lista_evento[9] ?>" value="<?php echo $lista_evento[9] ?>"required>
                </div>
                <label for="horaFin" class="col-sm-1 col-xs-2 control-label">hasta </label>
                <div class="col-xs-5 col-sm-6">
                  <input type="text" class="time form-control" id="timeformatExample2" name="hora_fin" data-scroll-default="<?php echo $lista_evento[10] ?>" value="<?php echo $lista_evento[10] ?>" required/>
                </div>
              </div>
              <div class="form-group">
                <label for="mail" class="control-label">Tiempo de alquiler:</label>
                <input type="number" class="form-control" name="tiempo_alquiler" value="<?php echo $lista_evento[11] ?>" min="1" max="16">
              </div>
              <div class="form-group">
                <label for="mail" class="control-label">Costo:</label>
                <input type="number" class="form-control" name="costo" value="<?php echo $lista_evento[12] ?>">
              </div>                                        
              <div class="form-group">
                <label for="mail" class="control-label">N&uacute;mero de Jugadores:</label>
                <input type="number" class="form-control" name="num_jugadores" value="<?php echo $lista_evento[13] ?>" min="1">
              </div>
              <div class="form-group">
                <label for="mail" class="control-label">Foto del centro:</label>
                <input type="file" class="form-control" name="foto_centro">
              </div>
              <script>
                $(function() {
                  $('#timeformatExample1').timepicker({ 'timeFormat': 'H:i:s' });
                  $('#timeformatExample2').timepicker({ 'timeFormat': 'H:i:s' });
                });
              </script>
              <script>
                $(function() {
                  $('#basicExample1').timepicker();
                });
              </script>                    
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
          hola
          </div>
          <!-- END CANCHA HORARIO TAB --> 
        </div>
      </div>
    </div>
  </div>
</div>