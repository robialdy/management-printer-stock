<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PrinterLog extends CI_Controller
{
	public $data_user, $Auth_Model;
	public function __construct()
{
		parent::__construct();
		if (!$this->session->userdata('data_user')) {
			redirect('auth');
		};
		$this->data_user = $this->db->get_where('users', ['username' => $this->session->userdata('data_user')])->row_array();
		$this->load->model('Printer_Log_Model');
	}

	public function index()
	{
		$data = [
			'title'		=> 'Printer Log',
			'data_user'	=> $this->data_user,
		];
		$this->load->view('printer_log/printer_log', $data);
	}

	public function view_data_table()
	{
		$data = $this->Printer_Log_Model->read_data_group();

		$html = '';
		$i = 1;
		foreach ($data as $al) {
			$html .= '
			<tr>
				<td class="text-center text-uppercase">
					<h6 class="mb-0 text-lg fw-normal">' . $i++ . '</h6>
				</td>
				<td class="text-center text-uppercase">
					<h6 class="mb-0 text-lg fw-normal">' . $al->printer_sn . '</h6>
				</td>
				<td class="text-center text-uppercase">
					<h6 class="mb-0 text-lg fw-normal">';
			if ($al->status != '-') {
				$html .= '<span class="badge badge-' . ($al->status == 'IN DAMAGE' ? 'danger' : ($al->status == 'IN CUSTOMER' ? 'warning' : 'success')) . '">' . $al->status . '</span>';
			} else {
				$html .= $al->status;
			}
			$html .= '</h6>
				</td>
				<td class="text-center text-uppercase">
					<a class="mb-0 text-md fw-normal btn-detail" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#detail" data-modal="' . $al->printer_sn . '">
						<i class="material-icons">assignment</i>
					</a>
				</td>
			</tr>
		';
		}

		header('Content-Type: application/json');
		echo json_encode(['html' => $html]);
	}

	public function modal_detail()
	{
		$printer_sn = $this->input->post('modal');
		$data = $this->Printer_Log_Model->read_data($printer_sn);

			$html = '
        <div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="text-end me-1">
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="text-start ms-3">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">History Printer SN</h5>
                        <small>Detail Tentang Printer, Pernah Digunakan Siapa Saja</small>';

			// Ambil data pertama untuk mendapatkan printer_sn
			$html .= '<h5 class="font-weight-normal text-info text-gradient mt-2">SN ' . $data[0]->printer_sn . '</h5>
                    </div>
                    <div class="modal-body">
                        <div class="timeline timeline-one-side" data-timeline-axis-style="dotted">
        ';

			// Looping untuk setiap log printer
			foreach ($data as $log_detail) {
				$html .= '
            <div class="timeline-block mb-3">
                <span class="timeline-step bg-dark p-3 d-flex justify-content-center align-items-center">
                    <i class="material-icons text-white text-sm opacity-10">print</i>
                </span>
                <div class="timeline-content pt-1">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">' . $log_detail->cust_name;

				if ($log_detail->status != '-') {
					$html .= '<span class="badge badge-' . ($log_detail->status == 'IN DAMAGE' ? 'danger' : ($log_detail->status == 'IN CUSTOMER' ? 'warning' : 'success')) . '">' . $log_detail->status . '</span>';
				}

				$html .= '
                    </h6>
                    <p class="text-secondary text-xs mb-0">' . $log_detail->cust_id . '</p>
                    <p class="text-sm text-dark mt-3 mb-2">
                        Printer Diterima Cust Tanggal <span class="fw-bold">' . $log_detail->date_out . '</span> Dan Printer Di Return Pada Tanggal <span class="fw-bold">' . $log_detail->returned . '</span>
                    </p>
                </div>
            </div>
            ';
			}

			$html .= '
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ';

			echo $html;
		}
	}




