<div style="width:100%; margin-bottom:2em;">
  <div style="width:90%; display:inline-block; text-align:center;">
    <h1>Crear un Partido</h1>  
  </div>
  <div style="width:08%; display:inline-block; text-align:right; font-size:24px;">
    <a title="Cerrar" href="perfil.php" style="text-decoration:none; color:#585858;"><span class="glyphicon glyphicon-remove-circle"></span></a>
  </div>
</div>
<form method="post" action="../include/insertar_evento.php" enctype="multipart/form-data" class="form-horizontal">

  <div class="form-group">
    <label for="grupo" class="col-sm-2 control-label">Grupo</label>
    <div class="col-sm-9" style="font-size: 12px; display:inline-block">
      <label style="color:#757575">  &nbsp; &nbsp; Selecciona un Grupo con el que deses jugar un partido</label>
    </div>
    <div class="col-sm-9">
      <select style="border-radius:5px;" name="grupo" class="form-control">
    <?php                 
      $miconexion->consulta("select g.id_grupo, g.nombre_grupo from grupos_miembros gm, grupos g where g.id_grupo=gm.id_grupo and  gm.email='".$_SESSION["email"]."' ");
      $miconexion->opciones();
    ?>
    </select>
    </div>
  </div>
  <div class="form-group">
    <label for="cancha" class="col-sm-2 control-label">Cancha </label>
    <div class="col-sm-9">
      <select style="border-radius:5px;" name="cancha" class="form-control">
      <?php 
          $miconexion->consulta("select * from canchas");
          $miconexion->opciones();
      ?>
     </select>
    </div>
    <div class="col-sm-1">
        <a title="Crear Cancha" style="font-size:20px;" href="perfil.php?op=cancha">
        <span class="glyphicon glyphicon-plus"></span></a> 
    </div>
  </div>
  <div class="form-group">
    <label for="fecha" class="col-sm-2 control-label">Fecha </label>
    <div class="col-sm-9">
      <input type="date" min="<?php echo date("Y-m-d");?>"class="form-control" id="fecha" name="fecha" required>
    </div>
  </div>

  
  <div class="form-group">
    <label for="fecha" class="col-sm-2 control-label">Hora </label>
    <div class="col-sm-9">
      <input type="time" name="hora" value="11:45:00" max="22:00:00" min="10:00:00" step="1">
    </div>
  </div>


  
  <div class="form-group">
    <label for="estado" class="col-sm-2 control-label">Estado </label>
    <div class="col-sm-9">
      <label class="css-switch">
          <input type="checkbox" name="estado" value="1" class="css-switch-check" required>
          <span class="css-switch-label"></span>
          <span class="css-switch-handle"></span>
      </label>
    </div>
  </div>
  <div class="form-group">
    <label for="equipoA" class="col-xs-12 col-sm-2 control-label">Equipos</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="equipoA" name="equipoA" value="Equipo A"  >
    </div>
    <label for="equipoB" class="col-xs-1 col-sm-1 control-label">vs. </label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="equipoB" name="equipoB" value="Equipo B"  >
    </div>
  </div>
  <div class="form-group">
    <label for="ResEquipoA" class="col-xs-12 col-sm-2 control-label">Resultados</label>
    <div class="col-xs-5 col-sm-4">
      <input type="number" class="form-control" id="ResEquipoA" name="ResEquipoA" value="0" readonly>
    </div>
    <label for="ResEquipoB" class="col-xs-1 col-sm-1 control-label">- </label>
    <div class="col-xs-5 col-sm-4">
      <input type="number" class="form-control" id="ResEquipoB" name="ResEquipoB" value="0" readonly>
    </div>
  </div>
  <input type="hidden" name="bd" value="partidos">
  <input type="hidden" name="email" value=<?php echo $_SESSION['email']; ?>>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Guardar</button>
    </div>
  </div>
</form>
