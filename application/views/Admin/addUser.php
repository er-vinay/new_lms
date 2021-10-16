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

                                                    <h4>Add Users</h4>

                                                </div>

                                                <div class="widget-container">

                                                    <div class=" widget-block">

                                                        <form id="formData" method="post" enctype="multipart/form-data">

                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                                                            <input type="hidden" name="user_id" value="<?= $user->user_id?>" readonly/>

                                                        

                                                            <div class="row">

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

                                                                        <?php foreach($userRole->result() as $row) : ?>

                                                                        <option value="<?= $row->role_id; ?>"><?= $row->labels; ?> - <?= $row->name; ?></option>

                                                                        <?php endforeach; ?>

                                                                    </select>

                                                                </div>



                                                                <div class="col-md-6">

                                                                    <label><span class="span">*</span> User Branch</label>

                                                                    <select id="restrectedBranchUser" class="form-control" name="restrectedBranchUser" class="form-control"  required>

                                                                        <option></option>

                                                                        <?php foreach($states->result() as $row) : ?>

                                                                        <option value="<?= $row->state_id; ?>"><?= $row->state; ?></option>

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



                                                        <div class="row">

                                                            <div class="col-md-12">

                                                                <button class="button-add btn btn-ifo" id="adminSaveUser">Save</button>

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

                        $.each(response , function(index, item) {

                            $('#centerName').append('<option value="'+item.id+'">'+item.city+'</option>').css('height', '100px');

                        });

                    }

                }); 

            } else {

                $('#restrectedBranchUser').html('<option value="">Select state first</option>'); 

            }

        });

    });



    $('#adminSaveUser').click(function(e){

        

                    // notification("User Created Successfully")

                    // catchError("User Created Successfully")

                    // catchSuccess("User Created Successfully")

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

                    catchSuccess("User Created Successfully")

                    $('#userRole, #restrectedBranchUser, #centerName').empty();

                    $('#formData')[0].reset();

                    window.setTimeout(function(){location.reload()}, 0);

                }else{

                    $('#formData')[0].reset();

                    catchError("Failed to Create User! try again.");

                }

            }

        });

    });



</script>