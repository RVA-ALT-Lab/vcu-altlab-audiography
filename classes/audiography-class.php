<?php 


class AudiographyPlugin {

	public function getAudiographyOptions(){
		return wp_get_options('audiography_plugin_options'); 
	}

	public static function stripProtocolFromString($string){
		$processed_string; 
		
		$patterns = array(); 
		
		$https_pattern = '/https:/i'; 
		$http_pattern = '/http:/i'; 

		$patterns[0] = $https_pattern; 
		$patterns[1] = $http_pattern; 


		$processed_string = preg_replace($patterns, '', $string ); 



		return $processed_string; 

	}

}



?>