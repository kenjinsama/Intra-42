<div class="content_page">

	<?PHP
	echo heading($project->name, 2);
	echo div("groupe de " . $project->grp_size . ($project->grp_size > 1 ? " personnes" : " personne"));
	echo br();
	echo br();
	if ($project->auto_insc == "TRUE")
		echo div("Inscription automatique");
	$state = $this->projects_m->get_project_stats($project->id, $this->session->userdata['user_login']);
	if ((!isset($inscription) && $available == TRUE) || (isset($inscription) && $inscription["state"] == "UNREGISTERED" && $available == TRUE))
		echo anchor(base_url().'module/project_register?id='.$project->id.'&name='.$project->name, 'Inscription', array('class' => 'btn btn-lg btn-success'));
	else if ($available == FALSE)
		echo "Impossible de s'inscrire ! <BR />Il n'y a plus de place ou ce n'est pas le moment";
	else if ($available == TRUE || ($inscription["state"] == "REGISTERED" && $nb_insc >= $project->nb_place))
		echo anchor(base_url().'module/project_unregister/'.$project->id, 'Desinscription', array('class' => 'btn btn-lg btn-danger'));
	echo br();
	echo br();
	echo br();
	echo anchor($project->pdf_url, "Sujet");

	echo div($project->desc);

	if ($project->grp_size > 1 && isset($grp) && $inscription["state"] != "UNREGISTERED")
	{
		echo heading("Composition de votre groupe", 4);
		echo heading("chef de grp : ". $this->check_log->obtain_name($inscription["id_master"]), 5);
		foreach ($grp as $data)
		{
			echo div($this->check_log->obtain_name($data["user_id"]));
		}
	}

	?>

</div>