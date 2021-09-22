<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {

	public $vars;

	public function __construct()
	{
		parent::__construct();
		
		$this->CI =& get_instance();
		
		if ($this->settings->website('maintenance') == 'N')
			redirect('home');
	}
	

	public function index()
	{
		$this->vars['website_name'] = $this->settings->website('web_name');
		$this->vars['tanggal']      = substr($this->settings->website('maintenance_time'), 0, 2);
		$this->vars['bulan']        = substr($this->settings->website('maintenance_time'), 3, 2);
		$this->vars['tahun']        = substr($this->settings->website('maintenance_time'), 6, 4);
		$this->vars['jam']          = substr($this->settings->website('maintenance_time'), 11, 2);
		$this->vars['menit']        = substr($this->settings->website('maintenance_time'), 14, 2);
		$this->load->view('maintenance/index', $this->vars);
	}
}