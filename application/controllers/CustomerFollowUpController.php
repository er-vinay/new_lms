<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class CustomerFollowUpController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
            $this->load->model('Task_Model');

	    	$login = new IsLogin();
	    	$login->index();
		}

		public function index()
	    {
            $this->db->select('leads.lead_id, leads.name, leads.email, tb_states.state, leads.created_on, leads.source, leads.status, leads.userChecked, leads.partPayment')
                ->where('date(leads.created_on)', todayDate)
                ->where('leads.leads_duplicate', 0)
                ->where('leads.lead_rejected', 0)
                ->from(tableLeads)
                ->join('tb_states', 'leads.state_id = tb_states.id');
            $query = $this->db->order_by('leads.lead_id', 'desc')->get();
			$data['taskCount'] = $query->num_rows();
			$data['listTask'] = $query->result();
            
        	$this->load->view('Tasks/GetLeadTaskList', $data);
	    }

	    public function CustomerFollowUp($lead_id)
	    {
            $this->db->select('leads.lead_id, leads.name, leads.email, tb_states.state, leads.created_on, leads.source, leads.status, leads.userChecked, leads.partPayment, credit.loan_amount_approved, credit.mobile, credit.customer_id, loan.loan_no, loan.loan_tenure, loan.loan_intrest, loan.loan_repay_amount, loan.loan_repay_date, loan.loan_disburse_date')
                // ->where('date(leads.created_on)', todayDate)
            	->where('leads.lead_id', $lead_id)
                // ->where('leads.leads_duplicate', 0)
                // ->where('leads.lead_rejected', 0)
                ->from(tableLeads)
                ->join('credit', 'credit.lead_id = leads.lead_id')
                ->join('loan', 'loan.lead_id = leads.lead_id')
                ->join('tb_states', 'leads.state_id = tb_states.id');
            $query = $this->db->order_by('leads.lead_id', 'desc')->get();
			$data['customerDetails'] = $query->row();
            
        	$this->load->view('FollowUp/index', $data);
	    }

	}

?>