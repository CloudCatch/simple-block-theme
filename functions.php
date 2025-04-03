<?php
/**
 * Theme functions.
 * 
 * @package SimpleBlockTheme
 */

namespace SimpleBlockTheme;

/**
 * Require necessary files
 */
require_once 'inc/blocks.php';
require_once 'inc/scripts-styles.php';

/**
 * Load translations
 * 
 * @return void
 */
function theme_setup() {
	load_theme_textdomain( 'simple-block-theme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_setup' );
