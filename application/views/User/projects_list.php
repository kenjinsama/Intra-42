<LINK rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/project_style.css' ?>" media="all"/>

<H1>Projects list</H1>
<?php
if ($button["url"])
	echo anchor($button["url"], $button["name"], $button["class"]);
?>
<DIV id="projects">
<?PHP foreach ($projects as $project): ?>
	<DIV class="project">
		<DIV class="state">
			<?PHP
			if (!isset($this->projects_m))
				$this->load->model('projects_m');
			$state = $this->projects_m->get_project_stats($project->id, $this->session->userdata['user_login']);
			if ($state != -1)
				echo $state;
			?>
		</DIV>
		<DIV class="project-desc-name">
			<A class="project-name" href="<?PHP echo base_url(); ?>module/project/<?PHP echo $project->id; ?>"> <?PHP echo $project->name; ?></A>
			<DIV class="project-desc">
				<?PHP echo $project->desc; ?>
			</DIV>
		</DIV>
		<DIV class="project-info">
			<SPAN class="project-registered">
			<?PHP
			echo $this->projects_m->get_registered($project->id)->nb.' inscrits';
			?>
			</SPAN>
			<SPAN class="project-duration">
			<?PHP
			echo 'Durée: '.$this->projects_m->get_totaltime($project->id);
			?>
			</SPAN>
			<SPAN class="project-percent">
			<?PHP
			/*
			**	Calcule progression (%)
			*/
			$rest = strtotime($project->dt_end) - time();
			$state = round($rest / ((strtotime($project->dt_end) - strtotime($project->dt_start)) / 100), 1);
			echo $state;
			?>
			</SPAN>
		</DIV>
	</DIV>
<?PHP endforeach; ?>
</DIV>
<DIV id="archives">

</DIV>