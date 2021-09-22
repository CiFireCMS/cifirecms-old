<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends Backend_Controller {

	public $mod = 'comment';
	public $pk;

	public function __construct() 
	{
		parent::__construct();
		
		$this->lang->load('mod/'.$this->mod);
		$this->load->model('mod/comment_model');
		$this->meta_title(lang_line('mod_title'));
	}


	public function index()
	{
		$this->meta_title(lang_line('mod_title_all'));

		if ( $this->read_access )
		{
			if ( $this->input->is_ajax_request() )
			{
				$submit_act = $this->input->post('act');

				if ($submit_act == 'delete')
				{
					return $this->_delete();
				}

				elseif ($submit_act == 'active' || $submit_act == 'banned')
				{
					return $this->_block();
				}

				else
				{
					$data = array();

					foreach ($this->comment_model->datatable('_all_comment', 'data') as $val) 
					{
						$row = [];

						$row[] = '<div class="text-center"><input type="checkbox" class="row_data" value="'. encrypt($val['id']) .'"></div>';

						$post = $this->db->select('title, seotitle')
									     ->where('id', $val['id_post'])
									     ->get('t_post')
									     ->row_array();

						$row[] = $val['name'].' - '.$val['email']. '<br>'. lang_line('_post'). ': <a href="'.post_url($post['seotitle']).'" class="text-primary" target="_blank">'.$post['title'].'</a>';
						
						$row[] = ci_date($val['date'], 'd M Y | h:i A');

						if ($val['active'] == 'N') {
							$valactive = '<span id="cstatus_'.$val['id'].'" class="badge badge-primary">New</span>';
						}
						else if ($val['active'] == 'X') {
							$valactive = '<span id="cstatus_'.$val['id'].'" class="badge badge-outline-danger">Banned</span>';
						}
						else {
							$valactive = '<span id="cstatus_'.$val['id'].'" class="badge badge-outline-success">'.lang_line('ui_publish').'</span>';
						}

						$row[] = $valactive;



						if ($val['active'] == 'X') 
						{
							$btn_ctoggle = '<button type="button" id="btn_ctoggle" class="btn btn-xs btn-white btn_ctoggle ctoggle'.$val['id'].'" data-act="active" data-pk="'.encrypt($val['id']).'" data-toggle="tooltip" data-placement="top" data-title="'.lang_line('button_active').'"><i class="cificon licon-check-circle"></i></button>';
						}
						else
						{
							$btn_ctoggle = '<button type="button" id="btn_ctoggle" class="btn btn-xs btn-white btn_ctoggle ctoggle'.$val['id'].'" data-act="banned" data-pk="'.encrypt($val['id']).'" data-toggle="tooltip" data-placement="top" data-title="'.lang_line('button_ban').'"><i class="cificon licon-slash"></i></button>';
						}

						
						$row[] = '<div class="text-center"> <div class="btn-group">
						 <button type="button" class="modal_detail btn btn-xs btn-white" data-toggle="tooltip" data-placement="top" data-title="'.lang_line('button_view').'" idDet="'.$val['id'].'"><i class="cificon licon-eye"></i></button>

						 <a href="'.admin_url($this->mod.'/reply/'.$val['id']).'" class="btn btn-xs btn-white" data-toggle="tooltip" data-placement="top" data-title="'.lang_line('button_reply').'"><i class="cificon licon-edit-3"></i></a> 

						'.$btn_ctoggle.'

						<button type="button" class="btn btn-xs btn-white delete_single" data-toggle="tooltip" data-placement="top" data-title="'.lang_line('button_delete').'" data-pk="'. encrypt($val['id']) .'"><i class="cificon licon-trash-2"></i></button>
						 </div> </div>';

						$data[] = $row;
					}

					$this->json_output(['data' => $data, 'recordsFiltered' => $this->comment_model->datatable('_all_comment', 'count')]);
				}
			}
			else
			{
				$this->render_view('view_index', $this->vars);
			}
			
		}
		else
		{
			show_403();
		}
	}


	public function reply($id='')
	{
		$this->meta_title(lang_line('_reply_comment'));

		if ($this->read_access && $this->write_access)
		{
			$id = xss_filter($id,'sql');
			$result_comment = $this->comment_model->get_comment($id);
			

			if (!is_null($result_comment))
			{
				$this->vars['result'] = $result_comment;
				$this->vars['post'] = $this->db->select('title,seotitle')->where('id',$result_comment['id_post'])->get('t_post')->row_array();

				if ($_SERVER['REQUEST_METHOD']=='POST' && $this->input->post('act')=='reply')
				{
					$parent = ($result_comment['parent']!=0?$result_comment['parent']:$result_comment['id']);
					$data = array(
						'id_post' => $result_comment['id_post'],
						'parent'  => $parent,
						'id_user' => decrypt(login_key()),
						'name'    => data_login('name'),
						'email'   => data_login('email'),
						'comment' => xss_filter($this->input->post('comment')),
						'ip'      => $this->CI->input->ip_address(),
						'active'  => 'Y',
					);

					$this->comment_model->insert($data);

					redirect(admin_url($this->mod));
				}

				$this->render_view('reply', $this->vars);
			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_403();
		}
	}


	private function _delete()
	{
		if ($this->delete_access)
		{
			$data = $this->input->post('data');

			foreach ($data as $key)
			{
				$pk = xss_filter(decrypt($key),'sql');
				$this->comment_model->delete($pk);
			}

			$response['success'] = true;
			$response['alert']['type']    = 'success';
			$response['alert']['content'] = lang_line('form_message_delete_success');
			$this->json_output($response);
		} 
		else
		{
			$response['success'] = false;
			$response['alert']['type']    = 'error';
			$response['alert']['content'] = 'ERROR';
			$this->json_output($response);
		}
	}

	private function _block()
	{
		if ($this->modify_access)
		{
			$pk = decrypt($this->input->post('pk'));
			$act = $this->input->post('act');

			if ($act == 'banned')
			{
				$this->comment_model->update($pk,['active'=>'X']);
				$response['success'] = TRUE;
				$response['pk'] = $pk;
				$response['act'] = 'active';
				$response['status-class'] = 'badge badge-outline-danger';
				$response['status-text'] = lang_line('ui_banned');
				$response['icon'] = 'cificon licon-check-circle';
				$response['tooltip-text'] = lang_line('button_active');
				$this->json_output($response);
			}

			else if ($act == 'active')
			{
				$this->comment_model->update($pk,['active'=>'Y']);
				$response['success'] = TRUE;
				$response['pk'] = $pk;
				$response['act'] = 'banned';
				$response['status-class'] = 'badge badge-outline-success';
				$response['status-text'] = lang_line('ui_publish');
				$response['icon'] = 'cificon licon-slash';
				$response['tooltip-text'] = lang_line('button_ban');
				$this->json_output($response);
			}
		}
		else
		{
			show_403();
		}
	}


	public function view_detail($id = '')
	{
		if ( $this->read_access )
		{
			if ( !empty($id) && $this->input->is_ajax_request() && $this->read_access && $this->modify_access) 
			{
				
				$id = xss_filter($id, 'sql');
				$result = $this->comment_model->get_comment($id);
				$_output = $result;
				$_output['comment'] = $result['comment'];
				$_output['date'] = ci_date($result['date'], 'd M Y | h:i A');
				$_output['link'] = '<hr><div class="text-right"><a href="'.admin_url($this->mod.'/reply/'.$id).'" class="btn btn-sm btn-primary"><i class="cificon licon-edit-3 mr-2"></i>'.lang_line('button_reply').'<a></div>';
				
				if ($_output['active'] == "X") 
				{
					$_output['class'] = "badge badge-outline-danger";
					$_output['text'] = lang_line('ui_banned');
				}
				else
				{
					$this->comment_model->update($id, array('active'=>'Y'));
					$_output['class'] = "badge badge-outline-success";
					$_output['text'] = lang_line('ui_publish');
				}

				$this->json_output($_output);
			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_403();
		}
	}

} // End class.