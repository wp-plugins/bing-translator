<?php
/**
 * Plugin administration.
 *
 * @since 1.0.0
 *
 * @package BingTranslator
 * @copyright Copyright (c) 2014, Microsoft Open Technologies, Inc. All rights reserved.
 * @license GPL-2.0+
 */

/**
 * Plugin administration setup class.
 *
 * @package BingTranslator
 * @since 1.0.0
 */
class Bing_Translator_Admin {
	/**
	 * Load administration functionality.
	 *
	 * @since 1.0.0
	 */
	public function load() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_assets' ), 1 );
		add_action( 'sidebar_admin_setup', array( $this, 'enqueue_assets' ) );
		add_action( 'media_buttons', array( $this, 'editor_button' ), 15 );
	}

	/**
	 * Add the Bing Translator settings screen.
	 *
	 * @since 1.0.0
	 */
	public function admin_menu() {
		$settings = new Bing_Translator_Settings();

		$screen = new Bing_Translator_Admin_Screen_Settings( $settings );
		$screen->load();
	}

	/**
	 * Register scripts and style sheets.
	 *
	 * @since 1.0.0
	 */
	public function register_assets() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_style( 'bing-translator-admin', BING_TRANSLATOR_URL . 'admin/assets/css/admin' . $suffix . '.css' );
		wp_style_add_data( 'bing-translator-admin', 'rtl', 'replace' );
		wp_style_add_data( 'bing-translator-admin', 'suffix', $suffix );
		wp_register_script( 'bing-translator-editor', BING_TRANSLATOR_URL . 'admin/assets/js/editor' . $suffix . '.js', array( 'shortcode' ) );
	}

	/**
	 * Enqueue the admin style sheet on the widgets screen.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_assets() {
		wp_enqueue_style( 'bing-translator-admin' );
	}

	/**
	 * Display a button above the editor to insert the [bing_translator] shortcode.
	 *
	 * @since 1.0.0
	 *
	 * @param string $editor_id The editor ID.
	 */
	public function editor_button( $editor_id ) {
		wp_enqueue_style( 'bing-translator-admin' );
		wp_enqueue_script( 'bing-translator-editor' );
		?>
		<div class="bing-translator-button-group" data-editor="<?php echo esc_attr( $editor_id ); ?>">
			<button class="button" title="<?php esc_attr_e( 'Bing Translator', 'bing-translator' ); ?>">
				<img src="<?php echo esc_url( BING_TRANSLATOR_URL . 'admin/assets/images/bing-logo-small.png' ); ?>" alt="<?php esc_attr_e( 'Bing Translator', 'bing-translator' ); ?>" width="44" height="17">
			</button>
			<ul class="bing-translator-dropdown-menu">
				<li><a href="#" data-bing-translator="insert-widget"><?php _e( 'Insert Widget', 'bing-translator' ); ?></a></li>
				<li><a href="#" data-bing-translator="notranslate"><?php _e( "Don't Translate", 'bing-translator' ); ?></a></li>
			</ul>
		</div>
		<?php
	}
}
