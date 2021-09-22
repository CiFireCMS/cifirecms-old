<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_Controller extends MY_Controller {
	
	public $mod;
	public $mod_view;
	public $_language;

	protected $read_access;
	protected $write_access;
	protected $modify_access;
	protected $delete_access;

	public function __construct()
	{
		parent::__construct();

		if ( login_status() == FALSE ) // Login FALSE
		{
			redirect(admin_url('login'));
		}
		
		else // login TRUE
		{
			$this->lang->load('general/menu_lang'); // load menu lang
			
			// $this->set_access(); // set user access.
			$this->__role_access(); // set user access.

			$this->_act = !empty($this->input->post('act')) ? $this->input->post('act') : NULL;

			$this->form_validation->set_error_delimiters('<div>*&nbsp;', '</div>');

			// $this->vars['a_login_key'] = login_key();
			$this->vars['a_site_url']  = site_url();
			$this->vars['a_admin_url'] = site_url(FADMIN.'/');
			$this->vars['a_content_url']  = content_url();
			$this->vars['a_fcontent']  = CONTENTPATH;
			$this->vars['a_mod'] = $this->mod;
			$this->vars['a_act'] = (!empty($this->uri->segment(3)) ? "/".$this->uri->segment(3) : "");
			$this->vars['a_datatable_lang'] = content_url('plugins/datatable/lang/'.lang_active().'.json');
			$this->vars['a_system_lang']    = content_url('plugins/json/lang/'.lang_active().'.json');
		}

		// var_dump($this->read_access);
		// var_dump($_SESSION);
	}


	protected function __role_access()
	{
		$this->read_access = $this->role->access($this->mod,'read_access');
		$this->write_access = $this->role->access($this->mod,'write_access');
		$this->delete_access = $this->role->access($this->mod,'delete_access');
		$this->modify_access = $this->role->access($this->mod,'modify_access');
		return $this;
	}

	public function global_access($mod)
	{
		$read_access = $this->user_role->access(login_key('admin'), $mod, 'read_access');
		$write_access = $this->user_role->access(login_key('admin'), $mod, 'write_access');
		$delete_access = $this->user_role->access(login_key('admin'), $mod, 'delete_access');
		$modify_access = $this->user_role->access(login_key('admin'), $mod, 'modify_access');

		if (
		    $read_access == FALSE || 
		    $write_access == FALSE || 
		    $delete_access == FALSE || 
		    $modify_access == FALSE
		    )
		{
			show_404();
		}
	}



	/*
	public function render_viewX($view = '', array $data, $parm = FALSE)
	{
		$this->mod_view = $view;
		$this->load->view('admin/index', $data, $parm);
	}
	*/


	public function render_view($view = '', array $data, $parm = FALSE)
	{
		$mod = $this->mod;
		$view_file = "$view.php";
		$view_path = VIEWPATH . "mod/$this->mod/$view_file";
		if ($view && file_exists($view_path))
		{
			$this->load->view('admin/header', $data, $parm);
			$this->load->view('mod/'.$this->mod.'/'.$view, $data, $parm);
			$this->load->view('admin/footer', $data, $parm);
		}
		else
		{
			show_error("mod/$this->mod/$view_file");
		}
	}



	public function render_400()
	{
		// $this->mod_view = 'error400';
		$this->load->view('admin/header', $this->vars);
		$this->load->view('admin/error_400', $this->vars);
		$this->load->view('admin/footer', $this->vars);

	}


	public function render_403()
	{
		// $this->mod_view = 'error403';
		$this->load->view('admin/header', $this->vars);
		$this->load->view('admin/error_403', $this->vars);
		$this->load->view('admin/footer', $this->vars);
	}


	public function render_404()
	{
		// $this->mod_view = 'error404';
		$this->load->view('admin/header', $this->vars);
		$this->load->view('admin/error_404', $this->vars);
		$this->load->view('admin/footer', $this->vars);
	}

	/*
	public function load_admin_content()
	{
		if ($this->mod_view == 'error403') 
		{
			$this->load->view('admin/error_403');
		}
		elseif ($this->mod_view == 'error404') 
		{
			$this->load->view('admin/error_404');
		}
		elseif ($this->mod_view && file_exists(VIEWPATH . "mod/".$this->mod."/".$this->mod_view.".php"))
		{
			$this->load->view('mod/'.$this->mod.'/'.$this->mod_view);
		}
		else
		{
			$this->load->view('admin/error_404');
		}
	}
	*/

	public function ds_notif($type = '', $data = FALSE)
	{
		$result = '';

		if ($type == 'mail')
		{
			if ($data == TRUE) {
				$result = $this->db
					->where('box', 'in')
					->order_by('id', 'DESC')
					->limit(5)
					->get('t_mail')
					->result_array();
			}
			else {
				$result = $this->db->where('active', 'N')->where('box', 'in')->get('t_mail')->num_rows();
			}
		}
		
		elseif ($type == 'comment')
		{
			$result = $this->db->where('active', 'N')->get('t_comment')->num_rows();
		}

		return $result;
	}


	public function m_filter($str, $segment = 3) 
	{
		if ($this->uri->segment($segment) === $str)
			show_404();
	}
} // End class.