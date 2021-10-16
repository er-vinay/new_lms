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
            <div class="row" style="padding-top:35px;">
                <div class="col-md-12">
                    <div class="page-container list-menu-view">
                        <div class="page-content">
                            <div class="main-container">
                                <div class="container-fluid">
	
                                    <div class="col-md-3 drop-me">
                                      <?php $this->load->view('Layouts/leftsidebar') ?>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="login-formmea">
                                            <div class="box-widget widget-module">
                                                <div class="widget-head clearfix">
                                                    <span class="h-icon"><i class="fa fa-plus"></i></span>
                                                    <h4>Add Company Details</h4>
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <form id="formData" method="post" enctype="multipart/form-data">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                            <div class="row">
                                                                <div id="divCompanyId"></div>
                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span>Company Name</label>
                                                                    <input type="text" class="form-control" name="company_name" id="company_name">
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span>Comapny Type</label>
                                                                    <input type="text" class="form-control" name="company_type" id="company_type">
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span>Company Url</label>
                                                                    <input type="text" class="form-control" name="url" id="url" >
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> Address</label>
                                                                    <input type="text" class="form-control" name="address" id="address">
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> Contact</label>
                                                                    <input type="text" class="form-control" name="contact" id="contact">
                                                                </div>
                                                            </div>
                                                        </form>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <button type="button" class="button-add btn" id="saveCompany">Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="login-formmea">
                                            <div class="box-widget widget-module">
                                                <div class="widget-head clearfix">
                                                    <span class="h-icon"><i class="fa fa-th"></i></span>
                                                    <h4>Add Bank Details</h4>
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <div class="widget-container">
                                                            <div class=" widget-block">
                                                                <div class="row">
                                                                    <div class="table-responsive">
                                                                        <table class="table dt-table table-striped table-bordered table-hover" style="border: 1px solid #dde2eb">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th><b>Company&nbsp;ID</b></th>
                                                                                    <th><b>Company&nbsp;Name</b></th>
                                                                                    <th><b>Company&nbsp;Type</b></th>
                                                                                    <th><b>Url</b></th>
                                                                                    <th><b>Address</b></th>
                                                                                    <th><b>Company&nbsp;Contact</b></th>
                                                                                    <th><b>Initiated&nbsp;On</b></th>
                                                                                    <th><b>Created&nbsp;By</b></th>
                                                                                    <th><b>Action</b></th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php foreach($company->result() as $row) : ?>
                                                                                <tr>
                                                                                    <td><?= ($row->company_id) ?$row->company_id : '-'; ?></td>
                                                                                    <td><?= ($row->company_name) ? $row->company_name : '-'; ?></td>
                                                                                    <td><?= ($row->company_type) ? $row->company_type : '-'; ?></td>
                                                                                    <td><?= ($row->url) ? $row->url : '-'; ?></td>
                                                                                    <td><?= ($row->address) ? $row->address : '-'; ?></td>
                                                                                    <td><?= ($row->company_contact) ? $row->company_contact : '-'; ?></td>
                                                                                    <td><?= $row->created_at; ?></td>
                                                                                    <td><?= ($row->name) ? $row->name : '-'; ?></td>
                                                                                    <td>
                                                                                        <a href="#" onclick="editCompanyDetails('<?= $row->company_id; ?>', '<?= $row->company_name ?>', '<?= $row->company_type ?>', '<?= $row->url ?>', '<?= $row->address ?>', '<?= $row->company_contact ?>')" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" title="View Costomer Details"></i></a>
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

<script>
$(document).ready(function(){
    $('#saveCompany, #updateCompany').click(function(e){
        $.ajax({
            url : '<?= base_url("saveCompanyDetails") ?>',
            type : 'POST',
            dataType : "json",
            data : $('#formData').serialize(),
            success : function(response){
                if(response.err){
                    catchError(response.err);
                } else {
                    catchSuccess(response.msg);
                    // window.location.reload();
                }
            }
        });
    });
});


function editCompanyDetails(company_id, company_name, company_type, url, address, company_contact)
{
    $('#divCompanyId').val('<input type="hidden" name="company_id" id="company_id" value="'+ company_id +'">');
    $("#saveCompany").attr('id', 'updateCompany').html("Update");
    $('#company_id').val(company_id);
    $('#company_name').val(company_name);
    $('#company_type').val(company_type);
    $('#url').val(url);
    $('#address').val(address);
    $('#contact').val(company_contact);
}
</script>
