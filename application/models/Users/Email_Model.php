<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	 
    class Email_Model extends CI_Model
    {
        private $table_email_credentails = 'tbl_email_credentails';
        private $table_send_mail = 'ftc_send_mail';
		
		public function getAuthMail($company_id, $product_id)
		{
		    $where = array('company_id' => $company_id, 'product_id' => $product_id);
	        return $this->db->select('*')->where($where)->from($this->table_email_credentails)->get();
		}
		
		public function getMailAndSendTocustomer($company_id, $product_id, $mail_type)
		{
		    $where = array('company_id' => $company_id, 'product_id' => $product_id, 'mail_type'=> $mail_type, 'is_active'=> 1);
	        return $this->db->select('*')->where($where)->from($this->table_send_mail)->get();
		}
    }
?>