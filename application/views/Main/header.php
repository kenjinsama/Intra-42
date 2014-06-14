<!DOCTYPE HTML>
<HTML lang="fr">
<HEAD>
	<META charset="utf-8">
	<TITLE>Intra 42</TITLE>
	<LINK rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<SCRIPT type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></SCRIPT>
	<SCRIPT type="text/javascript" src="<?PHP echo base_url(); ?>assets/js/main.js"></SCRIPT>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</HEAD>
<BODY style="overflow-x: hidden;">
	<HEADER>
		<DIV id="logo">
			<?PHP
			echo anchor(base_url() . "/", img( array( 'src' => base_url() . 'assets/images/42.png', 'id' => 'home') ) );
			?>
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
			echo anchor(base_url().'user/yearbook', 'Annuaire', array('class' => 'button')) . '<BR />';
			if ($admin)
				echo anchor(base_url().'admin', 'Admin', array('class' => 'button')) . '<BR />';
			echo anchor(base_url() . "connexion/logout", "Log out") . '<BR />';
			?>
		</DIV>
	</HEADER>
	<NAV>
		<?PHP echo img( array( 'src' => base_url() . 'assets/images/arrow.png', 'id' => 'img-nav') );?>
		<?php
			if ($admin)
			{
				echo "Panel admin:<BR />";
				echo anchor(base_url() . "admin/add_module", "Ajouts de modules") . "<br />";
				echo anchor(base_url() . "admin/add_project", "Ajouts de projets") . "<br /><br />";
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
				echo anchor(base_url() . "module/projects/" . $data['id'], $data['name'], ["class" => "module_link"]) . "<br />";
				if (isset($data['project']))
				{
					foreach ($data['project'] as $project)
						echo anchor(base_url() . "module/project/" . $project['id'], $project['name'], ["class" => "project_link"]) . "<br />";
				}
			}

			/*
			**	e-learning
			*/

			echo br() . "E-learning :" . br();
			foreach ($nav as $data)
			{
				if (isset($data["semestre"]) && $data["semestre"] != $semestre)
				{
					$semestre = $data["semestre"];
					echo "<span class='semestre_link'>Semestre " . $semestre . "</span><br />";
				}
				echo "<span class='module_link'>" . $data['name'] . "</span><br />";
				if (isset($data['project']))
				{
					foreach ($data['project'] as $project)
						echo anchor(base_url() . "e_learning/project/" . $project['id'], $project['name'], ["class" => "project_link"]) . "<br />";
				}
			}
			echo br() . anchor(base_url() . "forum/", "Forum", ["class" => "semestre_link"]) . br();
		?>
	</NAV>
	<SELECTION>
