<?php
/**
 * General API functions.
 *
 * @since 1.0.0
 *
 * @package BingTranslator
 * @copyright Copyright (c) 2014, Microsoft Open Technologies, Inc. All rights reserved.
 * @license GPL-2.0+
 */

/**
 * Template tag to display the Bing Translator widget.
 *
 * @since 1.0.0
 * @see Bing_Translator_Settings::__construct()
 *
 * @param array $args Optional. Custom settings overrides. Defaults to site-wide settings.
 */
function bing_translator( $args = array() ) {
	static $instance = 0;
	$instance++;

	if ( $instance > 1 ) {
		return;
	}

	$settings = new Bing_Translator_Settings( $args );

	$embed = new Bing_Translator_Embed( $settings );
	$embed->render();
}
