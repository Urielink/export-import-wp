<?php

echo '
<!-- wp:jetpack/slideshow {"ids":[1941,2222,1940,1939],"effect":"fade","sizeSlug":"medium","className":"is-style-rectangular"} -->
<div class="wp-block-jetpack-slideshow aligncenter is-style-rectangular" data-effect="fade">
	<div class="wp-block-jetpack-slideshow_container swiper-container">
		<ul class="wp-block-jetpack-slideshow_swiper-wrapper swiper-wrapper">
			<li class="wp-block-jetpack-slideshow_slide swiper-slide">
				<figure>
					<img alt="" class="wp-block-jetpack-slideshow_image wp-image-1941" data-id="1941" src="http://localhost/wpdev/grupo201/wp-content/uploads/2023/11/233022-05-4-189x300.png"/>
				</figure>
			</li>
			<li class="wp-block-jetpack-slideshow_slide swiper-slide">
				<figure>
					<img alt="" class="wp-block-jetpack-slideshow_image wp-image-2222" data-id="2222" src="http://localhost/wpdev/grupo201/wp-content/uploads/2023/11/233022-05-1-1-300x300.jpg"/>
				</figure>
			</li>
			<li class="wp-block-jetpack-slideshow_slide swiper-slide">
				<figure>
					<img alt="" class="wp-block-jetpack-slideshow_image wp-image-1940" data-id="1940" src="http://localhost/wpdev/grupo201/wp-content/uploads/2023/11/233022-05-2-300x300.jpg"/>
				</figure>
			</li>
			<li class="wp-block-jetpack-slideshow_slide swiper-slide">
				<figure>
					<img alt="" class="wp-block-jetpack-slideshow_image wp-image-1939" data-id="1939" src="http://localhost/wpdev/grupo201/wp-content/uploads/2023/11/233022-05-1-300x300.jpg"/>
				</figure>
			</li>
		</ul>
		<a class="wp-block-jetpack-slideshow_button-prev swiper-button-prev swiper-button-white" role="button"></a>
		<a class="wp-block-jetpack-slideshow_button-next swiper-button-next swiper-button-white" role="button"></a>
		<a aria-label="Pause Slideshow" class="wp-block-jetpack-slideshow_button-pause" role="button"></a>
		<div class="wp-block-jetpack-slideshow_pagination swiper-pagination swiper-pagination-white"></div>
	</div>
</div>
<!-- /wp:jetpack/slideshow -->
';


echo '
<!-- wp:jetpack/slideshow {"ids":[],"effect":"fade","sizeSlug":"medium","className":"is-style-rectangular"} -->
<div class="wp-block-jetpack-slideshow aligncenter is-style-rectangular" data-effect="fade">
	<div class="wp-block-jetpack-slideshow_container swiper-container">
		<ul class="wp-block-jetpack-slideshow_swiper-wrapper swiper-wrapper">
			<li class="wp-block-jetpack-slideshow_slide swiper-slide">
				<figure>
					<img alt="" class="wp-block-jetpack-slideshow_image wp-image" src=\"$imagen\"/>
				</figure>
			</li>
		</ul>
		<a class="wp-block-jetpack-slideshow_button-prev swiper-button-prev swiper-button-white" role="button"></a>
		<a class="wp-block-jetpack-slideshow_button-next swiper-button-next swiper-button-white" role="button"></a>
		<a aria-label="Pause Slideshow" class="wp-block-jetpack-slideshow_button-pause" role="button"></a>
		<div class="wp-block-jetpack-slideshow_pagination swiper-pagination swiper-pagination-white"></div>
	</div>
</div>
<!-- /wp:jetpack/slideshow -->
';


		// Genera el formato de la galería para gallery_images_url
		$content .= "\t\t\t\t<!-- wp:jetpack/slideshow {\"ids\":[],\"effect\":\"fade\",\"sizeSlug\":\"medium\",\"className\":\"is-style-rectangular\"} -->" . PHP_EOL;
		$content .= "\t\t\t\t<div class=\"wp-block-jetpack-slideshow aligncenter is-style-rectangular\" data-effect=\"fade\">" . PHP_EOL;
		$content .= "\t\t\t\t\t<div class=\"wp-block-jetpack-slideshow_container swiper-container\">" . PHP_EOL;
		$content .= "\t\t\t\t\t\t<ul class=\"wp-block-jetpack-slideshow_swiper-wrapper swiper-wrapper\">" . PHP_EOL;

		// Verifica si $datos[4] existe antes de intentar trabajar con él
		if (isset($datos[4])) {
			// foreach (explode(",", $datos[4]) as $imagen) {
			foreach (explode("\n", $datos[4]) as $imagen) {
				$content .= "\t\t<li class=\"wp-block-jetpack-slideshow_slide swiper-slide\">" . PHP_EOL;
				$content .= "\t\t\t<figure>" . PHP_EOL;
				$content .= "\t\t\t\t<img alt=\"\" class=\"wp-block-jetpack-slideshow_image wp-image\" src=\"$imagen\"/>" . PHP_EOL;
				$content .= "\t\t\t</figure>" . PHP_EOL;
				$content .= "\t\t</li>" . PHP_EOL;
			}
		} 

		$content .= "\t\t\t\t\t\t</ul>" . PHP_EOL;

		$content .= "\t\t\t\t\t\t<a class=\"wp-block-jetpack-slideshow_button-prev swiper-button-prev swiper-button-white\" role=\"button\"></a>" . PHP_EOL;
		$content .= "\t\t\t\t\t\t<a class=\"wp-block-jetpack-slideshow_button-next swiper-button-next swiper-button-white\" role=\"button\"></a>" . PHP_EOL;
		$content .= "\t\t\t\t\t\t<a aria-label=\"Pause Slideshow\" class=\"wp-block-jetpack-slideshow_button-pause\" role=\"button\"></a>" . PHP_EOL;
		$content .= "\t\t\t\t\t\t<div class=\"wp-block-jetpack-slideshow_pagination swiper-pagination swiper-pagination-white\"></div>" . PHP_EOL;

		$content .= "\t\t\t\t\t</div>" . PHP_EOL;
		$content .= "\t\t\t\t</div>" . PHP_EOL;
		$content .= "\t\t\t\t<!-- /wp:jetpack/slideshow -->" . PHP_EOL;