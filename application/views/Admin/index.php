<div id="content_page">
	<?php
		echo heading("Projets", 2);
		echo anchor(base_url() . 'e_learning/add_video', "Ajouter fichier e-learning", array('class' => 'btn btn-lg btn-success'));

		echo $this->table->generate($projects);

		echo heading("Modules", 2);
		echo $this->table->generate($modules);
	?>
</div>