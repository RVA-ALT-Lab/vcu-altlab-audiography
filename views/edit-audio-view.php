<?php 
require_once(plugin_dir_path(__FILE__) . '/partials/audiography-header.php');
?>

<div class="wrap">

<h2><?php echo $selected_audiographic['id'] ?></h2>
<p><?php echo $selected_audiographic['name'] ?></p>
<p><?php echo $selected_audiographic['media_url'] ?></p>
<?php echo sprintf('<a href="/wp-admin/admin.php?page=vcu_altlab_audiography&action=edit&id=%s">Edit This File</a>', $selected_audiographic['id']) ?>


<?php echo sprintf('<audio id="audiographic-source"> <source src="%s"></source></audio>', $selected_audiographic['media_url']) ?>
		<div id="custom-audio-controls">
			<div class="btn btn-default" id="seek-backward-button">
				<span class="glyphicon glyphicon-backward">Back</span>
			</div>
			<div class="btn btn-default" id="play-button">
				<span class="glyphicon glyphicon-play">Play</span>
			</div>
			<div class="btn btn-default" id="pause-button">
				<span class="glyphicon glyphicon-pause">Pause</span>
			</div>
			<div class="btn btn-default" id="seek-forward-button">
				<span class="glyphicon glyphicon-forward">Forward</span>
			</div>
			<div class="btn btn-default" id="zoom-in-button">
				<span class="glyphicon glyphicon-zoom-in">Zoom In</span>
			</div>
			<div class="btn btn-default" id="zoom-out-button">
				<span class="glyphicon glyphicon-zoom-out">Zoom Out</span>
			</div>
		</div>


<div id="audiographic-waveform"></div>
<button type="button">+ Add Segment</button>

<div id="new-segment-form">
	<form name="new-segment" id="new-segment" method="post">
		<input type="hidden" name="edit-audio-submitted" id="edit-audio-submitted" value="Y">
		<input type="hidden" name="audiographic-id" value="<?php echo $selected_audiographic['id'] ?>">
		<label>Segment Title</label>
		<br>
		<input type="text" name="segment-name" id="segment-name" class=".regular-text">
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

		<?php wp_editor('', 'segment-description', array('textarea_name' => 'segment-description')); ?>

		<?php submit_button('Submit');  ?>

	</form>
</div>

<button type="button" id="log-vue">Log Vue</button>

<h3>Existing Segments</h3>

<?php foreach($selected_audiographic_segments as $segment): ?>
<h4><?php  echo $segment['segmentName'] ?></h4>

<?php endforeach; ?>


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
		    }
		  }

		  var myAudioContext = new AudioContext(); 

		  var existingSegments = <?php echo $segments_json; ?>; 
		  existingSegments.forEach(function(segment){
		  	segment.startTime = parseInt(segment.startTime); 
		  	segment.endTime = parseInt(segment.endTime); 

		  }); 


		  var p = Peaks.init({

		  	container: document.querySelector('#audiographic-waveform'), 
		  	mediaElement: document.querySelector('#audiographic-source'), 
		  	audioContext: myAudioContext, 
		  	segments: existingSegments, 


		  });

		  var newSegment = new Vue({
		  		el: '#new-segment-form',
		  		data: {
		  			startTime: 60, 
		  			endTime: 120, 
		  			color: '#000000',
		  			segmentId: '', 
		  			segmentTitle: '',  
		  			segmentToAdd: {}

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

		  	})

		  	console.log(p.segments.getSegments()); 
		  	document.querySelector('#log-vue').addEventListener('click', function(){
		  		console.log(newSegment.color); 
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

		  p.on('points.ready', function(event){
		  	console.log("Points ready: " + event); 
		  }); 

		  p.on('points.dragged', function(event){
		  	console.log("Points dragged: " + event); 
		  }) 

		  p.on('segments.dragged', function(event){
		  	console.log(event); 
		  	newSegment.startTime = event.startTime; 
		  	newSegment.endTime = event.endTime; 
		  })



		})(peaks);
	}); 



</script>