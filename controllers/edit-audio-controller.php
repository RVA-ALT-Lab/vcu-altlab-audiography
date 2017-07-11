<?php


if (isset($_POST['edit-audio-submitted']) && $_POST['edit-audio-submitted'] == 'Y'){
	$audiographic_id = $_POST['audiographic-id']; 
	$segmentName = $_POST['segment-name'];
	$segmentDescription = $_POST['segment-description'];  
	$startTime = $_POST['beginning-time'];
	$endTime = $_POST['ending-time']; 
	$color = $_POST['color']; 
	$segmentId = $_POST['segment-id']; 


	$newSegment = array(
		'id' => $segmentId, 
		'segmentName' => $segmentName, 
		'segmentDescription' => $segmentDescription, 
		'startTime' => $startTime, 
		'endTime' => $endTime, 
		'color' => $color, 
		); 

	$segment_options = get_option('audiography_plugin_audiographic_' . $audiographic_id );

	if ($segment_options){

		if(count($segment_options) == 0){
			echo 'count equals zero'; 
			$new_options = array(); 
			array_push($new_options, $newSegment); 
			update_option('audiography_plugin_audiographic_' . $audiographic_id, $new_options ); 	
		}

		array_push($segment_options, $newSegment); 
		update_option('audiography_plugin_audiographic_' . $audiographic_id , $segment_options); 

	} else {
		$new_options = array(); 
		array_push($new_options, $newSegment); 

		add_option('audiography_plugin_audiographic_' . $audiographic_id, $new_options ); 
	}



}
if (isset($_GET['id'])){

	$options = get_option('audiography_plugin'); 

	$selected_audiographic; 
	$selected_audiographic_segments; 
	$segments_json; 

	foreach($options as $value){
		if ($value['id'] == $_GET['id']){
			$selected_audiographic = $value; 

			$selected_audiographic_segments = get_option('audiography_plugin_audiographic_'. $selected_audiographic['id']); 
			$segments_json = json_encode($selected_audiographic_segments); 

		}
	}

	require_once(plugin_dir_path(__DIR__) . '/views/edit-audio-view.php'); 


} else {

require_once(plugin_dir_path(__DIR__) . '/views/edit-audio-view.php'); 

}

?>