<?php 
header('Content-Type: text/html; charset=ISO-8859-1');
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
session_start();
extract($_GET);

global $lista_evento;
$miconexion->consulta("select * from canchas where id_cancha= '".$id."' ");  
  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    $lista_evento=$miconexion->consulta_lista();
  }
$miconexion->consulta("select * from canchas ");
  for ($i=0; $i < $miconexion->numregistros(); $i++) { 
    $lista_cancha=$miconexion->consulta_lista();
  }
  $time=strtotime($lista_evento[3]);
  global $fecha;
  $fecha = date("d M Y H:i",$time); 
?>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
  <div class="row">
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
      <h3 class="page-title">
        Cancha <small>Editar Cancha</small>
      </h3>
      <div class="portlet light ">
<form method="post" action="" id="form_editar_evento" enctype="multipart/form-data" class="form-horizontal">
  
<div class="form-group">
    
    <div class="col-sm-9">      
      <input type="hidden" class="form-control" id="cancha" name="id_cancha" value="<?php echo $lista_evento[0] ?>">
    </div>
</div> 

<div class="form-group">
  <label for="nombre" class="col-sm-2 control-label">Nombre</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="mail" name="nombre_cancha"  value="<?php echo $lista_evento[1] ?>" required >
</div>
</div>

<div class="form-group">
    <label for="pass" class="col-sm-2 control-label">Direcci&oacute;n:</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="mail" name="direccion_cancha" value="<?php echo $lista_evento[2] ?>" >            
</div>
</div>

<div class="form-group">
    <label for="pass" class="col-sm-2 control-label">N&uacute;mero de Jugadores:</label>
    <div class="col-sm-9">
        <input type="number" class="form-control" id="mail" name="num_max" value="<?php echo $lista_evento[3] ?>" min="1" required>
</div>
</div>

<div class="form-group">     
     <label for="latitud" class="col-sm-2 control-label">Latitud:</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="mail" name="latitud" value="<?php echo $lista_evento[4] ?>" >
    </div>
</div>

<div class="form-group">
      
      <label for="longitud" class="col-sm-2 control-label">Longitud:</label>
    <div class="col-sm-9">

      <input type="text" class="form-control" id="mail" name="longitud" value="<?php echo $lista_evento[5] ?>">
    </div>
</div>

<div class="form-group">
      <label for="pass" class="col-sm-2 control-label">Costo:</label>
  <div class="col-sm-9">
      <input type="number" class="form-control" id="mail" name="costo" value="<?php echo $lista_evento[6] ?>">
</div>  
</div>                  

<div class="form-group">
    <label for="pass" class="col-sm-2 control-label">Horario de Atenci&oacute;n:</label>
    <div class="col-sm-9">
</div>                    
</div>

<div class="form-group" style = "margin-top: -15px; margin-left: -15px; margin-right: -15px;">
    <div class="col-xs-5 col-sm-5">
       <input type="text" class="time form-control" id="timeformatExample1" name="hora_inicio" data-scroll-default=".$lista_evento[7]." value="<?php echo $lista_evento[7] ?>" required>
    </div>
    <label for="horaFin" class="col-sm-1 col-xs-2 control-label">hasta </label>
   <div class="col-xs-5 col-sm-6">
        <input type="text" class="time form-control" id="timeformatExample2" name="hora_fin" data-scroll-default=".$lista_evento[8]." value="<?php echo $lista_evento[8] ?>" required/>
   </div>
   </div>
  <script>
      $(function() {
        $('#timeformatExample1').timepicker({ 'timeFormat': 'H:i:s' });
        $('#timeformatExample2').timepicker({ 'timeFormat': 'H:i:s' });
       });
  </script>

  <script>
       $(function() {
         $('#basicExample1').timepicker();
       });
  </script>

   <div class="form-group">    
    <div class="col-sm-9">
      <input type="hidden" name="bd" value="canchas">
    </div>
  </div>
</form>
<div class="form-group" style="text-align:center;">
    <div class="col-sm-offset-2 col-sm-4">
      <button type="submit" onclick='enviar_form("../include/actualizar_cancha.php","form_editar_evento")' class="btn btn-default">Guardar</button>
    </div>
    <div class="col-sm-offset-2 col-sm-4" style="padding-top:5px;">
      <a href="perfil.php?op=canchas&id=<?php echo $lista_evento[0] ?>" class="btn green-haze" style="background:#4CAF50;"> Regresar</a>
    </div>
  </div>
  <div id="respuesta"></div>
</div>
</div>