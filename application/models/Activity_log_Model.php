<?php

class Activity_log_Model extends CI_Model
{
	public function sendUserLog($id_user, $ip, $os, $browser)
	{
		$form_data = [
			'id_user'		=> $id_user,
			'ip_address'	=> $ip,
			'os'			=> $os,
			'browser'		=> $browser,
			'login_at'		=> date('Y-m-d H:i:s'),
		];
		$this->db->insert('activity_log', $form_data);
	}

	public function readData($start_date, $end_date)
	{
		$this->db->select('users.username, users.role, activity_log.*');
		$this->db->from('activity_log');
		$this->db->join('users', 'activity_log.id_user = users.id_user');
		$this->db->order_by('activity_log.login_at', 'DESC');
		$this->db->where('activity_log.login_at >=', $start_date . ' 00:00:00');
		$this->db->where('activity_log.login_at <=', $end_date . ' 23:59:59');
		$query = $this->db->get();

		return $query->result();
	}


}
