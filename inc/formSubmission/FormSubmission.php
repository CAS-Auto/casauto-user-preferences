<?php
namespace Inc\formSubmission;

class FormSubmission{

    public function __construct()
    {
        add_action( 'wpforms_frontend_output_success', array($this,'handleFormSubmission'), 100, 3 );
    }

    function handleFormSubmission(  $form_data, $fields, $entry_id ) {
       
        $options = get_option( 'user_preferences_settings' );
        $formId = $options['form_id'];
        

        // Optional, you can limit to specific forms. Below, we restrict output to form #235.
        if ( absint( $form_data['id'] ) !== intval($formId) ) {
            return;
        }
                    // Reset the fields to blank
            unset(
                $_GET['wpforms_return'],
                $_POST['wpforms']['id']
            );
     
            // If you want to preserve the user entered values in form fields - remove the line below.
            unset( $_POST['wpforms']['fields'] );
     
            // Actually render the form.
            wpforms()->frontend->output( $form_data['id'] );
      
    }

}