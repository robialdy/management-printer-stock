<?php

class PrinterBackup_Model extends CI_Model
{
	public function readData()
	{
		// return $this->db->order_by('date_in', 'DESC')->get_where('printer_backup', ['status' => 'READY'])->result_array();
		$this->db->select('printer_backup.*, type_printer.name_type');
		$this->db->from('printer_backup');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->where('status', 'READY');
		$this->db->order_by('created_at', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function insertData()
	{
		$printer_sn = strtoupper($this->input->post('printersn', true));
		$return_cgk = $this->input->post('return_cgk'); // isi valuue nya id

		//update return_cgk damage
		$form_data ['return_cgk'] = $printer_sn;
		$this->db->where('id_printer', $return_cgk);
		$this->db->update('printer_damage', $form_data);


		$form_data = [
			'printer_sn'	=> $printer_sn,
			'id_type'	=> $this->input->post('typeprinter', true),
			'origin'		=> 'BANDUNG',
			'date_in'		=> date('d/m/Y / H:i:s'),
			'status'		=> 'READY',
			'created_at' 	=> date('d F Y H:i:s'),
		];
		$this->db->insert('printer_backup', $form_data);
	}

	//jumlah data
	public function jumlahData()
	{
		$this->db->where('status', 'READY');
		return $this->db->count_all_results('printer_backup');
	}

	public function jumlah()
	{
		return $this->db->count_all_results('printer_backup');
	}

	public function dateTime()
	{
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('printer_backup');
		return $query->row();
	}
}
