<?php

class PrinterReplacement_Model extends CI_Model
{
	public function readData()
	{
		$this->db->select('printer_replacement.*, customers.origin_name, printer_backup.date_in, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type, printer_list_inagen.*');
		$this->db->from('printer_replacement');
		$this->db->join('printer_list_inagen', 'printer_replacement.id_printer_list = printer_list_inagen.id_printer_list');
		$this->db->join('customers', 'printer_list_inagen.id_cust = customers.id_cust');
		$this->db->join('printer_backup', 'printer_list_inagen.id_printer = printer_backup.id_printer');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type'); // Join dari printer_backup ke type_printer
		$this->db->order_by('printer_replacement.created_at', 'DESC');

		$query = $this->db->get();
		return $query->result();
	}

	public function search_sn($id) // buat notif
	{
		return $this->db->select('printer_sn')->from('printer_backup')->where('id_printer', $id)->get()->row();
	}

	public function insertNew($id_printer,$id_cust,$pic_it,$pic_user,$no_ref, $kelengkapan, $sn_damage)
	{
		// update jadi sn normal jika ada penanda inactive
		$get_idprinter = $id_printer;
		$printer = $this->db->get_where('printer_backup', ['id_printer' => $get_idprinter])->row();
		$printer_sn = $printer->printer_sn;
		$parts = explode(' - ', $printer_sn);
		$sn = $parts[0];
		$this->db->where('id_printer', $get_idprinter);
		$this->db->update('printer_backup', ['printer_sn' => $sn]);

		// update data printer backup
		$status['status'] = 'BORROWING';
		$this->db->where('id_printer', $id_printer);
		$this->db->update('printer_backup', $status);

		$form_data_list = [
			'id_printer'	=> $id_printer,
			'id_cust'		=> $id_cust,
			'pic_it'		=> $pic_it,
			'pic_user'		=> $pic_user,
			'no_ref'		=> $no_ref,
			'date_out'		=> date('d/m/Y H:i:s'),
			'kelengkapan'	=> $kelengkapan,
			'created_at'	=> date('d F Y H:i:s')
		];
		$this->db->insert('printer_list_inagen', $form_data_list);
		$get_id_list = $this->db->insert_id(); //mengambil id yang baru di upload yaitu id list

		$this->db->insert('printer_summary', $form_data_list);

		// mengambil printer sn untuk di upload di rep
		$printer_sn = $this->db->select('printer_sn')->from('printer_backup')->where('id_printer', $id_printer)->get()->row()->printer_sn;

		$form_data_rep = [
			'id_printer_list'	=> $get_id_list,
			'printer_sn_rep'	=> $printer_sn,
			'sn_damage'			=> $sn_damage,
			'created_at'		=> date('d/m/Y H:i:s'),
		];
		$this->db->insert('printer_replacement', $form_data_rep);

		// update log
		$cust = $this->db->where('id_cust', $id_cust)->get('customers')->row();

		$update_log = [
			'status'	=> 'IN CUSTOMER',
			'cust_id'	=> $cust->cust_id,
			'cust_name'	=> $cust->cust_name,
			'date_out'	=> date('d/m/Y H:i:s'),
		];
		$this->db->where('printer_sn', $printer_sn);
		$this->db->where('status', 'IN BACKUP');
		$this->db->update('printer_log', $update_log);
	}

	//ngirim data ke damage
	public function insertToDamage()
	{

		// update data printer
		$status['status'] = 'DAMAGE';
		$this->db->where('id_printer', $this->input->post('idprinter', true));
		$this->db->update('printer_backup', $status);

		$kelengkapan_ker = $this->input->post('kelengkapan_ker');
		$kelengkapan = implode(', ', $kelengkapan_ker);

		$form_del = [
			'id_printer'	=> 	$this->input->post('idprinter', true),
			'id_cust'		=> 	$this->input->post('idcust', true),
			'date_in'		=> date('d/m/Y H:i:s'),
			'kelengkapan'	=> $kelengkapan,
			'deskripsi'		=> strtoupper($this->input->post('deskripsi')),
		];
		$this->db->insert('printer_damage', $form_del);

		// diubah jadi update
		$form_log = [
			'status'	=> 'IN DAMAGE',
			'returned'	=> date('d/m/Y H:i:s'),
		];
		$this->db->where('printer_sn', $this->input->post('printersn'));
		$this->db->where('status', 'IN CUSTOMER');
		$this->db->update('printer_log', $form_log);
	}


	//untuk memilih printer 
	public function modalSelectJoin()
	{
		$id_cust = $this->input->post('agenname', true);
		$this->db->select('printer_list_inagen.*, customers.origin_name, printer_backup.date_in, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type');
		$this->db->from('printer_list_inagen');
		$this->db->join('customers', 'printer_list_inagen.id_cust = customers.id_cust');
		$this->db->join('printer_backup', 'printer_list_inagen.id_printer = printer_backup.id_printer');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type'); // Join dari printer_backup ke type_printer
		$this->db->where('printer_list_inagen.id_cust', $id_cust);
		return $this->db->get();
	}

	public function get_printer_by_id($cust_id, $id_list, $sn_damage)
	{
		if ($sn_damage == '-'){ //cek jika sn damagenya ada tidak bisa dirubah lagi

		$this->db->select(' printer_list_inagen.*, printer_backup.printer_sn, type_printer.name_type, customers.cust_name, customers.cust_id');
		$this->db->from('printer_list_inagen');
		$this->db->join('customers', 'printer_list_inagen.id_cust = customers.id_cust');
		$this->db->join('printer_backup', 'printer_list_inagen.id_printer = printer_backup.id_printer');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where('printer_list_inagen.status_transaksi', 'NEW');
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
