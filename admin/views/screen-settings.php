<div class="wrap">
	<h2 class="bing-translator-screen-title">
		<img src="<?php echo esc_url( BING_TRANSLATOR_URL . 'admin/assets/images/bing-logo.png' ); ?>" alt="<?php esc_attr_e( 'Bing', 'bing-translator' ); ?>" width="70" height="27">
		<?php _e( 'Translator Widget', 'bing-translator' ); ?>
	</h2>

	<form action="options.php" method="post">
		<?php settings_fields( 'bing-translator' ); ?>
		<?php do_settings_sections( 'bing-translator' ); ?>
		<?php submit_button(); ?>
	</form>
</div>
