<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;

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
			'sndamage'		=> $this->PrinterBackup_Model->read_data_return_cgk(),
			'type_printer'	=> $this->Type_printer_Model->read_data(),
		];

		$this->load->view('printerBackup/printer_backup', $data);
	}

	public function view_data_table()
	{
		$data = $this->PrinterBackup_Model->read_data_backup();

		$html = '';
		$i = 1;
		foreach ($data as $al) {
			$html .= '
        <tr>
            <td class="text-center text-uppercase">
                <h6 class="mb-0 text-md fw-normal">' . $i++ . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-md fw-normal">' . $al['printer_sn'] . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-md fw-normal">' . $al['name_type'] . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-md fw-normal">' . $al['date_in'] . '</h6>
            </td>
        </tr>';
		}

		header('Content-Type: application/json');
		echo json_encode([
			'html' => $html,
			'token' => $this->security->get_csrf_hash() //update token setelah request tabel
		]);
	}

	public function insert()
	{

		$this->form_validation->set_rules('printersn', 'PRINTER SN', 'required|trim');
		$this->form_validation->set_rules('typeprinter', 'PRINTER SN', 'required|trim');
		$this->form_validation->set_rules('return_cgk', 'Return Cgk', 'trim');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('notifError', "Printer SN $prin_sn Telah Digunakan!");
			redirect('printer');
		} else {
			$prin_sn = strtoupper($this->input->post('printersn', true));

			// cek printer
			$cek_sn = $this->db->select('printer_backup.id_printer, type_printer.name_type, printer_backup.status')->from('printer_backup')->join('type_printer', 'printer_backup.id_type = type_printer.id_type')->where('printer_backup.printer_sn', $prin_sn)->get()->row();


			if ($cek_sn) {

				if ($cek_sn->status != 'DAMAGE') {
					$this->session->set_flashdata('notifError', "Printer SN $prin_sn Sedang Berada di Cust / Backup");
					redirect('printer');
				} else {
					// set flashdata
					$this->session->set_flashdata('confirm', ['sn' => $prin_sn, 'sn_damage' => $this->input->post('sn_damage', true), 'id_prin' => $cek_sn->id_printer, 'type_prin' => $cek_sn->name_type]);
					redirect('printer');
				}
			} else {
				$this->PrinterBackup_Model->insertData();
				$this->session->set_flashdata('notifSuccess', "Printer SN $prin_sn Berhasil Ditambahkan!");
				redirect('printer');
			}
		}
	}

	public function update_printer_backup()
	{
		$this->PrinterBackup_Model->update_printer_backup();
		$this->session->set_flashdata('notifSuccess', 'Printer Sn ' . $this->input->post('printer_sn', true) . ' Berhasil Ditambahkan!');
		redirect('printer');
	}
}
