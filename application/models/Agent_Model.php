<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
    class Agent_Model extends CI_Model{
    	function __construct()  
		{
			parent::__construct();  
		}

		public function index($agent_id)  
		{
			$query = $this->db->where('id', $agent_id)->get('tbl_agent')->row_array();
			return $query;
		}

		public function select()  
		{
			$query = $this->db->where('email', $_SESSION['email'])->get('tbl_agent')->row_array();
			return $query;
		}

		public function current_date()  
		{
			return $query = date_default_timezone_set('Asia/Kolkata');
		}
    }
?>