//either sets this equal to JSON from PHP or an empty array
var existingSegments = existingSegments || []; 


//Perform this check of the query string to determine which DOM elements are present 
// for Peaks and Vue to bind to
var queryString = location.search; 
var isEditingAudiographic = ( queryString.includes('action=edit') && queryString.includes('id') && !queryString.includes('segmentId') ); 
var isEditingSegment = ( queryString.includes('action=edit') && queryString.includes('segmentId') ); 


document.addEventListener('DOMContentLoaded', function(event){



		var audiography = new Audiography(document.querySelector('#audiographic-source')); 		

		if (isEditingSegment){
			audiography.initializeEditSegmentView(); 

		} else if (isEditingAudiographic) {
			audiography.initializeAddSegmentView(); 
		}



}); 
