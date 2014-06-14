<?php
	/*
	**	Affichage des projets en cours
	*/
	foreach ($projects as $project)
	{
?>

		<div class='current_project'>
			<h1><?php echo $project->name; ?></h1>

<?php
			/*
			 *	Etat du projet
			 */
			if (!isset($this->projects_m))
				$this->load->model('projects_m');
			$state = $this->projects_m->get_project_stats($project->id, $this->session->userdata['user_login']);
			$nb_insc = $this->db->query("SELECT COUNT(`id`) FROM `user_projects` WHERE `state` = 'REGISTERED' AND `project_id` = ?", array($project->id));
			$nb_insc = $nb_insc->result_array();
			if ($state == 'UNREGISTERED' && strtotime($project->dt_end_insc) > time() && $nb_insc[0]["COUNT(`id`)"] < $project->nb_place)
				echo anchor(base_url().'module/project_register?id='.$project->id.'&name='.$project->name, 'Inscription', array('class' => 'button'));
			else
			{
				echo anchor(base_url() . $project->pdf_url, "Sujet", ["class" => "sujet_button"]) . "</br>";
				echo $state;
			}

			/*
			**	Calcule temps restant & progression (%)
			*/
			$rest = strtotime($project->dt_end) - time();
			$state = round($rest / ((strtotime($project->dt_end) - strtotime($project->dt_start)) / 100), 1);
			$rest = ($rest / 60) / 60;
			if ($rest < 24)
				$rest = round($rest) < 2 ? round($rest) . " heure restante" : round($rest) . " heures restante";
			else
				$rest = round($rest / 24) < 2 ? round($rest / 24) . " jour restant" : round($rest / 24) . " jours restant";
?>

			<div><?php echo 'Durée: '.$this->projects_m->get_totaltime($project->id); ?></div>
			<div><?php echo $state . "%"; ?></div>
			<div class='current_p_desc'><?php echo $project->desc; ?></div>
		</div>
<?php
	}

	/*
	**	DEBUG : affichage des id des correcteurs
	*/
	$correction = $this->projects_m->get_projects_correction();
	foreach ($correction as $data)
	{
		if ($data["id"] > 0)
		{
			$result = $this->projects_m->get_corrector($data["id"]);
			foreach ($result as $res)
			{
				echo "Vous devez être noté(e) par ".$this->check_log->obtain_name($res['corrector_id'])."<BR />";
			}
			$result = $this->projects_m->get_corrected($data["id"]);
			foreach ($result as $res)
			{
				if($res['rate'] == null)
					echo anchor(base_url().'module/project_correction/'.$data["id"]."/".$res['id_user'], 'Vous devez corriger '.$this->check_log->obtain_name($res['id_user']))."<BR />";
				else
				{
					echo "Vous avez donné la note ".$res['rate']." à ".$this->check_log->obtain_name($res['id_user']).". ";
					if ($res['nb_stars'] == null)
						echo "La note n'a pas été apprécié<BR />";
					else
						echo "La note a été appréciée ".$res['nb_stars']." étoiles<BR />";
				}
			}
		}
	}
?>