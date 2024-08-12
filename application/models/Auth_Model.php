<?php

class Auth_Model extends CI_Model
{
	public function insert()
	{
		$form_data = [
			'username'	=> $this->input->post('username', true),
			'password'	=> password_hash($this->input->post('password1', true), PASSWORD_DEFAULT),
		];
		$this->db->insert('auth', $form_data);
	}
}
