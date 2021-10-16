<?php $url = $this->uri->segment(1); ?>

<style>
    #map {
        height: 100%;
      }

      /* Optional: Makes the sample page fill the window. */
      
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: "Roboto", "sans-serif";
        line-height: 30px;
        padding-left: 10px;
      }

      #floating-panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        width: 350px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }

      #latlng {
        width: 225px;
      }
</style>
<div id="myModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="margin-top : 4%; background: #fff;">
        <div class="modal-content page-height"  style="height:700px; overflow:auto;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">...</h5><hr>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="progressBar"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="tab" role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist">
                                <?php //$uriString = $this->uri->uri_string();   ?>
                                    
                                <li role="presentation" class="borderList "><a href="#LeadSaction" onclick="getLeadDetails()" aria-controls="lead" role="tab" data-toggle="tab">Lead</a></li>
                                
                                <li role="presentation" class="borderList"><a href="#DocumentSaction" onclick="getCustomerDocs()" aria-controls="Document" role="tab" data-toggle="tab">Documents</a></li>
                                
                                <li role="presentation" class="borderList"><a href="#Verification" aria-controls="Verification" role="tab" data-toggle="tab" style="background:gray">Verification</a></li>

                                <li role="presentation" class="borderList"><a href="#PersonalDetailSaction" onclick="getPersonalDetails()" aria-controls="Personal" role="tab" data-toggle="tab">Personal</a></li>
                                
                                <li role="presentation" class="borderList <?= $class ?>"><a href="#CAMSheetSaction" onclick="getCam()" aria-controls="messages" role="tab" data-toggle="tab">CAM</a></li>

                                <li role="presentation" class="borderList"><a href="#DisbursalSaction" onclick="disbursalDetails()" aria-controls="messages" role="tab" data-toggle="tab">Disbursal</a></li>
                                
                                <li role="presentation" class="borderList"><a href="#collection" onclick="getCollection()" aria-controls="messages" role="tab" data-toggle="tab" style="background:gray">Collection</a></li>
                                
                                <?php if($_SESSION['isUserSession']['role'] == "Account and MIS" || $url == "oldUserHistory" || $url == "search"){ ?>
                                <li role="presentation" class="borderList"><a href="#CollectionSaction" onclick="collectionDetails()" aria-controls="messages" role="tab" data-toggle="tab">Collection</a></li>
                                <?php } ?>
                            </ul><hr>

                            <div class="tab-content tabs">
                                <div role="tabpanel" class="tab-pane fade in active" id="LeadSaction">
                                    <div id="formDuplicate"></div>
                                    <div id="LeadDetails"></div>
                                    
                                    <div class="footer-support">
                                        <h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#old_leads">INTERNAL DEDUPE&nbsp;<i class="fa fa-angle-double-down"></i></button></h2>
                                    </div>
                                    <div id="old_leads" class="collapse"> 
                                        <div id="oldTaskHistory"></div>
                                    </div>
                                    
                                    <div class="footer-support">
                                        <h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#cibil_details">CREDIT BUREAU&nbsp;<i class="fa fa-angle-double-down"></i></button></h2>
                                    </div>
                                    <div id="bankStatement"></div>
                                    
                                    <div id="cibil_details" class="collapse">
                                        <?php if($user->permission_user_credit == 1) : ?>
                                        <div id="btndivCheckCibil">
                                            <div id="checkCustomerCibil" style="background:#fff !important;">
                                                <a href="#" class="btn btn-primary" id="btnCheckCibil" onclick="checkCustomerCibil()">Check CIBIL</a>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <div id="cibilStatement"></div>
                                    </div>
                                    <?php if($user->permission_user_credit == 1) : ?>
                                    <div id="btndivReject">
                                        <div calss="row" style="border-top: solid 1px #ddd;text-align: center; padding-top : 20px; padding-bottom: 20px; background: #f3f3f3; overflow: auto;">
                                            <div class="col-md-6 text-center">
                                                <select class="form-control inputField" name="resonForReject" id="resonForReject" autocomplete="off" style="float: right;height: 43px !important;">
                                                    <option value="">Select</option>
                                                    <option value="TEST LEAD">TEST LEAD</option>
                                                    <option value="OUT OF RANGE LEAD">OUT OF RANGE LEAD</option>
                                                    <option value="NOT CONTACTABLE">NOT CONTACTABLE</option>
                                                    <option value="NOT INTERESTED - HIGH ROI/FEES">NOT INTERESTED - HIGH ROI/FEES</option>
                                                    <option value="NOT INTERESTED - NOT RESPONDING">NOT INTERESTED - NOT RESPONDING</option>
                                                    <option value="NOT INTERESTED - HIGH AMOUNT REQD">NOT INTERESTED - HIGH AMOUNT REQD</option>
                                                    <option value="NOT ELIGIBLE - RECENT 30+ DPD IN PL">NOT ELIGIBLE - RECENT 30+ DPD IN PL</option>
                                                    <option value="NOT ELIGIBLE - RECENT 60+ DPD IN CC">NOT ELIGIBLE - RECENT 60+ DPD IN CC</option>
                                                    <option value="NOT ELIGIBLE - LOW CIBIL">NOT ELIGIBLE - LOW CIBIL</option>
                                                    <option value="DEROGATORY RTR WITH NMFL">DEROGATORY RTR WITH NMFL</option>
                                                    <option value="RUNNING NMFL CUSTOMER">RUNNING NMFL CUSTOMER</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 text-left">
                                                <button class="btn btn-success reject-button" onclick="ResonForRejectLoan()">Reject</button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div role="tabpanel" class="tab-pane fade" id="DocumentSaction">
                                    <!--div class="footer-support">
                                        <h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#documents">Documents &nbsp;<i class="fa fa-angle-double-down"></i></button>
                                        </h2>
                                    </div-->
                                    <input type="hidden" name="leadIdForDocs" id="leadIdForDocs">
                                   
                                    <div id="documents" class="show">
                                        <?php if($user->permission_user_credit == 1) : ?>
                                        <div id="btndivUploadDocs">
                                            <div style="background:#fff !important;">
                                                <button class="btn btn-primary" style="background:#ddd !important; color: #000 !important; border: none;" id="sendRequestToCustomerForUploadDocs" onclick="sendRequestToCustomerForUploadDocs()" disabled>Send Request For Upload Docs</button>
                                                <!--button class="btn btn-primary" id="btnUploadDocsByUser">Upload Docs</button-->
                                            </div> 
                                            <div id="formUploadDocs" class="white-back-cust" style="display:block">
                                                <div class="row">
                                                    <form id="formUserDocsData1" method="post" enctype="multipart/form-data">
                                                        <div class="footer-support">
                                                            <h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#old_leads">KYC Address Proof&nbsp;<i class="fa fa-angle-double-down"></i></button></h2>
                                                        </div>
                                                        <input type="hidden" class="form-control" name="kyc" id="kyc" value="KYC">
                                                        <input type="hidden" class="form-control" name="lead_id" id="lead_id">
                                                        <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['isUserSession']['user_id'] ?>">
                                                        <input type="hidden" name="company_id" id="company_id" value="<?= $_SESSION['isUserSession']['company_id'] ?>">
                                                        <div id="getDocId"></div>
                                                        <div class="col-md-3" id="selectDocType">
                                                            <select class="form-control" name="docsType" id="docsType" required>
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
                                                        <div class="col-md-4" id="selectFileType">
                                                            <input type="file" class="form-control" name="kycfile" id="kycfile" accept="image/*,.jpeg, .png, .jpg,.pdf" required>
                                                        </div>
                                                        <!--<span id="bankPassword"></span>-->
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                                                        </div>
                                                        <div class="col-md-2" id="btnDocsSave">
                                                           <button class="btn btn-primary" id="btnSaveDocs">Save</button>
                                                        </div></br></br>
                                                    </form>
                                                        
                                                    <form id="formUserDocsData2" method="post" enctype="multipart/form-data">
                                                        <div class="footer-support">
                                                            <h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#old_leads">Identity Proof&nbsp;<i class="fa fa-angle-double-down"></i></button></h2>
                                                        </div>
                                                        <input type="hidden" class="form-control" name="lead_id" id="lead_id">
                                                        <input type="hidden" class="form-control" name="identity" id="identity" value="IDENTITY">
                                                        <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['isUserSession']['user_id'] ?>">
                                                        <input type="hidden" name="company_id" id="company_id" value="<?= $_SESSION['isUserSession']['company_id'] ?>">
                                                        <div id="getDocId"></div>
                                                        <div class="col-md-3" id="selectDocType">
                                                            <select class="form-control" name="docsType" id="docsType" required>
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
                                                        <div class="col-md-4" id="selectFileType">
                                                            <input type="file" class="form-control" name="identityfile" id="identityfile" accept="image/*,.jpeg, .png, .jpg,.pdf" required>
                                                        </div>
                                                        <!--<span id="bankPassword"></span>-->
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                                                        </div>
                                                        <div class="col-md-2" id="btnDocsSave">
                                                           <button class="btn btn-primary" id="btnSaveDocs">Save</button>
                                                        </div></br></br>
                                                    </form>    
                                                        
                                                    <form id="formUserDocsData3" method="post" enctype="multipart/form-data">
                                                        <div class="footer-support">
                                                            <h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#old_leads">Income Proof&nbsp;<i class="fa fa-angle-double-down"></i></button></h2>
                                                        </div>
                                                        <input type="hidden" class="form-control" name="lead_id" id="lead_id">
                                                        <input type="hidden" class="form-control" name="income" id="income" value="INCOME">
                                                        <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['isUserSession']['user_id'] ?>">
                                                        <input type="hidden" name="company_id" id="company_id" value="<?= $_SESSION['isUserSession']['company_id'] ?>">
                                                        <div id="getDocId"></div>
                                                        <div class="col-md-3" id="selectDocType">
                                                            <select class="form-control" name="docsType" id="docsType" required>
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
                                                        <div class="col-md-4" id="selectFileType">
                                                            <input type="file" class="form-control" name="incomefile" id="incomefile" accept="image/*,.jpeg, .png, .jpg,.pdf" required>
                                                        </div>
                                                        <!--<span id="bankPassword"></span>-->
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                                                        </div>
                                                        <div class="col-md-2" id="btnDocsSave">
                                                           <button class="btn btn-primary" id="btnSaveDocs">Save</button>
                                                        </div></br></br>
                                                    </form>    
                                                        
                                                        
                                                    <form id="formUserDocsData4" method="post" enctype="multipart/form-data">
                                                        <div class="footer-support">
                                                            <h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#old_leads">Other Address Proof&nbsp;<i class="fa fa-angle-double-down"></i></button></h2>
                                                        </div>
                                                        <input type="hidden" class="form-control" name="lead_id" id="lead_id">
                                                        <input type="hidden" class="form-control" name="other" id="other" value="OTHER">
                                                        <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['isUserSession']['user_id'] ?>">
                                                        <input type="hidden" name="company_id" id="company_id" value="<?= $_SESSION['isUserSession']['company_id'] ?>">
                                                        <div id="getDocId"></div>
                                                        <div class="col-md-3" id="selectDocType">
                                                            <select class="form-control" name="docsType" id="docsType" required>
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
                                                        <div class="col-md-4" id="selectFileType">
                                                            <input type="file" class="form-control" name="otherfile" id="otherfile" accept="image/*,.jpeg, .png, .jpg,.pdf" required>
                                                        </div>
                                                        <!--<span id="bankPassword"></span>-->
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                                                        </div>
                                                        <div class="col-md-2" id="btnDocsSave">
                                                           <button class="btn btn-primary" id="btnSaveDocs">Save</button>
                                                        </div></br></br>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="footer-support">
                                            <h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#old_leads">Uploaded Documents&nbsp;<i class="fa fa-angle-double-down"></i></button></h2>
                                        </div>
                                        <?php endif; ?>
                                        <div id="docsHistory"></div>
                                    </div>
                                </div>
                                
                                <div role="tabpanel" class="tab-pane fade" id="PersonalDetailSaction">
                                    <div style="border : solid 1px #ddd;margin-bottom: 20px;">
                                        <?php if($user->permission_user_credit == 1) : ?>
                                        <div id="divpersonalDetails">
                                            <form id="FormSaveCustomerRecord" class="form-inline" method="post" autocomplete="off">
                                                
                                                <div class="form-group" style="margin-top:30px">
                                                    <input type="hidden" name="leadID" id="leadID">
                                                    <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['isUserSession']['user_id'] ?>">
                                                    <input type="hidden" name="company_id" id="company_id" value="<?= $_SESSION['isUserSession']['company_id'] ?>">
                        
                                                    <div class="col-md-6" >
                                                        <label class="labelField">First Name&nbsp;<strong class="required_Fields">*</strong></label>
                                                        <input class="form-control inputField" id="borrower_name" name="borrower_name" type="text" autocomplete="off">
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <label class="labelField">Middle Name&nbsp;<strong class="required_Fields">*</strong></label>
                                                        <input class="form-control inputField" id="borrower_mname" name="borrower_mname" type="text" autocomplete="off">
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <label class="labelField">Last Name&nbsp;<strong class="required_Fields">*</strong></label>
                                                        <input class="form-control inputField" id="borrower_lname" name="borrower_lname" type="text" autocomplete="off">
                                                    </div>
                                                    
                                                     <div class="col-md-6">
                                                        <label class="labelField">Gender&nbsp;<strong class="required_Fields">*</strong></label>
                                                        <input type="text" class="form-control inputField" id="gender" name="gender" autocomplete="off">
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
                                                        <label class="labelField">Email Id&nbsp;<strong class="required_Fields">*</strong></label>
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
                                                        <label class="labelField">Initiated On&nbsp;<strong class="required_Fields">*</strong></label>
                                                        <input type="text" class="form-control inputField" id="lead_initiated_date" name="lead_initiated_date" autocomplete="off" readonly>
                                                    </div>
                                                    
                                                    <div class="col-md-6" style="background: #ddd; margin-bottom: 10px;">
                                                        <label class="labelField">Post Office</label>
                                                        <input type="text" class="form-control inputField" id="post_office" name="post_office" autocomplete="off" readonly style="    margin-bottom: 5px !important; margin-top: 5px;">
                                                    </div>

                                                    
                                                    <div class="col-md-6">
                                                        <label class="labelField">Alternate Email Id</label>
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
                                                        <select class="form-control inputField" name="residential_proof" id="residential_proof" autocomplete="off"> 
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
                                                            <option value="">Select</option><option value="Salary Slip 2">Salary Slip 2</option><option value="PAN">PAN</option>
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
                                    <a class="btn btn-primary" href="<?= base_url('viewCAM/1') ?>" target="_blank" title="View" style="width: 30px;height: 30px;padding: 5px 0px 0px 0px;"><fa class="fa fa-eye"></i></a>
                                    <a class="btn btn-primary" href="<?= base_url('downloadCAM/1') ?>" download target="_blank" title="Download" style="width: 30px;height: 30px;padding: 5px 0px 0px 0px;"><fa class="fa fa-download"></i></a>
                                        
                                    <div class="camBorder">
                                        <?php if($user->permission_user_credit == 1) : ?>
                                        <div id="divCamDetails">
                                            <form id="FormSaveCAM" class="form-inline" method="post" autocomplete="off">
                                                <p>&nbsp</p>
                                                <input type="hidden" name="leadID" class="leadID">
                                                <input type="hidden" name="user_id" value="<?= $_SESSION['isUserSession']['user_id'] ?>">
                                                <input type="hidden" name="company_id" value="<?= $_SESSION['isUserSession']['company_id'] ?>">
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
                                                        <label class="labelField">Repayment Date&nbsp;<strong class="required_Fields">*</strong></label>
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
                                                        <label class="labelField">Repayment Amount (Rs.)</label>
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
                        
                                                    <!--div class="col-sm-6" style="padding: 15px;margin-bottom: 10px;">
                                                        <p>Change in ROI : <input type="text" name="changeROI" id="changeROI" value="NO" readonly style="width: 35px;"></p>
                                                        <p>Change in Fees : <input type="text" name="changeFee" id="changeFee" value="NO" readonly style="width: 35px;"></p>
                                                        <p>Higher Loan amount : <input type="text" name="changeLoanAmount" id="changeLoanAmount" value="NO" readonly style="width: 35px;"></p>
                                                        <p>Tenor more than norms : <input type="text" name="changeTenure" id="changeTenure" value="NO" readonly style="width: 35px;"></p>
                                                        <p>Poor RTR with CC : <input type="text" name="changeRTR" id="changeRTR" value="NO" readonly style="width: 35px;"></p>
                                                    </div-->
                        
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
                                            
                                            <div calss="row" style="border-top: solid 1px #ddd;text-align: center; padding-top : 20px; padding-bottom: 20px; background: #f3f3f3;">
                                                <div calss="col-md-12 text-center">
                                                    <button class="btn btn-primary" id="btnFormSaveCAM" style="text-align: center; padding-left: 50px; padding-right: 50px; font-weight: bold;">Save</button>
                                                    <button class="btn btn-success" id="LeadRecommend" style="background: #7cb342 !important; text-align: center; padding-left: 25px; padding-right: 25px; font-weight: bold;">Recomend</button>
                                                    <button class="btn btn-success" id="hold"  onClick="holdSanction()" style="background: #ab2e09 !important; text-align: center; padding-left: 50px; padding-right: 50px; font-weight: bold;">Hold</button>
                                                </div>  
                                            </div>
                                            <span id="ResonBoxForHold"></span>
                                        </div>
                                        <?php endif; ?>
                                        <div id="ViewCAMDetails"></div>

                                        <?php if($user->permission_approve_credit == 1) : ?>
                                        <div id="btndivCamDetails">
                                            <div calss="row" style="border-top: solid 1px #ddd;text-align: center; padding-top : 20px; padding-bottom: 20px; background: #f3f3f3;">
                                                <div calss="col-md-12 text-center">
                                                    <button class="btn btn-primary" id="btnSendBack" style="text-align: center; padding-left: 25px; padding-right: 25px; font-weight: bold;">Send Back</button>
                                                    <button class="btn btn-success" id="btnCAM_Approve" style="background: #7cb342 !important; text-align: center; padding-left: 25px; padding-right: 25px; font-weight: bold;">Sanction</button>
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
                                        <?php if($user->permission_user_disburse == 1): ?>
                                            <div id="formDisbursalOtherDetails">
                                                <div class="col-md-12" style="padding: 0px 0px; border-bottom:1px solid #ddd; margin-bottom : 15px;">
                                                    <p class="headingForm">Disbursal Bank</p>
                                                </div>
                                                <div class="form-group">
                                                    <form id="disbursalPayableDetails" class="form-inline" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" class="form-control" name="lead_id" id="lead_id" readonly>
                                                        <input type="hidden" class="form-control" name="company_id" id="company_id" value="<?= $_SESSION['isUserSession']['company_id'] ?>" readonly>
                                                        <input type="hidden" class="form-control" name="user_id" id="user_id" value="<?= $_SESSION['isUserSession']['user_id'] ?>" readonly>
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
                                                        <input type="hidden" class="form-control" name="company_id" id="company_id" value="<?= $_SESSION['isUserSession']['company_id'] ?>" readonly>
                                                        <input type="hidden" class="form-control" name="user_id" id="user_id" value="<?= $_SESSION['isUserSession']['user_id'] ?>" readonly>

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
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div role="tabpanel" class="tab-pane fade" id="CollectionSaction">
                                    <div id="collection">
                                        <div class="footer-support">
                                            <input type="hidden" name="leadIdForDocs" id="leadIdForDocs">
                                            <h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#collapse_loan_statust">Loan Status &nbsp;<i class="fa fa-angle-double-down"></i></button></h2>
                                        </div>
                                    </div>

                                    <div id="collapse_loan_statust" class="collapse">
                                        <div id="loanStatus"></div>
                                    </div>
                                    
                                    <?php if($_SESSION['isUserSession']['role'] == "Collection"
                                        || $_SESSION['isUserSession']['role'] == "Client Admin" ) { ?>
                                            
                                        <div id="collection">
                                            <div class="footer-support">
                                                <h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#collapse_update-paymunt">Update Payment &nbsp;<i class="fa fa-angle-double-down"></i></button> </h2>
                                            </div>
                                        </div>

                                        <div id="collapse_update-paymunt" class="collapse">
                                            <form id="FormRecoveryAmount" method="post" enctype="multipart/form-data" style="background:#fff !important;">
                                                <input type="hidden" class="form-control" name="lead_id" id="lead_id" readonly>
                                                <input type="hidden" class="form-control" name="recovery_id" id="recovery_id" readonly>
                                                <div class="form-group row" style="background:#fff  !important;">
                                                    <div class="col-sm-6">
                                                        <label for="Payment Recived">Payment Received <span class="required_Fields">*</span></label>
                                                        <input class="form-control rounded-0" id="payment_amount" name="payment_amount" onchange="checkLeftAmount(this)" type="number"/>
                                                    </div>
                        
                                                    <div class="col-sm-6">
                                                        <label for="inputLastname">Refrence No. <span class="required_Fields">*</span></label>
                                                        <input class="form-control rounded-0" id="refrence_no" name="refrence_no" type="text" value=""/>
                                                    </div>
                        
                                                    <div class="col-sm-6">
                                                        <label for="Payment Mode">Payment Mode <span class="required_Fields">*</span></label>
                                                        <select class="form-control" name="payment_mode" id="payment_mode">
                                                            <option value="">Select Payment Mode</option>
                                                            <option value="Google Pay">Google Pay</option>
                                                                <option value="Easy Pay">Easy Pay</option>
                                                            <option value="ICICI UPI">ICICI UPI</option>
                                                            <option value="eNACH">eNACH</option>
                                                            <option value="PayTM">PayTM</option>
                                                            <option value="084305001370">Icici Bank/ 084305001370</option>
                                                            <option value="920020009314172">Axis Bank/ 920020009314172</option>
                                                            <option value="201002831962">Indus Bank/ 201002831962</option>
                                                            <option value="Approval">Approval</option>
                                                        </select>
                                                    </div>
                        
                                                    <div class="col-sm-6">
                                                        <label for="Payment Type">Payment Type <span class="required_Fields">*</span></label>
                                                        <select class="form-control" name="payment_type" id="payment_type">
                                                            <option value="">Select Payment Type</option>
                                                            <option value="Full Payment">Full Payment</option>
                                                            <option value="Part Payment">Part Payment</option>
                                                            <option value="Settlement">Settlement</option>
                                                            <option value="Renuable Amount">Renuable Amount</option>
                                                            <option value="Admin Fee">Admin Fee</option>
                                                            <option value="EMI">EMI</option> 
                                                        </select>
                                                    </div>
                        
                                                    <div class="col-sm-6">
                                                        <label for="Discount">Discount <span class="required_Fields">*</span></label>
                                                        <input class="form-control rounded-0" id="discount" name="discount" type="number" value="0"/>
                                                    </div>
                        
                                                    <div class="col-sm-6">
                                                        <label for="Upload Docs">Upload Docs <span class="required_Fields">*</span></label>
                                                        <input type="file" class="form-control" name="image" id="image">
                                                    </div>
                        
                                                    <div class="col-sm-12">
                                                        <label for="Remark">Remark <span class="required_Fields">*</span></label>
                                                        <textarea class="form-control" name="remark" id="remark"></textarea>
                                                    </div>
                                                </div>
                        
                                                <div class="row">
                                                    <div class="col-sm-9"></div>
                                                    <div class="col-sm-2">
                                                        <button class="btn btn-primary" id="btnPaymentReceived">PAYMENT RECIVED</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    <?php } ?>
                                    <?php if($_SESSION['isUserSession']['role'] == "Account and MIS" 
                                            || $_SESSION['isUserSession']['role'] == "Client Admin"){ ?>
                                        <div id="collection">
                                            <div class="footer-support">
                                                <input type="hidden" name="leadIdForDocs" id="leadIdForDocs">
                                                <h2 class="footer-support">Recovery Status &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                                            </div>
                                        </div>
                                        <div id="recoveryData"></div>
                        
                                        <?php if($_SESSION['isUserSession']['role'] == "Collection" 
                                            || $_SESSION['isUserSession']['role'] == "Account and MIS"
                                            || $_SESSION['isUserSession']['role'] == "Client Admin") { ?>
                                            
                                            <div id="collection">
                                                <div class="footer-support">
                                                    <h2 class="footer-support">Verify Payment &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                                                </div>
                                            </div>
                                        
                                            <form id="FormVerifyPayment" method="post" enctype="multipart/form-data">
                                                <input type="hidden" class="form-control" name="lead_id" id="lead_id" readonly>
                                                <input type="hidden" class="form-control" name="recovery_id" id="recovery_id" readonly>
                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <label for="Payment Recived">Payment Received <span class="required_Fields">*</span></label>
                                                        <input class="form-control rounded-0" id="payment_amount" name="payment_amount" onchange="checkLeftAmount(this)" type="number"/>
                                                    </div>
                        
                                                    <div class="col-sm-6">
                                                        <label for="inputLastname">Refrence No. <span class="required_Fields">*</span></label>
                                                        <input class="form-control rounded-0" id="refrence_no" name="refrence_no" type="text" value=""/>
                                                    </div>
                        
                                                    <div class="col-sm-6">
                                                        <label for="Payment Mode">Payment Mode <span class="required_Fields">*</span></label>
                                                        <select class="form-control" name="payment_mode" id="payment_mode">
                                                            <option value="">Select Payment Mode</option>
                                                            <option value="Google Pay">Google Pay</option>
                                                            <option value="Easy Pay">Easy Pay</option>
                                                            <option value="ICICI UPI">ICICI UPI</option>
                                                            <option value="eNACH">eNACH</option>
                                                            <option value="PayTM">PayTM</option>
                                                            <option value="084305001370">Icici Bank/ 084305001370</option>
                                                            <option value="920020009314172">Axis Bank/ 920020009314172</option>
                                                            <option value="201002831962">Indus Bank/ 201002831962</option>
                                                            <option value="Approval">Approval</option>
                                                        </select>
                                                    </div>
                        
                                                    <div class="col-sm-6">
                                                        <label for="Payment Type">Payment Type <span class="required_Fields">*</span></label>
                                                        <select class="form-control" name="payment_type" id="payment_type">
                                                            <option value="">Select Payment Type</option>
                                                            <option value="Full Payment">Full Payment</option>
                                                            <option value="Part Payment">Part Payment</option>
                                                            <option value="Settlement">Settlement</option>
                                                            <option value="Renuable Amount">Renuable Amount</option>
                                                            <option value="Admin Fee">Admin Fee</option>
                                                            <option value="EMI">EMI</option>
                                                        </select>
                                                    </div>
                        
                                                    <div class="col-sm-6">
                                                        <label for="Date Of Received">Date Of Received <span class="required_Fields">*</span></label>
                                                        <input type="text" class="form-control rounded-0" id="date_of_recived" name="date_of_recived"/>
                                                    </div>
                        
                                                    <div class="col-sm-6">
                                                        <label for="Discount">Discount <span class="required_Fields">*</span></label>
                                                        <input class="form-control rounded-0" id="discount" name="discount" type="number" value="0"/>
                                                    </div>
                        
                                                    <div class="col-sm-6">
                                                        <label for="Remark">Remark <span class="required_Fields">*</span></label>
                                                        <textarea class="form-control" name="remark" id="remark"></textarea>
                                                    </div>
                                                </div>
                        
                                                <div class="row">
                                                    <div class="col-sm-9"></div>
                                                    <div class="col-sm-2">
                                                        <button class="btn btn-primary" id="btnPaymentVerify">VERIFY PAYMENT</button>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
            
    function viewLeadsDetails(lead_id)
    {
        $('#leadIdForDocs, #lead_id').val('');
        $('#leadIdForDocs, #lead_id').val(lead_id);
        $('#btndivCheckCibil, #btndivUploadDocs, #btndivReject, #divpersonalDetails, #divCamDetails, #btndivCamDetails, #formDisbursalOtherDetails').hide();
        $('#ViewPersonalDetails, #ViewCAMDetails, #ViewDisbursalBankDetails, #divUpdateReferenceNo').show();
        $("#exampleModalLongTitle, #modelTable, #oldTaskHistory, #viewCredit, #docsHistory").empty();
        $("#viewContactDetails").html('');
        // $('#btnCheckCibil').prop("disabled", true);

        $.ajax({
            url : '<?= base_url("getleadDetails/") ?>'+lead_id,
            type : 'POST',
            dataType : "json",
            beforeSend: function() {
                $('#viewLeadsDetailse').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').addClass('disabled', true);
            },
            success : function(response){
               // alert(response['tbl_cibil']);
                var html = "";
                html += '<div class="table-responsive"><table class="table table-hover table-striped table-bordered">';
                html += '<tr><th colspan="2"></th><th class="thbg">Application No</th><td>-</td></tr>';
                html += '<tr><th>First Name</th><td>'+ response['leadDetails'].name +'</td><th>Middle Name</th><td>'+ ((response['leadDetails'].middle_name == '') ? '-':response['leadDetails'].middle_name) +'</td></tr>';
                html += '<tr><th>Surname</th><td>'+ ((response['leadDetails'].sur_name=='')?'-':response['leadDetails'].sur_name) +'</td><th>Gender</th><td>'+ ((response['leadDetails'].gender=='')?'-':response['leadDetails'].gender) +'</td></tr>';
                html += '<tr><th>DOB</th><td>'+ ((response['leadDetails'].dob=='')?'-':response['leadDetails'].dob) +'</td><th>PAN</th><td>'+ ((response['leadDetails'].pancard=='')?'-':response['leadDetails'].pancard) +'</td></tr>';
                html += '<tr><th>Mobile</th><td>'+ ((response['leadDetails'].mobile=='')?'-':response['leadDetails'].mobile) +'</td><th>Alternate Mobile</th><td>'+ ((response['leadDetails'].alternateMobileNo=='')?'-':response['leadDetails'].alternateMobileNo) +'</td></tr>';
                html += '<tr><th>Email</th><td>'+ ((response['leadDetails'].email=='')?'-':response['leadDetails'].email) +'</td><th>Loan Applied</th><td>'+ ((response['leadDetails'].loan_amount=='')?'-':response['leadDetails'].loan_amount) +'</td></tr>';
                html += '<tr><th>State</th><td>'+ ((response['leadDetails'].state=='')?'-':response['leadDetails'].state) +'</td><th>City</th><td>'+ ((response['leadDetails'].city=='')?'-':response['leadDetails'].city) +'</td></tr>';
                html += '<tr><th>Pincode</th><td>'+ ((response['leadDetails'].pincode=='')?'-':response['leadDetails'].pincode) +'</td><th style="background: #ddd;">Post Office</th><td style="background: #ddd;">-</td></tr>';
                html += '<tr><th>Initiated On</th><td>'+ response['leadDetails'].created_on +'</td><th>Lead Source</th><td>'+ ((response['leadDetails'].source=='')?'-':response['leadDetails'].source) +'</td></tr>';
                html += '<tr><th>Geo Coordinates</th><td>'+ ((response['leadDetails'].coordinates=='')?'-':response['leadDetails'].coordinates) +'</td><th>IP Address</th><td>'+ ((response['leadDetails'].ip=='')?'-':response['leadDetails'].ip) +'</td></tr>';
                html += '<tr style="background: #ddd;"><th>Selfie Video</th><td>-</td><th></th><td></td></tr>';
                $('#LeadDetails').html(html);
                
                
                // if(response['checkCibil'].check_cibil_status == 0 && response['checkCibil'].created_on) 
                // {
                //     $('#btnCheckCibil').prop("disabled",true); 
                // } 
                
                if(response['tbl_cibil'] === true)
                { 
                    $('#btnCheckCibil').attr('disabled','disabled');
                } 
                else {
                    $('#btnCheckCibil').removeAttr("disabled"); 
                } 

                if(response['leadStatus'].status == "New Leads" || response['leadStatus'].status == "IN PROCESS" || response['leadStatus'].status == "SEND BACK" || response['leadStatus'].status == "Hold" ){
                    $('#btndivCheckCibil, #btndivUploadDocs, #btndivReject, #divpersonalDetails, #divCamDetails').show();
                    $('#ViewPersonalDetails, #ViewCAMDetails').hide();
                }

                if(response['leadStatus'].status == "RECOMMEND"){
                    $('#btndivCamDetails').show();
                }
                // if(response['leadStatus'].status == "SANCTION"){
                //     $('#formDisbursalOtherDetails').show();
                // }
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
                
                viewOldHistory(lead_id);
                ViewCibilStatement(lead_id);
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
    
    function getLeadDetails()
    {
        var lead_id = $('#lead_id').val();
        viewLeadsDetails(lead_id);
    }
    
    // function getPersonalDetails()
    // {
    //     var lead_id = $('#lead_id').val();
    //     $.ajax({
    //         url : '<?= base_url("getleadDetails/") ?>'+lead_id,
    //         type : 'POST',
    //         dataType : "json",
    //         success : function(response){
    //             var alternateMobileNo = response['taskHistory'].alternateMobileNo;
    //             var alternateEmailAddress = response['taskHistory'].alternateEmailAddress;
    //             var addressLine1 = response['taskHistory'].addressLine1;
    //             var area = response['taskHistory'].area;
    //             var landmark = response['taskHistory'].landmark;

    //             if(alternateMobileNo != "" && alternateEmailAddress != "" && addressLine1 != "" && area != "" && landmark != "")
    //             {
    //                 $('#yourMobile, #alternateMobileNo, #yourEmail, #alternateEmailAddress, #yourGender, #yourPancard, #addressLine1, #area, #yourPincode, #landmark, .btnAddContactDetails').prop('disabled', true);

    //                 var contactDetails = '<div class="table-responsive"><table class="table table-hover table-striped">';
    //                 contactDetails += '<tr><th>Alternate Mobile No</th><td>'+ alternateMobileNo +'</td><th>Alternate Email</th><td>'+ alternateEmailAddress +'</td></tr>';
    //                 contactDetails += '<tr><th>Address Line1</th><td>'+ addressLine1 +'</td><th>Area</th><td>'+ area +'</td></tr>';
    //                 contactDetails += '<tr><th>Landmark</th><td>'+ landmark +'</td><th></th><td></td></tr>';
    //                 contactDetails += '</table></div>';

    //                 $('#viewContactDetails').show().html(contactDetails);
    //                 $('#addContactDetails').hide();
    //             }else{
    //                 $('#yourMobile, #alternateMobileNo, #yourEmail, #alternateEmailAddress, #yourGender, #yourPancard, #addressLine1, #area, #yourPincode, #landmark,.btnAddContactDetails').prop('disabled', false);
    //             }
    //             $('#yourMobile').val(response['taskHistory'].mobile);
    //             $('#alternateMobileNo').val(response['taskHistory'].alternateMobileNo);
    //             $('#yourEmail').val(response['taskHistory'].email);
    //             $('#alternateEmailAddress').val(response['taskHistory'].alternateEmailAddress);
    //             $('#yourGender').val(response['taskHistory'].gender);
    //             $('#yourPancard').val(response['taskHistory'].pancard);
    //             $('#addressLine1').val(response['taskHistory'].addressLine1);
    //             $('#area').val(response['taskHistory'].area);
    //             $('#yourPincode').val(response['taskHistory'].pincode);
    //             $('#landmark').val(response['taskHistory'].landmark);

    //         }
    //     });
    //     ShowCustomerEmploymentDetails(lead_id);
    // }
    
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
    
    function getCamDetails()
    {
        $('#viewCibil').html("");
        var lead_id = $('#lead_id').val();
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
    
    // function RejectedLoan() 
    // {
    //     if (confirm("Are you sure, this lead is duplicate!")) {

    //         var prependFormDuplicateLead = '<div id="formResonforDuplicateLeads">'
    //         prependFormDuplicateLead += '<div class="row">';
    //         prependFormDuplicateLead += '<form id="formResonRejectLoan" method="post" enctype="multipart/form-data">';
    //         prependFormDuplicateLead += '<div class="col-md-10">';
    //         prependFormDuplicateLead += '<input type="text" class="form-control" name="resonForReject" id="resonForReject" placeholder="Give reson for reject Loan" required>';
    //         prependFormDuplicateLead += '</div>';
    //         prependFormDuplicateLead += '</form>';
    //         prependFormDuplicateLead += '<div class="col-md-2">';
    //         prependFormDuplicateLead += '<button class="btn btn-primary" onclick="ResonForRejectLoan()">Reject</button>';
    //         prependFormDuplicateLead += '</div>';
    //         prependFormDuplicateLead += '</div>';
    //         prependFormDuplicateLead += '</div>';
    //         $("#ResonBoxForrejectLoan").html(prependFormDuplicateLead);
    //     }
    // }

    function ResonForRejectLoan()
    {
        var lead_id = $("#lead_id").val();
        var reson = $("#resonForReject").val();

        if(lead_id == ""){
            catchError("Lead ID is required.");
            return false;
        } else if(reson == ""){
            catchError("Reason is required.");
            return false;
        }else{
            $.ajax({
                url : '<?= base_url("resonForRejectLoan") ?>',
                type : 'POST',
                data:{lead_id : lead_id, reson : reson},
                dataType : 'json',
                beforeSend: function() {
                    $(".reject-button").html('<span class="spinner-border spinner-border-sm" role="status"></span>Processing...').addClass('disabled');
                },
                success : function(response) {
                    if(response.msg){
                        $('#reson').empty();
                        catchSuccess(response.msg);
                        window.location.reload();
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $(".reject-button").html('REJECT').removeClass('disabled');
                }
            });
        }
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
    
    function viewOldHistory(lead_id)
    {
        $.ajax({
            url : '<?= base_url("viewOldHistory/") ?>'+lead_id,
            type : 'POST',
            dataType : "json",
            success : function(response){
                $('#oldTaskHistory').empty();
                $('#oldTaskHistory').html(response);
            }
        });
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
    
    function ViewCibilStatement(lead_id)
    {
        $.ajax({
            url : '<?= base_url("cibilStatement"); ?>',
            type : 'POST',
            data : {lead_id : lead_id},
            dataType : "json",
            success : function(response){
                $('#cibilStatement').html("");
                $('#cibilStatement').html(response);
            }
        });
    }
    
    // function viewCustomerCibilPDF(cibil_id)
    // {
    //     $.ajax({
    //         url : '<?= base_url("viewCustomerCibilPDF"); ?>',
    //         type : 'POST',
    //         dataType : "json",
    //         data : {cibil_id : cibil_id},
    //         async: false,
    //         success : function(response){
    //             $('#viewCibil').html(response.cibil_file);
    //         }
    //     });
    // }
    
	function checkCustomerCibil()
	{
	    var lead_id = $('#lead_id').val();
	    autoCheckCustomerCibil(lead_id);
	}
	
	function autoCheckCustomerCibil(lead_id)
	{
        // $('#viewCibilModel').click();
	    if(lead_id != '')
        {
	        $.ajax({
                url : '<?= base_url("cibil") ?>',
                type : 'POST',
                data:{lead_id : lead_id},
                dataType: 'json',
                beforeSend: function() {
                    $('#checkCustomerCibil a').html('<span class="spinner-border spinner-border-sm" role="status"></span>Processing...').addClass('disabled');
                },
                success : function(response) {
                    if(response.err){
                        catchError(response.err);
                    }else{
                        catchSuccess(response);
                        ViewCibilStatement(lead_id);
                    }
                },
                complete: function() {
                    $('#checkCustomerCibil a').html('Check Cibil').removeClass('disabled');
                }
            });
	    } else {
            catchError("No record found.");
	    }
	}
    
    //////////////////////////////////////////////////////////////// Document Section /////////////////////////////////////////////////////////////////////////////////
    
    function sendRequestToCustomerForUploadDocs()
    {
        if (confirm("Are you sure to send request to the customer for upload docs!")) {
            var lead_id = $('#leadIdForDocs').val();
            $.ajax({
                url : '<?= base_url("sendRequestToCustomerForUploadDocs") ?>',
                type : 'POST',
                dataType : "json",
                data : {lead_id : lead_id},
                async: false,
                success : function(response) {
                    if(response == "true"){
                        $(".msg").show().fadeOut(2000);
                        $(".msg a").html("Request Send Successfully.");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#exampleModalLongTitle").html(textStatus +" : "+ errorThrown);
                    return false;
                }
            });
        }else{
            console.log('not ok');
        }
    }

    function viewCustomerDocs(docs_id) {
        $.ajax({
            url : '<?= base_url("viewCustomerDocs/") ?>'+docs_id,
            type : 'POST',
            dataType : "json",
            async: false,
            success : function(response) { 
                window.open(response, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=50,width=400,height=400");  
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                $("#exampleModalLongTitle").html(textStatus +" : "+ errorThrown);
                return false;
            }
        });
    }

    function editCustomerDocs(docs_id) 
    {
        console.log(docs_id);
        $('#formUploadDocs').show();
        $.ajax({
            url : '<?= base_url("viewCustomerDocsById/") ?>'+docs_id,
            type : 'POST',
            dataType : "json",
            success : function(response) {
                $('#getDocId').html('<input type="hidden" name="docs_id" id="docs_id" value="'+ response.docs_id +'">');
                $("#btnSaveDocs").html("Update Docs");
                $("#docsType").val(response.type);
            }
        });
    }

    function viewCustomerPaidSlip(docs_id) 
    {
        $.ajax({
            url : '<?= base_url("viewCustomerPaidSlip/") ?>'+docs_id,
            type : 'POST',
            dataType : "json",
            async: false,
            success : function(response) {
                window.open(response, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=50,width=400,height=400");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                $("#exampleModalLongTitle").html(textStatus +" : "+ errorThrown);
                return false;
            }
        });
    }

    function downloadCustomerdocs(docs_id) 
    {
        $.ajax({
            url : '<?= base_url("downloadCustomerdocs/") ?>'+docs_id,
            type : 'POST',
            dataType : "json",
            async: false,
            success : function(response) {
                    window.location.href = response;
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                $("#exampleModalLongTitle").html(textStatus +" : "+ errorThrown);
                return false;
            }
        });
    }

    function getDocs(lead_id)
    {
        $.ajax({
            url : '<?= base_url("getDocsUsingAjax/") ?>' +lead_id,
            type : 'POST',
            dataType : "json",
            async: false,
            success : function(response) {
                // $('#docsHistory').empty();
                $('#docsHistory').html(response);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                $("#exampleModalLongTitle").html(textStatus +" : "+ errorThrown);
                return false;
            }
        });
    }

    //$('#formUploadDocs').hide();
    $('#btnUploadDocsByUser').click(function()
    {
        $('#formUploadDocs').show();
        $("#btnSaveDocs").html("Save Docs");
        $('#docs_id, #docsType').val('');
    });

    $(document).ready(function(){
        $('#formUserDocsData1').submit(function(e){
            var lead_id = $('#leadIdForDocs').val();
            e.preventDefault();
            $.ajax({
                url : '<?= base_url("saveCustomerDocs") ?>',
                type : 'POST',
                data:new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                success : function(response) {
                    if(response == "true"){
                        if($('#docs_id').val() != ""){
                            $("#btnSaveDocs").html("Save Docs");
                            $('#formUserDocsData1').hide();
                            $('#docs_id').val('');
                        }
                        catchSuccess("File Uploaded Successfully.");
                        $('#formUserDocsData')[0].reset();
                        $('#btnGetDocumentById').click();
                    }else{
                        catchError(response);
                    }
                    getDocs(lead_id);
                }
            });
        }); 
    

        $('#formUserDocsData2').submit(function(e){
            var lead_id = $('#leadIdForDocs').val();
            e.preventDefault();
            $.ajax({
                url : '<?= base_url("saveCustomerDocs") ?>',
                type : 'POST',
                data:new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                success : function(response) {
                    if(response == "true"){
                        if($('#docs_id').val() != ""){
                            $("#btnSaveDocs").html("Save Docs");
                            $('#formUserDocsData2').hide();
                            $('#docs_id').val('');
                        }
                        catchSuccess("File Uploaded Successfully.");
                        $('#formUserDocsData')[0].reset();
                        $('#btnGetDocumentById').click();
                    }else{
                        catchError(response);
                    }
                    getDocs(lead_id);
                }
            });
        }); 
        
        $('#formUserDocsData3').submit(function(e){
            var lead_id = $('#leadIdForDocs').val();
            e.preventDefault();
            $.ajax({
                url : '<?= base_url("saveCustomerDocs") ?>',
                type : 'POST',
                data:new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                success : function(response) {
                    if(response == "true"){
                        if($('#docs_id').val() != ""){
                            $("#btnSaveDocs").html("Save Docs");
                            $('#formUserDocsData3').hide();
                            $('#docs_id').val('');
                        }
                        catchSuccess("File Uploaded Successfully.");
                        $('#formUserDocsData')[0].reset();
                        $('#btnGetDocumentById').click();
                    }else{
                        catchError(response);
                    }
                    getDocs(lead_id);
                }
            });
        }); 
        
        $('#formUserDocsData4').submit(function(e){
            var lead_id = $('#leadIdForDocs').val();
            e.preventDefault();
            $.ajax({
                url : '<?= base_url("saveCustomerDocs") ?>',
                type : 'POST',
                data:new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                success : function(response) {
                    if(response == "true"){
                        if($('#docs_id').val() != ""){
                            $("#btnSaveDocs").html("Save Docs");
                            $('#formUserDocsData4').hide();
                            $('#docs_id').val('');
                        }
                        catchSuccess("File Uploaded Successfully.");
                        $('#formUserDocsData')[0].reset();
                        $('#btnGetDocumentById').click();
                    }else{
                        catchError(response);
                    }
                    getDocs(lead_id);
                }
            });
        });
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
    
    
	
    function disbursalDetails()
    {
        $('#updateDisbursalApprove').prop('disabled', true);
        $('#divUpdateReferenceNo').hide();
        $('#formDisbursalOtherDetails').show();
        var lead_id = $("#lead_id").val();
        $.ajax({
            url : '<?= base_url("getSanctionDetails/") ?>'+lead_id,
            type : 'POST',
            dataType : "json",
            success : function(response){
                var IFSC = "";
                var Branch = "";
                var accountNo = "CC Account Number";
                var holderName = "CC Holder Name";
                var bankName = "CC Bank Name";
                var accountType = "CC Type";
                var customer_account_no = response['CAM']['customer_account_no'];
                var customer_name = response['CAM']['customer_name'];
                var customer_bank = response['CAM']['customer_bank_name'];
                var account_type = response['CAM']['account_type'];

                if(response['CAM']['isDisburseBankAC'] == "YES"){
                    IFSC = "IFSC Code";
                    Branch = "Bank Branch";
                    accountNo = "Bank Account Number";
                    holderName = "Bank Holder Name";
                    bankName = "Bank Name";
                    accountType = "Account Type";

                    customer_account_no = response['CAM']['bankA_C_No'];
                    customer_name = response['CAM']['bankHolder_name'];
                    customer_bank = response['CAM']['bank_name'];
                    account_type = response['CAM']['bank_account_type'];
                }

                var html = '<table class="table table-bordered table-striped">';
                    html += '<tbody>';  
                    html += '<tr><th class="thbg">Application No</th><td>-</td><th class="thbg">Loan No</th><td>-</td></tr>';
                    html += '<tr><th class="thbg">'+ bankName +'</th><td class="tdbg">'+ ((customer_bank=='')?'-':customer_bank) +'</td><th class="thbg">'+ accountType +'</th><td class="tdbg">'+ ((account_type=='')?'-':account_type) +'</td></tr>';
                    html += '<tr><th class="thbg">'+ accountNo +'</th><td class="tdbg">'+ ((customer_account_no=='')?'-':customer_account_no) +'</td><th class="thbg">'+ holderName +'</th><td class="tdbg">'+ ((customer_name=='')?'-':customer_name) +'</td></tr>';
                    html += '<tr><th class="thbg">ROI (%)</th><td class="tdbg">'+ ((response['CAM']['roi']=='')?'-':response['CAM']['roi']) +'</td><th class="thbg">Sanctioned Amount</th><td class="tdbg">'+ response['CAM']['loan_recomended'] +'</td></tr>';
                    html += '<tr><th class="thbg">Tenure (Days)</th><td class="tdbg">'+ ((response['CAM']['tenure']=='')?'-':response['CAM']['tenure']) +'</td><th class="thbg">Repayment Amount</th><td class="tdbg">'+ ((response['CAM']['repayment_amount']=='')?'-':response['CAM']['repayment_amount']) +'</td></tr>';
                    html += '<tr><th class="thbg">Admin Fee</th><td class="tdbg">'+ ((response['CAM']['processing_fee']=='')?'-':response['CAM']['processing_fee']) +'</td><th class="thbg">Net Disbursal Amount</th><td class="tdbg">'+ ((response['CAM']['net_disbursal_amount']=='')?'-':response['CAM']['net_disbursal_amount']) +'</td></tr>';
                    html += '<tr><th class="thbg">Disbursal Date</th><td class="tdbg">'+ ((response['CAM']['disbursal_date']=='')?'-':response['CAM']['disbursal_date']) +'</td><th class="thbg">Repayment Date</th><td class="tdbg">'+ ((response['CAM']['repayment_date']=='')?'-':response['CAM']['repayment_date']) +'</td></tr>';
                    html += '</tbody>';
                    html += '</table>';

                var html2 = '<table class="table table-bordered table-striped">';
                    html2 += '<tbody>';
                    html2 += '<tr><th class="thbg">Sent to Email</th><td class="tdbg">'+ ((response['CAM']['email']=='')?'-':response['CAM']['email']) +'</td><td colspan="2" class="tdbg">'+ ((response['Disburse']['loanAgreementRequest']=='')?'-':response['Disburse']['loanAgreementRequest']) +'</td></tr>';

                    html2 += '<tr><th class="thbg">Sent to Alternate Email</th><td class="tdbg">'+ ((response['CAM']['alternateEmail']=='')?'-':response['CAM']['alternateEmail']) +'</td><td colspan="2">'+ ((response['Disburse']['loanAgreementRequest2']=='')?'-':response['Disburse']['loanAgreementRequest2']) +'</td></tr>';
                    html2 += '<tr><th class="thbg">Email Sent Date</th><td class="tdbg">'+ ((response['Disburse']['agrementRequestedDate']=='')?'-':response['Disburse']['agrementRequestedDate']) +'</td><th class="thbg">Email Response</th><td class="tdbg">'+ ((response['Disburse']['loanAgreementResponse']=='')?'-':response['Disburse']['loanAgreementResponse']) +'</td></tr>';
                    html2 += '<tr><th class="thbg">Response Email Date</th><td class="tdbg">'+ ((response['Disburse']['agrementResponseDate']=='')?'-':response['Disburse']['agrementResponseDate']) +'</td><th class="thbg">Response Email</th><td class="tdbg">'+ ((response['Disburse']['responseEmail']=='')?'-':response['Disburse']['responseEmail']) +'</td></tr>';
                    html2 += '<tr><th class="thbg">Response Email IP</th><td colspan="3" >'+ ((response['Disburse']['agrementUserIP']=='')?'-':response['Disburse']['agrementUserIP']) +'</td></tr>';
                    html2 += '</tbody>';
                    html2 += '</table>';

                var html3 = '<table class="table table-bordered table-striped">';
                    html3 += '<tbody>';
                    html3 += '<tr><th class="thbg">Disbursal Bank</th><td class="tdbg">'+ ((response['Disburse']['company_account_no']=='')?'-':response['Disburse']['company_account_no']) +'</td><th>Channel</th><td class="tdbg">'+ ((response['Disburse']['channel']=='')?'-':response['Disburse']['channel']) +'</td></tr>';
                    html3 += '<tr><th class="thbg">Disbursed Amount</th><td colspan="3">'+ ((response['CAM']['net_disbursal_amount']=='')?'-':response['CAM']['net_disbursal_amount']) +'</td></tr>';
                    html3 += '<tr><th class="thbg">Disbursal Referance no</th><td colspan="3">'+ ((response['Disburse']['disburse_refrence_no']=='')?'-':response['Disburse']['disburse_refrence_no']) +' | <a target="_blank" href="<?= base_url('upload/'); ?>'+ response['Disburse']['screenshot'] +'"><fa class="fa fa-picture-o"></fa></a></td></tr>';
                    html3 += '</tbody>';
                    html3 += '</table>';

                $('#payable_amount').val(response['CAM']['net_disbursal_amount']);
                $('#updateDisbursalApprove').prop('disabled', false);

                if(response['Disburse']['loanAgreementResponse'] == "APPROVED"){
                    $('#formDisbursalOtherDetails').show();
                }
                if(response['Disburse']['loan_status'] == "DISBURSE"){
                    $('#formDisbursalOtherDetails, #updateDisbursalApprove').hide();
                    $('#updateDisbursalApprove').prop('disabled', true);
                    $('#divUpdateReferenceNo').show();
                }
                
                // $('#formDisbursalOtherDetails').show(); 
                if(response['Disburse']['disburse_refrence_no'] != ""){
                    $('#formDisbursalOtherDetails').hide(); 
                }
                
                if(response['Disburse']['loan_status'] == "DISBURSED"){
                    $('#formDisbursalOtherDetails').hide();
                }

                $('#ViewDisbursalDetails').html(html);
                $('#ViewAgreementDetails').html(html2);
                $('#ViewDisbursalBankDetails').html(html3);
            }
        });
        
    }
    
    ////////////////////////Get bank Details For Update Disbursal////////////////////////
    
    $(document).ready(function(){
        
        $('#customer_ifsc_code').select2({
            placeholder: 'Select IFSC Code',
            minimumInputlength: 2,
            allowClear: true,
        //   $.ajax({
        //         url: '<?= base_url('getCustomerBankDetails') ?>',
        //         dataType: 'json',
        //         delay: 250,
        //         data: function (data) {
        //             return {
        //                 searchTerm: data.term // search term
        //             };
        //         },
        //         processResults: function (response) {
        //             return {
        //                 results: $.map(response, function (item) {
        //                     return {
        //                         id: item.bank_ifsc,
        //                         text: item.bank_ifsc,
        //                     }
        //                 })
        //             };
        //         },
        //         cache: true
        //     }); 
                ajax: {
                url: '<?= base_url('getCustomerBankDetails') ?>',
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
                data : {ifsc_code : ifsc_code},
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
                        // window.location.reload();
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
                        location.reload();
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
    
    $("#sdsafsfsds").change(function(){
        var name = $(this).val();
        if(name =="Credit card statement")
        {
            $('#bankPassword').html('<div class="col-md-3"><input type="text" class="form-control" name="password" id="password" placeholder="Password"></div>');
            $('#selectDocType').attr('class', 'col-md-3');
            $('#selectFileType').attr('class', 'col-md-4');
            $('#btnDocsSave').attr('class', 'col-md-2');
        }else{
            $('#bankPassword').html('<span></span>');
            $('#selectDocType').attr('class', 'col-md-4');
            $('#selectFileType').attr('class', 'col-md-6');
            $('#btnDocsSave').attr('class', 'col-md-2');
        }
        // $.ajax({
        //     url : '<?= base_url("filterReportFilterType") ?>',
        //     type : 'POST',
        //     dataType : "json",
        //     data : {name : name},
        //     success : function(response){
        //         $('#filterType').empty();
        //         $('#filterType').html('<option value="">Filter Type</option>');
        //         $.each(response, function (i, item) {
        //             $('#filterType').append($('<option>', { 
        //                 value: item.name,
        //                 text : item.name 
        //             }));
        //         });
        //     }
        // });
    });
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
                  <!-- contact Details -->
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

<!-- <a href="#" data-toggle="modal" data-target="#viewCibilModel" class="btn btn-primary" id="btnEditModel"></a> -->

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

<div id="editContact" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true" style="width= : 100%; height : auto;">
    <div class="modal-dialog modal-lg" role="document" style="margin-top :100px; margin-left: 100px; background: #fff;">
        <div class="modal-content" id="viewCustomerData" style="height : 600px; overflow: auto;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">...</h5><hr>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="formEditContactDetails" method="post" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-2">
                                    <label>Mobile <span class="required_Fields">*</span></label> 
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="mobile" id="yourMobileedit">
                                </div>
                                <div class="col-md-2">
                                    <label>Alternate Mobile <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="alternateMobileNo" id="alternateMobileNoedit">
                                </div>
                            </div>

                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-2">
                                    <label>Email <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="email" id="yourEmailedit">
                                </div>
                                <div class="col-md-2">
                                    <label>Alternate Email <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="alternateEmailAddress" id="alternateEmailAddressedit" onchange="IsEmail(this)">
                                </div>
                            </div>

                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-2">
                                    <label>Gender <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="gender" id="yourGenderedit">
                                </div>
                                
                                <div class="col-md-2">
                                    <label>Pancard <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="pancard" id="yourPancardedit" onchange="validatePanNumber(this)" title="Ex. DPDPK3222P">
                                </div>
                            </div>

                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-2">
                                    <label>Address Line 1 <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="addressLine1" id="addressLine1edit">
                                </div>

                                <div class="col-md-2">
                                    <label>Area <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="area" id="areaedit">
                                </div>
                            </div>

                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-2">
                                    <label>Pincode <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="pincode" id="yourPincodeedit" maxlength="6">
                                </div>
                                <div class="col-md-2">
                                    <label>Landmark <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="landmark" id="landmarkedit"></textarea>
                                </div>
                            </div>

                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-2">
                                    <label>Date of Birth<span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" name="dob" id="yourDOBedit">
                                </div>
                            </div>

                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-2">
                                    <input type="button" class="btn btn-primary editContactDetails" value="Update Contact">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
           </div>
        </div>
    </div>
</div>

<div id="editBankDetails" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true" style="width= : 100%; height : auto;">
    <div class="modal-dialog modal-lg" role="document" style="margin-top : 100px; margin-left: 100px; background: #fff;">
        <div class="modal-content" id="viewCustomerData" style="height : 600px; overflow: auto;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">...</h5><hr>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="UpdateBankDetailsDisbursal" method="post" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <input type="hidden" class="form-control" name="lead_id" id="lead_id" readonly>
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-2">
                                    <label>IFSC Code <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                <select class="form-control" style="width:100%;" name="customer_ifsc_code" id="customer_ifsc_code_edit" required></select>
                                    <!-- <option value="" id="ifsc" selected><span id="ifsc_value"></span></option> -->
                                </div>

                                <div class="col-md-2">
                                    <label>Customer Bank Name <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="customer_bank_name" id="customer_bank_name_edit" required>
                                </div>
                            </div>

                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-2">
                                    <label>A/C No. <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="customer_account_no" id="customer_account_no_edit" required>
                                </div>
                                <div class="col-md-2">
                                    <label>Confirm A/C No. <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="customer_confirm_account_no" id="customer_confirm_account_no_edit" onchange="customer_confirm_acc_no_edit(this)" required>
                                </div>
                            </div>
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-2">
                                    <label>Customer Name <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="customer_name" id="customer_name_edit" value="" required>
                                </div>

                                <div class="col-md-2">
                                    <label>Account Type <span class="required_Fields">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" style="width:100%;" name="account_type" id="account_type_edit" required>
                                        <option value="">Select Account Type</option>
                                        <option value="Saving">Savings Account</option>
                                        <option value="Current">Current Account</option>
                                        <option value="Fixed Deposit">Fixed Deposit Account</option>
                                        <option value="Recurring Deposit">Recurring Deposit Account</option>
                                        <option value="DEMAT">DEMAT Account</option>
                                        <option value="NRI">NRI Account</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-2" style="margin-top:10px;">
                                <input type="button" class="btn btn-primary" id="UpdateBankDetails" value="Update Customer A/C Details">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
           </div>
        </div>
    </div>
</div>

<script>
    function getPersonalDetails()
    {
        var lead_id = $('#lead_id').val();
        if(lead_id != "") {
            $.ajax({
                url : '<?= base_url("getPersonalDetails/") ?>'+lead_id,
                type : 'POST',
                dataType : "json",
                success : function(response){ 
                    $("#leadID").val(lead_id);
                    $("#borrower_name").val((response['leadDetails'].name=='')?'-':response['leadDetails'].name);
                    $("#borrower_mname").val((response['leadDetails'].middle_name=='')?'-':response['leadDetails'].middle_name);
                    $("#borrower_lname").val((response['leadDetails'].surname=='')?'-':response['leadDetails'].surname);
                    $("#gender").val((response['leadDetails'].gender=='')?'-':response['leadDetails'].gender);
                    $("#dob").val((response['leadDetails'].dob=='')?'-':response['leadDetails'].dob);
                    $("#pancard").val((response['leadDetails'].pancard=='')?'-':response['leadDetails'].pancard);
                    $("#mobile").val((response['leadDetails'].mobile=='')?'-':response['leadDetails'].mobile); 
                    $("#alternate_no").val((response['leadDetails'].alternateMobileNo=='')?'-':response['leadDetails'].alternateMobileNo);
                    $("#emailID").val((response['leadDetails'].email=='')?'-':response['leadDetails'].email);

                    $("#state, #city").empty();
                    $.each(response.state, function(index, myarr){
                        if(myarr.state_id == undefined){
                            $("#state").append('<option value="" >Select</option>'); 
                        }else{
                            $("#state").append('<option value="'+ myarr.state_id +'" '+ myarr.s +'>'+ myarr.state_name +'</option>');
                        }
                    });
                    
                    $.each(response.city, function(index, myarr){
                        if(myarr.city_id == undefined){
                            $("#city").append('<option value="" >Select</option>'); 
                        }else{
                            $("#city").append('<option value="'+ myarr.city_id +'" '+ myarr.s +'>'+ myarr.city_name +'</option>');
                        }
                    });
                    
                    // $.each(response.city, function(index, myarr){  
                    //     if(myarr.city == undefined){
                    //         $("#city").append('<option value="" >Select</option>'); 
                    //     }else{
                    //          $("#city").append('<option value="'+ myarr.city_name +'" '+ myarr.s +'>'+ myarr.city_name +'</option>');
                    //         //$("#city").append(response['citylistSelected']);
                    
                    //     }
                    // });

                    $("#pincode").val((response['leadDetails'].pincode=='')?'-':response['leadDetails'].pincode);
                    $("#lead_initiated_date").val(response['leadDetails'].created_on);
                    $("#alternateEmail").val((response['leadDetails'].alternateEmail=='')?'-':response['leadDetails'].alternateEmail);
                    $("#aadhar").val((response['leadDetails'].aadhar=='')?'-':response['leadDetails'].aadhar);
                    $("#residentialType").val((response['leadDetails'].residentialType=='')?'-':response['leadDetails'].residentialType);
                    $("#residential_proof").val((response['leadDetails'].residential_proof=='')?'-':response['leadDetails'].residential_proof);
                    $("#residence_address_line1").val((response['leadDetails'].residence_address_line1=='')?'-':response['leadDetails'].residence_address_line1);
                    $("#residence_address_line2").val((response['leadDetails'].residence_address_line2=='')?'-':response['leadDetails'].residence_address_line2);
                    
                    $("#presentAddressType").val((response['leadDetails'].residentialType=='')?'-':response['leadDetails'].residentialType);
                    $("#present_address_line1").val((response['leadDetails'].residence_address_line1=='')?'-':response['leadDetails'].residence_address_line1);
                    $("#present_address_line2").val((response['leadDetails'].residence_address_line2=='')?'-':response['leadDetails'].residence_address_line2);
                    //$("#isPresentAddress").attr('checked', true);
                      
                    
                    /*if(response['leadDetails'].isPresentAddress == "YES"){
                        $('#selectPresentAddress').hide();
                        $("#isPresentAddress").val(response['leadDetails'].isPresentAddress).attr('checked', true);
                    }else{
                        $('#selectPresentAddress').show();
                        $("#isPresentAddress").val(response['leadDetails'].isPresentAddress).attr('unchecked', false);
                    }
                    $("#presentAddressType").val(response['leadDetails'].presentAddressType);
                    $("#present_address_line1").val(response['leadDetails'].present_address_line1);
                    $("#present_address_line2").val(response['leadDetails'].present_address_line2); */
                    
                    $("#employer_business").val((response['leadDetails'].employer_business=='')?'-':response['leadDetails'].employer_business);
                    $("#office_address").val((response['leadDetails'].office_address=='')?'-':response['leadDetails'].office_address);
                    $("#office_website").val((response['leadDetails'].office_website=='')?'-':response['leadDetails'].office_website);
                    $('#residential_proof').empty();
                    $('#residential_proof').append(response['residential_proof']); 

                    var html = '<table class="table table-bordered">';
                        html += '<tbody>';
                        html += '<tr><th>Borrower Name</th><td>'+ response['leadDetails'].name +'</td><th>Middle Name</th><td>'+ ((response['leadDetails'].middle_name=='')?'-':response['leadDetails'].middle_name) +'</td></tr>';
                        html += '<tr><th>Surname</th><td>'+ ((response['leadDetails'].surname=='')?'-':response['leadDetails'].surname) +'</td><th>Gender</th><td>'+ ((response['leadDetails'].gender=='')?'-':response['leadDetails'].gender) +'</td></tr>';
                        html += '<tr><th>DOB</th><td>'+ ((response['leadDetails'].dob=='')?'-':response['leadDetails'].dob) +'</td><th>PAN</th><td>'+ ((response['leadDetails'].pancard=='')?'-':response['leadDetails'].pancard) +'</td></tr>';
                        html += '<tr><th>Mobile</th><td>'+ ((response['leadDetails'].mobile=='')?'-':response['leadDetails'].mobile) +'</td><th>Alternate Mobile</th><td>'+ ((response['leadDetails'].alternateMobileNo=='')?'-':response['leadDetails'].alternateMobileNo) +'</td></tr>';
                        html += '<tr><th>Email Id</th><td>'+ ((response['leadDetails'].email=='')?'-':response['leadDetails'].email) +'</td><th>State</th><td>'+ response['stateName'].state.toUpperCase() +'</td></tr>';
                        html += '<tr><th>City</th><td>'+response['cityName'].city.toUpperCase() +'</td><th>Pincode</th><td>'+ ((response['leadDetails'].pincode=='')?'-':response['leadDetails'].pincode) +'</td></tr>';
                        html += '<tr><th>Initiated On</th><td>'+ response['leadDetails'].created_on +'</td><th>Post Office</th><td>-</td></tr>';
                        html += '<tr><th>Alternate Email Id</th><td>'+ ((response['leadDetails'].alternateEmail=='')?'-':response['leadDetails'].alternateEmail) +'</td><th>Aadhar</th><td>'+((response['leadDetails'].aadhar=='')?'-':response['leadDetails'].aadhar) +'</td></tr>';
                        html += '<tr><th>Residence Type</th><td>'+ ((response['leadDetails'].residentialType.toUpperCase()=='')?'-':response['leadDetails'].residentialType.toUpperCase()) +'</td><th>Residential Proof</th><td>'+ ((response['leadDetails'].residential_proof.toUpperCase()=='')?'-':response['leadDetails'].residential_proof.toUpperCase()) +'</td></tr>';
                        html += '<tr><th>Residence Address Line 1</th><td>'+ ((response['leadDetails'].residence_address_line1.toUpperCase()=='')?'-':response['leadDetails'].residence_address_line1.toUpperCase()) +'</td><th>Residence Address Line 2</th><td>'+ ((response['leadDetails'].residence_address_line2.toUpperCase()=='')?'-':response['leadDetails'].residence_address_line2.toUpperCase()) +'</td></tr>';
                        html += '<tr><th>Present Address different from Residence Address ?</th><td colspan="3">'+ ((response['leadDetails'].isPresentAddress=='')?'-':response['leadDetails'].isPresentAddress) +'</td></tr>';
                        html += '<tr><th>Present Address</th><td>'+ ((response['leadDetails'].presentAddressType.toUpperCase()=='')?'-':response['leadDetails'].presentAddressType.toUpperCase()) +'</td><th></th><td></td></tr>';
                        html += '<tr><th>Present Address Line 1</th><td>'+ ((response['leadDetails'].present_address_line1.toUpperCase()=='')?'-':response['leadDetails'].present_address_line1) +'</td><th>Present Address Line 2</th><td>'+ ((response['leadDetails'].present_address_line2.toUpperCase()=='')?'-':response['leadDetails'].present_address_line2.toUpperCase()) +'</td></tr>';
                        html += '<tr><th>Employer/ Business name</th><td>'+ ((response['leadDetails'].employer_business.toUpperCase()=='')?'-':response['leadDetails'].employer_business.toUpperCase()) +'</td><th>Office Address</th><td>'+ ((response['leadDetails'].office_address.toUpperCase()=='')?'-':response['leadDetails'].office_address.toUpperCase()) +'</td></tr>';
                        html += '<tr><th>Office Website</th><td>'+ ((response['leadDetails'].office_website.toUpperCase()=='')?'-':response['leadDetails'].office_website.toUpperCase()) +'</td><th></th><td></td></tr>';
                        html += '</tbody>';
                        html += '</table>';

                    $('#ViewPersonalDetails').html(html);
                }
            });
        } else {
            catchError("Lead Id Not Found.");
        }
    }
    
    

    function getCam()
    {
        var lead_id = $('#lead_id').val();
        if(lead_id != "") {
            $.ajax({
                url : '<?= base_url("getCAMDetails/") ?>'+lead_id,
                type : 'POST',
                dataType : "json",
                success : function(response){
                    $(".leadID").val(lead_id);
                    $('#userType').val(response['camDetails'].userType);
                    $('#cibil').val(response['camDetails'].cibil);
                    $('#Active_CC').val(response['camDetails'].Active_CC);
                    $('#cc_statementDate').val(response['camDetails'].cc_statementDate);
                    $('#cc_paymentDueDate').val(response['camDetails'].cc_paymentDueDate);
                    $('#customer_bank_name').val(response['camDetails'].customer_bank_name);
                    // $('#account_type').val(response['camDetails'].account_type);
                    $('#account_type').empty();
                    var s = "";
                    if(response['camDetails'].account_type == "AMEX"){
                        s = 'selected';
                        $('#account_type').html('<option value="'+response['camDetails'].account_type+'" '+ s +'>'+response['camDetails'].account_type+'</option>');
                    }else{
                        var accountTypeArr = ['MASTER', 'VISA'];
                        $.each(accountTypeArr, function(index, arr){
                            s = "";
                            if(response['camDetails'].account_type == arr){
                                s = 'selected';
                            }
                            $('#account_type').append('<option value="'+arr+'" '+ s +'>'+arr+'</option>');
                        });
                    }

                    $('#customer_account_no').val(response['camDetails'].customer_account_no);
                    $('#customer_confirm_account_no').val(response['camDetails'].customer_confirm_account_no);
                    $('#customer_name').val(response['camDetails'].customer_name);
                    $('#cc_limit').val(response['camDetails'].cc_limit);
                    $('#cc_outstanding').val(response['camDetails'].cc_outstanding);
                    $('#max_eligibility').val(response['camDetails'].max_eligibility);

                    if(response['camDetails'].cc_name_Match_borrower_name == "YES"){
                        $('#cc_name_Match_borrower_name_YES').prop('checked', true);
                        $('#cc_name_Match_borrower_name_NO').prop('checked', false);
                    }else{
                        $('#cc_name_Match_borrower_name_YES').prop('checked', false);
                        $('#cc_name_Match_borrower_name_NO').prop('checked', true);
                    }

                    if(response['camDetails'].emiOnCard == "YES"){
                        $('#emiOnCard_YES').prop('checked', true);
                        $('#emiOnCard_NO').prop('checked', false);
                    }else{
                        $('#emiOnCard_YES').prop('checked', false);
                        $('#emiOnCard_NO').prop('checked', true);
                    }
                    
                    if(response['camDetails'].DPD30Plus == "YES"){
                        $('#DPD30Plus_YES').prop('checked', true);
                        $('#DPD30Plus_NO').prop('checked', false);
                    }else{
                        $('#DPD30Plus_YES').prop('checked', false);
                        $('#DPD30Plus_NO').prop('checked', true);
                    }

                    if(response['camDetails'].cc_statementAddress == "YES"){
                        $('#cc_statementAddress_YES').prop('checked', true);
                        $('#cc_statementAddress_NO').prop('checked', false);
                    }else{
                        $('#cc_statementAddress_YES').prop('checked', false);
                        $('#cc_statementAddress_NO').prop('checked', true);
                    }

                    if(response['camDetails'].last3monthDPD == "YES"){
                        $('#last3monthDPD_YES').prop('checked', true);
                        $('#last3monthDPD_NO').prop('checked', false);
                        $('#divhigherDPDLast3month').show();
                    }else{
                        $('#divhigherDPDLast3month').hide();
                        $('#last3monthDPD_YES').prop('checked', false);
                        $('#last3monthDPD_NO').prop('checked', true);
                    }

                    $('#higherDPDLast3month').val(response['camDetails'].higherDPDLast3month);


                    if(response['camDetails'].isDisburseBankAC == "YES"){
                        $('#isDisburseBankAC').prop('checked', true);
                        $('#customer_ifsc_code').html('<option value="'+ response['camDetails'].bankIFSC_Code +'">'+ response['camDetails'].bankIFSC_Code +'</option>');
                        $('#bank_name').val(response['camDetails'].bank_name);
                        $('#bank_branch').val(response['camDetails'].bank_branch);
                        $('#bankA_C_No').val(response['camDetails'].bankA_C_No);
                        $('#confBankA_C_No').val(response['camDetails'].confBankA_C_No);
                        $('#bankHolder_name').val(response['camDetails'].bankHolder_name);
                        $('#bank_account_type').val(response['camDetails'].bank_account_type);

                        $('#disbursalBankDetails').show();
                    }else{
                        $('#disbursalBankDetails').hide();
                        $('#isDisburseBankAC').prop('uncheck', false);
                        $('#bankIFSC_Code', '#bank_name', '#bank_branch', '#bankA_C_No', '#confBankA_C_No', '#bankHolder_name', '#bank_account_type').val('');
                    } 
                    var roi = 1; 
                    if(response['camDetails'].roi == '')
                    {
                        roi = response['camDetails'].roi;
                    }
                    $('#loan_applied').val(response['leadDetails'].loan_amount);
                    $('#loan_recomended').val(Math.round(response['leadDetails'].loan_amount));
                    $('#processing_fee').val(Math.round(response.adminFee));
                    // $('#processing_fee').val(response['leadDetails'].processing_fee);
                    $('#roi').val(roi);
                    $('#adminFeeWithGST').val(Math.round(response['camDetails'].adminFeeWithGST));
                    $('#net_disbursal_amount').val(Math.round(response['camDetails'].net_disbursal_amount));
                    $('#disbursal_date').val(response['camDetails'].disbursal_date);
                    $('#repayment_date').val(response['camDetails'].repayment_date);
                    $('#tenure').val(response['camDetails'].tenure);
                    $('#repayment_amount').val(Math.round(response['camDetails'].repayment_amount));
                    $('#special_approval').val(response['camDetails'].special_approval);
                    $('#deviationsApprovedBy').val(response['camDetails'].deviationsApprovedBy);
                    $('#changeROI').val(response['camDetails'].changeROI);
                    $('#changeFee').val(response['camDetails'].changeFee);
                    $('#changeLoanAmount').val(response['camDetails'].changeLoanAmount);
                    $('#changeTenure').val(response['camDetails'].changeTenure);
                    $('#changeRTR').val(response['camDetails'].changeRTR);
                    $('#remark').val(response['camDetails'].remark);
                    var status = $('#status').val();

                    var html = '<table class="table table-bordered">';
                        html += '<tbody>';
                        html += '<tr><th>User Type</th><td>'+ response['camDetails'].userType +'</td><th>Status</th><td>'+ status +'</td></tr>';
                        html += '<tr><th>CIBIL Score</th><td>'+ response['camDetails'].cibil +'</td><th>No of Active CC</th><td>'+ response['camDetails'].Active_CC +'</td></tr>';
                        html += '<tr><th>CC Bank</th><td>'+ response['camDetails'].customer_bank_name +'</td><th>CC Type</th><td>'+ response['camDetails'].account_type +'</td></tr>';
                        html += '<tr><th>CC No.</th><td>'+ response['camDetails'].customer_account_no +'</td><th>Confirm CC No.</th><td>'+ response['camDetails'].customer_confirm_account_no +'</td></tr>';
                        html += '<tr><th>CC Statement Date.</th><td>'+response['camDetails'].cc_statementDate +'</td><th>CC Payment Due Date.</th><td>'+ response['camDetails'].cc_paymentDueDate +'</td></tr>';
                        html += '<tr><th>CC Limit</th><td>'+ response['camDetails'].cc_limit +'</td><th>CC Outstanding</th><td>'+ response['camDetails'].cc_outstanding +'</td></tr>';
                        html += '<tr><th>Name As on Card</th><td>'+ response['camDetails'].customer_name +'</td><th>Max Eligibility</th><td>'+ response['camDetails'].max_eligibility +'</td></tr>';
                        html += '<tr><th>CC Name matches with Borrower Name ?</th><td colspan="3">'+ response['camDetails'].cc_name_Match_borrower_name +'</td></tr>';
                        html += '<tr><th>EMI on Card ?</th><td colspan="3">'+ response['camDetails'].emiOnCard +'</td></tr>';
                        html += '<tr><th>30+ DPD in last 3 mths in any CC ?</th><td colspan="3">'+ response['camDetails'].DPD30Plus +'</td></tr>';
                        html += '<tr><th>CC Statement Address same as Present address ?</th><td colspan="3">'+ response['camDetails'].cc_statementAddress +'</td></tr>';
                        html += '<tr><th>DPD On CC in Last 3 months</th><td colspan="3">'+ response['camDetails'].last3monthDPD +'</td></tr>';
                        // html += '<tr><th>Disburse to Bank Account ?</th><td colspan="3">'+ response['camDetails'].higherDPDLast3month +'</td></tr>';
                        html += '<tr><th>Is Disburse to Bank Account ?</th><td colspan="3">'+ response['camDetails'].isDisburseBankAC +'</td></tr>';
                        html += '<tr><th>IFSC Code</th><td colspan="3">'+ response['camDetails'].bankIFSC_Code +'</td></tr>';
                        html += '<tr><th>Bank Name</th><td>'+ response['camDetails'].bank_name +'</td><th>Bank Branch</th><td>'+ response['camDetails'].bank_branch +'</td></tr>';
                        html += '<tr><th>A/C No.</th><td>'+ response['camDetails'].bankA_C_No +'</td><th>Confirm A/C No.</th><td>'+ response['camDetails'].confBankA_C_No +'</td></tr>';
                        html += '<tr><th>A/C Holder Name</th><td>'+ response['camDetails'].bankHolder_name +'</td><th>Account Type</th><td>'+ response['camDetails'].bank_account_type +'</td></tr>';
                        html += '<tr><th>Loan Applied</th><td>'+ response['camDetails'].loan_applied +'</td><th>Loan Recommended</th><td>'+ response['camDetails'].loan_recomended +'</td></tr>';
                        html += '<tr><th>Admin Fee</th><td>'+ response['camDetails'].processing_fee +'</td><th>ROI (%)</th><td>'+ response['camDetails'].roi +'</td></tr>';
                        html += '<tr><th>Admin Fee with GST (18 %)</th><td>'+ response['camDetails'].adminFeeWithGST +'</td><th>Net Disbursal Amount</th><td>'+ response['camDetails'].net_disbursal_amount +'</td></tr>';
                        html += '<tr><th>Disbursal Date</th><td>'+ response['camDetails'].disbursal_date +'</td><th>Repayment Date</th><td>'+ response['camDetails'].repayment_date +'</td></tr>';
                        html += '<tr><th>Tenure (days)</th><td>'+ response['camDetails'].tenure +'</td><th>Repayment Amount</th><td>'+ response['camDetails'].repayment_amount +'</td></tr>';
                        html += '<tr><th>Reference</th><td>'+ response['camDetails'].special_approval +'</td><th>Deviations Approved By</th><td>'+ response['camDetails'].deviationsApprovedBy +'</td></tr>';
                        html += '<tr><th>Change in ROI : </th><td colspan="3">'+ response['camDetails'].changeROI +'</td></tr>';
                        html += '<tr><th>Change in Fees : </th><td colspan="3">'+ response['camDetails'].changeFee +'</td></tr>';
                        html += '<tr><th>Higher Loan amount : </th><td colspan="3">'+ response['camDetails'].changeLoanAmount +'</td></tr>';
                        html += '<tr><th>Tenor more than norms : </th><td colspan="3">'+ response['camDetails'].changeTenure +'</td></tr>';
                        html += '<tr><th>Poor RTR with CC : </th><td colspan="3">'+ response['camDetails'].changeRTR +'</td></tr>';
                        html += '<tr><th>Note</th><td colspan="3">'+ response['camDetails'].remark +'</td></tr>';

                        html += '</tbody>';
                        html += '</table>';

                    $('#ViewCAMDetails').html(html);
                }
            });
        } else {
            catchError("Lead Id Not Found.");
        }
    }
    
    $(document).ready(function(){

        $('#state').change(function() {
            var state_id = $(this).val();
            if (state_id != '') {
                $.ajax({
                    url: "<?= base_url('getCity/'); ?>" +state_id,
                    type: "POST",
                    dataType : "json",
                    success: function(response) {
                        $("#city").empty();
                        $("#city").append('<option value="">Select</option>');
                        $.each(response.city, function(index, myarr) { 
                            $("#city").append('<option value="'+ myarr.city +'">'+ myarr.city +'</option>');
                        });
                    }
                });
            } else {
                $('#city').html('<option value="">Select City</option>');
            }
        });

        $('#roi').change(function(){
            var roi = $(this).val();
            if(roi == 1){
                $(this).val(1);
                $("#changeROI").val('NO').css('color', '#000');
            }else if(roi <= 0){
                $(this).val(1);
                $("#changeROI").val('NO').css('color', '#000');
            }else{
                $("#changeROI").val('YES').css('color', 'red');
            }
        });
        
        $('#loan_recomended').change(function(){
            var loan_applied = $("#loan_applied").val();
            var loan_recomended = $(this).val();
            
            if(loan_recomended <= loan_applied)
            {
                var processing_fee = ((loan_recomended * 2) / 100);
                $("#processing_fee").val(Math.round(processing_fee));
                var gst = ((processing_fee * 100) / 118);
                var newGST = (processing_fee + (processing_fee - gst));
                var adminfeegst = parseFloat(newGST).toFixed(2);
                $("#adminFeeWithGST").val(Math.round(adminfeegst));


                if(loan_recomended == loan_applied){
                    $(this).val(loan_applied);
                    $("#changeLoanAmount").val('NO').css('color', '#000');
                }else if(loan_recomended > loan_applied){
                    $(this).val(loan_applied);
                    $("#changeLoanAmount").val('NO').css('color', '#000');
                }else if(loan_recomended <= 0){
                    $(this).val(loan_applied);
                    $("#changeLoanAmount").val('NO').css('color', '#000');
                }else{
                    $("#changeLoanAmount").val('YES').css('color', 'red');
                }
                net_disbursal_amount(loan_recomended, adminfeegst);
            }else{
                
                $("#loan_recomended").val(Math.round(loan_applied));
            }
        });
        
        // $('#processing_fee').change(function(){
            
        // });
        
        $('#processing_fee_percent').change(function(){
            var admin_fee_percent = $(this).val();
            var loan_applied = $("#loan_applied").val();
            var loan_recomended = $('#loan_recomended').val();    
            
            var admin_fee = ((loan_recomended*admin_fee_percent)/100).toFixed(2);
            var gst = ((admin_fee * 100) / 118);
            var newGST = parseFloat(admin_fee) + parseFloat(admin_fee - gst);
            var disubrsal_amnt = loan_recomended-admin_fee;
            
            $("#processing_fee").val(Math.round(admin_fee));
            var amountwithgst = parseFloat(newGST).toFixed(2);
            $("#adminFeeWithGST").val(Math.round(amountwithgst));
            $("#net_disbursal_amount").val(Math.round(disubrsal_amnt));
            
        });
        
        
        
        $('#processing_fee').change(function(){
            var processing_fee = $(this).val();
            var loan_recomended = $('#loan_recomended').val();

            var gst = ((processing_fee * 100) / 118);
            var newGST = parseFloat(processing_fee) + parseFloat(processing_fee - gst);
            $("#adminFeeWithGST").val('');
            var adminfeewithGst = parseFloat(newGST).toFixed(2);
            $("#adminFeeWithGST").val(Math.round(adminfeewithGst));
            
            var adminfeePer = ((processing_fee * 100) / loan_recomended); //processing_fee_percent
            $("#processing_fee_percent").val(adminfeePer.toFixed(2));

            if(processing_fee <= 0){
                $(this).val(processing_fee);
                $("#changeFee").val('NO').css('color', '#000');
            }else{
                $("#changeFee").val('YES').css('color', 'red');
            }
            net_disbursal_amount(loan_recomended, newGST);
        });
        
        $('#aadhar').keyup(function() {
            $(this).attr("maxLength", "14");
            var value = $(this).val();
            value = value.replace(/\D/g, "").split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join(" ");
            $(this).val(value);
        });
            
        $('#sameResidenceAddress').click(function(){
            var sameAddress = $(this).val();
            var residence_address = $("#residence_address").val();
            if($(this).is(":checked")){
                $('#office_address').val(residence_address);
            }else{
                $('#office_address').val('');
            }
        });

        $('#isPresentAddress').click(function(){
        
            if($(this).is(":checked")){
                $('#present_address').hide();
                var residence_address_line1 = $("#residence_address_line1").val();
                var residence_address_line2 = $("#residence_address_line2").val();
                //isAddressLine_1_or_2(residence_address_line1, residence_address_line2);
            }else{
                $('#present_address').show();
            }
            
        });

        $("input[name=last3monthDPD]").click(function(){
            var selValueByClass = $(".last3monthDPD:checked").val();
            if(selValueByClass == "YES"){
                $('#divhigherDPDLast3month').show().attr('margin-top', '0px');
            }else{
                $('#divhigherDPDLast3month').hide().attr('margin-top', '10px');
            }
        });

        $('#isDisburseBankAC').attr('unchecked', true);
        $('#disbursalBankDetails').hide();
        $("#isDisburseBankAC").click(function(){
            var isDisburseBankAC = $("#isDisburseBankAC:checked").val();
            if(isDisburseBankAC == "YES"){
                $('#disbursalBankDetails').show();
            }else{
                $('#disbursalBankDetails').hide();
            }
        });

        $('#residence_address_line1').on('change', function(){
            var residence_address_line1 = $(this).val();
            var residence_address_line2 = $("#residence_address_line2").val();
            isAddressLine_1_or_2(residence_address_line1, residence_address_line2);
        });

        $('#residence_address_line2').on('change', function(){
            var residence_address_line1 = $("#residence_address_line1").val();
            var residence_address_line2 = $(this).val();
            isAddressLine_1_or_2(residence_address_line1, residence_address_line2);
        });

        $('#cc_limit').keyup(function(e){
            if (/\D/g.test(this.value))
            {
                this.value = this.value.replace(/\D/g, '');
            }
        });

        $('#cc_outstanding').val(0);
        $('#cc_limit').val(0);
        $('#max_eligibility').val(0);

        $('#cc_limit').on('change', function(){
            var cc_limit = $(this).val();
            var cc_outstanding = $('#cc_outstanding').val();
            max_eligibility(cc_limit, cc_outstanding);
        });

        $('#cc_outstanding').on('change', function(){
            var cc_outstanding = $(this).val();
            var cc_limit = $('#cc_limit').val();
            max_eligibility(cc_limit, cc_outstanding);
        });

        $('#disbursal_date').on('change', function(){
            var disbursal_date = $(this).val();
            var repayment_date = $('#repayment_date').val();
            tenureAndRepaymentAmount(disbursal_date, repayment_date);
        });

        $('#repayment_date').on('change', function(){
            var repayment_date = $(this).val();
            var disbursal_date = $('#disbursal_date').val();
            tenureAndRepaymentAmount(disbursal_date, repayment_date);
        });

        var lengthCount = 0;
        $('#customer_account_no, #customer_confirm_account_no').keyup(function() {
            
            var account_type = $('#account_type').val();
            if(lengthCount == 0){
                catchError('Please select CC Bank Name.');
                $(this).val('');
            }else if(account_type == ""){
                catchError('Please select CC Type.');
                $(this).val('');
            }else{
                if(lengthCount == 19){
                    $(this).attr("maxLength", lengthCount);
                    var value = $(this).val();
                    value = value.replace(/\D/g, "").split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join(" ");
                    $(this).val(value);
                }else{
                    $(this).attr("maxLength", lengthCount);
                    var value = $(this).val();
                    value = value.replace(/^(.{4})(.{6})(.{4})$/, "$1 $2 $3");
                    $(this).val(value);
                }
            }
        });

        $('#customer_bank_name').on('change', function(){
            lengthCount = 0;
            $('#customer_account_no, #customer_confirm_account_no').val('');
            var customer_bank_name = $(this).val();
            if(customer_bank_name == "American Express"){
                var account_type = $('#account_type').val();
                if(account_type != "AMEX"){
                    lengthCount = 17;
                    $('#account_type').html('<option value="AMEX">AMEX</option>');
                }
            }else{
                lengthCount = 19;
                $('#account_type').html('<option value="">Select</option><option value="Master">Master</option><option value="Visa">Visa</option>');
            }
            var disbursal_date = $('#disbursal_date').val();
            tenureAndRepaymentAmount(disbursal_date, repayment_date);
        });

        $('#customer_name').on('change', function(){
            var customer_name = $(this).val();
            var borrower_name = $("#borrower_name").val();
            if(customer_name == borrower_name){
                var account_type = $('#account_type').val();
                $('#cc_name_Match_borrower_name_YES').prop('checked', true);
                $('#cc_name_Match_borrower_name_NO').prop('unchecked', false);
                $('#thumb_cc_name_Match_borrower_name').html('<i class="fa fa-thumbs-o-up" style="color : green; font-size : 18px;"></i>');
            }else{
                $('#cc_name_Match_borrower_name_YES').prop('unchecked', false);
                $('#cc_name_Match_borrower_name_NO').prop('checked', true);
                $('#thumb_cc_name_Match_borrower_name').html('<i class="fa fa-thumbs-o-down" style="color : red; font-size : 18px;"></i>');
            }
            var disbursal_date = $('#disbursal_date').val();
            tenureAndRepaymentAmount(disbursal_date, repayment_date);
        });

        $('#bankA_C_No, #confBankA_C_No').keyup(function() {
            $(this).attr("maxLength", "19");
            var value = $(this).val();
            value = value.replace(/\D/g, "").split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join(" ");
            $(this).val(value);
        });

        $('#saveCustomerDetails').on('click', function(){
            var FormSaveCustomerRecord = $('#FormSaveCustomerRecord').serialize();
            $.ajax({
                url : '<?= base_url("saveCustomerPersonalDetails") ?>',
                type : 'POST',
                dataType : "json",
                data : FormSaveCustomerRecord,
                beforeSend: function() {
                    $('#saveCustomerDetails').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
                },
                success : function(response){
                    if(response.msg){
                        catchSuccess(response.msg);
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#saveCustomerDetails').html('Save').prop('disabled', false);
                },
            });
        });

    });

    function net_disbursal_amount(loan_recomended, processing_feeWithGST) {
        return $('#net_disbursal_amount').val(Math.round(loan_recomended - processing_feeWithGST));
    }

    function tenureAndRepaymentAmount(disbursal_date, repayment_date)
    {
        if(disbursal_date != "" && repayment_date != "") 
        {
            var start = moment(disbursal_date, "DD-MM-YYYY");
            var future = moment(repayment_date, "DD-MM-YYYY");
            var tenure = future.diff(start, 'days'); // 9

            var loan_recomended = $('#loan_recomended').val();
            var roi = $('#roi').val();
            var repayment_amount = parseFloat(loan_recomended) + parseFloat((loan_recomended * roi * tenure) / 100);

            $('#tenure').val(tenure);
            $('#repayment_amount').val(Math.round(repayment_amount));
        }
    }

    function max_eligibility(cc_limit, cc_outstanding)
    {
        if(parseInt(cc_limit) > parseInt(cc_outstanding)){
            $('#max_eligibility').val(cc_outstanding);
        }else{
            $('#max_eligibility').val(cc_limit);
        }
    }

    function isAddressLine_1_or_2(residence_address_line1, residence_address_line2)
    {
        if($("#isPresentAddress").is(":checked")){
            $("#isPresentAddress").val('YES');
            $('#selectPresentAddress').hide();
            $("#present_address_line1").val(residence_address_line1);
            $("#present_address_line2").val(residence_address_line2);
        } else {
            $("#isPresentAddress").val('NO');
            $('#selectPresentAddress').show();
            $("#present_address_line1").val('');
            $("#present_address_line2").val('');
        }
    }
    
    function customer_confirm_bank_ac_no(acc_no2)
    {
        var acc1 = $("#bankA_C_No").val();
        var acc2 = $(acc_no2).val();

        if(acc1 === acc2){
            $("#bankA_C_No, #confBankA_C_No").css('border-color', '#aaa');
            return true;
        }else{
            $("#bankA_C_No, #confBankA_C_No").val('').css('border-color', 'red');
            $("#bankA_C_No").focus();
            
            catchError('Invalid Bank A/C no.');
        }
    }

</script>
<script>
    $(document).ready(function(){
        $('#btnFormSaveCAM').click(function(){
            var camFormData = $('#FormSaveCAM').serialize();
            
            $.ajax({
                url : '<?= base_url("saveCAMDetails") ?>',
                type : 'POST',
                dataType : "json",
                data : camFormData,
                beforeSend: function() {
                    $('#btnFormSaveCAM').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
                },
                success : function(response){
                    if(response.msg){
                        catchSuccess(response.msg);
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#btnFormSaveCAM').html('Save').prop('disabled', false);
                },
            });
        });

        $('#LeadRecommend').on('click', function(){
            var formDataLeadRecommend = $('#FormSaveCAM').serialize();
            $.ajax({
                url : '<?= base_url("LeadRecommendation") ?>',
                type : 'POST',
                dataType : "json",
                data : formDataLeadRecommend,
                beforeSend: function() {
                    $('#LeadRecommend').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
                },
                success : function(response){
                    if(response.msg){
                        catchSuccess(response.msg);
                        location.reload();
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#LeadRecommend').html('Recomend').prop('disabled', false);
                },
            });
        });

        $('#btnSendBack').on('click', function(){
            var lead_id = $('#lead_id').val();
            $.ajax({
                url : '<?= base_url("reEditCAM/") ?>'+lead_id,
                type : 'POST',
                dataType : "json",
                beforeSend: function() {
                    $('#btnSendBack').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
                },
                success : function(response){
                    if(response.msg){
                        catchSuccess(response.msg);
                        location.reload();
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#btnSendBack').html('Send Back').prop('disabled', false);
                },
            });
        });

        $('#btnCAM_Approve').on('click', function(){
            var lead_id = $('#lead_id').val();
            $.ajax({
                url : '<?= base_url("headCAMApproved/") ?>'+lead_id,
                type : 'POST',
                dataType : "json",
                beforeSend: function() {
                    $('#btnCAM_Approve').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
                },
                success : function(response){
                    if(response.msg){
                        catchSuccess(response.msg);
                        location.reload();
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#btnCAM_Approve').html('Sanction').prop('disabled', false);
                },
            });
        });

        $('#formUpdateReferenceNo').submit(function(e) {
            var lead_id = $('#leadIdForDocs').val();
            e.preventDefault();

            $.ajax({
                url : '<?= base_url("UpdateDisburseReferenceNo") ?>',
                type : 'POST',
                data:new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
                dataType : 'json',
                beforeSend: function() {
                    $('#updateReferenceNo').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Processing...');
                },
                success : function(response) {
                    if(response.msg) {
                        catchSuccess(response.msg);
                        location.reload();
                    } else {
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#updateReferenceNo').html('Update Reference');
                    // .removeClass('disabled'); 
                },
            });
        });
    });
</script>
