<?

class Utils {

	const PRODUCCION = true;
	const DEFAULT_TIMEZONE = "America/Lima";
//	PRODUCCIÓN
	const URL = "https://manjaresdecasa.jedebarbieri.dev/";
	const DIR_FOTOS = "/home/jedebarbieri/www/manjaresdecasa/images/productos";

//	DESARROLLO REMOTO
//	const DIR_FOTOS = "/home/kingsoft/www/test/ManjaresDeCasa/images/productos";
//	const URL = "http://test.kingsoft.pe/ManjaresDeCasa/";

	/**
	 * Devuelve una cadena Json que se utilizará para un combobox
	 * @param array $arreglo Es la lista de los objetos
	 * @param string $value Es el nombre del atributo del objeto que se utilizará como value
	 * @param string $display Es el nombre del atributo del objeto que se utilizará como display
	 * @return string
	 */
	public static function jsonCombo($arreglo, $value, $display) {
		$ajaxObj = array();
		foreach ($arreglo as $obj) {
			$ajaxObj[] = array(
				"value" => $obj->$value,
				"display" => $obj->$display
			);
		}
		return json_encode($ajaxObj);
	}

	public static function getDiaCorto($numberOfDay) {
		$array = array(
			1 => "dom",
			2 => "lun",
			3 => "mar",
			4 => "mie",
			5 => "jue",
			6 => "vie",
			7 => "sab"
		);
		return $array[$numberOfDay];
	}

	public static function getDiaCompleto($numberOfDay) {
		$array = array(
			1 => "Domingo",
			2 => "Lunes",
			3 => "Martes",
			4 => "Miércoles",
			5 => "Jueves",
			6 => "Viernes",
			7 => "Sábado"
		);
		return $array[$numberOfDay];
	}

	public static function getMesCorto($numberOfMonth) {
		$array = array(
			1 => "ene",
			2 => "feb",
			3 => "mar",
			4 => "abr",
			5 => "may",
			6 => "jun",
			7 => "jul",
			8 => "ago",
			9 => "sep",
			10 => "oct",
			11 => "nov",
			12 => "dic"
		);
		return $array[$numberOfMonth];
	}

	public static function getFechaCorta(DateTime $date = NULL, $separacion = "-") {
		if (!empty($date) && ($date instanceof DateTime)) {
			return $date->format("j") . $separacion . strtolower(self::getMesCorto($date->format("n"))) . $separacion . $date->format("Y");
		}
		return "";
	}

	public static function getMesCompleto($numberOfMonth) {
		$array = array(
			1 => "Enero",
			2 => "Febrero",
			3 => "Marzo",
			4 => "Abril",
			5 => "Mayo",
			6 => "Junio",
			7 => "Julio",
			8 => "Agosto",
			9 => "Septiembre",
			10 => "Octubre",
			11 => "Noviembre",
			12 => "Diciembre"
		);
		return $array[$numberOfMonth];
	}

	public static function getFechaCompleta(DateTime $date = NULL) {
		if (!empty($date) && ($date instanceof DateTime)) {
			return self::getDiaCompleto($date->format("w") + 1) . ", " . $date->format("j") . " de " . strtolower(self::getMesCompleto($date->format("n"))) . " de " . $date->format("Y");
		}
		return "";
	}

	public static function getFechaHora(DateTime $date = NULL) {
		if (!empty($date) && ($date instanceof DateTime)) {
			return $date->format("j") . "-" . self::getMesCorto($date->format("n")) . "-" . $date->format("Y h:i a");
		} else {
			return "";
		}
	}

	public static function getUrlName($name) {
		$urlName = $name;
		$search = array(" ", "á", "é", "í", "ó", "ú", "ü", "ñ", "&", ".", "/", "'", "´", "Á", "É", "Í", "Ó", "Ú", "Ñ", "¿", "?", "¡", "!", "\r", "\n");
		$replace = array("_", "a", "e", "i", "o", "u", "u", "n", "-", "-", "-", "-", "", "A", "E", "I", "O", "U", "N", "", "", "", "", "", "_");
		$salida = str_replace($search, $replace, $urlName);
		return $salida;
	}

	public static function fileName($name) {
		$urlName = $name;
		$search = array("&", "/", "'", "´", "¿", "?", "¡", "!");
		$replace = array("", "", "", "", "", "", "", "");
		$salida = str_replace($search, $replace, $urlName);
		return $salida;
	}

}
