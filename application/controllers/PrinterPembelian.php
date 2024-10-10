<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PrinterPembelian extends CI_Controller
{

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
		$data = [
			'title'	=> 'Printer Pembelian',
			'data_user'	=> $this->data_user,
		];
		$this->load->view('printerpembelian/printer_pembelian', $data);
	}

}
