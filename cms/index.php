<?
spl_autoload_register(function ($clase) {
	include_once 'clases/' . str_replace("\\", "/", $clase) . '.php';
});

use \Conexion;

if (isset($_SESSION)) {
	session_destroy();
}
session_start();
if (isset($_POST["usuario"])) {
	try {
		Conexion::validar($_POST["usuario"], $_POST["contrasena"]);
		$_SESSION["usuario"] = TRUE;
		header("Location: productos.php?categoria=1");
	} catch (Exception $e) {
		header("Location: index.php?error=" . $e->getMessage());
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?= Utils::URL ?>/cms/styles.css" type="text/css" rel="stylesheet"/>
		<title>CMS - Majares de Casa</title>
	</head>

	<body>
		<div id="principal">
			<img src="logo.jpg" id="logo"/>
			<h1>Sistema Administrador de Contenidos</h1>
			<p class="mensajeError"><?= $_GET['error'] ?></p>
			<div style="margin:auto; width:350px">
				<form method="post" action="index.php">
					<table>
						<tr>
							<td style="width:150px">
								Usuario:
							</td>
							<td>
								<input type="text" id="usuario" name="usuario" class="cajaTexto" />
							</td>
						</tr>
						<tr>
							<td>
								Contraseña:
							</td>
							<td>
								<input type="password" id="contrasena" name="contrasena" class="cajaTexto"/>
							</td>
						</tr>
						<tr>
							<td style="text-align:center" colspan="2">
								<input type="submit" class="boton" value="Entrar"/>
							</td>
						</tr>
				</form>
			</div>
		</div>
	</body>
</html>