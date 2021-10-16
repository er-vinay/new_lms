<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class User_Model extends CI_Model
    {
        private $table = 'users';

    	public function login($data){
    		if(!empty($this->db->where($data)->get($this->table)->result_array())){
    			return $this->db->where($data)->get($this->table)->result_array();
    		}else{
    			return false;
    		}
    	}
    	
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


        
        public function getUser($user_id)
        {
            return $this->db->select('u.*')->where('u.user_id', $user_id)->from('users as u')->get();
        }
    	
    	public function updateUser($user_id, $data)
    	{
    	    return $this->db->where('users.user_id', $user_id)->update('users', $data);
    	}
    }