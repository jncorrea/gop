<link href='../assets/css/fullcalendar.css' rel='stylesheet' />
<link href='../assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='../assets/js/moment.min.js'></script>
<script src='../assets/js/fullcalendar.min.js'></script>
<script src='../assets/js/es.js'></script>
<script>

  function leer_horarios() {
    fecha = $("#dateformatExample").val();       
    centro = $("#id_centro").val();  
    $.ajax({
      type: "POST",
      url: "../datos/cargarHorarios.php",
      data: "fecha="+fecha+"&centro="+centro,
      dataType: "html",
      error: function(){
        alert("error petición ajax");
      },
      success: function(data){ 
        cargar_calendario(JSON.parse(data));  
      }                         
    });
   } 

  function cargar_calendario(datos) {
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'agendaWeek,agendaDay'
      },
      minTime: min,
      maxTime: max,
      defaultView: 'agendaDay',
      defaultDate: $("#dateformatExample").val(),
      editable: false,
      events: datos
    }); 
  }

</script>
<div class="portlet-title">
  <div class="caption">
    <i class="icon-bubble font-red-sunglo"></i>
    <span style="color: red; font-size:11px; padding:10px;">
      * Campos requeridos <br>
      Estimado usuario, al crear su partido se enviar&aacute; la solicitud de reserva al encargado del centro deportivo,
       te avisaremos cuando responda.
    </span>
  </div>
</div>
<br>
<ul class="nav nav-tabs">
  <li class="active">
    <a href="#general" data-toggle="tab" aria-expanded="true">
    Crear Partido </a>
  </li>
  <li class="">
    <a href="#elegirHorario" data-toggle="tab" aria-expanded="false" onclick="cambio_centro();">
    Ver Horarios </a>
  </li>
</ul>
<div class="portlet-body" id="chats">
  <div class="tab-content">
  <div class="tab-pane active" id="general">
    <!-- CANCHA INFO TAB -->
    <form  method="post" action="" id="form_crear_evento" enctype="multipart/form-data" class="form-horizontal">
      <input type="hidden" name="bd" value="partidos">
      <div class="form-group">
        <label for="Nombre_Partido" class="col-xs-12 col-sm-2 control-label" required><span style="color:red;">* </span>Nombre del Partido:</label>
        <div class="col-sm-9" style="padding-top:12px;">
          <input type="text" class="form-control" id="nombre" name="nombre_partido" placeholder="Da un nombre al partido..">
        </div>
      </div>
      <div class="form-group">
        <label for="Descripcion" class="col-xs-12 col-sm-2 control-label">Descripci&oacute;n:</label>
        <div class="col-sm-9">
          <textarea type="text" class="form-control" id="descripcion" name="descripcion_partido" placeholder="Describe tu partido.."></textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="grupo" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Grupo</label>
        <div class="col-sm-9">
          <select style="border-radius:5px;" id="u_grupo" name="id_grupo" class="form-control">
          <?php                 
            $miconexion->consulta("select g.id_grupo, g.nombre_grupo from grupos g, user_grupo ug where g.id_grupo = ug.id_grupo and ug.id_user='".$_SESSION["id"]."' ");
            $miconexion->opciones(0);
          ?>
          </select>
        </div>
      </div>     
       <div class="form-group">
          <label for="cancha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Lugar: </label>
          <div class="col-sm-9">
            <select style="border-radius:5px;" id="id_centro" name="id_centro" class="form-control">
            <?php 
                $miconexion->consulta("select distinct(cd.id_centro), cd.centro_deportivo, cd.tiempo_alquiler from centros_deportivos cd, horarios_centros hc where cd.id_centro = hc.id_centro");
                $miconexion->opciones(0);
            ?>
           </select>
          </div>
        </div>
        <div class="form-group">
          <label for="Fecha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Cuando: </label>
          <div class="col-xs-12 col-sm-4" id="datepairExample">
            <input type="text" class="date start form-control" id="dateformatExample" onchange="cambio_centro();" name="fecha_partido" placeholder="yyyy-mm-dd" min="08-10-2015" required />
          </div>
          <label for="Hora" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Hora: </label>
          <div class="col-xs-12 col-sm-3">
            <input type="text" class="time start form-control" id="timeformatExample" onchange="borrar_alerta();" name="hora_partido" data-scroll-default="12:00:00" placeholder="00:00:00" required/>
          </div>
          <div id="alerta"></div>
        </div>   
        <div id="error" style="margin-left:5%; color:red; font-size:80%;"></div>
        <br>
        <article>                      
        <script>     
            $('#datepairExample .date').datepicker({
                'format': 'yyyy-m-d',
                'autoclose': true,                        
            });
            $(function() {
                $( "#dateformatExample" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
                $( "#dateformatExample" ).datepicker( "option", "yearRange", "-99:+0" );
                $( "#dateformatExample" ).datepicker( "option", "minDate", "+0m +0d" );
                $( "#dateformatExample" ).datepicker('setDate', new Date());
            });           
        </script> 
        <script>
            $(function() {
              $('#timeformatExample').timepicker({ 'timeFormat': 'H:i:s'});
            });
        </script>
      </article>          
      <div class="form-group">
        <label for="equipoA" class="col-xs-12 col-sm-2 control-label">Equipos:</label>
        <div class="col-xs-5 col-sm-4">
          <input type="text" class="form-control" id="equipoA" name="equipo_a" value="Equipo A"  >
        </div>
        <label for="equipoB" class="col-xs-1 col-sm-1 control-label">vs. </label>
        <div class="col-xs-5 col-sm-4">
          <input type="text" class="form-control" id="equipoB" name="equipo_b" value="Equipo B"  >
        </div>
      </div>               
      <div id="respuesta"></div>
    </form>
    <!-- END CANCHA INFO TAB --> 
  </div>
  <!-- BEGIN CANCHA HORARIO TAB --> 
  <div class="tab-pane" id="elegirHorario">
    <ul>
      <li style="color:#4CAF50; list-style-type: square;">Horas Disponibles</li>
      <li style="color:#D2383C; list-style-type: square;">Horas Ocupadas</li>
    </ul>
    <div id='calendar'></div>
  </div>
  <!-- END CANCHA HORARIO TAB --> 
  </div>
</div>
<script>
  function borrar_alerta(){
      document.getElementById('error').innerHTML = '';
  }
  
  function cambio_centro(){
    document.getElementById('error').innerHTML = '';
    $('#calendar').fullCalendar('destroy');
    fecha = $("#dateformatExample").val();           
    centro = $("#id_centro").val();
    $.ajax({
      type: "POST",
      url: "../include/disponibilidad.php",
      data: "fecha="+fecha+"&centro="+centro+"&op=3",
      dataType: "html",
      error: function(){
        alert("error petición ajax");
      },
      success: function(data){     
        $("#alerta").html(data);
      }                         
    });          
  }
  function cargar_horarios(){
    centro = $("#id_centro").val();
  }
</script>