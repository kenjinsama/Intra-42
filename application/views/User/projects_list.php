<LINK rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/project_style.css' ?>" media="all"/>

<H1>Projects list</H1>
<?PHP
foreach ($projects as $project): ?>
	<DIV class="project">
		<A href="<?PHP echo base_url(); ?>module/project/<?PHP echo $project->name; ?>">
			<?PHP echo $project->name; ?>
		</A>
	</DIV>
<?PHP endforeach;
?>