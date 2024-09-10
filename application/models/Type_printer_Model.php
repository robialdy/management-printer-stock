<?php

class Type_printer_Model extends CI_Model
{
	public function read_data()
	{
		return $this->db->order_by('created_at', 'DESC')->get('type_printer')->result();
	}


	public function insert_data()
	{
		$form_data = [
			'name_type'		=> strtoupper($this->input->post('name_type')),
			'created_at'	=> date('d F Y H:i:s'),
		];	
		$this->db->insert('type_printer', $form_data);
	}

	public function delete($id)
	{
		$this->db->where('id_type', $id);
		$this->db->delete('type_printer');
	}

	public function jumlah_data()
	{
		return $this->db->count_all_results('type_printer');
	}

	public function dateTime()
	{
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('type_printer');
		return $query->row();
	}
}
