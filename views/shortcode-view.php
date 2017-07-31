
<div class="row">
<div class="col-lg-12">
	<h3><?php echo $selected_audiographic['name']; ?></h3>
	<?php echo sprintf('<audio id="audiographic-source"> <source src="%s"></source></audio>', $selected_audiographic['media_url']) ?>
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
				Current Time: {{currentTime}} 
			</h5>
			<div>
			<div class="row">
				<div class="col-lg-3">
					<div class="list-group">
				    <div v-bind:class="{active: (segment.startTime < currentTime && segment.endTime > currentTime), 'list-group-item': true }" v-for="segment in segments">
				      <a v-on:click="seekToSegment(segment)">
				      <h5>{{segment.segmentName }}</h5>
				      <button type="button" v-on:click="seekToNextSegment(segment)">Next</button>
				      <button type="button" v-on:click="seekToPreviousSegment(segment)">Previous</button>
				      <p>{{Math.floor(segment.startTime)}} - {{Math.floor(segment.endTime)}}</p>
				      </a>
				    </div>
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
	var existingSegments = <?php echo $segments_json; ?>; 
</script>