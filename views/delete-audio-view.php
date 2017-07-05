<?php 
require_once(plugin_dir_path(__FILE__) . '/partials/audiography-header.php');
?>

<p>Are you sure you want to delete this audiographic?</p>
<p>If you delete this audiographic, the file, its metadata, and any existing segments will be deleted as well. Press the delete button below to confirm your action.</p>
<a href="/wp-admin/admin.php?page=vcu_altlab_audiography&action=delete&id=<?php echo $audiographic_id; ?>&confirm=true" class="btn btn-block btn-danger">Yes, Delete This Audiographic</a>

<?php 
require_once(plugin_dir_path(__FILE__) . '/partials/audiography-footer.php');
?>