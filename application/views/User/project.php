<?PHP
echo heading($project->name, 2);
echo div("groupe de " . $project->grp_size . ($project->grp_size > 1 ? " personnes" : " personne"));
if ($project->auto_insc == "TRUE")
	echo div("Inscription automatique");
else
	echo div("vous etes inscrit");
if (isset($inscription) && $inscription["state"] == "UNREGISTERED")
	echo anchor(base_url() . "module/project_register/id=" . $project->id, "Inscription");
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