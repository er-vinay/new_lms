<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class CreditController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
            $this->load->model('Task_Model');

	    	$login = new IsLogin();
	    	$login->index();
	        define("sessionUserID", $_SESSION['isUserSession']['user_id']);
		}

		public function AddCreditDetails($lead_id)
		{
			$data['crm_Approval'] = $this->Task_Model->getCrmApporal();
            $this->db->where("lead_id", $lead_id)->update('leads', ['userChecked'=> $_SESSION['isUserSession']['user_id']]);
    		$this->db->select('leads.lead_id, leads.name, leads.email, leads.alternateEmailAddress, leads.mobile, leads.alternateMobileNo, leads.addressLine1, leads.area, leads.landmark, leads.purpose, leads.type, leads.user_type, leads.pancard, leads.monthly_income, leads.loan_amount, leads.tenure, leads.interest, leads.cibil, leads.source, leads.dob, leads.gender, leads.city, tb_states.state, leads.pincode, leads.status, leads.schedule_time, leads.created_on, leads.salary_mode, leads.userChecked, leads.partPayment')
                ->where('leads.lead_id', $lead_id)
                ->from(tableLeads)
                ->join('tb_states', 'leads.state_id = tb_states.id');
                
            $data['leadDetails'] = $this->db->get()->row();	
            $data['branch'] = $this->Task_Model->getBranch();

			$this->load->view('Tasks/AddCreditDetails', $data);
		}

		public function getCustomerLeadDetails($lead_id)
		{
			$data = $this->Task_Model->getCustomerLeadDetails($lead_id);
			echo json_encode($data);
		}

		// public function getPersonalDetails($lead_id)
		// {
		// 	$data = $this->Task_Model->getPersonalDetails($lead_id);
		// 	echo json_encode($data);
		// }

		public function saveCreditDetails()
		{
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
				$this->form_validation->set_rules('name', 'Name', 'required|trim');
				$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
				$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
				$this->form_validation->set_rules('pancard', 'Pancard', 'required|trim');
				$this->form_validation->set_rules('salary', 'Salary', 'required|trim');
				$this->form_validation->set_rules('salary_date', 'Salary Date', 'required|trim');
				$this->form_validation->set_rules('dob', 'DOB', 'required|trim');
				$this->form_validation->set_rules('marital_status', 'Marital Status', 'required|trim');
				$this->form_validation->set_rules('father_name', 'Father Name', 'required|trim');
				$this->form_validation->set_rules('branch', 'Branch', 'required|trim');
				$this->form_validation->set_rules('loanapproved', 'Loan Approved', 'required|trim');
				$this->form_validation->set_rules('roi', 'Roi', 'required|trim');
				$this->form_validation->set_rules('processing_fee', 'Processing Fee', 'required|trim');
				$this->form_validation->set_rules('repayment_date', 'Repayment Date', 'required|trim');
				$this->form_validation->set_rules('residential', 'Residential', 'required|trim');
				$this->form_validation->set_rules('residential_proof', 'Residential Proof', 'required|trim');
				$this->form_validation->set_rules('residential_no', 'Residential No', 'required|trim');
				$this->form_validation->set_rules('special_approval', 'Specia Approval', 'required|trim');
				$this->form_validation->set_rules('repeat', 'Repeat', 'required|trim');
				$this->form_validation->set_rules('obligations', 'Obligations', 'required|trim');
				$this->form_validation->set_rules('mail', 'Male Send', 'required|trim');
				$this->form_validation->set_rules('cibil', 'Cibil', 'required|trim');
				$this->form_validation->set_rules('status', 'Status', 'required|trim');
				$this->form_validation->set_rules('remark', 'Remark', 'required|trim');
	        	if($this->form_validation->run() == FALSE) 
	        	{
	        		$json['err'] = validation_errors();
		            echo json_encode($json);
	        	} 
	        	else 
	        	{
			        
			        $lead_id = $this->input->post('lead_id');
			        $name = $this->input->post('name');
			        $email = $this->input->post('email');
			        $father_name = $this->input->post('father_name');
			        $roi = $this->input->post('roi');
			        $processing_fee = $this->input->post('processing_fee');
			        $mail = $this->input->post('mail');
			        $obligations = $this->input->post('obligations');
			        $cibil = $this->input->post('cibil');

					$pancard = $this->input->post('pancard');
					$dob = $this->input->post('dob');
					$mobile = $this->input->post('mobile');
					$alternate_no= $this->input->post('alternate_no');
					$salary = $this->input->post('salary');
					$salary_date = $this->input->post('salary_date');
					$residential = $this->input->post('residential');
					$residential_proof = $this->input->post('residential_proof');
					$residential_no = $this->input->post('residential_no');
					$marital_status = $this->input->post('marital_status');
					$special_approval = $this->input->post('special_approval');
					$other_approval = $this->input->post('other_approval');
					$remark = $this->input->post('remark');
					$status = $this->input->post('status');
					$loanApproved = $this->input->post('loanapproved');
					$branch = $this->input->post('branch');
					$repeat = $this->input->post('repeat');
			        $repayment_date = $this->input->post('repayment_date');
					$sms = $this->input->post('sms');
			        $now2 = date("Y-m-d", strtotime(updated_at));
			        
			        $date1_ts = strtotime($now2);
				    $date2_ts = strtotime($repayment_date);
				    $diff = $date2_ts - $date1_ts;
			        $tenure = ($diff / 60/60/24);

					$query1 = $this->db->select('count(customer_id) as total, customer_id')->where('pancard', $pancard)->from('customer')->get();

					$result1 = $query1->result();

					if($result1[0]->total > 0) {
					  	$customer_id = $result1[0]->customer_id;
					}
					else
					{
						$last_row = $this->db->select('customer.customer_id')->from('customer')->order_by('customer_id', 'desc')->limit(1)->get()->row();
                        
						$str = preg_replace('/\D/', '', $last_row->customer_id);
						$customer_id= "FTC".str_pad(($str + 1), 6, "0", STR_PAD_LEFT);

						$dataCustomer = array(
							'customer_id'	=>$customer_id,
							'name'			=>$name,
							'email'			=>$email,
							'mobile'		=>$mobile,
							'pancard'		=>$pancard,
							'aadhar_no'		=>$residential_no,
							'created_date'	=>updated_at
						);
						$resultCustomer = $this->db->insert('customer', $dataCustomer);
					}

					$lan = 'NFPL'.date('ymd').$lead_id;
					$repay = $loanApproved + (($loanApproved * $roi * $tenure)/100);
					
					$data = array(
						'lead_id' 				=> $lead_id,
						'customer_id'			=> $customer_id,
						'obligations'			=> $obligations,
						'loan_amount_approved'	=> $loanApproved,
						'roi'					=> $roi,
						'tenure'				=> $tenure,
						'lan' 					=> $lan,
						'repay_amount' 			=> $repay,
						'repayment_date'		=> $repayment_date,
						'processing_fee'		=> $processing_fee,
						'cibil'					=> $cibil,
						'status' 				=> $status,
						'remark' 				=> $remark,
						'branch' 				=> $branch,
						'email' 				=> $email,
						'name' 					=> $name,
						'father_name' 			=> $father_name,
						'pancard' 				=> $pancard,
						'dob' 					=> $dob,
						'mobile' 				=> $mobile,
						'alternate_no' 			=> $alternate_no,
						'salary' 				=> $salary,
						'salary_date' 			=> $salary_date,
						'residential' 			=> $residential,
						'residential_proof' 	=> $residential_proof,
						'residential_no' 		=> $residential_no,
						'marital_status'		=> $marital_status,
						'special_approval'		=> $special_approval,
						'crm_approval'			=> $other_approval,
						'ip' 					=> ip,
						'sms'					=> $sms,
						'approved_by'			=> sessionUserID,
				// 		'created_on'			=> updated_at,
						'noofdisbursal'			=> $repeat
			      	);
					$this->db->trans_start();

					$queryCheckCredit = $this->db->where('credit.lead_id', $lead_id)->get('credit');
					if($queryCheckCredit->num_rows() > 0){
			      	    array_merge($data, ['loan_approved' => 1, created_on=>updated_at]);
						$this->db->where('credit.lead_id', $lead_id)->update('credit', $data);
					}else{
			      	    array_merge($data, ['updated_on' => updated_at]);
						$result = $this->db->insert('credit', $data);
						$this->db->where('lead_id', $lead_id)->update('leads', ['lead_status' =>$status, 'remark' =>$remark]);
				// 		if($status == "Hold")
				// 		{
				// 		    $this->sanction_mail_for_hold_customer($lead_id);
				// 		}
					}
					
					
			        $queryUser = $this->db->where("user_id", sessionUserID)->get('users')->result();
			        
			        $salary_mode = "Bank Transfer";
					$lead_rejected = $lead_hold = 0;

					if(!empty($queryUser[0]->salary_mode)) {
						$salary_mode = $queryUser[0]->salary_mode;
					}
					
					if($status == "Sanction"){
						$status = "Credit";
					} else if($status = "Rejected"){
						$lead_rejected = 1;
					} else {}

					$updateLeadStatus = array(
						'interest' 		=>$roi,
						'cibil' 		=>$cibil,
						'salary_mode' 	=>$salary_mode,
						'status' 		=>$status,
						'lead_rejected' =>$lead_rejected,
						'repay_amount' 	=>$repay,
						'credit_added'  =>1,
						'updated_on'	=>updated_at
					);

					$this->db->where('lead_id', $lead_id)->update('leads', $updateLeadStatus);

			        $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge" /><meta name="viewport" content="width=device-width, initial-scale=1" /><meta name="x-apple-disable-message-reformatting" /><meta name="apple-mobile-web-app-capable" content="yes" /><meta name="apple-mobile-web-app-status-bar-style" content="black" /><meta name="format-detection" content="telephone=no" /><title></title><link href="https://www.dafont.com/kg-blank-space.font" rel="stylesheet" type="text/css" /><style type="text/css">
			                /* Resets */
			                .ReadMsgBody { width: 100%; background-color: #ebebeb;}
			                .ExternalClass {width: 100%; background-color: #ebebeb;}
			                .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
			                a[x-apple-data-detectors]{
			                    color:inherit !important;
			                    text-decoration:none !important;
			                    font-size:inherit !important;
			                    font-family:inherit !important;
			                    font-weight:inherit !important;
			                    line-height:inherit !important;
			                }        
			                body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
			                body {margin:0; padding:0;}
			                .yshortcuts a {border-bottom: none !important;}
			                .rnb-del-min-width{ min-width: 0 !important; }

			                /* Add new outlook css start */
			                .templateContainer{
			                    max-width:590px !important;
			                    width:auto !important;
			                }
			                /* Add new outlook css end */

			                /* Image width by default for 3 columns */
			                img[class="rnb-col-3-img"] {
			                max-width:170px;
			                }

			                /* Image width by default for 2 columns */
			                img[class="rnb-col-2-img"] {
			                max-width:264px;
			                }

			                /* Image width by default for 2 columns aside small size */
			                img[class="rnb-col-2-img-side-xs"] {
			                max-width:180px;
			                }

			                /* Image width by default for 2 columns aside big size */
			                img[class="rnb-col-2-img-side-xl"] {
			                max-width:350px;
			                }

			                /* Image width by default for 1 column */
			                img[class="rnb-col-1-img"] {
			                max-width:550px;
			                }

			                /* Image width by default for header */
			                img[class="rnb-header-img"] {
			                max-width:590px;
			                }

			                /* Ckeditor line-height spacing */
			                .rnb-force-col p, ul, ol{margin:0px!important;}
			                .rnb-del-min-width p, ul, ol{margin:0px!important;}

			                /* tmpl-2 preview */
			                .rnb-tmpl-width{ width:100%!important;}

			                /* tmpl-11 preview */
			                .rnb-social-width{padding-right:15px!important;}

			                /* tmpl-11 preview */
			                .rnb-social-align{float:right!important;}

			                /* Ul Li outlook extra spacing fix */
			                li{mso-margin-top-alt: 0; mso-margin-bottom-alt: 0;}        

			                /* Outlook fix */
			                table {mso-table-lspace:0pt; mso-table-rspace:0pt;}
			            
			                /* Outlook fix */
			                table, tr, td {border-collapse: collapse;}

			                /* Outlook fix */
			                p,a,li,blockquote {mso-line-height-rule:exactly;} 

			                /* Outlook fix */
			                .msib-right-img { mso-padding-alt: 0 !important;}

			                @media only screen and (min-width:590px){
			                /* mac fix width */
			                .templateContainer{width:590px !important;}
			                }

			                @media screen and (max-width: 360px){
			                /* yahoo app fix width "tmpl-2 tmpl-10 tmpl-13" in android devices */
			                .rnb-yahoo-width{ width:360px !important;}
			                }

			                @media screen and (max-width: 380px){
			                /* fix width and font size "tmpl-4 tmpl-6" in mobile preview */
			                .element-img-text{ font-size:24px !important;}
			                .element-img-text2{ width:230px !important;}
			                .content-img-text-tmpl-6{ font-size:24px !important;}
			                .content-img-text2-tmpl-6{ width:220px !important;}
			                }

			                @media screen and (max-width: 480px) {
			                td[class="rnb-container-padding"] {
			                padding-left: 10px !important;
			                padding-right: 10px !important;
			                }

			                /* force container nav to (horizontal) blocks */
			                td.rnb-force-nav {
			                display: inherit;
			                }
			                }

			                @media only screen and (max-width: 600px) {

			                /* center the address &amp; social icons */
			                .rnb-text-center {text-align:center !important;}

			                /* force container columns to (horizontal) blocks */
			                td.rnb-force-col {
			                display: block;
			                padding-right: 0 !important;
			                padding-left: 0 !important;
			                width:100%;
			                }

			                table.rnb-container {
			                 width: 100% !important;
			                }

			                table.rnb-btn-col-content {
			                width: 100% !important;
			                }
			                table.rnb-col-3 {
			                /* unset table align="left/right" */
			                float: none !important;
			                width: 100% !important;

			                /* change left/right padding and margins to top/bottom ones */
			                margin-bottom: 10px;
			                padding-bottom: 10px;
			                /*border-bottom: 1px solid #eee;*/
			                }

			                table.rnb-last-col-3 {
			                /* unset table align="left/right" */
			                float: none !important;
			                width: 100% !important;
			                }

			                table[class~="rnb-col-2"] {
			                /* unset table align="left/right" */
			                float: none !important;
			                width: 100% !important;

			                /* change left/right padding and margins to top/bottom ones */
			                margin-bottom: 10px;
			                padding-bottom: 10px;
			                /*border-bottom: 1px solid #eee;*/
			                }

			                table.rnb-col-2-noborder-onright {
			                /* unset table align="left/right" */
			                float: none !important;
			                width: 100% !important;

			                /* change left/right padding and margins to top/bottom ones */
			                margin-bottom: 10px;
			                padding-bottom: 10px;
			                }

			                table.rnb-col-2-noborder-onleft {
			                /* unset table align="left/right" */
			                float: none !important;
			                width: 100% !important;

			                /* change left/right padding and margins to top/bottom ones */
			                margin-top: 10px;
			                padding-top: 10px;
			                }

			                table.rnb-last-col-2 {
			                /* unset table align="left/right" */
			                float: none !important;
			                width: 100% !important;
			                }

			                table.rnb-col-1 {
			                /* unset table align="left/right" */
			                float: none !important;
			                width: 100% !important;
			                }

			                img.rnb-col-3-img {
			                /**max-width:none !important;**/
			                width:100% !important;
			                }

			                img.rnb-col-2-img {
			                /**max-width:none !important;**/
			                width:100% !important;
			                }

			                img.rnb-col-2-img-side-xs {
			                /**max-width:none !important;**/
			                width:100% !important;
			                }

			                img.rnb-col-2-img-side-xl {
			                /**max-width:none !important;**/
			                width:100% !important;
			                }

			                img.rnb-col-1-img {
			                /**max-width:none !important;**/
			                width:100% !important;
			                }

			                img.rnb-header-img {
			                /**max-width:none !important;**/
			                width:100% !important;
			                margin:0 auto;
			                }

			                img.rnb-logo-img {
			                /**max-width:none !important;**/
			                width:100% !important;
			                }

			                td.rnb-mbl-float-none {
			                float:inherit !important;
			                }

			                .img-block-center{text-align:center !important;}

			                .logo-img-center
			                {
			                    float:inherit !important;
			                }

			                /* tmpl-11 preview */
			                .rnb-social-align{margin:0 auto !important; float:inherit !important;}

			                /* tmpl-11 preview */
			                .rnb-social-center{display:inline-block;}

			                /* tmpl-11 preview */
			                .social-text-spacing{margin-bottom:0px !important; padding-bottom:0px !important;}

			                /* tmpl-11 preview */
			                .social-text-spacing2{padding-top:15px !important;}

			            }@media screen{body{font-family:`KG Blank Space Space Sketch`,`Arial`,Helvetica,sans-serif;}}</style><!--[if gte mso 11]><style type="text/css">table{border-spacing: 0; }table td {border-collapse: separate;}</style><![endif]--><!--[if !mso]><!--><style type="text/css">table{border-spacing: 0;} table td {border-collapse: collapse;}</style> <!--<![endif]--><!--[if gte mso 15]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]--><!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]--></head><body>

			        	<table class="main-template" style="background-color: rgb(249, 250, 252);" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f9fafc" align="center">

			            <tbody><tr style="display:none !important; font-size:1px; mso-hide: all;"><td></td><td></td></tr>
			            <tr>
			                <td valign="top" align="center">
			                <!--[if gte mso 9]>
			                                <table align="center" border="0" cellspacing="0" cellpadding="0" width="590" style="width:590px;">
			                                <tr>
			                                <td align="center" valign="top" width="590" style="width:590px;">
			                                <![endif]-->
			                    <table class="templateContainer" style="max-width:590px!important; width: 590px;" width="100%" cellspacing="0" cellpadding="0" border="0">
			                <tbody><tr>

			                <td valign="top" align="center">

			                    <table class="rnb-del-min-width" style="min-width:590px;" name="Layout_0" id="Layout_0" width="100%" cellspacing="0" cellpadding="0" border="0">
			                        <tbody><tr>
			                            <td class="rnb-del-min-width" style="min-width:590px;" valign="top" align="center">
			                                <table width="100%" height="38" cellspacing="0" cellpadding="0" border="0">
			                                    <tbody><tr>
			                                        <td valign="top" height="38">
			                                            <img style="display:block; max-height:38px; max-width:20px;" alt="" src="http://www.loanwalle.com/assets/images/email/rnb_space.gif" width="20" height="38">
			                                        </td>
			                                    </tr>
			                                </tbody></table>
			                            </td>
			                        </tr>
			                    </tbody></table>
			                    </td>
			            </tr><tr>

			                <td valign="top" align="center">

			                    <div>
			                    
			                        <!--[if mso]>
			                        <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
			                        <tr>
			                        <![endif]-->
			                        
			                        <!--[if mso]>
			                        <td valign="top" width="590" style="width:590px;">
			                        <![endif]-->
			                        <table class="rnb-del-min-width" style="min-width:100%;" name="Layout_5" width="100%" cellspacing="0" cellpadding="0" border="0">
			                        <tbody><tr>
			                            <td class="rnb-del-min-width" valign="top" align="center">
			                                <table class="rnb-container" style="background-color: rgb(255, 255, 255); padding-left: 20px; padding-right: 20px; border-collapse: separate; border-radius: 0px; border-bottom: 0px none rgb(200, 200, 200);" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">

			                                                <tbody><tr>
			                                                    <td style="font-size:1px; line-height:0px;" height="20">&nbsp;</td>
			                                                </tr>
			                                                <tr>
			                                                    <td class="rnb-container-padding" valign="top" align="left">

			                                                        <table class="rnb-columns-container" width="100%" cellspacing="0" cellpadding="0" border="0">
			                                                            <tbody><tr>
			                                                                <td class="rnb-force-col" style="padding-right: 0px;" valign="top">

			                                                                    <table valign="top" class="rnb-col-1" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">

			                                                                        <tbody><tr>
			                                                                            <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;"><div>Dear '.strtoupper($name).',
			        <div><strong>LAN: '.$lan.'</strong></div>
			        </div>
			        </td>
			                                                                </tr>
			                                                                </tbody></table>

			                                                            </td></tr>
			                                                </tbody></table></td>
			                                        </tr>
			                                        <tr>
			                                            <td style="font-size:1px; line-height:0px" height="0">&nbsp;</td>
			                                        </tr>
			                                    </tbody></table>
			                    </td>
			                </tr>
			            </tbody></table><!--[if mso]>
			                </td>
			                <![endif]-->
			                
			                <!--[if mso]>
			                </tr>
			                </table>
			                <![endif]-->

			            </div></td>
			    	</tr><tr>

			        <td valign="top" align="center">

			            <div>
			                
			                <!--[if mso]>
			                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
			                <tr>
			                <![endif]-->
			                
			                <!--[if mso]>
			                <td valign="top" width="590" style="width:590px;">
			                <![endif]-->
			                <table class="rnb-del-min-width" style="min-width:100%;" name="Layout_2" id="Layout_2" width="100%" cellspacing="0" cellpadding="0" border="0">
			                <tbody><tr>
			                    <td class="rnb-del-min-width" valign="top" align="center">
			                        <table class="rnb-container" style="max-width: 100%; min-width: 100%; table-layout: fixed; background-color: rgb(255, 255, 255); border-radius: 0px; border-collapse: separate; padding-left: 20px; padding-right: 20px;" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
			                            <tbody><tr>
			                                <td style="font-size:1px; line-height:0px;" height="20">&nbsp;</td>
			                            </tr>
			                            <tr>
			                                <td class="rnb-container-padding" valign="top" align="left">

			                                    <table class="rnb-columns-container" width="100%" cellspacing="0" cellpadding="0" border="0">
			                                        <tbody><tr>
			                                            <td class="rnb-force-col" style="padding-right: 0px;" width="550" valign="top">
			                                                <table valign="top" class="rnb-col-1" width="550" cellspacing="0" cellpadding="0" border="0" align="left">
			                                                    <tbody><tr>
			                                                        <td class="img-block-center" width="100%" valign="top" align="left">
			                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
			                                                            <tbody>
			                                                                <tr>
			                                                                    <td class="img-block-center" width="100%" valign="top" align="left">
			                                                                        <table style="display: inline-block;" cellspacing="0" cellpadding="0" border="0">
			                                                                            <tbody><tr>
			                                                                                <td>
			                                                                                    <div style="border-top:0px None #000;border-right:0px None #000;border-bottom:0px None #000;border-left:0px None #000;display:inline-block;"><div><img alt="" class="rnb-col-1-img" src="http://www.loanwalle.com/assets/images/email/5cbab562126376462121161e.png" style="vertical-align: top; max-width: 1000px; float: left;" width="550" vspace="0" hspace="0" border="0"></div><div style="clear:both;"></div>
			                                                                                    </div>
			                                                                            </td>
			                                                                            </tr>
			                                                                        </tbody></table>

			                                                                    </td>
			                                                                </tr>
			                                                            </tbody>
			                                                        </table></td>
			                                                    </tr><tr>
			                                                        <td class="col_td_gap" style="font-size:1px; line-height:0px;" height="10">&nbsp;</td>
			                                                    </tr><tr>
			                                                        <td style="font-size:24px; font-family:`Arial`,Helvetica,sans-serif; color:#3c4858; text-align:left;">
			                                                            <span style="color:#3c4858; "><strong><span style="font-size:18px;">We are pleased to inform you that your loan for Rs'.$this->input->post('loanapproved').'/- has been sanctioned with the following terms:</span></strong></span></td>
			                                                    </tr><tr>
			                                                        <td class="col_td_gap" style="font-size:1px; line-height:0px;" height="10">&nbsp;</td>
			                                                    </tr><tr>
			                                                        <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                            <div></div>
			                                                        </td>
			                                                    </tr>
			                                                    </tbody></table>

			                                                </td></tr>
			                                    </tbody></table></td>
			                            </tr>
			                            <tr>
			                                <td style="font-size:1px; line-height:0px;" height="0">&nbsp;</td>
			                            </tr>
			                        </tbody></table>

			                    </td>
			                </tr>
			            </tbody></table><!--[if mso]>
			                </td>
			                <![endif]-->
			                
			                <!--[if mso]>
			                </tr>
			                </table>
			                <![endif]-->
			                
			            </div></td>
			    	</tr><tr>

			        <td valign="top" align="center">

			            <div>
			                
			                <!--[if mso 15]>
			                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
			                <tr>
			                <![endif]-->
			                
			                <!--[if mso 15]>
			                <td valign="top" width="590" style="width:590px;">
			                <![endif]-->
			                <table class="rnb-del-min-width" style="min-width:100%;" name="Layout_9" id="Layout_9" width="100%" cellspacing="0" cellpadding="0" border="0">
			                <tbody><tr>
			                    <td class="rnb-del-min-width" valign="top" align="center">
			                        <table class="rnb-container" style="max-width: 100%; min-width: 100%; table-layout: fixed; background-color: rgb(255, 255, 255); border-radius: 0px; border-collapse: separate; padding: 20px;" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
			                            <tbody><tr>
			                                <td class="rnb-container-padding" valign="top" align="left">

			                                    <table class="rnb-columns-container" width="100%" cellspacing="0" cellpadding="0" border="0">
			                                        <tbody><tr>

			                                            <td class="rnb-force-col img-block-center" style="padding-right: 20px;" width="180" valign="top">

			                                                <table valign="top" class="rnb-col-2-noborder-onright" width="180" cellspacing="0" cellpadding="0" border="0" align="left">


			                                                    <tbody><tr>
			                                                        <td style="line-height: 0px;" class="img-block-center" width="100%" valign="top" align="left">
			                                                            <div style="border-top:0px none #000;border-right:0px None #000;border-bottom:0px None #000;border-left:0px None #000;display:inline-block;"><div><img alt="" style="vertical-align:top; float: left; width:180px;max-width:1000px !important; " class="rnb-col-2-img-side-xl" src="http://www.loanwalle.com/assets/images/email/5cbab80d1263764bfe698abf.png" width="180" vspace="0" hspace="0" border="0"></div><div style="clear:both;"></div></div></td>
			                                                    </tr>
			                                                    </tbody></table>
			                                                </td><td class="rnb-force-col" valign="top">

			                                                <table valign="top" class="rnb-last-col-2" width="350" cellspacing="0" cellpadding="0" border="0" align="left">

			                                                    <tbody><tr>
			                                                        <td class="rnb-mbl-float-none" style="font-size:14px; font-family:Arial,Helvetica,sans-serif;color:#3c4858;float:right;width:350px; line-height: 21px;"><div style="line-height:24px;"><span style="font-size:15px;">1. Loan amount: Rs'.$this->input->post('loanapproved').'/-<br>
			                                    2. Interest: '.$this->input->post('roi').'% (percent) per day<br>
			                                    3. Payback period: '.$tenure.' days<br>
			                                    4. Payback date: '.date("F jS, Y", strtotime($repayment_date)).'<br>
			                                    5. Payback amount. with interest: Rs '.$repay.' /-</span></div>

			                                    </td>       
			                                                    </tr>
			                                                    </tbody></table>
			                                                </td>

			                                            </tr></tbody></table></td>
			                            </tr>
			                        </tbody></table>

			                    </td>
			                </tr>
			            </tbody></table>
			            <!--[if mso 15]>
			                </td>
			                <![endif]-->

			                <!--[if mso 15]>
			                </tr>
			                </table>
			                <![endif]-->
			            
			        </div></td>
			    	</tr><tr>

			        <td valign="top" align="center">

			            <div>
			            
			                <!--[if mso]>
			                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
			                <tr>
			                <![endif]-->
			                
			                <!--[if mso]>
			                <td valign="top" width="590" style="width:590px;">
			                <![endif]-->
			                <table class="rnb-del-min-width" style="min-width:100%;" name="Layout_8" width="100%" cellspacing="0" cellpadding="0" border="0">
			                <tbody><tr>
			                    <td class="rnb-del-min-width" valign="top" align="center">
			                        <table class="rnb-container" style="background-color: rgb(255, 255, 255); padding-left: 20px; padding-right: 20px; border-collapse: separate; border-radius: 0px; border-bottom: 0px none rgb(200, 200, 200);" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">

			                                        <tbody><tr>
			                                            <td style="font-size:1px; line-height:0px;" height="20">&nbsp;</td>
			                                        </tr>
			                                        <tr>
			                                            <td class="rnb-container-padding" valign="top" align="left">

			                                                <table class="rnb-columns-container" width="100%" cellspacing="0" cellpadding="0" border="0">
			                                                    <tbody><tr>
			                                                        <td class="rnb-force-col" style="padding-right: 0px;" valign="top">

			                                                            <table valign="top" class="rnb-col-1" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">

			                                                                <tbody><tr>
			                                                                    <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;"><div><strong><span style="font-size:18px;">Our executive will call you soon and fix a time to visit your residence/office to carry out a simple verification and get an agreement signed.:</span></strong></div>
			                                                                    </td>
			                                                                </tr>
			                                                                </tbody></table>

			                                                            </td></tr>
			                                                </tbody></table></td>
			                                        </tr>
			                                        <tr>
			                                            <td style="font-size:1px; line-height:0px" height="20">&nbsp;</td>
			                                        </tr>
			                                    </tbody></table>
			                    </td>
			                </tr>
			            </tbody></table><!--[if mso]>
			                </td>
			                <![endif]-->
			                
			                <!--[if mso]>
			                </tr>
			                </table>
			                <![endif]-->

			            </div></td>
			    	</tr><tr>

			        <td valign="top" align="center">

			            <div>
			                
			                <!--[if mso 15]>
			                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
			                <tr>
			                <![endif]-->
			                
			                <!--[if mso 15]>
			                <td valign="top" width="590" style="width:590px;">
			                <![endif]-->
			                <table class="rnb-del-min-width" style="min-width:100%;" name="Layout_6" id="Layout_6" width="100%" cellspacing="0" cellpadding="0" border="0">
			                <tbody><tr>
			                    <td class="rnb-del-min-width" valign="top" align="center">
			                        <table class="rnb-container" style="max-width: 100%; min-width: 100%; table-layout: fixed; background-color: rgb(255, 255, 255); border-radius: 0px; border-collapse: separate; padding: 20px;" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
			                            <tbody><tr>
			                                <td class="rnb-container-padding" valign="top" align="left">

			                                    <table class="rnb-columns-container" width="100%" cellspacing="0" cellpadding="0" border="0">
			                                        <tbody><tr>

			                                            <td class="rnb-force-col" valign="top">

			                                                <table valign="top" class="rnb-last-col-2" width="350" cellspacing="0" cellpadding="0" border="0" align="left">

			                                                    <tbody><tr>
			                                                        <td class="rnb-mbl-float-none" style="font-size:14px; font-family:Arial,Helvetica,sans-serif;color:#3c4858;float:left;width:350px; line-height: 21px;"><div><span style="font-size:15px;">1. One signed cheque of the bank account<br>
			                                                        2. An admin fee of Rs.'.$this->input->post('processing_fee').'<br>
			                                                        3. Co-applicant KYC (PAN, Adhaar, Voter Id Card) -</span></div>

			                                                        <div><span style="font-size:15px;">&nbsp;&nbsp;&nbsp; wherever applicable<br>
			                                                        4. Residence proof (Electricity Bill, Water Bill, Rent</span></div>

			                                                        <div><span style="font-size:15px;">&nbsp;&nbsp;&nbsp; Agreement, Passport, etc.)</span></div>
			                                                        </td>
			                                                    </tr>
			                                                    </tbody></table>
			                                                </td>

			                                            <td class="msib-right-img rnb-force-col img-block-center" style="padding-left: 20px;" width="180" valign="top">

			                                                <table valign="top" class="rnb-col-2-noborder-onleft" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">

			                                                    <tbody><tr>
			                                                        <td style="line-height: 0px;" class="img-block-center" width="100%" valign="top" align="left">
			                                                            <div style="border-top:0px none #000;border-right:0px None #000;border-bottom:0px None #000;border-left:0px None #000;display:inline-block;"><div>
			                                                               <img alt="" style="vertical-align:top; float: left; max-width:1000px !important; " class="rnb-col-2-img-side-xl" src="http://www.loanwalle.com/assets/images/email/5cbac1df88069c4adf6c2689.png" width="180" vspace="0" hspace="0" border="0"></div><div style="clear:both;"></div>
			                                                                </div></td>
			                                                    </tr>
			                                                    </tbody></table>
			                                                </td></tr></tbody></table></td>
			                            </tr>
			                        </tbody></table>

			                    </td>
			                </tr>
			            </tbody></table>
			            <!--[if mso 15]>
			                </td>
			                <![endif]-->

			                <!--[if mso 15]>
			                </tr>
			                </table>
			                <![endif]-->
			            
			        </div></td>
			    	</tr><tr>

			        <td valign="top" align="center">

			            <div>
			                
			                <!--[if mso]>
			                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
			                <tr>
			                <![endif]-->
			                
			                <!--[if mso]>
			                <td valign="top" width="590" style="width:590px;">
			                <![endif]-->
			                <table class="rnb-del-min-width" style="min-width:100%;" name="Layout_15" id="Layout_15" width="100%" cellspacing="0" cellpadding="0" border="0">
			                <tbody><tr>
			                    <td class="rnb-del-min-width" valign="top" align="center">
			                        <table class="rnb-container" style="max-width: 100%; min-width: 100%; table-layout: fixed; background-color: rgb(255, 255, 255); border-radius: 0px; border-collapse: separate; padding-left: 20px; padding-right: 20px;" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
			                            <tbody><tr>
			                                <td style="font-size:1px; line-height:0px;" height="20">&nbsp;</td>
			                            </tr>
			                            <tr>
			                                <td class="rnb-container-padding" valign="top" align="left">

			                                    <table class="rnb-columns-container" width="100%" cellspacing="0" cellpadding="0" border="0">
			                                        <tbody><tr>
			                                            <td class="rnb-force-col" style="padding-right: 0px;" width="550" valign="top">
			                                                <table valign="top" class="rnb-col-1" width="550" cellspacing="0" cellpadding="0" border="0" align="left">
			                                                    <tbody><tr>
			                                                        <td class="img-block-center" width="100%" valign="top" align="left">
			                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
			                                                            <tbody>
			                                                                <tr>
			                                                                    <td class="img-block-center" width="100%" valign="top" align="left">
			                                                                        <table style="display: inline-block;" cellspacing="0" cellpadding="0" border="0">
			                                                                            <tbody><tr>
			                                                                                <td>
			                                                                                    <div style="border-top:0px None #000;border-right:0px None #000;border-bottom:0px None #000;border-left:0px None #000;display:inline-block;"><div><img alt="" class="rnb-col-1-img" src="http://www.loanwalle.com/assets/images/email/5cbdfd614e348ee2e5284f5a.png" style="vertical-align: top; max-width: 1200px; float: left;" width="550" vspace="0" hspace="0" border="0"></div><div style="clear:both;"></div>
			                                                                                    </div>
			                                                                            </td>
			                                                                            </tr>
			                                                                        </tbody></table>

			                                                                    </td>
			                                                                </tr>
			                                                            </tbody>
			                                                        </table></td>
			                                                    </tr><tr>
			                                                        <td class="col_td_gap" style="font-size:1px; line-height:0px;" height="10">&nbsp;</td>
			                                                    </tr><tr>
			                                                        <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                            <div></div>
			                                                        </td>
			                                                    </tr>
			                                                    </tbody></table>

			                                                </td></tr>
			                                    </tbody></table></td>
			                            </tr>
			                            <tr>
			                                <td style="font-size:1px; line-height:0px;" height="0">&nbsp;</td>
			                            </tr>
			                        </tbody></table>

			                    </td>
			                </tr>
			            </tbody></table><!--[if mso]>
			                </td>
			                <![endif]-->
			                
			                <!--[if mso]>
			                </tr>
			                </table>
			                <![endif]-->
			                
			            </div></td>
			    	</tr><tr>

			        <td valign="top" align="center">

			            <div>
			                
			                <table class="rnb-del-min-width rnb-tmpl-width" style="min-width:590px;" name="Layout_" id="Layout_" width="100%" cellspacing="0" cellpadding="0" border="0">
			                    <tbody><tr>
			                        <td class="rnb-del-min-width" style="min-width:590px; background-color: #ffffff;" valign="top" bgcolor="#ffffff" align="center">
			                            <table class="rnb-container" style="background-color: rgb(255, 255, 255);" width="590" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center">
			                                <tbody><tr>
			                                    <td style="font-size:1px; line-height:0px;" height="20">&nbsp;</td>
			                                </tr>
			                                <tr>
			                                    <td class="rnb-container-padding" style="font-size: 14px; font-family: Arial,Helvetica,sans-serif; color: #888888;" valign="top" align="center">

			                                        <table class="rnb-columns-container" width="100%" cellspacing="0" cellpadding="0" border="0">
			                                            <tbody><tr>
			                                                <td class="rnb-force-col rnb-social-width2" style="mso-padding-alt: 0 20px 0 20px; padding-right: 28px; padding-left: 28px;" valign="top">

			                                                    <table valign="top" class="rnb-last-col-2" width="533" cellspacing="0" cellpadding="0" border="0" align="center">

			                                                        <tbody><tr>
			                                                            <td valign="top">
			                                                                <table class="rnb-social-align2" cellspacing="0" cellpadding="0" border="0" align="center">
			                                                                    <tbody><tr>
			                                                                        <td style="line-height: 0px;" class="rnb-text-center" ng-init="width=setSocialIconsBlockWidth(item)" width="533" valign="middle" align="center">
			                                                                            <!--[if mso]>
			                                                                            <table align="center" border="0" cellspacing="0" cellpadding="0">
			                                                                            <tr>
			                                                                            <![endif]-->

			                                                                                <div class="rnb-social-center" style="display: inline-block;">
			                                                                                <!--[if mso]>
			                                                                                <td align="center" valign="top">
			                                                                                <![endif]-->
			                                                                                    <table style="float:left; display: inline-block" cellspacing="0" cellpadding="0" border="0" align="left">
			                                                                                        <tbody><tr>
			                                                                                            <td style="padding:0px 5px 5px 0px; mso-padding-alt: 0px 4px 5px 0px;" align="left">
			                                                                                <span style="color:#ffffff; font-weight:normal;">
			                                                                                    <a target="_blank" href="https://www.facebook.com/loanwalle2019/"><img alt="Facebook" style="vertical-align:top;" target="_blank" src="http://www.loanwalle.com/assets/images/email/rnb_ico_fb.png" vspace="0" hspace="0" border="0"></a></span>
			                                                                                            </td></tr></tbody></table>
			                                                                                <!--[if mso]>
			                                                                                </td>
			                                                                                <![endif]-->
			                                                                                </div><div class="rnb-social-center" style="display: inline-block;">
			                                                                                <!--[if mso]>
			                                                                                <td align="center" valign="top">
			                                                                                <![endif]-->
			                                                                                    <table style="float:left; display: inline-block" cellspacing="0" cellpadding="0" border="0" align="left">
			                                                                                        <tbody><tr>
			                                                                                            <td style="padding:0px 5px 5px 0px; mso-padding-alt: 0px 4px 5px 0px;" align="left">
			                                                                                <span style="color:#ffffff; font-weight:normal;">
			                                                                                    <a target="_blank" href="https://twitter.com/loanwalle1"><img alt="Twitter" style="vertical-align:top;" target="_blank" src="http://www.loanwalle.com/assets/images/email/rnb_ico_tw.png" vspace="0" hspace="0" border="0"></a></span>
			                                                                                            </td></tr></tbody></table>
			                                                                                <!--[if mso]>
			                                                                                </td>
			                                                                                <![endif]-->
			                                                                                </div><div class="rnb-social-center" style="display: inline-block;">
			                                                                                <!--[if mso]>
			                                                                                <td align="center" valign="top">
			                                                                                <![endif]-->
			                                                                                    <table style="float:left; display: inline-block" cellspacing="0" cellpadding="0" border="0" align="left">
			                                                                                        <tbody><tr>
			                                                                                            <td style="padding:0px 5px 5px 0px; mso-padding-alt: 0px 4px 5px 0px;" align="left">
			                                                                                <span style="color:#ffffff; font-weight:normal;">
			                                                                                    <a target="_blank" href="https://www.youtube.com/channel/UC0XGjHs-oPeZxa1sqeE_q_w?view_as=subscriber"><img alt="YouTube" style="vertical-align:top;" target="_blank" src="http://www.loanwalle.com/assets/images/email/rnb_ico_yt.png" vspace="0" hspace="0" border="0"></a></span>
			                                                                                            </td></tr></tbody></table>
			                                                                                <!--[if mso]>
			                                                                                </td>
			                                                                                <![endif]-->
			                                                                                </div><!--[if mso]>
			                                                                            </tr>
			                                                                            </table>
			                                                                            <![endif]-->
			                                                                        </td>
			                                                                    </tr>
			                                                                </tbody></table>
			                                                            </td>
			                                                        </tr>
			                                                        </tbody></table>
			                                                    </td>
			                                            </tr>
			                                        </tbody></table></td>
			                                </tr>
			                                <tr>
			                                    <td style="font-size:1px; line-height:0px;" height="20">&nbsp;</td>
			                                </tr>
			                            </tbody></table>

			                        </td>
			                    </tr></tbody></table>
			                
			            </div></td>
			    	</tr><tr>

			        <td valign="top" align="center">

			            <div>
			            
			                <!--[if mso]>
			                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
			                <tr>
			                <![endif]-->
			                
			                <!--[if mso]>
			                <td valign="top" width="590" style="width:590px;">
			                <![endif]-->
			                <table class="rnb-del-min-width" style="min-width:100%;" name="Layout_10" width="100%" cellspacing="0" cellpadding="0" border="0">
			                <tbody><tr>
			                    <td class="rnb-del-min-width" valign="top" align="center">
			                        <table class="rnb-container" style="background-color: rgb(255, 255, 255); padding-left: 20px; padding-right: 20px; border-collapse: separate; border-radius: 0px; border-bottom: 0px none rgb(200, 200, 200);" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">

			                                        <tbody><tr>
			                                            <td style="font-size:1px; line-height:0px;" height="0">&nbsp;</td>
			                                        </tr>
			                                        <tr>
			                                            <td class="rnb-container-padding" valign="top" align="left">

			                                                <table class="rnb-columns-container" width="100%" cellspacing="0" cellpadding="0" border="0">
			                                                    <tbody><tr>
			                                                        <td class="rnb-force-col" style="padding-right: 0px;" valign="top">

			                                                            <table valign="top" class="rnb-col-1" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">

			                                                                <tbody>
			                                                                 <tr>
			                                                                    <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;"><div style="text-align: center;"><strong>Please make sure that the due amount is paid on '.date("F jS, Y", strtotime($repayment_date)).'. This will ensure your CIBIL record is not affected and you are free to avail loan again.</strong></div>
										</td>
			                                                                </tr>
			                                                                <tr>
			                                                                    <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;"><div style="text-align: center;"><strong>For any clarification please feel free to call</strong></div>
											</td>
			                                                                </tr>
			                                                                
			                                                               
			                                                                </tbody></table>

			                                                            </td></tr>
			                                                </tbody></table></td>
			                                        </tr>
			                                        <tr>
			                                            <td style="font-size:1px; line-height:0px" height="0">&nbsp;</td>
			                                        </tr>
			                                    </tbody></table>
			                    </td>
			                </tr>
			            </tbody></table><!--[if mso]>
			                </td>
			                <![endif]-->
			                
			                <!--[if mso]>
			                </tr>
			                </table>
			                <![endif]-->

			            </div></td>
			    	</tr><tr>

			        <td valign="top" align="center">

			            <div>
			                
			                <!--[if mso]>
			                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
			                <tr>
			                <![endif]-->
			                
			                <!--[if mso]>
			                <td valign="top" width="590" style="width:590px;">
			                <![endif]-->
			                <table class="rnb-del-min-width" style="min-width:590px;" name="Layout_11" id="Layout_11" width="100%" cellspacing="0" cellpadding="0" border="0">
			                <tbody><tr>
			                    <td class="rnb-del-min-width" style="min-width:590px;" valign="top" align="center">
			                        <table class="mso-button-block rnb-container" style="background-color: rgb(255, 255, 255); border-radius: 0px; padding-left: 20px; padding-right: 20px; border-collapse: separate;" width="100%" cellspacing="0" cellpadding="0" border="0">
			                            <tbody><tr>
			                                <td style="font-size:1px; line-height:0px;" height="10">&nbsp;</td>
			                            </tr>
			                            <tr>
			                                <td class="rnb-container-padding" valign="top" align="left">

			                                    <table class="rnb-columns-container" width="100%" cellspacing="0" cellpadding="0" border="0">
			                                        <tbody><tr>
			                                            <td class="rnb-force-col" valign="top">

			                                                <table valign="top" class="rnb-col-1" width="550" cellspacing="0" cellpadding="0" border="0" align="center">

			                                                    <tbody><tr>
			                                                        <td valign="top">
			                                                            <table class="rnb-btn-col-content" style="margin:auto; border-collapse: separate;" cellspacing="0" cellpadding="0" border="0" align="center">
			                                                                <tbody><tr>
			                                                                    <td style="font-size:18px; font-family:`Trebuchet MS`,Helvetica,sans-serif; color:#ffffff; font-weight:normal; padding-left:20px; padding-right:20px; vertical-align: middle; background-color:#3499db;border-radius:4px;border-top:0px None #000;border-right:0px None #000;border-bottom:0px None #000;border-left:0px None #000;" width="auto" valign="middle" height="40" bgcolor="#3499db" align="center">
			                                                                        <span style="color:#ffffff; font-weight:normal;">
			                                                                                <a style="text-decoration:none; color:#ffffff; font-weight:normal;" target="_blank"><strong>9999999341</strong></a>
			                                                                            </span>
			                                                                    </td>
			                                                                </tr></tbody></table>
			                                                                <table valign="top" class="rnb-col-1" width="100%" cellspacing="0" cellpadding="0" border="1"  style="text-align: center;margin-top: 10px;">
			                                                            <tbody>
			                                                            <tr>
			                                                            <td colspan="2" style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                                <div><strong>Please pay your admin fee and loan repayment :-</strong></div>
			                                                            </td>
			                                                            </tr>
			                                                            <tr>
			                                                            <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                                <div><strong>Beneficiary Name</strong></div>
			                                                            </td>
			                                                            <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                                <div><strong>Naman Finlease Pvt. Ltd.</strong></div>
			                                                            </td>
			                                                            </tr>
			                                                            <tr>
			                                                            <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                                <div><strong>Bank Name</strong></div>
			                                                            </td>
			                                                            <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                                <div><strong>IndusInd Bank</strong></div>
			                                                            </td>
			                                                            </tr>
			                                                            <tr>
			                                                            <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                                <div><strong>Account Number</strong></div>
			                                                            </td>
			                                                            <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                                <div><strong>201002831962</strong></div>
			                                                            </td>
			                                                            </tr>
			                                                            <tr>
			                                                            <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                                <div><strong>IFSC</strong></div>
			                                                            </td>
			                                                            <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                                <div><strong>INDB0001383</strong></div>
			                                                            </td>
			                                                            </tr>
			                                                            <tr>
			                                                            <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                                <div><strong>Branch Address</strong></div>
			                                                            </td>
			                                                            <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                                <div><strong>IndusInd bank, Vasant Vihar Branch, New Delhi</strong></div>
			                                                            </td>
			                                                            </tr>
			                                                            <tr>
			                                                            <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                                <div><strong>Account Type</strong></div>
			                                                            </td>
			                                                            <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
			                                                                <div><strong>Current Account</strong></div>
			                                                            </td>
			                                                            </tr>
			                                                            </tbody>
			                                                            </table>
			                                                        </td>
			                                                    </tr>
			                                                    </tbody></table>
			                                                </td>
			                                        </tr>
			                                    </tbody></table></td>
			                            </tr>
			                            <tr>
			                                <td style="font-size:1px; line-height:0px;" height="20">&nbsp;</td>
			                            </tr>
			                        </tbody></table>

			                    </td>
			                </tr>
			            </tbody></table>
			            <!--[if mso]>
			                </td>
			                <![endif]-->
			                
			                <!--[if mso]>
			                </tr>
			                </table>
			                <![endif]-->
			                
			            </div></td>
			    	</tr><tr>

			        <td valign="top" align="center">

			            <div>
			            
			                <!--[if mso]>
			                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
			                <tr>
			                <![endif]-->
			                
			                <!--[if mso]>
			                <td valign="top" width="590" style="width:590px;">
			                <![endif]-->
			                <table class="rnb-del-min-width" style="min-width:100%;" name="Layout_12" width="100%" cellspacing="0" cellpadding="0" border="0">
			                <tbody><tr>
			                    <td class="rnb-del-min-width" valign="top" align="center">
			                        <table class="rnb-container" style="background-color: rgb(255, 255, 255); padding-left: 20px; padding-right: 20px; border-collapse: separate; border-radius: 0px; border-bottom: 0px none rgb(200, 200, 200);" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">

			                                        <tbody><tr>
			                                            <td style="font-size:1px; line-height:0px;" height="0">&nbsp;</td>
			                                        </tr>
			                                        <tr>
			                                            <td class="rnb-container-padding" valign="top" align="left">

			                                                <table class="rnb-columns-container" width="100%" cellspacing="0" cellpadding="0" border="0">
			                                                    <tbody><tr>
			                                                        <td class="rnb-force-col" style="padding-right: 0px;" valign="top">

			                                                            <table valign="top" class="rnb-col-1" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">

			                                                                <tbody><tr>
			                                                                    <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;"><div><strong>Thanks &amp; Regards<br><br>
			                                                                        '.$queryUser[0]->name.'<br>Credit Manager<br>'.$queryUser[0]->mobile.'<br>Team Loanwalle</strong></div>

			                                        <div>&nbsp;</div>

			                                        <div style="text-align: right;">&nbsp;</div>

			                                        <div style="text-align: right;">&nbsp;</div>

			                                        <div style="text-align: center;"><span style="font-size:10px;"><span style="color:#FF0000;"><span style="font-size:12px;">* </span></span>Delaying repayment beyond </span><span style="font-size:10px;">the due </span><span style="font-size:10px;">date will attract a penal interest of '. $this->input->post('roi')*2 .' percent per day.</span></div>
			                                        </td>
			                                                                </tr>
			                                                                </tbody></table>

			                                                            </td></tr>
			                                                </tbody></table></td>
			                                        </tr>
			                                        <tr>
			                                            <td style="font-size:1px; line-height:0px" height="20">&nbsp;</td>
			                                        </tr>
			                                    </tbody></table>
			                    </td>
			                </tr>
			            </tbody></table><!--[if mso]>
			                </td>
			                <![endif]-->
			                
			                <!--[if mso]>
			                </tr>
			                </table>
			                <![endif]-->

			            </div></td>
			    	</tr><tr>

			        <td valign="top" align="center">

			            <div>
			                
			                <table class="rnb-del-min-width rnb-tmpl-width" style="min-width:590px;" name="Layout_4" id="Layout_4" width="100%" cellspacing="0" cellpadding="0" border="0">
			                    <tbody><tr>
			                        <td class="rnb-del-min-width" style="min-width:590px;" valign="top" align="center">
			                            <table style="padding-right: 20px; padding-left: 20px; background-color: rgb(255, 255, 255);" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center">
			                                <tbody><tr>
			                                    <td style="font-size:1px; line-height:0px;" height="20">&nbsp;</td>
			                                </tr>
			                                <tr>
			                                    <td style="font-size:14px; color:#888888; font-weight:normal; text-align:center; font-family:Arial,Helvetica,sans-serif;">
			                                        <div><div>&copy; 2019 loanwalle.com</div>
							</div>
			                                    </td></tr>
			                                <tr>
			                                    <td style="font-size:1px; line-height:0px;" height="20">&nbsp;</td>
			                                </tr>
			                            </tbody></table>
			                        </td>
			                    </tr>
			                </tbody></table>
			                
			            </div></td>
			    	</tr></tbody></table>
			            <!--[if gte mso 9]>
			                        </td>
			                        </tr>
			                        </table>
			                        <![endif]-->
			                        </td>
			        </tr>
			        </tbody></table>

					</body></html>';


					$msg1='
					<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head><meta http-equiv="X-UA-Compatible" content="IE=edge" /><meta name="viewport" content="width=device-width, initial-scale=1" /><meta name="x-apple-disable-message-reformatting" /><meta name="apple-mobile-web-app-capable" content="yes" /><meta name="apple-mobile-web-app-status-bar-style" content="black" /><meta name="format-detection" content="telephone=no" /><title></title><link href="https://www.dafont.com/kg-blank-space.font" rel="stylesheet" type="text/css" /><style type="text/css">
					        /* Resets */
					        .ReadMsgBody { width: 100%; background-color: #ebebeb;}
					        .ExternalClass {width: 100%; background-color: #ebebeb;}
					        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
					        a[x-apple-data-detectors]{
					            color:inherit !important;
					            text-decoration:none !important;
					            font-size:inherit !important;
					            font-family:inherit !important;
					            font-weight:inherit !important;
					            line-height:inherit !important;
					        }        
					        body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
					        body {margin:0; padding:0;}
					        .yshortcuts a {border-bottom: none !important;}
					        .rnb-del-min-width{ min-width: 0 !important; }

					        /* Add new outlook css start */
					        .templateContainer{
					            max-width:590px !important;
					            width:auto !important;
					        }
					        /* Add new outlook css end */

					        /* Image width by default for 3 columns */
					        img[class="rnb-col-3-img"] {
					        max-width:170px;
					        }

					        /* Image width by default for 2 columns */
					        img[class="rnb-col-2-img"] {
					        max-width:264px;
					        }

					        /* Image width by default for 2 columns aside small size */
					        img[class="rnb-col-2-img-side-xs"] {
					        max-width:180px;
					        }

					        /* Image width by default for 2 columns aside big size */
					        img[class="rnb-col-2-img-side-xl"] {
					        max-width:350px;
					        }

					        /* Image width by default for 1 column */
					        img[class="rnb-col-1-img"] {
					        max-width:550px;
					        }

					        /* Image width by default for header */
					        img[class="rnb-header-img"] {
					        max-width:590px;
					        }

					        /* Ckeditor line-height spacing */
					        .rnb-force-col p, ul, ol{margin:0px!important;}
					        .rnb-del-min-width p, ul, ol{margin:0px!important;}

					        /* tmpl-2 preview */
					        .rnb-tmpl-width{ width:100%!important;}

					        /* tmpl-11 preview */
					        .rnb-social-width{padding-right:15px!important;}

					        /* tmpl-11 preview */
					        .rnb-social-align{float:right!important;}

					        /* Ul Li outlook extra spacing fix */
					        li{mso-margin-top-alt: 0; mso-margin-bottom-alt: 0;}        

					        /* Outlook fix */
					        table {mso-table-lspace:0pt; mso-table-rspace:0pt;}
					    
					        /* Outlook fix */
					        table, tr, td {border-collapse: collapse;}

					        /* Outlook fix */
					        p,a,li,blockquote {mso-line-height-rule:exactly;} 

					        /* Outlook fix */
					        .msib-right-img { mso-padding-alt: 0 !important;}

					        @media only screen and (min-width:590px){
					        /* mac fix width */
					        .templateContainer{width:590px !important;}
					        }

					        @media screen and (max-width: 360px){
					        /* yahoo app fix width "tmpl-2 tmpl-10 tmpl-13" in android devices */
					        .rnb-yahoo-width{ width:360px !important;}
					        }

					        @media screen and (max-width: 380px){
					        /* fix width and font size "tmpl-4 tmpl-6" in mobile preview */
					        .element-img-text{ font-size:24px !important;}
					        .element-img-text2{ width:230px !important;}
					        .content-img-text-tmpl-6{ font-size:24px !important;}
					        .content-img-text2-tmpl-6{ width:220px !important;}
					        }

					        @media screen and (max-width: 480px) {
					        td[class="rnb-container-padding"] {
					        padding-left: 10px !important;
					        padding-right: 10px !important;
					        }

					        /* force container nav to (horizontal) blocks */
					        td.rnb-force-nav {
					        display: inherit;
					        }
					        }

					        @media only screen and (max-width: 600px) {

					        /* center the address &amp; social icons */
					        .rnb-text-center {text-align:center !important;}

					        /* force container columns to (horizontal) blocks */
					        td.rnb-force-col {
					        display: block;
					        padding-right: 0 !important;
					        padding-left: 0 !important;
					        width:100%;
					        }

					        table.rnb-container {
					         width: 100% !important;
					        }

					        table.rnb-btn-col-content {
					        width: 100% !important;
					        }
					        table.rnb-col-3 {
					        /* unset table align="left/right" */
					        float: none !important;
					        width: 100% !important;

					        /* change left/right padding and margins to top/bottom ones */
					        margin-bottom: 10px;
					        padding-bottom: 10px;
					        /*border-bottom: 1px solid #eee;*/
					        }

					        table.rnb-last-col-3 {
					        /* unset table align="left/right" */
					        float: none !important;
					        width: 100% !important;
					        }

					        table[class~="rnb-col-2"] {
					        /* unset table align="left/right" */
					        float: none !important;
					        width: 100% !important;

					        /* change left/right padding and margins to top/bottom ones */
					        margin-bottom: 10px;
					        padding-bottom: 10px;
					        /*border-bottom: 1px solid #eee;*/
					        }

					        table.rnb-col-2-noborder-onright {
					        /* unset table align="left/right" */
					        float: none !important;
					        width: 100% !important;

					        /* change left/right padding and margins to top/bottom ones */
					        margin-bottom: 10px;
					        padding-bottom: 10px;
					        }

					        table.rnb-col-2-noborder-onleft {
					        /* unset table align="left/right" */
					        float: none !important;
					        width: 100% !important;

					        /* change left/right padding and margins to top/bottom ones */
					        margin-top: 10px;
					        padding-top: 10px;
					        }

					        table.rnb-last-col-2 {
					        /* unset table align="left/right" */
					        float: none !important;
					        width: 100% !important;
					        }

					        table.rnb-col-1 {
					        /* unset table align="left/right" */
					        float: none !important;
					        width: 100% !important;
					        }

					        img.rnb-col-3-img {
					        /**max-width:none !important;**/
					        width:100% !important;
					        }

					        img.rnb-col-2-img {
					        /**max-width:none !important;**/
					        width:100% !important;
					        }

					        img.rnb-col-2-img-side-xs {
					        /**max-width:none !important;**/
					        width:100% !important;
					        }

					        img.rnb-col-2-img-side-xl {
					        /**max-width:none !important;**/
					        width:100% !important;
					        }

					        img.rnb-col-1-img {
					        /**max-width:none !important;**/
					        width:100% !important;
					        }

					        img.rnb-header-img {
					        /**max-width:none !important;**/
					        width:100% !important;
					        margin:0 auto;
					        }

					        img.rnb-logo-img {
					        /**max-width:none !important;**/
					        width:100% !important;
					        }

					        td.rnb-mbl-float-none {
					        float:inherit !important;
					        }

					        .img-block-center{text-align:center !important;}

					        .logo-img-center
					        {
					            float:inherit !important;
					        }

					        /* tmpl-11 preview */
					        .rnb-social-align{margin:0 auto !important; float:inherit !important;}

					        /* tmpl-11 preview */
					        .rnb-social-center{display:inline-block;}

					        /* tmpl-11 preview */
					        .social-text-spacing{margin-bottom:0px !important; padding-bottom:0px !important;}

					        /* tmpl-11 preview */
					        .social-text-spacing2{padding-top:15px !important;}

					    }@media screen{body{font-family:`KG Blank Space Space Sketch`,`Arial`,Helvetica,sans-serif;}}</style><!--[if gte mso 11]><style type="text/css">table{border-spacing: 0; }table td {border-collapse: separate;}</style><![endif]--><!--[if !mso]><!--><style type="text/css">table{border-spacing: 0;} table td {border-collapse: collapse;}</style> <!--<![endif]--><!--[if gte mso 15]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]--><!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]--></head><body>

						<table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" class="main-template" bgcolor="#f9fafc" style="background-color: rgb(249, 250, 252);">

					    <tbody><tr style="display:none !important; font-size:1px; mso-hide: all;"><td></td><td></td></tr>
					    <tr>
					        <td align="center" valign="top">
					        <!--[if gte mso 9]>
					                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="590" style="width:590px;">
					                        <tr>
					                        <td align="center" valign="top" width="590" style="width:590px;">
					                        <![endif]-->
					            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="max-width:590px!important; width: 590px;">
					        <tbody><tr>

					        <td align="center" valign="top">

					            <table class="rnb-del-min-width" width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:590px;" name="Layout_0" id="Layout_0">
					                <tbody><tr>
					                    <td class="rnb-del-min-width" valign="top" align="center" style="min-width:590px;">
					                        <table width="100%" cellpadding="0" border="0" height="38" cellspacing="0">
					                            <tbody><tr>
					                                <td valign="top" height="38">
					                                    <img width="20" height="38" style="display:block; max-height:38px; max-width:20px;" alt="" src="http://www.loanwalle.com/assets/images/email/rnb_space.gif">
					                                </td>
					                            </tr>
					                        </tbody></table>
					                    </td>
					                </tr>
					            </tbody></table>
					            </td>
					    		</tr><tr>

					        <td align="center" valign="top">

					            <div>
					            
					                <!--[if mso]>
					                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
					                <tr>
					                <![endif]-->
					                
					                <!--[if mso]>
					                <td valign="top" width="590" style="width:590px;">
					                <![endif]-->
					                <table class="rnb-del-min-width" width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:100%;" name="Layout_5">
					                <tbody><tr>
					                    <td class="rnb-del-min-width" align="center" valign="top">
					                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-container" bgcolor="#ffffff" style="background-color: rgb(255, 255, 255); padding-left: 20px; padding-right: 20px; border-collapse: separate; border-radius: 0px; border-bottom: 0px none rgb(200, 200, 200);">

					                                        <tbody><tr>
					                                            <td height="20" style="font-size:1px; line-height:0px;">&nbsp;</td>
					                                        </tr>
					                                        <tr>
					                                            <td valign="top" class="rnb-container-padding" align="left">

					                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-columns-container">
					                                                    <tbody><tr>
					                                                        <td class="rnb-force-col" valign="top" style="padding-right: 0px;">

					                                                            <table border="0" valign="top" cellspacing="0" cellpadding="0" width="100%" align="left" class="rnb-col-1">

					                                                                <tbody><tr>
					                                                                    <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;"><div>Dear '.strtoupper($name).',</div>
																						</td>
					                                                                </tr>
					                                                                </tbody></table>

					                                                            </td></tr>
					                                                </tbody></table></td>
					                                        </tr>
					                                        <tr>
					                                            <td height="0" style="font-size:1px; line-height:0px">&nbsp;</td>
					                                        </tr>
					                                    </tbody></table>
					                    </td>
					                </tr>
					            </tbody></table><!--[if mso]>
					                </td>
					                <![endif]-->
					                
					                <!--[if mso]>
					                </tr>
					                </table>
					                <![endif]-->

					            </div></td>
					    		</tr><tr>

					        <td align="center" valign="top">

					            <div>
					                
					                <!--[if mso]>
					                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
					                <tr>
					                <![endif]-->
					                
					                <!--[if mso]>
					                <td valign="top" width="590" style="width:590px;">
					                <![endif]-->
					                <table class="rnb-del-min-width" width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:100%;" name="Layout_2" id="Layout_2">
					                <tbody><tr>
					                    <td class="rnb-del-min-width" align="center" valign="top">
					                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-container" bgcolor="#ffffff" style="max-width: 100%; min-width: 100%; table-layout: fixed; background-color: rgb(255, 255, 255); border-radius: 0px; border-collapse: separate; padding-left: 20px; padding-right: 20px;">
					                            <tbody><tr>
					                                <td height="20" style="font-size:1px; line-height:0px;">&nbsp;</td>
					                            </tr>
					                            <tr>
					                                <td valign="top" class="rnb-container-padding" align="left">

					                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-columns-container">
					                                        <tbody><tr>
					                                            <td class="rnb-force-col" width="550" valign="top" style="padding-right: 0px;">
					                                                <table border="0" valign="top" cellspacing="0" cellpadding="0" align="left" class="rnb-col-1" width="550">
					                                                    <tbody><tr>
					                                                        <td width="100%" class="img-block-center" valign="top" align="left">
					                                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
					                                                            <tbody>
					                                                                <tr>
					                                                                    <td width="100%" valign="top" align="left" class="img-block-center">
					                                                                        <table style="display: inline-block;" cellspacing="0" cellpadding="0" border="0">
					                                                                            <tbody><tr>
					                                                                                <td>
					                                                                                    <div style="border-top:0px None #000;border-right:0px None #000;border-bottom:0px None #000;border-left:0px None #000;display:inline-block;"><div><img border="0" width="550" hspace="0" vspace="0" alt="" class="rnb-col-1-img" src="http://www.loanwalle.com/assets/images/email/5cbc5ae2ba6cf5d74c464f0e.png" style="vertical-align: top; max-width: 1200px; float: left;"></div><div style="clear:both;"></div>
					                                                                                    </div>
					                                                                            </td>
					                                                                            </tr>
					                                                                        </tbody></table>

					                                                                    </td>
					                                                                </tr>
					                                                            </tbody>
					                                                        </table></td>
					                                                    </tr><tr>
					                                                        <td height="10" class="col_td_gap" style="font-size:1px; line-height:0px;">&nbsp;</td>
					                                                    </tr><tr>
					                                                        <td style="font-size:24px; font-family:Arial,Helvetica,sans-serif; color:#3c4858; text-align:left;">
					                                                            <span style="color:#3c4858; "><strong><span style="font-size:18px;">However, we regret that we are unable to comply as your application does not meet the required criteria for approval.</span></strong></span></td>
					                                                    </tr><tr>
					                                                        <td height="10" class="col_td_gap" style="font-size:1px; line-height:0px;">&nbsp;</td>
					                                                    </tr><tr>
					                                                        <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
					                                                            <div></div>
					                                                        </td>
					                                                    </tr>
					                                                    </tbody></table>

					                                                </td></tr>
					                                    </tbody></table></td>
					                            </tr>
					                            <tr>
					                                <td height="20" style="font-size:1px; line-height:0px;">&nbsp;</td>
					                            </tr>
					                        </tbody></table>

					                    </td>
					                </tr>
					            </tbody></table><!--[if mso]>
					                </td>
					                <![endif]-->
					                
					                <!--[if mso]>
					                </tr>
					                </table>
					                <![endif]-->
					                
					            </div></td>
					    	</tr><tr>

					        <td align="center" valign="top">

					            <div>
					                
					                <table class="rnb-del-min-width rnb-tmpl-width" width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:590px;" name="Layout_" id="Layout_">
					                    <tbody><tr>
					                        <td class="rnb-del-min-width" align="center" valign="top" bgcolor="#ffffff" style="min-width:590px; background-color: #ffffff;">
					                            <table width="590" class="rnb-container" cellpadding="0" border="0" align="center" cellspacing="0" bgcolor="#ffffff" style="background-color: rgb(255, 255, 255);">
					                                <tbody><tr>
					                                    <td height="20" style="font-size:1px; line-height:0px;">&nbsp;</td>
					                                </tr>
					                                <tr>
					                                    <td valign="top" class="rnb-container-padding" style="font-size: 14px; font-family: Arial,Helvetica,sans-serif; color: #888888;" align="center">

					                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-columns-container">
					                                            <tbody><tr>
					                                                <td class="rnb-force-col rnb-social-width2" valign="top" style="mso-padding-alt: 0 20px 0 20px; padding-right: 28px; padding-left: 28px;">

					                                                    <table border="0" valign="top" cellspacing="0" cellpadding="0" width="533" align="center" class="rnb-last-col-2">

					                                                        <tbody><tr>
					                                                            <td valign="top">
					                                                                <table cellpadding="0" border="0" cellspacing="0" class="rnb-social-align2" align="center">
					                                                                    <tbody><tr>
					                                                                        <td valign="middle" style="line-height: 0px;" class="rnb-text-center" ng-init="width=setSocialIconsBlockWidth(item)" width="533" align="center">
					                                                                            <!--[if mso]>
					                                                                            <table align="center" border="0" cellspacing="0" cellpadding="0">
					                                                                            <tr>
					                                                                            <![endif]-->

					                                                                                <div class="rnb-social-center" style="display: inline-block;">
					                                                                                <!--[if mso]>
					                                                                                <td align="center" valign="top">
					                                                                                <![endif]-->
					                                                                                    <table align="left" style="float:left; display: inline-block" border="0" cellpadding="0" cellspacing="0">
					                                                                                        <tbody><tr>
					                                                                                            <td style="padding:0px 5px 5px 0px; mso-padding-alt: 0px 4px 5px 0px;" align="left">
					                                                                                <span style="color:#ffffff; font-weight:normal;">
					                                                                                    <a target="_blank" href="https://www.facebook.com/loanwalle2019/"><img alt="Facebook" border="0" hspace="0" vspace="0" style="vertical-align:top;" target="_blank" src="http://www.loanwalle.com/assets/images/email/rnb_ico_fb.png"></a></span>
					                                                                                            </td></tr></tbody></table>
					                                                                                <!--[if mso]>
					                                                                                </td>
					                                                                                <![endif]-->
					                                                                                </div><div class="rnb-social-center" style="display: inline-block;">
					                                                                                <!--[if mso]>
					                                                                                <td align="center" valign="top">
					                                                                                <![endif]-->
					                                                                                    <table align="left" style="float:left; display: inline-block" border="0" cellpadding="0" cellspacing="0">
					                                                                                        <tbody><tr>
					                                                                                            <td style="padding:0px 5px 5px 0px; mso-padding-alt: 0px 4px 5px 0px;" align="left">
					                                                                                <span style="color:#ffffff; font-weight:normal;">
					                                                                                    <a target="_blank" href="https://twitter.com/loanwalle1"><img alt="Twitter" border="0" hspace="0" vspace="0" style="vertical-align:top;" target="_blank" src="http://www.loanwalle.com/assets/images/email/rnb_ico_tw.png"></a></span>
					                                                                                            </td></tr></tbody></table>
					                                                                                <!--[if mso]>
					                                                                                </td>
					                                                                                <![endif]-->
					                                                                                </div><div class="rnb-social-center" style="display: inline-block;">
					                                                                                <!--[if mso]>
					                                                                                <td align="center" valign="top">
					                                                                                <![endif]-->
					                                                                                    <table align="left" style="float:left; display: inline-block" border="0" cellpadding="0" cellspacing="0">
					                                                                                        <tbody><tr>
					                                                                                            <td style="padding:0px 5px 5px 0px; mso-padding-alt: 0px 4px 5px 0px;" align="left">
					                                                                                <span style="color:#ffffff; font-weight:normal;">
					                                                                                    <a target="_blank" href="https://www.youtube.com/channel/UC0XGjHs-oPeZxa1sqeE_q_w?view_as=subscriber"><img alt="YouTube" border="0" hspace="0" vspace="0" style="vertical-align:top;" target="_blank" src="http://www.loanwalle.com/assets/images/email/rnb_ico_yt.png"></a></span>
					                                                                                            </td></tr></tbody></table>
					                                                                                <!--[if mso]>
					                                                                                </td>
					                                                                                <![endif]-->
					                                                                                </div><!--[if mso]>
					                                                                            </tr>
					                                                                            </table>
					                                                                            <![endif]-->
					                                                                        </td>
					                                                                    </tr>
					                                                                </tbody></table>
					                                                            </td>
					                                                        </tr>
					                                                        </tbody></table>
					                                                    </td>
					                                            </tr>
					                                        </tbody></table></td>
					                                </tr>
					                                <tr>
					                                    <td height="20" style="font-size:1px; line-height:0px;">&nbsp;</td>
					                                </tr>
					                            </tbody></table>

					                        </td>
					                    </tr></tbody></table>
					                
						            </div></td>
						    </tr><tr>

					        <td align="center" valign="top">

					            <div>
					            
					                <!--[if mso]>
					                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
					                <tr>
					                <![endif]-->
					                
					                <!--[if mso]>
					                <td valign="top" width="590" style="width:590px;">
					                <![endif]-->
					                <table class="rnb-del-min-width" width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:100%;" name="Layout_8">
					                <tbody><tr>
					                    <td class="rnb-del-min-width" align="center" valign="top">
					                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-container" bgcolor="#ffffff" style="background-color: rgb(255, 255, 255); padding-left: 20px; padding-right: 20px; border-collapse: separate; border-radius: 0px; border-bottom: 0px none rgb(200, 200, 200);">

					                                        <tbody><tr>
					                                            <td height="0" style="font-size:1px; line-height:0px;">&nbsp;</td>
					                                        </tr>
					                                        <tr>
					                                            <td valign="top" class="rnb-container-padding" align="left">

					                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-columns-container">
					                                                    <tbody><tr>
					                                                        <td class="rnb-force-col" valign="top" style="padding-right: 0px;">

					                                                            <table border="0" valign="top" cellspacing="0" cellpadding="0" width="100%" align="left" class="rnb-col-1">

					                                                                <tbody><tr>
					                                                                    <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;"><div style="text-align: center;"><strong>For any clarification please feel free to call:</strong></div>
																						</td>
					                                                                </tr>
					                                                                </tbody></table>

					                                                            </td></tr>
					                                                </tbody></table></td>
					                                        </tr>
					                                        <tr>
					                                            <td height="0" style="font-size:1px; line-height:0px">&nbsp;</td>
					                                        </tr>
					                                    </tbody></table>
					                    </td>
					                </tr>
					            </tbody></table><!--[if mso]>
					                </td>
					                <![endif]-->
					                
					                <!--[if mso]>
					                </tr>
					                </table>
					                <![endif]-->

					            </div></td>
					    		</tr><tr>

					        <td align="center" valign="top">

					            <div>
					                
					                <!--[if mso]>
					                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
					                <tr>
					                <![endif]-->
					                
					                <!--[if mso]>
					                <td valign="top" width="590" style="width:590px;">
					                <![endif]-->
					                <table class="rnb-del-min-width" width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:590px;" name="Layout_7" id="Layout_7">
					                <tbody><tr>
					                    <td class="rnb-del-min-width" align="center" valign="top" style="min-width:590px;">
					                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="mso-button-block rnb-container" style="background-color: rgb(255, 255, 255); border-radius: 0px; padding-left: 20px; padding-right: 20px; border-collapse: separate;">
					                            <tbody><tr>
					                                <td height="20" style="font-size:1px; line-height:0px;">&nbsp;</td>
					                            </tr>
					                            <tr>
					                                <td valign="top" class="rnb-container-padding" align="left">

					                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-columns-container">
					                                        <tbody><tr>
					                                            <td class="rnb-force-col" valign="top">

					                                                <table border="0" valign="top" cellspacing="0" cellpadding="0" width="550" align="center" class="rnb-col-1">

					                                                    <tbody><tr>
					                                                        <td valign="top">
					                                                            <table cellpadding="0" border="0" align="center" cellspacing="0" class="rnb-btn-col-content" style="margin:auto; border-collapse: separate;">
					                                                                <tbody><tr>
					                                                                    <td width="auto" valign="middle" bgcolor="#3499db" align="center" height="40" style="font-size:18px; font-family:`Trebuchet MS`,Helvetica,sans-serif; color:#ffffff; font-weight:normal; padding-left:20px; padding-right:20px; vertical-align: middle; background-color:#3499db;border-radius:4px;border-top:0px None #000;border-right:0px None #000;border-bottom:0px None #000;border-left:0px None #000;">
					                                                                        <span style="color:#ffffff; font-weight:normal;">
					                                                                                <a style="text-decoration:none; color:#ffffff; font-weight:normal;" target="_blank"><strong>9999999341</strong></a>
					                                                                            </span>
					                                                                    </td>
					                                                                </tr></tbody></table>
					                                                        </td>
					                                                    </tr>
					                                                    </tbody></table>
					                                                </td>
					                                        </tr>
					                                    </tbody></table></td>
					                            </tr>
					                            <tr>
					                                <td height="20" style="font-size:1px; line-height:0px;">&nbsp;</td>
					                            </tr>
					                        </tbody></table>

					                    </td>
					                </tr>
					            </tbody></table>
					            <!--[if mso]>
					                </td>
					                <![endif]-->
					                
					                <!--[if mso]>
					                </tr>
					                </table>
					                <![endif]-->
					                
					            </div></td>
					    		</tr><tr>

					        <td align="center" valign="top">

					            <div>
					            
					                <!--[if mso]>
					                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
					                <tr>
					                <![endif]-->
					                
					                <!--[if mso]>
					                <td valign="top" width="590" style="width:590px;">
					                <![endif]-->
					                <table class="rnb-del-min-width" width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:100%;" name="Layout_6">
					                <tbody><tr>
					                    <td class="rnb-del-min-width" align="center" valign="top">
					                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-container" bgcolor="#ffffff" style="background-color: rgb(255, 255, 255); padding-left: 20px; padding-right: 20px; border-collapse: separate; border-radius: 0px; border-bottom: 0px none rgb(200, 200, 200);">

					                                        <tbody><tr>
					                                            <td height="0" style="font-size:1px; line-height:0px;">&nbsp;</td>
					                                        </tr>
					                                        <tr>
					                                            <td valign="top" class="rnb-container-padding" align="left">

					                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="rnb-columns-container">
					                                                    <tbody><tr>
					                                                        <td class="rnb-force-col" valign="top" style="padding-right: 0px;">

					                                                            <table border="0" valign="top" cellspacing="0" cellpadding="0" width="100%" align="left" class="rnb-col-1">

					                                                                <tbody>
					                                                                <tr>
					                                                                    <td style="font-size:14px; font-family:Arial,Helvetica,sans-serif, sans-serif; color:#3c4858; line-height: 21px;">
					                                                                    <div>
					                                                                    <strong>Thanks &amp; Regards<br>   
					                                                                    '.$queryUser[0]->name.'<br>
					                                                                    Credit Manager<br>
					                                                                    '.$queryUser[0]->mobile.'<br>Team Loanwalle</strong>
					                                                                    </div>
					                                                                </td>
					                                                                </tr>
					                                                                </tbody>
					                                                                </table>

					                                                            </td></tr>
					                                                </tbody></table></td>
					                                        </tr>
					                                        <tr>
					                                            <td height="0" style="font-size:1px; line-height:0px">&nbsp;</td>
					                                        </tr>
					                                    </tbody></table>
					                    </td>
					                </tr>
					            </tbody></table><!--[if mso]>
					                </td>
					                <![endif]-->
					                
					                <!--[if mso]>
					                </tr>
					                </table>
					                <![endif]-->

					            </div></td>
					    		</tr><tr>

					        <td align="center" valign="top">

					            <div>
					                
					                <table class="rnb-del-min-width rnb-tmpl-width" width="100%" cellpadding="0" border="0" cellspacing="0" style="min-width:590px;" name="Layout_4" id="Layout_4">
					                    <tbody><tr>
					                        <td class="rnb-del-min-width" align="center" valign="top" style="min-width:590px;">
					                            <table width="100%" cellpadding="0" border="0" align="center" cellspacing="0" bgcolor="#ffffff" style="padding-right: 20px; padding-left: 20px; background-color: rgb(255, 255, 255);">
					                                <tbody><tr>
					                                    <td height="20" style="font-size:1px; line-height:0px;">&nbsp;</td>
					                                </tr>
					                                <tr>
					                                    <td style="font-size:14px; color:#888888; font-weight:normal; text-align:center; font-family:Arial,Helvetica,sans-serif;">
					                                        <div><div>&copy; 2019 loanwalle.com</div>
																				</div>
					                                    </td></tr>
					                                <tr>
					                                    <td height="20" style="font-size:1px; line-height:0px;">&nbsp;</td>
					                                </tr>
					                            </tbody></table>
					                        </td>
					                    </tr>
					                </tbody></table>
					                
					            </div></td>
					    		</tr></tbody></table>
					            <!--[if gte mso 9]>
					                        </td>
					                        </tr>
					                        </table>
					                        <![endif]-->
					                        </td>
						        </tr>
						        </tbody></table>

							</body></html>';

						        
		            $emailid = "sanction@loanwalle.com";
					$config = Array(
						'protocol' 	=> 'smtp',
						'smtp_host' => 'ssl://smtp.gmail.com',
						'smtp_port' => '465',
						'smtp_user' => 'sanction@loanwalle.com',
						// 'smtp_pass' => 'Welcome@0101', 
						'smtp_pass' => 'Naman@01$#01', 
						'mailtype'  => 'html',
						'charset'   => 'utf-8',
						'wordwrap'  => TRUE
					);
		                   
		  //          if($status == 'Sanction' && $mail == "Yes")
		  //          {
				// 		$this->load->library('email', $config);
				// 		$this->email->set_newline("\r\n");
				// 		$this->email->from('sanction@loanwalle.com','Loanwalle');
				// 		$this->email->to($email);
				// 		$this->email->bcc($emailid);
				// 		$this->email->subject('Your loan for Rs. '.$loanApproved.' sanctioned - '.$branch.'-'.$repeat);
				// 		$this->email->message($msg);
				// 		$this->email->send();
				// 		// echo $status.'    '. $mail.'<br>';
				// 		//echo $msg;exit;
		  //          }
		            if($status == 'Rejected' && $mail == "Yes")
		            {
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						$this->email->from('sanction@loanwalle.com','Loanagaistcard');
						$this->email->to($email);
						$this->email->bcc($emailid);
						$this->email->subject('Regret Intimation - '.$branch.'-'.$repeat);
						$this->email->message($msg1);
						$this->email->send();
		            }
		            
		            $this->db->trans_complete();    
		            
		            if($this->db->trans_status() === FALSE)
		            {
		                $response = "Unable to update status";
    		            echo json_encode($response);
		            }
		            else
		            {
		              //  if($this->db->affected_rows() > 0)
		              //  {
		                  //  $response ="Lead status successfully updated";
    		          //      echo json_encode($response);
		              //  }
		              //  else
		              //  {
		              //      $response = "Lead status successfully updated, but it looks like you haven't updated anything!";
    		          //      echo json_encode($response);
		              //  }
	                    $response ="Lead status successfully updated";
		                echo json_encode($response);
		            }
		          //  print_r($response);
		        }
	        }
	    }

	    public function EditCreditDetails($lead_id)
	    {
	    	$this->db->select('credit.*, tb_states.state, leads.loan_amount, leads.monthly_income')
                ->where('leads.lead_id', $lead_id)
                ->from(tableLeads)
                ->join('credit', 'credit.lead_id = leads.lead_id')
                ->join('tb_states', 'leads.state_id = tb_states.id');
                
            $data['leadDetails'] = $this->db->get()->row();
            $data['branch'] = $this->Task_Model->getBranch();

			$this->load->view('Tasks/EditCreditDetails', $data);
	    }

	    public function updateCreditDetails($lead_id)
	    {
	    	if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
				$this->form_validation->set_rules('name', 'Name', 'required|trim');
				$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
				$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
				$this->form_validation->set_rules('pancard', 'Pancard', 'required|trim');
				$this->form_validation->set_rules('salary', 'Salary', 'required|trim');
				$this->form_validation->set_rules('salary_date', 'Salary Date', 'required|trim');
				$this->form_validation->set_rules('dob', 'DOB', 'required|trim');
				$this->form_validation->set_rules('marital_status', 'Marital Status', 'required|trim');
				$this->form_validation->set_rules('father_name', 'Father Name', 'required|trim');
				$this->form_validation->set_rules('branch', 'Branch', 'required|trim');
				$this->form_validation->set_rules('loanapproved', 'Loan Approved', 'required|trim');
				$this->form_validation->set_rules('roi', 'Roi', 'required|trim');
				$this->form_validation->set_rules('processing_fee', 'Processing Fee', 'required|trim');
				$this->form_validation->set_rules('repayment_date', 'Repayment Date', 'required|trim');
				$this->form_validation->set_rules('residential', 'Residential', 'required|trim');
				$this->form_validation->set_rules('residential_proof', 'Residential Proof', 'required|trim');
				$this->form_validation->set_rules('residential_no', 'Residential No', 'required|trim');
				$this->form_validation->set_rules('special_approval', 'Specia Approval', 'required|trim');
				$this->form_validation->set_rules('repeat', 'Repeat', 'required|trim');
				$this->form_validation->set_rules('obligations', 'Obligations', 'required|trim');
				$this->form_validation->set_rules('cibil', 'Cibil', 'required|trim');
				$this->form_validation->set_rules('status', 'Status', 'required|trim');
				$this->form_validation->set_rules('remark', 'Remark', 'required|trim');
	        	if($this->form_validation->run() == FALSE) {
	        		$this->session->set_flashdata('err', validation_errors());
		            return redirect(base_url('EditCreditDetails/'.$_POST['lead_id']), 'refresh');
	        	} 
	        	else 
	        	{
			        $lead_id = $this->input->post('lead_id');
			        $name = $this->input->post('name');
			        $email = $this->input->post('email');
			        $father_name = $this->input->post('father_name');
			        $roi = $this->input->post('roi');
			        $processing_fee = $this->input->post('processing_fee');
			        $obligations = $this->input->post('obligations');
			        $cibil = $this->input->post('cibil');

					$pancard = $this->input->post('pancard');
					$dob = $this->input->post('dob');
					$mobile = $this->input->post('mobile');
					$alternate_no= $this->input->post('alternate_no');
					$salary = $this->input->post('salary');
					$salary_date = $this->input->post('salary_date');
					$residential = $this->input->post('residential');
					$residential_proof = $this->input->post('residential_proof');
					$residential_no = $this->input->post('residential_no');
					$marital_status = $this->input->post('marital_status');
					$special_approval = $this->input->post('special_approval');
					$crm_approval = $this->input->post('crm_approval');
					$recovery_approval = $this->input->post('recovery_approval');
					$remark = $this->input->post('remark');
					$status = $this->input->post('status');
					$loanApproved = $this->input->post('loanapproved');
					$branch = $this->input->post('branch');
					$repeat = $this->input->post('repeat');
			        $repayment_date = $this->input->post('repayment_date');
					$sms = $this->input->post('sms');
			        $now2 = date("Y-m-d", strtotime(updated_at));
			        
			        $date1_ts = strtotime($now2);
				    $date2_ts = strtotime($repayment_date);
				    $diff = $date2_ts - $date1_ts;
			        $tenure = ($diff / 60/60/24);

					$repay = $loanApproved + (($loanApproved * $roi * $tenure)/100);

					$data = array(
						'loan_amount_approved'	=> $loanApproved,
						'roi'					=> $roi,
						'tenure'				=> $tenure,
						'repay_amount' 			=> $repay,
						'repayment_date'		=> $repayment_date,
						'processing_fee'		=> $processing_fee,
						'obligations'			=> $obligations,
						'cibil'					=> $cibil,
						'status' 				=> $status,
						'branch' 				=> $branch,
						'email' 				=> $email,
						'name' 					=> $name,
						'father_name' 			=> $father_name,
						'pancard' 				=> $pancard,
						'dob' 					=> $dob,
						'mobile' 				=> $mobile,
						'alternate_no' 			=> $alternate_no,
						'salary' 				=> $salary,
						'salary_date' 			=> $salary_date,
						'residential' 			=> $residential,
						'residential_proof' 	=> $residential_proof,
						'residential_no' 		=> $residential_no,
						'marital_status'		=> $marital_status,
						'special_approval'		=> $special_approval,
						'crm_approval'			=> $crm_approval,
						'recovery_approval'		=> $recovery_approval,
						'ip' 					=> ip,
						'remark'				=> $remark,
						'sms'					=> $sms,
						'approved_by'			=> sessionUserID,
						'created_on'			=> updated_at,
						'noofdisbursal'			=> $repeat
			      	);
						         
					$this->db->trans_start();

					$result = $this->db->where('lead_id', $lead_id)->update('credit', $data);
			        $queryUser = $this->db->where("user_id", sessionUserID)->get('users')->result();
			        
			        $salary_mode = "Bank Transfer";
					if(!empty($queryUser[0]->salary_mode)) {
						$salary_mode = $queryUser[0]->salary_mode;
					}

					$updateLeadStatus = array(
						'interest' 		=>$roi,
						'cibil' 		=>$cibil,
						'salary_mode' 	=>$salary_mode,
						'status' 		=>$status,
						'repay_amount' 	=>$repay,
						'loan_approved' =>0,
						'updated_on'	=>updated_at
					);

					$this->db->where('lead_id', $lead_id)->update('leads', $updateLeadStatus);

	        		$this->session->set_flashdata('msg', 'Updated successfully.');
		            return redirect(base_url('TaskList'), 'refresh');
				}
			}
	    }

	    public function get_credit($lead_id)
	    {
	        if(!empty(sessionUserID))
	        {
				$output = $this->Task_Model->get_credit($lead_id);
				echo json_encode($output);
	        }else{
	            return redirect(base_url());
	        } 
	    }
	    
	    public function sanction_mail_for_hold_customer($lead_id)
		{ 
		    $this->db->select('leads.lead_id, leads.name, leads.email, leads.mobile, credit.loan_amount_approved, credit.tenure, credit.roi, credit.repay_amount, credit.repayment_date, credit.updated_on, credit.processing_fee') 
	                ->where('leads.lead_id', $lead_id)
	                ->from('leads')
	                ->join('credit', 'credit.lead_id = leads.lead_id')
	                ->join('tb_states', 'leads.state_id = tb_states.id');
	            $query = $this->db->get()->row(); 
	            
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
            
            $date = strtotime($query->updated_on);
            $new_date = date('d-m-Y', $date);  
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
                                    <td bgcolor="#FFFFFF">'.$query->loan_amount_approved.'</td>
                                  </tr>
                                  <tr>
                                    <td bgcolor="#FFFFFF" style="padding:10px;"><strong id="docs-internal-guid-81302841-7fff-d67e-afb5-3794704879ca">Rate of Interest</strong></td>
                                    <td align="center" valign="middle" bgcolor="#FFFFFF" style="padding:10px;"><strong>:</strong></td>
                                    <td bgcolor="#FFFFFF" style="padding:10px;">'.$query->roi.' %</td>
                                  </tr>
                                  <tr>
                                    <td bgcolor="#FFFFFF" style="padding:10px;"><strong id="docs-internal-guid-812ef595-7fff-f93d-6228-79a9ef54e56d">Processing fee</strong></td>
                                    <td align="center" valign="middle" bgcolor="#FFFFFF" style="padding:10px;"><strong>:</strong></td>
                                    <td bgcolor="#FFFFFF" style="padding:10px;">'.$query->processing_fee.'</td>
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
                            //print_r($message); exit;
    
            $this->load->library('email');
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->from('docs@loanagainstcard.com');
            $this->email->to($query->email);
            $this->email->bcc('n7309429590@gmail.com,docs@loanagainstcard.com');
            // $this->email->to('nandlal@loanwalle.com');
            $this->email->subject("Loan Sanctioned From Loanagainstcard");
            $this->email->message($message);
            if($this->email->send())
            {
                echo "send";
            }else{
                echo "Sanctioned mail Not send !";
            }
		}

	}


?>