<?PHP

echo $coms;

echo form_open(base_url() . 'module/validate_project/'.$id_project."/".$id_corrector."/".$id_user);

echo	"<div class='form_separator'>";
echo	form_error('note', '<span class="error">', '</span>');
echo	form_label('Note', 'note');
echo	form_input(array('type' => 'number', 'min' => '0', 'max' => '5', 'name' => 'note', 'id' => 'note', 'placeholder' => '0'));
echo	"</div>";

echo	form_submit(array("class" => "btn btn-lg btn-success", "value" => "Confirm", "type" => "submit"));

echo form_close()

?>