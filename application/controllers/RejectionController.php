<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	class RejectionController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
            $this->load->model('Task_Model', 'Tasks');
            $this->load->model('Admin_Model');
            $this->load->model('Users/Rejection_Model', 'Reject');
            $this->load->model('Users/Email_Model', 'Email');
            $this->load->model('Users/SMS_Model', 'SMS');
            $this->load->model('CAM_Model', 'CAM');
	        $this->load->library('encrypt');

	    	$login = new IsLogin();
	    	$login->index();
		}
        
		public function resonForRejectLoan()
		{
			if($this->input->post('user_id') == ''){
				$json['errSession'] = "Session Expired.";
				echo json_encode($json);
			}
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('lead_id', 'Lead ID', 'required|trim|numeric');
                $this->form_validation->set_rules('reason', 'Reject reason', 'required|trim');
	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
		            echo json_encode($json);
	        	} 
	        	else 
	        	{
	        	    $status = "REJECT";
                    $stage = "S9";
    				$lead_id = $this->input->post('lead_id');
    				$user_id = $this->input->post('user_id');
    				$customer_id = $this->input->post('customer_id');
    				$reason = $this->input->post('reson');

    	            $data = array (
    	                'status'           => $status,
                        'stage'            => $stage
    	            );
    	            $data2 = array (
    	            	'customer_id'		=> ($customer_id) ? $customer_id : "",
    	            	'lead_id'			=> $lead_id,
    	            	'user_id'			=> $user_id,
    	                'status'           	=> $status,
                        'stage'            	=> $stage,
                        'remarks'    		=> $_POST['reason'],
    	                'created_on'      	=> timestamp
    	            );

                    $conditions = ['lead_id' => $lead_id];
                    $result = $this->Tasks->updateLeads($conditions, $data, 'leads');
                    $result = $this->Tasks->insert($data2, 'lead_followup');
                    if($result == true)
                    {
                        $json['msg'] = 'Application Rejected Successfully.';
                    } else {
                        $json['err'] = 'Failed to Reject Application.';
                    }
                    echo json_encode($json);

    				$fetch = "first_name, email, mobile";
    				$conditions2 = ['customer_id' => $customer_id];
                    $leadsDetails = $this->Tasks->select($conditions2, $fetch, 'customer');
    				$leads = $leadsDetails->row();
                    
                    $rowMail = $this->Email->getMailAndSendTocustomer(company_id, product_id, $status);
                    if($rowMail->num_rows() > 0)
                    {
                        $mail = $rowMail->row();
                        $this->sentmail($leads, $mail);
                    }
                    
    				$rejectionSMS = $this->SMS->getRejectionSMS(company_id, product_id);
    				if($rejectionSMS->num_rows() > 0)
    				{
    				    $smsReject = $rejectionSMS->row();
    				    $rejectionSMS = $this->SMS->notification($leads->mobile, $smsReject->message);
    				}
	        	}
	        }else{
	            $json['err'] = "Lead Id is missing";
	            echo json_encode($json);
	        }
		}
	    
		public function getRejectionReasonMaster()
		{ 
		    if(product_id == 1)
		    {   
		        $product_id = 1;
    		    if($_SESSION['isUserSession']['labels'] == 'CR1'){
    		        $whereOnRole = 'user_access = "1" ';
    		    }else if($_SESSION['isUserSession']['labels'] == 'CR2'){
    		        $whereOnRole = 'user_access = "1" or user_access = "2"';
    		    }else if($_SESSION['isUserSession']['labels'] == 'CR3'){
    		        $whereOnRole = 'user_access = "3" ';
    		    }else if($_SESSION['isUserSession']['labels'] == 'DS1'){
    		        $whereOnRole = 'user_access = "4" ';
    		    }else{
    		        $whereOnRole = 'user_access = "1" or user_access = "2" or user_access = "3" or user_access = "4" ';
    		    }
		    }
		    else if(product_id == 2)
		    {
		        $product_id = 2;
    		    $whereOnRole = 'user_access = "1" ';
		    }
		    
		    $where = ' company_id = "'. company_id .'" and product_id = "'. $product_id .'" and status = "1" and ('.$whereOnRole .')';
		    $rejectionList = $this->Reject->getRejectionReasonMaster($where);
		    $data['rejectionLists'] = $rejectionList->result();
		    echo json_encode($data);
		}

		public function sentmail($leads, $mail)
		{
            $name = $leads->name;
            $to_email = $leads->email;
            $source = $leads->source;
            $mailRequest = 0;
            $message = "Dear ". $name .",<br><br><br>Greetings of the day.<br>Thank you for your recent loan application with ". $source .".<br> Your request for a loan was carefully considered, and we regret that we are unable to approve your application at this time. \nPlease note that this rejection does not reflect upon your financial status or spend pattern alone but the decision is made as a result of multiple checks on multiple parameters pre-defined for any such application. <br>Request you to re-apply some time in future for re-assessment of your application.<br><br><br>Thank you,<br><br>Team ". $source ." <br><br>";
            // <img src='https://loanagainstcard.com/assets/images/logo-final.png'>
            $authMail = $this->Email->getAuthMail(company_id, product_id);
            if($authMail->num_rows() > 0)
            {       
                $mailAuth = $authMail->row();
                
                $config['protocol']     = $mailAuth->protocol;
                $config['smtp_host']    = $mailAuth->smtp_host;
                $config['smtp_port']    = $mailAuth->smtp_port;
                $config['smtp_timeout'] = '7';
                $config['smtp_user']    = $mailAuth->smtp_user;
                $config['smtp_pass']    = $mailAuth->smtp_pass;
                $config['charset']    	= 'utf-8';
                $config['newline']    	= "\r\n";
                $config['mailtype'] 	= 'html';
                $config['validation'] 	= TRUE;
                $this->load->library('email');
                $this->email->initialize($config);
                $this->email->from($mail->from_email);
                $this->email->to($email);
                $this->email->bcc($mail->bcc);
                $this->email->subject($mail->subject);
                $this->email->message($message);
                if($this->email->send() == true)
                {
                    $mailRequest = 1;
                } 
            }
        	return $mailRequest;
		}
		
		public function rejectedTaskList()
	    {
	        $data['rejectedLists'] = $this->Tasks->rejectedTask();
	        $this->load->view('Tasks/RejectTaskList', $data);
	    }
	    
		public function rejectedLeadDetails($lead_id)
	    {
	        $rejectedLists = $this->Tasks->rejectedLeadDetails($lead_id);
	        echo json_encode($rejectedLists);
	    }
    }
?>