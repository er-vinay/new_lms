<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class CompanyController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
            $this->load->model('Task_Model');
            $this->load->model('Admin_Model');
            $this->load->model('Company_Model', 'company');

	    	$login = new IsLogin();
	    	$login->index();
	    	
	    	date_default_timezone_set('Asia/Kolkata');
	        define("updated_at", date('Y-m-d H:i:s'));
	        define("created_at", date('Y-m-d H:i:s'));
	        define("ipaddress", $ipaddress);
		}
	    
	    public function addCompanyDetails() 
	    {
	    	$fetch = 'company.*, u.name';
	    	$table2 = 'users';
	        $data['company'] = $this->company->join_table($fetch, $table2);
	    	$this->load->view('Company/addCompany', $data);
	    }

	    public function saveCompanyDetails() 
	    {
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
		    	$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
		    	$this->form_validation->set_rules('company_type', 'Company Type', 'trim');
	            $this->form_validation->set_rules('url', 'URL', 'trim');
	            $this->form_validation->set_rules('address', 'Address', 'trim');
	            $this->form_validation->set_rules('contact', 'Contact', 'trim|numeric');
	            if ($this->form_validation->run() == FALSE) 
	            {
                    $json['err'] = validation_errors();
                    echo json_encode($json);
	            }
	            else
	            {
	                $company_name = $this->input->post('company_name');
	                $company_type = $this->input->post('company_type');
	                $url = $this->input->post('url');
	                $address = $this->input->post('address');
	                $contact = $this->input->post('contact');
	                $company_id = $this->input->post('company_id');
	    	        if(empty($company_id))
	    	        {
    	                $data = array(
                            'company_name'			=>$company_name,
                            'company_type'			=>$company_type,
                            'url'		            =>$url,
                            'address'		        =>$address,
                            'company_contact'		=>$contact,
                            'created_by'	        =>$_SESSION['isUserSession']['user_id'],
                            'created_at'	        =>created_at
                        );
    
    	            	$result = $this->company->insert($data);
    	            	$json['msg'] = "Added Successfully";
	    	        } else {
	    	            $data = array(
                            'company_name'			=>$company_name,
                            'company_type'			=>$company_type,
                            'url'		            =>$url,
                            'address'		        =>$address,
                            'company_contact'		=>$contact,
                            'updated_by'	        =>$_SESSION['isUserSession']['user_id'],
                            'updated_at'	        =>created_at
                        );
                        $conditions = ['company_id' => $company_id];
    					$result = $this->company->update($conditions, $data);
    	            	$json['msg'] = "Updated Successfully";
	    	        }
                    echo json_encode($json);
	            }
	        } else {
	          	echo "Session Expired. Please login first.";
	          	$this->islogin();
	        } 
	    }

	    public function adminEditUser($user_id)
	    {
	    	$userRole = $this->Admin_Model->getUserRole();
    		$data['userRole'] = $userRole->result();
	    	$userBranch = $this->Admin_Model->getUserBranch();
    		$data['userBranch'] = $userBranch->result();
	        $rowUserDetails = $this->Admin_Model->getUserDetailById($user_id);
    		$data['userDetails'] = $rowUserDetails->row();

    		$this->load->view('Admin/editUser', $data);
	    }

	    public function adminUpdateUser() 
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
	               // print_r( $this->form_validation->error_array() );
	               echo "All fields required";
	            }
	            else
	            {
	                $userId = $this->input->post('userId');
	                $firstName = $this->input->post('firstName');
	                $lastName = $this->input->post('lastName');
	                $fullName = $firstName ." ". $lastName;
	                $email = $this->input->post('email');
	                $mobile = $this->input->post('mobile');
	                $userRole = $this->input->post('userRole');
	                $restrectedBranchUser = $this->input->post('restrectedBranchUser');
	                $centerName = $this->input->post('centerName');
	                $centerName = implode(", ",$centerName);

	                $data = array(
                        'name'			=>$fullName,
                        'email'			=>$email,
                        // 'password'		=>$hash,
                        'mobile'		=>$mobile,
                        'branch'		=>$restrectedBranchUser,
                        'role'			=>$userRole,
                        'center'		=>$centerName,
                        'status'		=>"Active",
                        'ip'			=>ip,
                        'updated_on'	=>created_at
                    );

	            	echo $result = $this->Admin_Model->adminUpdateUser($userId, $data);
	            }
	        } else {
	          	echo "Session Expired. Please login first.";
	        } 
	    }

	}

?>