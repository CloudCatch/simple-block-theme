<?php
/**
 * Theme functions.
 * 
 * @package SimpleBlockTheme
 */

namespace SimpleBlockTheme;

/**
 * Enqueue scripts
 *
 * @return void
 */
function enqueue_scripts() {
	wp_enqueue_style( 'simple-block-theme', get_stylesheet_uri(), array(), wp_get_theme( 'simple-block-theme' )->get( 'Version' ) );
	wp_enqueue_script( 'simple-block-theme', get_theme_file_uri( 'assets/js/main.js' ), array(), wp_get_theme( 'simple-block-theme' )->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_scripts' );

/**
 * Enqueue editor scripts
 *
 * @return void
 */
function enqueue_block_editor_scripts() {
	wp_enqueue_style( 'simple-block-theme-editor', get_theme_file_uri( 'assets/css/editor.css' ), array(), wp_get_theme( 'simple-block-theme' )->get( 'Version' ) );
	wp_enqueue_script( 'simple-block-theme-editor', get_theme_file_uri( 'assets/js/editor.js' ), array(), wp_get_theme( 'simple-block-theme' )->get( 'Version' ), true );
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_block_editor_scripts' );

/**
 * Load translations
 * 
 * @return void
 */
function theme_setup() {
	load_theme_textdomain( 'simple-block-theme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_setup' );
