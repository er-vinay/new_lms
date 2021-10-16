
    <form id="FormSaveCAM" class="form-inline" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <p>&nbsp</p>
        <input type="hidden" name="leadID" class="leadID">
        <input type="hidden" name="user_id" value="<?= user_id ?>">
        <input type="hidden" name="company_id" value="<?= company_id ?>">
        <input type="hidden" name="product_id" value="<?= product_id ?>">
        <div class="form-group">
            
            <div class="col-md-6">
                <label class="labelField">User Type</label>
                <input type="text" class="form-control inputField" id="userType" name="userType" autocomplete="off" readonly>
            </div>
            
            <div class="col-sm-6">
                <label class="labelField">Status</label>
                <input type="text" class="form-control inputField" id="status" name="status" autocomplete="off" readonly>
            </div>
            
            <div class="col-sm-6">
                <label class="labelField">CIBIL Score</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>

            <div class="col-sm-6">
                <label class="labelField">No of Active CC&nbsp;<strong class="required_Fields">*</strong></label>
                <select class="form-control inputField" name="Active_CC" id="Active_CC" autocomplete="off" >
                    <option value="">Select</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6">
                <label class="labelField">CC Bank&nbsp;<span class="required_Fields">*</span></label>
                <select class="form-control inputField" name="customer_bank_name" id="customer_bank_name" required>
                    <option value="">Select</option>
                    <option value="IDFC First Bank">IDFC First Bank</option>
                    <option value="American Express">American Express</option>
                    <option value="ICICI Bank">ICICI Bank</option>
                    <option value="Axis Bank">Axis Bank</option>
                    <option value="HDFC Bank">HDFC Bank</option>
                    <option value="Kotak Bank">Kotak Bank</option>
                    <option value="SBI">SBI</option>
                    <option value="HSBC">HSBC</option>
                    <option value="IndusInd Bank">IndusInd Bank</option>
                    <option value="RBL Bank">RBL Bank</option>
                    <option value="Standard Chartered">Standard Chartered</option>
                    <option value="Citibanks">Citibanks</option>
                    <option value="YES Bank">YES Bank</option>
                    <option value="Canara Bank">Canara Bank</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="labelField">CC Type&nbsp;<span class="required_Fields">*</span></label>
                <select class="form-control inputField" style="width:100%;" name="account_type" id="account_type" required>
                    <option value="">Select</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="labelField">CC No.&nbsp;<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" name="customer_account_no" id="customer_account_no" required>
            </div>

            <div class="col-md-6">
                <label class="labelField">Confirm CC No.&nbsp;<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" name="customer_confirm_account_no" id="customer_confirm_account_no" onchange="customer_confirm_acc_no(this)" required>
            </div>

             <div class="col-md-6">
                <label class="labelField">CC Statement Date.&nbsp;<strong class="required_Fields">*</strong></label>
                <input type="text" class="form-control inputField" id="cc_statementDate" name="cc_statementDate" autocomplete="off"/>
            </div>

             <div class="col-md-6">
                <label class="labelField">CC Payment Due Date.&nbsp;<strong class="required_Fields">*</strong></label>
                <input type="text" class="form-control inputField" id="cc_paymentDueDate" name="cc_paymentDueDate" autocomplete="off"/>
            </div>

            <div class="col-md-6">
                <label class="labelField">CC Limit&nbsp;<strong class="required_Fields">*</strong></label>
                <input type="text" class="form-control inputField" id="cc_limit" name="cc_limit" autocomplete="off" >
            </div>

            <div class="col-md-6">
                <label class="labelField">CC Outstanding&nbsp;<strong class="required_Fields">*</strong></label>
                <input type="text" class="form-control inputField" id="cc_outstanding" name="cc_outstanding" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Name As on Card&nbsp;<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" name="customer_name" id="customer_name" value="" required>
            </div>

            <div class="col-md-6">
                <label class="labelField">Max Eligibility</label>
                <input type="text" class="form-control inputField" id="max_eligibility" name="max_eligibility" autocomplete="off" readonly>
            </div>
        </div>

        <div class="form-group" style="float: left; width: 100%; padding: 0px 10px;">
            <!--<div class="col-md-12" style="padding: 0px 0px;"><p class="headingForm">Credit Card Details</p></div>--> 
            <div class="row">
                <div class="col-md-5">
                    <label class="labelFieldCheck">CC Name matches with Borrower Name ?</label>
                </div>
                <div class="col-md-7">
                    <label class="radio-inline">
                        <input type="radio" name="cc_name_Match_borrower_name" id="cc_name_Match_borrower_name_YES" value="YES">&nbsp;YES
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="cc_name_Match_borrower_name" id="cc_name_Match_borrower_name_NO" value="NO">&nbsp;NO
                    </label>
                    <label class="radio-inline">
                        <div id="thumb_cc_name_Match_borrower_name"></div>
                    </label>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-5">
                    <label class="labelFieldCheck">EMI on Card ?</label>
                </div>
                <div class="col-md-7">
                    <label class="radio-inline">
                        <input type="radio" name="emiOnCard" id="emiOnCard_YES" value="YES" checked>&nbsp;YES
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="emiOnCard" id="emiOnCard_NO" value="NO">&nbsp;NO
                    </label>
                    <label class="radio-inline">
                        <div id="thumb_emiOnCard"></div>
                    </label>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-5">
                    <label class="labelFieldCheck">30+ DPD in last 3 mths in any CC ?</label>
                </div>
                <div class="col-md-7">
                    <label class="radio-inline">
                        <input type="radio" name="DPD30Plus" id="DPD30Plus_YES" value="YES" checked>&nbsp;YES
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="DPD30Plus" id="DPD30Plus_NO" value="NO">&nbsp;NO
                    </label>
                    <label class="radio-inline">
                        <div id="thumb_DPD30Plus"></div>
                    </label>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-5">
                    <label class="labelFieldCheck">CC Statement Address same as Present address ?</label>
                </div>
                <div class="col-md-7">
                    <label class="radio-inline">
                        <input type="radio" name="cc_statementAddress" id="cc_statementAddress_YES" value="YES" checked>&nbsp;YES
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="cc_statementAddress" id="cc_statementAddress_NO" value="NO">&nbsp;NO
                    </label>
                    <label class="radio-inline">
                        <div id="thumb_cc_statementAddress"></div>
                    </label>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-5">
                    <label class="labelFieldCheck">DPD On CC in Last 3 months</label>
                </div>
                <div class="col-md-7">
                    <label class="radio-inline">
                        <input type="radio" name="last3monthDPD" class="last3monthDPD" id="last3monthDPD_YES" value="YES">&nbsp;YES
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="last3monthDPD" class="last3monthDPD" id="last3monthDPD_NO" value="NO">&nbsp;NO
                    </label>
                    <label class="radio-inline">
                        <div id="thumb_last3monthDPD"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12" id="divhigherDPDLast3month">
                <label class="labelField" style="width:auto;">Highest DPD Amount in CC in last 3 months ?</label>
                <input type="text" class="form-control inputField" id="higherDPDLast3month" name="higherDPDLast3month" autocomplete="off">
            </div>
        </div>
        <div class="form-group" style="float: left; width: 100%;">
            <div class="col-md-5">
                <label class="">Is Disburse to Bank Account ?</label>
            </div>
            <div class="col-md-7">
                <input type="checkbox" class="form-control" name="isDisburseBankAC" id="isDisburseBankAC" value="YES" style="margin-top : -10px;">
            </div>
        </div>

        <div class="form-group" id="disbursalBankDetails">
            <div class="col-md-12" style="margin-bottom : 10px;">
                <label class="labelField">IFSC Code&nbsp;<span class="required_Fields">*</span></label>
                <select class="form-control inputField" id="customer_ifsc_code" name="bankIFSC_Code" autocomplete="off"></select>
            </div>

            <div class="col-md-6">
                <label class="labelField">Bank Name</label>
                <input type="text" class="form-control inputField" id="bank_name" name="bank_name" autocomplete="off" readonly>
            </div>

            <div class="col-md-6">
                <label class="labelField">Bank Branch</label>
                <input type="text" class="form-control inputField" id="bank_branch" name="bank_branch" autocomplete="off" readonly>
            </div>

            <div class="col-md-6">
                <label class="labelField">A/C No.&nbsp;<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="bankA_C_No" name="bankA_C_No" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Confirm A/C No.&nbsp;<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="confBankA_C_No" name="confBankA_C_No" onchange="customer_confirm_bank_ac_no(this)" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">A/C Holder Name&nbsp;<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="bankHolder_name" name="bankHolder_name" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Account Type&nbsp;<span class="required_Fields">*</span></label>
                <select class="form-control inputField" id="bank_account_type" name="bank_account_type" autocomplete="off">
                    <option value="">Select</option>
                    <option value="Saving">Saving</option>
                    <option value="Current">Current</option>
                    <option value="Fixed Deposit">Fixed Deposit</option>
                    <option value="Recurring Deposit">Recurring Deposit</option>
                    <option value="DEMAT">DEMAT</option>
                    <option value="NRI">NRI</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6">
                <label class="labelField">Loan Applied (Rs.)</label>
                <input type="text" class="form-control inputField" id="loan_applied" name="loan_applied" autocomplete="off" readonly>
            </div>

            <div class="col-md-6">
                <label class="labelField">Loan Recommended (Rs.)&nbsp;<strong class="required_Fields">*</strong></label>
                <input type="text" class="form-control inputField" id="loan_recomended" name="loan_recomended" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Admin Fee (Rs.)&nbsp;<strong class="required_Fields">*</strong></label>
                <input class="form-control inputField" id="processing_fee" name="processing_fee" type="text" maxlength="5" minlength="3" autocomplete="off">
            </div>
            
            <div class="col-md-6">
                <label class="labelField">Admin Fee(%)&nbsp;<strong class="required_Fields">*</strong></label>
                <input class="form-control inputField" id="processing_fee_percent" name="processing_fee_percent" value="2" type="text" maxlength="5" minlength="3" autocomplete="off">
            </div> 

            <div class="col-md-6">
                <label class="labelField">Admin Fee with GST (18 %)</label>
                <input type="text" class="form-control inputField" id="adminFeeWithGST" name="adminFeeWithGST" autocomplete="off" readonly>
            </div>

            <div class="col-md-6">
                <label class="labelField">Net Disbursal Amount (Rs.)</label>
                <input type="text" class="form-control inputField" id="net_disbursal_amount" name="net_disbursal_amount" autocomplete="off" readonly>
            </div>

            <div class="col-md-6">
                <label class="labelField">Disbursal Date&nbsp;<strong class="required_Fields">*</strong></label>
                <input type="text" class="form-control inputField" id="disbursal_date" name="disbursal_date" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Repay Date&nbsp;<strong class="required_Fields">*</strong></label>
                <input type="text" class="form-control inputField" id="repayment_date" name="repayment_date" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Tenure (days)</label>
                <input type="text" class="form-control inputField" id="tenure" name="tenure" autocomplete="off" readonly>
            </div>
            
            <div class="col-md-6">
                <label class="labelField">ROI (%)&nbsp;<strong class="required_Fields">*</strong></label>
                <input class="form-control inputField" id="roi" name="roi" type="text" value="1" onchange="validloanamount(this)" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Repay Amount (Rs.)</label>
                <input type="text" class="form-control inputField" id="repayment_amount" name="repayment_amount" autocomplete="off" readonly>
            </div>

            <div class="col-md-6">
                <label class="labelField">Reference</label>
                <input type="text" class="form-control inputField" id="special_approval" name="special_approval" autocomplete="off" >
            </div>

            <div class="col-sm-6">
                <label class="labelField"> Change in ROI </label>
               <input type="text" class="form-control inputField" name="changeROI" id="changeROI" value="NO" readonly >
            </div>
            
            <div class="col-sm-6">
                <label class="labelField">Change in Fees </label>
               <input type="text"  class="form-control inputField" name="changeFee" id="changeFee" value="NO" readonly>
            </div>
            
             <div class="col-sm-6">
                <label class="labelField"> Higher Loan amount </label>
               <input type="text" class="form-control inputField" name="changeLoanAmount" id="changeLoanAmount" value="NO" readonly >
            </div>
            
             <div class="col-sm-6">
                <label class="labelField"> Higher Tenure</label>
               <input type="text" class="form-control inputField" name="changeTenure" id="changeTenure" value="NO" readonly >
            </div> 

            <div class="col-sm-12" style="margin-bottom:10px">
                <label class="labelField">Remark</label>
                <textarea class="form-control" id="remark" name="remark" rows="3" cols="80" ></textarea>
            </div>
            
            <div class="col-sm-6">
                <label class="labelField"> Deviations Approved By</label>
                <select class="form-control inputField" name="deviationsApprovedBy" id="deviationsApprovedBy" autocomplete="off">
                    <option value="">Select</option>
                    <option value="BH">BH</option>
                    <option value="MD">MD</option>
                </select>
            </div>
        </div>
    </form>