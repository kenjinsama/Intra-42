<H1>Home</H1>
<?php

print_r($this->ldap->get_user_info($this->session->userdata("user_login")));