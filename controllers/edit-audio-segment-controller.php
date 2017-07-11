<?php
if (isset($_POST['edit-segment-submitted']) && $_POST['edit-segment-submitted'] == 'Y'){

	$audiographic_id = $_POST['audiographic-id']; 
	$segmentName = $_POST['segment-name'];
	$segmentDescription = $_POST['segment-description'];  
	$startTime = $_POST['beginning-time'];
	$endTime = $_POST['ending-time']; 
	$color = $_POST['color']; 
	$segmentId = $_POST['segment-id']; 

	$updated_segment = array(
		'id' => $segmentId, 
		'segmentName' => $segmentName, 
		'segmentDescription' => $segmentDescription, 
		'startTime' => $startTime, 
		'endTime' => $endTime, 
		'color' => $color, 
		); 

	$segment_options = get_option('audiography_plugin_audiographic_' . $audiographic_id );

	foreach ($segment_options as &$segment) {
		if ($segment['id'] == $updated_segment['id']){
			$segment['segmentName'] = $updated_segment['segmentName'];
			$segment['segmentDescription'] = $updated_segment['segmentDescription'];
			$segment['startTime'] = $updated_segment['startTime']; 
			$segment['endTime'] = $updated_segment['endTime'];
			$segment['color'] = $updated_segment['color'];
		}
	}

	update_option('audiography_plugin_audiographic_' . $audiographic_id, $segment_options ); 

}  
if (isset($_GET['id']) && isset($_GET['segmentId'])){

	$options = get_option('audiography_plugin'); 

	$selected_audiographic; 
	$selected_audiographic_segments; 
	$selcted_segment; 
	$segments_json; 

	foreach($options as $value){
		if ($value['id'] == $_GET['id']){
			$selected_audiographic = $value; 

			$selected_audiographic_segments = get_option('audiography_plugin_audiographic_'. $selected_audiographic['id']); 
			
			foreach($selected_audiographic_segments as $segment){
				if ($segment['id'] == $_GET['segmentId']){
					$selcted_segment = $segment; 
				}
			}

			$segments_json = json_encode($selcted_segment); 

		}
	}

	require_once(plugin_dir_path(__DIR__) . '/views/edit-audio-segment-view.php'); 

}


?>