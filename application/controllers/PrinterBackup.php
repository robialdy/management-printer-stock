<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PrinterBackup extends CI_Controller
{
	//dibawah ini hmm
	public $PrinterBackup_Model, $data_user, $PrinterDamage_Model, $Type_printer_Model;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->load->model('PrinterBackup_Model');
		$this->load->model('PrinterDamage_Model');
		$this->load->model('Type_printer_Model');
		$this->data_user = $this->db->get_where('users', ['username' => $this->session->userdata('data_user')])->row_array();
	}

	public function index()
	{
		$data = [
			'title' 		=> 'Printer Backup',
			'printerList'	=> $this->PrinterBackup_Model->readData(),
			'totalPrinter'	=> $this->PrinterBackup_Model->jumlahData(),
			'data_user'		=> $this->data_user,
			'dateTime'		=> $this->PrinterBackup_Model->dateTime(),
			'sndamage'		=> $this->PrinterDamage_Model->readDataSn(),
			'type_printer'	=> $this->Type_printer_Model->read_data(),
		];

		$this->load->view('printerBackup/printer_backup', $data);
	}

	public function insert()
	{
		$prin_sn = strtoupper($this->input->post('printersn', true));

		$this->form_validation->set_rules('printersn', 'PRINTER SN', 'required|is_unique[printer_backup.printer_sn]|trim');
		$this->form_validation->set_rules('typeprinter', 'PRINTER SN', 'required|trim');
		$this->form_validation->set_rules('return_cgk', 'Return Cgk', 'required|trim');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('notifError', "Printer SN $prin_sn Telah Digunakan!");
			redirect('printer');
		}else {
			$this->PrinterBackup_Model->insertData();
			
			$this->session->set_flashdata('notifSuccess', "Printer SN $prin_sn Berhasil Ditambahkan!");
			redirect('printer');
		}
	}
}
