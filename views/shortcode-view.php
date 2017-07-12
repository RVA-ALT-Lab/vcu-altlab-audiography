
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
	var existingSegments = <?php echo $segments_json; ?>; 
</script>