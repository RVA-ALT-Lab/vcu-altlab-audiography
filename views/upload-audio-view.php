<h2>Upload an Audio File</h2>

<?php 

require_once(plugin_dir_path(__FILE__) . '/partials/audiography-header.php');

?>

<form id="upload-audio" name="upload-audio" method="post" enctype="multipart/form-data">
<label for="audiographic-name">Audiographic Name</label>
<br>
<input type="text" name="audiographic-name" id="audiographic-name">
<br>
<br>
<label for="uploaded-audio">Audio File</label>
<br>
<input type="file" name="uploaded-audio" name="uploaded-audio">
<input type="hidden" name="is-uploaded-audio" value="Y">
<?php submit_button('Upload') ?>	

</form>
