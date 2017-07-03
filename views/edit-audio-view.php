<?php 

require_once(plugin_dir_path(__FILE__) . '/partials/audiography-header.php');

?>



<h2><?php echo $selected_audiographic['id'] ?></h2>
<p><?php echo $selected_audiographic['name'] ?></p>
<p><?php echo $selected_audiographic['media_url'] ?></p>
<?php echo sprintf('<a href="/wp-admin/admin.php?page=vcu_altlab_audiography&action=edit&id=%s">Edit This File</a>', $selected_audiographic['id']) ?>


<?php echo sprintf('<audio id="audiographic-source"> <source src="%s"></source></audio>', $selected_audiographic['media_url']) ?>
<div id="audiographic-waveform"></div>


<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function(event){


		(function(Peaks){
		  var myAudioContext = new AudioContext(); 


		  var p = Peaks.init({

		  	container: document.querySelector('#audiographic-waveform'), 
		  	mediaElement: document.querySelector('#audiographic-source'), 
		  	audioContext: myAudioContext

		  });
		
		  p.on('segments.ready', function(){

		  }); 

		})(peaks);
	}); 



</script>