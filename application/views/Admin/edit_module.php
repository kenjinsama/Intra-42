<?php
echo form_open(base_url() . 'admin/validate_edit_m/' . $modules->id);

echo	"<div class='form_separator'>";
echo	form_error('name', '<span class="error">', '</span>');
echo	form_label('Module Name', 'name');
echo	form_input(array('name' => 'name', 'id' => 'name', 'value' => $modules->name));
echo	"</div>";

echo	"<div class='form_separator'>";
echo	form_error('description', '<span class="error">', '</span>');
echo	form_label('Description', 'description');
echo	form_textarea(array('name' => 'description', 'id' => 'description', 'value' => $modules->desc));
echo	"</div>";

echo	"<div class='form_separator'>";
echo	form_error('nb_credit', '<span class="error">', '</span>');
echo	form_label('Credit(s) number', 'nb_credit');
echo	form_input(array('name' => 'nb_credit', 'id' => 'nb_credit', 'value' => $modules->credits, 'type' => 'number', 'min' => '0'));
echo	"</div>";

echo	"<div class='form_separator'>";
echo	form_error('nb_place', '<span class="error">', '</span>');
echo	form_label('Place(s) number', 'nb_place');
echo	form_input(array('name' => 'nb_place', 'id' => 'nb_place', 'value' => $modules->nb_place, 'type' => 'number', 'min' => '0'));
echo	"</div>";

$date = $modules->dt_start;

echo	"<div class='form_separator'>";
echo	form_error('dt_start', '<span class="error">', '</span>');
echo	form_error('dt_start_h', '<span class="error">', '</span>');
echo	form_label('Start', 'dt_start');
echo	form_input(array('name' => 'dt_start', 'id' => 'dt_start', 'type' => 'date', 'value' => substr($date, 0, 10)));
echo	form_input(array('name' => 'dt_start_h', 'id' => 'dt_start_h', 'type' => 'time', 'value' => substr($date, 11, 5)));
echo	"</div>";

$date = $modules->dt_end;

echo	"<div class='form_separator'>";
echo	form_error('dt_end', '<span class="error">', '</span>');
echo	form_error('dt_end_h', '<span class="error">', '</span>');
echo	form_label('End', 'dt_end');
echo	form_input(array('name' => 'dt_end', 'id' => 'dt_end', 'type' => 'date', 'value' => substr($date, 0, 10)));
echo	form_input(array('name' => 'dt_end_h', 'id' => 'dt_end_h', 'type' => 'time', 'value' => substr($date, 11, 5)));
echo	"</div>";

$date = $modules->dt_end_insc;

echo	"<div class='form_separator'>";
echo	form_error('dt_end_insc', '<span class="error">', '</span>');
echo	form_error('dt_end_insc_h', '<span class="error">', '</span>');
echo	form_label('End inscription', 'dt_end_insc');
echo	form_input(array('name' => 'dt_end_insc', 'id' => 'dt_end_insc', 'type' => 'date', 'value' => substr($date, 0, 10)));
echo	form_input(array('name' => 'dt_end_insc_h', 'id' => 'dt_end_insc_h', 'type' => 'time', 'value' => substr($date, 11, 5)));
echo	"</div>";

echo	form_submit(array("class" => "btn btn-lg btn-success", "value" => "Confirm", "type" => "submit"));

echo form_close();

?>


