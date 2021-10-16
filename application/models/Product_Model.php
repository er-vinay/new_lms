<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
    class Product_Model extends CI_Model
    {
		private $table = "tbl_product";

    	public function index($limit = null, $order_by = null) {
    	    return $this->db->select('*')->from($this->table)->limit($limit)->order_by($order_by)->get();
    	}

		public function select($company_id, $fetch)
		{
			return $this->db->select($fetch)->where('company_id', $company_id)->from($this->table)->get();
		}

		public function update($lead_id, $data)
		{
			return $this->db->where('leads.lead_id', $lead_id)->update('leads', $data);
		}
		
    }
?>