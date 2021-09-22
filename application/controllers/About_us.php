<?php defined('BASEPATH') OR exit('No direct script access allowed');

class About_us extends Web_controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('web/pages_model');
	}
	
	
	public function index($seotitle = 'about-us')
	{
		$check_seotitle = $this->pages_model->check_seotitle($seotitle);

		if ( !empty($seotitle) && $check_seotitle == TRUE ) 
		{
			$data = $this->pages_model->get_data($seotitle);
			$this->vars['result_pages'] = $data;

			$this->meta_title($data['title']);
			$this->meta_description(cut($data['content'], 150));
			$this->meta_image(post_images($data['picture'],'medium',TRUE));
			
			$this->render_view('about_us', $this->vars);
		}
		else
		{
			$this->render_404();
		}
	}
} // End class.