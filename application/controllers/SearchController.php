<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class SearchController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
            $this->load->model('Task_Model');
            $this->load->model('Admin_Model');

	    	$login = new IsLogin();
	    	$login->index();
		}
	    
	    public function index() 
	    {
	    	$this->load->view('Search/index');
	    }

		public function filter()
		{ 
			$loan_no = $this->input->post('loan_no');
			$pancard = $this->input->post('pancard');
			$name = $this->input->post('name');
			$mobile = $this->input->post('mobile');
			$application_no = $this->input->post('application_no'); 
			$aadhar = $this->input->post('aadhar');
			$cif = $this->input->post('cif');
     
   //    		$querySearch = "SELECT L.lead_id, C.customer_id, C.borrower_name as name, C.email, C.mobile, C.pancard, C.loan_recomended as loan_amount_approved, C.status as credit_status, L.status, C.cam_created_date as credit_date, 
   //    		L.created_on as lead_date, L.city  
   //    		FROM tbl_cam C 
   //    		JOIN leads L ON C.lead_id = L.lead_id ";
			
			// if(!empty($loan_no)){
			// 	$querySearch .= "INNER JOIN loan LL ON C.lead_id=LL.lead_id AND LL.loan_no LIKE'".$loan_no."%'" ;
			// } if(!empty($pancard)){
			// 	$querySearch .= " AND C.pancard LIKE'".$pancard."%'";
			// } if(!empty($name)){
			// 	$querySearch .= " AND C.borrower_name LIKE '".$name."%'";
			// } if(!empty($mobile)){
			// 	$querySearch .= " AND C.mobile LIKE'".$mobile."%'";
			// } if(!empty($application_no)){
			// 	$querySearch .= " AND L.application_no LIKE'".$application_no."%'"; 
			// } if(!empty($aadhar)){
			// 	$querySearch .= " AND C.aadhar LIKE'".$aadhar."%'";
			// } if(!empty($cif)){
			// 	$querySearch .= " AND C.customer_id LIKE'".$cif."%'";
			// }
   //    		$querySearch .= " ORDER BY C.lead_id DESC";
      		if($name){
	      		$querySearch = "SELECT L.lead_id, L.customer_id, L.name as name, L.email, L.mobile, L.pancard, L.loan_amount as loan_amount_approved, L.status as credit_status, L.status, L.created_on as credit_date, L.created_on as lead_date, L.city  
	      		FROM leads L";
	      	}else{
	      		$querySearch = "SELECT L.lead_id, C.customer_id, C.borrower_name as name, C.email, C.mobile, C.pancard, C.loan_recomended as loan_amount_approved, C.status as credit_status, L.status, C.cam_created_date as credit_date, 
	      		L.created_on as lead_date, L.city  
	      		FROM leads L 
	      		LEFT JOIN tbl_cam C ON C.lead_id = L.lead_id ";
	      	}
			
			if(!empty($loan_no)){
				$querySearch .= "INNER JOIN loan LL ON L.lead_id=LL.lead_id AND LL.loan_no LIKE'".$loan_no."%'" ;
			} if(!empty($pancard)){
				$querySearch .= " AND C.pancard LIKE'".$pancard."%'";
			} if(!empty($name)){
				$querySearch .= " where L.name LIKE '".$name."%'";
			} if(!empty($mobile)){
				$querySearch .= " AND C.mobile LIKE'".$mobile."%'";
			} if(!empty($application_no)){
				$querySearch .= " AND L.application_no LIKE'".$application_no."%'"; 
			} if(!empty($aadhar)){
				$querySearch .= " AND C.aadhar LIKE'".$aadhar."%'";
			} if(!empty($cif)){
				$querySearch .= " AND C.customer_id LIKE'".$cif."%'";
			}
      		$querySearch .= " ORDER BY L.lead_id DESC";



			$query = $this->db->query($querySearch);
			if($this->session->userdata['isUserSession']['role'] == 'Recovery' || 
				$this->session->userdata['isUserSession']['role'] == 'MIS' || 
				$this->session->userdata['isUserSession']['role'] == 'Admin') {
				$url = 'leads';
			}else{
				$url = 'leadDetails';
			}
			$datatable = '<table class="table dt-table table-striped table-bordered table-responsive table-hover" style="border: 1px solid #dde2eb">
					<thead>
						<tr>
							<th><b>#</b></th>
							<th><b>Lead&nbsp;ID</b></th>
							<th><b>Customer&nbsp;ID</b></th>
							<th><b>Borrower&nbsp;Name</b></th>
							<th><b>Email</b></th>
							<th><b>Mobile</b></th>
							<th><b>Pancard</b></th>
							<th><b>Branch</b></th>
							<th><b>Loan&nbsp;Amount</b></th>
							<th><b>Status</b></th>
							<th><b>Initiated&nbsp;Date</b></th>
							<th><b>Credit&nbsp;Date</b></th>
							<th><b>Action</b></th>
						</tr>
					</thead>
					<tbody>';
		    $i = 1;
		    if($query->num_rows() > 0) {
		      	foreach($query->result() as $row) 
		      	{
	            	$datatable .='<tr>
            			<td>'.$i++.'</td>
            			<td>'.$row->lead_id.'</td>
            			<td>'.$row->customer_id.'</td>
            			<td>'.$row->name.'</td>
            			<td>'.$row->email.'</td>
            			<td>'.$row->mobile.'</td>
            			<td>'.$row->pancard.'</td>
            			<td>'.$row->city.'</td>
            			<td>'.$row->loan_amount_approved.'</td>
            			<td>'.$row->status.'</td>
            			<td>'.$row->lead_date.'</td>
            			<td>'.$row->credit_date.'</td>
            			<td><a href="'. base_url("getleadDetails/". $this->encrypt->encode($row->lead_id)) .'" class="" id="viewLeadsDetails"><i class="fa fa-pencil-square-o" title="View Costomer Details"></i></a></td></tr>';
	           	}
	       	} else { 
	            $datatable .='<tr><td colspan="13" style="text-align: center;color : red;">No Record Found...</td></tr>';
	        }
            $datatable .='</tbody></table>';
			echo json_encode($datatable);
	 	}

	 	public function exportData()
	 	{
	 	    $data['filterMenu'] = $this->db->select('m.filter_id, m.sub_menu_id, m.name')->from('tbl_filter_sub_menu  m')->get();
	    	$this->load->view('Export/export', $data);
	 	}

	 	public function exportReport()
	 	{
	 		$exportUrl = $this->input->post('exportUrl');
	 		$exportReport = $this->input->post('exportReport');

	 		if ($this->input->server('REQUEST_METHOD') == 'POST') 
	        {
		    	$this->form_validation->set_rules('toDate', 'To Date', 'trim|required');
		    	$this->form_validation->set_rules('fromDate', 'From Date', 'trim|required');
	            if ($this->form_validation->run() == FALSE) 
	            {
	        		$this->session->set_flashdata('err', validation_errors());
		            return redirect(base_url('exportData/'.$exportReport), 'refresh');
	            }
	            else
	            {
 					$toDate = $this->input->post('toDate');
 					$fromDate = $this->input->post('fromDate');
	 				echo "<pre>"; print_r($_POST); exit;

	            }
	        }
	 	}
	}

?>