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
		$this->form_validation->set_rules('custid', 'CUST ID', 'is_unique[customers.cust_id]|trim');
		$this->form_validation->set_rules('name', 'NAME', 'required|is_unique[customers.cust_name]|trim');
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
			$cust_name = strtoupper($this->input->post('name', true));
			$this->session->set_flashdata('notifSuccess', "Create Customer $cust_name Succesfuly!");
			redirect('customers');
		}
	}

	public function view_data_table()
	{
		$data = $this->Customers_Model->readData();

		// Lakukan looping di server untuk membentuk row HTML
		$html = '';
		$i = 1;
		foreach ($data as $al) {
			$html .= '
                <tr>
                    <td class="text-center text-uppercase">
						<h6 class="mb-0 text-md fw-normal">' . $i++ . '</h6></td>
                    <td class="text-center text-uppercase">
						<h6 class="mb-0 text-md fw-normal">' . $al->cust_id . '</h6></td>
                    <td class="text-center text-uppercase">
						<h6 class="mb-0 text-md fw-normal">' . $al->cust_name . '</h6></td>
                    <td class="text-center text-uppercase">
						<h6 class="mb-0 text-md fw-normal">' . $al->type_cust . '</h6></td>
                    <td class="text-center text-uppercase">
						<h6 class="mb-0 text-md fw-normal">' . $al->origin_id . '</h6></td>
                    <td class="text-center text-uppercase">
						<h6 class="mb-0 text-md fw-normal">' . $al->origin_name . '</h6></td>
                    <td class="text-center text-uppercase">
						<h6 class="mb-0 text-md fw-normal">' . $al->status . '</h6></td>
                    <td>	
                        <form action="' . site_url('customers/delete/' . $al->id_cust) . '" method="post">
                            <button type="submit" class="btn p-0 mb-1" onclick="return confirm(\'Yakin ingin menghapus ini?\')">
                                <i class="material-icons text-dark">delete</i>
                            </button>
                        </form>
                    </td>
                    <td>
                        <a class="mb-0 text-sm fw-normal" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#edit-' . $al->id_cust . '">
                            <i class="material-icons btn-tooltip">edit</i>
                        </a>
                    </td>
                </tr>';
		}

		header('Content-Type: application/json');
		echo json_encode(['html' => $html]);
	}

	public function edit_status()
	{
		$this->db->where('id_cust', $this->input->post('id_cust'));
		$this->db->update('customers', ['status' => $this->input->post('status')]);

		$this->session->set_flashdata('notifSuccess', $this->input->post('cust_name') . ' Sekarang '. $this->input->post('status'));
		redirect('customers');
	}

	public function delete($id)
	{
		$this->Customers_Model->delete($id);
		$this->session->set_flashdata('notifSuccess', 'Delete Customers Successfuly!');
		redirect('customers');
	}


}
