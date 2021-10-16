<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class ForgetPasswordController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
            $this->load->model('Task_Model');
            $this->load->model('Admin_Model');

	    	date_default_timezone_set('Asia/Kolkata');
	        define("updated_at", date('Y-m-d H:i:s'));
		}

	    public function forgetPassword()
	    {
	    	$this->load->view('change_password');
	    }
	    
	    public function forgetOldPassword()
	    {
	      // $this->load->view('createNewAfterForgetPassword');
	       $this->load->view('change_new_password');
	    } 
	    
	    public function verifyotp()
	    {
	        echo "test";
	    }

	    public function verifyUser()
	    { 
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
	        	if($this->form_validation->run() == FALSE) {
	        		$this->session->set_flashdata('err', validation_errors());
		            return redirect(base_url('forgetPassword'), 'refresh');
	        	}else{
	        		$input_email = $this->input->post('email');
	        		$sql = $this->db->select('user_id, name, email, mobile, role')
	        			->where('email', $input_email)
	        			->get('users')->row();
					$user_id = $sql->user_id;
					$name = $sql->name;
					$email = $sql->email;
					$role = $sql->role;
					$otp = mt_rand(100000, 999999);
					$this->db->set('otp', $otp)->where('email', $email)->update('users');
					if($input_email == $email){
						$sessionData = [
		        			"user_id" 	=> $user_id,
		        			"name" 		=> $name,
		        			"email" 	=> $email,
		        			"role" 		=> $role,
		        		];
		        		$this->session->set_userdata('isUserSession', $sessionData); 
		        		$this->session->set_flashdata('msg', "OTP Sent To Registered mail Please Verify.");
    					$this->load->view('otpverify');
					}else{
		        		$this->session->set_flashdata('err', "Invalid Email, try once more.");
			            return redirect(base_url('forgetPassword'), 'refresh');
					}
	        	}
	        }
	    }

	}

?>