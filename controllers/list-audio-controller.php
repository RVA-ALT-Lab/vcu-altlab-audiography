<?php

$audiographic_list = get_option('audiography_plugin'); 


if (!isset($audiographic_list)){
	$audiographic_list = array(); 
}

require_once(plugin_dir_path(__DIR__) . '/views/list-audio-view.php'); 

?>