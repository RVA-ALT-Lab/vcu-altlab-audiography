
<div class="wrap">



<h3><?php echo $selected_audiographic['name']; ?></h3>
<?php echo sprintf('<audio id="audiographic-source"> <source src="%s"></source></audio>', $selected_audiographic['media_url']) ?>
		<div id="custom-audio-controls" class="btn-group btn-group-lg" role="group">
			<div class="btn btn-default" id="seek-backward-button">
				<span class="glyphicon glyphicon-backward"></span>
			</div>
			<div class="btn btn-default" id="play-button">
				<span class="glyphicon glyphicon-play"></span>
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
<br>
<div id="audiographic-waveform">
	
</div>
<div class="hidden-content">
	<?php for($i = 0; $i < count($selected_audiographic_segments); $i++): ?>
	<div id="<?php echo $selected_audiographic_segments[$i]['id']; ?>">

			<?php echo $selected_audiographic_segments[$i]['segmentDescription']; ?>
			
	</div>
	<?php endfor; ?> 	
</div>
<div class="col-lg-12" id="segments-list">
			<h3>Existing Segments</h2>
			<p>Click on one of the segments from the list below to skip to the beginning of that segment.</p>
			<h5>
				Current Time: {{currentTime}} 
			</h5>
			<div>
			<div class="row">
				<div class="col-lg-3">
					<div class="list-group">
				    <a v-bind:class="{active: (segment.startTime < currentTime && segment.endTime > currentTime), 'list-group-item': true }" v-for="segment in segments" v-on:click="seekToSegment(segment)">
				      <h5>{{segment.segmentName }}</h5>
				      <p>{{Math.floor(segment.startTime)}} - {{Math.floor(segment.endTime)}}</p>
				    </a>
				 </div>
				</div>
				<div class="col-lg-9">
					<div class="panel panel-default">
						<div class="panel-body" id="current-segment-description">
							<div v-if="currentSegment" v-html="currentSegment.segmentDescription">
							</div>
						</div>
					</div>
					
				</div>
				<div class="col-lg-9">
					
				</div>
				
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
		      } else if(!audiography.audioElement.paused){
		        audiography.audioElement.pause()
		      }

		      console.log(this); 
		      var button = document.querySelector('#play-button'); 
		      button.children[0].classList.toggle('glyphicon-play');
		      button.children[0].classList.toggle('glyphicon-pause'); 
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
		  	segment.segmentDescription = document.getElementById(segment.id).innerHTML;  

		  }); 

		  console.log(existingSegments); 

		  existingSegments.sort(function(a, b){
		  	return parseInt(a.startTime) -  parseInt(b.startTime); 
		  }); 


		  var p = Peaks.init({

		  	container: document.querySelector('#audiographic-waveform'), 
		  	mediaElement: document.querySelector('#audiographic-source'), 
		  	audioContext: myAudioContext, 
		  	segments: existingSegments, 


		  });
		
		  p.on('segments.ready', function(){

		  	var segmentsList = new Vue({
			      el:'#segments-list', 
			      data: {
			      	segments: existingSegments, 
			        //segments: p.segments.getSegments(),
			        currentTime: 0
			      }, 
			      computed: {
			      	currentSegment: function(){

			      		var segments = this.segments; 
			      		var currentTime = this.currentTime; 
			      		var currentSegment; 

			      		segments.forEach(function(segment){
			      		
			      		if (segment.startTime < currentTime && segment.endTime > currentTime){
			      			currentSegment = segment; 

			      			}

			      		});

			      		return currentSegment; 

			      	}
			      },
			      methods: {
			        seekToSegment: function(segment){
			          console.log(segment)
			          p.time.setCurrentTime(parseFloat(segment.startTime)); 
			        }
			      }
			 })

		  	audiography.audioElement.addEventListener('timeupdate', function(){
		      segmentsList.currentTime = p.time.getCurrentTime(); 
		    })


		  	console.log(p.segments.getSegments()); 

		  	//Sync up audio controls 
		  	 //hook up custom audio controls to UI
		    document.querySelector('#zoom-out-button').addEventListener('click', p.zoom.zoomOut)
		    document.querySelector('#zoom-in-button').addEventListener('click', p.zoom.zoomIn)
		    document.querySelector('#seek-forward-button').addEventListener('click', audiography.seekAudioForward)
		    document.querySelector('#seek-backward-button').addEventListener('click', audiography.seekAudioBackward)
		    document.querySelector('#play-button').addEventListener('click', audiography.playAudio)
		    window.addEventListener('keydown', function(event){
		    	if(event.keyCode == 32){
		    		event.preventDefault(); 
		    		audiography.playAudio(); 
		    	}
		    })


		  });

		  p.on('points.ready', function(event){
		  	console.log("Points ready: " + event); 
		  }); 

		  p.on('points.dragged', function(event){
		  	console.log("Points dragged: " + event); 
		  }) 

		  p.on('segments.dragged', function(event){
		  	console.log(event); 

		  })



		})(peaks);
	}); 



</script>