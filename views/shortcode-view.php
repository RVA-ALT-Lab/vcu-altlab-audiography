
<div class="row audiographic-container">
<div class="col-lg-12">
	<h3><?php echo $selected_audiographic['name']; ?></h3>
	<?php echo sprintf('<audio id="audiographic-source"> <source src="%s"></source></audio>', AudiographyPlugin::stripProtocolFromString($selected_audiographic['media_url'])); ?>
	<div id="audiographic-waveform">
		
	</div>
	<div class="hidden-content">
		<?php for($i = 0; $i < count($selected_audiographic_segments); $i++): ?>
		<div id="<?php echo $selected_audiographic_segments[$i]['id']; ?>">

				<?php echo $selected_audiographic_segments[$i]['segmentDescription']; ?>
				
		</div>
		<?php endfor; ?> 	
	</div>
</div>
<br>
<div class="col-lg-12" id="segments-list">
<br>
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
			<div class="btn btn-default" id="zoom-button">
				<span class="glyphicon glyphicon-zoom-in"></span>
			</div>
		</div>
			<h5>
				Current Time: {{formattedTime}} 
			</h5>
			<div>
			<div class="row">
				<div class="col-lg-3 col-md-3">
				<div class="list-group hidden-sm hidden-xs">
				      <a v-bind:class="{active: (segment.startTime < currentTime && segment.endTime > currentTime), 'list-group-item': true }" v-for="segment in segments" v-on:click="seekToSegment(segment)">
				      <h5>{{segment.segmentName }}</h5>
				      <p>{{ formatTime(segment.startTime) }} - {{formatTime(segment.endTime)}}</p>
				      </a>
				 </div>

				 <div class="list-group hidden-md hidden-lg">
				    
					 <div class="btn-group btn-group-justified">
					 	<a class="btn btn-primary" v-on:click="seekToPreviousSegment(currentSegment)">
					 		<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Previous Segment
					 	</a>
					 	<a class="btn btn-primary" v-on:click="seekToNextSegment(currentSegment)">
					 		Next Segment&nbsp;<span class="glyphicon glyphicon-chevron-right"></span>
					 	</a>
					 </div>
				 </div>
				</div>
				<div class="col-lg-9 col-md-9">
					<div class="panel panel-default">
						<div class="panel-body" id="current-segment-description">
							<h2 v-if="currentSegment">{{currentSegment.segmentName}}&nbsp;({{formatTime(currentSegment.startTime)}} - {{formatTime(currentSegment.endTime)}})</h2>
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
	var existingSegments = <?php echo $segments_json; ?>; 
</script>