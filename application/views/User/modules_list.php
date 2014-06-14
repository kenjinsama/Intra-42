<LINK rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/project_style.css' ?>" media="all"/>

<?PHP
	foreach ($modules as $module): ?>
		<DIV class="module">
			<a href="<?PHP echo base_url(); ?>module/projects/<?PHP echo $module->id; ?>"><?PHP echo $module->name; ?></a>
			<DIV class="module-desc">
				<?PHP echo $module->desc; ?>
			</DIV>
			<?PHP echo img( array( 'src' => base_url() . 'assets/images/arrow.png', 'class' => 'arrow-module') ); ?>
		</DIV>
	<?PHP endforeach;
?>