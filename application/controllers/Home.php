<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Web_Controller {

	public $vars;
	public $mod = 'home';

	public function __construct()
	{
		parent::__construct();

		$this->load->library('paging');
		$this->load->model('web/home_model');
	}
	

	public function index()
	{
		$this->vars['headline'] = $this->home_model->get_headline();
			

		$this->render_view('home', $this->vars);
	}
} // End Class