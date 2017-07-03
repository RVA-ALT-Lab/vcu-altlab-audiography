<?php 

require_once(plugin_dir_path(__FILE__) . '/partials/audiography-header.php');

?>
<div class="wrap">
<?php foreach($audiographic_list as $value): ?>

	<h2><?php echo $value['id'] ?></h2>
	<p><?php echo $value['name'] ?></p>
	<p><?php echo $value['media_url'] ?></p>
	<?php echo sprintf('<a href="/wp-admin/admin.php?page=vcu_altlab_audiography&action=edit&id=%s">Edit This File</a>', $value['id']) ?>
<?php endforeach; ?>

</div>