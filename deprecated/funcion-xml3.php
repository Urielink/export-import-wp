<?php
/**
 * Exportar productos de csv a wordpress.
 */
function convertirCSVaXML($archivoCSV) {
	// Abre el archivo CSV para lectura
	if (($gestor = fopen($archivoCSV, "r")) !== FALSE) {
		// Define el inicio del XML
		$xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;

		// datos duros.
		$date_created = date('Y-m-d H:i'); // 2023-11-27 22:33.
		$xml .= '<!-- generator="WordPress/6.4.1" created="' . $date_created . '" -->' . PHP_EOL;

		$xml .= '<rss version="2.0"' . PHP_EOL;
		$xml .= "\t".'xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"' . PHP_EOL;
		$xml .= "\t".'xmlns:content="http://purl.org/rss/1.0/modules/content/"' . PHP_EOL;
		$xml .= "\t".'xmlns:wfw="http://wellformedweb.org/CommentAPI/"' . PHP_EOL;
		$xml .= "\t".'xmlns:dc="http://purl.org/dc/elements/1.1/"' . PHP_EOL;
		$xml .= "\t".'xmlns:wp="http://wordpress.org/export/1.2/"' . PHP_EOL;
		$xml .= '>' . PHP_EOL;

		$xml .= '<channel>' . PHP_EOL;

		// Datos duros.
		$date_pub = date("D, j M Y H:i:s O"); // Mon, 27 Nov 2023 22:33:43 +0000.

		$xml .= "\t".'<title>Laboratorio</title>' . PHP_EOL;
		$xml .= "\t".'<link>http://localhost/wpdev/wplab</link>' . PHP_EOL;
		$xml .= "\t".'<description></description>' . PHP_EOL;
		$xml .= "\t".'<pubDate>' . $date_pub . '</pubDate>' . PHP_EOL;
		$xml .= "\t".'<language>es</language>' . PHP_EOL;
		$xml .= "\t".'<wp:wxr_version>1.2</wp:wxr_version>' . PHP_EOL;
		$xml .= "\t".'<wp:base_site_url>http://localhost/wpdev/wplab</wp:base_site_url>' . PHP_EOL;
		$xml .= "\t".'<wp:base_blog_url>http://localhost/wpdev/wplab</wp:base_blog_url>' . PHP_EOL;

		$xml .= "\t".'<wp:author>' . PHP_EOL;
		$xml .= "\t".'<wp:author_id>1</wp:author_id>' . PHP_EOL;
		$xml .= "\t".'<wp:author_login><![CDATA[urielink]]></wp:author_login>' . PHP_EOL;
		$xml .= "\t".'<wp:author_email><![CDATA[web@bixnia.com]]></wp:author_email>' . PHP_EOL;
		$xml .= "\t".'<wp:author_display_name><![CDATA[urielink]]></wp:author_display_name>' . PHP_EOL;
		$xml .= "\t".'<wp:author_first_name><![CDATA[]]></wp:author_first_name>' . PHP_EOL;
		$xml .= "\t".'<wp:author_last_name><![CDATA[]]></wp:author_last_name>' . PHP_EOL;
		$xml .= "\t".'</wp:author>' . PHP_EOL;

		$xml .= "\t".'<generator>https://wordpress.org/?v=6.4.1</generator>' . PHP_EOL;


		// Lee el archivo CSV línea por línea
		while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
			// Ignora la primera línea que suele contener encabezados
			if ($datos[0] == "post_title") {
				continue;
			}

			// Agrupa post_title y custom_sku
			// $titulo = $datos[0] . ' - ' . $datos[1];
			$titulo = $datos[0];

			// Inicia la estructura XML para el producto
			$xml .= "\t".'<item>' . PHP_EOL;
			$xml .= "\t\t<title><![CDATA[$titulo]]></title>" . PHP_EOL;

			// Datos duros.
			$xml .= "\t\t<link></link>" . PHP_EOL;
			$xml .= "\t\t<pubDate>'" . $date_pub . "'</pubDate>" . PHP_EOL;
			$xml .= "\t\t<dc:creator><![CDATA[urielink]]></dc:creator>" . PHP_EOL;
			$xml .= "\t\t<guid isPermaLink=\"false\"></guid>" . PHP_EOL;
			$xml .= "\t\t<description></description>" . PHP_EOL;

			// Genera el contenido.
			$content = generarContenido($datos);

			// Cierra la estructura XML para el producto
			$xml .= "\t\t<content:encoded><![CDATA[$content]]></content:encoded>" . PHP_EOL;

			// Datos duros.
			$post_date = date("Y-m-d H:i:s"); //2023-11-29 03:38:56.
			$post_date_gmt = date("Y-m-d H:i:s");
			// Suma una hora (3600 segundos) a la fecha actual
			$post_modified = date("Y-m-d H:i:s", strtotime($post_date) + 3600);
			$post_modified_gmt = date("Y-m-d H:i:s", strtotime($post_date_gmt) + 3600);

			$xml .= "\t\t<excerpt:encoded><![CDATA[]]></excerpt:encoded>" . PHP_EOL;
			$xml .= "\t\t<wp:post_id></wp:post_id>" . PHP_EOL;
			$xml .= "\t\t<wp:post_date><![CDATA[$post_date]]></wp:post_date>" . PHP_EOL;
			$xml .= "\t\t<wp:post_date_gmt><![CDATA[$post_date_gmt]]></wp:post_date_gmt>" . PHP_EOL;
			$xml .= "\t\t<wp:post_modified><![CDATA[$post_modified]]></wp:post_modified>" . PHP_EOL;
			$xml .= "\t\t<wp:post_modified_gmt><![CDATA[$post_modified_gmt]]></wp:post_modified_gmt>" . PHP_EOL;
			$xml .= "\t\t<wp:comment_status><![CDATA[closed]]></wp:comment_status>" . PHP_EOL;
			$xml .= "\t\t<wp:ping_status><![CDATA[closed]]></wp:ping_status>" . PHP_EOL;
			$xml .= "\t\t<wp:post_name><![CDATA[]]></wp:post_name>" . PHP_EOL;
			$xml .= "\t\t<wp:status><![CDATA[publish]]></wp:status>" . PHP_EOL;
			$xml .= "\t\t<wp:post_parent>0</wp:post_parent>" . PHP_EOL;
			$xml .= "\t\t<wp:menu_order>0</wp:menu_order>" . PHP_EOL;
			$xml .= "\t\t<wp:post_type><![CDATA[post]]></wp:post_type>" . PHP_EOL;
			$xml .= "\t\t<wp:post_password><![CDATA[]]></wp:post_password>" . PHP_EOL;
			$xml .= "\t\t<wp:is_sticky>0</wp:is_sticky>" . PHP_EOL;

			// Categorías y etiquetas.
			$xml .= "\t\t<category domain=\"category\" nicename=\"productos\"><![CDATA[Productos]]></category>" . PHP_EOL;

			// Verifica si $datos[5] existe antes de intentar trabajar con él
			if (isset($datos[5])) {
				// convertir texto en nicename.
				$nicename = strtolower(str_replace(' ', '-', $datos[5]));
				$xml .= "\t\t<category domain=\"category\" nicename=\"$nicename\"><![CDATA[$datos[5]]]></category>" . PHP_EOL;
			} else {
				// $xml .= "\t<!-- No hay categoría disponible -->" . PHP_EOL;
				$xml .= "\t\t<category domain=\"category\" nicename=\"sin-categoria\"><![CDATA[Sin categoría]]></category>" . PHP_EOL;
			}

			// Verifica si $datos[6] y $datos[7] existen antes de intentar trabajar con ellos
			if (isset($datos[6])) {
				$nicename = strtolower(str_replace(' ', '-', $datos[6]));
				$xml .= "\t\t<category domain=\"post_tag\" nicename=\"$nicename\"><![CDATA[$datos[6]]]></category>" . PHP_EOL;
			} else {
				// $xml .= "\t<!-- No hay etiquetas disponibles -->" . PHP_EOL;
				$xml .= "\t\t<category domain=\"post_tag\" nicename=\"sin-etiqueta\"><![CDATA[sin etiqueta]]></category>" . PHP_EOL;
			}

			$xml .= "\t".'</item>' . PHP_EOL;
		}

		// Cierra el XML
		$xml .= '</channel>' . PHP_EOL;
		$xml .= '</rss>' . PHP_EOL;

		// Cierra el archivo CSV
		fclose($gestor);

		// Retorna el XML generado
		return $xml;
	} else {
		return "Error al abrir el archivo CSV.";
	}
}

// Obtén el contenido XML
$xmlContent = convertirCSVaXML("Productos-Tabla4.csv");

// Establece las cabeceras para indicar que el contenido es XML y forzar la descarga del archivo
header('Content-Type: text/xml');
header('Content-Disposition: attachment; filename="productos.xml"');

// Imprime el contenido XML
echo $xmlContent;


/**
 * Plantilla de contenido.
 *
 */
function generarContenido($datos) {

	// Genera el contenido.
	$content = '';

	// Estructura en columnas 1.
	$content .= "<!-- wp:columns -->" . PHP_EOL;
	$content .= "\t\t<div class=\"wp-block-columns\">" . PHP_EOL;
	$content .= "\t\t<!-- wp:column {\"width\":\"\"} -->" . PHP_EOL;
	$content .= "\t\t\t<div class=\"wp-block-column\">" . PHP_EOL;

	//saber cuantas imagenes hay en explode("\n", $datos[4]).
	$columnas = '1';
	if (isset($datos[4])) {
		$imagenes = explode("\n", $datos[4]);
		$cantidad_imagenes = count($imagenes);
		switch($cantidad_imagenes) {
			case 1:
			case 2:
			$columnas = '1';
			break;

			case 3:
			$columnas = '2';
			break;

			case 4:
			$columnas = '3';
			break;

			default:
			$columnas = '4';
		}
	}

		// Genera el formato de la galería para gallery_images_url
		$content .= "\t\t\t\t<!-- wp:gallery {\"columns\":$columnas,\"linkTo\":\"none\",\"className\":\"galeria201\"} -->" . PHP_EOL;
		$content .= "\t\t\t\t<figure class=\"wp-block-gallery has-nested-images columns-$columnas is-cropped galeria201\">" . PHP_EOL;

		// Verifica si $datos[4] existe antes de intentar trabajar con él
		if (isset($datos[4])) {
			// foreach (explode(",", $datos[4]) as $imagen) {
			foreach (explode("\n", $datos[4]) as $imagen) {
				$content .= "\t\t<!-- wp:image {\"sizeSlug\":\"large\",\"linkDestination\":\"none\"} -->" . PHP_EOL;
				$content .= "\t\t\t<figure class=\"wp-block-image size-large\"><img src=\"$imagen\" alt=\"\"/></figure>" . PHP_EOL;
				$content .= "\t\t<!-- /wp:image -->" . PHP_EOL;
			}
		} else {
			// Si $datos[4] no existe, puedes manejarlo de alguna manera, como mostrar un mensaje o hacer algo diferente.
			$content .= "\t\t\t\t\t<!-- No hay imágenes disponibles -->" . PHP_EOL;
		}

		$content .= "\t\t\t\t</figure>" . PHP_EOL;
		$content .= "\t\t\t\t<!-- /wp:gallery -->" . PHP_EOL;


	// Estructura en columnas 2.
	$content .= "\t\t\t</div>" . PHP_EOL;
	$content .= "\t\t<!-- /wp:column -->" . PHP_EOL;
	$content .= "\t\t<!-- wp:column -->" . PHP_EOL;
	$content .= "\t\t\t<div class=\"wp-block-column\">" . PHP_EOL;

		// Bloque de título.
		$content .= "\t\t\t\t<!-- wp:post-title {\"fontSize\":\"large\"} /-->" . PHP_EOL;

		// Bloque de código SKU.
		$content .= "\t\t\t\t<!-- wp:paragraph -->" . PHP_EOL;
		$content .= "\t\t\t\t\t<p>SKU: $datos[1]</p>" . PHP_EOL;
		$content .= "\t\t\t\t<!-- /wp:paragraph -->" . PHP_EOL;

		// Genera los párrafos para post_content
		foreach (explode("\n", $datos[2]) as $parrafo) {
			$content .= "\t\t\t\t<!-- wp:paragraph -->" . PHP_EOL;
			$content .= "\t\t\t\t\t<p>$parrafo</p>" . PHP_EOL;
			$content .= "\t\t\t\t<!-- /wp:paragraph -->" . PHP_EOL;
		}

		// Verifica si $datos[3] existe antes de intentar trabajar con él
		$button_url = '';
		if (isset($datos[3])) {
			// Aplica htmlspecialchars o htmlentities
			$button_url = htmlentities($datos[3], ENT_QUOTES, 'UTF-8');
		}

		// Genera el formato del botón para post_content_button_url
		$content .= "\t\t\t\t<!-- wp:buttons -->" . PHP_EOL;
		$content .= "\t\t\t\t<div class=\"wp-block-buttons\">" . PHP_EOL;
		$content .= "\t\t\t\t\t<!-- wp:button -->" . PHP_EOL;
		$content .= "\t\t\t\t\t\t<div class=\"wp-block-button\">" . PHP_EOL;
		$content .= "\t\t\t\t\t\t\t<a class=\"wp-block-button__link wp-element-button\" href=\"$button_url\" target=\"_blank\" rel=\"noreferrer noopener\">Comprar</a>" . PHP_EOL;
		$content .= "\t\t\t\t\t\t</div>" . PHP_EOL;
		$content .= "\t\t\t\t\t<!-- /wp:button -->" . PHP_EOL;
		$content .= "\t\t\t\t</div>" . PHP_EOL;
		$content .= "\t\t\t\t<!-- /wp:buttons -->" . PHP_EOL;


	// Estructura en columnas 3.
	$content .= "\t\t\t</div>" . PHP_EOL;
	$content .= "\t\t<!-- /wp:column -->" . PHP_EOL;
	$content .= "\t\t</div>" . PHP_EOL;
	$content .= "\t\t<!-- /wp:columns -->" . PHP_EOL;

	// stringify content, clear tabs.
	$content = str_replace("\t", "", $content);
	$content = str_replace("\n", "", $content);

	return $content;
}