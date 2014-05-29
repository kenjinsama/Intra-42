<LINK rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/project_style.css' ?>" media="all"/>

<?PHP
	foreach ($modules as $module): ?>
		<DIV class="module">
			<a href="<?PHP echo base_url(); ?>module/projects/<?PHP echo $module->name; ?>">
			<?PHP echo $module->name; ?>
			</a>
		</DIV>
	<?PHP endforeach;
?>