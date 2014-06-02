<h1><?php echo $ticket['id'], '. ', $ticket['titre'], ' [', $ticket['state'], ']'; ?></h1>
Description <br />
<hr />
<p>
<?php echo $ticket['content']; ?>
</p>
Follow-Ups
<hr />
<img width="100" height="120" style="-webkit-border-radius: 6px;-moz-border-radius: 6px;border-radius: 6px;" src="data:image/jpeg;base64,<?php  echo $img_profile ?>" alt="profile">
