<?php
/**
 * Bing Translator
 *
 * @package BingTranslator
 * @copyright Copyright (c) 2014, Microsoft Open Technologies, Inc. All rights reserved.
 * @license GPL-2.0+
 * @link http://www.bing.com/widget/translator
 *
 * @wordpress-plugin
 * Plugin Name: Bing Translator
 * Plugin URI: http://wordpress.org/plugins/bing-translator/
 * Description: Enable visitors to translate your site in their language in one click with the Bing Translator plugin from Microsoft Open Technologies, Inc.
 * Version: 1.0
 * Author: Microsoft Open Technologies, Inc.
 * Author URI: http://msopentech.com/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /languages
 * Text Domain: bing-translator
 */

/**
 * Main plugin instance.
 *
 * @since 1.0.0
 * @type Bing_Translator $bing_translator
 */
global $bing_translator;

if ( ! defined( 'BING_TRANSLATOR_PATH' ) ) {
	/**
	 * Path to the plugin root.
	 *
	 * @since 1.0.0
	 * @type string BING_TRANSLATOR_PATH
	 */
	define( 'BING_TRANSLATOR_PATH', dirname( __FILE__ ) . '/' );
}

if ( ! defined( 'BING_TRANSLATOR_URL' ) ) {
	/**
	 * URL to the plugin's root directory.
	 *
	 * Includes trailing slash.
	 *
	 * @since 1.0.0
	 * @type string BING_TRANSLATOR_PATH
	 */
	define( 'BING_TRANSLATOR_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Include helper files and API methods.
 */
include( BING_TRANSLATOR_PATH . 'includes/functions.php' );

/**
 * Autoloader callback.
 *
 * Converts a class name to a file path and requires it if it exists.
 *
 * @since 1.0.0
 *
 * @param string $class Class name.
 */
function bing_translator_autoloader( $class ) {
	if ( 0 !== strpos( $class, 'Bing_Translator' ) ) {
		return;
	}

	$file  = dirname( __FILE__ );
	$file .= ( false === strpos( $class, 'Admin' ) ) ? '/includes/' : '/admin/includes/';
	$file .= 'class-' . strtolower( str_replace( '_', '-', $class ) ) . '.php';

	if ( file_exists( $file ) ) {
		require_once( $file );
	}
}
spl_autoload_register( 'bing_translator_autoloader' );

// Initialize the main plugin class.
$bing_translator = new Bing_Translator();

// Load the plugin.
add_action( 'plugins_loaded', array( $bing_translator, 'load_plugin' ) );
