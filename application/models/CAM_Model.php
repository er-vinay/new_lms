<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
    class CAM_Model extends CI_Model
    {
    	function __construct()  
		{
			parent::__construct();
		}

		private $table = 'tbl_cam';
        
        public function select($conditions, $data = null) {
            return $this->db->select($data)->where($conditions)->from($this->table)->get();
        }
        
        public function insert($data) {
            return $this->db->insert($this->table, $data);
        }
        
        public function update($conditions, $data) {
            return $this->db->where($conditions)->update($this->table, $data);
        }

		public function updateCAM($lead_id, $data)
		{
			return $this->db->where($this->table.'.lead_id', $lead_id)->update($this->table, $data);
		}
        
        public function delete($conditions) {
            return $this->db->where($conditions)->delete($this->table);
        }

        public function join_table($conditions = null, $data = null, $table2 = null, $table3 = null) 
        {
            return $this->db->select($data)
                ->where($conditions)
                ->from($this->table.' LD')
                ->join($table2, 'DS.lead_id = LD.lead_id')
                ->join($table3, 'ST.state_id = LD.state_id')
                ->get();
        }
		
    }
?>