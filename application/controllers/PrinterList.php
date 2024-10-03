<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

class PrinterList extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->load->model('PrinterList_Model');
		$this->load->model('PrinterBackup_Model');
		$this->load->model('Customers_Model');
		$this->data_user = $this->db->get_where('users', ['username' => $this->session->userdata('data_user')])->row_array();
	}

	public function detail()
	{
		$data = [
			'title'			=> 'Printer List',
			'data_user'		=> $this->data_user,
			'printer_detail'=> $this->PrinterList_Model->read_data(),
			'cust'			=> $this->Customers_Model->read_data_active(),
			'printer'		=> $this->PrinterBackup_Model->read_data_backup(),
			'jum_printer'	=> $this->PrinterBackup_Model->jumlahData(),
			'dateTimeB'		=> $this->PrinterBackup_Model->dateTime(),
			'jum_data'		=> $this->PrinterList_Model->jumlah_data(),
			'time'			=> $this->PrinterList_Model->date_time(),
		];

		$this->load->view('printer_list/printer_detail', $data);
	}

	public function summary()
	{
		$data = [
			'title'			=> 'Dashboard',
			'data_user'		=> $this->data_user,
			'printer_summary' => $this->PrinterList_Model->read_data_summary(),
			'type_printer'	=> $this->PrinterList_Model->type_printer(),
		];

		$this->load->view('printer_list/printer_summary', $data);
	}

	public function send_to_backup()
	{
		$this->db->delete('printer_list_inagen', ['id_printer' => $this->input->post('id_printer', true)]);

		$this->db->where('id_printer', $this->input->post('id_printer', true));
		$this->db->update('printer_backup', ['status' => 'READY', 'printer_sn' => $this->input->post('printer_sn', true) . ' - IN-ACTIVE']);

		$this->session->set_flashdata('notifSuccess', 'Printer SN '. $this->input->post('printer_sn', true). ' Berhasil Dikirim Ke Printer Backup');
		redirect('printerdetail');
	}

	public function printer_out()
	{
		$this->form_validation->set_rules('printersn', 'PRINTER SN', 'required|trim');
		$this->form_validation->set_rules('agenname', 'AGEN NAME', 'required|trim');
		$this->form_validation->set_rules('picit', 'PIC IT', 'required|trim');
		$this->form_validation->set_rules('picuser', 'PIC USER', 'required|trim');
		// $this->form_validation->set_rules('kelengkapan', 'PRINTER SN', 'required|trim');
		if ($this->form_validation->run() == FALSE) {
			redirect('printerdetail');
		} else {
			$this->PrinterList_Model->printer_out();
			$sn = $this->PrinterList_Model->search_sn($this->input->post('printersn'));
			$this->session->set_flashdata('notifSuccess', 'Printer SN '. $sn->printer_sn .' Berhasil Ditambahkan');
			redirect('printerdetail');
		}
	}

	public function detail_($sn)
	{
		// var_dump($this->PrinterReplacement_Model->read_data_detail($sn));
		// die;

		$data = [
			'title' => 'Detail Printer',
			'data_user'		=> $this->data_user,
			'detail' => $this->PrinterList_Model->read_data_detail($sn),
		];

		$this->load->view('printerreplacement/detail', $data);
	}

	public function uploadProof()
	{
		if ($this->input->post('proof')) {
			$path = FCPATH . 'public/proof_replacement/' . $this->input->post('proof');
			unlink($path);
		}


		$config['upload_path'] = FCPATH . 'public/proof_replacement/';
		$config['allowed_types'] = 'pdf|jpg|jpeg|png';
		$config['max_size'] = 30000; // Batas ukuran file (da lam KB)

		$this->load->library('upload', $config);

		// Proses upload
		if ($this->upload->do_upload('file_proof')) {
			$new_file = $this->upload->data('file_name');
		} else {
			redirect('printerdetail/' . $this->input->post('sn'));
		}

		$id = $this->input->post('idrep');
		$this->db->where('id_printer_list', $id);
		$this->db->update('printer_list_inagen', ['proof' => $new_file]);

		$this->session->set_flashdata('notifSuccess', 'Bukti Transaksi Berhasil Diupload!');
		redirect('printerdetail/' . $this->input->post('sn'));
	}

	public function view_data_table()
	{
		$data = $this->PrinterList_Model->read_data();


		$html = '';
		$i = 1;
		foreach ($data as $al) {
    $html .= '
        <tr>
            <td class="text-center text-uppercase py-3">
                <h6 class="mb-0 text-sm fw-normal">' . $i++ . '</h6>
            </td>
            <td class="text-center text-uppercase py-3">
                <h6 class="mb-0 text-sm fw-normal">' . $al->origin_name . '</h6>
            </td>
            <td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->date_in . '</h6>
            </td>
            <td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->name_type . '</h6>
            </td>
            <td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->printer_sn . '</h6>
            </td>
            <td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->cust_id . '</h6>
            </td>
            <td class="text-center text-uppercase py-3">
                <h6 class="mb-0 text-sm fw-normal">' . $al->cust_name . '</h6>
            </td>
            <td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->type_cust . '</h6>
            </td>
            <td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->pic_it . '</h6>
            </td>
            <td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->pic_user . '</h6>
            </td>
            <td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->no_ref . '</h6>
            </td>
            <td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->date_out . '</h6>
            </td>
            <td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->status . '</h6>
            </td>
            <td class="text-center text-uppercase">
				<a href="' . site_url('printerdetail/' . $al->printer_sn) . '" class="mb-0 text-sm fw-normal">
					<i class="material-icons">assignment</i>
				</a>
            </td>
            <td class="text-center text-uppercase">';
    
			if ($al->status != 'ACTIVE') {
				$html .= '
						<a class="mb-0 text-sm fw-normal" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#send-' . $al->id_printer_list . '">
							<i class="material-icons btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Mengembalikan Printer Ke Backup" data-container="body" data-animation="true">send</i>
						</a>';
			} else {
				$html .= '';
			}
    
    $html .= '
            </td>
        </tr>';
	}

		header('Content-Type: application/json');
		echo json_encode(['html' => $html]);
	}









	// import excel
	public function import_excel()
	{
		// Konfigurasi untuk upload file
		$config['upload_path'] = FCPATH . 'public/import_excel/'; 
		$config['allowed_types'] = 'xls|xlsx';  
		$config['max_size'] = 100000; 
		$this->load->library('upload', $config);

		// Jika upload berhasil
		if ($this->upload->do_upload('excel_file')) {
			// Ambil informasi file yang di-upload
			$path_unlink = $this->upload->data('file_name');
			$fileData = $this->upload->data();
			$inputFileName = $fileData['full_path'];  

			try {
				$spreadsheet = IOFactory::load($inputFileName);
			} catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
				die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
			}

			$sheet = $spreadsheet->getActiveSheet();
			$data = $sheet->toArray(null, true, true, true);  

			foreach (array_slice($data, 1) as $row) {
				if (!empty($row['E']) && !empty($row['F']) && !empty($row['G']) && !empty($row['A'])) {
					// insert customers
					$cust_data = [
						'cust_id' => $row['E'], 
						'cust_name' => $row['F'], 
						'type_cust' => $row['G'],
						'origin_name' => $row['A'], 
					];

					// cek jika datanya udah ada make pake yang ada kalo ga buat baru
					$existing_cust = $this->db->get_where('customers', ['cust_id' => $cust_data['cust_id']])->row();
					if (!$existing_cust) {
						$this->db->insert('customers', $cust_data);
						$cust_id = $this->db->insert_id(); 
					} else {
						$cust_id = $existing_cust->id_cust;
					}

					// Ambil atau insert tipe printer
					$printer_type_name = $row['C'];
					$existing_type = $this->db->get_where('type_printer', ['name_type' => $printer_type_name])->row();

					// Jika tipe printer tidak ada, insert ke tabel printer_types
					if (!$existing_type) {
						$this->db->insert('type_printer', ['name_type' => $printer_type_name]);
						$id_type = $this->db->insert_id(); // Ambil id_type yang baru diinsert
					} else {
						$id_type = $existing_type->id_type; // Ambil id_type yang sudah ada
					}

					// insert printer backup
					$printer_data = [
						'printer_sn' => $row['D'],
						'id_type' => $id_type,  
						'status' => 'REPLACEMENT',
						'date_in' => date('d/m/Y H:i:s'), 
					];

					// cek jika datanya udah ada make pake yang ada kalo ga buat baru
					$existing_printer = $this->db->get_where('printer_backup', ['printer_sn' => $printer_data['printer_sn']])->row();
					if (!$existing_printer) {
						$this->db->insert('printer_backup', $printer_data);
						$id_printer = $this->db->insert_id();
					} else {
						$id_printer = $existing_printer->id_printer;
					}

					// insert di printer
					$list_data = [
						'id_printer' => $id_printer,
						'id_cust' => $cust_id,
						'pic_it' => $row['H'],     
						'pic_user' => $row['I'],
						'no_ref' => $row['J'],    
						'status' => 'active',    
						'date_out' => $row['K'], 
						'status'	=> $row['L'],
					];

					$this->db->insert('printer_list_inagen', $list_data);
				}
			}

			$unlink = FCPATH . 'public/import_excel/' . $path_unlink;
			unlink($unlink);
			$this->session->set_flashdata('notifSucces');
			redirect('printerdetail');
		} else {
			// Jika upload gagal, tampilkan error
			redirect('printerdetail');
		}
	}
}
