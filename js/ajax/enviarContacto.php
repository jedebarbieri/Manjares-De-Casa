<?

spl_autoload_register(function ($clase) {
	include_once '../../cms/clases/' . str_replace("\\", "/", $clase) . '.php';
});
$exito = true;
try {
	try {
		$usuario = new Usuario();
		$usuario->seleccionarPorEmail($_POST["email"]);
	} catch (Exception $e) {
		$usuario->nombre = $_POST["nombre"];
		$usuario->email = strtolower($_POST["email"]);
		$usuario->telefono = $_POST["telefono"];
		$usuario->ingresar();
	}
	$mail = new PHPMailer();
	$mail->addAddress("adriana@manajaresdecasa.com");
	$mail->addReplyTo($usuario->email, $usuario->nombre);
	$mail->Subject = $usuario->nombre . " te ha enviado un mensaje.";

	$mail->Body = '
	<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
		<body>
			<br/>
			<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
			De: ' . $usuario->nombre . ' &lt;' . $usuario->email . '&gt;<br/>
			Teléfono: ' . $usuario->telefono . '
			<br/><br>
			' . nl2br($_POST["consultas"]) . '
			<br/><br/><br/>
			</span>
			<span style="font-family:Arial, Helvetica, sans-serif; font-size:9px">
			Email enviado desde la sección CONTACTO
			</span>
		</body>
	</html>';
	if (!$mail->send()) {
		throw new Exception($mail->ErrorInfo);
	}
} catch (Exception $e) {
	$exito = false;
	$mensaje = $e->getMessage();
	unset($usuario);
}
$ajaxObj = array(
	"exito" => $exito,
	"mensaje" => $mensaje,
	"usuario" => $usuario
);
echo json_encode($ajaxObj);
