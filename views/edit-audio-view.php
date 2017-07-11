<?php 
require_once(plugin_dir_path(__FILE__) . '/partials/audiography-header.php');
?>

<div class="wrap">

<table class="table">
	<tr>
		<th>Name</th>
		<td><?php echo $selected_audiographic['name'] ?></td>
	</tr>
	<tr>
		<th>ID</th>
		<td><?php echo $selected_audiographic['id'] ?></td>
	</tr>
	<tr>
		<th>Media URL</th>
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
<button type="button" class="btn btn-default" id="add-segment"><span class="glyphicon glyphicon-plus"></span> Add Segment</button>
<!-- <button type="button" class="btn btn-default" id="add-point"><span class="glyphicon glyphicon-plus"></span> Add Point</button> -->
<br>
<br>

<div id="new-segment-form" style="display: none; ">
	<form name="new-segment" id="new-segment" method="post">
		<div class="row">
		<div class="col-lg-4">
		<input type="hidden" name="edit-audio-submitted" id="edit-audio-submitted" value="Y">
		<input type="hidden" name="audiographic-id" value="<?php echo $selected_audiographic['id'] ?>">
		<div class="form-group">
			<label>Segment Title</label>
			<input type="text" name="segment-name" id="segment-name" class="form-control">
		</div>
		<br>
		<div class="form-group">
			<label for="beginning-time">Beginning Time (in seconds)</label>
			<span class="help-block">Use the sliders on the waveform to edit the start time for this segment.</span>
			<input type="text"  name="beginning-time" class="form-control" v-model="startTime" readonly="readonly">
		</div>
		<div class="form-group">
			<label for="ending-time">Ending Time (in seconds)</label>
			<input type="text" class="form-control" name="ending-time" v-model="endTime" readonly="readonly">	
		</div>
		
		<label for="color">Color</label>
		<div class="radio">
			<label for='red'>
			<input type="radio" name="red" value="#FF0000" v-model="color">
			Red</label>
		</div>
		<div class="radio">
			<label for='green'>
			<input type="radio" name="green" value="#008000" v-model="color">
			Green</label>
		</div>
		<div class="radio">
			<label for='blue'>
			<input type="radio" name="blue" value="#0000FF" v-model="color">
			Blue</label>
		</div>
		<div class="radio">
			<label for='yellow'>
			<input type="radio" name="yellow" value="#FFFF00" v-model="color">
			Yellow</label>
		</div>
		<div class="radio">
			<label for='orange'>
			<input type="radio" name="orange" value="#FFA500" v-model="color">
			Orange</label>
		</div>
		<div class="radio">
			<label for='purple'>
			<input type="radio" name="purple" value="#800080" v-model="color">
			Purple</label>
		</div>	
		<input type="hidden" name="color" v-model="color"> 
		<div class="form-group">
			<label for="segment-id">Segment ID</label>
			<input type="text" class="form-control" name="segment-id" id="segment-id" v-model="segmentId" readonly="readonly">
		</div>
		</div>
		<div class="col-lg-8">
			<div class="form-group">
			<label>Segment Description</label>
				<?php wp_editor('', 'segment-description', array('textarea_name' => 'segment-description', 'textarea_rows' => 25)); ?>
			</div>	
		</div>
		<div class="col-lg-12">
			<?php submit_button('Submit');  ?>
		</div>
		</div>
	</form>
</div>

<div class="row">
<div class="col-lg-12">
<h3>Existing Segments</h3>


	<div class="list-group">


	<?php if($selected_audiographic_segments): ?>
		<?php foreach($selected_audiographic_segments as $segment): ?>

		<div class="list-group-item">
		<h4><?php  echo $segment['segmentName']; ?></h4>
		<p><?php  echo $segment['startTime']; ?> to <?php  echo $segment['endTime']; ?></p>
		<p><?php echo stripslashes($segment['segmentDescription']); ?></p>
		<a href="/wp-admin/admin.php?page=vcu_altlab_audiography&action=edit&id=<?php echo $selected_audiographic['id'] ?>&segmentId=<?php echo $segment['id']; ?>" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Edit Segment</a>
		<a href="/wp-admin/admin.php?page=vcu_altlab_audiography&action=delete&id=<?php echo $selected_audiographic['id'] ?>&segmentId=<?php echo $segment['id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete Segment</a>
		</div>
		<?php endforeach; ?>
	<?php endif; ?>
		
	</div>
</div>
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

		  if (existingSegments !== null && existingSegments !== undefined && existingSegments !== false){
			  existingSegments.forEach(function(segment){
			  	segment.startTime = parseInt(segment.startTime); 
			  	segment.endTime = parseInt(segment.endTime); 

			  }); 
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
		  		el: '#new-segment-form',
		  		data: {
		  			startTime: 60, 
		  			endTime: 120, 
		  			color: '#000000',
		  			segmentId: audiography.generateUniqueId(1, 100000), 
		  			segmentTitle: '',  
		  			segmentToAdd: {}

		  		}, 
		  		methods: {

		  		}
		  	}); 
		
		  p.on('segments.ready', function(){

		  	var guid = audiography.generateUniqueId(1, 1000); 
		  	console.log(guid); 

		  	// p.segments.add({
		  	// 	startTime: newSegment.startTime, 
		  	// 	endTime: newSegment.endTime,
		  	// 	color: newSegment.color, 
		  	// 	editable: true,
		  	// 	id: newSegment.segmentId, 

		  	// })
		  	document.querySelector('#add-segment').addEventListener('click', function(){
				p.segments.add({
			  		startTime: newSegment.startTime, 
			  		endTime: newSegment.endTime,
			  		color: newSegment.color, 
			  		editable: true,
			  		id: newSegment.segmentId, 

			  	})
			  	document.querySelector('#new-segment-form').style.display ='block'; 
		 
		  	}) 
		  	

		  	//Sync up audio controls 
		  	 //hook up custom audio controls to UI
		    document.querySelector('#zoom-out-button').addEventListener('click', function(){
		    	document.querySelector('.zoom-container').style.display = 'none'; 
		    }); 

		    document.querySelector('#zoom-in-button').addEventListener('click', function(){
		    	document.querySelector('.zoom-container').style.display = 'block'; 
		    }); 

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