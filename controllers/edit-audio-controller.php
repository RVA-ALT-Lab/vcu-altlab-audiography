<?php

if (isset($_GET['id'])){

	$options = get_option('audiography_plugin'); 

	$selected_audiographic; 

	foreach($options as $value){
		if ($value['id'] == $_GET['id']){
			$selected_audiographic = $value; 
		}
	}


}

require_once(plugin_dir_path(__DIR__) . '/views/edit-audio-view.php'); 

?>