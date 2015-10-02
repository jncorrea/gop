<div class="portlet-title">
  <div class="caption">
    <i class="icon-bubble font-red-sunglo"></i>
    <span style="color: red; font-size:11px; padding:10px;">
      * Campos requeridos <br>
    </span>
  </div>
</div>
<br>
<div class="portlet-body">
    <!-- CANCHA INFO TAB -->
    <form  method="post" action="" id="form_crear_reserva" enctype="multipart/form-data" class="form-horizontal">
      <input type="hidden" id="op" name="op" value="1">
      <input type="hidden" name="id_centro" value="<?php echo $id; ?>">
      <div class="checkbox form-group">
        <label class="col-xs-12 col-sm-2 control-label"></label>
        <div class="checkbox col-sm-9">
          <input type="checkbox" id="varios" onchange="varias_fechas();"> Reservar un d&iacute;a en un rango de fechas
        </div>
      </div>
      <div class="form-group">
        <label for="motivo" class="col-xs-12 col-sm-2 control-label">Motivo:</label>
        <div class="col-sm-9">
          <textarea type="text" class="form-control" id="motivo" name="motivo" placeholder="Motivo de la reserva.."></textarea>
        </div>
      </div>
      <div class="form-group" id="insert_dias">        
      </div>
      <div class="form-group" id="insert_fechas">        
      </div>
      <div class="form-group">
        <label for="Hora" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Hora Inicio: </label>
        <div class="col-xs-12 col-sm-3">
          <input type="text" class="time start form-control" id="hora_reserva_ini" onchange="borrar_alerta();" name="hora_inicio" data-scroll-default="08:00:00" placeholder="00:00:00" required/>
        </div>
        <label for="Hora" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Hora Fin: </label>
        <div class="col-xs-12 col-sm-3">
          <input type="text" class="time start form-control" id="hora_reserva_fin" onchange="borrar_alerta();" name="hora_fin" data-scroll-default="13:00:00" placeholder="00:00:00" required/>
        </div>
        <div id="alerta"></div>
      </div>   
        <div id="error" style="margin-left:5%; color:red; font-size:92%;"></div>
        <br>
        <article>                      
        <script>         
            $('#datepairExample .date').datepicker({
                'format': 'yyyy-m-d',
                'autoclose': true,                        
            });
            $(function() {
                $( "#fecha_reserva_ini" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
                $( "#fecha_reserva_ini" ).datepicker( "option", "yearRange", "-99:+0" );
                $( "#fecha_reserva_ini" ).datepicker( "option", "minDate", "+0m +0d" );
                $( "#fecha_reserva_ini" ).datepicker('setDate', new Date());
            });           
        </script> 
        <script>
            $(function() {
              $('#hora_reserva_ini').timepicker({ 'timeFormat': 'H:i:s'});
            });
            $(function() {
              $('#hora_reserva_fin').timepicker({ 'timeFormat': 'H:i:s'});
            });
        </script>
      </article>      
      <div class="checkbox form-group">
        <label class="col-xs-12 col-sm-2 control-label"></label>
        <div class="checkbox col-sm-9">
          <input type="checkbox" id="asignar" onchange="asignar_reserva();"> Asignar reserva a un grupo existente.
        </div>
      </div> 
      <div class="form-group" id="campo_asignar">
        <label for="grupo" class="col-xs-12 col-sm-2 control-label">Grupo</label>
        <div class="col-sm-9">
          <select style="border-radius:5px;" name="id_grupo" class="form-control">
          <?php                 
            $miconexion->consulta("select id_grupo, nombre_grupo from grupos");
            $miconexion->opciones(0);
          ?>
          </select>
        </div>
      </div>        
      <div id="respuesta"></div>
    </form>
  </div>
<script>
  
function varias_fechas(){
  if ($("#varios:checked").val()) {
    document.getElementById("insert_dias").innerHTML='<label for="dia" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>D&iacute;a:</label>'
            +'<div class="col-sm-9">'      
            +'<select style="border-radius:5px;" class="form-control" name="dia" id="dia">'
            +'<optgroup label="Seleccione un d&iacute;a"></optgroup>'
            +'<option value="0">Domingo</option>'
            +'<option value="1">Lunes</option>'
            +'<option value="2">Martes</option>'
            +'<option value="3">Miercoles</option>'
            +'<option value="4">Jueves</option>'
            +'<option value="5">Viernes</option>'
            +'<option value="6">Sabado</option>'
          +'</select></div>';

    document.getElementById("insert_fechas").innerHTML= '<label for="Fecha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Fecha Inicio: </label>'
        +'<div class="col-xs-12 col-sm-3" id="datepairExample">'
        +'  <input type="text" class="date start form-control" id="fecha_reserva_ini" name="fecha_reserva" placeholder="yyyy-mm-dd" required />'
        +'</div>'
        +'<label for="Fecha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Fecha Fin: </label>'
        +'<div class="col-xs-12 col-sm-3" id="datepairExample_fin">'
        +'  <input type="text" class="date start form-control" id="fecha_reserva_fin" name="fecha_fin" placeholder="yyyy-mm-dd" required />'
        +'</div>';

    document.getElementById("op").value="2";

    $('#datepairExample .date').datepicker({
      'format': 'yyyy-m-d',
      'autoclose': true,                        
    });
    $('#datepairExample_fin .date').datepicker({
      'format': 'yyyy-m-d',
      'autoclose': true,                        
    });

    $( "#fecha_reserva_ini" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
    $( "#fecha_reserva_fin" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
    $( "#fecha_reserva_ini" ).datepicker( "option", "yearRange", "-99:+0" );
    $( "#fecha_reserva_fin" ).datepicker( "option", "yearRange", "-99:+0" );
    $( "#fecha_reserva_ini" ).datepicker( "option", "minDate", "+0m +0d" );
    $( "#fecha_reserva_fin" ).datepicker( "option", "minDate", "+0m +0d" );
    $( "#fecha_reserva_ini" ).datepicker('setDate', new Date());
    $( "#fecha_reserva_fin" ).datepicker('setDate', new Date());

    $('select').select2();
  }else{
    document.getElementById("insert_dias").innerHTML='';

    document.getElementById("insert_fechas").innerHTML= '<label for="Fecha" class="col-xs-12 col-sm-2 control-label"><span style="color:red;">* </span>Fecha: </label>'
        +'<div class="col-xs-12 col-sm-3" id="datepairExample">'
        +'  <input type="text" class="date start form-control" id="fecha_reserva_ini" name="fecha_reserva" placeholder="yyyy-mm-dd" required />'
        +'</div>';

    document.getElementById("op").value="1";
    $('#datepairExample .date').datepicker({
      'format': 'yyyy-m-d',
      'autoclose': true,                        
    });
    $( "#fecha_reserva_ini" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
    $( "#fecha_reserva_ini" ).datepicker( "option", "yearRange", "-99:+0" );
    $( "#fecha_reserva_ini" ).datepicker( "option", "minDate", "+0m +0d" );
    $( "#fecha_reserva_ini" ).datepicker('setDate', new Date());
  };
}

  var list_grupos = $( "#campo_asignar" ).clone();
function asignar_reserva(){
  if ($("#asignar:checked").val()) {
    document.getElementById("campo_asignar").innerHTML='';
    list_grupos.appendTo( "#campo_asignar" );
    $('select').select2();
  }else{
    document.getElementById("campo_asignar").innerHTML='<label for="email" class="col-xs-12 col-sm-2 control-label">Email:</label>'
        +'<div class="col-sm-9">'
        +'<input type="email" class="form-control" name="email" placeholder="alguien@mail.com" value=" ">'
        +'</div>';
  };
}

varias_fechas();

asignar_reserva();


</script>