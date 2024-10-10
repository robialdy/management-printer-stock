<?php

class Printer_Log_Model extends CI_Model
{
	public function read_data_group()
	{
		return $this->db->order_by('created_at', 'DESC')->where('status !=', '')->group_by('printer_sn')->get('printer_log')->result();
	}

	public function read_data($printer_sn)
	{
		return $this->db->order_by('created_at', 'DESC')
		->where('printer_sn', $printer_sn)
			->get('printer_log')
			->result();
	}
}
