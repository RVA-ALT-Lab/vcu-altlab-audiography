<?php 

require_once(plugin_dir_path(__FILE__) . '/partials/audiography-header.php');

?>
<div class="wrap">

<div class="list-group">
<?php if(isset($audiographic_list)): ?>
<?php foreach($audiographic_list as $value): ?>

<div class="list-group-item">
	<h2><?php echo $value['name'] ?></h2>
	<p>ID: <?php echo $value['id'] ?></p>
	<p>URL: <?php echo $value['media_url'] ?></p>
	<p>Shortcode: [audiographic id=<?php echo $value['id']; ?>]</p>
	<?php echo sprintf('<a class="btn btn-primary" href="%s/wp-admin/admin.php?page=vcu_altlab_audiography&action=edit&id=%s"><span class="glyphicon glyphicon-pencil"></span> Edit This File</a>', get_site_url(), $value['id']) ?>
	<?php echo sprintf('<a class="btn btn-danger" href="%s/wp-admin/admin.php?page=vcu_altlab_audiography&action=delete&id=%s"><span class="glyphicon glyphicon-trash"></span> Delete This File</a>', get_site_url(), $value['id']) ?>

</div>
<?php endforeach; ?>
<?php endif; ?>
<?php if(count($audiographic_list) == 0): ?>
<h2>Get started, and maybe are a few quick directions blah blah blah;</h2>


<?php endif; ?>

</div>
</div>


<?php require_once(plugin_dir_path(__FILE__) . '/partials/audiography-footer.php'); ?>