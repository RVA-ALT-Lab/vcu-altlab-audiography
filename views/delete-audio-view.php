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


<?php echo sprintf('<a class="btn btn-block btn-danger" href="%s/wp-admin/admin.php?page=vcu_altlab_audiography&action=delete&id=%s&confirm=true"><span class="glyphicon glyphicon-remove"></span> Yes, Delete This Audiographic</a>', get_site_url(), $audiographic_id) ?>



<?php endif; ?>
<?php if($deleted_successful): ?>
	<div class="alert alert-success alert-dismissable">
		Your audiographic #<?php echo $audiographic_id; ?> was deleted successfully.
	</div>

	<?php echo sprintf('<a class="btn btn-primary" href="%s/wp-admin/admin.php?page=vcu_altlab_audiography"><span class="glyphicon glyphicon-home"></span> Click here to see all audiographics</a>', get_site_url());?>
<?php endif; ?>


<?php 
require_once(plugin_dir_path(__FILE__) . '/partials/audiography-footer.php');
?>