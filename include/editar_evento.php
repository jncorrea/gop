<div style="width:100%; margin-bottom:2em;">
  <div style="width:90%; display:inline-block; text-align:center;">
    <h1>Editar Evento</h1>  
  </div>
  <div style="width:08%; display:inline-block; text-align:right; font-size:24px;">
    <a title="Cerrar" href="perfil.php" style="text-decoration:none; color:#585858;"><span class="glyphicon glyphicon-remove-circle"></span></a>
  </div>
</div>

<?php 

//$miconexion->consulta("select * from canchas where id_cancha=".$lista_evento[1]);
$miconexion->consulta("select * from centros_deportivos ");
  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    $lista_cancha=$miconexion->consulta_lista();
  }

echo '
<form method="post" action="../include/actualizar_evento.php" enctype="multipart/form-data" class="form-horizontal">
  
<div class="form-group">
    
    <div class="col-sm-9">      
      <input type="hidden" class="form-control" id="cancha" name="id_partido" value="'.$lista_evento[0].'">
    </div>
</div> 
 <div class="form-group">
    <label for="pass" class="col-sm-2 control-label">Cancha</label>
    <div class="col-sm-9">
      <input type="hidden" class="form-control" id="cancha" name="id_cancha" value="'.$lista_evento[2].'">
      <input type="text" class="form-control" id="cancha" name="cancha1" value="'.$lista_cancha[1].'" >      
    </div>
  </div>  
  <div class="form-group">
    <label for="posicion" class="col-sm-2 control-label">Fecha </label>
    <div class="col-sm-9">
      <input type="datetime" class="form-control" id="posicion" name="fecha" value="'.$lista_evento[3].'">
    </div>
  </div>
  <div class="form-group">
    <label for="nombres" class="col-sm-2 control-label">Estado</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" id="nombres" name="estado" value="'.$lista_evento[4].'">
    </div>
  </div>  
  <div class="form-group">
    <label for="apellidos" class="col-xs-12 col-sm-2 control-label">Equipos</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail" name="nomequipoa" value="'.$lista_evento[5].'" >
    </div>
    <label for="posicion" class="col-xs-1 col-sm-1 control-label">vs.</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail" name="nomequipob" value="'.$lista_evento[6].'">
    </div>
  </div>

  <div class="form-group">
    <label for="posicion" class="col-xs-12 col-sm-2 control-label">Resultados</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail"name="resequipoa" value="'.$lista_evento[7].'">
    </div>
    <label for="posicion" class="col-xs-1 col-sm-1 control-label">- </label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail" name="resequipob" value="'.$lista_evento[8].'">
    </div>
  </div>

   <div class="form-group">    
    <div class="col-sm-9">
      <input type="hidden" name="bd" value="partidos">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Guardar</button>
    </div>
  </div>
</form>';
?>