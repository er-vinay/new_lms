<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class PromotionalSmsDndController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
	        $this->load->database();
	        $this->load->library('session');
	        $this->load->helper('form');
	        $this->load->library('encrypt');
        	$this->load->library('email');
	        if($_SESSION['email'] != ''){
	        	// $this->index();
	        }else{
                return redirect(base_url());
            }
		}

		public function index()
	    {
			date_default_timezone_set('Asia/Kolkata');
	    	$data['order_no'] = md5(date("d/m/Y H:i:s"));
	    	$email = $_SESSION['email'];
	    	$agent = $this->db->where('email', $email)->get('tbl_agent')->row_array();
	    	$data['agent_id'] = $agent['id'];
	    	$data['admin_id'] = $agent['master_admin_id'];
	        $data['sub_service'] = $this->db->select('tbl_sub_service.name')->get('tbl_sub_service')->result_array();

	        $this->load->view('DashboardAdmin/Quotation/index', $data);
	    }

	    public function view()
	    {
	    	$email = $_SESSION['email'];
	    	$agent = $this->db->where('email', $email)->get('tbl_agent')->row_array();
	    	$agent_id = $agent['id'];

	    	$this->db->select('*')
			    ->where('tbl_agent.id', $agent_id)
			    ->from('tbl_agent')
			    ->join('tbl_promotional_sms_dnd', 'tbl_agent.id = tbl_promotional_sms_dnd.agent_id');
			$data['promotionalSmsDND'] = $this->db->order_by('tbl_promotional_sms_dnd.id', 'desc')->get()->result_array();

	    	$this->load->view('DashboardAdmin/Quotation/view_quotation', $data);
	    }

	    public function add()
	    {
	        if($this->input->server('REQUEST_METHOD') == 'POST')
	        {
	        	$agent_id = $this->input->post('agent_id');
	        	$master_admin_id = $this->input->post('admin_id');
	        	$volume_of_sms = $this->input->post('volume_of_sms');
	        	$project_details = $this->input->post('project_details');
	        	$keyword = $this->input->post('keyword');
	        	$price = $this->input->post('price');
	        	$gst = $this->input->post('gst');

	        	$tax = '';
	        	$volume = '';
	        	$project = '';
	        	$gst_check = '';
	        	$keyWord = '';
	        	$total_price_with_GST = '';
	        	$per_sms_price = '';

	        	if($volume_of_sms != ''){
	        		$volume = $volume_of_sms;
	        		$per_sms_price = $price / 100;
		        	$new_price = $volume_of_sms * $per_sms_price;

		        	if($gst == 1){
		        		$gst_check = 1;
		        		$tax = ($new_price * 18) / 100;
	        	 		$total_price_with_GST = $new_price + $tax;
		        	}else{
		        		$gst_check = 0;
		        		$tax = 0;
	        	 		$total_price_with_GST = $new_price + $tax;
		        	}
	        	}

	        	if($project_details != ''){
	        		$project = $project_details;
	        		$per_sms_price = '';
	        		$new_price = $price;
		        	if($gst == 1){
		        		$gst_check = 1;
		        		$tax = ($price * 18) / 100;
	        	 		$total_price_with_GST = $price + $tax;
		        	}else{
		        		$gst_check = 0;
		        		$tax = 0;
	        	 		$total_price_with_GST = $price + $tax;
		        	}
	        	}

	        	if($keyword != ''){
	        		$keyWord = $keyword;
	        	}else{
	        		$keyWord;
	        	}

	        	$data = array(
	        		'agent_id' 				=> $agent_id,
	        		'master_admin_id' 		=> $master_admin_id,
	        		'prepare' 				=> $this->input->post('prepare'),
	        		'client_email' 			=> $this->input->post('client_email'),
	        		'client_mobile' 		=> $this->input->post('client_mobile'),
	        		'quote' 				=> $this->input->post('quote'),
	        		'service' 				=> $this->input->post('description'),
	        		'keyword' 				=> $keyWord,
	        		'project_details' 		=> $project,
	        		'volume' 				=> $volume,
	        		'price' 				=> $per_sms_price,
	        		'unit_price' 			=> $new_price,
	        		'total' 				=> $new_price,
	        		'gst' 					=> $gst_check,
	        		'total_amount' 			=> $total_price_with_GST,
	        		'start_date' 			=> $this->input->post('start_date'),
	        		'end_date' 				=> $this->input->post('end_date'),
	        	);

	        	$quote_id = $this->input->post('quote_id');

	        	if(empty($quote_id)){
                	$result = $this->db->insert('tbl_promotional_sms_dnd', $data);
                	echo json_encode($result);
                }else{
                	$result = $this->db->where('id', $quote_id)->update('tbl_promotional_sms_dnd', $data);
                	echo json_encode($result);
                }
	        }else{
	        	$this->load->view('DashboardAdmin/Quotation/index');
	        }
	    }

	    public function calculate()
	    {
	    	$volume_of_sms = $this->input->post('volume_of_sms');
	    	$project_details = $this->input->post('project_details');
	    	$keyword = $this->input->post('keyword');
        	$gst = $this->input->post('gst');
        	$price = $this->input->post('price');
        	echo "price : ".$price;
	    	if($volume_of_sms) {

	        	$tax = '';
	        	$total_price_with_GST = '';

	        	$per_sms_price = $price / 100;
	        	$new_price = $volume_of_sms * $per_sms_price;

	        	if($gst == 1) {
	        		$tax = ($new_price * 18) / 100;
        	 		$total_price_with_GST = $new_price + $tax;
	        	} else {
	        		$tax = 0;
        	 		$total_price_with_GST = $new_price + $tax;
	        	}
	        }else{
	        	if($gst == 1) {
	        		$tax = ($price * 18) / 100;
        	 		$total_price_with_GST = $price + $tax;
	        	} else {
	        		$tax = 0;
        	 		$total_price_with_GST = $price + $tax;
	        	}
	        }

	        if($project_details != '' || $keyword) {

	        	if($gst == 1) {
	        		$tax = ($price * 18) / 100;
        	 		$total_price_with_GST = $price + $tax;
	        	} else {
	        		$tax = 0;
        	 		$total_price_with_GST = $price + $tax;
	        	}
	        }
	        echo json_encode($total_price_with_GST);
	    }
    
	    public function add_place_order_gst()
	    {
	    	if($this->input->server('REQUEST_METHOD') == 'POST')
	        {
	        	$gst = $this->input->post('gst');
	        	$price = $this->input->post('price');
	        	$volume_of_sms = $this->input->post('volume_of_sms');
	        	$project_details = $this->input->post('project_details');
	        	$keyword = $this->input->post('keyword');

	        	$tax = '';
	        	$volume = '';
	        	$project = '';
	        	$total_price_with_GST = '';

	        	if($volume_of_sms){
	        		$volume = $volume_of_sms;
	        		$per_sms_price = $price / 100;
		        	$new_price = $volume_of_sms * $per_sms_price;

		        	if($gst == 1){
		        		$tax = ($new_price * 18) / 100;
	        	 		$total_price_with_GST = $new_price + $tax;
		        	}else{
		        		$tax = 0;
	        	 		$total_price_with_GST = $new_price + $tax;
		        	}
	        	}else{
		        	if($gst == 1) {
		        		$tax = ($price * 18) / 100;
	        	 		$total_price_with_GST = $price + $tax;
		        	} else {
		        		$tax = 0;
	        	 		$total_price_with_GST = $price + $tax;
		        	}
		        }

	        	if($project_details != '' || $keyword != '') {
		        	if($gst == 1) {
		        		$tax = ($price * 18) / 100;
	        	 		$total_price_with_GST = $price + $tax;
		        	}else{
		        		$tax = 0;
	        	 		$total_price_with_GST = $price;
		        	}
	        	}

            	echo json_encode($total_price_with_GST);	
            }
	    }

	    public function agent_edit_quotation($id)
	    {
	    	if(!empty($id)){
	    		$data['quote'] = $this->db->where('id', $id)->get('tbl_promotional_sms_dnd')->row_array();
	    		$this->load->view('DashboardAdmin/Quotation/edit', $data);
	    	}
	    }

	    public function generate_PDF($id)
	    {
			$email = $_SESSION['email'];
	    	$agent = $this->db->where('email', $email)->get('tbl_agent')->row_array();
	    	$agent_id = $agent['id'];

	    	$data['record'] = $this->db->where('id', $id)->where('agent_id', $agent_id)->get('tbl_promotional_sms_dnd')->row_array();

        	$mpdf = new \Mpdf\Mpdf();
        	// $mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '']);
        	$mpdf->SetProtection(array());
	        $html = $this->load->view('pdf', $data, true);
	    	// echo "<pre>"; print_r($html); echo "</pre>"; exit;
	        $mpdf->WriteHTML($html);
	        $mpdf->defaultfooterline = 1;
	        $mpdf->Output();
	    }

	    public function send_sms_with_mail()
	    {
	    	if($this->input->server('REQUEST_METHOD') == 'POST')
	        {
	        	$agent_email = $this->input->post('agent_email');
	        	$client_email = $this->input->post('client_email');
	        	$client_mobile = $this->input->post('client_mobile');

                $journalName = str_replace(' ', '_', $_FILES['image']['name']);
                $config['file_name'] = time() . $journalName;
            	$config['upload_path'] = './public/uploads/';
				$config['allowed_types'] = 'pdf|doc|docx';
                $this->upload->initialize($config);
                $this->upload->do_upload('image');
                $file = $config['file_name'];

	        	$this->send_mail($agent_email, $client_email, $client_mobile, $file);
		    }
		}

	    public function send_mail($agent_email, $client_email, $client_mobile, $file)
	    {	
        	$subject = "Quotation From Designhost.in";
        	$message = "Please Check Quotation";

			$config = Array(
				'mailpath' 	=> '/usr/sbin/sendmail',
                'protocol'	=> 'smtp',
          		'smtp_host'	=> 'ssl://smtp.gmail.com',
          		'smtp_port'	=> 465,
          		'mailtype'  => 'html', 
          		'charset'   => 'iso-8859-1'
			);

			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($agent_email);
			$this->email->to($client_email);
			$this->email->subject($subject);
			$this->email->message($message);
        
        	$files = '';
        
        	if($file){
        		$files = $_SERVER['DOCUMENT_ROOT'].'/crm/public/uploads/'.$file;
            }else{
        		$files = $_SERVER['DOCUMENT_ROOT'].'/public/uploads/'.$file;
            }
        
            $this->email->attach($files);
			if($this->email->send())
			{
				$this->send_notification($client_mobile);
				$this->session->set_flashdata('msg', 'Email and SMS Send Successfully!');
            	return redirect(base_url('admin-view-pro-sms-dnd'), 'refresh');
			}
			else
			{
				show_error($this->email->print_debugger());
				$this->session->set_flashdata('err', 'Failed to send Email and SMS!');
            	return redirect(base_url('admin-view-pro-sms-dnd'), 'refresh');
			}
	    }

	    public function send_notification($client_mobile)
	    {
	        $message = "<p>SMS From www.designhost.in
	        	<p>
	        		Please check your Email<br/>
	        		Quotation Send Successfully!
	        	</p>
	        ";

	        $parampro['uname'] = "divyatest";
	        $parampro['password'] = "123456";
	        $parampro['sender'] = "DZNHST";
	        $parampro['receiver'] = $client_mobile;
	        $parampro['route'] = "TA";
	        $parampro['msgtype'] = "1";
	        $parampro['sms'] = $message;

			$urlpro = "http://sendsms.designhost.in/index.php/smsapi/httpapi/?". http_build_query($parampro);
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $urlpro);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        $resultpro = curl_exec($ch);

			$this->session->set_flashdata('msg', 'SMS Send Successfully!');
	    }

	}

?>