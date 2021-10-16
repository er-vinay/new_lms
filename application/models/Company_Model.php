<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Company_Model extends CI_Model
    {
        private $table = 'company_login';
    	
    	public function index($limit = null, $order_by = null) {
    	    return $this->db->select('*')->from($this->table)->limit($limit)->order_by($order_by)->get();
    	}
        
        public function select($conditions, $data = null) {
            return $this->db->select($data)->where($conditions)->from($this->table)->get();
        }
        
        public function insert($data) {
            return $this->db->insert($this->table, $data);
        }
        
        public function update($conditions, $data) {
            return $this->db->where($conditions)->update($this->table, $data);
        }
        
        public function delete($conditions) {
            return $this->db->where($conditions)->delete($this->table);
        }
        
        public function join_table($data, $table2=null) {
            return $this->db->select($data)->from($this->table .' company')
                ->join($table2. ' u', 'u.user_id = company.created_by')
                ->get();
        }
    }