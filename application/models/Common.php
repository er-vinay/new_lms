<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Common extends CI_Model
    {
    	public function add($table_name,$data)
    	{
    		if($table_name=='' || empty($data))
    		{
    			return false;
    		}
    		else
    		{
    			$this->db->insert($table_name,$data);
    			 $x=$this->db->insert_id();
    			 if($x!='')
    			 {
    			 	return $x;
    			 }else{
    			 	return false;
    			 }    		
    		}
    	}

    	public function get_all_data($table_name)
    	{
    		return $this->db->get($table_name)->result_array();
    	}

    	public function get_data_by_condition($table_name,$where)
    	{
    		return $this->db->where($where)->get($table_name)->result_array();
    	}

    	public function delete_data($table_name,$where)
    	{
    		$this ->db->where($where);
  			return $this ->db-> delete($table_name);
    	}

    	public function update_data($table_name,$where,$data)
    	{
    		$this->db->where($where);
    		return $this->db->update($table_name, $data);
    	}
    }