document.addEventListener('DOMContentLoaded', function(event){


		(function(Peaks){
		    

		    var audiography = {
		    audioElement: document.querySelector('#audiographic-source'),
		    initialize: function(){
				  var AudioContext = window.AudioContext = ( window.AudioContext || window.webkitAudioContext ); 
				  var initializedAudioContext = new AudioContext(); 

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
				  	audioContext: initializedAudioContext, 
				  	segments: existingSegments, 


				  });
				
				  p.on('segments.ready', function(){

				  	var segmentsList = new Vue({
					      el:'#segments-list', 
					      data: {
					      	segments: existingSegments, 
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

					      		if (currentSegment == undefined){
					      			currentSegment = segments[0]; 
					      		}

					      		return currentSegment; 

					      	}
					      },
					      methods: {
					        seekToSegment: function(segment){
					          console.log(segment)
					          p.time.setCurrentTime(parseFloat(segment.startTime + 1)); 
					        }, 
					        seekToNextSegment: function(segment){
					        	console.log(segment); 
					        	var currentIndex = this.segments.indexOf(segment);
					        	if (currentIndex >= (this.segments.length - 1) ){
					        		//set to the beginning of the array to loop
					        		currentIndex = 0; 
					        	} else {
					        		currentIndex++; 
					        	}

					        	this.seekToSegment(this.segments[currentIndex]); 
					        	//then call seekToSegment 
					        }, 
					        seekToPreviousSegment: function(segment){
					        	console.log(segment); 
					        	var currentIndex = this.segments.indexOf(segment);
					        	if (currentIndex == 0 ){
					        		//set to the last index of the array to loop
					        		currentIndex = this.segments.length - 1; 
					        	} else {
					        		currentIndex--; 
					        	}

					        	this.seekToSegment(this.segments[currentIndex]);
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

					audiography.toggleZoom(); 
					window.addEventListener('resize', audiography.toggleZoom);   


				  });
		    }, 	
		    playAudio: function(){
		      if(audiography.audioElement.paused){
		        audiography.audioElement.play()
		      } else if(!audiography.audioElement.paused){
		        audiography.audioElement.pause()
		      }

		      var button = document.querySelector('#play-button'); 
		      button.children[0].classList.toggle('glyphicon-play');
		      button.children[0].classList.toggle('glyphicon-pause'); 
		    },
		    seekNextSegment: function(){

		    },  
		    seekAudioForward: function(){
		      audiography.audioElement.currentTime = (audiography.audioElement.currentTime + (audiography.audioElement.duration / 10))
		    }, 
		    seekAudioBackward: function(){
		      audiography.audioElement.currentTime = (audiography.audioElement.currentTime - (audiography.audioElement.duration / 10))
		    },
		    toggleZoom: function(){
		    	var container = document.querySelector('.zoom-container'); 
		    	if (window.innerWidth >= 792){
		    		container.style.display = 'block'; 
		    	} else {
		    		container.style.display = 'none'; 
		    	}
		    }, 
		  }

		// This is all really to appease Safari. The creataion of the waveform needs to happen in Safari after the 
		// data for the audio element loads. Since we are doing other stuff to differentiate between webkitAudioContext and AudioContext
		// elsewhere, this seems more sensible than UA sniffing

			if (window.webkitAudioContext){
				audiography.audioElement.addEventListener('loadeddata', audiography.initialize)
			} else {
				audiography.initialize(); 
			}

		// }); 
		//End event listener for when audio is loaded
		//Call once after everything has loaded to hide zoom on XS screens

		})(peaks);
	}); 

