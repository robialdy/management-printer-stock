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
				// dibawah penyebab lagging
				// 'agenList'	=> $this->Customers_Model->readData(),
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
                        <a class="mb-0 text-sm fw-normal btn-edit" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#edit" data-modal="'. $al->id_cust .'">
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
		$func_delete = $this->Customers_Model->delete($id);

		// belum jalan 10/10/2024
		if ($func_delete) {
			$this->Customers_Model->delete($id);
			$this->session->set_flashdata('notifSuccess', 'Delete Customers Successfuly!');
			redirect('customers');
		} else {
			$this->session->set_flashdata('notifError', 'Delete Telah Dibatalkan!');
			redirect('customers');
		}

	}

	public function modal_edit()
	{
		$id_cust = $this->input->post('modal');
		$data = $this->Customers_Model->getCustomerById($id_cust);

		// Menghasilkan HTML untuk modal
		$html = '
        <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="text-end me-1">
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="text-start ms-3">
                            <h5 class="modal-title fw-bold" id="exampleModalLabel">EDIT CUSTOMER</h5>
                            <small>Edit Status Customer</small>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="'. site_url('customers/edit_status') .'" method="POST">

						<input type="hidden" name="id_cust" value="'. $data->id_cust .'">
						<input type="hidden" name="cust_name" value="'. $data->cust_name .'">

						<div class="row">
							<div class="col-4 mt-2">
								<label for="sn">STATUS <span class="text-danger">*</span></label>
							</div>
							<div class="col">
								<div class="input-group input-group-static mb-3">
									<select class="choices form-select" id="exampleFormControlSelect1" name="status" required>
										<option value="ACTIVE" '. (($data->status == 'ACTIVE') ? 'selected' : '') .'>ACTIVE</option>
										<option value="IN-ACTIVE" '. (($data->status == 'IN-ACTIVE') ? 'selected' : '') .'>IN-ACTIVE</option>
									</select>
								</div>
							</div>
						</div>

						<div class="text-end mt-3">
							<button type="button" class="btn bg-white" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn bg-gradient-info text-white border-radius-sm">Save changes</button>
						</div>

					</form>
                    </div>
                </div>
            </div>
        </div>
    ';
		echo $html; // Kirim HTML ke respons
	}



}
