<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class ExportController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
            $this->load->model('Task_Model');
            $this->load->model('Emails_Model');
            $this->load->model('Export_Model');
            $this->load->library('csvimport');
            $this->load->database('OldDatabase'); 
	    	$login = new IsLogin();
	    	$login->index();
		} 
		
	 	public function filterReportType()
	 	{
 	        $result = $this->db->where('status', 1)->get('tbl_filter_menu')->result();
 	        echo json_encode($result);
	 	}

	 	public function filterReportFilterType()
	 	{
	 	    if(!empty($_POST['name'])){
	 	        $query = $this->db->where('name', $_POST['name'])->get('tbl_filter_menu')->row();
	 	        $result = $this->db->where('filter_id', $query->filter_id)->get('tbl_filter_sub_menu')->result();
	 	        echo json_encode($result);
	 	    }
	 	}

        public function ExportDisbursalData()
	    {
			$result = $this->Export_Model->ExportDisbursalData();
			if($result->num_rows() > 0)
			{
    			$filename = 'Disbursal_Report_'. date('d_m_Y') .'.csv'; 
    			header("Content-Description: File Transfer"); 
    			header("Content-Disposition: attachment; filename=$filename"); 
    			header("Content-Type: application/csv; ");
    
    			$file = fopen('php://output', 'w');
    			$header = array("loan_id","branch","lead_id","loan_no","lan","loan_amount","loan_tenure","loan_intrest","loan_repay_amount",
    			"loan_repay_date","loan_disburse_refrence_no","loan_disburse_date","customer_name","email","customer_account_no","loan_account_type",
    			"loan_frequency","customer_bank_ifsc","customer_bank","customer_bank_branch","customer_cheque_details","loan_pd_date","loan_care_by",
    			"loan_admin_fee","loan_admin_fee_collect","loan_fee_ref","remarks","form_no","loan_status","company_account_no","ip","sms","mail","urmn",
    			"mandate_status","created_by","created_on");
    			
    			fputcsv($file, $header);
    			foreach ($result->result_array() as $key =>$line){ 
    				fputcsv($file, $line); 
    			}
    			fclose($file); 
    			exit;
			} else {
			    echo "<script>alert('No record found.');</script>";
			}
	    }
	    

        public function ExportData($file_name)
	    {
	        $result = 0;
	        if(!empty($file_name) && $file_name == 'leads')
	        {
	            $result = $this->Export_Model->ExportLeadsData();
	        }
	        
			if($result->num_rows() > 0)
			{
    			$filename = $file_name .'_'. date('d_m_Y') .'.csv';
    			header("Content-Description: File Transfer"); 
    			header("Content-Disposition: attachment; filename=$filename"); 
    			header("Content-Type: application/csv; ");
    
    			$file = fopen('php://output', 'w');
    			$header = array("loan_id","branch","lead_id","loan_no","lan","loan_amount","loan_tenure","loan_intrest","loan_repay_amount","loan_repay_date","loan_disburse_refrence_no","loan_disburse_date","customer_name","email","customer_account_no","loan_account_type","loan_frequency","customer_bank_ifsc","customer_bank","customer_bank_branch","customer_cheque_details","loan_pd_date","loan_care_by","loan_admin_fee","loan_admin_fee_collect","loan_fee_ref","remarks","form_no","loan_status","company_account_no","ip","sms","mail","urmn","mandate_status","created_by","created_on");
    			
    			fputcsv($file, $header);
    			foreach ($result->result_array() as $key =>$line){ 
    				fputcsv($file, $line); 
    			}
    			fclose($file); 
    			exit;
			} else {
			    echo "<script>alert('No record found.');</script>";
			}
	    }
	    
        public function FilterExportReports()
	    { 
	        //print_r($_POST); exit;
            if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        { 
	        	$this->form_validation->set_rules('filterType', 'Filter Type', 'required|trim');
	        	$this->form_validation->set_rules('toDate', 'To Date', 'required|trim');
	        	$this->form_validation->set_rules('fromDate', 'From Date', 'required|trim');
	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
	        	}
	        	else
	        	{ 
	        	    $filterType = $this->input->post('filterType');
	        	    $toDate = $this->input->post('toDate');
	        	    $fromDate = $this->input->post('fromDate');
	        	    
        	        $file_name = $filterType;
	        	    
	        	    if($filterType == "Leads Duplicate") {
                        $this->exportCSVLeadDuplicate($filterType, $toDate, $fromDate);
	        	    }
	        	    else if($filterType == "Leads Reject") {
                        $this->exportCSVLeadRejected($filterType, $toDate, $fromDate);
	        	    }
	        	    else if($filterType == "Leads Total") {
                        $this->exportCSVLeadTotal($filterType, $toDate, $fromDate);
	        	    }
	        	    else if($filterType == "Loan Disbursed") {
                        $this->exportCSVLoanDisbursed($filterType, $toDate, $fromDate);
	        	    }
	        	    else if($filterType == "Loan Pre Disburse") {
                        $this->exportCSVLoanPreDisbursed($filterType, $toDate, $fromDate);
	        	    }
	        	    else if($filterType == "Loan Pending") {
                        $this->exportCSVLoanPending($filterType, $toDate, $fromDate);
	        	    }
	        	    else if($filterType == "Collection") {
                        $this->exportCollection($filterType, $toDate, $fromDate);
	        	    }
	        	    else if($filterType == "Sanction Total") {
                        $this->exportTotalSanction($filterType, $toDate, $fromDate);
	        	    }
	        	    else if($filterType == "Rejected Sanction") {
                        $this->exportTotalRejectedSanction($filterType, $toDate, $fromDate);
	        	    } 
	        	    else if($filterType == "Pending Recovery") {
                        $this->exportPendingRevovery($filterType, $toDate, $fromDate);
	        	    }
	        	     
        	        echo json_encode($json);
	        	}
	        }  
	    }
	    
	    public function exportCollection($filterType, $toDate, $fromDate)
	    {
	        $collectionDate = date('Y-m-d', strtotime('+5 days', strtotime(todayDate)));
			$result = $this->db->select('leads.lead_id, leads.name, leads.email, leads.mobile, tb_states.state, leads.created_on,loan.loan_no,credit.loan_amount_approved, loan.loan_repay_amount, loan.loan_repay_date, loan.loan_tenure, loan.loan_intrest, loan.loan_disburse_date')
				->where('date(loan.loan_repay_date) BETWEEN "'. date('Y-m-d', strtotime('now')). '" and "'. date('Y-m-d', strtotime($collectionDate)).'"')
				->from('loan')
                ->join('leads', 'loan.lead_id = leads.lead_id')
                ->join('credit', 'credit.lead_id = loan.lead_id')
                ->join('tb_states', 'leads.state_id = tb_states.id')->get();
            if($result->num_rows() > 0)
			{
			    //echo "test"; exit;
                $header = array("lead ID", "Customer Name", "Customer Email", "Customer Mobile", "State", "Created_ On", "Loan No", "Loan Approved Amount", "Repay Amount", "Repay Date", "Tenure", "Loan Interest", "Loan Disbursed Date");
                // $header = array("Loan ID", "Customer ID", "Branch", "Lead ID", "Loan No", "LAN", "Loan Amount", "Tenure", "Interest", "Repay Amount", "Repay Date", "Reference No", "Disbursed Date", "Customer Name", "Customer Email", "Customer A/C No", "A/C Type", "Customer Bank IFSC", "Customer Bank Name", "Customer Bank Branch", "Cheque Details", "Processing Fee", "Processing Fee Collected", "Loan Fee Reference", "Remarks", "Loan Status", "Company A/C No", "MOP", "Channel", "SMS", "Mail");
    		
    	        $filename = 'Collection_'. $toDate .' _ '.$fromDate ."_download_". date('d_m_Y h:i:s') .'.csv';
    			header("Content-Description: File Transfer"); 
    			header("Content-Disposition: attachment; filename=$filename"); 
    			header("Content-Type: application/csv; ");
    
    			$file = fopen('php://output', 'w');
    			fputcsv($file, $header);
    			foreach ($result->result_array() as $key =>$line){ 
    				fputcsv($file, $line); 
    			}
    			fclose($file); 
    			exit;
			} else {
		        $json['err'] = 'No record found.';
			}
	    }
	    
	    public function exportCSVLeadDuplicate($filterType, $toDate, $fromDate)
	    {
	        $result = $this->db->select('LD.lead_id, LD.customer_id, LD.name, LD.purpose, LD.type, LD.user_type, LD.monthly_income, LD.loan_amount, LD.tenure, LD.interest,
	                LD.repay_amount, LD.cibil, LD.obligations, LD.source, LD.dob, LD.gender, LD.address,
	                LD.addressLine1, LD.area, LD.landmark, LD.city, S.state, LD.pincode, LD.residential_proof, LD.residential_no, LD.residence_type, LD.education, LD.status,
	                LD.preferred_time, LD.schedule_time, LD.utm_source, LD.created_on, LD.updated_by, LD.updated_on, LD.salary_mode, DL.reson')
                    ->where('LD.leads_duplicate', 1)
		            ->where('date(LD.created_on) BETWEEN "'. date('Y-m-d', strtotime($toDate)). '" and "'. date('Y-m-d', strtotime($fromDate)).'"')
		            ->from('leads LD')
		            ->join('tb_states S', 'LD.state_id = S.id')
		            ->join('tbl_duplicate_leads DL', 'DL.lead_id = LD.lead_id')
                    ->get();
            if($result->num_rows() > 0)
			{
                $header = array("Lead ID", "Customer ID", "Customer Name","Purpose", "Type", "User Type", "Monthly Income", "Loan Amount", "Tenure", "Interest",
                "Repayment Amount", "CIBIL", "Obligations", "Lead Source", "Date Of Birth", "Gender", "Address", "Address Line 1", "Area", "Landmark", "City", "State",
                "Pincode", "Residental Proof", "Residental No", "Residental Type", "Education", "Status", "Prefered Time", "Customer Scheduled Time to Talk",
                "UTM Source ", "Initiated Date", "Updated By", "Modified Date", "Salary Mode", "Reason Of Duplicate");
    			
    	        $filename = 'Lead_Duplicate_'. $toDate .' _ '.$fromDate ."_download_". date('d_m_Y h:i:s') .'.csv';
    			header("Content-Description: File Transfer"); 
    			header("Content-Disposition: attachment; filename=$filename"); 
    			header("Content-Type: application/csv; ");
    
    			$file = fopen('php://output', 'w');
    			fputcsv($file, $header);
    			foreach ($result->result_array() as $key =>$line){ 
    				fputcsv($file, $line); 
    			}
    			fclose($file); 
    			exit;
			} else {
		        $json['err'] = 'No record found.';
			}
	    }
	    
	    public function exportCSVLeadRejected($filterType, $toDate, $fromDate)
	    {
	        $result = $this->db->select('LD.name, LD.email, LD.mobile, LD.pancard, LD.monthly_income, LD.cibil, LD.dob,LD.pincode,')
                    ->where('LD.lead_rejected', 1)
		            ->where('date(LD.created_on) BETWEEN "'. date('Y-m-d', strtotime($toDate)). '" and "'. date('Y-m-d', strtotime($fromDate)).'"')
		            ->from('leads LD')
		            ->join('tb_states S', 'LD.state_id = S.id')
		            ->join('tbl_rejected_loan RL', 'RL.lead_id = LD.lead_id')
                    ->get(); 
            if($result->num_rows() > 0)
			{
                $header = array("Customer Name", "Customer Email", "Customer Mobile", "Pancard", "Monthly Income",  "CIBIL", "Date Of Birth",  "Pincode");
    		
    	        $filename = 'Lead_Rejected_'. $toDate .' _ '.$fromDate ."_download_". date('d_m_Y h:i:s') .'.csv';
    			header("Content-Description: File Transfer"); 
    			header("Content-Disposition: attachment; filename=$filename"); 
    			header("Content-Type: application/csv; ");
    
    			$file = fopen('php://output', 'w');
    			fputcsv($file, $header);
    			foreach ($result->result_array() as $key =>$line){ 
    				fputcsv($file, $line); 
    			}
    			fclose($file); 
    			exit;
			} else {
		        $json['err'] = 'No record found.';  
			}
	    }
	    
	    public function exportCSVLeadTotal($filterType, $toDate, $fromDate)
	    {
	        $result = $this->db->select('LD.lead_id, LD.customer_id, LD.name, LD.purpose, LD.type, LD.monthly_income, LD.loan_amount, CAM.loan_recomended, LD.tenure, LD.interest,
	                   LD.repay_amount, LD.obligations, LD.source, LD.dob, LD.gender, LD.addressLine1, LD.area, LD.landmark, LD.city, S.state, LD.pincode, LD.residential_proof, 
	                   LD.residential_no, LD.residence_type, LD.education, LD.status, LR.reason, LD.preferred_time, LD.schedule_time, LD.created_on, LD.updated_on, LD.salary_mode,
	                   u1.name as RejctedBy, LD.rejected_on, u2.name as ProcessBy, LD.created_on, u3.name as Sanctioned_By, CAM.cam_created_date, u4.name as Sanction_Approved_By,
	                   CAM.sanctioned_date')
                    ->where('date(LD.created_on) BETWEEN "'. date('Y-m-d', strtotime($toDate)). '" and "'. date('Y-m-d', strtotime($fromDate)).'"')
		            ->from('leads LD')
		            ->join('tb_states S', 'LD.state_id = S.id')
		            ->join('tbl_cam CAM', 'LD.lead_id = CAM.lead_id', "left")
		            ->join('tbl_rejected_loan LR', 'LD.lead_id = LR.lead_id', "left")
		            ->join('users u1', 'u1.user_id = LR.user_id', "left")
		            ->join('users u2', 'u2.user_id = CAM.usr_created_by', "left")
		            ->join('users u3', 'u3.user_id = CAM.cam_created_by', "left")
		            ->join('users u4', 'u4.user_id = CAM.sanctioned_by', "left")
                    ->get();
            if($result->num_rows() > 0)
			{
                $header = array("Lead ID", "Customer ID", "Customer Name", "Customer Email", "Customer Alternate Email", "Customer Alternate Mobile", "Customer Mobile", "Purpose", "Type", "User Type", "Pancard", "Monthly Income", "Loan Amount", "Tenure", "Interest", "Repayment Amount", "CIBIL", "Obligations", "Lead Source", "Date Of Birth", "Gender", "Address Line 1", "Area", "Landmark", "City", "State", "Pincode", "Residental Proof", "Residental No", "Residental Type", "Education", "Status", "Prefered Time", "Customer Scheduled Time to Talk", "mail", "UTM Source ", "Initiated Date", "Updated By", "Modified Date", "Salary Mode");
    		
    	        $filename = 'Lead_Total_'. $toDate .' _ '.$fromDate ."_download_". date('d_m_Y h:i:s') .'.csv';
    			header("Content-Description: File Transfer"); 
    			header("Content-Disposition: attachment; filename=$filename"); 
    			header("Content-Type: application/csv; ");
    
    			$file = fopen('php://output', 'w');
    			fputcsv($file, $header);
    			foreach ($result->result_array() as $key =>$line){ 
    				fputcsv($file, $line); 
    			}
    			fclose($file); 
    			exit;
			} else {
		        $json['err'] = 'No record found.';
			}
	    }
	    
	    public function exportCSVLoanDisbursed($filterType, $toDate, $fromDate)
	    { 
			$result = $this->db->select('br.branch, cr.pancard, l.loan_no, ld.source, l.customer_id, l.customer_name, l.email, l.mobile, cr.loan_amount_approved, cr.processing_fee, cr.tenure, cr.roi,  cr.repay_amount, l.loan_disburse_date, l.loan_repay_date, l.ModeOfPayment, l.company_account_no,  ld.address, ld.dob, cr.cibil, l.customer_account_no, l.customer_bank, l.customer_bank_ifsc, l.loan_fee_ref, l.loan_admin_fee_collect, l.loan_fee_ref, l.company_account_no, l.loan_care_by, l.loan_status')
        			        ->where('date(l.loan_disburse_date) BETWEEN "'. date('Y-m-d', strtotime($toDate)). '" and "'. date('Y-m-d', strtotime($fromDate)).'"')
        			        ->where('l.loan_fee_ref !=', '') 
        			        ->from('loan l') 
            				->join('leads ld', 'ld.lead_id = l.lead_id')
            				->join('credit cr', 'cr.lead_id = l.lead_id')
            				->join('branch br', 'br.code = l.branch')
            				->get()->result(); 
            if($result->num_rows() > 0)
			{
                $header = array("Branch Name", "Pan Number", "Loan No", "Lead Source Name", "Customer ID", "Customer Name", "Email", "Mobile Number", "Loan Amount", "Admin Fee", "Tenure", "ROI", "Loan Repay Amount", "Disbursement Date", "Closure Date", "Mode Of Payment", "Company Bank Account Number", "Customer Current Address", "DOB", "Cibil Score", "Customer Bank Account Number", "Customer Bank Name", "Customer Bank IFSC", "Refrence No Of Disbursement", "Company Account", "Disbursed By", "Disbursement Status");
    	        $filename = 'Loan_Disbursed_'. $toDate .' _ '.$fromDate ."_download_". date('d_m_Y h:i:s') .'.csv';
    			header("Content-Description: File Transfer"); 
    			header("Content-Disposition: attachment; filename=$filename"); 
    			header("Content-Type: application/csv; ");
    
    			$file = fopen('php://output', 'w');
    			fputcsv($file, $header);
    			foreach ($result->result_array() as $key =>$line){ 
    				fputcsv($file, $line); 
    			}
    			fclose($file); 
    			exit;
			} else {
			    echo"<script>alert('Record not Found.')</script>";
                $this->session->set_flashdata('err', 'No Record Found!');
                return redirect(base_url('exportData'), 'refresh');
			}
	    }
	    public function exportCSVLoanPreDisbursed($filterType, $toDate, $fromDate)
	    {
			$result = $this->db->select('br.branch, cr.pancard, l.loan_no, ld.source, l.customer_id, l.customer_name, l.email, l.mobile, cr.loan_amount_approved, cr.processing_fee, cr.tenure, cr.roi,  cr.repay_amount, l.loan_disburse_date, l.loan_repay_date, l.ModeOfPayment, l.company_account_no,  ld.address, ld.dob, cr.cibil, l.customer_account_no, l.customer_bank, l.customer_bank_ifsc, l.loan_fee_ref, l.loan_admin_fee_collect, l.loan_fee_ref, l.company_account_no, l.loan_care_by, l.loan_status, U.name')
    			        ->where('date(l.created_on) BETWEEN "'. date('Y-m-d', strtotime($toDate)). '" and "'. date('Y-m-d', strtotime($fromDate)).'"')
    			    //   $this->db->select('loan_id, customer_id, L.branch, lead_id, loan_no, lan, loan_amount, loan_tenure, loan_intrest, loan_repay_amount, loan_repay_date, loan_disburse_refrence_no,  loan_disburse_date, customer_name, L.email, customer_account_no, loan_account_type,  loan_frequency, customer_bank_ifsc, customer_bank, customer_bank_branch, customer_cheque_details, loan_pd_date, loan_care_by, loan_admin_fee, loan_admin_fee_collect, loan_fee_ref, remarks, loan_status, company_account_no, modeOfPayment, channel, sms, mail')
        				->from('loan l')
        				->where('l.loan_status',"Pre Disburse")
        				->join('users U', 'l.created_by=U.user_id')
        				->join('leads ld', 'ld.lead_id = l.lead_id')
        				->join('credit cr', 'cr.lead_id = l.lead_id')
        				->join('branch br', 'br.code = l.branch')
        				->get();
            if($result->num_rows() > 0)
			{
                // $header = array("Loan ID", "Customer ID", "Branch", "Lead ID", "Loan No", "LAN", "Loan Amount", "Tenure", "Interest", "Repay Amount", "Repay Date", "Reference No", "Disbursed Date", "Customer Name", "Customer Email", "Customer A/C No", "A/C Type", "Customer Bank IFSC", "Customer Bank Name", "Customer Bank Branch", "Cheque Details", "Processing Fee", "Processing Fee Collected", "Loan Fee Reference", "Remarks", "Loan Status", "Company A/C No", "MOP", "Channel", "SMS", "Mail");
    		    $header = array("Branch Name", "Pan Number", "Loan No", "Lead Source Name", "Customer ID", "Customer Name", "Email", "Mobile Number", "Loan Amount", "Admin Fee", "Tenure", "ROI", "Loan Repay Amount", "Disbursement Date", "Closure Date", "Mode Of Payment", "Company Bank Account Number", "Customer Current Address", "DOB", "Cibil Score", "Customer Bank Account Number", "Customer Bank Name", "Customer Bank IFSC", "Refrence No Of Disbursement", "Company Account", "Disbursed By", "Disbursement Status", "Created By");
    	        $filename = 'Loan_Pre_Disbursed_'. $toDate .' _ '.$fromDate ."_download_". date('d_m_Y h:i:s') .'.csv';
    			header("Content-Description: File Transfer"); 
    			header("Content-Disposition: attachment; filename=$filename"); 
    			header("Content-Type: application/csv; ");
    
    			$file = fopen('php://output', 'w');
    			fputcsv($file, $header);
    			foreach ($result->result_array() as $key =>$line){ 
    				fputcsv($file, $line); 
    			}
    			fclose($file); 
    			exit;
			} else {
                $this->session->set_flashdata('err', 'No Record Found!');
                return redirect(base_url('exportData'), 'refresh');
			}
	    }
	    
	     public function exportCSVLoanPending($filterType, $toDate, $fromDate)
	    {
			$result = $this->db->select('br.branch, cr.pancard, l.loan_no, ld.source, l.customer_id, l.customer_name, l.email, l.mobile, cr.loan_amount_approved, cr.processing_fee, cr.tenure, cr.roi,  cr.repay_amount, l.loan_disburse_date, l.loan_repay_date, l.ModeOfPayment, l.company_account_no,  ld.address, ld.dob, cr.cibil, l.customer_account_no, l.customer_bank, l.customer_bank_ifsc, l.loan_fee_ref, l.loan_admin_fee_collect, l.loan_fee_ref, l.company_account_no, l.loan_care_by, l.loan_status, U.name')
    			        ->where('date(l.created_on) BETWEEN "'. date('Y-m-d', strtotime($toDate)). '" and "'. date('Y-m-d', strtotime($fromDate)).'"')
    			    //   $this->db->select('loan_id, customer_id, L.branch, lead_id, loan_no, lan, loan_amount, loan_tenure, loan_intrest, loan_repay_amount, loan_repay_date, loan_disburse_refrence_no,  loan_disburse_date, customer_name, L.email, customer_account_no, loan_account_type,  loan_frequency, customer_bank_ifsc, customer_bank, customer_bank_branch, customer_cheque_details, loan_pd_date, loan_care_by, loan_admin_fee, loan_admin_fee_collect, loan_fee_ref, remarks, loan_status, company_account_no, modeOfPayment, channel, sms, mail')
        				->from('loan l')
        				->where('l.loan_status',"Disburse Pending")
        				->join('users U', 'l.created_by=U.user_id')
        				->join('leads ld', 'ld.lead_id = l.lead_id')
        				->join('credit cr', 'cr.lead_id = l.lead_id')
        				->join('branch br', 'br.code = l.branch')
        				->get();
            if($result->num_rows() > 0)
			{
                // $header = array("Loan ID", "Customer ID", "Branch", "Lead ID", "Loan No", "LAN", "Loan Amount", "Tenure", "Interest", "Repay Amount", "Repay Date", "Reference No", "Disbursed Date", "Customer Name", "Customer Email", "Customer A/C No", "A/C Type", "Customer Bank IFSC", "Customer Bank Name", "Customer Bank Branch", "Cheque Details", "Processing Fee", "Processing Fee Collected", "Loan Fee Reference", "Remarks", "Loan Status", "Company A/C No", "MOP", "Channel", "SMS", "Mail");
    		    $header = array("Branch Name", "Pan Number", "Loan No", "Lead Source Name", "Customer ID", "Customer Name", "Email", "Mobile Number", "Loan Amount", "Admin Fee", "Tenure", "ROI", "Loan Repay Amount", "Disbursement Date", "Closure Date", "Mode Of Payment", "Company Bank Account Number", "Customer Current Address", "DOB", "Cibil Score", "Customer Bank Account Number", "Customer Bank Name", "Customer Bank IFSC", "Refrence No Of Disbursement", "Company Account", "Disbursed By", "Disbursement Status", "Created By");
    	        $filename = 'Loan_Pending_'. $toDate .' _ '.$fromDate ."_download_". date('d_m_Y h:i:s') .'.csv';
    			header("Content-Description: File Transfer"); 
    			header("Content-Disposition: attachment; filename=$filename"); 
    			header("Content-Type: application/csv; ");
    
    			$file = fopen('php://output', 'w');
    			fputcsv($file, $header);
    			foreach ($result->result_array() as $key =>$line){ 
    				fputcsv($file, $line); 
    			}
    			fclose($file); 
    			exit;
			} else {
                $this->session->set_flashdata('err', 'No Record Found!');
                return redirect(base_url('exportData'), 'refresh');
			}
	    }
	    
	    //////////////////////////////////////////////////Export Total Sanction////////////////////////////////////////////////////
	    
	    public function exportTotalSanction($filterType, $toDate, $fromDate)
	    {
			$result = $this->db->select('cr.credit_id, cr.lead_id, cr.customer_id, cr.loan_amount_approved, cr.cibil, cr.processing_fee, cr.tenure, cr.roi, cr.repay_amount, cr.repayment_date, cr.status, br.branch, l.name, cr.father_name, cr.pancard, cr.dob, cr.email,  cr.mobile, cr.alternate_no, cr.salary, cr.salary_date, cr.residential, cr.residential_proof, cr.residential_no, cr.noofdisbursal, cr.created_on')
    			        ->where('date(cr.created_on) BETWEEN "'. date('Y-m-d', strtotime($toDate)). '" and "'. date('Y-m-d', strtotime($fromDate)).'"')
    			        ->where('cr.status',"Sanction")
    			        ->from('leads l') 
        				->join('credit cr', 'cr.lead_id=l.lead_id')
        				->join('users u', 'cr.approved_by=u.user_id')
        				->join('branch br', 'br.code = cr.branch')
        				->get();
            if($result->num_rows() > 0)
			{
    		    $header = array("Credit ID", "lead ID", "Customer ID", "Loan Approved Amount", "Cibil", "Admin Fee", "Tenure", "ROI", "Repay Amount", "Repay Date", "Status", "Branch", "Name", "Father Name", "Pancard", "DOB", "Email", "Mobile", "Alternate Mobile No", "Salary", "Salary Date", "Residential Type", "Residential Proof", "Residential No", "Number Of Disbursed", "Created Date");
    	        $filename = 'Total_Sanction_'. $toDate .' _ '.$fromDate ."_download_". date('d_m_Y h:i:s') .'.csv';
    			header("Content-Description: File Transfer"); 
    			header("Content-Disposition: attachment; filename=$filename"); 
    			header("Content-Type: application/csv; ");
    
    			$file = fopen('php://output', 'w');
    			fputcsv($file, $header);
    			foreach ($result->result_array() as $key =>$line){ 
    				fputcsv($file, $line); 
    			}
    			fclose($file); 
    			exit;
			} else {
                $this->session->set_flashdata('err', 'No Record Found!');
                return redirect(base_url('exportData'), 'refresh');
			}
	    }
	    
	    //////////////////////////////////////////////////Export Total Rejected Sanction////////////////////////////////////////////////////
	    
	    public function exportTotalRejectedSanction($filterType, $toDate, $fromDate)
	    {
			$result = $this->db->select('cam.cam_id, cam.lead_id, cam.customer_id, cam.borrower_name as Customer_Name, cam.gender, cam.dob, cam.pancard, cam.mobile, cam.alternate_no, cam.email,
			            cam.alternateEmail, S.state, cam.city, cam.residence_address_line1, cam.residence_address_line2, cam.cibil, cam.loan_applied, cam.loan_recomended, cam.processing_fee,
			            cam.roi, cam.net_disbursal_amount, cam.disbursal_date, cam.repayment_date, cam.tenure, cam.remark, cam.status, u.name as Sanction_By, cam.sanctioned_date')
    			        ->where('date(cam.sanctioned_date) BETWEEN "'. date('Y-m-d', strtotime($toDate)). '" and "'. date('Y-m-d', strtotime($fromDate)).'"')
                        ->where('cam.status',"Rejected")
                        ->from('leads l') 
        				->join('tbl_cam cam', 'cam.lead_id=l.lead_id')
        				->join('users u', 'cam.sanctioned_by=u.user_id')
        			    ->join('tb_states S', 'cam.state = S.id') 
        				->get(); 
            if($result->num_rows() > 0)
			{
    		    $header = array("CAM ID", "lead ID", "Customer ID", "Name", "Gender", "DOB", "Pancard", "Mobile", "Alternate Mobile", "Email", "Alternate Email", "State", "City",
    		    "Residence Add-1", "Residence Add-2", "Cibil", "Loan Applied", "Loan Recomended", "Processing Fee", "ROI", "Disbursal Amount", "Disbursal Date", "Repayment Date", "Tenur", "Remark", "Status", "Sanction By", "Sanction Date");
    	        $filename = 'Rejected_Sanction_'. $toDate .' _ '.$fromDate ."_download_". date('d_m_Y h:i:s') .'.csv';
    			header("Content-Description: File Transfer"); 
    			header("Content-Disposition: attachment; filename=$filename"); 
    			header("Content-Type: application/csv; ");
    
    			$file = fopen('php://output', 'w');
    			fputcsv($file, $header);
    			foreach ($result->result_array() as $key =>$line){ 
    				fputcsv($file, $line); 
    			}
    			fclose($file); 
    			exit;
			} else {
                $this->session->set_flashdata('err', 'No Record Found!');
                return redirect(base_url('exportData'), 'refresh');
			}
	    }
	    
	     //////////////////////////////////////////////////Export Revovery Pending////////////////////////////////////////////////////
	     
        public function exportPendingRevovery($filterType, $toDate, $fromDate)
        {           
        	            $recoveryDate = date('Y-m-d', strtotime('5 days', strtotime(todayDate)));
        	            $result = $this->db->select('leads.lead_id, leads.name, leads.email, leads.mobile, tb_states.state, leads.created_on,loan.loan_no,credit.loan_amount_approved, credit.processing_fee, loan.loan_repay_amount, loan.loan_repay_date, loan.loan_tenure, loan.loan_intrest, recovery.status, loan.loan_disburse_date')
                				->where('date(loan.loan_repay_date) BETWEEN "'. date('Y-m-d', strtotime('now')). '" and "'. date('Y-m-d', strtotime($recoveryDate)).'"')
                				// ->where('date(loan.) BETWEEN "'. date('Y-m-d', strtotime($toDate)). '" and "'. date('Y-m-d', strtotime($fromDate)).'"')
                				->where('recovery.status',"Part Payment")
                				->from('recovery')
                				->order_by('recovery_id', "DESC")
                				->join('loan', 'loan.lead_id = recovery.lead_id')
                                ->join('leads', 'loan.lead_id = leads.lead_id')
                                ->join('credit', 'credit.lead_id = loan.lead_id') 
                                ->join('tb_states', 'leads.state_id = tb_states.id')->get();
                    if($result->num_rows() > 0)
        			{
                        $header = array("lead ID", "Customer Name", "Customer Email", "Customer Mobile", "State", "Created_ On", "Loan No", "Loan Approved Amount", "Admin Fee", "Repay Amount", "Repay Date", "Tenure", "Loan Interest", "Status", "Loan Disbursed Date");
                       
            	        $filename = 'Recovery_Pending_'. $toDate .' _ '.$fromDate ."_download_". date('d_m_Y h:i:s') .'.csv';
            			header("Content-Description: File Transfer"); 
            			header("Content-Disposition: attachment; filename=$filename"); 
            			header("Content-Type: application/csv; ");
            
            			$file = fopen('php://output', 'w');
            			fputcsv($file, $header);
            			foreach ($result->result_array() as $key =>$line){ 
            				fputcsv($file, $line); 
            			}
            			fclose($file); 
            			exit;
        			} else {
                        $this->session->set_flashdata('err', 'No Record Found!');
                        return redirect(base_url('exportData'), 'refresh');
        			}  
        }
		
	}

?>