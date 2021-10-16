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
	
                                    <div class="col-md-3 drop-me">
                                        <?php if($_SESSION['isUserSession']['role'] == "Client Admin") : ?>
                                      <?php $this->load->view('Layouts/leftsidebar') ?>
                                      <?php endif; ?>
                                    </div>
                                
                                    <div class="col-md-9">
                                        <!--<ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                                            <li class="breadcrumb-item active">Admin</li>
                                            <a class="button-add btn" href="<?php echo base_url() ?>viewBankDetailsview">View Bank Details</a>
                                        </ol>-->
                                        <div class="login-formmea">
                                            <div class="box-widget widget-module">
                                                <div class="widget-head clearfix">
                                                    <span class="h-icon"><i class="fa fa-th"></i></span>
                                                    <h4>Add Bank Details</h4>
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <form id="formData" method="post" action="<?php echo base_url(); ?>saveBankDetails" enctype="multipart/form-data">
                                                            <div class="row">
                                                                
                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span>Bank Name</label>
                                                                    <input type="text" class="form-control" name="name" id="name">
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span>Bank IFSC</label>
                                                                    <input type="text" class="form-control" name="ifsc" id="ifsc">
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span>Bank Branch</label>
                                                                    <input type="text" class="form-control" name="branch" id="branch" >
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> Bank Address</label>
                                                                    <input type="text" class="form-control" name="address" id="address">
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> Bank City</label>
                                                                    <input type="text" class="form-control" name="city" id="city">
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> Bank District</label>
                                                                    <input type="text" class="form-control" name="district" id="district">
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> Bank state</label>
                                                                    <input type="text" class="form-control" name="state" id="state">
                                                                </div>
                                                                
                                                                <input type="hidden" class="form-control" name="updated_by" id="updated_by" value="<?php ?>">
                                                                
                                                                <input type="hidden" class="form-control" name="ip" id="ip" value="<?= $_SERVER['REMOTE_ADDR']; ?>">
                                                                
                                                               <div class="col-md-6">
                                                                    <label><span class="span" id="error"></span></label>
                                                                    
                                                                </div>
                                                               
                                                            </div>
                                                        </form>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <button type="button" class="button-add btn" id="bankDetails">ADD Bank Details</button>
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
    $('#bankDetails').click(function(e){
        e.preventDefault();
        var name = $('#name').val();
        var ifsc = $('#ifsc').val();
        var address = $('#address').val();
        var city = $('#city').val();
        var state = $('#state').val();
        if(name =="" || ifsc =="" || address =="" || city =="" || state =="")
        {
            catchError("All Fields required.");
        }else{
            $.ajax({
                url : '<?= base_url("saveBankDetails") ?>',
                type : 'POST',
                dataType : "json",
                data : $('#formData').serialize(),
                success : function(response){
                    if(response.err){
                        catchError(response.err);
                    } else {
                        catchSuccess("Record Added Successfully!");
                        window.location.reload();
                    }
                }
            });
        }
    });
  });
</script>

// <script type="text/javascript">
//   $("document").ready(function(){
//     $("#bankDetails").click(function(){  
      
//     });
// });
 </script>






