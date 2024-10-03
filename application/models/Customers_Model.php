<?php

class Customers_Model extends CI_Model
{
	public function readData()
	{
		return $this->db->order_by('created_at', 'DESC')->get('customers')->result();
	}

	public function read_data_active()
	{
		return $this->db->where('status', 'ACTIVE')->order_by('created_at', 'DESC')->get('customers')->result();
	}

	public function insertData()
	{
		$cust_name = strtoupper($this->input->post('name', true));
		$form_data = [
			'cust_id'	=> $this->input->post('custid', true),
			'cust_name'	=> $cust_name,
			'type_cust'	=> $this->input->post('typecust', true),
			'origin_id'	=> $this->input->post('originid', true),
			'origin_name'	=> $this->input->post('originname', true),
			'status'	=> 'ACTIVE',
			'created_at'=> date('d F Y H:i:s'),
		];
		$this->db->insert('customers', $form_data);
	}

	public function jumlahData()
	{
		return $this->db->count_all_results('customers');
	}

	public function dateTime()
	{
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('customers');
		return $query->row();
	}

	public function delete($id)
	{
		$this->db->where('id_cust', $id);
		$this->db->delete('customers');
	}
}
