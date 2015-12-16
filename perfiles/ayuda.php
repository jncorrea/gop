
<?php 
extract($_GET);
switch ($op) {
    case '1':?>
        <div class="panel-group accordion" id="accordion1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1" aria-expanded="false"> Editar Perfil </a>
                    </h4>
                </div>
                <div id="collapse_1" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <p style="text-align:justify;"> Para editar tu perfil debes dirigirte al inoco de usuario ubicado en la parte superior derecha, 
                            en el men&uacute; desplegable selecciona la opci&oacute;n <strong>MI PERFIL</strong>.</p>
                        <img src="../assets/img/ayuda/1.gif" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_2" aria-expanded="false"> Favoritos </a>
                    </h4>
                </div>
                <div id="collapse_2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <p style="text-align:justify;"> Para administrar tus deportes y centros favoritos, ubicate en tu perfil y selecciona
                        la pesta&ntilde;a <strong>FAVORITOS</strong>.</p>
                        <img src="../assets/img/ayuda/2.gif" class="img-responsive">
                    </div>
                </div>
            </div>            
        </div>
    <?php break;

    case '2':?>
        <div class="panel-group accordion" id="accordion1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1" aria-expanded="false"> Crear un Grupo</a>
                    </h4>
                </div>
                <div id="collapse_1" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <p style="text-align:justify;"> Para crear un grupo nuevo debes dirigirte al men&uacute; lateral izquierdo y selecciona 
                            <strong>MI GRUPOS</strong>, luego la opci&oacute;n <strong>CREAR GRUPO</strong>.</p>
                        <img src="../assets/img/ayuda/3.gif" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_3" aria-expanded="false"> Cambiar Imagen del Grupo </a>
                    </h4>
                </div>
                <div id="collapse_3" class="panel-collapse collapse" aria-expanded="false">
                    <div class="panel-body">
                        <p style="text-align:justify;"> Para cambiar la imagen de un grupo selecciona el icono de la camara ubicado en la parte
                        derecha inferior en la imagen actual, selecciona la nueva imagen y luego en <strong>GUARDAR CAMBIOS</strong>. <br>
                        Las imagenes puede ser de extensi&oacute;n: .jpg .png &oacute; .gif</p>
                        <img src="../assets/img/ayuda/4.gif" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_4" aria-expanded="false"> Invitar Amigos </a>
                    </h4>
                </div>
                <div id="collapse_4" class="panel-collapse collapse" aria-expanded="false">
                    <div class="panel-body">
                        <p style="text-align:justify;"> Para invitar un amigo en el grupo dirigite hacia la pesta&ntilde;a 
                        <strong>MIEMBROS</strong> aqu&iacute; selecciona la opci&oacute;n <strong>INVITAR</strong>, 
                        puedes buscar un amigo por su nombre, correo &oacute; usuario. En caso de que el usuario a&uacute;n no se encuentre 
                        registrado escribe su correo y entonces se le enviar&aacute; una invitaci&oacute;n por email.</p>
                        <img src="../assets/img/ayuda/5.gif" class="img-responsive">
                    </div>
                </div>
            </div>
        </div>
    <?php break;

    case '3':?>
        <div class="panel-group accordion" id="accordion1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1" aria-expanded="false"> Crear un Partido </a>
                    </h4>
                </div>
                <div id="collapse_1" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <p style="text-align:justify;"> Para crear un partido dirigite hacia el men&uacute; lateral izquierdo y al literal
                            <strong>MIS PARTIDOS</strong> aqu&iacute; selecciona la opci&oacute;n <strong>CREAR PARTIDO</strong>
                            completa el formulario con los datos requeridos y crea el partido. <br>                            
                        </p>
                        <img src="../assets/img/ayuda/6.gif" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_2" aria-expanded="false"> Reservar una Cancha </a>
                    </h4>
                </div>
                <div id="collapse_2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <p style="text-align:justify;"> Para hacer una reserva al crear un partido marca la casilla 
                        <strong>Crear una reserva en un centro deportivo</strong> entonces se habilitara la pesta&ntilde;a 
                        <strong>VER HORARIOS</strong>, aqu&iacute; podr&aacute;s ver los horarios disponibles de la cancha deportiva seleccionada,  
                        luego de tener un horario regresa a la pesta&ntilde;a <strong>CREAR PARTIDO</strong> e introduce la fecha y hora de la reserva.</p>
                        <img src="../assets/img/ayuda/15.gif" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_3" aria-expanded="false"> Editar Partido </a>
                    </h4>
                </div>
                <div id="collapse_3" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <p style="text-align:justify;"> El due&ntilde;o del grupo y el creador de un partido podr&aacute;n acceder
                            a la opci&oacute;n <strong>Editar Partido</strong>, para esto debes dirigirte al icono del l&aacute;piz 
                            junto a la fecha del partido, aqu&iacute; edita la informaci&oacute;n necesaria. <br>
                            Los campos para establecer el marcador final del partido aparecer&aacute;n, cuando la fecha del partido
                            sea menor a la actual.</p>
                        <img src="../assets/img/ayuda/7.gif" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_4" aria-expanded="false"> Cambiar Alineaci&oacute;on </a>
                    </h4>
                </div>
                <div id="collapse_4" class="panel-collapse collapse" aria-expanded="false">
                    <div class="panel-body">
                        <p style="text-align:justify;"> Puedes cambiar la alineaci&oacute;n de un partido arrastrando
                            las imagenes de los jugadores hacia la cancha, para guardar los cambios debes seleccionar
                            <strong>GUARDAR CAMBIOS</strong>.</p>
                        <img src="../assets/img/ayuda/8.gif" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_5" aria-expanded="false"> Notificar por Email  </a>
                    </h4>
                </div>
                <div id="collapse_5" class="panel-collapse collapse" aria-expanded="false">
                    <div class="panel-body">
                        <p style="text-align:justify;"> 
                            El due&ntilde;o del grupo y el creador de un partido podr&aacute;n notificar a los miembros 
                            del partido sobre la alineaci&oacute;n actual por medio de un email, para esto deben acceder
                            al icono ubicado debajo del bot&oacute;n <strong>GUARDAR CAMBIOS</strong> y seleccionar la
                            opci&oacute;n <strong>Notificar</strong>.</p>
                        <img src="../assets/img/ayuda/9.gif" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_6" aria-expanded="false"> Ofertar Cupos </a>
                    </h4>
                </div>
                <div id="collapse_6" class="panel-collapse collapse" aria-expanded="false">
                    <div class="panel-body">
                        <p>
                            El due&ntilde;o del grupo y el creador de un partido podr&aacute;n ofertar cupos para un partido 
                            de tal manera que personas dentro de la aplicaci&oacute; puedan aceptar la oferta y formar parte
                            del partido, para esto deben acceder al icono ubicado debajo del bot&oacute;n <strong>GUARDAR CAMBIOS</strong> 
                            y seleccionar la opci&oacute;n <strong>Ofertar Cupos</strong>.</p>
                        <img src="../assets/img/ayuda/10.gif" class="img-responsive">
                    </div>
                </div>
            </div>
        </div>
    <?php break;

    case '4':?>
        <div class="panel-group accordion" id="accordion1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1" aria-expanded="false"> Crear un Campeonato</a>
                    </h4>
                </div>
                <div id="collapse_1" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <p style="text-align:justify;"> 
                            Para crear un campeonato dirigite hacia el men&uacute; lateral izquierdo y al literal
                            <strong>MIS CAMPEONATOS</strong> aqu&iacute; selecciona la opci&oacute;n <strong>CREAR CAMPEONATO</strong>
                            completa el formulario con los datos requeridos y crea el partido. <br>  
                        <img src="../assets/img/ayuda/11.gif" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_2" aria-expanded="false"> Invitar Grupos</a>
                    </h4>
                </div>
                <div id="collapse_2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <p style="text-align:justify;"> Para invitar un grupo al campeonato dirigite hacia la pesta&ntilde;a 
                        <strong>PARTICIPANTES</strong> aqu&iacute; selecciona la opci&oacute;n <strong>INVITAR GRUPOS</strong>, 
                        y entonces en el buscador escribe el nombre del grupo a invitar.</p>
                        <img src="../assets/img/ayuda/12.gif" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_3" aria-expanded="false"> Crear y Remover Etapas </a>
                    </h4>
                </div>
                <div id="collapse_3" class="panel-collapse collapse" aria-expanded="false">
                    <div class="panel-body">
                        <p style="text-align:justify;"> Para crear una nueva etapa selecciona el literal 
                        <strong>Agregar una etapa +</strong> ubicado debajo del nombre del campeonato. <br>
                        Para eliminar una de las etapas estan no deben contener partidos, ubicate en el <strong>X</strong> de color
                        rojo disponible a la izquierda de cada etapa para eliminar alguna de ellas. 
                        </p>
                        <img src="../assets/img/ayuda/13.gif" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_4" aria-expanded="false"> Crear Partido en una Etapa </a>
                    </h4>
                </div>
                <div id="collapse_4" class="panel-collapse collapse" aria-expanded="false">
                    <div class="panel-body">
                        <p style="text-align:justify;"> Para crear una partido en una etapa ubicate en el <strong>+</strong> de color
                        verde disponible a la izquierda de cada etapa, completa el formulario y crea el partido. <br>                         
                        </p>
                        <img src="../assets/img/ayuda/14.gif" class="img-responsive">
                    </div>
                </div>
            </div>
        </div>
    <?php break;
    
    default:
        # code...
        break;
} ?>
