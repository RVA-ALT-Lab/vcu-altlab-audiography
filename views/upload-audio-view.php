<?php

require_once(plugin_dir_path(__FILE__) . '/partials/audiography-header.php');

?>

<div class="col-lg-12">

<?php if($audiographic_upload_successful): ?>
	<div class="alert alert-success alert-dismissable">
		Your file <?php echo $audiographic_name; ?> was uploaded successfully.

		<?php echo sprintf('<a href="%s/wp-admin/admin.php?page=vcu_altlab_audiography&action=edit&id=%s">Click here to start editing this audiographic.</a>', get_site_url(), $uploaded) ?>
	</div>

<?php endif; ?>

<?php if($audiographic_upload_error): ?>
	<div class="alert alert-danger alert-dismissable">
		There was an error uploading your file, <?php echo $audiographic_name; ?>.
		Details: <?php echo $audiographic_upload_error ?>
	</div>

<?php endif; ?>
	<p>You can upload either an audio file from your local computer, or you can provide a link to a public audio file stored in a cloud service like Dropbox or Google Drive. If, for whatever reason, you decide to include both, the URL will be disregarded.</p>

	<form id="upload-audio" name="upload-audio" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="audiographic-name">Audiographic Name</label>
		<br>
		<input type="text" name="audiographic-name" id="audiographic-name" class="regular-text">
	</div>
	<div class="form-group">
		<label for="uploaded-audio">Audio File</label>
		<br>
		<input type="file" name="uploaded-audio" name="uploaded-audio">
	</div>
	<input type="hidden" name="is-uploaded-audio" value="Y">
	<?php submit_button('Upload') ?>

	</form>
</div>

<?php
require_once(plugin_dir_path(__FILE__) . '/partials/audiography-footer.php');
?>