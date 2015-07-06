<div style="width:100%; margin-bottom:2em;">
  <div style="width:90%; display:inline-block; text-align:center;">
    <h1>Crear un Partido</h1>  
  </div>
  <div style="width:08%; display:inline-block; text-align:right; font-size:24px;">
    <a title="Cerrar" href="perfil.php" style="text-decoration:none; color:#585858;"><span class="glyphicon glyphicon-remove-circle"></span></a>
  </div>
</div>
<form method="post" action="../include/insertar_evento.php" enctype="multipart/form-data" class="form-horizontal">
<<<<<<< HEAD
        

        <div class="form-group">
          
            <label for="posicion" class="col-sm-2 control-label">Grupo</label>
            
          <div style="width:80%; display:inline-block">
            <label style="color:#757575">  &nbsp; &nbsp; Selecciona un Grupo con el que deses jugar un partido</label>
          </div>

          <div style="width:80%; display:inline-block">
            <select style="border-radius:5px; padding:0.4em; width:80%; margin:0 1em;" name="grupo" class="form-control">
              <?php                 
                $miconexion->consulta("select g.id_grupo, g.nombre_grupo from grupos_miembros gm, grupos g where g.id_grupo=gm.id_grupo and  gm.email='".$_SESSION["email"]."' ");
                $miconexion->opciones();
              ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          
            <label for="posicion" class="col-sm-2 control-label">Cancha </label>
            
          
          <div style="width:80%; display:inline-block">
            <select style="border-radius:5px; padding:0.4em; width:80%; margin:0 1em;" name="cancha" class="form-control">
              <?php 
                $miconexion->consulta("select * from canchas");
                $miconexion->opciones();
              ?>
            </select>

            <div style="width:10%; ">            
              
              <button class="btn btn-default" onclick="window.location.href='perfil.php?op=cancha'">Crear Cancha</button>
            </div>

          </div>

          

        </div>

        <div class="form-group">
          <label for="posicion" class="col-sm-2 control-label">Fecha </label>
          <div class="col-sm-10">
            <input style="width:80%;"type="date" min="<?php echo date("Y-m-d");?>"class="form-control" id="posicion" name="fecha" required>
          </div>
        </div>

        <div class="form-group">
          <div >
            <label for="posicion" class="col-sm-2 control-label">Estado </label>
            
          </div>
          <div style="width:80%; display:inline-block">
            <label class="css-switch">
                  <input type="checkbox" name="estado" value="1" class="css-switch-check" required>
                  <span class="css-switch-label"></span>
                  <span class="css-switch-handle"></span>
            </label>
          </div>
        </div>       

        <div class="form-group">
          <label for="mail" class="col-sm-2 control-label">Nombre Equipo A</label>
          <div class="col-sm-10">

            <input type="text" class="form-control" id="mail" name="equipoA" value="Equipo A"  >

          </div>
        </div>

        <div class="form-group">
          <label for="mail" class="col-sm-2 control-label">Nombre Equipo B</label>
          <div class="col-sm-10">

            <input type="text" class="form-control" id="mail" name="equipoB" value="Equipo B" >

          </div>
        </div>

       

        <div class="form-group">
          <label for="mail" class="col-sm-2 control-label">Resultados Equipo A</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="mail" name="ResEquipoA" value="0" readonly>
          </div>
        </div>

        <div class="form-group">
          <label for="mail" class="col-sm-2 control-label">Resultados Equipo B</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="mail" name="ResEquipoB" value="0" readonly>
          </div>
        </div>

        <input type="hidden" name="bd" value="partidos">


=======
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
  </div>
  <div class="form-group">
    <label for="fecha" class="col-sm-2 control-label">Fecha </label>
    <div class="col-sm-9">
      <input type="date" min="<?php echo date("Y-m-d");?>"class="form-control" id="fecha" name="fecha" required>
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
      <input type="text" class="form-control" id="ResEquipoA" name="ResEquipoA" value="0" readonly>
    </div>
    <label for="ResEquipoB" class="col-xs-1 col-sm-1 control-label">- </label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="ResEquipoB" name="ResEquipoB" value="0" readonly>
    </div>
  </div>
>>>>>>> origin/master
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Guardar</button>
    </div>
  </div>
</form>
