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
                                                <div class="widget-head clearfix">
                                                    <span class="h-icon"><i class="fa fa-th"></i></span>
                                                    <h4>Add Menu</h4>
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <form id="formData" method="post" enctype="multipart/form-data">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>" readonly/>
                                                        
                                                            <div class="row">
                                                                <div class="col-md-4">
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

                                                                <div class="col-md-4">
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

                                                                <div class="col-md-4">
                                                                    <label><span class="span">*</span> Menu Name</label>
                                                                    <input type="text" class="form-control" name="menu_name" id="menu_name" required>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label><span class="span">*</span> Route Link</label>
                                                                    <input type="text" class="form-control" name="route_link" id="route_link" required>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label><span class="span">*</span> Menu Order By</label>
                                                                    <input type="text" class="form-control" name="menu_order" id="menu_order" required>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label><span class="span">*</span> Icon</label>
                                                                    <input type="text" class="form-control" name="icon" id="icon" required>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label><span class="span">*</span> Box Background Color</label>
                                                                    <input type="text" class="form-control" name="box_bg_color" id="box_bg_color" required>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label><span class="span">*</span> Is Active</label>
                                                                    <select class="form-control" name="is_active" id="is_active" required>
                                                                        <option value="">Select</option>
                                                                        <option value="1">Active</option>
                                                                        <option value="0">In Active</option>
                                                                    </select>
                                                                </div>

                                                            </div>
                                                        </form>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <button class="button-add btn btn-ifo" id="btnAddMenu">Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="box-widget widget-module">
                                                <div class="widget-head clearfix">
                                                    <span class="h-icon"><i class="fa fa-th"></i></span>
                                                    <span class="inner-page-tag">Menu List</span>
                                                    <span class="counter inner-page-box"><?= $menus->num_rows(); ?></span>
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <div class="row">
                                                            <div class="scroll_on_x_axis">
                                                                <table class="table dt-table table-striped table-bordered table-responsive table-hover" style="border: 1px solid #dde2eb">
                                                                    <thead>
                                                                        <tr>
                                                                            <th><b>ID</b></th>
                                                                            <th><b>Company&nbsp;ID</b></th>
                                                                            <th><b>Product&nbsp;ID</b></th>
                                                                            <th><b>Menu&nbsp;Name</b></th>
                                                                            <th><b>Route&nbsp;Link</b></th>
                                                                            <th><b>Menu&nbsp;Order</b></th>
                                                                            <th><b>Icons</b></th>
                                                                            <th><b>Box&nbsp;Color</b></th>
                                                                            <th><b>IsActive</b></th>
                                                                            <th><b>Initiated&nbsp;On</b></th>
                                                                            <th><b>Action</b></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $i = 1; foreach($menus->result() as $row) : ?>
                                                                        <tr class="table-default">
                                                                            <td><?= $row->id; ?></td>
                                                                            <td><?= $row->company_id; ?></td>
                                                                            <td><?= $row->product_id; ?></td>
                                                                            <td><?= $row->menu_name; ?></td>
                                                                            <td><?= $row->route_link; ?></td>
                                                                            <td><?= $row->menu_order; ?></td>
                                                                            <td><?= $row->icon; ?></td>
                                                                            <td><?= $row->box_bg_color; ?></td>
                                                                            <td><?= $row->is_active; ?></td>
                                                                            <td><?= $row->created_on; ?></td>
                                                                            <td>
                                                                                <div style="display: flex; margin: 5px;">
                                                                                <a  class="btn btn-primary btn-sm" href="<?= base_url('adminEditDashboardMenu/'. $this->encrypt->encode($row->id)) ?>"><i class="fa fa-pencil-square-o"></i></a>
                                                                                
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

        $('#btnAddMenu').click(function(e){
            e.preventDefault();
            $.ajax({
                url : '<?= base_url("adminAddDashboardMenu") ?>',
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