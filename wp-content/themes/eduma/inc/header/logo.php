<?php
add_action( 'thim_logo', 'thim_logo', 1 );
// logo
if ( ! function_exists( 'thim_logo' ) ) :
	function thim_logo() {
		$thim_logo = get_theme_mod( 'thim_logo', false );
		$style     = '';
		$logo_alt  = get_bloginfo( 'name' );
 		if ( ! empty( $thim_logo ) ) {
			if ( is_numeric( $thim_logo ) ) {
				$logo_attachment = wp_get_attachment_image_src( $thim_logo, 'full' );

				if ( get_post_meta( $thim_logo, '_wp_attachment_image_alt', true ) ) {
					$logo_alt = get_post_meta( $thim_logo, '_wp_attachment_image_alt', true );
				}
				if ( $logo_attachment ) {
					$src   = $logo_attachment[0];
					$style = 'width="' . $logo_attachment[1] . '" height="' . $logo_attachment[2] . '"';
				} else {
					// Default image
					// Case: image ID from demo data
					$src   = get_template_directory_uri() . '/images/logo.png';
					$style = 'width="153" height="40"';
				}
			} else {
				$src = $thim_logo;
			}
		} else {
			// Default image
			// Case: The first install
			$src   = get_template_directory_uri() . '/images/logo-sticky.png';
			$style = 'width="153" height="40"';
		}
		$src = thim_ssl_secure_url( $src );
		echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home" class="no-sticky-logo">';
		echo '<img src="' . $src . '" alt="' . esc_attr( $logo_alt ) . '" ' . $style . '>';
		echo '</a>';
	}
endif;
add_action( 'thim_sticky_logo', 'thim_sticky_logo', 1 );

// get sticky logo
if ( ! function_exists( 'thim_sticky_logo' ) ) :
	function thim_sticky_logo() {
		$sticky_logo     = get_theme_mod( 'thim_sticky_logo', false );
		$sticky_logo_alt = get_bloginfo( 'name' );

		$style = '';
		if ( ! empty( $sticky_logo ) ) {
			if ( is_numeric( $sticky_logo ) ) {
				$logo_attachment = wp_get_attachment_image_src( $sticky_logo, 'full' );
				if ( get_post_meta( $sticky_logo, '_wp_attachment_image_alt', true ) ) {
					$sticky_logo_alt = get_post_meta( $sticky_logo, '_wp_attachment_image_alt', true );
				}
				if ( $logo_attachment ) {
					$src   = $logo_attachment[0];
					$style = 'width="' . $logo_attachment[1] . '" height="' . $logo_attachment[2] . '"';
				} else {
					// Default image
					// Case: image ID from demo data
					$src   = get_template_directory_uri() . '/images/logo-sticky.png';
					$style = 'width="153" height="40"';
				}
			} else {
				$src = $sticky_logo;
			}

		} else {
			// Default image
			// Case: The first install
			$src   = get_template_directory_uri() . '/images/logo-sticky.png';
			$style = 'width="153" height="40"';
		}
		$src = thim_ssl_secure_url( $src );
		echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="sticky-logo">';
		echo '<img src="' . $src . '" alt="' . esc_attr( $sticky_logo_alt ) . '" ' . $style . '>';
		echo '</a>';
	}
endif;
