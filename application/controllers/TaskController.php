<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class TaskController extends CI_Controller
	{
		public $tbl_leads = 'leads LD';
		public $tbl_lead_followup = 'lead_followup LF';
		public $tbl_customer = 'customer C';
		public $tbl_docs = 'docs D';
		public $tbl_users = 'users U';
		public $tbl_customer_employment = "customer_employment CE";
		public $tbl_cam = "credit_analysis_memo CAM";

		public function __construct()
		{
			parent::__construct();
            $this->load->model('Leadmod', 'Leads');
            $this->load->model('Task_Model', 'Tasks');
            $this->load->model('Admin_Model', 'Admin');
            $this->load->model('Status_Model', 'Status');
            $this->load->model('CAM_Model', 'CAM');
            $this->load->model('Docs_Model', 'Docs');
            $this->load->model('Users/Email_Model', 'Email');
            $this->load->model('Users/SMS_Model', 'SMS');

            date_default_timezone_set('Asia/Kolkata');
            $timestamp = date("Y-m-d H:i:s");
            
	    	$login = new IsLogin();
	    	$login->index();
		}
	    
	    public function index1($stage)
	    {
		    $conditions = "company_id='". company_id ."' AND product_id='". product_id ."' AND stage='". $stage ."'"; 
	        $data['leadDetails'] = $this->Tasks->index($conditions); 
	    	$user = $this->Admin->getUser(user_id);
	    	$data['user'] = $user->row();
        	$this->load->view('Tasks/GetLeadTaskList', $data);
	    }

		public function index($stage)
		{
			// echo "<pre>".$this->uri->segment(1);
	        $url = (base_url() . $this->uri->segment(1) ."/". $this->uri->segment(2));
	        $totalCount = $this->Tasks->getLeadsCount($stage);
	        $rowperpage = 10;
	        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		    $conditions = "LD.company_id='". company_id ."' AND LD.product_id='". product_id ."' AND LD.stage='". $stage ."'";

	        $config = array();
	        $config["base_url"] = $url;
	        $config["total_rows"] = $totalCount; // get count leads
	        $config["per_page"] = $rowperpage;
	        $config['full_tag_open']    = '<div class="pagging text-right"><nav><ul class="pagination">';
	        $config['full_tag_close']   = '</ul></nav></div>';
	        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
	        $config['num_tag_close']    = '</span></li>';
	        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
	        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
	        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
	        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
	        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
	        $config['prev_tag_close']  = '</span></li>';
	        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
	        $config['first_tag_close'] = '</span></li>';
	        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
	        $config['last_tag_close']  = '</span></li>';

	        $this->pagination->initialize($config);
	        $data['links'] = $this->pagination->create_links();
	        $data['pageURL'] = $url;
	        $data['leadDetails'] = $this->Tasks->index($conditions, $rowperpage, $page);
	    	$this->load->view('Tasks/GetLeadTaskList', $data);
		}

		public function getLeadDetails($lead_id)
	    {
    		$lead_id = $this->encrypt->decode($lead_id);
            $table1 = 'leads LD';
            $table2 = 'customer C';
            $join2 	= 'C.customer_id = LD.customer_id';
            $table3 = 'customer_employment CE';
            $join3 	= 'CE.customer_id = LD.customer_id';
            $table4 = 'tbl_state ST';
            $join4 	= 'ST.state_id = LD.state_id';

	        $conditions = ['LD.company_id' => company_id, 'LD.product_id' => product_id, 'LD.lead_id' => $lead_id];
	        
            $select = 'LD.lead_id, LD.customer_id, LD.application_no, C.first_name, C.middle_name, C.sur_name, C.email, C.alternate_email, C.gender, C.mobile, C.alternate_mobile, LD.obligations, LD.promocode, LD.purpose, LD.user_type, C.pancard,  LD.loan_amount, LD.tenure, LD.cibil, CE.income_type, CE.salary_mode, CE.monthly_income, LD.source, C.dob, ST.state, LD.city, LD.pincode, LD.status, LD.stage, LD.schedule_time, LD.created_on, LD.coordinates, LD.ip, LD.imei_no, LD.term_and_condition';
	        $leadData = $this->Tasks->join_table($conditions, $select, $table1, $table2, $join2, $table3, $join3, $table4, $join4);
	        $sql = $leadData->row();
            $data['leadDetails'] = $sql;
            $data['docs_master'] = $this->Docs->docs_type_master();
    		$this->load->view('Tasks/task_js.php', $data);
			$this->load->view('Tasks/main_js.php');
	    }
	    
	    // public function applicationinprocess()
	    // {
	    // 	$data['leadDetails'] = $this->Tasks->applicationinprocess(); 
	    // 	$user = $this->Admin->getUser(user_id);
	    // 	$data['user'] = $user->row();
     //    	$this->load->view('Screener/applicationInProcess', $data);
	    // }
	    
	    //  public function applicationHold()
	    // {
	    //     $data['title'] = "Applications Hold";
	    // 	$data['leadDetails'] = $this->Tasks->applicationHold(); 
	    // 	$user = $this->Admin->getUser(user_id);
	    // 	$data['user'] = $user->row();
	    	
     //    	$this->load->view('Screener/applicationHold', $data);
	    // }

		public function getCity($state_id)
	    {
	    	$cityArr = $this->Tasks->getCity($state_id);
	    	$json['city'] = $cityArr->result();
        	echo json_encode($json);
	    }
		public function getState()
	    {
	    	$stateArr = $this->Tasks->getState();
	    	$json['state'] = $stateArr->result();
        	echo json_encode($json);
	    }
	    
	  //   public function inProcess($stage)
	  //   {
			// $conditions = "company_id='". company_id ."' AND product_id='". product_id ."' AND stage='". $stage ."'";
	  //       $data['leadDetails'] = $this->Tasks->index($conditions); 
	  //   	$user = $this->Admin->getUser(user_id);
	  //   	$data['user'] = $user->row();
   //      	$this->load->view('Tasks/GetLeadTaskList', $data);
	  //   }
	    
	  //   public function leadRecommend()
	  //   {
	  //   	$data['recommend'] = $this->Tasks->recommend();
	  //   	$user = $this->Admin->getUser(user_id);
	  //   	$data['user'] = $user->row();
   //      	$this->load->view('Tasks/recommend', $data);
	  //   }
	    
	  //   public function leadSendBack()
	  //   {
	  //   	$data['sendBack'] = $this->Tasks->leadSendBack();
	  //   	$user = $this->Admin->getUser(user_id);
	  //   	$data['user'] = $user->row();
   //      	$this->load->view('Tasks/leadSendBack', $data);
	  //   }
	    
	  //   public function leadSanctioned()
	  //   {
	  //   	$data['leadSanctioned'] = $this->Tasks->leadSanctioned();
	  //   	$user = $this->Admin->getUser(user_id);
	  //   	$data['user'] = $user->row();
   //      	$this->load->view('Tasks/leadSanctioned', $data);
	  //   }
	    
	  //   public function leadDisbursed()
	  //   {
	  //   	$data['leadDisbursed'] = $this->Tasks->leadDisbursed();
	  //   	$user = $this->Admin->getUser(user_id);
	  //   	$data['user'] = $user->row();
   //      	$this->load->view('Tasks/leadDisbursed', $data);
	  //   }
	    
	    public function getLeadDisbursed1()
	    {
	        $limit = $this->input->post('limit');
	        $start = $this->input->post('start');
	    	$data = $this->Tasks->leadDisbursed1($limit, $start);
            $output = '
                <table class="table dt-tables table-striped table-bordered table-responsive table-hover" style="border: 1px solid #dde2eb">
                    <thead>
                        <tr>
                            <th><b>Sr. No</b></th>
                            <th><b>Action</b></th>
                            <th><b>Application No</b></th>
                            <th><b>Borrower</b></th>
                            <th><b>State</b></th>
                            <th><b>City</b></th>
                            <th><b>Mobile</b></th>
                            <th><b>Email</b></th>
                            <th><b>PAN</b></th>
                            <th><b>Source</b></th>
                            <th><b>Status</b></th>
                            <th><b>Initiated On</b></th>
                        </tr>
                    </thead>
                    <tbody>
            ';
	    	if($data->num_rows() > 0)
            {
                $i = $start++;
                foreach($data->result() as $row)
                {
                    $output .= '
                    <div class="post_data">
                            <tr class="table-default">
                                <td>'. $start++ .'</td>
                                <td>
                                    <a href="#" onclick="viewLeadsDetails('. $row->lead_id .')" id="viewLeadsDetails" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" title="View Costomer Details"></i></a>
                                </td>
                                <td></td>
                                <td>'. strtoupper($row->name ." ". $row->middle_name ." ". $row->sur_name) .'</td>
                                <td>'. strtoupper($row->state) .'</td>
                                <td>'. strtoupper($row->city) .'</td>
                                <td>'. $row->mobile .'</td>
                                <td>'. $row->email .'</td>
                                <td>'. strtoupper($row->pancard) .'</td>
                                <td>'. $row->source .'</td>
                                <td>'. strtoupper($row->status) .'</td>
                                <td>'. date('d-m-Y', strtotime($row->created_on)) .'</td>
                            </tr>
                    </div>
                    ';
                }
                $output .= '</tbody></table>';
            }
            echo $output;
	    }
	    
	  //   public function agentToDoTask()
	  //   {
	  //       $this->db->select('leads.lead_id, leads.name, leads.email, tb_states.state, leads.created_on, leads.source, leads.status, leads.credit_manager_id, leads.partPayment')
			// 	// ->where('date(leads.created_on) BETWEEN "'. date('Y-m-d', strtotime("2020-12-25")). '" and "'. date('Y-m-d', strtotime(todayDate)).'"')
   //              ->where('leads.utm_source', "LoanAgainstCard")
   //              ->where('leads.leads_duplicate', 0)
   //              ->where('leads.lead_rejected', 0)
   //              ->where('leads.loan_approved',0)
   //              ->where('leads.lead_status !=', "Hold")
   //              ->from('leads')
   //              ->join('tb_states', 'leads.state_id = tb_states.id');
   //          $query = $this->db->order_by('leads.lead_id', 'desc')->get();
			// $data['taskCount'] = $query->num_rows();
			// $data['listTask'] = $query->result(); 
   //      	$this->load->view('Tasks/GetLeadTaskList', $data);
	  //   }
	    
	  //   public function sanctionHold()
	  //   { 
	  //      	$query = $this->Tasks->sanctionHold();
	  //       $data['sanctionHold'] = $query->result();   
	  //       $data['taskCount'] = $query->num_rows();
	  //       $user = $this->Admin->getUser($_SESSION['isUserSession']['user_id']);
	  //   	$data['user'] = $user->row();
   //      	$this->load->view('Tasks/sanctionHold', $data); 
	  //   }

		// public function rejectApproval()
	 //    {
  //           $this->db->select('leads.lead_id, leads.name, leads.email, tb_states.state, leads.created_on, leads.source, leads.status, leads.credit_manager_id, leads.partPayment')
  //               ->where('date(leads.created_on) BETWEEN "'. date('Y-m-d', strtotime("2020-12-06")). '" and "'. date('Y-m-d', strtotime(todayDate)).'"')
  //               // ->where('date(leads.created_on)', todayDate)
  //               ->where('leads.loan_approved', 2)
  //               ->from(tableLeads)
  //               ->join('tb_states', 'leads.state_id = tb_states.id');
  //           $query = $this->db->order_by('leads.lead_id', 'desc')->get();
		// 	$data['taskCount'] = $query->num_rows();
		// 	$data['listTask'] = $query->result();
            
  //       	$this->load->view('Tasks/GetLeadTaskList', $data);
	 //    }

	  //   public function getLWHistory($pancard)
	  //   {
   //          $db_LW = $this->load->database('LWDatabase', TRUE);
   //          // $pancard = "avxpm1125g";

			// $query = $db_LW->query('SELECT L.*, LL.name, LL.state_id, LL.city, LL.source, C.mobile, C.email, C.pancard, LL.status from loan L 
			// 			INNER JOIN credit C ON L.lead_id=C.lead_id 
			// 			INNER JOIN leads LL ON L.lead_id=LL.lead_id 
			// 				AND L.loan_status LIKE"%DISBURSED%" 
			// 				AND C.status LIKE"%Approved%" 
			// 				AND LL.status IN("DISBURSED", "CLOSED", "Part Payment", "Settelment") 
			// 				AND C.pancard LIKE"%'.$pancard.'%" 
			// 				ORDER BY L.loan_id DESC');
            
		 //    return $query; 
	  //   }
	    
	  //   public function getFTCHistory($pancard)
	  //   {
   //          $db_FTC = $this->load->database('FTCDatabase', TRUE);  
		 //    $db_FTC->select('leads.lead_id, c.residential_no, leads.name, leads.email, leads.mobile, leads.pancard, tb_states.state, leads.city, leads.created_on, leads.source, 
		 //    leads.status, leads.credit_manager_id, leads.partPayment, loan.loan_amount, loan.loan_no, loan.loan_tenure, loan.loan_intrest, loan.loan_repay_amount,
		 //    loan.loan_repay_date, loan.loan_disburse_date, loan.loan_admin_fee, loan.updated_on')
   //              ->where('leads.pancard', $pancard)
   //              ->where('leads.loan_approved', 3)
   //              ->from('leads')
   //              ->join('tb_states', 'leads.state_id = tb_states.id')
   //              ->join('loan', 'leads.lead_id = loan.lead_id')
   //              ->join('credit as c', 'c.lead_id = loan.lead_id'); 
   //          $ftcResult = $db_FTC->get(); 
		 //    return $ftcResult; 
	  //   }


		public function viewOldHistory($lead_id)
	    {
	    	$table1 = 'leads LD';
            $table2 = 'customer C';
            $join2 	= 'C.customer_id = LD.customer_id';
            $table3 = 'customer_employment CE';
            $join3 	= 'CE.customer_id = LD.customer_id';
            $table4 = 'tbl_state ST';
            $join4 	= 'ST.state_id = LD.state_id';

	        $conditions = ['LD.company_id' => company_id, 'LD.product_id' => product_id, 'LD.lead_id' => $lead_id];
	        
            $select = 'LD.lead_id, LD.customer_id, LD.loan_no, LD.application_no, C.first_name, C.middle_name, C.sur_name, C.email, C.alternate_email, C.gender, C.mobile, C.alternate_mobile, LD.obligations, LD.promocode, LD.purpose, LD.user_type, C.pancard, C.aadhar_no,  LD.loan_amount, LD.tenure, LD.cibil, CE.income_type, CE.salary_mode, CE.monthly_income, LD.source, C.dob, ST.state, LD.city, LD.pincode, LD.status, LD.stage, LD.schedule_time, LD.created_on, LD.coordinates, LD.ip, LD.imei_no, LD.term_and_condition';
	        $leadData = $this->Tasks->join_table($conditions, $select, $table1, $table2, $join2, $table3, $join3, $table4, $join4);

			$data = '<div class="table-responsive">
		        <table class="table table-hover table-striped table-bordered">
                  <thead>
                    <tr class="table-primary">
                        <th>Sr.&nbsp;No</th>
                        <th>Status</th>
						<th>Application&nbsp;No</th>
                        <th>Loan&nbsp;No</th>
                        <th>Borrower</th>
                        <th>PAN</th>
                        <th>Aadhar</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Loan&nbsp;Amount</th>
                        <th>Open&nbsp;Date</th>
                        <th>Product</th>
                    </tr>
                  </thead>';
            if($leadData->num_rows() > 0)
            {
      			$i = 1; 
				foreach($leadData->result() as $colum)
				{
				    if($colum->status == 'Full Payment' || $colum->status == 'Settelment')
				    {
				        $optn = '<i class="fa fa-check" style="font-size:24px;color:green"></i>';
				        $status = 'Full Payment';
				    }else{
				        $status='ACTIVE';
				    }
				    $data .='<tbody>
                		<tr>
							<td>'. $i .'</th>
                            <td>'. $status .'</td>
							<td><a href="#">'. $colum->application_no .'</a></td>
                            <td><a href="#">'. $colum->loan_no .'</a></td>
							<td>'. $colum->first_name.''.$colum->middle_name.''.$colum->sur_name .'</td>
                            <td>'. $colum->pancard .'</td>
                            <td>'. $colum->aadhar_no .'</td>
                            <td>'. $colum->email .'</td>
                            <td>'. $colum->mobile .'</td>
                            <td>'. $colum->state .'</td>
                            <td>'. $colum->city .'</td>
                            <td>'. $colum->loan_amount .'</td>
                            <td>'. date('d/m/Y', strtotime($colum->created_on)) .'</td> 
                            <td>'. $colum->source .'</td>
						</tr>';
					$i++;
				}
			}else{
		    	$data .='<tbody><tr><td colspan="16" style="text-align: -webkit-center;color:red;">Record Not Found...</td></tr></tbody></table></div>';
			}
			echo json_encode($data);
	    }

		public function oldUserHistory($lead_id)
		{
		    $sql = $this->db->select('pancard, mobile')->where('lead_id', $lead_id)->from('leads')->get();
		    $result = $sql->row();
		    $pancard = $result->pancard;
		    if(empty($pancard)) {
		        $result = $sql->result();
		        foreach($result as $row){
		            if(!empty($row->pancard)){
		                $pancard = $row->pancard;
		                break;
		            }
		        }
		    }
		    $this->db->select('leads.lead_id, leads.name, leads.email, leads.pancard, tb_states.state, leads.created_on, leads.source, leads.status, leads.credit_manager_id, leads.partPayment,
		            loan.loan_amount, loan.loan_tenure, loan.loan_intrest, loan.loan_repay_amount, loan.loan_repay_date, loan.loan_disburse_date, loan.loan_admin_fee')
                ->where('leads.pancard', $pancard)
                ->where('leads.loan_approved', 3)
                ->from(tableLeads)
                ->join('tb_states', 'leads.state_id = tb_states.id')
                ->join('loan', 'leads.lead_id = loan.lead_id');
            $query = $this->db->order_by('leads.lead_id', 'desc')->get();
			$data['taskCount'] = $query->num_rows();
			$data['listTask'] = $query->result();
			
			$data = '<div class="table-responsive">
		        <table class="table table-hover table-striped">
                  <thead>
                    <tr class="table-primary">
                      <th><b>Sr. No</b></th>
                        <th><b>Action</b></th>
                        <th><b>Borrower Name</b></th>
                        <th><b>Email</b></th>
                        <th><b>Pancard</b></th>
                        <th><b>Loan Amount</b></th>
                        <th><b>Loan Tenure</b></th>
                        <th><b>Loan Interest</b></th>
                        <th><b>Loan Repay Amount</b></th>
                        <th><b>Loan Repay Date</b></th>
                        <th><b>Loan Disbursed Date</b></th>
                        <th><b>Loan Admin Fee</b></th>
                        <th><b>Center</b></th>
                        <th><b>Initiated On</b></th>
                        <th><b>Lead Source</b></th>
                        <th><b>Lead Status</b></th>
                    </tr>
                  </thead>';
            if($effected_rows)
            {
          		$i = 1;
				foreach($effected_rows as $column)
				{
				    if($column->status == 'Full Payment' || $column->status == 'Settelment')
				    {
				        $optn = '<i class="fa fa-check" style="font-size:24px;color:green"></i>';
				        $status = 'Full Payment';
				    }else{
				        $status='ACTIVE';
				    }
				    $data .='<tbody>
                		<tr>
							<td>'. $i .'</th>
							<td>'. $optn .'</td>
							<td>'. $colum->name .'</td>
                            <td>'. $colum->email .'</td>
                            <td>'. $colum->pancard .'</td>
                            <td>'. $colum->loan_amount .'</td>
                            <td>'. $colum->loan_tenure .'</td>
                            <td>'. $colum->loan_intrest .'</td>
                            <td>'. $colum->loan_repay_amount .'</td>
                            <td>'. $colum->loan_repay_date .'</td>
                            <td>'. $colum->loan_disburse_date .'</td>
                            <td>'. $colum->loan_admin_fee .'</td>
                            <td>'. $colum->state .'</td>
                            <td>'. $colum->created_on .'</td>
                            <td>'. $colum->source .'</td>
						</tr>';
				}
				
				$data .='</tbody></table></div>';
			}else{
		    	$data .='<tbody><tr><td colspan="8" style="text-align: -webkit-center;color:red;">Record Not Found...</td></tr></tbody></table></div>';
			}
			echo json_encode($data);
			
			$this->load->view('Tasks/oldHistory', $data);
		}
		
		public function TaskList()
	    {
	    	$this->index();
	    }

		public function getDocumentSubType($docs_type)
		{
			$docs_type = str_ireplace("%20"," ", trim($docs_type));
			$docsSubMaster = $this->Docs->getDocumentSubType($docs_type);
			$data = $docsSubMaster->result();
			echo json_encode($data);
		}

		public function getDocsUsingAjax($lead_id)
	    {
	        $fetch = "U.name, D.application_no, D.docs_id, D.docs_type, D.sub_docs_type, D.pwd, D.file, D.created_on";
	        $conditions = ['D.customer_id' => $this->input->post("customer_id")];
	        $join2 = 'U.user_id = D.upload_by';
	    	$docsDetails = $this->Tasks->join_two_table_with_where($conditions, $fetch, $this->tbl_docs, $this->tbl_users, $join2);

			$data = '<div class="table-responsive">
		        <table class="table table-hover table-striped table-bordered" style="margin-top: 10px;">
                  <thead>
                    <tr class="table-primary">
                      <th scope="col"><b>#</b></th>
                      <th scope="col"><b>Document&nbsp;Name</b></th>
                      <th scope="col"><b>File&nbsp;Name</b></th>
                      <th scope="col"><b>Document&nbsp;Type</b></th>
                      <th scope="col"><b>Password</b></th>
                      <th scope="col"><b>Uploaded&nbsp;By</b></th>
                      <th scope="col"><b>Uploaded&nbsp;On</b></th>
                      <th scope="col"><b>Application&nbsp;No.</b></th>
                      <th scope="col"><b>Action</b></th>
                    </tr>
                </thead>';
	        if($docsDetails->num_rows() > 0)
			{
				// onclick="viewCustomerDocs('.$column->docs_id.')"
				$i = 1;
				foreach($docsDetails->result() as $column)
				{
			        $pwd = '-';
				    if($column->pwd){
				        $pwd = $column->pwd;
				    } 
				    $date = $column->created_on;
				    $newDate = date("d-m-Y", strtotime($date));
				    $data.='<tbody>
                		<tr>
							<td>'.$i++.'</td>
							<td>'.$column->docs_type.'</td>
							<td>'.$column->file.'</td>  
							<td>'.$column->sub_docs_type.'</td>
							<td>'.$pwd.'</td>   
							<td>'.$column->name.'</td>  
							<td>'.$newDate.'</td>  
							<td>'.$column->application_no.'</td>
							<td> 
							 	<a onclick="viewCustomerDocs('.$column->docs_id.')"><i class="fa fa-eye" style="padding : 3px; color : #35b7c4; border : 1px solid #35b7c4;"></i></a>
							    <a onclick="deleteCustomerDocs('.$column->docs_id.')"><i class="fa fa-trash" style="padding : 3px; color : #35b7c4; border : 1px solid #35b7c4;"></i></a>
								<a href="'.base_url("upload/".$column->file).'" download><i class="fa fa-download" style="padding : 3px; color : #35b7c4; border : 1px solid #35b7c4;"></i></a>
							</td> 
						</tr>';
				}
				// 	<a onclick="editCustomerDocs('.$column->docs_id.')"><i class="fa fa-pencil" style="padding : 3px; color : #35b7c4; border : 1px solid #35b7c4;"></i></a>
				 	$data .='</tbody></table></div>';
			} else {
		    	$data .='<tbody><tr><td colspan="9" style="text-align: -webkit-center;color:red;">Record Not Found...</td></tr></tbody></table></div>';
	        }	
	        echo json_encode($data);
	    }
	    
	    public function deleteCustomerDocsById($docs_id)
	    { 
	        $docs_row = $this->db->select("*")->from("docs")->where("docs_id", $docs_id)->get()->row();
	        $lead_id = $docs_row->lead_id;
	        if(!empty($docs_id))
	    	{
		    	$query = $this->db->where("docs_id", $docs_id)->delete('docs');
		    	$response = ['result' => $query, "lead_id" =>$lead_id];
		    	echo json_encode($response); 
		    }
	    }
 
	    public function viewCustomerDocs($docs_id)
        {
            if(!empty($docs_id))
            {
                $query = $this->db->where("docs_id", $docs_id)->get('docs')->row_array();
                $img = $query['file'];
                $match_http = substr($img, 0, 4);
                if($match_http == "http")
                {
                    echo json_encode($img);
                }else{
                    echo json_encode(base_url().'upload/'.$img);
                }
            }
        }

	    public function viewCustomerDocsById($docs_id)
	    {
	    	if(!empty($docs_id))
	    	{
		    	$query = $this->db->select('*')->where("docs_id", $docs_id)->get('docs')->row_array();
		    	echo json_encode($query); 
		    }
	    }

	    public function viewCustomerPaidSlip($recovery_id)
	    {
	    	if(!empty($recovery_id))
	    	{
		    	$query = $this->db->where("recovery_id", $recovery_id)->get('recovery')->row_array();
		    	$img = $query['docs'];
		    	$match_http = substr($img, 0, 4);
		    	if($match_http == "http")
		    	{
		    		echo json_encode($img);
		    	}else{
		    		echo json_encode(base_url().'public/images/'.$img);
		    	}
		    }
	    }

	    public function downloadCustomerdocs($docs_id)
	    {
	    	if(!empty($docs_id))
	    	{
		    	$query = $this->db->where("docs_id", $docs_id)->get('docs')->row_array();
		    	$img = $query['file'];
		    	$match_http = substr($img, 0, 4);
		    	if($match_http == "http")
		    	{
		    		// echo json_encode($img);
	        		force_download($img, live.$img);
		    	}else{
		    		if(server == "localhost"){
		        		force_download($img, base_url().localhost.$img);
		        	}else{
		        		force_download($img, live.$img);
		        	}
		    	}
		    }
	    }

		public function sendRequestToCustomerForUploadDocs()
	    {
            $lead_id = $this->input->post('lead_id');
	    	if(isset($lead_id))
	    	{
	    		$leadDetails = $this->db->select("leads.name, leads.mobile")->where('lead_id', $lead_id)->get('leads')->row_array();
	    		$name = $leadDetails['name'];
	    		$mobile = $leadDetails['mobile'];

	        	$msg = "Dear ".ucfirst($name).",\nYour documentation process is incomplete.\nPlease click on the below link to upload the required documents.\n.https://www.loanwalle.com/re-upload-docs/\nThank you";

	    		$this->notification($mobile, $msg);
		        echo json_encode("true");
	    	}
	    }

	    public function notification($mobile, $msg)
		{
			$username = urlencode("namanfinl");
			$password = urlencode("6I1c0TdZ");
			$message = urlencode($msg);
			$destination = $mobile;
			// 	$destination = "8887877098";
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
            //  echo "<pre>"; print_r($data); exit;

			curl_close($ch);
		} 

		public function saveCustomerDocs()
		{
			if($this->input->post('user_id') == ""){
				return redirect(base_url(), 'refresh');
			}
			if(isset($_FILES['file_name']['name']))  
			{ 
            	$config['upload_path'] = 'upload/';
                $config['allowed_types'] = 'pdf|jpg|png|jpeg';  
				$this->upload->initialize($config);
				if(!$this->upload->do_upload('file_name'))
				{ 
					echo $this->upload->display_errors(); 
				}
				else
				{  
					$data = array('upload_data' => $this->upload->data());
        			$lead_id     = $this->input->post('lead_id');
        			$customer_id = $this->input->post('customer_id');
        			$user_id     = $this->input->post('user_id');
        			$company_id  = $this->input->post('company_id'); 
        			$product_id  = $this->input->post('product_id'); 
        			$docs_id     = $this->input->post('docs_id');
					$docs_type    = $this->input->post('docuemnt_type');
					$sub_docs_type    = $this->input->post('document_name');
					$password    = $this->input->post('password');
					$image       = $data['upload_data']['file_name'];  

            		if(empty($docs_id) && !empty($lead_id) && !empty($customer_id))
            		{
            		    $fetch = 'C.pancard, C.mobile';
            		    $join2 = "LD.customer_id = C.customer_id";
            		    $getLeads = $this->Tasks->join_two_table($fetch, $this->tbl_customer, $this->tbl_leads, $join2);

            		    $lead = $getLeads->row();

    		            $data = array (
    		                'lead_id'       => $lead_id,
    		                'company_id'    => $company_id,
    		                'customer_id'    => $customer_id,
    		                'pancard'       => $lead->pancard,
    		                'mobile'        => $lead->mobile,
    		                'docs_type'     => $docs_type,
    		                'sub_docs_type' => $sub_docs_type,
    		                'file'          => $image,
    		                'pwd'           => $password,
    		                'ip'            => ip,
    		                'upload_by'     => $user_id,
    		                'created_on'    => timestamp
    		            );
    		            $result = $this->Leads->globel_inset('docs', $data);
    		            echo "true";
            		}else{
    		            // $data = array (
    		            //     'pwd'           => $password,
    		            //     'docs_type'     => $docs_type,
    		            //     'sub_docs_type' => $sub_docs_type,
    		            //     'file'          => $image,
    		            //     'ip'            => ip,
    		            //     'upload_by'     => 1,
    		            //     'created_on'    => timestamp
    		            // );
    		            
                  //       $where = ['company_id' => $company_id];
    		            // $this->db->where($where)->where('lead_id', $lead_id)->where('docs_id', $docs_id)->update('docs', $data);
    		            echo "Required Custome ID and Lead ID";
            		}
				}   
	        }
		}

        public function allocateLeads()
        { 
            if(isset($_POST["checkList"]) && !empty(user_id))  
			{
                foreach($_POST["checkList"] as $lead_id)
			    {
			    	$label = $_SESSION['isUserSession']['labels'];
                    if($label == 'CR1' || $label == 'CA' || $label == 'SA') {
			            $status = "LEAD-INPROCESS";
			            $stage = "S2";
			        }
                    else if($label == 'CR2' || $label == 'CA' || $label == 'SA') {
			            $status = "APPLICATION-INPROCESS";
			            $stage = "S5";
                    }

	        		$data = [ 
		            	'status' 			=> $status, 
		            	'stage' 			=> $stage
		            ];
			        $where = ['company_id' => company_id, 'product_id' => product_id];
			        $data2 = [
			            'customer_id'  		=> $this->input->post('customer_id'), 
			            'lead_id'  			=> $lead_id, 
			            'user_id'       	=> $this->input->post('user_id'),
			            'status'            => $status,
			            'stage'            	=> $stage,
			            'created_on'    	=> timestamp,
			        ];
			        $conditions = ['lead_id' => $lead_id];
		            $this->Tasks->updateLeads($conditions, $data, $this->tbl_leads);  
		            $this->Tasks->insert($data2, 'lead_followup'); 
			    }
	            echo "true";  
			}else{
				$json['err'] = "Somthing Found wrong.";
	            echo json_encode($json); 
			}  
            
        }
        
        public function reallocate()
        {
            
         echo "<pre>"; print_r($_POST); exit;   
            
        }

		public function resonForDuplicateLeads()
		{
			if(isset($_POST["checkList"]))  
			{
			    foreach($_POST["checkList"] as $item)
			    {
        			$lead_id = $item;
                    $this->Tasks->update(['lead_id' => $lead_id], ['status' => 'DUPLICATE', 'stage' => 'S14']);
			    }
	            echo "true";
	        } else {
	        	echo "false";
	        }
		}
	    
		public function duplicateTaskList()
	    {
	        $taskLists = $this->Tasks->duplicateTask();
    		$data['taskCount'] = $taskLists->num_rows();
    		$data['listTask'] = $taskLists->result();
    		
	        $this->load->view('Tasks/DuplicateTaskList', $data);
	    }
	    
		public function duplicateLeadDetails($lead_id)
	    {
	        $taskLists = $this->Tasks->duplicateTaskList($lead_id);
	        echo json_encode($taskLists);
	    }
	    
	    public function saveHoldleads($lead_id)
	    {
	        $where = ['company_id' => company_id, 'product_id' => product_id];
	        $status = $this->input->post('status');
	        $stage = $this->input->post('stage');

	        if(agent == 'CR1'){
	        	$status = "LEAD-HOLD";
	        	$stage = "S3";
	        }
	        if(agent == 'CR2'){
	        	$status = "APPLICATION-HOLD";
	        	$stage = "S6";
	        }

	        $data1 = [
	            'status'            => $status,
	            'stage'            	=> $stage,
	        ];
	        $data2 = [
	            'lead_id'  			=> $lead_id, 
	            'customer_id'  		=> $this->input->post('customer_id'), 
	            'user_id'       	=> $this->input->post('user_id'),
	            'status'            => $status,
	            'stage'            	=> $stage,
	            'remarks'   		=> $this->input->post('hold_remark'),
	            'scheduled_date'    => date('d-m-Y h:i:sa' ,strtotime($this->input->post('hold_date'))),
	            'created_on'    	=> timestamp,
	        ];
	        
	        $conditions = ['lead_id' => $lead_id];
            $this->Tasks->updateLeads($conditions, $data1, 'leads');  
            $this->Tasks->insert($data2, 'lead_followup');  
	        $data['msg'] = 'Application Hold Successfuly.';
	        echo json_encode($data);
	    }

        public function generateLoanNo()
        {
        	
        	$fetchProductData = 'product_code, product_name';

        	$selectProduct = $this->PM->select($company_id, $fetchProductData);
        	$product = $selectProduct->row();
        	$PDCode = $product->product_code;

        	$fetchDisburseData = 'loan_no';
        	$disbursalDetails = $this->DM->selectDisbursalDetails($fetchDisburseData);
        	$Disbursal = $disbursalDetails->row();
        	$lastLoanNO = $Disbursal->loan_no;

        	$CITYCode = "MUM";
        	// $lastLoanNO = 'NFPDMUM0009';
        	$number = preg_replace("/[a-zA-Z]/", '', $lastLoanNO); // only 0-9
        	$number1 = preg_replace("/[a-zA-Z0]/", '', $lastLoanNO); // only 1-9
        	$number2 = preg_replace("/[a-zA-Z1-9]/", '', $lastLoanNO); // only 0000
        	

	        $counting = ++$number;
	        $numOfZeros = 0;
	        if(strlen($lastLoanNO) > 4){
	        	for($i = 0; $i < (strlen($number2) - 1); $i++){
	        		$numOfZeros .= "0";
	        	}
	        }else{
	        	$numOfZeros = $number2;
	        }

	        echo $loanNo = "NF". $PDCode ."". $CITYCode ."". $numOfZeros ."". $counting; // NFPDMUM00000003;
        }

        public function sanctionleads()
        {
        	if($this->input->post('user_id') == ''){
        		$json['errSession'] = "Session Expired";
        		echo json_encode($json);
        	}
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
		    {
        		$this->form_validation->set_rules('lead_id', 'Lead ID', 'required|trim');
        		$this->form_validation->set_rules('customer_id', 'Customer ID', 'required|trim');
        		$this->form_validation->set_rules('company_id', 'Company ID', 'required|trim');
        		$this->form_validation->set_rules('product_id', 'Product ID', 'required|trim');
        		$this->form_validation->set_rules('salary_credit1', 'Salary 1', 'required|trim');
        		$this->form_validation->set_rules('salary_credit2', 'Salary 2', 'required|trim');
        		$this->form_validation->set_rules('salary_credit3', 'Salary 3', 'required|trim');
        		$this->form_validation->set_rules('salary_credit1_date', 'Salary Date 1', 'required|trim');
        		$this->form_validation->set_rules('salary_credit2_date', 'Salary Date 2', 'required|trim');
        		$this->form_validation->set_rules('salary_credit3_date', 'Salary Date 3', 'required|trim');
        		$this->form_validation->set_rules('salary_credit1_amount', 'Salary Amount 1', 'required|trim');
        		$this->form_validation->set_rules('salary_credit2_amount', 'Salary Amount 2', 'required|trim');
        		$this->form_validation->set_rules('salary_credit3_amount', 'Salary Amount 3', 'required|trim');
        		$this->form_validation->set_rules('processing_fee_percent', 'Admin Fee Percentage', 'required|trim');

        		$this->form_validation->set_rules('loan_recommended', 'Loan Recommended', 'required|trim');
	        	$this->form_validation->set_rules('disbursal_date', 'Disbursal Date', 'required|trim');
	        	$this->form_validation->set_rules('repayment_date', 'Repayment Date', 'required|trim');
        		$this->form_validation->set_rules('roi', 'ROI', 'required|trim|callback_check_zero');

	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
		            echo json_encode($json);
	        	} else {
					$lead_id = $this->input->post('lead_id');
					$status = "SANCTION";
					$stage = "S12";
					$data = ['status' => $status, "stage" => $stage];
					$data2 = [
						'lead_id' 		=> $lead_id,
						'customer_id' 	=> $this->input->post('customer_id'),
						'user_id' 		=> $this->input->post('user_id'),
						'status' 		=> $status, 
						"stage" 		=> $stage, 
						'remarks' 		=> "Sanctioned",
						'created_on'	=> timestamp
					];

	        		include ("DisbursalController.php");
	        		$DC = new DisbursalController();
	        		$sendLetter = $DC->sendDisbursalMail($lead_id);
	        		$loan_no = $this->Tasks->generateLoanNo($lead_id);

					$data3 = [
						'company_id' 				=> $this->input->post('company_id'),
						'product_id' 				=> $this->input->post('product_id'),
						'lead_id' 					=> $this->input->post('lead_id'),
						'customer_id' 				=> $this->input->post('customer_id'),
						'loan_no' 					=> $loan_no,
						'status' 					=> $status,
						'loanAgreementRequest' 		=> ($sendLetter == true) ? 1 : 0,
						'agrementRequestedDate' 	=> ($sendLetter == true) ? timestamp : '',
					];
		        	$conditions = ['company_id' => company_id, 'product_id' => product_id, 'lead_id' => $lead_id];
					$this->Tasks->updateLeads($conditions, $data, 'leads');
	            	$this->Tasks->insert($data2, 'lead_followup'); 
	            	$this->Tasks->insert($data3, 'loan');   
		            $data['msg'] = 'Application Senctioned.';
		            echo json_encode($data);
		        }
	        }
        }

		public function leadSendBack()
		{
        	if($this->input->post('user_id') == ''){
        		$json['errSession'] = "Session Expired";
        		echo json_encode($json);
        	}
			if(isset($_POST["lead_id"]))  
			{
				$lead_id = $this->input->post('lead_id');
				$status = "APPLICATION-SEND-BACK";
				$stage = "S11";
				$data = ['status' => $status, "stage" => $stage];
				$data2 = [
					'lead_id' 		=> $lead_id,
					'customer_id' 	=> $this->input->post('customer_id'),
					'user_id' 		=> $this->input->post('user_id'),
					'status' 		=> $status, 
					"stage" 		=> $stage, 
					'remarks' 		=> "Head sommething found wrong.",
					'created_on'	=> timestamp
				];
	        	$conditions = ['company_id' => company_id, 'product_id' => product_id, 'lead_id' => $lead_id];
				$this->Tasks->updateLeads($conditions, $data, 'leads');
            	$this->Tasks->insert($data2, 'lead_followup');   
	            $data['msg'] = 'Application Send Back.';
	            echo json_encode($data);
	        }
		}

		// public function AddContactDetails($lead_id)
		// {
		// 	if ($this->input->server('REQUEST_METHOD') == 'POST') 
	 //        {
	 //        	$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
	 //        	$this->form_validation->set_rules('alternateMobileNo', 'Alternate Mobile No', 'required|trim');
	 //        	$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
	 //        	$this->form_validation->set_rules('alternateEmailAddress', 'Alternate Email Address', 'required|trim|valid_email');
	 //        	$this->form_validation->set_rules('gender', 'Gender', 'required|trim');
	 //        	$this->form_validation->set_rules('pancard', 'Pancard', 'required|trim|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/]');
	 //        	$this->form_validation->set_rules('addressLine1', 'Address Line1', 'required|trim');
	 //        	$this->form_validation->set_rules('area', 'Area', 'required|trim');
	 //        	$this->form_validation->set_rules('pincode', 'Pincode', 'required|trim');
	 //        	$this->form_validation->set_rules('landmark', 'Landmark', 'required|trim');

	 //        	if($this->form_validation->run() == FALSE) {
	 //        		$json['error'] = validation_errors();
		//             echo json_encode($json);
	 //        	} else {
		// 			$alternateMobileNo = $this->input->post('alternateMobileNo');
		// 			$alternateEmailAddress = $this->input->post('alternateEmailAddress');
		// 			$addressLine1 = $this->input->post('addressLine1');
		// 			$area = $this->input->post('area');
		// 			$landmark = $this->input->post('landmark');
		// 			$mobile = $this->input->post('mobile');
		// 			$email = $this->input->post('email');
		// 			$gender = ucfirst($this->input->post('gender'));
		// 			$pincode = $this->input->post('pincode');
		// 			$pancard = $this->input->post('pancard');
		// 			$dob     = $this->input->post('dob');

		//             $data = array (
		//                 'pancard'       			=> $pancard,
		//                 'mobile'       				=> $mobile,
		//                 'alternateMobileNo'       	=> $alternateMobileNo,
		//                 'email'   					=> $email,
		//                 'alternateEmailAddress'   	=> $alternateEmailAddress,
		//                 'gender'   					=> $gender,
		//                 'pincode'   				=> $pincode,
		//                 'addressLine1'       		=> $addressLine1,
		//                 'area'       				=> $area,
		//                 'landmark'       			=> $landmark,
		//                 'dob'       		    	=> $dob,
		//                 'contactUpdatedBy'       	=> 1,
		//             );

		//             $this->db->where('lead_id', $lead_id)->update('leads', $data);
		//             $result = "true";
		//             echo json_encode($result);
		//         }
	 //        }
		// }

		// public function saveCustomerEmployeeDetails($lead_id)
		// {
		// 	if ($this->input->server('REQUEST_METHOD') == 'POST') 
	 //        {
	 //        	$this->form_validation->set_rules('employeeType', 'Employee Type', 'required|trim');
	 //        	$this->form_validation->set_rules('dateOfJoining', 'Date Of Joining', 'required|trim');
	 //        	$this->form_validation->set_rules('designation', 'Designation', 'required|trim');
	 //        	$this->form_validation->set_rules('currentEmployer', 'Current Employer', 'required|trim');
	 //        	$this->form_validation->set_rules('companyAddress', 'Company Address', 'required|trim');
	 //        	$this->form_validation->set_rules('otherDetails', 'Other Details', 'required|trim');

	 //        	if($this->form_validation->run() == FALSE) {
	 //        		$json['error'] = validation_errors();
		//             echo json_encode($json);
	 //        	} else {
		//             $data = array (
		// 				'lead_id'		 	 => $lead_id,
		// 				'employeeType'		 => $this->input->post('employeeType'),
		// 				'dateOfJoining'		 => $this->input->post('dateOfJoining'),
		// 				'designation'		 => $this->input->post('designation'),
		// 				'currentEmployer'	 => $this->input->post('currentEmployer'),
		// 				'companyAddress'	 => $this->input->post('companyAddress'),
		// 				'otherDetails'		 => $this->input->post('otherDetails'),
		// 				'updated_by'		 => $_SESSION['isUserSession']['user_id'],
		//             );
		//             $result = $this->db->insert('tbl_customerEmployeeDetails', $data);
		//             $this->db->where('lead_id', $lead_id)->update('leads', ['employeeDetailsAdded' => 1]);
		//             echo json_encode($result);
		//         }
	 //        }
		// }

		// public function ShowCustomerEmploymentDetails($lead_id)
		// {
	 //    	if(!empty($lead_id))
	 //    	{
	 //    		$result = $this->Tasks->ShowCustomerEmploymentDetails($lead_id);
		//         echo json_encode($result);
	 //    	}
		// }

		public function RequestForApproveLoan()
		{
			if(isset($_POST["lead_id"]))  
			{
				$lead_id = $this->input->post('lead_id');
	            $query = $this->db->select('leads.contactUpdatedBy, leads.employeeDetailsAdded, leads.credit_added')
	            ->where('leads.created_on BETWEEN "'. date('Y-m-d', strtotime("2020-12-06")). '" and "'. date('Y-m-d', strtotime(todayDate)).'"')
	            
                //->where('date(leads.created_on)', todayDate)
	            ->where('lead_id', $lead_id)->get('leads')->row();
				$contactUpdatedBy = $query->contactUpdatedBy;
				$employeeDetailsAdded = $query->employeeDetailsAdded;
				$credit_added = $query->credit_added;
				// if($contactUpdatedBy == 0) {
				// 	$json["err"] = "Contact Details Required.";
				// } else if($employeeDetailsAdded == 0) {
				// 	$json["err"] = "Employee Details Required.";
				// } else if($credit_added == 0) {
				// 	$json["err"] = "Credit Details Required.";
				// } else {
					$data = [
							'loan_approved'     => 1,
							'status' 	 	    => "Credit",
							'credit_manager_id' 	 	=> $_SESSION['isUserSession']['user_id']
						];
		            $this->db->where('lead_id', $lead_id)->update('leads', $data);
					$json["msg"] = "Request Send to Head.";
				// }
			    echo json_encode($json);
	        }
		}

		public function taskRequestForApprove()
	    {
            $this->db->select('leads.lead_id, leads.name, leads.email, tb_states.state, leads.created_on, leads.source, leads.status, leads.credit_manager_id, leads.partPayment')
                ->where('leads.loan_approved', 1)
                ->from(tableLeads)
                ->join('tb_states', 'leads.state_id = tb_states.id');
            $query = $this->db->order_by('leads.lead_id', 'desc')->get();
			$data['taskCount'] = $query->num_rows();
			$data['listTask'] = $query->result();
            
        	$this->load->view('Tasks/taskRequestForApprove', $data);
	    }
	    
		public function ApproveSenctionLoan()
		{
			if(isset($_POST["lead_id"]))  
			{
				$lead_id = $this->input->post('lead_id');

				$this->db->select('leads.lead_id, leads.name, leads.email, leads.mobile, leads.source, leads.status, leads.credit_manager_id, leads.partPayment, credit.loan_amount_approved, credit.tenure, credit.roi, credit.repay_amount, credit.repayment_date, credit.updated_on, credit.processing_fee')
	               // ->where('leads.created_on BETWEEN "'. date('Y-m-d', strtotime("2020-12-01")). '" and "'. date('Y-m-d', strtotime("2020-12-03")).'"')
	                ->where('leads.lead_id', $lead_id)
	                ->from('leads')
	                ->join('credit', 'credit.lead_id = leads.lead_id')
	                ->join('tb_states', 'leads.state_id = tb_states.id');
	            $query = $this->db->get()->row();

				$name = $query->name;
				$mobile = $query->mobile;

				$msg = "Dear ".$name .",\nYour loan amount of \nRs. ".$query->loan_amount_approved."\nis sanctioned of ROI ".$query->roi."/ day \nIf you fail to pay \nRepay amount : ".$query->repay_amount." \non Repayment date : ".$query->repayment_date." \nthen the interest rate will be double of interest \nThanks & Regards \nLoanwalle";

	            $this->notification($mobile, $msg); 
                $loan_approved = 3;
                if($_SESSION['isUserSession']['role'] == "Client Admin"){
                	$loan_approved = 0;
                }
	            $data = array (
	            	'loan_approved' => $loan_approved, 
	            	'status' 		=> "Sanction", 
	            	'is_Disbursed' 	=> 1
	            );
	            $this->db->where('lead_id', $lead_id)->update('leads', $data);
	            $this->db->where('lead_id', $lead_id)->update('credit', ['is_Senctioned' => 3]);
	            echo "true";
	        }
		}

		public function getReasonList()
		{
			$data = $this->db->get('tbl_rejected_reson')->result();
			echo "<pre>"; print_r($data); exit;
		} 
		
		public function followUp()
	    { 
	        $lead_id = $this->input->post('lead_id');
	        $remark = $this->input->post('reson');
	        $data = array (
	            	'lead_status'   => "Hold", 
	            	'status' 		=> "Hold", 
	            	'remark' 		=> $remark, 
	            	'updated_on' 	=> date('Y-m-d H:i:s'),
	            );
	       if($this->db->where('lead_id', $lead_id)->update('leads', $data))
	       {
	          echo "true"; 
	       } 
	    }
		
		public function sanctionLetter($lead_id)
	    { 
	        $data = array (
	            	'lead_status'   => "Hold", 
	            	'status' 		=> "Hold", 
	            	'updated_on' 	=> date('Y-m-d H:i:s'),
	            );
            $this->db->where('lead_id', $lead_id)->update('leads', $data); 
            
            $this->db->select('leads.lead_id, leads.name, leads.email, leads.mobile, leads.loan_amount, leads.created_on, leads.updated_on') 
                    ->where('leads.lead_id', $lead_id)
                    ->from('leads');
            $query = $this->db->get()->row(); 
            $loan_amount = $query->loan_amount;
            $proccessingfee = ($loan_amount * 2 /100); 
	            
            $date = strtotime($query->updated_on);
            $new_date = date('d-m-Y', $date);
	            
		    $config['protocol']    = 'ssmtp';
            $config['smtp_host']    = 'loanagainstcard.com';
            $config['smtp_port']    = '465';
            $config['smtp_timeout'] = '7';
            $config['smtp_user']    = 'docs@loanagainstcard.com';
            $config['smtp_pass']    = 'R{vo&!f=RU]5';
            $config['charset']    	= 'utf-8';
            $config['newline']    	= "\r\n";
            $config['mailtype'] 	= 'html'; // or html
            $config['validation'] 	= TRUE; // bool whether to validate email 
            $config['newline'] 		= "\r\n";
            $config['newline'] 		= "\r\n";  
              
            $message = '<table width="668" border="0" align="center" cellpadding="0" cellspacing="0" style="padding:20px; border:solid 1px #ddd; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:25px;">
                              <tr>
                                <td colspan="3" style="border-bottom:1px #ddd solid; padding-bottom:20px; line-height:0px;"><img src="'.base_url("public/mailer_image/").'logo.png" width="250" height="70" /></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="365"><strong id="docs-internal-guid-d40fae2e-7fff-359a-3929-25076e5203fb">Dear Sir,</strong></td>
                                <td width="11">&nbsp;</td>
                                <td width="290" rowspan="2"><img src="'.base_url("public/mailer_image/").'sanction-images-mailer.jpg" width="279" height="205" style="border: solid 4px #e28b45;
                                border-radius: 5px;" /></td>
                              </tr>
                              <tr>
                                <td valign="top">Congratulations! Your loan has been successfully sanctioned. You are just one step away from the disbursal of your loan.<br />
                                  <br />
                                For a quick disbursal, go through the below-mentioned terms and conditions of the loan. Kindly accept the conditions and revert back with the required documents.</td>
                                <td valign="top">&nbsp;</td>
                              </tr>
                              <tr>
                                <td valign="top">&nbsp;</td>
                                <td valign="top">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="3"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#dddddd">
                                  <tr>
                                    <td width="47%" bgcolor="#FFFFFF" style="padding:10px;"><strong>Name</strong></td>
                                    <td width="4%" align="center" valign="middle" bgcolor="#FFFFFF" style="padding:10px;"><strong>:</strong></td>
                                    <td width="49%" bgcolor="#FFFFFF" style="padding:10px;">'.$query->name.'</td>
                                  </tr>
                                  <tr>
                                    <td bgcolor="#FFFFFF" style="padding:10px;"><strong>Loan Amount</strong></td>
                                    <td align="center" valign="middle" bgcolor="#FFFFFF" style="padding:10px;"><strong>:</strong></td>
                                    <td bgcolor="#FFFFFF">'.$query->loan_amount.'</td>
                                  </tr>
                                  <tr>
                                    <td bgcolor="#FFFFFF" style="padding:10px;"><strong id="docs-internal-guid-81302841-7fff-d67e-afb5-3794704879ca">Rate of Interest</strong></td>
                                    <td align="center" valign="middle" bgcolor="#FFFFFF" style="padding:10px;"><strong>:</strong></td>
                                    <td bgcolor="#FFFFFF" style="padding:10px;">1% /Day</td>
                                  </tr>
                                  <tr>
                                    <td bgcolor="#FFFFFF" style="padding:10px;"><strong id="docs-internal-guid-812ef595-7fff-f93d-6228-79a9ef54e56d">Processing fee</strong></td>
                                    <td align="center" valign="middle" bgcolor="#FFFFFF" style="padding:10px;"><strong>:</strong></td>
                                    <td bgcolor="#FFFFFF" style="padding:10px;">'.$proccessingfee.'</td>
                                  </tr>
                                  <tr>
                                    <td bgcolor="#FFFFFF" style="padding:10px;"><strong id="docs-internal-guid-6cfc4d8a-7fff-22ce-a262-a90cab84fac7">Sanction Date</strong></td>
                                    <td align="center" valign="middle" bgcolor="#FFFFFF" style="padding:10px;"><strong>:</strong></td>
                                    <td bgcolor="#FFFFFF" style="padding:10px;">'.$new_date.'</td>
                                  </tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td colspan="3">&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="3"><strong id="docs-internal-guid-5e8941b7-7fff-41ae-b25d-b8a499450e3d">The documents required are:</strong></td>
                              </tr>
                              <tr>
                                <td colspan="3">■ PAN Card</td>
                              </tr>
                              <tr>
                                <td colspan="3">■ Aadhar Card</td>
                              </tr>
                              <tr>
                                <td colspan="3">■ Canceled Cheque</td>
                              </tr>
                              <tr>
                                <td colspan="3">■ Latest Credit Card statement</td>
                              </tr>
                              <tr>
                                <td colspan="3">&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="3"><strong style="color:red;">Note- </strong>The validity of this letter is one month from the sanction date</td>
                              </tr>
                              <tr>
                                <td colspan="3">&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="3"><strong id="docs-internal-guid-970d1140-7fff-4671-039b-fb260d16cb46">Warm Regards,</strong></td>
                              </tr>
                              <tr>
                                <td colspan="3"><a href="https://loanagainstcard.com/" target="_blank" style="text-decoration:blink;">Loanagainstcard.com</a></td>
                              </tr>
                              <tr>
                                <td colspan="3">Powered by Naman Finlease Pvt. Ltd. (RBI approved NBFC)</td>
                              </tr>
                              <tr>
                                <td colspan="3">Tower 12-102, Sunworld Vanalika Noida-201304</td>
                              </tr>
                            </table>'; 
    
            $this->load->library('email');
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->from('docs@loanagainstcard.com');
            $this->email->to($query->email);
            $this->email->bcc('docs@loanagainstcard.com'); 
            $this->email->subject("Loan Sanctioned From Loanagainstcard");
            $this->email->message($message);
            if($this->email->send())
            {
                echo "true"; 
            }else{
                echo "Sanctioned mail Not send !"; 
            }
		}

		public function getPersonalDetails($lead_id)
		{
			$tbl_users = "users U1";
	        $fetch = "LD.application_no, LD.lead_id, C.first_name, C.middle_name, C.sur_name, C.gender, C.dob, C.pancard, C.email, C.alternate_email, C.mobile, C.alternate_mobile, U1.name as screenedBy, LF.created_on as screenedOn";
	        $conditions = ['LD.lead_id' => $lead_id];
	        $join2 = 'C.customer_id = LD.customer_id';
	        $join3 = 'LD.lead_id = LF.lead_id';
	        $join4 = 'U1.user_id = LF.user_id';

	    	$personalDetails = $this->Tasks->join_table($conditions, $fetch, $this->tbl_leads, $this->tbl_customer, $join2, $this->tbl_lead_followup, $join3, $tbl_users, $join3);
	    	$data['personalDetails1'] = $personalDetails->row();
			echo json_encode($data);
		}

		public function getResidenceDetails($lead_id)
		{
			$tbl_users = "users U1";
	        $fetch = "C.current_house, C.current_locality, C.current_landmark, C.current_residence_since, C.current_residence_type, C.current_residing_withfamily, C.aadhar_no, C.current_state, C.current_city, C.current_district, C.cr_residence_pincode, C.current_res_status, U1.name as screenedBy, LF.created_on as screenedOn, C.aa_same_as_current_address, C.aa_current_house, C.aa_current_locality, C.aa_current_state, C.aa_current_city, C.aa_current_district, C.aa_cr_residence_pincode, C.current_residence_since, C.current_residence_type, C.current_residing_withfamily";
	        $conditions = ['LD.lead_id' => $lead_id];
	        $join2 = 'C.customer_id = LD.customer_id';
	        $join3 = 'LD.lead_id = LF.lead_id';
	        $join4 = 'U1.user_id = LF.user_id';

	    	$residenceDetails = $this->Tasks->join_table($conditions, $fetch, $this->tbl_leads, $this->tbl_customer, $join2, $this->tbl_lead_followup, $join3, $tbl_users, $join3);
	    	$data['residenceDetails'] = $residenceDetails->row();
			echo json_encode($data);
		}

		public function getEmploymentDetails($lead_id)
		{
	        $fetch = "CE.customer_id, CE.employer_name, CE.emp_state, CE.emp_city, CE.emp_district, CE.emp_pincode, CE.emp_house, CE.emp_street, CE.emp_landmark, CE.emp_residence_since, CE.presentServiceTenure, CE.emp_designation, CE.emp_department, CE.emp_employer_type, CE.emp_website, CE.monthly_income, CE.emp_salary_mode, CE.income_type, CE.industry, CE.sector, CE.salary_mode, CE.emp_status, CE.created_on";
	        $conditions = ['LD.lead_id' => $lead_id];
	        $join2 = 'CE.customer_id = LD.customer_id';

	    	$employmentDetails = $this->Tasks->join_two_table_with_where($conditions, $fetch, $this->tbl_leads, $this->tbl_customer_employment, $join2);
	    	$data['employmentDetails'] = $employmentDetails->row();
			echo json_encode($data);
		}

		public function getReferenceDetails($lead_id)
		{
	        $fetch = "CE.customer_id, CE.reference_one, CE.reference_two, CE.relation_one, CE.relation_two, CE.ref_one_mobile, CE.ref_two_mobile";
	        $conditions = ['LD.lead_id' => $lead_id];
	        $join2 = 'CE.customer_id = LD.customer_id';

	    	$referenceDetails = $this->Tasks->join_two_table_with_where($conditions, $fetch, $this->tbl_leads, $this->tbl_customer_employment, $join2);
	    	$data['referenceDetails'] = $referenceDetails->row();
			echo json_encode($data);
		}

		public function insertPersonal()
		{
			// echo "<pre>"; print_r($_POST); exit;
			if($this->input->post('user_id') == ""){
				return redirect(base_url(), 'refresh');
			}
			if($this->input->server('REQUEST_METHOD') == 'POST')
		    {
	        	$this->form_validation->set_rules('customer_id', 'Customer ID', 'required|trim');
	        	$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
	        	$this->form_validation->set_rules('middle_name', 'Middle Name', 'trim');
	        	$this->form_validation->set_rules('sur_name', 'Surname', 'trim');
	        	$this->form_validation->set_rules('gender', 'Gender', 'required|trim');

        		$this->form_validation->set_rules('dob', 'DOB', 'required|trim');
        		$this->form_validation->set_rules('pancard', 'Pancard', 'required|trim');
        		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
        		$this->form_validation->set_rules('alternate_mobile', 'Alternate Mobile', 'required|trim');
        		$this->form_validation->set_rules('email', 'Alternate Email', 'required|trim');

				if($state == "" || $city == "" || $pincode == ""){
        			$this->form_validation->set_rules('state', 'State', 'required|trim');
        			$this->form_validation->set_rules('city', 'City', 'required|trim');
        			$this->form_validation->set_rules('pincode', 'Pincode', 'required|trim');
				} else {
	        		$this->form_validation->set_rules('screenedBy', 'Screener By', 'required|trim');
	        		$this->form_validation->set_rules('screenedOn', 'Screener ON', 'required|trim');
				}

	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
	        	} else {
	        		$lead_id = $this->input->post('lead_id');
	        		$conditions = ['C.customer_id' => $this->input->post('customer_id')];
	        		$data = [
					    'first_name' 		=> $this->input->post('first_name'),
					    'middle_name' 		=> $this->input->post('middle_name'),
					    'sur_name' 			=> $this->input->post('sur_name'),
					    'gender' 			=> $this->input->post('gender'),
					    'dob' 				=> $this->input->post('dob'),
					    'pancard' 			=> $this->input->post('pancard'),
					    'mobile' 			=> $this->input->post('mobile'),
					    'alternate_mobile' 	=> $this->input->post('alternate_mobile'),
					    'email' 			=> $this->input->post('email'),
					    'alternate_email' 	=> $this->input->post('alternate_email')
	        		];

    				if($state == "" || $city == "" || $pincode == "")
    				{
    					$conditions2 = ['lead_id' => $lead_id];
    					$data2 = [
    						'customer_id' 	=> $this->input->post('customer_id'),
    						'state_id' 		=> $this->input->post('state'),
	    					'city' 			=> $this->input->post('city'),
	    					'pincode' 		=> $this->input->post('pincode')
	    				];
	        			$this->Tasks->globalUpdate($conditions2, $data2, 'leads');
	        		// echo "leads : <pre>"; print_r($data2); exit;
    				}
	        		// echo "<pre>"; print_r($_POST); exit;
	        		$result = $this->Tasks->globalUpdate($conditions, $data, $this->tbl_customer);
	        		if($result == true)
	        		{
		        		$json['msg'] = "Customer Details Updated Successfully.";
		        	}else{
		        		$json['err'] = "Failed to Updated Customer Details.";
		        	}
	        	}
	            echo json_encode($json);
        	}
        	else
        	{
        		$json['err'] = "Invalid Request";
	            echo json_encode($json);
        	}
		}

		public function insertResidence()
		{
			if($this->input->post('user_id') == ""){
				return redirect(base_url(), 'refresh');
			}
			if ($this->input->server('REQUEST_METHOD') == 'POST')
		    {
	        	$this->form_validation->set_rules('hfBulNo1', 'First Name', 'required|trim');
	        	$this->form_validation->set_rules('lcss1', 'Middle Name', 'required|trim');
	        	$this->form_validation->set_rules('lankmark1', 'Surname', 'trim');
	        	$this->form_validation->set_rules('state1', 'state1', 'required|trim');
	        	$this->form_validation->set_rules('city1', 'city1', 'required|trim');
	        	$this->form_validation->set_rules('pincode1', 'pincode1', 'required|trim');
	        	$this->form_validation->set_rules('district1', 'district1', 'trim');
	        	$this->form_validation->set_rules('aadhar1', 'aadhar1', 'required|trim');
	        	$this->form_validation->set_rules('addharAddressSameasAbove', 'addharAddressSameasAbove', 'trim');

	        	$this->form_validation->set_rules('hfBulNo2', 'hfBulNo2', 'required|trim');
	        	$this->form_validation->set_rules('lcss2', 'lcss2', 'required|trim');
	        	$this->form_validation->set_rules('landmark2', 'landmark2', 'trim');
	        	$this->form_validation->set_rules('state2', 'state2', 'required|trim');
	        	$this->form_validation->set_rules('city2', 'city2', 'required|trim');
	        	$this->form_validation->set_rules('pincode2', 'pincode2', 'required|trim');
	        	$this->form_validation->set_rules('district2', 'district2', 'trim');
	        	$this->form_validation->set_rules('presentResidenceType', 'presentResidenceType', 'required|trim');
	        	$this->form_validation->set_rules('residenceSince', 'residenceSince', 'required|trim');

	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
	        	} else {
	        		$conditions = ['C.customer_id' => $this->input->post('customer_id')];
	        		
					$dataResidence = [
					    'current_house' 			=> $this->input->post('hfBulNo1'),
					    'current_locality' 			=> $this->input->post('lcss1'),
					    'current_landmark' 			=> $this->input->post('lankmark1'),
					    'current_state' 			=> $this->input->post('state1'),
					    'current_city' 				=> $this->input->post('city1'),
					    'cr_residence_pincode' 		=> $this->input->post('pincode1'),
					    'current_district' 			=> $this->input->post('district1'),
					    'aadhar_no' 				=> $this->input->post('aadhar1'),
					    'aa_same_as_current_address'=> $this->input->post('addharAddressSameasAbove'),
					    'aa_current_house' 			=> $this->input->post('hfBulNo2'),
					    'aa_current_locality' 		=> $this->input->post('lcss2'),
					    'aa_current_landmark' 		=> $this->input->post('landmark2'),
					    'aa_current_state' 			=> $this->input->post('state2'),
					    'aa_current_city' 			=> $this->input->post('city2'),
					    'aa_cr_residence_pincode' 	=> $this->input->post('pincode2'),
					    'aa_current_district' 		=> $this->input->post('district2'),
					    'current_residence_type' 	=> ($this->input->post('presentResidenceType'))?$this->input->post('presentResidenceType') : "OWNED",
					    'current_residence_since' 	=> $this->input->post('residenceSince')
					];
	        		$result = $this->Tasks->globalUpdate($conditions, $dataResidence, $this->tbl_customer);
	        		if($result == true)
	        		{
		        		$json['msg'] = "Residence Details Updated Successfully.";
		        	}else{
		        		$json['err'] = "Failed to Updated Residence Details.";
		        	}
	        	}
	            echo json_encode($json);
        	}
        	else
        	{
        		$json['err'] = "Invalid Request";
	            echo json_encode($json);
        	}
		}

		public function insertEmployment()
		{
			if($this->input->post('user_id') == ""){
				return redirect(base_url(), 'refresh');
			}
			if ($this->input->server('REQUEST_METHOD') == 'POST')
		    {
	        	$this->form_validation->set_rules('officeEmpName', 'Office/ Employer Name', 'required|trim');
	        	$this->form_validation->set_rules('hfBulNo3', 'Shop/ Block/ Building', 'required|trim');
	        	$this->form_validation->set_rules('lcss3', 'Locality', 'required|trim');
	        	$this->form_validation->set_rules('lankmark3', 'Landmark', 'trim');
	        	$this->form_validation->set_rules('state3', 'State', 'required|trim');
	        	$this->form_validation->set_rules('city3', 'City', 'required|trim');
	        	$this->form_validation->set_rules('pincode3', 'Pincode', 'required|trim');
	        	$this->form_validation->set_rules('district3', 'District', 'trim');
	        	$this->form_validation->set_rules('website', 'Website', 'required|trim');
	        	$this->form_validation->set_rules('employeeType', 'Employee Type', 'required|trim');
	        	$this->form_validation->set_rules('industry', 'Industry', 'trim');
	        	$this->form_validation->set_rules('sector', 'Sector', 'trim');
	        	$this->form_validation->set_rules('department', 'Department', 'trim');
	        	$this->form_validation->set_rules('designation', 'Designation', 'trim');
	        	$this->form_validation->set_rules('employedSince', 'Employed Since', 'required|trim');
	        	$this->form_validation->set_rules('presentServiceTenure', 'Present Service Tenure', 'trim');

	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
	        	} else {
	        		$lead_id = $this->input->post('lead_id');
	        		$customer_id = $this->input->post('customer_id');
	        		$conditions = ['CE.customer_id' => $customer_id, 'CE.lead_id' => $lead_id];
			        $today = '01-'. date('m-Y', strtotime(timestamp));
	        		$employedSince = "01-". $this->input->post('employedSince');

					$d1 = new DateTime($today); 
					$d2 = new DateTime($employedSince);                                  
					$Months = $d2->diff($d1); 
					$presentServiceTenure = (($Months->y) * 12) + ($Months->m);
	        		
					$dataResidence = [
					    'customer_id' 				=> $customer_id,
					    'company_id' 				=> $this->input->post('company_id'),
					    'product_id' 				=> $this->input->post('product_id'),
					    'employer_name' 			=> $this->input->post('officeEmpName'),
					    'emp_house' 				=> $this->input->post('hfBulNo3'),
					    'emp_street' 				=> $this->input->post('lcss3'),
					    'emp_landmark' 				=> $this->input->post('lankmark3'),
					    'emp_state' 				=> $this->input->post('state3'),
					    'emp_city' 					=> $this->input->post('city3'),
					    'emp_pincode' 				=> $this->input->post('pincode3'),
					    'emp_district' 				=> $this->input->post('district3'),
					    'emp_website' 				=> $this->input->post('website'),
					    'emp_employer_type' 		=> $this->input->post('employeeType'),
					    'industry' 					=> $this->input->post('industry'),
					    'sector' 					=> $this->input->post('sector'),
					    'emp_department' 			=> $this->input->post('department'),
					    'emp_designation' 			=> $this->input->post('designation'),
					    'emp_residence_since' 		=> $this->input->post('employedSince'),
					    'presentServiceTenure' 		=> $presentServiceTenure,
					    'emp_status' 				=> "YES",
					];
					$array2 = ['lead_id' => $lead_id];
					$data = array_merge($dataResidence, $array2);

			        $fetch2 = "CE.lead_id";
			        $conditions2 = ['CE.lead_id' => $lead_id];

			    	$employmentDetails = $this->Tasks->select($conditions2, $fetch2, $this->tbl_customer_employment);
			    	$empDetails = $employmentDetails->num_rows();

					if($empDetails == 0){
	        			$result = $this->Tasks->insert($data, 'customer_employment');
					}else{
	        			$result = $this->Tasks->globalUpdate($conditions, $data, $this->tbl_customer_employment);
					}
	        		if($result == true)
	        		{
		        		$json['msg'] = "Employment Details Added Successfully.";
		        	}else{
		        		$json['err'] = "Failed to Updated Employment Details.";
		        	}
	        	}
	            echo json_encode($json);
        	}
        	else
        	{
        		$json['err'] = "Invalid Request";
	            echo json_encode($json);
        	}
		}

		public function insertReference()
		{
	    	echo "<pre>"; print_r($_POST); exit;
			if($this->input->post('user_id') == ""){
				return redirect(base_url(), 'refresh');
			}
			if ($this->input->server('REQUEST_METHOD') == 'POST')
		    {
	        	$this->form_validation->set_rules('officeEmpName', 'Office/ Employer Name', 'required|trim');
	        	$this->form_validation->set_rules('hfBulNo3', 'Shop/ Block/ Building', 'required|trim');
	        	$this->form_validation->set_rules('lcss3', 'Locality', 'required|trim');
	        	$this->form_validation->set_rules('lankmark3', 'Landmark', 'trim');
	        	$this->form_validation->set_rules('state3', 'State', 'required|trim');
	        	$this->form_validation->set_rules('city3', 'City', 'required|trim');
	        	$this->form_validation->set_rules('pincode3', 'Pincode', 'required|trim');
	        	$this->form_validation->set_rules('district3', 'District', 'trim');
	        	$this->form_validation->set_rules('website', 'Website', 'required|trim');
	        	$this->form_validation->set_rules('employeeType', 'Employee Type', 'required|trim');
	        	$this->form_validation->set_rules('industry', 'Industry', 'trim');
	        	$this->form_validation->set_rules('sector', 'Sector', 'trim');
	        	$this->form_validation->set_rules('department', 'Department', 'trim');
	        	$this->form_validation->set_rules('designation', 'Designation', 'trim');
	        	$this->form_validation->set_rules('employedSince', 'Employed Since', 'required|trim');
	        	$this->form_validation->set_rules('presentServiceTenure', 'Present Service Tenure', 'trim');

	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
	        	} else {
	        		$lead_id = $this->input->post('lead_id');
	        		$customer_id = $this->input->post('customer_id');
	        		$conditions = ['CE.customer_id' => $customer_id, 'CE.lead_id' => $lead_id];
	        		
					$dataResidence = [
					    'customer_id' 				=> $customer_id,
					    'company_id' 				=> $this->input->post('company_id'),
					    'product_id' 				=> $this->input->post('product_id'),
					    'employer_name' 			=> $this->input->post('officeEmpName'),
					    'emp_house' 				=> $this->input->post('hfBulNo3'),
					    'emp_street' 				=> $this->input->post('lcss3'),
					    'emp_landmark' 				=> $this->input->post('lankmark3'),
					    'emp_state' 				=> $this->input->post('state3'),
					    'emp_city' 					=> $this->input->post('city3'),
					    'emp_pincode' 				=> $this->input->post('pincode3'),
					    'emp_district' 				=> $this->input->post('district3'),
					    'emp_website' 				=> $this->input->post('website'),
					    'emp_employer_type' 		=> $this->input->post('employeeType'),
					    'industry' 					=> $this->input->post('industry'),
					    'sector' 					=> $this->input->post('sector'),
					    'emp_department' 			=> $this->input->post('department'),
					    'emp_designation' 			=> $this->input->post('designation'),
					    'emp_residence_since' 		=> $this->input->post('employedSince'),
					    'emp_status' 				=> "YES",
					];
					$array2 = ['lead_id' => $lead_id];
					$data = array_merge($dataResidence, $array2);

			        $fetch2 = "CE.lead_id";
			        $conditions2 = ['CE.lead_id' => $lead_id];

			    	$employmentDetails = $this->Tasks->select($conditions2, $fetch2, $this->tbl_customer_employment);
			    	$empDetails = $employmentDetails->num_rows();

					if($empDetails == 0){
	        			$result = $this->Tasks->insert($data, 'customer_employment');
					}else{
	        			$result = $this->Tasks->globalUpdate($conditions, $data, $this->tbl_customer_employment);
					}
	        		if($result == true)
	        		{
		        		$json['msg'] = "Employment Details Added Successfully.";
		        	}else{
		        		$json['err'] = "Failed to Updated Employment Details.";
		        	}
	        	}
	            echo json_encode($json);
        	}
        	else
        	{
        		$json['err'] = "Invalid Request";
	            echo json_encode($json);
        	}
		}

		public function saveCustomerPersonalDetails()
		{  
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('borrower_name', 'Borrower Name', 'required|trim');
	        	$this->form_validation->set_rules('gender', 'Gender', 'required|trim');
	        	$this->form_validation->set_rules('dob', 'DOB', 'required|trim');
	        	$this->form_validation->set_rules('pancard', 'PAN', 'required|trim');
	        	$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
	        	$this->form_validation->set_rules('alternate_no', 'Alternate Mobile', 'required|trim');
	        	// $this->form_validation->set_rules('alternateEmail', 'Alternate Email Id', 'required|trim');
	        	$this->form_validation->set_rules('state', 'State', 'required|trim');
	        	$this->form_validation->set_rules('city', 'City', 'required|trim');
	        	$this->form_validation->set_rules('pincode', 'Pincode', 'required|trim');
	        	$this->form_validation->set_rules('aadhar', 'Aadhar', 'required|trim');
	        	$this->form_validation->set_rules('residentialType', 'Residence Type', 'required|trim');
	        	// $this->form_validation->set_rules('residential_proof', 'Residential Proof', 'required|trim');
	        	$this->form_validation->set_rules('residence_address_line1', 'Recidence Address Line 1', 'required|trim');
	        	$this->form_validation->set_rules('residence_address_line2', 'Recidence Address Line 2', 'required|trim');

	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
		            echo json_encode($json);
	        	} else {
					$lead_id = $this->input->post('leadID');
					$company_id = $this->input->post('company_id');
					$product_id = $this->input->post('product_id');
					$user_id = $this->input->post('user_id');
					$borrower_name = $this->input->post('borrower_name');
					$borrower_mname = $this->input->post('borrower_mname');
					$borrower_lname = $this->input->post('borrower_lname');
					$gender = $this->input->post('gender');
					$dob = $this->input->post('dob');
					$pancard = $this->input->post('pancard');
					$mobile = $this->input->post('mobile');
					$alternate_no = $this->input->post('alternate_no');
					$email = $this->input->post('email');
					$state = $this->input->post('state');
					$city = $this->input->post('city');
					$pincode = $this->input->post('pincode');
					$lead_initiated_date = $this->input->post('lead_initiated_date');
					$post_office = $this->input->post('post_office');
					$alternateEmail = $this->input->post('alternateEmail');
					$aadhar = $this->input->post('aadhar');
					$residentialType = $this->input->post('residentialType');
					
					$other_address_proof = $this->input->post('other_add_proof');
					$residential_proof = $this->input->post('residential_proof');
					$residence_address_line1 = $this->input->post('residence_address_line1');
					$residence_address_line2 = $this->input->post('residence_address_line2');
					
					$isPresentAddress = "NO";
					if($this->input->post('isPresentAddress') == "YES"){
						$isPresentAddress = $this->input->post('isPresentAddress');
					}

					$presentAddressType = $this->input->post('presentAddressType');
					$present_address_line1 = $this->input->post('present_address_line1');
					$present_address_line2 = $this->input->post('present_address_line2');
					$employer_business = $this->input->post('employer_business');
					$office_address = $this->input->post('office_address');
					$office_website = $this->input->post('office_website');

				 	$data = [
					    'company_id' 				=> $company_id,
					    'product_id' 				=> $product_id,
					    'lead_id' 					=> $lead_id,
					    'borrower_name' 			=> $borrower_name,
						'middle_name' 				=> $borrower_mname,
						'surname' 					=> $borrower_lname,
					    'gender' 					=> $gender,
					    'dob' 						=> $dob,
					    'pancard' 					=> $pancard,
					    'mobile' 					=> $mobile,
					    'alternate_no' 				=> $alternate_no,
					    'email' 					=> $email,
					    'alternateEmail' 			=> $alternateEmail,
					    'state' 					=> $state,
					    'city' 						=> $city,
					    'pincode' 					=> $pincode,
					    'lead_initiated_date' 		=> $lead_initiated_date,
					    'post_office' 				=> $post_office,
					    'aadhar' 					=> $aadhar,
					    'residentialType' 			=> $residentialType,
						'other_address_proof' 		=> $other_address_proof,
					    'residential_proof' 		=> $residential_proof,
					    'residence_address_line1' 	=> $residence_address_line1,
					    'residence_address_line2' 	=> $residence_address_line2,
					    'isPresentAddress' 			=> $isPresentAddress,
					   // 'presentAddressType' 		=> $presentAddressType,
					    'present_address_line1' 	=> $present_address_line1,
					    'present_address_line2' 	=> $present_address_line2,
					    'employer_business' 		=> $employer_business,
					    'office_address' 			=> $office_address,
					    'office_website' 			=> $office_website,
					];
					
					$status = ['status' => "IN PROCESS"];
					$updateLead = ['status' => "IN PROCESS", 'state_id' =>$state, 'city' =>$city];

				// 	$query1 = $this->db->select('count(customer_id) as total, customer_id')->where('pancard', $pancard)->from('customer')->get()->result();

				// 	if($result1[0]->total > 0) {
				// 	  	$customer_id = $result1[0]->customer_id;
				// 	}
				// 	else
				// 	{
				// 		$last_row = $this->db->select('customer.customer_id')->from('customer')->order_by('customer_id', 'desc')->limit(1)->get()->row();
                        
				// 		$str = preg_replace('/\D/', '', $last_row->customer_id);
				// 		$customer_id= "FTC". str_pad(($str + 1), 6, "0", STR_PAD_LEFT);

				// 		$dataCustomer = array(
				// 			'customer_id'	=> $customer_id,
				// 			'name'			=> $borrower_name,
				// 			'email'			=> $email,
				// 			'alternateEmail'=> $alternateEmail,
				// 			'mobile'		=> $mobile,
				// 			'alternate_no'	=> $alternate_no,
				// 			'pancard'		=> $pancard,
				// 			'aadhar_no'		=> $aadhar,
				// 			'created_date'	=> updated_at
				// 		);
				// 		$this->db->insert('customer', $dataCustomer);
				// 	}
                    
                    $where = ['company_id' => $company_id, 'product_id' => $product_id];
					$sql = $this->db->where($where)->where('lead_id', $lead_id)->from('tbl_cam')->order_by('tbl_cam.cam_id', 'desc')->get();
					
					$row = $sql->row();
				// 	echo "<pre>"; print_r($sql->num_rows()); exit;
        			if($sql->num_rows() > 0)
        			{
						$insertDate = [
    					    'usr_updated_by' 			=> $user_id,
    					    'usr_updated_at' 			=> created_at,
						];
						$data = array_merge($insertDate, $data);
						$cam_id = $row->cam_id;
						$result = $this->db->where('cam_id', $cam_id)->update('tbl_cam', $data);
						$updateleads = $this->db->where($where)->where('lead_id', $lead_id)->update('leads',["state_id" =>$state, "city" =>$city]);

						$this->CAM->updateCAM($lead_id, $status);
					} else {
						$insertDate = [
							'lead_id' 					=> $lead_id,
				 			// 'customer_id' 				=> $customer_id,
						    'usr_created_by' 			=> user_id,
						    'usr_created_at' 			=> created_at,
						];
						$data = array_merge($insertDate, $data);
						$result = $this->db->insert('tbl_cam', $data);
						$cam_id = $this->db->insert_id();

						$this->Tasks->updateLeads($lead_id, $updateLead);
						$this->CAM->updateCAM($lead_id, $status);
					}

					if($result == 1){
						$json['msg'] = "Personal Details Updated Successfully.";
						echo json_encode($json);
					}else{
						$json['err'] = "Personal Details failed to Update.";
						echo json_encode($json);
					}
				}
			}
		}

		public function LACLeadRecommendation()
		{
			if ($this->input->server('REQUEST_METHOD') == 'POST')
		    {
		    	$this->form_validation->set_rules('Active_CC', 'Active CC', 'required|trim');
	        	$this->form_validation->set_rules('cc_statementDate', 'CC Statement Date', 'required|trim');
	        	$this->form_validation->set_rules('cc_paymentDueDate', 'CC Payment Date', 'required|trim');
	        	$this->form_validation->set_rules('cc_paymentDueDate', 'CC Payment Date', 'required|trim');
	        	$this->form_validation->set_rules('customer_bank_name', 'CC Bank', 'required|trim');
	        	$this->form_validation->set_rules('account_type', 'CC Type', 'required|trim');
	        	$this->form_validation->set_rules('customer_account_no', 'CC No', 'required|trim');
	        	$this->form_validation->set_rules('customer_confirm_account_no', 'CC Confirm No', 'required|trim');
	        	$this->form_validation->set_rules('customer_name', 'CC User Name', 'required|trim');
	        	$this->form_validation->set_rules('cc_limit', 'CC Limit', 'required|trim');
	        	$this->form_validation->set_rules('cc_outstanding', 'CC Outstanding', 'required|trim');
	        	$this->form_validation->set_rules('cc_name_Match_borrower_name', 'CC Name Match Borrower Name', 'required|trim');
	        	$this->form_validation->set_rules('emiOnCard', 'EMI On Card', 'required|trim');
	        	$this->form_validation->set_rules('DPD30Plus', '30+ DPD In Last 3 Month', 'required|trim');
	        	$this->form_validation->set_rules('cc_statementAddress', 'CC Statement Address', 'required|trim');
	        	$this->form_validation->set_rules('last3monthDPD', 'Last 3 Month DPD', 'required|trim');
	        	$this->form_validation->set_rules('loan_recomended', 'Loan Recomended', 'required|trim');
	        	$this->form_validation->set_rules('processing_fee', 'Admin Fee', 'required|trim');
	        	$this->form_validation->set_rules('roi', 'ROI', 'required|trim');
	        	$this->form_validation->set_rules('disbursal_date', 'Disbursal Date', 'required|trim');
	        	$this->form_validation->set_rules('repayment_date', 'Repayment Date', 'required|trim');

				if($this->input->post('isDisburseBankAC') == "YES"){
	        		$this->form_validation->set_rules('bankIFSC_Code', 'Bank IFSC Code', 'required|trim');
	        		$this->form_validation->set_rules('bank_name', 'Bank Name', 'required|trim');
	        		$this->form_validation->set_rules('bank_branch', 'Bank Branch', 'required|trim');
	        		$this->form_validation->set_rules('bankA_C_No', 'Bank A/C No', 'required|trim');
	        		$this->form_validation->set_rules('confBankA_C_No', 'Conf Bank A/C No', 'required|trim');
	        		$this->form_validation->set_rules('bankHolder_name', 'Bank Holder Name', 'required|trim');
	        		$this->form_validation->set_rules('bank_account_type', 'Bank A/C Type', 'required|trim');
				}

	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
		            echo json_encode($json);
	        	} else {
	        		$lead_id = $this->input->post('leadID');
					$statusCam = ['status' => "RECOMMEND"];
					$statusLeads = ['status' => "RECOMMEND", "screener_status" => 4];
					$this->Tasks->updateLeads($lead_id, $statusLeads);
					$this->CAM->updateCAM($lead_id, $statusCam);
	        		$json['msg'] = "Lead Recomendation Done.";
		            echo json_encode($json);
	        	}
	        }
		}

		public function PaydayLeadRecommendation()
		{
			if($this->input->post('user_id') == ""){
				$json['errSession'] = 'Session Expired.';
				echo json_encode($json);
			}
			if ($this->input->server('REQUEST_METHOD') == 'POST')
		    {
	        	$this->form_validation->set_rules('lead_id', 'Lead ID', 'required|trim');
	        	$this->form_validation->set_rules('customer_id', 'Company ID', 'required|trim');
	        	$this->form_validation->set_rules('user_id', 'User ID', 'required|trim');
	        	$this->form_validation->set_rules('loan_recommended', 'Loan Recommended', 'required|trim');
	        	$this->form_validation->set_rules('admin_fee', 'Admin Fee', 'required|trim');
	        	$this->form_validation->set_rules('roi', 'ROI', 'required|trim');
	        	$this->form_validation->set_rules('disbursal_date', 'Disbursal Date', 'required|trim');
	        	$this->form_validation->set_rules('repayment_date', 'Repayment Date', 'required|trim');
	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
		            echo json_encode($json);
	        	} else {
	        		$lead_id = $this->input->post('lead_id');
			        $conditions = ['company_id' => company_id, 'product_id' => product_id, 'lead_id' => $lead_id];
			        $fetch = 'CAM.cam_id, CAM.remark';
			        $sql = $this->Tasks->select($conditions, $fetch, $this->tbl_cam);
				
					if($sql->num_rows() > 0)
					{
						$status = "APPLICATION-RECOMMENDED";
						$stage = "S10";
						$camDetails = $sql->row();
						$data = ['status' => $status, "stage" => $stage];
						$data2 = [
							'lead_id' 		=> $lead_id,
							'customer_id' 	=> $this->input->post('customer_id'),
							'user_id' 		=> $this->input->post('user_id'),
							'status' 		=> $status, 
							"stage" 		=> $stage, 
							'remarks' 		=> $camDetails->remark,
							'created_on'	=> timestamp
						];
						$this->Tasks->updateLeads($conditions, $data, 'leads');
		            	$this->Tasks->insert($data2, 'lead_followup');
		        		$json['msg'] = "Lead Recomendation Done.";
			            echo json_encode($json);
					}else{
						$json['err'] = 'Failed to recommend Leads.';
						echo json_encode($json);
					}
	        	}
	        }
		}

		public function validateCustomerPersonalDetails()
		{
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('employeeType', 'Employee Type', 'required|trim');
	        	$this->form_validation->set_rules('dateOfJoining', 'Date Of Joining', 'required|trim');
	        	$this->form_validation->set_rules('designation', 'Designation', 'required|trim');
	        	$this->form_validation->set_rules('currentEmployer', 'Current Employer', 'required|trim');
	        	$this->form_validation->set_rules('companyAddress', 'Company Address', 'required|trim');
	        	$this->form_validation->set_rules('otherDetails', 'Other Details', 'required|trim');

	        	if($this->form_validation->run() == FALSE) {
	        		$json['error'] = validation_errors();
		            echo json_encode($json);
	        	} else {
		            $data = array (
						'lead_id'		 	 => $lead_id,
						'employeeType'		 => $this->input->post('employeeType'),
						'dateOfJoining'		 => $this->input->post('dateOfJoining'),
						'designation'		 => $this->input->post('designation'),
						'currentEmployer'	 => $this->input->post('currentEmployer'),
						'companyAddress'	 => $this->input->post('companyAddress'),
						'otherDetails'		 => $this->input->post('otherDetails'),
						'updated_by'		 => $_SESSION['isUserSession']['user_id'],
		            );
		            $result = $this->db->insert('tbl_customerEmployeeDetails', $data);
		            $this->db->where('lead_id', $lead_id)->update('leads', ['employeeDetailsAdded' => 1]);
		            echo json_encode($result);
		        }
	        }
		}

        //************** function for genereate the application number on behalf of user id ***************//
		function applicationNo()
		{
			$lead_id='5358';
			$totalLeadsCount = $this->Tasks->gettotalleadsCount('leads'); 
			$data = $this->Tasks->generateApplicationNo($lead_id); 
			$str=str_pad($totalLeadsCount, 9, '0', STR_PAD_LEFT);
			echo $applicationNo='AP'.$data[0]['product_code'].$data[0]['city_code'].$str; echo "</br>";

			echo $getBorrowerType = $this->Tasks->getBorrowerType('leads',$data[0]['pancard']); 


		}

		// function to export the XLX data into the database //

		

		
					
}

?>