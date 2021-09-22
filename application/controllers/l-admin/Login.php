<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public $vars;
	public $mod = 'login';

	public function __construct()
	{
		parent::__construct();

		$this->CI =& get_instance();

		$this->load->helper(array(
								// 'inflector',
								'form',
								// 'html',
								'security',
								//'file',
								'string',
								//'download',
								//'directory',
								// 'text',
		                    	));

		$this->load->library(array(
		                     'settings',
		                     'user_role',
		                     'alert'
		                     ));

		$this->load->model('admin_login_model', 'login_model');

		$this->form_validation->set_error_delimiters('<div><small>*&nbsp;', '</small></div>');

		$this->vars['input_uname'] = encrypt('username');
		$this->vars['input_pwd'] = encrypt('password');
	}


	public function index()
	{
		// echo encrypt($str = '123456');
		if (login_status('admin') == TRUE)
		{
			redirect(admin_url('home'), 'refresh');
		}
		else
		{		
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				return $this->_submit();
			}
			else
			{
				$this->load->view('admin/login', $this->vars);
			}
		}
	}

	public function ajax_cek() 
	{
		if ($this->input->is_ajax_request() == TRUE)
		{
			$data = xss_filter($this->input->post('data'), 'xss');
			$output =  $this->login_model->ajax_cek($data);
			echo json_encode($output);

		}
	}

	private function _submit($name=null,$value=null)
	{
		foreach ($this->input->post() as $key => $val)
		{
			$name .= $key.',';
			$value .= $val.',';
		}

		$input_name = explode(',', $name);
		$input_value = explode(',', $value);


		if (
		    decrypt($input_name[0]) == decrypt($this->vars['input_uname']) && 
		    decrypt($input_name[1]) == decrypt($this->vars['input_pwd'])
		    )
		{

			$this->form_validation->set_rules(array(array(
					'field' => $input_name[0],
					'label' => 'Username',
					'rules' => 'required|trim|min_length[4]|max_length[20]|regex_match[/^[a-z0-9_.]+$/]',
			)));

			$this->form_validation->set_rules(array(array(
					'field' => $input_name[1],
					'label' => 'Password',
					'rules' => 'required|min_length[6]|max_length[20]',
			)));

			if ($this->form_validation->run() == TRUE) 
			{
				$data_input = array(
					'username' => $this->input->post($input_name[0]),
					'password' => encrypt($this->input->post($input_name[1]))
				);

				$cek_data_input = $this->login_model->cek_login($data_input);

				if ($cek_data_input == TRUE)
				{
					$get_user = $this->login_model->get_user($data_input);

					$this->session->log_admin = array(
						'key'    => $get_user['id'],
						'access' => encrypt(random_string(16)),
						'level'  => $get_user['level']
					);

					redirect(admin_url('home'), 'refresh');
				}

				else
				{
					$this->alert->set('login', 'danger', 'Log In error.');
					redirect(uri_string());
				}
			}
			
			else
			{
				$this->alert->set('login', 'danger', validation_errors());
				redirect(uri_string());
			}
		}
		
		else
		{
			return show_400();
		}
	}




	public function forgot()
	{
		$this->load->view('admin/forgot', $this->vars);
	}


	private function _cek_username($username = '') 
	{
		$cek_username = $this->login_model->cek_username($username);

		if ($cek_username == '0') 
		{
			$this->form_validation->set_message('_cek_username', '{field} error.');
			return FALSE;
		}
		if ($cek_username == '1')
		{
			return TRUE;
		}
	}



	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url(FADMIN), 'refresh');
	}
} // End Class.