<?php 

namespace Inc\settings;

class Settings{

    public function __construct()
    {
        add_action('admin_menu',array($this, 'settingPageFunction'),20);
		add_action('admin_init',array($this, 'settingFields'));
    }
    public static function settingPageFunction() {
		add_submenu_page( 'edit.php?post_type=user-preferences',
                                 'Preference Settings Page ',
                                    'Preference Settings',
                                  'manage_options', 
                                  'preference-settings', 
                                  array(__CLASS__, 'settingApiPage'), 
                                   );
	}
    public static function settingApiPage(){
        include_once 'admin-page.php';
    }
    public  function settingFields(){
        register_setting( 'userPreferencesGroup', 'user_preferences_settings' );
		add_settings_section(
			'main_preferences_section',
			__( 'User Preferences Settings' ),
			array($this, 'userPreferencesSectionRender'),
			'preferencesPage'
		);
        
        add_settings_field(
			'offer_form',
			__( 'Form Id' ),
			array($this, 'offerFormIdRender'),
			'preferencesPage',
			'main_preferences_section'
		);
    }
    public   function userPreferencesSectionRender(  ) {
		echo __( 'Settings for user preferences Plugin', 'wordpress' );
	}
    public   function offerFormIdRender(){
        $options = get_option( 'user_preferences_settings' );
        ?>
         <div class="form-group">
            <input type="text" id="form_id" name='user_preferences_settings[form_id]'    value='<?php echo isset($options['form_id'])?$options['form_id']:''; ?>'>
         </div>
    
        <?php
        }
}