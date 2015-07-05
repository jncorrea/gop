<div style="width:100%; margin-bottom:2em;">
  <div style="width:90%; display:inline-block; text-align:center;">
    <h1>Editar Perfil</h1>  
  </div>
  <div style="width:08%; display:inline-block; text-align:right; font-size:24px;">
    <a title="Cerrar" href="perfil.php" style="text-decoration:none; color:#585858;"><span class="glyphicon glyphicon-remove-circle"></span></a>
  </div>
</div>
<?php 
echo '
<form method="post" action="../include/actualizar_perfil.php" enctype="multipart/form-data" class="form-horizontal">
  <div class="form-group">
    <label for="mail" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="mail" name="email" value="'.$lista[0].'" readonly>
    </div>
  </div>
  <div class="form-group">
    <label for="pass" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="pass" name="pass" value="'.$lista[1].'" placeholder="************" required>
    </div>
  </div>
  <div class="form-group">
    <label for="nombres" class="col-sm-2 control-label">Nombres</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="nombres" name="nombres" value="'.$lista[2].'" placeholder="Nombres">
    </div>
  </div>
  <div class="form-group">
    <label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="apellidos" name="apellidos" value="'.$lista[3].'" placeholder="Apellidos">
    </div>
  </div>
  <div class="form-group">
    <label for="celular" class="col-sm-2 control-label">Celular</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="celular" name="celular" value="'.$lista[4].'" placeholder="Celular">
    </div>
  </div>
  <div class="form-group">
    <label for="posicion" class="col-sm-2 control-label">Posici&oacute;n</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="posicion" name="posicion" value="'.$lista[5].'" placeholder="Posici&oacute;n">
    </div>
  </div>
  <div class="form-group">
    <label for="avatar" class="col-sm-2 control-label">Avatar</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" id="avatar" name="avatar" accept="image/png, image/gif, image/jpg">
      <output id="list" style="text-align: center;"></output>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Guardar</button>
    </div>
  </div>
</form>
';
?>