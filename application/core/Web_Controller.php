<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_Controller extends MY_Controller {

	public function __construct() 
	{
		parent::__construct();
		
		if ( get_setting('maintenance_mode') == 'Y' ) 
		{
			return show_maintenance();
		}
		else 
		{
			$this->set_cache();
			
			$this->load->library('web');
			$this->load->model('web/index_model');
			$this->theme_folder = theme_active('folder');

			$this->form_validation->set_error_delimiters('<div>*&nbsp; ', '</div>');
		}

		// Visitors.
		if ( get_setting('web_analytics') == 'Y' )
		{
			$this->get_visitors();
		} 
	}


	public function theme_asset($asset = '')
	{
		return content_url("themes/$this->theme_folder/$asset");
	}
	

	public function render_view($file = '', $data = NULL, $parm = FALSE)
	{
		$this->load->view("themes/$this->theme_folder/$file", $data, $parm);
	}


	public function render_404($data = NULL, $parm = FALSE)
	{
		$this->meta_title('404 Page Not Found');
		$this->meta_description('The page you requested was not found.');
		$this->load->view("themes/$this->theme_folder/404", $data, $parm);
	}


	public function load_menu($group_id = '', $ul = '', $ul_li = '', $ul_li_a ='', $ul_li_a_ul = '')
	{
		echo $this->menu->front_menu($group_id, $ul, $ul_li, $ul_li_a, $ul_li_a_ul);
		$this->menu->clear();
	}


	public function set_cache()
	{
		if ( get_setting('web_cache') == 'Y' )
		{
			$this->output->cache(get_setting('cache_time'));
		}
	}
} // End class.