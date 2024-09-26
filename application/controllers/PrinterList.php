<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PrinterList extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->load->model('PrinterList_Model');
		$this->data_user = $this->db->get_where('users', ['username' => $this->session->userdata('data_user')])->row_array();
	}

	public function detail()
	{
		$data = [
			'title'			=> 'Dashboard',
			'data_user'		=> $this->data_user,
			'printer_detail'=> $this->PrinterList_Model->read_data(),
		];

		$this->load->view('printer_list/printer_detail', $data);
	}

	public function summary()
	{
		$data = [
			'title'			=> 'Dashboard',
			'data_user'		=> $this->data_user,
			'printer_summary' => $this->PrinterList_Model->read_data_summary(),
			'type_printer'	=> $this->PrinterList_Model->type_printer(),
		];

		$this->load->view('printer_list/printer_summary', $data);
	}
}
