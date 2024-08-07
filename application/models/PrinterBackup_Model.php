<?php

class PrinterBackup_Model extends CI_Model
{
	public function readData()
	{
		return $this->db->get_where('printer_backup', ['status' => 'READY'])->result_array();
	}

	public function insertData()
	{
		$form_data = [
			'printer_sn'	=> $this->input->post('printersn', true),
			'type_printer'	=> $this->input->post('printertype', true),
			'origin'		=> 'BANDUNG',
			'date_in'		=> date('d/m/Y'),
			'status'		=> 'READY',
		];
		$this->db->insert('printer_backup', $form_data);
	}

	//jumlah data
	public function jumlahData()
	{
		$this->db->where('status', 'READY');
		return $this->db->count_all_results('printer_backup');
	}
}
