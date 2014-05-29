<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/forum_style.css' ?>" media="all"/>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/forum.js' ?>"></script>

<div id="tree">
	<?php foreach ($urls as $category => $url): ?>
	<a href="<?php echo $url; ?>"> <?php echo $category; ?> </a> <span>></span>
	<?php endforeach; ?>
	<div id="d_toggle">categories</div>
</div>

<?php if (isset($categories)): ?>
<div id="categories">
	<?php foreach ($categories as $category): ?>
	<a href="<?php echo current_url() . '/' . strtolower($category->name) ?>"><?php echo $category->name; ?></a>
	<?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (isset($posts)): ?>
<div id="posts">
	<?php foreach ($posts as $post): ?>
	<a href="<?php echo current_url() . '/thread?id=' . strtolower($post->id) ?>"><?php echo $post->title; ?></a>
	<?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (isset($thread) && !is_int($thread)): ?>
<div id="thread">
	<?php $author = $this->Forum_m->get_user($thread->id_user); ?>
	<h1><?php echo $thread->title; ?></h1>
	<p><?php echo $thread->content; ?></p>
	<span><?php echo '<a href="'. base_url() . 'profile?login=' . $author->login . '">' . $author->login . '</a> (' . $author->cn . ') '; echo $thread->date; ?></span>

	<?php elseif (!isset($categories)): ?>
	<h1 style='color:#F00;'>404 NOT FOUND :'(</h1>
	<?php endif; ?>
</div>