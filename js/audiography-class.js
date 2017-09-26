var Audiography = function(audioElement, Peaks, existingSegments){
	var self = this;

	this.audioElement = audioElement;

	this.playAudio = function(){
		if(self.audioElement.paused){
		        self.audioElement.play()
		      } else if(!self.audioElement.paused){
		        self.audioElement.pause()
		      }

		var button = document.querySelector('#play-button');
		button.children[0].classList.toggle('glyphicon-play');
		button.children[0].classList.toggle('glyphicon-pause');
	}

	this.seekAudioForward = function(){
		self.audioElement.currentTime = (self.audioElement.currentTime + (self.audioElement.duration / 10))
	}

	this.seekAudioBackward = function(){
		self.audioElement.currentTime = (self.audioElement.currentTime - (self.audioElement.duration / 10))
	}

	this.generateUniqueId = function(min, max){
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}

	this.toggleZoom = function(event){
		//TODO: work on this and maybe write another method to
		//close zoom container on window resize

		var container = document.querySelector('.zoom-container');
		if (window.innerWidth >= 792 || event){
		   container.style.display = 'block';
		} else {
		   container.style.display = 'none';
		}
	}

	this.initializeShortcodeView = function(){

		 var AudioContext = window.AudioContext = ( window.AudioContext || window.webkitAudioContext );
				  var initializedAudioContext = new AudioContext();

				  // existingSegments global is printed in shortcode-view.php
				  existingSegments.forEach(function(segment){
				  	segment.startTime = parseFloat(segment.startTime);
				  	segment.endTime = parseFloat(segment.endTime);
				  	segment.segmentDescription = document.getElementById(segment.id).innerHTML;

				  });


				  existingSegments.sort(function(a, b){
				  	return parseFloat(a.startTime) -  parseFloat(b.startTime);
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

					      	},
				  			formattedTime: function(){
				  				var formattedTime;

				  				var minutes = Math.floor(this.currentTime/ 60);
				  				var seconds = Math.floor(this.currentTime - (minutes * 60));

				  				minutes = (minutes < 10)? "0" + minutes : minutes;
				  				seconds = (seconds < 10)? "0" + seconds : seconds;

				  				return (minutes + ":" + seconds);
				  			},
					      },
					      methods: {
					        seekToSegment: function(segment){

					          p.time.setCurrentTime(parseFloat(segment.startTime + 1));
					        },
					        seekToNextSegment: function(segment){
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
					        	var currentIndex = this.segments.indexOf(segment);
					        	if (currentIndex == 0 ){
					        		//set to the last index of the array to loop
					        		currentIndex = this.segments.length - 1;
					        	} else {
					        		currentIndex--;
					        	}

					        	this.seekToSegment(this.segments[currentIndex]);
					        },
					        formatTime: function(time){
					        	var formattedTime;

				  				var minutes = Math.floor(time / 60);
				  				var seconds = Math.floor(time - (minutes * 60));

				  				minutes = (minutes < 10)? "0" + minutes : minutes;
				  				seconds = (seconds < 10)? "0" + seconds : seconds;

				  				return (minutes + ":" + seconds);
					        }
					      }
					 })

				  	self.audioElement.addEventListener('timeupdate', function(){
				      segmentsList.currentTime = p.time.getCurrentTime();
				    })


				  	//Sync up audio controls
				  	 //hook up custom audio controls to UI
				    document.querySelector('#zoom-button').addEventListener('click', self.toggleZoom)
				    document.querySelector('#seek-forward-button').addEventListener('click', self.seekAudioForward)
				    document.querySelector('#seek-backward-button').addEventListener('click', self.seekAudioBackward)
				    document.querySelector('#play-button').addEventListener('click', self.playAudio)
				    window.addEventListener('keydown', function(event){
				    	if(event.keyCode == 32){
				    		event.preventDefault();
				    		self.playAudio();
				    	}
				    })

					self.toggleZoom();
					window.addEventListener('resize', self.toggleZoom);


				  });

	}

	this.initializeAddSegmentView = function(){
			var AudioContext = window.AudioContext = ( window.AudioContext || window.webkitAudioContext );
			var initializedAudioContext = new AudioContext();

			if (existingSegments !== null
		  	&& existingSegments !== undefined
		  	&& existingSegments !== false){

		  	if ( Array.isArray(existingSegments) ){
			  existingSegments.forEach(function(segment){
			  	segment.startTime = parseFloat(segment.startTime);
			  	segment.endTime = parseFloat(segment.endTime);
			 });
			} else {
				existingSegments.startTime = parseFloat(existingSegments.startTime);
				existingSegments.endTime = parseFloat(existingSegments.endTime);
				existingSegments = [existingSegments];
			}

		  } else {
		  	existingSegments = [];
		  }


		  var p = peaks.init({

		  	container: document.querySelector('#audiographic-waveform'),
		  	mediaElement: document.querySelector('#audiographic-source'),
		  	audioContext: initializedAudioContext,
		  	segments: existingSegments,


		  });

		  var newSegment = new Vue({
		  		el: '#new-segment-form',
		  		data: {
		  			currentTime: p.time.getCurrentTime(),
		  			startTime: 60,
		  			endTime: 120,
		  			color: '#000000',
		  			segmentId: self.generateUniqueId(1, 100000),
		  			segmentTitle: '',

		  		},
		  		computed: {
		  			formattedTime: function(){
		  				var formattedTime;

		  				var minutes = Math.floor(this.currentTime) / 60;
		  				var seconds = this.currentTime - (minutes * 60);

		  				return (minutes + ":" + seconds);
		  			}
		  		},
		  		methods: {

		  		}
		  	});

		  self.audioElement.addEventListener('timeupdate', function(){
				      newSegment.currentTime = p.time.getCurrentTime();
				    })

		  p.on('segments.ready', function(){

		  	var clickDragStartTime = 0;
		  	var clickDragEndTime = 0;
		  	var isMouseDown = false;
		  	var isSegmentAlreadyAdded = false;

		  	var waveformCanvas = document.querySelector('#audiographic-waveform .overview-container');

		  	waveformCanvas.addEventListener('click', function(){

		  	});

		  	waveformCanvas.addEventListener('mousedown', function(){
		  		isMouseDown = true;

		  		clickDragStartTime = p.time.getCurrentTime();

		  	});

		  	waveformCanvas.addEventListener('mouseup', function(){
		  		isMouseDown = false;
		  		clickDragEndTime = p.time.getCurrentTime();

		  		if(clickDragStartTime !== clickDragEndTime && clickDragEndTime > clickDragStartTime){
		  			if(!isSegmentAlreadyAdded){

			  		newSegment.startTime = clickDragStartTime;
			  		newSegment.endTime = clickDragEndTime;
			  		p.segments.add({
				  		startTime: newSegment.startTime,
				  		endTime: newSegment.endTime,
				  		color: newSegment.color,
				  		editable: true,
				  		id: newSegment.segmentId,
				  	})

				  	document.querySelector('#new-segment-form').style.display ='block';

				  }
				  isSegmentAlreadyAdded = true;
			  	}
		  	});


		  	document.querySelector('#add-segment').addEventListener('click', function(){

		  		if (!isSegmentAlreadyAdded){
					p.segments.add({
				  		startTime: (newSegment.currentTime > 1) ? newSegment.currentTime : 3 ,
				  		endTime: (newSegment.currentTime + (self.audioElement.duration /10) ),
				  		color: newSegment.color,
				  		editable: true,
				  		id: newSegment.segmentId,
				  	})
				  	document.querySelector('#new-segment-form').style.display ='block';
			  	}
			  	isSegmentAlreadyAdded = true;

		  	})

		  	//Sync up audio controls
		  	 //hook up custom audio controls to UI
		    document.querySelector('#zoom-out-button').addEventListener('click', p.zoom.zoomOut)
		    document.querySelector('#zoom-in-button').addEventListener('click', p.zoom.zoomIn)
		    document.querySelector('#seek-forward-button').addEventListener('click', self.seekAudioForward)
		    document.querySelector('#seek-backward-button').addEventListener('click', self.seekAudioBackward)
		    document.querySelector('#play-button').addEventListener('click', self.playAudio)


		  });

		p.on('segments.dragged', function(event){
		  	newSegment.startTime = event.startTime;
		  	newSegment.endTime = event.endTime;
		 });


	}

	this.initializeEditSegmentView = function(){
			var AudioContext = window.AudioContext = ( window.AudioContext || window.webkitAudioContext );
			var initializedAudioContext = new AudioContext();
			if (existingSegments !== null
		  	&& existingSegments !== undefined
		  	&& existingSegments !== false){

		  	if ( Array.isArray(existingSegments) ){
			  existingSegments.forEach(function(segment){
			  	segment.startTime = parseFloat(segment.startTime);
			  	segment.endTime = parseFloat(segment.endTime);
			 });
			} else {
				existingSegments.startTime = parseFloat(existingSegments.startTime);
				existingSegments.endTime = parseFloat(existingSegments.endTime);
				existingSegments = [existingSegments];
			}

		  } else {
		  	existingSegments = [];
		  }

		  var p = peaks.init({

		  	container: document.querySelector('#audiographic-waveform'),
		  	mediaElement: document.querySelector('#audiographic-source'),
		  	audioContext: initializedAudioContext,
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
		    document.querySelector('#seek-forward-button').addEventListener('click', self.seekAudioForward)
		    document.querySelector('#seek-backward-button').addEventListener('click', self.seekAudioBackward)
		    document.querySelector('#play-button').addEventListener('click', self.playAudio)


		  });

		  p.on('segments.dragged', function(event){
		  	newSegment.startTime = event.startTime;
		  	newSegment.endTime = event.endTime;
		 });



	}

}
