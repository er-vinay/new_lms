<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class DisbursalController extends CI_Controller
	{
		public $tbl_leads = 'leads LD';
		public $tbl_customer_banking = 'customer_banking CB';

		public function __construct()
		{
			parent::__construct();
            $this->load->model('Task_Model', "Tasks");
            $this->load->model('Disburse_Model', 'DM');
            $this->load->model('Product_Model', 'PM');
            $this->load->model('CAM_Model', 'CAM');
            $this->load->model('Emails_Model');

	    	$login = new IsLogin();
	    	$login->index();
		}

		public function getCAMDetails($lead_id)
		{
            $table1 = 'leads LD';
            $table2 = 'customer C';
            $join2 	= 'C.customer_id = LD.customer_id';
            $table3 = 'credit_analysis_memo CAM';
            $join3 	= 'CAM.lead_id = LD.lead_id';
            $table4 = 'loan L';
            $join4 	= 'L.lead_id = LD.lead_id';

	        $conditions = ['LD.company_id' => company_id, 'LD.product_id' => product_id, 'LD.lead_id' => $lead_id];
	        
            $select = 'LD.lead_id, LD.customer_id, LD.application_no, C.first_name, C.middle_name, C.sur_name, C.email, C.alternate_email, C.gender, C.mobile, C.alternate_mobile, LD.obligations, LD.loan_amount, LD.status, LD.stage, CAM.loan_recommended, CAM.roi, CAM.total_admin_fee, CAM.disbursal_date, CAM.repayment_date, CAM.tenure, CAM.net_disbursal_amount, CAM.repayment_amount, L.loan_no, L.loanAgreementRequest, L.agrementRequestedDate, L.loanAgreementResponse, L.agrementUserIP, L.agrementResponseDate, L.status as loan_status, L.company_ac_no, L.channel, L.mode_of_payment, L.disburse_refrence_no';
	        return $this->Tasks->join_table($conditions, $select, $table1, $table2, $join2, $table3, $join3, $table4, $join4);
		}

		public function leadFollowUpUser($lead_id)
		{
	        $conditions2 = ['LF.lead_id' => $lead_id];
	        $fetch = 'U.user_id, U.labels, U.name, LF.created_on';
	        $table11 = 'lead_followup LF';
	        $table12 = 'users U';
	        $join12 = 'LF.user_id = U.user_id';
	        $followUpUser = $this->Tasks->join_two_table_with_where($conditions2, $fetch, $table11, $table12, $join12);

	        $processed_by = '-';
			$processed_on = '-';
			$sanctioned_by = '-';
			$sanctioned_on = '-';

	        if($followUpUser->num_rows() > 0)
	        {
		        foreach($followUpUser->result() as $row)
		        {
		        	if($row->labels == "CR1"){
		        		$processed_by = $row->name;
		        		$processed_on = date('d-m-Y h:i', strtotime($row->created_on));
		        	} else if($row->labels == "CR2"){
		        		$sanctioned_by = $row->name;
		        		$sanctioned_on = date('d-m-Y h:i', strtotime($row->created_on));
		        	}
		        }
		    }
	        $data = [
	        	'processed_by' 		=> $processed_by,
	        	'processed_on' 		=> $processed_on,
	        	'sanctioned_by' 	=> $sanctioned_by,
	        	'sanctioned_on' 	=> $sanctioned_on,
	        ];
	        return $data;
		}

		public function getSanctionDetails()
		{
			if($this->input->post('user_id') == '')
			{
				$json['errSession'] = 'Session Expired';
				echo json_encode($json);
			}
			if ($this->input->server('REQUEST_METHOD') == 'POST')
		    {
	        	$this->form_validation->set_rules('lead_id', 'Lead ID', 'required|trim');
	        	$this->form_validation->set_rules('customer_id', 'Company ID', 'required|trim');
	        	$this->form_validation->set_rules('user_id', 'User ID', 'required|trim');
	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
		            echo json_encode($json);
	        	} else {
	        		$lead_id = $this->input->post('lead_id');
			        $leadData = $this->getCAMDetails($lead_id);
			        $data['camDetails'] = $leadData->row();
			        $data['LeadFollowup'] = $this->leadFollowUpUser($lead_id);
			        echo json_encode($data);
			    }
			}
		}
        
        public function sendDisbursalMail($lead_id, $email = null)
        {	
	        $leadData = $this->getCAMDetails($lead_id);
	        $camDetails = $leadData->row();
	        $LeadFollowup = $this->leadFollowUpUser($lead_id);
	        if($email == null){
	        	$email = $camDetails->email;
	        }
		    $message = '
	            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	            <html xmlns="http://www.w3.org/1999/xhtml">
	               <head>
	                  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	                  <title>Mailer</title>
	               </head>
	               <body>
	                  <table width="778" border="0" align="center" cellpadding="0" cellspacing="0" style="padding:10px; border:solid 1px #ccc; font-family:Arial, Helvetica, sans-serif;">
	                     <tr>
	                        <td width="381" align="left"><img src="'. base_url('public/front/images/logo.gif') .'" class="img-responsive" alt="logo"/></td>
	                        <td width="11" align="left">&nbsp;</td>
	                        <td width="384" align="right">
	                           <table width="100%" border="0">
	                              <tr>
	                                 <td align="right"><strong style="line-height:25px;">Dear &nbsp;'. $camDetails->first_name .'</strong></td>
	                              </tr>
	                              <tr>
	                                 <td align="right">Loan No.: -</td>
	                              </tr>
	                           </table>
	                        </td>
	                     </tr>
	                     <tr>
	                        <td colspan="3">
	                           <hr / style="background:#ddd !important;">
	                        </td>
	                     </tr>
	                     <tr>
	                        <td colspan="3">&nbsp;</td>
	                     </tr>
	                     <tr>
	                        <td><strong>Loanwalle app Lead partner of Naman Finlease Pvt. Ltd.</strong></td>
	                        <td>&nbsp;</td>
	                        <td rowspan="4" align="center" valign="top"><img class="img-responsive" src="https://www.loanwalle.com/public/front/images/image-loan.jpg" width="384" height="406" / style="border:solid 1px #ccc; padding:10px;"></td>
	                     </tr>
	                     <tr>
	                        <td><span style="font-size:17px;
	                           line-height: 25px;
	                           padding-bottom: 6px; text-align:justify;">Thank you for choosing us and giving us the opportunity to be of service to you. Hope you are satisfied with us.</span></td>
	                        <td>&nbsp;</td>
	                     </tr>
	                     <tr>
	                        <td><span style="font-size:17px;
	                           line-height: 25px;
	                           padding-bottom: 6px; text-align:justify;">In order to avail this loan, you have already filled up and submitted a loan application and signed our loan agreement in acceptance of the terms and conditions. </span></td>
	                        <td>&nbsp;</td>
	                     </tr>
	                     <tr>
	                        <td><span style="font-size:17px;
	                           line-height: 25px;
	                           padding-bottom: 6px; text-align:justify;">To avoid any kind of ambiguity in future we are sending you this term sheet detailing the terms and conditions of the loan. Please go through this  carefully and give your approval so we can go forth and disburse the loan amount.</span></td>
	                        <td>&nbsp;</td>
	                     </tr>
	                     <tr>
	                        <td>&nbsp;</td>
	                        <td>&nbsp;</td>
	                        <td align="center" valign="top">&nbsp;</td>
	                     </tr>
	                     <tr>
	                        <td colspan="3" style="font-size:17px;
	                           line-height: 25px;
	                           padding-bottom: 6px;"><strong>Loanwalle.com Powered by Naman Finlease Pvt. Ltd. (RBI approved NBFC) </strong></td>
	                     </tr>
	                     <tr>
	                        <td colspan="3" style="font-size:17px;
	                           line-height: 25px;
	                           padding-bottom: 6px;"><strong>S-370 Panchsheel Park, Near Panchsheel Park Metro Station Gate No.1, New Delhi- 110017 </strong></td>
	                     </tr>
	                     <tr>
	                        <td colspan="3" style="font-size:17px;
	                           line-height: 25px;
	                           padding-bottom: 6px;"><strong>Loan Terms to be agreed by the Customer</strong></td>
	                     </tr>
	                     <tr>
	                        <td colspan="3" style="font-size:17px;
	                           line-height: 25px;
	                           padding-bottom: 6px;">&nbsp;</td>
	                     </tr>
	                     <tr>
	                        <td colspan="3">
	                           <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
	                              <tr>
	                                 <td width="42%" bgcolor="#FFFFFF" style="padding:10px;">Name </td>
	                                 <td width="58%" bgcolor="#FFFFFF" style="padding:10px;">'. $camDetails->first_name .'</td>
	                              </tr>
	                              <tr>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">Loan Amount</td>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">Rs. '. ($camDetails->loan_recommended).' /- </td>
	                              </tr>
	                              <tr>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">Rate of Interest (%)</td>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">'. $camDetails->roi .' per day</td>
	                              </tr>
	                              <tr>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">Disbursal Date</td>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">'. $camDetails->disbursal_date .' </td>
	                              </tr>
	                              <tr>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">Commitment Payback Date</td>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">'. $camDetails->repayment_date .'</td>
	                              </tr>
	                              <tr>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">Repayment Amount</td>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">'. $camDetails->repayment_amount .' </td>
	                              </tr>
	                              <tr>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">Period</td>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">'. $camDetails->tenure .' </td>
	                              </tr>
	                              <tr>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">Penalty (%)</td>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">2.00</td>
	                              </tr>
	                              <tr>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">Administrative Fee </td>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">Rs. '. $camDetails->total_admin_fee .'/-</td>
	                              </tr>
	                              <tr>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">Repayment Cheque(s)</td>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">&nbsp;-</td>
	                              </tr>
	                              <tr>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">Cheque drawn on (Bank Name) </td>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">&nbsp;-</td>
	                              </tr>
	                              <tr>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">Cheque &amp;NACHBouncing Charges </td>
	                                 <td bgcolor="#FFFFFF" style="padding:10px;">Rs. 1000/- every time</td>
	                              </tr>
	                           </table>
	                        </td>
	                     </tr>
	                     <tr>
	                        <td>&nbsp;</td>
	                        <td>&nbsp;</td>
	                        <td>&nbsp;</td>
	                     </tr>
	                     <tr>
	                        <td>&nbsp;</td>
	                        <td>&nbsp;</td>
	                        <td>&nbsp;</td>
	                     </tr>
	                     <tr>
	                        <td colspan="3" style="font-size:17px;
	                           line-height: 25px;
	                           padding-bottom: 6px;">Non-payment of loan on time will affect your CIBIL Score and will affect your chance of getting <br />
	                           further loans 
	                        </td>
	                     </tr>
	                     <tr>
	                        <td colspan="3" style="font-size:17px;
	                           line-height: 25px;
	                           padding-bottom: 6px;">from Banks and financial institutions  In case your cheque bounces we are liable to take legal action u/s 138 of IPC  </td>
	                     </tr>
	                     <tr>
	                        <td colspan="3" style="font-size:17px;
	                           line-height: 25px;
	                           padding-bottom: 6px;">Please send confirmation mail that you are agreed with the above term.</td>
	                     </tr>
	                     <tr>
	                        <td style="padding-bottom:10px; padding-top:10px;"><strong>Best Regards,  </strong></td>
	                        <td style="padding-bottom:10px; padding-top:10px;">&nbsp;</td>
	                        <td>&nbsp;</td>
	                     </tr>
	                     <tr>
	                        <td><strong>Team Loanwalle</strong></td>
	                        <td>&nbsp;</td>
	                        <td>&nbsp;</td>
	                     </tr>
	                     <tr>
	                        <td>&nbsp;</td>
	                        <td>&nbsp;</td>
	                        <td>&nbsp;</td>
                        </tr>
	                     <tr>
	                        <td>
		                        <form action="'. base_url('loanAgreementLetterResponse') .'" method="post" enctype="mutlipart-from/data">
                    				<input type="hidden" name="'. $this->security->get_csrf_token_name() .'" value="'. $this->security->get_csrf_hash() .'" />
		                        	<input type="hidden" name="lead_id" value="'. $lead_id .'">
		                        	<input type="hidden" name="email" value="'. $email .'">
		                        	<input type="hidden" name="response" value="1">
		                        	<input type="hidden" name="ip" value="'. $_SERVER['REMOTE_ADDR'] .'">
		                        	<input type="submit" name="Accept Terms & Conditions" value="Accept Terms & Conditions" style="color: #fff; background: #0d70ac; border-bottom: none !important; padding: 12px 9px !important;">
		                        </form>
	                        </td>
	                     </tr>
	                     <tr>
	                        <td>&nbsp;</td>
	                        <td>&nbsp;</td>
	                        <td>&nbsp;</td>
	                     </tr>
	                  </table>
	               </body>
	            </html>
	        ';

	        // echo "<pre>"; print_r($message); exit;

	        $from = 'info@loanwalle.com';
	        $conditions = ['CAM.company_id' => company_id];
	        $fetch = 'CAM.*';
	        $sql = $this->Tasks->select($conditions, $fetch, 'tbl_email_credentails');
	        
	        $config['protocol']     = 'sendmail';
	        $config['smtp_host']    = "smtp.gmail.com";
	        $config['smtp_port']    = 25;
	        $config['smtp_user']    = $sql->smtp_user;
	        $config['smtp_pass']    = $sql->smtp_pass;
	        $config['charset']      = 'iso-8859-1';
	        $config['wordwrap']     = TRUE;
	        $config['mailtype']     = 'html';
	        $config['priority']     = '1';
	        
	        $this->load->library('email');
	        $this->email->initialize($config);
	        $this->email->set_newline("\r\n");
	        $this->email->from($from);
	        $this->email->to($loanDetails->email);
	        $this->email->bcc("info@loanwalle.com, vinay.kumar@loanwalle.com");
	        $this->email->subject('Loan Disbursal Letter - Loanwalle');
	        $this->email->message($message);
	        
	        if($this->email->send() == true){
	        	$data = 'true';
	        }else{
	        	$data = 'false';
	        }
	        return $data;
        }

        // public function createLoanNo($lead_id)
        // {
        // 	$loan_no = $this->Tasks->generateLoanNo($lead_id);
        // 	print_r($loan_no);
        // }

        public function resendDisbursalMail()
        {
        	if($this->input->post('user_id') == '')
        	{
				$json['errSession'] = 'Session Expired';
				echo json_encode($json);
        	}
			if ($this->input->server('REQUEST_METHOD') == 'POST')
		    {
	        	$this->form_validation->set_rules('lead_id', 'Lead ID', 'required|trim');
	        	$this->form_validation->set_rules('user_id', 'User ID', 'required|trim');
	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
		            echo json_encode($json);
	        	} else {
	        		$lead_id = $this->input->post('lead_id');
	        		$sendLetter = $this->sendDisbursalMail($lead_id);
	        		if($sendLetter == true)
	        		{
						$data = [
							'loanAgreementRequest' 		=> ($sendLetter == true) ? 1 : 0,
							'agrementRequestedDate' 	=> ($sendLetter == true) ? timestamp : '',
						];
			        	$conditions = ['lead_id' => $lead_id];
						$this->Tasks->updateLeads($conditions, $data, 'loan');
	        			$json['msg'] = "SANCTION";
						echo json_encode($json);
	        		} else {
	        			$json['err'] = "FAILED SANCTION";
						echo json_encode($json);
	        		}
			    }
			}
        }

        public function getCustomerBanking()
        {
        	if(!empty($_POST['customer_id']))
        	{
	        	$fetch = 'CB.id, CB.customer_id, CB.lead_id, CB.bank_name, CB.ifsc_code, CB.branch, CB.account, CB.confirm_account, CB.account_type, CB.account_status, CB.remark, CB.created_on, CB.updated_on';
	        	$conditions = ['CB.customer_id' => $_POST['customer_id']];
	        	$join2 = 'LD.customer_id = CB.customer_id';
	        	$allDisbursalBank = $this->Tasks->select($conditions, $fetch, $this->tbl_customer_banking);
	        	$data['allDisbursalBankCount'] = $allDisbursalBank->num_rows();
	        	$data['allDisbursalBank'] = $allDisbursalBank->result();

	        	$disbursalBank = $this->getCustomerDisbBanking($_POST['customer_id']);
	        	$data['disbursalBankCount'] = $disbursalBank->num_rows();
	        	$data['disbursalBank'] = $disbursalBank->row();
	        	echo json_encode($data);
	        }
        }
        
        public function getCustomerDisbBanking($customer_id)
        {
        	$fetch = 'CB.id, CB.customer_id, CB.lead_id, CB.bank_name, CB.ifsc_code, CB.branch, CB.account, CB.confirm_account, CB.account_type, CB.account_status, CB.remark, CB.created_on, CB.updated_on';
        	$conditions = ['CB.customer_id' => $customer_id, 'CB.account_status' => "YES"];
        	$join2 = 'LD.customer_id = CB.customer_id';
        	return $this->Tasks->select($conditions, $fetch, $this->tbl_customer_banking);
        }
		
		public function getCustomerBankDetails()
		{
			if(!isset($_REQUEST['searchTerm'])){ 
		        $json = [];
		    }else{
		        $search = $_REQUEST['searchTerm'];
		        $sql = "SELECT bank.bank_id, bank.bank_ifsc FROM tbl_bank_details as bank
		                WHERE bank_ifsc LIKE '%".$search."%' LIMIT 10"; 
		        $result = $this->db->query($sql);
		        $bankData = $result->result_array(); 
				foreach($bankData as $row){
		            $json[] = ['bank_id'=>$row['bank_id'], 'bank_ifsc'=>$row['bank_ifsc']];
		        } 
		    }
		    echo json_encode($json);
		}

		public function getBankNameByIfscCode()
		{
			if(!empty($this->input->post('ifsc_code')))
			{ 
		        $ifsc_code = $this->input->post('ifsc_code');
		        $result = $this->db->select('bank.bank_name, bank.bank_branch')->where('bank_ifsc', $ifsc_code)->from('tbl_bank_details as bank')->get()->row();
		    	echo json_encode($result);
		    }
		}
		
		// public function loanAgreementLetterResponse($lead_id, $response)
		public function loanAgreementLetterResponse()
		{
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('lead_id', 'Lead ID', 'required|trim|numeric');
	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
	        		echo json_encode($json);
	        	}
	        	else
	        	{
					$lead_id = $this->input->post('lead_id');
					$status = 'DISBURSE-PENDING';
					$stage = 'S13';
		        	$data = [
		                "status" 					=> $status,
		                "loanAgreementResponse" 	=> $this->input->post('response'),
		                "mail" 						=> $this->input->post('email'),
		                "agrementUserIP" 			=> $this->input->post('ip'),
		                "agrementResponseDate" 		=> timestamp,
		        	];

		        	$conditions = ['lead_id' => $lead_id];
					$result = $this->Tasks->updateLeads($conditions, $data, 'loan');
					$this->Tasks->updateLeads($conditions, ['status' => $status, 'stage' => $stage], 'leads');
		        	if($result){
		        	    echo '<p style="text-align : center;"><img src="https://www.loanwalle.com/public/front/images/thumb.PNG" style=" width: 400px; height: 300px;" alt="thumb"></p>
		        	        <p style="text-align : center;">Thanks For Your Response.</p>
		        	    ';
		        	}
				}
			}
		}

		public function addBeneficiary()
		{
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('lead_id', 'Lead ID', 'required|trim');
	        	$this->form_validation->set_rules('user_id', 'User ID', 'required|trim');
	        	$this->form_validation->set_rules('customer_id', 'Customer ID', 'required|trim');
	        	$this->form_validation->set_rules('bankA_C_No', 'Bank A/C No', 'required|trim');
	        	$this->form_validation->set_rules('confBankA_C_No', 'Conf Bank A/C No', 'required|trim');
	        	$this->form_validation->set_rules('customer_ifsc_code', 'Customer ifsc Code', 'required|trim');
	        	$this->form_validation->set_rules('customer_bank_ac_type', 'Customers Bank A/C Type', 'required|trim');
	        	$this->form_validation->set_rules('customer_bank_name', 'Customer Bank Name', 'required|trim');
	        	$this->form_validation->set_rules('customer_bank_branch', 'Customer Bank Branch', 'required|trim');
	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
	        		echo json_encode($json);
	        	}
	        	else
	        	{
					$data = [
					    'lead_id' 					=> $this->input->post('lead_id'),
					    'customer_id' 				=> $this->input->post('customer_id'),
					    'user_id' 					=> $this->input->post('user_id'),
					    // 'company_id' 				=> $this->input->post('company_id'),
					    'account' 					=> $this->input->post('bankA_C_No'),
					    'confirm_account' 			=> $this->input->post('confBankA_C_No'),
					    'ifsc_code' 				=> $this->input->post('customer_ifsc_code'),
					    'account_type' 				=> $this->input->post('customer_bank_ac_type'),
					    'bank_name' 				=> $this->input->post('customer_bank_name'),
					    'branch' 					=> $this->input->post('customer_bank_branch'),
					    'account_status' 			=> 'NO',
					    'remark' 					=> '-',
					    'created_on' 				=> timestamp
					];
	        		
	        		$result = $this->Tasks->insert($data, 'customer_banking');
	        		if($result == 1){
		        		$json['msg'] = 'Beneficiary Added Successfully.';
		        	}else{
		        		$json['err'] = 'Beneficiary Failed to Add. try again';
		        	}
	        		echo json_encode($json);
	        	}
	        }
		}

		public function verifyDisbursalBank()
		{ 
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('lead_id', 'Lead ID', 'required|trim');
	        	$this->form_validation->set_rules('user_id', 'User ID', 'required|trim');
	        	$this->form_validation->set_rules('customer_id', 'Customer ID', 'required|trim');
	        	$this->form_validation->set_rules('list_bank_AC_No', 'Please Select Bank A/C No', 'required|trim');
	        	$this->form_validation->set_rules('bank_ac_verification', 'Bank A/C Verification', 'required|trim');
	        	$this->form_validation->set_rules('remarks', 'Remarks', 'trim');
	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
	        		echo json_encode($json);
	        	}
	        	else
	        	{
	        		$id = $this->input->post('list_bank_AC_No');
	        		$customer_id = $this->input->post('customer_id');
	        		$bankVerification = $this->input->post('bank_ac_verification');
					$conditions2 = ['CB.customer_id' => $customer_id];
					$data2 = ['CB.account_status' => "NO"];
	        		$this->Tasks->globalUpdate($conditions2, $data2, $this->tbl_customer_banking);
					
					$data = [
					    'account_status' 			=> ($bankVerification == "ACCOUNT AND NAME VERIFIED SUCCESSFULLY") ? "YES" : "NO",
					    'remark' 					=> $bankVerification ." - ". $this->input->post('remarks'),
					    'updated_on' 				=> timestamp
					];

					$conditions = ['CB.id' => $id];
	        		$result = $this->Tasks->globalUpdate($conditions, $data, $this->tbl_customer_banking);
	        		if($result == 1){
		        		$json['msg'] = 'Verified Successfully.';
		        	}else{
		        		$json['err'] = 'Failed to Verify. try again';
		        	}
	        		echo json_encode($json);
	        	}
	        }
		}

		public function allowDisbursalToBank()
		{ 
			if($this->input->post('user_id') == '')
			{
				$json['errSession'] = 'Session Expired';
				json_encode($json);
				return false;
			}
			if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('lead_id', 'Lead ID', 'required|trim');
	        	$this->form_validation->set_rules('company_id', 'Company ID', 'required|trim');
	        	$this->form_validation->set_rules('product_id', 'Product ID', 'required|trim');
	        	$this->form_validation->set_rules('user_id', 'Session Expired', 'required|trim');
	        	$this->form_validation->set_rules('payableAccount', 'Payable Account', 'required|trim');
	        	$this->form_validation->set_rules('channel', 'Channel', 'required|trim');
	        	$this->form_validation->set_rules('payable_amount', 'Payable Amount', 'required|trim');
	        	$this->form_validation->set_rules('disbursal_date', 'Disbursal Date', 'required|trim');
	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
	        		echo json_encode($json);
	        		return false;
	        	}
	        	else
	        	{
	        	    $status = 'DISBURSE-PENDING';
	        		$lead_id = $this->input->post('lead_id');
	        		$disbursal_date = $this->input->post('disbursal_date');

	        		$conditions = ['CAM.lead_id' => $lead_id];
	        		$fetch = 'CAM.cam_id, CAM.loan_recommended, CAM.roi, CAM.processing_fee_percent, CAM.disbursal_date, CAM.repayment_date';
	        		$query = $this->Tasks->select($conditions, $fetch, "credit_analysis_memo CAM");
	        		$camDetails = $query->row();
	        		$db_disbursal_date = date("d-m-Y", strtotime($camDetails->disbursal_date));
	        		$input_disbursal_date = date("d-m-Y", strtotime($disbursal_date));

	        		$conditions2 = ['lead_id' => $lead_id];

	        		if($input_disbursal_date != $db_disbursal_date)
	        		{
		        		include ("CAMController.php");
		        		$obj_CAM = new CAMController();
	        			$Arr_input = [
	        				'loan_recommended' 			=> $camDetails->loan_recommended,
	        				'roi' 						=> $camDetails->roi,
							'processing_fee_percent' 	=> $camDetails->processing_fee_percent,
							'disbursal_date' 			=> $disbursal_date,
							'repayment_date' 			=> $camDetails->repayment_date
	        			];
	        			$calcAmount = $obj_CAM->calcAmount($Arr_input);
	        			$CamData = [
	        				'tenure' 				=> $calcAmount->tenure,
	        				'repayment_amount' 		=> $calcAmount->repayment_amount,
	        				'admin_fee' 			=> $calcAmount->admin_fee,
	        				'adminFeeWithGST' 		=> $calcAmount->adminFeeWithGST,
	        				'total_admin_fee' 		=> $calcAmount->total_admin_fee,
	        				'disbursal_date' 		=> $disbursal_date,
	        			];
			// echo "if called : <pre>"; print_r($CamData); exit;
	        			$result = $this->Tasks->updateLeads($conditions2, $CamData, 'credit_analysis_memo');
	        		}
	        		$data = [
	        			'company_id' 			=> $this->input->post('company_id'),
	        			'company_account_no' 	=> $this->input->post('payableAccount'),
	        			'channel' 				=> $this->input->post('channel'),
	        			'payable_amount' 		=> $this->input->post('payable_amount'),
	        			'status' 				=> $status,
	        			'updated_by' 			=> $this->input->post('user_id'),
	        			'updated_on' 			=> timestamp,
	        		];
			// echo "else called : <pre>"; print_r($data); exit;
	        		$result = $this->Tasks->updateLeads($conditions2, $data, 'loan');
	        		if($result == 1){
		        		$json['msg'] = 'Disbursed Successfully.';
	        			echo json_encode($json);
	        			return true;
		        	}else{
		        		$json['err'] = 'Disbursed Failed. try again';
	        			echo json_encode($json);
	        			return false;
		        	}
	        	}
	        }
		}

		// public function PayAmountToCustomer($lead_id)
		// {
		// 	if(!empty($lead_id)) {
		// 		$data = array(
	 //          		'status' 		=>"DISBURSED",
	 //          	);
	 //    		$result = $this->db->where('lead_id', $lead_id)->update('leads', $data);
	 //    		$json = "Paid Successfully";
	 //    		echo json_encode($json);
	 //    	}
		// }

        public function UpdateDisburseReferenceNo()
		{
			if($this->input->post('user_id') == '')
			{
				$json['errSession'] = 'Session Expired';
				json_encode($json);
				return false;
			}
			if($this->input->post('customer_id') == '')
			{
				$json['err'] = 'Customer ID is required.';
				json_encode($json);
				return false;
			}
			if(isset($_FILES["file"]["name"]))  
			{
            	$config['upload_path'] = realpath(FCPATH.'upload');
                $config['allowed_types'] = 'jpg|png|jpeg';  
				$this->upload->initialize($config);
				if(!$this->upload->do_upload('file'))
				{
					$json['err'] = $this->upload->display_errors(); 
		        	echo json_encode($json);
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());
        			$lead_id = $this->input->post('lead_id');
        			$company_id = $this->input->post('company_id');
        			$product_id = $this->input->post('product_id');
        			$user_id = $this->input->post('user_id');
        			$loan_reference_no = $this->input->post('loan_reference_no');
					$image = $data['upload_data']['file_name'];

	                $status = "DISBURSED";
	                $stage = "S14";

		            $data = [
		                'disburse_refrence_no' 	=> $loan_reference_no,
		                'screenshot'        	=> $image,
		                'status'        	    => $status,
		                'updated_by'        	=> $user_id,
		                'updated_on'    		=> timestamp
		            ];
					$data2 = [
						'lead_id' 		=> $lead_id,
						'customer_id' 	=> $this->input->post('customer_id'),
						'user_id' 		=> $this->input->post('user_id'),
						'status' 		=> $status, 
						"stage" 		=> $stage, 
						'remarks' 		=> "DISBURSED",
						'created_on'	=> timestamp
					];
	        		
	        		$conditions = ['lead_id' => $lead_id];
					$result1 = $this->Tasks->updateLeads($conditions, ['status' => $status, 'stage'=>$stage], 'leads');
    			    $result2 = $this->Tasks->updateLeads($conditions, $data, 'loan');
	        		$result3 = $this->Tasks->insert($data2, 'lead_followup');
	        		
	        		if($result1 == 1 && $result2 == 1 && $result3 == 1){
		        		$json['msg'] = 'Loan Disbursed Successfully.';
		        		echo json_encode($json);
						return true;
		        	}else{
		        		$json['err'] = 'Failed to update Reference no, try again';
			        	echo json_encode($json);
						return false;
		        	}
				}   
	        }
		}
        
        public function getAgreementFile($lead_id)
        {
            if(!empty($lead_id))
            {
                $fetchDisburse = 'D.customer_name, D.status, D.loanAgreementLetter';
    			$queryDisburse = $this->Tasks->getAgreementDetails($lead_id, $fetchDisburse);
    			$data = $queryDisburse->row();
                return $data;
            }
        }
        
        public function viewAgreementLetter($lead_id)
        {
            $data = $this->getAgreementFile($lead_id);
            echo $data->loanAgreementLetter;
        }
        
        public function addBankDetails()
        {
            $this->load->view('Disbursal/addBankDetails');
        }





        public function a()
        {
	  //       {
			//     "requestId": "",
			//     "service": "PaymentApi",
			//     "encryptedKey": "oG5mU1JJNBuwQaSLKb3wfRZks/cT2Vo2yBNNuqjNHDWEC144WxC8iKqBpJAgq7reFKC4sHNUmNPRDya1AvmQ7x1L+3EAdEs9FEWNurZuWTvZpk4y7JrGhg0rz9KptBf+JfJUkSMo7NR3Saxel6EYtckkDr3AGW7WJZmhcEoAMMXRws/hLVmaNHC/nOjCNqqBd4IOOAzdJh/HADRVI+YAJKT8dE4x9NTl+UX1zAooWhza+TsWEHfxzQIa7zai7WSa/wiJD3uD7mk5vT1WY/fKJBquCuzM7l35vigDhmb7dLVLuX8VMiNQrtErWNI0uVaag1jg+uZUtyDSxjPFi5yEpKVVc7+T503IDnCvkCFDygqasDsPL24qOjYk4XavTZvwGuPAdYNNkVnLzVElEhg4zS2ye+fa/8fZiMt/3fwYeN9dgn9i5R6VOFbXSuZJYPSci9k0oqz73h1nzFtps60rUEDoGIkGvm9waJU3W78VH5mIdGfGvvJjiKIuVHmi/huzEX9v4w3mW7RDGgmOuKImkqki+XWgyB0JvVmsLdO+cBaym/seZP3+zdfhO9AWSI2tDLD4Vf0jDjzoDSFN2mzUFgHK9mbtbXgvsnReoGqx/KsivzmZNLmDmtg8eR4Z9LnLni4rl4OtkDv5y/mxMtL3MBUUUajkw6OS6NnhEG895yo=",
			//     "oaepHashingAlgorithm": "NONE",
			//     "iv": "",
			//     "encryptedData": "wBJSefFsnJVlobh1cJR553w6Ay6b8/2frCjxvdZ1Bsnxztsul7Ha8lFl4PoZD+IhdlRShWdKgz3yJYIisGV/KKpyMSY3DILOpbkqEa0Qq0g=",
			//     "clientInfo": "",
			//     "optionalParam": ""
			// }

			// Steps for Encryption 
			// 1. Generate 16 digit random number. Say RANDOMNO1. 
			// 2. Encrypt RANDOMNO1 using RSA/ECB/PKCS1Padding and ICICI Public Key. 
			// 3. Encode the output of step 2 using Base64. Say ENCR_KEY. 
			// 4. Generate another 16 digit random number. Say RANDOMNO2. 
			// 5. Concatenate RANDOMNO2 and data in JSON format. Say DATA. DATA = RANDOMNO2 + data in JSON format 
			// 6. Perform AES/CBC/PKCS5Padding encryption on DATA using RANDOMNO1 as key and RANDOMNO2 as IV. 
			// 7. Encode the output of step 6 using Base64. Say ENCR_DATA. Request Packet Body: 

			// { 
			//     "requestId": "LW000001", 
			//     "service": "UPI", 
			//     "encryptedKey": "<<ENCR_KEY>>", // RSA LW000001
			//     "oaepHashingAlgorithm": "NONE", 
			//     "iv": "", 
			//     "encryptedData": "<<ENCR_DATA>>", 
			//     "clientInfo": "", 
			//     "optionalParam": "" 
			// }
		}
        
        public function autoDisbursalCompositeAPI()
        {
			include(APPPATH .'third_party/PHPSecLib/Crypt/Crypt_RSA.php');
			// include(APPPATH .'third_party/PHPSecLib/Math/BigInteger.php');

			$icici_publicKey = file_get_contents(APPPATH.'libraries/ICICIUATpubliccert.txt');
			$rsa = new Crypt_RSA();
			$p = $rsa->loadKey($icici_publicKey);
			echo "<pre>"; print_r($icici_publicKey); exit;
			$plaintext = new Math_BigInteger('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
			$enc = $rsa->_exponentiate($plaintext)->toBytes();
			echo "<pre>"; print_r($enc); exit;

        	date_default_timezone_set("Asia/Calcutta");
        	$currentdate = date('dmYHis');
        	$randumNo1 = $currentdate. rand(10, 99); // 2209202113120657
        	$randumNo2 = $currentdate. rand(10, 99); // 2209202113120657
        	$Encrypt = ($randumNo1 ."u8zdY9yriHGToh466AyQeLzK1VO0DdAn");

        	$ENCR_KEY = base64_encode($Encrypt);












        	$iv = "";
        	$bankAccNo = "20279774002";
        	$beneIFSC = "SBIN0016732";
        	$amount = "1.00";
        	$senderName = "Vinay Kumar";
        	$mobile = "8936962573";
        	// echo "randumNo1 : " . $randumNo1 . "<br>"; 
        	// echo "randumNo2 : " . $randumNo2 . "<br>"; 

        	$apiData = [
				"localTxnDtTime"	=> $currentdate,
				"beneAccNo"			=> $bankAccNo,
				"beneIFSC"			=> $beneIFSC,
				"amount"			=> $amount,
				"tranRefNo"			=> "IC20210316007",
				"paymentRef"		=> "FTTransferP2A",
				"senderName"		=> $senderName,
				"mobile"			=> $mobile,
				"retailerCode"		=> "rcode",
				"passCode"			=> "447c4524c9074b8c97e3a3c40ca7458d",
				"bcID"				=> "IBCKer00055"
			];

			$json = json_encode($apiData);
			$enc_base64data = base64_encode($randumNo2.$json);
			$postData = [
			    "requestId" 			=> "",
			    "service" 				=> "PaymentApi",
			    "encryptedKey" 			=> $ENCR_KEY,
			    "oaepHashingAlgorithm" 	=> "NONE",
			    "iv" 					=> $randumNo2,
			    "encryptedData" 		=> $enc_base64data,
			    "clientInfo" 			=> "",
			    "optionalParam" 		=> ""
			];
			$postJson = json_encode($postData);

			echo "postData : <pre>"; print_r($postJson); exit;
        }
        
		
	}

?>