<?php

class PrinterDamage_Model extends CI_Model
{
	public function read_data()
	{
		$this->db->select('printer_damage.*, printer_backup.origin, printer_backup.date_in, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type');
		$this->db->from('printer_damage');
		$this->db->join('printer_backup', 'printer_damage.id_printer = printer_backup.id_printer');
		$this->db->join('customers', 'printer_damage.id_cust = customers.id_cust');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->order_by('printer_damage.created_at', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function read_data_nodummy()
	{
		$this->db->select('printer_damage.*, printer_backup.origin, printer_backup.date_in, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type');
		$this->db->from('printer_damage');
		$this->db->join('printer_backup', 'printer_damage.id_printer = printer_backup.id_printer');
		$this->db->join('customers', 'printer_damage.id_cust = customers.id_cust');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where('printer_damage.no_dummy', '-');
		$this->db->order_by('printer_damage.created_at', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function read_data_return_cgk()
	{
		$this->db->select('printer_damage.*, printer_backup.origin, printer_backup.date_in, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type');
		$this->db->from('printer_damage');
		$this->db->join('printer_backup', 'printer_damage.id_printer = printer_backup.id_printer');
		$this->db->join('customers', 'printer_damage.id_cust = customers.id_cust');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where('printer_damage.return_cgk', '-');
		$this->db->order_by('printer_damage.created_at', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function read_data_add_perbaikan()
	{
		$this->db->select('printer_damage.*, printer_backup.origin, printer_backup.date_in, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type');
		$this->db->from('printer_damage');
		$this->db->join('printer_backup', 'printer_damage.id_printer = printer_backup.id_printer');
		$this->db->join('customers', 'printer_damage.id_cust = customers.id_cust');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where('printer_damage.pic_it', '-');
		$this->db->order_by('printer_damage.created_at', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function add_perbaikan()
	{
		$take_kelengkapan = $this->input->post('kelengkapan');
		$kelengkapan = implode(', ', $take_kelengkapan);

		$form_data = [
			'note'				=> 'BETUL',
			'kelengkapan'		=> $kelengkapan,
			'pic_it'			=> $this->input->post('pic_it'),
		];
		$this->db->where('id_printer', $this->input->post('printersn')); //id printer
		$this->db->update('printer_damage', $form_data);
	}

	public function add_nodummy($idprinter, $nodummy) // idprinter = array
	{
		foreach ($idprinter as $id_prin) {
			// Lakukan update untuk setiap printer yang dipilih
			$this->db->where('id_printer', $id_prin);
			$this->db->update('printer_damage', ['no_dummy' => $nodummy]); // Sesuaikan nama tabel dan kolom
		}
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

	public function sum_damage()
	{
		return $this->db->count_all_results('printer_damage');
	}

	public function date_time()
	{
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('printer_damage');
		return $query->row();
	}
}
