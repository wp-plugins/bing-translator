<?php
/**
 * Embedded widget HTML.
 *
 * @since 1.0.0
 *
 * @package BingTranslator
 * @copyright Copyright (c) 2014, Microsoft Open Technologies, Inc. All rights reserved.
 * @license GPL-2.0+
 */

/**
 * Embedded widget HTML class.
 *
 * @package BingTranslator
 * @since 1.0.0
 */
class Bing_Translator_Embed {
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
	 * Print the embedded Bing Translator widget HTML and script.
	 *
	 * @since 1.0.0
	 */
	public function render() {
		$align      = $this->settings->get_setting( 'align' );
		$enable_ctf = $this->settings->get_setting( 'enable_ctf' ) ? 'True' : 'False';
		$mode       = ucwords( preg_replace( '/[^a-zA-Z]+/', '', $this->settings->get_setting( 'mode' ) ) );
		$theme      = ucwords( preg_replace( '/[^a-zA-Z]+/', '', $this->settings->get_setting( 'theme' ) ) );

		switch( $theme ) {
			case 'Light' :
				$background = 'transparent';
				break;
			default :
				$background = '#555';
		}

		$classes[] = 'bing-translator-widget';
		$classes[] = $theme;
		$classes[] = $align ? 'align' . $align : '';
		$classes   = array_map( 'sanitize_html_class', array_filter( $classes ) ) ;

		$snippet = $this->get_snippet();

		$replace = array(
			'{0}' => esc_js( implode( ' ', $classes ) ),
			'{1}' => esc_js( $enable_ctf ),
			'{2}' => esc_js( $mode ),
			'{3}' => '',
		);

		echo str_replace( array_keys( $replace ), $replace, $snippet );
	}

	/**
	 * Retrieve the code snippet.
	 *
	 * Fetches the code from the snippet service first and caches it for a day.
	 * A static fallback is used if the snippet service can't be reached.
	 *
	 * The snippet has the following placeholders:
	 * - {0} - String. Color scheme (Dark|Light).
	 * - {1} - String. Allow visitors to suggest translations (True|False).
	 * - {2} - String. Translate automatically or manually (Auto|Manual).
	 * - {3} - String. Language to translate from. Any value out of GetLanguagesForTranslate() method.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_snippet() {
		$transient_key = 'bing_translator_snippet';
		$snippet = get_transient( $transient_key );

		if ( ! $snippet ) {
			$response = wp_remote_get( 'http://www.microsofttranslator.com/ajax/v3/snippet.ashx?platform=wordpress' );
			if ( ! is_wp_error( $response ) && 200 == wp_remote_retrieve_response_code( $response ) ) {
				$snippet = wp_remote_retrieve_body( $response );
				set_transient( $transient_key, $snippet, 86400 ); // 1 day.
			} else {
				$snippet = "<div id='MicrosoftTranslatorWidget' class='{0}' style='color:white;background-color:#555555'></div><script type='text/javascript'>setTimeout(function(){{var s=document.createElement('script');s.type='text/javascript';s.charset='UTF-8';s.src=((location && location.href && location.href.indexOf('https') == 0)?'https://ssl.microsofttranslator.com':'http://www.microsofttranslator.com')+'/ajax/v3/WidgetV3.ashx?siteData=ueOIGRSKkd965FeEGM5JtQ**&ctf={1}&ui=true&settings={2}&from={3}';var p=document.getElementsByTagName('head')[0]||document.documentElement;p.insertBefore(s,p.firstChild); }},0);</script>";
			}
		}

		return $snippet;
	}
}
