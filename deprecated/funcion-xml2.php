<?php

function convertirCSVaXML($archivoCSV) {
	// Abre el archivo CSV para lectura
	if (($gestor = fopen($archivoCSV, "r")) !== FALSE) {
		// Define el inicio del XML
		$xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;

		// datos duros.
		$xml .= '<!-- generator="WordPress/6.4.1" created="2023-11-27 22:33" -->' . PHP_EOL;

		$xml .= '<rss version="2.0"
			xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
			xmlns:content="http://purl.org/rss/1.0/modules/content/"
			xmlns:wfw="http://wellformedweb.org/CommentAPI/"
			xmlns:dc="http://purl.org/dc/elements/1.1/"
			xmlns:wp="http://wordpress.org/export/1.2/"
		>' . PHP_EOL;

		$xml .= '<channel>' . PHP_EOL;

		// Datos duros.
		$xml .= '<title>Laboratorio</title>' . PHP_EOL;
		$xml .= '<link>http://localhost/wpdev/wplab</link>' . PHP_EOL;
		$xml .= '<description></description>' . PHP_EOL;
		$xml .= '<pubDate>Mon, 27 Nov 2023 22:33:43 +0000</pubDate>' . PHP_EOL;
		$xml .= '<language>es</language>' . PHP_EOL;
		$xml .= '<wp:wxr_version>1.2</wp:wxr_version>' . PHP_EOL;
		$xml .= '<wp:base_site_url>http://localhost/wpdev/wplab</wp:base_site_url>' . PHP_EOL;
		$xml .= '<wp:base_blog_url>http://localhost/wpdev/wplab</wp:base_blog_url>' . PHP_EOL;

		$xml .= '<wp:author>' . PHP_EOL;
		$xml .= '<wp:author_id>1</wp:author_id>' . PHP_EOL;
		$xml .= '<wp:author_login><![CDATA[urielink]]></wp:author_login>' . PHP_EOL;
		$xml .= '<wp:author_email><![CDATA[web@bixnia.com]]></wp:author_email>' . PHP_EOL;
		$xml .= '<wp:author_display_name><![CDATA[urielink]]></wp:author_display_name>' . PHP_EOL;
		$xml .= '<wp:author_first_name><![CDATA[]]></wp:author_first_name>' . PHP_EOL;
		$xml .= '<wp:author_last_name><![CDATA[]]></wp:author_last_name>' . PHP_EOL;
		$xml .= '</wp:author>' . PHP_EOL;

		$xml .= '<generator>https://wordpress.org/?v=6.4.1</generator>' . PHP_EOL;


		// Lee el archivo CSV línea por línea
		while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
			// Ignora la primera línea que suele contener encabezados
			if ($datos[0] == "post_title") {
				continue;
			}

			// Agrupa post_title y custom_sku
			// $titulo = $datos[0] . ' - ' . $datos[1];
			$titulo = $datos[0] . ' ' . $datos[1];

			// Inicia la estructura XML para el producto
			$xml .= '<item>' . PHP_EOL;
			$xml .= "\t<title><![CDATA[$titulo]]></title>" . PHP_EOL;

			// Datos duros.
			$xml .= "\t<link></link>" . PHP_EOL;
			$xml .= "\t<pubDate>Sat, 26 Aug 2023 01:16:29 +0000</pubDate>" . PHP_EOL;
			$xml .= "\t<dc:creator><![CDATA[urielink]]></dc:creator>" . PHP_EOL;
			$xml .= "\t<guid isPermaLink=\"false\"></guid>" . PHP_EOL;
			$xml .= "\t<description></description>" . PHP_EOL;


			// Genera los párrafos para post_content
			$content = '';
			foreach (explode("\n", $datos[2]) as $parrafo) {
				$content .= "\t<!-- wp:paragraph -->" . PHP_EOL;
				$content .= "\t<p>$parrafo</p>" . PHP_EOL;
				$content .= "\t<!-- /wp:paragraph -->" . PHP_EOL;
			}

			// Verifica si $datos[3] existe antes de intentar trabajar con él
			$button_url = '';
			if (isset($datos[3])) {
				// Aplica htmlspecialchars o htmlentities
				$button_url = htmlentities($datos[3], ENT_QUOTES, 'UTF-8');
			} 


			// Genera el formato del botón para post_content_button_url
			$content .= "\t<!-- wp:buttons -->" . PHP_EOL;
			$content .= "\t<div class=\"wp-block-buttons\">" . PHP_EOL;
			$content .= "\t\t<!-- wp:button -->" . PHP_EOL;
			$content .= "\t\t\t<div class=\"wp-block-button\">" . PHP_EOL;
			// $content .= "\t\t\t\t<a class=\"wp-block-button__link wp-element-button\" href=\"$datos[3]\" target=\"_blank\" rel=\"noreferrer noopener\">Comprar</a>" . PHP_EOL;
			$content .= "\t\t\t\t<a class=\"wp-block-button__link wp-element-button\" href=\"$button_url\" target=\"_blank\" rel=\"noreferrer noopener\">Comprar</a>" . PHP_EOL;
			$content .= "\t\t\t</div>" . PHP_EOL;
			$content .= "\t\t<!-- /wp:button -->" . PHP_EOL;
			$content .= "\t</div>" . PHP_EOL;
			$content .= "\t<!-- /wp:buttons -->" . PHP_EOL;

			// Genera el formato de la galería para gallery_images_url
			$content .= "\t<!-- wp:gallery {\"columns\":5,\"linkTo\":\"none\"} -->" . PHP_EOL;
			$content .= "\t<figure class=\"wp-block-gallery has-nested-images columns-5 is-cropped\">" . PHP_EOL;

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
				$content .= "\t\t<!-- No hay imágenes disponibles -->" . PHP_EOL;
			}

			$content .= "\t</figure>" . PHP_EOL;
			$content .= "\t<!-- /wp:gallery -->" . PHP_EOL;

			// Cierra la estructura XML para el producto
			$xml .= "\t<content:encoded><![CDATA[$content]]></content:encoded>" . PHP_EOL;

			// Datos duros.
			$xml .= "\t<excerpt:encoded><![CDATA[]]></excerpt:encoded>" . PHP_EOL;
			$xml .= "\t<wp:post_id></wp:post_id>" . PHP_EOL;
			$xml .= "\t<wp:post_date><![CDATA[2023-08-26 03:16:29]]></wp:post_date>" . PHP_EOL;
			$xml .= "\t<wp:post_date_gmt><![CDATA[2023-08-26 01:16:29]]></wp:post_date_gmt>" . PHP_EOL;
			$xml .= "\t<wp:post_modified><![CDATA[2023-08-26 03:16:29]]></wp:post_modified>" . PHP_EOL;
			$xml .= "\t<wp:post_modified_gmt><![CDATA[2023-08-26 01:16:29]]></wp:post_modified_gmt>" . PHP_EOL;
			$xml .= "\t<wp:comment_status><![CDATA[open]]></wp:comment_status>" . PHP_EOL;
			$xml .= "\t<wp:ping_status><![CDATA[open]]></wp:ping_status>" . PHP_EOL;
			$xml .= "\t<wp:post_name><![CDATA[]]></wp:post_name>" . PHP_EOL;
			$xml .= "\t<wp:status><![CDATA[publish]]></wp:status>" . PHP_EOL;
			$xml .= "\t<wp:post_parent>0</wp:post_parent>" . PHP_EOL;
			$xml .= "\t<wp:menu_order>0</wp:menu_order>" . PHP_EOL;
			$xml .= "\t<wp:post_type><![CDATA[post]]></wp:post_type>" . PHP_EOL;
			$xml .= "\t<wp:post_password><![CDATA[]]></wp:post_password>" . PHP_EOL;
			$xml .= "\t<wp:is_sticky>0</wp:is_sticky>" . PHP_EOL;


			// Verifica si $datos[5] existe antes de intentar trabajar con él
			if (isset($datos[5])) {
				// convertir texto en nicename.
				$nicename = strtolower(str_replace(' ', '-', $datos[5]));
				$xml .= "\t<category domain=\"category\" nicename=\"$nicename\"><![CDATA[$datos[5]]]></category>" . PHP_EOL;
			} else {
				// $xml .= "\t<!-- No hay categoría disponible -->" . PHP_EOL;
				$xml .= "\t<category domain=\"category\" nicename=\"sin-categoria\"><![CDATA[Sin categoría]]></category>" . PHP_EOL;
			}

			// Verifica si $datos[6] y $datos[7] existen antes de intentar trabajar con ellos
			if (isset($datos[6], $datos[7])) {
				$nicename = strtolower(str_replace(' ', '-', $datos[6]));
				$xml .= "\t<category domain=\"post_tag\" nicename=\"$nicename\"><![CDATA[$datos[6]]]></category>" . PHP_EOL;
			} else {
				// $xml .= "\t<!-- No hay etiquetas disponibles -->" . PHP_EOL;
				$xml .= "\t<category domain=\"post_tag\" nicename=\"sin-etiqueta\"><![CDATA[sin etiqueta]]></category>" . PHP_EOL;
			}

			$xml .= '</item>' . PHP_EOL;
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

// Uso de la función con un archivo CSV llamado "ejemplo.csv"
// echo convertirCSVaXML("Productos-Tabla4.csv");

// Obtén el contenido XML
$xmlContent = convertirCSVaXML("Productos-Tabla4.csv");

// Establece las cabeceras para indicar que el contenido es XML y forzar la descarga del archivo
header('Content-Type: text/xml');
header('Content-Disposition: attachment; filename="productos.xml"');

// Imprime el contenido XML
echo $xmlContent;
