<?php
	// defined('BASEPATH') OR exit('No direct script access allowed');

	require APPPATH . 'libraries/REST_Controller.php';
	class TaskApi extends REST_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function index_get($id = 0)
		{
			if(!empty($id)){
            	$data = $this->db->get_where("leads", ['id' => $id])->row_array();
	        }else{
	            $data = $this->db->get("leads")->result();
	        }
	     
	        $this->response($data, REST_Controller::HTTP_OK);
		}

		public function vinSaveTasks_post()
	    { 
	        if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
    	        $result = $this->db->insert('leads', $_POST);
    	        if($result == 1){
    	            $this->response($result, REST_Controller::HTTP_OK);
    	        }else{
	                $this->response(['Request Method Post Failed.'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    	        }
            }else{
    	        $this->response(['Request Method Post Failed.'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
	    }

		public function uatSaveTasks_post()
	    {
	        if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
    	        $result = $this->db->insert('leads_1', $_POST);
    	        if($result == 1){
    	            $this->response($result, REST_Controller::HTTP_OK);
    	        }else{
	                $this->response(['Request Method Post Failed.'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    	        }
            }else{
    	        $this->response(['Request Method Post Failed.'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
	    }

		public function index_post()
	    {
	        // $input = $this->input->post();

	   // 	print_r($_POST); exit;
	    	// echo json_decode($input) exit;
	        // $this->db->insert('leads', $input);
	     
	        $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
	    } 
	    
	    public function index_put($id)
	    {
	        $input = $this->put();
	        $this->db->update('leads', $input, array('id'=>$id));
	     
	        $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
	    }
	     
	    public function index_delete($id)
	    {
	        $this->db->delete('leads', array('id'=>$id));
	       
	        $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
	    }
	    
	    /*insert lead API*/
	    public function recoveryInsert_post()
        {
            //print_r($_POST); exit; 
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $this->form_validation->set_rules("company_id", "Company ID", "trim|required");
                $this->form_validation->set_rules("lead_id", "Lead ID", "trim|required");
                $this->form_validation->set_rules("loan_no", "Loan No", "trim|required");
                $this->form_validation->set_rules("refrence_no", "Refrence No", "trim|required");
                $this->form_validation->set_rules("payment_mode", "Payment Mode", "trim|required");
                $this->form_validation->set_rules("status", "Status", "trim|required");
                $this->form_validation->set_rules("recovery_status", "Recovery Status", "trim|required");
                $this->form_validation->set_rules("company_account_no", "Company Account No", "trim|required");
                $this->form_validation->set_rules("remarks", "Remark", "trim|required");
                $this->form_validation->set_rules("ip", "User IP", "trim|required");
                $this->form_validation->set_rules("recovery_by", "Recovered By", "trim|required");
                if($this->form_validation->run() == FALSE)
                {
                    $this->response(validation_errors(), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                }
                else
                {  
                    $recoveryData =  array(
                        'company_id'        =>$this->input->post('company_id'),
                        'lead_id'           =>$this->input->post('lead_id'),
                        'customer_id'       =>$this->input->post('customer_id'),
                        'loan_no'           =>$this->input->post('loan_no'),  
                        'payment_mode'      =>$this->input->post('payment_mode'),
                        'lan'               =>$this->input->post('lan'),
                        'payment_amount'    =>$this->input->post('payment_amount'),
                        'refrence_no'       =>$this->input->post('refrence_no'),
                        'status'            =>$this->input->post('status'),
                        'company_account_no'=>$this->input->post('company_account_no'),
                        'extraamount'       =>$this->input->post('extraamount'),
                        'date_of_recived'   =>$this->input->post('date_of_recived'),
                        'sattelment'        =>$this->input->post('sattelment'),
                        'docs'              =>$this->input->post('docs'),
                        'recovery_status'   =>$this->input->post('recovery_status'),
                        'remarks'           =>$this->input->post('remarks'),
                        'noc'               =>$this->input->post('noc'),
                        'ip'                =>$this->input->post('ip'),
                        'recovery_by'       =>$this->input->post('recovery_by'),
                        'created_on'        =>$this->input->post('created_on'),
                        'PaymentVerify'     =>$this->input->post('PaymentVerify'),
                        'updated_by'        =>$this->input->post('updated_by'),
                        'updated_at'        =>$this->input->post('updated_at'),
                    );

                    $this->db->insert('recovery', $recoveryData);
                    $id = $this->db->insert_id();
                    if(!empty($id))
                    {
                        $this->response(200, REST_Controller::HTTP_OK);
                    }else{
                        $this->response(201, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    } 
                }  
            }
            else
            {
                $this->response(500, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }    
        }

	}

?>