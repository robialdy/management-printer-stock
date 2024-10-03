<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('time_ago')) {
	function time_ago($time)
	{
		$date = DateTime::createFromFormat('d/m/Y H:i:s', $time);

		// Convert the input time to a timestamp
		$time_ago = $date->getTimestamp();
		$time_now = time();
		$time_difference = $time_now - $time_ago;
		$seconds = $time_difference;
		$minutes = round($seconds / 60); // value 60 is seconds per minute
		$hours = round($seconds / 3600); // value 3600 is seconds per hour
		$days = round($seconds / 86400); // value 86400 is seconds per day
		$weeks = round($seconds / 604800); // value 604800 is seconds per week
		$months = round($seconds / 2629440); // value 2629440 is seconds per month
		$years = round($seconds / 31536000); // value 31536000 is seconds per year

		if ($seconds <= 60) {
			return 'baru saja';
		} else if ($minutes <= 60) {
			if ($minutes == 1) {
				return '1 menit lalu';
			} else {
				return $minutes . ' menit lalu';
			}
		} else if ($hours <= 24) {
			if ($hours == 1) {
				return '1 jam lalu';
			} else {
				return $hours . ' jam lalu';
			}
		} else if ($days <= 7) {
			if ($days == 1) {
				return 'kemarin';
			} else {
				return $days . ' hari lalu';
			}
		} else if ($weeks <= 4) {
			return $weeks . ' minggu lalu';
		} else {
			return $time;
		}
	}	
}
