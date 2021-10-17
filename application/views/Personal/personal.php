    
    <?php if((agent == "CR2" || agent == "CA" || agent == "SA") && ($leadDetails->stage == "S5" || $leadDetails->stage == "S6" || $leadDetails->stage == "S11")) { ?>
    <form id="insertPersonal" class="form-inline" method="post" enctype="multipart/form-data" style="margin: 10px;">
        <input type="hidden" name="lead_id" id="lead_id" value="<?php echo $leadDetails->lead_id; ?>" />
        <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $leadDetails->customer_id; ?>" />
        <input type="hidden" name="user_id" id="user_id" value="<?= user_id ?>">
        <input type="hidden" name="company_id" id="company_id" value="<?= company_id ?>">
        <input type="hidden" name="product_id" id="product_id" value="<?= product_id ?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

        <div class="col-md-6">
            <label class="labelField" class="labelField">First Name &nbsp;<strong class="required_Fields">*</strong></label>
            <input type="text" class="form-control inputField" id="first_name" name="first_name" autocomplete="off">
        </div>

        <div class="col-md-6">
            <label class="labelField">Middle Name</label>
            <input type="text" class="form-control inputField" id="middle_name" name="middle_name" autocomplete="off">
        </div>

        <div class="col-md-6">
            <label class="labelField">Surname</label>
            <input type="text"  class="form-control inputField" id="sur_name" name="sur_name" autocomplete="off">
        </div>

        <div class="col-md-6">
            <label class="labelField">Gender  &nbsp;<strong class="required_Fields">*</strong></label>
            <select class="form-control inputField" id="gender" name="gender" autocomplete="off">
                <option value="MALE">MALE</option>
                <option value="FEMALE">FEMALE</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="labelField">DOB&nbsp;<strong class="required_Fields">*</strong></label>
            <input type="text" class="form-control inputField" id="dob" name="dob" autocomplete="off">
            <span id="pan_msg" style="color: red;"></span>
        </div>

        <div class="col-md-6">
            <label class="labelField">PAN&nbsp;<strong class="required_Fields">*</strong></label>
            <input type="text" class="form-control inputField" id="pancard" name="pancard" onchange="validatePanNumber(this)" autocomplete="off">
        </div>

        <div class="col-md-6">
            <label class="labelField">Mobile&nbsp;<strong class="required_Fields">*</strong> </label>
            <input type="text" class="form-control inputField" id="mobile" name="mobile" autocomplete="off">
        </div>

        <div class="col-md-6">
            <label class="labelField">Mobile Alternate &nbsp;<strong class="required_Fields">*</strong></label>
            <input type="text" class="form-control inputField" id="alternate_mobile" name="alternate_mobile" autocomplete="off">
        </div>

        <div class="col-md-6">
            <label class="labelField">Email (Personal) </label>
            <input  type="text" class="form-control inputField" id="email" name="email" onchange="IsEmail(this)" autocomplete="off">
        </div>

        <div class="col-md-6">
            <label class="labelField">Email (Office)</label>
            <input type="text" class="form-control inputField" id="alternate_email" name="alternate_email" onchange="IsEmail(this)" autocomplete="off">
        </div>

        <div class="col-md-6">
            <label class="labelField">Screened By </label>
            <input type="text" name="screenedBy" class="form-control inputField" id="screenedBy" autocomplete="off" readonly>
        </div>

        <div class="col-md-6">
            <label class="labelField">Screened On</label>
            <input type="text" class="form-control inputField" id="screenedOn" name="screenedOn" autocomplete="off" readonly>
        </div>
    </form>

    <div class="col-md-12" style="margin: 10px;">
        <button id="savePersonal" class="btn btn-success lead-sanction-button">Save </button> 
    </div>

    <?php } else { ?>
    <div id="ViewPersonalDetails"></div>
    <?php } ?>
    <!------ end for varification section ----------------------->

    <div class="footer-support">
        <h2 class="footer-support">
            <button type="button" class="btn btn-info collapse" onclick="getResidenceDetails(<?= $leadDetails->lead_id ?>)" data-toggle="collapse" data-target="#RESIDENCE1">RESIDENCE&nbsp;<i class="fa fa-angle-double-down"></i></button>
        </h2>
    </div>
    
    <!------ table for  RESIDENCE section ----------------------->

    <div id="RESIDENCE1" class="collapse"> 
        <?php if((agent == "CR2" || agent == "CA" || agent == "SA") && ($leadDetails->stage == "S5" || $leadDetails->stage == "S6" || $leadDetails->stage == "S11")) { ?>
        <form id="insertResidence" class="form-inline" method="post" enctype="multipart/form-data">
            <input type="hidden" name="lead_id" id="lead_id" value="<?php echo $leadDetails->lead_id; ?>" />
            <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $leadDetails->customer_id; ?>" />
            <input type="hidden" name="user_id" id="user_id" value="<?= user_id ?>">
            <input type="hidden" name="company_id" id="company_id" value="<?= company_id ?>">
            <input type="hidden" name="product_id" id="product_id" value="<?= product_id ?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <div class="col-md-12">
                <label class="labelField">House/Flat/ Building No. <span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="hfBulNo1" name="hfBulNo1" autocomplete="off" style="width: 76% !important;">
            </div>

            <div class="col-md-12">
                <label class="labelField">Locality/ Colony/ Sector/ Street<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="lcss1" name="lcss1" autocomplete="off" style="width: 76% !important;">
            </div>

            <div class="col-md-12">
                <label class="labelField">Landmark </label>
                <input type="text" class="form-control inputField" id="lankmark1" name="lankmark1" autocomplete="off" style="width: 76% !important;">
            </div>

            <div class="col-md-6">
                <label class="labelField">State</label>
                <input type="text" class="form-control inputField" id="state1" name="state1" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">City <span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="city1" name="city1" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Pincode <span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="pincode1" name="pincode1" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">District</label>
                <input type="text" class="form-control inputField" id="district1" name="district1" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Aadhar <span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="aadhar1" name="aadhar1" autocomplete="off">
            </div>

            <div class="col-md-12">
                <label class="labelField">Aadhar Address same as above </label>
                <input type="checkbox" name="addharAddressSameasAbove" class="form-control inputField" id="addharAddressSameasAbove" value="YES" style="width: 2% !important;">
            </div>

            <div class="col-md-12">
                <label class="labelField">House/Flat/ Building No. <span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="hfBulNo2" name="hfBulNo2" autocomplete="off" style="width: 76% !important;">
            </div>

            <div class="col-md-12">
                <label class="labelField">Locality/ Colony/ Sector/ Street<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="lcss2" name="lcss2" autocomplete="off" style="width: 76% !important;">
            </div>

            <div class="col-md-12">
                <label class="labelField">Landmark </label>
                <input type="text" class="form-control inputField" id="landmark2" name="landmark2" autocomplete="off" style="width: 76% !important;">
            </div>
            
            <div class="col-md-6">
                <label class="labelField">State</label>
                <input type="text" class="form-control inputField" id="state2" name="state2" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">City<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="city2" name="city2" autocomplete="off">
            </div>
            
            <div class="col-md-6">
                <label class="labelField">Pincode<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="pincode2" name="pincode2" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">District</label>
                <input type="text" class="form-control inputField" id="district2" name="district2" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Present Residence Type<span class="required_Fields">*</span></label>
                <select class="form-control inputField" id="presentResidenceType" name="presentResidenceType" autocomplete="off">
                    <option value="OWNED">OWNED</option>
                    <option value="RENTED">RENTED</option>
                    <option value="PARENTAL">PARENTAL</option>
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="labelField">Residing Since<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="residenceSince" name="residenceSince" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField"> SCM Confirmation Required</label>
                <input type="checkbox" name="SCM_CONF_REQ" class="form-control inputField" id="SCM_CONF_REQ" style="width: 3% !important;">
            </div>
            
            <div class="col-md-6">
                <label class="labelField"> SCM Response</label>
                <input type="text" class="form-control inputField" id="scmResponce" name="scmResponce" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField"> SCM Confirmation Initiated On</label>
                <input type="text" class="form-control inputField" id="scmConfIntOn" name="scmConfIntOn" autocomplete="off">
            </div>
            
            <div class="col-md-6">
                <label class="labelField"> SCM Response On</label>
                <input type="text" class="form-control inputField" id="scmResponceOn" name="scmResponceOn" autocomplete="off">
            </div>

            <div class="col-md-12">
                <label class="labelField"> SCM Remarks</label>
                <input type="text" class="form-control inputField" id="scmRemarks" name="scmRemarks" autocomplete="off" style="width: 76% !important;">
            </div>
        </form>

        <div class="col-md-6">        
            <label colspan='4' style="text-align: center;">
            <button type="Submit" id="saveResidence" class="btn btn-success lead-sanction-button">Save </button> </label>
        </div>
        <?php } else { ?>
        <div id="viewResidenceDetails"></div>
        <?php } ?>
    </div>

    <!-- end section for labele residence section ----------------->

    <!------ table for  OFFICE section ----------------------->
    <div class="footer-support">
        <h2 class="footer-support">
            <button type="button" class="btn btn-info collapse" onclick="getEmploymentDetails(<?= $leadDetails->lead_id ?>)"  data-toggle="collapse" data-target="#EMPLOYMENT">EMPLOYMENT&nbsp;<i class="fa fa-angle-double-down"></i></button>
        </h2>
    </div>

    <div id="EMPLOYMENT" class="collapse"> 
        <?php if((agent == "CR2" || agent == "CA" || agent == "SA") && ($leadDetails->stage == "S5" || $leadDetails->stage == "S6" || $leadDetails->stage == "S11")) { ?>
        <form id="insertEmployment" class="form-inline" method="post" >
            <input type="hidden" name="lead_id" id="lead_id" value="<?php echo $leadDetails->lead_id; ?>" />
            <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $leadDetails->customer_id; ?>" />
            <input type="hidden" name="user_id" id="user_id" value="<?= user_id ?>">
            <input type="hidden" name="company_id" id="company_id" value="<?= company_id ?>">
            <input type="hidden" name="product_id" id="product_id" value="<?= product_id ?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <div class="col-md-6">
                <label class="labelField">Office/ Employer Name&nbsp;<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="officeEmpName" name="officeEmpName" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Shop/ Block/ Building No.&nbsp;<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="hfBulNo3" name="hfBulNo3" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Locality/ Colony/ Sector/ Street&nbsp;<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="lcss3" name="lcss3" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Landmark</label>
                <input type="text" class="form-control inputField" id="lankmark3" name="lankmark3" autocomplete="off">
            </div>
        
            <div class="col-md-6">
                <label class="labelField">City&nbsp;<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="city3" name="city3" autocomplete="off">
            </div>
            
            <div class="col-md-6">
                <label class="labelField">Pincode&nbsp;<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="pincode3" name="pincode3" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">District</label>
                <input type="text" class="form-control inputField" id="district3" name="district3" autocomplete="off">
                <label class="labelField">State<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="state3" name="state3" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Website</label>
                <input type="text" class="form-control inputField" id="website" name="website" autocomplete="off">
            </div>
            
            <div class="col-md-6">
                <label class="labelField">Employer Type&nbsp;<span class="required_Fields">*</span></label>
                <select class="form-control inputField" id="employeeType" name="employeeType" autocomplete="off">
                    <option value="GOVT./ PSU">GOVT./ PSU</option>
                    <option value="MNC/ LISTED">MNC/ LISTED</option>
                    <option value="PVT LTD">PVT LTD</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="labelField">Industry </label>
                <input type="text" class="form-control inputField" id="industry" name="industry" autocomplete="off">
            </div>
            
            <div class="col-md-6">
                <label class="labelField">Sector</label>
                <input type="text" class="form-control inputField" id="sector" name="sector" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Department </label>
                <input type="text" class="form-control inputField" id="department" name="department" autocomplete="off">
            </div>
            
            <div class="col-md-6">
                <label class="labelField">Designation </label>
                <input type="text" class="form-control inputField" id="designation" name="designation" autocomplete="off">
            </div>

            <div class="col-md-6">
                <label class="labelField">Employed Since&nbsp;<span class="required_Fields">*</span></label>
                <input type="text" class="form-control inputField" id="employedSince" name="employedSince" autocomplete="off">
            </div>
            
            <div class="col-md-6">
                <label class="labelField">Present Service Tenure</label>
                <input type="text" class="form-control inputField" id="presentServiceTenure" name="presentServiceTenure" autocomplete="off" readonly>
            </div>
        </form>

        <div class="col-md-6">
            <label colspan='4' style="text-align: center;">
            <button id="saveEmployment" class="btn btn-success lead-sanction-button">Save </button> </label>
        </div>
        <?php } else { ?>
        <div id="ViewEmploymentDetails"></div>
        <?php } ?>
    </div>

    <div class="footer-support">
        <h2 class="footer-support">
            <button type="button" class="btn btn-info collapse" onclick="getReferenceDetails(<?= $leadDetails->lead_id ?>)"  data-toggle="collapse" data-target="#REFERENCES">REFERENCES&nbsp;<i class="fa fa-angle-double-down"></i></button>
        </h2>
        <div id="REFERENCES" class="collapse"> 
            <?php if((agent == "CR2" || agent == "CA" || agent == "SA") && ($leadDetails->stage == "S5" || $leadDetails->stage == "S6" || $leadDetails->stage == "S11")) { ?>
            <form id="insertReference" class="form-inline" method="post" enctype="multipart/form-data">
                <input type="hidden" name="lead_id" id="lead_id" value="<?php echo $leadDetails->lead_id; ?>" />
                <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $leadDetails->customer_id; ?>" />
                <input type="hidden" name="user_id" id="user_id" value="<?= user_id ?>">
                <input type="hidden" name="company_id" id="company_id" value="<?= company_id ?>">
                <input type="hidden" name="product_id" id="product_id" value="<?= product_id ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <div class="col-md-6">
                    <label class="labelField">Reference</label>
                    <input type="text" class="form-control inputField" id="refrence1" name="refrence1" autocomplete="off">
                </div>
                
                <div class="col-md-6">
                    <label class="labelField">Reference</label>
                    <input type="text" class="form-control inputField" id="refrence2" name="refrence2" autocomplete="off">
                </div>

                <div class="col-md-6">
                    <label class="labelField">Relation&nbsp;<span class="required_Fields">*</span></label>
                    <select class="form-control inputField" id="relation1" name="relation1" autocomplete="off">
                        <option value="Parents">Parents</option>
                        <option value="Relative">Relative</option>
                        <option value="Friend">Friend</option>
                        <option value="Colleague">Colleague</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label class="labelField">Relation&nbsp;<span class="required_Fields">*</span></label>
                    <select class="form-control inputField" id="relation2" name="relation2" autocomplete="off">
                        <option value="Parents">Parents</option>
                        <option value="Relative">Relative</option>
                        <option value="Friend">Friend</option>
                        <option value="Colleague">Colleague</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="labelField">Reference Mobile&nbsp;<span class="required_Fields">*</span></label>
                    <input type="text" class="form-control inputField" id="refrence1mobile" name="refrence1mobile" autocomplete="off">
                </div>
                
                <div class="col-md-6">
                    <label class="labelField">Reference Mobile&nbsp;<span class="required_Fields">*</span></label>
                    <input type="text" class="form-control inputField" id="refrence2mobile" name="refrence2mobile" autocomplete="off">
                </div>
            </form>

            <div class="col-md-6">
                <label colspan='4' style="text-align: center;">
                <button id="saveReference" class="btn btn-success lead-sanction-button">Save </button> </label>
            </div>
            <?php } else { ?>
            <div id=""></div>
            <?php } ?>
        </div>
    </div>
    