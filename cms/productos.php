<?
spl_autoload_register(function ($clase) {
	include_once 'clases/' . str_replace("\\", "/", $clase) . '.php';
});

use \Dibujador;
use \Categoria;
use \Producto;

session_start();

if (!isset($_SESSION["usuario"])) {
	header("Location: index.php?error=No ha iniciado sesión");
}
try {
	if (isset($_GET['categoria'])) {
		$categoria = new Categoria($_GET['categoria']);
	} else {
		$categoria = new Categoria(1);
	}
	if (isset($_GET['eliminar'])) {
		$producto = new Producto($_GET["eliminar"]);
		$producto->eliminar();
	}

	$listaProductos = Producto::todos($categoria);
	$mensaje = $_GET["error"];
} catch (Exception $e) {
	$mensaje = $e->getMessage();
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="styles.css" type="text/css" rel="stylesheet"/>
		<title><?= $categoria->nombre ?></title>
	</head>
	<script language="javascript" type="text/javascript">
		function confirmarEliminar(numero) {
			if (confirm("¿Seguro que desea eliminar este producto?")) {
				window.location = "productos.php?eliminar=" + numero + "&categoria=<?= $categoria->id ?>";
			}
		}
	</script>
	<body>
		<div id="principal">
			<?
			Dibujador::menuPrincipal($categoria);
			?>
			<div class="mensajeError"><?= $mensaje ?></div>
			<div id="submenu">
				<a href="nuevoproducto.php?categoria=<?= $categoria->id ?>"><p>[+] Agregar Producto</p></a>
			</div>
			<?
			foreach ($listaProductos as $pro) {
				?>
				<div class="cuadroProducto">
					<img src="<?= Utils::URL . "images/productos/" . $pro->imagen_previa ?>" />
					<div class="nombreProducto"><?= $pro->nombre ?></div>
					<div class="descripcionProducto"><?= nl2br($pro->descripcion) ?></div>
					<div class="precioProducto"><?= !is_null($pro->precio) ? sprintf("S/. %.2f", $pro->precio) : "Sin precio" ?></div>
					<div class="opcionesProducto"><a href="modificarproducto.php?id=<?= $pro->id ?>">[Modificar]</a> <a href="javascript:confirmarEliminar(<?= $pro->id ?>)">[Eliminar]</a></div>
				</div>
				<?
			}
			?>
		</div>
	</body>
</html>

