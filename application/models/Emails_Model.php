<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
    class Emails_Model extends CI_Model{
    	function __construct()  
		{
			parent::__construct();  
		}

		public function index()  
		{
			$query = $this->db->where('id', $agent_id)->get('tbl_agent')->row_array();
			return $query;
		}

		public function SendDesbursalMail($loanDetails)  
		{
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
                            <td width="381" align="left"><img src="https://www.loanwalle.com/public/front/images/logo.png" class="img-responsive" alt="logo"/></td>
                            <td width="11" align="left">&nbsp;</td>
                            <td width="384" align="right">
                               <table width="100%" border="0">
                                  <tr>
                                     <td align="right"><strong style="line-height:25px;">Dear &nbsp;'. $loanDetails->customer_name .'</strong></td>
                                  </tr>
                                  <tr>
                                     <td align="right">Loan No.: '. $loanDetails->loan_no .'</td>
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
                            <td><strong>Loanwalle app Lead partner of Loanwalle.com</strong></td>
                            <td>&nbsp;</td>
                            <td rowspan="4" align="center" valign="top"><img class="img-responsive" src="'. base_url()."public/img/image-loan.jpg" .'" width="384" height="406" / style="border:solid 1px #ccc; padding:10px;"></td>
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
                                     <td width="58%" bgcolor="#FFFFFF" style="padding:10px;">'. $loanDetails->customer_name .'</td>
                                  </tr>
                                  <tr>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">Loan Amount</td>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">Rs. '. ($loanDetails->loan_amount + $loanDetails->processing_fee).' /- </td>
                                  </tr>
                                  <tr>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">Rate of Interest </td>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">'. $loanDetails->loan_intrest .' per day</td>
                                  </tr>
                                  <tr>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">Disbursal Date</td>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">'. $loanDetails->loan_disburse_date .' </td>
                                  </tr>
                                  <tr>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">Commitment Payback Date</td>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">'. $loanDetails->loan_repay_date .'</td>
                                  </tr>
                                  <tr>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">Repayment Amount</td>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">'. $loanDetails->loan_repay_amount .' </td>
                                  </tr>
                                  <tr>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">Period</td>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">'. $loanDetails->loan_tenure .' </td>
                                  </tr>
                                  <tr>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">Penalty (%)</td>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">2.00</td>
                                  </tr>
                                  <tr>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">Administrative Fee </td>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">Rs. '. $loanDetails->processing_fee .'/-</td>
                                  </tr>
                                  <tr>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">Repayment Cheque(s)</td>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">&nbsp;</td>
                                  </tr>
                                  <tr>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">Cheque drawn on (Bank Name) </td>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">&nbsp;</td>
                                  </tr>
                                  <tr>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">Cheque &amp;NACHBouncing  Charges </td>
                                     <td bgcolor="#FFFFFF" style="padding:10px;">Rs. 1000.00/- every time</td>
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
                      </table>
                   </body>
                </html>
            ';
            $from = 'info@loanwalle.com';
            
            $config['protocol']    = 'ssmtp';
            $config['smtp_host']    = 'ssl://ssmtp.gmail.com';
            $config['smtp_port']    = '465';
            $config['smtp_timeout'] = '7';
            $config['smtp_user']    = $from;
            $config['smtp_pass']    = 'Naman@01#01$01';
            $config['charset']    = 'utf-8';
            $config['newline']    = "\r\n";
            $config['mailtype'] = 'html';
            $config['validation'] = TRUE;  
            // $config['newline'] = "\r\n";
            
            $this->load->library('email');
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->from($from);
            $this->email->to($loanDetails->email);
            $this->email->bcc("meena.joshi@loanwalle.com, vinaykumarfd@gmail.com, itzmir21225@gmail.com");
            $this->email->subject('Loan Disbursal Letter - Loanwalle');
            $this->email->message($message);
            $this->email->send();
		}
    }
?>