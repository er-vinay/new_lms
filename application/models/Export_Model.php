<?php
	class Export_Model extends CI_Model
	{	
		public function ExportDisbursalData()
		{
	    	date_default_timezone_set('Asia/Kolkata');
			$query = $this->db->select('loan_id, L.branch, lead_id, loan_no, lan, loan_amount, 
		        loan_tenure, loan_intrest, loan_repay_amount, loan_repay_date, loan_disburse_refrence_no, 
		        loan_disburse_date, customer_name, L.email, customer_account_no, loan_account_type, 
		        loan_frequency, customer_bank_ifsc, customer_bank, customer_bank_branch, customer_cheque_details,
		        loan_pd_date, loan_care_by, loan_admin_fee, loan_admin_fee_collect, loan_fee_ref, remarks')
		        ->where('date(L.created_on) BETWEEN "'. date('Y-m-d', strtotime("2020-12-01")). '" and "'. date('Y-m-d', strtotime(todayDate)).'"')
				->from('loan L')
				->get();
	 	    return $query;
		}
		
		public function ExportTotalLeadsData($reportType, $filterType, $toDate, $fromDate)
		{
            // return $q = $this->db->select('user_id')->get('leads');
			$query = $this->db->select('leads.lead_id,leads.name,leads.email,leads.mobile,leads.pancard,leads.monthly_income,leads.loan_amount,leads.tenure,leads.cibil,leads.source,leads.gender,leads.city,leads.alternateEmailAddress,leads.alternateMobileNo,leads.purpose,leads.obligations,leads.dob,leads.address,leads.addressLine1,leads.area,leads.state_id,leads.status,leads.created_on')
            			      ->from('leads')
            			      ->where('date(leads.created_on) BETWEEN "'. date('Y-m-d', strtotime($toDate)). '" and "'. date('Y-m-d', strtotime($fromDate)).'"')
            			      ->get();
			return $query;
		}
		
		public function ExportRejectLeadsData($reportType, $filterType, $toDate, $fromDate)
		{
            // return $q = $this->db->select('user_id')->get('leads');
			$query = $this->db->select('leads.lead_id,leads.name,leads.email,leads.mobile,leads.pancard,leads.monthly_income,leads.loan_amount,leads.tenure,leads.cibil,leads.source,leads.gender,leads.city,leads.alternateEmailAddress,leads.alternateMobileNo,leads.purpose,leads.obligations,leads.dob,leads.address,leads.addressLine1,leads.area,leads.state_id,leads.status,leads.created_on')
			     //   ->where('date(leads.created_on) BETWEEN "'. date('Y-m-d', strtotime($toDate)). '" and "'. date('Y-m-d', strtotime($fromDate)).'"')
			     //   ->where('date(leads.created_on) BETWEEN "'. date('Y-m-d', strtotime("2020-12-09")). '" and "'. date('Y-m-d', strtotime("2020-12-09")).'"')
			     //   ->where('date(leads.created_on) BETWEEN "'. date('Y-m-d', strtotime($toDate)). '" and "'. date('Y-m-d', strtotime($fromDate)).'"')
			        ->from('leads')
			     //   ->join('tbl_rejected_loan','tbl_rejected_loan.lead_id = leads.lead_id')
			     //   ->join('users','users.user_id = tbl_rejected_loan.user_id')
			        ->where('date(leads.created_on) BETWEEN "'. date('Y-m-d', strtotime($toDate)). '" and "'. date('Y-m-d', strtotime($fromDate)).'"')
			     //   ->where('leads.lead_rejected',1)
			     //   ->where('date(leads.created_on) BETWEEN "'. date('Y-m-d', strtotime($fromDate)). '" and "'. date('Y-m-d', strtotime($toDate)).'"')
			        ->get();
		        
				
				// ->join('users', 'users.user_id = leads.user_id');
			return $query;
		}
	}
	
// 			$query = $this->db->select('ld.lead_id, ld.user_id, ld.appUserId, ld.name, ld.email, ld.alternateEmailAddress, ld.alternateMobileNo, ld.mobile,	ld.purpose, 
// 			    ld.type, ld.user_type, ld.customer_status, ld.lead_status, ld.source, ld.pancard, ld.monthly_income, ld.loan_amount, ld.tenure,	ld.interest, ld.repay_amount, ld.cibil, 
// 			    ld.obligations, ld.dob, ld.gender, ld.address, ld.addressLine1, ld.area, ld.landmark, ld.city, ld.state_id, ld.pincode, ld.term_and_condition, ld.coordinates, 
// 			    ld.residential_proof, ld.residential_no, ld.residence_type, ld.education, ld.status, ld.preferred_time, ld.otp, is_verified, ld.is_recovery, ld.is_legal, 
// 			    ld.otp_created_on, ld.utm_source, ld.ip, ld.lock_by, ld.schedule_time, ld.created_on, ld.updated_by, ld.updated_on, ld.feedback, ld.salary_mode, ld.leads_duplicate, 
// 			    ld.lead_rejected, ld.loan_approved, ld.contactUpdatedBy, ld.userChecked, ld.employeeDetailsAdded, ld.partPayment, ld.isSenction, ld.is_Disbursed')
?>