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
	<?php $author = $this->Forum_m->get_user($post->id_user); ?>
	<a class="link" href="<?php echo current_url() . '/thread?id=' . strtolower($post->id) ?>"><div class="picture"><img class="resize" src="data:image/jpeg;base64,<?php echo $author->picture; ?>" /></div><?php echo $post->title; ?></a>
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
</div>
<?php endif; ?>


<?php if (isset($posts)): ?>
<h2 id="new_subject">Nouveau Sujet</h2>
<section class="f_form">
		<?php echo form_open(current_url());?>
		<div style="float:left;">
			<label for="title">Titre<span class="requiered">*</span></label><br />
			<input id="text" type="text" name="logins" value="<?php echo set_value('title'); ?>" >
			<?php echo form_error('title', '<span class="error">', '</span>');?><br /><br />

			<label for="message">Message<span class="requiered">*</span></label><br />
			<textarea id="content" name="message"><?php echo set_value('message'); ?></textarea>
			<?php echo form_error('message', '<span class="error">', '</span>');?><br />
		</div>
		<div id="options">
			<div>
				<div class="opt" onclick="tag('[url]', '[/url]', 'content');">[URL]</div>
				<div class="opt" onclick="tag('[b]', '[/b]', 'content');">[BIG]</div>
				<div class="opt" onclick="tag('[img]', '[/img]', 'content');">[IMG]</div>
				<div class="opt" onclick="tag('[i]', '[/i]', 'content');">[ITA]</div>
				<div class="opt" onclick="tag('[em]', '[/em]', 'content');">[EM]</div>
			</div>
			<div style="clear:both;">
				<div class="preview" onclick="">Prévisualiser</div>
				<label for="visibility">Visibilitée</label>
				<select name="visibility">
					<option value="STUDENT" selected="selected">Étudiants</option>
					<option value="MOD">Modérateurs</option>
					<option value="ADMIN">Admins</option>
				</select>
				<?php echo form_error('visibility', '<span class="error">', '</span>');?><br /><br />
				<input id="button" type="submit" class="submit" value="Envoyer" />
			</div>
		</div>
			<div style="clear:both;">
		</div>
		<?php echo form_close();?>
</section>
<?php endif; ?>