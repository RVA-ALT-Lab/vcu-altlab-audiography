<?php

	$audiographic_id; 
	$deleted_successful = false; 


	$audiographic_id = $_GET['id']; 
	$segment_id = $_GET['segmentId']; 
	$segment_to_delete; 
	$index_to_start_splice = 0; 
	
	$audiographic_option = get_option('audiography_plugin_audiographic_' . $audiographic_id); 
	echo count($audiographic_option); 

	for ($index = 0; $index < count($audiographic_option); $index++){

		echo $audiographic_option[$index]['id']; 
		if($audiographic_option[$index]['id'] == $segment_id ){
			$segment_to_delete = $audiographic_option[$index]; 
			$index_to_start_splice = $index; 
		}

	}	


	if (isset($_GET['confirm']) && $_GET['confirm'] == true ){
		
		array_splice($audiographic_option, $index_to_start_splice, 1); 
		if (count($audiographic_option) > 0){
			update_option('audiography_plugin_audiographic_' . $audiographic_id, $audiographic_option);
		} else {
			delete_option('audiography_plugin_audiographic_' . $audiographic_id); 
		}
		
		$deleted_successful = true; 	


	}



require_once(plugin_dir_path(__DIR__) . '/views/delete-audio-segment-view.php'); 

?>