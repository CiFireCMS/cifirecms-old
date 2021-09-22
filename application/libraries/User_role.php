<?php 
/**
 *
 * - File    : User_role.php
 * - License : MIT License
 * - Author  : ViRa
 *
 * - Contoh pengunaan :
 *   user_role->access('user', 'module', 'read_access');
 *   user_role->access('user', 'module', 'write_access');
 *   user_role->access('user', 'module', 'upadate_access');
 *   user_role->access('user', 'module', 'delete_access');
 * 
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class User_role {

	public function __construct()
	{
		$this->CI =& get_instance();
	} 


	/**
	 * 
	 * - access
	 *
	 * @param  int     $level
	 * @param  string  $module
	 * @param  string  $mode
	 * @return bol
	 * 
	 *
	 * access('user', 'module', 'read_access');
	 * access('user', 'module', 'write_access');
	 * access('user', 'module', 'upadate_access');
	 * access('user', 'module', 'delete_access');
	 *
	 * - Access List:
	 *    read_access
	 *    write_access
	 *    upadate_access
	 *    delete_access
	*/
	public function access($level, $module, $mode)
	{
		$user_role = $this->CI->db
			->where('level',$level)
			->where('module',$module)
			->get('t_user_role')
			->row_array();

		$user_level = $this->CI->db
			->where('id', $level)
			->get('t_user_level')
			->row_array();

		if ($level === '1' || $user_level['level'] === 'super-admin') 
		{
			return TRUE;
		}

		if ($user_role[$mode] === 'Y') 
		{
			return TRUE;
		}
		
		return FALSE;
	}

} // End class