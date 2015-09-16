//OPCIONES EDITABLES
var ImagenAlerta='alert.png';
var ImagenConfirmacion='confirm.png';

//OPCIONES NO EDITABLE
var VentanaModalActiva=false;
function VentanaAlertaModal(){
	var args = VentanaAlertaModal.arguments;
	var Mensaje = args[0];
	var NombreFuncion = args[1];
		
	$('#FndYnnovaAlertas').css({width:getRealDocWidth()+f_scrollLeft()+'px', height : getDocHeight()+'px', top: '0px',  left:'0px', display: 'block' });
	
	
	if(ImagenAlerta)
		var ImagenVentana='<img src="'+ImagenAlerta+'" /> '
	else
		var ImagenVentana=''

	if(!Mensaje)
		$('#FndYnnovaAlertas').html('<div id="MensajeYnnova">'+ImagenVentana+'<p>'+unescape('Ingrese un mensaje')+'</p><input type="button" name="button" id="button" value="Ok" onclick="javascript:CerrarModales();" /></div>');
	else if(NombreFuncion)
		$('#FndYnnovaAlertas').html('<div id="MensajeYnnova">'+ImagenVentana+'<p>'+unescape(Mensaje)+'</p><input type="button" name="button" id="button" value="Ok" onclick="javascript:CerrarModales();'+NombreFuncion+'()" /></div>');
	else
		$('#FndYnnovaAlertas').html('<div id="MensajeYnnova">'+ImagenVentana+'<p>'+unescape(Mensaje)+'</p><input type="button" name="button" id="button" value="Ok" onclick="javascript:CerrarModales();" /></div>');

	VentanaModalActiva=true
	AjustoFondoModalAlerta()
}

function VentanaConfirmacionModal(){
	var args = VentanaConfirmacionModal.arguments;
	var Mensaje = args[0];
	var NombreFuncion = args[1];

	$('#FndYnnovaAlertas').css({width:getRealDocWidth()+f_scrollLeft()+'px', height : getDocHeight()+'px', top: '0px',  left:'0px', display: 'block' });
	
	if(ImagenConfirmacion)
		var ImagenVentana='<img src="'+ImagenAlerta+'" /> '
	else
		var ImagenVentana=''

	if(!Mensaje)
		$('#FndYnnovaAlertas').html('<div id="MensajeYnnova"><p>'+unescape('Ingrese un mensaje')+'</p><input type="button" name="button" id="button" value="S&iacute;" onclick="javascript:CerrarModales()" />&nbsp;<input type="button" name="button" id="button" value="No" onclick="javascript:CerrarModales()" /></div>');
	else if(NombreFuncion)
		$('#FndYnnovaAlertas').html('<div id="MensajeYnnova">'+ImagenVentana+'<p>'+unescape(Mensaje)+'</p><input type="button" name="button" id="button" value="S&iacute;" onclick="javascript:CerrarModales();'+NombreFuncion+'()" />&nbsp;<input type="button" name="button" id="button" value="No" onclick="javascript:CerrarModales()" /></div>');
	else
		$('#FndYnnovaAlertas').html('<div id="MensajeYnnova">'+ImagenVentana+'<p>'+unescape(Mensaje)+'</p><input type="button" name="button" id="button" value="S&iacute;" onclick="javascript:CerrarModales()" />&nbsp;<input type="button" name="button" id="button" value="No" onclick="javascript:CerrarModales()" /></div>')

	VentanaModalActiva=true
	AjustoFondoModalAlerta()
}

function VentanaValorEntradaModal(){
	var args = VentanaValorEntradaModal.arguments;
	var Mensaje = args[0];
	var NombreFuncion = args[1];

	$('#FndYnnovaAlertas').css({width:getRealDocWidth()+f_scrollLeft()+'px', height : getDocHeight()+'px', top: '0px',  left:'0px', display: 'block' });

	
	if(ImagenConfirmacion)
		var ImagenVentana='<img src="'+ImagenAlerta+'" /> '
	else
		var ImagenVentana=''

	if(!Mensaje)
		$('#FndYnnovaAlertas').html('<div id="MensajeYnnova"><p>'+unescape('Ingrese un mensaje')+'</p><input type="button" name="button" id="button" value="S&iacute;" onclick="javascript:CerrarModales()" />&nbsp;<input type="button" name="button" id="button" value="No" onclick="javascript:CerrarModales()" /></div>')
	else if(NombreFuncion)
		$('#FndYnnovaAlertas').html('<div id="MensajeYnnova">'+ImagenVentana+'<p>'+unescape(Mensaje)+'</p><input type="text" name="YnnText" id="YnnText" /> <input type="button" name="button" id="button" value=" Aceptar " onclick="javascript:'+NombreFuncion+'($(\'YnnText\').value)" /><p><input type="button" name="button" id="button" value=" Cerrar " onclick="javascript:CerrarModales()" /></p></div>')
	else
		$('#FndYnnovaAlertas').html('<div id="MensajeYnnova">'+ImagenVentana+'<p>'+unescape(Mensaje)+'</p><input type="text" name="YnnText" id="YnnText" /> <input type="button" name="button" id="button" value="S&iacute;" onclick="javascript:CerrarModales()" />&nbsp;<input type="button" name="button" id="button" value="No" onclick="javascript:CerrarModales()" /></div>')

	VentanaModalActiva=true
	AjustoFondoModalAlerta()
}

function AjustoFondoModalAlerta(){
	
	if(!VentanaModalActiva)
		return false
	
	$('#FndYnnovaAlertas').css({width:getRealDocWidth()+f_scrollLeft()+'px', height : getDocHeight()+'px', top: '0px',  left:'0px', display: 'block' });
	
	var AnchoForm=$('#MensajeYnnova').width();

	$('#MensajeYnnova').css({top: f_scrollTop()+(getMinDocHeight())/2+'px', left:f_scrollLeft()+getRealDocWidth()/2-AnchoForm/2+'px' });

	
}

function CerrarModales(){
	$('#MensajeYnnova').html('');
	
	$('#FndYnnovaAlertas').css({width: '0px', height: '0px', top: '0px',  left:'0px', display: 'none' });


	$('#MensajeYnnova').css({ top: '0px', left:'0px' });
	
	VentanaModalActiva=false
}

$(window).bind("resize", function(){AjustoFondoModalAlerta()})
$(window).bind("scroll", function(){AjustoFondoModalAlerta()})
