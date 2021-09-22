<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings {
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
	}
} // End Class.