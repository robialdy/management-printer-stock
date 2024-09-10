<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TypePrinter extends CI_Controller
{
	public $Type_printer_Model, $data_user;
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
		$this->load->model('Type_printer_Model');
	}

	public function index()
	{
		$this->form_validation->set_rules('name_type', 'Name Type', 'required|trim');
		if ($this->form_validation->run() == FALSE) {

		$data = [
			'title'		=> 'Type Printer',
			'data_user'	=> $this->data_user,
			'type_prin'	=> $this->Type_printer_Model->read_data(),
			'jumlah_data'	=> $this->Type_printer_Model->jumlah_data(),
			'date_time'	=> $this->Type_printer_Model->dateTime(),
		];
		$this->load->view('type_printer/type_printer', $data);
	} else {
			$this->Type_printer_Model->insert_data();
			$name_type = strtoupper($this->input->post('name_type'));
			$this->session->set_flashdata('notifSuccess', "Create Type Printer $name_type ");
			redirect('type');
	}
	}

	public function delete($id)
	{
		$this->Type_printer_Model->delete($id);
		$this->session->set_flashdata('notifSuccess', 'Delete Type Printer Successfuly!');
		redirect('type');
	}
}
