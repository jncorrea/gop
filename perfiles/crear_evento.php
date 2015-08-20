<div class="page-bar">
  <ul class="page-breadcrumb">
    <li>
      <i class="icon-home"></i>
      <a href="perfil.php">Home</a>
      <i class="icon-angle-right"></i>
    </li>
    <li>
      <a href="perfil.php?op=crear_evento">Crear Partido</a>
    </li>
  </ul> 
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
  <div class="row">
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
      <h3 class="page-title">
        Partidos <small>Crear Partido</small>
      </h3>
      <div class="portlet light ">       

<form method="post" action="" id="form_crear_evento" enctype="multipart/form-data" class="form-horizontal">
  <div class="form-group">
    <label for="Nombre_Partido" class="col-xs-12 col-sm-2 control-label">Nombre del Partido:</label>
    <div class="col-sm-9" style="padding-top:12px;">
      <input type="text" class="form-control" id="nombre_partido" name="nombre_partido" placeholder="Da un nombre al partido..">
    </div>
  </div>
    <div class="form-group">
    <label for="Descripcion" class="col-xs-12 col-sm-2 control-label">Descripci&oacute;n:</label>
    <div class="col-sm-9">
      <textarea type="text" class="form-control" id="descripcion_partido" name="descripcion_partido" placeholder="Describe t&uacute; partido.."></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="grupo" class="col-sm-2 control-label">Grupo</label>
    <div class="col-xs-5 col-sm-4">
      <select style="border-radius:5px;" name="id_grupo" class="form-control">
    <?php                 
      $miconexion->consulta("select id_grupo, nombre_grupo from grupos where id_user='".$_SESSION["id"]."' ");
      $miconexion->opciones();
    ?>
    </select>
    </div>
    <label for="cancha" class="col-sm-1 control-label">Cancha </label>
    <div class="col-xs-5 col-sm-4">
      <select style="border-radius:5px;" name="id_centro" class="form-control">
      <?php 
          $miconexion->consulta("select id_centro, centro_deportivo from centros_deportivos");
          $miconexion->opciones();
      ?>
     </select>
    </div>
  </div>
  <div class="form-group">
    <label for="Fecha" class="col-xs-12 col-sm-2 control-label">Fecha: </label>
    <div class="col-xs-5 col-sm-4" id="datepairExample">
      <input type="text" class="date start form-control" name="fecha_partido" placeholder="yyyy-mm-dd" min="08-10-2015" required />
    </div>
    <label for="Hora" class="col-xs-1 col-sm-1 control-label">Hora: </label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="time start form-control" id="timeformatExample" name="hora_partido" data-scroll-default="23:30:00" placeholder="00:00:00" required/>
    </div>
  </div>
  <article>                      
    <script>                
        $('#datepairExample .date').datepicker({
            'format': 'yyyy-m-d',
            'autoclose': true
        });
    </script> 
    <script>
        $(function() {
            $('#timeformatExample').timepicker({ 'timeFormat': 'H:i:s' });  
        });
    </script>
  </article>


  <div class="form-group">
    <label for="estado" class="col-sm-2 control-label">Estado </label>
    <div class="col-sm-9">
      <label class="css-switch" style="height:33px;">
          <input type="checkbox" name="estado_partido" value="1" class="css-switch-check" required>
          <span class="css-switch-label"></span>
          <span class="css-switch-handle"></span>
      </label>
    </div>
  </div>
  <div class="form-group">
    <label for="equipoA" class="col-xs-12 col-sm-2 control-label">Equipos</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="equipoA" name="equipo_a" value="Equipo A"  >
    </div>
    <label for="equipoB" class="col-xs-1 col-sm-1 control-label">vs. </label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="equipoB" name="equipo_b" value="Equipo B"  >
    </div>
  </div>
  <div class="form-group">
    <input type="hidden" class="form-control" id="ResEquipoA" name="res_A" value="0" readonly>
    <input type="hidden" class="form-control" id="ResEquipoB" name="res_B" value="0" readonly>
    <input type="hidden" name="id_user" value="<?php echo $_SESSION['id']; ?>">
    <input type="hidden" name="bd" value="partidos">
  </div>

</form>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" onclick='enviar_form("../include/insertar_evento.php","form_crear_evento");'>Guardar</button>
    </div>
  </div>
  <div id="respuesta"></div>
      </div>
    </div>
    <div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
    <h4>USUARIOS CONECTADOS</h4>
    <ul style="color:#ffff; list-style: none; padding:0px;">
      <div id = "col_chat"></div>
    </ul>
  </div>
</div>