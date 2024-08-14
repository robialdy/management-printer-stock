<?php

class Agen_Model extends CI_Model
{
	public function readData()
	{
		return $this->db->get('agen')->result_array();
	}

	public function insertData()
	{
		$form_data = [
			'cust_id'	=> $this->input->post('custid'),
			'agen_name'	=> $this->input->post('name'),
			'type_cust'	=> $this->input->post('typecust'),
			'created_at'=> date('d M Y / H:i:s'),
		];
		$this->db->insert('agen', $form_data);
	}

	public function jumlahData()
	{
		return $this->db->count_all_results('agen');
	}

	public function dateTime()
	{
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('agen');
		return $query->row();
	}
}
