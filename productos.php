<?
spl_autoload_register(function ($clase) {
	include_once 'cms/clases/' . str_replace("\\", "/", $clase) . '.php';
});
if (!empty($_GET["producto"])) {
	try {
		$producto = new Producto($_GET["producto"]);
		$categoria = new Categoria($producto->categoria->id);
	} catch (Exception $e) {
		header("Location: " . Utils::URL . "index.php");
	}
} else if (!empty($_GET["categoria"])) {
	$categoria = new Categoria($_GET["categoria"]);
} else {
	$categoria = new Categoria(1);
}
$listaProductos = Producto::todos($categoria);
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
		<? if (empty($producto->id)) { ?>
			<meta property="og:title" content="Manjares de Casa: <?= $categoria->nombre ?>" />
			<meta property="og:type" content="website" />
			<meta property="og:description" content="<?= $categoria->descripcion ?>" />
			<meta property="og:url" content="<?= Utils::URL ?><?= $categoria->url() ?>" />
			<meta property="og:image:url" content="<?= Utils::URL ?><?= $categoria->imagen ?>" />
			<meta property="og:image:width" content="1200" />
			<meta property="og:image:height" content="628" />
			<meta name="description" content="<?= $categoria->descripcion ?>" />
		<? } else { ?>
			<meta property="og:title" content="Manjares de Casa: <?= $producto->nombre ?>" />
			<meta property="og:type" content="product" />
			<meta property="og:description" content="<?= addslashes($producto->descripcion) ?>" />
			<meta property="product:product_link" content="<?= Utils::URL ?><?= Utils::getUrlName($producto->nombre) ?>/<?= $producto->id ?>" />
			<meta property="og:image:url" content="<?= Utils::URL ?>images/productos/<?= $producto->imagen_grande ?>" />
			<meta property="og:image:width" content="480" />
			<meta property="og:image:height" content="480" />
			<meta property="og:url" content="<?= Utils::URL . $categoria->url() . "/" . Utils::getUrlName(strtolower($producto->nombre)) . "/" . $producto->id ?>" />
			<meta name="description" content="<?= addslashes($producto->descripcion_social) ?>" />
			<meta property="og:site_name" content="Manjares de Casa" />
			<meta property="product:brand" content="Manjares de Casa" />
		<? } ?>
		<script src="<?= Utils::URL ?>js/jquery-2.1.3.min.js" type="text/javascript"></script>
		<script src="<?= Utils::URL ?>js/jquery.tinyscrollbar.js" type="text/javascript"></script>
		<script src="<?= Utils::URL ?>js/general.js" type="text/javascript"></script>
		<script src="<?= Utils::URL ?>js/productos.js" type="text/javascript"></script>
		<link href="<?= Utils::URL ?>css/general.css" rel="stylesheet" type="text/css"/>
		<link href="<?= Utils::URL ?>css/productos.css" rel="stylesheet" type="text/css"/>
		<title><?= (empty($producto->id) ? $categoria->nombre : $producto->nombre) . " - Manjares de Casa" ?></title>
		<script>
			var categoria = {
				id: <?= $categoria->id ?>,
				nombre: "<?= $categoria->url() ?>"
			};
			var producto = <?= json_encode($producto) ?>;
		</script>
		<? Dibujador::socialsAPI(); ?>
		<? Dibujador::analytics(); ?>
	</head>
	<body>
		<? Dibujador::apiFacebookJS(); ?>
		<? Dibujador::cabecera($categoria); ?>
		<? if (!empty($producto->id)) { ?>
			<div class="detalleProducto" itemscope itemtype="http://schema.org/Product">
				<meta itemprod="brand" content="Manjares de Casa" />
				<div class="veladura"></div>
				<div class="ventana">
					<div class="contenido">
						<div class="imagen"><img src="<?= Utils::URL . "images/productos/" . $producto->imagen_grande ?>" itemprop="image"/></div>
						<div class="detalle">
							<div class="nombre" itemprop="name"><?= $producto->nombre ?></div>
							<div class="descripcion" itemprop="description"><?= nl2br(str_replace("\t", "<span style='display:inline; white-space:pre;'>&#09;</span>", $producto->descripcion)) ?></div>
							<? if ($producto->precio) { ?>
								<div class="precio" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
									<meta itemprop="priceCurrency" content="S/."/>
									<div class="monto">
										<strong itemprop="price">S/. <? printf("%.2f", $producto->precio); ?></strong>
										<span>el ciento.</span>
									</div>
									<div class="nota">(Pedido mínimo 25 unidades)</div>
								</div>
							<? } ?>
							<? if ($producto->ocasiones_especiales) { ?>
								<div class="nota ocaciones">Puedes encontrarlos en el menú de <a href="ocasiones-especiales">ocasiones especiales</a>, en cajas de regalo.</div>
							<? } ?>
							<div class="pieProducto">
								<div class="socials">
									<div class="pinterest"><a href="//www.pinterest.com/pin/create/button/?url=<?= Utils::URL . $categoria->url() . "/" . Utils::getUrlName(strtolower($producto->nombre)) . "/" . $producto->id ?>&media=<?= urlencode(Utils::URL . "images/productos/" . $producto->imagen_previa) ?>&description=<?= urlencode($producto->descripcion) ?>" data-pin-do="buttonPin" ><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" style="border:none" /></a></div>
									<div class="facebook">
										<div class="fb-like" data-href="<?= Utils::URL . $categoria->url() . "/" . Utils::getUrlName(strtolower($producto->nombre)) . "/" . $producto->id ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
									</div>
									<div class="gplus"><!-- Inserta esta etiqueta donde quieras que aparezca Botón +1. -->
										<div class="g-plusone" data-href="<?= Utils::URL . $categoria->url() . "/" . Utils::getUrlName(strtolower($producto->nombre)) . "/" . $producto->id ?>" data-size="medium" data-annotation="none"></div>
										<!-- Inserta esta etiqueta después de la última etiqueta de Botón +1. -->
										<script type="text/javascript">
											window.___gcfg = {lang: 'es'};

											(function () {
												var po = document.createElement('script');
												po.type = 'text/javascript';
												po.async = true;
												po.src = 'https://apis.google.com/js/platform.js';
												var s = document.getElementsByTagName('script')[0];
												s.parentNode.insertBefore(po, s);
											})();
										</script>
									</div>
									<div class="twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-dnt="true" data-count="none" data-url="<?= Utils::URL . $categoria->url() . "/" . Utils::getUrlName(strtolower($producto->nombre)) . "/" . $producto->id ?>" data-text="<?= $producto->twitter ?>" data-lang="es" >Tweet</a></div>
								</div>
								<div class="btn_pedir">Pídelo aquí</div>
							</div>
						</div>
						<div class="btn_cerrar"></div>
					</div>
				</div>
			</div>
		<? } ?>
		<div class="listado">
			<div class="scroll" id="listaProductos">
				<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
				<div class="viewport">
					<div class="overview">
						<? foreach ($listaProductos as $producto) {
							?><a data-id="<?= $producto->id ?>" class="producto" href="<?= Utils::URL . $categoria->url() . "/" . Utils::getUrlName(strtolower($producto->nombre)) . "/" . $producto->id ?>"><span><?= $producto->nombre ?></span><img src="<?= Utils::URL . "images/productos/" . $producto->imagen_previa ?>" alt="<?= $producto->nombre ?>"/><div class="layer"></div></a><? }
						?>
					</div>
				</div>
			</div>
		</div>
		<? Dibujador::pie(); ?>
		<? Dibujador::contacto(); ?>
	</body>
</html>