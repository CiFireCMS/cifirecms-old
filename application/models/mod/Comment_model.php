<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_model extends CI_Model {

	private $_table = 't_comment';
	private $_column_order = array(null, 'name', 'date','active');
	private $_column_search = array('name', 'date', 'active');

	public function __construct()
	{
		parent::__construct();
	}


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


	private function _all_comment()
	{
		$this->db->select('id,id_user,id_post,parent,name,email,date,active');
		$this->db->from($this->_table);


		$i = 0;	
		// loop column 
		foreach ($this->_column_search as $item) 
		{
			if ($this->input->post('search')['value']) // if datatable send POST for search
			{
				if ($i === 0) // first loop
				{
					$this->db->group_start();
					$this->db->like($item, $this->input->post('search')['value']);
				}
				else
				{
					$this->db->or_like($item, $this->input->post('search')['value']);
				}

				if (count($this->_column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if (!empty($this->input->post('order'))) 
		{
			$this->db->order_by(
				$this->_column_order[$this->input->post('order')['0']['column']], 
				$this->input->post('order')['0']['dir']
			);
		}
		else
		{
			$this->db->order_by('id', 'DESC');
		}
	}


	public function insert($data)
	{
		$this->db->insert($this->_table, $data);
	}


	public function update($id, $data)
	{
		$this->db->where('id',$id)->update($this->_table, $data);
	}


	public function delete($id)
	{
		$cek_id = $this->cek_id($id);

		if ( $cek_id == 1 ) 
		{
			$this->db->where('id', $id)->delete($this->_table);
			$respon = TRUE;
		}
		else
		{
			$respon = FALSE;
		}

		return $respon;
	}


	public function block_comment($id=0)
	{
		$cek_id = $this->cek_id($id);

		if ( $cek_id == 1 ) 
		{
			$this->update($id, array("active"=>"X"));
			$respon = TRUE;
		}
		else
		{
			$respon = FALSE;
		}

		return $respon;
	}


	public function unblock_comment($id=0)
	{
		$cek_id = $this->cek_id($id);

		if ( $cek_id == 1 ) 
		{
			$this->update($id, array("active"=>"Y"));
			$respon = TRUE;
		}
		else
		{
			$respon = FALSE;
		}

		return $respon;
	}


	public function get_comment($id) 
	{
		if ( $this->cek_id($id) == 1 )
		{
			$result = $this->db->where('id',$id)->get($this->_table)->row_array();
			return $result;
		}
		else
		{
			return NULL;
		}
	}


	public function get_post($id_post)
	{
		$table = 't_post';
		$cek_post = $this->db->where('id',$id_post)->get($table)->num_rows();

		if ( $cek_post == 1 )
		{
			$result_post = $this->db
				->select('id,title,seotitle')
				->where('id',$id_post)
				->get($table)
				->row_array();

			return $result_post;
		}
	}


	public function cek_id($id = 0)
	{
		$id = xss_filter($id,'sql');
		$query = $this->db
			->select('id')
			->where('id', $id)
			->get($this->_table);

		$result = $query->num_rows();
		$int = (int)$result;
		
		return $int;
	}
} // End class.