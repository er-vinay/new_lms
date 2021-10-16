<div id="loanStatus"></div>

<div class="footer-support">
    <h2 class="footer-support">
        <button type="button" class="btn btn-info collapse" onclick="collectionHistory('<?= $leadDetails->lead_id ?>', '<?= $leadDetails->customer_id ?>', '<?= user_id ?>')" data-toggle="collapse" data-target="#listRecoveryHistory">Recovery History&nbsp;<i class="fa fa-angle-double-down"></i></button>
    </h2>
</div>

<div id="listRecoveryHistory" class="collapse">
    <div id="recoveryHistory"></div>
</div>

<div class="footer-support">
    <h2 class="footer-support">
        <button type="button" class="btn btn-info collapse" onclick="getResidenceDetails(<?= $leadDetails->lead_id ?>)" data-toggle="collapse" data-target="#addRecoveryPayment">NEW PAYMENT RECEIVED&nbsp;<i class="fa fa-angle-double-down"></i></button>
    </h2>
</div>

<div id="addRecoveryPayment" class="collapse">
    <?php if((agent == "CO1" || agent == "AC1" || agent == "CA" || agent == "SA") ) { ?>
        <!-- && ($leadDetails->status == "CLOSED" || $leadDetails->status == "SETTLED" || $leadDetails->status == "WRITEOFF") -->
        <form id="FormUpdatePayment" class="form-inline" method="post" enctype="multipart/form-data" style="margin: 10px;">
            <input type="hidden" name="lead_id" id="lead_id" value="<?php echo $leadDetails->lead_id; ?>" />
            <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $leadDetails->customer_id; ?>" />
            <input type="hidden" name="user_id" id="user_id" value="<?= user_id ?>">
            <input type="hidden" name="company_id" id="company_id" value="<?= company_id ?>">
            <input type="hidden" name="product_id" id="product_id" value="<?= product_id ?>">
            <input type="hidden" name="loan_no" id="loan_no" value="<?= product_id ?>">
            <input type="hidden" name="recovery_id" id="recovery_id" value="">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

            <div class="col-md-6">
                <label class="labelField">Payment Received&nbsp;<strong class="required_Fields">*</strong></label>
                <input type="number" class="form-control inputField" id="received_amount" name="received_amount" onchange="receivedAmount(this)" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Reference No.&nbsp;<strong class="required_Fields">*</strong></label>
                <input type="text" class="form-control inputField" id="refrence_no" name="refrence_no" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Payment Mode&nbsp;<strong class="required_Fields">*</strong></label>
                <select class="form-control inputField" id="payment_mode" name="payment_mode" autocomplete="off">
                    <option value="">SELECT</option>
                    <option value="NEFT">NEFT</option>
                    <option value="IMPS">IMPS</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="labelField">Repayment Type&nbsp;<strong class="required_Fields">*</strong></label>
                <select class="form-control inputField" id="repayment_type" name="repayment_type" autocomplete="off">
                    <option value="">SELECT</option>
                    <option value="PART PAYMENT">PART PAYMENT</option>
                    <option value="CLOSED">CLOSED</option>
                    <option value="SETTLED">SETTLED</option>
                    <option value="WRITEOFF">WRITEOFF</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="labelField">Discount&nbsp;<strong class="required_Fields">*</strong></label>
                <input type="number" class="form-control inputField" id="discount" name="discount" value="0" onchange="discountAmount(this)" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Excess/ Refund&nbsp;<strong class="required_Fields">*</strong></label>
                <input type="number" class="form-control inputField" id="refund" name="refund" value="0" onchange="refundAmount(this)" autocomplete="off">
            </div>

            <?php if(agent == 'CO1'){ ?>
            <div class="col-md-12">
                <label class="labelField">Upload Payment&nbsp;<strong class="required_Fields">*</strong></label>
                <input type="file" class="form-control" id="upload_payment" name="upload_payment" autocomplete="off">
            </div>

            <div class="col-md-12" style="margin-top: 10px;">
                <label class="labelField">SCM Remarks&nbsp;<strong class="required_Fields">*</strong></label>
                <textarea class="form-control" id="scm_remarks" name="scm_remarks" autocomplete="off" cols="93" rows="1"></textarea>
            </div>

            <?php } else if(agent == 'AC1'){ ?>
            <div class="col-md-12">
                <label class="labelField">Upload Payment&nbsp;<strong class="required_Fields">*</strong></label>
                <input type="date" class="form-control" id="date_of_recived" name="date_of_recived" autocomplete="off">
            </div>

            <div class="col-md-12" style="margin-top: 10px;">
                <label class="labelField">OPS Remarks&nbsp;<strong class="required_Fields">*</strong></label>
                <textarea class="form-control" id="ops_remarks" name="ops_remarks" autocomplete="off" cols="93" rows="1"></textarea>
            </div>
            <?php } ?>
        </form>

        <div calss="row" style="margin-top: 10px; border-top: solid 1px #ddd;text-align: center; padding-top : 20px; padding-bottom: 20px; background: #f3f3f3;">
            <div class="col-md-12 text-center" style="margin-top: 20px;">
                <?php if(agent == 'CO1') { ?>
                <button class="btn btn-success" id="btnUpdatePayment" style="background : #22774e !important;" onclick="UpdatePayment()">Update</button>
                <?php //} else if(agent == 'AC1'){ ?>
                <button class="btn btn-success" id="btn_send_back" onclick="leadSendBack('<?= $leadDetails->lead_id ?>', '<?= user_id ?>', '<?= $leadDetails->customer_id ?>')">Send NOC</button>
                <button class="btn btn-success reject-button" onclick="RejectedLoan()">Reject</button>
                <button class="btn btn-success" id="UpdatePayment" onclick="UpdatePayment()">Verify</button>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>




