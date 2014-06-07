<?PHP if (isset($error)) : ?>
	<DIV id="upload-error"><?PHP echo $error; ?></DIV>
<?PHP endif; ?>
<?PHP if (isset($ok)) : ?>
	<DIV id="upload-ok"><?PHP echo $ok; ?></DIV>
<?PHP endif;?>

Select Video :
<form class="cssform" name="property" id="property" method="POST" action="<?php echo base_url()?>e_learning/upload_video"  enctype="multipart/form-data" >
	<select name="project" class="text">
		<option>Pour le projet</option>
		<?php
		foreach ($projects as $row)
		{
			echo "<option value='$row->id'";
			echo" >$row->name </option>";
		}
		?>
	</select>
	<input type="file" id="video" name="video" />
	<input id="name" name="name" placeholder="Rename"/>
	<input type="submit" id="button" name="submit" value="Submit" />
</form>