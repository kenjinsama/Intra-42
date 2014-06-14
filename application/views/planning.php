<div class="content_page">
	<?php

	if (isset($planning[0]))
	{
		echo heading("Planning", 2);

		$start = strtotime($planning[0]["dt_start"]);
		foreach ($planning as $data)
		{
			$width = round((strtotime($data["dt_end"]) - strtotime($data["dt_start"])) / 3600) > 450 ? 450 : round((strtotime($data["dt_end"]) - strtotime($data["dt_start"])) / 3600);
			$margin = (strtotime($data['dt_start']) - $start) / 3600 > 350 ? 350 : (strtotime($data['dt_start']) - $start) / 3600;
	?>
			<div class="block_planning" style="width: <?php echo $width . 'px'; ?>; margin-left: <?php echo $margin . 'px';?>">
				<?php echo "<span class='name_p_planning'>" . $data["name"] . "</span>"
				. "<span class='info_planning'>Start: " . date("F j", strtotime($data['dt_start']))
				. "</span><span class='info_planning'> Duration: " . round((strtotime($data["dt_end"]) - strtotime($data["dt_start"])) / 86400) . "j</span>"; ?>
			</div>
	<?php
		}
	}
	?>
</div>