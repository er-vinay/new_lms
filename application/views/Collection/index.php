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
                                                    <h4>Task Lists</h4>
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="head">LEAD APPROVALS 
                                                                <span><?= $taskCount; ?></span>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="widget-container" style="margin-top: 40px;">
                                                    <div class=" widget-block">
                                                        <div class="row">
                                                            <!--<div class="table-responsive">-->
                                                                <div class="scroll_on_x_axis">
                                                                    <table class="table dt-table table-striped table-bordered table-responsive table-hover" data-order='[[ 0, "desc" ]]' style="border: 1px solid #dde2eb">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="fixed-tb-column"><b>#</b></th>
                                                                                <th><b>Action</b></th>
                                                                                <th><b>Application No</b></th>
                                                                                <th class="fixed-tb-column"><b>Loan No</b></th>
                                                                                <th><b>Borrower Name</b></th> 
                                                                                <th><b>Mobile</b></th>
                                                                                <th><b>Branch</b></th>
                                                                                <th><b>Loan Approved Amount</b></th>
                                                                                <th><b>Loan Tenure</b></th>
                                                                                <th><b>Loan Intrest</b></th>
                                                                                <th><b>Loan Repay Amount</b></th>
                                                                                <th><b>Loan Repay Date</b></th>
                                                                                <th><b>Loan Disburse Date</b></th>
                                                                                <th><b>Proceed by</b></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach($listTask as $row) : ?>
                                                                            <tr>
                                                                                <td style="width : auto;">
                                                                                    <?= $row->lead_id; ?>
    
                                                                                    <?php if($row->partPayment > 0){ ?>
                                                                                        <div class="animateWarning"></div>
                                                                                    <?php } ?>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="#" onclick="viewLeadsDetails('<?= $row->lead_id; ?>')" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" title="View Costomer Details"></i></a>
                                                                                </td>
                                                                                <td></td>
                                                                                <td><a href="<?= base_url('CustomerFollowUp/'.$row->lead_id) ?>" target="_blank"><?= $row->loan_no; ?></a></td>
                                                                                <td><?= $row->name; ?></td> 
                                                                                <td><?= $row->mobile; ?></td>
                                                                                <td><?= $row->state; ?></td>
                                                                                <td><?= $row->loan_amount_approved ?></td>
                                                                                <td><?= $row->loan_tenure ?></td>
                                                                                <td><?= $row->loan_intrest ?></td>
                                                                                <td><?= $row->loan_repay_amount ?></td>
                                                                                <td><?= $row->loan_repay_date ?></td>
                                                                                <td><?= $row->loan_disburse_date ?></td>
                                                                                <td>
                                                                                    <?php if($row->userChecked > 0){ 
                                                                                        $query = $this->db->select('users.name')->where('user_id', $row->userChecked)->get('users')->row();
                                                                                    ?>
                                                                                    
                                                                                        <p class="text-success" title="<?= $query->name; ?>"><?= $query->name; ?></p>
                                                                                    <?php }else{ echo "Pending";} ?>
                                                                                </td>
                                                                            </tr>
                                                                            <?php endforeach; ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            <!--</div>-->
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

<!--<div id="myModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">-->
<!--    <div class="modal-dialog modal-lg" role="document" style="margin-top : 20px; background: #fff;">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h5 class="modal-title" id="exampleModalLongTitle">...</h5><hr>-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                <span aria-hidden="true">&times;</span>-->
<!--                </button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->

<!--                <input type="hidden" class="form-control" name="lead_id" id="lead_id" readonly>-->
                <!-- lead Details -->
<!--                <div id="LeadDetails"></div>-->

                <!-- contact details -->
<!--                <div class="footer-support">-->
<!--                    <h2 class="footer-support">Contact Details &nbsp;<i class="fa fa-angle-double-down"></i></h2>-->
<!--                </div>-->
<!--                <div id="viewContactDetails"></div>-->

                <!-- Customer Employment details -->
<!--                <div class="footer-support">-->
<!--                    <h2 class="footer-support">Customer Employment Details &nbsp;<i class="fa fa-angle-double-down"></i></h2>-->
<!--                </div>  -->
<!--                <div id="ShowCustomerEmploymentDetails"></div>-->

                <!-- old History -->
<!--                <div class="footer-support">-->
<!--                    <h2 class="footer-support">Old Leads History &nbsp;<i class="fa fa-angle-double-down"></i></h2>-->
<!--                </div>-->
<!--                <div id="oldTaskHistory"></div>-->

                <!-- credit History -->
<!--                <div class="footer-support">-->
<!--                    <h2 class="footer-support" id="credit">Credit History &nbsp;<i class="fa fa-angle-double-down"></i></h2>-->
<!--                </div>-->
<!--                <div id="viewCredit"></div>-->

                <!-- docs History -->
<!--                <div class="footer-support">-->
<!--                    <input type="hidden" name="leadIdForDocs" id="leadIdForDocs">-->
<!--                    <h2 class="footer-support">Documents &nbsp;<i class="fa fa-angle-double-down"></i></h2>-->
<!--                </div>-->
<!--                <div id="docsHistory"></div>-->

                <!-- Customer Bank Details -->
<!--                <div class="footer-support">-->
<!--                    <h2 class="footer-support">Customer Bank Details &nbsp;<i class="fa fa-angle-double-down"></i></h2>-->
<!--                </div><hr>-->
<!--                <div id="disbursalData"></div>-->

                <!-- loan Status -->
<!--                <div id="collection">-->
<!--                    <div class="footer-support">-->
<!--                        <input type="hidden" name="leadIdForDocs" id="leadIdForDocs">-->
<!--                        <h2 class="footer-support">Loan Status &nbsp;<i class="fa fa-angle-double-down"></i></h2>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div id="loanStatus"></div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- footer -->
<?php $this->load->view('Layouts/footer') ?>
<?php $this->load->view('Tasks/task_js.php') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
    $(document).ready(function(){
        $("#customer_account_no, #customer_confirm_account_no, #disburse_amount").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
               return false;
            }
        });
    });
</script>

