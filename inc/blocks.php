<?php
/**
 * Block functions and definitions
 *
 * @package SimpleBlockTheme
 */

namespace SimpleBlockTheme;

/**
 * Register blocks
 *
 * @return void
 */
function register_blocks() {
	$block_folders = glob( get_stylesheet_directory() . '/blocks/*', GLOB_ONLYDIR );

	foreach ( $block_folders as $block_folder ) {
		register_block_type_from_metadata( $block_folder );
	}
}
add_action( 'init', __NAMESPACE__ . '\register_blocks' );
