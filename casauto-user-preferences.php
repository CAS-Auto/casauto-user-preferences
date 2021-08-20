<?php 

/*
Plugin Name: Casauto user preferences
Plugin URI: 
Description: This plugin has the purpose to create user preferences
Author:
Author URI:
Version: 0.1
*/

defined ('ABSPATH') or die ('Hey, you can\t access this file');

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}
   
use Inc\customPostType\Cpt;
use Inc\settings\Settings;
use Inc\customFieldPopulate\CustomFieldPopulate;
use Inc\shortCode\ShortCode;
use Inc\Scripts;
use Inc\endPoint\EndPoints;
use Inc\formSubmission\FormSubmission;


if(!class_exists('CasautoUserPreferences')){
    class CasautoUserPreferences
    {
        private static $instance = null;
        
      
        function __construct()
        {
              
           $this->register();
        
        }

        function register(){
            $cpt = new Cpt();
            $settings = new Settings();
          
            $shortCode = new ShortCode();
            $scripts = new  Scripts();
            $endpoints = new EndPoints();
            $fomSubmission = new FormSubmission();

           
        }

      
        public static function getInstance()
        {
            if (self::$instance == null) {
                
                self::$instance = new CasautoUserPreferences();
            }

            return self::$instance;
        }
        function activate()
        {

            //Flush rewrite rules
            flush_rewrite_rules();
        }

        function deactivate()
        {
            //Flush rewrite rules

            flush_rewrite_rules();
        }
        static function uninstall()
        {
            flush_rewrite_rules();
        }
    }
}

if(class_exists('CasautoUserPreferences')){
    
    $casautoUserPreferences =CasautoUserPreferences::getInstance();
}
//activation
register_activation_hook(__FILE__, array($casautoUserPreferences, 'activate'));

//deactivate
register_deactivation_hook(__FILE__, array($casautoUserPreferences, 'deactivate'));

//uninstall

register_uninstall_hook(__FILE__, 'CasautoUserPreferences::uninstall');