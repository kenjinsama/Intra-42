<?php

	echo anchor(base_url() . "user/create_tickets", "New ticket", ["class" => "new_ticket_button"]);
?>
<table>
	<thead>
		<tr>
			<th>Title</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($tickets as $ticket): ?>
			<tr>
				<td><?php echo anchor(base_url() . "user/tickets/". $ticket['id'], $ticket['titre']); ?></a></td>
				<td><?php echo $ticket['state'] ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
