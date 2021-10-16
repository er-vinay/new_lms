<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class AdminController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
            $this->load->model('Task_Model');
            $this->load->model('Admin_Model');
            $this->load->model('State_Model', 'states');
            $this->load->model('User_Model', 'user');
            $this->load->model('UserRole_Model', 'role');
            $this->load->model('Company_Model', 'company');
            $this->load->model('Product_Model', 'product');

	    	$login = new IsLogin();
	    	$login->index();
		}
	    
	    public function index() 
	    {
	    	$data['users'] = $this->user->index();
	    	$this->load->view('Admin/index', $data);
	    }

	    public function addUsers() 
	    {
	    	$user_id = ['user_id' => $_SESSION['isUserSession']['user_id']];
	    	$users = $this->user->select($user_id);
	    	$data['user'] = $users->row();
	    	$data['company'] = $this->company->index();
	    	$data['product'] = $this->product->index([$conditions => company_id]);
	    	$data['userRole'] = $this->role->index();
	    	$data['states'] = $this->states->index();
	    	$this->load->view('Admin/addUser', $data);
	    }

	    public function getUserCenter() 
	    {
	    	if(!empty($_POST['state_id']))
	    	{
	    		$data = 'id, city';
	    		$conditions = ['state_id' => $_POST['state_id']];
		    	$cityList = $this->states->getCity($conditions, $data);
	    		$cities = $cityList->result_array();
	    		echo json_encode($cities);
	    	}
	    }

	    public function adminSaveUser() 
	    {
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
		    	$this->form_validation->set_rules('firstName', 'First Name', 'trim|required');
		    	$this->form_validation->set_rules('lastName', 'Last Name', 'trim|required');
	            $this->form_validation->set_rules('email', 'Email', 'trim|required');
	            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
	            $this->form_validation->set_rules('userRole', 'User Role', 'trim|required');
	            $this->form_validation->set_rules('restrectedBranchUser', 'Branch', 'trim|required');
	            $this->form_validation->set_rules('centerName[]', 'Center Name', 'trim|required');
	            if ($this->form_validation->run() == FALSE) 
	            {
	               echo validation_errors();
	            }
	            else
	            {
	                $user_id = $this->input->post('user_id');
	                $company_id = $this->input->post('company_id');
	                $product_id = $this->input->post('product_id');
	                $firstName = $this->input->post('firstName');
	                $lastName = $this->input->post('lastName');
	                $fullName = $firstName ." ". $lastName;
	                $email = $this->input->post('email');
	                $mobile = $this->input->post('mobile');
	                $role_id = $this->input->post('userRole');

	                $roles = $this->role->select(['role_id' => $role_id]);
	                $rowRole = $roles->row();
	                $restrectedBranchUser = $this->input->post('restrectedBranchUser');
	                $centerName = $this->input->post('centerName');
	                $centerName = implode(", ", $centerName);
	                $password = ucfirst("loanwalle" .strtoupper(chr(rand(65, 90)) . chr(rand(65, 90)) . rand(100, 999)));
	    	        $hash = MD5($password);
	    	        
	                $data = [
                        'company_id'	=> $company_id,
                        'product_id'	=> $product_id,
                        'name'			=> $fullName,
                        'email'			=> $email,
                        'password'		=> $hash,
                        'mobile'		=> $mobile,
                        'branch'		=> $restrectedBranchUser,
                        'center'		=> $centerName,
                        'role_id'		=> $role_id,
                        'labels'		=> $rowRole->labels,
                        'role'			=> $rowRole->heading,
                        'status'		=> "Active",
                        'ip'			=> ip,
                        'created_by'	=> $user_id,
                        'created_on'	=> created_at
                    ];
			        if($this->user->insert($data)) {
			            echo 1;
			        } else {
			            echo 0;
			        }
	            }
	        } else {
	          	echo "Session Expired. Please login first.";
	          	$this->islogin();
	        } 
	    }

	    public function adminEditUser($user_id)
	    {
	    	$data['userRole'] = $this->role->index();
	    	$data['states'] = $this->states->index();
	        $users = $this->user->select(['user_id' => $user_id]);
	    	$data['user'] = $users->row();
	    	$data['company'] = $this->company->index();
	    	$data['product'] = $this->product->index([$conditions => company_id]);
    		$this->load->view('Admin/editUser', $data);
	    }

	    public function adminUpdateUser() 
	    {
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
		    	$this->form_validation->set_rules('userId', 'User ID', 'trim|required');
		    	$this->form_validation->set_rules('company_id', 'Company ID', 'trim|required');
		    	$this->form_validation->set_rules('product_id', 'Product ID', 'trim|required');
		    	$this->form_validation->set_rules('firstName', 'First Name', 'trim|required');
		    	$this->form_validation->set_rules('lastName', 'Last Name', 'trim|required');
	            $this->form_validation->set_rules('email', 'Email', 'trim|required');
	            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
	            $this->form_validation->set_rules('userRole', 'User Role', 'trim|required');
	            $this->form_validation->set_rules('restrectedBranchUser', 'Branch', 'trim|required');
	            if ($this->form_validation->run() == FALSE) {
	                echo "All fields required";
	            } else {
	                $user_id = $this->input->post('userId');
	                $company_id = $this->input->post('company_id');
	                $product_id = $this->input->post('product_id');
	                $firstName = $this->input->post('firstName');
	                $lastName = $this->input->post('lastName');
	                $fullName = $firstName ." ". $lastName;
	                $email = $this->input->post('email');
	                $mobile = $this->input->post('mobile');
	                $role_id = $this->input->post('userRole');
	                $restrectedBranchUser = $this->input->post('restrectedBranchUser');
	                $centerName = $this->input->post('centerName');
	                $status = $this->input->post('status');

	                $roles = $this->role->select(['role_id' => $role_id]);
	                $rowRole = $roles->row();
	                $data = array(
                        'company_id'	=> $company_id,
                        'product_id'	=> $product_id,
                        'name'			=> $fullName,
                        'email'			=> $email,
                        'mobile'		=> $mobile,
                        'branch'		=> $restrectedBranchUser,
                        'role_id'		=> $role_id,
                        'labels'		=> $rowRole->labels,
                        'role'			=> $rowRole->heading,
                        'status'		=> $status,
                        'ip'			=> ip,
                        'updated_on'	=> created_at
                    );
	                if(isset($centerName)){
	                	$data = array_merge($data, ['center' => implode(",",$centerName)]);
		            }
	            	echo $result = $this->user->update(['user_id' => $user_id], $data);
	            }
	        } else {
	          	echo "Session Expired. Please login first.";
	        } 
	    }

	    public function adminTaskSetelment()
	    {
	    	echo "Admin <pre>"; print_r($_POST); exit;
	    }

	}

?>