<?

class Producto {

	public $id;
	public $nombre;
	public $descripcion;

	/**
	 * @var string Nombre del archivo de imagen grande del producto. No incluye el path
	 */
	public $imagen_previa;

	/**
	 * @var string Nombre del archivo de imagen previa del producto. No incluye el path
	 */
	public $imagen_grande;
	public $precio;

	/**
	 * @var Categoria
	 */
	public $categoria;

	/**
	 * @var bool Indica si es o no un producto del tipo "ocasiones especiales"
	 */
	public $ocasiones_especiales;

	/**
	 * @var string Texto que se pondrá al momento de compartir con opengraph
	 */
	public $descripcion_social;

	/**
	 * @var string Texto para twittear
	 */
	public $twitter;

	/**
	 * @var string Palabras claves del producto separadas por comas.
	 */
	public $keywords;

	public function __construct($id = NULL) {
		if (!empty($id)) {
			Conexion::conectar();

			Conexion::preparar_sentencia("SELECT * FROM producto WHERE id=?");
			Conexion::$sentencia->bind_param("i", $id);

			Conexion::ejecutar();

			if (Conexion::$sentencia->num_rows < 1) {
				throw new Exception("No se encontró el producto.");
			}

			$resultado = Conexion::extraer_fila();
			$this->asignarDatos($resultado);
		}
	}

	public function asignarDatos($arreglo) {
		$this->id = $arreglo["id"];
		$this->nombre = $arreglo["nombre"];
		$this->descripcion = $arreglo["descripcion"];
		$this->imagen_previa = $arreglo["imagen_previa"];
		$this->imagen_grande = $arreglo["imagen_grande"];
		$this->precio = $arreglo["precio"];
		$this->ocasiones_especiales = $arreglo["ocasiones_especiales"];
		if (!empty($arreglo["categoria"])) {
			$this->categoria = new Categoria();
			$this->categoria->id = $arreglo["categoria"];
		}
		$this->descripcion_social = $arreglo["descripcion_social"];
		$this->twitter = $arreglo["twitter"];
		$this->keywords = $arreglo["keywords"];
	}

	public static function todos(Categoria $categoria = NULL) {
		Conexion::conectar();
		if (!empty($categoria->id)) {
			Conexion::preparar_sentencia("
				SELECT p.*
				FROM producto p LEFT JOIN categoria c ON c.id = p.categoria
				WHERE p.categoria=? OR c.super = ? ORDER BY p.nombre
			");
			Conexion::$sentencia->bind_param("ii", $categoria->id, $categoria->id);
		} else {
			Conexion::preparar_sentencia("
				SELECT *
				FROM producto
				ORDER BY nombre
			");
		}
		Conexion::ejecutar();
		$listaProductos = array();
		while ($fila = Conexion::extraer_fila()) {
			$producto = new Producto();
			$producto->asignarDatos($fila);
			$listaProductos[$producto->id] = $producto;
		}
		return $listaProductos;
	}

	public function guardarImagen($imagenGrande = NULL, $imagenPrevia = NULL) {
		if (!empty($imagenGrande["name"])) {
			if (file_exists(Utils::DIR_FOTOS . "/" . $this->imagen_grande) && !empty($this->imagen_grande)) {
				unlink(Utils::DIR_FOTOS . "/" . $this->imagen_grande);
			}
			if (!@move_uploaded_file($imagenGrande["tmp_name"], Utils::DIR_FOTOS . "/manjares_de_casa_" . $this->id . "_" . Utils::getUrlName($this->nombre) . ".jpg")) {
				throw new Exception("No se pudo copiar la imagen grande del producto.");
			}
			$this->imagen_grande = "manjares_de_casa_" . $this->id . "_" . Utils::getUrlName($this->nombre) . ".jpg";
		}
		if (!empty($imagenPrevia["name"])) {
			if (file_exists(Utils::DIR_FOTOS . "/" . $this->imagen_previa) && !empty($this->imagen_previa)) {
				unlink(Utils::DIR_FOTOS . "/" . $this->imagen_previa);
			}
			if (!@move_uploaded_file($imagenPrevia["tmp_name"], Utils::DIR_FOTOS . "/manjares_de_casa_" . $this->id . "_" . Utils::getUrlName($this->nombre) . "_small.jpg")) {
				throw new Exception("No se pudo copiar la imagen previa del producto.");
			}
			$this->imagen_previa = "manjares_de_casa_" . $this->id . "_" . Utils::getUrlName($this->nombre) . "_small.jpg";
		}

		Conexion::conectar();
		Conexion::preparar_sentencia("
			UPDATE producto
			SET
				imagen_previa = ?,
				imagen_grande = ?
			WHERE id = ?
			");

		Conexion::$sentencia->bind_param("ssi", $this->imagen_previa, $this->imagen_grande, $this->id);
		Conexion::ejecutar();
	}

	public function ingresar($imagenGrande = NULL, $imagenPrevia = NULL) {
		Conexion::conectar();
		Conexion::preparar_sentencia("
			INSERT INTO producto
			(nombre, descripcion, precio, categoria, ocasiones_especiales, descripcion_social, twitter, keywords)
			VALUES
			(?,?,?,?,?,?,?,?)
			");
		Conexion::$sentencia->bind_param("ssdiisss", $this->nombre, $this->descripcion, $this->precio, $this->categoria->id, $this->ocasiones_especiales, $this->descripcion_social, $this->twitter, $this->keywords);
		Conexion::ejecutar();
		$this->id = Conexion::$sentencia->insert_id;
		$this->guardarImagen($imagenGrande, $imagenPrevia);
	}

	public function modificar($imagenGrande = NULL, $imagenPrevia = NULL) {
		if (empty($this->id)) {
			throw new Exception("No se indicó el producto a modificar. ");
		}

		Conexion::conectar();
		Conexion::preparar_sentencia("
			UPDATE producto
			SET
				nombre = ?,
				descripcion = ?,
				precio = ?,
				categoria = ?,
				ocasiones_especiales = ?,
				descripcion_social = ?,
				twitter = ?,
				keywords = ?
			WHERE id = ?
			");

		Conexion::$sentencia->bind_param("ssdiisssi", $this->nombre, $this->descripcion, $this->precio, $this->categoria->id, $this->ocasiones_especiales, $this->descripcion_social, $this->twitter, $this->keywords, $this->id);
		Conexion::ejecutar();

		$this->guardarImagen($imagenGrande, $imagenPrevia);
	}

	public function eliminar() {
		if (empty($this->id)) {
			throw new Exception("No se indicó el producto a modificar. ");
		}

		Conexion::conectar();
		Conexion::preparar_sentencia("DELETE FROM producto WHERE id = ?");
		Conexion::$sentencia->bind_param("i", $this->id);
		Conexion::ejecutar();

		if (file_exists(Utils::DIR_FOTOS . "/" . $this->imagen_grande)) {
			@unlink(Utils::DIR_FOTOS . "/" . $this->imagen_grande);
		}
		if (file_exists(Utils::DIR_FOTOS . "/" . $this->imagen_previa)) {
			@unlink(Utils::DIR_FOTOS . "/" . $this->imagen_previa);
		}
	}

}
