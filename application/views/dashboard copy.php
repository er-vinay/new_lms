<?php $this->load->view('Layouts/header') ?>

<!-- section start -->
<section>
    <!-- <div class="alert alert-dismissible alert-danger" id="div-error-message">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Oh snap!</strong> 
        <a href="#" class="alert-link"></a> Session expired!
    </div> -->
    

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Tasks</li>
                </ol>
            </div>
        </div>
        <div class="pageSize">
            <div class="row">
                <div class="col-md-2">
                    <a href="<?= base_url('GetLeadTaskList') ?>">
                        <div class="lead-box text-center">
                            <div class="text-center">
                                <i class="fa fa-paper-plane-o"></i>
                            </div>
                                <span>Leads</span>
                                <strong>10</strong>
                            <div calss="tabname">
                            </div>
                            <div calss="tabcounter">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- footer -->
<?php $this->load->view('Layouts/footer') ?>