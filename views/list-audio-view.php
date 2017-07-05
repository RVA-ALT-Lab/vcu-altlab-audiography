<?php 

require_once(plugin_dir_path(__FILE__) . '/partials/audiography-header.php');

?>
<div class="wrap">

<div class="list-group">
<?php foreach($audiographic_list as $value): ?>

<div class="list-group-item">
	<h2><?php echo $value['id'] ?></h2>
	<p><?php echo $value['name'] ?></p>
	<p><?php echo $value['media_url'] ?></p>
	<?php echo sprintf('<a class="btn btn-primary" href="/wp-admin/admin.php?page=vcu_altlab_audiography&action=edit&id=%s"><span class="glyphicon glyphicon-pencil"></span> Edit This File</a>', $value['id']) ?>
	<?php echo sprintf('<a class="btn btn-danger" href="/wp-admin/admin.php?page=vcu_altlab_audiography&action=delete&id=%s"><span class="glyphicon glyphicon-trash"></span> Delete This File</a>', $value['id']) ?>

</div>
<?php endforeach; ?>

</div>
</div>


<?php require_once(plugin_dir_path(__FILE__) . '/partials/audiography-footer.php'); ?>