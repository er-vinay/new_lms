<?php //if($_SESSION['isUserSession']['labels'] == 'CR2'): ?>
<?php //if($_SESSION['isUserSession']['labels'] == 'CR2'): ?>
    <form id="FormSaveCAM" class="form-inline" method="post" autocomplete="off">
        <p>&nbsp</p>
        <input type="hidden" name="leadID" class="leadID">
        <input type="hidden" name="user_id" value="<?= user_id ?>">
        <input type="hidden" name="company_id" value="<?= company_id ?>">
        <input type="hidden" name="product_id" value="<?= product_id ?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <!-- <div class="form-group">
            <div class="col-sm-6">
                <label class="labelField">CIBIL Score</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
            <div class="col-sm-6">
                <label class="labelField">NTC</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6">
                <label class="labelField">Running other Payday loan</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
            <div class="col-sm-6">
                <label class="labelField">Delay in other loans in last 30 days</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6">
                <label class="labelField">Job stability</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
            <div class="col-sm-6">
                <label class="labelField">City category</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6">
                <label class="labelField">Salary Credit</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
            <div class="col-sm-6">
                <label class="labelField">City category</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6">
                <label class="labelField">Next Pay Date</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
            <div class="col-sm-6">
                <label class="labelField">Median Salary (Rs)</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6">
                <label class="labelField">Salary Variance</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
            <div class="col-sm-6">
                <label class="labelField">Salary on Time</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6">
                <label class="labelField">Monthly Salary (Rs)</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
            <div class="col-sm-6">
                <label class="labelField">Obligations (Rs)</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6">
                <label class="labelField">Borrower Age (years)</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
            <div class="col-sm-6">
                <label class="labelField">End Use</label>
                <select class="form-control inputField" id="cibil" name="cibil" autocomplete="off">
                    <option></option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6">
                <label class="labelField">LW Score</label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
            <div class="col-sm-6">
                <label class="labelField">Scheme</label>
                <select class="form-control inputField" id="cibil" name="cibil" autocomplete="off">
                    <option></option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6">
                <label class="labelField">Eligible FOIR% </label>
                <input type="number" class="form-control inputField" id="cibil" name="cibil" autocomplete="off" readonly>
            </div>
            <div class="col-sm-6">
                <label class="labelField">Eligible Loan</label>
                <input type="text" class="form-control inputField" id="userType" name="userType" autocomplete="off" readonly>
            </div>
        </div> -->
            
            
            <div class="col-md-6">
                <label class="labelField">User Type</label>
                <input type="text" class="form-control inputField" id="userType" name="userType" autocomplete="off" readonly>
            </div>
            
            <div class="col-sm-6">
                <label class="labelField">Status</label>
                <input type="text" class="form-control inputField" id="status" name="status" autocomplete="off" readonly>
            </div>

            <div class="col-md-6" style="margin-bottom : 10px;">
                <label class="labelField">IFSC Code&nbsp;<span class="required_Fields">*</span></label>
                <select class="form-control inputField" id="customer_ifsc_code" name="bankIFSC_Code" autocomplete="off"></select>
            </div>

        <div class="form-group" id="disbursalBankDetails1">

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
                    <option value="OVERDRAFT">OVERDRAFT</option>
                    <!-- <option value="Fixed Deposit">Fixed Deposit</option> -->
                    <!-- <option value="Recurring Deposit">Recurring Deposit</option>
                    <option value="DEMAT">DEMAT</option>
                    <option value="NRI">NRI</option> -->
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
<?php //endif; ?>