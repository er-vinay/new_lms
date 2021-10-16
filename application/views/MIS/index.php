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
                                                    <div class="head">LEAD DISBURSAL 
                                                        <span><?= $MIS->num_rows(); ?></span>
                                                    </div>
                                                </div>
                                                <div class="widget-container">
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
                                                                            <th><b>Recovery Status</b></th>
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
                                                                            <td><?= $row->recovery_status; ?></td>
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