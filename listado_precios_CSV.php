<?
spl_autoload_register(function ($clase) {
	include_once 'cms/clases/' . str_replace("\\", "/", $clase) . '.php';
});
$listaProductos = Producto::todos();
header("Content-disposition: attachment; filename=Listado_de_precios-Manjares_de_casa.csv");
header('Content-Type: text/csv; charset=utf-8');
header('Content-Description: File Transfer');
?>Nombre, x100, x50, x25
<?
foreach ($listaProductos as $prod) {
	if ($prod->precio) {
		echo "\"" . utf8_decode($prod->nombre) . "\",S/." . number_format($prod->precio, 2) . ", S/." . number_format(ceil($prod->precio / 2), 2) . ",S/." . number_format(ceil($prod->precio / 4), 2) . "\n";
	}
}
?>