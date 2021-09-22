<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_login_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function cek_login($input)
    {
        $return = FALSE;
        
    	$cek = $this->db
            ->where("BINARY username = '".decrypt($input['username'])."'", NULL, FALSE)
            ->where('level','4')
            ->where('active','Y')
            ->get('t_user');

        if ((int)$cek->num_rows() == 1)
        {
            $row = $cek->row_array();

            if (decrypt($row['password']) == decrypt($input['password'])) 
            {
               $return = TRUE;
            }
            else
            {
               $return = FALSE;
            } 
        }

        return $return;
    }

    public function get_user($input)
    {
        return $this->db->where("BINARY username = '".decrypt($input['username'])."'", NULL, FALSE)->get('t_user')->row_array();
    }
}