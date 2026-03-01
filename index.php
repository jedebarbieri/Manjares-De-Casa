<?
spl_autoload_register(function ($clase) {
	include_once 'cms/clases/' . str_replace("\\", "/", $clase) . '.php';
});
?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1">
		<script src="js/jquery-2.1.3.min.js" type="text/javascript"></script>
		<script src="js/index.js" type="text/javascript"></script>
		<base href="<?= Utils::URL ?>" />
		<meta name="p:domain_verify" content="fa21ad7d379abc8c674f7da208ba6dce"/>
		<meta property="og:title" content="Manjares de Casa" />
		<meta property="og:type" content="website" />
		<meta property="og:description" content="Tenemos un producto especial, hecho en casa, para el evento que tienes en mente: trufas, cupcakes, marquezas, manjarcitos, barquillos, galletas y chocolates en direntes presentaciones... Pídelos aquí." />
		<meta property="og:url" content="<?= Utils::URL ?>" />
		<meta property="og:image" content="<?= Utils::URL ?>images/logo_manjares_de_casa_cuadrado.png" />
		<meta name="google-site-verification" content="c1byoRVfUP8fnqXvlTEV9lQ7XslgrQx4Tq8DWAF242A" />
		<meta name="description" content="Un universo de sabores y texturas... explora y descubre, tu manjar favorito. Trufas, manás, marquezas, manjarcitos, barquillos, galletas y chocolates en diferentes presentaciones para que puedas hacer un dulce detalle. Pedidos al 2243021 o al 993488105 Adriana Cárpena" />
		<meta name="keywords" content="adriana cárpena, trufas de chocolate, chocochips, cachitos de nueces del brasil, brownies, manjarcitos, marquezas con coco, bolitas de nuez, encanelados, alfajores bañados en chocolate, pecanas con manjar y chocolate, guarpagueros, alfajores, pirotines de chocolate blanco o bitter con limón, lúcuma, maracuyá, suspiro limeño o mousse de chocolate, manás, manás con canela, bombones surtidos [blanco, leche, bitter, manjarcito, mazapán, crema de avellanas, praliné]..." />
		<link rel="shortcut icon" href="<?= Utils::URL ?>images/icon_manjares_de_casa.png">
		<link href="<?= Utils::URL ?>css/general.css" rel="stylesheet" type="text/css"/>
		<link href="<?= Utils::URL ?>css/index.css" rel="stylesheet" type="text/css"/>
		<title>Manjares de Casa : Dulces | Trufas de Chocolate | Galletas y Barquillos | Cupcakes y Kekes | Ocasiones Especiales</title>
		<? Dibujador::analytics(); ?>
	</head>
	<body>
		<? Dibujador::apiFacebookJS(); ?>
		<div class="banners">
			<div class="imagen" style="background-image: url(images/imagen5.jpg)"></div>
			<div class="imagen" style="background-image: url(images/imagen4.jpg)"></div>
			<div class="imagen" style="background-image: url(images/imagen3.jpg)"></div>
			<div class="imagen" style="background-image: url(images/imagen2.jpg)"></div>
			<div class="imagen" style="background-image: url(images/imagen1.jpg)"></div>
		</div>
		<div class="contenido">
			<h1 class="logo">Manjares de Casa</h1>
			<div class="menu">
				<nav>
					<a href="dulces">dulces</a>
					<a href="trufas-de-chocolate">trufas de chocolate</a>
					<a href="galletas-y-barquillos">galletas y barquillos</a>
					<a href="cupcakes-y-kekes">cupcakes y kekes</a>
					<a href="ocasiones_especiales">ocasiones especiales</a>
				</nav>
				<div class="socials">
					<a class="pinterest" href="https://www.pinterest.com/manjaresdecasa/" target="_blank">Pinterest</a>
					<a class="facebook" href="https://www.facebook.com/ManjaresDeCasa" target="_blank">Facebook</a>
					<a class="gplus" href="https://plus.google.com/+Manjaresdecasa_dulces/" target="_blank">Google+</a>
					<a class="twitter" href="https://twitter.com/Manjaresdecasa/" target="_blank">Twitter</a>
				</div>
			</div>
			<div class="contactos">
				<div class="telefonos"><a href="tel:+5112663848" title="Tienda">2663848</a> / <a href="tel:+51993488105" title="Celular">993488105</a></div>
				<a class="direccion" href="https://www.google.com.pe/maps/search/Av.+Benavides+4534+-+Surco/@-12.1281202,-76.9893711,17z/data=!3m1!4b1?hl=es-419" target="_blank">Av. Benavides 4534 - Surco</a>
			</div>
		</div>
	</body>
</html>
