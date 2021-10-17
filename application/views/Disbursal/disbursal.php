
        <div id="ViewDisbursalDetails"></div>
        <!-- <div id="disbursalData"></div>
        <div id="ViewAgreementDetails"></div>
        <div id="ViewDisbursalBankDetails"></div> -->
        <?php //if($user->permission_user_disburse == 1): ?>
        <?php if(agent == "DS1" || agent == "CA" || agent == "SA") { ?>
        <div class="footer-support" id="div1disbursalBank">
            <h2 class="footer-support">
                <button type="button" class="btn btn-info collapse" onclick="getResidenceDetails(<?= $leadDetails->lead_id ?>)" data-toggle="collapse" data-target="#disbursalBank">Disbursal Bank&nbsp;<i class="fa fa-angle-double-down"></i></button>
            </h2>
        </div>
        <?php } ?>
        <div id="disbursalBank" class="collapse">
            <div class="form-group">
                <form id="disbursalPayableDetails" class="form-inline" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="lead_id" id="lead_id" readonly>
                    <input type="hidden" class="form-control" name="company_id" id="company_id" value="<?= company_id ?>" readonly>
                    <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $leadDetails->customer_id; ?>" />
                    <input type="hidden" class="form-control" name="product_id" id="product_id" value="<?= product_id ?>" readonly>
                    <input type="hidden" class="form-control" name="user_id" id="user_id" value="<?= user_id ?>" readonly>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <div class="col-sm-6">
                        <label class="labelField">Payable Account&nbsp;<strong class="required_Fields">*</strong></label>
                        <select class="form-control inputField" name="payableAccount" id="payableAccount" required autocomplete="off">
                            <option value="">Select</option>
                            <option value="084305001370">Icici Bank/ 084305001370</option>
                            <option value="920020009314172">Axis Bank/ 920020009314172</option>
                            <option value="201002831962">Indus Bank/ 201002831962</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="labelField">Channel&nbsp;<strong class="required_Fields">*</strong></label>
                        <select class="form-control inputField" style="width:100%;" name="channel" id="channel" required>
                            <option value="">Select</option>
                            <option value="IMPS">IMPS</option>
                            <option value="NEFT">NEFT</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="labelField">Net Disbursal Amount (Rs)&nbsp;<strong class="required_Fields">*</strong></label>
                        <input type="text" class="form-control inputField" name="payable_amount" id="payable_amount" readonly required>
                    </div>

                    <div class="col-md-6">
                        <label class="labelField">Disbursal Date&nbsp;<strong class="required_Fields">*</strong></label>
                        <input type="text" class="form-control inputField" name="disbursal_date" id="disbursal_date" required>
                    </div>
                </form>
            </div>

            <div class="form-group" id="divbtnDisburse" style="float:left; width:100%; margin-bottom: 0px;">
                <div calss="row" style="border-top: solid 1px #ddd;text-align: center; padding-top : 20px; padding-bottom: 20px; background: #f3f3f3;">
                    <div calss="col-md-12 text-center">
                        <button class="btn btn-primary" id="allowDisbursalToBank" style="text-align: center; padding-left: 50px; padding-right: 50px; font-weight: bold;">Disburse</button>
                    </div>
                </div>
            </div>
        </div>

        <?php if(agent == "DS1" || agent == "CA" || agent == "SA") { ?>
        <div class="footer-support" id="div1UpdateReferenceNo">
            <h2 class="footer-support">
                <button type="button" class="btn btn-info collapse" onclick="getResidenceDetails(<?= $leadDetails->lead_id ?>)" data-toggle="collapse" data-target="#divUpdateReferenceNo">Update Reference&nbsp;<i class="fa fa-angle-double-down"></i></button>
            </h2>
        </div>
        <?php } ?>
        <div id="divUpdateReferenceNo" class="collapse">
            <div class="form-group">
                <form id="formUpdateReferenceNo" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="lead_id" id="lead_id" readonly>
                    <input type="hidden" class="form-control" name="company_id" id="company_id" value="<?= company_id ?>" readonly>
                    <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $leadDetails->customer_id; ?>" />
                    <input type="hidden" class="form-control" name="product_id" id="product_id" value="<?= product_id ?>" readonly>
                    <input type="hidden" class="form-control" name="user_id" id="user_id" value="<?= user_id ?>" readonly>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                    <div class="col-md-6">
                        <label class="labelField1">Reference no&nbsp;<strong class="required_Fields">*</strong></label>
                        <input type="text" class="form-control inputField1" name="loan_reference_no" id="loan_reference_no" required>
                    </div>
                
                    <div class="col-md-6">
                        <label class="labelField1">Screenshot&nbsp;<strong class="required_Fields">*</strong></label>
                        <input type="file" class="form-control inputField" id="file" name="file" accept=".png, .jpg, .jpeg" autocomplete="off" required>
                    </div>

                    <div class="form-group" style="float:left; width:100%; margin-bottom: 0px;margin-top: 15px;">
                        <div calss="row" style="border-top: solid 1px #ddd;text-align: center; padding-top : 20px; padding-bottom: 20px; background: #f3f3f3;">
                            <div calss="col-md-12 text-center">
                                <button class="btn btn-primary" id="updateReferenceNo" style="text-align: center; font-weight: bold;">Update Reference</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>