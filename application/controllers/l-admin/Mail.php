<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends Admin_controller {
	
	public $mod = 'mail';

	public function __construct() 
	{
		parent::__construct();
		
		$this->lang->load('mod/'.$this->mod, $this->_language);
		$this->meta_title(lang_line('mod_title'));
		$this->load->model('mod/mail_model');
	}


	public function index()
	{
		if ($this->read_access === TRUE)
		{
			$this->vars['all_message'] = $this->mail_model->all_message();
			$this->render_view('view_index', $this->vars);
		}
		else
		{
			return $this->render_404();
		}
	}


	public function data_table()
	{
		if ($this->input->is_ajax_request() == TRUE && $this->read_access == TRUE)
		{
			$data_list = $this->mail_model->get_datatables();
			$data_output = array();

			foreach ($data_list as $val) 
			{
				$row = [];
				$row[] = '<div class="text-center"><input type="checkbox" class="row_data" value="'. encrypt($val['id']) .'"></div>';

				if ($val['active'] == 'Y')
				{
					$row[] = '<div id="mico-'.$val['id'].'" class="text-muted"><i class="fa fa-envelope-open-o"></i></div>';
				} 
				else 
				{
					$row[] = '<div id="mico-'.$val['id'].'" class="text-primary"><i class="fa fa-envelope"></i></div>';
				}

				$row[] = $val['name'].'<br><small class="text-muted">'. $val['email'] .'</small>';
				$row[] = '<a href="'. admin_url($this->mod.'/read/'.$val['id']) .'">'. $val['subject'] .' <small class="text-muted"> - '. cut($val['message'], 80) .'</small></a>';
				$row[] = $val['date'];
				$row[] = '
				<div class="text-center"> 
					<div class="btn-group">
						<button type="button" class="button btn-xs btn-default delete_single" data-toggle="tooltip" data-placement="top" data-title="'.lang_line('button_delete').'" data-pk="'. encrypt($val['id']) .'"><i class="icon-bin"></i></button>
					</div> 
				</div>';
				$data_output[] = $row;
			}

			$output = array(
							"data" => $data_output,
							"draw" => $this->input->post('draw'),
							"recordsTotal" => $this->mail_model->count_all(),
							"recordsFiltered" => $this->mail_model->count_filtered()
						);

			$this->json_output($output);
		}
	}

	public function read($paramId = 0)
	{
		$id = xss_filter($paramId,'sql');
		if ( $this->mail_model->cek_id($id) == 1)
		{
			$data = $this->db->where('id',$id)->get('t_mail')->row_array();
			$this->vars['res_mail'] = $this->db->where('id',$id)->get('t_mail')->row_array();
			$this->render_view('view_read', $this->vars);
			$this->mail_model->update($id, array('active' => 'Y'));
		}
		else
		{
			return $this->render_404();
		}
	}
	

	public function delete()
	{
		if ($this->input->is_ajax_request() == TRUE)
		{
			$data_pk = $this->input->post('data');
			foreach ($data_pk as $key)
			{
				$pk = xss_filter(decrypt($key),'sql');
				$this->mail_model->delete($pk);
			}
			$response['success'] = true;
			$response['alert']['type'] = 'success';
			$response['alert']['content'] = lang_line('form_message_delete_success');
			$this->json_output($response);
		}
		else
		{
			return $this->render_404();
		}
	}


	public function reply($id = '')
	{
		$id = xss_filter($id, 'sql');
		$mail = $this->db->where('id', $id)->get('t_mail')->row_array();
		$this->vars['mail'] = $mail;
		
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
		{
			$isi = $this->input->post('content');

			$send = $this->send($mail['email'],$subject='reply',$isi);

			if ( $send === TRUE )
			{
				redirect(admin_url($this->mod));
			}
			else
			{
				echo "ERROR";
			}
		}
		$this->render_view('view_reply', $this->vars);
	}



	public function send($to,$subject,$isi)
	{
		/*$cc = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'anisacutey69@gmail.com',
			'smtp_pass' => '(MANAMANAJO)',
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE
		);*/

		$this->load->library('email');
		$this->email->initialize($this->settings->email_config());
		$this->email->set_newline("\r\n");
		$this->email->from('email@email.com', $this->settings->website('web_name')); //$this->settings->website('web_email')
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($isi);
		
		if($this->email->send(FALSE))
		{
			return TRUE;
		}
		else
		{
			show_error($this->email->print_debugger());
		}
	}
} // End Class.