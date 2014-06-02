<?php

// ------------ HEAD ------------ //
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');
// ------------ **** ------------ //

class Ticket extends		CI_Model
{
	public function create_ticket(array $ticket)
	{
		$this->db->insert('tickets', $ticket);
	}

	public function get_all_tickets()
	{
		$this->db->select('id, titre, state');
		$query = $this->db->get('tickets');
		return ($query->result_array());
	}

	public function get_ticket($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('tickets')->result_array();
		return ($query[0]);
	}
}

 ?>
