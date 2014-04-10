/*global _:false, QTags:false, tinymce:false, wp:false */

(function( window, $, undefined ) {
	'use strict';

	var editor = {
		/**
		 * Insert content in the active editor at the current caret position.
		 * Selected content will be replaced.
		 *
		 * @global QTags
		 * @global tinymce
		 * @global wpActiveEditor
		 *
		 * @param {string} content Content to insert.
		 */
		insert: function( content ) {
			var ed = this.getTinyMce(),
				wpActiveEditor = window.wpActiveEditor;

			if ( false === ed ) {
				return false;
			}

			if ( ed && ! ed.isHidden() ) {
				// Restore caret position in IE.
				if ( tinymce.isIE && ed.windowManager.insertimagebookmark ) {
					ed.selection.moveToBookmark( ed.windowManager.insertimagebookmark );
				}

				ed.execCommand( 'mceInsertContent', false, content );
			} else if ( 'undefined' !== typeof QTags ) {
				QTags.insertContent( content );
			} else {
				document.getElementById( wpActiveEditor ).value += content;
			}
		},

		/**
		 * Insert a shortcode in the editor.
		 *
		 * @global _
		 * @global wp.shortcode
		 *
		 * @param {Object} shortcode Shortcode object as defined in wp.shortcode().
		 */
		insertShortcode: function( shortcode ) {
			var selection = this.getSelection();

			shortcode = _.extend({
				content: '',
				tag: '',
				type: 'closed'
			}, shortcode );

			if ( selection ) {
				// Replace any nested shortcodes.
				shortcode.content = wp.shortcode.replace( shortcode.tag, selection, function( match ) {
					return match.content;
				});
			}

			this.insert( wp.shortcode.string( shortcode ) );
		},

		/**
		 * Retrieve text selected in the editor.
		 *
		 * @global QTags
		 * @global wpActiveEditor
		 *
		 * @return {string} Selected text.
		 */
		getSelection: function() {
			var ed = this.getTinyMce(),
				selection = '',
				wpActiveEditor = window.wpActiveEditor,
				end, start;

			if ( false === ed ) {
				return false;
			}

			if ( ed && ! ed.isHidden() ) {
				selection = ed.selection.getContent();
			} else if ( 'undefined' !== typeof QTags ) {
				ed = QTags.getInstance( wpActiveEditor );
				start = ed.canvas.selectionStart;
				end = ed.canvas.selectionEnd;

				if ( end - start > 0 ) {
					selection = ed.canvas.value.substring( start, end );
				}
			}

			return selection;
		},

		/**
		 * Retrieve the current instance of TinyMCE.
		 *
		 * @global QTags
		 * @global tinymce
		 * @global wpActiveEditor
		 *
		 * @return {Object|bool} TinyMCE instance, null, or false.
		 */
		getTinyMce: function() {
			var mce = 'undefined' !== typeof tinymce,
				qt = 'undefined' !== typeof QTags,
				wpActiveEditor = window.wpActiveEditor,
				ed;

			if ( ! wpActiveEditor ) {
				if ( mce && tinymce.activeEditor ) {
					ed = tinymce.activeEditor;
					wpActiveEditor = window.wpActiveEditor = ed.id;
				} else if ( ! qt ) {
					return false;
				}
			} else if ( mce ) {
				if ( tinymce.activeEditor && ( 'mce_fullscreen' === tinymce.activeEditor.id || 'wp_mce_fullscreen' === tinymce.activeEditor.id ) ) {
					ed = tinymce.activeEditor;
				} else {
					ed = tinymce.get( wpActiveEditor );
				}
			}

			return ed;
		}
	};

	// Document ready.
	$(function( $ ) {
		var $group = $( '.bing-translator-button-group' );

		// Toggle the 'is-open' class.
		$group.on( 'click', '.button', function( e ) {
			var $group = $( this ).closest( '.bing-translator-button-group' );
			e.preventDefault();
			$group.toggleClass( 'is-open', ! $group.hasClass( 'is-open' ) );
		});

		// Handle dropdown menu item actions.
		$group.on( 'click', '.bing-translator-dropdown-menu a', function( e ) {
			var $this = $( this ),
				$group = $this.closest( '.bing-translator-button-group' ).removeClass( 'is-open' ),
				action = $this.data( 'bing-translator' );

			e.preventDefault();

			// Set the active editor.
			window.wpActiveEditor = $group.data( 'editor' );

			if ( 'insert-widget' === action ) {
				// @todo Is there a way to remove existing shortcodes to prevent duplicates?
				editor.insert( '[bing_translator]' );
			} else if ( 'notranslate' === action ) {
				editor.insertShortcode({ tag: 'notranslate' });
			}
		});
	});
})( this, jQuery );
