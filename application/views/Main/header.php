<!DOCTYPE HTML>
<HTML lang="fr">
<HEAD>
	<META charset="utf-8">
	<TITLE>Intra 42</TITLE>
	<LINK rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" type="text/css" media="screen"/>
	<SCRIPT type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></SCRIPT>
	<SCRIPT type="text/javascript" src="<?PHP echo base_url(); ?>assets/js/main.js"></SCRIPT>
</HEAD>
<BODY style="overflow-x: hidden;">
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
			echo "<img src='" . $profil_img . "' id='img-profile'>";
			?>
		</DIV>
		<DIV id="option">
			<?PHP
			/*
			**	Liens dans le menu visible apres clic sur la photo
			*/
			echo anchor(base_url().'user/profile', 'Profile', array('class' => 'button')) . '<BR />';
			echo anchor(base_url().'user/tickets', 'Tickets', array('class' => 'button')) . '<BR />';
			echo anchor(base_url() . "connexion/logout", "Log out") . '<BR />';
			if ($admin)
			{
				echo anchor(base_url() . "admin", "Panel Admin") . "<br />";
			}
			?>
		</DIV>
	</HEADER>
	<NAV>
		<?PHP echo img( array( 'src' => base_url() . 'assets/images/arrow.png', 'id' => 'img-nav') );?>
		<?php
			if ($admin)
			{
				echo anchor(base_url() . "admin/add_module", "+ Modules") . "<br />";
				echo anchor(base_url() . "admin/add_project", "+ Projets") . "<br />";
			}
			/*
			**	Impression des semestres, modules et projets chargé dans le loader_helper => load_nav
			*/
			if (isset($nav[0]["semestre"]))
			{
				$semestre = $nav[0]["semestre"];
				echo anchor(base_url() . "module", "Semestre " . $semestre, ["class" => "semestre_link"]) . "<br />";
			}
			foreach ($nav as $data)
			{
				if (isset($data["semestre"]) && $data["semestre"] != $semestre)
				{
					$semestre = $data["semestre"];
					echo anchor(base_url() . "module", "Semestre " . $semestre, ["class" => "semestre_link"]) . "<br />";
				}
				echo anchor(base_url() . "module/projects/" . $data['name'], $data['name'], ["class" => "module_link"]) . "<br />";
				if (isset($data['project']))
				{
					foreach ($data['project'] as $project)
						echo anchor(base_url() . "module/project/" . $project['name'], $project['name'], ["class" => "project_link"]) . "<br />";
				}
			}
		?>
	</NAV>
	<SELECTION>
