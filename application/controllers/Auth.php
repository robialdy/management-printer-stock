<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_Model');
	}

	public function index()
	{
		if ($this->session->userdata('data_user')) {
			redirect($_SERVER['HTTP_REFERER']); // ke halaman sebelumnya
		};

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
		$username = $this->input->post('username', true);
		$password = $this->input->post('password', true);
		$user = $this->db->get_where('users', ['username' => $username])->row_array();

		if ($user != null && password_verify($password, $user['password'])) {
			$data = [
				'id_user'	=> $user['id_user'],
				'data_user'	=> $user["username"],
			];
			// seting activity login
			$this->load->library('user_agent');
			$this->load->model('Activity_log_Model');
			$this->Activity_log_Model->sendUserLog($user['id_user'], $this->input->ip_address(), $this->agent->platform(), $this->agent->browser());

			$this->session->set_userdata($data);
			redirect(base_url());
		} else {
			$this->session->set_flashdata('message', '<small class="text-danger mx-auto">Username Atau Password Salah</small>');
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
