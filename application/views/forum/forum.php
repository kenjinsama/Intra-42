<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/forum_style.css' ?>" media="all"/>
<div id="categories">
	<?php foreach ($categories as $category): ?>
	<a href="<?php echo current_url() . '/' . strtolower($category->name) ?>"><?php echo $category->name; ?></a>
	<?php endforeach; ?>
</div>
