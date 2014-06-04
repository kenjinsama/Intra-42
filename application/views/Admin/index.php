<?php
	echo heading("Projets", 2);
	echo $this->table->generate($projects);

	echo heading("Modules", 2);
	echo $this->table->generate($modules);
	// foreach ($projects as $data)
	// {
	// 	var_dump($data);
	// 	echo "<br/>";
	// 	echo "<br/>";
	// }