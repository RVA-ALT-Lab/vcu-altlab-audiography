<?php 
/* Plugin Name: VCU ALT Lab Audiography
 *
 *
 *
 *
 * 
 *
*/

require_once(plugin_dir_path(__FILE__) . '/classes/audiography-class.php'); 
// Create Menus for Plugin

// Add CSS and JS

function vcu_altlab_audiography_menu(){
	add_menu_page(
		'VCU ALT Lab Audiography', 
		'Audiography', 
		'manage_options', 
		'vcu_altlab_audiography', 
		'vcu_altlab_audiography_options_page'
		); 

}

add_action('admin_menu', 'vcu_altlab_audiography_menu'); 

/*
* This is the main function for the plugin. It handles all routing in the function below
* Each route loads a separate controller that will invoke a certain view 
*/

function vcu_altlab_audiography_options_page(){

	//require main class 
	if(!current_user_can('manage_options')){
			wp_die( 'You do not have sufficient permissions to access this page' ); 

	}

	//run bootstrap scripts here to 

	if(isset($_FILES['uploaded-audio'])){
		$file = $_FILES['uploaded-audio'];
		$audiographic_name = $_POST['audiographic-name'];  

		$uploaded = media_handle_upload('uploaded-audio', 0); 

		if (is_wp_error($uploaded)){
			echo 'There is some sort of error ' . $uploaded->get_error_message(); 
			require_once(plugin_dir_path(__FILE__) . '/controllers/upload-audio-controller.php'); 
		} else {
			echo 'Your file upload was successful, here is the id: ' . $uploaded; 
			require_once(plugin_dir_path(__FILE__) . '/controllers/upload-audio-controller.php');  
		}

	}



	if(isset($_GET['action'])){

		//switch of routes to process 
		$action = $_GET['action']; 

		switch($action){
			case 'add':
			require_once(plugin_dir_path(__FILE__) . '/controllers/upload-audio-controller.php'); 
			break; 
			
			case 'edit':
			require_once(plugin_dir_path(__FILE__) . '/controllers/edit-audio-controller.php');
			break; 
			

			case 'delete':
			require_once(plugin_dir_path(__FILE__) . '/controllers/delete-audio-controller.php');
			break; 
			
			case 'home': 
			require_once(plugin_dir_path(__FILE__) . '/controllers/list-audio-controller.php'); 
			break; 

			default: 

			require_once(plugin_dir_path(__FILE__) . '/controllers/list-audio-controller.php');

		}


	} else {
		require_once(plugin_dir_path(__FILE__) . '/controllers/list-audio-controller.php');
	}

}




function vcu_altlab_audiography_load_scripts($hook){
	
	if($hook !== 'toplevel_page_vcu_altlab_audiography'){
		return; 
	}

	wp_enqueue_script('peak-js', plugins_url('/js/peaks.js', __FILE__)); 
	wp_enqueue_script('vue-js', plugins_url('/js/vue.js', __FILE__));  

}

add_action('admin_enqueue_scripts', 'vcu_altlab_audiography_load_scripts' );  





function vcu_altlab_audiography_shortcode($atts = [], $content = null){
		$id = $atts['id']; 
		return '<h2>Here is a test string to replace</h2>  ' . $id; 
}


function init_shortcodes(){
	add_shortcode('audiography', 'vcu_altlab_audiography_shortcode'); 
}

add_action('init', 'init_shortcodes'); 

?>
