<?php

$audiographic_id; 

if (isset($_GET['id'])){

	$audiographic_id = $_GET['id']; 

}

//if GET confirm == true
//then we will do the following:
//1. Get all of the segments, delete those options from the WP table 
//2. Remove the array from the main plugin options table
//3. Delete the media file associated with the audiographic 




require_once(plugin_dir_path(__DIR__) . '/views/delete-audio-view.php'); 

?>