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
		$this->load->model('PrinterList_Model');
		$this->load->model('PrinterDamage_Model');
		$this->data_user = $this->db->get_where('users', ['username' => $this->session->userdata('data_user')])->row_array();
	}

	public function index()
	{
		$data = [
			'title'			=> 'Dashboard',
			'jumPrinter' 	=> $this->PrinterBackup_Model->jumlah(),
			'jumPrinter_type' 	=> $this->PrinterBackup_Model->jumlah_type(),
			'jumBackup'		=> $this->PrinterBackup_Model->jumlahData(),
			'data_user'		=> $this->data_user,
			'jumDamage'		=> $this->PrinterDamage_Model->sum_damage(),
			'jumList'		=> $this->PrinterList_Model->jumlah_data(),

		];

		$this->load->view('dashboard/dashboard', $data);
	}
}
