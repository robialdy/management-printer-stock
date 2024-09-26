<?php

class PrinterList_Model extends CI_Model
{
	public function read_data()
	{
		$this->db->select('printer_list_inagen.*, printer_backup.origin, printer_backup.date_in, printer_backup.printer_sn, customers.cust_id, customers.cust_name, customers.type_cust, type_printer.name_type');
		$this->db->from('printer_list_inagen');
		$this->db->join('customers', 'printer_list_inagen.id_cust = customers.id_cust');
		$this->db->join('printer_backup', 'printer_list_inagen.id_printer = printer_backup.id_printer');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type'); // Join dari printer_backup ke type_printer
		$this->db->order_by('printer_list_inagen.date_out', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	// SUMMARY
	public function read_data_summary()
	{

		$printer_types = $this->type_printer();
		// COUNT(printer_list_inagen.id_printer) as total_printers,
		$this->db->select('
        customers.cust_id, 
        customers.cust_name, 
        customers.type_cust,
		customers.origin_id, 
        customers.origin_name, 
        printer_backup.origin,
        printer_backup.date_in,
        type_printer.name_type,
		printer_list_inagen.*
    ');

		foreach ($printer_types as $type) {
			$name_type = str_replace('-', '_', $type->name_type);
			$this->db->select("SUM(CASE WHEN type_printer.name_type = '$type->name_type' THEN 1 ELSE 0 END) as total_{$name_type}");
		}


		$sum_parts = [];
		foreach ($printer_types as $type) {
			$name_type = str_replace('-', '_', $type->name_type);
			$sum_parts[] = "SUM(CASE WHEN type_printer.name_type = '$type->name_type' THEN 1 ELSE 0 END)";
		}
		$sum_expression = implode(' + ', $sum_parts);
		$this->db->select("($sum_expression) as total_printer");

		$this->db->from('printer_list_inagen');
		$this->db->join('customers', 'printer_list_inagen.id_cust = customers.id_cust');
		$this->db->join('printer_backup', 'printer_list_inagen.id_printer = printer_backup.id_printer');
		$this->db->join('type_printer', 'printer_backup.id_type = type_printer.id_type');
		$this->db->group_by('customers.cust_id');
		$this->db->order_by('printer_list_inagen.date_out', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}



	// type printer judul
	public function type_printer()
	{
		return $this->db->select('type_printer.name_type')->from('type_printer')->get()->result();
	}



}
