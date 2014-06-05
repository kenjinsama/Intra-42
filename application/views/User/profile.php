<DIV id="profile-page">
	<div id="content">
		<h1>Profile</h1>

		<?php
			if (isset($user["picture"][0]))
				echo "<img src='data:image/png;base64,".base64_encode($user["picture"][0]) . "'><br/>";
			else
				echo img(base_url() . 'assets/images/default-profile.png' . '<br/>');
			if ($user["uid"][0] == $this->session->userdata['user_login'])
			{
				echo anchor(base_url() . "user/generate", "Generer un lien d'autologin");
				if (isset($generate))
					echo "<div>" . $generate . "</div>";
			}
		?>
			<p>Bienvenue<b>
			<?php echo $user["first-name"][0]." ".$user["last-name"][0]; ?></b></p>
			<p><b><u>Vos Informations</u></b><p>
			<?php
				echo "uid : ".$user["uid"][0]."<br />";
				if (isset($user["mobile-phone"][0]))
					echo "Numero de téléphone : ".$user["mobile-phone"][0]."<br />";
			?>
	</div>
	<div>
	<p><b>Vos Modules</p></b>
	<?php
		if ($user["uid"][0] == $this->session->userdata['user_login'])
		{

		}
	?>
	</div>
	<div>
	<p><b>Informations Administratives</b></p>
	<?php
		if ($user["uid"][0] == $this->session->userdata['user_login'])
		{
			if (isset($user["gender"][0]))
				echo "Genre : ".$user["gender"][0]."<br />";
			if (isset($user["nationality"][0]))
				echo "Nationalité : ".$user["nationality"][0]."<br />";
			if (isset($user["scholarity"][0]))
				echo "Niveau scolaire : ".$user["scholarity"][0]."<br />";
			if (isset($user["emergency-first-name"][0]))
				echo "<br /><b>Contact d'urgence</b><br /><br />".$user["emergency-first-name"][0]." ".$user["emergency-last-name"][0]."<br />";
			if (isset($user["emergency-home-phone"][0]))
				echo "Numéro : ".$user["emergency-home-phone"][0]."<br />";
			if (isset($user["emergency-postal-address"][0]))
				echo "Adresse : "."<br />".$user["emergency-postal-address"][0]."<br />".$user["emergency-postal-code"][0]." ".$user["emergency-city"][0]."<br />".$user["emergency-country"][0]."<br />";
			echo "<br />";
			if (isset($user["mother-last-name"][0]) && isset($user["father-last-name"][0]))
				echo "<b>Parents</b><br /><br />";
			elseif (isset($user["mother-last-name"][0]) || isset($user["father-last-name"][0]))
				echo "<b>Parent</b><br /><br />";
			if (isset($user["mother-first-name"][0]))
				echo "Mère : ".$user["mother-first-name"][0]." ".$user["mother-last-name"][0]."<br />";
			if (isset($user["mother-home-phone"][0]))
				echo "Numéro : ".$user["mother-home-phone"][0]."<br />";
			if (isset($user["mother-postal-address"][0]))
				echo "Adresse : "."<br />".$user["mother-postal-address"][0]."<br />".$user["mother-postal-code"][0]." ".$user["mother-city"][0]."<br />".$user["mother-country"][0]."<br />";
			echo "<br />";
			if (isset($user["father-first-name"][0]))
				echo "Père : ".$user["father-first-name"][0]." ".$user["father-last-name"][0]."<br />";
			if (isset($user["father-home-phone"][0]))
				echo "Numéro : ".$user["father-home-phone"][0]."<br />";
			if (isset($user["father-postal-address"][0]))
				echo "Adresse : "."<br />".$user["father-postal-address"][0]."<br />".$user["father-postal-code"][0]." ".$user["father-city"][0]."<br />".$user["father-country"][0]."<br />";
		}
	?>
	</div>
</div>
