<h1>Database Install</h1>

<?php
echo form_open(base_url() . 'install/validate');

echo	form_error('hostname', '<span class="error">', '</span>');
echo	form_input(array('name' => 'hostname', 'placeholder' => 'hostname for database'));

echo	form_error('username', '<span class="error">', '</span>');
echo	form_input(array('name' => 'username', 'placeholder' => 'Database username'));

echo	form_error('password', '<span class="error">', '</span>');
echo	form_input(array('name' => 'password', 'placeholder' => 'password', 'type' => 'password'));

echo	form_error('conf_pass', '<span class="error">', '</span>');
echo	form_input(array('name' => 'conf_pass', 'placeholder' => 'Password Confirmation', 'type' => 'password'));

echo	form_error('database', '<span class="error">', '</span>');
echo	form_input(array('name' => 'database', 'placeholder' => 'Database name'));

echo	form_submit('submit', 'Install');

echo form_close();

?>
