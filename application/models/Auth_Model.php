<?php

class Auth_Model extends CI_Model
{
	public function insert()
	{
		$form_data = [
			'username'	=> $this->input->post('username', true),
			'password'	=> password_hash($this->input->post('password1', true), PASSWORD_DEFAULT),
			'role'		=> $this->input->post('role', true),
		];
		$this->db->insert('auth', $form_data);
	}

	public function edit()
	{
		$form_data = [
			'username'	=> $this->input->post('username', true),
		];
		$this->db->where('username', $this->input->post('username', true));
		$this->db->update('auth', $form_data);
	}

	public function edi()
	{
		$k = 'kanjut';
		return $k;
	}
}
