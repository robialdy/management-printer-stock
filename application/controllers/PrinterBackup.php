<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PrinterBackup extends CI_Controller
{
	//dibawah ini hmm
	public $PrinterBackup_Model;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('PrinterBackup_Model');
	}

	public function index()
	{
		$data = [
			'title' 		=> 'PRINTER BACKUP',
			'printerList'	=> $this->PrinterBackup_Model->readData(),
			'totalPrinter'	=> $this->PrinterBackup_Model->jumlahData(),
		];

		$this->load->view('printerBackup/printer_backup', $data);
	}

	public function insert()
	{
		$this->form_validation->set_rules('printersn', 'PRINTER SN', 'required|trim');
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
