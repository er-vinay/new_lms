<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class PortalController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
            $this->load->model('Task_Model');
            $this->load->model('Admin_Model');

	    	$login = new IsLogin();
	    	$login->index();
	    	$ipaddress = '';
		    if (getenv('HTTP_CLIENT_IP')){
		        $ipaddress = getenv('HTTP_CLIENT_IP');
		    }
		    else if(getenv('HTTP_X_FORWARDED_FOR')){
		        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		    }
		    else if(getenv('HTTP_X_FORWARDED')){
		        $ipaddress = getenv('HTTP_X_FORWARDED');
		    }
		    else if(getenv('HTTP_FORWARDED_FOR')){
		        $ipaddress = getenv('HTTP_FORWARDED_FOR');
		    }
		    else if(getenv('HTTP_FORWARDED')){
		       $ipaddress = getenv('HTTP_FORWARDED');
		    }
		    else if(getenv('REMOTE_ADDR')){
		        $ipaddress = getenv('REMOTE_ADDR');
		    }
		    else{
		        $ipaddress = 'UNKNOWN';
		    }

	    	date_default_timezone_set('Asia/Kolkata');
	        define("ipaddress", $ipaddress);
		}
	    
	    public function login() 
	    {
	        $data['url'] = 'loginPortal';
	    	$this->load->view('login', $data);
	    }

	    public function home()
	    {
            $company_id = $_SESSION['isUserSession']['company_id'];
            $product_id = $_SESSION['isUserSession']['product_id'];
            $data['menusList'] = $this->Menus->menusList($company_id, $product_id);
            $myArr = [];
            foreach ($data['menusList']->result() as $key) 
            {
                switch ($key->id) {
                    case 1:
                        $getLeadDetails = $this->Tasks->getLeadDetails(); 
                        array_push($myArr, $getLeadDetails->num_rows());
                        break;
                    case 2:
                        $applicationHold = $this->Tasks->applicationHold();
                        array_push($myArr, $applicationHold->num_rows());
                        break;
                    case 3:
                        $applicationinprocess = $this->Tasks->applicationinprocess();
                        array_push($myArr, $applicationinprocess->num_rows());
                        break;
                    case 4:
                        $getleadsforSanction = $this->Tasks->getleadsforSanction();
                        array_push($myArr, $getleadsforSanction->num_rows());
                        break;
                    case 5:
                        $sanctionHold = $this->Tasks->sanctionHold();
                        array_push($myArr, $sanctionHold->num_rows());
                        break;
                    case 6:
                        $inProcess = $this->Tasks->inProcess();
                        array_push($myArr, $inProcess->num_rows());
                        break;
                    case 7:
                        $recommend = $this->Tasks->recommend();
                        array_push($myArr, $recommend->num_rows());
                        break;
                    case 8:
                        $leadSendBack = $this->Tasks->leadSendBack();
                        array_push($myArr, $leadSendBack->num_rows());
                        break;
                    case 9:
                        $leadSanctioned = $this->Tasks->leadSanctioned();
                        array_push($myArr, $leadSanctioned->num_rows());
                        break;
                    case 10:
                        $rejectedTask = $this->Tasks->rejectedTask();
                        array_push($myArr, $rejectedTask->num_rows());
                        break;
                    case 11:
                        $leadDisbursed = $this->Tasks->leadDisbursed();
                        array_push($myArr, $leadDisbursed->num_rows());
                        break;
                    case 12:
                        // $Repayment = $this->Tasks->Repayment();
                        array_push($myArr, 0);
                        break;
                    case 13:
                        // $mis = $this->Tasks->mis();
                        array_push($myArr, 0);
                        break;
                    case 14:
                        // $accounts = $this->Tasks->accounts();
                        array_push($myArr, 0);
                        break;
                    case 15:
                        // $accounts = $this->Tasks->accounts();
                        array_push($myArr, 0);
                        break;
                }
            }
            $data['totalCounts'] = $myArr;
            $this->load->view('home', $data);
	    }
	    
	    public function loginPortal()
	    {
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|xss_clean');
	        	$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
	        	if($this->form_validation->run() == FALSE) {
	        		$this->session->set_flashdata('err', validation_errors());
		            return redirect(base_url(), 'refresh');
	        	}else{
	        	    $_POST = $this->security->xss_clean($_POST);
		        	$input_email = $_POST['email'];
		        	$input_password = MD5($_POST['password']);

		        	$sql = $this->db->select('user_id, company_id, product_id, name, email, password, role')
		        			->where('email', $input_email)
		        			->where('password', $input_password)
		        			->get('users');
        			$num_rows = $sql->num_rows();

					if($num_rows === 1)
					{
        				$row = $sql->row_array();
						$user_id = $row['user_id'];
						$db_name = $row['name'];
						$db_email = $row['email'];
						$db_password = $row['password'];
						$db_role = $row['role'];
						$product_id = $row['product_id'];
						$company_id = $row['company_id'];

						if($input_email == $db_email && $input_password == $db_password)
			        	{
			        		$sessionData = [
			        			"user_id" 	    => $user_id,
			        			"company_id"    => $company_id,
			        			"product_id"    => $product_id,
			        			"name" 		    => $db_name,
			        	// 		"email" 	    => $db_email,
			        			"role" 		    => $db_role,
			        		];
			        		
			        		$this->session->set_userdata('isUserSession', $sessionData);
			        		$this->db->where('user_id', $user_id)->update('users', ['status'=>"Active"]);
				            return redirect(base_url('home'), 'refresh');
			        	} 
			        	else
			        	{
				            return redirect(base_url(), 'refresh');
			        	}
					} else {
		        		$this->session->set_flashdata('err', "Invalid credentail, Try once more.");
				        return redirect(base_url(), 'refresh');
					}
				}
		    } else {
	            return redirect(base_url('home'), 'refresh');
	    	}
	    }

	    public function myProfile()
	    {
	    	if(!empty($_SESSION['isUserSession']['user_id']))
	    	{
		    	$user_id = $_SESSION['isUserSession']['user_id'];
		    	$userdata = $this->Admin_Model->getUserProfileById($user_id);
		    	$result = $userdata->row_array();

            	$centerName = explode(", ", $result['center']);
            	$cityArr = array();
		    	foreach($centerName as $city_id){
		    		$cityLists = $this->db->select('tb_city.city_id, tb_city.city')->where('city_id', $city_id)->get('tb_city')->row();
		    		$cityArr[] = $cityLists->city;
		    	}
            	$center = implode(",\n", $cityArr);
            	$centerNameArr = array("center" => $center);
            	$data['userDetails'] = array_merge($result, $centerNameArr);

		    	$this->load->view('profile', $data);
		    }else{
		    	$this->session->set_flashdata('err', "Session Expired, Try once more.");
		    	return redirect(base_url(), 'refresh');
		    }
	    }

	}

?>