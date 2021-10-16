<?php $this->load->view('Layouts/header') ?>
<!-- section start -->
<section>
    <div class="container-fluid">
        <div class="taskPageSize">
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
                                    <div class="col-md-offset-3 col-md-6">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#">User</a></li>
                                            <li class="breadcrumb-item active">Profile</li>
                                        </ol>
                                        <div class="login-formmea">
                                            <div class="box-widget widget-module">
                                                <div class="widget-head clearfix">
                                                    <span class="h-icon"><i class="fa fa-th"></i></span>
                                                    <h4>Update Profile</h4>
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <?php 
                                                            if($this->session->flashdata('msg')!=''){
                                                                echo '<div class="alert alert-success alert-dismissible">
                                                                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                                      <strong>'.$this->session->flashdata('msg').'</strong> 
                                                                    </div>';
                                                            }
                                                            if($this->session->flashdata('err')!=''){
                                                                echo '<div class="alert alert-danger alert-dismissible">
                                                                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                                      <strong>'.$this->session->flashdata('err').'</strong> 
                                                                    </div>';
                                                            }
                                                        ?>
                                                        
                                                        <form action="<?= base_url('updateProfile/'.$user->user_id) ?>" method="post" autocomplete="off" enctype="multipart/form-data">
                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <label for="inputLastname"><b>Name</b>&nbsp;<span class="required_Fields">*</span></label>
                                                                    <input class="form-control rounded-0" id="name" name="name" type="text" value="<?= $user->name ?>" autocomplete="off" required>
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label for="inputLastname"><b>Official Email Id</b>&nbsp;<span class="required_Fields">*</span></label>
                                                                    <input class="form-control rounded-0" id="emails" name="email" value="<?= $user->email ?>" type="email" onchange="IsOfficialEmail(this)" autocomplete="off" required>
                                                                    <span id="emailErr"></span>
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label for="inputLastname"><b>Mobile</b>&nbsp;<span class="required_Fields">*</span></label>
                                                                    <input class="form-control rounded-0" id="mobile" name="mobile" value="<?= $user->mobile ?>" type="text" autocomplete="off" required>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label for="inputLastname"><b>DOB</b>&nbsp;<span class="required_Fields">*</span></label>
                                                                    <input class="form-control rounded-0" id="DOB" name="dob" type="text" value="<?= $user->dob ?>" autocomplete="off" required>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <label for="inputFirstname"><b>Gender</b>&nbsp;<span class="required_Fields">*</span></label>
                                                                    <select class="form-control" name="gender" id="gender" autocomplete="off" required>
                                                                        <option value="">Select Gender</option>
                                                                        <option <?php if($user->gender == "Male"){ echo "selected";} ?>>Male</option>
                                                                        <option <?php if($user->gender == "Female"){ echo "selected";} ?>>Female</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <label for="inputFirstname"><b>Marital Status</b>&nbsp;<span class="required_Fields">*</span></label>
                                                                    <select class="form-control" name="marital_status" id="marital_status" autocomplete="off" required>
                                                                        <option value="">Select Marital Status</option>
                                                                        <option <?php if($user->marital_status == "Married"){ echo "selected";} ?>>Married</option>
                                                                        <option <?php if($user->marital_status == "Single"){ echo "selected";} ?>>Single</option>
                                                                        <option <?php if($user->marital_status == "Divorced"){ echo "selected";} ?>>Divorced</option>
                                                                        <option <?php if($user->marital_status == "Widowed"){ echo "selected";} ?>>Widowed</option>
                                                                    </select>
                                                                </div>

                                                                 <div class="col-md-6">
                                                                    <label for="inputLastname"><b>Father's Name</b></label>
                                                                    <input class="form-control rounded-0" id="father_name" name="father_name" value="<?= $user->father_name; ?>" type="text" maxlength="30" style="text-transform:capitalize;" autocomplete="off"/>
                                                                </div>
                                                            </div>

                                                            <button type="submit" class="button btn btn-primary">Update</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
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
    $("#userRole, #restrectedBranchUser").select2({
        placeholder: "Select",
        allowClear: true
    });

    $('#roleTag').multiselect({ // #centerName
        columns: 1,
        placeholder: 'Select',
        search: true,
        selectAll: true,
        allowClear: true
    });
</script>
<script>

    $(document).ready(function () {
        $('#restrectedBranchUser').on('change', function(){
            var state_id = $(this).val();
            if(state_id){
                $.ajax({
                    url: '<?= base_url("AdminController/getUserCenter"); ?>',
                    type : 'POST',
                    data : {state_id : state_id},
                    dataType: 'json',
                    cache : false,
                    success: function(response) {
                        $('#centerName').empty();
                        $.each(response , function(index, item) {
                            $('#centerName').append('<option value="'+item.city_id+'">'+item.city+'</option>').css('height', '100px');
                        });
                    }
                }); 
            } else {
                $('#restrectedBranchUser').html('<option value="">Select state first</option>'); 
            }
        });
    });

    $('#adminSaveUser').click(function(e){
        e.preventDefault();
        $.ajax({
            url : '<?= base_url("adminSaveUser") ?>',
            type : 'POST',
            dataType : "json",
            data : $('#formData').serialize(),
            async: false,
            success : function(response){
                if(response == 1)
                {
                    $('#userRole, #restrectedBranchUser, #centerName').empty();
                    $('#formData')[0].reset();
                    $(".msg").show().fadeOut('slow');
                    $(".msg a").html("Added Successfully.");
                    window.setTimeout(function(){location.reload()}, 0);
                }else{
                    $('#formData')[0].reset();
                    $(".err").show().fadeOut('slow');
                    $(".err a").html("Try Again.");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                if(XMLHttpRequest != "")
                {   
                    $(".err").show().fadeOut('slow');
                    $(".err a").html("All Fields required.");
                }
                return false;
            }
        });
    });

</script>