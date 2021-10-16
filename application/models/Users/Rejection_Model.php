<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	 
    class Rejection_Model extends CI_Model
    {
        private $table = 'tbl_rejection_master';
        
		public function getRejectionReasonMaster($where) 
		{
	        return $this->db->select('*')->where($where)->from($this->table)->get();
		}
    }
?>