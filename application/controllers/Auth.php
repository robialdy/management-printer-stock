<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_Model');
	}

	public function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
		$this->load->view('auth/login');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$user = $this->db->get_where('auth', ['username' => $username])->row_array();

		if($user != null && password_verify($password, $user['password'])) {
			$data['data_user'] = $user["username"];
			$this->session->set_userdata($data);
			redirect(base_url());
		} else {
			$this->session->set_flashdata('message', '<small class="text-danger">Username Atau Password Salah</small>');
			redirect('auth');
		}
	}

	public function regis()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|matches[password2]');
		$this->form_validation->set_rules('password2', 'Re Password', 'required|trim|matches[password1]');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('auth/regis');
		} else {
			$this->Auth_Model->insert();
			redirect('auth');
		}
	}

	public function logout()
	{
		// Hapus sessionn
		$this->session->sess_destroy();
		redirect('auth');
	}

}
