<?
spl_autoload_register(function ($clase) {
	include_once 'clases/' . str_replace("\\", "/", $clase) . '.php';
});

session_start();

if (!isset($_SESSION["usuario"])) {
	header("Location: index.php?error=No ha iniciado sesión");
}

try {
	if (isset($_GET['eliminar'])) {
		$usuario = new Usuario($_GET['eliminar']);
		$usuario->eliminar();
	}
	$listaUsuarios = Usuario::todos();
} catch (Exception $e) {
	$mensaje = $e->getMessage();
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?= Utils::URL ?>/cms/styles.css" type="text/css" rel="stylesheet"/>
		<title>Usuarios</title>
	</head>
	<script language="javascript" type="text/javascript">
		function confirmarEliminar(numero) {
			if (confirm("Seguro que desea eliminar este usuario?")) {
				window.location = "usuarios.php?eliminar=" + numero;
			}
		}
	</script>
	<body>
		<div id="principal">
			<?php
			Dibujador::menuPrincipal();
			?>
			<div class="mensajeError"><?= $mensaje ?></div>
			<div id="submenu">
				<a href="nuevousuario.php"><p>[+] Agregar Usuario</p></a>
			</div>
			<div class="lista">
				<? foreach ($listaUsuarios as $usuario) { ?>
					<div class="cuadroUsuario">
						<div class="nombreUsuario"><?= $usuario->nombre . " " . $usuario->apellido ?></div>
						<div class="descripcionUsuario"><?= $usuario->email ?></div>
						<div class="descripcionUsuario"><?= $usuario->direccion ?></div>
						<div class="descripcionUsuario"><?= $usuario->telefono ?></div>
						<div class="opcionesUsuario"><a href="modificarusuario.php?id=<?= $usuario->id ?>">[Modificar]</a> <a href="javascript:confirmarEliminar(<?= $usuario->id ?>)">[Eliminar]</a></div>
					</div>
				<? } ?>
			</div>
		</div>
	</body>
</html>

