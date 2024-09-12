<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
        $this->form_validation->set_rules('id', 'Printer SN', 'required|trim');
        $this->form_validation->set_rules('biayaper', 'Biaya Perbaikan', 'required|trim|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('status_pembayaran', 'Status Pembayaran', 'required|trim');

        if ($this->form_validation->run() == false) {
            redirect('damage');
        } else {
            // Ambil data dari input
            $data = [
                'biaya_perbaikan' => $this->input->post('biayaper', true),
                'status_pembayaran' => $this->input->post('status_pembayaran', true),
                'date_perbaikan' => date('Y/m/d H:i:s'),
                'update_at' => date('Y-m-d H:i:s'),
            ];

            $id = $this->input->post('id', true);

            // Update data berdasarkan id_damage
            $this->db->where('id_damage', $id);
            $this->db->update('printer_damage', $data);

            $this->session->set_flashdata('notifSuccess', 'Data Updated Successfully');

            // Redirect kembali ke halaman damage
            redirect('damage');
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
