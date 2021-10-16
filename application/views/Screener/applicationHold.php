
<?php $this->load->view('Layouts/header') ?>
<?php $url =  $this->uri->segment(1); ?>
<span id="response" style="width: 100%;float: left;text-align: center;padding-top:-20%;"></span>
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
                <div class="col-md-12" style="padding: 0px !important;">
                    <div class="page-container list-menu-view">
                        <div class="page-content">
                            <div class="main-container">
                                <div class="container-fluid">
                                    <div class="col-md-12">
                                        <div class="login-formmea">
                                            <div class="box-widget widget-module">
                                                <div class="widget-head clearfix">
                                                    <span class="h-icon"><i class="fa fa-th"></i></span>
                                                    <span class="inner-page-tag">Applications Hold</span> 
                                                        <span class="counter counter inner-page-box"><?= $leadDetails->num_rows(); ?></span>  
                                                        <!--<a  class="btn inner-page-box" id="checkDuplicateItem" style="background:#0a5e90 !important;">Duplicate</a>-->
                                                        <?php if($_SESSION['isUserSession']['role'] == "Sanction Head") { ?>
                                                        <a  class="btn inner-page-box togglebtn" id="re_allocate" style="background:#0a5e90 !important;">Re-Allocate</a>
                                                        <div class="shome"><form><select class="form-control telecaller-name" name="">
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                        </select> <button type="submit" class="btn btn-default telecaller-submit">Submit</button></form></div>
                                                        <?php } ?>
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <div class="row">
                                                            <div class="scroll_on_x_axis table-responsive">
                                                                <table class="table dt-table table-striped table-bordered table-hover" data-order='[[ 0, "desc" ]]' style="border: 1px solid #dde2eb">
                                                                    <thead>
                                                                        <tr>
                                                                            <th><b>Sr. No</b></th>
                                                                            <th><b>Action</b></th>
                                                                            <th><b>Application No</b></th>
                                                                            <th><b>Borrower</b></th>
                                                                            <th><b>State</b></th>
                                                                            <th><b>City</b></th>
                                                                            <th><b>Mobile</b></th>
                                                                            <th><b>Email</b></th>
                                                                            <th><b>PAN</b></th>
                                                                            <th><b>Source</b></th> 
                                                                            <th><b>Status</b></th>
                                                                            <th><b>Initiated On</b></th>
                                                                            
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $sn=1; foreach($leadDetails->result() as $row) : ?>
                                                                        <?php  $remarks = $row->screener_remarks;  ?>
                                                                        <tr>
                                                                            <td> 
                                                                                <?= $sn++;//$row->lead_id; ?>

                                                                                <?php if($row->partPayment > 0){ ?>
                                                                                    <div class="animateWarning"></div>
                                                                                <?php } ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($_SESSION['isUserSession']['role'] == "Sanction Head") { ?>
                                                                                <input class="btn btn-primary btn-sm" type="checkbox" name="duplicate_id[]" class="duplicate_id" id="duplicate_id" value="<?= $row->lead_id; ?>">&nbsp;</br>
                                                                                  <?php } ?>    
                                                                                 <a onclick="viewLeadsDetails('<?= $row->lead_id; ?>')" id="viewLeadsDetails" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" title="View Costomer Details"></i></a>
                                                                            </td> 
                                                                            <td></td>
                                                                            <td><?= strtoupper($row->name ." ". $row->middle_name ." ". $row->sur_name) ?></td>
                                                                            <td><?= strtoupper($row->state) ?></td>
                                                                            <td><?= strtoupper($row->city) ?></td>
                                                                            <td><?= $row->mobile; ?></td>
                                                                            <td><?= $row->email; ?></td>
                                                                            <td><?= strtoupper($row->pancard) ?></td>
                                                                            <td><?= $row->source; ?></td> 
                                                                            <td><?php echo $status = ($row->status == "New Leads" ? "New" : $row->status); ?></td> 
                                                                            <td><?= date('d-m-Y', strtotime($row->created_on)) ?></td> 
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
<?php $this->load->view('Tasks/task_js.php') ?>
<?php $this->load->view('Tasks/main_js.php') ?>
<script>
    ////////////////////////////////////////// Allocate Leads ////////////////////////////////////////
    
    $(function(){
        $('#allocate').click(function () {
            var checkList = [];
            $('.duplicate_id:checked').each(function () {
               checkList.push($(this).val());
            });
            if(checkList.length > 0)
            {
                console.log(checkList);
                $.ajax({
                    url : '<?= base_url("allocateLeads") ?>',
                    type : 'POST',
                    dataType : "json",
                    data : {checkList : checkList},
                    success : function(response) {
                        if(response.err){
                            catchError(response.err);
                        }else{
                            catchSuccess("Leads added in Your Bucket.");
                            window.location.reload();
                        }
                    }
                });
            }else{
                catchError("Please select leads To add Your Bucket.");
            }
        });
    });
    ///////////////////////////////////////// contact section ////////////////////////////////////////
    $(function(){
        $('#checkDuplicateItem').click(function () {
            var checkList = [];
            $('.duplicate_id:checked').each(function () {
               checkList.push($(this).val());
            });
            if(checkList.length > 0)
            {
                console.log(checkList);
                $.ajax({
                    url : '<?= base_url("resonForDuplicateLeads") ?>',
                    type : 'POST',
                    dataType : "json",
                    data : {checkList : checkList},
                    success : function(response) {
                        if(response.err){
                            catchError(response.err);
                        }else{
                            catchSuccess("Leads added in duplicate List.");
                            window.location.reload();
                        }
                    }
                });
            }else{
                catchError("Please select leads for duplicate.");
            }
        });
    });
    $('.btnAddContactDetails').click(function(){
        var lead_id = $('#leadIdForDocs').val();
        var formData = $('#formAddContactDetails').serialize();
        $.ajax({
            url : '<?= base_url("AddContactDetails/") ?>'+lead_id,
            type : 'POST',
            dataType : "json",
            data : formData,
            async: false,
            success : function(response) {
                if(response.error){
                    catchError(response.error);
                }else{
                    catchSuccess("Contact Updated Successfully.");
                    $('#yourMobile, #alternateMobileNo, #yourEmail, #alternateEmailAddress, #yourGender, #yourPancard, #addressLine1, #area, #yourPincode, #landmark, .btnAddContactDetails').prop('disabled', true);
                }
            }
        });
    });
    
       ///////////////////////////////Update Conatct details /////////////////////////////////////

    $('.editContactDetails').click(function(){
        var lead_id = $('#leadIdForDocs').val();
        var formData = $('#formEditContactDetails').serialize();
        $.ajax({
            url : '<?= base_url("AddContactDetails/") ?>'+lead_id,
            type : 'POST',
            dataType : "json",
            data : formData,
            async: false,
            success : function(response){
                if(response.error){
                    catchError(response.error);
                }else{
                    catchSuccess("Contact Updated Successfully.");
                    $('#yourMobileedit, #alternateMobileNoedit, #yourEmailedit, #alternateEmailAddressedit, #yourGenderedit, #yourPancardedit, #addressLine1edit, #areaedit, #yourPincodeedit, #landmarkedit,#yourDOBedit, .btnEditContactDetails').prop('disabled', true);
                }
            }
        });
    });

    ///////////////////////////////////////// Employee Details section ////////////////////////////////////////

    $('.addEmployeeDetails').click(function(){
        var lead_id = $('#leadIdForDocs').val();
        var formData = $('#formAddEmployeeDetails').serialize();
        $.ajax({
            url : '<?= base_url("saveCustomerEmployeeDetails/") ?>'+lead_id,
            type : 'POST',
            dataType : "json",
            data : formData,
            async: false,
            success : function(response) {
                if(response.error){
                    catchError(response.error);
                }else{
                    catchSuccess("Customer Employment Added.");
                    $('#employeeType, #dateOfJoining, #designation, #currentEmployer, #companyAddress, #otherDetails, .addEmployeeDetails').prop('disabled', true);
                    ShowCustomerEmploymentDetails(lead_id);
                }
            }
        });
    });
    

    function RequestForApproveLoan(){
        var lead_id = $("#lead_id").val();

        $.ajax({
            url : '<?= base_url("RequestForApproveLoan") ?>',
            type : 'POST',
            data:{lead_id : lead_id},
            async:false,
            success : function(response) {
                var parsed_data = JSON.parse(response);
                if(parsed_data.err) {
                    catchError(parsed_data.err);
                } else {
                    catchSuccess(parsed_data.msg);
                    window.location.reload();
                }
            },
        });
    }
</script>

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

    $("#dob, #salary_date, #repayment_date").keypress(function myfunction(event) {
        var regex = new RegExp("^[0-9?=.*!@#$%^&*]+$");               
        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
         if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }              
        return false; 
    });
    
    function repaymentDate(date)
    {
        var repayment_date = $('#repayment_date').val();

        var start = new Date(repayment_date);
        var end = new Date(fullDate);
        var days = (end - start) / 1000 / 60 / 60 / 24;
        days = days - (end.getTimezoneOffset() - start.getTimezoneOffset()) / (60 * 24);

        var tenure = - days.toString().split(".")[0];
        $("#tenure").val(tenure);
    }
    
    function saveCreditData()
    {
        var lead_id = $('#lead_id').val();
        var formData = $('#FormSaveCreditData').serialize();
        $.ajax({
            url : '<?= base_url('save-credit-details') ?>',
            type : 'POST',
            data : formData,
            dataType : "json",
            // beforeSend: function() {
            //     $('#btnSaveCreditData').html('<span class="spinner-border spinner-border-sm" role="status"></span>Processing...').addClass('disabled');
            // },
            success : function(response) {
                if(response.err){
                    $(".err").show().fadeOut(4000);
                    $(".err a").html(response.err);
                }else{
                    // $('#FormSaveCreditData')[0].reset();
                    $('#addCreditSection').hide();
                    catchSuccess("Credit Added Successfully.");
                    viewCreditHistory(lead_id);
                    $('#btnSaveCreditData').html('<span class="spinner-border spinner-border-sm" role="status"></span>Processing...').addClass('disabled');
                }
            },
            // complete: function() {
            //     $('#btnSaveCreditData').html('<span class="spinner-border spinner-border-sm" role="status"></span>Save Credit').addClass('disabled');
            // },
        });
    }

</script>