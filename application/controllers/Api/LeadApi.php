<?php
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
class LeadApi extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();	
		$this->load->library('Authorization_Token');
	}
  
	public function users_get(){
	    echo "<pre>"; print_r($_GET); exit;    
	}
	
	public function user_post()
	{  
		$array  = array('status'=>'ok','data'=>1);
		$this->response($array); 
	}

	public function record_post()
	{  
		$array  = array('status'=>'ok','data'=>'post api');
		$this->response($array); 
	}
	
	public function register_post()
	{  
	   // echo "tst"; exit;
// 		$token_data['api_token'] = "Deepak with vinay testing api in jwt";
		$token_data['fullname'] = 'er_vin'; 
		$token_data['email'] = 'test@gmail.com';

		$tokenData = $this->authorization_token->generateToken($token_data);

		$final = array();
		$final['token'] = $tokenData;
		$final['status'] = 'ok';
 
		$this->response($final); 
	}
	
	public function verify_post()
	{  
		$headers = $this->input->request_headers(); 
		$decodedToken = $this->authorization_token->validateToken($headers['Authorization']);

		$this->response($decodedToken);  
	}

	public function vinSaveTasks_post()
	{
		$param = json_decode(file_get_contents('php://input'), TRUE);
// 		$headers = apache_request_headers(); 
// 		$headers = $this->input->request_headers(); 
		$headers = getallheaders(); 
		echo "<pre>"; print_r($headers); exit;
		
// 		$decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
		$decodedToken = $this->authorization_token->validateToken($headers['Postman-Token']);
		if($decodedToken['status'] == 0){
			$this->response($decodedToken); 
		}else{
			print_r($param);
		}


	}


 
}

