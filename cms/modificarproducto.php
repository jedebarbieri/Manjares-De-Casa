<?
spl_autoload_register(function ($clase) {
	include_once 'clases/' . str_replace("\\", "/", $clase) . '.php';
});
session_start();

if (!isset($_SESSION["usuario"])) {
	header("Location: index.php?error=No ha iniciado sesión");
}
try {
	$producto = new Producto($_GET["id"]);
	if ($producto->categoria->id > 5) {
		$producto->categoria = new Categoria($producto->categoria->id);
	}
	$listaCategorias = Categoria::todas(true);
	$listaSubcategorias = Categoria::todas(false);
	if (isset($_POST['modificar'])) {
		$producto->nombre = $_POST["nombre"];
		$producto->descripcion = $_POST["descripcion"];
		$producto->precio = $_POST["precio"] == "" ? null : $_POST["precio"];
		$producto->categoria = new Categoria($_POST['categoria'] >= 5 ? $_POST["subcategoria"] : $_POST["categoria"]);
		$producto->ocasiones_especiales = ($_POST["ocasiones"] ? true : false);
		$producto->descripcion_social = $_POST["descripcion_social"];
		$producto->twitter = $_POST["twitter"];
		$producto->keywords = $_POST["keywords"];
		$producto->modificar($_FILES["imagen_grande"], $_FILES["imagen_previa"]);
		$mensaje = "Se modificó correctamente el producto.";
	} else {
		$mensaje = $_GET["mensaje"];
	}
} catch (Exception $ex) {
	header("Location: productos.php?error=" . urlencode($ex->getMessage()) . "&categoria=" . $producto->categoria->id);
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?= Utils::URL ?>/cms/styles.css" type="text/css" rel="stylesheet"/>
		<title>Modificar Producto</title>
		<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
		<script language="javascript" type="text/javascript">
			$(document).ready(function (e) {
				$("#formulario").submit(function (e) {
					if (!$("#nombre").val()) {
						alert("Debe ingresar un nombre para el producto.");
						$("#nombre").focus();
						return false;
					}
					if (!$("#categoria").val()) {
						alert("Debe selecionar una categoría");
						$("#categoria").focus();
						return false;
					}
					if ($("#categoria").val() == 5 && !$("#subcategoria").val()) {
						alert("Debe seleccionar una subcategoría");
						$("#subcategoria").focus();
						return false;
					}
				});
				$("#categoria").change(function (e) {
					if ($("#categoria").val() < 5) {
						$("#filaSubCategoria").hide();
					}
					else {
						$("#filaSubCategoria").show();
					}
				})
			});
		</script>
	</head>
	<body>
		<div id="principal">
			<?php
			Dibujador::menuPrincipal($producto->categoria);
			?><br />
			<br />
			<br />
			<div class="mensajeError"><?= $mensaje ?></div>
			<form id="formulario" method="post" enctype="multipart/form-data" action="modificarproducto.php?id=<?= $producto->id ?>">
				<table>
					<tr>
						<td style="width:150px">Nombre:</td>
						<td><textarea id="nombre" name="nombre" class="cajaTexto" style="width:260px; height:100px"><?= $producto->nombre ?></textarea></td>
					</tr>
					<tr>
						<td style="width:150px">Descripci&oacute;n:</td>
						<td><textarea id="descripcion" name="descripcion" class="cajaTexto" style="width:260px; height:100px"><?= $producto->descripcion ?></textarea></td>
					</tr>
					<tr>
						<td style="width:150px">Imagen Grande:</td>
						<td>
							<? if (!empty($producto->imagen_grande)) { ?>
								<img src="../images/productos/<?= $producto->imagen_grande ?>" width="200" />
							<? } ?><br/>
							<input type="file" id="imagen_grande" name="imagen_grande" class="cajaTexto" style="width:300px; background-color:#FFF; font-size:10px; height:20px"/>
						</td>
					</tr>
					<tr>
						<td style="width:150px">Imagen Previa:</td>
						<td>
							<? if (!empty($producto->imagen_previa)) { ?>
								<img src="../images/productos/<?= $producto->imagen_previa ?>" width="200" />
							<? } ?><br/>
							<input type="file" id="imagen_previa" name="imagen_previa" class="cajaTexto" style="width:300px; background-color:#FFF; font-size:10px; height:20px" />
						</td>
					</tr>
					<tr>
						<td style="width:150px">Precio:</td>
						<td><input type="text" id="precio" name="precio" class="cajaTexto" value="<?= is_null($producto->precio) ? "" : $producto->precio ?>"/></td>
					</tr>
					<tr>
						<td style="width:150px" title="Indique el texto que aparecerá como descripción del producto al momento en que se comparta en alguna red social.">Descripción Social:</td>
						<td><textarea id="descripcion_social" name="descripcion_social" class="cajaTexto" style="width:260px; height:100px"><?= $producto->descripcion_social ?></textarea></td>
					</tr>
					<tr>
						<td style="width:150px" title="Indique el texto que aparecerá cuando se twittee el producto.">Texto Twitter:</td>
						<td><textarea id="twitter" name="twitter" class="cajaTexto" style="width:260px; height:100px"><?= $producto->twitter ?></textarea></td>
					</tr>
					<tr>
						<td style="width:150px" title="Escriba las palabras claves que definan al producto. Ayudará a posicionar mejor a los productos en la búsqueda de Google.">Keywords:</td>
						<td><textarea id="keywords" name="keywords" class="cajaTexto" style="width:260px; height:100px"><?= $producto->keywords ?></textarea></td>
					</tr>
					<tr>
						<td style="width:150px">Ocasiones Especiales:</td>
						<td><input type="checkbox" id="ocasiones" name="ocasiones" <?= $producto->ocasiones_especiales ? " checked=\"checked\"" : "" ?>/></td>
					</tr>
					<tr>
						<td style="width:150px">Categoría:</td>
						<td><select id="categoria" name="categoria" class="cajaTexto">
								<option value="0">Seleccionar...</option>
								<? foreach ($listaCategorias as $categoria) { ?>
									<option value="<?= $categoria->id ?>" <?= ($producto->categoria->id == $categoria->id || ($producto->categoria->super->id == $categoria->id)) ? "selected=\"selected\"" : "" ?>><?= $categoria->nombre ?></option>
								<? } ?>
							</select></td>
					</tr>
					<tr <?= ($producto->categoria->id <= 5) ? "style=\"display:none\"" : "" ?> id="filaSubCategoria">
						<td style="width:150px">Sub Categoría:</td>
						<td>
							<select id="subcategoria" name="subcategoria" class="cajaTexto">
								<option value="0">Seleccionar...</option>
								<? foreach ($listaSubcategorias as $categoria) { ?>
									<option value="<?= $categoria->id ?>" <?= ($producto->categoria->id == $categoria->id) ? "selected=\"selected\"" : "" ?>><?= $categoria->nombre ?></option>
								<? } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Guardar" class="boton" id="modificar" name="modificar"/></td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>

