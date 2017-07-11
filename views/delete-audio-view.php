<?php 
require_once(plugin_dir_path(__FILE__) . '/partials/audiography-header.php');
?>

<?php if(!$deleted_successful): ?>
<p>Are you sure you want to delete this audiographic?</p>
<p>If you delete this annotation, the file, its metadata, and any existing segments will be deleted as well. Press the delete button below to confirm your action.</p>
<table class="table">
	<tr>
		<th>ID</th>
		<td><?php echo $selected_audiographic['id']; ?></td>
	</tr>
	<tr>
		<th>Name</th>
		<td><?php echo $selected_audiographic['name']; ?></td>
	</tr>
</table>


<a href="/wp-admin/admin.php?page=vcu_altlab_audiography&action=delete&id=<?php echo $audiographic_id; ?>&confirm=true" class="btn btn-block btn-danger">Yes, Delete This Audiographic</a>

<?php endif; ?>
<?php if($deleted_successful): ?>
	<div class="alert alert-success alert-dismissable">
		Your audiographic #<?php echo $audiographic_id; ?> was deleted successfully.
	</div>


	<a href="/wp-admin/admin.php?page=vcu_altlab_audiography" class="btn btn-primary">Click here to see all audiographics <span class="glyphicon glyphicon-home"></span> </a>
<?php endif; ?>


<?php 
require_once(plugin_dir_path(__FILE__) . '/partials/audiography-footer.php');
?>