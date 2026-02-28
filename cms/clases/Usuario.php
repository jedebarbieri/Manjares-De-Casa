<?

class Usuario {

	public $id;
	public $nombre;
	public $apellido;
	public $direccion;
	public $email;
	public $telefono;

	public function __construct($id = NULL) {
		if (!empty($id)) {
			Conexion::conectar();

			Conexion::preparar_sentencia("SELECT * FROM usuarios WHERE id=?");
			Conexion::$sentencia->bind_param("i", $id);

			Conexion::ejecutar();

			if (Conexion::$sentencia->num_rows < 1) {
				throw new Exception("No se encontró el usuario.");
			}

			$resultado = Conexion::extraer_fila();
			$this->asignarDatos($resultado);
		}
	}

	public function seleccionarPorEmail($email) {
		Conexion::conectar();

		Conexion::preparar_sentencia("SELECT * FROM usuarios WHERE email like ?");
		$email = "%" . $email . "%";
		Conexion::$sentencia->bind_param("s", $email);

		Conexion::ejecutar();

		if (Conexion::$sentencia->num_rows < 1) {
			throw new Exception("No se encontró el usuario.");
		}

		$resultado = Conexion::extraer_fila();
		$this->asignarDatos($resultado);
	}

	public function asignarDatos($arreglo) {
		$this->id = $arreglo["id"];
		$this->nombre = $arreglo["nombre"];
		$this->apellido = $arreglo["apellido"];
		$this->direccion = $arreglo["direccion"];
		$this->email = strtolower($arreglo["email"]);
		$this->telefono = $arreglo["telefono"];
	}

	public static function todos() {
		Conexion::conectar();
		Conexion::preparar_sentencia("SELECT * FROM usuarios ORDER BY apellido, nombre");
		Conexion::ejecutar();
		$listaUsuarios = array();
		while ($fila = Conexion::extraer_fila()) {
			$usuario = new Usuario();
			$usuario->asignarDatos($fila);
			$listaUsuarios[] = $usuario;
		}
		return $listaUsuarios;
	}

	public function ingresar() {
		Conexion::conectar();
		Conexion::preparar_sentencia("
			INSERT INTO usuarios (nombre, apellido, direccion, email, telefono)
			VALUES (?,?,?,?,?)
		");
		Conexion::$sentencia->bind_param("sssss", $this->nombre, $this->apellido, $this->direccion, $this->email, $this->telefono);
		Conexion::ejecutar();
		$this->id = Conexion::$sentencia->insert_id;
	}

	public function modificar() {
		if (empty($this->id)) {
			throw new Exception("No se indicó el usuario a modificar. ");
		}
		Conexion::conectar();
		Conexion::preparar_sentencia("
			UPDATE usuarios
			SET
				nombre = ?,
				apellido = ?,
				direccion = ?,
				email = ?,
				telefono = ?
			WHERE id = ?
			");

		Conexion::$sentencia->bind_param("sssssi", $this->nombre, $this->apellido, $this->direccion, $this->email, $this->telefono, $this->id);
		Conexion::ejecutar();
	}

	public function eliminar() {
		if (empty($this->id)) {
			throw new Exception("No se indicó el usuario a eliminar. ");
		}
		Conexion::conectar();
		Conexion::preparar_sentencia("
			DELETE FROM usuarios
			WHERE id = ?
			");

		Conexion::$sentencia->bind_param("i", $this->id);
		Conexion::ejecutar();
	}

}
