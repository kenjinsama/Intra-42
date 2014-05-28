<?php $this->load->view('Main/header'); ?>

<div id="categories">
	<?php foreach ($categories as $category): ?>
	<h1><a href="<?php echo current_url() . '/' . strtolower($category->name) ?>"><?php echo $category->name; ?></a></h1>
	<?php endforeach; ?>
</div>

<?php $this->load->view('Main/footer'); ?>