<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TypePrinter extends CI_Controller
{
	public $Type_printer_Model, $data_user;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->data_user = $this->db->get_where('users', ['username' => $this->session->userdata('data_user')])->row_array();
		if ($this->data_user['role'] === 'ADMIN') {
			redirect();
		};
		$this->load->model('Type_printer_Model');
	}
	
	public function index()
	{
		$this->form_validation->set_rules('name_type', 'Name Type', 'required|trim');
		if ($this->form_validation->run() == FALSE) {

			$data = [
				'title'		=> 'Type Printer',
				'data_user'	=> $this->data_user,
				'type_prin'	=> $this->Type_printer_Model->read_data(),
				'jumlah_data'	=> $this->Type_printer_Model->jumlah_data(),
				'date_time'	=> $this->Type_printer_Model->dateTime(),
			];
			$this->load->view('type_printer/type_printer', $data);
		} else {
			$this->Type_printer_Model->insert_data();
			$name_type = strtoupper($this->input->post('name_type', true));
			$this->session->set_flashdata('notifSuccess', "Type Printer $name_type Berhasil Ditambahkan!");
			redirect('type');
		}
	}
	
	
		public function view_data_table()
		{
			$data = $this->Type_printer_Model->read_data();

			$html = '';
			$i = 1;
			foreach ($data as $al) {
				$html .= '
			<tr>
				<td class="text-center text-uppercase">
					<h6 class="mb-0 text-md fw-normal">' . $i++ . '</h6>
				</td>
				<td class="text-center text-uppercase">
					<h6 class="mb-0 text-md fw-normal">' . $al->name_type . '</h6>
				</td>
				<td class="text-center text-uppercase">
					<form action="'. site_url('typeprinter/delete/') . $al->id_type .'" method="post">
						<button type="submit" class="btn p-0 mb-1" onclick="rconfirm(\'Yakin ingin menghapus ini?\')">
							<i class="material-icons text-secondary">delete</i>
						</button>
					</form>
				</td>
			</tr>';
			}

		header('Content-Type: application/json');
		echo json_encode(['html' => $html]);
		}

	public function delete($id)
	{
		$this->Type_printer_Model->delete($id);
		$this->session->set_flashdata('notifSuccess', 'Type Printer Berhasil Dihapus!');
		redirect('type');
	}
}
