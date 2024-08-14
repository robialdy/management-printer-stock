<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agen extends CI_Controller
{
	public $Agen_Model, $data_user;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->load->model('Agen_Model');
		$this->data_user = $this->db->get_where('auth', ['username' => $this->session->userdata('data_user')])->row_array();
	}

	public function index()
	{
		$data = [
			'title'		=> 'Master Data Customer',
			'agenList'	=> $this->Agen_Model->readData(),
			'jumAgen'	=> $this->Agen_Model->jumlahData(),
			'data_user'	=> $this->data_user,
			'dateTime'	=> $this->Agen_Model->dateTime(),
		];

		$this->load->view('agen/agen', $data);
	}

	public function insert()
	{
		$this->form_validation->set_rules('custid', 'CUST ID', 'required|trim');
		$this->form_validation->set_rules('name', 'NAME', 'required|trim');
		if ($this->form_validation->run() == FALSE) {
			redirect('agen');
		}else {
			$this->Agen_Model->insertData();
			$this->session->set_flashdata('notifSuccess', 'baru berhasil ditambahkan!');
			redirect('agen');
		}
	}
}
