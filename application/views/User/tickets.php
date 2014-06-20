<div class="content_page">
	<?php echo anchor(base_url() . "user/create_tickets", "New ticket", ["class" => "new_ticket_button"]);
	if (isset($tickets))
	{
		echo heading("Mes tickets", 4);
		?>

	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>Priority</th>
				<th>Title</th>
				<th>Queue</th>
				<th>Status</th>
				<th>Author</th>
				<th>Assigned</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($tickets as $ticket): ?>
				<tr>
					<td><?php echo anchor(base_url() . 'user/response-tickets/' . $ticket['id'], '['.$ticket['type'].'-'.$ticket['id'].']'); ?></td>
					<td><?php echo $ticket['priority']; ?></td>
					<td><?php echo anchor(base_url() . 'user/response-tickets/' . $ticket['id'], $ticket['title']); ?></a></td>
					<td><?php echo $ticket['type']; ?></td>
					<td><?php echo $ticket['state'] ?></td>
					<td><?php echo  $this->check_log->obtain_name($ticket['id_user']) ?></td>
					<td><?php echo ($ticket['id_admin'] == 0 ? "Mr Nobody" : $this->check_log->obtain_name($ticket['id_admin'])) ?></td>
				</tr>
			<?php
				endforeach;
	}
			?>
		</tbody>
	</table>

	<?php
	if (isset($assign))
	{
		echo heading("Les tickets qui me sont assigné", 4);
		?>

	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>Priority</th>
				<th>Title</th>
				<th>Queue</th>
				<th>Status</th>
				<th>Author</th>
				<th>Assigned</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($assign as $ticket): ?>
				<tr>
					<td><?php echo anchor(base_url() . 'user/response-tickets/'. $ticket['id'], '['.$ticket['type'].'-'.$ticket['id'].']'); ?></td>
					<td><?php echo $ticket['priority']; ?></td>
					<td><?php echo anchor(base_url() . 'user/response-tickets/'. $ticket['id'], $ticket['title']); ?></a></td>
					<td><?php echo $ticket['type']; ?></td>
					<td><?php echo $ticket['state'] ?></td>
					<td><?php echo  $this->check_log->obtain_name($ticket['id_user']) ?></td>
					<td><?php echo ($ticket['id_admin'] == 0 ? "Mr Nobody" : $this->check_log->obtain_name($ticket['id_admin'])) ?></td>
				</tr>
			<?php
				endforeach;
	}
			?>
		</tbody>
	</table>


	<?php
	if (isset($no_assign))
	{
		echo heading("Les tickets du pool", 4);
		?>

	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>Priority</th>
				<th>Title</th>
				<th>Queue</th>
				<th>Status</th>
				<th>Author</th>
				<th>Assigned</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($no_assign as $ticket): ?>
				<tr>
					<td><?php echo anchor(base_url() . 'user/response-tickets/' . $ticket['id'], '['.$ticket['type'].'-'.$ticket['id'].']'); ?></td>
					<td><?php echo $ticket['priority']; ?></td>
					<td><?php echo anchor(base_url() . 'user/response-tickets/' . $ticket['id'], $ticket['title']); ?></a></td>
					<td><?php echo $ticket['type']; ?></td>
					<td><?php echo $ticket['state'] ?></td>
					<td><?php echo  $this->check_log->obtain_name($ticket['id_user']) ?></td>
					<td><?php echo ($ticket['id_admin'] == 0 ? "Mr Nobody" : $this->check_log->obtain_name($ticket['id_admin'])) ?></td>
				</tr>
			<?php
				endforeach;
	}
			?>
		</tbody>
	</table>
</div>