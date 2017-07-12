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
		    toggleZoom: function(){
		    	console.log(this); 
		    }, 
		  }

		  var myAudioContext = new AudioContext(); 

		  // existingSegments global is printed in shortcode-view.php 
		  existingSegments.forEach(function(segment){
		  	segment.startTime = parseInt(segment.startTime); 
		  	segment.endTime = parseInt(segment.endTime);
		  	segment.segmentDescription = document.getElementById(segment.id).innerHTML;  

		  }); 


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


		  	//Sync up audio controls 
		  	 //hook up custom audio controls to UI
		    document.querySelector('#zoom-button').addEventListener('click', audiography.toggleZoom)
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

