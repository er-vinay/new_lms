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
                                                <div class="widget-head clearfix">
                                                    <span class="h-icon"><i class="fa fa-th"></i></span>
                                                    <h4>MIS Lists</h4>
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="head">LEAD DISBURSAL 
                                                                <span><?= $MIS->num_rows(); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-container" style="margin-top: 40px;">
                                                    <div class=" widget-block">
                                                        <div class="row">
                                                            <div class="scroll_on_x_axis">
                                                                <table class="table dt-table table-striped table-bordered table-responsive table-hover" style="border: 1px solid #dde2eb">
                                                                    <thead>
                                                                        <tr>
                                                                            <th><b>#</b></th>
                                                                            <th><b>Loan No</b></th>
                                                                            <th><b>Borrower Name</b></th>
                                                                            <th><b>Email</b></th>
                                                                            <th><b>Branch</b></th>
                                                                            <th><b>Center</b></th>
                                                                            <th><b>Initiated On</b></th>
                                                                            <th><b>Lead Source</b></th>
                                                                            <th><b>Recovered Amount</b></th>
                                                                            <th><b>Loan Status</b></th>
                                                                            <th><b>Proceed by</b></th>
                                                                            <th><b>Action</b></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach($MIS->result() as $row) : ?>
                                                                        <tr>
                                                                            <td><?= $row->lead_id; ?></td>
                                                                            <td><?= $row->loan_no; ?></td>
                                                                            <td><?= $row->name; ?></td>
                                                                            <td><?= $row->email; ?></td>
                                                                            <td><?= $row->state; ?></td>
                                                                            <td><?= $row->state; ?></td>
                                                                            <td><?= $row->created_on; ?></td>
                                                                            <td><?= $row->source; ?></td>
                                                                            <td><?= $row->total_paid; ?></td>
                                                                            <td><?= $row->status; ?></td>
                                                                            <td><?= $row->recovery_by; ?></td>
                                                                            <td>
                                                                                <a href="#" onclick="viewLeadsDetails('<?= $row->lead_id; ?>')" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" title="View Costomer Details"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
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


                <!-- Recovery Status -->
                <div id="collection">
                    <div class="footer-support">
                        <input type="hidden" name="leadIdForDocs" id="leadIdForDocs">
                        <h2 class="footer-support">Recovery Status &nbsp;<i class="fa fa-angle-double-down"></i></h2>
                    </div>
                </div>
                <div id="recoveryData"></div>

                <?php if($_SESSION['isUserSession']['role'] == "Collection" ||
                        $_SESSION['isUserSession']['role'] == "Account and MIS"
                    ) { ?>

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

                            <!-- <div class="col-sm-6">
                                <label for="Upload Docs">Upload Docs <span class="required_Fields">*</span></label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div> -->

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