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
                                    <div class="col-md-8">
                                        <div class="login-formmea">
                                            <div class="box-widget widget-module">
                                                <div class="widget-head clearfix">
                                                    <span class="h-icon"><i class="fa fa-th"></i></span>
                                                    <h4>Follow Up &nbsp;&nbsp;&nbsp;</h4>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div style="margin-top: 10px;">
                                                            <select class="form-control form-control-sm" name="">
                                                                <option value="">Select Follow Up</option>
                                                                <option value="Send SMS"><i class="fa fa-phone" style="color: red;"></i> Call</option>
                                                                <option value="Send SMS"><i class="fa fa-mobile-alt" style="color: red;"></i>Send SMS</option>
                                                                <option value="Send SMS"><i class="fa fa-plane" style="color: red;"></i>Send Email</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <div class="row">
                                                            <div class="table-responsive">
                                                                <table class="table dts-table table-striped table-bordered table-hover">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <td><?= $customerDetails->lead_id; ?></td>

                                                                            <th>Customer Id</th>
                                                                            <td><?= $customerDetails->customer_id; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th>Loan No</th>
                                                                            <td><?= $customerDetails->loan_no; ?></td>

                                                                            <th>BorcustomerDetailser Name</th>
                                                                            <td><?= $customerDetails->name; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th>Email</th>
                                                                            <td><?= $customerDetails->email; ?></td>

                                                                            <th>Mobile</th>
                                                                            <td><?= $customerDetails->mobile; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th>Branch</th>
                                                                            <td><?= $customerDetails->state; ?></td>

                                                                            <th>Center</th>
                                                                            <td><?= $customerDetails->state; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th>Lead Source</th>
                                                                            <td><?= $customerDetails->source; ?></td>

                                                                            <th>Loan Approved Amount</th>
                                                                            <td><?= $customerDetails->loan_amount_approved ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Loan Tenure</th>
                                                                            <td><?= $customerDetails->loan_tenure ?></td>

                                                                            <th>Loan Intrest</th>
                                                                            <td><?= $customerDetails->loan_intrest ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Loan Repay Amount</th>
                                                                            <td><?= $customerDetails->loan_repay_amount ?></td>

                                                                            <th>Loan Repay Date</th>
                                                                            <td><?= $customerDetails->loan_repay_date ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Loan Disburse Date</th>
                                                                            <td><?= $customerDetails->loan_disburse_date ?></td>

                                                                            <th>Proceed by</th>
                                                                            <td>
                                                                                <?php if($customerDetails->userChecked > 0){ 
                                                                                    $query = $this->db->select('users.name')->where('user_id', $customerDetails->userChecked)->get('users')->row();
                                                                                ?>
                                                                                
                                                                                    <p class="text-success" title="<?= $query->name; ?>"><?= $query->name; ?></p>
                                                                                <?php }else{ echo "Pending";} ?>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="login-formmea">
                                            <div class="box-widget widget-module">
                                                <div class="widget-head clearfix">
                                                    <span class="h-icon"><i class="fa fa-th"></i></span>
                                                    <h4>Customer Details</h4>
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <div class="row">
                                                            <div class="table-responsive">
                                                                <table class="table dts-table table-striped table-bordered table-hover">
                                                                    <tbody>
                                                                        <p style="text-align : center;">
                                                                            <div class="user-icons">
                                                                                <?= strtoupper(substr($customerDetails->name, 0, 1));?><?= strtoupper(substr(explode(" ", $customerDetails->name, 2)[1], 0, 1)); ?>
                                                                            </div>
                                                                        </p>
                                                                        <p style="text-align : center;">Customer Id : <?= $customerDetails->customer_id; ?></p>
                                                                        <p style="text-align : center;">Customer Name : <?= $customerDetails->name; ?></p>
                                                                        <p style="text-align : center;">Email : <span class="text-info"><?= $customerDetails->email; ?></span></p>
                                                                        <p style="text-align : center;">Mobile : <?= $customerDetails->mobile; ?></p>
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
            </div>
        </div>
    </div>
</div>

<!-- footer -->
<?php $this->load->view('Layouts/footer') ?>
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

