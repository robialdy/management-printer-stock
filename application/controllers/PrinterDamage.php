<?php
defined('BASEPATH') or exit('No direct script access allowed');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

use PhpOffice\PhpSpreadsheet\IOFactory;

class PrinterDamage extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->load->model('PrinterDamage_Model');
		$this->load->model('PrinterList_Model');
		$this->load->model('PrinterPembelian_Model');
		$this->data_user = $this->db->get_where('users', ['username' => $this->session->userdata('data_user')])->row_array();
	}

	public function index()
	{

		$data = [
			'title' => 'Printer Damage',
			'data_user'	=> $this->data_user,
			'printer_pembelian' => $this->PrinterPembelian_Model->read_data_by_damage(),
			'damage'	=> $this->PrinterDamage_Model->read_data(),
			'sum_damage' => $this->PrinterDamage_Model->sum_damage(),
			'read_dummy' => $this->PrinterDamage_Model->read_data_dummy(),
			'date_time'	=> $this->PrinterDamage_Model->date_time(),
			'no_dummy'	=> $this->PrinterDamage_Model->read_data_nodummy(),
			'printer_list' => $this->PrinterList_Model->read_data(),
		];
		$this->load->view('printerDamage/printer_damage', $data);
	}

	public function view_data_table()
	{
		$data = $this->PrinterDamage_Model->read_data();


		$html = '';
		$i = 1;
		foreach ($data as $al) {
			$html .= '
        <tr>
            <td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $i++ . '</h6>
            </td>
            <td class="text-center text-uppercase">
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
                <h6 class="mb-0 text-sm fw-normal">' . $al->return_cgk . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->cust_id . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal text-wrap">' . $al->cust_name . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->type_cust . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->no_dummy .
				'</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">';

			if ($al->biaya_perbaikan != null) {
				$html .= '
					Rp.' . number_format($al->biaya_perbaikan, 2, ',', '.') . '
				';
			} else {
				$html .= '-';
			}

			$html .= '</h6>
            </td>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->status_pembayaran .
				'</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->status . '
				</h6>
            </td>
			<td class="text-center text-uppercase">
            	<a class="mb-0 text-sm fw-normal btn-kelengkapan" style="cursor: pointer;" data-bs-toggle="modal"  data-bs-target="#kelengkapan" data-modal="' . $al->id_damage . '">
            	<i class="material-icons">assignment</i>
            </a>
            </td>
			<td class="text-center">
            	<a class="mb-0 text-sm fw-normal btn-file" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#file" data-modal="' . $al->id_damage . '">
            	<i class="material-icons">cloud_upload</i>
            </a>
            </td>
			<td class="text-center">
            	<a class="mb-0 text-sm fw-normal btn-edit" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#edit" data-modal="' . $al->id_damage . '">
            	<i class="material-icons">edit</i>
            </a>
            </td>
        </tr>';
		}

		header('Content-Type: application/json');
		echo json_encode(['html' => $html]);
	}

	public function add_nodummy()
	{
		// $this->form_validation->set_rules('idprinter', 'PRINTER SN', 'required|trim');
		$this->form_validation->set_rules('nodummy', 'NO dummy', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			redirect('damage');
		} else {
			$nodummy = $this->input->post('nodummy');
			$idprinter = $this->input->post('idprinter'); //array


			$this->PrinterDamage_Model->add_nodummy($idprinter, $nodummy);
			$this->session->set_flashdata('notifSuccess', 'No Dummy Berhasil Ditambahkan!');
			redirect('damage');
		}
	}

	public function add_damage()
	{
		$this->PrinterDamage_Model->add_damage();
		$this->session->set_flashdata('notifSuccess', 'Printer Damage Berhasil ditambahkan');
		redirect('damage');
	}

	public function edit()
	{
		$this->form_validation->set_rules('no_dummy', 'NO DUMMY', 'trim');
		$this->form_validation->set_rules('biaya', 'BIAYA', 'required|trim');
		$this->form_validation->set_rules('status_pembayaran', 'STATUS', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			redirect('damage');
		} else {
			$this->PrinterDamage_Model->edit();
			$this->session->set_flashdata('notifSuccess', 'Printer berhasil di edit');
			redirect('damage');
		}
	}

	public function edit_status()
	{
		$this->PrinterDamage_Model->edit_status();
		$this->session->set_flashdata('notifSuccess', 'Status Sekarang Jadi ' . $this->input->post('return_cgk'));
		redirect('damage');
	}

	public function upload_file()
	{
		if ($this->input->post('name_file_indb')) {
			$path = FCPATH . 'public/file_damage/' . $this->input->post('name_file_indb');
			unlink($path);
		}

		$config['upload_path'] = FCPATH . 'public/file_damage/';
		$config['allowed_types'] = 'pdf|jpg|jpeg|png';
		$config['max_size'] = 30000; // Batas ukuran file (da lam KB)
		$this->load->library('upload', $config);

		// Proses upload
		if ($this->upload->do_upload('file')) {
			$new_file = $this->upload->data('file_name');
		} else {
			redirect('damage');
		}

		$id = $this->input->post('id_damage');
		$this->db->where('id_damage', $id);
		$this->db->update('printer_damage', ['file' => $new_file]);

		$this->session->set_flashdata('notifSuccess', 'Lampiran File Transaksi Berhasil Diupload!');
		redirect('damage');
	}

	public function modal_edit()
	{
		$id_damage = $this->input->post('modal');
		$data = $this->PrinterDamage_Model->read_data_by_id($id_damage);

		$html = '
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="text-end me-1">
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
				<div class="text-start">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">BIAYA PERBAIKAN</h5>
                </div>
                    <form action="' . site_url('printerdamage/edit') . '" method="post">
                        <input type="hidden" name="id_damage" value="' . $data->id_damage . '">
                        <div class="row">
                            <div class="col-4 mt-2">
                                <label for="biaya">BIAYA PERBAIKAN <span class="text-danger">*</span></label>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-dynamic mb-3">
                                    <input type="number" class="form-control" name="biaya" value="' . $data->biaya_perbaikan . '" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 mt-2">
                                <label for="status_pembayaran">STATUS PEMBAYARAN <span class="text-danger">*</span></label>
                            </div>
                            <div class="col mt-3">
                                <div class="row">
                                    <div class="form-check col">
                                        <input type="radio" name="status_pembayaran" id="sudah_bayar" value="SUDAH BAYAR" ' . ($data->status_pembayaran == "SUDAH BAYAR" ? 'checked' : '') . ' required>
                                        <label class="form-check-label" for="sudah_bayar">SUDAH BAYAR</label>
                                    </div>
                                    <div class="form-check col">
                                        <input type="radio" name="status_pembayaran" id="belum_bayar" value="BELUM BAYAR" ' . ($data->status_pembayaran == "BELUM BAYAR" ? 'checked' : '') . '>
                                        <label class="form-check-label" for="belum_bayar">BELUM BAYAR</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn bg-gradient-info text-white border-radius-sm">Save changes</button>
                        </div>
                    </form>
					<div class="text-start">
                    	<h5 class="modal-title fw-bold" id="exampleModalLabel">Edit Status</h5>
                	</div>
					<form action="' . site_url('printerdamage/edit_status') . '" method="post">
                        <input type="hidden" name="id_damage" value="' . $data->id_damage . '">
                        <div class="row">
                            <div class="col-4 mt-2">
                                <label for="biaya">STATUS <span class="text-danger">*</span></label>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-dynamic mb-3">
                                    <input type="text" class="form-control" name="return_cgk" value="' . $data->status . '" placeholder="EDIT STATUS" required>
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
    </div>';

		echo $html;
	}

	public function modal_file()
	{
		$id_damage = $this->input->post('modal');
		$data = $this->PrinterDamage_Model->read_data_by_id($id_damage);

		$html = '
        <div class="modal fade" id="file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="text-end me-1">
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="text-start ms-3">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">LAPORAN DARI JAKARTA</h5>
                        <small>Lampiran Terkait Dari Jakarta</small>
                    </div>
                    <div class="modal-body">
                        <div class="mx-1 mb-4">
                            <blockquote class="blockquote" style="max-width: 100%; margin: auto;">
                                ' . form_open('printerdamage/upload_file', ['enctype' => 'multipart/form-data', 'class' => 'd-flex w-100 gap-2 align-items-center']) . '
                                <input type="hidden" name="id_damage" value="' . $data->id_damage . '">
                                <input type="hidden" name="name_file_indb" value="' . $data->file . '">

                                <!-- Custom file input -->
                                <div class="d-flex align-items-center gap-3 w-30 file-wrapper" style="cursor:pointer;">
                                    <span class="form-text ms-2 file-name">Click! untuk upload file</span>
                                    <input type="file" class="d-none custom-file" name="file" required>
                                </div>

                                <!-- Tombol Upload -->
                                <div>
                                    <button class="btn btn-info px-4 py-2 mb-0" type="submit" id="inputGroupFileAddon04">Upload</button>
                                </div>
                                ' . form_close() . '
                            </blockquote>
                        </div>';

		// Logika untuk menampilkan file
		if ($data->file != null) {
			if (substr($data->file, -4) === ".pdf") {
				$html .= '
                <iframe src="' . base_url('public/file_damage/' . $data->file) . '" width="100%" height="750px"></iframe>
            ';
			} else {
				$html .= '
                <div style="max-width: 100%; max-height: 750px; overflow: auto;">
                    <img src="' . base_url('public/file_damage/' . $data->file) . '" alt="Bukti Transaksi" class="img-fluid">
                </div>
            ';
			}
		} else {
			$html .= '
            <div class="d-flex align-items-center justify-content-center" style="height: 600px;">
                <div class="text-center">
                    <i class="bi bi-exclamation-circle" style="font-size: 3rem; color: #dc3545;"></i>
                    <p class="mt-3 fs-4 text-danger">File belum diupload.</p>
                </div>
            </div>
        ';
		}

		$html .= '
                    </div>
                </div>
            </div>
        </div>
    ';

		echo $html;
	}

	public function modal_kelengkapan()
	{
		$id_damage = $this->input->post('modal');
		$data = $this->PrinterDamage_Model->read_data_by_id($id_damage);

		$html = '
        <div class="modal fade" id="kelengkapan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="text-end me-1">
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="text-start ms-3">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">KELENGKAPAN & KERUSAKAN</h5>
                        <small>Detail Kelengkapan Printer Yang Dibawa Ke Jakarta & Kerusakan</small>
                        <h5 class="font-weight-normal text-info text-gradient mt-2">SN ' . $data->printer_sn . '</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mx-3">';

		// Logika untuk kelengkapan
		if ($data->kelengkapan != null) {
			$html .= '
                            <h6 class="font-weight-bold text-dark">KELENGKAPAN</h6>
                            <blockquote class="blockquote mb-0">
                                <p class="text-dark ms-3">' . $data->kelengkapan . '</p>
                            </blockquote>';
		} else {
			$html .= '
                            <h6 class="font-weight-bold text-dark">KELENGKAPAN</h6>
                            <blockquote class="blockquote mb-0">
                                <p class="text-dark ms-3">-</p>
                            </blockquote>';
		}

		// Menambahkan deskripsi kerusakan
		$html .= '
                        </div>
                        <div class="mx-3 mt-3">
                            <h6 class="font-weight-bold text-dark">DESKRIPSI KERUSAKAN</h6>
                            <blockquote class="blockquote mb-0">
                                <p class="text-dark ms-3">' . $data->deskripsi . '</p>
                            </blockquote>
                        </div>

                        <div class="text-end mt-3">
                            <button type="button" class="btn bg-white shadow" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ';

		echo $html;
	}




	public function export_excel()
	{

		$from_raw = $this->input->post('from'); // Format: 2024-09-18
		$until_raw = $this->input->post('until'); // Format: 2024-09-30

		if ($from_raw && $until_raw) {

			// Konversi ke format 'Y-m-d H:i:s'
			$from = date('d/m/Y', strtotime($from_raw));
			$until = date('d/m/Y', strtotime($until_raw));

			$data = $this->PrinterDamage_Model->export_excel_by_date($from, $until);
		} else {
			$no_dummy = $this->input->post('no_dummy');
			
			$data = $this->PrinterDamage_Model->export_excel_by_dummy($no_dummy);
		}



		// Membuat objek spreadsheet baru
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Mengisi header kolom
		$headers = ['NO.', 'NO. DUMMY', 'TANGGAL', 'ORIGIN', 'CUST.ID', 'CUST.NAME', 'TYPE PRINTER', 'SN', 'DESCRIPTION', 'KELENGKAPAN', ''];
		$columnNames = range('A', 'K');

		// Mengatur panjang sesuai keinginan
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(25);
		$sheet->getColumnDimension('C')->setWidth(20);
		$sheet->getColumnDimension('D')->setWidth(20);
		$sheet->getColumnDimension('E')->setWidth(20);
		$sheet->getColumnDimension('F')->setWidth(50);
		$sheet->getColumnDimension('G')->setWidth(15);
		$sheet->getColumnDimension('H')->setWidth(15);
		$sheet->getColumnDimension('I')->setWidth(40);
		$sheet->getColumnDimension('J')->setWidth(90);
		$sheet->getColumnDimension('K')->setWidth(20);


		// mengatur desain header
		foreach ($columnNames as $index => $column) {
			// mengisi data header praktis di loop
			$sheet->setCellValue($column . '1', $headers[$index]);
			// Menambahkan border ke header
			$sheet->getStyle($column . '1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			// Mengatur gaya bold pada header
			$sheet->getStyle($column . '1')->getFont()->setBold(true);
			// Menambah padding
			$sheet->getRowDimension(1)->setRowHeight(45);
			// warna header
			$sheet->getStyle($column . '1')->getFill()->setFillType(Fill::FILL_SOLID);
			$sheet->getStyle($column . '1')->getFill()->getStartColor()->setARGB('C6E0B4'); // Mengubah warna latar belakang menjadi hijau
			// Mengatur posisi text header ke tengah
			$sheet->getStyle($column . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($column . '1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		}

		// Mengisi data dari database ke dalam Excel
		$i = 1;
		$row = 2;
		foreach ($data as $dm) {
			// mengisi data
			$sheet->setCellValue('A' . $row, $i++);
			$sheet->setCellValueExplicit('B' . $row, $dm->no_dummy, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValue('C' . $row, $dm->date_pengiriman);
			$sheet->setCellValue('D' . $row, $dm->origin_name);
			$sheet->setCellValue('E' . $row, $dm->cust_id);
			$sheet->setCellValue('F' . $row, $dm->cust_name);
			$sheet->setCellValue('G' . $row, $dm->name_type);
			$sheet->setCellValue('H' . $row, $dm->printer_sn);
			$sheet->setCellValue('I' . $row, $dm->deskripsi);
			$sheet->setCellValue('J' . $row, $dm->kelengkapan);
			$sheet->setCellValue('K' . $row, $dm->status);
			foreach ($columnNames as $column) {
				// Mengeedit desain data nya excel
				$sheet->getStyle($column . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
				$sheet->getStyle($column . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($column . $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			}
			$row++;
		}


		// Set nama file
		$filename = 'printer_damage_data.xlsx';

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

	public function import_excel()
	{
		ini_set('memory_limit', '2048M'); // Meningkatkan batas memori


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
				if (empty($orw['L']) && empty($row['M'])) {

					if ($row['E'] === null) {
						$cust_id = '-';
					} else {
						$cust_id = $row['E'];
					}

					$cust_data = [
						'cust_id' => $cust_id,
						'cust_name'	=> $row['F'],
						'origin_name' => $row['D'],
						'created_at' => date('d F Y H:i:s'),
					];

					$existing_cust = $this->db->get_where('customers', ['cust_id' => $cust_data['cust_id'], 'cust_name' => $cust_data['cust_name']])->row();
					if (!$existing_cust) {
						$this->db->insert('customers', $cust_data);
						$cust_id = $this->db->insert_id();
					} else {
						$cust_id = $existing_cust->id_cust;
					}

					// Ambil atau insert tipe printer
					$printer_type_name = $row['G'];
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
						'printer_sn' => $row['H'],
						'id_type' => $id_type,
						'status' => 'DAMAGE',
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

					$printer_damage = [
						'id_printer'	=> $id_printer,
						'id_cust'		=> $cust_id,
						'date_in'		=> date('d/m/Y H:i:s'),
						'kelengkapan'	=> $row['J'],
						'deskripsi'		=> $row['I'],
					];
					$this->db->insert('printer_damage', $printer_damage);

					$log_data = [
						'printer_sn'	=> $row['H'],
						'cust_id'		=> $cust_id,
						'cust_name'		=> $row['F'],
						'date_out'		=> '*MASTER DATA',
						'returned'		=> '*MASTER DATA',
						'status'		=> 'IN DAMAGE',
						'created_at'	=> date('d/m/Y H:i:s'),
					];
					$this->db->insert('printer_log', $log_data);
				}
			}

			$unlink = FCPATH . 'public/import_excel/' . $path_unlink;
			unlink($unlink);
			$this->session->set_flashdata('notifSucces');
			redirect('printerdamage');
		} else {
			// Jika upload gagal, tampilkan error
			redirect('printerdamage');
		}
	}
}
