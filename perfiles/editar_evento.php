<?php 
//$miconexion->consulta("select * from canchas where id_cancha=".$lista_evento[1]);
$miconexion->consulta("select * from canchas ");
  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    $lista_cancha=$miconexion->consulta_lista();
  }
?>

<div class="page-bar">
  <ul class="page-breadcrumb">
    <li>
      <i class="icon-home"></i>
      <a href="perfil.php">Home</a>
      <i class="icon-angle-right"></i>
    </li>
    <li>
      <a href="#">Editar Partido</a>
    </li>
  </ul> 
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
  <div class="row">
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
      <h3 class="page-title">
        Partidos <small>Editar Partido</small>
      </h3>
      <div class="portlet light ">
        <form method="post" action="../include/actualizar_evento.php" enctype="multipart/form-data" class="form-horizontal">
  
<div class="form-group">
    
    <div class="col-sm-9">      
      <input type="hidden" class="form-control" id="cancha" name="id_partido" value="<?php echo $lista_evento[0] ?>">
    </div>
</div> 

 <div class="form-group">
    <label for="pass" class="col-sm-2 control-label">Cancha</label>
    <div class="col-sm-9">
      <input type="hidden" class="form-control" id="cancha" name="id_cancha" value="<?php echo $lista_evento[2] ?>">
      <input type="text" class="form-control" id="cancha" name="cancha1" value="<?php echo $lista_cancha[1] ?>" >      
    </div>
  </div>
  
  <div class="form-group">
    <label for="fecha" class="col-sm-2 control-label">Fecha y Hora</label>
    <div class="col-sm-9">
     
          <input type="datetime-local" class="form-control" id="fecha" name="fecha" value="<?php echo $lista_evento[3] ?>" required>
                   
    </div>
  </div>

  <div class="form-group">
    <label for="nombres" class="col-sm-2 control-label">Estado</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" id="nombres" name="estado" value="<?php echo $lista_evento[4] ?>">
    </div>
  </div>  
  <div class="form-group">
    <label for="apellidos" class="col-xs-12 col-sm-2 control-label">Equipos</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail" name="NOMEQUIPOA" value="<?php echo $lista_evento[5] ?>" >
    </div>
    <label for="posicion" class="col-xs-1 col-sm-1 control-label">vs.</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail" name="NOMEQUIPOB" value="<?php echo $lista_evento[6] ?>">
    </div>
  </div>

  <div class="form-group">
    <label for="posicion" class="col-xs-12 col-sm-2 control-label">Resultados</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail"name="resequipoa" value="<?php echo $lista_evento[7] ?>">
    </div>
    <label for="posicion" class="col-xs-1 col-sm-1 control-label">- </label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail" name="resequipob" value="<?php echo $lista_evento[8] ?>">
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
</form>
      </div>
    </div>
    <div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
    <h4>USUARIOS CONECTADOS</h4>
    <ul style="color:#ffff; list-style: none; padding:0px;">
      <div id = "col_chat"></div>
    </ul>
  </div>
</div>