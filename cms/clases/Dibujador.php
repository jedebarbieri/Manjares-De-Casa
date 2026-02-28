<?

use \Categoria;

class Dibujador {

	public static function menuPrincipal($categoria = NULL) {
		$catPrincipales = Categoria::todas(true);
		?>
		<img src="logo.jpg" id="logo"/>
		<div id="menu">
			<ul>
				<?
				foreach ($catPrincipales as $cat) {
					?>
					<a href="productos.php?categoria=<?= $cat->id ?>"><li <?= (($cat->id == $categoria->id) || (!empty($cat->super->id))) ? "class='seleccionado'" : "" ?>><p><?= $cat->nombre ?></p></li></a>
					<?
				}
				?>
				<a href="usuarios.php"><li <?= empty($categoria->id) ? "class='seleccionado'" : "" ?>><p>Usuarios</p></li></a>
			</ul>
		</div>
		<?
		if ($categoria->id > 4) {
			$listaSubCategorias = Categoria::todas(false);
			?>
			<div id="subcategorias">
				<ul>
					<?
					foreach ($listaSubCategorias as $cat) {
						?>
						<a href="productos.php?categoria=<?= $cat->id ?>"><li <?= (($cat->id == $categoria->id)) ? "class='subcategoriaseleccionada'" : "" ?>><p><?= $cat->nombre ?></p></li></a>
						<?
					}
					?>
				</ul>
			</div>
			<?
		}
	}

	/**
	 * Imprime la cabecera de la versión web
	 * @param Categoria $categoria
	 */
	public static function cabecera($categoria = NULL, $lista = FALSE) {
		?>
		<div class="cabecera">
			<a class="logo" href="<?= Utils::URL ?>"><div></div></a>
			<nav>
				<a href="dulces"<?= $categoria->id == 1 ? " class='activo'" : "" ?>>dulces</a>
				<a href="trufas-de-chocolate"<?= $categoria->id == 2 ? " class='activo'" : "" ?>>trufas de chocolate</a>
				<a href="galletas-y-barquillos"<?= $categoria->id == 3 ? " class='activo'" : "" ?>>galletas y barquillos</a>
				<a href="cupcakes-y-kekes"<?= $categoria->id == 4 ? " class='activo'" : "" ?>>cupcakes y kekes</a>
				<a href="ocasiones-especiales"<?= $categoria->id >= 5 ? " class='activo'" : "" ?>>ocasiones especiales</a>
			</nav>
			<div class="menuResponsive">
				<div class="activo"><?= $lista ? "lista de precios" : strtolower($categoria->nombre) ?></div>
				<nav>
					<a href="dulces"<?= $categoria->id == 1 ? " class='activo'" : "" ?>>dulces</a>
					<a href="trufas-de-chocolate"<?= $categoria->id == 2 ? " class='activo'" : "" ?>>trufas de chocolate</a>
					<a href="galletas-y-barquillos"<?= $categoria->id == 3 ? " class='activo'" : "" ?>>galletas y barquillos</a>
					<a href="cupcakes-y-kekes"<?= $categoria->id == 4 ? " class='activo'" : "" ?>>cupcakes y kekes</a>
					<a href="ocasiones-especiales"<?= $categoria->id >= 5 ? " class='activo'" : "" ?>>ocasiones especiales</a>
					<div class="opciones">
						<a href="lista-de-precios"<?= $lista ? " class='activo'" : "" ?>>lista de precios</a>
						<button>escríbenos</button>
					</div>
				</nav>
				<div class="btn_desplegar"></div>
			</div>
		</div>
		<?
	}

	public static function pie($lista = FALSE) {
		?>
		<div class="pie">
			<div class="opciones">
				<a href="lista-de-precios"<?= $lista ? " class='activo'" : "" ?>>lista de precios</a>
				<button>escríbenos</button>
			</div>
			<div class="socials">
				<div class="likebutton">
					<div class="fb-like" data-href="https://www.facebook.com/ManjaresDeCasa" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
				</div>
				<a class="pinterest" href="https://www.pinterest.com/manjaresdecasa/" target="_blank">Pinterest</a>
				<a class="facebook" href="https://www.facebook.com/ManjaresDeCasa" target="_blank">Facebook</a>
				<a class="gplus" href="https://plus.google.com/+Manjaresdecasa_dulces/" target="_blank">Google+</a>
				<a class="twitter" href="https://twitter.com/Manjaresdecasa/" target="_blank">Twitter</a>
			</div>
		</div>
		<?
	}

	public static function analytics() {
		?>
		<script>
		<? if ((Utils::PRODUCCION) && FALSE) /* Para evitar llamadas al actual de manjares de casa oficial */ { ?>
				(function (i, s, o, g, r, a, m) {
					i['GoogleAnalyticsObject'] = r;
					i[r] = i[r] || function () {
						(i[r].q = i[r].q || []).push(arguments)
					}, i[r].l = 1 * new Date();
					a = s.createElement(o),
							m = s.getElementsByTagName(o)[0];
					a.async = 1;
					a.src = g;
					m.parentNode.insertBefore(a, m)
				})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

				ga('create', 'UA-18301965-1', 'auto');
				ga('send', 'pageview');
		<? } ?>
		</script>
		<?
	}

	public static function apiFacebookJS() {
		return ; /* Para evitar llamadas al actual de manjares de casa oficial */ 
		?>
		<div id="fb-root"></div>
		<script>(function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id))
					return;
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=808184405902642&version=v2.0";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
		<?
	}

	public static function socialsAPI() {
		?>
		<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyBLUNYd4SQZSxMboJaDVRku4Td4xgL-W1A&sensor=false">
		</script>
		<script>
			window.twttr = (function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0], t = window.twttr || {};
				if (d.getElementById(id))
					return;
				js = d.createElement(s);
				js.id = id;
				js.src = "https://platform.twitter.com/widgets.js";
				fjs.parentNode.insertBefore(js, fjs);
				t._e = [];
				t.ready = function (f) {
					t._e.push(f);
					twttr.widgets.load();
				};
				return t;
			}(document, "script", "twitter-wjs"));
		</script>
		<script defer="defer" src="//assets.pinterest.com/js/pinit.js"  data-pin-build="parsePinBtns"></script>
		<?
	}

	public static function contacto() {
		?>
		<div class="contacto">
			<div class="veladura"></div>
			<div class="ventana">
				<div class="contenido">
					<div class="formulario">
						<form id="contacto">
							<table>
								<tr class="nombre">
									<td class="etiqueta">nombre y apellido</td>
									<td class="campo"><input type="text" name="nombre" id="nombre"/></td>
								</tr>
								<tr class="telefono">
									<td class="etiqueta">teléfono</td>
									<td class="campo"><input type="text" name="telefono" id="telefono"/></td>
								</tr>
								<tr class="email">
									<td class="etiqueta">email</td>
									<td class="campo"><input type="text" name="email" id="email"/></td>
								</tr>
								<tr class="consultas">
									<td class="etiqueta">consultas</td>
									<td class="campo"><textarea name="consultas" id="consultas"></textarea></td>
								</tr>
								<tr>
									<td class="etiqueta"></td>
									<td><div class="btn_enviar">enviar</div></td>
								</tr>
							</table>
						</form>
					</div>
					<div class="datos">
						<table>
							<tr>
								<td class="datos">o contáctenos directamente al <br/>
									<a href="tel:+5112663848">2663848</a> o al <a href="tel:+51993488105">993488105</a><br/>
									o vía email<br/>
									<a href="mailto:adriana@manjaresdecasa.com">adriana@manjaresdecasa.com</a><br/>
									o visita nuestra tienda en <br/>
									<a href="https://www.google.com.pe/maps/search/Av.+Benavides+4534+-+Surco/@-12.1281202,-76.9893711,17z/data=!3m1!4b1?hl=es-419" target="_blank">Av. Benavides 4534 Surco</a>
								</td>
							</tr>
							<tr class="mapa">
								<td class="mapa">
									<div id="mapa">
									</div>
								</td>
							</tr>
							<tr>
								<td class="mensaje">Atendemos pedidos con 24 horas de anticipación. Pedidos para el mismo día, están sujetos a disponibilidad.</td>
							</tr>
						</table>
					</div>
					<div class="btn_cerrar"></div>
					<div class="estado"></div>
				</div>
			</div>
		</div>
		<?
	}

}
?>