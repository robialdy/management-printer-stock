<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PrinterBackup extends CI_Controller
{
	//dibawah ini hmm
	public $PrinterBackup_Model, $data_user;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->load->model('PrinterBackup_Model');
		$this->data_user = $this->db->get_where('auth', ['username' => $this->session->userdata('data_user')])->row_array();
	}

	public function index()
	{
		$data = [
			'title' 		=> 'Printer Backup',
			'printerList'	=> $this->PrinterBackup_Model->readData(),
			'totalPrinter'	=> $this->PrinterBackup_Model->jumlahData(),
			'data_user'		=> $this->data_user,
			'dateTime'		=> $this->PrinterBackup_Model->dateTime()
		];

		$this->load->view('printerBackup/printer_backup', $data);
	}

	public function insert()
	{
		$this->form_validation->set_rules('printersn', 'PRINTER SN', 'required|is_unique[printer_backup.printer_sn]|trim');
		$this->form_validation->set_rules('printertype', 'PRINTER SN', 'required|trim');
		if ($this->form_validation->run() == FALSE) {
			redirect('printer');
		}else {
			$this->PrinterBackup_Model->insertData();
			$this->session->set_flashdata('notifSuccess', 'baru berhasil ditambahkan!');
			redirect('printer');
		}
	}
}
