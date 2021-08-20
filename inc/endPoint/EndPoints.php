<?php 

namespace Inc\endPoint;
use WP_REST_Response;

class EndPoints{

    function __construct()
    {
        add_action('rest_api_init', array($this, 'registerRouteQuotes'));
    }

    function registerEnpoint($route, $subRoute, $method, $functionName){
        register_rest_route("$route/v1","/$subRoute",array(
			'methods'=> $method,
			 'callback'=> array($this, $functionName)
		));
    }

    function registerRouteQuotes(){
        $this->registerEnpoint('submit-quotes', 'quotes', 'POST', 'submitData');
    }
    
    function submitData($request){

        $headers = $request->get_headers();
       
        
       
        if ( empty($headers["x_wp_nonce"]) ||
            !check_ajax_referer('wp_rest', '_wpnonce', false)) {
                $response = [
                    "ok"=>false,
                    "msg"=>"Missin nonce"
                ];
                $res = new WP_REST_Response($response);
                $res->set_status(403);
                return $res;
            }
       
        $params = $request->get_params();
        [ , , $cardType, $mean, $userId] = $params['wpforms']['fields'];
      
       
    
     
        if(!empty($cardType)){
            $vehicleTypeTerm  = get_term($cardType);
        }
      
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
        
        if(empty($userPreferences)){
            $user = get_user_by('id', $userId);
            $displayName = $user->display_name;
            
            
            $postData = array(
                'post_title'   =>$displayName.'-preferences',
                'post_type' => 'user-preferences',
                'post_status'  => 'publish',
            );
            $postId = wp_insert_post( $postData );
           
            if( $postId){
              if( update_field('user_id', $userId, $postId) &&
                 update_field('contact_mean', $mean, $postId) &&
                update_field('vehicle_types', $vehicleTypeTerm->name, $postId)
              ){
                return $response = [
                    "ok" => true,
                    "msg" => "successfull",
                ];
                $res = new WP_REST_Response($response);
                $res->set_status(201);
                return $res;
              }else{
                $response = [
                    "ok"=>false,
                    "msg"=>"Coudnt update fields"
                ];
                $res = new WP_REST_Response($response);
                $res->set_status(404);
                return $res;
              }
            }else{
                $response = [
                    "ok"=>false,
                    "msg"=>"Coudnt insert post"
                ];
                $res = new WP_REST_Response($response);
                $res->set_status(404);
                
            }        

        }
     

        $userPreferencesId = $userPreferences[0]->ID;
      


        
        if (
            update_field('contact_mean', $mean, $userPreferencesId) ||
            update_field('vehicle_types',$vehicleTypeTerm->name, $userPreferencesId)
        ) {
            update_field('contact_mean', $mean, $userPreferencesId);
            update_field('vehicle_types',$vehicleTypeTerm->name, $userPreferencesId);
            return $response = [
                "ok" => true,
                "msg" => "successfull",
            ];
            $res = new WP_REST_Response($response);
            $res->set_status(201);
            return $res;
        } else {
            echo "we are here"; 
            $response = [
                "ok" => false,
                "msg" => "Coudnt update fields"
            ];
            $res = new WP_REST_Response($response);
            $res->set_status(404);
            return $res;
        }
    }
}