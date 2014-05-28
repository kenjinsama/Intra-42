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
				echo "<img src='data:image/png;base64,".base64_encode($result[0]["picture"][0]) . "'>";?>
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
		// verifier si set
			echo "Genre :".$result[0]["gender"][0]."<br />";
			echo "Nationalité : ".$result[0]["nationality"][0]."<br />";
			echo "Contact d'urgence :".$result[0]["emergency-first-name"][0]." ".$result[0]["emergency-last-name"][0]."<br />";
			echo "Numéro : ".$result[0]["emergency-home-phone"][0]."<br />";
			echo "Adresse :"."<br />".$result[0]["emergency-postal-address"][0]."<br />".$result[0]["emergency-postal-code"][0]." ".$result[0]["emergency-city"][0]."<br />".$result[0]["emergency-country"][0]."<br />";
			echo "Numéros d'urgence (mère) : ".$result[0]["mother-home-phone"][0]."<br />";
			echo "Adresse de la mère : ".$result[0]["mother-city"][0]."<br />";
			echo "Numéros d'urgence (père) : ".$result[0]["father-home-phone"][0]."<br />";
			echo "Nationalité : ".$result[0]["nationality"][0]."<br />";
			echo "Nationalité : ".$result[0]["nationality"][0]."<br />";
		?>
	</body>
</html>
