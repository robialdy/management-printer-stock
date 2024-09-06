<?php

class PrinterReplacement_Model extends CI_Model
{
	public function readData()
	{
		$this->db->select('printer_replacement.*, printer_backup.origin, printer_backup.date_in, printer_backup.type_printer, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust');
		$this->db->from('printer_replacement');
		$this->db->join('printer_backup', 'printer_replacement.id_printer = printer_backup.id_printer');
		$this->db->join('customers', 'printer_replacement.id_cust = customers.id_cust');
		$this->db->order_by('printer_replacement.created_at	', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function printer_sn($printer_id)
	{
		$results = $this->readData(); // Mendapatkan data lengkap

		// Mencari printer_sn dari hasil yang diperoleh
		foreach ($results as $row) {
			if ($row->id_printer == $printer_id) {
				return $row->printer_sn; // Mengembalikan printer_sn jika ditemukan
			}
		}

		return null; // Mengembalikan null jika tidak ditemukan
	}
	//auto invoice no ref
	public function autoInvoice()
	{
		$this->db->select_max('no_ref', 'no_ref_max');
		$query = $this->db->get('printer_replacement');
		$row = $query->row();

		$kode_lama = $row->no_ref_max;

		$number = (int) substr($kode_lama, 0, 3);
		$number++; // Increment number

		$kode_baru = sprintf("%03d", $number) . '/JNE/IT/BA/' . date('m/Y');
		return $kode_baru;
	}

	public function insertData()
	{

		// update data printer backup
		$status['status'] = 'REPLACEMENT';
		$this->db->where('id_printer', $this->input->post('printersn'));
		$this->db->update('printer_backup', $status);

		$take_kelengkapan = $this->input->post('kelengkapan');
		$kelengkapan = implode(', ', $take_kelengkapan);

		$form_data = [
			'id_printer'	=> $this->input->post('printersn', true),
			'id_cust'		=> $this->input->post('agenname', true), // id isinya
			'pic_it'		=> $this->input->post('picit', true),
			'pic_user'		=> $this->input->post('picuser', true),
			'no_ref'		=> $this->autoInvoice(),
			'date_out'		=> date('d/m/Y H:i:s'),
			'kelengkapan'	=> $kelengkapan,
			'created_at'	=> date('d F Y H:i:s'),
		];
		$this->db->insert('printer_replacement', $form_data);
	}

	public function insertNew($printer_sn,$agen_name,$pic_it,$pic_user,$no_ref,$date_out,$kelengkapan)
	{
		// update data printer backup
		$status['status'] = 'REPLACEMENT';
		$this->db->where('id_printer', $printer_sn);
		$this->db->update('printer_backup', $status);

		$form_data = [
			'id_printer'	=> $printer_sn,
			'id_cust'		=> $agen_name,
			'pic_it'		=> $pic_it,
			'pic_user'		=> $pic_user,
			'no_ref'		=> $no_ref,
			'date_out'		=> $date_out,
			'kelengkapan'	=> $kelengkapan,
			'created_at'	=> date('d F Y H:i:s'),
		];
		$this->db->insert('printer_replacement', $form_data);
	}

	//ngirim data ke damage
	public function insertToDamage()
	{

		// update data printer
		$status['status'] = 'DAMAGE';
		$this->db->where('id_printer', $this->input->post('idprinter'));
		$this->db->update('printer_backup', $status);

		$form_dd = [
			'id_printer'	=> 	$this->input->post('idprinter'),
			'id_cust'		=> 	$this->input->post('idcust'),
			'created_at'	=> date('d M Y / H:i:s'),
			'update_at'	=> date('d M Y H:i:s'),
		];
		$this->db->insert('printer_damage', $form_dd);
	}

	public function insertWithDamage($printer_sn, $agen_name, $pic_it, $pic_user, $no_ref, $date_out, $kelengkapan, $sn_lama)
	{
		$status['status'] = 'REPLACEMENT';
		$this->db->where('id_printer', $printer_sn);
		$this->db->update('printer_backup', $status);

		$form_data = [
			'id_printer'	=> $printer_sn,
			'id_cust'		=> $agen_name,
			'pic_it'		=> $pic_it,
			'pic_user'		=> $pic_user,
			'no_ref'		=> $no_ref,
			'date_out'		=> $date_out,
			'kelengkapan'	=> $kelengkapan,
			'sn_damage'		=> $sn_lama,
			'created_at'	=> date('d F Y H:i:s'),
		];
		$this->db->insert('printer_replacement', $form_data);
	}

	//untuk memilih printer 
	public function modalSelectJoin()
	{
		$id_cust = $this->input->post('agenname');
		$this->db->select('printer_replacement.*, printer_backup.printer_sn, printer_backup.type_printer, customers.cust_name');
		$this->db->from('printer_replacement');
		$this->db->join('printer_backup', 'printer_backup.id_printer = printer_replacement.id_printer');
		$this->db->join('customers', 'customers.id_cust = printer_replacement.id_cust');
		$this->db->where('printer_replacement.id_cust', $id_cust);
		return $this->db->get();
	}

	public function get_printer_by_id($cust_id, $idRep, $sn_damage)
	{
		if ($sn_damage == '-'){

		$this->db->select('printer_replacement.*, printer_backup.printer_sn, printer_backup.type_printer, customers.cust_name');
		$this->db->from('printer_replacement');
		$this->db->join('printer_backup', 'printer_backup.id_printer = printer_replacement.id_printer');
		$this->db->join('customers', 'customers.id_cust = printer_replacement.id_cust');
		$this->db->where('printer_replacement.id_cust', $cust_id); //nyari berdasarkan cust
		$this->db->where('printer_replacement.sn_damage', '-'); //nyari yang pake - doang
		$this->db->where_not_in('printer_replacement.id_replacement', $idRep); //gak nampilin punya sendiri
		$query = $this->db->get();
		return $query->result();
		} else {
			return null;
		}

	}

	//modal edit menampilkan nama agen di printer replacement
	public function custName()
	{
		//menghindari duplikat nama yang sama
		$this->db->distinct();
		$this->db->select('customers.id_cust, customers.cust_name');
		$this->db->from('printer_replacement');
		$this->db->join('customers', 'customers.id_cust = printer_replacement.id_cust');
		$query = $this->db->get();
		return $query->result();
	}


	public function jumlahData()
	{
		return $this->db->count_all_results('printer_replacement');
	}

	public function dateTime()
	{
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('printer_replacement');
		return $query->row();
	}



}
