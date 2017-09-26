//either sets this equal to JSON from PHP or an empty array
var existingSegments = existingSegments || [];

document.addEventListener('DOMContentLoaded', function(event){
	// var segments = ('existingSegments' in window
	// 				&& typeof existingSegments != 'undefined')
	// 				? existingSegments : [];
		(function(Peaks, Audiography, existingSegments){

		    var audiography = new Audiography(document.querySelector('#audiographic-source'), Peaks, existingSegments);

		// This is all really to appease Safari. The creataion of the waveform needs to happen in Safari after the
		// data for the audio element loads. Since we are doing other stuff to differentiate between webkitAudioContext and AudioContext
		// elsewhere, this seems more sensible than UA sniffing

			// if (window.webkitAudioContext){
			// 	audiography.audioElement.addEventListener('loadeddata', audiography.initializeShortcodeView)
			// } else {
				audiography.initializeShortcodeView();
			// }

		// });
		//End event listener for when audio is loaded
		//Call once after everything has loaded to hide zoom on XS screens

		})(peaks, Audiography, existingSegments);
	});

