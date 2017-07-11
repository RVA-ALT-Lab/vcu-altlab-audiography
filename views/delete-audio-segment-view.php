<?php 
require_once(plugin_dir_path(__FILE__) . '/partials/audiography-header.php');
?>

<?php if(!$deleted_successful): ?>
<p>Are you sure you want to delete this segment or point?</p>
<p>If you delete this annotation, the file, its metadata, and any existing segments will be deleted as well. Press the delete button below to confirm your action.</p>
<table class="table">
	<tr>
		<th>Segment Name</th>
		<td><?php echo $segment_to_delete['segmentName']; ?></td>
	</tr>
	<tr>
		<th>Start Time</th>
		<td><?php echo $segment_to_delete['startTime']; ?></td>
	</tr>
	<tr>
		<th>End Time</th>
		<td><?php echo $segment_to_delete['endTime']; ?></td>
	</tr>
	<tr>
		<th>Segment Description</th>
		<td><?php echo $segment_to_delete['segmentDescription']; ?></td>
	</tr>
</table>


<a href="/wp-admin/admin.php?page=vcu_altlab_audiography&action=delete&id=<?php echo $audiographic_id; ?>&segmentId=<?php echo $segment_id; ?>&confirm=true" class="btn btn-block btn-danger">Yes, Delete This Segment</a>

<?php endif; ?>
<?php if($deleted_successful): ?>
	<div class="alert alert-success alert-dismissable">
		Your segment #<?php echo $segment_id; ?> was deleted successfully.
	</div>


	<a href="/wp-admin/admin.php?page=vcu_altlab_audiography&action=edit&id=<?php echo $audiographic_id; ?>" class="btn btn-primary">Click here to continue editing <span class="glyphicon glyphicon-pencil"></span> </a>
<?php endif; ?>


<?php 
require_once(plugin_dir_path(__FILE__) . '/partials/audiography-footer.php');
?>