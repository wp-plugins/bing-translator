<?php
/**
 * Plugin settings.
 *
 * @since 1.0.0
 *
 * @package BingTranslator
 * @copyright Copyright (c) 2014, Microsoft Open Technologies, Inc. All rights reserved.
 * @license GPL-2.0+
 */

/**
 * Plugin settings class.
 *
 * @package BingTranslator
 * @since 1.0.0
 */
class Bing_Translator_Settings {
	/**
	 * Embedded widget alignment.
	 *
	 * @since 1.0.0
	 * @type string $align center|left|right
	 */
	protected $align;

	/**
	 * Community Translation Feature status.
	 *
	 * @since 1.0.0
	 * @type bool $enable_ctf
	 */
	protected $enable_ctf;

	/**
	 * When to translate mode.
	 *
	 * @since 1.0.0
	 * @type string $mode manual|auto
	 */
	protected $mode;

	/**
	 * Widget color scheme.
	 *
	 * @since 1.0.0
	 * @type string $theme dark|light
	 */
	protected $theme;

	/**
	 * Constructor method.
	 *
	 * The settings object is initialized with the defaults, then updated with
	 * any site-wide settings saved via the administration screen, and finally
	 * updated with custom overrides passed through the $args parameter.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args {
	 *     Optional. Defaults to site-wide settings.
	 *
	 *     @type bool $enable_ctf Whether the Community Translation Feature should be enabled.
	 *     @type string $mode When to translate the page. Accepts manual or auto.
	 *     @type string $theme Widget color scheme. Accepts dark or light.
	 * }
	 */
	public function __construct( $args = array() ) {
		$defaults = $this->get_defaults();

		// Initialize with defaults.
		$this->merge_settings( $defaults );

		// Update with any saved settings.
		$this->merge_settings( (array) get_option( 'bing_translator' ) );

		// Update with passed args.
		$this->merge_settings( $args );
	}

	/**
	 * Retrieve default settings.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_defaults() {
		return array(
			'align'      => '',
			'enable_ctf' => true,
			'mode'       => 'manual',
			'theme'      => 'dark',
		);
	}

	/**
	 * Retrieve a setting value by key.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Optional. Setting key. Defaults to returning all settings.
	 * @return mixed
	 */
	public function get_setting( $key = 'all' ) {
		$defaults = $this->get_defaults();
		$settings = wp_parse_args( get_object_vars( $this ), $defaults );
		$settings = array_intersect_key( $settings, $defaults );

		if ( 'all' != $key ) {
			return isset( $settings[ $key ] ) ? $settings[ $key ] : false;
		}

		return $settings;
	}

	/**
	 * Define a setting.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Setting key.
	 * @param mixed $value Setting value.
	 */
	public function set_setting( $key, $value ) {
		switch ( $key ) {
			case 'align' :
				$value = strtolower( $value );
				if ( in_array( $value, array( 'center', 'left', 'right' ) ) ) {
					$this->align = $value;
				}
				break;
			case 'enable_ctf' :
				$this->enable_ctf = ( empty( $value ) || ! $value ) ? false : true;
				break;

			case 'mode' :
				$value = strtolower( $value );
				if ( in_array( $value, array( 'manual', 'auto' ) ) ) {
					$this->mode = $value;
				}
				break;

			case 'theme' :
				$value = strtolower( $value );
				if ( in_array( $value, array( 'dark', 'light' ) ) ) {
					$this->theme = $value;
				}
				break;
		}
	}

	/**
	 * Merge list of settings with the current object.
	 *
	 * Settings passed in the first argument will update the current object. If
	 * the value for a particular key is invalid, it won't be saved and the
	 * existing value for the setting will be returned.
	 *
	 * The default is to merge valid settings back into the passed array and
	 * return all keys, however, passing 'intersect' as the second argument will
	 * remove invalid settings keys from the passed array before returning it.
	 *
	 * This can be used as a simple method for sanitizing settings.
	 *
	 * @since 1.0.0
	 *
	 * @param array $settings List of setting key-value pairs.
	 * @param array $diff Optional. What to do with keys that don't match default settings.
	 * @return array Merged settings array.
	 */
	public function merge_settings( $settings, $diff = '' ) {
		if ( is_array( $settings ) ) {
			foreach ( $settings as $key => $value ) {
				$this->set_setting( $key, $value );
			}
		}

		$settings = wp_parse_args( $this->get_setting(), $settings );

		if ( 'intersect' == $diff ) {
			$settings = array_intersect_key( $settings, $this->get_defaults() );
		}

		return $settings;
	}
}
