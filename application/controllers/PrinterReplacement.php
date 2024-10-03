<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PrinterReplacement extends CI_Controller
{
	
	//dibawah ini hmm ngubah tanda aja biar ga merah hehe
	public $PrinterReplacement_Model, $PrinterBackup_Model, $Customers_Model, $form_validation, $session, $data_user, $PrinterList_Model;
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->load->model('PrinterReplacement_Model');
		$this->load->model('PrinterBackup_Model');
		$this->load->model('Customers_Model');
		$this->load->model('PrinterList_Model');
		$this->data_user = $this->db->get_where('users', ['username' => $this->session->userdata('data_user')])->row_array();
	}

	public function index()
	{
		$data = [
			'title'			=> 'Printer Replacement',
			'replacement'	=> $this->PrinterReplacement_Model->readData(),
			'printer'		=> $this->PrinterBackup_Model->read_data_backup(),
			'cust'			=> $this->PrinterList_Model->read_data_cust(), 
			'jumPrinter'	=> $this->PrinterBackup_Model->jumlahData(),
			'jumReplacement'=> $this->PrinterReplacement_Model->jumlahData(),
			'data_user'		=> $this->data_user,
			'dateTimeP'		=> $this->PrinterReplacement_Model->dateTime(),
			'dateTimeB'		=> $this->PrinterBackup_Model->dateTime(),
		];

		$this->load->view('printerReplacement/printer_replacement', $data);
	}

	// modal printer out
	public function insert()
	{

		
		// tangkap inputnya
			$printer_sn = $this->input->post('printersn', true); //idprinter
			$agen_name = $this->input->post('agenname', true);
			$pic_it = $this->input->post('picit', true);
			$pic_user = $this->input->post('picuser', true);
			$no_ref = $this->PrinterReplacement_Model->autoInvoice();

			$take_kelengkapan = $this->input->post('kelengkapan', true);
			$kelengkapan = implode(', ', $take_kelengkapan);

			//simpan data si session
			$this->session->set_userdata('printersn', $printer_sn); //id_printer
			$this->session->set_userdata('agenname', $agen_name);
			$this->session->set_userdata('picit', $pic_it);
			$this->session->set_userdata('picuser', $pic_user);
			$this->session->set_userdata('noref', $no_ref);
			$this->session->set_userdata('kelengkapan', $kelengkapan);
			
			// mengeluarkan modal
			$query = $this->PrinterReplacement_Model->modalSelectJoin();
			$printerselect = $query->result();

			$this->session->set_flashdata('printerselect', $printerselect);
			redirect('replacement');

	}


	// modal select printer
	public function insertWithDamage()
	{

		// penangan printer out
		$printer_sn = $this->session->userdata('printersn'); //idprinter
		$agen_name = $this->session->userdata('agenname');
		$pic_it = $this->session->userdata('picit');
		$pic_user = $this->session->userdata('picuser');
		$no_ref = $this->session->userdata('noref');
		$kelengkapan = $this->session->userdata('kelengkapan');


		$this->db->delete('printer_list_inagen', ['id_printer' => $this->input->post('idprinter', true)]);

		//send to damage
		$this->PrinterReplacement_Model->insertToDamage();
		
		//send ke replacement
		$sn_lama = $this->input->post('printersn', true);
		$this->PrinterReplacement_Model->insertNew($printer_sn, $agen_name, $pic_it, $pic_user, $no_ref, $kelengkapan, $sn_lama);

		$this->session->set_flashdata('notifSuccess', "Printer SN $sn_lama Berhasil Ditukar!");
		redirect('replacement');
	}


	//kirim damage saja
	public function insertDamage()
	{
		
		// mengupdate status sn damage di replacement
		$idreplacement = $this->input->post('idreplacement', true);
		$printersn = $this->input->post('printersn', true);
		
		$form_data ['sn_damage'] = $printersn;
		$this->db->where('id_replacement', $idreplacement);
		$this->db->update('printer_replacement', $form_data);


		//delete data sebelumnya udh include dua tabel karena master dari foreignkey nya di delete
		$this->db->delete('printer_list_inagen', ['id_printer_list' => $this->input->post('idlist', true)]);

		//mengiriim data ke damage
		$this->PrinterReplacement_Model->insertToDamage();


		$this->session->set_flashdata('notifSuccess', 'Printer Berhasil ditambahkan di SN Damage');
		redirect('replacement');
	}

	public function view_data_table()
	{
		$data = $this->PrinterReplacement_Model->readData();

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
                <h6 class="mb-0 text-sm fw-normal">' . $al->printer_sn_rep . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->cust_id . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->cust_name . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->type_cust . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->sn_damage . '</h6>
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
			<td class="text-center">
				<a href="' . site_url('printerdetail/' . $al->printer_sn) . '" class="mb-0 text-sm fw-normal">
					<i class="material-icons">assignment</i>
				</a>
			</td>
			<td>
				<a class="mb-0 text-sm fw-normal text-decoration-underline btn-edit" style="cursor: pointer;"
                	data-bs-toggle="modal"
                	data-bs-target="#modaldamageselect' . $al->id_replacement . '"
                	data-id="' . $al->id_cust . '"
                	data-idlist="' . $al->id_printer_list . '"
                	data-idreplacement="' . $al->id_replacement . '"
                	data-sndamage="' . $al->sn_damage . '">
                <i class="material-icons">edit</i>
            	</a>
			</td>
        </tr>';
		}

		header('Content-Type: application/json');
		echo json_encode(['html' => $html]);
	}

	//menampilkan list printer di modal edit
	public function show_row_printer()
	{
		$this->load->helper('time_ago');

		$custId = $this->input->post('custID', true);
		$sn_damage = $this->input->post('snDamage', true);
		$id_list = $this->input->post('id_list', true);
		$id_rep = $this->input->post('idRep', true);

		$printers = $this->PrinterReplacement_Model->get_printer_by_id($custId, $id_list, $sn_damage);

		$html = '';

		if (!empty($printers)) {

		// Loop data printer dan buat string HTML
		foreach ($printers as $printer) {

			$time_ago = time_ago($printer->date_out);

			$html .= '
			<form method="POST" action="'.site_url('printerreplacement/insertDamage'). '">
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


						<input type="hidden" name="idreplacement" value="' . $id_rep . '">
						<input type="hidden" name="printersn" value="' . $printer->printer_sn . '">
						<input type="hidden" name="idlist" value="' . $printer->id_printer_list . '">
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
