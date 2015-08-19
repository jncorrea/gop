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
    <label for="grupo" class="col-sm-2 control-label" style="padding-top:30px">Grupo</label>
    <div class="col-sm-9" style="font-size: 12px; display:inline-block">
      <label style="color:#757575">  &nbsp; &nbsp; Selecciona un Grupo con el que deses jugar un partido</label>
    </div>
    <div class="col-sm-9">
      <select style="border-radius:5px;" name="id_grupo" class="form-control">
    <?php                 
      $miconexion->consulta("select g.id_grupo, g.nombre_grupo from user_grupo gm, grupos g where g.id_grupo=gm.id_grupo and  gm.id_user='".$_SESSION["id"]."' ");
      $miconexion->opciones();
    ?>
    </select>
    </div>
  </div>
  <div class="form-group">
    <label for="cancha" class="col-sm-2 control-label">Cancha </label>
    <div class="col-sm-9">
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
      <input type="text" class="date start" name="fecha_partido" placeholder="yyyy-mm-dd" min="08-10-2015" required />


    </div>
    <label for="Hora" class="col-xs-1 col-sm-1 control-label">Hora: </label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="time start" id="timeformatExample" name="hora_partido" data-scroll-default="23:30:00" placeholder="00:00:00" required/>
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
    <label for="ResEquipoA" class="col-xs-12 col-sm-2 control-label">Resultados</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="ResEquipoA" name="res_A" value="0" readonly>
    </div>
    <label for="ResEquipoB" class="col-xs-1 col-sm-1 control-label">- </label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="ResEquipoB" name="res_B" value="0" readonly>
    </div>
  </div>
  <input type="hidden" name="bd" value="partidos">
  <input type="hidden" name="id_user" value=<?php echo $_SESSION['id']; ?>>

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