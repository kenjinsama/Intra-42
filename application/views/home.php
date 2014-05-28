<H1>Home</H1>
<img src="data:image/jpeg;base64,<?php echo $this->ldap->get_img($this->session->userdata('user_login')); ?>">
<?php
print_r($this->ldap->get_img("dsousa"));
