<?
spl_autoload_register(function ($clase) {
	include_once 'cms/clases/' . str_replace("\\", "/", $clase) . '.php';
});
$categoria = new Categoria(5);
?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1">
		<meta name="p:domain_verify" content="fa21ad7d379abc8c674f7da208ba6dce"/>
		<meta name="google-site-verification" content="c1byoRVfUP8fnqXvlTEV9lQ7XslgrQx4Tq8DWAF242A" />
		<link rel="shortcut icon" href="<?= Utils::URL ?>images/icon_manjares_de_casa.png">
		<base href="<?= Utils::URL ?>" />
		<meta property="og:title" content="Manjares de Casa: Dulces y regalos para todas las ocaciones" />
		<meta property="og:type" content="website" />
		<meta property="og:description" content="El dulce ideal para cualquier ocasión: San Valentín, Día de la Madre, Día de la Secretaria, Navidad, Pascua, Día de la Mujer, Recuerdos, Día del Padre, etc." />
		<meta property="og:url" content="<?= Utils::URL ?>ocasiones-especiales" />
		<meta property="og:image" content="<?= Utils::URL ?>images/logo_manjares_de_casa_cuadrado.png" />
		<meta name="description" content="El dulce ideal para cualquier ocasión: San Valentín, Día de la Madre, Día de la Secretaria, Navidad, Pascua, Día de la Mujer, Recuerdos, Día del Padre, etc." />
		<script src="<?= Utils::URL ?>js/jquery-2.1.3.min.js" type="text/javascript"></script>
		<script src="<?= Utils::URL ?>js/jquery.tinyscrollbar.js" type="text/javascript"></script>
		<script src="<?= Utils::URL ?>js/general.js" type="text/javascript"></script>
		<link href="<?= Utils::URL ?>css/general.css" rel="stylesheet" type="text/css"/>
		<link href="<?= Utils::URL ?>css/ocasiones_especiales.css" rel="stylesheet" type="text/css"/>
		<title>Ocasiones Especiales - Manjares de Casa</title>
		<? Dibujador::analytics(); ?>
	</head>
	<body>
		<? Dibujador::apiFacebookJS(); ?>
		<? Dibujador::cabecera($categoria); ?>
		<div class="listado"><!--
			--><a href="<?= Utils::URL ?>san-valentin" class="san-valentin">san valentin</a><!--
			--><a href="<?= Utils::URL ?>dia-de-la-madre" class="dia-de-la-madre">día de la madre</a><!--
			--><a href="<?= Utils::URL ?>dia-de-la-secretaria" class="dia-de-la-secretaria">día de la secretaria</a><!--
			--><a href="<?= Utils::URL ?>navidad" class="navidad">navidad</a><!--
			--><a href="<?= Utils::URL ?>pascua" class="pascua">pascua</a><!--
			--><a href="<?= Utils::URL ?>dia-de-la-mujer" class="dia-de-la-mujer">día de la mujer</a><!--
			--><a href="<?= Utils::URL ?>recuerdos" class="recuerdos">recuerdos</a><!--
			--><a href="<?= Utils::URL ?>dia-del-padre" class="dia-del-padre">día del padre</a><!--
			--></div>
		<? Dibujador::pie(); ?>
		<? Dibujador::contacto(); ?>
	</body>
</html>