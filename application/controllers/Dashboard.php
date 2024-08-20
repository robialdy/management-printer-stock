<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public $PrinterBackup_Model, $PrinterReplacement_Model, $data_user;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->load->model('PrinterBackup_Model');
		$this->load->model('PrinterReplacement_Model');
		$this->data_user = $this->db->get_where('users', ['username' => $this->session->userdata('data_user')])->row_array();
	}

	public function index()
	{
		$data = [
			'title'			=> 'Dashboard',
			'jumPrinter' 	=> $this->PrinterBackup_Model->jumlah(),
			'jumBackup'		=> $this->PrinterBackup_Model->jumlahData(),
			'jumDamage'		=> '',
			'jumPembelian'	=> $this->PrinterReplacement_Model->jumlahData(),
			'data_user'		=> $this->data_user,

		];

		$this->load->view('dashboard/dashboard', $data);
	}
}
