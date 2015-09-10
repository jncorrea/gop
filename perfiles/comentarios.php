<?php 
  include("../static/site_config.php"); 
  include ("../static/clase_mysql.php");
  extract($_GET);
  session_start();
  $miconexion = new clase_mysql;
  $miconexion->conectar($db_name,$db_host, $db_user,$db_password); 
?>
<!-- BEGIN PORTLET -->
<div class="caption caption-md">
    <i class="icon-bar-chart theme-font hide"></i>
    <?php
    switch ($comen) {
      case 'a':
        $datos_comentario = file_get_contents("../datos/comentarios_partidos.json");
        break;
      
      case 'g':
        $datos_comentario = file_get_contents("../datos/comentarios_grupos.json");
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
      <div class="general-item-list" id="list_comentarios">    
        <?php           
        for ($i=0; $i <count($json_comentarios); $i++) {
          if ($json_comentarios[$i]['tipo']==$id) {?>
            <div class="item">
              <div class="item-head">
                <div class="item-details">
                  <?php if ($json_comentarios[$i]['avatar']=="") {
                    if ($json_comentarios[$i]['sexo']=="Femenino") {
                      echo '<img alt="Avatar" class="item-pic" src="../assets/img/user_femenino.png"/>';
                    }else{
                      echo '<img alt="Avatar" class="item-pic" src="../assets/img/user_masculino.png"/>';
                    }
                  ?>
                  <a href="#" class="item-name primary-link"><?php echo $json_comentarios[$i]['user'] ?></a>
                  <span class="item-label"><?php echo $json_comentarios[$i]['fecha_publicacion'] ?></span>
                  <?php }else{ ?>
                  <img class="item-pic" src="images/<?php echo $json_comentarios[$i]['user'] ?>/<?php echo $json_comentarios[$i]['avatar'] ?>">
                  <a href="#" class="item-name primary-link"><?php echo $json_comentarios[$i]['user'] ?></a>
                  <span class="item-label"><?php echo $json_comentarios[$i]['fecha_publicacion'] ?></span>
                  <?php } ?>
                </div>
              </div>
              <div class="item-body">
                <?php echo $json_comentarios[$i]['comentario'] ?>
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
  switch(op){
    case "a":
      enlace = "../datos/comentarios_partidos.json";
    break;
    case "g":
      enlace = "../datos/comentarios_grupos.json";
    break;
  }
  cargar_push();
function cargar_push() 
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
        var fecha_com = new Date(json[i].fecha_publicacion);        
        if (fecha_com >= fecha_actual) {
          var newItem = document.createElement("div");
          newItem.className = "item";
          if (json[i].avatar=="") {
            if(json[i].sexo=="Masculino"){
              var textnode = newItem.innerHTML +='<div class="item-head">'
              +'    <div class="item-details">'
              +'      <img alt="Avatar" class="item-pic" src="../assets/img/user_masculino.png"/>'
              +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
              +'      <span class="item-label">'+json[i].fecha_publicacion+'</span>'
              +'    </div>'
              +'  </div>'
              +'  <div class="item-body">'
              +'    '+json[i].comentario
              +'  </div>';
            }else{
              var textnode = newItem.innerHTML +='<div class="item-head">'
              +'    <div class="item-details">'
              +'      <img alt="Avatar" class="item-pic" src="../assets/img/user_femenino.png"/>'
              +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
              +'      <span class="item-label">'+json[i].fecha_publicacion+'</span>'
              +'    </div>'
              +'  </div>'
              +'  <div class="item-body">'
              +'    '+json[i].comentario
              +'  </div>';
            };
          }else{
            var textnode = newItem.innerHTML +='<div class="item-head">'
            +'    <div class="item-details">'
            +'      <img alt="Avatar" class="item-pic" src="images/'+json[i].user+json[i].avatar+'"/>'
            +'      <a href="#" class="item-name primary-link">'+json[i].user+'</a>'
            +'      <span class="item-label">'+json[i].fecha_publicacion+'</span>'
            +'    </div>'
            +'  </div>'
            +'  <div class="item-body">'
            +'    '+json[i].comentario
            +'  </div>';
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
    setTimeout('cargar_push()',2000);
          
    }
  });   
}
</script>