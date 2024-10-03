<?php

class PrinterList_Model extends CI_Model
{
	// detail
	public function read_data()
	{
		$this->db->select('printer_list_inagen.*, customers.origin_name, printer_backup.date_in, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, customers.status, type_printer.name_type');
		$this->db->from('printer_list_inagen');
		$this->db->join('customers', 'printer_list_inagen.id_cust = customers.id_cust');
		$this->db->join('printer_backup', 'printer_list_inagen.id_printer = printer_backup.id_printer');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type'); // Join dari printer_backup ke type_printer
		$this->db->order_by('printer_list_inagen.created_at', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function read_data_detail($sn)
	{
		$this->db->select('customers.origin_name, printer_backup.date_in, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type, printer_list_inagen.*');
		$this->db->from('printer_list_inagen');
		$this->db->join('customers', 'printer_list_inagen.id_cust = customers.id_cust');
		$this->db->join('printer_backup', 'printer_list_inagen.id_printer = printer_backup.id_printer');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type'); // Join dari printer_backup ke type_printer 
		$this->db->where('printer_backup.printer_sn', $sn);
		$query = $this->db->get();
		return $query->row();
	}

	public function search_sn($id) // buat notif
	{
		return $this->db->select('printer_sn')->from('printer_backup')->where('id_printer', $id)->get()->row();
	}

	public function read_data_cust()
	{
		return $this->db->select('DISTINCT(customers.cust_name), customers.id_cust', false)
			->from('printer_list_inagen')
			->join('customers', 'printer_list_inagen.id_cust = customers.id_cust')
			->get()
			->result();
	}

	// SUMMARY
	public function read_data_summary()
	{

		$printer_types = $this->type_printer();
		// COUNT(printer_list_inagen.id_printer) as total_printers,
		$this->db->select('
        customers.cust_id, 
        customers.cust_name, 
        customers.type_cust,
		customers.origin_id, 
        customers.origin_name, 
        printer_backup.origin,
        printer_backup.date_in,
        type_printer.name_type,
		printer_list_inagen.*
    ');

		foreach ($printer_types as $type) {
			$name_type = str_replace('-', '_', $type->name_type);
			$this->db->select("SUM(CASE WHEN type_printer.name_type = '$type->name_type' THEN 1 ELSE 0 END) as total_{$name_type}");
		}


		$sum_parts = [];
		foreach ($printer_types as $type) {
			$name_type = str_replace('-', '_', $type->name_type);
			$sum_parts[] = "SUM(CASE WHEN type_printer.name_type = '$type->name_type' THEN 1 ELSE 0 END)";
		}
		$sum_expression = implode(' + ', $sum_parts);
		$this->db->select("($sum_expression) as total_printer");

		$this->db->from('printer_list_inagen');
		$this->db->join('customers', 'printer_list_inagen.id_cust = customers.id_cust');
		$this->db->join('printer_backup', 'printer_list_inagen.id_printer = printer_backup.id_printer');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->group_by('customers.cust_id');
		$this->db->order_by('printer_list_inagen.date_out', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}


	// type printer judul
	public function type_printer()
	{
		return $this->db->select('type_printer.name_type')->from('type_printer')->get()->result();
	}

	public function autoInvoice()
	{
		$this->db->select_max('no_ref', 'no_ref_max');
		$query = $this->db->get('printer_list_inagen');
		$row = $query->row();

		$kode_lama = $row->no_ref_max;

		$number = (int) substr($kode_lama, 0, 4);
		$number++; // Increment number

		$kode_baru = sprintf("%04d", $number) . '/JNE/IT/BA/' . date('m/Y');
		return $kode_baru;
	}

	public function printer_out()
	{
		// update jadi sn normal jika ada penanda inactive
		$get_idprinter = $this->input->post('printersn');
		$printer = $this->db->get_where('printer_backup', ['id_printer' => $get_idprinter])->row();
		$printer_sn = $printer->printer_sn;
		$parts = explode(' - ', $printer_sn);
		$sn = $parts[0]; 
		$this->db->where('id_printer', $get_idprinter);
		$this->db->update('printer_backup', ['printer_sn' => $sn]);

		// update data printer backup
		$status['status'] = 'BORROWING';
		$this->db->where('id_printer', $this->input->post('printersn'));
		$this->db->update('printer_backup', $status);

		$take_kelengkapan = $this->input->post('kelengkapan');
		$kelengkapan = implode(', ', $take_kelengkapan);

		$form_data_list = [
			'id_printer'	=> $this->input->post('printersn', true), // id isinya
			'id_cust'		=> $this->input->post('agenname', true), // id isinya
			'pic_it'		=> $this->input->post('picit', true),
			'pic_user'		=> $this->input->post('picuser', true),
			'no_ref'		=> $this->autoInvoice(),
			'date_out'		=> date('d/m/Y H:i:s'),
			'kelengkapan'	=> $kelengkapan,
			'status_transaksi'	=> $this->input->post('replacement'),
			'created_at'	=> date('d F Y H:i:s')
		];
		$this->db->insert('printer_list_inagen', $form_data_list);

		if ($this->input->post('replacement') != 'NEW') {

			$get_insert_id = $this->db->insert_id(); // ambil id yang baru di upplod
			// mengambil printer sn untuk di upload di rep
			$printer_sn = $this->db->select('printer_sn')->from('printer_backup')->where('id_printer',$this->input->post('printersn', true))->get()->row()->printer_sn;

			$form_data_rep = [
				'id_printer_list'	=> $get_insert_id,
				'printer_sn_rep'	=> $printer_sn,
				'created_at'		=> date('d F Y H:i:s'),
			];
			$this->db->insert('printer_replacement', $form_data_rep);

		}

	}

	public function jumlah_data()
	{
		return $this->db->count_all_results('printer_list_inagen');
	}

	public function date_time()
	{
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('printer_list_inagen');
		return $query->row();
	}

}
