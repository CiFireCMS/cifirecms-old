<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

	private $_table = 't_category';
	private $_column_order = array(null, 'title', 'seotitle', 'id_parent', 'active');
	private $_column_search = array('id', 'title', 'id_parent');

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Function datatable
	 *
	 * @param     string    $method (query method)
	 * @param     string    $mode ('data' or 'count')
	 * @return    void
	*/
	public function datatable($method, $mode = '')
	{
		if ($mode == 'count')
		{
			$this->$method();
			
			$result =  $this->db->get()->num_rows();
		}

		elseif (empty($mode) || $mode == 'data')
		{
			$this->$method();
			if ($this->input->post('length') != -1) 
			{
				$this->db->limit($this->input->post('length'), $this->input->post('start'));
				$query = $this->db->get();
			}
			else
			{
				$query = $this->db->get();
			}
			
			$result =  $query->result_array();
		}

		return $result;
	}


	private function _all_category()
	{
		$this->db->select('id,id_parent,title,seotitle,active');
		$this->db->from($this->_table);
		$this->db->where('id !=','1');

		$i = 0;	
		foreach ($this->_column_search as $item) 
		{
			if ( $this->input->post('search')['value'] )
			{
				if ( $i == 0 )
				{
					$this->db->group_start();
					$this->db->like($item, $this->input->post('search')['value']);
				}
				else
				{
					$this->db->or_like($item, $this->input->post('search')['value']);
				}

				if ( count($this->_column_search)-1 == $i ) 
				{
					$this->db->group_end(); 
				}
			}
			$i++;
		}
		
		if ( !empty($this->input->post('order')) ) 
		{
			$this->db->order_by(
				$this->_column_order[$this->input->post('order')['0']['column']], 
				$this->input->post('order')['0']['dir']
			);
		}
		else
		{
			$this->db->order_by('id','DESC');
		}
	}



	public function insert(array $data)
	{
		$this->db->insert($this->_table, $data);
	}


	public function update($id = 0, array $data)
	{
		$cek_id = $this->cek_id($id);
		if ($id > 1 && $cek_id == 1) 
		{
			$this->db->where('id', $id);
			$this->db->update($this->_table, $data);
			return TRUE;
		}
		else
			return FALSE;
	}


	public function delete($id = 0)
	{
		$cek_id = $this->cek_id($id);

		if ($id > 1 && $cek_id == 1) 
		{
			$this->db->where('id', $id)->delete($this->_table);
			$scp = $this->db->where('id_parent', $id)->get($this->_table)->row_array();
			$this->db->where('id_parent', $scp['id_parent'])->update($this->_table, array('id_parent'=>'0'));

			return TRUE;
		}
		else
			return FALSE;
	}


	public function all_category() 
	{
		$query = $this->db->where('id !=','1');
		$query = $this->db->order_by('id', 'DESC');
		$query = $this->db->get($this->_table);
		$query = $query->result_array();
		$return = $query;
	}


	public function get_category($id) 
	{
		if ($id == '1')
		{
			show_404();
		}

		$query = $this->db->where('id', $id);
		$query = $this->db->get($this->_table);
		$query = $query->row_array();

		return $query;
	}


	public function get_parent($id = 0)
	{
		$query = $this->db
			->select('id, title')
			->where_not_in('id', ['1', $id])
			->order_by('id', 'DESC')
			->get('t_category')
			->result_array();
		return $query;
	}


	public function get_parent_title($id = 0)
	{
		$cek_id = $this->cek_id($id);

		if ($id > 1 && $cek_id == 1) 
		{
			$query = $this->db
				->select('title')
				->where('id', $id)
				->get($this->_table)
				->row_array();
			$parent_title = $query['title'];
		}
		else
			$parent_title = '-';

		return $parent_title;
	}


	public function cek_id($id = 0)
	{
		$int = 0;
		if ( $id != 0 && !empty($id) )
		{
			$query = $this->db
				->select('id')
				->where('id', $id)
				->get($this->_table)
				->num_rows();

			if ( $query == 1 )
				$int = 1;
			else
				$int = 0;
		}

		return $int;
	}


	public function cek_seotitle($seotitle)
	{
		$query = $this->db->select('id,seotitle');
		$query = $this->db->where('seotitle', $seotitle);
		$query = $this->db->get($this->_table);
		$query = $query->num_rows();

		if ($query == 0)
			return TRUE;
		else
			return FALSE;
	}

	
	public function cek_seotitle2($id, $seotitle)
	{
		$query = $this->db->select('id,seotitle');
		$query = $this->db->where('seotitle', $seotitle);
		$query = $this->db->get($this->_table);

		if (
		    $query->num_rows() == '1' && 
		    $query->row_array()['id'] == $id || 
		    $query->num_rows() != '1'
		   ) 
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
} // End class.