<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/forum_style.css' ?>" media="all"/>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/forum.js' ?>"></script>

<div id="tree">
	<?php foreach ($urls as $category => $url): ?>
	<a href="<?php echo $url; ?>"> <?php echo $category; ?> </a> <span>></span>
	<?php endforeach; ?>
	<div id="d_toggle">categories</div>
</div>

<div id="categories">
	<?php foreach ($categories as $category): ?>
	<a href="<?php echo current_url() . '/' . strtolower($category->name) ?>"><?php echo $category->name; ?></a>
	<?php endforeach; ?>
</div>
