<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PrinterReplacement extends CI_Controller
{
	//dibawah ini hmm ngubah tanda aja biar ga merah hehe
	public $PrinterReplacement_Model, $PrinterBackup_Model, $Customers_Model, $form_validation, $session, $data_user;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->load->model('PrinterReplacement_Model');
		$this->load->model('PrinterBackup_Model');
		
		$this->load->model('Customers_Model');
		$this->data_user = $this->db->get_where('users', ['username' => $this->session->userdata('data_user')])->row_array();
	}

	public function index()
	{
		$data = [
			'title'			=> 'Printer Replacement',
			'replacement'	=> $this->PrinterReplacement_Model->readData(),
			'printer'		=> $this->PrinterBackup_Model->readData(),
			'agen'			=> $this->Customers_Model->readData(),
			'jumPrinter'	=> $this->PrinterBackup_Model->jumlahData(),
			'jumReplacement'=> $this->PrinterReplacement_Model->jumlahData(),
			'data_user'		=> $this->data_user,
			'dateTimeP'		=> $this->PrinterReplacement_Model->dateTime(),
			'dateTimeB'		=> $this->PrinterBackup_Model->dateTime(),
		];

		$this->load->view('printerReplacement/printer_replacement', $data);
	}

	public function insert()
	{
		// tangkap inputnya
		$printer_sn = $this->input->post('printersn', true);
		$agen_name = $this->input->post('agenname', true);
		$pic_it = $this->input->post('picit', true);
		$pic_user = $this->input->post('picuser', true);
		$no_ref = $this->PrinterReplacement_Model->autoInvoice();
		$date_out = date('d/m/Y / H:i:s');

		$take_kelengkapan = $this->input->post('kelengkapan', true);
		$kelengkapan = implode(', ', $take_kelengkapan);

		//simpan data si session
		$this->session->set_userdata('printersn', $printer_sn); //id_printer
		$this->session->set_userdata('agenname', $agen_name);
		$this->session->set_userdata('picit', $pic_it);
		$this->session->set_userdata('picuser', $pic_user);
		$this->session->set_userdata('noref', $no_ref);
		$this->session->set_userdata('dateout', $date_out);
		$this->session->set_userdata('kelengkapan', $kelengkapan);

		$query = $this->PrinterReplacement_Model->modalSelectJoin();
		
		if ($query->num_rows() > 0 ){

			$printerselect = $query->result();
			$this->session->set_flashdata('printerselect', $printerselect);
			redirect('replacement');

		} else {
			
			$this->form_validation->set_rules('printersn', 'PRINTER SN', 'required|trim');
			$this->form_validation->set_rules('agenname', 'AGEN NAME', 'required|trim');
			$this->form_validation->set_rules('picit', 'PIC IT', 'required|trim');
			$this->form_validation->set_rules('picuser', 'PIC USER', 'required|trim');
			// $this->form_validation->set_rules('kelengkapan', 'PRINTER SN', 'required|trim');
			if ($this->form_validation->run() == FALSE) {
				redirect('replacement');
			} else {
				$this->PrinterReplacement_Model->insertData();
				$prin_sn = $this->PrinterReplacement_Model->printer_sn($printer_sn);
				$this->session->set_flashdata('notifSuccess', $prin_sn);
				redirect('replacement');
			}
		}
	}

	public function insertNew()
	{

		$printer_sn = $this->session->userdata('printersn');
		$agen_name = $this->session->userdata('agenname');
		$pic_it = $this->session->userdata('picit');
		$pic_user = $this->session->userdata('picuser');
		$no_ref = $this->session->userdata('noref');
		$date_out = $this->session->userdata('dateout');
		$kelengkapan = $this->session->userdata('kelengkapan');

		$this->PrinterReplacement_Model->insertNew($printer_sn, $agen_name, $pic_it, $pic_user, $no_ref, $date_out, $kelengkapan);

		$prin_sn = $this->PrinterReplacement_Model->printer_sn($printer_sn);
		$this->session->set_flashdata('notifSuccess', $prin_sn);
		redirect('replacement');
	}

	public function insertWithDamage()
	{

		$printer_sn = $this->session->userdata('printersn');
		$agen_name = $this->session->userdata('agenname');
		$pic_it = $this->session->userdata('picit');
		$pic_user = $this->session->userdata('picuser');
		$no_ref = $this->session->userdata('noref');
		$date_out = $this->session->userdata('dateout');
		$kelengkapan = $this->session->userdata('kelengkapan');

		$this->db->delete('printer_replacement', ['id_replacement' => $this->input->post('idreplacement')]);

		//send to damage (!have bug)
		$this->PrinterReplacement_Model->insertToDamage();


		//send new replacement to replacement
		$this->PrinterReplacement_Model->insertNeww($printer_sn, $agen_name, $pic_it, $pic_user, $no_ref, $date_out, $kelengkapan);

		$prin_sn = $this->PrinterReplacement_Model->printer_sn($printer_sn);
		$this->session->set_flashdata('notifSuccess', $prin_sn);
		redirect('replacement');
	}

}
