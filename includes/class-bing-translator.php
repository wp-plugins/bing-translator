<?php
/**
 * Bing Translator plugin.
 *
 * @since 1.0.0
 *
 * @package BingTranslator
 * @copyright Copyright (c) 2014, Microsoft Open Technologies, Inc. All rights reserved.
 * @license GPL-2.0+
 */

/**
 * Main plugin class.
 *
 * @package BingTranslator
 * @since 1.0.0
 */
class Bing_Translator {
	/**
	 * Load the plugin.
	 *
	 * @since 1.0.0
	 */
	public function load_plugin() {
		self::load_textdomain();
		self::register_shortcodes();

		if ( is_admin() ) {
			self::load_admin();
		}

		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
	}

	/**
	 * Load the textdomain to allow strings to be localized.
	 *
	 * @since 1.0.0
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'bing-translator', false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages' );
	}

	/**
	 * Load the administration functionality.
	 *
	 * @since 1.0.0
	 */
	public function load_admin() {
		$admin = new Bing_Translator_Admin();
		$admin->load();
	}

	/**
	 * Register widgets.
	 *
	 * @since 1.0.0
	 */
	public function register_widgets() {
		register_widget( 'Bing_Translator_Widget' );
	}

	/**
	 * Register shortcodes.
	 *
	 * @since 1.0.0
	 */
	public function register_shortcodes() {
		add_shortcode( 'bing_translator', array( $this, 'bing_translator_shortcode' ) );
		add_shortcode( 'notranslate', array( $this, 'notranslate_shortcode' ) );
	}

	/**
	 * Bing Translator shortcode handler.
	 *
	 * @since 1.0.0
	 * @see Bing_Translator_Settings::__construct()
	 * @see bing_translator()
	 *
	 * @param array $atts Optional. Attributes to override settings for the individual widget instance. Defaults to site-wide settings.
	 * @return string
	 */
	public function bing_translator_shortcode( $atts = array() ) {
		if ( isset( $atts['enable_ctf'] ) ) {
			$atts['enable_ctf'] = self::shortcode_bool( $atts['enable_ctf'] );
		}

		ob_start();
		bing_translator( $atts );
		return ob_get_clean();
	}

	/**
	 * Handler for [notranslate] shortcode.
	 *
	 * Wraps content in a div or span with a class of 'notranslate' to prevent
	 * the widget from translating text.
	 *
	 * Shortcodes surrounding block-level elements should appear on their own
	 * line in the editor.
	 *
	 * @since 1.0.0
	 * @link https://core.trac.wordpress.org/ticket/14050
	 * @link https://core.trac.wordpress.org/ticket/25856
	 *
	 * @param array $atts Optional. Shortcode attributes.
	 * @param string $content Content between shortcode tags.
	 * @return string
	 */
	public function notranslate_shortcode( $atts = array(), $content = '' ) {
		$is_inline = false === strpos( $content, "\n" );

		if ( ! $is_inline ) {
			// Try to clean up errant <p> tags.
			$content = preg_replace( '#^</p>#', '', $content );
			$content = preg_replace( '#<p>$#', '', $content );
			$content = wpautop( $content );
		}

		$tag = $is_inline ? 'span' : 'div';
		return sprintf( '<%1$s class="notranslate">%2$s</%1$s>', $tag, $content );
	}

	/**
	 * Determine if a shortcode attribute is true or false.
	 *
	 * @since 1.0.0
	 *
	 * @param string|int|bool $var Attribute value.
	 * @return bool
	 */
	public static function shortcode_bool( $var ) {
		$falsey = array( 'false', '0', 'no', 'n' );
		return ( ! $var || in_array( strtolower( $var ), $falsey ) ) ? false : true;
	}
}
