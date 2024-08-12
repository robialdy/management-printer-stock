<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PrinterReplacement extends CI_Controller
{
	//dibawah ini hmm ngubah tanda aja biar ga merah hehe
	public $PrinterReplacement_Model, $PrinterBackup_Model, $Agen_Model, $form_validation, $session;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->load->model('PrinterReplacement_Model');
		$this->load->model('PrinterBackup_Model');
		$this->load->model('Agen_Model');
	}

	public function index()
	{
		$data = [
			'title'			=> 'Printer Replacement',
			'replacement'	=> $this->PrinterReplacement_Model->readData(),
			'printer'		=> $this->PrinterBackup_Model->readData(),
			'agen'			=> $this->Agen_Model->readData(),
			'jumPrinter'	=> $this->PrinterBackup_Model->jumlahData(),
			'jumReplacement'=> $this->PrinterReplacement_Model->jumlahData(),
		];

		$this->load->view('printerReplacement/printer_replacement', $data);
	}

	public function insert()
	{
		// tangkap inputnya
		$printer_sn = $this->input->post('printersn');
		$agen_name = $this->input->post('agenname');
		$pic_it = $this->input->post('picit');
		$pic_user = $this->input->post('picuser');
		$no_ref = $this->PrinterReplacement_Model->autoInvoice();
		$date_out = date('d/m/Y');

		$take_kelengkapan = $this->input->post('kelengkapan');
		$kelengkapan = implode(', ', $take_kelengkapan);

		//simpan data si session
		$this->session->set_userdata('printersn', $printer_sn);
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
				$this->session->set_flashdata('notifSuccess', 'Replacement Successfuly!');
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

		$this->session->set_flashdata('notifSuccess', 'Replacement Successfuly!');
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

		//send to damage
		$this->PrinterReplacement_Model->insertToDamage();


		//send new replacement to replacement
		$this->PrinterReplacement_Model->insertNeww($printer_sn, $agen_name, $pic_it, $pic_user, $no_ref, $date_out, $kelengkapan);

		$this->session->set_flashdata('notifSuccess', 'Replacement Successfuly!');
		redirect('replacement');
	}

}
