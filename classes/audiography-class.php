<?php 


class AudiographyPlugin {

	public function getAudiographyOptions(){
		return wp_get_options('audiography_plugin_options'); 
	}

}



?>