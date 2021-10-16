<?php $this->load->view('Layouts/header') ?>
<!-- section start -->
<section>
    <div class="container-fluid">
        <div class="taskPageSize taskPageSizeDashboard">
            <div class="row">
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
                                                    <span class="h-icon"><i class="fa fa-th"></i></span>
                                                    <h4>Update Users</h4>
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <form id="formData" method="post" enctype="multipart/form-data">
                                                            <div class="row">

                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                <input type="text" class="form-control" id="userId" name="userId" value="<?= $user->user_id; ?>" readonly>

                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> Company</label>
                                                                    <select id="company_id" class="form-control" name="company_id" class="form-control" required>
                                                                        <option value="">Select Company</option>
                                                                        <?php foreach($company->result() as $row) : 
                                                                            $s = '';
                                                                            if($row->company_id == $user->company_id) 
                                                                            {
                                                                                $s = 'selected';
                                                                            }
                                                                            echo '<option value="'.$row->company_id.'" '.$s.'>'.$row->company_id .'. &nbsp '. $row->company_name .'</option>';
                                                                        ?>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> Product</label>
                                                                    <select id="product_id" class="form-control" name="product_id" class="form-control" required>
                                                                        <option value="">Select Product</option>
                                                                        <?php foreach($product->result() as $row) : 
                                                                            $s = '';
                                                                            if($row->product_id == $user->product_id) 
                                                                            {
                                                                                $s = 'selected';
                                                                            }
                                                                            echo '<option value="'.$row->product_id.'" '.$s.'>'.$row->product_id .'. &nbsp '. $row->product_name .'</option>';
                                                                        ?>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> First Name</label>
                                                                    <input type="text" class="form-control" name="firstName" id="firstName" value="<?= explode(" ", $user->name)[0]; ?>" required>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> Last Name</label>
                                                                    <input type="text" class="form-control" name="lastName" id="lastName" value="<?php if(!empty(explode(" ", $user->name)[1])){ echo explode(" ", $user->name)[1]; } ?>" required>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> Email</label>
                                                                    <input type="email" class="form-control" name="email" id="email" onchange="IsEmail(this)" value="<?= $user->email; ?>" required>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> Mobile</label>
                                                                    <input type="text" class="form-control" name="mobile" id="mobile" value="<?= $user->mobile; ?>" required>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> User Role</label>
                                                                    <select id="userRole" class="form-control" name="userRole" class="form-control" required>
                                                                        <option></option>
                                                                        <?php $i = 0;
                                                                        foreach($userRole->result() as $row) : 
                                                                            $s = '';
                                                                            if($row->role_id == $user->role_id) 
                                                                            {
                                                                                $s = 'selected';
                                                                            }
                                                                            echo '<option value="'.$row->role_id.'" '.$s.'>'.$row->labels .' - '. $row->name.'</option>';
                                                                        $i++;
                                                                        endforeach; 
                                                                        ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> User Branch</label>
                                                                    <select id="restrectedBranchUser" class="form-control" name="restrectedBranchUser" class="form-control" required>
                                                                        <option> Select Branch</option>
                                                                        <?php 
                                                                        foreach($states->result() as $row) : 
                                                                            $s = '';
                                                                            if($row->state_id == $user->branch) 
                                                                            {
                                                                                $s = 'selected';
                                                                            }
                                                                            echo '<option value="'.$row->state_id.'" '.$s.'>'.$row->state.'</option>';
                                                                        endforeach; 
                                                                        ?>
                                                                    </select>
                                                                </div>

                                                                <input type="hidden" class="form-control" id="userCenter" value="<?= $user->center; ?>">
                                                                <div class="col-md-6">
                                                                    <!-- <input type="text" id="selectedCenter" value="<?= $user->center ?>"> -->
                                                                    <label><span class="span">*</span> User Center</label>
                                                                    <select class="form-control" id="centerName" name="centerName[]" multiple required>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label><span class="span">*</span> User Status</label>
                                                                    <select id="status" class="form-control" name="status" class="form-control" required>
                                                                        <option>Select Status</option>
                                                                        <option <?php if($user->status == 'Active'){echo "selected";} ?>> ACTIVE</option>
                                                                        <option <?php if($user->status == 'InActive'){echo "selected";} ?>> Inactive</option>
                                                                        <option <?php if($user->status == 'Pending'){echo "selected";} ?>> PENDING</option>
                                                                        <option <?php if($user->status == 'Closed'){echo "selected";} ?>> CLOSED</option>
                                                                        <option <?php if($user->status == 'Blocked'){echo "selected";} ?>> BLOCKED</option>
                                                                    </select>
                                                                </div>

                                                            </div>
                                                        </form>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <button class="button-add btn btn-ifo" id="adminSaveUser">Update</button>
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
    var csrf_token = $("input[name=csrf_token]").val();
    $(document).ready(function () {

        $('#restrectedBranchUser').on('change', function(){
            var state_id = $(this).val();
            if(state_id){
                $.ajax({
                    url: '<?= base_url("AdminController/getUserCenter"); ?>',
                    type : 'POST',
                    data : {state_id : state_id, csrf_token},
                    dataType: 'json',
                    cache : false,
                    success: function(response) {
                        $('#centerName').empty();
                        var i = 0;
                        $.each(response , function(index, item) {
                            var s = '';
                            // var selectedCenter = $('#selectedCenter').val();
                            // console.log(selectedCenter);
                            // if(item.id == user[i].center) {s = 'selected';}
                            $('#centerName').append('<option value="'+item.id+'" '+ s +'>'+item.city+'</option>').css('height', '100px');
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
            url : '<?= base_url("adminUpdateUser") ?>',
            type : 'POST',
            dataType : "json",
            data : $('#formData').serialize(),
            success : function(response){
                if(response == 1)
                {
                    $('#userRole, #restrectedBranchUser, #centerName').empty();
                    $('#formData')[0].reset();
                    catchSuccess('Updated Successfully.');
                    window.setTimeout(function(){location.reload()}, 0);
                }else{
                    $('#formData')[0].reset();
                    catchError('Try Again.');
                }
            },
        });
    });

</script>