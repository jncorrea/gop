<?php 
header('Content-Type: text/html; charset=ISO-8859-1');
include("../static/site_config.php"); 
include ("../static/clase_mysql.php");
$miconexion = new clase_mysql;
$miconexion->conectar($db_name,$db_host, $db_user,$db_password);
session_start();
extract($_GET);
global $lista_evento;
$miconexion->consulta("select id_partido, id_centro, descripcion_partido, fecha_partido, hora_partido, estado_partido, equipo_a, equipo_b, res_a, res_b from partidos where id_partido= '".$id."' ");  
$lista_evento=$miconexion->consulta_lista();
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
      <select style="border-radius:5px;" name="id_centro" class="form-control"  onchange="detectar_cambios('id_centro');">
      <?php 
          $miconexion->consulta("select id_centro, centro_deportivo from centros_deportivos");
          for ($i=0; $i < $miconexion->numregistros(); $i++) { 
            $lista_cancha=$miconexion->consulta_lista();
            if ($lista_cancha[0]==$lista_evento[1]) {
              echo "<option selected value='$lista_cancha[0]'> $lista_cancha[1] </option>";
             }else{
              echo "<option value='$lista_cancha[0]'> $lista_cancha[1] </option>";
             } 
          }
         
      ?>
     </select>
    </div>
  </div>  
  <div class="form-group">
    <label for="Descripcion" class="col-xs-12 col-sm-2 control-label">Descripci&oacute;n:</label>
    <div class="col-sm-9">
      <textarea type="text" class="form-control" id="descripcion_partido" name="descripcion_partido" onchange="detectar_cambios('descripcion_partido');"><?php echo $lista_evento[2] ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="Fecha" class="col-xs-12 col-sm-2 control-label">Cuando: </label>
    <div class="col-xs-12 col-sm-4" id="datepair">
      <input type="text" class="date start form-control" id="dateformat" name="fecha_partido" value="<?php echo $lista_evento[3] ?>" onChange="detectar_cambios('fecha_partido');" required />
    </div>
    <label for="Hora" class="col-xs-12 col-sm-2 control-label">Hora: </label>
    <div class="col-xs-12 col-sm-3">
      <input type="text" class="time start form-control" id="timeformat" name="hora_partido" data-scroll-default="23:30:00" value="<?php echo $lista_evento[4] ?>"  onChange="detectar_cambios('hora_partido');"  required/>
    </div>
  </div>  
  <article>                      
    <script>     
        $('#datepair .date').datepicker({
            'format': 'yyyy-m-d',
            'autoclose': true
             
        });
        $(function() {
            $( "#dateformat" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
            $( "#dateformat" ).datepicker( "option", "yearRange", "-99:+0" );
            $( "#dateformat" ).datepicker( "option", "minDate", "+0m +0d" );
        });           
    </script> 
    <script>
        $(function() {
          $('#timeformat').timepicker({ 'timeFormat': 'H:i:s'});  
        });
    </script>
  </article> 
   
  <div class="form-group">
    <label for="estado" class="col-xs-12 col-sm-2 control-label">Estado del Partido: </label>
    <div class="col-xs-12 col-sm-3">
      <label class="css-switch" style="height:33px;">
        <?php
          if ($lista_evento[5]==1) {?>
            <input type="checkbox" checked value="<?php echo $lista_evento[5] ?>" class="css-switch-check" id = "estado_partido" onChange="cambiar_estado(); detectar_cambios('estado_partido');">                          
          <?php }else{?>
            <input type="checkbox" value="<?php echo $lista_evento[5] ?>" class="css-switch-check" id = "estado_partido" onChange="cambiar_estado(); detectar_cambios('estado_partido');">                          
          <?php }
        ?> 
          <span class="css-switch-label"></span>
          <span class="css-switch-handle"></span>
      </label>
    </div>
  </div> 
  <div class="form-group">
    <label for="apellidos" class="col-xs-12 col-sm-2 control-label">Equipos</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail" name="equipo_a" value="<?php echo $lista_evento[6] ?>" onchange="detectar_cambios('equipo_a');">
    </div>
    <label for="posicion" class="col-xs-1 col-sm-1 control-label">vs.</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail" name="equipo_b" value="<?php echo $lista_evento[7] ?>" onchange="detectar_cambios('equipo_b');">
    </div>
  </div>

  <div class="form-group">
    <label for="posicion" class="col-xs-12 col-sm-2 control-label">Resultados</label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail"name="res_a" value="<?php echo $lista_evento[8] ?>" onchange="detectar_cambios('res_a');">
    </div>
    <label for="posicion" class="col-xs-1 col-sm-1 control-label">- </label>
    <div class="col-xs-5 col-sm-4">
      <input type="text" class="form-control" id="mail" name="res_b" value="<?php echo $lista_evento[9] ?>" onchange="detectar_cambios('res_b');">
    </div>
  </div>

   <div class="form-group">    
    <div class="col-sm-9">
      <input type="hidden" name="bd" value="partidos">
      <input type="hidden" name="cambios" id="cambios">
      <input type="hidden" name="fecha_actual" id="fecha_cambio">
    </div>
  </div> 
</form>
  <div class="form-group" style="text-align:center;">
    <div class="col-sm-offset-2 col-sm-4">
      <button type="submit" onclick='cargar_fecha(); enviar_form("../include/actualizar_evento.php","form_editar_evento");' class="btn btn-default">Guardar</button>
    </div>
    <div class="col-sm-offset-2 col-sm-4" style="padding-top:5px;">
      <a href="perfil.php?op=alineacion&id=<?php echo $lista_evento[0] ?>" class="btn green-haze" style="background:#4CAF50;">Volver al Partido</a>
    </div>
  </div>
  <div id="respuesta"></div>

<script>
  function prueba(){   
    fecha = $("#dateformat").val();              
    centro = $("#id_centro").val();   
    if (fecha=="") {
      document.getElementById("timeformat").style.display="none";
    }else{
      document.getElementById("timeformat").style.display="";
      $.ajax({
        type: "POST",
        url: "../include/disponibilidad.php",
        data: "b="+fecha+"&c="+centro,
        dataType: "html",
        error: function(){
          alert("error petición ajax");
        },
        success: function(data){     
          $("#alerta").html(data);
          n();
        }                         
      });
    };           
  }
  function cambiar_estado(){
    if($("#estado_partido").val()==0){
      document.getElementById("estado_partido").value = 1;
    }else{
      document.getElementById("estado_partido").value = 0;
    }
  }

  var cambios = new Array();
  function detectar_cambios(input){
    var compr = 0;
    for (var i = 0; i < cambios.length+1; i++) {
      if (cambios[i]==input) {
        compr++;
      };        
    };
    if (compr==0) {
      cambios.push(input);
    };
    document.getElementById("cambios").value = cambios;
  }

  function cargar_fecha(){
    var d = new Date();     
      document.getElementById("fecha_cambio").value = d.getFullYear() + "-" + (d.getMonth() +1) + "-" + d.getDate()+ ' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
  }
</script>