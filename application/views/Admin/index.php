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
                                                    <span class="inner-page-tag">Users List</span>
                                                    <span class="counter inner-page-box"><?= $users->num_rows(); ?></span>
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <div class="row">
                                                            <div class="scroll_on_x_axis">
                                                                <table class="table dt-table table-striped table-bordered table-responsive table-hover" style="border: 1px solid #dde2eb">
                                                                    <thead>
                                                                        <tr>
                                                                            <th><b>#</b></th>
                                                                            <th><b>Name</b></th>
                                                                            <th><b>Email</b></th>
                                                                            <th><b>Mobile</b></th>
                                                                            <th><b>User Role</b></th>
                                                                            <th><b>User Branch</b></th>
                                                                            <th><b>User Center</b></th>
                                                                            <th><b>User Status</b></th>
                                                                            <th><b>Initiated On</b></th>
                                                                            <th><b>Action</b></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $i = 1; foreach($users->result() as $row) : ?>
                                                                        <tr class="table-default">
                                                                            <td><?= $row->user_id; ?></td>
                                                                            <td><?= $row->name; ?></td>
                                                                            <td><?= $row->email; ?></td>
                                                                            <td><?= $row->mobile; ?></td>
                                                                            <td><?= $row->labels; ?> - <?= $row->role; ?></td>
                                                                            <td><?= $row->state; ?></td>
                                                                            <td><?= $row->center; ?></td>
                                                                            <td><?= ($row->status == "Active")? '<div class="bg-success text-center rounded-circle">ACTIVE</div>' : '<div class="bg-danger text-center rounded-circle">CLOSED</div>'; ?>
                                                                                <!--<div class="badge badge-pill badge-danger text-danger"><?= $row->status; ?></div>-->
                                                                                </td> 
                                                                            <td><?= $row->created_on; ?></td> 
                                                                            <td>
                                                                                <div style="display: flex; margin: 5px;">
                                                                                <a  class="btn btn-primary btn-sm" href="<?= base_url('adminEditUser/'.$row->user_id) ?>"><i class="fa fa-pencil-square-o"></i></a>
                                                                                <a  class="btn btn-info btn-sm" href="<?= base_url('userPermission/'.$row->user_id) ?>"><i class="fa fa-lock "></i></a>
                                                                                </div>
                                                                            </td>
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

<div id="myModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="margin-top : 20px; background: #fff;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">...</h5><hr>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formData" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <label><span class="span">*</span> First Name</label>
                            <input type="text" class="form-control" name="firstName" id="firstName" required>
                        </div>
                        <div class="col-md-6">
                            <label><span class="span">*</span> Last Name</label>
                            <input type="text" class="form-control" name="lastName" id="lastName" required>
                        </div>

                        <div class="col-md-6">
                            <label><span class="span">*</span> Email</label>
                            <input type="email" class="form-control" name="email" id="email" onchange="IsEmail(this)" required>
                        </div>

                        <div class="col-md-6">
                            <label><span class="span">*</span> Mobile</label>
                            <input type="text" class="form-control" name="mobile" id="mobile" required>
                        </div>

                        <div class="col-md-6">
                            <label><span class="span">*</span> User Role</label>
                            <select id="userRole" class="form-control" name="userRole" class="form-control" required>
                                <option></option>
                                <?php foreach($userRole as $row) : ?>
                                <option value="<?= $row->role_id; ?>"><?= $row->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label><span class="span">*</span> Restricted Branch User</label>
                            <select id="restrectedBranchUser" class="form-control" name="restrectedBranchUser" class="form-control" required>
                                <option></option>
                                <?php foreach($userBranch as $row) : ?>
                                <option value="<?= $row->id; ?>"><?= $row->state; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label><span class="span">*</span> Center</label>
                            <select class="form-control" id="centerName" name="centerName[]" multiple required>
                            </select>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

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