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

        // Load the PrinterDamage_Model model
        $this->load->model('PrinterDamage_Model');

        // Fetch and store user data from the session
        $this->data_user = $this->db->get_where('auth', [
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
            'timedate' => $this->PrinterDamage_Model->dateTime(),
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
                
            ];
            $id = $this->input->post('id');
    
            // Update data berdasarkan id_damage
            $this->db->where('id_damage', $id);
            $this->db->update('printer_damage', $data);
            
                $this->session->set_flashdata('notifSuccess', 'Data berhasil diperbarui.');
    
            // Redirect kembali ke halaman damage
            redirect('damage');
        }
    }
    

}
