<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Role {
	
	public function __construct()
	{
		$this->CI =& get_instance();
	} 


	private function key_group($key_login='')
	{
		$id_login = (empty($key_login)?decrypt($this->CI->session->userdata('key_id')):decrypt($key_login));
		// $id_login = ;
		$query = $this->CI->db
			->select('
			         t_user.key_group    AS  user_group,
			         t_user_group.group  AS  group,
			         t_user_group.pk     AS  key_group
			         ')
			->from('t_user')
			->where('t_user.id',$id_login)
			->join('t_user_group', 't_user_group.group = t_user.key_group', 'left')
			->get();

		if ($query->num_rows()==1)
		{
			return $query->row_array()['group'];
		}
		else
		{
			return NULL;
		}
	}

	
	public function access($module='', $role='', $key_login='')
	{
		if (!empty($key_login))
			$key_group = $key_login;
		else
			$key_group = group_active();

		if (group_active() == 'root')
		{
			return TRUE;
		}

		elseif (!empty($key_group) && !empty($module))
		{
			$get_role = $this->CI->db
				->where('group', $key_group)
				->where('module', $module)
				->get('t_roles')
				->row_array();

			if ($get_role[$role]==1)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
} // End class