<?php
echo form_open(base_url() . 'admin/validate_project');

echo	form_error('name', '<span class="error">', '</span>');
echo	form_label('Module Name', 'name');
echo	form_input(array('name' => 'name', 'id' => 'name', 'placeholder' => 'Roger ...'));

echo	form_error('description', '<span class="error">', '</span>');
echo	form_label('Description', 'description');
echo	form_textarea(array('name' => 'description', 'id' => 'description', 'placeholder' => 'something ...'));

echo	form_error('dt_start', '<span class="error">', '</span>');
echo	form_error('dt_start_h', '<span class="error">', '</span>');
echo	form_label('Start', 'dt_start');
echo	form_input(array('name' => 'dt_start', 'id' => 'dt_start', 'type' => 'date'));
echo	form_input(array('name' => 'dt_start_h', 'id' => 'dt_start_h', 'type' => 'time'));

echo	form_error('dt_end', '<span class="error">', '</span>');
echo	form_error('dt_end_h', '<span class="error">', '</span>');
echo	form_label('End', 'dt_end');
echo	form_input(array('name' => 'dt_end', 'id' => 'dt_end', 'type' => 'date'));
echo	form_input(array('name' => 'dt_end_h', 'id' => 'dt_end_h', 'type' => 'time'));

echo	form_error('dt_end_insc', '<span class="error">', '</span>');
echo	form_error('dt_end_insc_h', '<span class="error">', '</span>');
echo	form_label('End inscription', 'dt_end_insc');
echo	form_input(array('name' => 'dt_end_insc', 'id' => 'dt_end_insc', 'type' => 'date'));
echo	form_input(array('name' => 'dt_end_insc_h', 'id' => 'dt_end_insc_h', 'type' => 'time'));

echo	form_error('dt_end_corr', '<span class="error">', '</span>');
echo	form_error('dt_end_corr_h', '<span class="error">', '</span>');
echo	form_label('End correction', 'dt_end_corr');
echo	form_input(array('name' => 'dt_end_corr', 'id' => 'dt_end_corr', 'type' => 'date'));
echo	form_input(array('name' => 'dt_end_corr_h', 'id' => 'dt_end_corrc_h', 'type' => 'time'));

?>

<select name="module" class="text">
	<option>Module parent</option>
	<?php

	foreach ($modules as $row)
	{
		echo "<option value='$row->id'";
		echo" >$row->name </option>";
	}
	?>
</select>

<?PHP
echo	form_error('pdf_url', '<span class="error">', '</span>');
echo	form_label('URL du pdf', 'pdf_url');
echo	form_input(array('name' => 'pdf_url', 'id' => 'pdf_url', 'placeholder' => 'URL pdf'));

echo	form_error('grp_size', '<span class="error">', '</span>');
echo	form_label('Group size', 'grp_size');
echo	form_input(array('name' => 'grp_size', 'id' => 'grp_size', 'placeholder' => 'xx', 'type' => 'number', 'min' => '0'));

echo	form_error('nb_place', '<span class="error">', '</span>');
echo	form_label('Place(s) number', 'nb_place');
echo	form_input(array('name' => 'nb_place', 'id' => 'nb_place', 'placeholder' => 'xx', 'type' => 'number', 'min' => '0'));

echo	form_error('rating_scale', '<span class="error">', '</span>');
echo	form_label('Barème de notation', 'rating_scale');
echo	form_textarea(array('name' => 'rating_scale', 'id' => 'rating_scale', 'placeholder' => 'something ...'));

echo	form_submit('submit', 'Confirm');

echo form_close();

?>
