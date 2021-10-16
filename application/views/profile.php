<?php $this->load->view('Layouts/header') ?>

<!-- section start -->
<section>
    <div class="container-fluid">
        <div class="taskPageSize taskPageSizeDashboard">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="page-container list-menu-view">
                        <div class="page-content">
                            <div class="main-container">
                                <div class="container-fluid">
                                    <div class="col-md-12">
                                        <div class="login-formmea">
                                            <div class="box-widget widget-module">
                                                <div class="widget-head clearfix">
                                                    <span class="h-icon"><i class="fa fa-th"></i></span>
                                                    <h4>User Profile</h4>
                                                </div>
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
                                                
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <div class="row">
                                                            <table class="table dt-table table-striped table-bordered table-responsive table-hover" style="border: 1px solid #dde2eb">
                                                                <tbody>
                                                                    <tr>
                                                                        <th><b>Name</b></th>
                                                                        <td><?= $userDetails['name']; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th><b>Email</b></th>
                                                                        <td><?= $userDetails['email']; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th><b>Mobile</b></th>
                                                                        <td><?= $userDetails['mobile']; ?></td>
                                                                    </tr> 

                                                                    <tr>
                                                                        <th><b>User Role</b></th>
                                                                        <td><?= $userDetails['role']; ?></td>
                                                                    </tr> 

                                                                    <?php if(!empty($userDetails['center'])){ ?>
                                                                    <tr>
                                                                        <th><b>User Center</b></th>
                                                                        <td><?= $userDetails['center']; ?></td>
                                                                    </tr>
                                                                    <?php } ?>

                                                                    <tr>
                                                                        <th><b>User Status</b></th>
                                                                        <td><?= $userDetails['status']; ?></td> 
                                                                    </tr>

                                                                    <!--<tr>-->
                                                                        <td colspan="2"><a href="<?= base_url('changePassword') ?>">Change Password</a></td>
                                                                        <!--<td colspan="2"><a href="<?= base_url('editProfile/'.$userDetails['user_id']) ?>">Update Profile</a></td>-->
                                                                    <!--</tr>-->
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
</script>
<script>
    function viewUserDetails(user_id){
        $.ajax({
            url : '<?= base_url("getUserDetailById/") ?>'+user_id,
            type : 'POST',
            dataType : "json",
            async: false,
            success : function(response){
                console.log(response);
                $('#exampleModalLongTitle').html('&nbsp;&nbsp; User ID # '+response.user_id);
                var fullName = response.name.split(" ");
                var firstName = fullName[0];
                var lastName = fullName[1];
                $('#firstName').val(firstName);
                $('#lastName').val(lastName);
                $('#email').val(response.email);
                $('#mobile').val(response.mobile);
                $('#userRole').val(response.role);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                $("#exampleModalLongTitle").html(textStatus +" : "+ errorThrown);
                return false;
            }
        });
    }
</script>