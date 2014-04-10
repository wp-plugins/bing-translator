=== Bing Translator ===
Contributors: msopentech, ivycat, bradyvercher, sewmyheadon, Websiteguy
Tags: translation, translator, internationalization, i18n, localization
Requires at least: 3.8
Tested up to: 3.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Enable visitors to translate your site in their language in one click with the Bing Translator plugin from Microsoft Open Technologies, Inc.

== Description ==

Allow your visitors to translate any page with the simple click of a bookmark. Translation happens in place without leaving the page with this light-weight, cross-browser plugin.

= Configuration Options =

* **Translation Settings** - Set when to translate (Manual or Automatic).
* **Pick a Color** - Select a Dark or Light version of the widget to fit your site.
* **Community Translations** -  Allow visitors to suggest alternate translations.

= Video Overview =

Using Bing Translator for WordPress

https://www.youtube.com/watch?v=CNGu9uAf77k

== Installation ==

You can install this plugin from within WordPress under **Plugins > Add New** and search for "Bing Translator."

If you prefer to manually install the plugin, simply:

1. Download the plugin from WordPress.org.
1. Upload the `bing-translator` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the *Plugins* menu in WordPress.

*Video:* Installing & Configuring Bing Translator for WordPress

https://www.youtube.com/watch?v=XO4WS14ajHc

= Adding Bing Translator to Web Pages =

There are three different ways you can add the Bing Translator widget to your site's pages:

1. **Widget** - Easiest. Simply drag the Bing Translator Widget to any widget-enabled area in your WordPress theme.
1. **Shortcode** - Embed a shortcode into the editor of any post, page, or custom post type.  
1. **Template tags** - Add a simple PHP function to one of your theme's template files.

**Add Bing Translator using WordPress Widget**

The easiest way to add the Bing Translator to your site is by using a WordPress widget:

1. Install and activate the Bing Translator plugin.
1. In the WordPress Admin, go to **Appearance > Widgets**.
1. Click and drag the Bing Translator widget from the *Available Widgets* column into a widget-enabled area within your theme on the right.  The widget will open showing the options you can configure.
1. Now, you can set your title, Translation Settings, Color scheme, and whether you'd like to *Allow visitors to suggest translations*.
1. View a page that includes this widget to verify that it's working.

*Video:* Adding Bing Translator to WordPress using WordPress Widgets 

https://www.youtube.com/watch?v=LaglCuYUfrU

**Add Bing Translator using WordPress Shortcodes**

The Bing Translator plugin also allows you to add the Bing Translator to individual content pages and posts using WordPress shortcodes:

1. Open the page, post, or custom post type where you wish to embed Bing Translator.
1. Click in the editor window at the point where you'd like to include the Bing Translator widget.
1. Click on the Bing button above the WordPress editor.  It will open showing two options: *Insert Widget* and *Don't Translate.*
1. Click **Insert Widget** and the `[bing_translator]` shortcode will be placed within the content area.  Note: this widget displays inline, so you may wish to add a line break before and after to make sure it clears your existing content.
1. Click *Publish* or *Update* to save.
1. View the page or post to verify that the widget appears as you'd expect.

*Video:* Adding Bing Translator to WordPress using Shortcodes

https://www.youtube.com/watch?v=e6vXrotHH8c

**Add Bing Translator using Template Tags**

If you're a theme or plugin developer, you can add the Bing Translator directly to your WordPress theme's template files using a special PHP template tag:

1. Open the theme template that you'd like to edit.
1. Add the following function into your template where you'd like the Bing Translator widget to appear: `<?php bing_translator(); ?>`
1. Save your file.
1. Preview your site to verify the changes.

*Video:* Adding Bing Translator to WordPress using PHP Template Tags 

https://www.youtube.com/watch?v=Yxjceu7La9U

**Marking Content That Should Not be Translated**

If you have content within a post, page or custom post type that you'd like Bing Translator to skip when translating, you can wrap that content in the `[notranslate][/notranslate]` shortcode:

1. Open the post, page or custom post type.
1. Select the content that should be exempt from translation.
1. Click the Bing button above the WordPress editor and select *Don't Translate*.

The content you selected will not be translated, regardless of the visitor's settings.

== Frequently Asked Questions ==

= Do I have to sign up for an account to use this plugin? =

No, this plugin is completely free.

= How many translations do I get per month? =

There's no limit.

= Does this plugin work on pages, posts, even custom post types? =

Yes.  No problem.  Because the widget is powered by JavaScript running in the visitor's browser, it translates any web page on-the-fly.

= Do I need to set my site's main language? =

No.  The plugin uses the language settings in WordPress.  Find out more about [WordPress in your language](https://codex.wordpress.org/WordPress_in_Your_Language/ "WordPress in Your Language").

= Can I embed multiple copies of the Bing Translator in my site? =

Yes.  However, the Bing Translator will only show on each page once.  So, it's best to decide on one implementation (Widget, Template Tag, or Shortcode) and stick with it.

= Does the *Don't Translate* shortcode work if I'm embedding the Bing Translator using WordPress Widgets or Template Tags? =

Yes.  The `[notranslate][/notranslate]` shortcode will protect content from being translated regardless of how you embed the Bing Translator on your site.

= I'm confused . . . should I embed the Bing Translator using the WordPress Widget, Shortcode, or Template Tag. =

* *WordPress Widget* - For most people, this is the easiest way to go since it will automatically show on all pages and posts that use that widget area.
* *Shortcode* - Shortcodes are best for sites that only want certain content to be translateable, but it's not great if you'd like visitors to be able to translate the whole site because you have to add the `[bing_translator]` shortcode to each piece of content on which you'd like it to appear.
* *Template Tag* - Because the template tag requires editing theme templates, it's best used by developers that have knowledge of PHP and HTML.

= What arguments can I pass along with the Template Tag or Shortcode? =

If you're implementing the Bing Translator plugin using WordPress Shortcodes or Template Tags, you can change the output by passing along an array of arguments.

Here are the possible arguments:

* *align* - `center` or `left` or `right`
* *enable_ctf*- `yes` or `no`
* *mode* - `manual` or `auto`
* *theme* - `light` or `dark`

** Passing arguments to Shortcode **

`[bing_translator align="center" enable_ctf="yes" mode="manual" theme="dark"]`

** Passing arguments to Template Tag **

`bing_translator( array( 
	'align'          => '', 
	'enable_ctf' => yes, 
	'mode'         => 'manual', 
	'theme'        => 'dark', 
) );`

== Screenshots ==

1. Example page translated to Arabic using Bing Translator
2. Example page translated to Chinese using Bing Translator
3. Bing Translator main settings page
4. Add Bing Translator using a WordPress widget
5. Add Bing Translator to a post or page using a shortcode
6. Mark specific text that shouldn't be translated using the No-Translate shortcode
7. Adding the Bing Translator to a theme template using the `bing-translator' template tag

== Changelog ==

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
Initial release