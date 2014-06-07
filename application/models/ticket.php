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

	public	function create_comment(array $comment)
	{
		$this->db->insert('comment_tickets', $comment);
	}

	public function get_all_tickets($order_by='id')
	{
		$this->db->select('id, title, state, priority, type');
		$this->db->order_by($order_by.' asc, id desc');
		$query = $this->db->get('tickets');
		if ($query->num_rows == 0)
			return (NULL);
		return ($query->result_array());
	}

	public function get_ticket($id)
	{
		$this->db->select('*');
		$this->db->from('tickets');
		$this->db->join('comment_tickets', 'tickets.id = comment_tickets.id_ticket');
		$this->db->where('tickets.id', $id);
		$query = $this->db->get();
		if ($query->num_rows == 0)
			return (NULL);
		return ($query->result_array());
	}

	public function get_my_tickets()
	{
		$this->db->select('*');
		$this->db->from('tickets');
		$this->db->where('id_user', $this->session->userdata("user_id"));
		$query = $this->db->get();
		if ($query->num_rows == 0)
			return (NULL);
		return ($query->result_array());
	}

	public function get_assign_ticket()
	{
		$this->db->select('*');
		$this->db->from('tickets');
		$this->db->where('id_admin', $this->session->userdata("user_id"));
		$query = $this->db->get();
		if ($query->num_rows == 0)
			return (NULL);
		return ($query->result_array());
	}

	public function get_non_assign_ticket()
	{
		$this->db->select('*');
		$this->db->from('tickets');
		$this->db->where('id_admin', 0);
		$query = $this->db->get();
		if ($query->num_rows == 0)
			return (NULL);
		return ($query->result_array());
	}

	public function enum_select($table, $field)
	{
		$row = $this->db->query('SHOW COLUMNS FROM '.$table.' LIKE "'.$field.'"')->row()->Type;
		$regex = "/'(.*?)'/";
		preg_match_all( $regex , $row, $enum_array );
		$enum_fields = $enum_array[1];
		foreach ($enum_fields as $key=>$value)
		{
			$enums[$value] = $value;
		}
		return $enums;
	}
}

 ?>
