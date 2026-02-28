<?

spl_autoload_register(function ($clase) {
	include_once '../../cms/clases/' . str_replace("\\", "/", $clase) . '.php';
});

$exito = true;
$mensaje = "";
try {
	if (empty($_GET["id"])) {
		throw new Exception("No se indicó el producto.");
	}
	$producto = new Producto($_GET["id"]);
	$producto->categoria = new Categoria($producto->categoria->id);
	$producto->url = Utils::URL . $producto->categoria->url() . "/" . Utils::getUrlName(strtolower($producto->nombre)) . "/" . $producto->id;
	$producto->urlEncode = urlencode($producto->url);
	$producto->descripcionEncode = urlencode($producto->descripcion);
	$producto->imagenGrandeEncode = urlencode(Utils::URL . "images/productos/" . $producto->imagen_grande);
	$producto->imagen_grande = Utils::URL . "images/productos/" . $producto->imagen_grande;
	$producto->imagen_previa = Utils::URL . "images/productos/" . $producto->imagen_previa;
	$producto->precio = !is_null($producto->precio) ? sprintf("%.2f", $producto->precio) : "";
	$producto->twitter = empty($producto->twitter) ? str_replace(array("\t", "\n", "\r"), " ", $producto->descripcion) : $producto->twitter;
	$producto->descripcion = nl2br(str_replace("\t", "<span style='display:inline; white-space:pre;'>&#09;</span>", $producto->descripcion));
} catch (Exception $e) {
	$exito = false;
	$mensaje = $e->getMessage();
	unset($producto);
}
$ajaxObj = array(
	"exito" => $exito,
	"mensaje" => $mensaje,
	"producto" => $producto
);
echo json_encode($ajaxObj);
