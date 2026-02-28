<?
spl_autoload_register(function ($clase) {
	include_once 'clases/' . str_replace("\\", "/", $clase) . '.php';
});
session_start();

if (!isset($_SESSION["usuario"])) {
	header("Location: index.php?error=No ha iniciado sesión");
}
$mensaje = "";
try {
	try {
		$usuario = new Usuario($_GET["id"]);
	} catch (Exception $ex) {
		header("Location: usuarios.php?error=" . urlencode($ex->getMessage()));
	}
	if (!empty($_POST["modificar"])) {
		$usuario->nombre = $_POST["nombre"];
		$usuario->apellido = $_POST["apellido"];
		$usuario->email = $_POST["email"];
		$usuario->telefono = $_POST["telefono"];
		$usuario->direccion = $_POST["direccion"];
		$usuario->modificar();
		$mensaje = "Se modificó correctamente el usuario";
	}
	if (!empty($_GET["error"])) {
		$mensaje = $_GET["error"];
	}
} catch (Exception $e) {
	$mensaje = $e->getMessage();
}
if (!isset($_GET["id"])) {
	header("Location: usuarios.php?error=No seleccionó ningún usuario.");
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?= Utils::URL ?>/cms/styles.css" type="text/css" rel="stylesheet"/>
		<title>Modificar Usuario</title>
		<script language="javascript" type="text/javascript">
			function validar() {
				if (document.getElementById("nombre").value == "") {
					alert("Debe ingresar un nombre.");
					document.getElementById("nombre").focus();
					return false;
				}
				else if (document.getElementById("apellido").value == "") {
					alert("Debe ingresar un apellido.");
					document.getElementById("apellido").focus();
					return false;
				}
				else {
					return true;
				}
			}
		</script>
	</head>
	<body>
		<div id="principal">
			<?php
			Dibujador::menuPrincipal(NULL);
			?><br />
			<br />
			<br />
			<div class="mensajeError"><?= $mensaje ?></div>
			<form id="formulario" method="post" enctype="multipart/form-data" action="modificarusuario.php?id=<?= $usuario->id ?>">
				<table id="tabla">
					<tr>
						<td style="width:150px">Nombre:</td>
						<td><input type="text" id="nombre" name="nombre" class="cajaTexto" value="<?= $usuario->nombre ?>"/></td>
					</tr>
					<tr>
						<td style="width:150px">Apellido:</td>
						<td><input type="text" id="apellido" name="apellido" class="cajaTexto" value="<?= $usuario->apellido ?>"/></td>
					</tr>
					<tr>
						<td style="width:150px">Email:</td>
						<td><input type="text" id="email" name="email" class="cajaTexto" value="<?= $usuario->email ?>"/></td>
					</tr>
					<tr>
						<td style="width:150px">Teléfono:</td>
						<td><input type="text" id="telefono" name="telefono" class="cajaTexto" value="<?= $usuario->telefono ?>"/></td>
					</tr>
					<tr>
						<td style="width:150px">Dirección:</td>
						<td><input type="text" id="direccion" name="direccion" class="cajaTexto" style="width:300px" value="<?= $usuario->direccion ?>"/></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Guardar" class="boton" id="modificar" name="modificar" onclick="javascript: return validar();"/></td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>

