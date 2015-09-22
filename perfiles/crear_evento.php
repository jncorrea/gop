<link href='../assets/css/fullcalendar.css' rel='stylesheet' />
<link href='../assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='../assets/js/moment.min.js'></script>
<script src='../assets/js/fullcalendar.min.js'></script>
<script src='../assets/js/lang-all.js'></script>
<script>

  function leer_horarios() {
    document.getElementById('nombre_partido').value = $("#nombre").val();
    document.getElementById('descripcion_partido').value = $("#descripcion").val();
    document.getElementById('id_grupo').value = $("#u_grupo").val();
    document.getElementById('equipo_a').value = $("#equipoA").val();
    document.getElementById('equipo_b').value = $("#equipoB").val();
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
      lang: 'es',
      editable: false,
      events: datos
    }); 
  }

</script>
<div class="page-bar">
  <ul class="page-breadcrumb">
    <li>
      <i class="icon-home"></i>
      <a href="perfil.php">Home</a>
      <i class="icon-angle-right"></i>
    </li>
    <li>
      <a href="perfil.php?op=crear_evento">Crear Partido</a>
    </li>
  </ul> 
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
  <div class="row">
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
      <h3 class="page-title">
        Partidos <small>Crear Partido</small>
      </h3>
      <div class="portlet light ">
        <div class="portlet-title">
          <div class="caption">
            <i class="icon-bubble font-red-sunglo"></i>
            <span class="caption-subject bold uppercase" style="color: #006064;">
              NUEVO PARTIDO
            </span>
            <br><span style="color: red; font-size:11px; padding:10px;">
              * Campos requeridos
            </span>
          </div>
        </div>
        <div class="portlet-body" id="chats">
          <div class="tab-content">
          <div class="tab-pane active" id="general">
            <!-- CANCHA INFO TAB -->
            <form method="post" action="" class="form-horizontal">
              <div class="form-group">
                <label for="Nombre_Partido" class="col-xs-12 col-sm-2 control-label" required><span style="color:red;">* </span>Nombre del Partido:</label>
                <div class="col-sm-9" style="padding-top:12px;">
                  <input type="text" class="form-control" id="nombre" placeholder="Da un nombre al partido..">
                </div>
              </div>
              <div class="form-group">
                <label for="Descripcion" class="col-xs-12 col-sm-2 control-label">Descripci&oacute;n:</label>
                <div class="col-sm-9">
                  <textarea type="text" class="form-control" id="descripcion" placeholder="Describe tu partido.."></textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="grupo" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Grupo</label>
                <div class="col-sm-9">
                  <select style="border-radius:5px;" id="u_grupo" name="u_grupo" class="form-control">
                  <?php                 
                    $miconexion->consulta("select id_grupo, nombre_grupo from grupos where id_user='".$_SESSION["id"]."' ");
                    $miconexion->opciones(0);
                  ?>
                  </select>
                </div>
              </div>              
              <div class="form-group">
                <label for="equipoA" class="col-xs-12 col-sm-2 control-label">Equipos:</label>
                <div class="col-xs-5 col-sm-4">
                  <input type="text" class="form-control" id="equipoA" value="Equipo A"  >
                </div>
                <label for="equipoB" class="col-xs-1 col-sm-1 control-label">vs. </label>
                <div class="col-xs-5 col-sm-4">
                  <input type="text" class="form-control" id="equipoB" value="Equipo B"  >
                </div>
              </div>
              <div class="form-group">
              <div class="margin-top-10 col-sm-10" style="float:right;">
                <a type="button" class="btn green-haze" onblur="cambio_centro();" style="background:#4CAF50;" href="#elegirHorario"  data-toggle="tab" aria-expanded="false">Continuar</a>
                <div id="respuesta"></div>
              </div>
            </div>                                 
            </form>
            <!-- END CANCHA INFO TAB --> 
          </div>
          <!-- BEGIN CANCHA HORARIO TAB --> 
          <div class="tab-pane" id="elegirHorario">
          <!-- CANCHA INFO TAB -->
            <form method="post" action="" id="form_crear_evento" enctype="multipart/form-data" class="form-horizontal">
              <input type="hidden" name="bd" value="partidos">
              <input type="hidden" id="nombre_partido" name="nombre_partido">
              <input type="hidden" id="descripcion_partido" name="descripcion_partido">
              <input type="hidden" id="id_grupo" name="id_grupo">
              <div class="form-group">
                  <label for="cancha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Lugar: </label>
                  <div class="col-sm-9">
                    <select style="border-radius:5px;" id="id_centro" name="id_centro" class="form-control" onChange="cambio_centro();">
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
                    <input type="text" class="date start form-control" id="dateformatExample" name="fecha_partido" placeholder="yyyy-mm-dd" min="08-10-2015" onchange="cambio_centro();" required />
                  </div>
                  <label for="Hora" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Hora: </label>
                  <div class="col-xs-12 col-sm-3">
                    <input type="text" class="time start form-control" id="timeformatExample" onchange="borrar_alerta();" name="hora_partido" data-scroll-default="23:30:00" placeholder="00:00:00" required/>
                    <input type="hidden" id="equipo_a" name="equipo_a">
                    <input type="hidden" id="equipo_b" name="equipo_b">
                    <input type="hidden" class="form-control" id="estado_partido" name="estado_partido" value="1"  >
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
              <div class="form-group" style="text-align:center;">
                <div class="col-sm-offset-2 col-sm-4">
                  <a type="button" class="btn red" href="#general" data-toggle="tab" aria-expanded="false">Volver</a>
                </div>
                <div class="col-sm-offset-2 col-sm-4">
                  <button type="button" class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/insertar_evento.php","form_crear_evento");'>Guardar</button>
                  <div id="respuesta"></div>
                </div>
              </div>
            </form>
            <br>
                  <ul style="list-style-type: square; display:inline-block;">
                    <li style="color:#D2383C; ">Horas Disponibles</li>
                    <li style="color:#4CAF50; ">Horas Ocupadas</li>
                  </ul>
            <div id='calendar'></div>
          </div>
          <!-- END CANCHA HORARIO TAB --> 
          </div>
        </div>
      </div>
    </div>
    <div class="chat page-sidebar-menu col-lg-2 col-md-2 col-sm-12 col-xs-12" style="border-left: 1px solid #EEEEEE;">
    <h4>USUARIOS CONECTADOS</h4>
    <ul style="color:#ffff; list-style: none; padding:0px;">
      <div id = "col_chat"></div>
    </ul>
  </div>
</div>
<script>
  function borrar_alerta(){
      document.getElementById('error').innerHTML = '';
  }
  
  function cambio_centro(){
    document.getElementById('error').innerHTML = '';
    $('#calendar').fullCalendar('destroy');
    leer_horarios();
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