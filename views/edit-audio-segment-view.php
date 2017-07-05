<?php 
require_once(plugin_dir_path(__FILE__) . '/partials/audiography-header.php');
?>

<div class="wrap">

<h2><?php echo $selected_audiographic['name'] ?></h2>
<table class="table">
	<tr>
		<td>ID</td>
		<td><?php echo $selected_audiographic['id'] ?></td>
	</tr>
	<tr>
		<td>Media URL</td>
		<td>
		<?php echo sprintf('<a href="%s">%s</a>', $selected_audiographic['media_url'], $selected_audiographic['media_url']) ?>
		</td>
	</tr>
</table>
<br>

<?php echo sprintf('<audio id="audiographic-source"> <source src="%s"></source></audio>', $selected_audiographic['media_url']) ?>
		<div id="custom-audio-controls">
			<div class="btn btn-default" id="seek-backward-button">
				<span class="glyphicon glyphicon-backward"></span>
			</div>
			<div class="btn btn-default" id="play-button">
				<span class="glyphicon glyphicon-play"></span>
			</div>
			<div class="btn btn-default" id="pause-button">
				<span class="glyphicon glyphicon-pause"></span>
			</div>
			<div class="btn btn-default" id="seek-forward-button">
				<span class="glyphicon glyphicon-forward"></span>
			</div>
			<div class="btn btn-default" id="zoom-in-button">
				<span class="glyphicon glyphicon-zoom-in"></span>
			</div>
			<div class="btn btn-default" id="zoom-out-button">
				<span class="glyphicon glyphicon-zoom-out"></span>
			</div>
		</div>

<br>
<div id="audiographic-waveform"></div>
<br>

<div id="edit-segment-form">
	<form name="edit-segment" id="edit-segment" method="post">
		<input type="hidden" name="edit-segment-submitted" id="edit-segment-submitted" value="Y">
		<input type="hidden" name="audiographic-id" value="<?php echo $selected_audiographic['id'] ?>">
		<label>Segment Title</label>
		<br>
		<input type="text" name="segment-name" id="segment-name" v-model="segmentName" class=".regular-text">
		<br>
		<label for="beginning-time">Beginning Time</label>
		<p id="beginning-time-display">{{startTime}}</p>
		<input type="hidden" name="beginning-time" v-model="startTime">
		<label for="ending-time">Ending Time</label>
		<p id="ending-time-display">{{endTime}}</p>
		<input type="hidden" name="ending-time" v-model="endTime">
		<label for="color">Color</label>
		<input type="color" name="color" v-model="color">
		<p>{{color}}</p>
		<input type="hidden" name="segment-id" id="segment-id" v-model="segmentId">
		<p>{{segmentId}}</p>

		<?php wp_editor($selcted_segment['segmentDescription'], 'segment-description', array('textarea_name' => 'segment-description')); ?>

		<?php submit_button('Submit');  ?>

	</form>
</div>

</div>


<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function(event){


		(function(Peaks){
		    var audiography = {
		    audioElement: document.querySelector('#audiographic-source'), 	
		    playAudio: function(){
		      if(audiography.audioElement.paused){
		        audiography.audioElement.play()
		      }
		    }, 
		    pauseAudio: function(){
		      if(!audiography.audioElement.paused){
		        audiography.audioElement.pause()
		      }
		    }, 
		    seekAudioForward: function(){
		      console.log('clicked')
		      console.log(audiography.audioElement.duration)
		      audiography.audioElement.currentTime = (audiography.audioElement.currentTime + (audiography.audioElement.duration / 10))
		      console.log(audiography.audioElement.currentTime); 
		    }, 
		    seekAudioBackward: function(){
		      audiography.audioElement.currentTime = (audiography.audioElement.currentTime - (audiography.audioElement.duration / 10))
		    }, 
		    exportSegments: function(){
		      console.log('clicked'); 
		        var segments = p.segments.getSegments(); 
		        document.querySelector('#export-area').innerText = segments; 
		    }, 
		    generateUniqueId: function(min, max){
		    	return Math.floor(Math.random() * (max - min + 1)) + min; 
			}
		  }

		  var myAudioContext = new AudioContext(); 

		  var existingSegments = <?php echo $segments_json; ?>; 

		  console.log(existingSegments); 

		  if (existingSegments !== null 
		  	&& existingSegments !== undefined 
		  	&& existingSegments !== false){

		  	if (typeof exportSegments == 'array'){
			  existingSegments.forEach(function(segment){
			  	segment.startTime = parseInt(segment.startTime); 
			  	segment.endTime = parseInt(segment.endTime); 
			 });
			} else {
				existingSegments = [existingSegments]; 
			}

		  } else {
		  	existingSegments = []; 
		  }

		  var p = Peaks.init({

		  	container: document.querySelector('#audiographic-waveform'), 
		  	mediaElement: document.querySelector('#audiographic-source'), 
		  	audioContext: myAudioContext, 
		  	segments: existingSegments, 


		  });

		  var newSegment = new Vue({
		  		el: '#edit-segment-form',
		  		data: {
		  			startTime: existingSegments[0].startTime, 
		  			endTime: existingSegments[0].endTime, 
		  			color: existingSegments[0].color,
		  			segmentId: existingSegments[0].id, 
		  			segmentName: existingSegments[0].segmentName,  

		  		}, 
		  		methods: {

		  		}
		  	}); 
		
		  p.on('segments.ready', function(){

		  	p.segments.add({
		  		startTime: newSegment.startTime, 
		  		endTime: newSegment.endTime,
		  		color: newSegment.color, 
		  		editable: true,
		  		id: newSegment.segmentId, 

		  	})

		  	//Sync up audio controls 
		  	 //hook up custom audio controls to UI
		    document.querySelector('#zoom-out-button').addEventListener('click', p.zoom.zoomOut)
		    document.querySelector('#zoom-in-button').addEventListener('click', p.zoom.zoomIn)
		    document.querySelector('#seek-forward-button').addEventListener('click', audiography.seekAudioForward)
		    document.querySelector('#seek-backward-button').addEventListener('click', audiography.seekAudioBackward)
		    document.querySelector('#play-button').addEventListener('click', audiography.playAudio)
		    document.querySelector('#pause-button').addEventListener('click', audiography.pauseAudio)


		  });
		
		p.on('segments.dragged', function(event){
		  	console.log(event); 
		  	newSegment.startTime = event.startTime; 
		  	newSegment.endTime = event.endTime; 
		 });   



		})(peaks);
	}); 



</script>