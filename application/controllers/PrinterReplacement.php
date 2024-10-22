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
			$no_ref = $this->PrinterList_Model->autoInvoice();

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

		// delete list
		$this->db->delete('printer_list_inagen', ['id_printer' => $this->input->post('idprinter', true)]);
		// delete summary
		$this->db->delete('printer_summary', ['id_printer' => $this->input->post('idprinter', true)]);

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

		// update status trans
		$form_data_status['status_transaksi'] = 'NEW';
		$this->db->where('id_printer_list', $this->input->post('_id_list'));
		$this->db->update('printer_list_inagen', $form_data_status);


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
                	data-bs-target="#modaldamageselect"
                	data-id="' . $al->id_cust . '"
                	data-idlist="' . $al->id_printer_list . '"
                	data-idreplacement="' . $al->id_replacement . '"
                	data-sndamage="' . $al->sn_damage . '"
					data-prinsn="'. $al->printer_sn .'">
                <i class="material-icons">edit</i>
            	</a>
			</td>
        </tr>';
		}

		header('Content-Type: application/json');
		echo json_encode(['html' => $html]);
	}

	//menampilkan list printer di modal edit
	public function modal_damage_select()
	{
		$this->load->helper('time_ago');

		$custId = $this->input->post('custID', true);
		$sn_damage = $this->input->post('snDamage', true);
		$id_list = $this->input->post('id_list', true);
		$id_rep = $this->input->post('idRep', true);
		// printer sn label
		$prinsn = $this->input->post('prinSn');


		$printers = $this->PrinterReplacement_Model->get_printer_by_id($custId, $id_list, $sn_damage);

		$html = '';

		if (!empty($printers)) {
			$html .= '
        <div class="modal fade" id="modaldamageselect" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="text-end me-1">
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="text-start ms-3">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">SN DAMAGE</h5>
                        <small>Pilih Untuk Menambahkan SN Damage</small> <br>
                    </div>
                    <div class="modal-body">
                        <small>~ Printer SN '. $prinsn .'</small>
                        <div class="overflow-auto" style="max-height: 600px">
        ';

			foreach ($printers as $printer) {

				// Cek apakah date_out kosong atau tidak
				if (empty($printer->date_out)) {
					$time_ago = 'null'; // Set tulisan "null" jika date_out kosong
				} else {
					$time_ago = time_ago($printer->date_out); // Panggil fungsi time_ago jika date_out tidak kosong
				}

				$html .= '
            <form method="POST" action="' . site_url('printerreplacement/insertDamage') . '">
                <div class="card mb-3 mx-2">
                    <div class="d-flex align-items-center p-3 border-radius-md">
                        <span class="avatar text-bg-info avatar-lg fs-5">
                            <i class="bi bi-printer"></i>
                        </span>
                        <div class="ms-3">
                            <h6 class="mb-0 fs-sm">Printer SN ' . $printer->printer_sn . '</h6>
                            <small class="text-muted fs-sm d-flex align-items-center">
                                <i class="material-icons text-sm me-1">schedule</i>
                                <span>' . $time_ago . '</span>
                            </small>
                        </div>

                        <input type="hidden" name="idreplacement" value="' . $id_rep . '">
                        <input type="hidden" name="printersn" value="' . $printer->printer_sn . '">
                        <input type="hidden" name="idlist" value="' . $printer->id_printer_list . '">
                        <input type="hidden" name="idprinter" value="' . $printer->id_printer . '">
                        <input type="hidden" name="idcust" value="' . $printer->id_cust . '">
                        <input type="hidden" name="_id_list" value="' . $id_list . '">

                        <button type="button" class="btn text-muted fs-3 ms-auto my-auto" data-bs-toggle="collapse" data-bs-target="#collapse-'. $printer->id_printer_list . '">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
					<div class="collapse" id="collapse-'. $printer->id_printer_list .'">
								<div class="card card-body">

									<div class="row mb-2">
										<div class="col-3 mt-2">
											<label for="typep">DESKRIPSI:</label>
										</div>
										<div class="col">
											<div class="input-group input-group-dynamic mb-4">
												<input type="text" class="form-control" aria-label="Username" placeholder="Enter Deskripsi kerusakan" id="typep" name="deskripsi" style="text-transform: uppercase;" required>
											</div>
										</div>
									</div>

									<div class="row mb-1">
										<div class="form-check col">
											<input class="childCheckbox" type="checkbox" name="kelengkapan_ker[]" id="dus" value="DUS">
											<label class="form-check-label" for="dus">
												DUS
											</label>
										</div>
										<div class="form-check col">
											<input class="childCheckbox" type="checkbox" name="kelengkapan_ker[]" id="usb" value="KABEL USB">
											<label class="form-check-label" for="usb">
												KABEL USB
											</label>
										</div>
									</div>

									<div class="row mb-1">
										<div class="form-check col">
											<input class="childCheckbox" type="checkbox" name="kelengkapan_ker[]" id="corelabel" value="CORE LABEL 1">
											<label class="form-check-label" for="corelabel">
												CORE LABEL 1
											</label>
										</div>
										<div class="form-check col">
											<input class="childCheckbox" type="checkbox" name="kelengkapan_ker[]" id="adaptor" value="ADAPTOR">
											<label class="form-check-label" for="adaptor">
												ADAPTOR
											</label>
										</div>
									</div>

									<div class="row mb-1">
										<div class="form-check col">
											<input class="childCheckbox" type="checkbox" name="kelengkapan_ker[]" id="coreribbon" value="CORE RIBBON 2">
											<label class="form-check-label" for="coreribbon">
												CORE RIBBON 2
											</label>
										</div>
										<div class="form-check col">
											<input class="childCheckbox" type="checkbox" name="kelengkapan_ker[]" id="kuping" value="KUPING CORE 2">
											<label class="form-check-label" for="kuping">
												KUPING CORE 2
											</label>
										</div>
									</div>

									<div class="row mb-1">
										<div class="form-check col">
											<input class="childCheckbox" type="checkbox" name="kelengkapan_ker[]" id="power" value="KABEL POWER">
											<label class="form-check-label" for="power">
												KABEL POWER
											</label>
										</div>
									</div>

									<div class="row justify-content-center mt-2">
										<small class="col-auto text-danger" style="font-size: 0.75rem;">
											Kelengkapan Kerusakan, Kosongkan Jika Tidak Perlu
										</small>
									</div>

									<!-- Submit button -->
									<button type="submit" class="btn btn-info shadow mt-2">Submit</button>
								</div>
							</div>
                </div>
            </form>
            ';
			}

			$html .= '
                        </div>
                    </div>
                </div>
            </div>
        </div>';
		} else {
			// Jika tidak ada printer, tampilkan pesan empty
			$html .= '
        <div class="modal fade" id="modaldamageselect" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="text-end me-1">
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="text-start ms-3">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">SN DAMAGE</h5>
                        <small>Pilih Untuk Menambahkan SN Damage</small> <br>
                    </div>
                    <div class="modal-body">
                        <div class="card mb-3 mx-2 mt-1">
                            <div class="ms-3 text-center" style="cursor: context-menu;">
                                <h6 class="mb-0 fs-sm p-3">Empty to Changes</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
		}

		echo $html;
	}





}
