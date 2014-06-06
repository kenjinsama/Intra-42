<?php
echo form_open_multipart(base_url() . 'admin/validate_project');

echo	"<div class='form_separator'>";
echo	form_error ('name', '<span class="error alert alert-danger">', '</span>');
echo	form_label('Project Name', 'name');
echo	form_input(array('name' => 'name', 'id' => 'name', 'placeholder' => 'Roger ...'));
echo	"</div>";

echo	"<div class='form_separator'>";
echo	form_error ('description', '<span class="error alert alert-danger">', '</span>');
echo	form_label('Description', 'description');
echo	form_textarea(array('name' => 'description', 'id' => 'description', 'placeholder' => 'something ...'));
echo	"</div>";

echo	"<div class='form_separator'>";
echo	form_error ('dt_start', '<span class="error alert alert-danger">', '</span>');
echo	form_error ('dt_start_h', '<span class="error alert alert-danger">', '</span>');
echo	form_label('Start', 'dt_start');
echo	form_input(array('name' => 'dt_start', 'id' => 'dt_start', 'type' => 'date'));
echo	form_input(array('name' => 'dt_start_h', 'id' => 'dt_start_h', 'type' => 'time'));
echo	"</div>";

echo	"<div class='form_separator'>";
echo	form_error ('dt_end', '<span class="error alert alert-danger">', '</span>');
echo	form_error ('dt_end_h', '<span class="error alert alert-danger">', '</span>');
echo	form_label('End', 'dt_end');
echo	form_input(array('name' => 'dt_end', 'id' => 'dt_end', 'type' => 'date'));
echo	form_input(array('name' => 'dt_end_h', 'id' => 'dt_end_h', 'type' => 'time'));
echo	"</div>";

echo	"<div class='form_separator'>";
echo	form_error ('dt_end_insc', '<span class="error alert alert-danger">', '</span>');
echo	form_error ('dt_end_insc_h', '<span class="error alert alert-danger">', '</span>');
echo	form_label('End inscription', 'dt_end_insc');
echo	form_input(array('name' => 'dt_end_insc', 'id' => 'dt_end_insc', 'type' => 'date'));
echo	form_input(array('name' => 'dt_end_insc_h', 'id' => 'dt_end_insc_h', 'type' => 'time'));
echo	"</div>";

echo	"<div class='form_separator'>";
echo	form_error ('dt_end_corr', '<span class="error alert alert-danger">', '</span>');
echo	form_error ('dt_end_corr_h', '<span class="error alert alert-danger">', '</span>');
echo	form_label('End correction', 'dt_end_corr');
echo	form_input(array('name' => 'dt_end_corr', 'id' => 'dt_end_corr', 'type' => 'date'));
echo	form_input(array('name' => 'dt_end_corr_h', 'id' => 'dt_end_corrc_h', 'type' => 'time'));
echo	"</div>";
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

<select name="types" class="text">
	<option>Types</option>
	<option>PROJET</option>
	<option>EXAM</option>
	<option>TD</option>
</select>

<?PHP

echo	"<div class='form_separator'>";
echo	form_label('Inscription auto', 'auto_insc');
echo	form_checkbox(array('name' => 'auto_insc', 'id' => 'auto_insc', 'value' => TRUE));
echo	"</div>";

echo	"<div class='form_separator'>";
echo	form_error ('pdf_url', '<span class="error alert alert-danger">', '</span>');
echo	form_label('Sujet', 'pdf_url');
echo	form_input(array('name' => 'pdf_url', 'id' => 'pdf_url', 'type' => 'file'));
echo	"</div>";

echo	"<div class='form_separator'>";
echo	form_error ('grp_size', '<span class="error alert alert-danger">', '</span>');
echo	form_label('Group size', 'grp_size');
echo	form_input(array('name' => 'grp_size', 'id' => 'grp_size', 'placeholder' => 'xx', 'type' => 'number', 'min' => '0'));
echo	"</div>";

echo	"<div class='form_separator'>";
echo	form_error ('nb_corrector', '<span class="error alert alert-danger">', '</span>');
echo	form_label('Corrector(s) number', 'nb_corrector');
echo	form_input(array('name' => 'nb_corrector', 'id' => 'nb_corrector', 'placeholder' => 'xx', 'type' => 'number', 'min' => '0'));
echo	"</div>";

echo	"<div class='form_separator'>";
echo	form_error ('nb_place', '<span class="error alert alert-danger">', '</span>');
echo	form_label('Place(s) number', 'nb_place');
echo	form_input(array('name' => 'nb_place', 'id' => 'nb_place', 'placeholder' => 'xx', 'type' => 'number', 'min' => '0'));
echo	"</div>";

echo	"<div class='form_separator'>";
echo	form_error ('rating_scale', '<span class="error alert alert-danger">', '</span>');
echo	form_label('Barème de notation', 'rating_scale');
echo	form_textarea(array('name' => 'rating_scale', 'id' => 'rating_scale', 'placeholder' => 'something ...'));
echo	"</div>";
echo	form_submit(array("class" => "btn btn-lg btn-success", "value" => "Confirm", "type" => "submit"));

echo form_close();

?>
