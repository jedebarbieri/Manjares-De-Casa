var intervalo = 0;
$(document).ready(function (e) {
	$("#listaProductos").tinyscrollbar({axis: "x"});
	$("#listaProductos .producto").mouseenter(function (e) {
		$(this).find(".layer").animate({top: "0%"}, {duration: 500, queue: false});
	});
	$("#listaProductos .producto").mouseleave(function (e) {
		$(this).find(".layer").animate({top: "100%"}, {duration: 500, queue: false});
	});
	$("#listaProductos .viewport").mouseenter(function (e) {
		$("#listaProductos .viewport").mousemove(desplazar);
	});
	$("#listaProductos .viewport").mouseleave(function (e) {
		$("#listaProductos .viewport").unbind("mousemove", desplazar);
		clearInterval(intervalo);
	});
	$("#listaProductos .producto").click(function (e) {
		e.preventDefault();
		mostrarDetalleProducto($(this).data("id"));
		window.history.pushState({
			url: $(this).attr("href"),
			idProd: $(this).data("id")
		}, "", $(this).attr("href"));
	});

	eventosDetalle();

	if (producto) {
		window.history.replaceState({
			url: window.location.href,
			idProd: producto.id
		}, "", window.location.href);
	} else {
		window.history.replaceState({url: host + "/" + categoria.nombre}, "", host + "/" + categoria.nombre);
	}
});
function desplazar(e) {
	clearInterval(intervalo);
	var pos = e.pageX / $("body").width();
	if (pos > 0.7) {
		intervalo = setInterval(function () {
			var scroll = $("#listaProductos").data("plugin_tinyscrollbar");
			scroll.update(scroll.contentPosition + (pos - 0.7) / 0.3 * 10);
		}, 25);
	} else if (pos < 0.3) {
		intervalo = setInterval(function () {
			var scroll = $("#listaProductos").data("plugin_tinyscrollbar");
			scroll.update(scroll.contentPosition - (0.3 - pos) / 0.3 * 10);
		}, 25);
	}
}

function mostrarDetalleProducto(id) {
	cerrarDetalle();
	var detalleCadena = "<div class='detalleProducto cargando' itemscope itemtype='http://schema.org/Product'>\n\
				<meta itemprod='brand' content='Manjares de Casa' />\n\
				<div class='veladura'></div>\n\
				<div class='ventana'>\n\
					<div class='contenido'>\n\
						<div class='imagen'><img src='' itemprop='image'/></div>\n\
						<div class='detalle'>\n\
							<div class='nombre' itemprop='name'></div>\n\
							<div class='descripcion' itemprop='description'></div>\n\
							<div class = 'precio' itemprop = 'offers' itemscope itemtype = 'http://schema.org/Offer'>\n\
				<meta itemprop = 'priceCurrency' content = 'S/.' />\n\
				<div class = 'monto'>\n\
				<strong itemprop = 'price' > S/. </strong><span> el ciento. </span></div><div class = 'nota'> (Pedido mínimo 25 unidades) </div></div>\n\
				<div class='nota ocasiones'>Puedes encontrarlos en el menú de <a href='ocasiones-especiales'>ocasiones especiales</a>, en cajas de regalo.</div>\n\
							<div class='pieProducto'>\n\
								<div class='btn_pedir'>Pídelo aquí</div>\n\
							</div>\n\
						</div>\n\
						<div class='btn_cerrar'></div>\n\
					</div>\n\
				</div>\n\
			</div>";
	var detalle = $(detalleCadena);
	$("body").append(detalle);
	$(detalle).fadeIn(300);
	$.ajax({
		url: "js/ajax/detalleProducto.php",
		type: "GET",
		data: {
			id: id
		},
		cache: false
	}).done(function (responseText) {
		var response = eval("(" + responseText + ")");
		if (!response.exito) {
			cerrarDetalle();
			return false;
		}
		var producto = response.producto;
		$(detalle).find(".pieProducto").prepend("<div class='socials'>\n\
									<div class='pinterest'><a href='//www.pinterest.com/pin/create/button/?url=" + producto.urlEncode + "&media=" + producto.imagenGrandeEncode + "&description=" + producto.descripcionEncode + " data-pin-do='buttonPin' ><img src='//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png' style='border:none' /></a></div>\n\
				<div class='facebook'>\n\
				<div class='fb-like' data-href='" + producto.url + "' data-layout='button_count' data-action='like' data-show-faces='false' data-share='true'></div>\n\
				</div>\n\
				<div class='gplus'>\n\
				<div class='g-plusone' data-href='" + producto.url + "' data-size='medium' data-annotation='none'></div>\n\
			<script type='text/javascript'>\n\
			window.___gcfg = {lang: 'es'};\n\
			(function () {\n\
				var po = document.createElement('script');\n\
				po.type = 'text/javascript';\n\
				po.async = true;\n\
				po.src = 'https://apis.google.com/js/platform.js';\n\
				var s = document.getElementsByTagName('script')[0];\n\
				s.parentNode.insertBefore(po, s);\n\
			})();\n\
			</script>\n\
		</div>\n\
		<div class='twitter'><a href='https://twitter.com/share' class='twitter-share-button' data-dnt='true' data-count='none' data-url='" + producto.url + "' data-text='" + producto.twitter + "' data-lang='es' >Tweet</a></div>\n\
								</div>");
		if (!producto.precio) {
			$(detalle).find(".precio").remove();
		}
		if (!producto.ocaciones_especiales) {
			$(detalle).find(".ocasiones").remove();
		}
		$(detalle).find(".imagen img").attr("src", producto.imagen_grande).load(function () {
			$(detalle).removeClass("cargando");
		});
		;
		$(detalle).find(".detalle .nombre").text(producto.nombre);
		$(detalle).find(".detalle .descripcion").html(producto.descripcion);
		$(detalle).find(".detalle .precio .monto strong").text("S/." + producto.precio);
		FB.XFBML.parse();
		twttr.widgets.load();
		window.parsePinBtns();
		eventosDetalle();

		if (typeof ga != 'undefined') {
			ga('send', 'pageview', window.location.href);
		}
	}).fail(function (obj) {
		console.log(obj.statusText);
	});
}
function eventosDetalle() {
	if ($(".detalleProducto").length > 0) {
		$(".detalleProducto .btn_cerrar").click(function (e) {
			cerrarDetalle();
			window.history.pushState({url: host + "/" + categoria.nombre}, "", host + "/" + categoria.nombre);
		});
		$(".detalleProducto .veladura").click(function (e) {
			cerrarDetalle();
			window.history.pushState({url: host + "/" + categoria.nombre}, "", host + "/" + categoria.nombre);
		});
		$(".detalleProducto .btn_pedir").click(function (e) {
			cerrarDetalle();
			mostrarContacto($(".detalleProducto .contenido .detalle .nombre").text().replace(/(?:\r\n|\r|\n)/g, ' '));
			window.history.pushState({contacto: true});
		});
	}
}
function cerrarDetalle() {
	if ($(".detalleProducto").length > 0) {
		$(".detalleProducto").fadeOut({
			duration: 300,
			complete: function () {
				$(".detalleProducto").remove();
			}
		});
	}
}