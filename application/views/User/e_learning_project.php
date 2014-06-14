E-Learning<BR />
<?PHP
$i = 0;
while (isset($project[$i])) :
?>
<DIV class="e-learning-title"><?PHP $tmp = substr(strrchr($project[$i]->path, '/'), 1);echo substr($tmp, 0, strlen($tmp) - strlen(strrchr($tmp, '.')));?></DIV>
<video width="400" height="222" controls="controls">
	<source src="<?PHP echo base_url().$project[$i]->path; ?>" type="video/mp4" />
</video>
<?PHP $i++; endwhile; ?>