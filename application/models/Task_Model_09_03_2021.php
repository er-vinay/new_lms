<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
    class Task_Model extends CI_Model{
    	function __construct()  
		{
			parent::__construct();
	        define("ip", $this->input->ip_address());
	    	date_default_timezone_set('Asia/Kolkata');
	        define("todayDate", date('Y-m-d'));
	        define("tableLeads", "leads");
	        define("currentDate", date('Y-m-d'));
	        define("created_at", date('Y-m-d H:i:s'));
	        define("updated_at", date('Y-m-d H:i:s'));
	        define("server", $_SERVER['SERVER_NAME']);
	        define("localhost", "public/images/");
	        define("live", base_url()."upload/");
		}

		public function import_lead_data($data) 
		{
		    return $this->db->insert('leads', $data);
		}

		public function selectLeads($lead_id, $fetch)
		{
			return $this->db->select($fetch)->where('LD.lead_id', $lead_id)->from('leads as LD')->get();
		}

		public function updateLeads($lead_id, $data)
		{
			return $this->db->where('leads.lead_id', $lead_id)->update('leads', $data);
		}

		public function getLeadDetails()
	    {
	    	$where = '(leads.status="New Leads" or leads.status = "Docs Received")';
            $this->db->select('leads.lead_id,leads.application_no, leads.name, leads.middle_name, leads.sur_name, leads.email, leads.mobile, leads.pancard, tb_states.state, leads.city, leads.created_on, leads.source, leads.status, leads.userChecked, leads.partPayment')
				// ->where('date(leads.created_on) BETWEEN "'. date('Y-m-d', strtotime("2020-12-25")). '" and "'. date('Y-m-d', strtotime(todayDate)).'"')
                ->where('leads.utm_source', "LoanAgainstCard")
                ->where($where)
                ->from('leads')
                ->join('tb_states', 'leads.state_id = tb_states.id');
            return $this->db->order_by('leads.lead_id', 'desc')->get();
	    }

		public function inProcess()
	    {
            $this->db->select('leads.lead_id,leads.application_no, leads.name, leads.middle_name, leads.sur_name, leads.email, leads.mobile, leads.pancard, tb_states.state, leads.city, leads.created_on, leads.source, leads.status, leads.userChecked, leads.partPayment')
                ->where('leads.utm_source', "LoanAgainstCard")
                ->where('leads.status', "IN PROCESS")
                ->from('leads')
                ->join('tb_states', 'leads.state_id = tb_states.id');
            return $this->db->order_by('leads.lead_id', 'desc')->get();
	    }

		public function recommend()
	    {
            $this->db->select('leads.lead_id,leads.application_no, leads.name, leads.middle_name, leads.sur_name, leads.email, leads.mobile, leads.pancard, tb_states.state, leads.city, leads.created_on, leads.source, leads.status, leads.userChecked, leads.partPayment')
                ->where('leads.utm_source', "LoanAgainstCard")
                ->where('leads.status', "RECOMMEND")
                ->from('leads')
                ->join('tb_states', 'leads.state_id = tb_states.id');
            return $this->db->order_by('leads.lead_id', 'desc')->get();
	    }

		public function leadSendBack()
	    {
            $this->db->select('leads.lead_id,leads.application_no, leads.name, leads.middle_name, leads.sur_name, leads.email, leads.mobile, leads.pancard, tb_states.state, leads.city, leads.created_on, leads.source, leads.status, leads.userChecked, leads.partPayment')
                ->where('leads.utm_source', "LoanAgainstCard")
                ->where('leads.status', "SEND BACK")
                ->from('leads')
                ->join('tb_states', 'leads.state_id = tb_states.id');
            return $this->db->order_by('leads.lead_id', 'desc')->get();
	    }

		public function leadSanctioned()
	    {
            $this->db->select('leads.lead_id,leads.application_no, leads.name, leads.middle_name, leads.sur_name, leads.email, leads.mobile, leads.pancard, tb_states.state, leads.city, leads.created_on, leads.source, leads.status, leads.userChecked, leads.partPayment')
                ->where('leads.utm_source', "LoanAgainstCard")
                ->where('leads.status', "SANCTION")
                ->from('leads')
                ->join('tb_states', 'leads.state_id = tb_states.id');
            return $this->db->order_by('leads.lead_id', 'desc')->get();
	    }

		public function leadDisbursed()
	    {
            $this->db->select('leads.lead_id,leads.application_no, leads.name, leads.middle_name, leads.sur_name, leads.email, leads.mobile, leads.pancard, tb_states.state, leads.city, leads.created_on, leads.source, leads.status, leads.userChecked, leads.partPayment')
                ->where('leads.utm_source', "LoanAgainstCard")
                ->where('leads.status', "DISBURSED")
                ->from('leads')
                ->join('tb_states', 'leads.state_id = tb_states.id');
            return $this->db->order_by('leads.lead_id', 'desc')->get();
	    }
		
		public function index()  
		{
            $this->db->select('leads.lead_id, leads.name, leads.email, tb_states.state, leads.created_on, leads.source, leads.status')
                ->where('date(leads.created_on)', todayDate)
		        ->where('leads.loan_approved', 1)
                ->from(tableLeads)
                ->join('tb_states', 'leads.state_id = tb_states.id');
            return $query = $this->db->order_by('leads.lead_id', 'desc')->get();
		}

	    public function selectQuery($fetch, $where, $table)
	    {
            return $this->db->select($fetch)->where($where)->get($table);
	    }

		public function updateQuery($where, $table, $update)
		{
            $this->db->where($where)->update($table, $update);
		}
		
		public function joinTwoTable($fetch, $where, $table, $joinTableTwo, $joinEqualTo)
		{
    		return $this->db->select($fetch)->where($where)->from($table)->join($joinTableTwo, $joinEqualTo)->get();
		}

	    public function getMISData()
	    {
	    	if(!empty($_SESSION['isUserSession']['user_id']))
	    	{
	    		$data = $this->db->distinct()->select('recovery.*, recovery.payment_amount as total_paid, leads.name, leads.email, tb_states.state, leads.source, leads.status, loan.loan_no, users.name as recovery_by')
	    			->where('DATE(recovery.created_on)', currentDate)
	    			->where('recovery.PaymentVerify', 0)
	    			->from('recovery')
	    			->join('leads', 'leads.lead_id = recovery.lead_id')
	    			->join('credit', 'credit.lead_id = recovery.lead_id')
	    			->join('loan', 'loan.lead_id = recovery.lead_id')
            		->join('tb_states', 'leads.state_id = tb_states.id')
            		->join('users', 'users.user_id = recovery.recovery_by')
            // 		->group_by('recovery.lead_id')
	    			->get();
    			return $data;
	    	}
	    }

	    public function getRecoveryData($lead_id)
	    {
	    	if(!empty($_SESSION['isUserSession']['user_id']))
	    	{
	    		$sql = $this->db->select('R.recovery_id, R.loan_no, R.payment_mode, R.discount, R.date_of_recived, R.payment_amount, R.refrence_no, R.created_on, R.status, R.recovery_by, R.PaymentVerify, users.name as recovery_by, R.docs')
	    			->where('R.lead_id', $lead_id)
	    			->from('recovery R')
            		->join('users', 'users.user_id = R.recovery_by')
            		->order_by('R.recovery_id', 'desc')
            		->get();
    			$query = $sql->result();

    			$data = '
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" style="border: 1px solid #dde2eb">
                            <thead>
                                <tr>
                                    <th><b>#</b></th>
                                    <th><b>Loan No</b></th>
                                    <th><b>Payment Mode</b></th>
                                    <th><b>Payment Amount</b></th>
                                    <th><b>Discount</b></th>
                                    <th><b>Refrence No</b></th>
                                    <th><b>Recovery Date</b></th>
                                    <th><b>Loan Status</b></th>
                                    <th><b>Payment Verification</b></th>
                                    <th><b>Proceed by</b></th>
                                    <th><b>Date</b></th>
                                    <th><b>Action</b></th>
                                </tr>
                            </thead>
                    	<tbody>';
	    		if($query > 0)
	    		{
	    			foreach($query as $row) 
	    			{
    			        $PaymentVerify = "Pending";
    			        $editBtn = '<a onclick="VerifyCoustomerPayment('.$row->recovery_id.', '.$row->payment_amount.', this.title)" title="'. $row->refrence_no .'"><i class="fa fa-pencil" style="padding : 3px; border : 1px solid purple;"></i></a>';
	    			    
	    			    if($row->PaymentVerify > 0){
	    			        $PaymentVerify = "Verified";
	    			        $editBtn = "";
                        }
	    				$data .= '
                            <tr>
                                <td>'. $row->recovery_id .'</td>
                                <td>'. $row->loan_no .'</td>
                                <td>'. $row->payment_mode .'</td>
                                <td>'. $row->payment_amount .'</td>
                                <td>'. $row->discount .'</td>
                                <td>'. $row->refrence_no .'</td>
                                <td>'. $row->date_of_recived.'</td>
                                <td>'. $row->status .'</td>
                                <td>'. $PaymentVerify.'</td>
                                <td>'. $row->recovery_by .'</td>
                                <td>'. $row->created_on .'</td>
                                <td>
			                        <a onclick="viewCustomerPaidSlip(this.title)" title="'. $row->recovery_id .'"><i class="fa fa-eye" style="padding : 3px; color : #35b7c4; border : 1px solid #35b7c4;"></i></a>
                                    '. $editBtn .'
                                </td>
                            </tr>
	    				';
	    			}
				    $data .='</tbody></table></div>';
				}else
				{
				    $data .='<tbody><tr><td colspan="40" style="text-align: -webkit-center;color:red;">Record Not Found...</td></tr></tbody></table></div>';
				}
		        return $data;
	    	}
	    }

		public function duplicateTask()  
		{
            $this->db->select('leads.lead_id, leads.name, leads.email, tb_states.state, leads.created_on, leads.source, leads.status')
                // ->where('date(leads.created_on)', todayDate)
                ->where('leads.leads_duplicate', 1)
                ->from(tableLeads)
                ->join('tb_states', 'leads.state_id = tb_states.id');
            return $query = $this->db->order_by('leads.lead_id', 'desc')->get();
		}

		public function duplicateTaskList($lead_id)  
		{
            $this->db->select('tbl_duplicate_leads.duplicate_lead_id, users.name, tbl_duplicate_leads.reson, tbl_duplicate_leads.created_on')
	            ->where('tbl_duplicate_leads.lead_id', $lead_id)
                ->from('tbl_duplicate_leads')
                ->join('users', 'users.user_id = tbl_duplicate_leads.user_id');
            $duplicateTaskDetails = $this->db->order_by('tbl_duplicate_leads.duplicate_lead_id', 'desc')->get()->result();

            $data = '<div class="table-responsive">
		        <table class="table table-hover table-striped">
                  <thead>
                    <tr class="table-primary">
                      <th scope="col">#</th>
                      <th scope="col">Duplicate Lead ID</th>
                      <th scope="col">Duplicate Marked By</th>
                      <th scope="col">Reson</th>
                      <th scope="col">Initiated On</th>
                    </tr>
                </thead>';
          	$i = 1;
			if($duplicateTaskDetails > 0)
			{
				foreach($duplicateTaskDetails as $column)
				{
				    $data.='<tbody>
                		<tr>
							<td>'.$i++.'</th>
							<td>'.$column->duplicate_lead_id.'</td>
							<td>'.$column->name.'</td>
							<td>'.$column->reson.'</td>
							<td>'.$column->created_on.'</td>
						</tr>';
				}
				
				$data .='</tbody></table></div>';
			}
			else
			{
			    $data .='<tbody><tr><td colspan="7" style="text-align: -webkit-center;color:red;">Record Not Found...</td></tr></tbody></table></div>';
			}
	        return $data;
		}

		public function rejectedTask()  
		{
            $this->db->select('leads.lead_id,leads.application_no, leads.name, leads.middle_name, leads.sur_name, leads.email, leads.mobile, leads.pancard, tb_states.state, leads.city, leads.created_on, leads.source, leads.status, leads.userChecked, leads.partPayment')
                // ->where('leads.lead_rejected', 1)
                ->where('leads.status', "REJECT")
                ->from(tableLeads)
                ->join('tb_states', 'leads.state_id = tb_states.id');
            return $query = $this->db->order_by('leads.lead_id', 'desc')->get();
		}

		public function rejectedLeadDetails($lead_id)  
		{
            $this->db->select('tbl_rejected_loan.rejected_lead_id, users.name, tbl_rejected_loan.reson, tbl_rejected_loan.created_on')
	            ->where('tbl_rejected_loan.lead_id', $lead_id)
                ->from('tbl_rejected_loan')
                ->join('users', 'users.user_id = tbl_rejected_loan.user_id');
            $rejectedTaskDetails = $this->db->order_by('tbl_rejected_loan.rejected_lead_id', 'desc')->get()->result();

            $data = '<div class="table-responsive">
		        <table class="table table-hover table-striped">
                  <thead>
                    <tr class="table-primary">
                      <th scope="col">#</th>
                      <th scope="col">Rejected Lead ID</th>
                      <th scope="col">Rejected By</th>
                      <th scope="col">Reson</th>
                      <th scope="col">Initiated On</th>
                    </tr>
                </thead>';
          	$i = 1;
			if($rejectedTaskDetails > 0)
			{
				foreach($rejectedTaskDetails as $column)
				{
				    $data.='<tbody>
                		<tr>
							<td>'.$i++.'</th>
							<td>'.$column->rejected_lead_id.'</td>
							<td>'.$column->name.'</td>
							<td>'.$column->reson.'</td>
							<td>'.$column->created_on.'</td>
						</tr>';
				}
				
				$data .='</tbody></table></div>';
			}
			else
			{
			    $data .='<tbody><tr><td colspan="7" style="text-align: -webkit-center;color:red;">Record Not Found...</td></tr></tbody></table></div>';
			}
	        return $data;
		}

		public function getBranch()
		{
			// $result1 = $this->db->select('branch.code, branch.branch, branch.state')->get("branch")->result();
			$query1 = $this->db->query("SELECT B.branch_id,B.branch,B.code,B.status,S.state,B.created_on FROM branch B INNER JOIN states S ON B.state=S.id  AND B.status='1' ORDER BY B.branch_id ASC");
	        $result1 = $query1->result();
	        return $result1;
		}

		public function get_credits($lead_id)
		{ 
			$select_column = array("credit.credit_id", "credit.loan_amount_approved", "credit.obligations", "credit.cibil", "credit.status", "credit.remark", "credit.sms", "users.name", "credit.created_on");  
			$order_column  = array("credit.credit_id", "credit.loan_amount_approved", "credit.obligations", "credit.cibil", "credit.status", "credit.remark", "credit.sms", "users.name", "credit.created_on");
			$this->db->select($select_column);  
			$this->db->from('credit');  

			$this->db->join('users', 'users.user_id = credit.approved_by AND credit.lead_id='.$lead_id);
			if(isset($_GET["search"]["value"]))  
			{  
			    $this->db->like("credit.credit_id", $_GET["search"]["value"]);
			    $this->db->or_like("credit.loan_amount_approved", $_GET["search"]["value"]);  
			    $this->db->or_like("credit.obligations", $_GET["search"]["value"]);
			    $this->db->or_like("credit.cibil", $_GET["search"]["value"]);
			    $this->db->or_like("credit.status", $_GET["search"]["value"]);
			    $this->db->or_like("credit.remark", $_GET["search"]["value"]);
			    $this->db->or_like("credit.sms", $_GET["search"]["value"]);
			    $this->db->or_like("users.name", $_GET["search"]["value"]);
			    $this->db->or_like("credit.created_on", $_GET["search"]["value"]);
			}
			if(isset($_POST["order"])) 
			{  
			    $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
			}  
			else  
			{  
			    $this->db->order_by('credit.credit_id', 'DESC');  
			}
		}

		public function get_credit($lead_id)
		{
			$OldDatabase = $this->load->database('OldDatabase', true);
			$creditArray = $this->db->where('lead_id', $lead_id)->get('leads')->row();
			
			$data = '<div class="table-responsive">
		        <table class="table table-hover table-striped table-bordered">
                  <thead>
                    <tr class="table-primary">
						<th scope="col">Credit ID</th>
						<th scope="col">CIF No.</th>
						<th scope="col">Name</th>
						<th scope="col">Father Name</th>
						<th scope="col">Email</th>
						<th scope="col">Mobile</th>
						<th scope="col">Alternate Mobile</th>
						<th scope="col">Pancard</th>
						<th scope="col">DOB</th>
						<th scope="col">Salary</th>
						<th scope="col">Salary Date</th>
						<th scope="col">Residential</th>
						<th scope="col">Residential Proof</th>
						<th scope="col">Residential No</th>
						<th scope="col">Marital Status</th>
						<th scope="col">Loan Amount Approved</th>
						<th scope="col">Cibil</th>
						<th scope="col">Repayment Amount</th>
						<th scope="col">Repayment Date</th>
						<th scope="col">Agreement Date</th>
						<th scope="col">Processing Fee</th>
						<th scope="col">ROI</th>
						<th scope="col">Tenure</th>
						<th scope="col">Status</th>
						<th scope="col">Branch</th>
						<th scope="col">Special Approval</th>
						<th scope="col">CRM Approval</th>
						<th scope="col">Recovery Approval</th>
						<th scope="col">Noofdisbursal</th>
						<th scope="col">Obligations</th>
						<th scope="col">Remark</th>
                    </tr>
                </thead>
                <tbody>';
				$i = 1;
			    $pancard = $creditArray->pancard;
			    $creditAlreadyExists = $this->db->where('pancard', $pancard)->from('credit')->order_by('credit.credit_id', 'desc')->get();
			    // $creditAlreadyExists = $this->db->where('lead_id', $lead_id)->from('credit')->get();

			    $creditHistory = $creditAlreadyExists->result();
				if($creditHistory > 0)
				{
				// if(!is_array($creditAlreadyExists->result_array())) {
				// }else{
					// $OldDatabase = $this->load->database('OldDatabase', true);
					// $creditHistory = $OldDatabase->where('pancard', $pancard)->get('credit')->result();
				// }

	          	foreach($creditHistory as $row)
	          	{
				    $data .= '
	            		<tr style="height : 50px;">
							<td>'.$row->credit_id.'</td>
							<td>'.$row->customer_id.'</td>
							<td>'.$row->name.'</td>
							<td>'.$row->father_name.'</td>
							<td>'.$row->email.'</td>
							<td>'.$row->mobile.'</td>
							<td>'.$row->alternate_no.'</td>
							<td>'.$row->pancard.'</td>
							<td>'.$row->dob.'</td>
							<td>'.$row->salary.'</td>
							<td>'.$row->salary_date.'</td>
							<td>'.$row->residential.'</td>
							<td>'.$row->residential_proof.'</td>
							<td>'.$row->residential_no.'</td>
							<td>'.$row->marital_status.'</td>
							<td>'.$row->loan_amount_approved.'</td>
							<td>'.$row->cibil.'</td>
							<td>'.$row->repay_amount.'</td>
							<td>'.$row->repayment_date.'</td>
							<td>'.$row->created_on.'</td>
							<td>'.$row->processing_fee.'</td>
							<td>'.$row->roi.'</td>
							<td>'.$row->tenure.'</td>
							<td>'.$row->status.'</td>
							<td>'.$row->branch.'</td>
							<td>'.$row->special_approval.'</td>
							<td>'.$row->crm_approval.'</td>
							<td>'.$row->recovery_approval.'</td>
							<td>'.$row->noofdisbursal.'</td>
							<td>'.$row->obligations.'</td>
							<td>'.$row->remark.'</td>
						</tr>';
			    }
				$data .='</tbody></table></div>';
			}
			else
			{
			    $data .='<tbody><tr><td colspan="40" style="text-align: -webkit-center;color:red;">Record Not Found...</td></tr></tbody></table></div>';
			}
	        return $data;
		}

		public function get_filtered_credit(){  
			$this->get_credits($lead_id);
			$query = $this->db->get();  
			return $query->num_rows();  
		}

		public function get_all_credit()
		{  
			$this->db->select('*');  
			$this->db->from("credit");
			$lead_id = $this->uri->segment(3);
			$this->db->where('lead_id',$lead_id);
			return $this->db->count_all_results();  
		}
		
		public function getCollection($lead_id)
		{
			$loan_status = '';
			$this->db->select('loan.loan_id, loan.branch, loan.lead_id, loan.loan_no, loan.lan, loan.loan_amount, loan.loan_tenure, 
			    loan.loan_intrest, loan.loan_repay_amount, loan.loan_repay_date, loan.loan_disburse_refrence_no, loan.loan_disburse_date, 
			    loan.customer_name, loan.customer_account_no, loan.customer_bank_ifsc, loan.customer_bank, loan.customer_bank_branch, 
			    loan.customer_cheque_details, loan.loan_pd_date, loan.loan_care_by, loan.loan_admin_fee, loan.loan_admin_fee_collect, 
			    loan.loan_fee_ref, loan.remarks, loan.loan_status, loan.ip, loan.sms, loan.created_on, credit.loan_amount_approved');
	        $this->db->where('loan.lead_id', $lead_id);
	        $this->db->from('loan');
	        $this->db->join('credit', 'credit.lead_id = loan.lead_id');
	       // $this->db->join('users', 'loan.created_by = users.user_id');
	        $disbursed_details = $this->db->get()->result();
	        
	        foreach($disbursed_details as $disbursed_detail)
	        {
    	        $recovery = $this->db->select('r.status, r.date_of_recived')
    	        	->where('r.lead_id', $lead_id)
    	        	->from('recovery as r')
        	        ->order_by('r.recovery_id', 'desc')
    	        	->get()
    	        	->row();
    	        $recoveryStatus = $recovery->status;
    	        $dateOfRecived = $recovery->date_of_recived;
    	        
    	        	
	        	$branch = $disbursed_detail->branch;
	        	$loan_no = $disbursed_detail->loan_no;
	        	$loan_amount = $disbursed_detail->loan_amount;
	        	$loan_amount_approved = $disbursed_detail->loan_amount_approved;
	        	$loan_intrest = $disbursed_detail->loan_intrest;
	        	$loan_disburse_date = $disbursed_detail->loan_disburse_date;
	        	$loan_repay_date = $disbursed_detail->loan_repay_date;
	        	$tenuredays = $disbursed_detail->loan_tenure;
	        	$loanrepayamy = $disbursed_detail->loan_repay_amount;

	        	$disburseddate = date('Y-m-d', strtotime($disbursed_detail->loan_disburse_date ));
	            $repaymentdate = date('Y-m-d', strtotime($disbursed_detail->loan_repay_date ));
	            $now = date('Y-m-d');
	            $date1 = strtotime($now);
	            $date2 = strtotime($disburseddate);
	            $date3 = strtotime($repaymentdate);
		        $diff = $date1 - $date2;

	            $tenure = ($diff / 60/60/24);
	            $rtenure = '';
	            $ptenure = '';

	            if($date1 <= $date3) {
					$realdays = $date1 - $date2;
					$rtenure=($realdays / 60/60/24);
				} else {
				  	$realdays = $date3 - $date2;
				  	$rtenure = ($realdays / 60/60/24);
				}

				if($date1 <= $date3) {
				  	$realdays = $date1 - $date2;
				 	$ptenure = 0;
				} else {
					$realdays = $date3 - $date2;
					$rtenure = ($realdays / 60/60/24);
					$paneldays = $date1 - $date3;
					$ptenure = ($paneldays / 60/60/24);
				}
				
				
				$realIntrest = ($loan_amount_approved * $loan_intrest * $rtenure) / 100;
				$penaltyIntrest = ($loan_amount_approved * ($loan_intrest * 2) * $ptenure)/100;
				$bcharge = 0;
	            if($recoveryStatus == "Full Payment"){
    	            $ptenure = 0;
    	            $realIntrest = ($loan_amount_approved * $loan_intrest * $rtenure) / 100;
    	        }
				
				$repaymentAmt = ($loan_amount_approved + $realIntrest + $penaltyIntrest);
				
				$recoveredAmount = $this->db->select('SUM(recovery.payment_amount) as total_paid')->where('loan_no', $loan_no)->from('recovery')->get()->row();
				
                $ReceivedAmount = 0;
                if($recoveredAmount->total_paid > 0){
				    $ReceivedAmount = $recoveredAmount->total_paid;
                }
                
	        	return $loan_status = '
	        		<div class="table-responsive">
	        			<table class="table table-hover table-striped">  
	                 	<tbody>
	                        <tr>
	                         	<th>Loan No</th> 
	                         	<td>'.$loan_no .'</td> 
	                         	<th>Branch </th>  
	                         	<td>'.$branch .'</td> 
	                       	</tr>
	                        <tr>
	                         	<th>Loan Disburse Date</th>
	                         	<td>'. $loan_disburse_date .'</td>
	                         	<th>Loan Amount</th>
	                         	<td>Rs. '.number_format($loan_amount_approved, 2) .'</td>
	                       	</tr>
	                       	<tr>
	                         	<th>Loan Repay Date</th>
	                         	<td>'. $loan_repay_date .'</td>
	                         	<th>ROI</th>
	                         	<td>'.$loan_intrest .'% </td>
	                       	</tr>
	                        <tr>
	                         	<th colspan="2"></th>
	                           	<th>Tenure</th>
	                           	<td>'.$tenuredays.' Days</td>
                           	</tr>
                           	<tr>
	                         	<th colspan="2"></th>
	                         	<th>Real Interest</th>
	                         	<td>Rs. '.number_format($realIntrest, 2).'</td>
	                       	</tr>
	                       	<tr style="color : blue;">  
	                         	<th colspan="2"></th>
	                           	<th>Loan Repay Amount</th> 
	                           	<td>Rs. '.number_format($loanrepayamy, 2).'</td> 
	                       	</tr>
                           	<tr>
	                         	<th colspan="2"></th>
	                        	<th>Penality Late/ days</th>
	                        	<td>'.$ptenure.' Days</td>
	                       	</tr>
	                       	<tr>
	                         	<th colspan="2"></th>
	                         	<th>Penality Late/ Interest</th>
	                         	<td>Rs. '.number_format($penaltyIntrest, 2).'</td>
	                       	</tr>
	                       	<tr style="color : red;font-size: 16px;">  
	                         	<th colspan="2"></th>
	                           	<th>Total Payable</th> 
	                           	<td>Rs. <span id="totalPayableAmount">'.number_format($repaymentAmt, 2).'</span></td> 
	                       	</tr>
	                       	<tr style="color : green;font-size: 16px;">  
	                         	<th colspan="2"></th>
	                           	<th>Total Received Amount</th> 
	                           	<td>Rs. <span id="totalReceived">'.number_format($ReceivedAmount, 2).'</span></td> 
	                       	</tr>
	               		</tbody>
	              	</table>
	             </div>
	        	';
	        }
		}
		public function ShowCustomerEmploymentDetails($lead_id)
		{
			$CustomerEmployeeDetails = $this->db->select('tbl_customerEmployeeDetails.*')->where('lead_id', $lead_id)->from('tbl_customerEmployeeDetails')->order_by('tbl_customerEmployeeDetails.employee_id', 'desc')->get()->result(); 

			$data = '<div class="table-responsive">
		        <table class="table table-hover table-striped">
                  <thead>
                    <tr class="table-primary">
                      <th scope="col">#</th>
                      <th scope="col">Employee Type</th>
                      <th scope="col">Date Of Joining</th>
                      <th scope="col">Designation</th>
                      <th scope="col">Current Employer</th>
                      <th scope="col">Company Address</th>
                      <th scope="col">Other Details</th>
                    </tr>
                </thead>';
          	$i = 1;
			if($CustomerEmployeeDetails)
			{
				foreach($CustomerEmployeeDetails as $column)
				{
				    $data.='<tbody>
                		<tr>
							<td>'.$i++.'</th>
							<td>'.$column->employeeType.'</td>
							<td>'.$column->dateOfJoining.'</td>
							<td>'.$column->designation.'</td>
							<td>'.$column->currentEmployer.'</td>
							<td>'.$column->companyAddress.'</td>
							<td>'.$column->otherDetails.'</td>
						</tr>';
				}
				$data .='</tbody></table></div>';
			}
			else
			{
		    	$data .='<tbody><tr><td colspan="7" style="text-align: -webkit-center;color:red;">Record Not Found...</td></tr></tbody></table></div>';
			}
			return $data;
		}

		public function getCrmApporal()
		{
			return $this->db->select('users.user_id, users.name')->where('crm_Approval', 1)->from('users')->get()->result();
		}

		public function bank_analiysis($lead_id)
		{
	        // return $this->db->select('tbl_cart.docId')->where('lead_id', $lead_id)->order_by('tbl_cart.docId', 'desc')->get('tbl_cart');
	        
	        $result = $this->db->select('tbl_cart.*')->where('lead_id', $lead_id)->order_by('tbl_cart.cart_id', 'desc')->get('tbl_cart');
        	$data = '<div class="table-responsive">
		        <table class="table table-hover table-striped">
                  <thead>
                    <tr class="table-primary">
                      <th scope="col">Sr.</th>
                      <th scope="col">Doc ID</th>
                      <th scope="col">Initiated On</th>
                      <th scope="col">Action</th>
                    </tr>
                </thead>';
          	if($result->num_rows() > 0)
			{
				$i = 1;
				foreach($result->result() as $column)
				{
					$id = $column->lead_id;
                    $status = "In Progress";
                    if($column->status == "Processed"){
                       $status = '<a href="#" data-toggle="modal" data-target="#viewCibilModel" id="viewCibilPDF" onclick="ViewBankingAnalysis(this.title)" title="'.$column->docId.'"><i class="fa fa-file-pdf-o"></i></a>'; 
                    }
				    $data.='<tbody>
                		<tr>							
							<td>'.$i.'</td>
							<td>'.$column->docId.'</td>
							<td>'.$column->created_at.'</td>
							<td><a href="#" data-toggle="modal" data-target="#viewCibilModel" id="viewCibilPDF" onclick="ViewBankingAnalysis(this.title)" title="'.$column->docId.'">'. $column->status .'</a>
						</td>
						</tr>';
				// 		<a href="#" data-toggle="modal" data-target="#viewCibilModel" id="viewCibilPDF" onclick="ViewBankingAnalysis(this.title)" title="'.$column->docId.'"><i class="fa fa-file-pdf-o"></i></a>
							    
					$i++;
				}
				$data .='</tbody></table></div>';
				
			}
			else
			{
		    	$data .='<tbody><tr><td colspan="9" style="text-align: -webkit-center;color:red;">Record Not Found...</td></tr></tbody></table></div>';
			}
		    return $data;
		}
		
		public function DownloadBankingAnalysis($doc_id)
		{
		  //  $Auth_Token = "UAT";
            $Auth_Token = "LIVE";
            
            if($Auth_Token == "UAT") {
                define('api_token', 'API://IlJKyP5wUwzCvKQbb796ZSjOITkMSRN8rifQTMrNM1/NUUv8/tuaN6Lun6d1NG4S');
            } else {
                define('api_token', 'API://9jwoyrhfdtDuDt0epG4VsisYdBHMsZMGC7IlUhwN8t1Qb2bgwxFqrn7K0LgWIly1');
            }
            
            $urlDownload = 'https://cartbi.com/api/downloadFile';
            $header2 = [
                'Content-Type: text/plain', 
                'auth-token: '. api_token
                ];
            
            $ch2 = curl_init($urlDownload);
            curl_setopt($ch2, CURLOPT_HTTPHEADER, $header2);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_POSTFIELDS, $doc_id);
            
            $downloadCartData = curl_exec($ch2);
            curl_close($ch2);
            return $this->db->where('docId', $doc_id)->update('tbl_cart', ['downloadCartData' => $downloadCartData]);
		}
		
		public function ViewBankingAnalysis($doc_id)
		{
		  //  date_default_timezone_set('Asia/Kolkata');
		    $row = $this->db->select('tbl_cart.downloadCartData')->where('docId', $doc_id)->get('tbl_cart');
		    $collection = $row->row_array();
		    $CartData = json_decode($collection['downloadCartData']);
            // echo "<pre>"; print_r($CartData); exit;
            // echo "<pre>"; print_r($CartData->data);
            // echo "<pre>"; print_r($CartData->data[0]);
            // echo "<pre>"; print_r($CartData->data[0]->salary[0]);
            // echo "<pre>"; print_r($CartData->data[0]->emi[0]); exit;
            
        	$data .= '
                <div id="collection">
                    <div class="footer-support">
                        <h2 class="footer-support">Salary Details &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                    </div>
                </div>
                <div class="table-responsive">
    		        <table class="table table-hover table-bordered table-striped">
                      <thead>
                        <tr class="table-primary">
                            <th scope="col"><strong>Transaction Date</strong></th>	
                            <th scope="col"><strong>Narration</strong></th>
                            <th scope="col"><strong>Cheque</strong></th>
                            <th scope="col"><strong>Amount</strong></th>
                            <th scope="col"><strong>Type</strong></th>
                        </tr>
                    </thead>';
	        foreach($CartData->data[0]->salary as $salary){
	            $data .= '<tbody>
	                <tr>
						<td><strong>'. $salary->month .'</strong></td>
						<td colspan="12"><strong>Rs. '. number_format($salary->totalSalary, 2) .'</strong></td>
	                </tr>';
    	        foreach($salary->transactions as $salaryList){
    	            $data .= '
					    <tr>
    					    <td>'. date('d/M/Y', substr($salaryList->transactionDate, 0, 10)) .'</td>
                            <td>'. $salaryList->narration .'</td>	
                            <td>'. $salaryList->cheque .'</td>
                            <td>'. number_format($salaryList->amount, 2) .'</td>
                            <td>'. $salaryList->type .'</td>
					    </tr>';
    	        }
	        }
            $data .= '</tbody></table></div>';
	        
        	$data .= '
                <div id="collection">
                    <div class="footer-support">
                        <h2 class="footer-support">EMI Details &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                    </div>
                </div>
                <div class="table-responsive">
    		        <table class="table table-hover table-bordered table-striped">
                      <thead>
                        <tr class="table-primary">
                            <th scope="col"><strong>Transaction Date</strong</th>
                            <th scope="col"><strong>Narration</strong</th>		
                            <th scope="col"><strong>Payment Category</strong</th>
                            <th scope="col"><strong>Cheque</strong</th>
                            <th scope="col"><strong>Amount</strong</th>
                            <th scope="col"><strong>Type</strong</th>	
                        </tr>
                    </thead>';
	        foreach($CartData->data[0]->emi as $emi){
	            $data .= '<tbody>
	                <tr>
						<td><strong>'. $emi->commonEntity .'</strong></td>
						<td colspan="5"><strong>Rs. '. number_format($emi->amount, 2) .'</strong></td>
						
	                </tr>';
    	        foreach($emi->transactions as $emiList){
    	            $data .= '
					    <tr>
    					    <td>'. date('d/M/Y', substr($emiList->transactionDate, 0, 10)) .'</td>
                            <td>'. $emiList->narration .'</td>		
                            <td>'. $emiList->paymentCategory .'</td>
                            <td>'. $emiList->cheque .'</td>
                            <td>Rs. '. number_format($emiList->amount, 2) .'</td>
                            <td>'. $emiList->type .'</td>
					    </tr>';
    	        }
	        
	        }
            $data .= '</tbody>
                </table>
            </div>';
		    return $data;
		}
		
		public function ViewCivilStatement($lead_id)
		{
		    $sql = $this->db->select('pancard')->where('lead_id', $lead_id)->get('leads')->row();
		    $pancard = $sql->pancard;
		    
		    if(!empty($pancard))
		    {
    			$result = $this->db->select('cbl.lead_id, cbl.cibil_id, cbl.cibil_file, cbl.memberCode, cbl.customer_name, cbl.totalAccount, 
                    cbl.totalBalance, cbl.overDueAccount, cbl.cibilScore, cbl.created_at, cbl.overDueAmount, cbl.zeroBalance')
			        ->where('pancard', $pancard)
			        ->from('tbl_cibil cbl')
			        ->order_by('cbl.cibil_id', 'DESC')->get();
		     
    			$data = '<div class="table-responsive">
    		        <table class="table table-hover table-striped table-bordered" style="margin-top: 10px;">
                      <thead>
                        <tr class="table-primary">
                          <th scope="col">Sr. No</th>
                          <th scope="col">Member ID</th>
                          <th scope="col">Customer Name</th>
                          <th scope="col">High Credit/ Sanc Amt</th>
                          <th scope="col">Total accounts</th>
                          <th scope="col">Overdue accounts</th>
                          <th scope="col">Zero Balance accounts</th>
                          <th scope="col">Current Balance</th>
                          <th scope="col">Score</th>
                          <th scope="col">Report Dt.</th>
                          <th scope="col">Report</th>
                        </tr>
                    </thead>';
	            if($result->num_rows() > 0)
	            {
    				$i = 1;
    				foreach($result->result() as $column)
    				{
    					$id = $column->lead_id;
    				    $data.='<tbody>
                    		<tr>				
    							<td>'.$i.'</td>
    							<td>'.$column->memberCode.'</td>
    							<td>'.strtoupper($column->customer_name).'</td>			
    							<td></td>
    							<td>'.$column->totalAccount.'</td>
    							<td>'.$column->totalBalance.'</td>
    							<td>'.$column->overDueAccount.'</td>
    							<td>'.$column->zeroBalance.'</td>
    							<td>'.$column->cibilScore.'</td>
    							<td>'.date('d-m-Y', strtotime($column->created_at)).'</td>
    							<td>
    							    <a href="'. base_url('viewCustomerCibilPDF/'.$column->cibil_id) .'" target="_blank"><i class="fa fa-file-pdf-o" title="View Cibil"></i></a> | 
    							    <a href="'. base_url('downloadCibilPDF/'.$column->cibil_id) .'"><i class="fa fa-download" title="Download Cibil"></i></a>
    							</td>
    						</tr>';
    					$i++;
    				}
    				return $data .='</tbody></table></div>';
    			}
    			else
    			{
    		    	return $data .='<tbody><tr><td colspan="11" style="text-align: -webkit-center;color:red;">Record Not Found...</td></tr></tbody></table></div>';
    			}
			}else{
				return $data .='<tbody><tr><td colspan="11" style="text-align: -webkit-center;color:red;">Record Not Found...</td></tr></tbody></table></div>';
			}
		}
		
		public function getCustomerLeadDetails($lead_id)
		{
            $table = 'leads';
            $where = [$table .'.lead_id', $lead_id];
            $update = ['userChecked' => $_SESSION['isUserSession']['user_id']];
            $this->updateQuery($where, $table, $update);

            $queryLeads = $this->db->select('credit_added, loan_approved')->where('leads.lead_id', $lead_id)->get('leads')->row();
            
			if($queryLeads->credit_added > 0){
	            $html = '<button class="btn btn-control btn-primary RequestForApproveLoan" onclick="RequestForApproveLoan()">Request For Approval</button>';
	        }
	        else
	        {
	        	$this->db->select('leads.lead_id, leads.name, leads.email, leads.alternateEmailAddress, leads.mobile, leads.alternateMobileNo, leads.addressLine1, leads.area, leads.landmark, leads.purpose, leads.type, leads.user_type, leads.pancard, leads.monthly_income, leads.loan_amount, leads.tenure, leads.interest, leads.cibil, leads.source, leads.dob, leads.gender, leads.city, leads.pincode, leads.status, leads.schedule_time, leads.created_on, leads.salary_mode, leads.userChecked, leads.partPayment,  tb_states.state')
	                ->where('leads.lead_id', $lead_id)
	                ->from(tableLeads)
	                ->join('tb_states', 'leads.state_id = tb_states.id');

	            $leadDetails = $this->db->get()->row();
	            $branch = $this->Task_Model->getBranch();
	            
	            $branchList = '';
	            foreach($branch as $branchs):
	                $branchList .= '<option value="'. $branchs->code .'">'. $branchs->state .'</option>';
	            endforeach;
				$html = '
	                <form id="FormSaveCreditData" method="post" autocomplete="off">
	                    <p style="color : #009fb3; font-size: 17px;">Customer Details</label>
	                    <div class="form-group row">
	                        <input type="hidden" name="lead_id" value="'. $leadDetails->lead_id .'">
	                        <input type="hidden" class="form-control rounded-0" id="sms" name="sms" value="Yes"/>
	                        <input type="hidden" class="form-control rounded-0" id="alternate_no" name="alternate_no" value="'. $leadDetails->alternateMobileNo .'"/>

	                         <div class="col-md-4">
	                            <label for="inputLastname">Customer Name<strong class="required_Fields">*</strong></label>
	                            <input class="form-control rounded-0" id="name" name="name" type="text" value="'. $leadDetails->name .'" autocomplete="off">
	                        </div>
	                        
	                        <div class="col-md-4">
	                            <label for="inputLastname">Email Id (For Sanction)<strong class="required_Fields">*</strong></label>
	                            <input class="form-control rounded-0" id="email" name="email" value="'. $leadDetails->email .'" type="email" autocomplete="off" >
	                        </div>

	                        <div class="col-md-4">
	                            <label for="inputLastname">Mobile<strong class="required_Fields">*</strong></label>
	                            <input class="form-control rounded-0" id="mobile" name="mobile" value="'. $leadDetails->mobile .'" type="tel" maxlength="10" autocomplete="off">
	                        </div>

	                        <div class="col-md-4">
	                            <label for="inputLastname">Pancard<strong class="required_Fields">*</strong></label>
	                            <input class="form-control rounded-0" id="pancard" name="pancard" type="text" value="'. $leadDetails->pancard .'" maxlength="10" minlength="10" autocomplete="off">
	                        </div>

	                        <div class="col-md-4">
	                            <label for="inputLastname">Salary<strong class="required_Fields">*</strong></label>
	                            <input class="form-control rounded-0" id="salary" name="salary" value="'. $leadDetails->monthly_income .'" type="number" autocomplete="off" >
	                        </div>

	                        <div class="col-md-4">
	                            <label for="inputLastname">Last salary date<strong class="required_Fields">*</strong></label>
	                            <input class="form-control rounded-0" id="salary_date" name="salary_date" type="date" min="" max="" autocomplete="off" >
	                        </div>

	                        <div class="col-md-4">
	                            <label for="inputLastname">DOB<strong class="required_Fields">*</strong></label>
	                            <input class="form-control rounded-0" id="dob" name="dob" type="date" value="'. $leadDetails->dob .'" autocomplete="off" >
	                        </div>

	                        <div class="col-sm-4">
	                            <label for="inputFirstname">Marital Status<strong class="required_Fields">*</strong></label>
	                            <select class="form-control" name="marital_status" id="marital_status" autocomplete="off" >
	                                <option value="">Select Marital Status</option>
	                                <option value="Married">Married</option>
	                                <option value="Single">Single</option>
	                                <option value="Divorced">Divorced</option>
	                                <option value="Widowed">Widowed</option>
	                              </select>
	                        </div>

	                         <div class="col-md-4">
	                            <label for="inputLastname">Father Name<strong class="required_Fields">*</strong></label>
	                            <input class="form-control rounded-0" id="father_name" name="father_name" type="text" maxlength="30" style="text-transform:capitalize;" autocomplete="off"/>
	                        </div>
	                    </div>

	                    <p style="color : #009fb3; font-size: 17px;">Other Details</p>

	                    <div class="form-group row">
	                        <div class="col-md-4">
	                            <label for="inputLastname">Branch<strong class="required_Fields">*</strong></label>
	                             <select class="form-control" name="branch" id="branch" autocomplete="off"> 
	                                <option value="">Select branch</option>
	                                '. $branchList .'
	                              </select>
	                        </div>

	                        <div class="col-md-4">
	                            <label for="inputLastname">Loan amount approved<strong class="required_Fields">*</strong></label>
	                            <input class="form-control rounded-0" id="loanapproved" name="loanapproved" value="'. $leadDetails->loan_amount .'" type="number" autocomplete="off" >
	                        </div>

	                        <div class="col-md-4">
	                            <label for="inputLastname">Repayment Date<strong class="required_Fields">*</strong></label>
	                            <input type="date" class="form-control rounded-0" id="repayment_date" onchange="repaymentDate(this)" name="repayment_date" min="'. date("Y-m-d") .'" max="'. date('Y-m-d', strtotime(' + 40 days')) .'" autocomplete="off">
	                        </div>

	                        <div class="col-md-4">
	                            <label for="inputLastname">Tenure<strong class="required_Fields">*</strong></label>
	                            <input class="form-control rounded-0" id="tenure" name="tenure" value="'. $leadDetails->tenure .'" type="number" autocomplete="off">
	                        </div>

	                        <div class="col-md-4">
	                            <label for="inputLastname">ROI(Example : 1.5)<strong class="required_Fields">*</strong></label>
	                            <input class="form-control rounded-0" id="roi" name="roi" type="text" value="1.5" maxlength="4" minlength="3" autocomplete="off">
	                        </div>

	                        <div class="col-md-4">
	                            <label for="inputLastname">Processing Fee<strong class="required_Fields">*</strong></label>
	                            <input class="form-control rounded-0" id="processing_fee" name="processing_fee" type="number" value="1000" maxlength="5" minlength="3" autocomplete="off">
	                        </div>

	                        <div class="col-md-4">
	                            <label for="inputWebsite">Mail Send<strong class="required_Fields">*</strong></label>
	                            <select class="form-control" name="mail" id="mail" autocomplete="off">
	                                <option value="">Select Mail Send</option>
	                                <option value="Yes">Yes</option>
	                                <option value="No">No</option>
	                              </select>
	                        </div>

	                        <div class="col-md-4">
	                            <label for="inputWebsite">Residential Type<strong class="required_Fields">*</strong></label>
	                            <select class="form-control" name="residential" id="residential" autocomplete="off">
	                                <option value="">Select Residential Type</option>
	                                <option value="Rented">Rented</option>
	                                <option value="Owned House">Owned House</option>
	                                <option value="Parental Home">Parental Home</option>
	                                <option value="Guest House">Guest House</option>
	                                <option value="PG">PG</option>
	                                <option value="Company Leased">Company Leased</option>
	                              </select>
	                        </div>
	                        
	                         <div class="col-md-4">
	                            <label for="inputWebsite">Residential Proof<strong class="required_Fields">*</strong></label>
	                            <select class="form-control" name="residential_proof" id="residential_proof" autocomplete="off">
	                                <option value="">Select Residential Proof</option>
	                                <option value="Aadhar Card">Aadhar Card</option>
	                                <option value="Voter ID">Voter ID</option>
	                                <option value="Passport">Passport</option>
	                                <option value="Driving Licence">Driving Licence</option>
	                                <option value="Other">Other</option>
	                              </select>
	                        </div>

	                        <div class="col-md-4">
	                            <label for="inputLastname">Residential Proof No.<strong class="required_Fields">*</strong></label>
	                            <input class="form-control rounded-0" id="residential_no" name="residential_no" type="text" autocomplete="off">
	                        </div>
	                        
	                         <div class="col-md-4">
	                            <label for="inputWebsite">Special Approval<strong class="required_Fields">*</strong></label>
	                            <select class="form-control" name="special_approval" id="special_approval" autocomplete="off">
	                                <option value="">Select Special Approval</option>
	                                <option value="Sachin Sir">Sachin Sir</option>
	                                <option value="Swadesh Sir">Swadesh Sir</option>
	                                <option value="Kamal Sir">Kamal Sir</option>
	                                <option value="Meena Mam">Meena Mam</option>
	                                <option value="NA">NA</option>
	                            </select>
	                        </div>
	                        
	                         <div class="col-md-4">
	                            <label for="inputWebsite">Other Approval<strong class="required_Fields">*</strong></label>
	                            <select class="form-control" name="other_approval" id="other_approval" autocomplete="off">
	                                <option value="">Select Other Approval</option>
	                                <option value="CRM">CRM</option>
	                                <option value="C/R Manager">Collection & Recovery Manager</option>
	                                <option value="NA">NA</option>
	                            </select>
	                        </div>

	                        <div class="col-md-4">
	                            <label for="inputWebsite">Repeat/Fresh<strong class="required_Fields">*</strong></label>
	                            <select class="form-control" name="repeat" id="repeat" autocomplete="off">
	                                <option value="">Select Repeat/Fresh</option>
	                                <option value="NEW">Fresh</option>
	                                <option value="R1">Repeat-1</option>
	                                <option value="R2">Repeat-2</option>
	                                <option value="R3">Repeat-3</option>
	                                <option value="R4">Repeat-4</option>
	                                <option value="R5">Repeat-5</option>
	                                <option value="R6">Repeat-6</option>
	                                <option value="R7">Repeat-7</option>
	                                <option value="R8">Repeat-8</option>
	                                <option value="R9">Repeat-9</option>
	                                <option value="R10">Repeat-10</option>
	                              </select>
	                        </div>

	                        <div class="col-sm-4">
	                            <label for="inputLastname">Obligations<strong class="required_Fields">*</strong></label>
	                            <input type="number" class="form-control rounded-0" id="obligations"  name="obligations" autocomplete="off">
	                        </div>

	                        <div class="col-sm-4">
	                            <label for="inputLastname">CIBIL Score<strong class="required_Fields">*</strong></label>
	                            <input type="number" class="form-control rounded-0" id="cibil"  name="cibil" autocomplete="off">
	                        </div>

	                        <div class="col-sm-4">
	                            <label for="inputFirstname">Status<strong class="required_Fields">*</strong></label>
	                            <select class="form-control" name="status" id="status" autocomplete="off">
	                                <option value="">Select Status</option>
	                                <option value="Sanction">Sanction</option>
	                                <option value="Rejected">Rejected</option>
	                                <option value="Hold">Hold</option>
	                              </select>
	                        </div>

	                        <div class="col-sm-8">
	                            <label for="inputLastname">Remark<strong class="required_Fields">*</strong></label>
	                            <textarea class="form-control rounded-0" id="remark" rows="3" cols="30" name="remark"></textarea>
	                        </div>
	                        
	                    </div>

	                </form>
	                <button id="btnSaveCreditData" onclick="saveCreditData()" class="button btn btn-primary">Save Credit</button>
				';
	        }
			
			return $html;
		} 
		
	    public function getOldHistory($lead_id)
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
		    $query = $this->db->select('leads.lead_id, leads.name, leads.email, leads.pancard, tb_states.state, leads.created_on, leads.source, leads.status, leads.userChecked, leads.partPayment,
		        loan.loan_amount, loan.loan_no, loan.loan_tenure, loan.loan_intrest, loan.loan_repay_amount, loan.loan_repay_date, loan.loan_disburse_date, loan.loan_admin_fee')
                ->where('leads.pancard', $pancard)
                ->where('leads.loan_approved', 3)
                ->from('leads')
                ->join('tb_states', 'leads.state_id = tb_states.id')
                ->join('loan', 'leads.lead_id = loan.lead_id');
                // ->join('recovery', 'recovery.lead_id = leads.lead_id')
            return $query->get();
	    }
	    
		public function getCustomerDocs($lead_id)
	    {
            $docsHistory = $this->db->select('docs.docs_id, docs.type, docs.file, docs.pwd, docs.created_on')
                    ->where('lead_id', $lead_id)
                    ->from('docs')
                    ->order_by('docs.docs_id', 'desc')
                    ->get(); 
            if($docsHistory->num_rows() != 1)
            {
		        $sql = $this->db->select('leads.pancard')->where('lead_id', $lead_id)->from('leads')->get()->row();
		        $pancard = $sql->pancard;
		        if(!empty($pancard))
		        {
	    			$docsHistory = $this->db->select('docs.docs_id, docs.type, docs.file, docs.created_on')
	                    ->where("docs.pancard LIKE '%$pancard%'")
				        ->from('docs')
				        ->order_by('docs.docs_id', 'desc')
				        ->get();
		        }
            }
            return $docsHistory;
	    }
		
		public function getCAM($lead_id, $fetch)
		{
			return $this->db->select($fetch)->where('CAM.lead_id', $lead_id)->from('tbl_cam as CAM')->order_by('cam_id', 'desc')->get();
		}
		
		public function getAgreementDetails($lead_id, $fetch)
		{
			return $this->db->select($fetch)->where('D.lead_id', $lead_id)->from('tbl_disburse as D')->order_by('D.loan_id', 'desc')->get();
		}
		
		public function getStateName($state_id)
		{
			return $this->db->select('st.state')->where('st.id', $state_id)->from('tb_states as st')->get();
		}
		
		public function getCityName($city_id)
		{
			return $this->db->select('city.city')->where('city.city_id', $city_id)->from('tb_city as city')->get();
		}
		
		public function getState()
		{
			return $this->db->select('state.id, state.state')->from('tb_states as state')->get();
		}
		
		public function getCity($state_id)
		{
			return $this->db->select('city.city_id, city.city, city.state_id')->where('city.state_id', $state_id)->from('tb_city as city')->get();	
		}

		public function getPersonalDetails($lead_id)
		{
            $table = 'leads';
            $where = [$table .'.lead_id', $lead_id];
            $update = ['userChecked' => $_SESSION['isUserSession']['user_id']];
            $this->updateQuery($where, $table, $update);

            $docsHistory = $this->getCustomerDocs($lead_id);
            $getDocsHistory = $docsHistory->result();
            //print_r($getDocsHistory); exit;
            
            $oldhistory = $this->getOldHistory($lead_id);
            $getLoanHistory = $oldhistory->num_rows();
            $getLoanHistoryRow = $oldhistory->result();
            
            $queryLeads = $this->db->select('credit_added, loan_approved')->where('leads.lead_id', $lead_id)->get('leads')->row();
            
        	$this->db->select('leads.lead_id, leads.name, leads.middle_name, leads.sur_name, leads.email, leads.alternateEmailAddress, leads.mobile, leads.alternateMobileNo, leads.addressLine1, leads.pancard, leads.dob, leads.gender, leads.state_id, leads.city, leads.pincode, leads.created_on, tb_states.state')
                ->where('leads.lead_id', $lead_id)
                ->from(tableLeads)
                ->join('tb_states', 'leads.state_id = tb_states.id');

            $leadDetails = $this->db->get()->row();

            $name				= strtoupper($leadDetails->name .' '. $leadDetails->middle_name .' '. $leadDetails->sur_name);
            $gender				= strtoupper($leadDetails->gender);
            $dob				= date('d-m-Y', strtotime($leadDetails->dob));
            $pancard			= strtoupper($leadDetails->pancard);
            $mobile				= $leadDetails->mobile;
            $alternateMobileNo	= $leadDetails->alternateMobileNo;
            $email				= $leadDetails->email;
            $state_id			= $leadDetails->state_id;
            $city_id			= "";
            $cityName			= ucfirst(strtolower($leadDetails->city));

            $stateArr = $this->getState();
            $stateList = $stateArr->result();

            $cityArr = $this->getCity($state_id);
            $cityList = $cityArr->result();

            $state = [];
            $city = [];
            $cityNameList = '';
            foreach($stateList as $row)
            {
            	$s = "";
            	if($row->id == $state_id){
            		$s = "Selected";
            	}
            	$state[] = [
            		's' 			=>$s,
            		'state_id' 		=>$row->id,
            		'state_name' 	=>$row->state,
            	];
            }

            foreach($cityList as $row)
            {
            	$s = "";
            	$city_id = $row->city_id;
            	if($row->city == $cityName){
            		$s = "Selected";
            	}
            	$city[] = [
            		's' 			=>$s,
            		'city_id' 		=>$city_id,
            		'city_name' 	=>$row->city,
            	];
            }

            $pincode			= $leadDetails->pincode;
            $created_on			= date('d-m-Y h:i:s', strtotime($leadDetails->created_on));

		    $alternateEmail 			= "";
		    $aadhar 					= "";
		    $residentialType 			= "";
		    $residential_proof 			= "";
		    $residence_address_line1 	= "";
		    $residence_address_line2 	= "";
		    $isPresentAddress 			= "";
		    $presentAddressType 		= "";
		    $present_address_line1 		= "";
		    $present_address_line2 		= "";
		    $employer_business 			= "";
		    $office_address 			= "";
		    $office_website 			= "";
            
            $residential_proof = '<option value="">Select</option>';
            foreach($getDocsHistory as $row):
                $residential_proof .= '<option value="'. $row->type .'">'. $row->type .'</option>';
            endforeach; 
            
            $data['residential_proof'] = $residential_proof;

			$fetch = 'CAM.company_id, CAM.customer_id, CAM.borrower_name, CAM.gender, CAM.dob, CAM.pancard, CAM.mobile, CAM.alternate_no, CAM.email, CAM.alternateEmail, CAM.state, CAM.city, CAM.pincode, CAM.lead_initiated_date, CAM.post_office, CAM.aadhar, CAM.residentialType, CAM.residential_proof, CAM.residence_address_line1, CAM.residence_address_line2, CAM.isPresentAddress, CAM.presentAddressType, CAM.present_address_line1, CAM.present_address_line2, CAM.employer_business, CAM.office_address, CAM.office_website, CAM.usr_created_by, CAM.usr_created_at, CAM.usr_updated_by, CAM.usr_updated_at';

			$sql = $this->getCAM($lead_id, $fetch);
			if($sql->num_rows() != 0)
			{
				$row = $sql->row();
            	$company_id			= $row->company_id;
            	$customer_id		= $row->customer_id;
            	$name				= strtoupper($row->borrower_name);
                $gender				= strtoupper($row->gender);
                $dob				= date('d-m-Y', strtotime($row->dob));
                $pancard			= strtoupper($row->pancard);
                $mobile				= $row->mobile;
                $alternateMobileNo	= $row->alternate_no;
                $email				= $row->email;
                $state_id			= $row->state;
                $cityCam         	= $row->city;
               // print_r($city); exit;
                $residential_proof	= $row->residential_proof; 
                $cityName			= ucfirst(strtolower($row->city));

                $state = [''];
                $city = [''];
                foreach($stateList as $stateColumn)
                {
                	$s = "";
                	if($stateColumn->id == $state_id){
                		$s = "Selected";
                	}
                	$state[] = [
                		's' 			=>$s,
                		'state_id' 		=>$stateColumn->id,
                		'state_name' 	=>$stateColumn->state,
                	];
                }

                //$cityArr = $this->getCity($state_id);
                //$cityList = $cityArr->result();

                // foreach($cityList as $cityColumn)
                // {
                // 	$s = "";
                // 	$city_id = $cityColumn->city_id;
                // 	if($cityColumn->city == $cityCam){
                // 		$s = "Selected";
                // 	}
                // 	$city[] = [
                // 		's' 			=>$s,
                // 		'city_id' 		=>$city_id,
                // 		'city_name' 	=>$cityColumn->city,
                // 	];
                // }
                foreach($cityList as $cityColumn)
	            {
	            	$s = "";
		            if($cityColumn->city == $cityCam){
		            	$s = "selected";
		            }
		            $cityNameList .= '<option value="'. $cityColumn->city .'" '. $s .'>'. $cityColumn->city .'</option>';
	            } 

                $pincode					= $row->pincode;
                $created_on					= $row->lead_initiated_date;
			    $alternateEmail 			= $row->alternateEmail;
			    $aadhar 					= $row->aadhar;
			    $residentialType 			= $row->residentialType;
			    $residential_proof 			= $row->residential_proof;
			    $residence_address_line1 	= $row->residence_address_line1;
			    $residence_address_line2 	= $row->residence_address_line2;
			    $isPresentAddress 			= $row->isPresentAddress;
			    $presentAddressType 		= $row->presentAddressType;
			    $present_address_line1 		= $row->present_address_line1;
			    $present_address_line2 		= $row->present_address_line2;
			    $employer_business 			= $row->employer_business;
			    $office_address 			= $row->office_address;
			    $office_website 			= $row->office_website;
			}
            
            $leadArr = [
            	'company_id'		=> $row->company_id,
            	'customer_id'		=> $row->customer_id,
                'name'				=> strtoupper($name),
                'gender'			=> strtoupper($gender),
                'dob'				=> date('d-m-Y', strtotime($dob)),
                'pancard'			=> strtoupper($pancard),
                'mobile'			=> $mobile,
                'alternateMobileNo'	=> $alternateMobileNo,
                'email'				=> $email,
                'pincode'			=> $pincode,
                'created_on'		=> $created_on,

			    'alternateEmail' 			=> $alternateEmail,
			    'aadhar' 					=> $aadhar,
			    'residentialType' 			=> $residentialType,
			    'residential_proof' 		=> $residential_proof,
			    'residence_address_line1' 	=> $residence_address_line1,
			    'residence_address_line2' 	=> $residence_address_line2,
			    'isPresentAddress' 			=> $isPresentAddress,
			    'presentAddressType' 		=> $presentAddressType,
			    'present_address_line1' 	=> $present_address_line1,
			    'present_address_line2' 	=> $present_address_line2,
			    'employer_business' 		=> $employer_business,
			    'office_address' 			=> $office_address,
			    'office_website' 			=> $office_website,
            ];

            $data['leadDetails'] = $leadArr;
            $data['state'] = $state;
            $data['city'] = $city;
            $data['citylistSelected'] = $cityNameList;
            

            $stateName = $this->getStateName($state_id);
            $data['stateName'] = $stateName->row();
            $cityName = $this->getCityName($city_id);
            $data['cityName'] = $cityName->row();
            
			return $data;
		}

		public function getCAMDetails($lead_id)
		{
            $oldhistory = $this->getOldHistory($lead_id);
            $getLoanHistory = $oldhistory->num_rows();

            $userType = 'NEW';
            if($getLoanHistory > 0){
                $userType = "REPEAT";
            }
        
        	$fetch = 'LD.loan_amount, LD.cibil';	
        	$leads = $this->selectLeads($lead_id, $fetch);
        	$leadDetails = $leads->row();

            $cibil				= $leadDetails->cibil;
            $loan_amount		= $leadDetails->loan_amount;
            $adminFee 			= (($loan_amount * 2) / 100);
            $net_disbursal_amount = $loan_amount - $adminFee;

			$fetch = 'CAM.lead_id, CAM.userType, CAM.cibil, CAM.Active_CC, CAM.cc_statementDate, CAM.cc_paymentDueDate, CAM.customer_bank_name, CAM.account_type, CAM.customer_account_no, CAM.customer_confirm_account_no, CAM.customer_name, CAM.cc_limit, CAM.cc_outstanding, CAM.max_eligibility, CAM.cc_name_Match_borrower_name, CAM.emiOnCard, CAM.DPD30Plus, CAM.cc_statementAddress, CAM.last3monthDPD, CAM.higherDPDLast3month, 
				CAM.isDisburseBankAC,
				CAM.bankIFSC_Code,	
				CAM.bank_name,		
				CAM.bank_branch,	
				CAM.bankA_C_No,	
				CAM.confBankA_C_No,
				CAM.bankHolder_name,
				CAM.bank_account_type, CAM.loan_applied, CAM.loan_recomended, CAM.processing_fee, CAM.roi, CAM.net_disbursal_amount, CAM.disbursal_date, CAM.repayment_date, CAM.tenure, CAM.repayment_amount, CAM.special_approval, CAM.deviationsApprovedBy, CAM.changeROI, CAM.changeFee, CAM.changeLoanAmount, CAM.changeTenure, CAM.changeRTR, CAM.remark, CAM.cam_created_by, CAM.cam_created_date, CAM.cam_updated_by, CAM.cam_updated_date';

			$sql = $this->getCAM($lead_id, $fetch);
 
// 			if($sql->num_rows() === 0)
			if(($sql->num_rows() > 0) || ($sql->num_rows() === 0))
			{
				$row = $sql->row();

				$userType 						= ($row->userType) 				? $row->userType 				: $userType;
				$cibil 							= ($row->cibil) 				? $row->cibil 					: $cibil;
				$Active_CC 						= ($row->Active_CC) 			? $row->Active_CC 				: '';
				$cc_statementDate 				= ($row->cc_statementDate) 		? $row->cc_statementDate 		: '';
				$cc_paymentDueDate 				= ($row->cc_paymentDueDate) 	? $row->cc_paymentDueDate 		: '';
				$customer_bank_name 			= ($row->customer_bank_name) 	? $row->customer_bank_name 		: '';
				$account_type 					= ($row->account_type) 			? $row->account_type 			: '';
				$customer_account_no 			= ($row->customer_account_no) 	? $row->customer_account_no 	: '';
				$customer_confirm_account_no 	= ($row->customer_confirm_account_no) ? $row->customer_confirm_account_no 	: '';
				$customer_name 					= ($row->customer_name) 		? $row->customer_name 			: '';
				$cc_limit 						= ($row->cc_limit) 				? $row->cc_limit 				: '';
				$cc_outstanding 				= ($row->cc_outstanding) 		? $row->cc_outstanding 			: '';
				$max_eligibility 				= ($row->max_eligibility) 		? $row->max_eligibility 		: '';
				$cc_name_Match_borrower_name 	= ($row->cc_name_Match_borrower_name) 	? $row->cc_name_Match_borrower_name : '';
				$emiOnCard 						= ($row->emiOnCard) 			? $row->emiOnCard 				: '';
				$DPD30Plus 						= ($row->DPD30Plus) 			? $row->DPD30Plus 				: '';
				$cc_statementAddress 			= ($row->cc_statementAddress) 	? $row->cc_statementAddress 	: '';
				$last3monthDPD 					= ($row->last3monthDPD) 		? $row->last3monthDPD 			: '';
				$higherDPDLast3month 			= ($row->higherDPDLast3month) 	? $row->higherDPDLast3month 	: '';
				

				$isDisburseBankAC 				= ($row->isDisburseBankAC) 		? $row->isDisburseBankAC 		: '';
				$bankIFSC_Code 					= ($row->bankIFSC_Code) 		? $row->bankIFSC_Code 			: '';
				$bank_name 						= ($row->bank_name) 			? $row->bank_name 				: '';
				$bank_branch 					= ($row->bank_branch) 			? $row->bank_branch 			: '';
				$bankA_C_No 					= ($row->bankA_C_No) 			? $row->bankA_C_No 				: '';
				$confBankA_C_No 				= ($row->confBankA_C_No) 		? $row->confBankA_C_No 			: '';
				$bankHolder_name 				= ($row->bankHolder_name) 	? $row->bankHolder_name 		: '';
				$bank_account_type 				= ($row->bank_account_type) 	? $row->bank_account_type 		: '';
				
				$loan_applied 					= ($row->loan_applied) 			? $row->loan_applied 			: $loan_amount;
				$loan_recomended 				= ($row->loan_recomended) 		? $row->loan_recomended 		: $loan_amount;
				$processing_fee 				= ($row->processing_fee) 		? $row->processing_fee 			: $adminFee;
				$roi 							= ($row->roi) 					? $row->roi 					: '';
				$net_disbursal_amount 			= ($row->net_disbursal_amount) 	? $row->net_disbursal_amount 	: $net_disbursal_amount;
				$disbursal_date 				= ($row->disbursal_date) 		? $row->disbursal_date 			: '';
				$repayment_date 				= ($row->repayment_date) 		? $row->repayment_date 			: '';
				$tenure 						= ($row->tenure) 				? $row->tenure 					: '';
				$repayment_amount 				= ($row->repayment_amount) 		? $row->repayment_amount 		: '';
				$special_approval 				= ($row->special_approval) 		? $row->special_approval 		: '';
				$deviationsApprovedBy 			= ($row->deviationsApprovedBy) 	? $row->deviationsApprovedBy 	: '';
				$changeROI 						= ($row->changeROI) 			? $row->changeROI 				: 'NO';
				$changeFee 						= ($row->changeFee) 			? $row->changeFee 				: 'NO';
				$changeLoanAmount 				= ($row->changeLoanAmount) 		? $row->changeLoanAmount 		: 'NO';
				$changeTenure 					= ($row->changeTenure) 			? $row->changeTenure 			: 'NO';
				$changeRTR 						= ($row->changeRTR) 			? $row->changeRTR 				: 'NO';
				$remark 						= ($row->remark) 				? $row->remark 					: '';
			}

            $camData = [
            	'userType' 						=> $userType,
				'cibil' 						=> $cibil,
				'Active_CC' 					=> $Active_CC,
				'cc_statementDate' 				=> $cc_statementDate,
				'cc_paymentDueDate' 			=> $cc_paymentDueDate,
				'customer_bank_name' 			=> $customer_bank_name,
				'account_type' 					=> $account_type,
				'customer_account_no' 			=> $customer_account_no,
				'customer_confirm_account_no' 	=> $customer_confirm_account_no,
				'customer_name' 				=> $customer_name,
				'cc_limit' 						=> $cc_limit,
				'cc_outstanding' 				=> $cc_outstanding,
				'max_eligibility' 				=> $max_eligibility,
				'cc_name_Match_borrower_name' 	=> $cc_name_Match_borrower_name,
				'emiOnCard' 					=> $emiOnCard,
				'DPD30Plus' 					=> $DPD30Plus,
				'cc_statementAddress' 			=> $cc_statementAddress,
				'last3monthDPD' 				=> $last3monthDPD,
				'higherDPDLast3month' 			=> $higherDPDLast3month,

				'isDisburseBankAC' 				=> $isDisburseBankAC,
				'bankIFSC_Code' 				=> $bankIFSC_Code,
				'bank_name' 					=> $bank_name,
				'bank_branch' 					=> $bank_branch,
				'bankA_C_No' 					=> $bankA_C_No,
				'confBankA_C_No' 				=> $confBankA_C_No,
				'bankHolder_name' 				=> $bankHolder_name,
				'bank_account_type' 			=> $bank_account_type,

				'loan_applied' 					=> $loan_applied,
				'loan_recomended' 				=> $loan_recomended,
				'processing_fee' 				=> $processing_fee,
				'roi' 							=> $roi,
				'net_disbursal_amount' 			=> $net_disbursal_amount,
				'disbursal_date' 				=> $disbursal_date,
				'repayment_date' 				=> $repayment_date,
				'tenure' 						=> $tenure,
				'repayment_amount' 				=> $repayment_amount,
				'special_approval' 				=> $special_approval,
				'deviationsApprovedBy' 			=> $deviationsApprovedBy,
				'changeROI' 					=> $changeROI,
				'changeFee' 					=> $changeFee,
				'changeLoanAmount' 				=> $changeLoanAmount,
				'changeTenure' 					=> $changeTenure,
				'changeRTR' 					=> $changeRTR,
				'remark' 						=> $remark,
            ];
            
            $leadArr = [
                'loan_amount'		=> $loan_amount,
                'cibil'				=> $cibil,
            ];
			$data['camDetails'] 	= $camData;
			$data['leadDetails'] 	= $leadArr;
            $data['userType'] 		= $userType;
            $data['adminFee'] 		= $adminFee;
            $data['net_disbursal_amount'] = $net_disbursal_amount;
	            
			return $data;
		}
		
		public function disburseDetails($lead_id)
		{
		    $url = $this->uri->segment(1);
		    $disburse = $this->db->select('loan.lead_id, loan.loan_no, loan.customer_bank_ifsc, loan.customer_bank, loan.customer_account_no, loan.customer_name, 
		            loan.loan_account_type, loan.loan_amount, loan.loan_intrest, loan.loan_admin_fee, loan.loan_fee_ref, loan.loan_tenure, 
		            loan.company_account_no, loan.modeOfPayment, credit.loan_amount_approved, credit.customer_id, loan.channel, loan.loanAgreementLetter, loan.loanAgreementRequest,
		            loan.loanAgreementResponse, loan.agrementRequestedDate, loan.agrementResponseDate, loan.agrementUserIP')
    	        	->where('loan.lead_id', $lead_id)
    	        	->from('loan')
    		        ->join('credit', 'credit.lead_id = loan.lead_id');
	        $disbursalDetails = $disburse->get();
	        $countDisburse = $disbursalDetails->num_rows();
	        $lead_details = $this->db->select('leads.is_Disbursed')->where('leads.lead_id', $lead_id)->get('leads')->row();
	        $data = "";
	        
	        if($countDisburse > 0)
	        {
	            $column = $disbursalDetails->row();
	            $loanDisbursedAmount = ($column->loan_amount - $column->loan_admin_fee);
	            $mailSend = "Failed";
	            if($column->loanAgreementRequest == 1){
	                $mailSend = "Sended";
	            }
	            
	            $requestedDate = "";
	            $responseDate = "";
	            if(!empty($column->agrementRequestedDate)){
	                $requestedDate = date("d-m-Y h:i:s", strtotime($column->agrementRequestedDate));
	            }
	            if(!empty($column->agrementResponseDate)){
                    $responseDate = date("d-m-Y h:i:s", strtotime($column->agrementResponseDate));
	            }
	            $mailResponse = "Pending";
	            if(!empty($column->loanAgreementResponse)){
	                $mailResponse = $column->loanAgreementResponse;
	            }
                $data = '<div class="table-responsive">
    		        <table class="table table-hover table-striped">
				        <tbody>
    							
                            <tr>
                                <th>CIF ID</th>
                                <td>'. $column->customer_id .'</td>
                                <th>Loan No</th>
                                <td>'. $column->loan_no .'</td>
                            </tr>
                            <tr>
                                <th>Credit Card A/C No.</th>
                                <td>'. $column->customer_account_no .'</td>
                                <th>Customer Credit Card Bank</th>
                                <td>'. $column->customer_bank .'</td>
                            </tr>
                            <tr>
                                <th>Credit Card Holder Name</th>
                                <td>'. $column->customer_name .'</td>
                                <th>Credit Card Type</th>
                                <td>'. $column->loan_account_type .'</td>
                            </tr>
                            <tr>
                                <th>Loan Approved Amount</th>
                                <td>'. number_format($column->loan_amount_approved, 2) .'</td>
                                <th>Admin Fee</th>
                                <td>Rs. '. number_format($column->loan_admin_fee, 2) .'</td>
                            </tr>
                            <tr>
                                <th>Loan Tenure</th>
                                <td>'. $column->loan_tenure .' Days</td>
                                <th>Disbursal Amount</th>
                                <input type="hidden" name="payAmount" id="payAmount" value="'. $loanDisbursedAmount .'">
                                <td>Rs. '. number_format($loanDisbursedAmount, 2) .'</td>
                            </tr>
						</tbody>
					</table>
				</div>
				';
				$data .= '
				        <div class="footer-supports">
                            <h2 class="footer-supports" style="background: #0b5e90;color : #fff; font-size: 14px; text-align: center;padding: 12px; border-radius: 3px;">Customer Confirmation Details &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                        </div>
        				<div class="table-responsive">
            		        <table class="table table-hover table-striped">
        				        <tbody>
                                    <tr>
                                        <th>Agreement Sent Date</th>
                                        <td>'. $requestedDate .'</td>
                                        <th>Agreement Sent Status</th>
                                        <td>'. $mailSend .'</td>
                                    </tr>
                                    <tr>
                                        <th>Agreement Response Date</th>
                                        <td>'. $responseDate .'</td>
                                        <th>Agreement Response Status</th>
                                        <td>'. $mailResponse .'</td>
                                    </tr>
                                    <tr>
                                        <th>Customer IP</th>
                                        <td>'. $column->agrementUserIP .'</td>
                                        <th colspan="2"></th>
                                    </tr>
        						</tbody>
        					</table>
        				</div>
				    ';
                
				if(!empty($column->company_account_no) && !empty($column->modeOfPayment) && !empty($column->loan_amount_approved) && !empty($column->channel))
				{
    				$data .= '
                        <div class="footer-support">
                            <h2 class="footer-support">Other Details &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                        </div>
        				<div class="table-responsive">
            		        <table class="table table-hover table-striped">
        				        <tbody>
                                    <tr>
                                        <th>MOP</th>
                                        <td>'. $column->modeOfPayment .'</td>
                                        <th>Disbursal A/C</th>
                                        <td>'. $column->company_account_no .'</td>
                                    </tr>
                                    <tr>
                                        <th>Channel</th>
                                        <td>'. $column->channel .'</td>
                                        <th>Loan Disbursed Amount</th>
                                        <td>Rs. '. number_format($loanDisbursedAmount, 2).'</td>
                                    </tr>
                                    <tr>
                                        <th>Reference No.</th>
                                        <td>'. $column->loan_fee_ref .'</td>
                                        <th></th>
                                        <td></td>
                                    </tr>
        						</tbody>
        					</table>
        				</div>
                    ';
                    if($_SESSION['isUserSession']['role'] == "Disbursal"){
                        
	                    if($lead_details->is_Disbursed == 1){
	                        $data .= '<button class="btn btn-control btn-primary" id="PayAmountToCustomer" onclick="PayAmountToCustomer()">Pay to customer</button>';
	                    }
	                    if($lead_details->is_Disbursed == 2)
	                    {
	                        $data .= '
	                            <form id="FormPaymentReference" method="post" enctype="multipart/form-data">
	                                <input type="hidden" class="form-control" name="lead_id" id="lead_id" value="'. $lead_id .'">
	                                <div class="col-md-8">
	                                    <input class="form-control" name="payment_reference_no" id="payment_reference_no" placeholder="Enter Reference No" required>
	                                </div>
	                            </form>
                                <div class="col-md-4">
                                	<button id="updatePaymentReference" class="btn btn-primary" onclick="UpdateDisburseReferenceNo()">Update Reference NO</button>
                                </div>
	                        ';
	                    }
                    }
				}
    				
	        }
	        return $data;
		}
		
		public function loanAgreementLetter($lead_id, $count)
		{
    		$personalDetails = $this->getPersonalDetails($lead_id);
    		$loan = $this->getCAMDetails($lead_id);

    		$company_id = $personalDetails['leadDetails']['company_id'];
    		$customer_id = $personalDetails['leadDetails']['customer_id'];
    		$name = $personalDetails['leadDetails']['name'];
    		$email = $personalDetails['leadDetails']['email'];
    		$alternateEmail = $personalDetails['leadDetails']['alternateEmail'];
    		$gender = $personalDetails['leadDetails']['gender'];
    		$dob = $personalDetails['leadDetails']['dob'];
    		$pancard = $personalDetails['leadDetails']['pancard'];
    		$loan_no = '';
    		$loan_amount = $loan['camDetails']['loan_recomended'];
    		$admin_fee = $loan['camDetails']['processing_fee'];
    		$netDueAmount = $loan['camDetails']['net_disbursal_amount'];
    		$tenure = $loan['camDetails']['tenure'];
    		$disbursal_date = $loan['camDetails']['disbursal_date'];
    		$repayment_date = $loan['camDetails']['repayment_date'];
    		$roi = $loan['camDetails']['roi'];
    		$repayment_amount = $loan['camDetails']['repayment_amount'];
    		$isDisburseBankAC = $loan['camDetails']['isDisburseBankAC'];

            $accountNo = "Credit Card Account Number";
			$holderName = "Credit Card Holder Name";
			$bankName = "Credit Card Bank Name";
			$accountType = "Credit Card Type";
            $customer_account_no = $loan['camDetails']['customer_account_no'];
            $customer_name = $loan['camDetails']['customer_name'];
            $customer_bank = $loan['camDetails']['customer_bank_name'];
            $account_type = $loan['camDetails']['account_type'];

    		if($isDisburseBankAC ==  "YES"){
	            $accountNo = "Bank Account Number";
				$holderName = "Bank Holder Name";
				$bankName = "Bank Name";
				$accountType = "Account Type";

				$customer_account_no = $loan['camDetails']['bankA_C_No'];
				$customer_name = $loan['camDetails']['bankHolder_name'];
				$customer_bank = $loan['camDetails']['bank_name'];
				$account_type = $loan['camDetails']['bank_account_type'];
    		}
		        
        	$mr = "Ms. ";
        	if($gender == "Male") { 
    			$mr = "Mr. ";
    		}

    		if(strlen($tenure) == 1){ 
    			$tenure = "0".$tenure;
    		}

		    $message = '
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Loan Against Card</title>
                </head>
                <body>
                
                <table width="778" border="0" align="center" cellpadding="0" cellspacing="0" style="padding:10px; border:solid 1px #ccc; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:22px;">
                  <tr>
                    <td width="381" align="left"><img src="https://loanagainstcard.com/assets/images/logo-final.png" width="234" height="60" /></td>
                    <td width="11" align="left">&nbsp;</td>
                    <td width="384" align="right"><table width="100%" border="0">
                      <tr>
                        <td align="right"><strong>'. $mr .''. strtoupper($name) .'</strong></td>
                      </tr>
                      <tr>
                        <td align="right"><strong>Loan No.:</strong> '. $loan_no .' </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td colspan="3"><hr / style="background:#ddd !important;"></td>
                  </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                  </tr>
                  <tr>
                    <td rowspan="7" align="left" valign="top"><table width="100%" border="0">
                      <tr>
                        <td align="left" valign="middle">Dear  Customer,</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Thank  you for choosing us and giving us the opportunity to be of service to you. Hope  you are satisfied with us.</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">In  response to your loan application, we are pleased to sanction you a personal  loan with the following terms and conditions. Please go through the terms and  conditions carefully and give your consent so that we may proceed with the disbursal of your loan and credit your credit card account.</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">You can repay the loan  via this link <a href="https://eazypay.icicibank.com/homePage" target="_blank" style="text-decoration:blink; color:#1a5ee6;"><span style="background : orange; color : #fff; padding : 2px;">https://eazypay.icicibank.com/homePage</span></a>
                        or UPI ID <span style="background : orange; color : #fff; padding : 2px;">8076329281@okbizaxis</span>. Kindly make the payment in the name of Naman  Finlease Pvt. Ltd. </td>
                      </tr>
                    </table></td>
                    <td>&nbsp;</td>
                    <td rowspan="7" align="center" valign="top"><img src="'. base_url("public/img/image-loan.jpg").'" width="384" height="261" / style="border:solid 1px #ccc; padding:5px;"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left"><img src="'. base_url('public/img/img.png').' " alt="text" width="26" height="10" /></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left">Loanagainstcard.com is powered by Naman Finlease Pvt.  Ltd. with registered office at S-370, Panchsheel Park, New Delhi-110017 </td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center" style="padding-top : 8px;padding-bottom : 10px;"><strong>Most  Important Terms and Conditions (MITC)</strong></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left"><table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                      <tr>
                        <td width="42%" bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Name </td>
                        <td width="58%" bgcolor="#FFFFFF" style="padding:5px;">&nbsp; '. $mr .''. strtoupper($name) .'</td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Loan Amount</td>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Rs. '. number_format($loan_amount, 2) .'</td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Administrative Fee</td>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Rs. '. number_format($admin_fee, 2) .'</td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Net Disbursal Amount</td>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Rs. '. number_format($netDueAmount, 2) .'</td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Disbursal Date</td>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; '. date('d-m-Y', strtotime($disbursal_date)) .'</td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Tenure</td>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; '.$tenure.' days</td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Repayment Date</td>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; '. date('d-m-Y', strtotime($repayment_date)) .'</td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Rate of Interest</td>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; '. $roi .' % per day (365.00 % per annum)</td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Repayment Amount</td>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Rs. '. number_format($repayment_amount, 2) .'</td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Late Payment Penalty *</td>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; 1.00 % per day (365.00% per annum)</td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; '. $accountNo .'</td>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; '. $customer_account_no .'</td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; '. $holderName .'</td>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; '. strtoupper($customer_name) .'</td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; '. $bankName .'</td>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; '. $customer_bank .'</td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; '. $accountType .'</td>
                        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; '. $account_type .'</td>
                      </tr>
                    </table>
                    
                    </td>
                  </tr>
                  
                    <tr>
                    <td colspan="3" align="left"><em>* Additional Interest Rate is applicable over and above the Rate of  Interest applicable to your loan for the delayed period of the loan.</em></td>
                    </tr>
                  <tr>
                    <td colspan="3" align="left"><img src="'. base_url('public/img/img.png') .'" alt="text" width="26" height="10" /></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left"><strong>Loan amount  to be credited directly to your Credit Card account as per your explicit  instructions. </strong></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left">Non-payment of loan on time will affect your CIBIL Score adversely and will reduce your ability to avail further loans from banks and financial institutions in future. Please provide your confirmation through the link below in agreement to the above terms.</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left"><img src="'. base_url('public/img/img.png') .'" alt="text" width="26" height="10" /></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left"><strong>Best Regards,</strong><br /></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left"><strong>Team Loanagainstcard</strong></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left"><img src="'. base_url('public/img/img.png') .'" alt="text" width="26" height="10" /></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center">
                        <p style="text-align: left;
                    background: #0070c0;
                    padding: 5px 10px;
                    color: #fff;
                    border-radius: 20px;
                    font-style: italic;
                    border: 1px #065892 solid;width: 77%;"><span>"
                    I hereby agree to the above loan terms and conditions and authorise Loanagainstcard.com to credit my Credit Card account with the loan money as per details conveyed above. I remain committed to repay the loan within due date and liable to legal prosecution on the event of default in the repayment of loan with all interest and charges as applicable."</span></p></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left"><img src="'. base_url('public/img/img.png') .'" alt="text" width="26" height="10" /></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center"><a href="'. base_url('loan-Agreement-Letter-Response/'. $lead_id .'/'. $count) .'" style="background: #ff0000;
                    color: #fff;
                    padding: 11px 13px;
                    border-radius: 3px;
                    text-decoration: blink;
                    font-weight: bold;
                    text-transform: uppercase;">&quot;Agree &amp; Confirm&quot; </a> <img src="'. base_url('public/img/hand.gif') .'" width="40" height="25"  style="position: relative;
                    top: 8px;"></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center">Our financial friendship has been started.</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center">You are special !!</td>
                  </tr>
                </table>
                </body>
                </html>
            ';
            $data = [
            	'company_id'		=> $company_id,
            	'customer_id'		=> $customer_id,
            	'name'				=> $name,
            	'pancard'			=> $pancard,
            	'email'				=> $email,
            	'alternateEmail'	=> $alternateEmail,
            	'message'			=> $message,
            ];
            return $data;
		}
		
    }
?>