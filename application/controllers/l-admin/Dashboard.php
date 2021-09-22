<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Backend_Controller {

	public $mod = 'dashboard';

	public function __construct()
	{
		parent::__construct();
		if ( !$this->read_access )
		{
			// show_403();
			redirect(admin_url('logout'));
		}
		$this->lang->load('mod/'.$this->mod);
		$this->load->model('mod/dashboard_model', 'Model');
		$this->meta_title(lang_line('mod_title'));

		if (ENVIRONMENT == 'development')
			$this->alert->set('ENV', 'default', lang_line('ui_environment_development_info').'<br/><small>CiFireCMS Version <a href="https://www.alweak.com/release" target="_blank" title="Build Version">'.$this->VERSION.'</a></small>',FALSE);
	}
	

	public function index()
	{
		$this->vars['h_post']       = $this->Model->card('post');
		$this->vars['h_category']   = $this->Model->card('category');
		$this->vars['h_tags']       = $this->Model->card('tag');
		$this->vars['h_pages']      = $this->Model->card('pages');
		$this->vars['h_theme']      = $this->Model->card('theme');
		$this->vars['h_component']  = $this->Model->card('component');
		$this->vars['h_mail']       = $this->Model->card('mail');
		$this->vars['h_users']      = $this->Model->card('user');

		$range = 6;
		for ($i = $range; $i >= 0; $i--) 
		{
			if ($i == 0) 
			{
				$visitorstemp = $this->db
					->where('date', date('Y-m-d'))
					->group_by('ip')
					->get('t_visitor')
					->result_array();

				$hitstemp = $this->db
					->select('SUM(hits) as hitstoday')
					->where('date', date('Y-m-d'))
					->group_by('date')
					->get('t_visitor')
					->row_array();
			} 
			else 
			{
				$visitorstemp = $this->db
					->where('date', date('Y-m-d', strtotime('-'.$i.' days')))
					->group_by('ip')
					->get('t_visitor')
					->result_array();

				$hitstemp = $this->db
					->select('SUM(hits) as hitstoday')
					->where('date', date('Y-m-d', strtotime('-'.$i.' days')))
					->group_by('date')
					->get('t_visitor')
					->row_array();
			}

			$arrvisitor[$i] = count($visitorstemp);
			$this->vars['arrhari'][$i] = '"'.ci_date(date('Y-m-d', strtotime('-'.$i.' days')), 'D, d M').'"';
			$arrhits[$i] = (empty($hitstemp['hitstoday']) ? '0' : $hitstemp['hitstoday']);
		}
		
		$this->vars['rvisitors'] = array_combine(array_keys($arrvisitor), array_reverse(array_values($arrvisitor)));
		$this->vars['rhits'] = array_combine(array_keys($arrhits), array_reverse(array_values($arrhits)));

		
		$this->render_view('view_index', $this->vars);
	}


	public function visitors()
	{
		$this->render_view('view_visitors', $this->vars);
	}


	public function _js_str($s)
	{
		return '"' . addcslashes($s, "\0..\37\"\\") . '"';
	}


	public function _js_array($array)
	{
		$temp = array_map(array($this, '_js_str'), $array);
		return '[' . implode(',', $temp) . ']';
	}


	public function setlang()
	{
		if ( $this->input->is_ajax_request() ) 
		{
			$session_lang['lang_active'] = $this->input->post('data');
			$this->session->set_userdata($session_lang);
			$response['status'] = true;
			$this->json_output($response);
		}
		else
		{
			show_404();
		}
	}
} // End Class.