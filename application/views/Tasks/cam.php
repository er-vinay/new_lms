
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CAM</title>
</head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#000; font-size:12px; line-height:21px;">
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#ddd">
      <tr>
        <td colspan="4" bgcolor="#0a5e90" style="color:#fff; text-align:center; font-weight:bold; padding:7px; font-size:15px;">Summary</td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">Application No</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($leadDetails->application_no) ? $leadDetails->application_no : "-" ?></td>
        <td width="25%" bgcolor="#f2f2f2">Loan No</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getDisbursalDetails['Disburse']['loan_no']) ? strtoupper($getDisbursalDetails['Disburse']['loan_no']) : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#FFFFFF">CIF No.</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($leadDetails->application_no) ? $leadDetails->application_no : "-" ?></td>
        <td width="25%" bgcolor="#FFFFFF">Status</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getPersonalDetails['leadDetails']['leadStatus']) ? strtoupper($getPersonalDetails['leadDetails']['leadStatus']) : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">Processed By</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($UsersProcessBy['processBy']) ? strtoupper($UsersProcessBy['processBy']) : "-" ?></td>
        <td width="25%" bgcolor="#f2f2f2">Process Date</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($UsersProcessBy['processDate']) ? date('d-m-Y h:i:s', strtotime($UsersProcessBy['processDate'])) : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#FFFFFF">Sanctioned by</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($UsersProcessBy['sanctioned_by']) ? strtoupper($UsersProcessBy['sanctioned_by']) : "-" ?></td>
        <td width="25%" bgcolor="#FFFFFF">Sanctioned Date</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($UsersProcessBy['sanctioned_date']) ? date('d-m-Y h:i:s', strtotime($UsersProcessBy['sanctioned_date'])) : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">Disbursed By</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($UsersProcessBy['disburse_by']) ? strtoupper($UsersProcessBy['disburse_by']) : "-" ?></td>
        <td width="25%" bgcolor="#f2f2f2">Disbursed Date</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($UsersProcessBy['disburse_date']) ? date('d-m-Y h:i:s', strtotime($UsersProcessBy['disburse_date'])) : "-" ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#ddd">
      <tr>
        <td colspan="4" bgcolor="#0a5e90" style="color:#fff; text-align:center; font-weight:bold; padding:7px; font-size:15px;">Personal</td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">Borrower</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getPersonalDetails['leadDetails']['name']) ? strtoupper($getPersonalDetails['leadDetails']['name']) : "-" ?></td>
        <td width="25%" bgcolor="#f2f2f2">Middle Name</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getPersonalDetails['leadDetails']['middle_name']) ? strtoupper($getPersonalDetails['leadDetails']['middle_name']) : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#FFFFFF">Surname</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getPersonalDetails['leadDetails']['surname']) ? strtoupper($getPersonalDetails['leadDetails']['surname']) : "-" ?></td>
        <td width="25%" bgcolor="#FFFFFF">Gender</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getPersonalDetails['leadDetails']['gender']) ? strtoupper($getPersonalDetails['leadDetails']['gender']) : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">DOB</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getPersonalDetails['leadDetails']['dob']) ? date('d-m-Y', strtotime($getPersonalDetails['leadDetails']['dob'])) : "-" ?></td>
        <td width="25%" bgcolor="#f2f2f2">Age</td>
        <td width="25%" bgcolor="#f2f2f2"><?= $yourAge ?></td>
      </tr>
      <tr>
          <td width="25%" bgcolor="#FFFFFF">PAN</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getPersonalDetails['leadDetails']['pancard']) ? strtoupper($getPersonalDetails['leadDetails']['pancard']) : "-" ?></td>
        <td width="25%" bgcolor="#FFFFFF">Aadhar</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getPersonalDetails['leadDetails']['aadhar']) ? $getPersonalDetails['leadDetails']['aadhar'] : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">Mobile</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getPersonalDetails['leadDetails']['mobile']) ? $getPersonalDetails['leadDetails']['mobile'] : "-" ?></td>
        <td width="25%" bgcolor="#f2f2f2">Alternate Mobile</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getPersonalDetails['leadDetails']['alternateMobileNo']) ? $getPersonalDetails['leadDetails']['alternateMobileNo'] : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#FFFFFF">Email Id</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getPersonalDetails['leadDetails']['email']) ? $getPersonalDetails['leadDetails']['email'] : "-" ?></td>
        <td width="25%" bgcolor="#FFFFFF">Alternate Email Id</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getPersonalDetails['leadDetails']['alternateEmail']) ? $getPersonalDetails['leadDetails']['alternateEmail'] : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">State</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getPersonalDetails['stateName']->state) ? strtoupper($getPersonalDetails['stateName']->state) : "-" ?></td>
        <td width="25%" bgcolor="#f2f2f2">City</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getPersonalDetails['selectedCity']) ? strtoupper($getPersonalDetails['selectedCity']) : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#FFFFFF">Pincode</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getPersonalDetails['leadDetails']['pincode']) ? $getPersonalDetails['leadDetails']['pincode'] : "-" ?></td>
        <td width="25%" bgcolor="#FFFFFF">Post Office</td>
        <td width="25%" bgcolor="#FFFFFF">-</td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">Initiated On</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($leadDetails->created_on) ? date('d-m-Y h:i:s', strtotime($leadDetails->created_on)) : "-" ?></td>
        <td width="25%" bgcolor="#f2f2f2">Lead Source</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($leadDetails->source) ? strtoupper($leadDetails->source) : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#FFFFFF">Geo Coordinates</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($leadDetails->coordinates) ? strtoupper($leadDetails->coordinates) : "-" ?></td>
        <td width="25%" bgcolor="#FFFFFF">IP Address</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($leadDetails->ip) ? $leadDetails->ip : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">Residence Type</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getPersonalDetails['leadDetails']['residentialType']) ? strtoupper($getPersonalDetails['leadDetails']['residentialType']) : "-" ?></td>
        <td width="25%" bgcolor="#f2f2f2">Residential Proof</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getPersonalDetails['leadDetails']['residential_proof']) ? strtoupper($getPersonalDetails['leadDetails']['residential_proof']) : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">Residence Address Line 1</td>
        <td bgcolor="#FFFFFF"><?= ($getPersonalDetails['leadDetails']['residence_address_line1']) ? strtoupper($getPersonalDetails['leadDetails']['residence_address_line1']) : "-" ?></td>
        <td bgcolor="#FFFFFF">Residence Address Line 2</td>
        <td bgcolor="#FFFFFF"><?= ($getPersonalDetails['leadDetails']['residence_address_line2']) ? strtoupper($getPersonalDetails['leadDetails']['residence_address_line2']) : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#f2f2f2">Present Address</td>
        <td colspan="3" bgcolor="#f2f2f2"><?= ($getPersonalDetails['leadDetails']['presentAddressType']) ? strtoupper($getPersonalDetails['leadDetails']['presentAddressType']) : "-" ?></td>
        </tr>
      <tr>
        <td width="25%" bgcolor="#FFFFFF">Residence Type</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getPersonalDetails['leadDetails']['residentialType']) ? strtoupper($getPersonalDetails['leadDetails']['residentialType']) : "-" ?></td>
        <td width="25%" bgcolor="#FFFFFF">Residential Proof</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getPersonalDetails['leadDetails']['residential_proof']) ? strtoupper($getPersonalDetails['leadDetails']['residential_proof']) : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#f2f2f2">Present Address Line 1</td>
        <td bgcolor="#f2f2f2"><?= ($getPersonalDetails['leadDetails']['present_address_line1']) ? strtoupper($getPersonalDetails['leadDetails']['present_address_line1']) : "-" ?></td>
        <td bgcolor="#f2f2f2">Present Address Line 2</td>
        <td bgcolor="#f2f2f2"><?= ($getPersonalDetails['leadDetails']['present_address_line2']) ? strtoupper($getPersonalDetails['leadDetails']['present_address_line2']) : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">Employer/ Business name</td>
        <td bgcolor="#FFFFFF"><?= ($getPersonalDetails['leadDetails']['employer_business']) ? strtoupper($getPersonalDetails['leadDetails']['employer_business']) : "-" ?></td>
        <td bgcolor="#FFFFFF">Office Address</td>
        <td bgcolor="#FFFFFF"><?= ($getPersonalDetails['leadDetails']['office_address']) ? strtoupper($getPersonalDetails['leadDetails']['office_address']) : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#f2f2f2">Office Website</td>
        <td colspan="3" bgcolor="#f2f2f2"><?= ($getPersonalDetails['leadDetails']['office_website']) ? strtoupper($getPersonalDetails['leadDetails']['office_website']) : "-" ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#ddd">
      <tr>
        <td colspan="4" bgcolor="#0a5e90" style="color:#fff; text-align:center; font-weight:bold; padding:7px; font-size:15px;">Documents</td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">#</td>
        <td width="25%" bgcolor="#f2f2f2">Document Type</td>
        <td width="25%" bgcolor="#f2f2f2">Password</td>
        <td width="25%" bgcolor="#f2f2f2">Initiated On</td>
      </tr>
      <?php $i=1; foreach($getCustomerDocs as $row) : ?>
      <?php $color = ""; if($i % 2 == 0){ $color = "#f2f2f2"; }else{ $color = "#ffffff";} ?>
      <tr>
        <td width="25%" bgcolor="<?= $color; ?>"><?= $i++ ?></td>
        <td width="25%" bgcolor="<?= $color; ?>"><?= ($row->type) ? $row->type : "-" ?></td>
        <td width="25%" bgcolor="<?= $color; ?>"><?php $pwd = ""; for($j = 1; $j <= strlen($row->pwd); $j++) { $pwd .= "x"; } echo ($pwd) ? $pwd : "-"; ?></td>
        <td width="25%" bgcolor="<?= $color; ?>"><?= ($row->created_on) ? date("d-m-Y h:i:s", strtotime($row->created_on)) : "-" ?></td>
      </tr>
      <?php endforeach; ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#ddd">
      <tr>
        <td colspan="4" bgcolor="#0a5e90" style="color:#fff; text-align:center; font-weight:bold; padding:7px; font-size:15px;">Verification</td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">Email Verified</td>
        <td width="25%" bgcolor="#f2f2f2">-</td>
        <td width="25%" bgcolor="#f2f2f2">Mobile Verified</td>
        <td width="25%" bgcolor="#f2f2f2">-</td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#FFFFFF">PAN Verified</td>
        <td width="25%" bgcolor="#FFFFFF">-</td>
        <td width="25%" bgcolor="#FFFFFF">Aadhar Verified</td>
        <td width="25%" bgcolor="#FFFFFF">-</td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">Address and Application Geo-Cordinate within range</td>
        <td width="25%" bgcolor="#f2f2f2">YES/NO</td>
        <td width="25%" bgcolor="#f2f2f2">Video KYC</td>
        <td width="25%" bgcolor="#f2f2f2">YES/NO</td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#FFFFFF">Bank Statement Verified</td>
        <td width="25%" bgcolor="#FFFFFF">-</td>
        <td width="25%" bgcolor="#FFFFFF">Residence Verified</td>
        <td width="25%" bgcolor="#FFFFFF">-</td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">App Download</td>
        <td width="25%" bgcolor="#f2f2f2">-</td>
        <td width="25%" bgcolor="#f2f2f2">Mobile Make</td>
        <td width="25%" bgcolor="#f2f2f2">-</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#ddd">
      <tr>
        <td colspan="4" bgcolor="#0a5e90" style="color:#fff; text-align:center; font-weight:bold; padding:7px; font-size:15px;">CAM</td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">User Type</td>
        <td width="25%" bgcolor="#f2f2f2" colspan="3"><?= ($getCAMDetails['camDetails']['userType']) ? strtoupper($getCAMDetails['camDetails']['userType']) : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#FFFFFF">CIBIL Score</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['cibil']) ? $getCAMDetails['camDetails']['cibil'] : "-" ?></td>
        <td width="25%" bgcolor="#FFFFFF">No of Active CC</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['Active_CC']) ? strtoupper($getCAMDetails['camDetails']['Active_CC']) : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">CC Bank</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['customer_bank_name']) ? strtoupper($getCAMDetails['camDetails']['customer_bank_name']) : "-" ?></td>
        <td width="25%" bgcolor="#f2f2f2">CC Type</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['account_type']) ? strtoupper($getCAMDetails['camDetails']['account_type']) : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#FFFFFF">CC No.</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['customer_account_no']) ? $getCAMDetails['camDetails']['customer_account_no'] : "-" ?></td>
        <td width="25%" bgcolor="#FFFFFF">Confirm CC No.</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['customer_confirm_account_no']) ? $getCAMDetails['camDetails']['customer_confirm_account_no'] : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">CC Statement Date</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['cc_statementDate']) ? date('d-m-Y', strtotime($getCAMDetails['camDetails']['cc_statementDate'])) : "-" ?></td>
        <td width="25%" bgcolor="#f2f2f2">CC Payment Due Date</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['cc_paymentDueDate']) ? date('d-m-Y', strtotime($getCAMDetails['camDetails']['cc_paymentDueDate'])) : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">CC Limit</td>
        <td bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['cc_limit']) ? $getCAMDetails['camDetails']['cc_limit'] : "-" ?></td>
        <td bgcolor="#FFFFFF">CC Outstanding</td>
        <td bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['cc_outstanding']) ? $getCAMDetails['camDetails']['cc_outstanding'] : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">Name As on Card</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['customer_name']) ? strtoupper($getCAMDetails['camDetails']['customer_name']) : "-" ?></td>
        <td width="25%" bgcolor="#f2f2f2">Max Eligibility</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['max_eligibility']) ? $getCAMDetails['camDetails']['max_eligibility'] : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">CC Name matches with Borrower Name ?</td>
        <td colspan="3" bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['cc_name_Match_borrower_name']) ? strtoupper($getCAMDetails['camDetails']['cc_name_Match_borrower_name']) : "-" ?></td>
        </tr>
      <tr>
        <td bgcolor="#f2f2f2">EMI on Card ?</td>
        <td colspan="3" bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['emiOnCard']) ? strtoupper($getCAMDetails['camDetails']['emiOnCard']) : "-" ?></td>
        </tr>
      <tr>
        <td bgcolor="#FFFFFF">30+ DPD in last 3 mths in any CC ?</td>
        <td colspan="3" bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['DPD30Plus']) ? strtoupper($getCAMDetails['camDetails']['DPD30Plus']) : "-" ?></td>
        </tr>
      <tr>
        <td bgcolor="#f2f2f2">CC Statement Address same as Present address ?</td>
        <td colspan="3" bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['cc_statementAddress']) ? strtoupper($getCAMDetails['camDetails']['cc_statementAddress']) : "-" ?></td>
        </tr>
      <tr>
        <td bgcolor="#FFFFFF">DPD On CC in Last 3 months</td>
        <td colspan="3" bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['last3monthDPD']) ? strtoupper($getCAMDetails['camDetails']['last3monthDPD']) : "-" ?></td>
        </tr>
      <tr>
        <td bgcolor="#FFFFFF">IFSC Code</td>
        <td colspan="3" bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['bankIFSC_Code']) ? strtoupper($getCAMDetails['camDetails']['bankIFSC_Code']) : "-" ?></td>
        </tr>
      <tr>
        <td bgcolor="#f2f2f2">Bank Name</td>
        <td bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['bank_name']) ? strtoupper($getCAMDetails['camDetails']['bank_name']) : "-" ?></td>
        <td bgcolor="#f2f2f2">Bank Branch</td>
        <td bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['bank_branch']) ? strtoupper($getCAMDetails['camDetails']['bank_branch']) : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">A/C No.</td>
        <td bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['bankA_C_No']) ? strtoupper($getCAMDetails['camDetails']['bankA_C_No']) : "-" ?></td>
        <td bgcolor="#FFFFFF">Confirm A/C No.</td>
        <td bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['confBankA_C_No']) ? strtoupper($getCAMDetails['camDetails']['confBankA_C_No']) : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#f2f2f2">A/C Holder Name</td>
        <td bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['bankHolder_name']) ? strtoupper($getCAMDetails['camDetails']['bankHolder_name']) : "-" ?></td>
        <td bgcolor="#f2f2f2">Account Type</td>
        <td bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['bank_account_type']) ? strtoupper($getCAMDetails['camDetails']['bank_account_type']) : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">Loan Applied</td>
        <td bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['loan_applied']) ? $getCAMDetails['camDetails']['loan_applied'] : "-" ?></td>
        <td bgcolor="#FFFFFF">Loan Recommended</td>
        <td bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['loan_recomended']) ? $getCAMDetails['camDetails']['loan_recomended'] : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#f2f2f2">Admin Fee</td>
        <td bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['processing_fee']) ? $getCAMDetails['camDetails']['processing_fee'] : "-" ?></td>
        <td bgcolor="#f2f2f2">ROI (%)</td>
        <td bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['roi']) ? $getCAMDetails['camDetails']['roi'] : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">Admin Fee with GST (18 %)</td>
        <td bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['adminFeeWithGST']) ? $getCAMDetails['camDetails']['adminFeeWithGST'] : "-" ?></td>
        <td bgcolor="#FFFFFF">Net Disbursal Amount</td>
        <td bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['net_disbursal_amount']) ? $getCAMDetails['camDetails']['net_disbursal_amount'] : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#f2f2f2">Disbursal Date</td>
        <td bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['disbursal_date']) ? date('d-m-Y', strtotime($getCAMDetails['camDetails']['disbursal_date'])) : "-" ?></td>
        <td bgcolor="#f2f2f2">Repayment Date</td>
        <td bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['repayment_date']) ? date('d-m-Y', strtotime($getCAMDetails['camDetails']['repayment_date'])) : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">Tenure (days)</td>
        <td bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['tenure']) ? $getCAMDetails['camDetails']['tenure'] : "-" ?></td>
        <td bgcolor="#FFFFFF">Repayment Amount</td>
        <td bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['repayment_amount']) ? $getCAMDetails['camDetails']['repayment_amount'] : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#f2f2f2">Reference</td>
        <td bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['special_approval']) ? strtoupper($getCAMDetails['camDetails']['special_approval']) : "-" ?></td>
        <td bgcolor="#f2f2f2">Deviations Approved By</td>
        <td bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['deviationsApprovedBy']) ? strtoupper($getCAMDetails['camDetails']['deviationsApprovedBy']) : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">Change in ROI :</td>
        <td colspan="3" bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['changeROI']) ? strtoupper($getCAMDetails['camDetails']['changeROI']) : "-" ?></td>
        </tr>
      <tr>
        <td bgcolor="#f2f2f2">Change in Fees :</td>
        <td colspan="3" bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['changeFee']) ? strtoupper($getCAMDetails['camDetails']['changeFee']) : "-" ?></td>
        </tr>
      <tr>
        <td bgcolor="#FFFFFF">Higher Loan amount :</td>
        <td colspan="3" bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['changeLoanAmount']) ? strtoupper($getCAMDetails['camDetails']['changeLoanAmount']) : "-" ?></td>
        </tr>
      <tr>
        <td bgcolor="#f2f2f2">Tenor more than norms :</td>
        <td colspan="3" bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['changeTenure']) ? strtoupper($getCAMDetails['camDetails']['changeTenure']) : "-" ?></td>
        </tr>
      <tr>
        <td bgcolor="#FFFFFF">Poor RTR with CC :</td>
        <td colspan="3" bgcolor="#FFFFFF"><?= ($getCAMDetails['camDetails']['changeRTR']) ? strtoupper($getCAMDetails['camDetails']['changeRTR']) : "-" ?></td>
        </tr>
      <tr>
        <td bgcolor="#f2f2f2">Remarks</td>
        <td colspan="3" bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['remark']) ? strtoupper($getCAMDetails['camDetails']['remark']) : "-" ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#ddd">
      <tr>
        <td colspan="4" bgcolor="#0a5e90" style="color:#fff; text-align:center; font-weight:bold; padding:7px; font-size:15px;">Disbursal</td>
      </tr>
      <?php
        $disburse_to = "Credit Card";
        // $IFSC = "";
        // $Branch = "";
        // $accountNo = "CC Account Number";
        // $holderName = "CC Holder Name";
        // $bankName = "CC Bank Name";
        // $accountType = "CC Type";
        // $bankIFSC_Code = "";
        // $bank_branch = "";
        // $customer_account_no = $getDisbursalDetails['CAM']->customer_account_no;
        // $customer_name = $getDisbursalDetails['CAM']->customer_name;
        // $customer_bank = $getDisbursalDetails['CAM']->customer_bank_name;
        // $account_type = $getDisbursalDetails['CAM']->account_type;

        if($getDisbursalDetails['CAM']->isDisburseBankAC == "YES"){
            $disburse_to = "BANK";
            // $IFSC = "IFSC Code";
            // $Branch = "Bank Branch";
            // $accountNo = "Bank Account Number";
            // $holderName = "Bank Holder Name";
            // $bankName = "Bank Name";
            // $accountType = "Account Type";

            // $bankIFSC_Code = $getDisbursalDetails['CAM']->bankIFSC_Code;
            // $bank_branch = $getDisbursalDetails['CAM']->bank_branch;
            // $customer_account_no = $getDisbursalDetails['CAM']->bankA_C_No;
            // $customer_name = $getDisbursalDetails['CAM']->bankHolder_name;
            // $customer_bank = $getDisbursalDetails['CAM']->bank_name;
            // $account_type = $getDisbursalDetails['CAM']->bank_account_type;
        ?>
        <?php } ?>
      <tr>
        <td width="25%" bgcolor="#FFFFFF">Disbursal To</td>
        <td width="25%" bgcolor="#FFFFFF"><?= $disburse_to ?></td>
        <td width="25%" bgcolor="#FFFFFF">Net Disbursal Amount</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getCAMDetails['net_disbursal_amount']) ? $getCAMDetails['net_disbursal_amount'] : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#f2f2f2">Disbursal Date</td>
        <td bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['disbursal_date']) ? date('d-m-Y', strtotime($getCAMDetails['camDetails']['disbursal_date'])) : "-" ?></td>
        <td bgcolor="#f2f2f2">Repayment Date</td>
        <td bgcolor="#f2f2f2"><?= ($getCAMDetails['camDetails']['repayment_date']) ? date('d-m-Y', strtotime($getCAMDetails['camDetails']['repayment_date'])) : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#FFFFFF">Sent to Email</td>
        <td width="25%" bgcolor="#FFFFFF"><?= ($getDisbursalDetails['CAM']->email) ? $getDisbursalDetails['CAM']->email : "-" ?></td>
        <td width="25%" colspan="2" bgcolor="#FFFFFF"><?= ($getDisbursalDetails['Disburse']['loanAgreementRequest']) ? $getDisbursalDetails['Disburse']['loanAgreementRequest'] : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#f2f2f2">Sent to Alternate Email</td>
        <td width="25%" bgcolor="#f2f2f2"><?= ($getDisbursalDetails['CAM']->alternateEmail) ? $getDisbursalDetails['CAM']->alternateEmail : "-" ?></td>
        <td width="25%" colspan="2" bgcolor="#f2f2f2"><?= ($getDisbursalDetails['Disburse']['loanAgreementRequest2']) ? $getDisbursalDetails['Disburse']['loanAgreementRequest2'] : "-" ?></td>
      </tr>
      <tr>
        <td width="25%" bgcolor="#FFFFFF">Email Sent Date</td>
        <td bgcolor="#FFFFFF"><?= ($getDisbursalDetails['Disburse']['agrementRequestedDate']) ? $getDisbursalDetails['Disburse']['agrementRequestedDate'] : "-" ?></td>
        <td bgcolor="#FFFFFF">Email Response</td>
        <td bgcolor="#FFFFFF"><?= ($getDisbursalDetails['Disburse']['loanAgreementResponse']) ? $getDisbursalDetails['Disburse']['loanAgreementResponse'] : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#f2f2f2">Response Email Date</td>
        <td bgcolor="#f2f2f2"><?= ($getDisbursalDetails['Disburse']['agrementResponseDate']) ? $getDisbursalDetails['Disburse']['agrementResponseDate'] : "-" ?></td>
        <td bgcolor="#f2f2f2">Response Email</td>
        <td bgcolor="#f2f2f2"><?= ($getDisbursalDetails['Disburse']['responseEmail']) ? $getDisbursalDetails['Disburse']['responseEmail'] : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">Response Email IP</td>
        <td colspan="3" bgcolor="#FFFFFF"><?= ($getDisbursalDetails['Disburse']['agrementUserIP']) ? $getDisbursalDetails['Disburse']['agrementUserIP'] : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#f2f2f2">Disbursed Bank</td>
        <td bgcolor="#f2f2f2"><?= ($getDisbursalDetails['Disburse']['company_account_no']) ? $getDisbursalDetails['Disburse']['company_account_no'] : "-" ?></td>
        <td bgcolor="#f2f2f2">Channel</td>
        <td bgcolor="#f2f2f2"><?= ($getDisbursalDetails['Disburse']['channel']) ? $getDisbursalDetails['Disburse']['channel'] : "-" ?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">Disbursed Amount</td>
        <td colspan="3" bgcolor="#FFFFFF"><?= ($getDisbursalDetails['Disburse']['payable_amount']) ? $getDisbursalDetails['Disburse']['payable_amount'] : "-" ?></td>
        </tr>
      <tr>
        <td bgcolor="#f2f2f2">Disbursal Referance no</td>
        <td colspan="3" bgcolor="#f2f2f2"><?= ($getDisbursalDetails['Disburse']['disburse_refrence_no']) ? $getDisbursalDetails['Disburse']['disburse_refrence_no'] : "-" ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
