<?php
	echo heading("Projets", 2);
	echo $this->table->generate($projects);

	echo heading("Modules", 2);
	echo $this->table->generate($modules);
?>