
    <?php if((agent == "CR2" || agent == "CA" || agent == "SA") && ($leadDetails->stage == "S5" || $leadDetails->stage == "S6" || $leadDetails->stage == "S11")) { ?>
        <form id="FormSaveCAM" class="form-inline" method="post" autocomplete="off">
            <p>&nbsp</p>
            <input type="hidden" name="lead_id" id="lead_id" value="<?php echo $leadDetails->lead_id; ?>" />
            <input type="hidden" name="alternate_email" id="alternate_email" value="<?php echo $leadDetails->alternate_email; ?>" />
            <input type="hidden" name="current_residence_type" id="current_residence_type" value="<?php echo $leadDetails->current_residence_type; ?>" />
            <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $leadDetails->customer_id; ?>" />
            <input type="hidden" name="user_id" id="user_id" value="<?= user_id ?>">
            <input type="hidden" name="company_id" id="company_id" value="<?= company_id ?>">
            <input type="hidden" name="product_id" id="product_id" value="<?= product_id ?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

            <div class="form-group">
                <div class="col-sm-6">
                    <label class="labelField">CIBIL Score</label>
                    <input type="number" class="form-control inputField" id="cibil" name="cibil" value="<?= $leadDetails->cibil ?>" autocomplete="off" readonly>
                </div>

                <div class="col-sm-6">
                    <label class="labelField">NTC</label>
                    <input class="form-control inputField" id="ntc" name="ntc" autocomplete="off" value="-" readonly>
                </div>

                <div class="col-sm-6">
                    <label class="labelField">Running other Payday loan&nbsp;<span class="required_Fields">*</span></label>
                    <select class="form-control inputField" id="run_other_pd_loan" name="run_other_pd_loan" autocomplete="off">
                        <option value="">SELECT</option>
                        <option value="YES">YES</option>
                        <option value="NO">NO</option>
                    </select>
                </div>

                <div class="col-sm-6">
                    <label class="labelField">Delay in other loans in last 30 days&nbsp;<span class="required_Fields">*</span></label>
                    <select class="form-control inputField" id="delay_other_loan_30_days" name="delay_other_loan_30_days" autocomplete="off">
                        <option value="">SELECT</option>
                        <option value="YES">YES</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                
                <div class="col-sm-6">
                    <label class="labelField">Job stability</label>
                    <input type="text" class="form-control inputField" id="job_stability" name="job_stability" value="-" autocomplete="off" readonly>
                </div>
                
                <div class="col-sm-6">
                    <label class="labelField">City category</label>
                    <input type="text" class="form-control inputField" id="city_category" name="city_category" value="<?= $leadDetails->city_category ?>" autocomplete="off" readonly>
                </div>
                
                <div class="col-sm-6">
                    <label class="labelField">Salary Credit&nbsp;<span class="required_Fields">*</span></label>
                    <select class="form-control inputField" id="salary_credit1" name="salary_credit1" autocomplete="off">
                        <option value="">SELECT</option>
                        <option value="JANUARY">JANUARY</option>
                        <option value="February">February</option>
                        <option value="MARCH">MARCH</option>
                        <option value="APRIL">APRIL</option>
                        <option value="MAY">MAY</option>
                        <option value="JUNE">JUNE</option>
                        <option value="JULY">JULY</option>
                        <option value="AUGUST">AUGUST</option>
                        <option value="SEPTEMBER">SEPTEMBER</option>
                        <option value="OCTOBER">OCTOBER</option>
                        <option value="NOVEMBER">NOVEMBER</option>
                        <option value="DECEMBER">DECEMBER</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="text" class="form-control inputField" id="salary_credit1_date" name="salary_credit1_date" onchange="calculateSalaryOnTime()" autocomplete="off">
                </div>

                <div class="col-md-3">
                    <input type="text" class="form-control inputField" id="salary_credit1_amount" name="salary_credit1_amount" onchange="calculateMedianSalary()" autocomplete="off" placeholder="Salary Amount" style="width: 60% !important;">
                </div>
                
                <div class="col-sm-6">
                    <label class="labelField">Salary Credit&nbsp;<span class="required_Fields">*</span></label>
                    <select class="form-control inputField" id="salary_credit2" name="salary_credit2" autocomplete="off">
                        <option value="">SELECT</option>
                        <option value="JANUARY">JANUARY</option>
                        <option value="February">February</option>
                        <option value="MARCH">MARCH</option>
                        <option value="APRIL">APRIL</option>
                        <option value="MAY">MAY</option>
                        <option value="JUNE">JUNE</option>
                        <option value="JULY">JULY</option>
                        <option value="AUGUST">AUGUST</option>
                        <option value="SEPTEMBER">SEPTEMBER</option>
                        <option value="OCTOBER">OCTOBER</option>
                        <option value="NOVEMBER">NOVEMBER</option>
                        <option value="DECEMBER">DECEMBER</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="text" class="form-control inputField" id="salary_credit2_date" name="salary_credit2_date" onchange="calculateSalaryOnTime()" autocomplete="off">
                </div>

                <div class="col-md-3">
                    <input type="number" class="form-control inputField" id="salary_credit2_amount" name="salary_credit2_amount" onchange="calculateMedianSalary()" autocomplete="off" placeholder="Salary Amount" style="width: 60% !important;">
                </div>
                
                <div class="col-sm-6">
                    <label class="labelField">Salary Credit&nbsp;<span class="required_Fields">*</span> </label>
                    <select class="form-control inputField" id="salary_credit3" name="salary_credit3" autocomplete="off">
                        <option value="">SELECT</option>
                        <option value="JANUARY">JANUARY</option>
                        <option value="February">February</option>
                        <option value="MARCH">MARCH</option>
                        <option value="APRIL">APRIL</option>
                        <option value="MAY">MAY</option>
                        <option value="JUNE">JUNE</option>
                        <option value="JULY">JULY</option>
                        <option value="AUGUST">AUGUST</option>
                        <option value="SEPTEMBER">SEPTEMBER</option>
                        <option value="OCTOBER">OCTOBER</option>
                        <option value="NOVEMBER">NOVEMBER</option>
                        <option value="DECEMBER">DECEMBER</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="text" class="form-control inputField" id="salary_credit3_date" name="salary_credit3_date" onchange="calculateSalaryOnTime()" autocomplete="off">
                </div>

                <div class="col-md-3">
                    <input type="number" class="form-control inputField" id="salary_credit3_amount" name="salary_credit3_amount" onchange="calculateMedianSalary()" autocomplete="off" placeholder="Salary Amount" style="width: 60% !important;">
                </div>

                <div class="col-md-6">
                    <label class="labelField">Next Pay Date</label>
                    <input type="text" class="form-control inputField" id="next_pay_date" name="next_pay_date" value="-" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="labelField">Avg. Salary (Rs)</label>
                    <input type="text" class="form-control inputField" id="median_salary" name="median_salary" value="-" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="labelField">Salary Variance</label>
                    <input type="text" class="form-control inputField" id="salary_variance" name="salary_variance" value="-" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="labelField">Salary on Time</label>
                    <input type="text" class="form-control inputField" id="salary_on_time" name="salary_on_time" value="-" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="labelField">Monthly Salary (Rs)&nbsp;<span class="required_Fields">*</span></label>
                    <input type="text" class="form-control inputField" id="monthly_salary" name="monthly_salary" onchange="checkLoanEligibility()" value="<?= $leadDetails->monthly_income ?>" autocomplete="off">
                </div>

                <div class="col-md-6">
                    <label class="labelField">Obligations (Rs)&nbsp;<span class="required_Fields">*</span></label>
                    <input type="number" class="form-control inputField" id="obligations" name="obligations" value="<?= round($leadDetails->obligations) ?>" autocomplete="off">
                </div>

                <div class="col-md-6">
                    <label class="labelField">Borrower Age (years)</label>
                    <input type="text" class="form-control inputField" id="borrower_age" name="borrower_age" value="-" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="labelField">End Use&nbsp;<span class="required_Fields">*</span></label>
                    <select class="form-control inputField" id="end_use" name="end_use" autocomplete="off">
                        <option value="">SELECT</option>
                        <option <?php if($leadDetails->purpose == "TRAVEL"){echo "selected";} ?>>TRAVEL</option>
                        <option <?php if($leadDetails->purpose == "MEDICAL"){echo "selected";} ?>>MEDICAL</option>
                        <option <?php if($leadDetails->purpose == "ACADEMICS"){echo "selected";} ?>>ACADEMICS</option>
                        <option <?php if($leadDetails->purpose == "OBLIGATIONS"){echo "selected";} ?>>OBLIGATIONS</option>
                        <option <?php if($leadDetails->purpose == "OCCASION"){echo "selected";} ?>>OCCASION</option>
                        <option <?php if($leadDetails->purpose == "PURCHASE"){echo "selected";} ?>>PURCHASE</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="labelField">LW Score</label>
                    <input type="text" class="form-control inputField" id="lw_score" name="lw_score" value="-" autocomplete="off" readonly disabled>
                </div>

                <div class="col-md-6">
                    <label class="labelField">Scheme</label>
                    <select class="form-control inputField" id="end_use" name="end_use" autocomplete="off" disabled>
                        <option value="">SELECT</option>
                        <option value="TRAVEL">REGULAR</option>
                        <option value="MEDICAL">MONSOON HUNGAMA</option>
                        <option value="ACADEMICS">REFERRAL</option>
                        <option value="OBLIGATIONS">WINTER FEST</option>
                        <option value="OCCASION">APPROVAL</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="labelField">Eligible FOIR %</label>
                    <input type="number" class="form-control inputField" id="eligible_foir_percentage" name="eligible_foir_percentage" value="-" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="labelField">Eligible Loan</label>
                    <input type="number" class="form-control inputField" id="eligible_loan" name="eligible_loan" value="-" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="labelField">Loan Applied (Rs.)</label>
                    <input type="number" class="form-control inputField" id="loan_applied" name="loan_applied" value="<?= round($leadDetails->loan_amount) ?>" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="labelField">Loan Recommended (Rs.)&nbsp;<strong class="required_Fields">*</strong></label>
                    <input type="number" class="form-control inputField" id="loan_recommended" name="loan_recommended" onchange="calculateAmount()" value="<?= round($leadDetails->loan_amount) ?>" autocomplete="off">
                </div>

                <div class="col-md-6">
                    <label class="labelField">Final FOIR %</label>
                    <input type="number" class="form-control inputField" id="final_foir_percentage" name="final_foir_percentage" value="-" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="labelField">FOIR ENHANCED BY %</label>
                    <input type="number" class="form-control inputField" id="foir_enhanced_by" name="foir_enhanced_by" value="-" autocomplete="off" readonly>
                </div>
                
                <div class="col-md-6">
                    <label class="labelField">Admin Fee (%)&nbsp;<strong class="required_Fields">*</strong></label>
                    <input class="form-control inputField" id="processing_fee_percent" name="processing_fee_percent" value="10" onchange="calculateAmount()" value="10" type="text" autocomplete="off">
                </div> 
                
                <div class="col-md-6">
                    <label class="labelField">ROI (%)&nbsp;<strong class="required_Fields">*</strong></label>
                    <input class="form-control inputField" id="roi" name="roi" type="text" value="1" value="1" onchange="calculateAmount()" autocomplete="off">
                </div>

                <div class="col-md-6">
                    <label class="labelField">Admin Fee (Rs.)</label>
                    <input class="form-control inputField" id="admin_fee" name="admin_fee" type="text" value="0" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="labelField">Disbursal Date&nbsp;<strong class="required_Fields">*</strong></label>
                    <input type="text" class="form-control inputField" id="disbursal_date" name="disbursal_date" onchange="calculateAmount()" value="<?= date('d-m-Y', strtotime(timestamp)) ?>" autocomplete="off">
                </div>

                <div class="col-md-6">
                    <label class="labelField">GST @18.00 %</label>
                    <input type="text" class="form-control inputField" id="adminFeeWithGST" name="adminFeeWithGST" value="0" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="labelField">Repay Date&nbsp;<strong class="required_Fields">*</strong></label>
                    <input type="text" class="form-control inputField" id="repayment_date" name="repayment_date" onchange="calculateAmount()" autocomplete="off">
                </div>

                <div class="col-md-6">
                    <label class="labelField">Total Admin Fee (Rs.)</label>
                    <input class="form-control inputField" id="total_admin_fee" name="total_admin_fee" type="text" value="0" autocomplete="off" readonly>
                </div>

                    <div class="col-md-6">
                        <label class="labelField">Tenure (days)</label>
                        <input type="text" class="form-control inputField" id="tenure" name="tenure" value="0" autocomplete="off" readonly>
                    </div>

                <div class="col-md-6">
                    <label class="labelField">Net Disb. Amount (Rs.)</label>
                    <input type="text" class="form-control inputField" id="net_disbursal_amount" name="net_disbursal_amount" value="0" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="labelField">Repay Amount (Rs.)</label>
                    <input type="text" class="form-control inputField" id="repayment_amount" name="repayment_amount" value="0" autocomplete="off" readonly>
                </div>

                <div class="col-md-6">
                    <label class="labelField">Penal ROI</label>
                    <input type="number" class="form-control inputField" id="panel_roi" name="panel_roi" autocomplete="off" value="1" readonly>
                </div>

                <div class="col-md-6">
                    <label class="labelField">B2B Disbursal</label>
                    <select class="form-control inputField" id="b2b_disbursal" name="b2b_disbursal" autocomplete="off">
                        <option value="">SELECT</option>
                        <option value="YES">YES</option>
                        <option value="NO">NO</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="labelField">B2B NO.</label>
                    <select class="form-control inputField" id="b2b_number" name="b2b_number" autocomplete="off">
                        <option value="">SELECT</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                
                <div class="col-sm-6">
                    <label class="labelField">Deviations</label>
                    <input type="number" class="form-control inputField" id="deviationsApprovedBy" name="deviationsApprovedBy" autocomplete="off" value="-" readonly>
                </div>

                <div class="col-sm-12" style="margin-bottom:10px">
                    <label class="labelField">Remark</label>
                    <textarea class="form-control" id="remark" name="remark" rows="3" cols="95" ></textarea>
                </div>
            </div>
        </form>
        <div class="col-md-12" style="margin: 10px;">
            <button id="btnFormSaveCAM" class="btn btn-success lead-sanction-button">Save </button> 
        </div>
    <?php } else { ?>
        <div id="ViewCAMDetails"></div>
    <?php } ?>