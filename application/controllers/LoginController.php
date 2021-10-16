<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class LoginController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
            $this->load->model('Admin_Model');
            $this->load->model('Task_Model', 'Tasks');
            $this->load->model('Users/Menu_Model', 'Menus');
            $this->load->model('User_Model');
            $this->load->database('fintechc_ftc_vincrm');

            if(isset($_SESSION['isUserSession']['email']) && $_SESSION['isUserSession']['email'] == NULL) {
            	return redirect(base_url());
            }
		}

	    public function islogin()
	    {	
	    	if(isset($_SESSION['isUserSession']['email']) && $_SESSION['isUserSession']['email'] == NULL) {
            	return redirect(base_url());
            } else {
            	$isEmail = MD5(date('Y-m-d h:i:s').$_SESSION['isUserSession']['email']);
            	echo json_encode($isEmail);
            }
	    }

	    public function login()
	    {
	        $data['url'] = 'dashboard';
	    	$this->load->view('login', $data);
	    }

	    public function home($labels)
	    {
    		$labelname = $this->encrypt->decode($labels);
        	$where = "company_id=".company_id." AND product_id=".product_id;
        	// $data['leadDetails'] = $this->Tasks->getleadsforSanction();
        	
	        switch ($labelname){
	            case 'SA': // Super Admin
					$data['menusList'] = $this->Menus->menusList($where);
					$stage = $data['menusList']->result_array();
					foreach($stage as $st)
					{
						$leadsCount[] = $this->Tasks->getLeadsCount($st['stage']);
					}
					$data['leadcount']=$leadsCount;
	            	return $this->load->view('home', $data);
	                break;
	            case 'CA': // Client Admin
					$where .= " AND is_active='1' OR user_labels='SA'";
					$data['menusList'] = $this->Menus->menusList($where);
					$stage = $data['menusList']->result_array();
					foreach($stage as $st)
					{
						$leadsCount[] = $this->Tasks->getLeadsCount($st['stage']);
					}
					$data['leadcount']=$leadsCount;
	            	return $this->load->view('home', $data);
	                break;
				case 'CR1': // Credit (Screener)
					$where .= " AND is_active='1' AND (user_labels='CR1' OR user_labels='SA')";
					$data['menusList'] = $this->Menus->menusList($where);
					$stage = $data['menusList']->result_array();
					foreach($stage as $st)
					{
						$leadsCount[] = $this->Tasks->getLeadsCount($st['stage']);
					}
					$data['leadcount']=$leadsCount;
	            	return $this->load->view('home', $data);
	                break;
	            case 'CR2': // Credit (Credit Manager)
					$where .= " AND is_active='1' AND (user_labels='CR2' OR user_labels='SA')";
					$data['menusList'] = $this->Menus->menusList($where);
					$stage = $data['menusList']->result_array();
					foreach($stage as $st)
					{
						$leadsCount[] = $this->Tasks->getLeadsCount($st['stage']);
					}
					$data['leadcount']=$leadsCount;
	            	return $this->load->view('home', $data);
	                break;
	            case 'CR3': // Credit (Credit Head)
					$where .= " AND is_active='1' AND (user_labels='CR1' OR user_labels='CR2' OR user_labels='CR3' OR user_labels='SA')";
					$data['menusList'] = $this->Menus->menusList($where);
					$stage = $data['menusList']->result_array();
					foreach($stage as $st)
					{
						$leadsCount[] = $this->Tasks->getLeadsCount($st['stage']);
					}
					$data['leadcount']=$leadsCount;
	            	return $this->load->view('home', $data);
	                break;
	            case 'DS1': // Disbursal (Disbursal Team)
					$where .= " AND is_active='1' AND (user_labels='DS1' OR user_labels='CR3' OR user_labels='SA')";
					$data['menusList'] = $this->Menus->menusList($where);
					$stage = $data['menusList']->result_array();
					foreach($stage as $st)
					{
						$leadsCount[] = $this->Tasks->getLeadsCount($st['stage']);
					}
					$data['leadcount']=$leadsCount;
	            	return $this->load->view('home', $data);
	                break;
	            case 'CO1': // collection (collection Team)
					$where .= " AND is_active='1' AND (user_labels='CO1' OR user_labels='CO2' OR user_labels='CO3' OR user_labels='SA')";
					$data['menusList'] = $this->Menus->menusList($where);
					$stage = $data['menusList']->result_array();
					foreach($stage as $st)
					{
						$leadsCount[] = $this->Tasks->getLeadsCount($st['stage']);
					}
					$data['leadcount']=$leadsCount;
	            	return $this->load->view('home', $data);
	                break;
	            case 'AC1': // collection (collection Team)
					$where .= " AND is_active='1' AND (user_labels='CO1' OR user_labels='CO2' OR user_labels='CO3' OR user_labels='SA')";
					$data['menusList'] = $this->Menus->menusList($where);
					$stage = $data['menusList']->result_array();
					foreach($stage as $st)
					{
						$leadsCount[] = $this->Tasks->getLeadsCount($st['stage']);
					}
					$data['leadcount']=$leadsCount;
	            	return $this->load->view('home', $data);
	                break;
	            default:
	                return redirect(base_url());
	                break;
	        }
	    }
	    
	    public function dashboard()
	    {	
	    	$role = '';
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
	        	$this->form_validation->set_rules('password', 'Password', 'required|trim');
	        	if($this->form_validation->run() == FALSE) {
	        		$this->session->set_flashdata('err', validation_errors());
		            return redirect(base_url(), 'refresh');
	        	}else{
		        	$input_email = $_POST['email'];
		        	$input_password = MD5($_POST['password']);

		        	$sql = $this->db->select('user_id, company_id, product_id, name, email, password, role, labels')
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
						$labels = $row['labels'];
						$product_id = $row['product_id'];
						$company_id = $row['company_id'];

						if($input_email == $db_email && $input_password == $db_password)
			        	{
			        		$role = $db_role;
			        		$sessionData = [
			        			"user_id" 	    => $user_id,
			        			"company_id"    => $company_id,
			        			"product_id"    => $product_id,
			        			"name" 		    => $db_name,
			        			"role" 		    => $role,
			        			"labels" 		=> $labels,
			        		];
			        		$this->session->set_userdata('isUserSession', $sessionData);
			        		$this->db->where('user_id', $user_id)->update('users', ['status'=>"Active"]);
				            return redirect(base_url('home/'. $this->encrypt->encode($labels)), 'refresh');
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
	            return redirect(base_url('home/'. $this->encrypt->encode($_SESSION['isUserSession']['labels'])), 'refresh');
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

	    public function changePassword()
	    {
	    	if(!empty($_SESSION['isUserSession']['user_id']))
	    	{
		    	$data['sessionEmail'] = $_SESSION['isUserSession']['email'];

		    	$this->load->view('change_new_password', $data);
		    }
	    }

	    public function generatePassword()
	    {
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('password', 'Password', 'required|trim');
	        	if($this->form_validation->run() == FALSE) {
	        		$this->session->set_flashdata('err', validation_errors());
		            return redirect(base_url('changePassword'), 'refresh');
	        	}else{
					if(!empty($_SESSION['isUserSession']['user_id']))
		        	{
						$user_id = $_SESSION['isUserSession']['user_id'];
		        		$input_password = $this->input->post('password');
		        		$hash = MD5($input_password);

		        		$sql = $this->db->select('user_id, name, email, mobile')
		        			->where('user_id', $user_id)
		        			->get('users')->row();
						$name = $sql->name;
						$email = $sql->email;
						$mobile = $sql->mobile;

						$this->db->where('user_id', $user_id)->update('users', ['password'=>$hash]);

				        $this->notification($name, $mobile, $email, $input_password);
				        $this->logout();
					} else {
		        		$this->session->set_flashdata('err', "Session Expired, Try once more.");
				        return redirect(base_url(), 'refresh');
					}
				}
		    }
	    }

	    public function notification($fullName, $mobile, $email, $pass)
		{
	        $msg = "Dear ".ucfirst($fullName).", \n CRM Login details are. \n Username - ". $email ."\n Password - ". $pass." \n URL - ". base_url() ." \n Please don't share it with anyone. \n Thanks - Authorised by, Organization \n";

			$username = urlencode("namanfinl");
			$password = urlencode("6I1c0TdZ");
			$message = urlencode($msg);
			$destination = $mobile;
			$source = "LOANPL";
			$type = "0";
			$dlr = "1";
			
			$data = "username=$username&password=$password&type=$type&dlr=$dlr&destination=$destination&source=$source&message=$message";
			$url = "http://sms6.rmlconnect.net/bulksms/bulksms";
			
			$ch = curl_init();
			curl_setopt_array($ch, array(
							CURLOPT_URL => $url,
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_POST => true,
							CURLOPT_POSTFIELDS => $data
							));
			$output = curl_exec($ch);

			curl_close($ch);
		}

	    public function logout()
	    {
	    	if(!empty($_SESSION['isUserSession']['email'])){
	    		$email = $_SESSION['isUserSession']['email'];
	    		$query = $this->db->where('email', $email)->get('users')->row_array();
		    	$query_email = $query['email'];
		    	$status = 'Closed';

		    	$data = array(
					'status' 		=> $status,
					'updated_on' 	=> updated_at,
				);

		    	$this->db->where('email', $query_email)->update('users', $data);
		    	session_destroy();

				$this->session->set_flashdata('msg', 'Session Expired!');
	            return redirect(base_url(),'refresh');
	    	}else{
		    	session_destroy();
				$this->session->set_flashdata('msg', 'Session Expired!');
	            return redirect(base_url(),'refresh');
	    	}
	    }
	    
	    public function editProfile($user_id)
	    {
	        $query = $this->User_Model->getUser($user_id);
	        $data['user'] = $query->row();
	        $this->load->view('Users/editProfile', $data);
	    }
	    
	    public function updateProfile($user_id)
	    {
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('name', 'Name', 'required|trim');
	        	$this->form_validation->set_rules('email', 'Email', 'required|trim');
	        	$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
	        	$this->form_validation->set_rules('dob', 'DOB', 'required|trim');
	        	$this->form_validation->set_rules('gender', 'Gender', 'required|trim');
	        	$this->form_validation->set_rules('marital_status', 'Marital Status', 'required|trim');
	        	if($this->form_validation->run() == FALSE) {
	        	    echo "if called : "; print_r($_POST); exit;
	        		$this->session->set_flashdata('err', validation_errors());
		            return redirect(base_url('editProfile/'.$user_id), 'refresh');
	        	}else{
        	        $data = [
                        'name'              => $this->input->post('name'),
                        'email'             => $this->input->post('email'),
                        'mobile'            => $this->input->post('mobile'),
                        'gender'            => $this->input->post('gender'),
                        'dob'               => $this->input->post('dob'),
                        'marital_status'    => $this->input->post('marital_status'),
                        'father_name'       => $this->input->post('father_name'),
                    ];
                    $this->User_Model->updateUser($user_id, $data);
                    
	        		$this->session->set_flashdata('msg', 'Updated Successfully.');
		            return redirect(base_url('myProfile'), 'refresh');
	        	}
	        }else{
        		$this->session->set_flashdata('err', 'Updated Successfully.');
	            return redirect(base_url('editProfile/'.$user_id), 'refresh');
	        }
	    }

	}

?>