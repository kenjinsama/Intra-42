<?php
echo form_open('connexion/login', array('id' => 'form_inscription'));

echo	form_error('login', '<span class="error">', '</span>');
echo	form_input(array('name' => 'login'));
echo	form_error('password', '<span class="error">', '</span>');
echo	form_input(array('name' => 'password'));
echo	form_submit('submit', 'Sign in');

echo form_close();