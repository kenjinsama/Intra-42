<?php echo anchor(base_url() . "user/tickets", "Show tickets", ["class" => "tickets"]); ?>
<table>
	<th colspan="2"><h3><?php echo $ticket[0]['id_ticket'], '. ', $ticket[0]['title'], ' [', $ticket[0]['state'], ']'; ?></h3></th>
	<tr>
		<th>Type</th>
		<td><?php echo $ticket[0]['type']; ?></td>
	</tr>
	<tr>
		<th>Submitted on</th>
		<td><?php echo date($ticket[0]['date']); ?></td>
	</tr>
	<tr>
		<th>Assigned to</th>
		<td><?php echo $ticket[0]['id_admin']; ?></td>
	</tr>
	<tr>
		<th>Submitter</th>
		<td><?php echo $ticket[0]['id_user']; ?></td>
	</tr>
	<tr>
		<th>Description</th>
	</tr>
	<tr>
		<td><?php echo $ticket[0]['content']; ?></td>
	</tr>
	<tr>
		<th>Resolution</th>
	</tr>
	<tr>
		<td>dfgdfgdfg</td>
	</tr>
</table>
