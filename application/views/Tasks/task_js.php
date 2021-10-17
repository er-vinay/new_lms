<?php $this->load->view('Layouts/header') ?>
<?php 
    $url =  $this->uri->segment(1); 
?>

<div class="width-my">
    <div class="container-fluid">
        <div class="taskPageSize taskPageSizeDashboard" style="height:auto !important;">
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
                <div class="row sushil-hight">
                <div class="col-md-8 col-sm-offset-2">
                    <div class="tab" role="tabpanel">
                        <input type="hidden" name="lead_id" id="lead_id" value="<?= $leadDetails->lead_id ?>" readonly>
                        <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['isUserSession']['user_id'] ?>" readonly>
                        <ul class="nav nav-tabs" role="tablist">
                            
                            <li role="presentation" class="borderList"><a href="#LeadSaction" onclick="getLeadsDetails(<?= $leadDetails->lead_id ?>)" aria-controls="lead" role="tab" data-toggle="tab">Lead</a></li>
                            <?php if(agent == "CR1") { ?>
                            <li role="presentation" class="borderList"><a href="#ApplicationSaction" onclick="modifyLeadsDetails(<?= $leadDetails->lead_id ?>)" aria-controls="lead" role="tab" data-toggle="tab">Application</a></li>
                            <?php } if(agent == "CR2" || agent == "CR3"|| agent == "CO1" || agent == "AC1" || agent == "CA" || agent == "SA" || agent == "DS1" || $url == "search"){ ?>
                            <li role="presentation" class="borderList"><a href="#DocumentSaction" aria-controls="Document" role="tab" data-toggle="tab">Documents</a></li>
                            
                            <li role="presentation" class="borderList"><a href="#PersonalDetailSaction" onclick="getPersonalDetails(<?= $leadDetails->lead_id ?>)" aria-controls="Personal" role="tab" data-toggle="tab">Personal</a></li>

                            <li role="banking" class="borderList"><a href="#BankingDetailSaction" onclick="getCustomerBanking('<?= $leadDetails->customer_id ?>')" aria-controls="Banking" role="tab" data-toggle="tab">Banking</a></li>

                            <li role="presentation" class="borderList"><a href="#Verification" aria-controls="Verification" role="tab" data-toggle="tab" >Verification</a></li> 
                            
                            <li role="presentation" class="borderList "><a href="#CAMSheetSaction" onclick="getCam(<?= $leadDetails->lead_id ?>)" aria-controls="messages" role="tab" data-toggle="tab">CAM</a></li>
                            
                            <?php } if(agent == "DS1" 
                                || agent == "CO1" 
                                || agent == "AC1" 
                                || agent == "CA" 
                                || agent == "SA" 
                                || $url == "search"){ ?>
                            <li role="presentation" class="borderList"><a href="#DisbursalSaction" onclick="disbursalDetails('<?= $leadDetails->lead_id ?>', '<?= $leadDetails->customer_id ?>', '<?= user_id ?>')" aria-controls="messages" role="tab" data-toggle="tab">Disbursal</a></li>
                            
                            <?php } if(agent == "AC1" 
                                || agent == "CO1" 
                                || agent == "AC1" 
                                || agent == "CA" 
                                || agent == "SA" 
                                || $url == "search"){ ?>
                            <li role="presentation" class="borderList"><a href="#CollectionSaction" aria-controls="messages" role="tab" data-toggle="tab">Collection</a></li>

                            <li role="presentation" class="borderList"><a href="#RepaymentSaction" onclick="repaymentLoanDetails('<?= $leadDetails->lead_id ?>', '<?= $leadDetails->customer_id ?>', '<?= user_id ?>')" aria-controls="messages" role="tab" data-toggle="tab">Repayment</a></li>
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
                                    <?php if(agent == "CR1" 
                                        || agent == "CR2"
                                        || agent == "CA"
                                        || agent == "SA") : ?>
                                    <div id="btndivCheckCibil">
                                        <div id="checkCustomerCibil" style="background:#fff !important;">
                                            <a href="#" class="btn btn-primary" id="btnCheckCibil" onclick="checkCustomerCibil()">Check CIBIL</a>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div id="cibilStatement"></div>
                                </div>
                            </div> 

                            <div role="tabpanel" class="tab-pane fade" id="ApplicationSaction">
                                <div>
                                    <?php $this->load->view('Tasks/application'); ?>
                                </div>
                            </div>
                            
                            <div role="tabpanel" class="tab-pane fade" id="DocumentSaction"> 
                                <input type="hidden" name="leadIdForDocs" id="leadIdForDocs"> 
                                <div id="documents" class="show">
                                    <div id="btndivUploadDocs">
                                    <?php if(agent == "CR2" || agent == "CA") { ?>
                                        <div style="background:#fff !important;">
                                            <button class="btn btn-primary" style="background:#ddd !important; color: #000 !important; border: none;" id="sendRequestToCustomerForUploadDocs" onclick="sendRequestToCustomerForUploadDocs()" disabled>Send Request For Upload Docs</button>
                                            <p id="selectDocsTypes" style="text-transform:uppercase; margin-top:20px;padding-left: 10px;padding-bottom: 15px;">
                                                <?php $i = 1; foreach ($docs_master->result() as $row) : ?>
                                                <label class="radio-inline">
                                                    <input type="radio" name="selectdocradio" id="selectdocradio<?= $i ?>" value="<?= $row->docs_type ?>">&nbsp;<?= $row->docs_type ?>  
                                                </label>
                                                <?php $i++; endforeach; ?>
                                            </p>
                                        </div>   
                                        <div class="row" id="docsform">
                                            <?php $this->load->view('Document/docs'); ?>
                                        </div> 
                                    <?php } //else { ?>
                                        <div class="footer-support">
                                            <h2 class="footer-support" style="margin-top: 0px;">
                                                <button type="button" class="btn btn-info collapse" onclick="getCustomerDocs(<?= $leadDetails->lead_id ?>, '<?= $leadDetails->customer_id ?>')" data-toggle="collapse" data-target="#Uploaded-Documents">Uploaded Documents&nbsp;<i class="fa fa-angle-double-down"></i></button>
                                            </h2>
                                        </div>
                                        <div id="Uploaded-Documents" class="collapse" style="background: #fff !important;">
                                            <div id="docsHistory"></div>
                                        </div> 
                                    <?php //} ?>
                                    </div> 
                                </div>  
                            </div>
                                 
                            <div role="tabpanel" class="tab-pane fade" id="PersonalDetailSaction">
                                <div style="border : solid 1px #ddd;margin-bottom: 20px; background: #fff;">
                                    <?php $this->load->view('Personal/personal'); ?>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="BankingDetailSaction">
                                <div style="border : solid 1px #ddd;margin-bottom: 20px; background: #fff;">
                                    <?php $this->load->view('Disbursal/banking'); ?>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="Verification">
                                <div id="divVerification">
                                    <?php //$this->load->view('Verification/verification'); ?>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="CAMSheetSaction">
                                <a class="btn btn-primary" href="#" id="urlViewCAM" target="_blank" title="View" style="width: 30px;height: 30px;padding: 5px 0px 0px 0px;"><i class="fa fa-eye"> </i>
                                </a>
                                <a class="btn btn-primary" href="#" id="urlDownloadCAM" style="width: 30px;height: 30px;padding: 5px 0px 0px 0px;"><i class="fa fa-download"></i>
                                </a>
                                <div class="camBorder">
                                    <div id="divCamDetails">
                                        <?php 
                                            if(company_id == 1 && product_id == 1){
                                                $this->load->view('CAM/camPayday'); 
                                            } 
                                            if(company_id == 1 && product_id == 2){ 
                                                 $this->load->view('CAM/camLAC'); 
                                            } 
                                        ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div role="tabpanel" class="tab-pane fade" id="DisbursalSaction">
                                <div id="disbursal">
                                    <?php $this->load->view('Disbursal/disbursal'); ?>
                                </div>
                            </div>
                            
                            <div role="tabpanel" class="tab-pane fade" id="RepaymentSaction">
                                <div id="repay">
                                    <?php $this->load->view('Collection/repayment'); ?>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="CollectionSaction">
                                <div id="collection">
                                    <?php $this->load->view('Collection/collection'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button disabled style="background: #fff;border: none;"></button> 
                            <input type="hidden" name="customer_id" id="customer_id" value="<?= $leadDetails->customer_id ?>">
                            <input type="hidden" name="status" id="status" value="<?= $leadDetails->status ?>">
                            <input type="hidden" name="stage" id="stage" value="<?= $leadDetails->stage ?>">
                            
                            <?php if((agent == "CR1" || agent == "CR2" || agent == "CA" || agent == "SA") || (agent == "CR3" && $leadDetails->stage == "S10")) { ?>
                            <div id="btndivReject1">  
                                <div calss="row" style="border-top: solid 1px #ddd;text-align: center; padding-top : 20px; padding-bottom: 20px; background: #f3f3f3; overflow: auto;">
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-success reject-button" onclick="RejectedLoan()">Reject</button>
                                        <?php if(agent == 'CR1' || agent == 'CR2') { ?>
                                        <button class="btn btn-success lead-hold-button" onclick="holdLeadsRemark()">Hold</button>
                                        <button class="btn btn-success lead-sanction-button" onclick="leadRecommendation()" ?>Recommend</button>
                                        <?php } else if(agent == 'CR3'){ ?>
                                            <button class="btn btn-success" id="btn_send_back" onclick="leadSendBack('<?= $leadDetails->lead_id ?>', '<?= user_id ?>', '<?= $leadDetails->customer_id ?>')">Send Back</button>
                                        <?php } if(agent == 'CR2' || agent == 'CR3'){ ?>
                                            <button class="btn btn-primary lead-sanction-button" style="background : #0a5e90 !important;" onclick="sanctionleads('<?= $leadDetails->lead_id ?>', '<?= user_id ?>', '<?= $leadDetails->customer_id ?>')">Sanction</button>
                                        <?php } ?>
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
                                     <!-- <div class="col-md-3 text-left">&nbsp;</div> -->
                                    <div class="col-md-7 text-left">
                                      <input type="text" class="form-control inputField" name="remark" id="hold_remark" placeholder="Enter Remarks" style="width:100% !important;">
                                    </div> 
                                    
                                    <div class="col-md-3 text-left">
                                      <input type="datetime-local" class="form-control inputField" name="holdDurationDate" id="holdDurationDate" placeholder="Enter Remarks" style="width:100% !important;">
                                    </div>
                                    
                                    <div class="col-md-2 text-left">
                                        <button class="btn btn-primary" id="btnRejectApplication" onclick="saveHoldleads(<?= $leadDetails->lead_id ?>)">Lead Hold</button>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                                        <!-- <div calss="row" style="border-top: solid 1px #ddd;text-align: center; padding-top : 20px; padding-bottom: 20px; background: #f3f3f3;">
                                            <div calss="col-md-12 text-center">
                                                <button class="btn btn-primary" id="btnFormSaveCAM" style="text-align: center; padding-left: 50px; padding-right: 50px; font-weight: bold;height: 42px;">Save</button>
                                                <button class="btn btn-success reject-button" onclick="RejectedLoan()">Reject</button>
                                                <button class="btn btn-success lead-hold-button" onclick="holdLeadsRemark()">Hold</button>
                                                <button class="btn btn-success lead-sanction-button" onclick="LeadRecommendation()">Recommend</button>
                                            </div>  
                                        </div> -->
                                        <?php if($_SESSION['isUserSession']['role'] == creditManager){ ?>
                                            <!-- <div id="divExpendReason" class="marging-footer-verifa">
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
                                                        <button class="btn btn-primary" id="btnRejectApplication" onclick="saveHoldleads(<?= $leadDetails->lead_id ?>)">Hold Application</button>
                                                    </div>
                                                </div>
                                            </div> -->
                                        <?php } ?>
                                        <!-- <span id="ResonBoxForHold"></span> -->
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('Layouts/footer') ?>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<script> 
    var csrf_token = $("input[name=csrf_token]").val();
</script>