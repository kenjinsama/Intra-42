<DIV class="yearbook">
<?PHP foreach ($users as $user): ?>

	<SPAN class="yearbook-user">
		<?PHP
		if ($user['uid'][0])
			echo anchor(base_url().'user/profile/'.$user['uid'][0], $user['uid'][0], array('class' => 'button')) . '<BR />';
		?>
	</SPAN>

<?PHP endforeach ?>
</DIV>