<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PrinterDamage extends CI_Controller
{
    private $data_user;

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('data_user')) {
            redirect('auth');
        }

        // Load model PrinterDamage_Model
        $this->load->model('PrinterDamage_Model');

        // Ambil dan simpan data user dari session
        $this->data_user = $this->db->get_where('users', [
            'username' => $this->session->userdata('data_user')
        ])->row_array();
    }

    public function index()
    {
        $data = [
            'title' => 'Printer Damage',
            'data_user' => $this->data_user,
            'damage' => $this->PrinterDamage_Model->readData(),
            'jumdamage' => $this->PrinterDamage_Model->jumlahData(),
            'timedate' => $this->PrinterDamage_Model->timedate(),

        ];

        $this->load->view('damage/damage', $data);
    }

    public function update()
{
    // Validasi form
    $this->form_validation->set_rules('id', 'Printer SN', 'required|trim');
    $this->form_validation->set_rules('biayaper', 'Biaya Perbaikan', 'required|trim|numeric|greater_than_equal_to[0]');
    $this->form_validation->set_rules('nodum', 'No Dummy', 'required|trim');
    $this->form_validation->set_rules('status_pembayaran', 'Status Pembayaran', 'required|trim');

    if ($this->form_validation->run() == false) {
        redirect('damage');
    } else {
        // Ambil data dari input form
        $kelengkapan = $this->input->post('kelengkapan');
        $kelengkapan = !empty($kelengkapan) ? implode(', ', $kelengkapan) : '';

        $data = [
            'biaya_perbaikan' => $this->input->post('biayaper', true),
            'status_pembayaran' => $this->input->post('status_pembayaran', true),
            'kelengkapan' => $kelengkapan, 
            'no_dummy' => $this->input->post('nodum', true),
            'date_perbaikan' => date('Y/m/d H:i:s'),
            'update_at' => date('Y-m-d H:i:s'),
        ];

        $id = $this->input->post('id');

        // Update data berdasarkan id_damage
        $this->db->where('id_damage', $id);
        $this->db->update('printer_damage', $data);

        $this->session->set_flashdata('notifSuccess', 'Data Updated Successfully');
        // Redirect kembali ke halaman damage
        redirect('damage');
    }

    public function edit()

    {
        // Aturan validasi form
        $this->form_validation->set_rules('note', 'Note', 'required|trim');
        $this->form_validation->set_rules('biayaper', 'Biaya Perbaikan', 'required|trim');

        // Cek validasi form
        if ($this->form_validation->run() == false) {
            redirect('damage');
        } else {
            // Mengambil nama file yang diunggah
            $upload_file = $_FILES['file']['name'];

            // Jika ada file yang diunggah
            if ($upload_file) {

                $config['upload_path'] = FCPATH . 'public/img/file_uploaded/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 30000; // Batas ukuran file (da lam KB)

                // Load library upload dengan konfigurasi
                $this->load->library('upload', $config);

                // Proses upload
                if ($this->upload->do_upload('file')) {
                    // Ambil nama file yang baru diunggah
                    $new_file = $this->upload->data('file_name');
                } else {
                    echo $this->upload->display_errors();
                    return;
                }
            }


            $data = [
                'pic_it' => $this->input->post('picit', true),
                'note' => $this->input->post('note', true),
                'biaya_perbaikan' => $this->input->post('biayaper', true),
                'status_pembayaran' => $this->input->post('status_pembayaran', true),
                'date_perbaikan' => date('Y-m-d H:i:s'),
                'update_at' => date('Y-m-d H:i:s'),
            ];

            // Tambahkan data file jika ada file yang diunggah
            if (!empty($new_file)) {
                $data['file'] = $new_file;
            }

            $id = $this->input->post('id_damage');
            $this->db->where('id_damage', $id);
            $this->db->update('printer_damage', $data);

            // Redirect ke halaman damage
            redirect('damage');
        }
    }
}


public function edit()
{
    // Aturan validasi form
    $this->form_validation->set_rules('note', 'Note', 'required|trim');
    $this->form_validation->set_rules('biayaper', 'Biaya Perbaikan', 'required|trim');

    // Cek validasi form
    if ($this->form_validation->run() == false) {
        redirect('damage');
    } else {
        // Data yang akan di-update
        $data = [
            'pic_it' => $this->input->post('picit', true),
            'note' => $this->input->post('note', true),
            'biaya_perbaikan' => $this->input->post('biayaper', true),
            'status_pembayaran' => $this->input->post('status_pembayaran', true),
            'date_perbaikan' => date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s'),
        ];

        // Update data tanpa file
        $id = $this->input->post('id_damage');
        $this->db->where('id_damage', $id);
        $this->db->update('printer_damage', $data);

        // Redirect ke halaman damage
        redirect('damage');
    }
}


public function uploadProof()
{
    // Aturan untuk file upload
    $config['upload_path'] = FCPATH . 'public/img/file_uploaded/';
    $config['allowed_types'] = 'pdf|jpg|jpeg|png'; // Diperbolehkan PDF dan gambar
    $config['max_size'] = 30000; // Maksimal 30MB

    // Load library upload dengan konfigurasi
    $this->load->library('upload', $config);

    if ($this->upload->do_upload('file_proof')) {
        // Ambil data file yang diupload
        $fileData = $this->upload->data();
        $fileName = $fileData['file_name'];
        $fileType = $fileData['file_type']; // Mendapatkan tipe file

        // Simpan nama file ke database
        $id_damage = $this->input->post('id_damage');
        $data = [
            'file' => $fileName, // Menyimpan nama file yang diunggah
            
        ];

        $this->db->where('id_damage', $id_damage);
        $this->db->update('printer_damage', $data);

        // Berikan notifikasi sukses
        $this->session->set_flashdata('message', '<div class="alert alert-success">File berhasil diunggah!</div>');
    } else {
        // Jika upload gagal, tampilkan error
        $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
    }

    // Redirect ke halaman damage
    redirect('damage');
}

public function exportToExcel()
    {
        
        // Load model jika dibutuhkan
        $this->load->model('PrinterDamage_Model');
        $dataDamage = $this->PrinterDamage_Model->getAllData();

        // Membuat objek Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan header kolom
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nama Printer');
        $sheet->setCellValue('C1', 'Note');
        $sheet->setCellValue('D1', 'Biaya Perbaikan');
        $sheet->setCellValue('E1', 'Status Pembayaran');
        $sheet->setCellValue('F1', 'Tanggal Perbaikan');

        // Mengisi data dari database ke baris berikutnya
        $row = 2;
        foreach ($dataDamage as $data) {
            $sheet->setCellValue('A' . $row, $data->id_damage);
            $sheet->setCellValue('B' . $row, $data->printer_name);
            $sheet->setCellValue('C' . $row, $data->note);
            $sheet->setCellValue('D' . $row, $data->biaya_perbaikan);
            $sheet->setCellValue('E' . $row, $data->status_pembayaran);
            $sheet->setCellValue('F' . $row, $data->date_perbaikan);
            $row++;
        }

        // Membuat file Excel dan mendownloadnya
        $writer = new Xlsx($spreadsheet);
        $filename = 'data_printer_damage_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}

