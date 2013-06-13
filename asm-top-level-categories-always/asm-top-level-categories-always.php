<?php 
 
/**
 * Will display all top level categories always
 * Will only display child categories if on the parent or child of parent
 * 
 * This will affect the second row as well, instead of the default 3rd row only
 */ 
 
 add_filter( 'advanced_sidebar_menu_category_ids', array( $this, 'allTopCategories' ) );
     function allTopCategories($term_ids){
       //Once inside the function it grabs all the product_category ids             
    
                 $terms =  get_terms(
                                    'product_category',
                                    array(
                                       
                                        'order_by' => 'term_order'
                                    )
                            );
                foreach( $terms as $k => $t ){
                       if( $t->parent != 0 ) continue;
                       if( in_array( $t->term_id, $term_ids ) ){
                           unset( $term_ids[array_search($t->term_id, $term_ids)] );
                       }
                       $term_ids[] =  $t->term_id; 
                }

        //Returns the newly created array to the filter which overrides the top level terms (categories)
          return array_filter($term_ids);
       }
     


add_filter('advanced_sidebar_menu_first_level_category', array($this,'filterChildCategories'), 1, 3 );
     /**
      * Filters out sub categories from displaying when not on the parent category
      */
     function filterChildCategories($return, $cat, $obj){
        
        
         if( !in_array( get_queried_object()->term_id, $obj->ancestors ) ){
                 
             return false;
         } else {
             return true;
         }
     }     