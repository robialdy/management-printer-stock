<?php

class PrinterReplacement_Model extends CI_Model
{
	public function readData()
	{
		$this->db->select('printer_replacement.*, printer_backup.origin, printer_backup.date_in, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type, printer_list_inagen.*');
		$this->db->from('printer_replacement');
		$this->db->join('printer_list_inagen', 'printer_replacement.id_printer_list = printer_list_inagen.id_printer_list');
		$this->db->join('customers', 'printer_list_inagen.id_cust = customers.id_cust');
		$this->db->join('printer_backup', 'printer_list_inagen.id_printer = printer_backup.id_printer');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type'); // Join dari printer_backup ke type_printer
		$this->db->order_by('printer_replacement.created_at', 'DESC');

		$query = $this->db->get();
		return $query->result();
	}

	public function search_sn($id)
	{
		return $this->db->select('printer_sn')->from('printer_backup')->where('id_printer', $id)->get()->row();

	}

	public function read_data_detail($sn)
	{
		$this->db->select('printer_replacement.*, printer_backup.origin, printer_backup.date_in, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type, printer_list_inagen.*');
		$this->db->from('printer_replacement');
		$this->db->join('printer_list_inagen', 'printer_replacement.id_printer_list = printer_list_inagen.id_printer_list');
		$this->db->join('customers', 'printer_list_inagen.id_cust = customers.id_cust');
		$this->db->join('printer_backup', 'printer_list_inagen.id_printer = printer_backup.id_printer');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type'); // Join dari printer_backup ke type_printer 
		$this->db->where('printer_backup.printer_sn', $sn);
		$query = $this->db->get();
		return $query->row();
	}

	//auto invoice no ref
	public function autoInvoice()
	{
		$this->db->select_max('no_ref', 'no_ref_max');
		$query = $this->db->get('printer_list_inagen');
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

		$form_data_list = [
			'id_printer'	=> $this->input->post('printersn', true),
			'id_cust'		=> $this->input->post('agenname', true), // id isinya
			'pic_it'		=> $this->input->post('picit', true),
			'pic_user'		=> $this->input->post('picuser', true),
			'no_ref'		=> $this->autoInvoice(),
			'date_out'		=> date('d/m/Y H:i:s'),
			'kelengkapan'	=> $kelengkapan,
		];
		$this->db->insert('printer_list_inagen', $form_data_list);


		$last_insert_id = $this->db->insert_id(); //mengambil id yang baru di upload yaitu id list
		// mengambil printer sn untuk di upload di rep
		$printer_sn = $this->db->select('printer_sn')->from('printer_backup')->where('id_printer', $this->input->post('printersn', true))->get()->row()->printer_sn;

		$form_data_rep = [
			'id_printer_list'	=> $last_insert_id,
			'printer_sn_rep'	=> $printer_sn,
			'created_at'	=> date('d F Y H:i:s'),
		];
		$this->db->insert('printer_replacement', $form_data_rep);
	}

	public function insertNew($id_printer,$id_cust,$pic_it,$pic_user,$no_ref,$date_out,$kelengkapan, $sn_damage)
	{
		// mengecek jika ada sn damage tampilkan di rep 
		if ($sn_damage) {
			$sn_damage;
		} else {
			$sn_damage = '-';
		}

		// update data printer backup
		$status['status'] = 'REPLACEMENT';
		$this->db->where('id_printer', $id_printer);
		$this->db->update('printer_backup', $status);

		$form_data_list = [
			'id_printer'	=> $id_printer,
			'id_cust'		=> $id_cust,
			'pic_it'		=> $pic_it,
			'pic_user'		=> $pic_user,
			'no_ref'		=> $no_ref,
			'date_out'		=> $date_out,
			'kelengkapan'	=> $kelengkapan,
		];
		$this->db->insert('printer_list_inagen', $form_data_list);

		$last_insert_id = $this->db->insert_id(); //mengambil id yang baru di upload yaitu id list
		// mengambil printer sn untuk di upload di rep
		$printer_sn = $this->db->select('printer_sn')->from('printer_backup')->where('id_printer', $id_printer)->get()->row()->printer_sn;

		$form_data_rep = [
			'id_printer_list'	=> $last_insert_id,
			'printer_sn_rep'	=> $printer_sn,
			'sn_damage'			=> $sn_damage,
			'created_at'		=> date('d F Y H:i:s'),
		];
		$this->db->insert('printer_replacement', $form_data_rep);
	}

	//ngirim data ke damage
	public function insertToDamage()
	{

		// update data printer
		$status['status'] = 'DAMAGE';
		$this->db->where('id_printer', $this->input->post('idprinter', true));
		$this->db->update('printer_backup', $status);

		$form_del = [
			'id_printer'	=> 	$this->input->post('idprinter', true),
			'id_cust'		=> 	$this->input->post('idcust', true),
			'created_at'	=> date('d F Y H:i:s'),
			'update_at'	=> date('d F Y H:i:s'),
		];
		$this->db->insert('printer_damage', $form_del);
	}


	//untuk memilih printer 
	public function modalSelectJoin()
	{
		$id_cust = $this->input->post('agenname', true);
		$this->db->select('printer_replacement.*, printer_backup.printer_sn, type_printer.name_type, customers.cust_name, printer_list_inagen.*');
		$this->db->from('printer_replacement');
		$this->db->join('printer_list_inagen', 'printer_replacement.id_printer_list = printer_list_inagen.id_printer_list');
		$this->db->join('customers', 'printer_list_inagen.id_cust = customers.id_cust');
		$this->db->join('printer_backup', 'printer_list_inagen.id_printer = printer_backup.id_printer');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where('printer_list_inagen.id_cust', $id_cust);
		return $this->db->get();
	}

	public function get_printer_by_id($cust_id, $id_list, $sn_damage)
	{
		if ($sn_damage == '-'){ //cek jika sn damagenya ada tidak bisa dirubah lagi

		$this->db->select('printer_replacement.*, printer_backup.printer_sn, type_printer.name_type, customers.cust_name, printer_list_inagen.*');
		$this->db->from('printer_replacement');
		$this->db->join('printer_list_inagen', 'printer_replacement.id_printer_list = printer_list_inagen.id_printer_list');
		$this->db->join('customers', 'printer_list_inagen.id_cust = customers.id_cust');
		$this->db->join('printer_backup', 'printer_list_inagen.id_printer = printer_backup.id_printer');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where('printer_list_inagen.id_cust', $cust_id); //nyari berdasarkan cust
		// $this->db->where('printer_replacement.sn_damage', '-'); //nyari yang pake - doang 
		$this->db->where_not_in('printer_list_inagen.id_printer_list', $id_list); //gak nampilin punya sendiri
		$query = $this->db->get();
		return $query->result();
		} else {
			return null;
		}

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
