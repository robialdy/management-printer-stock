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
			'cust'			=> $this->Customers_Model->readData(), //ada bug
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

		$query = $this->PrinterReplacement_Model->modalSelectJoin();
		
		if ($query->num_rows() > 0 ){

			// tangkap inputnya
			$printer_sn = $this->input->post('printersn', true); //idprinter
			$agen_name = $this->input->post('agenname', true);
			$pic_it = $this->input->post('picit', true);
			$pic_user = $this->input->post('picuser', true);
			$no_ref = $this->PrinterReplacement_Model->autoInvoice();
			$date_out = date('d/m/Y H:i:s');

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
				$this->session->set_flashdata('notifSuccess', 'Printer SN ' . $this->input->post('printersn', true) . ' Berhasil Ditambahkan!');
				redirect('replacement');
			}
		}
	}

	public function insertNew()
	{

		$printer_sn = $this->session->userdata('printersn'); //idprinter
		$agen_name = $this->session->userdata('agenname'); //idcust
		$pic_it = $this->session->userdata('picit');
		$pic_user = $this->session->userdata('picuser');
		$no_ref = $this->session->userdata('noref');
		$date_out = $this->session->userdata('dateout');
		$kelengkapan = $this->session->userdata('kelengkapan');

		$sn_lama = $this->input->post('printersn', true);
		$this->PrinterReplacement_Model->insertNew($printer_sn, $agen_name, $pic_it, $pic_user, $no_ref, $date_out, $kelengkapan, $sn_lama);

		$this->session->set_flashdata('notifSuccess', "Printer SN $printer_sn Berhasil Ditambahkan!");
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

		$this->db->delete('printer_replacement', ['id_replacement' => $this->input->post('idreplacement', true)]);

		// //ini apa eyy lupa 
		// $idprinter = $this->input->post('idprinter');
		// $this->db->select('printer_sn');
		// $this->db->where('id_printer', $idprinter);
		// $prin_sn = $this->db->get('printer_backup');

		//send to damage
		$this->PrinterReplacement_Model->insertToDamage();
		
		//send ke replacement
		$sn_lama = $this->input->post('printersn', true);
		$this->PrinterReplacement_Model->insertNew($printer_sn, $agen_name, $pic_it, $pic_user, $no_ref, $date_out, $kelengkapan, $sn_lama);

		$this->session->set_flashdata('notifSuccess', "Printer SN $sn_lama Berhasil Ditukar!");
		redirect('replacement');
	}


	//kirim damage saja
	public function insertDamage()
	{
		
		// mengupdate status sn damage di replacement
		$idreplacement = $this->input->post('idreplacement2', true);
		$printersn = $this->input->post('printersn', true);


		$form_data ['sn_damage'] = $printersn;
		$this->db->where('id_replacement', $idreplacement);
		$this->db->update('printer_replacement', $form_data);


		//delete data sebelumnya
		$this->db->delete('printer_replacement', ['id_replacement' => $this->input->post('idreplacement', true)]);

		//mengiriim data ke damage
		$this->PrinterReplacement_Model->insertToDamage();


		$this->session->set_flashdata('notifSuccess', 'Printer Berhasil ditambahkan di SN Damage');
		// Redirect setelah operasi selesai
		redirect('replacement');
	}

	//menampilkan list printer di modal edit
	public function show_row_printer()
	{
		$this->load->helper('time_ago');

		$custId = $this->input->post('custID', true);
		$sn_damage = $this->input->post('snDamage', true);
		$idRep = $this->input->post('idRep', true);

		$printers = $this->PrinterReplacement_Model->get_printer_by_id($custId, $idRep, $sn_damage);


		$html = '';

		if (!empty($printers)) {

		// Loop data printer dan buat string HTML
		foreach ($printers as $printer) {

			$time_ago = time_ago($printer->created_at);

			$html .= '
			<form method="POST" action="'.site_url('printerreplacement/insertDamage'). '">
			<input type="hidden" name="idreplacement2" value="">
				<div class="card mb-3 mx-2">
					<div class="d-flex align-items-center p-3 border-radius-md">
						<span class="avatar text-bg-info avatar-lg fs-5">
							<i class="bi bi-printer"></i>
						</span>
						<div class="ms-3">
    						<h6 class="mb-0 fs-sm">Printer SN '. $printer->printer_sn .'</h6>
    						<small class="text-muted fs-sm d-flex align-items-center">
        						<i class="material-icons text-sm me-1">schedule</i>
        						<span>'. $time_ago .'</span>
    						</small>
						</div>


						<input type="hidden" name="idreplacement" value="' . $printer->id_replacement . '">
						<input type="hidden" name="printersn" value="' . $printer->printer_sn . '">
						<input type="hidden" name="idprinter" value="' . $printer->id_printer . '">
						<input type="hidden" name="idcust" value="' . $printer->id_cust . '">
						<button type="submit" class="btn text-muted fs-3 ms-auto my-auto" type="button">
						<i class="bi bi-plus-lg"></i>
						</button>
					</div>
				</div>
			</form>
			';
		}
	} else {
		$html .= '
				<div class="card mb-3 mx-2 mt-1">
						<div class="ms-3 text-center" style="cursor: context-menu;">
							<h6 class="mb-0 fs-sm p-3">Empty to Changes</h6>
						</div>
				</div>
		';
	};

		echo $html;
	}


}
