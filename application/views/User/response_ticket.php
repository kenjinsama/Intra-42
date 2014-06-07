<?php

// var_dump($tickets);
echo heading($tickets[0]["title"] . " - " . $tickets[0]["state"], 3);
echo heading($tickets[0]["type"], 5);
echo br();
?>

<p id="content_tickets"><?php echo $tickets[0]["content"] ?></p>
<div id="comments">

<?php
if (isset($comment))
{
	foreach ($comment as $data)
	{
?>
		<div class="box_comment">
			<span class="info_comment"> <?php echo $this->check_log->obtain_name($this->session->userdata("user_id")) . " -- " . $data["date"]?></span>
			<div class="content_comment">
				<?php echo $data["content"]; ?>
			</div>
		</div>
<?php
	}
}
?>

</div>

<?php

echo form_open("user/add_comment");

echo	"<div class='form_separator'>";
echo	form_textarea(array("name" => "content", "placeholder" => "comment ..."));
echo	form_input(array("type" => "hidden", "name" => "id", "value" => $id));
echo	"</div>";

echo	form_submit(array("class" => "btn btn-lg btn-success", "value" => "Confirm", "type" => "submit"));

echo form_close();

?>
