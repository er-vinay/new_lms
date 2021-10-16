<?php $this->load->view('Layouts_Master/head'); ?>
<body>
    <div class="page-container list-menu-view">
        <?php $this->load->view('Layouts_Master/sidebarMaster'); ?>
        <div class="page-content">
            <?php $this->load->view('Layouts_Master/header'); ?>
            <div class="main-container">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-widget widget-module">
                                <div class="widget-head clearfix">
                                    <span class="h-icon"><i class="fa fa-th"></i></span>
                                    <div class="row">
                                        <h4>Add Agent</h4>
                                        <div class="alert alert-dismissible alert-success" id="success" style="display: none; width: auto; float: right;"></div>
                                        <div class="alert alert-dismissible alert-danger" id="error" style="display: none; width: 20%; float: right;"></div>
                                    </div>
                                </div>
                                <div class="widget-container">
                                    <div class=" widget-block">
                                	    <form id="form_register_admin" method="post" enctype="multipart/form-data" style="margin-top: 20px;" autocomplete="off">
                                            <div class="row">

                                                <input type="hidden" class="form-control form-control-sm" name="master_admin_id" id="master_admin_id" value="<?= $master_admin_id; ?>" readonly="">

                                                <?php
                                                    $agentCode = "DH/A";
                                                    $usersql = $this->db->query("SELECT * FROM tbl_agent WHERE agent_code LIKE '$agentCode%'");
                                                    $usercnt = $usersql->num_rows();

                                                    if ($usercnt >= 1) {
                                                        $num = ++$usercnt;
                                                        $agentCode = $agentCode . $num;
                                                    }
                                                ?>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="col-form-label col-form-label-sm" for="Agent Code">Agent Code</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control form-control-sm" name="agent_code" id="agent_code" value="<?= $agentCode ?>" title="Agent Code" placeholder="Agent Code" readonly="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="col-form-label col-form-label-sm" for="name">Name</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control form-control-sm" name="name" id="name" value="" title="Name" placeholder="Name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="col-form-label col-form-label-sm" for="email">Email</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="email" class="form-control form-control-sm" name="email" id="email" value="" title="Email" placeholder="Email">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            	<div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="col-form-label col-form-label-sm" for="phone">Mobile</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control form-control-sm" name="mobile" id="mobile" value="" title="Mobile Number" placeholder="Mobile Number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="col-form-label col-form-label-sm" for="gender">Gender</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="radio" class="form-control-sm" name="gender" id="gender" title="Male" value="Male" checked="Male">&nbsp;Male
                                                                <input type="radio" class="form-control-sm" name="gender" id="gender" title="Female" value="Female">&nbsp;Female
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->

                                            </div>
                                        </form>
                                        <div class="row">
                                        	<div class="col-md-10 form-group"></div>
                                            <div class="col-md-2 form-group">
                                                <button class="btn btn-primary" id="register_admin" title="Add Agent" style="float: right;">Add Agent</button>
                                                <!-- <a href="<?= base_url(); ?>">Login</a> -->
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
</body>
<?php $this->load->view('Layouts_Master/footer')?>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
        <!-- <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script> -->
        <script type="text/javascript">
            $(document).ready(function(){
                $("#admin_name").keypress(function(event){
                    $('#error').empty();
                    var inputValue = event.which;
                    if(!(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0)) { 
                        $('#error').append('Invalid!').show().css({'color' : 'red'}).fadeOut();
                        event.preventDefault(); 
                    }
                });

                $('#mobile').keypress(function (e) {
                    $('#error').empty();
                    var length = jQuery(this).val().length;
                    if(length > 9) {
                        $('#error').append('Invalid!').show().css({'color' : 'red'}).fadeOut();
                        return false;
                    } else if(e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                        $('#error').append('Invalid!').show().css({'color' : 'red'}).fadeOut();
                        return false;
                    } else if((length == 0) && (e.which == 48)) {
                        $('#error').append('Invalid!').show().css({'color' : 'red'}).fadeOut();
                        return false;
                    }
                });

            	$('#register_admin').on('click', function(){
            		var name = $('#name').val();
            		var email = $('#email').val();
            		var mobile = $('#mobile').val();

            		var formData = $('#form_register_admin').serialize();

                    $('#error').empty();
                    $('#success').empty();
                    
                    if(name === ''){
                        $('#error').append('Please Fill Agent Name!').show().css({'color' : 'red'}).fadeOut();
                        return false;
                    }else if(email === ''){
                        $('#error').append('Please Fill Email!').show().css({'color' : 'red'}).fadeOut();
                        return false;
                    }else if(mobile === ''){
                        $('#error').append('Please Select Mobile Number!').show().css({'color' : 'red'}).fadeOut();
                        return false;
                    } else{
                        $.ajax({
                            url  : "<?= base_url('CompanyController/add_company_admin'); ?>",
                            type : 'POST',
                            data :  formData,
                            dataType : 'json',
                            cache : false,
                            success : function(result){
                                $('#success').append('Employee Registered Successfully!').show().css({'color' : 'green'}).fadeOut(3000);
                                if(result == 1){
                                    $('#form_register_admin').each(function(){
                                        this.reset();
                                    });
                                    window.setTimeout(function(){location.reload()}, 0);
                                }else{
                                    $('#error').append('Failed to Register Employee!').show().css({'color' : 'red'}).fadeOut(3000);
                                }
                            }
                        });
                    }
            	});
            });
        </script>
    </body>
</html>