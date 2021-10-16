<?php $this->load->view('Layouts/header') ?>
<?php $url =  $this->uri->segment(1); ?>
<span id="response" style="width: 100%;float: left;text-align: center;padding-top:-20%;"></span>
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
                <div class="col-md-12" style="padding: 0px !important;">
                    <div class="page-container list-menu-view">
                        <div class="page-content">
                            <div class="main-container">
                                <div class="container-fluid">
                                    <div class="col-md-12">
                                        <div class="login-formmea">
                                            <div class="box-widget widget-module">
                                                <div class="widget-head clearfix">
                                                    <span class="h-icon"><i class="fa fa-th"></i></span>
                                                    <span class="inner-page-tag">Applications New</span> 
                                                        <span class="counter inner-page-box"><?= $leadDetails->num_rows(); ?></span>
                                                        <?php //if($_SESSION['isUserSession']['role'] =="Tellecaller"){ ?>
                                                        <a  class="btn inner-page-box" id="checkDuplicateItem" style="background: #0d7ec0 !important;">Duplicate</a>
                                                        <a  class="btn inner-page-box" id="allocate" style="background: #0d7ec0 !important;">Allocate</a> 
                                                        <?php //} ?>
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <div class="row">
                                                            <div class="scroll_on_x_axis table-responsive">
                                                                <table class="table dt-table table-striped table-bordered table-hover" data-order='[[ 0, "desc" ]]' style="border: 1px solid #dde2eb">
                                                                    <thead>
                                                                        <tr>
                                                                            <th><b>Sr. No</b></th>
                                                                            <th><b>Action</b></th>
                                                                            <th><b>Application No</b></th>
                                                                            <th><b>Borrower</b></th>
                                                                            <th><b>State</b></th>
                                                                            <th><b>City</b></th>
                                                                            <th><b>Mobile</b></th>
                                                                            <th><b>Email</b></th>
                                                                            <th><b>PAN</b></th>
                                                                            <th><b>Source</b></th>
                                                                            <th><b>Status</b></th>
                                                                            <th><b>Initiated On</b></th>
                                                                            
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $i = 1; foreach($leadDetails->result() as $row) : ?>
                                                                        <tr>
                                                                            <td><?= $i ?></td>
                                                                            <td>
                                                                                <div style="display: flex;">
                                                                                    <input class="btn btn-primary btn-sm duplicate_id" type="checkbox" name="duplicate_id[]" id='duplicate_id<?= $i ?>' value="<?= $row->lead_id; ?>">&nbsp;</br>
                                                                                      
                                                                                    <!--<a style="font-size: 16px;" onclick="viewLeadsDetails('<?= $row->lead_id; ?>')" id="viewLeadsDetails" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" title="View Costomer Details"></i></a>-->
                                                                                </div>
                                                                            </td> 
                                                                            <td></td>
                                                                            <td><?= strtoupper($row->name ." ". $row->middle_name ." ". $row->sur_name) ?></td>
                                                                            <td><?= strtoupper($row->state) ?></td>
                                                                            <td><?= strtoupper($row->city) ?></td>
                                                                            <td><?= $row->mobile; ?></td>
                                                                            <td><?= $row->email; ?></td>
                                                                            <td><?= strtoupper($row->pancard) ?></td>
                                                                            <td><?= $row->source; ?></td> 
                                                                            <td><?php echo $status = ($row->status == "New Leads" ? "New" : $row->status); ?></td> 
                                                                            <td><?= date('d-m-Y', strtotime($row->created_on)) ?></td> 
                                                                        </tr>
                                                                        <?php $i++; endforeach; ?>
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
<?php $this->load->view('Tasks/main_js.php') ?>