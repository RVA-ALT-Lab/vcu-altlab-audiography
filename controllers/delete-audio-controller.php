<?php

$audiographic_id; 
$audiographic_id = $_GET['id']; 
$main_plugin_options = get_option('audiography_plugin'); 
$selected_audiographic; 
$index_to_start_splice = 0; 
$deleted_successful = false; 

for ($index = 0; $index < count($main_plugin_options); $index++) {
	
	if($main_plugin_options[$index]['id'] == $audiographic_id){
		$selected_audiographic = $main_plugin_options[$index]; 
		$index_to_start_splice = $index; 
	}
}

//if GET confirm == true
//then we will do the following:
//1. Get all of the segments, delete those options from the WP table 
//2. Remove the array from the main plugin options table
//3. Delete the media file associated with the audiographic 


	if (isset($_GET['confirm']) && $_GET['confirm'] == true ){

		delete_option('audiography_plugin_audiographic_' . $audiographic_id); 

		array_splice($main_plugin_options, $index_to_start_splice, 1); 

		update_option('audiography_plugin', $main_plugin_options); 

		wp_delete_attachment($audiographic_id); 

		$deleted_successful = true; 
	

	}



require_once(plugin_dir_path(__DIR__) . '/views/delete-audio-view.php'); 

?>