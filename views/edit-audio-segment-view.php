<?php 
require_once(plugin_dir_path(__FILE__) . '/partials/audiography-header.php');
?>

<div class="wrap">

<h2><?php echo $selected_audiographic['name'] ?></h2>
<table class="table">
	<tr>
		<td>ID</td>
		<td><?php echo $selected_audiographic['id'] ?></td>
	</tr>
	<tr>
		<td>Media URL</td>
		<td>
		<?php echo sprintf('<a href="%s">%s</a>', AudiographyPlugin::stripProtocolFromString($selected_audiographic['media_url']), AudiographyPlugin::stripProtocolFromString($selected_audiographic['media_url']));  ?>
		</td>
	</tr>
</table>
<br>

<?php echo sprintf('<audio id="audiographic-source"> <source src="%s"></source></audio>', AudiographyPlugin::stripProtocolFromString($selected_audiographic['media_url'])) ?>
		<div id="custom-audio-controls">
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
<div id="audiographic-waveform"></div>
<br>

<div id="edit-segment-form">
	<form name="edit-segment" id="edit-segment" method="post">
	<div class="row">
		<div class="col-lg-4">
		<input type="hidden" name="edit-segment-submitted" id="edit-segment-submitted" value="Y">
		<input type="hidden" name="audiographic-id" value="<?php echo $selected_audiographic['id'] ?>">
		<div class="form-group">
			<label>Segment Title</label>
			<input type="text" name="segment-name" id="segment-name" v-model="segmentName" class="form-control">	
		</div>
		<label for="color">Color</label>
		<div class="radio">
			<label for='red'>
			<input type="radio" name="red" value="#ff0000" v-model="color">
			Red</label>
		</div>
		<div class="radio">
			<label for='green'>
			<input type="radio" name="green" value="#008000" v-model="color">
			Green</label>
		</div>
		<div class="radio">
			<label for='blue'>
			<input type="radio" name="blue" value="#0000ff" v-model="color">
			Blue <div class="color-swatch" style="background-color: #0000ff;"></div></label>
		</div>
		<div class="radio">
			<label for='yellow'>
			<input type="radio" name="yellow" value="#ffff00" v-model="color">
			Yellow</label>
		</div>
		<div class="radio">
			<label for='orange'>
			<input type="radio" name="orange" value="#ffa500" v-model="color">
			Orange</label>
		</div>
		<div class="radio">
			<label for='purple'>
			<input type="radio" name="purple" value="#800080" v-model="color">
			Purple</label>
		</div>	
		<input type="hidden" name="color" v-model="color"> 
		
		<div class="form-group">
			<label for="beginning-time">Beginning Time (in seconds)</label>
			<span class="help-block">Use the sliders on the waveform to edit the start time for this segment.</span>
			<input type="text"  name="beginning-time" class="form-control" v-model="startTime" readonly="readonly">
		</div>
		<div class="form-group">
			<label for="ending-time">Ending Time (in seconds)</label>
			<input type="text" class="form-control" name="ending-time" v-model="endTime" readonly="readonly">	
		</div>
		<div class="form-group">
			<label for="segment-id">Segment ID</label>
			<input type="text" class="form-control" name="segment-id" id="segment-id" v-model="segmentId" readonly="readonly">
		</div>
		</div>

		
		<div class="col-lg-8">

		<?php wp_editor($selcted_segment['segmentDescription'], 'segment-description', array('textarea_name' => 'segment-description')); ?>
		</div>

		</div>

		<?php submit_button('Submit');  ?>

	</form>
</div>

</div>

<script type="text/javascript">
	var existingSegments = <?php echo $segments_json; ?>; 
</script>