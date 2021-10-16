<?php $this->load->view('Layouts/header') ?>
<?php 
    $url = $this->uri->segment(1); 
    $report = $this->uri->segment(2);
 ?>
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
                                                <?php if($url != 'exportData'){ ?>
                                                    <div class="widget-head clearfix">
                                                        <span class="h-icon"><i class="fa fa-th"></i></span>
                                                        <h4>Search BY</h4>
                                                        
                                                    </div>
                                                    <div class="widget-container">
                                                        <div class=" widget-block">
                                                            <div class="row">
                                                                <form id="search" method="post" enctype="multipart/form-data">
                                                                    <div class="col-md-2">
                                                                        <label>Loan No</label>
                                                                        <input type="text" class="form-control" name="loan_no" id="loan_no" placeholder="Loan No" title="Loan No">
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <label>Pancard</label>
                                                                        <input type="text" class="form-control" name="pancard" id="pancard" onchange="validatePanNumber(this)" placeholder="Pancard" title="Pancard">
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <label>Name</label>
                                                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" title="Name">
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <label>Mobile</label>
                                                                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile" title="Mobile">
                                                                    </div>

                                                                </form>
                                                                <div class="col-md-2">
                                                                    <button class="btn btn-info search" style="background-color : #35b7c4;margin-top: 23px;">Search</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="widget-container">
                                                        <div class=" widget-block">
                                                            <div class="searchResults"></div>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="widget-head clearfix">
                                                        <span class="h-icon"><i class="fa fa-th"></i></span>
                                                        <h4>Filter BY Date</h4>
                                                        
                                                    </div>
                                                    <div class="widget-container">
                                                        <div class=" widget-block">
                                                            <div class="row">
                                                                <form action="<?= base_url('exportReport') ?>" method="post" enctype="multipart/form-data">
                                                                    <input type="hidden" name="exportUrl" id="exportUrl" value="<?= $url; ?>">
                                                                    <input type="hidden" name="exportReport" id="exportReport" value="<?= $report; ?>">

                                                                    <div class="col-md-2">
                                                                        <label>To Date</label>
                                                                        <input type="text" class="form-control" name="toDate" id="toDate" title="To Date">
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <label>From Date</label>
                                                                        <input type="text" class="form-control" name="fromDate" id="fromDate" title="From Date">
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <button class="btn btn-info SearchForExport" style="background-color : #35b7c4;margin-top: 23px;"><i class="fa fa-search"></i> &nbsp;Search</button>
                                                                        <button class="btn btn-info SearchForExport" style="background-color : #35b7c4;margin-top: 23px;"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp;Export</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
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

<div id="myModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="margin-top : 20px; background: #fff;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">...</h5><hr>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" class="form-control" name="lead_id" id="lead_id" readonly>
                <!-- lead Details -->
                <div id="LeadDetails"></div>

                <!-- contact details -->
                <div class="footer-support">
                    <h2 class="footer-support">Contact Details &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                </div>
                <div id="viewContactDetails"></div>

                <!-- Customer Employment details -->
                <div class="footer-support">
                    <h2 class="footer-support">Customer Employment Details &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                </div>  
                <div id="ShowCustomerEmploymentDetails"></div>

                <!-- old History -->
                <div class="footer-support">
                    <h2 class="footer-support">Old Leads History &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                </div>
                <div id="oldTaskHistory"></div>

                <!-- credit History -->
                <div class="footer-support">
                    <h2 class="footer-support" id="credit">Credit History &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                </div>
                <div id="viewCredit"></div>

                <!-- docs History -->
                <div class="footer-support">
                    <input type="hidden" name="leadIdForDocs" id="leadIdForDocs">
                    <h2 class="footer-support">Documents &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                </div>
                <div id="docsHistory"></div>

                <!-- Customer Bank Details -->
                <div class="footer-support">
                    <h2 class="footer-support">Customer Bank Details &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                </div><hr>
                <div id="disbursalData"></div>

                <!-- loan Status -->
                <div id="collection">
                    <div class="footer-support">
                        <input type="hidden" name="leadIdForDocs" id="leadIdForDocs">
                        <h2 class="footer-support">Loan Status &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                    </div>
                </div>
                <div id="loanStatus"></div>


                <?php if($_SESSION['isUserSession']['role'] == "Collection") { ?>
                    <div id="collection">
                        <div class="footer-support">
                            <h2 class="footer-support">Update Payment &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                        </div>
                    </div>
                
                    <form id="FormRecoveryAmount" method="post" enctype="multipart/form-data">
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
                                    <option value="ICICI UPI">ICICI UPI</option>
                                    <option value="eNACH">eNACH</option>
                                    <option value="PayTM">PayTM</option>
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label for="Payment Type">Payment Type <span class="required_Fields">*</span></label>
                                <select class="form-control" name="payment_type" id="payment_type">
                                    <option value="">Select Payment Type</option>
                                    <option value="Full Payment">Full Payment</option>
                                    <option value="Part Payment">Part Payment</option>
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
                                <button class="btn btn-primary">PAYMENT RECIVED</button>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- footer -->
<?php $this->load->view('Layouts/footer') ?>
<?php $this->load->view('Tasks/task_js.php') ?>
<script>
    $("#toDate, #fromDate").keypress(function myfunction(event) {
        var regex = new RegExp("^[0-9?=.*!@#$%^&*]+$");               
        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
         if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }              
        return false; 
    });
    $("#fromDate, .SearchForExport").prop('disabled', true);
    $("#toDate").datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true,
        startView: 2,
        endDate : Date(),
    });

    $("#toDate").change(function(){
        var todate = $(this).val();
        $("#fromDate").prop('disabled', false);
        $("#fromDate").datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,
            startView: 2,
            startDate : todate,
            endDate : Date(),
        });
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
    $('.search').click(function(e){
        e.preventDefault();
        const filter = $('#search').serialize();
        console.log(filter);
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
    });

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