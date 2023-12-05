<?php

function convertirCSVaXML($archivoCSV) {
	// Abre el archivo CSV para lectura
	if (($gestor = fopen($archivoCSV, "r")) !== FALSE) {
		// Define el inicio del XML
		$xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
		$xml .= '<channel>' . PHP_EOL;

		// Lee el archivo CSV línea por línea
		while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
			// Ignora la primera línea que suele contener encabezados
			if ($datos[0] == "post_title") {
				continue;
			}

			// Agrupa post_title y custom_sku
			$titulo = $datos[0] . ' - ' . $datos[1];

			// Inicia la estructura XML para el producto
			$xml .= '<item>' . PHP_EOL;
			$xml .= "\t<title><![CDATA[ $titulo ]]></title>" . PHP_EOL;

			// Genera los párrafos para post_content
			$content = '';
			foreach (explode("\n", $datos[2]) as $parrafo) {
				$content .= "\t<!-- wp:paragraph -->" . PHP_EOL;
				$content .= "\t<p> $parrafo </p>" . PHP_EOL;
				$content .= "\t<!-- /wp:paragraph -->" . PHP_EOL;
			}

			// Genera el formato del botón para post_content_button_url
			$content .= "\t<!-- wp:buttons -->" . PHP_EOL;
			$content .= "\t<div class=\"wp-block-buttons\">" . PHP_EOL;
			$content .= "\t\t<!-- wp:button -->" . PHP_EOL;
			$content .= "\t\t\t<div class=\"wp-block-button\">" . PHP_EOL;
			$content .= "\t\t\t\t<a class=\"wp-block-button__link wp-element-button\" href=\"$datos[3]\" target=\"_blank\" rel=\"noreferrer noopener\">Comprar</a>" . PHP_EOL;
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

			// Verifica si $datos[5] existe antes de intentar trabajar con él
			if (isset($datos[5])) {
				$xml .= "\t<category domain=\"category\" nicename=\"4bf\"><![CDATA[$datos[5]]]></category>" . PHP_EOL;
			} else {
				$xml .= "\t<!-- No hay categoría disponible -->" . PHP_EOL;
			}

			// Verifica si $datos[6] y $datos[7] existen antes de intentar trabajar con ellos
			if (isset($datos[6], $datos[7])) {
				$xml .= "\t<category domain=\"post_tag\" nicename=\"pelota-para-perro\"><![CDATA[$datos[6], $datos[7]]]></category>" . PHP_EOL;
			} else {
				$xml .= "\t<!-- No hay etiquetas disponibles -->" . PHP_EOL;
			}

			$xml .= '</item>' . PHP_EOL;
		}

		// Cierra el XML
		$xml .= '</channel>' . PHP_EOL;

		// Cierra el archivo CSV
		fclose($gestor);

		// Retorna el XML generado
		return $xml;
	} else {
		return "Error al abrir el archivo CSV.";
	}
}

// Uso de la función con un archivo CSV llamado "ejemplo.csv"
echo convertirCSVaXML("Productos-Tabla4.csv");
