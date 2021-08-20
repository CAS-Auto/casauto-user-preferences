<?php 

namespace Inc\customFieldPopulate;

class CustomFIeldPopulate{

    public function __construct()
    {
        add_filter('acf/load_field/key=field_610c393e6cbdc',  array($this, 'populateVehicleTag'));
    }

    private function populateAttr($field , $terms){
     
        $field['choices'] = array();
       
        $terms = get_terms([
            'taxonomy' => $terms,
            'hide_empty' => false,
        ]);
        
    
        $choices = [];
        $i= 0;
        if($terms){

            foreach($terms as  $term){
                $choices[$i] = $term->name;
                $i++;
                
            }   
        }
        
       
        $choices = array_map('trim', $choices);
      
       
        // loop through array and add to field 'choices'
        if( is_array($choices) ) {
           
            foreach( $choices as $choice ) {
                
                $field['choices'][ $choice ] = $choice;
                
            }
            
        }
        
       
        return $field;
    }
    function populateVehicleTag($field){
        return $this->populateAttr($field, 'product_tag');
    }
}