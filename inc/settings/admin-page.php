<?php 
?>
<form  id="user_preferences" action='options.php' method='post'>

	<?php
	 $options = get_option( 'user_preferences_settings' );
	settings_fields('userPreferencesGroup');
	do_settings_sections('preferencesPage');
	submit_button( $text = 'submit',  $type = 'primary',  $name = 'submit_main');
	?>
</form>