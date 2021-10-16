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
                                      <?php $this->load->view('Layouts/leftsidebar') ?>
                                    </div>
                                
                                    <div class="col-md-9">
                                        <div class="login-formmea">
                                            <div class="row">
                                                <div class="col-md-4">   
                                                    <ul id="AllowAddUser" class="accordion">
                                                        <li>
                                                            <div class="link" onclick="permissionGetUsers()">
                                                                <i class="fa fa-plus"></i>Permission Add User
                                                            </div>
                                                            <ul class="submenu-drop-new accordion" id="sub_menu_item">
                                                                <div id="userDetails">
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">   
                                                    <ul id="permissions_test_sms" class="accordion">
                                                        <li>
                                                            <div class="link">
                                                                <i class="fa fa-file-excel-o"></i>Permission Export User
                                                            </div>
                                                            <ul class="submenu-drop-new accordion" id="sub_menu_item">
                                                                <?php $num = 1; foreach ($userDetails as $agent) : ?>
                                                                <li title="<?= $agent->user_id;?>">
                                                                    <a href="#"><span class="user-nav-icon" style="background-color: #fff !important;">
                                                                        <input type="checkbox" name="export" id="export" <?php if($agent->permission_export_Data == 1){echo "checked"; } ?>  
                                                                        onchange='allow_export(<?= $agent->user_id;?>, this)'>
                                                                        </span><span class="user-nav-label"><?= $agent->name ?>&nbsp;(<?= $agent->role ?>)</span>
                                                                    </a>
                                                                </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                                
                                                
                                                <div class="col-md-4" id="AllowDataToExport">   
                                                    <ul id="AllowDataToExport1" class="accordion">
                                                        <li>
                                                            <div class="link">
                                                                <i class="fa fa-file-excel-o"></i>Permission Export Data
                                                            </div>
                                                            <ul class="submenu-drop-new accordion" id="sub_menu_item">
                                                                <input type="text" name="user_id" id="user_id" readonly>
                                                                <input type="text" name="permission_user" id="permission_user" readonly>
                                                                <?php $i = 1; foreach ($exportDataType as $dataType) : ?>
                                                                <li title="<?= $dataType->filter_id;?>">
                                                                    <a href="#"><span class="user-nav-icon">
                                                                        <input type="checkbox" name="reportType[]" class="reportType" id="reportType<?= $dataType->filter_id ?>" value="<?= $dataType->filter_id ?>" onchange='allow_exportReportType(<?= $dataType->filter_id ?>, this)'>
                                                                        </span><span class="user-nav-label"><?= $dataType->name ?></span>
                                                                    </a>
                                                                </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                                
                                                <div class="col-md-4">   
                                                    <ul id="AllowDataToExportType" class="accordion">
                                                        <li>
                                                            <div class="link">
                                                                <i class="fa fa-file-excel-o"></i>Permission Export Type
                                                            </div>
                                                            <ul class="submenu-drop-new accordion">
                                                                <div id="reportExportTypefilter_id"></div>
                                                                <div id="reportExportType"></div>
                                                                
                                                            </ul>
                                                        </li>
                                                    </ul>
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
    </div>
</section>

<!-- footer -->
<?php $this->load->view('Layouts/footer') ?>
<?php //$this->load->view('Tasks/task_js.php') ?>
    <script type="text/javascript">
        $(function() {
            var Accordion = function(el, multiple) {
                this.el = el || {};
                this.multiple = multiple || false;

                var links = this.el.find('.link');
                links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
            }

            Accordion.prototype.dropdown = function(e) {
                var $el = e.data.el;
                    $this = $(this),
                    $next = $this.next();

                $next.slideToggle();
                $this.parent().toggleClass('open');

                if (!e.data.multiple) {
                    $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
                };
            }   

            var permissions_test_sms = new Accordion($('#permissions_test_sms'), false);
            var permissions_test_sms1 = new Accordion($('#AllowDataToExport1'), false);
            var permissions_test_sms1 = new Accordion($('#AllowAddUser'), false);
            var permissions_test_sms1 = new Accordion($('#AllowDataToExportType'), false);
        });
    </script>
    <script type="text/javascript">
        $('#success').hide();
        function allow_export(user_id, permission_export)
        {
            var filterID = "";
            var permission_user = $(permission_export).prop('checked');
            if(permission_user){
               permission_user = 1;
               AllowDataToExport(user_id);
            } else {
               permission_user = 0;
            }
            $('#user_id').val(user_id);
            $('#permission_user').val(permission_user);
        }
        
        function permissionExportData(user_id, permission_user, filterID) {
            $.ajax({
                url : '<?= base_url('permissionExportData') ?>',
                type : "POST",
                data : { user_id : user_id, permission_user : permission_user, filterID : filterID},
                dataType : "json",
                success : function (response){
                  if(response.msg == "0"){
                        catchSuccess("Permission Removed.");
                  }else{
                        catchSuccess("Permission Allowed.");
                  }
                   
                }
            });
        }
        
        function allow_exportReportType(id, currentCheck)
        {
            var user_id = $('#user_id').val();
            var permission_user = $('#permission_user').val();
            
            var filterID = [];
            $('.reportType:checkbox:checked').each(function(i){
              filterID[i] = $(this).val();
            });
            
            var filter_permission = $(currentCheck).prop('checked');
            if(filter_permission){
               filter_permission = 1;
            } else {
               filter_permission = 0;
            }
            var html1 = '<input type="text" name="filter_id" id="filter_id" value="'+ id +'" readonly>';
            html1 += '<input type="text" name="filter_permission" id="filter_permission" value="'+ filter_permission +'" readonly>';
            $("#reportExportTypefilter_id").html(html1);
            
            permissionExportData(user_id, permission_user, filterID);
            
            $.ajax({
                url : '<?= base_url('getExportType/'); ?>'+ id,
                type : "POST",
                dataType : "json",
                success : function (response){
                    $("#reportExportType").empty();
                    $.each(response, function(myarr, index){
                        var html = '<li title="'+ index.sub_menu_id +'">';
                        html += '<a href="#"><span class="user-nav-icon">';
                        html += '<input type="checkbox" name="exportType[]" class="exportType" id="exportType'+ index.sub_menu_id +'" value="'+ index.sub_menu_id +'"  onchange="allow_exportType('+ index.sub_menu_id +', this)">';
                        html += '</span><span class="user-nav-label">'+ index.name +'</span>';
                        html += '</a>';
                        html += '</li>';
                        $("#reportExportType").append(html);
                    });
                   
                }
            });
        }
        
        function allow_exportType(id, currentCheck)
        {
            var user_id = $('#user_id').val();
            var current = $(currentCheck).prop('checked');
            
            var filterID = [];
            $('.exportType:checkbox:checked').each(function(i){
                filterID[i] = $(this).val();
            });
            
            currentCheck = 0;
            if(current){
                currentCheck = 1;
            }
            
            permissionExportData(user_id, filterID, currentChecked);
            
        }
        
        function AllowDataToExport(user_id)
        {
            $(".user_id").val(user_id);
        }
        
        function permissionGetUsers()
        {
            $.ajax({
                url : '<?= base_url('permissionGetUsers'); ?>',
                type : "POST",
                dataType : "json",
                success : function (response){
                    $('#userDetails').empty();
                    $.each(response['userDetails'], function(index, myarr){
                        var check = "";
                        if(myarr.permission_add_user == 1) {
                            check = "checked";
                        }
                        
                        var html = '<li>';
                            html += '<a href="#"><span class="user-nav-icon">';
                            html += '<input type="checkbox" name="userChecklist" class="userCheckList" '+ check +' onchange="allowPermissionToAddUser('+ myarr.user_id +', this)">';
                            html += '<span class="user-nav-label"> &nbsp;'+ myarr.name +' ('+ myarr.role +'</i></span>';
                            html += '</a>';
                            html += '</li>';
                        $('#userDetails').append(html);
                    });
                }
            });   
        }
        
        function allowPermissionToAddUser(user_id, permission_user)
        {
            var allowUser = $(permission_user).prop('checked');
            if(allowUser == true){
                allowUser = 1;
            } else {
                allowUser = 0;
            }
            $.ajax({
                url : '<?= base_url('allowPermissionToAddUser'); ?>',
                type : "POST",
                data : { user_id : user_id, allowUser : allowUser},
                dataType : "json",
                success : function (response){
                   if(response.msg == "0"){
                        catchSuccess("Permission Removed.");
                   }else{
                        catchSuccess("Permission Allowed.");
                   }
                   
                }
            }); 
        }
    </script>






