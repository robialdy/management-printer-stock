<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customers extends CI_Controller
{
	public $Customers_Model, $data_user;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->load->model('Customers_Model');
		$this->data_user = $this->db->get_where('users', ['username' => $this->session->userdata('data_user')])->row_array();
	}

	public function index()
	{
		$this->form_validation->set_rules('custid', 'CUST ID', 'required|is_unique[customers.cust_id]|trim');
		$this->form_validation->set_rules('name', 'NAME', 'required|trim');
		$this->form_validation->set_rules('typecust', 'NAME', 'required|trim');
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'title'		=> 'Customers',
				'agenList'	=> $this->Customers_Model->readData(),
				'jumAgen'	=> $this->Customers_Model->jumlahData(),
				'data_user'	=> $this->data_user,
				'dateTime'	=> $this->Customers_Model->dateTime(),
			];

			$this->load->view('customers/customer', $data);
		}else {
			$this->Customers_Model->insertData();
			$cust_name = strtoupper($this->input->post('name'));
			$this->session->set_flashdata('notifSuccess', "Create Customer $cust_name Succesfuly!");
			redirect('customers');
		}
	}

	public function delete($id)
	{
		$this->Customers_Model->delete($id);
		$this->session->set_flashdata('notifSuccess', 'Delete Customers Successfuly!');
		redirect('customers');
	}


}
