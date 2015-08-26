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
      <select style="border-radius:5px;" name="id_centro" class="form-control">
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
      <label for="Fecha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Cuando: </label>
      <div class="col-xs-12 col-sm-4" id="datepairExample">
        <input type="text" class="date start form-control" value="<?php echo $lista_evento[6] ?>" id="dateformatExample" name="fecha_partido" placeholder="yyyy-mm-dd" min="08-10-2015" onChange="prueba();" required />
      </div>
      <label for="Hora" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Hora: </label>
      <div class="col-xs-12 col-sm-3">
        <input type="text" class="time start form-control" value="<?php echo $lista_evento[7] ?>" id="timeformatExample" name="hora_partido" data-scroll-default="23:30:00" placeholder="00:00:00" onChange="prueba();"  required/>
      </div>
    </div>
  <div class="form-group">
    <label for="estado" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Estado del Partido: </label>
    <div class="col-xs-12 col-sm-3">
      <label class="css-switch" style="height:33px;">
        <?php
        if ($lista_evento[12]==1) {
          echo '<input type="checkbox" name="estado_partido" checked value="1" class="css-switch-check">';                          
        }else{
          echo '<input type="checkbox" name="estado_partido" value="1" class="css-switch-check">';                          

        }
        ?>   
          <span class="css-switch-label"></span>
          <span class="css-switch-handle"></span>
      </label>
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
  <article>                      
    <script>     
        $('#datepairExample .date').datepicker({
            'format': 'yyyy-m-d',
            'autoclose': true
             
        });
        $(function() {
            $( "#dateformatExample" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
            $( "#dateformatExample" ).datepicker( "option", "yearRange", "-99:+0" );
            $( "#dateformatExample" ).datepicker( "option", "minDate", "+0m +0d" );
        });           
    </script> 
    <script>
        $(function() {
          $('#timeformatExample').timepicker({ 'timeFormat': 'H:i:s'});  
        });
    </script>
  </article>  
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

<script>
  function prueba(){   
    fecha = $("#dateformatExample").val();              
    centro = $("#id_centro").val();   
    if (fecha=="") {
      document.getElementById("timeformatExample").style.display="none";
    }else{
      document.getElementById("timeformatExample").style.display="";
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
  function cargar_horarios(){
    centro = $("#id_centro").val();
  }
</script>