<div style="width:100%; margin-bottom:2em;">
  <div style="width:90%; display:inline-block; text-align:center;">

    <h2>Formulario para Crear una Nueva Cancha</h2>  


  </div>
  <div style="width:08%; display:inline-block; text-align:right; font-size:24px;">
    <a title="Cerrar" href="perfil.php" style="text-decoration:none; color:#585858;"><span class="glyphicon glyphicon-remove-circle"></span></a>
  </div>
</div>

<form method="post" action="../include/insertar_evento.php" enctype="multipart/form-data" class="form-horizontal">
        

        <div class="form-group">
          <label for="mail" class="col-sm-2 control-label">Nombre de cancha:</label>
          <div class="col-sm-10">

            <input type="text" class="form-control" id="mail" name="nombre"  placeholder="Ingrese Nombre de la cancha" required >

          </div>
        </div>

        <div class="form-group">
          <label for="mail" class="col-sm-2 control-label">Direccion</label>
          <div class="col-sm-10">

            <input type="text" class="form-control" id="mail" name="direccion" placeholder="Ingrese direcci&oacute;n" required >            
          </div>
        </div>

       

        <div class="form-group">
          <label for="mail" class="col-sm-2 control-label">N&uacute;mero m&aacute;ximo de Jugadores</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" id="mail" name="nmaximo" placeholder="Ingrese el n&uacute;mero m&aacute;ximo de jugadores disponible" required>
          </div>
        </div>

        <div class="form-group">
          <label for="mail" class="col-sm-2 control-label">Latitud</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="mail" name="latitud" placeholder="Ingrese latitud" required>
          </div>
        </div>

        <div class="form-group">
          <label for="mail" class="col-sm-2 control-label">Longitud</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="mail" name="longitud" placeholder="Ingrese longitud" required>
          </div>
        </div>

        <div class="form-group">
          <label for="mail" class="col-sm-2 control-label">Costo</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" id="mail" name="costo" placeholder="Ingrese el costo" required>
          </div>
        </div>

        <input type="hidden" name="bd" value="canchas">


  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Guardar</button>
    </div>
  </div>            
      </form>
