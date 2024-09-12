<?php
defined('BASEPATH') or exit('No direct script access allowed');

class P extends CI_Controller
{
	public $data_user, $Auth_Model;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->data_user = $this->db->get_where('users', ['username' => $this->session->userdata('data_user')])->row_array();
	}

	public function index()
	{
		$form_type = $this->input->post('form_type', true);

		if($form_type == 'change_username') {

		$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'title' 		=> 'Profile',
				'data_user'		=> $this->data_user,
			];
			$this->load->view('profile/profile', $data);
		} else {
			//terupdate tapi harus relog login nya
			$form_data = [
				'id_user'	=> $this->input->post('id', true),
				'username'	=> $this->input->post('username', true),
			];
			$this->db->where('id_user', $this->input->post('id', true));
			$this->db->update('users', $form_data);
			redirect('auth/logout');
		}
	} else {
			$this->form_validation->set_rules('current_pass', 'Current Password', 'required|trim');
			$this->form_validation->set_rules('new_pass1', 'New password', 'required|trim|min_length[5]|matches[new_pass2]');
			$this->form_validation->set_rules('new_pass2', 'Confirm New password', 'required|trim');

			if ($this->form_validation->run() == FALSE) {
				$data = [
					'title' 		=> 'Profile',
					'data_user'		=> $this->data_user,
				];
				$this->load->view('profile/profile', $data);
			} else {
				$current_pass = $this->input->post('current_pass', true);
				$new_password = $this->input->post('new_pass1', true);
				if (!password_verify($current_pass, $this->data_user['password'])) {
					$this->session->set_flashdata('current_error', '<small class="text-danger ms-2">Password lama salah!</small>');
					redirect('p');
				} else {
					if ($current_pass === $new_password){
						$this->session->set_flashdata('pass_error', '<small class="text-danger" ms-2>Password sama dengan yang lama!</small>');
						redirect('p');
					} else {
						$password_hash = password_hash($new_password, PASSWORD_DEFAULT);

						$this->db->set('password', $password_hash);
						$this->db->where('username', $this->data_user['username']);
						$this->db->Update('users');
						$this->session->set_flashdata('notifSuccess', 'baru berhasil diupdate!');
						redirect('p');
					}
				}
			}
	}

	}
}
