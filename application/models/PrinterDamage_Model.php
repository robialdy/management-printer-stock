<?php

class PrinterDamage_Model extends CI_Model
{
	public function read_data()
	{
		$this->db->select('printer_damage.*, customers.origin_name, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type');
		$this->db->from('printer_damage');
		$this->db->join('printer_backup', 'printer_damage.id_printer = printer_backup.id_printer');
		$this->db->join('customers', 'printer_damage.id_cust = customers.id_cust');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->order_by('printer_damage.date_in', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function read_data_with_type()
	{
		// Ambil semua jenis printer
		$printer_types = $this->type_printer();

		// Pilih kolom yang diinginkan
		$this->db->select('printer_damage.*, customers.origin_name, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type');

		// Tambahkan perhitungan total printer berdasarkan name_type
		foreach ($printer_types as $type) {
			$name_type = str_replace('-', '_', $type->name_type);
			$this->db->select("SUM(CASE WHEN type_printer.name_type = '{$type->name_type}' THEN 1 ELSE 0 END) as total_{$name_type}");
		}

		// Query dari tabel printer_damage dengan join beberapa tabel terkait
		$this->db->from('printer_damage');
		$this->db->join('printer_backup', 'printer_damage.id_printer = printer_backup.id_printer');
		$this->db->join('customers', 'printer_damage.id_cust = customers.id_cust');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');

		// Group by berdasarkan jenis printer
		$this->db->group_by('type_printer.name_type');

		// Urutkan berdasarkan tanggal masuk
		$this->db->order_by('printer_damage.date_in', 'DESC');

		// Eksekusi query
		$query = $this->db->get();
		return $query->result();
	}
	public function type_printer()
	{
		return $this->db->order_by('created_at', 'DESC')->get('type_printer')->result();
	}


	public function read_data_by_id($id_damage)
	{
		$this->db->select('printer_damage.*, customers.origin_name, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type');
		$this->db->from('printer_damage');
		$this->db->join('printer_backup', 'printer_damage.id_printer = printer_backup.id_printer');
		$this->db->join('customers', 'printer_damage.id_cust = customers.id_cust');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where('printer_damage.id_damage', $id_damage);
		$this->db->order_by('printer_damage.date_in', 'DESC');
		$query = $this->db->get();
		return $query->row();
	}

	public function read_data_nodummy()
	{
		$this->db->select('printer_damage.*, customers.origin_name, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type');
		$this->db->from('printer_damage');
		$this->db->join('printer_backup', 'printer_damage.id_printer = printer_backup.id_printer');
		$this->db->join('customers', 'printer_damage.id_cust = customers.id_cust');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where('printer_damage.no_dummy', '-');
		$this->db->order_by('printer_damage.date_in', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function read_data_dummy()
	{
		return $this->db->order_by('date_in', 'DESC')->where('no_dummy !=', '-')->group_by('no_dummy')->get('printer_damage')->result();
	}

	public function read_data_return_cgk()
	{
		$this->db->select('printer_damage.*, customers.origin_name, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type');
		$this->db->from('printer_damage');
		$this->db->join('printer_backup', 'printer_damage.id_printer = printer_backup.id_printer');
		$this->db->join('customers', 'printer_damage.id_cust = customers.id_cust');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where('printer_damage.no_dummy !=', '-');
		$this->db->where('printer_damage.return_cgk', '-');
		$this->db->order_by('printer_damage.date_in', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function export_excel_by_dummy($no_dummy)
	{
		$this->db->select('printer_damage.*, customers.origin_name, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type');
		$this->db->from('printer_damage');
		$this->db->join('printer_backup', 'printer_damage.id_printer = printer_backup.id_printer');
		$this->db->join('customers', 'printer_damage.id_cust = customers.id_cust');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where('printer_damage.no_dummy', $no_dummy);
		$this->db->order_by('printer_damage.date_in', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function export_excel_by_date($from, $until)
	{
		$this->db->select('printer_damage.*, customers.origin_name, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type');
		$this->db->from('printer_damage');
		$this->db->join('printer_backup', 'printer_damage.id_printer = printer_backup.id_printer');
		$this->db->join('customers', 'printer_damage.id_cust = customers.id_cust');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where('printer_damage.no_dummy !=', '-');

		$this->db->where('printer_damage.date_in >=', $from . ' 00:00:00');
		$this->db->where('printer_damage.date_in <=', $until . ' 23:59:59');

		$this->db->order_by('printer_damage.date_in', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function add_nodummy($idprinter, $nodummy) // idprinter = array
	{
		foreach ($idprinter as $id_prin) {
			// Lakukan update untuk setiap printer yang dipilih
			$this->db->where('id_printer', $id_prin);
			$this->db->update('printer_damage', ['no_dummy' => $nodummy, 'date_pengiriman' => date('d/m/y')]); // Sesuaikan nama tabel dan kolom
		}
	}

	public function add_damage()
	{
		// mengambil value
		$id_printer_and_cust = $this->input->post('idprinter'); // isinya id printer dan cust
		$values = explode('|', $id_printer_and_cust);
		$id_printer = $values[0];
		$id_cust = $values[1];

		// update data printer
		$status['status'] = 'DAMAGE';
		$this->db->where('id_printer', $id_printer);
		$this->db->update('printer_backup', $status);

		// menyatukan array
		$kelengkapan = $this->input->post('kelengkapan');
		$kelengkapan = implode(', ', $kelengkapan);
		// kirim ke damage
		$form_del = [
			'id_printer'	=> 	$id_printer,
			'id_cust'		=> 	$id_cust,
			'date_in'		=> date('d/m/Y H:i:s'), //sama kaya yang di log
			'kelengkapan'	=> $kelengkapan,
			'deskripsi'		=> strtoupper($this->input->post('deskripsi')),
		];
		$this->db->insert('printer_damage', $form_del);

		// UPDATE LOG
		$printer_sn = $this->db->where('id_printer', $id_printer)->get('printer_backup')->row();
		$form_log = [
			'status'	=> 'IN DAMAGE',
			'returned'	=> date('d/m/Y H:i:s'),
		];
		$this->db->where('printer_sn', $printer_sn->printer_sn);
		$this->db->where('status', 'IN CUSTOMER');
		$this->db->update('printer_log', $form_log);

		// delete list
		$this->db->delete('printer_list_inagen', ['id_printer' => $id_printer]);
	}

	public function edit()
	{
		$form_data = [
			'biaya_perbaikan'		=> $this->input->post('biaya'),
			'status_pembayaran' => $this->input->post('status_pembayaran'),
		];
		$this->db->where('id_damage', $this->input->post('id_damage'));
		$this->db->update('printer_damage', $form_data);
	}

	public function edit_status()
	{
		$form_damage = [
			'status' => strtoupper($this->input->post('return_cgk')),
		];
		$this->db->where('id_damage', $this->input->post('id_damage'));
		$this->db->update('printer_damage', $form_damage);
	}

	public function sum_damage()
	{
		return $this->db->count_all_results('printer_damage');
	}

	public function date_time()
	{
		$this->db->order_by('date_in', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('printer_damage');
		return $query->row();
	}
}
