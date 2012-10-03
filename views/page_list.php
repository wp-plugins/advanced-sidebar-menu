<?php 



/**
 * The Ouput of tad Advanced Sidebar Page Widget
 * @author Mat Lipe
 * @since 7/16/12
 *
 *
 * @uses to edit, create a file named page_list.php and put in a folder in the your theme called 'advanced-sidebar-menu
 * @uses copy the contents of the file into that file and edit at will
 * @uses Do not edit this file in its original location or it will break on upgrade
 */

$asm->title();

#-- list the parent page if chosen
if( $asm->include_parent() ){
	echo '<ul class="parent-sidebar-menu" >';
			 wp_list_pages("sort_column=menu_order&title_li=&echo=1&depth=1&include=".$top_parent);
}


//If there are children start the Child Sidebar Menu
if( $child_pages ){
	echo '<ul class="child-sidebar-menu">';

	#-- If they want all the pages displayed always
	if( $asm->display_all() ){

		wp_list_pages("sort_column=menu_order&title_li=&echo=1&child_of=".$top_parent."&depth=".$instance['levels']."&exclude=".$instance['exclude']);
	} else {

		#-- Display children of current page's parent only
		foreach($result as $pID){

				#-- If the page is not in the excluded ones
			if( $asm->exclude( $pID->ID) ){
					#--echo the current page from the $result
				wp_list_pages("sort_column=menu_order&title_li=&echo=1&depth=1&include=".$pID->ID);
			}

			#-- if the link that was just listed is the current page we are on
			if( $asm->page_ancestor( $pID ) ){

				//Get the children of this page
				$grandkids = $asm->page_children($pID->ID );				
				if( $grandkids ){
					#-- Create a new menu with all the children under it
					echo '<ul class="grandchild-sidebar-menu">';
							wp_list_pages("sort_column=menu_order&title_li=&echo=1&exclude=".$instance['exclude']."&child_of=".$pID->ID);

					echo '</ul>';
				}
			}
		}
	}

	#-- Close the First Level menu
	echo '</ul><!-- End child-sidebar-menu -->';

}
if( $asm->include_parent() ) {
	echo '</ul><!-- .parent-sidebar-menu -->';
}
		


	
