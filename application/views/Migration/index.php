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
                                                    <h4>Import Data</h4>
                                                    <!--<div class="head">LEAD DISBURSAL </div>-->
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <div class="row">
                                                            <form autocomplete="off" action="<?= base_url('import_Loan_data'); ?>" id="get_form_data" method="post" enctype="multipart/form-data" >
                                            
                                                                <div class="row">
                                                                    <!--<div class="col-md-12">-->
                                                                    <!--    <div class="form-group">-->
                                                                    <!--        <div class="row">-->
                                                                    <!--            <div class="col-md-2">-->
                                                                    <!--                <label class="col-form-label col-form-label-sm" for="Name">Person Name</label>-->
                                                                    <!--            </div>-->
                                                                    <!--            <div class="col-md-10">-->
                                                                    <!--                <input type="text" class="form-control" name="name" id="name" placeholder="Data Person Name" title="Data Person Name" required="">-->
                                                                    <!--            </div>-->
                                                                    <!--        </div>-->
                                                                    <!--    </div>-->
                                                                    <!--</div>-->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-md-2">
                                                                                    <label class="col-form-label col-form-label-sm" for="File">Import CSV</label>
                                                                                </div>
                                                                                <div class="col-md-10">
                                                                                    <input type="file" class="form-control form-control-sm" name="csv_file" id="csv_file" value="" title="Import CSV" placeholder="Import CSV" required="" accept=".csv">
                                                                                    Ex. Allowed .csv file only
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                    
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-10"></div>
                                                                        <div class="col-md-2">
                                                                            <button type="submit" class="btn btn-primary" id="add_query" title="Import Old Data" style="float: right;">Import CSV</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
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
