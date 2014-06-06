<?php
echo anchor(base_url() . "user/tickets", "Show tickets", ["class" => "tickets"]);
echo form_open('user/validate_tickets');
echo form_label('Type : ', 'type');
echo form_dropdown('type', $enums);
echo form_error('type', '<span class="error">', '</span>');
echo '<br />';
echo form_label('Title : ', 'title_ticket');
echo form_input($title);
echo form_error('title_ticket', '<span class="error">', '</span>');
echo '<br />';
echo form_label('Description : ', 'description');
echo form_textarea(array("name" => 'description', "id" => "description"));
echo form_error('description', '<span class="error">', '</span>');
echo '<br />';
echo form_label('Priority : ', 'priority');
echo form_dropdown('priority', $priorities, 'NORMAL');
echo form_error('priority', '<span class="error">', '</span>');
echo '<br />';
echo form_submit('submit', 'Submit');
echo form_close();
?>
