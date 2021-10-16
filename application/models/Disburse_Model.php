<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
    class Disburse_Model extends CI_Model
    {
    	function __construct()  
		{
			parent::__construct();
		}

		private $table = 'tbl_disburse';

		public function updateDisburse($lead_id, $data)
		{
			return $this->db->where($this->table.'.lead_id', $lead_id)->update($this->table, $data);
		}
		
		public function selectDisbursalDetails($fetch)
		{
			return $this->db->select($fetch)
							->where($this->table .'.loan_no !=', '')
							->from($this->table)
							->order_by($this->table .'.loan_id', 'desc')
							->limit(1)
							->get();
		}
    }
?>