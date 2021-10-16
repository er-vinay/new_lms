<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class UserController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
	        $this->load->database();
	        $this->load->library('session');
	        $this->load->helper('captcha');
		}

		public function index()
	    {
	        $data['admin'] = $this->db->where('email', $_SESSION['email'])->get('users')->result_array();
	        $this->load->view('DashboardAdmin/User/index', $data);
	    }

	    public function sign_up()
	    {
	        // $query['countries'] = $this->db->select('*')->get('countries')->result_array();
	        return $this->load->view('userRegister');
	    }

	    // public function selectState($id)
	    // {
	    //     $result = $this->db->where("country_id",$id)->get("states")->result();
	    //     echo json_encode($result);
	    // }

	    // public function selectCity($id)
	    // {
	    //     $result = $this->db->where("state_id",$id)->get("cities")->result();
	    //     echo json_encode($result);
	    // }

	    public function addUser()
	    {
	        if($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha|min_length[3]|max_length[12]');
	            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha');
	            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
	            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[10]|max_length[10]|numeric');
	            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[8]|md5');
	            $this->form_validation->set_rules('confirm_password', 'confirm_password', 'trim|required|matches[password]|md5');
	            $this->form_validation->set_rules('gender', 'Gender', 'required');
	            $this->form_validation->set_rules('dateofbirth', 'Date Of Birth', 'required');
	            $this->form_validation->set_rules('country', 'Country', 'required');
	            $this->form_validation->set_rules('state', 'State', 'required');
	            $this->form_validation->set_rules('city', 'Distict', 'required');
	            $this->form_validation->set_rules('town', 'Town', 'trim|required');
	            $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|min_length[6]|max_length[6]|numeric');

	            if($this->form_validation->run()== true){}

	        	$data = array(
	        		'first_name' => $this->input->post('first_name'),
	        		'last_name' => $this->input->post('last_name'),
	        		'email' => $this->input->post('email'),
	        		'phone' => $this->input->post('phone'),
	        		'password' => $this->input->post('password'),
	        		'confirm_password' => $this->input->post('confirm_password'),
	        		'gender' => $this->input->post('gender'),
	        		'dateofbirth' => $this->input->post('dateofbirth'),
	        		'country' => $this->input->post('country'),
	        		'state' => $this->input->post('state'),
	        		'city' => $this->input->post('city'),
	        		'town' => $this->input->post('town'),
	        		'pincode' => $this->input->post('pincode')
	        	);

	        	$journalName = str_replace(' ', '_', $_FILES['image']['name']);
                $config['file_name'] = time() . $journalName;
                $config['upload_path'] = './public/front/images/adminUserProfile/';
                $config['allowed_types'] = 'jpg|png|JPG|JPEG|jpeg';
                $this->upload->initialize($config);
                $this->upload->do_upload('image');
                $_POST['image'] = $config['file_name'];

                if($this->db->insert('users', $data, $_POST) > 0)
                {
                    $this->session->set_flashdata('msg', 'User Add Successfully!');
                    return redirect(base_url('portal'), 'refresh');
                }
                else
                {
                    $this->session->set_flashdata('err', 'Please try Again After SomeTimes');
                    return redirect(base_url('sign-up'),'refresh');
                }
	        }
            $this->load->view('userRegister');
	    }

	    public function editAdminUser($id)
	    {
    		$data = $this->db->where('id', $id)->get('users')->result_array();
	    	echo json_encode($data);
			return $this->load->view('DashboardAdmin/profile', $data);
	    }

	    
	    public function logout()
	    {
	    	session_destroy();
			$this->session->set_flashdata('msg', 'User Session Expire!');
            return redirect(base_url(),'refresh');
	    }

	    public function dashboard(){
	    	if(isset($_SESSION['email']))
	        {
	        	return $this->index();
	        }else{
            	return redirect(base_url(),'refresh');
	        }
	    }

	    public function profile() {
	        if(!isset($_SESSION['email']))
	        {
	        	return redirect(base_url('newadmin'), 'refresh');
	        }else{
	        	$email = $_SESSION['email'];
	        	$data['agent_details'] = $this->db->where('email', $email)->get('tbl_agent')->row_array();

	        	// echo "<pre>"; print_r($data['agent_details']); echo "</pre>"; exit;
		        $this->load->view('DashboardAdmin/profile', $data);
		    }
	    }

		public function view_login()
		{
			// $config = array(
	  //           'img_path'      => 'public/captcha_images/',
	  //           'img_url'       => base_url().'public/captcha_images/',
	  //           'font_path'     => 'system/fonts/texb.ttf',
	  //           'img_width'     => '160',
	  //           'img_height'    => 50,
	  //           'word_length'   => 6,
	  //           'font_size'     => 24
	  //       );
	  //       $captcha = create_captcha($config);
	  //       $this->session->unset_userdata('captchaCode');
	  //       $this->session->set_userdata('captchaCode', $captcha['word']);
	  //       $data['captchaword'] = $captcha['word'];

			$this->load->view('userLogin');
		}

		public function refresh(){
	        $config = array(
	            'img_path'      => 'public/captcha_images/',
	            'img_url'       => base_url().'public/captcha_images/',
	            'font_path'     => 'system/fonts/texb.ttf',
	            'img_width'     => '160',
	            'img_height'    => 50,
	            'word_length'   => 6,
	            'font_size'     => 24
	        );
	        $captcha = create_captcha($config);
	       
	        $this->session->unset_userdata('captchaCode');
	        $this->session->set_userdata('captchaCode',$captcha['word']);
	        echo $captcha['word'];
            return redirect(base_url(),'refresh');
	    }

		public function loginOtp($id)
		{
			echo json_encode($id);
			return $this->load->view('userLogin', $id);
		}

		public function login()
		{
			$x = $this->session->userdata('logged');
	        if (isset($session['email'])) {
	            return $this->index();
	        } else {
				if ($this->input->server('REQUEST_METHOD') == 'POST') 
		        {
		        	$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
		        	$this->form_validation->set_rules('password', 'Password', 'required|trim');

		        	$inputCaptcha = $this->input->post('captcha');
		            $sessCaptcha = $this->session->userdata('captchaCode');

		        	if($this->form_validation->run()==true)
			        {
			        	$email = $this->input->post('email');
			        	$password = md5($this->input->post('password'));

			        	$data = $this->db->select('email, password')->where('email', $email)->get('users')->row_array();
						if($data > 0)
						{
							$db_email = $data['email'];
				        	$db_password = $data['password'];

							if($email === $db_email)
				        	{
				        		if($password === $db_password)
				        		{
				        			// if($inputCaptcha === $sessCaptcha){
					        			$_SESSION['email'] = $email;
					        			$this->load->view('DashboardAdmin/index'); 
						       //      }else{
									    // $this->session->set_flashdata('err', 'Invalid OTP!');
					        //         	return redirect(base_url(),'refresh');
						       //      }
				        		}
				        		else{
				        			$this->session->set_flashdata('err', 'Invalid Password!');
					                return redirect(base_url(),'refresh');
				        		}
				        	}
				        	else
				        	{
				        		$this->session->set_flashdata('err', 'Invalid Email!');
					            return redirect(base_url(),'refresh');
				        	}
						}
						else{
			        		$this->session->set_flashdata('err', 'Invalid Email/Password!');
					        return redirect(base_url(),'refresh');
						}
			        	
			        }
			        else{
			        	$this->load->view('userLogin');
			        }
			    }
			}
		}

		public function change_pass() {
	        // $x = $this->session->userdata('logged');

	        // if ($x['email'] == '') {
	        if (!$_SESSION['email']) {
	            return redirect('DashboardAdmin/index', 'refresh');
	        }else{
		        $this->load->view('DashboardAdmin/change_pass');
		    }
	    }
	    public function save_password() {
	        $x = $this->session->userdata('logged');
	        $this->form_validation->set_rules('password', 'Password', 'required');
	        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
	        if ($this->form_validation->run() == FALSE) {
	            $this->load->view('change_pass');
	        } else {
	            $password = md5($this->input->post('password'));
	            if ($this->db->where('email', $x['email'])->update('user', array('password' => $password))) {
	                $this->session->set_flashdata('msg', 'Password Updated Successfully');
	                return redirect(base_url('profile'), 'refresh');
	            } else {
	                $this->session->set_flashdata('err', 'Password Not Updated Please Try Again');
	                return redirect(base_url('profile'), 'refresh');
	            }
	        }
	    }
	    public function event_holiday() {
	        $data['class'] = $this->db->where('status', 1)->get('class')->result_array();
	        $this->load->view('events', $data);
	    }
	    public function get_number() {
	        if ($_POST['search_by1'] == 'class') {
	            if ($_POST['section'] != 'Select Section') {
	                $data = $this->db->select('parent_contact')->from('student')->where(array('class' => $_POST['class'], 'section' => $_POST['section'], 'status' => 1))->get()->result_array();
	            } else {
	                $data = $this->db->select('parent_contact')->from('student')->where(array('class' => $_POST['class'], 'status' => 1))->get()->result_array();
	            }
	        } elseif ($_POST['search_by1'] == 'all') {
	            $data = $this->db->select('parent_contact')->from('student')->where(array('status' => 1))->get()->result_array();
	        } elseif ($_POST['search_by1'] == 'parent_contact') {
	            $data = $this->db->select('parent_contact')->from('student')->where(array('parent_contact' => $_POST['field_val'], 'status' => 1))->get()->result_array();
	        }
	        print_r(json_encode($data));
	    }
	    public function send_notification() {
	        /*print_r($_POST);
	        
	        exit;*/
	        //print_r(json_decode($_POST['all_cont']));
	        $val = [];
	        foreach (json_decode($_POST['all_cont']) as $key => $value) {
	            $val[] = $value->parent_contact;
	        }
	        $cont = implode(',', $val);
	        $data11 = $this->db->get('smsinfo')->result_array();
	        $msg = $_POST['msg'];
	        $parampro['uname'] = $data11[0]['user_name'];
	        $parampro['password'] = $data11[0]['password'];
	        $parampro['sender'] = $data11[0]['sender_id'];
	        $parampro['receiver'] = $cont;
	        $parampro['route'] = "TA";
	        $parampro['msgtype'] = "1";
	        $parampro['sms'] = $msg;
	        $sendsmspro = http_build_query($parampro);
	        $urlpro = "http://staticking.org/index.php/smsapi/httpapi/?" . $sendsmspro;
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $urlpro);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        $resultpro = curl_exec($ch);
	        return redirect(base_url(), 'refresh');
	    }

	    public function sms_details() {
	        $data['sms'] = $this->db->get('smsinfo')->result_array();
	        $this->load->view('sms_info', $data);
	    }
	    
	    public function update_sms_info() {
	        $this->form_validation->set_rules('user_name', 'User Name', 'required');
	        $this->form_validation->set_rules('password', 'Passsword', 'required');
	        $this->form_validation->set_rules('sender_id', 'Sender ID', 'required');
	        if ($this->form_validation->run() == FALSE) {
	            $data['sms'] = $this->db->where('id', $this->input->post('id'))->get('smsinfo')->result_array();
	            $this->load->view('sms_info', $data);
	        } else {
	            $this->db->where('id', $this->input->post('id'))->update('smsinfo', $this->input->post());
	            $data['sms'] = $this->db->where('id', $this->input->post('id'))->get('smsinfo')->result_array();
	            $this->load->view('sms_info', $data);
	        }
	    }

	    public function viewUserInvoice(){
	    	$this->load->view('DashboardAdmin/userInvoice');
	    }

	}

?>