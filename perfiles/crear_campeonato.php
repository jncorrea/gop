<div class="portlet-title">
  <div class="caption">
    <i class="icon-bubble font-red-sunglo"></i>
    <span style="color: red; font-size:11px; padding:10px;" id="mensaje_crear">
      * Campos requeridos <br>
    </span>
  </div>
</div>

<br>
<ul class="nav nav-tabs">
  <li class="active">
    <a href="#general_c" data-toggle="tab" aria-expanded="true">
    Crear Campeonato </a>
  </li>
  
</ul>
<div class="portlet-body" id="chats">
  <div class="tab-content">
  <div class="tab-pane active" id="general_c">
    <!-- CANCHA INFO TAB -->
    <form  method="post" action="" id="form_crear_campeonato" enctype="multipart/form-data" class="form-horizontal">
      <input type="hidden" name="bd" value="campeonatos" id="compr_campeonato">
      <div class="form-group">
        <label for="nombre_campeonato" class="col-xs-12 col-sm-2 control-label" required><span style="color:red;">* </span>Nombre del Campeonato:</label>
        <div class="col-sm-9" style="padding-top:12px;">
          <input type="text" class="form-control" id="nombre_campeonato" name="nombre_campeonato" placeholder="Nombre del campeonato..">
        </div>
      </div>

      <div class="form-group">
        <label for="Descripcion_c" class="col-xs-12 col-sm-2 control-label">Descripci&oacute;n:</label>
        <div class="col-sm-9">
          <textarea type="text" class="form-control" id="descripcion_c" name="descripcion" placeholder="Describe el campeonato (Opcional) "></textarea>
        </div>
      </div> 

      <div class="form-group">
        <label for="tipo_C" class="col-xs-12 col-sm-2 control-label">Tipo de Campeonato: </label>
        <div class="col-sm-9">
          <div >
          <select style="border-radius:5px;" name="tipo" class="form-control">
              <?php
              echo "<option value='eliminatorias' selected ='selected'> Por Eliminatorias </option>";
              echo "<option value='nacional' > Nacional (Por fechas) </option>";
              ?>
          </select>
        </div>
        </div>
      </div>
      <div class="form-group">
        <label for="etapas" class="col-xs-12 col-sm-2 control-label" ><span style="color:red;">* </span>Etapas: </label>
        <div class="col-sm-9" style="padding-top:12px;">
          <input type="number" class="form-control" id="etapas" name="etapas" placeholder="5">
        </div>
      </div>
      <div class="form-group">
        <label for="msn" class="col-xs-12 col-sm-2 control-label" > </label>
        <div class="col-sm-9">
          <label ><h5>(N&uacute;mero de etapas o fechas en las que se jugara este campeonato )</h5>  </label>
       </div>
      </div>      

    </form>
    <!-- END CANCHA INFO TAB --> 
  </div>
  <!-- BEGIN CANCHA HORARIO TAB --> 
  
  <!-- END CANCHA HORARIO TAB --> 
  </div>
</div>

