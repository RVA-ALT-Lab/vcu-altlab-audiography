//either sets this equal to JSON from PHP or an empty array
var existingSegments = existingSegments || []; 


//Perform this check of the query string to determine which DOM elements are present 
// for Peaks and Vue to bind to
var queryString = location.search; 
var isEditingAudiographic = ( queryString.includes('action=edit') && queryString.includes('id') && !queryString.includes('segmentId') ); 
var isEditingSegment = ( queryString.includes('action=edit') && queryString.includes('segmentId') ); 


console.log(isEditingSegment + " : " + isEditingAudiographic); 


document.addEventListener('DOMContentLoaded', function(event){

		(function(Peaks, existingSegments){
			console.log(isEditingAudiographic); 
			console.log(isEditingSegment); 
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

		  // var existingSegments = <?php echo $segments_json; ?>; 

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



		})(peaks, existingSegments);
	}); 
