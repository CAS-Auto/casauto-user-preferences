<?php 
namespace Inc\shortCode;

class ShortCode{

    public function __construct()
    {
        add_shortcode('user-preferences', array($this, 'handle'));
    }
    public function handle(){
        $options = get_option( 'user_preferences_settings' );
        $formId = $options['form_id'];
        $currentUser = wp_get_current_user();
       $userId = $currentUser->ID;
       $nonce = wp_create_nonce('wp_rest');
       $args = array(
        'post_type' => 'user-preferences', 
        'posts_per_page' => -1,  
        'meta_query' => array( 
                            array(
                                'key' => 'user_id',
                                'value'=> $userId,
                                'compare'=> '='  

                            )
            )
    );
    
    $userPreferences = get_posts($args);
    if(!empty($userPreferences)){
        $meanContact = get_field('contact_mean', $userPreferences[0]->ID);
        $vehicleType = get_field('vehicle_types', $userPreferences[0]->ID);

        $term = get_term_by('name', $vehicleType, 'product_tag');
         $termId = $term->term_id;
      
    
    }
 

        ob_start(); ?>
       <div class="casauto-preferences-wrapper" data-user="<?php echo $userId?>" 
                    data-form-id = "<?php echo $formId ?>" 
                            data-nonce ="<?=$nonce ?> "  
                                        data-contact="<?php echo !empty($meanContact)? $meanContact: '' ?>" 
                                        data-vehicle-type=<?php echo !empty($termId)? $termId: '' ?>      >
       <!-- <pre style="display: none;">
           <?php // echo !empty($vehicleTypes)? wp_json_encode($vehicleTypesIds): '' ?></pre> -->
           <h3 style="text-align: center">User preferences</h3>
           
            <?php echo do_shortcode("[wpforms id='".$formId."']"); ?>
       </div>

        <?php return ob_get_clean();
    }
}
