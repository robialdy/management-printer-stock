<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
			'printer_detail' => $this->PrinterList_Model->read_data(),
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

		$this->session->set_flashdata('notifSuccess', 'Printer SN ' . $this->input->post('printer_sn', true) . ' Berhasil Dikirim Ke Printer Backup');
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
			$this->session->set_flashdata('notifSuccess', 'Printer SN ' . $sn->printer_sn . ' Berhasil Ditambahkan');
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

	public function view_data_table_summary()
	{
		$data = $this->PrinterList_Model->read_data_summary();
		$type_printer = $this->PrinterList_Model->type_printer();

		$html = '';
		$i = 1;
		foreach ($data as $pd) {
			$html .= '
            <tr>
                <td class="text-center text-uppercase py-3">
                    <h6 class="mb-0 text-md fw-normal">' . $i++ . '</h6>
                </td>
                <td class="text-center text-uppercase py-3">
                    <h6 class="mb-0 text-md fw-normal">' . $pd->cust_id . '</h6>
                </td>
                <td class="text-center text-uppercase">
                    <h6 class="mb-0 text-md fw-normal">' . $pd->type_cust . '</h6>
                </td>
                <td class="text-center text-uppercase">
                    <h6 class="mb-0 text-md fw-normal">' . $pd->cust_name . '</h6>
                </td>
                <td class="text-center text-uppercase">
                    <h6 class="mb-0 text-md fw-normal">' . $pd->system . '</h6>
                </td>';

			foreach ($type_printer as $tp) {
				$name_type_alias = 'total_' . str_replace('-', '_', $tp->name_type);
				$html .= '
                <td class="text-center text-uppercase">
                    <h6 class="mb-0 text-md fw-normal">' . $pd->$name_type_alias . '</h6>
                </td>';
			}

			$html .= '
                <td class="text-center text-uppercase py-3">
                    <h6 class="mb-0 text-md fw-normal">' . $pd->total_printer . '</h6>
                </td>
                <td class="text-center text-uppercase">
                    <h6 class="mb-0 text-md fw-normal">' . $pd->cn_label_status . '</h6>
                </td>
                <td class="text-center text-uppercase">
                    <h6 class="mb-0 text-md fw-normal">' . $pd->origin_id . '</h6>
                </td>
                <td class="text-center text-uppercase">
                    <h6 class="mb-0 text-md fw-normal">' . $pd->origin_name . '</h6>
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
				if (isset($row['E']) && !empty($row['F']) && !empty($row['G']) && !empty($row['A'])) {

					if ($row['A'] == 'BANDUNG') {
						$origin_id = 'BDO10000';
					} else if ($row['A'] == 'SOREANG') {
						$origin_id = 'BDO10100';
					} else if ($row['A'] == 'RANCAEKEK') {
						$origin_id = 'BDO10129';
					} else if ($row['A'] == 'SUMEDANG') {
						$origin_id = 'BDO20200';
					} else if ($row['A'] == 'GARUT') {
						$origin_id = 'BDO20700';
					} else if ($row['A'] == 'CIMAREME') {
						$origin_id = 'BDO21000';
					} else if ($row['A'] == 'CIANJUR') {
						$origin_id = 'BDO21200';
					}

					// insert customers
					$cust_data = [
						'cust_id' => $row['E'],
						'cust_name' => $row['F'],
						'type_cust' => $row['G'],
						'origin_id' => $origin_id,
						'origin_name' => $row['A'],
						'status'	=> $row['L'],
						'created_at'	=> date('d F Y H:i:s'),
					];

					// cek jika datanya udah ada make pake yang ada kalo ga buat baru
					$existing_cust = $this->db->get_where('customers', ['cust_id' => $cust_data['cust_id'], 'cust_name' => $cust_data['cust_name']])->row();
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
						$this->db->insert('type_printer', ['name_type' => $printer_type_name, 'created_at' => date('d F Y H:i:s')]);
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
						'created_at'	=> date('d F Y H:i:s'),
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
						'date_out' => date('d/m/Y H:i:s'),
						'created_at' => date('d F Y H:i:s'),
					];
					$this->db->insert('printer_list_inagen', $list_data);


					if ($row['K']) {
						$date_out_log = $row['K'];
					} else {
						$date_out_log = '-';
					}

					$log_data = [
						'printer_sn'	=> $row['D'],
						'cust_id'		=> $row['E'],
						'cust_name'		=> $row['F'],
						'date_out'		=> $date_out_log,
						'status'		=> 'IN CUSTOMER',
						'created_at'	=> date('d/m/Y H:i:s'),
					];
					$this->db->insert('printer_log', $log_data);
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

	public function export_excel()
	{
		$this->load->model('Type_Printer_Model');
		$this->load->model('PrinterDamage_Model');

		$data = $this->PrinterList_Model->read_data_summary();
		// backup
		$backups = $this->PrinterBackup_Model->readData();
		$total_backup = $this->PrinterBackup_Model->jumlahData();
		// damage
		$total_damage = $this->PrinterDamage_Model->sum_damage();
		$damages = $this->PrinterDamage_Model->read_data_with_type();
		// type printer
		$type_printer = $this->Type_Printer_Model->read_data();

		// Membuat objek spreadsheet baru
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// header dinamis
		$printer_headers = [];
		foreach ($type_printer as $type) {
			$printer_headers[] = $type->name_type;
		}
		$static_header_start = ['NO.', 'CUST NAME', 'CUST ID', 'SYSTEM'];
		$static_header_end = ['TOTAL', 'CN LABEL STATUS', 'ORIGIN ID', 'ORIGIN NAME', 'TYPE CUST'];

		$headers = array_merge($static_header_start, $printer_headers, $static_header_end);
		$columnNames = range('A', chr(64 + count($headers)));
		// $headers = ['NO.','CUST NAME', 'CUST ID', 'SYSTEM', 'CP-2240', 'OX-130', 'OS-200', 'TOTAL', 'CN LABEL STATUS', 'ORIGIN ID', 'ORIGIN NAME', 'TYPE CUST'];

		// Mengatur panjang sesuai keinginan
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(60);
		$sheet->getColumnDimension('C')->setWidth(15);
		$sheet->getColumnDimension('D')->setWidth(15);
		$sheet->getColumnDimension('E')->setWidth(15);
		$sheet->getColumnDimension('F')->setWidth(15);
		$sheet->getColumnDimension('G')->setWidth(15);
		$sheet->getColumnDimension('H')->setWidth(15);
		$sheet->getColumnDimension('I')->setWidth(20);
		$sheet->getColumnDimension('J')->setWidth(15);
		$sheet->getColumnDimension('K')->setWidth(15);
		$sheet->getColumnDimension('L')->setWidth(25);

		foreach ($columnNames as $index => $column) {
			$sheet->setCellValue($column . '1', $headers[$index]);
			$sheet->getStyle($column . '1')->getFont()->setBold(true);
			$sheet->getRowDimension(1)->setRowHeight(20);
			$sheet->getStyle($column . '1')->getFill()->setFillType(Fill::FILL_SOLID);
			$sheet->getStyle($column . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($column . '1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			$sheet->getStyle($column . '1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
		}

		// Mapping tipe printer ke kolom
		$printerColumnMap = [];
		foreach ($printer_headers as $index => $name_type) {
			$printerColumnMap[$name_type] = $columnNames[$index + count($static_header_start)];
		}

		$i = 1;
		$row = 2;
		foreach ($data as $dr) {
			$sheet->setCellValue('A' . $row, $i++);
			$sheet->setCellValue('B' . $row, $dr->cust_name);
			$sheet->setCellValue('C' . $row, $dr->cust_id);
			$sheet->setCellValue('D' . $row, $dr->system);

			foreach ($printer_headers as $header) {
				$col = $printerColumnMap[$header] ?? null;
				if ($col) {
					$total_key = 'total_' . str_replace('-', '_', $header);
					$sheet->setCellValue($col . $row, !empty($dr->$total_key) ? $dr->$total_key : null);
				}
			}

			$sheet->setCellValue('H' . $row, $dr->total_printer);
			$sheet->setCellValue('I' . $row, $dr->cn_label_status);
			$sheet->setCellValue('J' . $row, $dr->origin_id);
			$sheet->setCellValue('K' . $row, $dr->origin_name);
			$sheet->setCellValue('L' . $row, $dr->type_cust);
			foreach ($columnNames as $column) {
				$sheet->getStyle($column . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
				$sheet->getStyle($column . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($column . $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			}
			$row++;
		}

		$row += 2; // Tambahkan jarak sebelum PRINTER BACKUP BDO

		//PRINTER BACKUP BDO
		$sheet->setCellValue('B' . $row, 'PRINTER BACKUP BDO');
		$sheet->setCellValue('H' . $row, $total_backup);
		foreach ($backups as $backup) {
			$col = $printerColumnMap[$backup['name_type']] ?? null;
			if ($col) {
				$sheet->setCellValue($col . $row, $backup["total_" . str_replace('-', '_', $backup['name_type'])]);
			}
		}

		// Terapkan border dan alignment untuk seluruh kolom pada baris ini
		foreach ($columnNames as $column) {
			$sheet->getStyle($column . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$sheet->getStyle($column . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($column . $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		}

		// PRINTER DAMAGE
		$end_row = $row += 1;
		$sheet->setCellValue('B' . $row, 'PRINTER DAMAGE');
		$sheet->setCellValue('H' . $row, $total_damage);
		foreach ($damages as $damage) {
			$col = $printerColumnMap[$damage->name_type] ?? null;
			if ($col) {
				$total_key = "total_" . str_replace('-', '_', $damage->name_type);
				$sheet->setCellValue($col . $row, $damage->$total_key);
			}
		}


		foreach ($columnNames as $column) {
			$sheet->getStyle($column . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$sheet->getStyle($column . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($column . $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		}

		// BLACK
		$row += 1; // Tambah baris baru
		$sheet->setCellValue('B' . $row, '');
		$sheet->setCellValue('E' . $row, '');
		$sheet->setCellValue('F' . $row, '');
		$sheet->setCellValue('G' . $row, '');
		$sheet->setCellValue('H' . $row, '');

		// Terapkan border dan alignment pada baris ini juga
		foreach (['B', 'E', 'F', 'G', 'H'] as $column) {
			$sheet->getStyle($column . $row)->getFill()->setFillType(Fill::FILL_SOLID);
			$sheet->getStyle($column . $row)->getFill()->getStartColor()->setARGB('000000');
		}

		$row += 1; // Tambah baris baru
		$sheet->setCellValue('B' . $row, 'TOTAL :');
		$sheet->getStyle('B' . $row)->getFont()->setBold(true);

		$sheet->setCellValue('E' . $row, '=SUM(E2:E' . $end_row . ')');
		$sheet->setCellValue('F' . $row, '=SUM(F2:F' . $end_row . ')');
		$sheet->setCellValue('G' . $row, '=SUM(G2:G' . $end_row . ')');
		$sheet->setCellValue('H' . $row, '=SUM(H2:H' . $end_row . ')');

		// Terapkan alignment pada baris ini juga
		foreach (['B', 'E', 'F', 'G', 'H'] as $column) {
			$sheet->getStyle($column . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($column . $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		}


		// Set nama file
		$filename = 'report_printer.xlsx';

		// Hapus buffer output
		ob_end_clean();

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		// meload isi konten untuk di terapkan di dalam excel
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit; // Hentikan eksekusi skrip
	}
}
