<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menumanager extends Backend_Controller {
	
	public $mod = 'menumanager';
	public $dirout = 'mod/menumanager/';
	public $act;

	public function __construct() 
	{
		parent::__construct();
		if ( !$this->read_access || !$this->write_access || !$this->modify_access || !$this->delete_access )
		{
			show_403();
		}

		$this->lang->load('mod/'.$this->mod);
		$this->meta_title(lang_line('mod_title'));
	}


	public function index() 
	{
		if ( $this->read_access && $this->write_access )
		{
			$grids = xss_filter($this->input->get('group_id'),'sql');

			if ( !empty($grids) )
				$_get_group_id = $grids;
			else 
				$_get_group_id = 1;

			$group_id = 1;

			if (isset($_get_group_id)) 
			{
				$this->vars['group_id'] = (int)$_get_group_id;
				$$group_id = (int)$_get_group_id;
			}

			$cari_id = 1;

			$grids = xss_filter($this->input->get('group_id'), 'sql');

			if ( !empty($grids) )
				$group_ids = $grids;
			else 
				$group_ids = 1;

			$menu = $this->db
				->where('group_id',$group_ids)
				->order_by('position','ASC')
				->get('t_menu')
				->result_array();
			
			$this->vars['menu_ul'] = '<ul id="easymm"></ul>';

			foreach ($menu as $row) 
			{
				$this->_add_row(
					$row['id'],
					$row['parent_id'],
					' id="menu-'.$row['id'].'" class="sortable"',
					$this->_get_label($row)
				);
			}

			$this->vars['menu_ul']     = $this->_generate_list('id="easymm"');
			$this->vars['group_id']    = $group_id;
			$this->vars['group_title'] = $this->_get_menu_group_title($group_id);
			$this->vars['menu_groups'] = $this->_get_menu_groups($group_id);
			
			$this->render_view('view_menumanager', $this->vars);
		}
		else
		{
			show_403();
		}
	}


	private function _add_row($id, $parent, $li_attr, $label) 
	{
		$this->vars[$parent][] = array('id' => $id, 'li_attr' => $li_attr, 'label' => $label);
	}


	private function _generate_list($attr = '', $attrss = '') 
	{
		return $this->_ul(0, $attr, $attrss);
	}
	

	private function _ul($parent = 0, $attr = '', $attrss = '') 
	{
		static $i = 1;

		$indent = str_repeat("\t\t", $i);

		if (isset($this->vars[$parent])) 
		{
			if ( $attr )
				$attr = ' ' . $attr;

			if ( $attrss )
				$attrss = ' ' . $attrss;

			$html = "\n$indent";
			$html .= "<ul $attr>";
			$i++;

			foreach ($this->vars[$parent] as $row) 
			{
				$child = $this->_ul($row['id'], $attrss);
				$html .= "\n\t$indent";
				$html .= '<li'. $row['li_attr'] . '>';
				$html .= $row['label'];

				if ( $child )
				{
					$i--;
					$html .= $child;
					$html .= "\n\t$indent";
				}

				$html .= '</li>';
			}
			$html .= "\n$indent</ul>";

			return $html;
		} 
		else 
		{
			return FALSE;
		}
	}


	public function add_menu_group()
	{
		if ( ! $_POST )
		{
			$this->load->view($this->dirout.'templates/menu_group_add', $this->vars);
		}

		elseif ($this->input->post('act') == 'add') 
		{
			$post_title = xss_filter($this->input->post('title',TRUE),'xss');
			if (!empty($post_title)) 
			{
				if ($this->db->insert('t_menu_group', array('title' => $post_title))) 
				{
					$id_self = $this->db->insert_id();
					
					$this->db->insert('t_menu', array(
						'title'    => 'Menu Title',
						'url'      => '',
						'class'    => '',
						'group_id' => $id_self,
						'position' => '1',
						'active'   => 'N',
					));
					
					$response['status'] = 1;
					$response['id'] = $id_self;
				} 
				else 
				{
					$response['status'] = 2;
					$response['msg'] = 'Add menu group error.';
				}
			} 
			else 
			{
				$response['status'] = 3;
			}
			
			header('Content-type: application/json');
			echo json_encode($response);
		}

		else
		{
			show_404();
		}
	}


	public function edit_menu_group() 
	{
		if ( $this->input->is_ajax_request() && $this->modify_access )
		{
			$post_title = xss_filter($this->input->post('title',TRUE),'xss');
			if ( !empty($post_title) )
			{
				$id = xss_filter($this->input->post('id'),'sql');
				$dataTitle = trim($post_title);
				$cek = $this->db->where('id',$id)->get('t_menu_group')->num_rows();
				
				if ($cek==1)
				{
					$update = $this->db->where('id',$id)->update('t_menu_group', array('title' => $dataTitle));
					$response['success'] = true;
				}
				else
				{
					$response['success'] = false;
				}
				
				header('Content-type: application/json');
				echo json_encode($response);
			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_404();
		}
	}


	public function delete_menu_group() 
	{
		if ( $this->input->is_ajax_request() && $this->delete_access )
		{
			$ID = xss_filter($this->input->post('id'),'sql');
			$cek = $this->db->select('id')->where('id',$ID)->get('t_menu_group')->num_rows();
			if ( !empty($ID) && $cek==1 && $ID>1 ) 
			{
				$id = $ID;
				
				if ( $ID == 1 ) 
				{
					$response['success'] = false;
					$response['msg'] = 'Cannot delete Group ID = 1';
				} 
				else 
				{
					$del_group = $this->db->where('id', $ID)->delete('t_menu_group');
					
					if ( $del_group ) 
					{
						$this->db->where('group_id', $ID)->delete('t_menu');
					}

					$response['success'] = true;
				}

				$this->output
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($response, JSON_PRETTY_PRINT))
					->_display();
				exit;
			}
			else
			{
				$response['success'] = false;
				$response['msg'] = 'ERROR';
				$this->output
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($response, JSON_PRETTY_PRINT))
					->_display();
				exit;
			}
		}
		else
		{
			show_404();
		}
	}


	public function add_single_menu() 
	{
		if ( $this->input->is_ajax_request() && $this->write_access)
		{
			$gid = xss_filter($this->input->post('gid',TRUE),'sql');
			$query_lp = $this->db->select_max('position')
				->where('group_id', 0)
				->get('t_menu')
				->row_array();

			$postition = is_null($query_lp['position']) ? 1 : $query_lp['position'] + 1;
			// var_dump($postition);exit;

			$this->db->insert('t_menu', array(
				'title'    => xss_filter($this->input->post('title'),'xss'),
				'url'      => xss_filter($this->input->post('url')),
				'class'    => stripcslashes(htmlspecialchars($this->input->post('class') ,ENT_QUOTES)),
				'active'   => ($this->input->post('active')=='Y'?'Y':'N'),
				'group_id' => $gid,
				'position' => $postition
			));

			$li_id = 'menu-'.$this->db->insert_id();
			
			$data['id']     = $this->db->insert_id();
			$data['title']  = xss_filter($this->input->post('title'),'xss');
			$data['url']    = xss_filter($this->input->post('url'));
			$data['class']  = xss_filter($this->input->post('class'),'xss');
			$data['active'] = ($this->input->post('active')=='Y'?'Y':'N');

			$response['status'] = 1;
			$response['li']     = '<li id="'.$li_id.'" class="sortable">'.$this->_get_label($data).'</li>';
			$response['li_id']  = $li_id;
			$response['gid']    = $gid;
			$response['msg']    = 'Success';

			$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response, JSON_PRETTY_PRINT))
				->_display();
			exit;
		}
		else
		{
			show_404();
		}
	}


	function editsinglemenu() 
	{
		if ( $this->input->is_ajax_request() && $this->modify_access)
		{
			if ( $this->input->post('acc') == 'editsinglemenu' ) 
			{
				$id = xss_filter($this->input->post('menu_id'),'sql');
				$cek = $this->db->select('id')->where('id',$id)->get('t_menu')->num_rows();
				
				if ($cek==1)
				{
					$data = array(
						'title'  => xss_filter($this->input->post('title'),'xss'),
						'url'    => xss_filter($this->input->post('url')),
						'class'  => stripcslashes(htmlspecialchars($this->input->post('class') ,ENT_QUOTES)),
						'active' => ($this->input->post('active')=='Y'?'Y':'N')
					);
					
					$this->db->where('id', $id)->update('t_menu', $data); // update

					$response['menu'] = $data;
					$response['status'] = 1;
					$response['gid'] = $this->input->post('g_id');
					
					$this->output
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode($response, JSON_PRETTY_PRINT))
						->_display();
					exit;
				}
				else
				{
					$response = "ERROR";
					$this->output
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode($response, JSON_PRETTY_PRINT))
						->_display();
					exit;
				}
			}

			else
			{
				$this->vars['title'] = $this->input->get('id');

				$this->vars['res_menu'] = $this->db
					->where('id',$this->input->get('id'))
					->get('t_menu')
					->row();

				$this->load->view($this->dirout.'templates/menu_edit', $this->vars);
			}
		}
		else
		{
			show_404();
		}
	}
	

	public function savemenuposition() 
	{
		if ($this->write_access)
		{
			$easymm = $this->input->post('easymm');
			return $this->_update_position(0, $easymm);
		}
	}


	private function _update_position($parent, $children) 
	{
		$i = 1;

		foreach ($children as $k => $v) 
		{
			$id = (int)$children[$k]['id'];
			$data = array(
				'parent_id' => $parent,
				'position' => $i
			);
			
			$this->db->where('id',$id)->update('t_menu',$data); // update

			if (isset($children[$k]['children'][0])) 
			{
				$this->_update_position($id, $children[$k]['children']);
			}
			
			$i++;
		}
	}


	public function deletesinglemenu() 
	{
		if ( $this->input->is_ajax_request() && $this->delete_access)
		{
			$id = xss_filter($this->input->post('id'),'sql');
			$del_menu = $this->db->where('id', $id)->delete('t_menu');
			
			$response['success'] = false;

			if ($del_menu) 
			{
				$this->_del_childs($id);
				$response['success'] = true;
			}
			
			$this->output->set_content_type('application/json', 'utf-8')->set_output(json_encode($response, JSON_PRETTY_PRINT))->_display();
			exit;
		}
	}
	

	private function _del_childs($id)
	{
		$ids = $this->db->where('parent_id', $id)->get('t_menu')->result_array();
		foreach ($ids as $key) 
		{
			$this->db->where('id', $key['id'])->delete('t_menu');
			$this->_del_childs($key['id']);
		}
	}


	private function _get_label($row) 
	{
		$img_edit  = content_url('images/menu/edit.png');
		$img_cross = content_url('images/menu/cross.png');
		$label =
			'<div class="ns-row">' .
				'<div class="ns-title">'.$row['title'].'</div>' .
				'<div class="ns-url">'.$row['url'].'</div>' .
				'<div class="ns-class">'.$row['class'].'</div>' .
				'<div class="ns-active">'.$row['active'].'</div>' .
				'<div class="ns-actions">' .
					'<a href="#" class="edit-menu" title="Edit Menu">' .
						'<img src="'.$img_edit.'" alt="Edit">' .
					'</a>' .
					'<a href="#" class="delete-menu" data-token="'.$this->security->get_csrf_hash().'">' .
						'<img src="'.$img_cross.'" alt="Delete">' .
					'</a>' .
					'<input type="hidden" name="menu_id" value="'.$row['id'].'">' .
					'<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'">' .
				'</div>' .
			'</div>';
			
		return $label;
	}


	private function _get_menu_group_title($group_id) 
	{
		$result = $this->db->where('id', $group_id)->get('t_menu_group')->row_array();
		return $result;
	}
	

	private function _get_menu_groups($group_id) 
	{	
		$result = $this->db->where('id',$group_id)->get('t_menu_group')->row_array();
		return $result;
	}
} // End Class.