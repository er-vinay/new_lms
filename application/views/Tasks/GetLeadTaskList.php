<?php $this->load->view('Layouts/header') ?>
<?php 
    $stage =  $this->uri->segment(2);
    
?>
<span id="response" style="width: 100%;float: left;text-align: center;padding-top:-20%;"></span>
<section>
    <div class="width-my">
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
                                                    <span class="inner-page-tag">Leads</span> 
                                                    <span class="counter inner-page-box"><?= $leadDetails->num_rows(); ?></span>
                                                    <?php if($stage == "S1" || $stage == "S4" ){ ?>
                                                    <a  class="btn inner-page-box checkDuplicateItem" id="checkDuplicateItem" style="background: #0d7ec0 !important;">Duplicate</a>
                                                    <a  class="btn inner-page-box" id="allocate" style="background: #0d7ec0 !important;">Allocate</a> 
                                                    <?php } ?>
                                                    <div class="tb_search">
                                                        <select class="form-control" id='selectRecord' onchange="location = this.value;">
                                                            <option value="<?= $pageURL ?>/10">10</option>
                                                            <option value="<?= $pageURL ?>/20/-">20</option>
                                                            <option value="<?= $pageURL ?>/30/-">30</option>
                                                            <option value="<?= $pageURL ?>/40/-">40</option>
                                                            <option value="<?= $pageURL ?>/50/-">50</option>
                                                        </select>
                                                        <input type='text' class="form-control" id='txt_searchall' placeholder='Enter search text'>
                                                    </div>
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <div class="row">
                                                            <div class="table-responsive">
                                                                <!-- data-order='[[ 0, "desc" ]]'  dt-table -->
                                                                <table class="table table-striped table-bordered table-hover"  style="border: 1px solid #dde2eb">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="whitespace data-fixed-columns"><b>Sr.&nbsp;No</b></th>
                                                                            <th class="whitespace"><b>Action</b></th>
                                                                            <th class="whitespace"><b>CIF&nbsp;No.</b></th>
                                                                            <th class="whitespace"><b>Application&nbsp;No.</b></th>
                                                                            <th class="whitespace"><b>Loan&nbsp;No.</b></th>
                                                                            <th class="whitespace"><b>Name</b></th>
                                                                            <th class="whitespace"><b>State</b></th>
                                                                            <th class="whitespace"><b>City</b></th>
                                                                            <th class="whitespace"><b>Mobile</b></th>
                                                                            <!-- <th class="whitespace"><b>Email</b></th> -->
                                                                            <th class="whitespace"><b>PAN</b></th>
                                                                            <th class="whitespace"><b>User&nbsp;Type</b></th>
                                                                            <th class="whitespace"><b>Source</b></th>
                                                                            <th class="whitespace"><b>Status</b></th>
                                                                            <th class="whitespace"><b>Applied&nbsp;On</b></th>
                                                                            
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            if($leadDetails->num_rows() > 0){
                                                                            $sn=1; 
                                                                            foreach($leadDetails->result() as $row) : 
                                                                        ?>
                                                                        <tr>
                                                                            <td class="whitespace data-fixed-columns"><?= $sn++; ?></td>
                                                                            <td class="whitespace">
                                                                            <?php if($row->status == "LEAD-NEW" || $row->status == "APPLICATION-NEW"){ ?>
                                                                                <input type="checkbox" name="duplicate_id[]" class="duplicate_id" id="duplicate_id" value="<?= $row->lead_id; ?>">&nbsp;</br>
                                                                                <input type="hidden" name="customer_id" id="customer_id" value="<?= $row->customer_id ?>">
                                                                                <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['isUserSession']['user_id'] ?>">
                                                                            <?php }else{ ?>
                                                                                <a href="<?= base_url("getleadDetails/". $this->encrypt->encode($row->lead_id)) ?>" class="" id="viewLeadsDetails">
                                                                                    <span class="glyphicon glyphicon-edit" style="font-size: 20px;"></span>
                                                                                </a>
                                                                            <?php } ?>
                                                                            </td>
                                                                            <td class="whitespace"><?= $row->customer_id; ?></td> 
                                                                            <td class="whitespace"><?= ($row->application_no) ? strtoupper($row->application_no) : "-" ?></td>
                                                                            <td class="whitespace"><?= $row->customer_id; ?></td>
                                                                            <td class="whitespace"><?= strtoupper($row->first_name ." ". $row->middle_name ." ". $row->sur_name) ?></td>
                                                                            <td class="whitespace"><?= strtoupper($row->state) ?></td>
                                                                            <td class="whitespace"><?= strtoupper($row->city) ?></td>
                                                                            <td class="whitespace"><?= ($row->mobile) ? $row->mobile : '-' ?></td>
                                                                            <td class="whitespace"><?= ($row->pancard) ? strtoupper($row->pancard) : '-' ?></td>
                                                                            <td class="whitespace"><?= ($row->user_type) ? strtoupper($row->user_type) : '-' ?></td>
                                                                            <td class="whitespace"><?= ($row->source) ? strtoupper($row->source) : '-' ?></td>
                                                                            <td class="whitespace"><?= ($row->status) ? strtoupper($row->status) : '-' ?></td>
                                                                            <td class="whitespace"><?= date('d-m-Y h:i', strtotime($row->created_on)) ?></td> 
                                                                        </tr>
                                                                        <?php endforeach; }else{ ?>
                                                                        <tr>
                                                                            <th colspan="13" class="whitespace data-fixed text-center"><b style="color: #b73232;">No Record Found...</b></th>
                                                                        </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                                <?= $links; ?>
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
</div>
</section>
<?php $this->load->view('Layouts/footer') ?>
<?php $this->load->view('Tasks/main_js.php') ?>
<script type="text/javascript">
    
    $(document).ready(function(){
        $('#txt_searchall').keyup(function(){
            var search = $(this).val().toUpperCase();
            $('table tbody tr').hide();
            var len = $('table tbody tr:not(.notfound) td:contains("'+ search +'")').length;
            if(len > 0){
                $('table tbody tr:not(.notfound) td:contains("'+ search +'")').each(function(){
                $(this).closest('tr').show();
                $('.price-counter').text(len);
            });
            }else{
                $('.notfound').show();
                $('.price-counter').text(len);
            }
        });
    });

</script>