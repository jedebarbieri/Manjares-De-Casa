<?

use \Conexion;

class Categoria {

	public $id;
	public $nombre;
	public $categoria;
	public $descripcion;
	public $imagen;

	/**
	 * @var Categoria Indica la categoría padre
	 */
	public $super;

	public function __construct($id = NULL) {
		if (!empty($id)) {
			Conexion::conectar();

			Conexion::preparar_sentencia("SELECT * FROM categoria WHERE id=?");
			Conexion::$sentencia->bind_param("i", $id);

			Conexion::ejecutar();

			if (Conexion::$sentencia->num_rows < 1) {
				throw new Exception("No se encontró la categoría.");
			}

			$resultado = Conexion::extraer_fila();
			$this->asignarDatos($resultado);
		}
	}

	public function asignarDatos($arreglo) {
		$this->id = $arreglo["id"];
		$this->nombre = $arreglo["nombre"];
		$this->categoria = $arreglo["categoria"];
		$this->descripcion = $arreglo["descripcion"];
		$this->imagen = $arreglo["imagen"];
		if (!empty($arreglo["super"])) {
			$this->super = new Categoria();
			$this->super->id = $arreglo["super"];
		}
	}

	/**
	 * Devuelve un listado de categorías. Si $pricipales es true, devuelve las que no tienen super categoría
	 * @param bool $principales Indica si se debe devolver las categorías principales
	 */
	public static function todas($principales = true) {
		Conexion::conectar();
		if ($principales) {
			Conexion::preparar_sentencia("SELECT * FROM categoria WHERE super IS NULL");
		} else {
			Conexion::preparar_sentencia("SELECT * FROM categoria WHERE super IS NOT NULL");
		}
		Conexion::ejecutar();
		$categorias = array();
		while ($fila = Conexion::extraer_fila()) {
			$categoria = new Categoria();
			$categoria->asignarDatos($fila);
			$categorias[] = $categoria;
		}
		return $categorias;
	}

	/**
	 * Devuelve un string con el nombre de la categoría para poner en la URL
	 */
	public function url() {
		$nombreUrl = str_replace(" ", "-", $this->nombre);
		return Utils::getUrlName(strtolower($nombreUrl));
	}

}
