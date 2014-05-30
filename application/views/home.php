<?php
	/*
	**	Affichage des projets en cours
	*/
	foreach ($project as $data)
	{
?>

		<div class='current_project'>
			<h1><?php echo $data["name"]; ?></h1>

<?php
			echo anchor(base_url() . $data["pdf_url"], "Sujet", ["class" => "sujet_button"]) . "</br>";
			echo anchor(base_url() . "module/inscription/" . $data["name"], "inscription", ["class" => "insc_button"]);

			/*
			**	Calcule temps restant & progression (%)
			*/
			$rest = strtotime($data["dt_end"]) - time();
			$state = round($rest / ((strtotime($data["dt_end"]) - strtotime($data["dt_start"])) / 100), 1);
			$rest = ($rest / 60) / 60;
			if ($rest < 24)
				$rest = round($rest) < 2 ? round($rest) . " heure restante" : round($rest) . " heures restante";
			else
				$rest = round($rest / 24) < 2 ? round($rest / 24) . " jour restant" : round($rest / 24) . " jours restant";
?>

			<div><?php echo $rest; ?></div>
			<div><?php echo $state . "%"; ?></div>
			<div class='current_p_desc'><?php echo $data["desc"]; ?></div>
		</div>

<?php
	}
?>