<LINK rel="stylesheet" href="<?php echo base_url();?>assets/css/ratings.css" type="text/css" media="screen"/>
<?PHP

echo "vous corriger: ".$this->check_log->obtain_name($corrected_user);

function parse_rating_scale($rating_scale)
{
	$rating_scale = strtr($rating_scale, array("\n" => "<BR />"));
	preg_match_all('/(titre|pref|mod-titre|desc-pts|nb-pts)=(.*?)[;|\n]/', $rating_scale, $match);
	$i = 0;
	$res = array();
	while (isset($match[0][$i]))
	{
		if ($match[1][$i] == 'titre')
			$res['titre'] = $match[2][$i];
		else if ($match[1][$i] == 'pref')
			$res['pref'] = $match[2][$i];
		else if ($match[1][$i] == 'mod-titre')
			$res['mod-titre'][] = $match[2][$i];
		else if ($match[1][$i] == 'desc-pts')
			$res['desc-pts'][] = $match[2][$i];
		else if ($match[1][$i] == 'nb-pts')
			$res['nb-pts'][] = $match[2][$i];
		$i++;
	}
	return $res;
}

if (isset($rating_scale)) :

$res = parse_rating_scale($rating_scale);
echo "<H2>" . $res['titre'] . "</H2>";
echo "<P>".$res['pref']."</P>";
$i = 0;
?>
<FORM action="../../validate_corr/<?PHP echo $project_id."/".$corrected_user; ?>" method="post">
	<?PHP
	while (isset($res['mod-titre'][$i])) :
		?>
		<DIV class="mod">
			<DIV class="mod-title"><?PHP echo $res['mod-titre'][$i]; ?></DIV>
			<DIV class="desc-pts"><?PHP echo $res['desc-pts'][$i]; ?></DIV>
			<DIV class="div-pts">
				<?PHP
					$tmp = explode('-', $res['nb-pts'][$i]);
					$j = 0;
					foreach ($tmp as $value) :
				?>
					<INPUT class="pts" name="note-<?PHP echo $i; ?>" value="<?PHP echo $value; ?>" type="radio" <?PHP if($j == 0) echo "checked='checked'"; ?>/>
				<?PHP
					$j++;
					echo $value;
					endforeach;
				?>
			</DIV>
			<INPUT type="hidden" name="com-name-<?PHP echo $i; ?>" value="<?PHP echo $res['mod-titre'][$i]; ?>"/>
			<TEXTAREA class="com" name="com-<?PHP echo $i; ?>"></TEXTAREA>
		</DIV>
		<?PHP
		$i++;
		echo "<BR />";
	endwhile;
	?>
	<DIV id="resume">
		<INPUT type="hidden" name="nb-mod" value="<?PHP echo $i; ?>"/>
		<INPUT type="submit" value="Valider"/>
	</DIV>
</FORM>
<?PHP
else :
	echo "Pas de bareme pour ce projet !";
endif;
?>