<?php //$this->load->view('frontEnd/header');?>
<html lang="en">
  	<head>
  		<title>User Registration</title>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="description" content="OneTech shop project">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/front/'); ?>css/datepicker.min.css">
		<style type="text/css">
			label{ float: right; }
			.row{ margin-top: 10px; margin-right: 25px;}
			.form_user { border: 1px solid #000; }
			h2{color: #2e6da4;}
			b{color: red;font-size: 18px;}
		</style>
	</head>
  	<body>
		<div class="container-fluid body-background" style="background-image: url('<?= base_url('public/front/') ?>images/bg-1.jpg'); height: 100%;">
			<div class="row form_border login-formme">
			 	<div class="col-md-12" style="margin-top: 0px;">
	                <?php //echo form_open('sign_up', ['class'=>'form_user login-formme', 'style'=>' background-color: #fff; width: 80%;margin-left: 12%;']); ?>
	                <form action="<?= base_url('sign_up');?>" method="POST" class="form_user login-formme" style="background-color: #fff; width: 80%;margin-left: 12%;">
				 		<h2 align="center">User Register</h2><hr>
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
				 		<div class="row">
				 			<div class="col-md-2">
				 				<label for="first_name"><b>*</b>First Name</label>
				 			</div>
				 			<div class="col-md-4">
				 				<?= form_input(['class'=>'form-control', 'placeholder'=>'Enter First Name', 'name'=>'first_name', 'id'=>'first_name', 'required'=>'', 'value'=>set_value("first_name")]); ?>
				 			</div>
				 			<div class="col-md-2">
				 				<label for="last_name"><b>*</b>Last Name</label>
				 			</div>
				 			<div class="col-md-4">
				 				<?= form_input(['class'=>'form-control', 'placeholder'=>'Enter Last Name', 'name'=>'last_name', 'id'=>'last_name', 'required'=>'', 'value'=>set_value("last_name")]); ?>
				 			</div>
				 		</div>
				 		<div class="row">
				 			<div class="col-md-2">
				 				<label for="email"><b>*</b>Email</label>
				 			</div>
				 			<div class="col-md-4">
				 				<?= form_input(['class'=>'form-control', 'placeholder'=>'Enter Email', 'name'=>'email', 'id'=>'email', 'required'=>'', 'value'=>set_value("email")]); ?>
				 			</div>
				 			<div class="col-md-2">
				 				<label for="phone"><b>*</b>Phone</label>
				 			</div>
				 			<div class="col-md-4">
				 				<?= form_input(['class'=>'form-control', 'placeholder'=>'Enter phone', 'name'=>'phone', 'id'=>'phone', 'required'=>'', 'maxlength'=>"10", 'value'=>set_value("phone")]); ?>
				 			</div>
				 		</div>
				 		<div class="row">
				 			<div class="col-md-2">
				 				<label for="password"><b>*</b>Password</label>
				 			</div>
				 			<div class="col-md-4">
				 				<?= form_password(['class'=>'form-control', 'placeholder'=>'Enter password', 'name'=>'password', 'id'=>'password', 'required'=>'', 'value'=>set_value("password")]); ?>
				 			</div>
				 			<div class="col-md-2">
				 				<label for="confirm_password"><b>*</b>Confirm Password</label>
				 			</div>
				 			<div class="col-md-4">
				 				<?= form_password(['class'=>'form-control', 'placeholder'=>'Enter confirm password', 'name'=>'confirm_password', 'id'=>'confirm_password', 'required'=>'']); ?>
				 			</div>
				 		</div>
				 		<div class="row">
				 			<div class="col-md-2">
				 				<label for="title"><b>*</b>Gender</label>
				 			</div>
				 			<div class="col-md-4">
				 				<input type="radio" name="gender" id="radio" value="Male" checked />&nbsp;Male
				 				<input type="radio" name="gender" id="radio" value="Female" />&nbsp;Female
				 				<input type="radio" name="gender" id="radio" value="Other" />&nbsp;Other                                
		                    </div>
		                    <div class="col-md-2">
				 				<label for="title"><b>*</b>DOB</label>
				 			</div>
				 			<div class="col-md-4">
				 				<input class="form-control" type="text" name="dateofbirth" id="dateofbirth" placeholder="Select Date of Birth" required="">
		                    </div>
				 		</div>
				 		<div class="row">
				 			<div class="col-md-2">
				 				<label for="country"><b>*</b>Country</label>
				 			</div>
				 			<div class="col-md-4">
				 				<select name="country" id="country" class="form-control">
		                            <option value="">Select Country</option>
				 					<?php foreach ($countries as $country):?>
		                            <option name='country' value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
		                    		<?php endforeach; ?>
		                        </select>
				 			</div>
				 			<div class="col-md-2">
				 				<label for="state"><b>*</b>State</label>
				 			</div>
				 			<div class="col-md-4">
				 				<select name="state" id="state" class="form-control" required=""></select>
				 			</div>
				 		</div>
				 		<div class="row">
				 			<div class="col-md-2">
				 				<label for="city"><b>*</b>District</label>
				 			</div>
				 			<div class="col-md-4">
				 				<?= form_input(['class'=>'form-control', 'placeholder'=>'Enter District', 'name'=>'city', 'id'=>'city', 'required'=>'', 'value'=>set_value("city")]); ?>
				 			</div>
				 			<div class="col-md-2">
				 				<label for="town"><b>*</b>Town</label>
				 			</div>
				 			<div class="col-md-4">
				 				<?= form_input(['class'=>'form-control', 'placeholder'=>'Enter town', 'name'=>'town', 'id'=>'town', 'required'=>'', 'value'=>set_value("town")]); ?>
				 			</div>
				 		</div>

				 		<div class="row">
				 			<div class="col-md-2">
				 				<label for="pincode"><b>*</b>Pincode</label>
				 			</div>
				 			<div class="col-md-4">
				 				<?= form_input(['class'=>'form-control', 'placeholder'=>'Enter pincode', 'name'=>'pincode', 'id'=>'pincode', 'maxlength'=>"6", 'value'=>set_value("pincode")]); ?>
				 			</div>
				 			<div class="col-md-2">
				 				<label for="image"><b>*</b>Profile</label>
				 			</div>
				 			<div class="col-md-4">
				 				<input type="file" name="image" class="form-control" required=''>
				 			</div>
				 		</div>
				 		<div class="row" style="margin-bottom: 25px;">
				 			<div class="col-md-2">&nbsp;</div>
				 			<div class="col-md-4">
								<?php echo form_submit(['class'=>'btn btn-control btn-primary AddUser', 'value'=>'User Register']);?>
				 				<!-- <a href="<?php echo base_url(); ?>">User Login</a> -->
				 			</div>
				 		</div>
				 	</form>
			 	</div>
			 </div>
		</div>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
	    <script type="text/javascript" src="<?= base_url('public/front')?>/js/datepicker.min.js"></script>
	    <script type="text/javascript" src="<?= base_url('public/front')?>/js/bootstrap-select.min.js"></script>
	    <script type="text/javascript">

		    $("#dateofbirth").datepicker({
		    	autoclose: true,
		    	format:'dd/mm/yyyy',
		    	todayHighlight: true,
		    	endDate: new Date()
		    });

		    $("#first_name, #last_name, #city, #town").keypress(function(event){
		        var inputValue = event.which;
		        if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) { 
		            event.preventDefault(); 
		        }
		    });

		    $("#phone, #pincode").keypress(function (e) {
	            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	                $("#errormessage").html("Acceptable Number Only!").show().fadeOut("slow");
	               return false;
	            }
	        });

	        $("#dateofbirth").keypress(function myfunction(event) {
	            var regex = new RegExp("^[0-9?=.*!@#$%^&*]+$");               
	            var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
	             if (!regex.test(key)) {
	                event.preventDefault();
	                return false;
	            }              
	            return false; 
	        });

		    $(document).ready(function() {
		        $('#country').on('change', function() {
		            var country_id = $(this).val();
		            if(country_id) {
		                $.ajax({
		                    url: 'sign-up/'+country_id,
		                    type: "GET",
		                    dataType: "json",
		                    success:function(data) {
		                        $('select[name="state"]').empty();
		                        $.each(data, function(key, value) {
		                            $('select[name="state"]').append(
		                            	'<option value="'+ value.name +'">'+ value.name +'</option>'
		                            	);
		                        });
		                    }
		                });
		            }else{
		                $('select[name="state"]').empty();
		            }
		        });

		        $('#state').on('change', function() {
		            var state_id = $(this).val();
		            if(state_id) {
		                $.ajax({
		                    url: '/sign-up/'+state_id,
		                    type: "GET",
		                    dataType: "json",
		                    success:function(data) {
		                        $('select[name="city"]').empty();
		                        $.each(data, function(key, value) {
		                            $('select[name="city"]').append(
		                            	'<option value="Select City">Select City</option>',
		                            	'<option value="'+ value.name +'">'+ value.name +'</option>'
		                            	);
		                        });
		                    }
		                });
		            }else{
		                $('select[name="city"]').empty();
		            }
		        });

		    });

		</script>
    
  	</body>

</html>
