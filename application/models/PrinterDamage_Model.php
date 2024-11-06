<?php

class PrinterDamage_Model extends CI_Model
{
	public function read_data()
	{
		return $this->db->order_by('date_in', 'DESC')->get('printer_damage')->result();
	}
	// EDIT DI DAMAGE
	public function read_data_by_id($id_damage)
	{

		$this->db->select('*');
		$this->db->where('id_damage', $id_damage);
		$query = $this->db->get('printer_damage');
		return $query->row();
	}

	// READ DATA UNTUK MILIH NO DUMMY YANG MASIH KOSONG
	public function read_data_nodummy()
	{
		return $this->db->where('no_dummy', '-')->get('printer_damage')->result();
	}

		// READ DATA UNTUK MILIH NO DUMMY YANG TERSEDIA
	public function read_data_dummy()
	{
		return $this->db->order_by('date_in', 'DESC')->where('no_dummy !=', '-')->group_by('no_dummy')->get('printer_damage')->result();
	}

	// EXPORT BERDASARKAN DATA DARI NO DUMMY
	public function export_excel_by_dummy($no_dummy)
	{
		$this->db->select('*');
		$this->db->where('no_dummy', $no_dummy);
		$this->db->order_by('date_in', 'DESC');
		$query = $this->db->get('printer_damage');
		return $query->result();
	}

	// EXPORT BERDASARKAN WAKTU
	public function export_excel_by_date($from, $until)
	{
		$this->db->select('*');
		$this->db->where('no_dummy !=', '-');
		$this->db->where('date_pengiriman >=', $from);
		$this->db->where('date_pengiriman <=', $until);
		$this->db->order_by('date_pengiriman', 'DESC');
		$query = $this->db->get('printer_damage');
		return $query->result();
	}

	public function add_nodummy($id_damage, $nodummy) // printersn = array
	{
		foreach ($id_damage as $prinsn) {
			// Lakukan update untuk setiap printer yang dipilih
			$this->db->where('id_damage', $prinsn);
			$this->db->update('printer_damage', ['no_dummy' => $nodummy, 'date_pengiriman' => date('d/m/y')]); // Sesuaikan nama tabel dan kolom
		}
	}

	public function add_damage()
	{
		// mengambil value
		$id_printer_and_cust = $this->input->post('idprinter', true); // isinya id printer dan cust
		$values = explode('|', $id_printer_and_cust);
		$id_printer = $values[0];
		$id_cust = $values[1];

		// masuk idpinter
		$printer_list = $this->db->where('id_printer', $id_printer)->get('printer_list_inagen')->row();

		// update data printer
		$status['status'] = 'DAMAGE';
		$this->db->where('id_printer', $id_printer);
		$this->db->update('printer_backup', $status);
		// menyatukan array
		$kelengkapan = $this->input->post('kelengkapan', true);
		$kelengkapan = implode(', ', $kelengkapan);

		// masuk printer backup
		$printer_backup = $this->db->select('printer_sn, name_type')->from('printer_backup')->join('type_printer', 'printer_backup.id_type = type_printer.id_type')->where('printer_backup.id_printer', $id_printer)->get()->row();

		// update data printer
		$customer = $this->db->where('id_cust', $id_cust)->get('customers')->row();

		// kirim ke damage
		$form_del = [
			'type_printer'	=> $printer_backup->name_type,
			'printer_sn'	=> $printer_backup->printer_sn,
			'origin'		=> $customer->origin_name,
			'type_cust'		=> $customer->type_cust,
			'cust_id'		=> $customer->cust_id,
			'cust_name'		=> $customer->cust_name,
			'date_in'		=> date('d/m/Y H:i:s'), //sama kaya yang di log
			'kelengkapan'	=> $kelengkapan,
			'deskripsi'		=> strtoupper($this->input->post('deskripsi', true)),
			'loan_file'		=> $printer_list->proof,
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

		$this->db->where('id_cust', $id_cust);
		$customer = $this->db->get('customers')->row();

		if ($customer->status == 'IN-ACTIVE') {
			// delete list
			$this->db->delete('printer_list_inagen', ['id_printer' => $id_printer]);
			$this->db->delete('printer_summary', ['id_printer' => $id_printer]);
		} else {
			// delete list
			$this->db->delete('printer_list_inagen', ['id_printer' => $id_printer]);
		}

	}

	public function edit()
	{
		$form_data = [
			'biaya_perbaikan'		=> $this->input->post('biaya', true),
			'status_pembayaran' => $this->input->post('status_pembayaran',true),
		];
		$this->db->where('id_damage', $this->input->post('id_damage', true));
		$this->db->update('printer_damage', $form_data);
	}

	public function edit_status()
	{
		$form_damage = [
			'status' => strtoupper($this->input->post('return_cgk', true)),
		];
		$this->db->where('id_damage', $this->input->post('id_damage', true));
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
