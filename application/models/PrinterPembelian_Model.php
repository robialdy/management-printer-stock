<?php

class PrinterPembelian_Model extends CI_Model
{
	public function read_data()
	{
		return $this->db->order_by('date_out', 'DESC')->get('printer_pembelian')->result();
	}

	public function read_data_damage()
	{
		return $this->db->where('status', null)->get('printer_pembelian')->result();
	}

	public function read_data_by_damage()
	{
		return $this->db->where('status !=', null)->get('printer_pembelian')->result();
	}

	public function insert()
	{
		$customer = $this->db->where('id_cust', $this->input->post('customer', true))->get('customers')->row();

		$form = [
			'type_printer'	=> $this->input->post('type_printer', true),
			'printer_sn'	=> $this->input->post('printer_sn', true),
			'cust_id'		=> $customer->cust_id,
			'cust_name'		=> $customer->cust_name,
			'origin_name'	=> $customer->origin_name,
			'type_cust'		=> $customer->type_cust,
			'date_out'		=> date('d/m/Y H:i:s'),
			'pic_it'		=> strtoupper($this->input->post('picit', true)),
			'pic_user'		=> strtoupper($this->input->post('picuser', true)),
		];
		$this->db->insert('printer_pembelian', $form);
	}

	public function damage()
	{

		$form_pemb = [
			'status'	=> 'PERBAIKAN',
			'sn_temporary'	=> $this->input->post('printer_sn_temp', true),
			'pic_it_perbaikan' => strtoupper($this->input->post('picit', true)),
			'pic_user_perbaikan' => strtoupper($this->input->post('picuser', true)),
		];
		$this->db->where('id_printer_pembelian', $this->input->post('id_pembelian', true));
		$this->db->update('printer_pembelian', $form_pemb);

		$status['status'] = 'BORROWED BY BUYER';
		$this->db->where('printer_sn', $this->input->post('printer_sn_temp', true));
		$this->db->update('printer_backup', $status);

		// buat keperluan nyari data di tabel pembeliannya
		$data_pem = $this->db->get_where('printer_pembelian', ['id_printer_pembelian' => $this->input->post('id_pembelian', true)])->row();


		$form_damage = [
			'type_printer'	=> $data_pem->type_printer,
			'printer_sn'	=> $data_pem->printer_sn,
			'origin'		=> $data_pem->origin_name,
			'type_cust'		=> $data_pem->type_cust,
			'cust_id'		=> $data_pem->cust_id,
			'cust_name'		=> $data_pem->cust_name,
			'date_in' => date('d/m/Y H:i:s'),
			'kelengkapan' => '-',
			'deskripsi' => $this->input->post('deskripsi', true),
			'status' => 'PEMBELIAN',
		];
		$this->db->insert('printer_damage', $form_damage);


	}

	public function set_default_backup()
	{
		if ($this->input->post('sn_backup', true) != null) {

			if ($this->input->post('condition', true) == 'BAGUS') {

				$form = [
					'status'	=> null,
					'sn_temporary' => null,
					'pic_it_perbaikan' => null,
					'pic_user_perbaikan' => null,
				];
				$this->db->where('sn_temporary', $this->input->post('sn_backup', true));
				$this->db->update('printer_pembelian', $form);

				$status['status'] = 'READY';
				$this->db->where('printer_sn', $this->input->post('sn_backup', true));
				$this->db->update('printer_backup', $status);

				$this->db->delete('printer_damage', ['printer_sn' => $this->input->post('printersn', true)]);
			} else {
				$status['status'] = 'DAMAGE';
				$this->db->where('printer_sn', $this->input->post('sn_backup', true));
				$this->db->update('printer_backup', $status);

				// masuk pembelian
				$data_pembelian = $this->db->get_where('printer_pembelian', ['id_printer_pembelian' => $this->input->post('id_pem', true)])->row();

				// masuk prnter_backup
				$printer_backup = $this->db->select('printer_sn, name_type')->from('printer_backup')->join('type_printer', 'printer_backup.id_type = type_printer.id_type')->where('printer_backup.printer_sn', $this->input->post('sn_backup', true))->get()->row();

				// menyatukan array
				$kelengkapan = $this->input->post('kelengkapan', true);
				$kelengkapan = implode(', ', $kelengkapan);

				$form_damage = [
					'type_printer'	=> $printer_backup->name_type,
					'printer_sn'	=> $printer_backup->printer_sn,
					'origin'		=> $data_pembelian->origin_name,
					'type_cust'		=> $data_pembelian->type_cust,
					'cust_id'		=> $data_pembelian->cust_id,
					'cust_name'		=> $data_pembelian->cust_name,
					'date_in'		=> date('d/m/Y H:i:s'), //sama kaya yang di log
					'kelengkapan'	=> $kelengkapan,
					'deskripsi'		=> strtoupper($this->input->post('deskripsi', true)),
				];
				$this->db->insert('printer_damage', $form_damage);

				// update log
				$form_log = [
					'cust_id' => $data_pembelian->cust_id,
					'cust_name' => $data_pembelian->cust_name,
					'status'	=> 'IN DAMAGE',
					'date_out'	=> '-',
					'returned'	=> date('d/m/Y H:i:s'),
				];
				$this->db->where('printer_sn', $printer_backup->printer_sn);
				$this->db->where('status', 'IN BACKUP'); //SEMENTARA
				$this->db->update('printer_log', $form_log);


				$form = [
					'status'	=> null,
					'sn_temporary' => null,
					'pic_it_perbaikan' => null,
					'pic_user_perbaikan' => null,
				];
				$this->db->where('sn_temporary', $this->input->post('sn_backup', true));
				$this->db->update('printer_pembelian', $form);


				$this->db->delete('printer_damage', ['printer_sn' => $this->input->post('printersn', true)]);
			}
		} else {
			$form = [
				'status'	=> null,
				'sn_temporary' => null,
				'pic_it_perbaikan' => null,
				'pic_user_perbaikan' => null,
			];
			$this->db->where('id_printer_pembelian', $this->input->post('id_pembelian', true));
			$this->db->update('printer_pembelian', $form);

			$this->db->delete('printer_damage', ['printer_sn' => $this->input->post('printersn', true)]);
		}
	}

	public function getPrinterById($id)
	{
		return $this->db->where('id_printer_pembelian', $id)->get('printer_pembelian')->row();
	}

	public function sum_data()
	{
		return $this->db->count_all_results('printer_pembelian');
	}

	public function dateTime()
	{
		$this->db->order_by('date_out', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('printer_pembelian');
		return $query->row();
	}
}
