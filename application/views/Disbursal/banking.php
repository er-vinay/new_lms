
<div id="disbursalBanking"></div>

<?php if((agent == "CR2" || agent == "DS1" || agent == "CA" || agent == "SA") && ($leadDetails->stage == "S5" || $leadDetails->stage == "S11" || $leadDetails->stage == "S13")) { ?>
<div class="footer-support">
    <h2 class="footer-support">
        <button type="button" class="btn btn-info collapse" onclick="getResidenceDetails(<?= $leadDetails->lead_id ?>)" data-toggle="collapse" data-target="#AddBank" style="width: 13% !important;">Add Banking&nbsp;<i class="fa fa-angle-double-down"></i></button>
    </h2>
</div>
<?php } ?>

<!------ Add Banking section ----------------------->

<div id="AddBank" class="collapse"> 

    <form id="addBeneficiary" class="form-inline" method="post" enctype="multipart/form-data" style="margin: 10px;">
        <input type="hidden" name="lead_id" id="lead_id" value="<?php echo $leadDetails->lead_id; ?>" />
        <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $leadDetails->customer_id; ?>" />
        <input type="hidden" name="user_id" id="user_id" value="<?= user_id ?>">
        <input type="hidden" name="company_id" id="company_id" value="<?= company_id ?>">
        <input type="hidden" name="product_id" id="product_id" value="<?= product_id ?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

        <div class="col-md-6">
            <label class="labelField">Bank A/C No.&nbsp;<strong class="required_Fields">*</strong></label>
            <input type="text" class="form-control inputField" id="bankA_C_No" name="bankA_C_No" autocomplete="off">
        </div>

        <div class="col-md-6">
            <label class="labelField">Reconfirm Bank A/C No.&nbsp;<strong class="required_Fields">*</strong> </label>
            <input type="text" class="form-control inputField" id="confBankA_C_No" name="confBankA_C_No" onchange="customer_confirm_bank_ac_no(this)" autocomplete="off">
        </div>

        <div class="col-md-6">
            <label class="labelField" class="labelField">IFSC Code&nbsp;<strong class="required_Fields">*</strong></label>
            <select class="form-control inputField" id="customer_ifsc_code" name="customer_ifsc_code" autocomplete="off">
            </select>
        </div>

        <div class="col-md-6">
            <label class="labelField">Bank A/C Type&nbsp;<strong class="required_Fields">*</strong></label>
            <select class="form-control inputField" id="customer_bank_ac_type" name="customer_bank_ac_type" autocomplete="off">
                <option value="SAVINGS">SAVINGS</option>
                <option value="CURRENT">CURRENT</option>
                <option value="OVERDRAFT">OVERDRAFT</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="labelField">Bank Name</label>
            <input type="text" class="form-control inputField" id="customer_bank_name" name="customer_bank_name" autocomplete="off" readonly>
        </div>

        <div class="col-md-6">
            <label class="labelField">Branch Name</label>
            <input type="text"  class="form-control inputField" id="customer_bank_branch" name="customer_bank_branch" autocomplete="off" readonly>
        </div>
    </form>

    <div class="col-md-12" style="margin: 10px;">
        <button id="saveBeneficiary" class="btn btn-success lead-sanction-button">Save </button> 
    </div>
</div>

<div id="viewBankingDetails"></div>

<?php if((agent == "CR2" || agent == "DS1" || agent == "CA" || agent == "SA") && ($leadDetails->stage == "S5" || $leadDetails->stage == "S11" || $leadDetails->stage == "S13")) { ?>
<div class="footer-support">
    <h2 class="footer-support">
        <button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#confirmDisbursalBank">BANK ACCOUNT FOR DISBURSAL - VERIFICATION&nbsp;<i class="fa fa-angle-double-down"></i></button>
    </h2>
</div>
<?php } ?>
<div id="confirmDisbursalBank" class="collapse"> 
    <form id="verifyDisbursalBank" class="form-inline" method="post" enctype="multipart/form-data" style="margin: 10px;">
        <input type="hidden" name="lead_id" id="lead_id" value="<?php echo $leadDetails->lead_id; ?>" />
        <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $leadDetails->customer_id; ?>" />
        <input type="hidden" name="user_id" id="user_id" value="<?= user_id ?>">
        <input type="hidden" name="company_id" id="company_id" value="<?= company_id ?>">
        <input type="hidden" name="product_id" id="product_id" value="<?= product_id ?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />


        <div class="col-md-6">
            <label class="labelField" class="labelField">Bank A/C No.&nbsp;<strong class="required_Fields">*</strong></label>
            <select class="form-control inputField" id="list_bank_AC_No" name="list_bank_AC_No" autocomplete="off">
            </select>
        </div>

        <div class="col-md-6">
            <label class="labelField">Account Verification Status&nbsp;<strong class="required_Fields">*</strong> </label>
            <select class="form-control inputField" id="bank_ac_verification" name="bank_ac_verification" autocomplete="off">
                <option value="">SELECT</option>
                <option value="ACCOUNT AND NAME VERIFIED SUCCESSFULLY">ACCOUNT AND NAME VERIFIED SUCCESSFULLY</option>
                <option value="ACCOUNT VERIFIED BUT NAME MISMATCH">ACCOUNT VERIFIED BUT NAME MISMATCH</option>
                <option value="IFSC CODE WRONG">IFSC CODE WRONG</option>
                <option value="ACCOUNT NUMBER WRONG">ACCOUNT NUMBER WRONG</option>
                <option value="CUSTOMER BANK OFFLINE">CUSTOMER BANK OFFLINE</option>
            </select>
        </div>

        <div class="col-md-12">
            <label class="labelField">Remark&nbsp;<strong class="required_Fields">*</strong> </label>
            <textarea class="form-control" id="remarks" name="remarks" autocomplete="off" style="width: 76%;"></textarea>
        </div>
    </form>

    <div class="col-md-12" style="margin: 10px;">
        <button id="allowDisbursalBank" class="btn btn-success lead-sanction-button">Save </button> 
    </div>
</div>
