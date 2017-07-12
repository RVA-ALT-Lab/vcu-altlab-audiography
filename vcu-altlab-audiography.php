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
		$audiographic_upload_error = false; 
		$audiographic_upload_successful = true; 

		global $audiographic_upload_error, $audiographic_upload_successful; 
		$file = $_FILES['uploaded-audio'];
		$audiographic_name = $_POST['audiographic-name'];  

		$uploaded = media_handle_upload('uploaded-audio', 0); 
		require_once(plugin_dir_path(__FILE__) . '/controllers/upload-audio-controller.php'); 
	}



	if(isset($_GET['action'])){

		//switch of routes to process 
		$action = $_GET['action']; 

		switch($action){
			case 'add':
			require_once(plugin_dir_path(__FILE__) . '/controllers/upload-audio-controller.php'); 
			break; 
			
			case 'edit':
				
				if ( isset($_GET['id']) && isset($_GET['segmentId'])){
					require_once(plugin_dir_path(__FILE__) . '/controllers/edit-audio-segment-controller.php');
				} else if ( isset($_GET['id']) ){
					require_once(plugin_dir_path(__FILE__) . '/controllers/edit-audio-controller.php');	
				} else {
					require_once(plugin_dir_path(__FILE__) . '/controllers/edit-audio-controller.php');
				}	
			break; 
			

			case 'delete':
				if ( isset($_GET['id']) && isset($_GET['segmentId'])){
					require_once(plugin_dir_path(__FILE__) . '/controllers/delete-audio-segment-controller.php');
				} else if ( isset($_GET['id'])){
					require_once(plugin_dir_path(__FILE__) . '/controllers/delete-audio-controller.php');
				} else {
					require_once(plugin_dir_path(__FILE__) . '/controllers/delete-audio-controller.php');	
				}
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




function vcu_altlab_audiography_load_admin_scripts($hook){
	
	if($hook !== 'toplevel_page_vcu_altlab_audiography'){
		return; 
	}
	wp_enqueue_style('bootstrap-css', plugins_url('/css/bootstrap.css', __FILE__)); 
	wp_enqueue_script('peak-js', plugins_url('/js/peaks.js', __FILE__)); 
	wp_enqueue_script('vue-js', plugins_url('/js/vue.js', __FILE__));  

}

add_action('admin_enqueue_scripts', 'vcu_altlab_audiography_load_scripts' );  

function vcu_altlab_audiography_load_scripts($hook){
	
	wp_enqueue_style('bootstrap-css', plugins_url('/css/bootstrap.css', __FILE__)); 
	wp_enqueue_script('peak-js', plugins_url('/js/peaks.js', __FILE__)); 
	wp_enqueue_script('vue-js', plugins_url('/js/vue.js', __FILE__));  

}

add_action('wp_enqueue_scripts', 'vcu_altlab_audiography_load_scripts' );


function vcu_altlab_audiography_shortcode($atts = [], $content = null){
		
		ob_start(); 

		$id = $atts['id']; 

		$selected_audiographic; 
		$segments_json; 
		$options = get_option('audiography_plugin'); 

		foreach ($options as $option) {
			if ($id == $option['id']){

				$selected_audiographic = $option; 
			}
		}

		$selected_audiographic_segments = get_option('audiography_plugin_audiographic_' . $selected_audiographic['id']); 
		
		foreach ($selected_audiographic_segments as &$segment) {
			$segment['segmentDescription'] = stripslashes($segment['segmentDescription']); 
		}

		$segments_json = json_encode($selected_audiographic_segments); 

		require_once(plugin_dir_path(__FILE__) . '/views/shortcode-view.php'); 

		$output = ob_get_clean(); 
		$run_shortcodes = do_shortcode($output); 
		return $run_shortcodes;  
}


function init_shortcodes(){
	add_shortcode('audiographic', 'vcu_altlab_audiography_shortcode'); 
}

add_action('init', 'init_shortcodes'); 

?>
