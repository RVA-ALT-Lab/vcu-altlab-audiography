<?php 

require_once(plugin_dir_path(__FILE__) . '/partials/audiography-header.php');

?>

<?php foreach($audiographic_list as $value): ?>

	<h2><?php echo $value['id'] ?></h2>
	<p><?php echo $value['name'] ?></p>
	<p><?php echo $value['media_url'] ?></p>
<?php endforeach; ?>