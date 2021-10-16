
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Loan Against Card</title>
</head>
<body>


<table width="778" border="0" align="center" cellpadding="0" cellspacing="0" style="padding:10px; border:solid 1px #ccc; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:22px;">
  <tr>
    <td width="381" align="left"><img src="https://loanagainstcard.com/assets/images/logo-final.png" width="234" height="60" /></td>
    <td width="11" align="left">&nbsp;</td>
    <td width="384" align="right"><table width="100%" border="0">
      <tr>
        <td align="right"><strong><?php if($loan->gender == "Male"){ echo "Mr. ";}else{ echo "Ms. "; } ?> <?= strtoupper($loan->customer_name) ?></strong></td>
      </tr>
      <tr>
        <td align="right"><strong>Loan No.:</strong> <?= $loan->loan_no ?> </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><hr / style="background:#ddd !important;"></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="7" align="left" valign="top"><table width="100%" border="0">
      <tr>
        <td align="left" valign="middle">Dear  Customer,</td>
      </tr>
      <tr>
        <td align="left" valign="middle">Thank  you for choosing us and giving us the opportunity to be of service to you. Hope  you are satisfied with us.</td>
      </tr>
      <tr>
        <td align="left" valign="middle">In  response to your loan application, we are pleased to sanction you a personal  loan with the following terms and conditions. Please go through the terms and  conditions carefully and give your consent so that we may proceed with the disbursal of your loan and credit your credit card account.</td>
      </tr>
      <tr>
        <td align="left" valign="middle">You can repay the loan  via this link <a href="https://eazypay.icicibank.com/homePage" target="_blank" style="text-decoration:blink; color:#1a5ee6;"><span style="background : orange; color : #fff; padding : 2px;">https://eazypay.icicibank.com/homePage</span></a>
        or UPI ID <span style="background : orange; color : #fff; padding : 2px;">8076329281@okbizaxis</span>. Kindly make the payment in the name of Naman  Finlease Pvt. Ltd. </td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
    <td rowspan="7" align="center" valign="top"><img src="<?= base_url('public/img/') ?>image-loan.jpg" width="384" height="261" / style="border:solid 1px #ccc; padding:5px;"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left"><img src="<?= base_url('public/img/') ?>img.png" alt="text" width="26" height="10" /></td>
  </tr>
  <tr>
    <td colspan="3" align="left">Loanagainstcard.com is powered by Naman Finlease Pvt.  Ltd. with registered office at S-370, Panchsheel Park, New Delhi-110017 </td>
  </tr>
  <!--<tr>-->
  <!--  <td colspan="3" align="center">&nbsp;</td>-->
  <!--</tr>-->
  <tr >
    <td colspan="3" align="center" style="padding-top : 8px;padding-bottom : 10px;"><strong>Most  Important Terms and Conditions (MITC)</strong></td>
  </tr>
  <tr>
    <td colspan="3" align="left"><table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <td width="42%" bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Name </td>
        <td width="58%" bgcolor="#FFFFFF" style="padding:5px;">&nbsp; <?php if($loan->gender == "Male"){ echo "Mr. ";}else{ echo "Ms. "; } ?><?= strtoupper($loan->customer_name) ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Loan Amount</td>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Rs. <?= number_format($loan->loan_amount, 2) ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Administrative Fee</td>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Rs. <?= number_format($loan->loan_admin_fee, 2) ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Net Disbursal Amount</td>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Rs. <?= number_format(($loan->loan_amount - $loan->loan_admin_fee), 2) ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Disbursal Date</td>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; <?= date('d-m-Y', strtotime($loan->created_on)) ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Tenure</td>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; <?php if(strlen($loan->loan_tenure) == 1){ echo "0".$loan->loan_tenure;}else{ echo $loan->loan_tenure; } ?> days</td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Repayment Date</td>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; <?= $loan->loan_repay_date ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Rate of Interest</td>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; <?= $loan->loan_intrest ?> % per day (365.00 % per annum)</td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Repayment Amount</td>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Rs. <?= number_format($loan->loan_repay_amount, 2) ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Late Payment Penalty *</td>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; 1.00 % per day (365.00% per annum)</td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Credit Card Account Number</td>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; <?= number_format($loan->customer_account_no, 0, '', '') ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Credit Card Holder Name</td>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; <?= strtoupper($loan->customer_name) ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Credit Card Bank Name</td>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; <?= $loan->customer_bank ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; Credit Card Type</td>
        <td bgcolor="#FFFFFF" style="padding:5px;">&nbsp; <?= $loan->loan_account_type ?></td>
      </tr>
    </table>
    
    </td>
  </tr>
  
    <tr>
    <td colspan="3" align="left"><em>* Additional Interest Rate is applicable over and above the Rate of  Interest applicable to your loan for the delayed period of the loan.</em></td>
    </tr>
  <tr>
    <td colspan="3" align="left"><img src="<?= base_url('public/img/') ?>img.png" alt="text" width="26" height="10" /></td>
  </tr>
  <tr>
    <td colspan="3" align="left"><strong>Loan amount  to be credited directly to your Credit Card account as per your explicit  instructions. </strong></td>
  </tr>
  <tr>
    <td colspan="3" align="left">Non-payment of loan on time will affect your CIBIL Score adversely and will reduce your ability to avail further loans from banks and financial institutions in future. Please provide your confirmation through the link below in agreement to the above terms.</td>
  </tr>
  <tr>
    <td colspan="3" align="left"><img src="<?= base_url('public/img/') ?>img.png" alt="text" width="26" height="10" /></td>
  </tr>
  <tr>
    <td colspan="3" align="left"><strong>Best Regards,</strong><br /></td>
  </tr>
  <tr>
    <td colspan="3" align="left"><strong>Team Loanagainstcard</strong></td>
  </tr>
  <tr>
    <td colspan="3" align="left"><img src="<?= base_url('public/img/') ?>img.png" alt="text" width="26" height="10" /></td>
  </tr>
  <tr>
    <td colspan="3" align="center">
        <p style="text-align: left;
    background: #0070c0;
    padding: 5px 10px;
    color: #fff;
    border-radius: 20px;
    font-style: italic;
    border: 1px #065892 solid;width: 77%;"><span>"
    I hereby agree to the above loan terms and conditions and authorise Loanagainstcard.com to credit my Credit Card account with the loan money as per details conveyed above. I remain committed to repay the loan within due date and liable to legal prosecution on the event of default in the repayment of loan with all interest and charges as applicable."</span></p></td>
  </tr>
  <tr>
    <td colspan="3" align="left"><img src="<?= base_url('public/img/') ?>img.png" alt="text" width="26" height="10" /></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><a href="<?= base_url('loan-Agreement-Letter-Response/'.$loan->lead_id) ?>" style="background: #ff0000;
    color: #fff;
    padding: 11px 13px;
    border-radius: 3px;
    text-decoration: blink;
    font-weight: bold;
    text-transform: uppercase;">&quot;Agree &amp; Confirm&quot; </a> <img src="<?= base_url('public/img/') ?>hand.gif" width="40" height="25"  style="position: relative;
    top: 8px;"></td>
  </tr>
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
</table>



</body>
</html>
