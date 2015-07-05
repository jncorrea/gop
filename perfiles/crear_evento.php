<div style="width:100%; margin-bottom:2em;">
  <div style="width:90%; display:inline-block; text-align:center;">
    <h2>Crear un Partido</h2>  
  </div>
  <div style="width:08%; display:inline-block; text-align:right; font-size:24px;">
    <a title="Cerrar" href="perfil.php" style="text-decoration:none; color:#585858;"><span class="glyphicon glyphicon-remove-circle"></span></a>
  </div>
</div>

<form method="post" action="../include/insertar_evento.php" enctype="multipart/form-data" class="form-horizontal">
        <div class="form-group">
          <div >
            <label for="posicion" class="col-sm-2 control-label">Cancha </label>
            
          </div>
          <div style="width:80%; display:inline-block">
            <select style="border-radius:5px; padding:0.4em; width:80%; margin:0 1em;" name="docente" class="form-control">
              <?php 
                $miconexion->consulta("select * from canchas");
                $miconexion->opciones();
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="posicion" class="col-sm-2 control-label">Fecha </label>
          <div class="col-sm-10">
            <input style="width:80%;"type="date" class="form-control" id="posicion" name="fecha">
          </div>
        </div>
        <div class="form-group">
          <div >
            <label for="posicion" class="col-sm-2 control-label">Estado </label>
            
          </div>
          <div style="width:80%; display:inline-block">
            <label class="css-switch">
                  <input type="checkbox" name="estado1" value="1" class="css-switch-check">
                  <span class="css-switch-label"></span>
                  <span class="css-switch-handle"></span>
            </label>
          </div>
        </div>       

        <div class="form-group">
          <label for="mail" class="col-sm-2 control-label">Nombre Equipo A</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="mail" name="equipoA" value="Equipo A">
          </div>
        </div>

        <div class="form-group">
          <label for="mail" class="col-sm-2 control-label">Nombre Equipo B</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="mail" name="equipoB" value="Equipo B">
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

        <input type="hidden" name="base" value="partidos">  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Guardar</button>
    </div>
  </div>            
      </form>