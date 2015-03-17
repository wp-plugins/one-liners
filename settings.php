<div class="wrap">
	<h2><?php _e( 'Oneliners', 'thebrent_oneliners' );?></h2>
	<form method="post" action="options.php">
		<?php settings_fields( 'thebrent_oneliners_options' ); ?>
		<?php do_settings_sections( 'thebrent_oneliners_options' );?>
		<?php submit_button(); ?>
	</form>
</div>