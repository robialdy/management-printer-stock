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
		if ($this->data_user['role'] === 'ADMIN') {
			redirect();
		};
		$this->load->model('Users_Model');
	}

	public function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
		$this->form_validation->set_rules('password1', 'Password', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'title'	=> 'User Manage',
				'data_user'	=> $this->data_user,
				'read_data_a'	=> $this->Users_Model->readData_a($this->data_user['username']),
				'read_data_m'	=> $this->Users_Model->readData_m($this->data_user['username']),
				'jumUsers'		=> $this->Users_Model->jumlah(),
				'dateTime'		=> $this->Users_Model->dateTime(),
			];
			$this->load->view('users/user_manage', $data);
		} else {
			$this->Users_Model->insert();
			$username = $this->input->post('username', true);
			$this->session->set_flashdata('notifSuccess', "User $username Berhasil Ditambahkan!");
			redirect('users');
		}
	}

	public function user_log()
	{
		$this->load->model('Activity_log_Model');
		$data = [
			'title'	=> 'User Log',
			'data_user'	=> $this->data_user,
		];

		$this->load->view('users/user_log', $data);
	}

	public function view_user_log()
	{
		$start_date = $this->input->post('from_date', true);
		$end_date = $this->input->post('until_date', true);

		// var_dump($start_date . '  /  '. $end_date);
		// die();

		$this->load->model('Activity_log_Model');
		$logs = $this->Activity_log_Model->readData($start_date, $end_date);


		// Mulai membangun HTML tabel
		$output = '';
		$no = 1;
		foreach ($logs as $log) {
			$output .= '<tr>';
			$output .= '<td class="text-center text-uppercase"><h6 class="mb-0 text-md fw-normal">' . $no++ . '</h6></td>';
			$output .= '<td class="text-center text-uppercase"><h6 class="mb-0 text-md fw-normal">' . $log->username . '</h6></td>';
			$output .= '<td class="text-center text-uppercase"><h6 class="mb-0 text-md fw-normal">' . $log->role . '</h6></td>';
			$output .= '<td class="text-center text-uppercase"><h6 class="mb-0 text-md fw-normal">' . $log->ip_address . '</h6></td>';
			$output .= '<td class="text-center text-uppercase"><h6 class="mb-0 text-md fw-normal">' . $log->os . '</h6></td>';
			$output .= '<td class="text-center text-uppercase"><h6 class="mb-0 text-md fw-normal">' . $log->browser . '</h6></td>';
			$output .= '<td class="text-center text-uppercase"><h6 class="mb-0 text-md fw-normal">' . $log->login_at . '</h6></td>';
			$output .= '</tr>';
		}

		header('Content-Type: application/json');
		echo json_encode([
			'html' => $output,
			'token' => $this->security->get_csrf_hash(),
		]);
	}

	public function delete($username)
	{
		$this->Users_Model->delete($username);
		$this->session->set_flashdata('notifSuccess', 'User Berhasil Dihapus!');
		redirect('users');
	}
}
