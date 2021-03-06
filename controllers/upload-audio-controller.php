<?php

$audiographic_upload_successful = false; 
$audiographic_upload_error = null; 

if (isset($uploaded) && is_wp_error($uploaded)){

	$audiographic_upload_error = $uploaded->get_error_message(); 

} else if(isset($uploaded)){
	$audiographic_upload_successful = true; 
	//This means a file was just uploaded, so we need to get plugin options, 
	// look to see if the id already exists, which it shouldn't, 
	// then add it to the array and update the options hash
	$attachment = wp_get_attachment_url($uploaded); 

	$options = get_option('audiography_plugin'); 

	$new_audiographic = array(
		'name' => $audiographic_name, 
		'id' => $uploaded, 
		'media_url' => $attachment
		); 

	if($options){

		array_push($options, $new_audiographic);
		update_option('audiography_plugin', $options);  
	} else {
		$new_options = array(); 
		array_push($new_options, $new_audiographic);
		update_option('audiography_plugin', $new_options);  
	}


} 

require_once(plugin_dir_path(__DIR__) . '/views/upload-audio-view.php'); 

?>