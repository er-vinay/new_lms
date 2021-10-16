<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class CollectionController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
            $this->load->model('Task_Model', 'Tasks');

	    	$login = new IsLogin();
	    	$login->index();
		}

		public function index()
	    {
	    	$collectionDate = date('Y-m-d', strtotime('+5 days', strtotime(todayDate)));
	    	$todayCollection = $this->db->select('leads.lead_id, leads.name, leads.email, tb_states.state, leads.created_on, leads.source, leads.status, leads.userChecked, leads.partPayment, credit.loan_amount_approved, credit.mobile, credit.customer_id,loan.loan_id, loan.lead_id, loan.loan_no, loan.loan_repay_date, loan.loan_tenure, loan.loan_intrest, loan.loan_repay_amount, loan.loan_repay_date, loan.loan_disburse_date')
				->where('loan.loan_repay_date BETWEEN "'. date('Y-m-d', strtotime(todayDate)). '" and "'. date('Y-m-d', strtotime($collectionDate)).'"')
				->from('loan')
                ->join('credit', 'credit.lead_id = loan.lead_id')
                ->join('leads', 'loan.lead_id = leads.lead_id')
                ->join('tb_states', 'leads.state_id = tb_states.id');
            $todayData = $todayCollection->get();
			$data['taskCount'] = $todayData->num_rows();
			$data['listTask'] = $todayData->result();
            
        	$this->load->view('Collection/index', $data);
	    }

	    public function collectionDetails($lead_id, $refrence_no = null)
	    {
            $table1 = 'leads LD';
            $table2 = 'customer C';
            $join2 	= 'C.customer_id = LD.customer_id';
            $table3 = 'collection CO';
            $join3 	= 'CO.customer_id = LD.customer_id';
            $table4 = 'lead_followup LF';
            $join4 	= 'LF.user_id = LD.state_id';

	        $conditions = ['CO.company_id' => company_id, 'CO.product_id' => product_id, 'CO.lead_id' => $lead_id];
            if($refrence_no != null){
	        	$conditions = ['CO.company_id' => company_id, 'CO.product_id' => product_id, 'CO.lead_id' => $lead_id, 'CO.refrence_no' =>$refrence_no];
            }
	        
            $select = 'LD.lead_id, LD.customer_id, CO.id, CO.loan_no, CO.payment_mode, CO.discount, CO.refund, CO.date_of_recived, CO.received_amount, CO.refrence_no, CO.recovery_status, CO.payment_verification, CO.created_on';
	        $data = $this->Tasks->join_table($conditions, $select, $table1, $table2, $join2, $table3, $join3, $table4, $join4);
	        return $data;	    	
	    }

	    public function getLeadDetail($conditions)
	    {
			$fetech = 'LD.lead_id, LD.customer_id, LD.status, LD.stage';
        	return $this->Tasks->select($conditions, $fetch, 'leads LD');
	    }

	    public function getCAMDetail($conditions)
	    {
			$fetech = 'CAM.cam_id, CAM.lead_id, CAM.customer_id, CAM.loan_recommended, CAM.final_foir_percentage, CAM.foir_enhanced_by, CAM.processing_fee_percent, CAM.roi, CAM.admin_fee, CAM.disbursal_date, CAM.repayment_date, CAM.adminFeeWithGST, CAM.total_admin_fee, CAM.tenure, CAM.net_disbursal_amount, CAM.repayment_amount, CAM.panel_roi';
        	return $this->Tasks->select($conditions, $fetch, 'credit_analysis_memo CAM');
	    }

	    public function calculateRepaymentAmount($lead_id)
	    {
	    	$conditions = ['company_id' => company_id, 'product_id' => product_id, 'lead_id' => $lead_id];
            $sql = $this->getLeadDetail($conditions);
            $leads = $sql->row();
            $fetch = 'CO.date_of_recived, CO.recovery_status';
            $sql1 = $this->getCAMDetail($conditions);
            $sql2 = $this->Tasks->select($conditions, $fetch, 'collection CO');

            $status = $leads->status;
            $stage = $leads->stage;

            $today_data = date('d-m-Y');
            $loan_recommended = 0;
            $roi = 0;
            $panel_roi = 0;
            $disbursal_date = '-';
            $repayment_date = '-';
            $tenure = 0;
            $repayment_amount = 0;
            $d_of_r = '-';

            if($sql1->num_rows() > 0)
            {
            	$cam = $sql1->row();
	        	$loan_recommended 	= (int) $cam->loan_recommended;
	        	$roi 				= (int) $cam->roi;
	        	$panel_roi 			= (int) $cam->panel_roi;
	        	$disbursal_date 		= date('d-m-Y', strtotime($cam->disbursal_date));
	        	$repayment_date 	= date('d-m-Y', strtotime($cam->repayment_date));
	        	$tenure 			= $cam->tenure;
	        	$repayment_amount 	= $cam->repayment_amount;
            }
            if($sql2->num_rows() > 0)
            {
            	$collection 		= $sql2->row();
	        	$d_of_r 			= date('d-m-Y', strtotime($collection->date_of_recived));
            }

            if($status == "CLOSED" || $status =="SETTLED")
            {
	            $date1 = strtotime($d_of_r);
	            $date2 = strtotime($disbursal_date);
	            $date3 = strtotime($repayment_date);
	            $date5 = strtotime($d_of_r);
		        $diff = $date1 - $date2;   
            }else{ 
	            $date1 = strtotime($today_data);
	            $date2 = strtotime($disbursal_date);
	            $date3 = strtotime($repayment_date);
	            $date5 = strtotime($d_of_r);
		        $diff = $date1 - $date2; 
            }

			$tenure = ($date3 - $date2) / (60 * 60 * 24);
            $repayment_amount = $loan_recommended + (($loan_recommended * $roi * $tenure)/100);
            $rtenure = '';
            $ptenure = '';

            if($date1 <= $date3) {
				$realdays = $date1 - $date2;
				$rtenure = ($realdays / 60/60/24);
			} else {
			  	$realdays = $date3 - $date2;
			  	$rtenure = ($realdays / 60/60/24);
			}

			if($date1 <= $date3) {
			  	$realdays = $date1 - $date2;
			 	$ptenure = 0;
			} else {
				$endDate = $date1 - $date3;
				$oneDay = (60*60*24);
				$dateDays60 = ($oneDay * 60);
				$date4 = ($date3 + $dateDays60); // stopped LPI days

				if($endDate <= $dateDays60) {
					$realdays = $date3 - $date2;
					$rtenure = ($realdays / 60/60/24);
					$paneldays = $date1 - $date3;
					$ptenure = ($paneldays / 60/60/24);
				} 
				else{
				    $ptenure = 60;
				}
			}
            $msg = "";

            if($status == "CLOSED")
            {
				if($date5 <= $date3) {
					$paidBeforeDays = ($date3 - $date5) / (60 * 60 * 24);
					$rtenure = $tenure - $paidBeforeDays;
				 	$ptenure = 0;
				 	$msg = ' - paid before '.$paidBeforeDays.' Days back';
				}else{
				    $rtenure;
				    $ptenure;
				}
	        } else if($status == "PART PAYMENT" || $status == "SETTLED" || $status == "WRITEOFF"){
	            $status;
	        } else if($status == "CANCLIED"){
	            $status = $status;
	            if($date5 <= $date3) {
					$rtenure = 0;
				 	$ptenure = 0;
				} else {
				    $rtenure;
				    $ptenure;
				}
	        }

			$realIntrest = ($loan_recommended * $roi * $rtenure) / 100;
			$penaltyIntrest = ($loan_recommended * ($roi * $panel_roi) * $ptenure)/100;
			$repaymentAmt = ($loan_recommended + $realIntrest + $penaltyIntrest);

            $fetch3 = 'SUM(CO.received_amount) as total_paid';
            $conditions3 = ['payment_verification' => 1, 'recovery_status !=' => "REJECT"];
            $sql13 = $this->Tasks->select($conditions3, $fetch3, 'collection CO');
        	$recoveredAmount = $sql13->row();

            $ReceivedAmount = 0;
            if($recoveredAmount->total_paid > 0){
			    $ReceivedAmount = $recoveredAmount->total_paid;
            }
            $todalDue = $repaymentAmt - $ReceivedAmount;

			$data['status'] = $status;
			$data['disbursal_date'] = $disbursal_date;
			$data['repayment_date'] = $repayment_date;
            $data['loan_recommended'] = $loan_recommended;
            $data['roi'] = $roi;
            $data['panel_roi'] = $panel_roi;
            $data['tenure'] = $tenure;
            $data['penalty_days'] = $ptenure;
            $data['real_interest'] = $realIntrest;
			$data['penality_interest'] = $penaltyIntrest;
			$data['repayment_amount'] = $repayment_amount;
			$data['total_repayment_amount'] = $repaymentAmt;
			$data['total_received_amount'] = $ReceivedAmount;
			$data['total_due_amount'] = $todalDue;

    		return $data;
	    }

	    public function repaymentLoanDetails()
	    {
	    	if($this->input->post('user_id') == '')
	    	{
	    		$json['errSession'] = "Session Expired.";
	    		echo json_encode($json);
	    		return false;
	    	}
	    	if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('lead_id', 'Lead Id', 'required|trim');
	        	$this->form_validation->set_rules('customer_id', 'Customer ID', 'required|trim');
	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
		            echo json_encode($json);
	        	} else {
	    			$lead_id = $this->input->post('lead_id');
	    			$customer_id = $this->input->post('customer_id');
	    			$data = $this->calculateRepaymentAmount($lead_id);
    				echo json_encode($data);
	        	}
	    	}
	    }

	    public function collectionHistory()
	    {
	    	if($this->input->post('user_id') == '')
	    	{
	    		$json['errSession'] = "Session Expired.";
	    		echo json_encode($json);
	    		return false;
	    	}
	    	if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('lead_id', 'Lead Id', 'required|trim');
	        	$this->form_validation->set_rules('customer_id', 'Customer ID', 'required|trim');
	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
		            echo json_encode($json);
	        	} else {
	    			$lead_id = $this->input->post('lead_id');
	    			$customer_id = $this->input->post('customer_id');
	    			$sql = $this->collectionDetails($lead_id);
    				$data['recoveryData'] = $this->Tasks->getRecoveryData($sql);
    				echo json_encode($data);
	        	}
	    	}
	    }

	    public function deleteCoustomerPayment()
	    {
	    	if($this->input->post('user_id') == '')
	    	{
	    		$json['errSession'] = "Session Expired.";
	    		echo json_encode($json);
	    		return false;
	    	}
	    	if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('id', 'ID', 'required|trim');
	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
		            echo json_encode($json);
	        	} else {
	    			$lead_id = $this->input->post('lead_id');
	    			$id = $this->input->post('id');
	    			// echo '<pre>'; print_r($_POST); exit;
	    			$conditions = ['id' => $id, 'payment_verification' => 'PENDING'];
    				$result = $this->Tasks->delete($conditions, 'collection');
    				if($result == true)
    				{
    					$json['msg'] = 'Record deleted successfully.';
    				}else{
    					$json['err'] = 'Record can not ne deleted.';
    				}
    				echo json_encode($json);
	        	}
	    	}
	    }

	    public function UpdatePayment()
	    {
			if($this->input->post('user_id') == '')
			{
				$json['errSession'] = 'Session Expired.';
				echo json_encode($json);
        		return false;
			}
	    	if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('lead_id', 'Lead Id', 'required|trim');
	        	$this->form_validation->set_rules('customer_id', 'Customer Id', 'required|trim');
	        	$this->form_validation->set_rules('loan_no', 'Loan No', 'required|trim');
	        	$this->form_validation->set_rules('user_id', 'Session Expired', 'required|trim');
	        	$this->form_validation->set_rules('company_id', 'Company Id', 'required|trim');
	        	$this->form_validation->set_rules('product_id', 'Product Id', 'required|trim');
	        	$this->form_validation->set_rules('received_amount', 'Received Amount', 'required|trim');
	        	$this->form_validation->set_rules('refrence_no', 'Refrence No', 'required|trim');
	        	$this->form_validation->set_rules('payment_mode', 'Payment Mode', 'required|trim');
	        	$this->form_validation->set_rules('repayment_type', 'Payment Type', 'required|trim');
	        	$this->form_validation->set_rules('discount', 'Discount', 'required|trim');
	        	$this->form_validation->set_rules('refund', 'Refund', 'required|trim');
	        	$this->form_validation->set_rules('scm_remarks', 'SCM Remarks', 'required|trim');

	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
		            echo json_encode($json);
            		return false;
	        	} else {
	    			$recovery_id = $this->input->post('recovery_id');
	    			$lead_id = $this->input->post('lead_id');
					$customer_id = $this->input->post('customer_id');
					$loan_no = $this->input->post('loan_no');
					$user_id = $this->input->post('user_id');
					$company_id = $this->input->post('company_id');
					$product_id = $this->input->post('product_id');
					$received_amount = $this->input->post('received_amount');
					$refrence_no = $this->input->post('refrence_no');
					$payment_mode = $this->input->post('payment_mode');
					$repayment_type = $this->input->post('repayment_type');
					$discount = $this->input->post('discount');
					$refund = $this->input->post('refund');
					$scm_remarks = $this->input->post('scm_remarks');
					$ops_remarks = $this->input->post('ops_remarks');
	    			$payment_verification = "PENDING";
	    			$paymentSlips = "";

					$getLeadStatus = $this->Tasks->getLeadStatus($repayment_type);
					$sqlRecovery = $this->collectionDetails($lead_id, $refrence_no);

		            $data = [
						'lead_id'		 	=> $lead_id,
						'company_id'		=> $company_id,
						'product_id'		=> $product_id,
						'customer_id'		=> $customer_id,
						'loan_no'			=> $loan_no,
						'received_amount'	=> $received_amount,
						'refrence_no'		=> $refrence_no,
						'payment_mode'	 	=> $payment_mode,
						'repayment_type'	=> $repayment_type,
						'docs'	 			=> $paymentSlips,
						'discount'	 		=> $discount,
						'refund'	 		=> $refund,
			            'payment_verification'	=> $payment_verification,
						'ip'				=> ip,
						'date_of_recived'	=> timestamp,
		            ];
		            $data2 = [
						'lead_id'		 	=> $lead_id,
						'customer_id'		=> $customer_id,
						'user_id'		 	=> $user_id,
						'status'			=> $getLeadStatus['status'],
						'stage'				=> $getLeadStatus['stage'],
						'created_on'		=> timestamp,
		            ]; 
		            if(isset($recovery_id)) {
						$arr = ['payment_verification' => 'VERIFIED'];
						$data = array_merge($data, $arr);

						$arr2 = ['remarks' => $ops_remarks];
						$data2 = array_merge($data2, $arr2);

			            $result = $this->Tasks->updateLeads($data, 'collection');
			            $result2 = $this->Tasks->insert($data2, 'lead_followup');
			            $json['msg'] = 'Upload Successfully.';
			            echo json_encode($json);

			        } else  if($sqlRecovery->num_rows() == 0 ) {
		    			$config['upload_path'] = 'public/upload/paymentslip';
		                $config['allowed_types'] = 'pdf|jpg|png|jpeg';
						$this->upload->initialize($config);
						if(!$this->upload->do_upload('upload_payment'))
						{
							$json['err'] = $this->upload->display_errors();
		            		echo json_encode($json);
						}
						else
						{
							$data = array('upload_data' => $this->upload->data());
							$paymentSlips = $data['upload_data']['file_name'];
						}
						$arr = ['created_on' => timestamp,];
						$data = array_merge($data, $arr);

						$arr2 = ['remarks' => $scm_remarks];
						$data2 = array_merge($data2, $arr2);

			            $result = $this->Tasks->insert($data, 'collection');
			            $result2 = $this->Tasks->insert($data2, 'lead_followup');
			            $json['msg'] = 'Upload Successfully.';
			            echo json_encode($json);
			        } else  {
			        	$data = $sqlRecovery->row();
			            $json['msg'] = 'Payment already uploaded.';
			            echo json_encode($json);
			        }
		        }
	        }
	    }

	    public function MIS()
	    {
    		$data['MIS'] = $this->Tasks->getMISData();
	    	$this->load->view('MIS/index', $data);
	    }

	    public function getRecoveryData($lead_id)
	    {
    		$getRecoveryData = $this->Tasks->getRecoveryData($lead_id);
    		echo json_encode($getRecoveryData);
    	}

	    public function getPaymentVerification($refrence_no)
	    {
	    	$data = $this->db->where('refrence_no', $refrence_no)->get('recovery')->row_array();
    		echo json_encode($data);
    	}

	    public function verifyCustomerPayment()
	    {
			$recovery_id = $this->input->post('recovery_id');
			$lead_id = $this->input->post('lead_id');
			$loan_no = "";
			
			if(empty($recovery_id)){
			    $loanDetails = $this->db->select('loan.loan_no, loan.customer_id')->where('lead_id', $lead_id)->from('loan')->get()->row();
			    $loan_no = $loanDetails->loan_no;
			    $customer_id = $loanDetails->customer_id;
			} else {
			    $recoveryDetails = $this->db->select('recovery.loan_no')->where('recovery_id', $recovery_id)->from('recovery')->get()->row();
			    $loan_no = $recoveryDetails->loan_no;
			}
			
	    	if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
	        	$this->form_validation->set_rules('lead_id', 'Lead Id', 'required|trim');
	        	$this->form_validation->set_rules('payment_amount', 'Payment Amount', 'required|trim');
	        	$this->form_validation->set_rules('refrence_no', 'Refrence No', 'required|trim');
	        	$this->form_validation->set_rules('payment_mode', 'Payment Mode', 'required|trim');
	        	$this->form_validation->set_rules('payment_type', 'Payment Type', 'required|trim');
	        	$this->form_validation->set_rules('discount', 'Discount', 'required|trim');
	        	$this->form_validation->set_rules('remark', 'Remarks', 'required|trim');

	        	if($this->form_validation->run() == FALSE) {
	        		$json['err'] = validation_errors();
		            echo json_encode($json);
	        	} else {
					$payment_amount     = $this->input->post('payment_amount');
					$refrence_no        = $this->input->post('refrence_no');
					$payment_mode       = $this->input->post('payment_mode');
					$payment_type       = $this->input->post('payment_type');
					$discount           = $this->input->post('discount');
					$remark             = $this->input->post('remark'); 
					$date_of_recived    = $this->input->post('date_of_recived');
					
					$recovery_status = "Approved";
					$dataInsert = [
						'lead_id' 	        => $lead_id,
					    'customer_id' 	    => $customer_id,
						'loan_no' 	        => $loan_no,
						'payment_amount' 	=> $payment_amount,
						'refrence_no' 		=> $refrence_no,
						'payment_mode' 		=> $payment_mode,
						'status' 			=> $payment_type,
						'discount' 			=> $discount,
						'remarks' 			=> $remark,
						'recovery_status' 	=> $recovery_status,
						'date_of_recived' 	=> $date_of_recived,
						'noc' 	            => "Yes",
						'PaymentVerify' 	=> 1,
						'recovery_by' 		=> $_SESSION['isUserSession']['user_id'],
						'updated_by' 		=> $_SESSION['isUserSession']['user_id'],
					]; 
					$data = [
						'loan_no' 	        => $loan_no,
						'payment_amount' 	=> $payment_amount,
						'refrence_no' 		=> $refrence_no,
						'payment_mode' 		=> $payment_mode,
						'status' 			=> $payment_type,
						'discount' 			=> $discount,
						'remarks' 			=> $remark,
						'recovery_status' 	=> $recovery_status,
						'date_of_recived' 	=> $date_of_recived,
						'PaymentVerify' 	=> 1,
						'updated_by' 		=> $_SESSION['isUserSession']['user_id'],
					]; 
					if(empty($recovery_id)) {
					    $result = $this->db->insert('recovery', $dataInsert);
					    $this->db->where('lead_id', $lead_id)->update('leads', ['status' => $payment_type]);
					    
					    if($payment_type == "Full Payment")
					    {
					        $this->NOC_letter($loan_no);
					        
					    }
					} else {
	    			    $result = $this->db->where('lead_id', $lead_id)->where('recovery_id', $recovery_id)->update('recovery', $data);
	    			    $this->db->where('lead_id', $lead_id)->update('leads', ['status' => $payment_type]); 
					}
	    		
	    			if($result == true){
		        		$json['msg'] = "Payment Approved Successfully.";
			            echo json_encode($json);
	    			}else{
	    				$json['err'] = "Payment Failed to Approved.";
			            echo json_encode($json);
	    			}
				}
			}
    	}
    	
    	public function NOC_letter($loan_no)
    	{
    	    $result =  $this->db->select('l.loan_no, l.loan_amount, l.customer_name, l.email, l.created_on as loaninitiatedDate, r.created_on as recInitiatedDate')
    	            ->where('l.loan_no', $loan_no)
    	            ->where('r.status', "Full Payment")
    	            ->from('loan l')
    	            ->join('recovery r', 'r.loan_no = l.loan_no');
    	    $sql = $result->get()->row();
    	    $query = $this->db->select_sum('payment_amount')->where('loan_no', $loan_no)->from('recovery')->get()->row();
    	    
    	    $loanCloserDate = date('d-M-Y', strtotime(updated_at));
    	   // $to = $sql->email;
    	    $to = "vinaykumarfd@gmail.com";
    	    
	        $loanInitiatedDate = date('d-m-Y', strtotime($sql->loaninitiatedDate));
    	    if(empty($loanInitiatedDate)){
    	        $loanInitiatedDate = date('d-m-Y', strtotime($sql->loaninitiatedDate));
    	    };
    	    
	        $recInitiatedDate = date('d-m-Y', strtotime($sql->recInitiatedDate));
    	    if(empty($recInitiatedDate)){
    	        $recInitiatedDate = date('d-m-Y', strtotime($sql->recInitiatedDate));
    	    };
    	    
    	    $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Loan Against Card</title>
				</head>
				<body>


				<table width="778" border="0" align="center" cellpadding="0" cellspacing="0" style="padding:10px; border:solid 1px #ccc; font-family:Arial, Helvetica, sans-serif;">
				  <tr>
				    <td align="left"><img src="https://loanagainstcard.com/wp-content/uploads/2020/04/logo-final.png" width="234" height="50" /></td>
				  </tr>
				  <tr>
				    <td><hr style="background:#ddd !important;"></td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td align="center" valign="top"><strong>No Objection Certificate</strong></td>
				  </tr>
				  <tr>
				    <td align="center" valign="top">&nbsp;</td>
				  </tr>
				  <tr>
				    <td align="left" valign="top"><strong style="line-height:25px;">Date : '. $loanCloserDate .'</strong></td>
				  </tr>
				  <tr>
				    <td align="left" valign="top"><strong style="line-height:25px;">Loan No. : '. $sql->loan_no .'</strong></td>
				  </tr>
				  <tr>
				    <td align="left" valign="top"><strong style="line-height:25px;">Mr/Ms '. $sql->customer_name .'</strong></td>
				  </tr>
				  <tr>
				    <td align="left" valign="top">&nbsp;</td>
				  </tr>
				  <tr>
				    <td align="left" valign="top"><span style="font-size:17px;
				    line-height: 25px;
				    padding-bottom: 6px; text-align:justify;">This is to certify that Mr/Ms '. $sql->customer_name .' who had taken a short-term loan from 
				    Naman Finlease Pvt. Ltd. for Rs '. $sql->loan_amount .' on '. $loanInitiatedDate .' has repaid Rs '. $query->payment_amount .' on '. $recInitiatedDate .'</span></td>
				  </tr>
				  <tr>
				    <td align="left" valign="top"><span style="font-size:17px;
				    line-height: 25px;
				    padding-bottom: 6px; text-align:justify;">This is the full amount which was due from him/her, including interest.</span> </td>
				  </tr>
				  <tr>
				    <td align="left" valign="top"><span style="font-size:17px;
				    line-height: 25px;
				    padding-bottom: 6px; text-align:justify;">Hence, there are no more dues from Mr/Ms '. $sql->customer_name .' against loan taken by him/her from Naman Finlease Pvt. Ltd.</span><br /><br /> </td>
				  </tr>
				  <tr>
				    <td align="left" valign="top"><span style="font-size:17px;
				    line-height: 25px;
				    padding-bottom: 6px; text-align:justify; margin:10px 0px;"><strong>For Naman Finlease Pvt Ltd </strong></span></td>
				  </tr>
				  <tr>
				    <td align="left" valign="top"><span style="font-size:17px;
				    line-height: 25px;
				    padding-bottom: 6px; text-align:justify; margin:10px 0px;"><strong>Authorised Signatory</strong></span></td>
				  </tr>
				  <tr>
				    <td><img src="'. base_url('public/front/') .'images/Authorised-Signatory.jpg" width="184" height="97" /></td>
				  </tr>
				  <tr>
				    <td style="margin-top:20px;">&nbsp;</td>
				  </tr>
				  <tr>
				    <td style="margin-top:20px;"><span style="font-size:17px;
				    line-height:20px;
				    padding-bottom: 6px; text-align:justify; margin:20px 0px;"><strong>* This is Computer generated document, hence does not require any signature</strong></span></td>
				  </tr>
				  <tr>
				    <td style="margin-top:20px;">&nbsp;</td>
				  </tr>
				  <tr>
				    <td><strong style="color:#2e5f8b;">Naman Finlease Pvt. Ltd. </strong></td>
				  </tr>
				  <tr>
				    <td><span style="font-size:17px;
				    line-height: 25px;
				    padding-bottom: 6px; text-align:justify;">S-370, Basement, Panchsheel Enclave,</span> </td>
				  </tr>
				  <tr>
				    <td><span style="font-size:17px;
				    line-height: 25px;
				    padding-bottom: 6px; text-align:justify;">New Delhi-110017</span></td>
				  </tr>
				  <tr>
				    <td><span style="font-size:17px;
				    line-height: 25px;
				    padding-bottom: 6px; text-align:justify; margin:10px 0px;"><a href="mailto:docs@loanagainstcard.com" style="text-decoration:blink;">docs@loanagainstcard.com</a></span></td>
				  </tr>
				  <tr>
				    <td><span style="font-size:17px;
				    line-height: 25px;
				    padding-bottom: 6px; text-align:justify; margin:10px 0px;"><a href="https://loanagainstcard.com/" target="_blank" style="text-decoration:blink;">www.loanagainstcard.com</a></span></td>
				  </tr>
				  <tr>
				    <td align="left">&nbsp;</td>
				  </tr>
				</table>
				</body>
				</html>
                ';
                
                $config['protocol']    = 'ssmtp';
                $config['smtp_host']    = 'ssl://ssmtp.gmail.com';
                $config['smtp_port']    = '465';
                $config['smtp_timeout'] = '7';
                $config['smtp_user']    = 'info@loanwalle.com';
                // $config['smtp_pass']    = 'password';
                $config['charset']    = 'utf-8';
                $config['newline']    = "\r\n";
                $config['mailtype'] = 'html'; // or html
                $config['validation'] = TRUE; // bool whether to validate email or not 
                
                $this->load->library('email');
                $this->email->initialize($config);
                // $this->email->set_newline("\r\n");
                $this->email->from('info@loanwalle.com');
                $this->email->to($sendData['email_to']); 
                $this->email->bcc("vipin@loanwalle.com, vinaykumarfd@gmail.com, darpanverma72@gmail.com");
                $this->email->subject('NOC Letter');
                $this->email->message($sendData['message']);
                $this->email->send();
		    
    	}
	}

?>