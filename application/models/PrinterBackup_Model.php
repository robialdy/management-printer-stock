<?php

class PrinterBackup_Model extends CI_Model
{
	public function read_data_backup()
	{
		$this->db->select('printer_backup.*, type_printer.name_type');
		$this->db->from('printer_backup');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where('printer_backup.status', 'READY');
		$this->db->order_by('printer_backup.date_in', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function readData()
	{
		// Ambil semua jenis printer
		$printer_types = $this->type_printer();

		// Pilih kolom yang diinginkan
		$this->db->select('printer_backup.*, type_printer.name_type');

		// Menghitung total printer berdasarkan name_type
		foreach ($printer_types as $type) {
			$name_type = str_replace('-', '_', $type->name_type);
			$this->db->select("SUM(CASE WHEN type_printer.name_type = '{$type->name_type}' THEN 1 ELSE 0 END) as total_{$name_type}");
		}

		// Query dari tabel printer_backup dan join dengan type_printer
		$this->db->from('printer_backup');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where('printer_backup.status', 'READY');
		$this->db->group_by('type_printer.name_type'); // Group by untuk mendapatkan total per type
		$this->db->order_by('printer_backup.created_at', 'DESC');

		$query = $this->db->get();
		return $query->result_array();
	}


	public function type_printer()
	{
		return $this->db->order_by('created_at', 'DESC')->get('type_printer')->result();
	}


	public function insertData()
	{
		$printer_sn = strtoupper($this->input->post('printersn', true));
		$return_cgk = $this->input->post('return_cgk', true); // isi valuue nya id

		//update return_cgk damage
		$form_data ['return_cgk'] = $printer_sn;
		$this->db->where('id_printer', $return_cgk);
		$this->db->update('printer_damage', $form_data);


		$form_data = [
			'printer_sn'	=> $printer_sn,
			'id_type'	=> $this->input->post('typeprinter', true),
			'origin'		=> 'BANDUNG',
			'date_in'		=> date('d/m/Y H:i:s'),
			'status'		=> 'READY',
			'created_at' 	=> date('d F Y H:i:s'),
		];
		$this->db->insert('printer_backup', $form_data);

		// insert data baru di log
		$form_log = [
			'printer_sn'	=> $printer_sn,
			'status'		=> 'IN BACKUP',
			'created_at'	=> date('d/m/Y H:i:s'),
		];
		$this->db->insert('printer_log', $form_log);
	}

	public function update_printer_backup()
	{
		// UPDATE SN PRINTER
		$printer_sn = $this->input->post('printer_sn');
		$id_prin = $this->input->post('id_prin');
		// baris di sn damage
		$id_printer_cgk = $this->input->post('id_prin_cgk');


		// delete di damagenya
		$this->db->delete('printer_damage', ['id_printer' => $id_prin]);
		// update return cgk di damage
		$cgk ['return_cgk'] = $printer_sn;
		$this->db->where('id_printer', $id_printer_cgk);
		$this->db->update('printer_damage', $cgk);
		// ubah backup dari damage jadi ready lagi
		$printer_update = [
			'status'	=> 'READY',
			'date_in'	=> date('d/m/Y H:i:s'),
			'created_at'=> date('d F Y H:i:s'),
		];
		$this->db->where('id_printer', $id_prin);
		$this->db->update('printer_backup', $printer_update);


		// UPDATE STATUS PRINTER LOG
		$status_log ['status'] = null;
		$this->db->where('printer_sn', $printer_sn);
		$this->db->where('status', 'IN DAMAGE');
		$this->db->update('printer_log', $status_log);

		// insert data baru di log
		$form_log = [
			'printer_sn'	=> $printer_sn,
			'status'		=> 'IN BACKUP',
			'created_at'	=> date('d/m/Y H:i:s'),
		];
		$this->db->insert('printer_log', $form_log);

	}

	//jumlah data
	public function jumlahData()
	{
		$this->db->where('status', 'READY');
		return $this->db->count_all_results('printer_backup');
	}

	public function jumlah()
	{
		$this->db->where_in('status', ['READY', 'BORROWING']);
		return $this->db->count_all_results('printer_backup');
	}

	public function jumlah_type()
	{
		// Menghitung jumlah printer berdasarkan status dan type
		$this->db->select('type_printer.name_type, COUNT(printer_backup.id_printer) as total_printers');
		$this->db->from('printer_backup');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where_in('printer_backup.status', ['READY', 'BORROWING']);
		$this->db->group_by('type_printer.name_type'); // Mengelompokkan hasil berdasarkan type
		$query = $this->db->get();

		return $query->result_array(); // Mengembalikan hasil sebagai array

	}

	public function dateTime()
	{
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('printer_backup');
		return $query->row();
	}
}
