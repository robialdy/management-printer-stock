<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FormatReplacement extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		}
		$this->load->model('PrinterReplacement_Model');
	}

	public function generate_format($sn)
	{
		$data['data'] = $this->PrinterReplacement_Model->read_data_detail($sn);

		$datetime = DateTime::createFromFormat('d/m/Y H:i:s', $data['data']->date_out)->format('Y-m-d H:i:s');

		// Mengonversi datetime menjadi timestamp
		$timestamp = strtotime($datetime);
		$tgl = date('d', $timestamp);
		$bln = date('m', $timestamp);
		$thn = date('Y', $timestamp);

		$view_data = array_merge($data, [
			'tgl' => $tgl,
			'bln' => $bln,
			'thn' => $thn,
		]);
		$this->load->view('printerreplacement/generate_format', $view_data);
	}

	public function test()
	{
		$this->load->view('printerreplacement/test');
	}

}
