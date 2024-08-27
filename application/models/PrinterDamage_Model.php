<?php

class PrinterDamage_Model extends CI_Model
{
 public function readData()
 { 
    $this->db->select('printer_damage.*, printer_backup.origin, printer_backup.date_in, printer_backup.type_printer, printer_backup.printer_sn, agen.cust_id, agen.agen_name, agen.type_cust');
    $this->db->from('printer_damage');
    $this->db->join('printer_backup', 'printer_damage.id_printer = printer_backup.id_printer');
    $this->db->join('agen', 'printer_damage.id_agen = agen.id_agen');
    $this->db->order_by('printer_backup.date_in', 'DESC'); 
    $query = $this->db->get();
    return $query->result();
 }

	
	public function insertData()
	{
		$form_data = [
			
			'id_printer'=> $this->input->post('printersn', true),
			'id_agen'	=> $this->input->post('agenname', true),
            'pic_it'	=> $this->input->post('picit', true),
			'date_perbaikan'=> date('d/m/Y / H:i:s'),
			'biaya_perbaikan' =>$this->input->post('biayaperbaikan',true),
            'status_pembayaran'=>$this->input->post('statuspembayaran',true),
			'created_at'=> date('d M Y / H:i:s'),
			'update_at'=>date('d M Y / H:i:s'),
		];
		$this->db->insert('printer_damage', $form_data);
	}
	
	public function jumlahData()
	{
		
		return $this->db->count_all_results('printer_damage');
	}

	public function jumlah()
	{
		return $this->db->count_all_results('printer_damage');
	}

	public function updateData()
    {
		$data = [
			'biaya_perbaikan' => $this->input->post('biayaper', true),
			'status_pembayaran' => $this->input->post('status_pembayaran', true),
		];
		$id = $this->input->post('id');

        $this->db->where('id_damage', $id);
        $this->db->update('printer_damage', $data);
    }

	
	public function dateTime()
{
    $this->db->order_by('created_at', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get('printer_damage');
    return $query->row();
}

    
	
}