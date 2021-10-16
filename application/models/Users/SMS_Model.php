<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	 
    class SMS_Model extends CI_Model
    {
        private $table_send_sms = 'ftc_send_sms';
		
		public function getRejectionSMS($company_id, $product_id)
		{
		    $where = array('company_id' => $company_id, 'product_id' => $product_id, 'sms_type'=> "Reject", 'is_active'=> 1);
	        return $this->db->select('message')->where($where)->from($this->table_send_sms)->get();
		}
		
	    public function notification($mobile, $msg)
		{
			$username = urlencode("namanfinl");
			$password = urlencode("6I1c0TdZ");
			$message = urlencode($msg);
			$destination = $mobile;
			$source = "LOANPL";
			$type = "0";
			$dlr = "1";
			
			$data = "username=$username&password=$password&type=$type&dlr=$dlr&destination=$destination&source=$source&message=$message";
			$url = "http://sms6.rmlconnect.net/bulksms/bulksms";
			
			$ch = curl_init();
			curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $data
				));
			$output = curl_exec($ch);
			curl_close($ch);
		} 
    }
?>