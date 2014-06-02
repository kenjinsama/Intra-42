<!DOCTYPE html>
<?php
	$titre='Profil';
	$user_login=$this->session->userdata('user_login');
?>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" />
		<title><?php echo $titre; ?></title>
	</head>
	<body>
		<div id="content">
			<h1><?php echo $titre;?></h1>

			<?php
				$result = $this->ldap->get_user_info($user_login);
				echo "<img src='data:image/png;base64,".base64_encode($result[0]["picture"][0]) . "'>";
				echo anchor(base_url() . "user/profile/generate", "Generer un lien d'autologin");
				if (isset($generate))
					echo "<div>" . $generate . "</div>";
			?>
				<p>Bienvenue<b>
				<?php echo $result[0]["first-name"][0]." ".$result[0]["last-name"][0]; ?></b></p>
				<p><b><u>Vos Informations</u></b><p>
				<?php
					echo "uid : ".$result[0]["uidnumber"][0]."<br />";
					echo "Numero de téléphone : ".$result[0]["mobile-phone"][0]."<br />";
				?>
		</div>
		<div>
		<p><b>Informations Administratives</b></p>
		<?php
			if (isset($result[0]["gender"][0]))
				echo "Genre : ".$result[0]["gender"][0]."<br />";
			if (isset($result[0]["nationality"][0]))
				echo "Nationalité : ".$result[0]["nationality"][0]."<br />";
			if (isset($result[0]["scholarity"][0]))
				echo "Niveau scolaire : ".$result[0]["scholarity"][0]."<br />";
			if (isset($result[0]["emergency-first-name"][0]))
				echo "<br /><b>Contact d'urgence</b><br /><br />".$result[0]["emergency-first-name"][0]." ".$result[0]["emergency-last-name"][0]."<br />";
			if (isset($result[0]["emergency-home-phone"][0]))
				echo "Numéro : ".$result[0]["emergency-home-phone"][0]."<br />";
			if (isset($result[0]["emergency-postal-address"][0]))
				echo "Adresse : "."<br />".$result[0]["emergency-postal-address"][0]."<br />".$result[0]["emergency-postal-code"][0]." ".$result[0]["emergency-city"][0]."<br />".$result[0]["emergency-country"][0]."<br />";
			echo "<br />";
			if (isset($result[0]["mother-last-name"][0]) && isset($result[0]["father-last-name"][0]))
				echo "<b>Parents</b><br /><br />";
			elseif (isset($result[0]["mother-last-name"][0]) || isset($result[0]["father-last-name"][0]))
				echo "<b>Parent</b><br /><br />";
			if (isset($result[0]["mother-first-name"][0]))
				echo "Mère : ".$result[0]["mother-first-name"][0]." ".$result[0]["mother-last-name"][0]."<br />";
			if (isset($result[0]["mother-home-phone"][0]))
				echo "Numéro : ".$result[0]["mother-home-phone"][0]."<br />";
			if (isset($result[0]["mother-postal-address"][0]))
				echo "Adresse : "."<br />".$result[0]["mother-postal-address"][0]."<br />".$result[0]["mother-postal-code"][0]." ".$result[0]["mother-city"][0]."<br />".$result[0]["mother-country"][0]."<br />";
			echo "<br />";
			if (isset($result[0]["father-first-name"][0]))
				echo "Père : ".$result[0]["father-first-name"][0]." ".$result[0]["father-last-name"][0]."<br />";
			if (isset($result[0]["father-home-phone"][0]))
				echo "Numéro : ".$result[0]["father-home-phone"][0]."<br />";
			if (isset($result[0]["father-postal-address"][0]))
				echo "Adresse : "."<br />".$result[0]["father-postal-address"][0]."<br />".$result[0]["father-postal-code"][0]." ".$result[0]["father-city"][0]."<br />".$result[0]["father-country"][0]."<br />";
		?>
	</body>
	</div>
</html>
