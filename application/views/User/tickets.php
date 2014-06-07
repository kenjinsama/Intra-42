<?php echo anchor(base_url() . "user/create_tickets", "New ticket", ["class" => "new_ticket_button"]);
if (isset($tickets))
{?>
<table>
	<thead>
		<tr>
			<th>#</th>
			<th>Priority</th>
			<th>Title</th>
			<th>Queue</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($tickets as $ticket): ?>
			<tr>
				<td><?php echo anchor(base_url() . (($isadmin) ? 'user/response-tickets/' : 'user/tickets/'). $ticket['id'], '['.$ticket['type'].'-'.$ticket['id'].']'); ?></td>
				<td><?php echo $ticket['priority']; ?></td>
				<td><?php echo anchor(base_url() . (($isadmin) ? 'user/response-tickets/' : 'user/tickets/'). $ticket['id'], $ticket['title']); ?></a></td>
				<td><?php echo $ticket['type']; ?></td>
				<td><?php echo $ticket['state'] ?></td>
			</tr>
		<?php
			endforeach;
}
		?>
	</tbody>
</table>
