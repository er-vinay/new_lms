<?php $this->load->view('Layouts/header') ?>
 
<!-- section start -->

<section>
    <div class="container-fluid">
        <div class="taskPageSize taskPageSizeDashboard">
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
                    <div class="page-container list-menu-view">
                        <div class="page-content">
                            <div class="main-container">
                                <div class="container-fluid">
                                    <div class="col-md-12">
                                        <div class="login-formmea">
                                            <div class="box-widget widget-module"> 
                                                    <div class="widget-head clearfix">
                                                        <span class="h-icon"><i class="fa fa-th"></i></span>
                                                        <h4>Search BY</h4> 
                                                    </div>
                                                    <div class="widget-container">
                                                        <div class=" widget-block">
                                                            <div class="row">
                                                                <form id="search" enctype="multipart/form-data" class="form-inline">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <div class="form-group">
                                                                        <div class="col-md-6">
                                                                            <label class="labelField">APPLICATION No.&nbsp;</label>
                                                                            <input type="text" class="form-control inputFieldsearch" name="application_no" id="application_no" title="Application No" autocomplete="off">     
                                                                        </div>              
                                                                        <div class="col-md-6">
                                                                            <label class="labelField">LOAN No.&nbsp;</label>
                                                                            <input type="text" class="form-control inputFieldsearch" name="loan_no" id="loan_no" title="Loan No" autocomplete="off"> 
                                                                        </div> 
                                                                        <div class="col-md-6">
                                                                            <label class="labelField">NAME&nbsp;</label>
                                                                            <input type="text" class="form-control inputFieldsearch" name="name" id="name" title="Name" autocomplete="off">
                                                                        </div>  
                                                                        <div class="col-md-6">
                                                                            <label class="labelField">MOBILE&nbsp;</label>
                                                                            <input type="text" class="form-control inputFieldsearch" name="mobile" id="mobile" title="Mobile" autocomplete="off">
                                                                        </div>                                                 
                                                                        <div class="col-md-6">
                                                                            <label class="labelField">PAN&nbsp;</label>
                                                                            <input type="text" class="form-control inputFieldsearch" name="pancard" id="pancard" onchange="validatePanNumber(this)" title="Pan" autocomplete="off">     
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="labelField">AADHAR&nbsp;</label>
                                                                            <input type="text" class="form-control inputFieldsearch" name="aadhar" id="aadhar" title="Aadhar" autocomplete="off">     
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="labelField">CIF&nbsp;</label>
                                                                            <input type="text" class="form-control inputFieldsearch" name="cif" id="cif" title="CIF" autocomplete="off">     
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                             
                                                        <div calss="row" style="border: solid 1px #ddd;text-align: center; padding-top : 20px; padding-bottom: 20px;background: #f3f3f3;">
                                                            <div calss="col-md-12 text-center">
                                                                <button class="btn btn-info search" id="btnSearch"  style="text-align: center; padding-left: 50px; padding-right: 50px; font-weight: bold;">Search</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="scroll_on_x_axis">
                                                    <div class="widget-container">
                                                        <div class=" widget-block">
                                                            <div class="searchResults"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Footer Start Here -->
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</section>

<!-- footer -->

<?php $this->load->view('Layouts/footer') ?>

<?php $this->load->view('Tasks/main_js.php') ?>

<script>
    var csrf_token = $("input[name=csrf_token]").val();
    $("#toDate, #fromDate").keypress(function myfunction(event) {
        var regex = new RegExp("^[0-9?=.*!@#$%^&*]+$");               
        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }    
        return false;
    }); 

    $("#fromDate").change(function(){
        var dateTo = $("#toDate").val();
        var dateFrom = $("#fromDate").val();
        if(dateTo == "" && dateFrom == "")
        {
            $(".SearchForExport").prop('disabled', true);
        }else{
            $(".SearchForExport").prop('disabled', false);
        }

    });

    $('#loan_no, #pancard, #name, #mobile').keypress(function (e) {
        if(e.which == 13)
        {
            searchLeads(e);
        }
    });
    $('.search').click(function(e){
        e.preventDefault();
        searchLeads(e);
    });
    function searchLeads(e)
    {
        e.preventDefault();
        var csrf_token      = $("input[name=csrf_token]").val(); 
        var application_no  = $("#application_no").val(); 
        var loan_no         = $("#loan_no").val(); 
        var name            = $("#name").val(); 
        var mobile          = $("#mobile").val(); 
        var pancard         = $("#pancard").val(); 
        var aadhar          = $("#aadhar").val(); 
        var cif             = $("#cif").val(); 
        $.ajax({
            url : '<?= base_url("filter") ?>',
            type : 'POST',
            dataType : "json",
            data : {application_no :application_no, loan_no:loan_no, name:name, mobile:mobile, pancard:pancard, aadhar:aadhar, cif:cif, csrf_token},
            beforeSend: function() {
                $('#btnSearch').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Processing...').addClass('disabled', true);
            },
            success : function(response){
                $(".searchResults").html(response);
                $('#search')[0].reset();
            },
            complete: function() {
                $('#btnSearch').html('Search').removeClass('disabled'); 
            },
        });
    }

    ///////////////////////////////////////////////////////// filter and export Data ///////////////////////////////////////////////////

    function checkLeftAmount(amount)
    {
        var totalPayableAmount = $("#totalPayableAmount").text().replace(",", "");
        var totalReceived = $("#totalReceived").text().replace(",", "");
        var payableAmount = $("#payment_amount").val();
        var total = totalPayableAmount - totalReceived;
        if(payableAmount > total || payableAmount < 1 || payableAmount == total){
            $("#payment_amount").val(total);
            $('#payment_type').val("Full Payment");
        } else{
            $('#payment_type').val("Part Payment");
        }
    }

    $(document).ready(function(){
        var totalPayableAmount = $("#totalPayableAmount").val();
        var totalReceived = $("#totalReceived").val();
        $("#payment_amount").val(totalPayableAmount - totalReceived);
        $('#payment_type').val("Full Payment");
        $('#FormRecoveryAmount').submit(function(e){
            e.preventDefault();
            $.ajax({
                url : '<?= base_url("AddCollectionAmount") ?>',
                type : 'POST',
                data : new FormData(this),
                processData : false,
                contentType : false,
                cache : false,
                async : false,
                success : function(response) {
                    if(response == "name") {
                        catchError("Payment Already Added.");
                    } else {
                        catchSuccess("Payment Added Successfully.");
                        window.location.reload();
                    }
                }
            });
        });
    });

    function MIS()
    {
        $.ajax({
            url : '<?= base_url("filter") ?>',
            type : 'POST',
            dataType : "json",
            data : filter,
            async: false,
            success : function(response){
                $(".searchResults").html(response);
                // $('#search')[0].reset();
            }
        });
    }
</script>