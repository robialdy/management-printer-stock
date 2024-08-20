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
		$this->data_user = $this->db->get_where('users', ['username' => $this->session->userdata('data_user')])->row_array();
		if ($this->data_user['role'] === 'Admin') {
			redirect();
		};
		$this->load->model('Users_Model');
	}

	public function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|matches[password2]');
		$this->form_validation->set_rules('password2', 'Re Password', 'required|trim|matches[password1]');

		if ($this->form_validation->run() == FALSE) {			
			$data = [
				'title'	=> 'User Manage',
				'data_user'	=> $this->data_user,
				'read_data_a'	=> $this->Users_Model->readData_a(),
				'read_data_m'	=> $this->Users_Model->readData_m(),
				'jumUsers'		=> $this->Users_Model->jumlah(),
				'dateTime'		=> $this->Users_Model->dateTime(),
			];
			$this->load->view('moderator/user_manage', $data);
		} else {
			$this->Users_Model->insert();
			redirect('users');
		}
	}

	public function delete($username)
	{
		$this->Users_Model->delete($username);
		$this->session->set_flashdata('notifSuccess', 'Delete Account Successfuly!');
		redirect('users');
	}
}
