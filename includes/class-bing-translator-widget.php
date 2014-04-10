<?php
/**
 * Bing Translator WordPress widget.
 *
 * @since 1.0.0
 *
 * @package BingTranslator
 * @copyright Copyright (c) 2014, Microsoft Open Technologies, Inc. All rights reserved.
 * @license GPL-2.0+
 */

/**
 * Bing Translator WordPress widget class.
 *
 * @package BingTranslator
 * @since 1.0.0
 */
class Bing_Translator_Widget extends WP_Widget {
	/**
	 * Setup widget options.
	 *
	 * @since 1.0.0
	 * @see WP_Widget::__construct()
	 */
	public function __construct( $id_base = false, $name = false, $widget_options = array(), $control_options = array() ) {
		$id_base = ( $id_base ) ? $id_base : 'bing-translator';
		$name = ( $name ) ? $name : __( 'Bing Translator', 'bing-translator' );

		$widget_options = wp_parse_args( $widget_options, array(
			'classname'   => 'widget_bing_translator',
			'description' => __( 'Embed a Bing Translator widget', 'bing-translator' ),
		) );

		$control_options = wp_parse_args( $control_options, array() );

		parent::__construct( $id_base, $name, $widget_options, $control_options );
	}

	/**
	 * Display the widget.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Args specific to the widget area (sidebar).
	 * @param array $instance Widget instance settings.
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $before_widget;

			echo empty( $instance['title'] ) ? '' : $before_title . $instance['title'] . $after_title;

			if ( ! $output = apply_filters( 'bing_translator_widget_output', '', $instance, $args ) ) {
				bing_translator( $instance );
			}

		echo $after_widget;
	}

	/**
	 * Save widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance New widget settings.
	 * @param array $old_instance Old widget settings.
	 */
	public function update( $new_instance, $old_instance ) {
		$new_instance['title']      = wp_strip_all_tags( $new_instance['title'] );
		$new_instance['enable_ctf'] = isset( $new_instance['enable_ctf'] );

		$settings = new Bing_Translator_Settings();
		$instance = $settings->merge_settings( $new_instance );

		return $instance;
	}

	/**
	 * Form to modify widget instance settings.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Current widget instance settings.
	 */
	public function form( $instance ) {
		$instance['title'] = isset( $instance['title'] ) ? $instance['title'] : '';

		// Merge sanitized settings into the instance settings.
		$settings = new Bing_Translator_Settings();
		$instance = $settings->merge_settings( $instance );

		$title = wp_strip_all_tags( $instance['title'] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'bing-translator' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat">
		</p>

		<h4><?php _e( 'Translation Settings', 'bing-translator' ); ?></h4>
		<p>
			<label>
				<input type="radio"
					name="<?php echo $this->get_field_name( 'mode' ); ?>"
					id="<?php echo $this->get_field_id( 'mode-manual' ); ?>"
					value="manual"
					<?php checked( $instance['mode'], 'manual' ); ?>>
				<?php _e( 'Manual', 'bing-translator' ); ?>
			</label>
			<span class="bing-translator-tooltip">
				<span class="bing-translator-tooltip-tip"><?php _e( 'Translate when visitor clicks on the translate button.', 'bing-translator' ); ?></span>
			</span>
			<br>
			<label>
				<input type="radio"
					name="<?php echo $this->get_field_name( 'mode' ); ?>"
					id="<?php echo $this->get_field_id( 'mode-automatic' ); ?>"
					value="auto"
					<?php checked( $instance['mode'], 'auto' ); ?>>
				<?php _e( 'Automatic', 'bing-translator' ); ?>
			</label>
			<span class="bing-translator-tooltip">
				<span class="bing-translator-tooltip-tip"><?php _e( 'Translate automatically based on the visitor’s browser language.', 'bing-translator' ); ?></span>
			</span>
		</p>

		<h4><?php _e( 'Pick a Color', 'bing-translator' ); ?></h4>
		<p>
			<label>
				<input type="radio"
					name="<?php echo $this->get_field_name( 'theme' ); ?>"
					id="<?php echo $this->get_field_id( 'theme-dark' ); ?>"
					value="dark"
					<?php checked( $instance['theme'], 'dark' ); ?>>
				<?php _e( 'Dark', 'bing-translator' ); ?>
			</label>
			<span class="bing-translator-tooltip">
				<span class="bing-translator-tooltip-tip"><?php _e( 'Best for pages with a light background.', 'bing-translator' ); ?></span>
			</span>
			<br>
			<label>
				<input type="radio"
					name="<?php echo $this->get_field_name( 'theme' ); ?>"
					id="<?php echo $this->get_field_id( 'theme-light' ); ?>"
					value="light" <?php checked( $instance['theme'], 'light' ); ?>>
				<?php _e( 'Light', 'bing-translator' ); ?>
			</label>
			<span class="bing-translator-tooltip">
				<span class="bing-translator-tooltip-tip"><?php _e( 'Best for pages with a dark background.', 'bing-translator' ); ?></span>
			</span>
		</p>

		<h4><?php _e( 'Community Translations', 'bing-translator' ); ?></h4>
		<p>
			<label>
				<input type="checkbox"
					name="<?php echo $this->get_field_name( 'enable_ctf' ); ?>"
					id="<?php echo $this->get_field_id( 'enable-ctf' ); ?>"
					value="1"
					<?php checked( $instance['enable_ctf'] ); ?>>
				<?php _e( 'Allow visitors to suggest translations?', 'bing-translator' ); ?>
			</label>
		</p>
		<?php
	}
}
