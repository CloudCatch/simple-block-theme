<?php
/**
 * Enqueue scripts and styles
 *
 * @package SimpleBlockTheme
 */

namespace SimpleBlockTheme;

use WP_Font_Face_Resolver;

/**
 * Load core block assets only when they are rendered.
 *
 * @return bool
 */
add_filter( 'should_load_separate_core_block_assets', '__return_true' );

/**
 * Enqueue scripts
 *
 * @return void
 */
function enqueue_scripts() {
	$style_asset = include get_theme_file_path( 'assets/css/main.asset.php' );

	wp_enqueue_style( 'simple-block-theme-style', get_theme_file_uri( 'assets/css/main.css' ), $style_asset['dependencies'], $style_asset['version'] );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_scripts' );

/**
 * Register module scripts and styles
 *
 * @return void
 */
function register_module_scripts() {
	// Register any module stylesheets.
	$style_modules = glob( get_stylesheet_directory() . '/assets/css/modules/*.css' );
	foreach ( $style_modules as $style_module ) {
		$style_module_asset = include get_stylesheet_directory() . '/assets/css/modules/' . str_replace( '.css', '.asset.php', basename( $style_module ) );

		wp_register_style( 'ns-' . basename( $style_module, '.css' ), get_stylesheet_directory_uri() . '/assets/css/modules/' . basename( $style_module ), $style_module_asset['dependencies'], $style_module_asset['version'] );
	}
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\register_module_scripts' );

/**
 * Enqueue block assets
 *
 * @return void
 */
function block_assets() {
	wp_register_script_module( 'Swiper', get_theme_file_uri( 'assets/js/modules/swiper.js' ) );

	if ( is_admin() ) {
		$editor_style_asset = include get_theme_file_path( 'assets/css/editor.asset.php' );

		wp_enqueue_style( 'ns-editor', get_theme_file_uri( 'assets/css/editor.css' ), $editor_style_asset['dependencies'], $editor_style_asset['version'] );
	}
}
add_action( 'enqueue_block_assets', __NAMESPACE__ . '\block_assets' );

/**
 * Enqueue editor scripts
 *
 * @return void
 */
function enqueue_block_editor_scripts() {
	$editor_script_asset = include get_theme_file_path( 'assets/js/editor.asset.php' );

	wp_enqueue_script( 'ns-editor', get_theme_file_uri( 'assets/js/editor.js' ), $editor_script_asset['dependencies'], $editor_script_asset['version'], true );
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_block_editor_scripts' );

/**
 * Enqueue block specific styles
 *
 * @return void
 */
function enqueue_block_specific_styles() {
	/**
	 * Locate all specific block stylesheets
	 */
	$styled_blocks_glob = glob( get_stylesheet_directory() . '/assets/css/blocks/*.css' );
	$styled_blocks      = array_reduce(
		$styled_blocks_glob,
		function ( $accumulator, $css_file ) {
			$pattern = '/(.+?)-(.+)\.css/i';
			preg_match( $pattern, basename( $css_file ), $matches );

			$block_name = $matches[1] . '/' . $matches[2];

			$accumulator[ $block_name ]['path'] = $css_file;
			$accumulator[ $block_name ]['src']  = str_replace( get_stylesheet_directory(), get_stylesheet_directory_uri(), $css_file );

			return $accumulator;
		},
		array()
	);

	foreach ( $styled_blocks as $block_name => $stylesheet_path ) {
		$block_filename = sanitize_file_name( str_replace( '/', '-', $block_name ) );

		$asset = include dirname( $stylesheet_path['path'] ) . DIRECTORY_SEPARATOR . $block_filename . '.asset.php';

		$args = array(
			'handle' => $block_name,
			'path'   => $stylesheet_path['path'],
			'deps'   => $asset['dependencies'],
			'src'    => $stylesheet_path['src'],
			'ver'    => $asset['version'],
		);

		wp_enqueue_block_style( $block_name, $args );
	}
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\enqueue_block_specific_styles' );

/**
 * Preload .woff2 fonts.
 *
 * @return void
 */
function preload_fonts() {
	$fonts = WP_Font_Face_Resolver::get_fonts_from_theme_json();

	if ( empty( $fonts ) ) {
		return;
	}

	foreach ( $fonts as $font ) {
		if ( ! is_array( $font ) || empty( $font ) ) {
			continue;
		}

		foreach ( $font as $variation ) {
			$src = $variation['src'] ?? array();

			if ( empty( $src ) ) {
				continue;
			}

			if ( ! is_array( $src ) ) {
				$src = array( $src );
			}

			foreach ( $src as $uri ) {
				$extension = pathinfo( $uri, PATHINFO_EXTENSION );

				if ( ! $extension || 'woff2' !== $extension ) {
					continue;
				}

				printf(
					'<link rel="preload" href="%s" as="font" type="font/%s" crossorigin="anonymous">',
					esc_url( $uri ),
					esc_attr( $extension )
				);

				echo PHP_EOL;
			}
		}
	}
}
add_action( 'wp_head', __NAMESPACE__ . '\preload_fonts' );
