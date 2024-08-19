<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
	public $data_user;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->load->model('Auth_Model');
		$this->data_user = $this->db->get_where('auth', ['username' => $this->session->userdata('data_user')])->row_array();
	}

	public function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|matches[password2]');
		$this->form_validation->set_rules('password2', 'Re Password', 'required|trim|matches[password1]');

		if ($this->form_validation->run() == FALSE) {			
			$data = [
				'title'	=> 'User Manage',
				'data_user'	=> $this->data_user,
			];
			$this->load->view('moderator/user_manage', $data);
		} else {
			$this->Auth_Model->insert();
			redirect('users');
		}

	}
}
