<!DOCTYPE HTML>
<HTML lang="fr">
<HEAD>
	<META charset="utf-8">
	<TITLE>Intra 42</TITLE>
	<LINK rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" type="text/css" media="screen"/>
	<SCRIPT type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></SCRIPT>
	<SCRIPT type="text/javascript" src="<?PHP echo base_url(); ?>assets/js/main.js"></SCRIPT>
</HEAD>
<BODY>
	<HEADER>
		<DIV id="logo">
			<A id="home" href="/">LOGO</A>
		</DIV>
		<DIV id="search-background"></DIV>
		<DIV id="search">
		<?PHP
			echo form_label( img( array( 'src' => base_url() . 'assets/images/search.png', 'id' => 'img-search') ), 'search-input' );
			echo form_input( array( 'id' => 'search-input', 'name' => 'hostname', 'placeholder' => 'Search') );
		?>
		</DIV>
		<DIV id="profile">
		<?PHP
			// TODO:
			// if ($this->session->userdata('logged'))
			// 	echo img( array( 'src' => echo base_url() . LIEN_IMAGE_PROFILE_USER ) );
			// else
				echo img( array( 'src' => base_url() . 'assets/images/default-profile.png', 'id' => 'img-profile' ) );
		?>
		</DIV>
		<DIV id="option">
		<?PHP
			echo anchor(base_url().'user/profile', 'Profile', array('class' => 'button')) . '<BR />';
			echo anchor(base_url().'user/tickets', 'Tickets', array('class' => 'button'));
		?>
		</DIV>
	</HEADER>
	<NAV>
		Nav
	</NAV>
	<SELECTION>
