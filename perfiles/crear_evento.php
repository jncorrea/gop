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
            <!-- CANCHA INFO TAB -->
            <form method="post" action="" id="form_crear_evento" enctype="multipart/form-data" class="form-horizontal">
              <input type="hidden" name="bd" value="partidos">
              <div class="form-group">
                <label for="Nombre_Partido" class="col-xs-12 col-sm-2 control-label" required><span style="color:red;">* </span>Nombre del Partido:</label>
                <div class="col-sm-9" style="padding-top:12px;">
                  <input type="text" class="form-control" id="nombre_partido" name="nombre_partido" placeholder="Da un nombre al partido..">
                </div>
              </div>
              <div class="form-group">
                <label for="Descripcion" class="col-xs-12 col-sm-2 control-label">Descripci&oacute;n:</label>
                <div class="col-sm-9">
                  <textarea type="text" class="form-control" id="descripcion_partido" name="descripcion_partido" placeholder="Describe tu partido.."></textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="grupo" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Grupo</label>
                <div class="col-sm-9">
                  <select style="border-radius:5px;" name="id_grupo" class="form-control">
                  <?php                 
                    $miconexion->consulta("select id_grupo, nombre_grupo from grupos where id_user='".$_SESSION["id"]."' ");
                    $miconexion->opciones();
                  ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="cancha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Lugar: </label>
                <div class="col-sm-9">
                  <select style="border-radius:5px;" id="id_centro" name="id_centro" class="form-control" onChange="prueba();">
                  <?php 
                      $miconexion->consulta("select id_centro, centro_deportivo from centros_deportivos");
                      $miconexion->opciones();
                  ?>
                 </select>
                </div>
              </div>
              <div class="form-group">
                <label for="Fecha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Cuando: </label>
                <div class="col-xs-12 col-sm-4" id="datepairExample">
                  <input type="text" class="date start form-control" id="dateformatExample" name="fecha_partido" placeholder="yyyy-mm-dd" min="08-10-2015" onChange="prueba();" required />
                </div>
                <label for="Hora" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Hora: </label>
                <div class="col-xs-12 col-sm-3">
                  <input style="display:none;" type="text" class="time start form-control" id="timeformatExample" name="hora_partido" data-scroll-default="23:30:00" placeholder="00:00:00" onChange="prueba();"  required/>
                </div>
              </div>
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
              <div class="form-group">
                <input type="hidden" class="form-control" id="estado_partido" name="estado_partido" value="1"  >
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
            <div class="form-group">
              <div class="margin-top-10 col-sm-10" style="float:right;">
                <button type="submit" class="btn green-haze" style="background:#4CAF50;" onclick='enviar_form("../include/insertar_evento.php","form_crear_evento");'>Guardar</button>
                <div id="respuesta"></div>
              </div>
            </div>           
            <!-- END CANCHA INFO TAB -->    
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