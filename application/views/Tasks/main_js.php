
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<script>
    var csrf_token = $("input[name=csrf_token]").val();
    	$(".js-select2").select2({
			closeOnSelect : false,
			placeholder : "SELECT",
// 			allowHtml: true,
			allowClear: true,
			tags: true
		}).css("float", 'left');
</script>
<script>
    $(function(){
        $('#checkDuplicateItem').click(function() {
            var checkList = [];
            $('.duplicate_id:checked').each(function () {
              checkList.push($(this).val());
            });
            if(checkList.length > 0)
            {
                $.ajax({
                    url : '<?= base_url("resonForDuplicateLeads") ?>',
                    type : 'POST',
                    dataType : "json",
                    async : false,
                    data : {checkList : checkList, csrf_token},
                    success : function(response) {
                        if(response.err){
                            catchError(response.err);
                        }else{
                            catchSuccess("Leads added in duplicate List.");
                            window.location.reload();
                        }
                    }
                });
            }else{
                catchError("Please select Leads to mark Duplicates .");
            }
        });
    });
    
    ////////////////////////////////////////// Allocate Leads ////////////////////////////////////////
    
    $(function(){
        $('#allocate').click(function () {
            var checkList = [];
            $('.duplicate_id:checked').each(function () {
               checkList.push($(this).val());
            });
            if(checkList.length > 0)
            {
                var user_id = $('#user_id').val();
                var customer_id = $('#customer_id').val();
                $.ajax({
                    url : '<?= base_url("allocateLeads") ?>',
                    type : 'POST',
                    dataType : "json",
                    data : {checkList : checkList, user_id : user_id, customer_id : customer_id, csrf_token},
                    success : function(response) {
                        if(response.err){
                            catchError(response.err); 
                        }else{
                            catchSuccess("Leads added in Your Bucket.");
                            window.location.reload();
                        }
                    }
                });
            }else{
                catchError("Please select Leads to Assign Yourself.");
            }
        });
    });
    
    ////////////////////////////////////////// Re-Allocate Leads ////////////////////////////////////////
    
    $(function(){
        $('#reallocate').click(function () {
            var telecaller = $('#telecaller-name').val();
            var checkList = [];
            $('.duplicate_id:checked').each(function () {
               checkList.push($(this).val());
            });
            if(checkList.length > 0)
            {
                $.ajax({
                    url : '<?= base_url("reallocate") ?>',
                    type : 'POST',
                    dataType : "json",
                    data : {checkList : checkList, csrf_token},
                    success : function(response) {
                        if(response.err){
                            catchError(response.err);
                        }else{
                            catchSuccess("Leads Reallocated Successfully.");
                            window.location.reload();
                        }
                    }
                });
            }else{
                catchError("Please select leads for Re-Allocate.");
            }
        });
    });
    
    //////////////////////////// get old loan History ////////////////////////////////////////////////
    
    function getLeadsDetails(lead_id)
    {
        window.location.href="<?= base_url('getleadDetails/'. $this->encrypt->encode($leadDetails->lead_id)) ?>";
    }

    function modifyLeadsDetails(lead_id)
    {
        $.ajax({
            url : '<?= base_url("getState") ?>',
            type : 'POST',
            dataType : "json",
            data : {csrf_token},
            beforeSend: function() {
                $("#cover").show();
            },
            success : function(response){
                getPersonalDetails(lead_id);
                $("#state").empty();
                $("#state").append('<option value="">Select</option>');
                $.each(response.state, function(index, myarr) { 
                    $("#state").append('<option value="'+ myarr.state_id +'">'+ myarr.state +'</option>');
                });
            },
            complete: function() {
                $("#cover").fadeOut(1750)
            }
        });
    }

    function viewOldHistory(lead_id)
    {
        $.ajax({
            url : '<?= base_url("viewOldHistory/") ?>'+lead_id,
            type : 'POST',
            dataType : "json",
            data : {csrf_token},
            beforeSend: function() {
                $("#cover").show();
            },
            success : function(response){
                $('#oldTaskHistory').empty();
                $('#oldTaskHistory').html(response);
            },
            complete: function() {
                $("#cover").fadeOut(1750)
            }
        });
    }
    
    function ViewCibilStatement(lead_id)
    {
        $.ajax({
            url : '<?= base_url("cibilStatement"); ?>',
            type : 'POST',
            data : {lead_id : lead_id, csrf_token},
            dataType : "json",
            beforeSend: function() {
                $("#cover").show();
            },
            success : function(response){
                $('#cibilStatement').html("");
                $('#cibilStatement').html(response);
            },
            complete: function() {
                $("#cover").fadeOut(1750)
            }
        });
    }
    
	function checkCustomerCibil()
	{
	    var lead_id = $('#lead_id').val();
	    autoCheckCustomerCibil(lead_id);
	}
	
	function autoCheckCustomerCibil(lead_id)
	{
	    if(lead_id != '')
        {
	        $.ajax({
                url : '<?= base_url("cibil") ?>',
                type : 'POST',
                data:{lead_id : lead_id, csrf_token},
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
    
    $('#divExpendReason').hide();
    
    function RejectedLoan() 
    {
        $('#divExpendReason2').hide();
        $('#divExpendReason').toggle();
        
        <?php if($_SESSION['isUserSession']['role'] == "Disbursal"){ ?>
        // $("#ResonBoxForRejectDisbursalLoan").html(prependFormDuplicateLead);
        <?php } else{ ?>
        // $("#ResonBoxForrejectLoan").html(prependFormDuplicateLead);
        <?php }  ?>
        
        $.ajax({
            url : '<?= base_url("getRejectionReasonMaster") ?>',
            type : 'POST',
            data : {csrf_token},
            dataType : 'json',
            beforeSend: function() {
                $('.reject-button').html('<span class="spinner-border spinner-border-sm" role="status"></span>Processing...').addClass('disabled');
            },
            success : function(response) {
                $("#resonForReject").empty();
                $("#resonForReject").append('<option value="">Select Reason</option>');
                $.each(response.rejectionLists, function(index, myarr){
                    $("#resonForReject").append('<option value="'+ myarr.reason +'">'+ myarr.reason +'</option>');
                });
            },
            complete: function() {
                $('.reject-button').html('REJECT').removeClass('disabled');
            }
        });
    }

    function ResonForRejectLoan()
    {
        var user_id = $("#user_id").val();
        var lead_id = $("#lead_id").val();
        var customer_id = $("#customer_id").val();
        var reason = $("#resonForReject").val();
        if(lead_id == ""){
            catchError("Lead ID is required.");
            return false;
        } else if(user_id == ""){
            catchError("Session Expore. Please re-login.");
            return false;
        } else if(reason == ""){
            catchError("Reason is required.");
            return false;
        }else{
            $.ajax({
                url : '<?= base_url("resonForRejectLoan") ?>',
                type : 'POST',
                data:{user_id : user_id, lead_id : lead_id, customer_id : customer_id, reason : reason, csrf_token},
                dataType : 'json',
                beforeSend: function() {
                    $("#btnRejectApplication").html('<span class="spinner-border spinner-border-sm" role="status"></span>Processing...').addClass('disabled');
                },
                success : function(response) {
                    if(response.errSession){
                        window.location.href = "<?= base_url() ?>";
                    } else if(response.msg){
                        $('#reson').empty();
                        catchSuccess(response.msg);
                        history.back(1);
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $("#btnRejectApplication").html('REJECT APPLICATION').removeClass('disabled');
                }
            });
        }
    }
    
    $("#divExpendReason2").hide();
    function holdLeadsRemark()
    {
        $("#divExpendReason").hide();
        $("#divExpendReason2").toggle();
    }

    function saveHoldleads(lead_id)
    {
        var hold_remark = $("#hold_remark").val();
        var hold_date = $("#holdDurationDate").val();
        // var status = $("#status").val();
        // var stage = $("#stage").val();
        var user_id = $("#user_id").val();
        var customer_id = $("#customer_id").val();
        if(hold_remark == "" && hold_date == ""){
            catchError("Remarks and Date Required.");
            return false;
        }else{
            $.ajax({
                url : '<?= base_url("saveHoldleads/") ?>' + lead_id,
                type : 'POST',
                data: {hold_remark : hold_remark, hold_date : hold_date, customer_id : customer_id, user_id : user_id, csrf_token},
                dataType : 'json', 
                success : function(response) {
                    if(response.msg){
                        $('#reson').empty();
                        catchSuccess(response.msg);
                        history.back(1);
                    }else{
                        catchError(response.err);
                    }
                }
            });
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
                data : {lead_id : lead_id, csrf_token},
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
            catchSuccess("Network Error, Try Again");
        }
    }

    function viewCustomerDocs(docs_id) {
        $.ajax({
            url : '<?= base_url("viewCustomerDocs/") ?>'+docs_id,
            type : 'POST',
            data : {csrf_token},
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
        $('#formUploadDocs').show();
        $.ajax({
            url : '<?= base_url("viewCustomerDocsById/") ?>'+docs_id,  /*selectDocsTypes   editCustomerDocs*/
            type : 'POST',
            data : {csrf_token},
            dataType : "json",
            success : function(response) {
                $('#getDocId').html('<input type="hidden" name="docs_id" id="docs_id" value="'+ response.docs_id +'">');
                $("#btnSaveDocs").html("Update Docs");
                $("#docuemnt_type").val(response.docs);
                $("#document_name").val(response.type); 
                $("#password").val(response.pwd); 
            }
        });
    }
    
    function deleteCustomerDocs(docs_id) 
    { 
        var customer_id = $('#customer_id').val();
        $.ajax({
            url : '<?= base_url("deleteCustomerDocsById/") ?>'+docs_id,  /*selectDocsTypes   editCustomerDocs*/
            type : 'POST',
            data : {csrf_token},
            dataType : "json",
            success : function(response) {
                if(response['result'] == true){ 
                    catchSuccess("Document Deleted Successfully."); 
                    $('#formUserDocsData').trigger("reset");
                    $('#selectDocsTypes').trigger("reset");
                }else{ 
                    catchError("Process Failed, Try Again");
                }
                getDocs(response['lead_id'], customer_id);
            }
            
        });
    }

    function viewCustomerPaidSlip(docs_id) 
    {
        $.ajax({
            url : '<?= base_url("viewCustomerPaidSlip/") ?>'+docs_id,
            type : 'POST',
            data : {csrf_token},
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
            data : {csrf_token},
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
    
    function getCustomerDocs(lead_id, customer_id)
    {
        getDocs(lead_id, customer_id);
    }

    function editsCoustomerPayment(id, received_amount, refrence_no, discount, refund, date_of_recived)
    {
        console.log(id);
        // console.log();
        // $('#recovery_id').val(id);
        // $('#received_amount').val(received_amount);
        // $('#refrence_no').val(refrence_no);
        // $('#discount').val(discount);
        // $('#refund').val(refund);
        // $('#date_of_recived').val(date_of_recived);
    }

    function getDocs(lead_id, customer_id)
    {
        $.ajax({
            url : '<?= base_url("getDocsUsingAjax/") ?>' +lead_id,
            type : 'POST',
            data : {customer_id : customer_id, csrf_token},
            dataType : "json",
            beforeSend: function() {
                $("#cover").show();
            },
            success : function(response) { 
                $('#docsHistory').html(response);
            },
            complete: function() {
                $("#cover").fadeOut(1750)
            }
        });
    }
    
    function sanctionleads(lead_id, user_id, customer_id)
    {
        if(lead_id == ""){
            catchError("Lead ID is required.");
            return false;
        }else{
            $.ajax({
                url : '<?= base_url("sanctionleads") ?>',
                type : 'POST',
                data:{lead_id : lead_id, user_id : user_id, customer_id : customer_id, csrf_token},
                dataType : 'json', 
                beforeSend: function() {
                    $('.lead-sanction-button').html('<span class="spinner-border spinner-border-sm" role="status"></span>Processing...').addClass('disabled');
                },
                success : function(response) {
                    if(response.errSession){
                        window.location.href='<?= base_url() ?>';
                    } else if(response.msg){
                        $('#reson').empty();
                        catchSuccess(response.msg);
                        history.back(1);
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('.lead-sanction-button').html('RECOMMEND').removeClass('disabled');
                   
                }
            });
        }
    }

    function leadSendBack(lead_id, user_id, customer_id)
    {
        if(lead_id == ""){
            catchError("Lead ID is required.");
            return false;
        }else{
            $.ajax({
                url : '<?= base_url("leadSendBack") ?>',
                type : 'POST',
                data:{lead_id : lead_id, user_id : user_id, customer_id : customer_id, csrf_token},
                dataType : 'json', 
                beforeSend: function() {
                    $('#btn_send_back').html('<span class="spinner-border spinner-border-sm" role="status"></span>Processing...').addClass('disabled');
                },
                success : function(response) {
                    if(response.errSession){
                        window.location.href='<?= base_url() ?>';
                    } else if(response.msg){
                        $('#reson').empty();
                        catchSuccess(response.msg);
                        history.back(1);
                    } else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#btn_send_back').html('RECOMMEND').removeClass('disabled');
                   
                }
            });
        }
    }
    
    function resendAgreementLetter(lead_id, user_id)
    {
        if($('#resendAgreementLetter').prop('checked'))
        {
            var resendAggLetter = "YES";
            $.ajax({
                url : '<?= base_url("resendDisbursalMail") ?>',
                type : 'POST',
                data : {lead_id : lead_id, user_id : user_id, csrf_token},
                dataType : "json",
                success : function(response){
                    catchSuccess(lead_id +" - "+ resendAggLetter);
                }
            });
        }else{
            var resendAggLetter = "NO";
        }
    }

    function disbursalDetails(lead_id, customer_id, user_id)
    {
        $('#div1disbursalBank, #disbursalBank, #div1UpdateReferenceNo, #divUpdateReferenceNo').show();
        $.ajax({
            url : '<?= base_url("getSanctionDetails") ?>',
            type : 'POST',
            data : {lead_id : lead_id, customer_id : customer_id, user_id : user_id, csrf_token},
            dataType : "json",
            success : function(response){
                var res = response['camDetails'];
                var res2 = response['LeadFollowup'];
                var html = '<table class="table table-bordered table-striped"><tbody>';  
                    html += '<tr><th class="thbg">Loan No.</th><td colspan="4">'+ ((typeof res.loan_status !== 'undefined' && typeof res.loan_status == 'DISBURSED') ? res.loan_no : "-") +'</td></tr>';
                    html += '<tr><th class="thbg">Processed By</th><td>'+ (res2.processed_by) +'</td><th class="thbg">Processed On</th><td>'+ (res2.processed_on) +'</td></tr>';
                    html += '<tr><th class="thbg">Sanctioned By</th><td>'+ (res2.sanctioned_by) +'</td><th class="thbg">Sanctioned On</th><td>'+ (res2.sanctioned_on) +'</td></tr>';
                    html += '<tr><th class="thbg">Loan Approved</th><td>'+ ((res.loan_recommended)?res.loan_recommended : "-") +'</td><th class="thbg">ROI % (p.d.) Approved</th><td>'+ ((res.roi)?res.roi : "-") +'</td></tr>';
                    html += '<tr><th class="thbg">Total Admin Fee (Rs) Approved</th><td>'+ ((res.total_admin_fee)?res.total_admin_fee : "-") +'</td><th class="thbg">Tenure Approved</th><td>'+ ((res.tenure)?res.tenure : "-") +'</td></tr>';
                    html += '<tr><th class="thbg">Disbursal Email Sent On</th><td>'+ ((res.agrementRequestedDate) ? res.agrementRequestedDate : '-') +'</td><th class="thbg">Disbursal Email Sent To</th><td>'+ ((res.email) ? res.email : '-') +'</td></tr>';
                    html += '<tr><th class="thbg">Disbursal Email Delivery status</th><td>'+ ((res.loanAgreementRequest == 1) ? "Sended" : 'Pending') +'</td><th class="thbg">Disbursal Email Response status</th><td>'+ ((res.loanAgreementResponse == 1) ? "Accepted" : '-') +'</td></tr>';
                    html += '<tr><th class="thbg">Disbursal Email Response IP</th><td>'+ ((res.agrementUserIP)?res.agrementUserIP : "-") +'</td><th class="thbg">Acceptance Email</th><td>'+ ((res.loanAgreementResponse == 1) ? res.email : '-') +'</td></tr>';

                    if(typeof res.loan_status !== 'undefined' && typeof res.loan_status != 'DISBURSED-PENDING')
                    {
                        <?php if(agent == "DS1"){ ?>
                            html += '<tr><th class="thbg">Resend Disbursal Email</th><td colspan="4"><input type="checkbox" name="resendAgreementLetter" id="resendAgreementLetter" onclick="resendAgreementLetter('+ lead_id  +', '+ user_id +')"></td></tr>';
                        <?php } else { ?>
                            html += '<tr><th class="thbg">Payable Account</th><td>'+ ((res.company_ac_no)?res.company_ac_no : "-") +'</td><th class="thbg">Channel</th><td>'+ ((res.channel) ? res.channel : '-') +'</td></tr>';
                            html += '<tr><th class="thbg">MOP</th><td>'+ ((res.mode_of_payment)?res.mode_of_payment : "-") +'</td><th class="thbg">Disbursal Reference No.</th><td colspan="4">'+ ((res.disburse_refrence_no) ? res.disburse_refrence_no : '-') +'</td></tr>';
                        <?php } ?>
                    } else {
                        // $('#div1disbursalBank, #disbursalBank, #div1UpdateReferenceNo, #divUpdateReferenceNo').hide();
                        html += '<tr><th class="thbg">Payable Account</th><td>'+ ((res.company_ac_no)?res.company_ac_no : "-") +'</td><th class="thbg">Channel</th><td>'+ ((res.channel) ? res.channel : '-') +'</td></tr>';
                        html += '<tr><th class="thbg">MOP</th><td>'+ ((res.mode_of_payment)?res.mode_of_payment : "-") +'</td><th class="thbg">Disbursal Reference No.</th><td colspan="4">'+ ((res.disburse_refrence_no) ? res.disburse_refrence_no : '-') +'</td></tr>';
                    }
                    html += '</tbody></table>';
                    if(typeof res.loan_status !== 'undefined' && typeof res.loan_status == 'SANCTION')
                    {
                        $('#div1disbursalBank, #disbursalBank, #div1UpdateReferenceNo, #divUpdateReferenceNo').hide();
                    } else if(typeof res.loan_status !== 'undefined' && typeof loan_status == 'DISBURSE-PENDING'){
                        $('#resendAgreementLetter').prop('disabled', true);
                        $('#div1disbursalBank, #disbursalBank').show();
                        $('#div1UpdateReferenceNo, #divUpdateReferenceNo').hide();
                    } else if(typeof res.loan_status !== 'undefined' && typeof loan_status == 'DISBURSED' && res.disburse_refrence_no == ''){
                        $('#resendAgreementLetter').prop('disabled', true);
                        $('#div1UpdateReferenceNo, #divUpdateReferenceNo').show();
                        $('div1disbursalBank, #disbursalBank').hide();
                    } else {
                        $('#div1disbursalBank, #disbursalBank, #div1UpdateReferenceNo, #divUpdateReferenceNo').hide();
                    }
                $('#ViewDisbursalDetails').html(html);
            }
        });
    }

    function receivedAmount(amount)
    {
        var amount = $(amount).val();
        var total_due_amount = $('#total_due_amount').val(); 

        if(total_due_amount < amount){
            $('#received_amount').val(total_due_amount); 
        } else if(amount <= 0) {
            $('#received_amount').val(total_due_amount); 
        } else {
            $('#received_amount').val(amount);
        }
    }

    function discountAmount(amount)
    {
        var amount = $(amount).val();
        var total_due_amount = $('#total_due_amount').val(); 

        if(total_due_amount < amount){
            $('#discount').val(0); 
        } else if(amount <= 0) {
            $('#discount').val(0); 
        } else {
            $('#discount').val(amount);
        }
    }

    function refundAmount(amount)
    {
        var amount = $(amount).val();
        var total_due_amount = $('#total_due_amount').val(); 

        if(total_due_amount < amount) {
            $('#refund').val(0); 
        } else if(amount <= 0) {
            $('#refund').val(0); 
        } else {
            $('#refund').val(amount);
        }
    }

    function repaymentLoanDetails(lead_id, customer_id, user_id)
    {
        $.ajax({
            url : '<?= base_url("repaymentLoanDetails") ?>',
            type : 'POST',
            data : {lead_id : lead_id, customer_id : customer_id, user_id : user_id, csrf_token},
            dataType : "json",
            success : function(response){
                console.log(response)
                var html = '<table class="table table-bordered table-striped"><tbody>';  
                    html += '<tr><th class="thbg">Loan No.</th><td>'+ ((response.loan_status == 'DISBURSED') ? response.loan_no : "-") +'</td><th>Status</th><td>'+ ((response.status) ? response.status : '-') +'</td></tr>';
                    html += '<tr><th>Loan Amount</th><td>'+ ((response.loan_recommended) ? response.loan_recommended : '-') +'</td><th>Tenure as on date</th><td>'+ ((response.tenure) ? response.tenure : '-') +'</td></tr>';
                    html += '<tr><th>ROI</th><td>'+ ((response.roi) ? response.roi : '-') +'</td><th>Interest as on date</th><td>'+ ((response.real_interest) ? response.real_interest : '-') +'</td></tr>';
                    html += '<tr><th>Disbursal Date</th><td>'+ ((response.disbursal_date) ? response.disbursal_date : '-') +'</td><th>Delay (days)</th><td>'+ ((response.penalty_days) ? response.penalty_days : 0) +'</td></tr>';
                    html += '<tr><th>Repay Date</th><td>'+ ((response.repayment_date) ? response.repayment_date : '-') +'</td><th>Late Payment Interest as on date</th><td>'+ ((response.repayment_date) ? response.repayment_date : '-') +'</td></tr>';
                    html += '<tr><th>Repay Amount</th><td>'+ ((response.repayment_amount) ? response.repayment_amount : '-') +'</td><th>Total Payable (Rs)</th><td>'+ ((response.total_repayment_amount) ? response.total_repayment_amount : '-') +'</td></tr>';
                    html += '<tr><th>Penal ROI</th><td>'+ ((response.panel_roi) ? response.panel_roi : '-') +'</td><th>Total Received (Rs)</th><td>'+ ((response.total_received_amount) ? response.total_received_amount : 0) +'</td></tr>';
                    html += '<tr><th colspan="2"></th><th>Total Due (Rs)</th><td><input type="hidden" id="total_due_amount" value="'+ ((response.total_due_amount) ? response.total_due_amount : '-') +'">'+ ((response.total_due_amount) ? response.total_due_amount : '-') +'</td></tr>';
                    html += '</thead></table>';
                $('#received_amount').val(response.total_due_amount);

                $('#loanStatus').html(html);
            }
        });
    }

    function deleteCoustomerPayment(id, user_id)
    {
        console.log();
        $.ajax({
            url : '<?= base_url("deleteCoustomerPayment") ?>',
            type : 'POST',
            data : {id : id, user_id : user_id, csrf_token},
            dataType : "json",
            success : function(response){
                if(response.errSession){
                    window.location.href = "<?= base_url() ?>";
                } else if(response.msg){
                    catchSuccess(response.msg);
                    history.back(1);
                }else{
                    catchError(response.err);
                }
            }
        });
    }

    function collectionHistory(lead_id, customer_id, user_id)
    {
        $.ajax({
            url : '<?= base_url("collectionHistory") ?>',
            type : 'POST',
            data : {lead_id : lead_id, customer_id : customer_id, user_id : user_id, csrf_token},
            dataType : "json",
            success : function(response){
                $('#recoveryHistory').html(response['recoveryData']);
            }
        });
    }

    function leadRecommendation()
    {
        var FormData = $('#FormSaveCAM').serialize();
        
        <?php if(company_id == 1 && product_id == 1){ ?>
            var url = "PaydayLeadRecommendation";
        <?php } if(company_id == 1 && product_id == 2){ ?>
            var url = "LACLeadRecommendation";
        <?php } ?>
        $.ajax({
            url : '<?= base_url() ?>' + url,
            type : 'POST',
            dataType : "json",
            data : FormData,
            beforeSend: function() {
                $('#LeadRecommend').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
            },
            success : function(response){
                if(response.errSession){
                    window.location.href = "<?= base_url() ?>";
                } else if(response.msg){
                    catchSuccess(response.msg);
                    history.back(1);
                }else{
                    catchError(response.err);
                }
            },
            complete: function() {
                $('#LeadRecommend').html('Recomend').prop('disabled', false);
            },
        });
    }

    function getPersonalDetails(lead_id)
    {
        if(lead_id != "") {
            $.ajax({
                url : '<?= base_url("getPersonalDetails/") ?>'+lead_id,
                type : 'POST',
                data : {csrf_token},
                dataType : "json",
                success : function(response){
                    $("#first_name").val((response['personalDetails1'].first_name=='')?'-':response['personalDetails1'].first_name);
                    $("#middle_name").val((response['personalDetails1'].middle_name=='')?'-':response['personalDetails1'].middle_name);
                    $("#sur_name").val((response['personalDetails1'].sur_name=='')?'-':response['personalDetails1'].sur_name);
                    $("#gender").val((response['personalDetails1'].gender=='')?'-':response['personalDetails1'].gender).prop("selected", "selected");
                    $("#dob").val((response['personalDetails1'].dob=='')?'-':response['personalDetails1'].dob);
                    $("#pancard").val((response['personalDetails1'].pancard=='')?'-':response['personalDetails1'].pancard);
                    $("#mobile").val((response['personalDetails1'].mobile=='')?'-':response['personalDetails1'].mobile); 
                    $("#alternate_mobile").val((response['personalDetails1'].alternate_mobile=='')?'-':response['personalDetails1'].alternate_mobile);
                    $("#email").val((response['personalDetails1'].email=='')?'-':response['personalDetails1'].email);
                    $("#alternate_email").val((response['personalDetails1'].alternate_email=='')?'-':response['personalDetails1'].alternate_email);
                    $("#screenedBy").val((response['personalDetails1'].screenedBy=='')?'-':response['personalDetails1'].screenedBy);
                    $("#screenedOn").val((response['personalDetails1'].screenedOn=='')?'-':response['personalDetails1'].screenedOn);


                    var html = '<table class="table table-bordered table-striped">';
                        html += '<tbody>';
                        html += '<tr><th>First&nbsp;Name</th><td>'+ response['personalDetails1'].first_name +'</td><th>Middle&nbsp;Name</th><td>'+ ((response['personalDetails1'].middle_name=='')?'-':response['personalDetails1'].middle_name) +'</td></tr>';
                        html += '<tr><th>Surname</th><td>'+ ((response['personalDetails1'].sur_name=='')?'-':response['personalDetails1'].sur_name) +'</td><th>Gender</th><td>'+ ((response['personalDetails1'].gender=='')?'-':response['personalDetails1'].gender) +'</td></tr>';
                        html += '<tr><th>DOB</th><td>'+ ((response['personalDetails1'].dob=='')?'-':response['personalDetails1'].dob) +'</td><th>PAN</th><td>'+ ((response['personalDetails1'].pancard=='')?'-':response['personalDetails1'].pancard) +'</td></tr>';
                        html += '<tr><th>Mobile</th><td>'+ ((response['personalDetails1'].mobile=='')?'-':response['personalDetails1'].mobile) +'</td><th>Alternate&nbsp;Mobile</th><td>'+ ((response['personalDetails1'].alternate_mobile=='')?'-':response['personalDetails1'].alternate_mobile) +'</td></tr>';
                        html += '<tr><th>Email&nbsp;Personal</th><td>'+ ((response['personalDetails1'].email=='')?'-':response['personalDetails1'].email) +'</td><th>Email&nbsp;Office</th><td>'+ ((response['personalDetails1'].alternate_email=='')?'-':response['personalDetails1'].alternate_email) +'</td></tr>';
                        html += '<tr><th>Screened&nbsp;By</th><td>'+ ((response['personalDetails1'].screenedBy=='')?'-':response['personalDetails1'].screenedBy) +'</td><th>Screened&nbsp;On</th><td>'+ ((response['personalDetails1'].screenedOn=='')?'-':response['personalDetails1'].screenedOn) +'</td></tr>';
                        html += '</tbody>';
                        html += '</table>';

                    $('#ViewPersonalDetails').html(html);
                }
            });
        } else {
            catchError("Lead Id Not Found.");
        }
    }

    function getResidenceDetails(lead_id)
    {
        if(lead_id != "") {
            $.ajax({
                url : '<?= base_url("getResidenceDetails/") ?>'+lead_id,
                type : 'POST',
                data : {csrf_token},
                dataType : "json",
                success : function(response){
                    $("#hfBulNo1").val((response['residenceDetails'].current_house=='')?'-':response['residenceDetails'].current_house);
                    $("#lcss1").val((response['residenceDetails'].current_locality=='')?'-':response['residenceDetails'].current_locality);
                    $("#lankmark1").val((response['residenceDetails'].current_landmark=='')?'-':response['residenceDetails'].current_landmark);
                    $("#state1").val((response['residenceDetails'].current_state=='')?'-':response['residenceDetails'].current_state);
                    $("#city1").val((response['residenceDetails'].current_city=='')?'-':response['residenceDetails'].current_city);
                    $("#pincode1").val((response['residenceDetails'].cr_residence_pincode=='')?'-':response['residenceDetails'].cr_residence_pincode);
                    $("#district1").val((response['residenceDetails'].current_district=='')?'-':response['residenceDetails'].current_district);
                    $("#aadhar1").val((response['residenceDetails'].aadhar_no=='')?'-':response['residenceDetails'].aadhar_no);
                    

                    $("#addharAddressSameasAbove").val((response['residenceDetails'].aa_same_as_current_address=='')?'NO':response['residenceDetails'].aa_same_as_current_address);
                    if(response['residenceDetails'].aa_same_as_current_address=='YES'){
                        $("#addharAddressSameasAbove").prop('checked', true);
                    }else{
                        $("#addharAddressSameasAbove").prop('checked', false);   
                    }

                    $("#hfBulNo2").val((response['residenceDetails'].aa_current_house=='')?'-':response['residenceDetails'].aa_current_house);
                    $("#lcss2").val((response['residenceDetails'].aa_current_locality=='')?'-':response['residenceDetails'].aa_current_locality);
                    $("#landmark2").val((response['residenceDetails'].aa_current_landmark=='')?'-':response['residenceDetails'].aa_current_landmark);
                    $("#state2").val((response['residenceDetails'].aa_current_state=='')?'-':response['residenceDetails'].aa_current_state);
                    $("#city2").val((response['residenceDetails'].aa_current_city=='')?'-':response['residenceDetails'].aa_current_city);
                    $("#pincode2").val((response['residenceDetails'].aa_cr_residence_pincode=='')?'-':response['residenceDetails'].aa_cr_residence_pincode);
                    $("#district2").val((response['residenceDetails'].aa_current_district=='')?'-':response['residenceDetails'].aa_current_district);
                    $("#presentResidenceType").val((response['residenceDetails'].current_residence_type=='')?'OWNED':response['residenceDetails'].current_residence_type);
                    $("#residenceSince").val((response['residenceDetails'].current_residence_since=='')?'-':response['residenceDetails'].current_residence_since);

                    
                    var html = '<table class="table table-bordered table-striped"><tbody>';
                        html += '<tr><th>House&nbsp;No.</th><td>'+ ((response['residenceDetails'].current_house=='')?'-':response['residenceDetails'].current_house) +'</td><th>Locality/Street</th><td>'+((response['residenceDetails'].current_locality=='')?'-':response['residenceDetails'].current_locality) +'</td></tr>';
                        html += '<tr><th>Landmark</th><td>'+ ((response['residenceDetails'].current_landmark=='')?'-':response['residenceDetails'].current_landmark) +'</td><th>State</th><td>'+ ((response['residenceDetails'].current_state=='')?'-':response['residenceDetails'].current_state) +'</td></tr>';
                        html += '<tr><th>City</th><td>'+ ((response['residenceDetails'].current_city=='')?'-':response['residenceDetails'].current_city) +'</td><th>Pincode</th><td>'+ ((response['residenceDetails'].cr_residence_pincode=='')?'-':response['residenceDetails'].cr_residence_pincode) +'</td></tr>';
                        html += '<tr><th>District</th><td>'+ ((response['residenceDetails'].current_district=='')?'-':response['residenceDetails'].current_district) +'</td><th>Aadhar</th><td>'+((response['residenceDetails'].aadhar_no=='')?'-':response['residenceDetails'].aadhar_no) +'</td></tr>';
                        html += '<tr><th>House&nbsp;No.</th><td>'+ ((response['residenceDetails'].aa_current_house=='')?'-':response['residenceDetails'].aa_current_house) +'</td><th>Locality/Street</th><td>'+ ((response['residenceDetails'].aa_current_locality=='')?'-':response['residenceDetails'].aa_current_locality) +'</td></tr>';
                        html += '<tr><th>Landmark</th><td>'+ ((response['residenceDetails'].aa_current_landmark=='')?'-':response['residenceDetails'].aa_current_landmark) +'</td><th>State</th><td>'+ ((response['residenceDetails'].aa_current_state=='')?'-':response['residenceDetails'].aa_current_state) +'</td></tr>';
                        html += '<tr><th>City</th><td>'+ ((response['residenceDetails'].aa_current_city=='')?'-':response['residenceDetails'].aa_current_city) +'</td><th>Pincode</th><td>'+ ((response['residenceDetails'].aa_cr_residence_pincode=='')?'-':response['residenceDetails'].aa_cr_residence_pincode) +'</td></tr>';
                        html += '<tr><th>District</th><td>'+ ((response['residenceDetails'].aa_current_district=='')?'-':response['residenceDetails'].aa_current_district) +'</td><th>Present&nbsp;Residence&nbsp;Type</th><td>'+ ((response['residenceDetails'].current_residence_type=='')?'OWNED':response['residenceDetails'].current_residence_type) +'</td></tr>';
                        html += '<tr><th>Residing&nbsp;Since</th><td>'+ ((response['residenceDetails'].current_residence_since=='')?'-':response['residenceDetails'].current_residence_since) +'</td></tr>';
                        html += '</tbody></table>';
                    $('#viewResidenceDetails').html(html);
                }
            });
        } else {
            catchError("Lead Id Not Found.");
        }
    }

    function getEmploymentDetails(lead_id)
    {
        if(lead_id != "") {
            $.ajax({
                url : '<?= base_url("getEmploymentDetails/") ?>'+lead_id,
                type : 'POST',
                data : {csrf_token},
                dataType : "json",
                success : function(response){
                    $("#officeEmpName").val((response['employmentDetails'].employer_name==null)?'-':response['employmentDetails'].employer_name);
                    $("#hfBulNo3").val((response['employmentDetails'].emp_house==null)?'-':response['employmentDetails'].emp_house);
                    $("#lcss3").val((response['employmentDetails'].emp_street==null)?'-':response['employmentDetails'].emp_street);
                    $("#lankmark3").val((response['employmentDetails'].emp_landmark==null)?'-':response['employmentDetails'].emp_landmark);
                    $("#state3").val((response['employmentDetails'].emp_state==null)?'-':response['employmentDetails'].emp_state);
                    $("#city3").val((response['employmentDetails'].emp_city==null)?'-':response['employmentDetails'].emp_city);
                    $("#pincode3").val((response['employmentDetails'].emp_pincode==null)?'-':response['employmentDetails'].emp_pincode);
                    $("#district3").val((response['employmentDetails'].emp_district==null)?'-':response['employmentDetails'].emp_district);
                    $("#website").val((response['employmentDetails'].emp_website==null)?'-':response['employmentDetails'].emp_website);
                    $("#employeeType").val((response['employmentDetails'].emp_employer_type==null)?'-':response['employmentDetails'].emp_employer_type);
                    $("#industry").val((response['employmentDetails'].industry==null)?'-':response['employmentDetails'].industry);
                    $("#sector").val((response['employmentDetails'].sector==null)?'-':response['employmentDetails'].sector);
                    $("#department").val((response['employmentDetails'].emp_department==null)?'-':response['employmentDetails'].emp_department);
                    $("#designation").val((response['employmentDetails'].emp_designation==null)?'-':response['employmentDetails'].emp_designation);
                    $("#employedSince").val((response['employmentDetails'].emp_residence_since==null)?'-':response['employmentDetails'].emp_residence_since);
                    $("#presentServiceTenure").val((response['employmentDetails'].presentServiceTenure==null)?'-':response['employmentDetails'].presentServiceTenure);
                    


                    var html = '<table class="table table-bordered table-striped"><tbody>';
                        html += '<tr><th>Office/&nbsp;Employer&nbsp;Name</th><td>'+ ((response['employmentDetails'].employer_name==null)?'-':response['employmentDetails'].employer_name) +'</td><th>Shop/&nbsp;Block/&nbsp;Building&nbsp;No.</th><td>'+ ((response['employmentDetails'].emp_house==null)?'-':response['employmentDetails'].emp_house) +'</td></tr>';
                        html += '<tr><th>Locality/&nbsp;Colony/&nbsp;Sector/&nbsp;Street</th><td>'+ ((response['employmentDetails'].emp_street==null)?'-':response['employmentDetails'].emp_street) +'</td><th>Landmark</th><td>'+ ((response['employmentDetails'].emp_landmark==null)?'-':response['employmentDetails'].emp_landmark) +'</td></tr>';
                        html += '<tr><th>State</th><td>'+ ((response['employmentDetails'].emp_state==null)?'-':response['employmentDetails'].emp_state) +'</td><th>City</th><td>'+ ((response['employmentDetails'].emp_city==null)?'-':response['employmentDetails'].emp_city) +'</td></tr>';
                        html += '<tr><th>Pincode</th><td>'+ ((response['employmentDetails'].emp_pincode==null)?'-':response['employmentDetails'].emp_pincode) +'</td><th>District</th><td>'+ ((response['employmentDetails'].emp_district==null)?'-':response['employmentDetails'].emp_district) +'</td></tr>';
                        html += '<tr><th>Website</th><td>'+ ((response['employmentDetails'].emp_website==null)?'-':response['employmentDetails'].emp_website) +'</td><th>Employer&nbsp;Type</th><td>'+ ((response['employmentDetails'].emp_employer_type==null)?'-':response['employmentDetails'].emp_employer_type) +'</td></tr>';
                        html += '<tr><th>Industry</th><td>'+ ((response['employmentDetails'].industry==null)?'-':response['employmentDetails'].industry) +'</td><th>Sector</th><td>'+ ((response['employmentDetails'].sector==null)?'-':response['employmentDetails'].sector) +'</td></tr>';
                        html += '<tr><th>Department</th><td>'+ ((response['employmentDetails'].emp_department==null)?'-':response['employmentDetails'].emp_department) +'</td><th>Designation</th><td>'+ ((response['employmentDetails'].emp_designation==null)?'-':response['employmentDetails'].emp_designation) +'</td></tr>';
                        html += '<tr><th>Employed&nbsp;Since</th><td>'+ ((response['employmentDetails'].emp_residence_since==null)?'-':response['employmentDetails'].emp_residence_since) +'</td><th>Present&nbsp;Service&nbsp;Tenure</th><td>'+ ((response['employmentDetails'].presentServiceTenure==null)?'-':response['employmentDetails'].presentServiceTenure) +'</td></tr>';
                        html += '</tbody></table>';

                    $('#ViewEmploymentDetails').html(html);
                }
            });
        } else {
            catchError("Lead Id Not Found.");
        }
    }

    function getReferenceDetails(lead_id)
    {
        if(lead_id != "") {
            $.ajax({
                url : '<?= base_url("getReferenceDetails/") ?>'+lead_id,
                type : 'POST',
                data : {csrf_token},
                dataType : "json",
                success : function(response){
                    $("#refrence1").val((response['referenceDetails'].reference_one==null)?'-':response['referenceDetails'].reference_one);
                    $("#refrence2").val((response['referenceDetails'].reference_two==null)?'-':response['referenceDetails'].reference_two);
                    $("#relation1").val((response['referenceDetails'].relation_one==null)?'-':response['referenceDetails'].relation_one);
                    $("#relation2").val((response['referenceDetails'].relation_two==null)?'-':response['referenceDetails'].relation_two);
                    $("#refrence1mobile").val((response['referenceDetails'].ref_one_mobile==null)?'-':response['referenceDetails'].ref_one_mobile);
                    $("#refrence2mobile").val((response['referenceDetails'].ref_two_mobile==null)?'-':response['referenceDetails'].ref_two_mobile);
                    

                }
            });
        } else {
            catchError("Lead Id Not Found.");
        }
    }

    function getCustomerBanking(customer_id)
    {
        if(customer_id != "") {
            $.ajax({
                url : '<?= base_url("getCustomerBanking") ?>',
                type : 'POST',
                data : {customer_id : customer_id, csrf_token},
                dataType : "json",
                success : function(response){
                    $('#disbursalBanking').html('');
                    if(response.disbursalBankCount > 0)
                    {
                        var res = response.disbursalBank;
                        var html1 = '<table class="table table-bordered table-striped"><tbody>';
                        html1 += '<tr><th>Customer&nbsp;ID</th><td>'+ res.customer_id +'</td><th>Bank&nbsp;A/C&nbsp;No.</th><td>'+ res.account +'</td></tr>';
                        html1 += '<tr><th>IFSC&nbsp;Code</th><td>'+ res.ifsc_code +'</td><th>Reconfirm&nbsp;Bank&nbsp;A/C&nbsp;No.</th><td>'+ res.confirm_account +'</td></tr>';
                        html1 += '<tr><th>Bank&nbsp;A/C&nbsp;Type</th><td>'+ res.account_type +'</td><th>Bank&nbsp;Name</th><td>'+ res.bank_name +'</td></tr>'; 
                        html1 += '<tr><th>Branch&nbsp;Name</th><td>'+ res.branch +'</td><th>Active&nbsp;Account</th><td style="color: green">'+ res.account_status +'&nbsp;<i class="fa fa-check"></i></td></tr>'; 
                        html1 += '<tr><th>Created&nbsp;ON</th><td>'+ res.created_on +'</td><th>Updated&nbsp;ON</th><td>'+ res.updated_on +'</td></tr>';
                        html1 += '<tr><th>Remark</th><td>'+ res.remark +'</td></tr><tbody></table>'; 
                        $('#disbursalBanking').html(html1);
                    }

                    var html = '<div class="table-responsive"><table class="table table-bordered table-striped"><thead><tr><th>#</th><th>Customer&nbsp;ID</th><th>Bank&nbsp;A/C&nbsp;No.</th><th>Reconfirm&nbsp;Bank&nbsp;A/C&nbsp;No.</th><th>IFSC&nbsp;Code</th><th>Bank&nbsp;A/C&nbsp;Type</th><th>Bank&nbsp;Name</th><th>Branch&nbsp;Name</th><th>Active&nbsp;Account</th><th>Remark</th><th>Created&nbsp;ON</th><th>Updated&nbsp;ON</th></tr></thead><tbody>';
                    if(response.allDisbursalBankCount > 0)
                    {
                        var i = 1;
                        var html2 = "<option value=''>SELECT</option>";
                        $.each(response.allDisbursalBank, function(key, value){
                            html += '<tr><td>'+ i +'</td><td>'+ value.customer_id +'</td><td>'+ value.account +'</td><td>'+ value.confirm_account +'</td><td>'+ value.ifsc_code +'</td><td>'+ value.account_type +'</td><td>'+ value.bank_name +'</td><td>'+ value.branch +'</td><td>'+ value.account_status +'</td><td>'+ value.remark +'</td><td>'+ value.created_on +'</td><td>'+ value.updated_on +'</td></tr>';
                            $('#list_bank_AC_No option').val(value.account);
                            html2 += ("<option value='"+ value.id +"'>"+ value.account +"</option>");
                            i++;
                        }); 
                        $('#list_bank_AC_No').html(html2);
                        html += '</tbody>';
                    }else{
                        html += '<tr><td colspan="11" class="text-danger text-center">No Record Found.</td></tbody>';
                    }
                    html += '</table></div>';
                    $('#viewBankingDetails').html(html);
                }
            });
        } else {
            catchError("Customer Id Not Found.");
        }
    }

    // function getListsOfCustBankAccount(customer_id)
    // {
    //     if(customer_id != "") {
    //         $.ajax({
    //             url : '<?= base_url("getListsOfCustBankAccount") ?>',
    //             type : 'POST',
    //             data : {customer_id : customer_id, csrf_token},
    //             dataType : "json",
    //             success : function(response){
    //                 var html = '<div class="table-responsive"><table class="table table-bordered"><thead><tr><th>#</th><th>Customer&nbsp;ID</th><th>Bank&nbsp;A/C&nbsp;No.</th><th>Reconfirm&nbsp;Bank&nbsp;A/C&nbsp;No.</th><th>IFSC&nbsp;Code</th><th>Bank&nbsp;A/C&nbsp;Type</th><th>Bank&nbsp;Name</th><th>Branch&nbsp;Name</th><th>Active&nbsp;Account</th><th>Remark</th><th>Created&nbsp;ON</th><th>Updated&nbsp;ON</th></tr></thead><tbody>';
    //                 if(response.allDisbursalBankCount > 0)
    //                 {
    //                     var i = 1;
    //                     $.each(response.allDisbursalBank, function(key, value){
    //                         html += '<tr><td>'+ i +'</td><td>'+ value.customer_id +'</td><td>'+ value.account +'</td><td>'+ value.confirm_account +'</td><td>'+ value.ifsc_code +'</td><td>'+ value.account_type +'</td><td>'+ value.bank_name +'</td><td>'+ value.branch +'</td><td>'+ value.account_status +'</td><td>'+ value.remark +'</td><td>'+ value.created_on +'</td><td>'+ value.updated_on +'</td></tr>';
    //                         i++;
    //                     }); 
    //                     html += '</tbody>';
    //                 }else{
    //                     html += '<tr><td colspan="11" class="text-danger text-center">No Record Found.</td></tbody>';
    //                 }
    //                 html += '</table></div>';
    //                 $('#viewBankingDetails').html(html);
    //             }
    //         });
    //     } else {
    //         catchError("Customer Id Not Found.");
    //     }
    // }

    function getCam(lead_id)
    {
        if(lead_id != "") {
            $.ajax({
                url : '<?= base_url("getCAMDetails/") ?>'+lead_id,
                type : 'POST',
                data : {csrf_token},
                dataType : "json",
                success : function(response){
                    <?php if(company_id == 1 && product_id == 1){ ?>
                        getPaydayCAM(response);
                    <?php } if(company_id == 1 && product_id == 2){ ?>
                        getLACCAM(response);
                    <?php } ?>
                }
            });
        } else {
            catchError("Lead Id Not Found.");
        }
    }

    function getLACCAM(response)
    {
        $('#userType').val(response['camDetails'].userType);
        $('#status').val(response['camDetails'].status);
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
        $('#loan_applied').val(response['leadDetails'].loan_amount);
        $('#loan_recommended').val(Math.round(response['camDetails'].loan_recommended));
        $('#processing_fee').val(Math.round(response['camDetails'].processing_fee));
        $('#roi').val(response['camDetails'].roi);
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

        var html = '<table class="table table-bordered table-striped">';
            html += '<tbody>';
            html += '<tr><th>User Type</th><td>'+ response['camDetails'].userType +'</td><th>Status</th><td>'+ response['camDetails'].status +'</td></tr>';
            html += '<tr><th>CIBIL Score</th><td>'+ response['camDetails'].cibil +'</td><th>No of Active CC</th><td>'+ response['camDetails'].Active_CC +'</td></tr>';
            html += '<tr><th>CC Bank</th><td>'+ response['camDetails'].customer_bank_name.toUpperCase() +'</td><th>CC Type</th><td>'+ response['camDetails'].account_type.toUpperCase() +'</td></tr>';
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
            html += '<tr><th>Loan Applied (Rs.)</th><td>'+ response['camDetails'].loan_applied +'</td><th>Loan Recommended (Rs.)</th><td>'+ response['camDetails'].loan_recommended +'</td></tr>';
            html += '<tr><th>Admin Fee (Rs.)</th><td>'+ response['camDetails'].processing_fee +'</td><th>ROI (%)</th><td>'+ response['camDetails'].roi +'</td></tr>';
            html += '<tr><th>Admin Fee with GST (18 %) (Rs.)</th><td>'+ response['camDetails'].adminFeeWithGST +'</td><th>Net Disbursal Amount (Rs.)</th><td>'+ response['camDetails'].net_disbursal_amount +'</td></tr>';
            html += '<tr><th>Disbursal Date</th><td>'+ response['camDetails'].disbursal_date +'</td><th>Repayment Date</th><td>'+ response['camDetails'].repayment_date +'</td></tr>';
            html += '<tr><th>Tenure (days)</th><td>'+ response['camDetails'].tenure +'</td><th>Repayment Amount (Rs.)</th><td>'+ response['camDetails'].repayment_amount +'</td></tr>';
            html += '<tr><th>Reference</th><td>'+ response['camDetails'].special_approval +'</td><th>Deviations Approved By</th><td>'+ response['camDetails'].deviationsApprovedBy +'</td></tr>';
            html += '<tr><th>Change in ROI : </th><td>'+ response['camDetails'].changeROI +'</td><th>Change in Fees : </th><td>'+ response['camDetails'].changeFee +'</td></tr>';
            html += '<tr><th>Higher Loan amount : </th><td>'+ response['camDetails'].changeLoanAmount +'</td><th>Tenor more than norms : </th><td>'+ response['camDetails'].changeTenure +'</td></tr>';
            html += '<tr><th>Note</th><td colspan="3">'+ response['camDetails'].remark +'</td></tr>';

            html += '</tbody>';
            html += '</table>';
        $('#ViewCAMDetails').html(html);
    }
    
    function calculateMedianSalary()
    {
        calculateAmount();
        var s_cr1 = $('#salary_credit1_amount').val();
        var s_cr2 = $('#salary_credit2_amount').val();
        var s_cr3 = $('#salary_credit3_amount').val();

        if (s_cr1 != "" && s_cr2 != "" && s_cr3 != "")
        {
            var salaryAmt = s_cr1 +'-'+ s_cr2 +'-'+ s_cr3;
            $.ajax({
                url: "<?= base_url('calculateMedian/'); ?>"+salaryAmt,
                type: "POST",
                data : {csrf_token},
                dataType : "json",
                success: function(response) {
                    $('#median_salary').val(response['average_salary']);
                }
            });
        }
    }
    
    function calculateSalaryOnTime()
    {
        var s_cr1 = $('#salary_credit1_date').val();
        var s_cr2 = $('#salary_credit2_date').val();
        var s_cr3 = $('#salary_credit3_date').val();

        if (s_cr1 != "" && s_cr2 != "" && s_cr3 != "")
        {
            const words1 = s_cr1.split('-');
            const words2 = s_cr2.split('-');
            const words3 = s_cr3.split('-');

            var date = words1[0] +'-'+ words2[0] +'-'+ words3[0];
            $.ajax({
                url: "<?= base_url('calculateMedian/'); ?>"+date,
                type: "POST",
                data : {csrf_token},
                dataType : "json",
                success: function(response) {
                    $('#salary_on_time').val(response['salary_on_time']);
                    $('#next_pay_date').val(response['next_pay_date']);
                    $('#salary_variance').val(response['salary_variance']);
                }
            });
        }
    }

    function getPaydayCAM(response)
    {
        var res = response['getCamDetails'];
        $('#ntc').val((res.ntc != undefined) ? res.ntc : response.calculation.ntc);
        $('#run_other_pd_loan').val((res.run_other_pd_loan) ? res.run_other_pd_loan : "-");
        $('#delay_other_loan_30_days').val((res.delay_other_loan_30_days) ? res.delay_other_loan_30_days : "-");
        $('#job_stability').val((res.job_stability) ? res.job_stability : response.calculation.job_stability);
        $('#city_category').val((res.city_category) ? res.city_category : "-");
        $('#salary_credit1').val((res.salary_credit1) ? res.salary_credit1 : "-");
        $('#salary_credit1_date').val((res.salary_credit1_date) ? res.salary_credit1_date : "-");
        $('#salary_credit1_amount').val((res.salary_credit1_amount) ? res.salary_credit1_amount : '');
        $('#salary_credit2').val((res.salary_credit2) ? res.salary_credit2 : "-");
        $('#salary_credit2_date').val((res.salary_credit2_date) ? res.salary_credit2_date : "-");
        $('#salary_credit2_amount').val((res.salary_credit2_amount) ? res.salary_credit2_amount : '');
        $('#salary_credit3').val((res.salary_credit3) ? res.salary_credit3 : "-");
        $('#salary_credit3_date').val((res.salary_credit3_date) ? res.salary_credit3_date : "-");
        $('#salary_credit3_amount').val((res.salary_credit3_amount) ? res.salary_credit3_amount : '');
        $('#next_pay_date').val((res.next_pay_date) ? res.next_pay_date : "-");
        $('#median_salary').val((res.median_salary) ? res.median_salary : 0);
        $('#salary_variance').val((res.salary_variance) ? res.salary_variance : "-");
        $('#salary_on_time').val((res.salary_on_time) ? res.salary_on_time : "-");
        $('#borrower_age').val((res.borrower_age != undefined) ? res.borrower_age : response.calculation.borrower_age);
        $('#end_use').val((res.end_use) ? res.end_use : "-");
        $('#eligible_foir_percentage').val((res.eligible_foir_percentage) ? res.eligible_foir_percentage : "0");
        $('#eligible_loan').val((res.eligible_loan) ? res.eligible_loan : "0");
        $('#loan_recommended').val(Math.round(res.loan_recommended) ? Math.round(res.loan_recommended) : '<?= round($leadDetails->loan_amount) ?>');
        $('#final_foir_percentage').val((res.final_foir_percentage) ? res.final_foir_percentage : "0");
        $('#foir_enhanced_by').val((res.foir_enhanced_by) ? res.foir_enhanced_by : "0");
        $('#processing_fee_percent').val((res.processing_fee_percent) ? res.processing_fee_percent : "10");
        $('#admin_fee').val((res.admin_fee) ? res.admin_fee : "0");
        $('#disbursal_date').val((res.disbursal_date) ? res.disbursal_date : "<?= date('d-m-Y', strtotime(timestamp)) ?>");
        $('#repayment_date').val((res.repayment_date) ? res.repayment_date : "");
        $('#adminFeeWithGST').val((res.adminFeeWithGST) ? res.adminFeeWithGST : "0");
        $('#total_admin_fee').val((res.total_admin_fee) ? res.total_admin_fee : "0");
        $('#tenure').val((res.tenure) ? res.tenure : "0");
        $('#net_disbursal_amount').val((res.net_disbursal_amount) ? res.net_disbursal_amount : "0");
        $('#repayment_amount').val((res.repayment_amount) ? res.repayment_amount : "0");
        $('#panel_roi').val((res.panel_roi) ? res.panel_roi : "1");
        $('#b2b_disbursal').val((res.b2b_disbursal) ? res.b2b_disbursal : "");
        $('#b2b_number').val((res.b2b_number) ? res.b2b_number : "1");
        $('#deviationsApprovedBy').val((res.deviationsApprovedBy) ? res.deviationsApprovedBy : "-");
        $('#remark').val((res.remark) ? res.remark : "-");

        var html = '<table class="table table-bordered table-striped">';
            html += '<tbody>';
            html += '<tr><th>CIBIL Score</th><td><?= $leadDetails->cibil ?></td><th>NTC</th><td>'+ ((res.ntc) ? res.ntc : "-") +'</td></tr>';
            html += '<tr><th>Running other Payday loan</th><td>'+ ((res.run_other_pd_loan) ? res.run_other_pd_loan : "-") +'</td><th>Delay in other loans in last 30 days</th><td>'+ ((res.delay_other_loan_30_days) ? res.delay_other_loan_30_days : "-") +'</td></tr>';
            html += '<tr><th>Job stability</th><td>'+ ((res.job_stability) ? res.job_stability : "-") +'</td><th>City category</th><td>'+ ((res.city_category) ? res.city_category : "-") +'</td></tr>';
            html += '<tr><th>Salary Credit</th><td>'+ ((res.salary_credit1) ? res.salary_credit1 : "-") +'</td><td>'+ ((res.salary_credit1_date) ? res.salary_credit1_date : "-") +'</td><td>'+ ((res.salary_credit1_amount) ? res.salary_credit1_amount : "-") +'</td></tr>';
            html += '<tr><th>Salary Credit</th><td>'+ ((res.salary_credit2) ? res.salary_credit2 : "-") +'</td><td>'+ ((res.salary_credit2_date) ? res.salary_credit2_date : "-") +'</td><td>'+ ((res.salary_credit2_amount) ? res.salary_credit2_amount : "-") +'</td></tr>';
            html += '<tr><th>Salary Credit</th><td>'+ ((res.salary_credit3) ? res.salary_credit3 : "-") +'</td><td>'+ ((res.salary_credit3_date) ? res.salary_credit3_date : "-") +'</td><td>'+ ((res.salary_credit3_amount) ? res.salary_credit3_amount : "-") +'</td></tr>';
            html += '<tr><th>Next Pay Date</th><td>'+ ((res.next_pay_date) ? res.next_pay_date : "-") +'</td><th>Avg. Median Salary (Rs)</th><td>'+ ((res.median_salary) ? res.median_salary : "-") +'</td></tr>';
            html += '<tr><th>Salary Variance</th><td>'+ ((res.salary_variance) ? res.salary_variance : "-") +'</td><th>Salary on Time</th><td>'+ ((res.salary_on_time) ? res.salary_on_time : "-") +'</td></tr>';
            html += '<tr><th>Monthly Salary (Rs)</th><td><?= $leadDetails->monthly_income ?></td><th>Obligations (Rs)</th><td><?= $leadDetails->obligations ?></td></tr>';
            html += '<tr><th>Borrower Age (years)</th><td>'+ ((res.borrower_age) ? res.borrower_age : "-") +'</td><th>End Use</th><td>'+ ((res.end_use) ? res.end_use : "-") +'</td></tr>';
            html += '<tr><th>LW Score</th><td>-</td><th>Scheme</th><td>-</td></tr>';
            html += '<tr><th>Eligible FOIR %</th><td>'+ ((res.eligible_foir_percentage) ? res.eligible_foir_percentage : "-") +'</td><th>Eligible Loan</th><td>'+ ((res.eligible_loan) ? res.eligible_loan : "-") +'</td></tr>';
            html += '<tr><th>Loan Applied (Rs.)</th><td>-</td><th>Loan Recommended (Rs.)</th><td>'+ res.loan_recommended +'</td></tr>';
            html += '<tr><th>Final FOIR %</th><td>'+ ((res.final_foir_percentage) ? res.final_foir_percentage : "-") +'</td><th>FOIR ENHANCED BY %</th><td>'+ ((res.foir_enhanced_by) ? res.foir_enhanced_by : "-") +'</td></tr>';
            html += '<tr><th>Admin Fee (%)</th><td>'+ ((res.processing_fee_percent) ? res.processing_fee_percent : "-") +'</td><th>ROI (%)</th><td>'+ ((res.roi) ? res.roi : "-") +'</td></tr>';
            html += '<tr><th>Admin Fee (Rs.)</th><td>'+ ((res.adminFee) ? res.adminFee : "-") +'</td><th>Disbursal Date</th><td>'+ ((res.disbursal_date) ? res.disbursal_date : "-") +'</td></tr>';
            html += '<tr><th>GST @18.00 %</th><td>'+ ((res.adminFeeWithGST) ? res.adminFeeWithGST : "-") +'</td><th>Repay Date</th><td>'+ ((res.repayment_date) ? res.repayment_date : "-") +'</td></tr>';
            html += '<tr><th>Total Admin Fee (Rs.)</th><td>'+ ((res.total_admin_fee) ? res.total_admin_fee : "-") +'</td><th>Tenure (days)</th><td>'+ ((res.tenure) ? res.tenure : "-") +'</td></tr>';
            html += '<tr><th>Net Disb. Amount (Rs.)</th><td>'+ ((res.net_disbursal_amount) ? res.net_disbursal_amount : "-") +'</td><th>Repay Amount (Rs.)</th><td>'+ ((res.repayment_amount) ? res.repayment_amount : "-") +'</td></tr>';
            html += '<tr><th>Penal ROI</th><td>'+ ((res.panel_roi) ? res.panel_roi : "-") +'</td><th>B2B Disbursal</th><td>'+ ((res.b2b_disbursal) ? res.b2b_disbursal : "-") +'</td></tr>';
            html += '<tr><th>B2B NO.</th><td>'+ ((res.b2b_number) ? res.b2b_number : "-") +'</td><th>Deviations</th><td>'+ ((res.deviationsApprovedBy) ? res.deviationsApprovedBy : "-") +'</td></tr>';
            html += '<tr><th>Note</th><td colspan="3">'+ res.remark +'</td></tr>';

            html += '</tbody>';
            html += '</table>';
        $('#ViewCAMDetails').html(html);
    }

    $(document).ready(function(){

        $('#addharAddressSameasAbove').click(function(){
            if($('#addharAddressSameasAbove').prop('checked')){
                $('#addharAddressSameasAbove').val("YES");
                $("#hfBulNo2").val($("#hfBulNo1").val());
                $("#lcss2").val($("#lcss1").val());
                $("#landmark2").val($("#landmark1").val());
                $("#state2").val($("#state1").val());
                $("#city2").val($("#city1").val());
                $("#pincode2").val($("#pincode1").val());
                $("#district2").val($("#district1").val());
            }else{
                $('#addharAddressSameasAbove').val("NO");
                $("#hfBulNo2").val('-');
                $("#lcss2").val('-');
                $("#landmark2").val('-');
                $("#state2").val('-');
                $("#city2").val('-');
                $("#pincode2").val('-');
                $("#district2").val('-');
            }
        });
        
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
                    $('#customer_bank_name').val(response.bank_name);
                    $('#customer_bank_branch').val(response.bank_branch);
                }
            });
        });

        $('#state').change(function() {
            var state_id = $(this).val();
            if (state_id != '') {
                $.ajax({
                    url: "<?= base_url('getCity/'); ?>" +state_id,
                    type: "POST",
                    data : {csrf_token},
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
            var roi = $('#roi').val();
            tenureAndRepaymentAmount(disbursal_date, repayment_date, roi);
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
            var roi = $('#roi').val();
            tenureAndRepaymentAmount(disbursal_date, repayment_date, roi);
        });

        $('#bankA_C_No, #confBankA_C_No').keyup(function() {
            $(this).attr("maxLength", "19");
            var value = $(this).val();
            value = value.replace(/\D/g, "").split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join(" ");
            $(this).val(value);
        });

    });

    function checkLoanEligibility()
    {
        if($('#loan_recommended').val() > $('#loan_applied').val()){
            $('#loan_recommended').val($('#loan_applied').val());
        }
        var camFormData = $('#FormSaveCAM').serialize();
        $.ajax({
            url : '<?= base_url("checkLoanEligibility") ?>',
            type : 'POST',
            dataType : "json",
            data : camFormData,
            success : function(response){
                $('#eligible_foir_percentage').val(response.eligible_foir_percentage);
                $('#final_foir_percentage').val(response.final_foir_percentage);
                $('#eligible_loan').val(response.eligible_loan);
            }
        });
    }

    function calculateAmount()
    {
        if($('#loan_recommended').val() > $('#loan_applied').val()){
            $('#loan_recommended').val($('#loan_applied').val());
        }
        var camFormData = $('#FormSaveCAM').serialize();
        $.ajax({
            url : '<?= base_url("calculateAmount") ?>',
            type : 'POST',
            dataType : "json",
            data : camFormData,
            success : function(response){
                console.log(response);
                $('#tenure').val(response.tenure);
                $('#admin_fee').val(response.admin_fee);
                $('#repayment_amount').val(response.repayment_amount);
                $('#adminFeeWithGST').val(response.adminFeeWithGST);
                $('#total_admin_fee').val(response.total_admin_fee);
                $('#net_disbursal_amount').val(response.net_disbursal_amount);
            }
        });
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
        }
    }

    function UpdatePayment() 
    {
        var FormData = $("#FormUpdatePayment").serialize();
        $.ajax({
            url : '<?= base_url("UpdatePayment") ?>',
            type : 'POST',
            data : FormData,
            dataType : "json",
            beforeSend: function() {
                $('#UpdatePayment').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
            },
            success : function(response){
                if(response.errSession){
                    window.location.href="<?= base_url() ?>";
                } else if(response.msg){
                    $("#UpdatePayment")[0].reset();
                    catchSuccess(response.msg);
                }else{
                    catchError(response.err);
                }
            },
            complete: function() {
                $('#UpdatePayment').html('Update').prop('disabled', false);
            },
        });
    }

</script>

<script>
    $(document).ready(function(){
        $('#docsform').hide();
        $('#btnFormSaveCAM').click(function(){
            
            <?php if(company_id == 1 && product_id == 1){ ?>
                var url = 'savePaydayCAMDetails';
            <?php } if(company_id == 1 && product_id == 2){ ?>
                var url = 'saveLACCAMDetails';
            <?php } ?>
            $.ajax({
                url : '<?= base_url() ?>' + url,
                type : 'POST',
                dataType : "json",
                data : $('#FormSaveCAM').serialize(),
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

        $('#btnCAM_Approve').on('click', function(){
            var lead_id = $('#lead_id').val();
            $.ajax({
                url : '<?= base_url("headCAMApproved/") ?>'+lead_id,
                type : 'POST',
                data : {csrf_token},
                dataType : "json",
                beforeSend: function() {
                    $('#btnCAM_Approve').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
                },
                success : function(response){
                    if(response.notification){
                        catchNotification(response.notification);
                    } else if(response.msg){
                        catchSuccess(response.msg);
                        // window.location.reload();
                        history.back(1);
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#btnCAM_Approve').html('Sanction').prop('disabled', false);
                }
            });
        });

        $('#formUpdateReferenceNo').submit(function(e) {
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
                    if(response.errSession) {
                        window.location.href="<?= base_url() ?>";
                    } else if(response.msg) {
                        catchSuccess(response.msg);
                        history.back(1);
                    } else {
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#updateReferenceNo').html('Update Reference');
                },
            });   
        });

        $('#saveCustomerDetails').on('click', function(){
            var FormSaveCustomerDetails = $('#FormSaveCustomerDetails').serialize();
            $.ajax({
                url : '<?= base_url("saveCustomerPersonalDetails") ?>',
                type : 'POST',
                data : FormSaveCustomerDetails,
                dataType : "json",
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

        $('#selectDocsTypes').on('click', function(){
            var radioval = $("input[name='selectdocradio']:checked").val() 
            $("#docuemnt_type").val(radioval);
            $('#docsform').show();

            const api_url = "<?= base_url('getDocumentSubType/') ?>"+ radioval;
            var field = $('#document_name');
            showLoader(field);
            getDocumentSubType(api_url);
        }) ;  

        $('#formUserDocsData').submit(function(e){
            var lead_id = $('#leadIdForDocs').val();
            var customer_id = $('#customer_id').val();
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
                            $('#docs_id').val('');
                        } 
                        catchSuccess("Document Uploaded Successfully."); 
                        $('#formUserDocsData').trigger("reset");
                        $('input[name="selectdocradio"]').attr('checked', false);
                        $('#docsform').hide();
                    }else{ 
                        catchError(response);
                    }
                }
            });
        });
		
		$("#insertVerification").on('submit', function(e) {
			e.preventDefault();

            if($('#initiateMobileVerification').is(':checked'))
            {
             var initiateMobileVerification='YES';
            }
            else 
            { 
                var initiateMobileVerification='NO';
            }

            if($('#residenceCPV').is(':checked'))
            {
             var residenceCPV='YES';
            }
            else 
            { 
                var residenceCPV='NO';
            }

            if($('#officeEmailVerification').is(':checked'))
            {
             var officeEmailVerification='YES';
            }
            else 
            { 
                var officeEmailVerification='NO';
            }

            if($('#officeCPV').is(':checked'))
            {
             var officeCPV='YES';
            }
            else 
            { 
                var officeCPV='NO';
            }

			
            var params = {
                PANverified			             :$("#PANverified").val(),
                BankStatementSVerified	         :$("#BankStatementSVerified").val(),
				enterOTPMobile			         :$("#enterOTPMobile").val(),
                lead_id			                 :$("#lead_id").val(),
                initiateMobileVerification		 :initiateMobileVerification,
                residenceCPV		             :residenceCPV,
                officeEmailVerification			 :officeEmailVerification,
                officeCPV			             :officeCPV
                
			}

            $.post('<?= base_url("saveVerification"); ?>', {
                data: params,csrf_token
    		}, function(data, status) {
                setTimeout(function(){
                    location.reload();
                }, 2000);
    		});     
    	});	
    });	
    
</script>
<script> 
    async function getDocumentSubType(url) {
        const response = await fetch(url);
        var data = await response.json();
        var field = $('#document_name');
        if (response) {
            hideLoader(field);
        }
        field.empty();
        field.append('<option value="">SELECT</option>');
        data.forEach(function (index) {
            field.append('<option value='+ index.docs_sub_type +'>'+ index.docs_sub_type +'</option>');
        });
    }

    function showLoader(field) {
        field.html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
    }
    function hideLoader(field) {
        field.prop('disabled', false);
    }

    $(document).ready(function(){
		$("#savePersonal").on('click',function(e) {
            var FormData = $("#insertPersonal").serialize();
            $.ajax({
                url : '<?= base_url("insertPersonal") ?>',
                type : 'POST',
                data : FormData,
                dataType : "json",
                beforeSend: function() {
                    $('#savePersonal').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
                },
                success : function(response){
                    if(response.msg){
                        getPersonalDetails($('#lead_id').val());
                        catchSuccess(response.msg);
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#savePersonal').html('Save').prop('disabled', false);
                },
            });
        });

        $("#saveResidence").on('click',function(e) {
            var FormData = $("#insertResidence").serialize();
            $.ajax({
                url : '<?= base_url("insertResidence") ?>',
                type : 'POST',
                data : FormData,
                dataType : "json",
                beforeSend: function() {
                    $('#saveResidence').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
                },
                success : function(response){
                    if(response.msg){
                        getResidenceDetails($('#lead_id').val());
                        catchSuccess(response.msg);
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#saveResidence').html('Save').prop('disabled', false);
                },
            });
        });

        $("#saveEmployment").on('click',function(e) {
            var FormData = $("#insertEmployment").serialize();
            $.ajax({
                url : '<?= base_url("insertEmployment") ?>',
                type : 'POST',
                data : FormData,
                dataType : "json",
                beforeSend: function() {
                    $('#saveEmployment').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
                },
                success : function(response){
                    if(response.msg){
                        getEmploymentDetails($('#lead_id').val());
                        catchSuccess(response.msg);
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#saveEmployment').html('Save').prop('disabled', false);
                },
            });
        });

        $("#saveReference").on('click',function(e) {
            var FormData = $("#insertReference").serialize();
            $.ajax({
                url : '<?= base_url("insertReference") ?>',
                type : 'POST',
                data : FormData,
                dataType : "json",
                beforeSend: function() {
                    $('#saveReference').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
                },
                success : function(response){
                    if(response.msg){
                        catchSuccess(response.msg);
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#saveReference').html('Save').prop('disabled', false);
                },
            });
        });

        $("#saveBeneficiary").on('click',function(e) {
            var FormData = $("#addBeneficiary").serialize();
            $.ajax({
                url : '<?= base_url("addBeneficiary") ?>',
                type : 'POST',
                data : FormData,
                dataType : "json",
                beforeSend: function() {
                    $('#saveBeneficiary').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
                },
                success : function(response){
                    if(response.msg){
                        getCustomerBanking($('#customer_id').val());
                        $("#addBeneficiary")[0].reset();
                        catchSuccess(response.msg);
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#saveBeneficiary').html('Save').prop('disabled', false);
                },
            });
        });

        $("#allowDisbursalToBank").on('click',function(e) {
            var FormData = $("#disbursalPayableDetails").serialize();
            $.ajax({
                url : '<?= base_url("allowDisbursalToBank") ?>',
                type : 'POST',
                data : FormData,
                dataType : "json",
                beforeSend: function() {
                    $('#allowDisbursalToBank').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
                },
                success : function(response){
                    if(response.msg){
                        getCustomerBanking($('#customer_id').val());
                        $("#verifyDisbursalBank")[0].reset();
                        catchSuccess(response.msg);
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#allowDisbursalToBank').html('Save').prop('disabled', false);
                },
            });
        });

        $("#formUpdateReferenceNo").on('submit',function(e) {
            var FormData = $("#formUpdateReferenceNo").serialize();
            $.ajax({
                url : '<?= base_url("UpdateDisburseReferenceNo") ?>',
                type : 'POST',
                data : FormData,
                dataType : "json",
                beforeSend: function() {
                    $('#updateReferenceNo').html('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>Processing...').prop('disabled', true);
                },
                success : function(response){
                    if(response.errSession) {
                        window.location.href="<?= base_url() ?>";
                    } else if(response.msg) {
                        catchSuccess(response.msg);
                        history.back(1);
                    }else{
                        catchError(response.err);
                    }
                },
                complete: function() {
                    $('#updateReferenceNo').html('Update Reference').prop('disabled', false);
                },
            });
        });

    });	
</script>
