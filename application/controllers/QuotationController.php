<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class QuotationController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
	        $this->load->database();
	        $this->load->library('session');
	        $this->load->helper('form');
	        $this->load->library('encrypt');
	        if($_SESSION['email'] == ''){
	        	return redirect(base_url());
	        }
		}

		public function get_Quotation_Name()
		{
			print_r($_POST);exit;
		}

	}

?>