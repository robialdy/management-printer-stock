<?php

class PrinterReplacement_Model extends CI_Model
{
	public function readData()
	{
		$this->db->select('printer_replacement.*, printer_backup.origin, printer_backup.date_in, printer_backup.type_printer, printer_backup.printer_sn, agen.cust_id, agen.agen_name, agen.type_cust');
		$this->db->from('printer_replacement');
		$this->db->join('printer_backup', 'printer_replacement.id_printer = printer_backup.id_printer');
		$this->db->join('agen', 'printer_replacement.id_agen = agen.id_agen');
		$this->db->order_by('printer_replacement.date_out', 'DESC');
		$query = $this->db->get();
		return $query->result();
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
			'id_agen'		=> $this->input->post('agenname', true), // id isinya
			'pic_it'		=> $this->input->post('picit', true),
			'pic_user'		=> $this->input->post('picuser', true),
			'no_ref'		=> $this->autoInvoice(),
			'date_out'		=> date('d/m/Y / H:i:s'),
			'kelengkapan'	=> $kelengkapan,
			'created_at'	=> date('d M Y / H:i:s'),
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
			'id_agen'		=> $agen_name,
			'pic_it'		=> $pic_it,
			'pic_user'		=> $pic_user,
			'no_ref'		=> $no_ref,
			'date_out'		=> $date_out,
			'kelengkapan'	=> $kelengkapan,
		];
		$this->db->insert('printer_replacement', $form_data);
	}

	public function insertToDamage()
	{
		$this->db->delete('printer_replacement', ['id_replacement' => $this->input->post('idreplacement')]);

		// update data printer
		$status['status'] = 'DAMAGE';
		$this->db->where('id_printer', $this->input->post('idprinter'));
		$this->db->update('printer_backup', $status);

		$form_dd = [
			'id_printer'	=> 	$this->input->post('idprinter'),
			'id_agen'		=> 	$this->input->post('idagen'),
		];
		$this->db->insert('printer_damage', $form_dd);
	}

	public function insertNeww($printer_sn, $agen_name, $pic_it, $pic_user, $no_ref, $date_out, $kelengkapan)
	{
		$status['status'] = 'REPLACEMENT';
		$this->db->where('id_printer', $printer_sn);
		$this->db->update('printer_backup', $status);

		$form_data = [
			'id_printer'	=> $printer_sn,
			'id_agen'		=> $agen_name,
			'pic_it'		=> $pic_it,
			'pic_user'		=> $pic_user,
			'no_ref'		=> $no_ref,
			'date_out'		=> $date_out,
			'kelengkapan'	=> $kelengkapan,
		];
		$this->db->insert('printer_replacement', $form_data);
	}

	public function modalSelectJoin()
	{
		$id_agen = $this->input->post('agenname');
		$this->db->select('printer_replacement.*, printer_backup.printer_sn, printer_backup.type_printer');
		$this->db->from('printer_replacement');
		$this->db->join('printer_backup', 'printer_backup.id_printer = printer_replacement.id_printer');
		$this->db->where('printer_replacement.id_agen', $id_agen);
		return $this->db->get();
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
