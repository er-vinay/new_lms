<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
    class Admin_Model extends CI_Model
    {
    	private $t_role = 'tbl_user_role';

		public function getUser($user_id)
		{
            return $query = $this->db->select('u.*')->where('u.user_id', $user_id)->from('users u')->get();
		}

		// public function getUserDetails()  
		// {
		// 	$role = "";
		// 	if($_SESSION['isUserSession']['role'] == "Senction Head"){
		// 		$role = "Sanction & Telecaller";
		// 	}
		// 	$user_id = $_SESSION['isUserSession']['user_id'];
		// 	$agentDetails = $this->db->select('company_id')->where('user_id', $user_id)->get('users')->row();
  //           $company_id = $agentDetails->company_id;
            
  //           $stateList = $this->db->select('tb_states.id, tb_states.state')
  //               ->from('tb_states')->get()->result();
  //           foreach($stateList as $state){
	 //            $this->db->select('users.user_id, users.created_by, users.name, users.email, users.mobile, users.password,
	 //                    users.role, users.branch, users.center, users.status, users.created_on, tb_states.state')
	 //           // 	->where('users.created_by', $user_id)
	 //           // 	->where('users.company_id', $company_id)
	 //                ->from('users')
	 //                ->join('tb_states', 'users.branch = tb_states.id');
	 //            return $query = $this->db->order_by('users.user_id', 'desc')->get();
	 //        }
		// }

		public function getUserRole()  
		{
            return $this->db->select('role.role_id, role.name')->from($this->t_role.' role')->order_by('role.role_id', 'asc')->get();
		}

		public function getUserBranch()
		{
            return $this->db->select('tb_states.id, tb_states.state')->from('tb_states')->order_by('tb_states.id', 'asc')->get();
		}

		public function getUserDetailById($user_id)
		{
            $stateList = $this->db->select('tb_states.id, tb_states.state')->from('tb_states')->get()->row();

            $this->db->select('users.user_id, users.name, users.email, users.mobile, users.password, users.role, users.branch, users.center, users.status, users.created_on')
	            ->where('users.user_id', $user_id)
	            ->from('users');
            return $query = $this->db->order_by('users.user_id', 'desc')->get();
		}

		public function getUserProfileById($user_id)
		{
            $stateList = $this->db->select('tb_states.id, tb_states.state')
                ->from('tb_states')->get()->result();
            foreach($stateList as $state){
	            $this->db->select('u.user_id, u.name, u.email, u.mobile, u.password, u.dob, u.gender, u.marital_status, u.father_name, u.role, u.branch, u.center, 
	                u.status, u.created_on, tb_states.state') 
	            	->where('u.user_id', $user_id)
	                ->from('users as u')
	                ->join('tb_states', 'u.branch = tb_states.id');
	            return $query = $this->db->order_by('u.user_id', 'desc')->get();
	        }
		}
		
		public function adminUpdateUser($user_id, $data)
		{
            $result = $this->db->where('user_id', $user_id)->update('users', $data);
	        if($result == 1) {
	            return 1;
	        } else {
	            return 0;
	        }
		}
		
		public function addBankDetails($data)
		{
		    //print_r($data); exit;
		    $query = $this->db->insert('tbl_bank_details', $data);
		    print_r($query); exit;
	   
		}
    }
?>