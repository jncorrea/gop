<?php 
global $lista_evento;
@$miconexion->consulta("select id_partido, id_centro, descripcion_partido, fecha_partido, hora_partido, estado_partido, equipo_a, equipo_b, res_a, res_b, nombre_partido, id_grupo from partidos where id_partido= '".$id."' ");  
@$lista_evento=$miconexion->consulta_lista();
?>
<link href='../assets/css/fullcalendar.css' rel='stylesheet' />
<link href='../assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='../assets/js/moment.min.js'></script>
<script src='../assets/js/fullcalendar.min.js'></script>
<script src='../assets/js/es.js'></script>
<script>

  function leer_horariosEdit() {
    fecha = $("#dateformatEdit").val();       
    centro = $("#id_centro_edit").val();  
    grupo = "<?php $lista_evento[11]; ?>";
    $.ajax({
      type: "POST",
      url: "../datos/cargarHorarios.php",
      data: "fecha="+fecha+"&centro="+centro+"&grupo="+grupo,
      dataType: "html",
      error: function(){
        alert("error petición ajax");
      },
      success: function(data){ 
        cargar_calendarioEdit(JSON.parse(data));  
      }                         
    });
   } 

  function cargar_calendarioEdit(datos) {
    $('#calendarEdit').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      minTime: min,
      maxTime: max,
      defaultView: 'agendaDay',
      defaultDate: $("#dateformatEdit").val(),
      editable: false,
      events: datos
    }); 
  }

</script>
<?php
 if (isset($editar_cancelado)) { ?>
    <ul class="nav nav-tabs">
  <li class="active">
    <a href="#formulario" data-toggle="tab" aria-expanded="true">
    Editar Partido </a>
  </li>
  <?php if ($editar_cancelado == "campeonato_partido" || $editar_cancelado == "campeonato_marcador") {    
  }else{
  ?> 
  <li clas="">
    <a href="#horarios" data-toggle="tab" aria-expanded="false" onclick="cambio_centroEdit();">
    Ver Horarios </a>
  </li>
  <?php } ?>
</ul>
<div class="tab-content">
  <div class="tab-pane active" id="formulario">
    <div class="caption">
    <i class="icon-bubble font-red-sunglo"></i><span style="color: red; font-size:11px; padding:10px;">
      * Campos requeridos
    </span>
  </div>
    <form method="post" action="" id="form_editar_evento" enctype="multipart/form-data" class="form-horizontal">
      
    <div class="form-group">
        
        <div class="col-sm-9">      
          <input type="hidden" class="form-control" id="id_partidoEdit" name="id_partido" value="<?php echo $lista_evento[0] ?>">
        </div>
    </div>
    <?php 
      if ($editar_cancelado=="campeonato_partido") { ?>
        <div class="form-group">
          <label for="Descripcion" class="col-xs-12 col-sm-2 control-label">Descripci&oacute;n:</label>
          <div class="col-sm-9">
            <textarea type="text" class="form-control" id="descripcion_partido" name="descripcion_partido" onchange="detectar_cambios('descripcion_partido');"><?php echo $lista_evento[2]; ?></textarea>
          </div>
        </div>
    <?php
      }
      if ($editar_cancelado=="campeonato_marcador") {
        ?>
          <div class="form-group">
          <label for="posicion" class="col-xs-12 col-sm-2 control-label">Resultados</label>
          <div class="col-xs-5 col-sm-4">
            <div>Equipo1</div>
            <input type="text" class="form-control" id="res_a"name="res_a" value="<?php echo $lista_evento[8]; ?>" onchange="detectar_cambios('res_a');">
          </div>
          <label for="posicion" class="col-xs-1 col-sm-1 control-label">- </label>
          <div class="col-xs-5 col-sm-4">
            <div>Equipo2</div>
            <input type="text" class="form-control" id="res_b" name="res_b" value="<?php echo $lista_evento[9]; ?>" onchange="detectar_cambios('res_b');">
          </div>
        </div>
        <?php 
      }else{
    ?>     
      <div class="form-group">
        <label for="cancha" class="col-sm-2 control-label">Cancha: </label>
        <div class="col-sm-9">
          <select style="border-radius:5px;" name="id_centro" id="id_centro_edit" class="form-control"  onchange="detectar_cambios('id_centro');">
          <?php 
              $miconexion->consulta("select distinct(cd.id_centro), cd.centro_deportivo, cd.tiempo_alquiler from centros_deportivos cd, horarios_centros hc where cd.id_centro = hc.id_centro");
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
          <input type="text" value="<?php echo $lista_evento[3] ?>" class="date start form-control" id="dateformatEdit" name="fecha_partido" placeholder="yyyy-mm-dd" min="08-10-2015" onchange="detectar_cambios('fecha_partido');" required />
        </div>
        <label for="Hora" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Hora: </label>
        <div class="col-xs-12 col-sm-3">
          <input type="text" class="time start form-control" id="timeformatEdit" value="<?php echo $lista_evento[4]; ?>" onchange=" detectar_cambios('hora_partido'); borrar_alerta();" name="hora_partido" data-scroll-default="23:30:00" placeholder="00:00:00" required/>
        </div>
      </div>
      <div id="error" style="margin-left:5%; color:red; font-size:90%;"></div>
      <div id="alerta"></div>
      <?php } ?>      
       <div class="form-group">    
        <div class="col-sm-9">
          <input type="hidden" name="estado_partido" value="2">
          <input type="hidden" name="bd" value="partidos">
          <input type="hidden" name="cambios" id="cambios">
          <input type="hidden" name="fecha_actual" id="fecha_cambio">
          <input type="hidden" name="op" value="1">
        </div>
      </div> 
    </form>
    <div id="respuesta"></div>
  </div>
  <div class="tab-pane" id="horarios">
    <div>
      
    <ul style="list-style-type: square;">
      <li style="color:#D2383C; ">Horas Disponibles</li>
      <li style="color:#4CAF50; ">Horas Ocupadas</li>
    </ul>
    <div id='calendarEdit'></div>
    </div>
  </div>
</div>
<?php
 }else{
  $fecha_p = date("Y-m-d H:i:s", strtotime($lista_evento[3]." ".$lista_evento[4]."-0500"));
  if ($fecha_p > date("Y-m-d H:i:S", time()) ){ ?>
  <ul class="nav nav-tabs">
    <li class="active">
      <a href="#formulario" data-toggle="tab" aria-expanded="true">
      Editar Partido </a>
    </li>
    <li class="" id="ver_horariosEdit">
      <a href="#horarios" data-toggle="tab" aria-expanded="false" onclick="cambio_centroEdit();">
      Ver Horarios </a>
    </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="formulario">
      <div class="caption">
      <i class="icon-bubble font-red-sunglo"></i><span style="color: red; font-size:11px; padding:10px;" id="mensaje_edit">
        * Campos requeridos
      </span>
    </div>
      <form method="post" action="" id="form_editar_evento" enctype="multipart/form-data" class="form-horizontal">
        
      <div class="form-group">
          
          <div class="col-sm-9">      
            <input type="hidden" class="form-control" id="id_partido" name="id_partido" value="<?php echo $lista_evento[0] ?>">
          </div>
      </div> 
      
      <?php if ($lista_evento[1]==null || $lista_evento[1]==""){ ?>
        <div class="checkbox form-group">
          <label class="col-xs-12 col-sm-2 control-label"></label>
          <div class="checkbox col-sm-9">
            <input type="checkbox" id="asignar_centroEdit" onchange="asignarUncentroEdit();"> Crear una reserva en un centro deportivo.
          </div>
        </div>        
       <div class="form-group" id="listado_centrosEdit">
          <label for="cancha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Lugar: </label>
          <div class="col-sm-9">
            <select style="border-radius:5px;" id="id_centro_edit" name="id_centro" class="form-control" onchange="detectar_cambios('id_centro');">
            <?php 
                $miconexion->consulta("select distinct(cd.id_centro), cd.centro_deportivo, cd.tiempo_alquiler from centros_deportivos cd, horarios_centros hc where cd.id_centro = hc.id_centro");
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
      <?php }else{ ?>
        <div class="form-group">
          <label for="cancha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Lugar: </label>
          <div class="col-sm-9">
            <select style="border-radius:5px;" id="id_centro_edit" name="id_centro" class="form-control" onchange="detectar_cambios('id_centro');">
            <?php 
                $miconexion->consulta("select distinct(cd.id_centro), cd.centro_deportivo, cd.tiempo_alquiler from centros_deportivos cd, horarios_centros hc where cd.id_centro = hc.id_centro");
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
      <?php } ?>
        <div class="form-group">
          <label for="Descripcion" class="col-xs-12 col-sm-2 control-label">Descripci&oacute;n:</label>
          <div class="col-sm-9">
            <textarea type="text" class="form-control" id="descripcion_partido" name="descripcion_partido" onchange="detectar_cambios('descripcion_partido');"><?php echo $lista_evento[2]; ?></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="Fecha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Cuando: </label>
          <div class="col-xs-12 col-sm-4" id="datepairExample">
            <input type="text" value="<?php echo $lista_evento[3] ?>" class="date start form-control" id="dateformatEdit" name="fecha_partido" placeholder="yyyy-mm-dd" min="08-10-2015" onchange="detectar_cambios('fecha_partido');" required />
          </div>
          <label for="Hora" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Hora: </label>
          <div class="col-xs-12 col-sm-3">
            <input type="text" class="time start form-control" id="timeformatEdit" value="<?php echo $lista_evento[4]; ?>" onchange=" detectar_cambios('hora_partido'); borrar_alerta();" name="hora_partido" data-scroll-default="23:30:00" placeholder="00:00:00" required/>
          </div>
        </div>
        <div id="error" style="margin-left:5%; color:red; font-size:90%;"></div>
        <div id="alerta"></div>
        <input type="hidden" name="estado_partido" id="estado" value="<?php echo $lista_evento[5]; ?>">
        <div class="form-group">
          <label for="apellidos" class="col-xs-12 col-sm-2 control-label">Equipos</label>
          <div class="col-xs-5 col-sm-4">
            <input type="text" class="form-control" id="mail" name="equipo_a" value="<?php echo $lista_evento[6]; ?>" onchange="detectar_cambios('equipo_a');">
          </div>
          <label for="posicion" class="col-xs-1 col-sm-1 control-label">vs.</label>
          <div class="col-xs-5 col-sm-4">
            <input type="text" class="form-control" id="mail" name="equipo_b" value="<?php echo $lista_evento[7]; ?>" onchange="detectar_cambios('equipo_b');">
          </div>
        </div>

        <?php
        $fecha_juega_partido=$lista_evento[3]." ".$lista_evento[4];
        $fecha_actual=date("Y-m-d H:i:S", time());
        if ($fecha_juega_partido > date("Y-m-d H:i:S", time()) ){
          //se quita del formalaio los imput de resultados
        }else{
          ?>
        <div class="form-group">
          <label for="posicion" class="col-xs-12 col-sm-2 control-label">Resultados</label>
          <div class="col-xs-5 col-sm-4">
            <input type="text" class="form-control" id="mail"name="res_a" value="<?php echo $lista_evento[8]; ?>" onchange="detectar_cambios('res_a');">
          </div>
          <label for="posicion" class="col-xs-1 col-sm-1 control-label">- </label>
          <div class="col-xs-5 col-sm-4">
            <input type="text" class="form-control" id="mail" name="res_b" value="<?php echo $lista_evento[9]; ?>" onchange="detectar_cambios('res_b');">
          </div>
        </div>

        <?php
        }
        ?>
        <div class="form-group">
          <label for="estado" class="col-xs-12 col-sm-2 control-label">Estado del Partido: </label>
          <div class="col-xs-12 col-sm-3">
            <label class="css-switch" style="height:33px;">
              <?php
                if ($lista_evento[5]=="1") {?>
                  <input type="checkbox" value="<?php echo $lista_evento[5]; ?>"  checked class="css-switch-check" id = "estado_partido" onChange="cambiar_estado(); detectar_cambios('estado_partido');">                          
                <?php }else{?>
                  <input type="checkbox" value="<?php echo $lista_evento[5]; ?>"  class="css-switch-check" id = "estado_partido" onChange="cambiar_estado(); detectar_cambios('estado_partido');">                          
                <?php }
              ?> 
                <span class="css-switch-label"></span>
                <span class="css-switch-handle"></span>
            </label>
          </div>
          <div id="aviso" style="margin-left:5%; color:red; font-size:82%;"></div>
        </div>       
         <div class="form-group">    
          <div class="col-sm-9">
            <input type="hidden" name="bd" value="partidos">
            <input type="hidden" name="cambios" id="cambios">
            <input type="hidden" name="fecha_actual" id="fecha_cambio">
            <input type="hidden" name="op" value="1">
          </div>
        </div> 
      </form>
      <div id="respuesta"></div>
    </div>
    <div class="tab-pane" id="horarios">
      <div>
        
      <ul style="list-style-type: square;">
        <li style="color:#D2383C; ">Horas Disponibles</li>
        <li style="color:#4CAF50; ">Horas Ocupadas</li>
      </ul>
      <div id='calendarEdit'></div>
      </div>
    </div>
  </div>
  <?php }else{ ?>
    <ul class="nav nav-tabs">
    <li class="active">
      <a href="#formulario" data-toggle="tab" aria-expanded="true">
      Resultados del partido </a>
    </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="formulario">
      <form method="post" action="" id="form_editar_evento" enctype="multipart/form-data" class="form-horizontal">
        
      <div class="form-group">
          
          <div class="col-sm-9">      
            <input type="hidden" class="form-control" id="id_partido" name="id_partido" value="<?php echo $lista_evento[0] ?>">
          </div>
      </div>
        <div class="form-group">
          <label for="apellidos" class="col-xs-12 col-sm-2 control-label">Equipos</label>
          <div class="col-xs-5 col-sm-4">
            <input type="text" class="form-control" id="mail" name="equipo_a" value="<?php echo $lista_evento[6]; ?>" onchange="detectar_cambios('equipo_a');">
          </div>
          <label for="posicion" class="col-xs-1 col-sm-1 control-label">vs.</label>
          <div class="col-xs-5 col-sm-4">
            <input type="text" class="form-control" id="mail" name="equipo_b" value="<?php echo $lista_evento[7]; ?>" onchange="detectar_cambios('equipo_b');">
          </div>
        </div>

        <div class="form-group">
          <label for="posicion" class="col-xs-12 col-sm-2 control-label">Resultados</label>
          <div class="col-xs-5 col-sm-4">
            <input type="text" class="form-control" id="mail"name="res_a" value="<?php echo $lista_evento[8]; ?>" onchange="detectar_cambios('res_a');">
          </div>
          <label for="posicion" class="col-xs-1 col-sm-1 control-label">- </label>
          <div class="col-xs-5 col-sm-4">
            <input type="text" class="form-control" id="mail" name="res_b" value="<?php echo $lista_evento[9]; ?>" onchange="detectar_cambios('res_b');">
          </div>
        </div>     
         <div class="form-group">    
          <div class="col-sm-9">
            <input type="hidden" name="bd" value="partidos">
            <input type="hidden" name="cambios" id="cambios">
            <input type="hidden" name="fecha_actual" id="fecha_cambio">
            <input type="hidden" name="op" value="2">
          </div>
        </div> 
      </form>
      <div id="respuesta"></div>
    </div>
  </div>
<?php }} ?>
<script>
  function borrar_alerta(){
      document.getElementById('error').innerHTML = '';
  }

  function cambio_centroEdit(){
    $('#calendarEdit').fullCalendar('destroy');
    fecha = $("#dateformatEdit").val();           
    centro = $("#id_centro_edit").val();
    $.ajax({
      type: "POST",
      url: "../include/disponibilidad.php",
      data: "fecha="+fecha+"&centro="+centro+"&op=5",
      dataType: "html",
      error: function(){
        alert("error petición ajax");
      },
      success: function(data){     
        $("#alerta").html(data);
      }                         
    });          
  }

  function cambiar_estado(){
    if($("#estado_partido").val()=="0"){
      document.getElementById("estado").value = 1;
      document.getElementById("estado_partido").value = 1;
      document.getElementById("aviso").innerHTML="";
    }else{
      document.getElementById("estado").value = 0;
      document.getElementById("estado_partido").value = 0;
      document.getElementById("aviso").innerHTML="Estimado usuario, si desactiva el partido su fecha y hora de reserva estaran disponibles para otros partidos. ";

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
   
  $('#datepairExample .date').datepicker({
      'format': 'yyyy-m-d',
      'autoclose': true,                        
  });
  $(function() {
      $( "#dateformatEdit" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
      $( "#dateformatEdit" ).datepicker( "option", "yearRange", "-99:+0" );
      $( "#dateformatEdit" ).datepicker( "option", "minDate", "+0m +0d" );
      $( "#dateformatEdit" ).datepicker('setDate', new Date("<?php echo $lista_evento[3].'T'.$lista_evento[4].'-0500' ?>"));
  });  
  $(function() {
    $('#timeformatEdit').timepicker({ 'timeFormat': 'H:i:s'});
  });

  var list_centrosEdit = $("#listado_centrosEdit").clone();
  function asignarUncentroEdit(){
    if ($("#asignar_centroEdit:checked").val()) {
      list_centrosEdit.appendTo("#listado_centrosEdit");
      $('select').select2();
      //document.getElementById("compr_c").value='1';
      document.getElementById("ver_horariosEdit").innerHTML='<a href="#horarios" data-toggle="tab" aria-expanded="false" onclick="cambio_centroEdit();">Ver Horarios </a>';
      document.getElementById("mensaje_edit").innerHTML='* Campos requeridos <br>'
          +'Estimado usuario, al crear su partido se enviar&aacute; la solicitud de reserva al encargado del centro deportivo, '
          +'te avisaremos cuando responda.';
      detectar_cambios('id_centro');
    }else{
      document.getElementById("listado_centrosEdit").innerHTML='';
      document.getElementById("ver_horariosEdit").innerHTML='';
      //document.getElementById("compr_c").value='0';
      document.getElementById("mensaje_edit").innerHTML='* Campos requeridos <br>';
    };
  }
asignarUncentroEdit();
</script>