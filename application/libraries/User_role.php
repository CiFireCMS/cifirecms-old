<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_role {

	public function __construct()
	{
		$this->CI =& get_instance();
	} 


	public function access($pk, $module, $mode)
	{
		$key = xss_filter($pk,'sql');
		$get_user = $this->CI->db
			->select('level')
			->where('id', $key)
			->get('t_user')
			->row_array();
		
		$user_role = $this->CI->db
			->where('level', $key)
			->where('module', $module)
			->get('t_user_role')
			->row_array();

		$user_level = $this->CI->db
			->where('id', $get_user['level'])
			->get('t_user_level')
			->row_array();

		if ($key == 1 || $user_level['level'] == 'super-admin') 
		{
			return TRUE;
		}
		else if ($user_role[$mode] == 'Y') 
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function set($group='',$module='', $role='')
	{
		if ($group=='root')
		{
			return TRUE;
		}
		elseif (!empty($group) && !empty($module))
		{
			$getRole = $this->CI->db
				->where('group',$group)
				->where('module',$module)
				->get('t_roles')
				->row_array();

			if ($getRole[$role]==1)
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