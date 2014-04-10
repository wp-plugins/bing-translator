<?php
/**
 * Settings administration screen.
 *
 * @since 1.0.0
 *
 * @package BingTranslator
 * @copyright Copyright (c) 2014, Microsoft Open Technologies, Inc. All rights reserved.
 * @license GPL-2.0+
 */

/**
 * Settings administration screen class.
 *
 * @package BingTranslator
 * @since 1.0.0
 */
class Bing_Translator_Admin_Screen_Settings {
	/**
	 * Plugin settings.
	 *
	 * @since 1.0.0
	 * @type Bing_Translator_Settings
	 */
	protected $settings;

	/**
	 * Constructor method.
	 *
	 * Copies the plugin settings object to a local property on initialization.
	 *
	 * @since 1.0.0
	 *
	 * @param Bing_Translator_Settings $settings Plugin settings.
	 */
	public function __construct( Bing_Translator_Settings $settings ) {
		$this->settings = $settings;
	}

	/**
	 * Load the settings screen.
	 *
	 * Should not be called before 'admin_menu'.
	 *
	 * @since 1.0.0
	 */
	public function load() {
		self::add_menu_item();
		self::register_settings();
		self::add_sections();
		self::add_settings();
	}

	/**
	 * Add the settings menu item.
	 *
	 * @since 1.0.0
	 */
	public function add_menu_item() {
		add_options_page(
			__( 'Bing Translator', 'bing-translator' ),
			__( 'Bing Translator', 'bing-translator' ),
			'manage_options',
			'bing-translator',
			array( $this, 'render_screen' )
		);

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Register the settings option.
	 *
	 * @since 1.0.0
	 */
	public function register_settings() {
		register_setting( 'bing-translator', 'bing_translator', array( $this, 'sanitize_settings' ) );
	}

	/**
	 * Add settings sections.
	 *
	 * @since 1.0.0
	 */
	public function add_sections() {
		add_settings_section(
			'translation-settings',
			__( 'Translation Settings', 'bing-translator' ),
			'__return_null',
			'bing-translator'
		);

		add_settings_section(
			'colors',
			__( 'Pick a Color', 'bing-translator' ),
			'__return_null',
			'bing-translator'
		);

		add_settings_section(
			'community-translations',
			__( 'Community Translations', 'bing-translator' ),
			'__return_null',
			'bing-translator'
		);
	}

	/**
	 * Register individual settings.
	 *
	 * @since 1.0.0
	 */
	public function add_settings() {
		add_settings_field(
			'mode',
			__( 'When to translate', 'bing-translator' ),
			array( $this, 'render_field_mode' ),
			'bing-translator',
			'translation-settings'
		);

		add_settings_field(
			'theme',
			__( 'Theme', 'bing-translator' ),
			array( $this, 'render_field_theme' ),
			'bing-translator',
			'colors'
		);

		add_settings_field(
			'enable_ctf',
			__( 'Enable Community Translations', 'bing-translator' ),
			array( $this, 'render_field_enable_ctf' ),
			'bing-translator',
			'community-translations'
		);
	}

	/**
	 * Sanitize options.
	 *
	 * @since 1.0.0
	 */
	public function sanitize_settings( $value ) {
		if ( ! isset( $value['enable_ctf' ] ) ) {
			$value['enable_ctf'] = false;
		}

		// Sanitize the settings.
		$settings = new Bing_Translator_Settings();
		$value = $settings->merge_settings( $value, 'intersect' );

		return $value;
	}

	/**
	 * Enqueue the admin style sheet.
	 *
	 * @since 1.0.0
	 *
	 * @param string $hook_suffix Screen id.
	 */
	public function enqueue_assets( $hook_suffix ) {
		if ( 'settings_page_bing-translator' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style( 'bing-translator-admin' );
	}

	/**
	 * Display the screen.
	 *
	 * @since 1.0.0
	 */
	public function render_screen() {
		include( BING_TRANSLATOR_PATH . 'admin/views/screen-settings.php' );
	}

	/**
	 * Display the mode settings field.
	 *
	 * @since 1.0.0
	 */
	public function render_field_mode() {
		$mode = $this->settings->get_setting( 'mode' );
		?>
		<p class="bing-translator-togglable-field">
			<label>
				<input type="radio" name="bing_translator[mode]" id="bing-translator-mode-manual" value="manual" <?php checked( $mode, 'manual' ); ?>>
				<?php _e( 'Manual', 'bing-translator' ); ?>
			</label><br>
			<span class="description"><?php _e( 'Translate when visitor clicks on the translate button.', 'bing-translator' ); ?></span>
		</p>
		<p class="bing-translator-togglable-field">
			<label>
				<input type="radio" name="bing_translator[mode]" id="bing-translator-mode-automatic" value="auto" <?php checked( $mode, 'auto' ); ?>>
				<?php _e( 'Automatic', 'bing-translator' ); ?>
			</label><br>
			<span class="description"><?php _e( 'Translate automatically based on the visitor’s browser language.', 'bing-translator' ); ?></span>
		</p>
		<?php
	}

	/**
	 * Display the theme settings field.
	 *
	 * @since 1.0.0
	 */
	public function render_field_theme() {
		$theme = $this->settings->get_setting( 'theme' );
		?>
		<p class="bing-translator-togglable-field">
			<label>
				<input type="radio" name="bing_translator[theme]" id="bing-translator-theme-dark" value="dark" <?php checked( $theme, 'dark' ); ?>>
				<?php _e( 'Dark', 'bing-translator' ); ?>
			</label><br>
			<span class="description"><?php _e( 'Best for pages with a light background.', 'bing-translator' ); ?></span>
		</p>
		<p class="bing-translator-togglable-field">
			<label>
				<input type="radio" name="bing_translator[theme]" id="bing-translator-theme-light" value="light" <?php checked( $theme, 'light' ); ?>>
				<?php _e( 'Light', 'bing-translator' ); ?>
			</label><br>
			<span class="description"><?php _e( 'Best for pages with a dark background.', 'bing-translator' ); ?></span>
		</p>
		<?php
	}

	/**
	 * Display the settings field to enable Community Translations.
	 *
	 * @since 1.0.0
	 */
	public function render_field_enable_ctf() {
		$is_enabled = $this->settings->get_setting( 'enable_ctf' );
		?>
		<p class="bing-translator-togglable-field">
			<label>
				<input type="checkbox" name="bing_translator[enable_ctf]" id="bing-translator-enable-ctf" value="1" <?php checked( $is_enabled ); ?>>
				<?php _e( 'Allow visitors to suggest translations?', 'bing-translator' ); ?>
			</label><br>
			<span class="description"><?php _e( 'The translations submitted by a visitor become available to other visitors as alternatives. By default, these alternatives will never replace the default translation.', 'bing-translator' ); ?></span>
		</p>
		<?php
	}
}
