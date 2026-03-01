<?

spl_autoload_register(function ($clase) {
	include_once 'clases/' . str_replace("\\", "/", $clase) . '.php';
});

$listaProductos = Producto::todos();

foreach ($listaProductos as $producto) {
//	if (file_exists("/home/kingsoft/www/test/ManjaresDeCasa/" . $producto->imagen_grande)) {
//		if (copy("/home/kingsoft/www/test/ManjaresDeCasa/" . $producto->imagen_grande, Utils::DIR_FOTOS . "/" . $producto->id . "_" . Utils::getUrlName($producto->nombre) . ".jpg")) {
//			echo "se copió correctamente la imagen grande";
//			$producto->imagen_grande = $producto->id . "_" . Utils::getUrlName($producto->nombre) . ".jpg";
//		}
//	}
//	if (file_exists("/home/kingsoft/www/test/ManjaresDeCasa/" . $producto->imagen_previa)) {
//		if (copy("/home/kingsoft/www/test/ManjaresDeCasa/" . $producto->imagen_previa, Utils::DIR_FOTOS . "/" . $producto->id . "_" . Utils::getUrlName($producto->nombre) . "_small.jpg")) {
//			echo "se copió correctamente la imagen previa";
//			$producto->imagen_previa = $producto->id . "_" . Utils::getUrlName($producto->nombre) . "_small.jpg";
//		}
//	}

	$cambios = false;

	if (file_exists("/home/jedebarbieri/www/manjaresdecasa/" . $producto->imagen_grande)) {
		if (copy("/home/jedebarbieri/www/manjaresdecasa/" . $producto->imagen_grande, Utils::DIR_FOTOS . "/manjares_de_casa_" . $producto->id . "_" . Utils::getUrlName($producto->nombre) . ".jpg")) {
			echo "se copió correctamente la imagen grande";
			$producto->imagen_grande = "manjares_de_casa_" . $producto->id . "_" . Utils::getUrlName($producto->nombre) . ".jpg";
			$cambios = true;
		}
	}
	if (file_exists("/home/jedebarbieri/www/manjaresdecasa/" . $producto->imagen_previa)) {
		if (copy("/home/jedebarbieri/www/manjaresdecasa/" . $producto->imagen_previa, Utils::DIR_FOTOS . "/manjares_de_casa_" . $producto->id . "_" . Utils::getUrlName($producto->nombre) . "_small.jpg")) {
			echo "se copió correctamente la imagen previa";
			$producto->imagen_previa = "manjares_de_casa_" . $producto->id . "_" . Utils::getUrlName($producto->nombre) . "_small.jpg";
			$cambios = true;
		}
	}

	if ($cambios) {
		$producto->guardarImagen(NULL, NULL);
	}
}
