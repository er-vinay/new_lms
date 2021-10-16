<?php $this->load->view('Layouts/header') ?>
<?php $url =  $this->uri->segment(1); ?>

<section>
    <div class="container">
        <div class="taskPageSize taskPageSizeDashboard" style="border: 1px solid #ddd;height:auto !important;">
            <div class="alertMessage">
                <div class="alert alert-dismissible alert-success msg">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Thanks!</strong>
                    <a href="#" class="alert-link">Add Successfully</a>
                </div>
                <div class="alert alert-dismissible alert-danger err">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Failed!</strong>
                    <a href="#" class="alert-link">Try Again.</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tab" role="tabpanel">
                        <input type="hidden" name="lead_id" id="lead_id" value="<?= $leadDetails->lead_id ?>" readonly>
                        <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['isUserSession']['user_id'] ?>" readonly>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="borderList "><a href="#LeadSaction" onclick="getLeadDetails()" aria-controls="lead" role="tab" data-toggle="tab">Lead</a></li>
                            <?php if($_SESSION['isUserSession']['labels'] == "CR2" 
                                || $_SESSION['isUserSession']['labels'] == "CR3"
                                || $_SESSION['isUserSession']['labels'] == "CA"
                                || $_SESSION['isUserSession']['labels'] == "SA"
                                || $_SESSION['isUserSession']['labels'] == "DS1" 
                                || $url == "search"){ ?>
                            <li role="presentation" class="borderList"><a href="#DocumentSaction" onclick="getCustomerDocs()" aria-controls="Document" role="tab" data-toggle="tab">Documents</a></li>
                            
                            <li role="presentation" class="borderList"><a href="#Verification" aria-controls="Verification" role="tab" data-toggle="tab" >Verification</a></li>

                            <li role="presentation" class="borderList"><a href="#PersonalDetailSaction" onclick="getPersonalDetails()" aria-controls="Personal" role="tab" data-toggle="tab">Personal</a></li>
                            
                            <li role="presentation" class="borderList "><a href="#CAMSheetSaction" onclick="getCam()" aria-controls="messages" role="tab" data-toggle="tab">CAM</a></li>
                            
                            <?php } if($_SESSION['isUserSession']['labels'] == "DS1" 
                                || $_SESSION['isUserSession']['labels'] == "CA" 
                                || $_SESSION['isUserSession']['labels'] == "SA" 
                                || $url == "search"){ ?>
                            <li role="presentation" class="borderList"><a href="#DisbursalSaction" onclick="disbursalDetails()" aria-controls="messages" role="tab" data-toggle="tab">Disbursal</a></li>
                            
                            <?php } if($_SESSION['isUserSession']['labels'] == "AC1" 
                                || $_SESSION['isUserSession']['labels'] == "CA" 
                                || $_SESSION['isUserSession']['labels'] == "SA" 
                                || $url == "search"){ ?>
                            <li role="presentation" class="borderList"><a href="#CollectionSaction" onclick="collectionDetails()" aria-controls="messages" role="tab" data-toggle="tab">Collection</a></li>
                            <?php } ?>
                        </ul><hr> 
                        <div class="tab-content tabs">
                            <div role="tabpanel" class="tab-pane fade in active" id="LeadSaction">
                                <div id="LeadDetails">
                                    <?php $this->load->view('Tasks/leadsDetails'); ?>
                                </div>
                                
                                <div class="footer-support">
                                    <h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#old_leads" onclick="viewOldHistory(<?= $leadDetails->lead_id ?>)">INTERNAL DEDUPE&nbsp;<i class="fa fa-angle-double-down"></i></button></h2>
                                </div>
                                <div id="old_leads" class="collapse"> 
                                    <div id="oldTaskHistory"></div>
                                </div>
                                
                                <div class="footer-support">
                                    <h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#cibil_details" onclick="ViewCibilStatement(<?= $leadDetails->lead_id ?>)">CREDIT BUREAU&nbsp;<i class="fa fa-angle-double-down"></i></button></h2>
                                </div>
                                <div id="bankStatement"></div>
                                
                                <div id="cibil_details" class="collapse">
                                    <?php if($_SESSION['isUserSession']['labels'] == "CR1" 
                                        || $_SESSION['isUserSession']['labels'] == "CR2"
                                        || $_SESSION['isUserSession']['labels'] == "CA"
                                        || $_SESSION['isUserSession']['labels'] == "SA") : ?>
                                    <div id="btndivCheckCibil">
                                        <div id="checkCustomerCibil" style="background:#fff !important;">
                                            <a href="#" class="btn btn-primary" id="btnCheckCibil" onclick="checkCustomerCibil()">Check CIBIL</a>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div id="cibilStatement"></div>
                                </div>
                                <?php if(($_SESSION['isUserSession']['labels'] == "CR1" 
                                        || $_SESSION['isUserSession']['labels'] == "CA"
                                        || $_SESSION['isUserSession']['labels'] == "SA") && $leadDetails->stage != "S9") { ?>
                                <div id="btndivReject">  
                                    <div calss="row" style="border-top: solid 1px #ddd;text-align: center; padding-top : 20px; padding-bottom: 20px; background: #f3f3f3; overflow: auto;">
                                        <div class="col-md-12 text-center">
                                            <button class="btn btn-success reject-button" onclick="RejectedLoan()">Reject</button>
                                            <button class="btn btn-success lead-hold-button" onclick="holdLeadsRemark()">Hold</button>
                                            <button class="btn btn-success lead-sanction-button" onclick="sanctionleads()">Recommend</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="divExpendReason" class="marging-footer-verifa">
                                    <div style="margin-top: 15px">
                                        <div class="col-md-3 text-center">&nbsp;</div>
                                        <div class="col-md-4 text-center">
                                            <select class="js-select2 form-control inputField" name="resonForReject" id="resonForReject" autocomplete="off" style="float: right;width: 100% !important;height: 43px !important;">  
                                            </select>
                                        </div>
                                        <div class="col-md-2 text-left">
                                         <button class="btn btn-primary" id="btnRejectApplication" onclick="ResonForRejectLoan()">Reject Application</button>
                                        </div>
                                        <div class="col-md-3 text-center">
                                          &nbsp;
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="divExpendReason2" class="marging-footer-verifa">
                                    <div style="margin-top: 15px">
                                         <div class="col-md-3 text-left">&nbsp;</div>
                                        <div class="col-md-2 text-left">
                                          <input type="text" class="form-control inputField" name="remark" id="hold_remark" placeholder="Enter Remarks" style="width:100% !important;">
                                        </div> 
                                        
                                        <div class="col-md-2 text-left">
                                          <input type="date" class="form-control inputField" name="holdDurationDate" id="holdDurationDate" placeholder="Enter Remarks" style="width:100% !important;">
                                        </div>
                                        
                                        <div class="col-md-2 text-left">
                                            <button class="btn btn-primary" id="btnRejectApplication" onclick="holdleads()">Lead Hold</button>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div> 
                            
                            <div role="tabpanel" class="tab-pane fade" id="DocumentSaction"> 
                                <input type="hidden" name="leadIdForDocs" id="leadIdForDocs"> 
                                <div id="documents" class="show">
                                <?php if($_SESSION['isUserSession']['role'] == creditManager 
                                    || $_SESSION['isUserSession']['role'] == admin) : ?>
                                    <div id="btndivUploadDocs">
                                        <div style="background:#fff !important;">
                                            <button class="btn btn-primary" style="background:#ddd !important; color: #000 !important; border: none;" id="sendRequestToCustomerForUploadDocs" onclick="sendRequestToCustomerForUploadDocs()" disabled>Send Request For Upload Docs</button>
                                            <!--button class="btn btn-primary" id="btnUploadDocsByUser">Upload Docs</button-->
                                            <p id="selectDocsTypes" style="text-transform:uppercase; margin-top:20px;">
                                                <label class="radio-inline">
                                                    <input type="radio" name="selectdocradio" id="selectdocradio1" value="KYC"> KYC Address Proof  
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="selectdocradio" id="selectdocradio2" value="IDENTITY"> Identity Proof
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="selectdocradio" id="selectdocradio3" value="INCOME"> Income Proof
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="selectdocradio" id="selectdocradio4" value="OTHER"> Other Identity Proof
                                                </label>
                                            </p>
                                        </div>   
                                        <div class="row" id="docsform">
                                            <form id="formUserDocsData" method="post" enctype="multipart/form-data" style="float: left;width: 97%;margin:13px 13px 20px 0px;">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" /><!-- 
                                                <input type="hidden" name="lead_id" id="lead_id" value="<?= $leadDetails->lead_id ?>"> -->
                                                <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['isUserSession']['user_id'] ?>">
                                                <input type="hidden" name="company_id" id="company_id" value="<?= $_SESSION['isUserSession']['company_id'] ?>">
                                                <!--Update docs for doc id-->
                                                <div id="getDocId"></div>
                                                <div class="col-md-2">
                                                    <input type="text" id="docuemnt_type" name="docuemnt_type" class="form-control" placeholder="Document Type" readonly="readonly" required>
                                                </div>
                                                <div class="col-md-3" id="selectDocType">
                                                    <select class="form-control" name="document_name" id="document_name" required>
                                                        <option value="">Select Type</option>
                                                        <option value="Aadhar (front)">Aadhar (front)</option>
                                                        <option value="Aadhar (back)">Aadhar (back)</option>
                                                        <option value="PAN">PAN</option>
                                                        <option value="Passport Foto">Passport Foto</option>
                                                        <option value="Credit Card (front)">Credit Card (front)</option>
                                                        <option value="Credit card statement">Credit card statement</option>
                                                        <option value="Salary Slip 1">Salary Slip 1</option>
                                                        <option value="Salary Slip 2">Salary Slip 2</option>
                                                        <option value="Office ID Card (front)">Office ID Card (front)</option>
                                                        <option value="Office ID Card (back)">Office ID Card (back)</option>
                                                        <option value="Rent agreement">Rent agreement</option>
                                                        <option value="Utility Bill">Utility Bill</option>
                                                        <option value="Domestic Gas Receipt">Domestic Gas Receipt</option>
                                                        <option value="Passport (name)">Passport (name)</option>
                                                        <option value="Passport (address)">Passport (address)</option>
                                                        <option value="Driving License">Driving License</option>
                                                        <option value="Bank Statement">Bank Statement</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3" id="selectFileType">
                                                    <input type="file" class="form-control" name="file_name" id="file_name" accept="image/*,.jpeg, .png, .jpg,.pdf" required>
                                                </div>
                                                <!--<span id="bankPassword"></span>-->
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                                                </div>
                                                <div class="col-md-2" id="btnDocsSave">
                                                   <button class="btn btn-primary" id="btnSaveDocs">Save</button>
                                                </div></br></br> 
                                            </form> 
                                        </div> 
                                        <div class="footer-support">
                                            <h2 class="footer-support" style="margin-top: 0px;"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#Uploaded-Documents">Uploaded Documents&nbsp;<i class="fa fa-angle-double-down"></i></button></h2>
                                        </div>
                                        <div id="Uploaded-Documents" class="collapse" style="background: #fff !important;">
                                            <div id="docsHistory"></div>
                                        </div> 
                                    </div> 
                                    <?php endif; ?>
                                </div>  
                            </div>
                        
                            <div role="tabpanel" class="tab-pane fade" id="Verification">
                                <div id="divVerification">
                                    <?php //$this->load->view('Verification/verification'); ?>
                                </div>
                            </div>
                                 
                            <div role="tabpanel" class="tab-pane fade" id="PersonalDetailSaction">
                                <div style="border : solid 1px #ddd;margin-bottom: 20px;">
                                    <?php if($_SESSION['isUserSession']['role'] == creditManager): ?>
                                    <div id="divPersonalDetails">
                                        <form id="FormSaveCustomerDetails" class="form-inline" method="post" autocomplete="off">
                                            <div class="form-group" style="margin-top:30px">
                                                <input type="hidden" name="leadID" id="leadID">
                                                <input type="hidden" name="user_id" id="user_id" value="<?= user_id ?>">
                                                <input type="hidden" name="company_id" id="company_id" value="<?= company_id ?>">
                                                <input type="hidden" name="product_id" id="product_id" value="<?= product_id ?>">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                                                <div class="col-md-6" >
                                                    <label class="labelField">First Name&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <input class="form-control inputField" id="borrower_name" name="borrower_name" type="text" autocomplete="off">
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label class="labelField">Middle Name&nbsp;</label>
                                                    <input class="form-control inputField" id="borrower_mname" name="borrower_mname" type="text" autocomplete="off">
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label class="labelField">Last Name&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <input class="form-control inputField" id="borrower_lname" name="borrower_lname" type="text" autocomplete="off">
                                                </div>
                                                
                                                 <div class="col-md-6">
                                                    <label class="labelField">Gender&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <select class="form-control inputField gender" id="gender" name="gender" autocomplete="off">
                                                        <option vlaue="">Select</option>
                                                        <option vlaue="MALE">MALE</option>
                                                        <option vlaue="FEMALE">FEMALE</option>
                                                    </select>
                                                </div>
                    
                                                <div class="col-md-6">
                                                    <label class="labelField">DOB&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <input type="text" class="form-control inputField" id="dob" name="dob" autocomplete="off" >
                                                </div>
                    
                                                <div class="col-md-6">
                                                    <label class="labelField">PAN&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <input type="text" class="form-control inputField" id="pancard" name="pancard" maxlength="10" minlength="10" autocomplete="off">
                                                </div>
                    
                                                <div class="col-md-6">
                                                    <label class="labelField">Mobile&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <input type="tel" class="form-control inputField" id="mobile" name="mobile" maxlength="10" autocomplete="off">
                                                </div>
                    
                                                <div class="col-md-6">
                                                    <label class="labelField">Alternate Mobile&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <input type="tel" class="form-control inputField" id="alternate_no" name="alternate_no" maxlength="10" autocomplete="off">
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label class="labelField">Email (Personal)&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <input type="email" class="form-control inputField" id="emailID" name="email" autocomplete="off" >
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label class="labelField">State&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <select class="form-control inputField" id="state" name="state" autocomplete="off" ></select>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label class="labelField">City&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <select class="form-control inputField" id="city" name="city" autocomplete="off" ></select>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label class="labelField">Pincode&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <input type="text" class="form-control inputField" id="pincode" name="pincode" autocomplete="off" >
                                                </div>
                                                
                                                <div class="col-md-6" style="margin-bottom: 10px;">
                                                    <label class="labelField">Initiated On&nbsp;</label>
                                                    <input type="text" class="form-control inputField" id="lead_initiated_date" name="lead_initiated_date" autocomplete="off" readonly>
                                                </div>
                                                
                                                <div class="col-md-6" style="background: #ddd; margin-bottom: 10px;">
                                                    <label class="labelField">Post Office</label>
                                                    <input type="text" class="form-control inputField" id="post_office" name="post_office" autocomplete="off" readonly style="    margin-bottom: 5px !important; margin-top: 5px;">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="labelField">Email (Office)</label>
                                                    <input type="email" class="form-control inputField" id="alternateEmail" name="alternateEmail" onchange="IsEmail(this)" autocomplete="off" >
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label class="labelField">Aadhar&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <input type="text" class="form-control inputField" id="aadhar" name="aadhar" autocomplete="off" >
                                                </div>
                     
                                                 <div class="col-md-6">
                                                     <label class="labelField">Residence Address Line 1&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <input type="text" class="form-control inputField" id="residence_address_line1" name="residence_address_line1" autocomplete="off" >
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label class="labelField">Residence Address Line 2&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <input type="text" class="form-control inputField" id="residence_address_line2" name="residence_address_line2" autocomplete="off" >
                                                </div>
                    
                                                <div class="col-md-6">
                                                    <label class="labelField">Residence Type&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <select class="form-control inputField" name="residentialType" id="residentialType" autocomplete="off">
                                                        <option value="">Select</option>
                                                        <option value="PG">PG</option>
                                                        <option value="Owned">Owned</option>
                                                        <option value="Rented">Rented</option>
                                                        <option value="Family owned">Family owned</option>
                                                        <option value="Guest House">Guest House</option>
                                                        <option value="Company Accomodation">Company Accomodation</option>
                                                    </select>
                                                </div>
                                                
                                                 <div class="col-md-6">
                                                    <label class="labelField">Residential Proof&nbsp;<strong class="required_Fields">*</strong></label>
                                                    <select class="form-control inputField residential_proof" name="residential_proof" id="residential_proof" autocomplete="off"> 
                                                     </select>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <label class="labelFields">Present Address same as Residence Address ?</label>
                                                    <input type="checkbox" id="isPresentAddress" name="isPresentAddress">
                                                </div>
                                                
                                                <span id="present_address">
                                                    <div class="col-md-6" id="selectPresentAddress">
                                                        <label class="labelField">Present Address Type</label>
                                                        <select class="form-control inputField" name="presentAddressType" id="presentAddressType" autocomplete="off">
                                                            <option value="">Select</option>
                                                            <option value="PG">PG</option>
                                                            <option value="Owned">Owned</option>
                                                            <option value="Rented">Rented</option>
                                                            <option value="Family owned">Family owned</option>
                                                            <option value="Guest House">Guest House</option>
                                                            <option value="Company Accomodation">Company Accomodation</option>
                                                        </select>
                                                    </div>
                                                   
                                                    <div class="col-md-6">
                                                        <label class="labelField">Other Address Proof&nbsp;<strong class="required_Fields"></strong></label>
                                                        <select class="form-control inputField" name="other_add_proof" id="other_add_proof" autocomplete="off">
                                                            <option value="">Select</option>
                                                            <option value="Salary Slip 2">Salary Slip 2</option>
                                                            <option value="PAN">PAN</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <label class="labelField">Present Address Line 1</label>
                                                        <input type="text" class="form-control inputField" id="present_address_line1" name="present_address_line1" autocomplete="off" >
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <label class="labelField">Present Address Line 2</label>
                                                        <input type="text" class="form-control inputField" id="present_address_line2" name="present_address_line2" autocomplete="off" >
                                                    </div>
                                                </span>
                                                
                                                <div class="col-md-6">
                                                    <label class="labelField">Employer/ Business name</label>
                                                    <input type="text" class="form-control inputField" id="employer_business" name="employer_business" autocomplete="off" >
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="labelField">Office Address</label>
                                                    <input type="text" class="form-control inputField" id="office_address" name="office_address" autocomplete="off" >
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="labelField">Office Website</label>
                                                    <input type="text" class="form-control inputField" id="office_website" onchange="websiteValidation(this)" name="office_website" autocomplete="off" >
                                                </div>
                                            </div>
                                        </form>
                                        <div calss="row" style="border-top: solid 1px #ddd;text-align: center; padding-top : 20px; padding-bottom: 20px;background: #f3f3f3;">
                                            <div calss="col-md-12 text-center">
                                                <button class="btn btn-primary" id="saveCustomerDetails" style="text-align: center; padding-left: 50px; padding-right: 50px; font-weight: bold;">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div id="ViewPersonalDetails"></div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="CAMSheetSaction">
                                <a class="btn btn-primary" href="#" id="urlViewCAM" target="_blank" title="View" style="width: 30px;height: 30px;padding: 5px 0px 0px 0px;">
                                    <i class="fa fa-eye"> 
                                    </i>
                                </a>
                                <a class="btn btn-primary" href="#" id="urlDownloadCAM" style="width: 30px;height: 30px;padding: 5px 0px 0px 0px;">
                                    <i class="fa fa-download"></i>
                                </a>
                                <div class="camBorder">
                                    <?php //if($user->permission_user_credit == 1) : ?>
                                    <div id="divCamDetails">
                                        <?php if(company_id == 2 && product_id == 1){ ?>
                                            <?php $this->load->view('CAM/camPayday'); ?>
                                        <?php } if(company_id == 2 && product_id == 2){ ?>
                                            <?php $this->load->view('CAM/camLAC'); ?>
                                        <?php } ?>
                                        
                                        <div calss="row" style="border-top: solid 1px #ddd;text-align: center; padding-top : 20px; padding-bottom: 20px; background: #f3f3f3;">
                                            <div calss="col-md-12 text-center">
                                                <button class="btn btn-primary" id="btnFormSaveCAM" style="text-align: center; padding-left: 50px; padding-right: 50px; font-weight: bold;height: 42px;">Save</button>
                                                <button class="btn btn-success reject-button" onclick="RejectedLoan()">Reject</button>
                                                <button class="btn btn-success lead-hold-button" onclick="holdLeadsRemark()">Hold</button>
                                                <button class="btn btn-success lead-sanction-button" onclick="LeadRecommendation()">Recommend</button>
                                            </div>  
                                        </div>
                                        <?php if($_SESSION['isUserSession']['role'] == creditManager){ ?>
                                            <div id="divExpendReason" class="marging-footer-verifa">
                                                <div style="margin-top: 15px">
                                                    <div class="col-md-3 text-center">&nbsp;</div>
                                                    <div class="col-md-4 text-center">
                                                        <select class="js-select2 form-control inputField" name="resonForReject" id="resonForReject" autocomplete="off" style="float: right;width: 100% !important;height: 43px !important;">  
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 text-left">
                                                     <button class="btn btn-primary" id="btnRejectApplication" onclick="ResonForRejectLoan()">Reject Application</button>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                      &nbsp;
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div id="divExpendReason2" class="marging-footer-verifa">
                                                <div style="margin-top: 15px">
                                                     <div class="col-md-3 text-left">&nbsp;</div>
                                                    <div class="col-md-2 text-left">
                                                      <input type="text" class="form-control inputField" name="remark" id="hold_remark" placeholder="Enter Remarks" style="width:100% !important;">
                                                    </div> 
                                                    
                                                    <div class="col-md-2 text-left">
                                                      <input type="date" class="form-control inputField" name="holdDurationDate" id="holdDurationDate" placeholder="Enter Remarks" style="width:100% !important;">
                                                    </div>
                                                    
                                                    <div class="col-md-2 text-left">
                                                        <button class="btn btn-primary" id="btnRejectApplication" onclick="holdleads()">Hold Application</button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <span id="ResonBoxForHold"></span>
                                    </div>
                                    <?php //endif; ?>
                                    <div id="ViewCAMDetails"></div>

                                    <?php if($_SESSION['isUserSession']['role'] == headCreditManager): ?>
                                    <div id="btndivCamDetails">
                                        <div calss="row" style="border-top: solid 1px #ddd;text-align: center; padding-top : 20px; padding-bottom: 20px; background: #f3f3f3;">
                                            <div calss="col-md-12 text-center">
                                                <button class="btn btn-success reject-button" onclick="RejectedLoan()" style="text-align: center; padding-left: 25px; padding-right: 25px; font-weight: bold;">Reject</button>
                                                <button class="btn btn-primary" id="btnSendBack" style="text-align: center; padding-left: 25px; padding-right: 25px; font-weight: bold;">Send Back</button>
                                                <button class="btn btn-success" id="btnCAM_Approve" style="background: #7cb342 !important; text-align: center; padding-left: 25px; padding-right: 25px; font-weight: bold;">Sanction</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="divExpendReason" class="marging-footer-verifa">
                                        <div style="margin-top: 15px">
                                            <div class="col-md-3 text-center">&nbsp;</div>
                                            <div class="col-md-4 text-center">
                                                <select class="js-select2 form-control inputField" name="resonForReject" id="resonForReject" autocomplete="off" style="float: right;width: 100% !important;height: 43px !important;">  
                                                </select>
                                            </div>
                                            <div class="col-md-2 text-left">
                                             <button class="btn btn-primary" id="btnRejectApplication" onclick="ResonForRejectLoan()">Reject Application</button>
                                            </div>
                                            <div class="col-md-3 text-center">
                                              &nbsp;
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div role="tabpanel" class="tab-pane fade" id="DisbursalSaction">
                                <div class="camBorder" style="float : left;">
                                    <div id="disbursalData"></div>
                                    <div id="ViewDisbursalDetails"></div>
                                    <div id="ViewAgreementDetails"></div>
                                    <div id="ViewDisbursalBankDetails"></div>
                                    <?php //if($user->permission_user_disburse == 1): ?>
                                        <div id="formDisbursalOtherDetails">
                                            <div class="col-md-12" style="padding: 0px 0px; border-bottom:1px solid #ddd; margin-bottom : 15px;">
                                                <p class="headingForm">Disbursal Bank</p>
                                            </div>
                                            <div class="form-group">
                                                <form id="disbursalPayableDetails" class="form-inline" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" class="form-control" name="lead_id" id="lead_id" readonly>
                                                    <input type="hidden" class="form-control" name="company_id" id="company_id" value="<?= company_id ?>" readonly>
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
                                                        <label class="labelField">Disbursal Amount&nbsp;<strong class="required_Fields">*</strong></label>
                                                        <input type="text" class="form-control inputField" name="payable_amount" id="payable_amount" readonly required>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="form-group" id="divbtnDisburse" style="float:left; width:100%; margin-bottom: 0px;">
                                                <div calss="row" style="border-top: solid 1px #ddd;text-align: center; padding-top : 20px; padding-bottom: 20px; background: #f3f3f3;">
                                                    <div calss="col-md-12 text-center">
                                                        <button class="btn btn-primary" id="updateDisbursalApprove" style="text-align: center; padding-left: 50px; padding-right: 50px; font-weight: bold;">Disburse</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="divUpdateReferenceNo">
                                            <div class="col-md-12" style="padding: 0px 0px; border-bottom:1px solid #ddd; margin-bottom : 15px;">
                                                <p class="headingForm">Update Reference</p>
                                            </div>
                                            <div class="form-group">
                                                <form id="formUpdateReferenceNo" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" class="form-control" name="lead_id" id="lead_id" readonly>
                                                    <input type="hidden" class="form-control" name="company_id" id="company_id" value="<?= company_id ?>" readonly>
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
                                        <?php //$this->view->load('Disbursal/tab_disburse_form'); ?>
                                    <?php //endif; ?>
                                </div>
                            </div>
                            
                            <div role="tabpanel" class="tab-pane fade" id="CollectionSaction">
                                <div id="collection">
                                    <?php $this->load->view('Collection/collection'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</senction>
<?php $this->load->view('Layouts/footer') ?>
<?php $this->load->view('Tasks/main_js.php') ?>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<script> 
    var csrf_token = $("input[name=csrf_token]").val();
</script>
<!-- 
 
<script> 
    function validloanamount(roi) 
    {
        var loan_roi = $(roi).val();
        if(loan_roi < 0.5 || loan_roi > 5) {
            $('#errorroi').html("* Max ROI 5 %").show().css({'color' : 'red'});
            $(roi).val("");
            return false;
        }else{
            $("#errorroi").html('').show().css({'color' : 'white'});
        }
    }
    function websiteValidation(websiteName){
        var url = $(websiteName).val();
       // var a=["http://www.sample.com","https://www.sample.com/","https://www.sample.com#","http://www.sample.com/xyz","http://www.sample.com/#xyz","www.sample.com","www.sample.com/xyz/#/xyz","sample.com","sample.com?name=foo","http://www.sample.com#xyz","http://www.sample.c"];
        var regex =/^((https?|ftp|smtp):\/\/)?(www.)?[a-z0-9]+(\.[a-z]{2,}){1,3}(#?\/?[a-zA-Z0-9#]+)*\/?(\?[a-zA-Z0-9-_]+=[a-zA-Z0-9-%]+&?)?$/; 
        if (url.match(regex)) 
        {
            $('').html('').show().css({'color' : 'green'});
        }else{
            catchError("Please Enter Valid URL.");
            $(websiteName).val("");
            return false;
        }
        
    }

   
    
    $('#customer_confirm_account_no, #customer_account_no').bind('copy paste cut',function(e) {
				  	e.preventDefault();
				});

    function internam_dedupe()
    {
        var lead_id = $('#lead_id').val();
        viewLeadsDetails(lead_id);
    }


    // viewOldHistory(lead_id);
    // ViewCibilStatement(lead_id);


































    function viewLeadsDetails(lead_id)
    {
        console.log(lead_id);
        $('#leadIdForDocs, #lead_id').val('');
        $('#leadIdForDocs, #lead_id').val(lead_id);
        $('#btndivCheckCibil, #btndivUploadDocs, #btndivReject, #divpersonalDetails, #divCamDetails, #btndivCamDetails, #formDisbursalOtherDetails').hide();
        $('#ViewPersonalDetails, #ViewCAMDetails, #ViewDisbursalBankDetails, #divUpdateReferenceNo').show();
        $("#exampleModalLongTitle, #modelTable, #oldTaskHistory, #viewCredit, #docsHistory").empty();
        $("#viewContactDetails").html('');
        // $('#btnCheckCibil').prop("disabled", true);
        
        var t = $("#urlViewCAM").attr("href", "<?= base_url('viewCAM/') ?>"+ lead_id +"/"+ csrf_token);
        console.log("<?= base_url('viewCAM/') ?>"+ lead_id +"/"+ csrf_token);
        $("#urlDownloadCAM").attr("href", "<?= base_url('downloadCAM/') ?>"+ lead_id);
        $("#agreementLetter").attr("href", "<?= base_url('viewAgreementLetter/') ?>"+ lead_id);
        $.ajax({
            url : '<?= base_url("getleadDetails/") ?>'+lead_id,
            type : 'POST',
            dataType : "json",
            // async : false,
            data : {csrf_token},
            beforeSend: function() {
                $('#viewLeadsDetailse').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').addClass('disabled', true);
            },
            success : function(response){ 
                // if(response['taskHistory'].term_and_condition == "true"){
                //     $('input.tnc1').attr('checked',"checked");
                //     $("input.tnc1").attr("disabled", "disabled"); 
                // }
                if(response['taskHistory'].terms_and_condition_2 == "true")
                {
                   // alert("hello check2");
                    $('input.tnc2').attr('checked',"checked");
                    $("input.tnc2").attr("disabled", "disabled");
                }
                //console.log("checkbox one value : "+ tnc1 +"Checkbox2 value : "+tnc2); debugger;
                var html = "";
                html += '<div class="table-responsive"><table class="table table-hover table-striped table-bordered">';
                html += '<tr><th colspan="2"></th><th class="thbg">Application No</th><td>-</td></tr>';
                html += '<tr><th>First Name</th><td>'+ response['leadDetails'].name +'</td><th>Middle Name</th><td>'+ ((response['leadDetails'].middle_name == '') ? '-':response['leadDetails'].middle_name) +'</td></tr>';
                html += '<tr><th>Surname</th><td>'+ ((response['leadDetails'].sur_name=='')?'-':response['leadDetails'].sur_name) +'</td><th>Gender</th><td>'+ ((response['leadDetails'].gender=='')?'-':response['leadDetails'].gender) +'</td></tr>';
                html += '<tr><th>DOB</th><td>'+ ((response['leadDetails'].dob=='')?'-':response['leadDetails'].dob) +'</td><th>PAN</th><td>'+ ((response['leadDetails'].pancard=='')?'-':response['leadDetails'].pancard) +'</td></tr>';
                html += '<tr><th>Mobile</th><td>'+ ((response['leadDetails'].mobile=='')?'-':response['leadDetails'].mobile) +'</td><th>Alternate Mobile</th><td>'+ ((response['leadDetails'].alternateMobileNo=='')?'-':response['leadDetails'].alternateMobileNo) +'</td></tr>';
                html += '<tr><th>Email (Personal)</th><td>'+ ((response['leadDetails'].email=='')?'-':response['leadDetails'].email) +'</td><th>Email (Office)</th><td>'+ ((response['leadDetails'].alternateEmailAddress=='')?'-':response['leadDetails'].alternateEmailAddress) +'</td></tr>';
                html += '<tr><th>Loan Applied</th><td>'+ ((response['leadDetails'].loan_amount=='')?'-':response['leadDetails'].loan_amount) +'</td><th>State</th><td>'+ ((response['leadDetails'].state=='')?'-':response['leadDetails'].state) +'</td></tr>';
                html += '<tr><th>City</th><td>'+ ((response['leadDetails'].city=='')?'-':response['leadDetails'].city) +'</td><th>Pincode</th><td>'+ ((response['leadDetails'].pincode=='')?'-':response['leadDetails'].pincode) +'</td></tr>';
                html += '<tr><th style="background: #ddd;">Post Office</th><td style="background: #ddd;">-</td><th>Initiated On</th><td>'+ response['leadDetails'].created_on +'</td></tr>';
                html += '<tr><th>Lead Source</th><td>'+ ((response['leadDetails'].source=='')?'-':response['leadDetails'].source) +'</td><th>Geo Coordinates</th><td>'+ ((response['leadDetails'].coordinates=='')?'-':response['leadDetails'].coordinates) +'</td></tr>';
                html += '<tr><th>IP Address</th><td>'+ ((response['leadDetails'].ip=='')?'-':response['leadDetails'].ip) +'</td><th style="background: #ddd;">Selfie Video</th><td style="background: #ddd;">-</td></tr>';
                html += '<tr><th colspan="4">I authorize Loanwalle to communicate via Phone / SMS / Whatsapp or other suitable channels with reference to my loan application overriding any subsisting registration for DNC / NDNC.<input type="checkbox" id="tnc1" name="t&c" class="lead-checkbox"></th></tr>';
                html += '<tr><th colspan="4">I authorize Loanwalle to disclose information / data submitted herein to any external agency, Govt. authorities, CKYC Registry etc. for the purpose of verification and appraisal of the loan.<input type="checkbox" id="tnc2" name="t&c" class="lead-checkbox"></th></tr>';
                
                $('#LeadDetails').html(html); 
                if(response['tbl_cibil'] === true){   
                    $('#btnCheckCibil').attr('disabled','disabled');
                } else {
                    $('#btnCheckCibil').removeAttr("disabled"); 
                } 

                if(response['leadStatus'].status == "New Leads" 
                    || response['leadStatus'].status == "IN PROCESS" 
                    || response['leadStatus'].status == "SEND BACK" 
                    || response['leadStatus'].status == "HOLD" ){
                    $('#btndivCheckCibil, #btndivUploadDocs, #btndivReject, #divpersonalDetails, #divCamDetails').show();
                    $('#ViewPersonalDetails, #ViewCAMDetails').hide();
                }

                if(response['leadStatus'].status == "RECOMMEND"){
                    $('#btndivCamDetails').show();
                }
                if(response['leadStatus'].status == "SANCTIONED"){
                    $('#formDisbursalOtherDetails').show();
                }
                if(response['leadStatus'].status == "DISBURSED"){
                    $('#divUpdateReferenceNo').hide();
                }

                $('#status').val(response['leadStatus'].status);

                <?php if($_SESSION['isUserSession']['role'] == "Sanction & Telecaller"){ ?>
                    
                    if(response['creditCount'] <= 0) {
                        $('#addCreditSection').show();
                    }
                    if(response['taskHistory'].loan_approved == 2) {
                        $('#addCreditSection').html('Credit History <i class="fa fa-angle-double-down" style="font-size:18px;color:#35b7c4"></i> <a class="btn" href="<?= base_url('EditCreditDetails/'); ?>'+response["taskHistory"].lead_id+'" style="color:#35b7c4; background:#efefef;" target="_blank">Edit Credit Details</a>');
                    }

                    if(response['taskHistory'].loan_approved == 3) {
                        $('.btnMarkDuplicate, #sendRequestToCustomerForUploadDocs, #btnUploadDocsByUser, .Reject_Loan, .RequestForApproveLoan').prop('disabled', true);
                    }

                    if(response['taskHistory'].is_Disbursed == 1) {
                        $('.Reject_Loan, .btnMarkDuplicate, #sendRequestToCustomerForUploadDocs, #btnUploadDocsByUser').prop('disabled', true);
                    }
                    if(response['taskHistory'].employeeDetailsAdded == 1) {
                        $('#formAddEmployeeDetails').css('display', 'none');
                    }
                <?php } ?>
                <?php if($_SESSION['isUserSession']['role'] == "Client Admin" || $url == "Collection" || $url == "search" || $url == "Account and MIS" || $url == "oldUserHistory" 
                        || $_SESSION['isUserSession']['role'] == "Client Admin") { ?>
                    $('#loanStatus').html(response['loanStatus']);
                <?php } ?>
                
                /////////////////////////// Receive collection amount //////////////////////////////
                var totalPayableAmount = $("#totalPayableAmount").text().replace(/,/g, "");
                var totalReceived = $("#totalReceived").text().replace(/,/g, "");
                var payableAmount = totalPayableAmount - totalReceived;
                $("#payment_amount").val(payableAmount);
                
            },
            complete: function() {
                $('#viewLeadsDetailse').html('<i class="fa fa-pencil-square-o">').addClass('disabled', false);
            },
        });
    }
    
    function getCustomerDocs()
    {
        var lead_id = $('#lead_id').val();
        getDocs(lead_id);
    }
    
    function getPersonalDetailsEdit()
    {     
        var lead_id = $('#lead_id').val();
        $.ajax({
            url : '<?= base_url("getleadDetails/") ?>'+lead_id,
            type : 'POST',
            dataType : "json",
            success : function(response){
                $('#yourMobileedit').val(response['taskHistory'].mobile);      
                $('#yourMobileedit').val(response['taskHistory'].mobile);
                $('#alternateMobileNoedit').val(response['taskHistory'].alternateMobileNo);
                $('#yourEmailedit').val(response['taskHistory'].email);
                $('#alternateEmailAddressedit').val(response['taskHistory'].alternateEmailAddress);
                $('#yourGenderedit').val(response['taskHistory'].gender);
                $('#yourPancardedit').val(response['taskHistory'].pancard);
                $('#addressLine1edit').val(response['taskHistory'].addressLine1);
                $('#areaedit').val(response['taskHistory'].area);
                $('#yourPincodeedit').val(response['taskHistory'].pincode);
                var dob = $('#yourDOBedit').val(response['taskHistory'].dob);
                //console.log(dob);  
                $('#landmarkedit').val(response['taskHistory'].landmark);
              }
        });
        ShowCustomerEmploymentDetails(lead_id);
    }
    
    function viewCAM()
    {
        var lead_id = $('#lead_id').val();
        getDocs(lead_id);
        if(lead_id != ""){
            $.ajax({
                url : '<?= base_url("getBankAnalysis/") ?>'+lead_id,
                type : 'POST',
                dataType : "json",
                success : function(response){
                    $('#ViewBankingAnalysis').html(response);
                    // ViewBankingAnalysis(this.title);
                }
            });
        } else {
            catchError("Lead Id Not Found.");
        }
    }
    
    function getCamDetails()
    {
        $('#viewCibil').html("");
        var lead_id = $('#lead_id').val();
        if(lead_id != ""){
            $.ajax({
                url : '<?= base_url("getBankAnalysis/") ?>'+lead_id,
                data : {csrf_token},
                type : 'POST',
                dataType : "json",
                success : function(response){
                    $('#ViewBankingAnalysis').html(response);
                    // ViewBankingAnalysis(this.title);
                }
            });
        } else {
            catchError("Lead Id Not Found.");
        }
    }
    
    function DuplicateLead() 
    {
        if (confirm("Are you sure, this lead is duplicate!")) {
            $('#formResonforDuplicateLeads').show();

            var prependFormDuplicateLead = '<div id="formResonforDuplicateLeads">'
            prependFormDuplicateLead += '<div class="row">';
            prependFormDuplicateLead += '<form id="formResonDuplicateLeads" method="post" enctype="multipart/form-data">';
            prependFormDuplicateLead += '<div class="col-md-10">';
            prependFormDuplicateLead += '<input type="text" class="form-control" name="reson" id="reson" placeholder="Give Reason" required>';
            prependFormDuplicateLead += '</div>';
            prependFormDuplicateLead += '</form>';
            prependFormDuplicateLead += '<div class="col-md-2">';
            prependFormDuplicateLead += '<button class="btn btn-primary" onclick="MarkDuplicate()">Mark Duplicate</button>';
            prependFormDuplicateLead += '</div>';
            prependFormDuplicateLead += '</div>';
            prependFormDuplicateLead += '</div>';
            $("#LeadDetails").before(prependFormDuplicateLead);
        }
    }

    function MarkDuplicate()
    {
        var lead_id = $("#lead_id").val();
        var reson = $("#reson").val();

        if(reson == ""){
            $('#reson').focus();
            $(".err").show().fadeOut(2000);
            $(".err a").html("Please select reson and mark leads duplicate.");
            return false;
        }else{
            $.ajax({
                url : '<?= base_url("resonForDuplicateLeads") ?>',
                type : 'POST',
                data:{lead_id : lead_id, reson : reson},
                success : function(response) {
                    if(response == "true"){
                        $(".msg").show().fadeOut(2000);
                        $(".msg a").html("Lead marked duplicate.");
                        $('#reson').empty();
                        $('#formResonforDuplicateLeads').html('');
                        window.location.reload();
                    }
                }
            });
        }
    }

    function viewCreditHistory(lead_id)
    {
        $.ajax({
            url : '<?= base_url("get_credit/") ?>'+lead_id,
            type : 'POST',
            dataType : "json",
            success : function(response){
                $('#viewCredit').empty();
                $('#viewCredit').html(response);
            }
        });

    }
    
    function sanctionLetter()
    {
        var lead_id = $("#lead_id").val();
        //alert(lead_id);
        if(lead_id != ""){ 
            $.ajax({
                url : '<?= base_url("sanctionLetter/") ?>'+lead_id, 
                type : 'POST', 
                async:false,
                success : function(response) { 
                    if(response == "true"){
                        $(".msg").show().fadeOut(2000);
                        $(".msg a").html("Sanction letter Sent Successfully.");
                        $('#reson').empty();
                        $('#formResonforDuplicateLeads').html('');
                        window.location.reload();
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#exampleModalLongTitle").html(textStatus +" : "+ errorThrown);
                    return false;
                }
            });
        }
    }
    
    function holdSanction() 
    {
        if (confirm("Are you sure, this lead want to Hold!")) { 
            var prependFormDuplicateLead = '<div id="formResonforDuplicateLeads">'
            prependFormDuplicateLead += '<div class="row">';
            prependFormDuplicateLead += '<form id="formResonRejectLoan" method="post" enctype="multipart/form-data">';
            prependFormDuplicateLead += '<div class="col-md-9">';
            prependFormDuplicateLead += '<input type="text" style="margin-bottom:10px; margin-left:20px" class="form-control" name="remarkHold" id="remarkHold" placeholder="Please Enter Remark" required>';
            prependFormDuplicateLead += '</div>';
            prependFormDuplicateLead += '</form>';
            prependFormDuplicateLead += '<div class="col-md-3">'; 
            prependFormDuplicateLead += '<button class="btn btn-primary" id="hold" onclick="followUp()" style="text-align: center; margin-bottom:10px; padding-left: 50px; padding-right: 50px; font-weight: bold;">Hold</button>';
            prependFormDuplicateLead += '</div>';
            prependFormDuplicateLead += '</div>';
            prependFormDuplicateLead += '</div>';
            $("#ResonBoxForHold").html(prependFormDuplicateLead);
        }
    }
    
    function followUp()
    {
        var lead_id = $("#lead_id").val();
        var reson = $("#remarkHold").val();

        if(reson == ""){
            $('#remarkHold').focus();
            $(".err").show().fadeOut(2000);
            $(".err a").html("Please Fill reson.");
            return false;
        }else{
            $.ajax({
                url : '<?= base_url("followUp") ?>',
                type : 'POST',
                data:{lead_id : lead_id, reson : reson},
                async:false,
                success : function(response){
                    if(response == "true"){
                        $(".msg").show().fadeOut(2000);
                        $(".msg a").html("Lead On Hold Successfully.");
                        $('#reson').empty();
                        $('#formResonforDuplicateLeads').html('');
                        window.location.reload();
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#exampleModalLongTitle").html(textStatus +" : "+ errorThrown);
                    return false;
                }
            });
        }
    }

    function ShowCustomerEmploymentDetails(lead_id)
    {
        $.ajax({
            url : '<?= base_url("ShowCustomerEmploymentDetails/") ?>'+lead_id,
            type : 'POST',
            dataType : "json",
            async: false,
            success : function(response){
                $('#ShowCustomerEmploymentDetails').html(response);
            },
        });   
    }
    
    function progressBar(progress)
    {
        $('#progressBar').html('');
        $('#progressBar').html('<div class="progress md-progress" style="height: 20px;"><div class="progress-bar" role="progressbar" style="width: '+progress+'%; height: 20px" aria-valuenow="'+progress+'" aria-valuemin="0" aria-valuemax="100">Completed '+progress+'%</div></div>');
    }

    function reCreditLoan()
    {
        var lead_id = $("#lead_id").val();

        $.ajax({
            url : '<?= base_url("reCreditLoan") ?>',
            type : 'POST',
            data:{lead_id : lead_id},
            success : function(response) {
                if(response == "true"){
                    $(".msg").show().fadeOut(2000);
                    $(".msg a").html("Loan Approved Successfully.");
                    window.location.reload();
                }
            }
        });
    }

    function ApproveSenctionLoan()
    {
        var lead_id = $("#lead_id").val();
        $.ajax({
            url : '<?= base_url("ApproveSenctionLoan") ?>',
            type : 'POST',
            data : {lead_id : lead_id},
            success : function(response) {
                if(response == "true"){
                    $(".msg").show().fadeOut(2000);
                    $(".msg a").html("Loan Approved Successfully.");
                    <?php if($_SESSION['isUserSession']['role'] != "Client Admin"){ ?>
                    window.location.reload();
                    <?php } ?>
                }
            }
        });
    }
    
    
    
    
    
    
    
    
    
    
    
    
    //////////////////////////////////////////////////////////////////////////// Cibil Details ////////////////////////////////////////////////////////////////////////////////////////
    
    function getCibilDetails() 
    {
        var lead_id = $('#lead_id').val();
        if(lead_id != "") {
            viewCreditHistory(lead_id);
            $.ajax({
                url : '<?= base_url("CreditController/getCustomerLeadDetails/") ?>'+lead_id,
                type : 'POST',
                dataType : "json",
                success : function(response){
                    $('#addCreditSection').html(response);
                }
            });
        } else {
            catchError("Lead Id Not Found.");
        }
    } 
    $('#btnUploadDocsByUser').click(function()
    {
        $('#formUploadDocs').show();
        $("#btnSaveDocs").html("Save Docs");
        $('#docs_id, #docsType').val('');
    });

    //////////////////////////////////////////////////////////////////////////// CAM Banking Analysis ///////////////////////////////////////////////////////////////////////////////////

    $(document).ready(function(){
        $('#formCheckBankAnalysis').submit(function(e) {
            var lead_id = $('#leadIdForDocs').val();
            e.preventDefault();
            $.ajax({
                url : '<?= base_url("saveBankAnalysis") ?>',
                type : 'POST',
                data:new FormData(this),
                // dataType: 'json',
                processData:false,
                contentType:false,
                cache:false,
                // async:false,
                beforeSend: function() {
                    $('#btnBankAnalysisi').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Processing...').addClass('disabled', true);
                },
                success : function(response) {
                    if(response.err) {
                        catchError(response.err);
                    } else {
                        $("#formCheckBankAnalysis")[0].reset();
                        catchSuccess(response.msg);
                        getCamDetails();
                    }
                },
                complete: function() {
                    $('#btnBankAnalysisi').html('Bank Analysis').removeClass('disabled'); 
                },
            });
        });
    });
    
    function ViewBankingAnalysis(doc_id)
    {
        var json_data;
            $.ajax({
            url : '<?= base_url("ViewBankingAnalysis") ?>',
            type : 'POST',
            dataType : "json",
            data : {doc_id : doc_id},
            success : function(response){
                $('#viewCibil').html(response);
            }
        });
    }
    
    
    
    
    
    
    
    
    
    
    /////////////////////////////////////////////////////////////////////////// Collection details /////////////////////////////////////////////////////////////////////////////////
    
    function collectionDetails()
    {
        var lead_id = $('#lead_id').val();
        getRecoveryData(lead_id);
    }

    function getRecoveryData(lead_id)
    {
        // $('#recoveryData').empty();
        $.ajax({
            url : '<?= base_url("getRecoveryData/") ?>' +lead_id,
            type : 'POST',
            dataType : "json",
            // async: false,
            success : function(response) {
                $('#recoveryData').html(response);
            }
        });
    }

















//////////////////////////////////////////////////////////////////////////////// verify customer payment ///////////////////////////////////////////////////////////////////////////////////
    
    function VerifyCoustomerPayment(recovery_id, payment_amount, refrence_no)
    {
        $('#recovery_id').val(recovery_id);
        $('#payment_amount').val(payment_amount);
        $('#refrence_no').val(refrence_no);
        if(recovery_id != "" && payment_amount != "" && refrence_no != ""){
            $.ajax({
                url : '<?= base_url("getPaymentVerification/") ?>'+refrence_no,
                type : 'POST',
                dataType : "json",
                success : function(response){
                    $('#payment_mode, #payment_type, #discount, #remark').val('');
                    $('#payment_mode').val(response.payment_mode);
                    $('#payment_type').val(response.status);
                    $('#discount').val(response.discount);
                    $('#remark').val(response.remarks);
                }
            });
        } else {
            catchError("Recovery Id, Payment Amount and Refrence Missing.");
        }
    }

    $('#FormVerifyPayment').submit(function(e){
        var FormData = $(this).serialize();
        e.preventDefault();
        $.ajax({
            url : '<?= base_url("verifyCustomerPayment") ?>',
            type : 'POST',
            data : FormData,
            dataType : "json",
            // async : false,
            beforeSend: function() {
                $('#btnPaymentVerify').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Processing...').addClass('disabled', true);
            },
            success : function(response) {
                if(response.err) {
                    catchError(response.err);
                } else {
                    $('#btnPaymentVerify').prop('disabled', true);
                    catchSuccess(response.msg);
                    window.location.reload();
                }
            },
            complete: function() {
                $('#btnPaymentVerify').html('VERIFY PAYMENT').removeClass('disabled'); 
            },
        });
    });
    
    
	
    
    ////////////////////////Get bank Details For Update Disbursal////////////////////////
    
    $(document).ready(function(){
        
        $('#customer_ifsc_code').select2({
            placeholder: 'Select IFSC Code',
            minimumInputlength: 2,
            allowClear: true,
                ajax: {
                url: '<?= base_url('getCustomerBankDetails') ?>',
                data : {csrf_token},
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        searchTerm: data.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: $.map(response, function (item) {
                            return {
                                id: item.bank_ifsc,
                                text: item.bank_ifsc,
                            }
                        })
                    };
                },
                cache: true
            }
        });
            

        $("#customer_ifsc_code").change(function(){
            var ifsc_code = $(this).val();
            $.ajax({
                url : '<?= base_url("getBankNameByIfscCode") ?>',
                type : 'POST',
                data : {ifsc_code : ifsc_code, csrf_token},
                dataType : "json",
                success : function(response){
                    $('#bank_name').val(response.bank_name);
                    $('#bank_branch').val(response.bank_branch);
                }
            });
        });
    });
    
    function customer_confirm_acc_no(acc_no2)
    {
        var acc1 = $("#customer_account_no").val();
        var acc2 = $(acc_no2).val();

        if(acc1 === acc2){
            $("#customer_account_no, #customer_confirm_account_no").css('border-color', '#aaa');
            return true;
        }else{
            $("#customer_account_no, #customer_confirm_account_no").val('').css('border-color', 'red');
            $("#customer_account_no").focus();
            
            catchError('Invalid A/C no.');
        }
    }
    
    $(document).ready(function(){
        $('#disbursalApprove').on('click', function(){
            var formData = $('#FormDisbursal').serialize();
            $.ajax({
                url : '<?= base_url("saveDisbursalData") ?>',
                type : 'POST',
                data : formData,
                dataType : "json",
                // async: false,
                success: function(response) {
                    if(response.err) {
                        catchError(response.err);
                    }else{
                        catchSuccess(response.msg);
                        $('#customer_bank_name, #customer_account_no, #customer_confirm_account_no, #customer_name, #account_type').attr("readonly", "true");
                        $('#customer_ifsc_code, #disbursalApprove').addClass("disabled", true);
                        disbursalDetails();
                    }
                }
            });
        });
    
        $('#updateDisbursalApprove').click(function(){
            var formData = $('#disbursalPayableDetails').serialize();
            $.ajax({
                url : '<?= base_url("updateDisbursalData") ?>',
                type : 'POST',
                data : formData,
                dataType : "json",
                beforeSend: function() {
                    $('#updateDisbursalApprove').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
                },
                success : function(response){
                    if(response.msg){
                        catchSuccess(response.msg);
                        disbursalDetails();
                        // window.location.reload();
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#updateDisbursalApprove').html('Disburse').prop('disabled', false);
                }
            });
        });
    });  
        // $("#updatePaymentReference, #updatePaymentReference").AddClass("disabled");
        
    function UpdateDisburseReferenceNo()
    {
        var formData = $('#FormPaymentReference').serialize();
        $.ajax({
            url : '<?= base_url("UpdateDisburseReferenceNo") ?>',
            type : 'POST',
            data : formData,
            dataType : "json",
            // async: false,
            success: function(response) {
                if(response.err){
                    catchError(response.err);
                }else{
                    catchSuccess("Reference No updated successfully!");
                    $('#updatePaymentReference, #updatePaymentReference').prop("disabled", true);
                    window.location.reload();
                }
            }
        });
    }

    function PayAmountToCustomer()
    {
        var lead_id = $("#lead_id").val();
        if (confirm('Are you sure to pay.')) {
            $.ajax({
                url : '<?= base_url("PayAmountToCustomer/") ?>'+lead_id,
                type : 'POST',
                dataType : "json",
                // async: false,
                beforeSend: function() {
                    $('#PayAmountToCustomer').html('<span class="spinner-border spinner-border-sm" role="status"></span>Processing...').addClass('disabled');
                },
                success: function(response) {
                    catchSuccess(response);
                    $("#PayAmountToCustomer").addClass("disabled", true);
                    // $("#updatePaymentReference, #updatePaymentReference").removeClass("disabled");
                    // window.location.reload();
                    disbursalDetails();
                },
                complete: function() {
                    $('#PayAmountToCustomer').html('Pay To Customer').removeClass('disabled');
                }
            });
        }
    }
    
    function getBankDetails()
    {
        var lead_id = $('#lead_id').val();
        $.ajax({
            url : '<?= base_url("getBankDetails/") ?>'+lead_id,
            type : 'POST',
            dataType : "json",
            success : function(response){
                $('#customer_ifsc_code_edit').val(response['loanDetails'].customer_bank_ifsc);      
                $('#customer_bank_name_edit').val(response['loanDetails'].customer_bank);
                $('#customer_account_no_edit').val(response['loanDetails'].customer_account_no);
                $('#customer_confirm_account_no_edit').val(response['loanDetails'].customer_account_no);
                $('#customer_name_edit').val(response['loanDetails'].customer_name);
                $('#account_type_edit').val(response['loanDetails'].loan_account_type);
            }
        });
    }
    
    function disbursalLetterAgreeAndConfirm(lead_id) 
    {
        if (confirm("Are you sure, this lead is duplicate!")) {
            var responsemsg = 1;
            $.ajax({
                url : '<?= base_url("loan-Agreement-Letter-Response") ?>',
                type : 'POST',
                dataType : "json",
                data : {lead_id : lead_id, response : responsemsg},
                success : function(response){
                    alert("Your Response sended Successfully.");
                }
            });
        }else{
            var responsemsg = 0;
            $.ajax({
                url : '<?= base_url("loan-Agreement-Letter-Response") ?>',
                type : 'POST',
                dataType : "json",
                data : {lead_id : lead_id, response : responsemsg},
                success : function(response){
                    alert("Your Response sended Successfully.");
                }
            });
        }
    }
</script>

    <script>
      function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 8,
          center: { lat: 40.731, lng: -73.997 },
        });
        const geocoder = new google.maps.Geocoder();
        const infowindow = new google.maps.InfoWindow();
        document.getElementById("submit").addEventListener("click", () => {
          geocodeLatLng(geocoder, map, infowindow);
        });
      }

      function geocodeLatLng(geocoder, map, infowindow) {
        const input = document.getElementById("latlng").value;
        const latlngStr = input.split(",", 2);
        const latlng = {
          lat: parseFloat(latlngStr[0]),
          lng: parseFloat(latlngStr[1]),
        };
        geocoder.geocode({ location: latlng }, (results, status) => {
          if (status === "OK") {
            if (results[0]) {
              map.setZoom(11);
              const marker = new google.maps.Marker({
                position: latlng,
                map: map,
              });
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
            } else {
              window.alert("No results found");
            }
          } else {
            window.alert("Geocoder failed due to: " + status);
          }
        });
      }
    </script>

<div id="bankdetails" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="margin-top :100px; margin-left: 100px; background: #fff;">
        <div class="modal-content" id="viewCustomerData" style="height :600px; overflow: auto; margin-top : 80px;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">...</h5><hr>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="footer-support">
                    <h2 class="footer-support">Bank Details &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                </div>
                              
                <table class="table table-striped" id="records_table">
                  <thead>
                    <tr>
                      <th scope="col">Narration</th>
                      <th scope="col">EMI Amount</th>
                      <th scope="col">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
                <div id="Cam_Sheet"></div>
           </div>
        </div>
    </div>
</div>

<div id="viewCibilModel" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true" style="width= : 100%; height : auto;">
    <div class="modal-dialog modal-lg" role="document" style="margin-top :100px; margin-left: 100px; background: #fff;">
        <div class="modal-content" id="viewCustomerData" style="height :600px; overflow: auto;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">...</h5><hr>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="viewCibil"></div>
           </div>
        </div>
    </div>
</div>
 -->