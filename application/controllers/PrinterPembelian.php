<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PrinterPembelian extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->load->model('PrinterPembelian_Model');
		$this->load->model('Customers_Model');
		$this->load->model('PrinterBackup_Model');
		$this->load->model('Type_printer_Model');
		$this->data_user = $this->db->get_where('users', ['username' => $this->session->userdata('data_user')])->row_array();
	}

	public function index()
	{

		$data = [
			'title'	=> 'Printer Pembelian',
			'data_user'	=> $this->data_user,
			'type_printers' => $this->Type_printer_Model->read_data(),
			'customers'	=> $this->Customers_Model->read_data_active(),
			'read_data_damage'	=> $this->PrinterPembelian_Model->read_data_damage(),
			'printer_pembelian'	=> $this->PrinterPembelian_Model->read_data(),
			'printer_backup'	=> $this->PrinterBackup_Model->read_data_backup(),
			'sum_data'	=> $this->PrinterPembelian_Model->sum_data(),
			'date_time'	=> $this->PrinterPembelian_Model->dateTime(),
		];
		$this->load->view('printerpembelian/printer_pembelian', $data);
	}

	public function insert()
	{
		$this->form_validation->set_rules('printer_sn', 'PRINTER SN', 'required|trim|is_unique[printer_backup.printer_sn]');
		$this->form_validation->set_rules('customer', 'CUSTOMER', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			redirect('printerpembelian');
		} else {
			$this->PrinterPembelian_Model->insert();
			$this->session->set_flashdata('notifSuccess', 'Berhasil! Menambah Data Pembelian');
			redirect('pembelian');
		}
	}

	public function damage()
	{
		$this->form_validation->set_rules('id_pembelian', 'PRINTER SN', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			redirect('printerpembelian');
		} else {
			$this->PrinterPembelian_Model->damage();
			$this->session->set_flashdata('notifSuccess', 'Printer Sekarang Dalam Proses Perbaikan!');
			redirect('pembelian');
		}
	}

	public function set_default_backup()
	{
		$this->PrinterPembelian_Model->set_default_backup();
		$this->session->set_flashdata('notifSuccess', 'Printer Telah Selesai Diperbaiki!');
		redirect('pembelian');
	}

	public function view_data_table()
	{
		$data = $this->PrinterPembelian_Model->read_data();

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
                <h6 class="mb-0 text-sm fw-normal">' . $al->cust_id . '</h6>
            </td>
            <td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal text-wrap">' . $al->cust_name . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->pic_it . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->pic_user . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->printer_sn . '</h6>
            </td>
			<td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->type_printer . '</h6>
            </td>
            <td class="text-center text-uppercase">
                <h6 class="mb-0 text-sm fw-normal">' . $al->date_out . '</h6>
            </td>
			<td class="text-center text-uppercase">';

				if ($al->status != null) {
					$html .= '
					<button type="button" class="btn btn-sm btn-outline-warning border-radius-xl mb-0 btn-perbaikan" data-modal="' . $al->id_printer_pembelian . '">
						Perbaikan
					</button>
					';
				}
            $html .= '</td>';

			$html .= '</tr>';
		}

		header('Content-Type: application/json');
		echo json_encode([
			'html' => $html,
			'token' => $this->security->get_csrf_hash(),
		]);
	}

	public function modal_perbaikan()
	{

		$idpem = $this->input->post('modal', true);
		$data = $this->PrinterPembelian_Model->getPrinterById($idpem);

		$html = '
	<div class="modal fade" id="perbaikan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="text-end me-1">
					<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">DETAIL PRINTER PERBAIKAN</h5>
					<small>SN PRINTER '. $data->printer_sn .'</small>
				</div>
				<div class="modal-body">
				<div class="mx-3">
					<small class="text-dark font-weight-bold">SN TEMPORARY</small>
                    <blockquote class="blockquote mb-0">
                        <p class="text-dark ms-2">'. ($data->sn_temporary == null ? 'TANPA SN BACKUP*' : $data->sn_temporary) . '</p>
                    </blockquote>
					<small class="text-dark font-weight-bold">PIC IT</small>
                    <blockquote class="blockquote mb-0">
                        <p class="text-dark ms-2">'. $data->pic_it_perbaikan . '</p>
                    </blockquote>
					<small class="text-dark font-weight-bold">PIC USERS</small>
                    <blockquote class="blockquote mb-0">
                        <p class="text-dark ms-2">'. $data->pic_user_perbaikan . '</p>
                    </blockquote>';

					if (!empty($data->sn_temporary)) {
						$html .= '<div class="text-end mt-2">
									<form action="' . site_url('printerpembelian/set_default_backup') . '" method="POST">
										<input type="hidden" name="' . $this->security->get_csrf_token_name() . '" value="' . $this->security->get_csrf_hash() . '">

										<input type="hidden" name="printersn" value="' . $data->printer_sn . '">
                        				<input type="hidden" name="id_pem" value="' . $data->id_printer_pembelian . '">
										<input type="hidden" name="sn_backup" value="' . $data->sn_temporary . '">
			
						<div class="row">
                            <div class="col-1 mt-2">
                                <label class="text-dark fs-6">KONDISI</label>
                            </div>
                            <div class="col mt-2">
                                <div class="row mb-1">
                                    <div class="form-check col">
                                        <input type="radio" name="condition" id="bagus" value="BAGUS" required>
                                        <label class="form-check-label" for="bagus">BAGUS</label>
                                    </div>
                                    <div class="form-check col">
                                        <input type="radio" name="condition" id="rusak" value="RUSAK">
                                        <label class="form-check-label" for="rusak">RUSAK</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="collapseSection" class="collapse">
                            <div class="row mb-2">
                                <div class="col-4 mt-2 text-start">
                                    <label for="typep">DESKRIPSI</label>
                                </div>
                                <div class="col">
                                    <div class="input-group input-group-dynamic mb-4">
                                        <input type="text" class="form-control" name="deskripsi" placeholder="Enter Deskripsi kerusakan" style="text-transform: uppercase;">
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="text-end mt-2">
                            <button type="submit" class="btn bg-gradient-info text-white border-radius-sm">SELESAI</button>
                        </div>
									</form>
								</div>
								
								<script>
        						document.querySelectorAll("input[name=\'condition\']").forEach(function(radio) {
            						radio.addEventListener("change", function() {
                						if (this.value === "RUSAK") {
                    						document.getElementById("collapseSection").classList.add("show");
                						} else {
                    						document.getElementById("collapseSection").classList.remove("show");
                						}
            						});
        						});
    						</script>
								';
					} else {
						$html .='<div class="text-end mt-2">
									<form action="'. site_url('printerpembelian/set_default_backup') .'" method="POST">
										<input type="hidden" name="' . $this->security->get_csrf_token_name() . '" value="' . $this->security->get_csrf_hash() . '">
			
										<input type="hidden" name="printersn" value="' . $data->printer_sn . '">
										<input type="hidden" name="id_pembelian" value="' . $data->id_printer_pembelian . '">
								
										<button type="submit" class="btn bg-gradient-info text-white border-radius-sm">SELESAI</button>
									</form>
								</div>';
					}

			$html .='</div>
				</div>
			</div>
		</div>
	</div>
		';

		header('Content-Type: application/json');
		echo json_encode([
			'html' => $html,
			'token' => $this->security->get_csrf_hash(),
		]);
	}
}
