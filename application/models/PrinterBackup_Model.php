<?php

class PrinterBackup_Model extends CI_Model
{
	public function readData()
	{
		return $this->db->order_by('date_in', 'DESC')->get_where('printer_backup', ['status' => 'READY'])->result_array();
	}

	public function insertData()
	{
		$printer_sn = strtoupper($this->input->post('printersn', true));
		$type = strtoupper($this->input->post('printertype', true));

		$form_data = [
			'printer_sn'	=> $printer_sn,
			'type_printer'	=> $type,
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
