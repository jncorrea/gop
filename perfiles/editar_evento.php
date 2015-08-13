<?php 
header('Content-Type: text/html; charset=ISO-8859-1');
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
session_start();
extract($_GET);
global $lista_evento;
$miconexion->consulta("select * from partidos where id_partido= '".$id."' ");  
  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    $lista_evento=$miconexion->consulta_lista();
  }
$miconexion->consulta("select * from centros_deportivos ");
  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    $lista_cancha=$miconexion->consulta_lista();
  }
?>
<h3 class="page-title">
  Partidos <small>Editar Partido</small>
</h3>
<div class="portlet light ">
<form method="post" action="" id="form_editar_evento" enctype="multipart/form-data" class="form-horizontal">
  
<div class="form-group">
    
    <div class="col-sm-9">      
      <input type="hidden" class="form-control" id="cancha" name="id_partido" value="<?php echo $lista_evento[0] ?>">
    </div>
</div> 
  <div class="form-group">
    <label for="cancha" class="col-sm-2 control-label">Cancha: </label>
    <div class="col-sm-9">
      <select style="border-radius:5px;" name="id_centro" value="<?php echo $lista_cancha[1] ?>" class="form-control">
      <?php 
          $miconexion->consulta("select * from centros_deportivos");
          $miconexion->opciones();
      ?>
     </select>
    </div>
  </div>  
  
   <div class="form-group">
    <label for="fecha" class="col-sm-2 control-label">Fecha:</label>
    <div class="col-sm-9">
      <p id="datepairExample">
          <input type="hidden" class="date start" name="fehhcha" placeholder="no" required /> 
          <input type="text" class="date start" id="timeformatExample" name="fecha_partido" value="<?php echo $lista_evento[6] ?>" required/> Hora
          <input type="text" class="time start" id="timeformatExample" name="hora_partido" data-scroll-default="23:30:00"  value="<?php echo $lista_evento[7] ?>" required/>
      </p>
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
    <label for="nombres" class="col-sm-2 control-label">Estado</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" id="nombres" name="estado_partido" value="<?php echo $lista_evento[12] ?>">
    </div>
  </div>  
  <div class="form-group">
    <label for="apellidos" class="col-xs-12 col-sm-2 control-label">Equipos</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail" name="equipo_a" value="<?php echo $lista_evento[8] ?>" >
    </div>
    <label for="posicion" class="col-xs-1 col-sm-1 control-label">vs.</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail" name="equipo_b" value="<?php echo $lista_evento[9] ?>">
    </div>
  </div>

  <div class="form-group">
    <label for="posicion" class="col-xs-12 col-sm-2 control-label">Resultados</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail"name="res_a" value="<?php echo $lista_evento[10] ?>">
    </div>
    <label for="posicion" class="col-xs-1 col-sm-1 control-label">- </label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail" name="res_b" value="<?php echo $lista_evento[11] ?>">
    </div>
  </div>

   <div class="form-group">    
    <div class="col-sm-9">
      <input type="hidden" name="bd" value="partidos">
    </div>
  </div>
</form>
  <div class="form-group" style="text-align:center;">
    <div class="col-sm-offset-2 col-sm-4">
      <button type="submit" onclick='enviar_form("../include/actualizar_evento.php","form_editar_evento")' class="btn btn-default">Guardar</button>
    </div>
    <div class="col-sm-offset-2 col-sm-4" style="padding-top:5px;">
      <a href="perfil.php?op=alineacion&id=<?php echo $lista_evento[0] ?>" class="btn green-haze" style="background:#4CAF50;">Volver al Partido</a>
    </div>
  </div>
  <div id="respuesta"></div>
