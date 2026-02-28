<?
spl_autoload_register(function ($clase) {
	include_once 'cms/clases/' . str_replace("\\", "/", $clase) . '.php';
});
$listaProductos = Producto::todos();
foreach ($listaProductos as $prod) {
	$prod->categoria = new Categoria($prod->categoria->id);
}
?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1">
		<meta name="p:domain_verify" content="fa21ad7d379abc8c674f7da208ba6dce"/>
		<meta name="google-site-verification" content="c1byoRVfUP8fnqXvlTEV9lQ7XslgrQx4Tq8DWAF242A" />
		<link rel="shortcut icon" href="<?= Utils::URL ?>images/icon_manjares_de_casa.png">
		<base href="<?= Utils::URL ?>" />
		<meta property="fb:app_id" content="808184405902642" />
		<meta property="fb:admins" content="718297922" />
		<meta property="og:title" content="Manjares de Casa: Lista de precios" />
		<meta property="og:type" content="website" />
		<meta property="og:description" content="Pedidos por ciento, x50 o x25. Tenemos un producto especial, hecho en casa, para el evento que tienes en mente: trufas, cupcakes, marquezas, manjarcitos, barquillos, galletas y chocolates en direntes presentaciones... Pídelos aquí." />
		<meta property="og:url" content="<?= Utils::URL ?>" />
		<meta property="og:image" content="<?= Utils::URL ?>images/logo_manjares_de_casa_cuadrado.png" />
		<meta name="description" content="Pedidos por ciento, x50 o x25. Tenemos un producto especial, hecho en casa, para el evento que tienes en mente: trufas, cupcakes, marquezas, manjarcitos, barquillos, galletas y chocolates en direntes presentaciones... Pídelos aquí." />
		<script src="js/jquery-2.1.3.min.js" type="text/javascript"></script>
		<script src="js/general.js" type="text/javascript"></script>
		<script src="js/lista_precios.js" type="text/javascript"></script>
		<link href="css/general.css" rel="stylesheet" type="text/css"/>
		<link href="css/lista_precios.css" rel="stylesheet" type="text/css"/>
		<title>Lista de Precios - Manjares de Casa</title>
		<? Dibujador::socialsAPI(); ?>
		<? Dibujador::analytics(); ?>
	</head>
	<body>
		<? Dibujador::apiFacebookJS(); ?>
		<? Dibujador::cabecera(NULL, true); ?>
		<h2>Lista de precios</h2>
		<h3>Manjares de Casa</h3>
		<div class="listado">
			<table>
				<thead>
				<td>Nombre</td>
                <td>x100</td>
                <td>x50</td>
                <td>x25</td>
				</thead><?
				foreach ($listaProductos as $prod) {
					if ($prod->precio) {
						?>
						<tr>
							<td class="nombre"><a href="<?= Utils::URL . $prod->categoria->url() . "/" . Utils::getUrlName(strtolower($prod->nombre)) . "/" . $prod->id ?>"><?= $prod->nombre ?></a></td>
							<td class="precio">S/. <?= number_format($prod->precio, 2) ?></td>
							<td class="precio">S/. <?= number_format(ceil($prod->precio / 2), 2) ?></td>
							<td class="precio">S/. <?= number_format(ceil($prod->precio / 4), 2) ?></td>
						</tr><?
					}
				}
				?>
			</table>
		</div>
		<div class="comandos">
			<div class="imprimir"></div>
			<a class="guardar" href="<?= Utils::URL ?>listado_precios_CSV.php"></a>
		</div>
		<? Dibujador::pie(true); ?>
		<? Dibujador::contacto(); ?>
	</body>
</html>