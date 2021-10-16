<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    // require_once 'Task_Model.php';
    // $Tasks = new Task_Model;
    class Status_Model extends CI_Model
    {
        private $table = 'status_master';
    	
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
        
        public function join_table($conditions = null, $data = null, $table2 = null) {
            return $this->db->select($data)
                ->where($conditions)
                ->from($this->table.' S')
                ->join($table2. ' LD', 'LD.status = S.status')
                ->get();
        }
        
        public function getNewStatus($lead_id=null, $new_status=null) // algorithm get leads status
        {
            if($lead_id == null){ 
                // No status found
                $data = ['status' => "LEAD-NEW", 'stage' => 'S1'];
            } else if($lead_id != null && $new_status == null){ 
                // Current status found
                $conditions = "company_id='". company_id ."' AND product_id='". product_id ."' AND lead_id='". $lead_id ."'";
                $leadsDetails = $this->Tasks->select($conditions, "lead_id, status, stage");
                $leads = $leadsDetails->row();
                $data = ['status' => $leads->status, 'stage' => $leads->stage];
            } else {
                // New status found
                $conditions = "company_id='". company_id ."' AND product_id='". product_id ."' AND lead_id='". $lead_id ."'";
                $leadsDetails = $this->Tasks->select($conditions, "lead_id, status, stage");
                $leads = $leadsDetails->row();

                $status = $this->Status->join_table(['S.status' => $leads->status], 'S.id, S.status, S.stage', 'leads');
                $statusMaster = $this->Status->index();
                $statusArr = $statusMaster->result();

                $i = 0;
                $j = 0;
                $data = [];
                foreach ($statusArr as $row) 
                {
                    $i++;
                    if($j == 1){
                        $j += 1;
                    }
                    if($row->status == $leads->status){
                        $j = 1;
                    }
                    if($j == 2){
                        $data = ['status' => $row->status, 'stage' => $row->stage];
                        break;
                    }
                }
            }
            return $data;
        }

    }