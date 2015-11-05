<!-- BEGIN PORTLET -->
<div class="caption caption-md">
    <i class="icon-bar-chart theme-font hide"></i>
    <?php
    switch ($comen) {
      case 'a':
        $datos_comentario = file_get_contents("../datos/comentarios_partidos.json");
        break;
      case 'a_c':
        $datos_comentario = file_get_contents("../datos/comentarios_partidos_campeonato.json");
        break;       
      case 'g':
        $datos_comentario = file_get_contents("../datos/comentarios_grupos.json");
        break;
      case 'c':
        $datos_comentario = file_get_contents("../datos/comentarios_campeonatos.json");
        break;
    }
    $json_comentarios = json_decode($datos_comentario, true);
    $cont_comen = 0;
    for ($i=0; $i <count($json_comentarios); $i++) {
      if ($json_comentarios[$i]['tipo']==$id) {
        $cont_comen++;
      }
    }
    ?>
    <span class="caption-subject font-blue-madison bold uppercase">Comentarios</span>
    <span class="caption-helper" id="num_comentarios"><?php echo $cont_comen ?> comentario(s)</span>
    </div>
      <div id="list_comentarios" class="general-item-list scroller" style="height: 441px;" data-always-visible="1" data-rail-visible1="1">    
        <?php           
        for ($i=0; $i <count($json_comentarios); $i++) {
          if ($json_comentarios[$i]['tipo']==$id) {?>
            <div class="item">
              <div class="item-head">
                <div class="item-details">
                  <?php if ($json_comentarios[$i]['avatar']=="") {
                    if ($json_comentarios[$i]['sexo']=="Femenino") {
                      echo '<img alt="Avatar" class="item-pic img-circle" src="../assets/img/user_femenino.png"/>';
                    }else{
                      echo '<img alt="Avatar" class="item-pic img-circle" src="../assets/img/user_masculino.png"/>';
                    }
                  ?>
                  <a href="#" class="item-name primary-link"><?php echo $json_comentarios[$i]['user'] ?></a>
                  <span class="item-label" style="font-size:12px;"><?php echo time_ago(date("Y-m-d H:i:s",strtotime($json_comentarios[$i]['fecha_publicacion']))) ?></span>
                  <?php }else{ ?>
                  <img class="item-pic img-circle" src="images/<?php echo $json_comentarios[$i]['user'] ?>/<?php echo $json_comentarios[$i]['avatar'] ?>">
                  <a href="#" class="item-name primary-link"><?php echo $json_comentarios[$i]['user'] ?></a>
                  <span class="item-label" style="font-size:12px;"><?php echo time_ago(date("Y-m-d H:i:s",strtotime($json_comentarios[$i]['fecha_publicacion']))) ?></span>
                  <?php } ?>
                </div>
                <div class="item-details" style="widht: 30px; float:right;">
                  <?php
                  if (@$json_comentarios[$i]['id_user']==$_SESSION['id'] || @$json_comentarios[$i]['admin']==$_SESSION['id']) {
                  ?>
                    <a title="Eliminar comentario" onclick="actualizar_notificacion(32,<?php echo $json_comentarios[$i]['id_comen'] ?>);" style="display:inline-block; background-color:transparent; margin: 0;padding: 0;">
                      <i style="font-size:12px;" class="icon-remove"></i>
                    </a>
                  <?php
                  }
                  ?>
                </div>
              </div>
              <div class="item-body" style="widht: 100%; height: auto;">
                <?php echo '<p>'.utf8_decode($json_comentarios[$i]['comentario']).'</p>';
                if (@$json_comentarios[$i]['image']!=null || @$json_comentarios[$i]['image']!="") {
                  echo '<img style="width: 250px; height: 150px;" src="'.utf8_decode(@$json_comentarios[$i]['image']).'"/>';
                }
                ?>
              </div>          
            </div>
        <?php }
        } ?>
      </div>

<script>
  var id = '<?php echo $id ?>';
  var fecha_actual = new Date();
  var op = '<?php echo $comen ?>';
  var cont = 0;
  var enlace = "";
  var user = "<?php echo $_SESSION['id']; ?>";
  var act = 32;
  switch(op){
    case "a":
      enlace = "../datos/comentarios_partidos.json";
    break;
    case "a_c":
      enlace = "../datos/comentarios_partidos_campeonato.json";
    break;
    case "g":
      enlace = "../datos/comentarios_grupos.json";
    break;
    case 'c':
      enlace = "../datos/comentarios_campeonatos.json";
      break;
  }
function cargar_comentarios() 
{ 
  $.ajax({
  async:  true, 
    type: "POST",
    url: enlace,
    data: "",
  dataType:"html",
    success: function(data)
  { 
    var json = JSON.parse(data);
    for (var i = 0; i < json.length; i++) {
      if (json[i].tipo==id) {
        fecha_com = Date.parse(json[i].fecha_publicacion);      
        if (fecha_com >= fecha_actual.valueOf()) {
          var newItem = document.createElement("div");
          newItem.className = "item";
          if (json[i].image==null) {
            if (json[i].avatar=="") {
              if(json[i].sexo=="Masculino"){
                if (json[i].id_user == user || json[i].admin == user) {
                  var textnode = newItem.innerHTML +='<div class="item-head">'
                  +'    <div class="item-details">'
                  +'      <img alt="Avatar" class="item-pic img-circle" src="../assets/img/user_masculino.png"/>'
                  +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
                  +'      <span class="item-label" style="font-size:12px;">Hace un momento </span>'
                  +'    </div>'
                  +'    <div class="item-details" style="widht: 30px; float:right;">'
                  +'      <a title="Eliminar comentario" onclick="actualizar_notificacion('+act+','+json[i].id_comen+');" href="#" style="display:inline-block; background-color:transparent; margin: 0;padding: 0;">'
                  +'        <i style="font-size:12px;" class="icon-remove"></i>'
                  +'      </a>'
                  +'    </div>'
                  +'  </div>'
                  +'  <div class="item-body">'
                  +'    <p>'+json[i].comentario+'</p>'
                  +'  </div>';
                }else{
                  var textnode = newItem.innerHTML +='<div class="item-head">'
                  +'    <div class="item-details">'
                  +'      <img alt="Avatar" class="item-pic img-circle" src="../assets/img/user_masculino.png"/>'
                  +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
                  +'      <span class="item-label" style="font-size:12px;">Hace un momento </span>'
                  +'    </div>'
                  +'  </div>'
                  +'  <div class="item-body">'
                  +'    <p>'+json[i].comentario+'</p>'
                  +'  </div>';
                };
              }else{
                if (json[i].id_user ==user || json[i].admin == user) {
                  var textnode = newItem.innerHTML +='<div class="item-head">'
                  +'    <div class="item-details">'
                  +'      <img alt="Avatar" class="item-pic img-circle" src="../assets/img/user_femenino.png"/>'
                  +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
                  +'      <span class="item-label" style="font-size:12px;">Hace un momento </span>'
                  +'    </div>'
                  +'    <div class="item-details" style="widht: 30px; float:right;">'
                  +'      <a title="Eliminar comentario" onclick="actualizar_notificacion('+act+','+json[i].id_comen+');" style="display:inline-block; background-color:transparent; margin: 0;padding: 0;">'
                  +'        <i style="font-size:12px;" class="icon-remove"></i>'
                  +'      </a>'
                  +'    </div>'
                  +'  </div>'
                  +'  <div class="item-body">'
                  +'    <p>'+json[i].comentario+'</p>'
                  +'  </div>';
                }else{
                  var textnode = newItem.innerHTML +='<div class="item-head">'
                  +'    <div class="item-details">'
                  +'      <img alt="Avatar" class="item-pic img-circle" src="../assets/img/user_femenino.png"/>'
                  +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
                  +'      <span class="item-label" style="font-size:12px;">Hace un momento </span>'
                  +'    </div>'
                  +'  </div>'
                  +'  <div class="item-body">'
                  +'    <p>'+json[i].comentario+'</p>'
                  +'  </div>';
                };
              };
            }else{
              if (json[i].id_user ==user || json[i].admin == user) {
                  var textnode = newItem.innerHTML +='<div class="item-head">'
                  +'    <div class="item-details">'
                  +'      <img alt="Avatar" class="item-pic img-circle" src="images/'+json[i].user+json[i].avatar+'"/>'
                  +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
                  +'      <span class="item-label" style="font-size:12px;">Hace un momento </span>'
                  +'    </div>'
                  +'    <div class="item-details" style="widht: 30px; float:right;">'
                  +'      <a title="Eliminar comentario" onclick="actualizar_notificacion('+act+','+json[i].id_comen+');" href="#" style="display:inline-block; background-color:transparent; margin: 0;padding: 0;">'
                  +'        <i style="font-size:12px;" class="icon-remove"></i>'
                  +'      </a>'
                  +'    </div>'
                  +'  </div>'
                  +'  <div class="item-body">'
                  +'    <p>'+json[i].comentario+'</p>'
                  +'  </div>';
                }else{
                  var textnode = newItem.innerHTML +='<div class="item-head">'
                  +'    <div class="item-details">'
                  +'      <img alt="Avatar" class="item-pic img-circle" src="images/'+json[i].user+json[i].avatar+'"/>'
                  +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
                  +'      <span class="item-label" style="font-size:12px;">Hace un momento </span>'
                  +'    </div>'
                  +'  </div>'
                  +'  <div class="item-body">'
                  +'    <p>'+json[i].comentario+'</p>'
                  +'  </div>';
                };
            };
          }else{
            if (json[i].avatar=="") {
              if(json[i].sexo=="Masculino"){
                if (json[i].id_user ==user || json[i].admin == user) {
                  var textnode = newItem.innerHTML +='<div class="item-head">'
                  +'    <div class="item-details">'
                  +'      <img alt="Avatar" class="item-pic img-circle" src="../assets/img/user_masculino.png"/>'
                  +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
                  +'      <span class="item-label" style="font-size:12px;">Hace un momento </span>'
                  +'    </div>'
                  +'    <div class="item-details" style="widht: 30px; float:right;">'
                  +'      <a title="Eliminar comentario" onclick="actualizar_notificacion('+act+','+json[i].id_comen+');" href="#" style="display:inline-block; background-color:transparent; margin: 0;padding: 0;">'
                  +'        <i style="font-size:12px;" class="icon-remove"></i>'
                  +'      </a>'
                  +'    </div>'
                  +'  </div>'
                  +'  <div class="item-body">'
                  +'    <p>'+json[i].comentario+'</p>'
                  +'    <img style="width: 250px; height: 150px;" src="'+json[i].image+'"/>'
                  +'  </div>';
                }else{
                  var textnode = newItem.innerHTML +='<div class="item-head">'
                  +'    <div class="item-details">'
                  +'      <img alt="Avatar" class="item-pic img-circle" src="../assets/img/user_masculino.png"/>'
                  +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
                  +'      <span class="item-label" style="font-size:12px;">Hace un momento </span>'
                  +'    </div>'
                  +'  </div>'
                  +'  <div class="item-body">'
                  +'    <p>'+json[i].comentario+'</p>'
                  +'    <img style="width: 250px; height: 150px;" src="'+json[i].image+'"/>'
                  +'  </div>';
                };
              }else{
                if (json[i].id_user ==user || json[i].admin == user) {
                  var textnode = newItem.innerHTML +='<div class="item-head">'
                  +'    <div class="item-details">'
                  +'      <img alt="Avatar" class="item-pic img-circle" src="../assets/img/user_femenino.png"/>'
                  +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
                  +'      <span class="item-label" style="font-size:12px;">Hace un momento </span>'
                  +'    </div>'
                  +'    <div class="item-details" style="widht: 30px; float:right;">'
                  +'      <a title="Eliminar comentario" onclick="actualizar_notificacion('+act+','+json[i].id_comen+');" href="#" style="display:inline-block; background-color:transparent; margin: 0;padding: 0;">'
                  +'        <i style="font-size:12px;" class="icon-remove"></i>'
                  +'      </a>'
                  +'    </div>'
                  +'  </div>'
                  +'  <div class="item-body">'
                  +'    <p>'+json[i].comentario+'</p>'
                  +'    <img style="width: 250px; height: 150px;" src="'+json[i].image+'"/>'
                  +'  </div>';
                }else{
                  var textnode = newItem.innerHTML +='<div class="item-head">'
                  +'    <div class="item-details">'
                  +'      <img alt="Avatar" class="item-pic img-circle" src="../assets/img/user_femenino.png"/>'
                  +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
                  +'      <span class="item-label" style="font-size:12px;">Hace un momento </span>'
                  +'    </div>'
                  +'  </div>'
                  +'  <div class="item-body">'
                  +'    <p>'+json[i].comentario+'</p>'
                  +'    <img style="width: 250px; height: 150px;" src="'+json[i].image+'"/>'
                  +'  </div>';
                };
              };
            }else{
              if (json[i].id_user ==user || json[i].admin == user) {
                var textnode = newItem.innerHTML +='<div class="item-head">'
                +'    <div class="item-details">'
                +'      <img alt="Avatar" class="item-pic img-circle" src="images/'+json[i].user+json[i].avatar+'"/>'
                +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
                +'      <span class="item-label" style="font-size:12px;">Hace un momento </span>'
                +'    </div>'
                +'    <div class="item-details" style="widht: 30px; float:right;">'
                +'      <a title="Eliminar comentario" onclick="actualizar_notificacion('+act+','+json[i].id_comen+');" href="#" style="display:inline-block; background-color:transparent; margin: 0;padding: 0;">'
                +'        <i style="font-size:12px;" class="icon-remove"></i>'
                +'      </a>'
                +'    </div>'
                +'  </div>'
                +'  <div class="item-body">'
                +'    <p>'+json[i].comentario+'</p>'
                +'    <img style="width: 250px; height: 150px;" src="'+json[i].image+'"/>'
                +'  </div>';
              }else{
                var textnode = newItem.innerHTML +='<div class="item-head">'
                +'    <div class="item-details">'
                +'      <img alt="Avatar" class="item-pic img-circle" src="images/'+json[i].user+json[i].avatar+'"/>'
                +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
                +'      <span class="item-label" style="font-size:12px;">Hace un momento </span>'
                +'    </div>'
                +'  </div>'
                +'  <div class="item-body">'
                +'    <p>'+json[i].comentario+'</p>'
                +'    <img style="width: 250px; height: 150px;" src="'+json[i].image+'"/>'
                +'  </div>';
              };
            };
          };
          var list = document.getElementById("list_comentarios");
          list.insertBefore(newItem, list.childNodes[0]);
          cont++;
        };
      };
    };
    var nComentarios = parseInt('<?php echo $cont_comen ?>');
    if (cont>0) {
      fecha_actual = new Date();
      nComentarios = nComentarios + cont;
      $("#num_comentarios").html(nComentarios+" Comentario(s)");
    };
    }
  });   
}

</script>
<script>  
    function archivo(evt) {
      var files = evt.target.files; // FileList object       
        //Obtenemos la imagen del campo "file". 
    for (var i = 0, f; f = files[i]; i++) {         
        //Solo admitimos imágenes.
        if (!f.type.match('image.*')) {
            continue;
        }
        var reader = new FileReader();
            reader.onload = (function(theFile) {
            return function(e) {
            // Creamos la imagen.
                document.getElementById("img_comentario").innerHTML = ['<img style="width: 120px; height: 120px; border: 1px solid #000;" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
            };
           })(f);
           reader.readAsDataURL(f);
      }
    }  
    document.getElementById('imagen_comentario').addEventListener('change', archivo, false);
</script>
<?php
function time_ago( $date ){
    if( empty($date)){ return "No hay Fecha";}

    $periods = array("segundo", "minuto", "hora", "dia", "semana", "mes", "a&ntilde;o", "decada");
    $lengths = array("60","60","24","7","4.35","12","10");
    $now = time();
    $unix_date = strtotime( $date );
    if( empty( $unix_date ) )// check validity of date
    {
        return "Fecha inv&aacute;lida";
    }    
    if( $now > $unix_date ){ // is it future date or past date

        $difference = $now - $unix_date;
    }else {
        $difference = $unix_date - $now;
    }
    for( $j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++ ){
        $difference /= $lengths[$j];
    }
    $difference = round( $difference );
    if( $difference != 1 ){ $periods[$j].= "s"; }

    return "Hace $difference $periods[$j] ";
}
?>
