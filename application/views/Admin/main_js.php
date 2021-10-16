<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<script> 
    var csrf_token = $("input[name=csrf_token]").val();
    
    function dashbMenuPermission(checkList, user_id)
    {
        $.ajax({
            url : '<?= base_url("admin/dashboardMenuPermission/") ?>'+ user_id,
            type : 'POST',
            dataType : "json",
            async : false,
            data : {checkList : checkList, csrf_token},
            success : function(response) {
                if(response.err){
                    catchError(response.err);
                }
                if(response.msg){
                    catchSuccess(response.msg);
                }
                var i = 0;
                $.each(response['menuMaster'], function(index, myarr){
                    $("#dashboardMenuPermission").find("option[value="+response['menuPermitted'][i].menu_id+"]").prop("selected", "selected");
                    i++;
                });
            }
        });
    }
    var currentCheckList = [];
    function dashboardMenuPermission(currentCheck)
    {
        var menu_id = $('#dashboardMenuPermission').find(":selected").val();
        var checkList = $('#dashboardMenuPermission').val();
        var permission = 0;
        if(menu_id){
          permission = 1;
        }
        currentCheckList.push(permission);
        // console.log(checkList);
        var data = [{'checkList' : checkList, 'permission' : permission}];
        return data;
    }
    $(document).ready(function(){
        var List = "";
        dashbMenuPermission(List, <?= $this->uri->segment(2) ?>);
        $("#btnSubmit").click(function(){
            // var d = dashboardMenuPermission(currentCheck);
            // console.log(d);
            var checkList = $('#dashboardMenuPermission').val();
            dashbMenuPermission(checkList, <?= $this->uri->segment(2) ?>);
        });
        
    });

    
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

    function repaymentLoanDetails(lead_id, customer_id)
    {
        getCAMDetails($lead_id);
        // $.ajax({
        //     url : '<?= base_url("repaymentLoanDetails/") ?>'+lead_id,
        //     type : 'POST',
        //     dataType : "json",
        //     data : {customer_id : customer_id, csrf_token},
        //     beforeSend: function() {
        //         $('#PayAmountToCustomer').html('<span class="spinner-border spinner-border-sm" role="status"></span>Processing...').addClass('disabled');
        //     },
        //     success: function(response) {
        //         catchSuccess(response);
        //         $("#PayAmountToCustomer").addClass("disabled", true);
        //     },
        //     complete: function() {
        //         $('#PayAmountToCustomer').html('Pay To Customer').removeClass('disabled');
        //     }
        // });
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