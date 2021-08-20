<?php

namespace Inc;

class Scripts{

    public function __construct(){
         add_action('wp_enqueue_scripts', array($this, 'addFrontScripts'));
    }
   
    function addFrontScripts(){

      if(is_page('my-account')) {
            wp_enqueue_script('handle_form', plugin_dir_url(__DIR__).'build/index.js', array(), '', true  );
            wp_enqueue_style('handle_form_css',plugin_dir_url(__DIR__).'build/index.css');
           
          
        }
    }
}