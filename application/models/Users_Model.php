<?php

class Users_Model extends CI_Model
{
	public function readData_a()
	{
		return $this->db->order_by('created_at', 'DESC')->get_where('users', ['role' => 'Admin'])->result_array();
	}

	public function readData_m()
	{
		return $this->db->order_by('created_at', 'DESC')->get_where('users', ['role' => 'SUPER ADMIN'])->result_array();
	}

	public function insert()
	{
		$form_data = [
			'username'	=> $this->input->post('username', true),
			'password'	=> password_hash($this->input->post('password1', true), PASSWORD_DEFAULT),
			'role'		=> $this->input->post('role', true),
			'created_at'=> date('d-m-Y H:i:s'),
		];
		$this->db->insert('users', $form_data);
	}

	public function jumlah()
	{
		return $this->db->count_all_results('users');
	}

	public function dateTime()
	{
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('users');
		return $query->row();
	}

	public function delete($username)
	{
		$this->db->where('username', $username);
		$this->db->delete('users');
	}

}
