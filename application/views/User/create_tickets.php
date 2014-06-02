<?php

echo form_open('user/validate_tickets');
echo form_label('Title : ', 'title_ticket');
echo form_input($title);
echo form_error('title_ticket', '<span class="error">', '</span>');
echo '<br />';
echo form_label('Description : ', 'description');
echo form_textarea(array("name" => 'description', "id" => "description"));
echo form_error('description', '<span class="error">', '</span>');
echo form_submit('submit', 'Submit');
echo form_close();
?>
