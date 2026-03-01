<?

abstract class Conexion {

//	PRODUCCIÓN
	const NOMBRE_BD = "jedebarbieri_manjares_catalogo";
	const HOST = "localhost";

	private static $USER = "adriana";
	private static $PASSWORD = "****";

//	DESARROLLO REMOTO
//	const NOMBRE_BD = "kingsoft_manjares";
//	const HOST = "localhost";
//	
//	private static $USER = "webuser";
//	private static $PASSWORD = "avengers";
//
// Constantes generales
	const MYSQL_CODE_DUPLICATE_KEY = 1062;
	const MYSQL_CODE_PARENT_NOT_EXIST = 1452;

	/**
	 * @var mysqli
	 */
	public static $conexion;

	/**
	 * @var mysqli_stmt
	 */
	public static $sentencia;
	public static $query;
	public static $mensaje_error;

	public static function conectar() {
		if (empty(self::$conexion)) {
			self::$conexion = new mysqli(self::HOST, self::$USER, self::$PASSWORD, self::NOMBRE_BD);
			if (mysqli_connect_error()) {
				throw new Exception("Error conectando a la base de datos. (" . mysqli_connect_errno() . ": " . mysqli_connect_error());
			} else {
				self::$conexion->set_charset("utf8");
				date_default_timezone_set(Utils::DEFAULT_TIMEZONE);
				return self::$conexion;
			}
		}
	}

	public static function preparar_sentencia($query_str) {
		self::$query = $query_str;
		if (!(self::$sentencia = self::$conexion->prepare($query_str))) {
			throw new Exception("Error al crear la sentencia: " . $query_str);
		}
	}

	public static function ejecutar() {
		/* ejecuta la sentencia. Si hay error lo coloca en $mensaje_error */

		if (!self::$sentencia->execute()) {
			self::$mensaje_error = self::$sentencia->error;
			self::$sentencia->close();
			//self::$conexion->close();
			throw new Exception("Error en la sentencia.<br/>" . self::$mensaje_error);
		}
		self::$sentencia->store_result();
	}

	public static function cerrar() {
		@self::$sentencia->close();
		/* No se cierra la conexión para optimizar recursos... Se cierra la conexión en el destructor */
		//self::$conexion->close();
	}

	public function __destruct() {
		self::$conexion->close();
	}

	public static function extraer_fila() {
		/*
		 *  Devuelve un arreglo asociativo con el nombre de la columna y el valor
		 */
		$columnas = self::$sentencia->result_metadata()->fetch_fields();
		$filaArreglo = array();
		$filaReferencias = array();

		/*
		 * Creamos un arreglo con los espacios para almacenar las variables y con los "keys" respectivos
		 * Además creamos un arreglo con las referencias a cada celda del anterior arreglo.
		 */
		foreach ($columnas as $col) {
			$filaArreglo[$col->name] = NULL;
			$filaReferencias[$col->name] = &$filaArreglo[$col->name];
		}

		/*
		 * Para cada valor del arreglo de referencias, ejecutamos la función bind_result
		 */
		call_user_func_array(array(self::$sentencia, "bind_result"), $filaReferencias);

		/*
		 * Cogemos los datos de la fila en el arreglo filaArreglo y el éxito se asigna a retorno
		 */
		$retorno = self::$sentencia->fetch();

		if ($retorno) {
			return $filaArreglo;
		} else {
			return $retorno;
		}
	}

	/**
	 * Se encarga de verificar si el usuario y contraseña ingresados son válidos para la base de datos.
	 * @param type $usuario
	 * @param type $password
	 * @throws Exception
	 */
	public static function validar($usuario, $password) {
		$link = null;
		if ($link = @mysql_connect(self::HOST, $usuario, $password)) {
			if (!@mysql_select_db(self::NOMBRE_BD, $link)) {
				throw new Exception("Error conectando a la base de datos...");
			}
		} else {
			throw new Exception("Usuario o clave incorrecta");
		}
	}

}

?>