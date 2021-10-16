<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
    class Payment_Model extends CI_Model{
    	function __construct()  
		{
			parent::__construct();
            $this->load->model('Agent_Model');
		}

		public function select_this_month_sale()  
		{
			date_default_timezone_set('Asia/Kolkata');
			$updated_at = date('m');

            $agent_details = $this->Agent_Model->select();
			$query = $this->db->select('SUM(total_price)')
					->where('agent_id', $agent_details['id'])
					->where('MONTH(created_at)', date('m'))
					->where("(notification = '0' OR notification = '1' OR status = 'Approved')")
					->get('tbl_payment')->row_array();
			return $query;
		}
		public function total_sale()  
		{
            $agent_details = $this->Agent_Model->select();
			$query = $this->db->select('SUM(total_price)')
					->where("(notification = '0' OR notification = '1' OR status = 'Approved')")
					->where('agent_id', $agent_details['id'])
					->get('tbl_payment')->row_array();
			return $query;
		}
    }
?>