<?php

class PrinterPembelian_Model extends CI_Model
{
	public function read_data()
	{
		return $this->db->select('printer_pembelian.*, printer_backup.printer_sn, type_printer.name_type')->from('printer_pembelian')->join('printer_backup', 'printer_backup.id_printer = printer_pembelian.id_printer')->join('type_printer', 'printer_backup.id_type = type_printer.id_type')->order_by('date_out', 'DESC')->get()->result();
	}

	public function read_data_damage()
	{
		return $this->db->select('printer_pembelian.*, printer_backup.printer_sn, type_printer.name_type')->from('printer_pembelian')->join('printer_backup', 'printer_backup.id_printer = printer_pembelian.id_printer')->join('type_printer', 'printer_backup.id_type = type_printer.id_type')->where('printer_pembelian.status', null)->get()->result();
	}

	public function read_data_by_damage()
	{
		return $this->db->select('printer_pembelian.*, printer_backup.printer_sn, type_printer.name_type')->from('printer_pembelian')->join('printer_backup', 'printer_backup.id_printer = printer_pembelian.id_printer')->join('type_printer', 'printer_backup.id_type = type_printer.id_type')->where('printer_pembelian.status !=', null)->get()->result();
		// return $this->db->where('status !=', null)->get('printer_pembelian')->result();
	}

	public function insert()
	{
		$form_backup = [
			'printer_sn' => $this->input->post('printer_sn'),
			'id_type' => $this->input->post('type_printer'),
			'origin' => 'BANDUNG',
			'date_in' => date('d/m/Y H:i:s'),
			'status' => 'BUYING',
		];
		$this->db->insert('printer_backup', $form_backup);

		$id_backup = $this->db->insert_id();
		$customer = $this->db->where('id_cust', $this->input->post('customer'))->get('customers')->row();

		$form = [
			'id_printer'	=> $id_backup,
			'cust_id'		=> $customer->cust_id,
			'cust_name'		=> $customer->cust_name,
			'date_out'		=> date('d/m/Y H:i:s'),
			'pic_it'		=> strtoupper($this->input->post('picit')),
			'pic_user'		=> strtoupper($this->input->post('picuser')),
		];
		$this->db->insert('printer_pembelian', $form);
	}

	public function damage()
	{
		$form_backup ['status'] = 'TEMPORARY REPLACEMENT';
		$this->db->where('printer_sn', $this->input->post('printer_sn_temp'));
		$this->db->update('printer_backup', $form_backup);

		if ($this->input->post('picit') != null) {
			$sn_temporary = strtoupper($this->input->post('picit'));
		} else {
			$sn_temporary = 'Tanpa Backup';
		}

		$form_pemb = [
			'status'	=> 'PERBAIKAN',
			'sn_temporary'	=> $this->input->post('printer_sn_temp'),
			'pic_it_perbaikan' => $sn_temporary,
			'pic_user_perbaikan' => strtoupper($this->input->post('picuser')),
		];
		$this->db->where('id_printer_pembelian', $this->input->post('id_pembelian'));
		$this->db->update('printer_pembelian', $form_pemb);

		$data_pembelian = $this->db->get_where('printer_pembelian', ['id_printer_pembelian' => $this->input->post('id_pembelian')])->row();

		// customer
		$cust = $this->db->get_where('customers', ['cust_name' => $data_pembelian->cust_name])->row();
		// printer

		$form_damage = [
			'id_printer' => $data_pembelian->id_printer,
			'id_cust' => $cust->id_cust,
			'date_in' => date('d/m/Y H:i:s'),
			'kelengkapan' => '-',
			'deskripsi' => $this->input->post('deskripsi'),
			'status' => 'PEMBELIAN',
		];
		$this->db->insert('printer_damage', $form_damage);
	}

	public function set_default_backup()
	{
		if ($this->input->post('sn_backup') != null) {

			if ($this->input->post('condition') == 'BARU') {

				$form = [
					'status'	=> null,
					'sn_temporary' => null,
					'pic_it_perbaikan' => null,
					'pic_user_perbaikan' => null,
				];
				$this->db->where('sn_temporary', $this->input->post('sn_backup'));
				$this->db->update('printer_pembelian', $form);
				
				$this->db->delete('printer_damage', ['id_printer' => $this->input->post('id_printer')]);

				$status['status'] = 'READY';
				$this->db->where('printer_sn', $this->input->post('sn_backup'));
				$this->db->update('printer_backup', $status);

			} else {

				$form = [
					'status'	=> null,
					'sn_temporary' => null,
					'pic_it_perbaikan' => null,
					'pic_user_perbaikan' => null,
				];
				$this->db->where('sn_temporary', $this->input->post('sn_backup'));
				$this->db->update('printer_pembelian', $form);

				$status['status'] = 'DAMAGE';
				$this->db->where('printer_sn', $this->input->post('sn_backup'));
				$this->db->update('printer_backup', $status);

				$cust = $this->db->where('cust_id', $this->input->post('cust_id'))->get('customers')->row();
				$printer = $this->db->where('printer_sn', $this->input->post('sn_backup'))->get('printer_backup')->row();

				// menyatukan array
				$kelengkapan = $this->input->post('kelengkapan');
				$kelengkapan = implode(', ', $kelengkapan);

				$form_dam = [
					'id_printer'	=> 	$printer->id_printer,
					'id_cust'		=> 	$cust->id_cust,
					'date_in'		=> date('d/m/Y H:i:s'),
					'kelengkapan'	=> $kelengkapan,
					'deskripsi'		=> strtoupper($this->input->post('deskripsi')),
				];
				$this->db->insert('printer_damage', $form_dam);

				$this->db->delete('printer_damage', ['id_printer' => $this->input->post('id_printer')]);
			}

		} else {
			$form = [
				'status'	=> null,
				'sn_temporary' => null,
				'pic_it_perbaikan' => null,
				'pic_user_perbaikan' => null,
			];
			$this->db->where('id_printer_pembelian', $this->input->post('id_pembelian'));
			$this->db->update('printer_pembelian', $form);

			$this->db->delete('printer_damage', ['id_printer' => $this->input->post('id_printer')]);
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
