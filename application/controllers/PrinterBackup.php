<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PrinterBackup extends CI_Controller
{

	public function index()
	{
		$this->load->view('printerBackup/printer_backup');
	}
}
