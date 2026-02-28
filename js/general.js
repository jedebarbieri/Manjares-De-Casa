//var host = 'http://test.kingsoft.pe/ManjaresDeCasa';
var host = 'http://www.manjaresdecasa.com';
$(document).ready(function (e) {
	$(".cabecera .menuResponsive .btn_desplegar").click(function (e) {
		if ($(".cabecera .menuResponsive").hasClass("desplegado")) {
			$(".cabecera .menuResponsive").removeClass("desplegado");
		} else {
			$(".cabecera .menuResponsive").addClass("desplegado");
		}
	});
	$(".opciones button").click(function (e) {
		mostrarContacto();
		window.history.pushState({contacto: true});
	});
	$(".contacto .btn_cerrar").click(function (e) {
		ocultarContacto();
		window.history.back();
	});
	$(".contacto .veladura").click(function (e) {
		ocultarContacto();
		window.history.back();
	});
	$(document).keyup(function (e) {
		if (e.keyCode == 27) {
			if (window.history.state.idProd !== 'undefined') {
				cerrarDetalle();
				window.history.pushState({url: dominio + categoria.nombre}, "", dominio + categoria.nombre);
			}
		}
	});
	$("#contacto").submit(function (e) {
		e.preventDefault();
		$(".contacto .formulario tr").removeClass("error");
		if (validarContacto()) {
			enviarContacto();
		}
		return false;
	});
	$("#contacto .btn_enviar").click(function (e) {
		$("#contacto").submit();
	});
	window.onpopstate = historyChange;
});
var map = null;
function mostrarContacto(nombreProducto) {
	if (typeof ga != 'undefined') {
		ga('send', 'screenview', {
			'screenname': 'contacto'
		});
	}
	$(".contacto").removeClass("enviando");
	$("#contacto")[0].reset();
	if (nombreProducto) {
		$("#consultas").val("Deseo pedir " + nombreProducto);
	}
	$(".contacto").fadeIn({
		duration: 300,
		complete: function () {
			if (!map) {
				var myLatlng = new google.maps.LatLng(-12.1281202, -76.9893711);
				var mapOptions = {
					center: myLatlng,
					zoom: 15,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					mapTypeControl: false,
					panControl: false,
					streetViewControl: false,
					streetViewControlOptions: false,
					zoomControl: false
				};
				var map = new google.maps.Map(document.getElementById("mapa"), mapOptions);
				var marker = new google.maps.Marker({
					position: myLatlng,
					map: map,
					title: 'Tienda de Manjares de Casa',
					icon: {
						url: host + '/images/marcador_mapa.png',
						size: new google.maps.Size(21, 32),
						origin: new google.maps.Point(0, 0),
						anchor: new google.maps.Point(9, 25)
					}
				});
			}
		}
	});
}
function ocultarContacto() {
	$(".contacto").fadeOut(300);
}
function validarContacto() {
	var valido = true;
	if ($.trim($("#nombre").val()).length < 3) {
		$(".contacto .formulario .nombre").addClass("error");
		valido = false;
	}
	if ($.trim($("#telefono").val()).length < 6) {
		$(".contacto .formulario .telefono").addClass("error");
		valido = false;
	}
	var regExEmail = new RegExp("^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$");
	if (!regExEmail.test($.trim($("#email").val()))) {
		$(".contacto .formulario .email").addClass("error");
		valido = false;
	}
	if ($.trim($("#consultas").val()).length < 10) {
		$(".contacto .formulario .consultas").addClass("error");
		valido = false;
	}
	return valido;
}
function enviarContacto() {
	$(".contacto").addClass("enviando");
	$(".contacto .estado").text("Espere un momento por favor...");
	$.ajax({
		url: "js/ajax/enviarContacto.php",
		type: "POST",
		data: {
			nombre: $.trim($("#nombre").val()),
			telefono: $.trim($("#telefono").val()),
			email: $.trim($("#email").val()),
			consultas: $.trim($("#consultas").val())
		}
	}).done(function (responseText) {
		console.log(responseText);
		var response = eval("(" + responseText + ")");
		if (response.exito) {
			$(".contacto .estado").text("Gracias por escribirnos, pronto estaremos encontacto contigo.");
			if (typeof ga != 'undefined') {
				ga("send", "event", "contacto", "enviarContacto");
			}
		} else {
			$(".contacto .estado").html("No se pudo enviar el mensaje. Por favor intenta enviando un email a <a href='mailto:adriana@manjaresdecasa.com'>adriana@manjaresdecasa.com</a>");
			console.log(repsonse.mensaje);
		}
	}).fail(function (obj) {
		console.log(obj.statusText);
	});
}

function historyChange(e) {
	if (window.history.state) {
		if (window.history.state.idProd) {
			ocultarContacto();
			mostrarDetalleProducto(window.history.state.idProd);
		} else if (window.history.state.contacto) {
			mostrarContacto();
			cerrarDetalle();
		} else {
			ocultarContacto();
			cerrarDetalle();
		}
	}
}
