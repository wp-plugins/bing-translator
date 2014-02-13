<?php
/**
 * @package Bing Translator
 * @author Websiteguy
 * @version 0.1
*/
/*
Plugin Name: Bing Translator
Plugin URI: http://wordpress.org/plugins/bing-translator/
Version: 0.1
Description: Display the translator in two ways, widget, or shortcode. <code>[tb]</code>.
Author: Websiteguy
Author URI: http://profiles.wordpress.org/kidsguide/
Tested up to WordPress 3.8.1
*/
/*
License:

@Copyright 2013 - 2014 Websiteguy (email : mpsparrow@cogeco.ca)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function HelloWorldShortcode() {
	return "<div id='MicrosoftTranslatorWidget' class='Dark' style='color:white;background-color:#555555'></div><script type='text/javascript'>setTimeout(function(){{var s=document.createElement('script');s.type='text/javascript';s.charset='UTF-8';s.src=((location && location.href && location.href.indexOf('https') == 0)?'https://ssl.microsofttranslator.com':'http://www.microsofttranslator.com')+'/ajax/v3/WidgetV3.ashx?siteData=ueOIGRSKkd965FeEGM5JtQ**&ctf=False&ui=true&settings=Auto&from=en';var p=document.getElementsByTagName('head')[0]||document.documentElement;p.insertBefore(s,p.firstChild); }},0);</script>";
}
add_shortcode('tb', 'HelloWorldShortcode');

add_action( 'widgets_init', create_function( '', 'register_widget( "Translator_Button" );' ) );

class Translator_Button extends WP_Widget {

public function __construct() {
parent::__construct(
'bapi_google_translate', // Base ID
'Translator Button', // Name
array( 'description' => __( 'A simple bing translator button.', 'text_domain' ), ) // Args
);
}

public function widget( $args, $instance ) {

$title = null;

extract( $args );

if (! empty( $instance['title'] ) ) { $title = apply_filters('widget_title', $instance['title'] ); }


echo $before_widget;
echo "<div id='MicrosoftTranslatorWidget' class='Dark' style='color:white;background-color:#555555'></div><script type='text/javascript'>setTimeout(function(){{var s=document.createElement('script');s.type='text/javascript';s.charset='UTF-8';s.src=((location && location.href && location.href.indexOf('https') == 0)?'https://ssl.microsofttranslator.com':'http://www.microsofttranslator.com')+'/ajax/v3/WidgetV3.ashx?siteData=ueOIGRSKkd965FeEGM5JtQ**&ctf=False&ui=true&settings=Auto&from=en';var p=document.getElementsByTagName('head')[0]||document.documentElement;p.insertBefore(s,p.firstChild); }},0);</script>";
echo $after_widget;
}

} 
?>