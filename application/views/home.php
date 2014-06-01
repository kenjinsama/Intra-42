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
			if ($state == -1)
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
?>