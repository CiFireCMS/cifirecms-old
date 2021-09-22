<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag extends Backend_Controller {

	public $mod = 'tag';

	public function __construct() 
	{
		parent::__construct();
		
		$this->lang->load('mod/'.$this->mod);
		$this->meta_title(lang_line('mod_title'));
		$this->load->model('mod/tag_model');
	}


	public function index()
	{
		$this->meta_title(lang_line('mod_title_all'));

		if ( $this->read_access )
		{
			if ( $this->input->is_ajax_request() )
			{
				if ($this->input->post('act') == 'delete')
				{
					return $this->_delete();
				}

				else
				{
					$data = array();

					foreach ($this->tag_model->datatable('_all_tag', 'data') as $val) 
					{
						$row = [];

						$row[] = '<div class="text-center"><input type="checkbox" class="row_data" value="'. encrypt($val['id']) .'"></div>';
						$row[] = $val['title'];
						$row[] = $val['tag_count'];
						$row[] = '<div class="text-center"><button type="button" class="btn btn-xs btn-white delete_single" data-toggle="tooltip" data-placement="top" data-title="'. lang_line('button_delete') .'" data-pk="'. encrypt($val['id']) .'"><i class="cificon licon-trash-2"></i></button></div>';

						$data[] = $row;
					}

					$this->json_output(['data' => $data, 'recordsFiltered' => $this->tag_model->datatable('_all_tag', 'count')]);
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


	public function add()
	{
		$this->meta_title(lang_line('mod_title_add'));

		if ( $this->write_access )
		{
			if ( $this->input->is_ajax_request() )
			{
				$data = xss_filter($this->input->post('data'), 'xss');
				$tags = explode(',', $data);
				// var_dump($tags);exit;
				
				if (!empty(clean_tag($data)))
				{
					foreach ($tags as $key)
					{
						$title = clean_tag($key);
						$seotitle = seotitle($key,'');
						if ( !empty($title) && $this->tag_model->cek_seotitle($seotitle) == TRUE )
						{
							$this->tag_model->insert(array(
								'title' => $title,
								'seotitle' => $seotitle
							));
						}
					}

					$this->alert->set($this->mod, 'info', lang_line('form_message_add_success'));
					$response['success'] = true;
					$this->json_output($response);
				}
				else
				{
					$response['success'] = false;
					$response['alert']['type'] = 'error';
					$response['alert']['content'] = lang_line('form_message_submit_error');
					$this->json_output($response);
				}
			}
			else
			{
				$this->render_view('view_add', $this->vars);
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
				$this->tag_model->delete($pk);
			}

			$response['success'] = true;
			$response['alert']['type']    = 'success';
			$response['alert']['content'] = lang_line('form_message_delete_success');
			return $this->json_output($response);
		} 
		else
		{
			$response['success'] = false;
			$response['alert']['type']    = 'error';
			$response['alert']['content'] = 'ERROR';
			return $this->json_output($response);
		}
	}
} // End class.