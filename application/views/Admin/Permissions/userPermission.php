<?php $this->load->view('Layouts/header') ?>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
  <style>
      
.select2-results__option {
  padding-right: 20px;
  vertical-align: middle;
}
.select2-results__option:before {
  content: "";
  display: inline-block;
  position: relative;
  height: 20px;
  width: 20px;
  border: 2px solid #e9e9e9;
  border-radius: 4px;
  background-color: #fff;
  margin-right: 20px;
  vertical-align: middle;
}
.select2-results__option[aria-selected=true]:before {
  font-family:fontAwesome;
  content: "\f00c";
  color: #fff;
  background-color: #f77750;
  border: 0;
  display: inline-block;
  padding-left: 3px;
}
.select2-container--default .select2-results__option[aria-selected=true] {
  background-color: #fff;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
  background-color: #eaeaeb;
  color: #272727;
}
.select2-container--default .select2-selection--multiple {
  margin-bottom: 10px;
}
.select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
  border-radius: 4px;
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
  border-color: #f77750;
  border-width: 2px;
}
.select2-container--default .select2-selection--multiple {
  border-width: 2px;
}
.select2-container--open .select2-dropdown--below {
  
  border-radius: 6px;
  box-shadow: 0 0 10px rgba(0,0,0,0.5);

}
.select2-selection .select2-selection--multiple:after {
  content: 'hhghgh';
}
/* select with icons badges single*/
.select-icon .select2-selection__placeholder .badge {
  display: none;
}
.select-icon .placeholder {
/*  display: none; */
}
.select-icon .select2-results__option:before,
.select-icon .select2-results__option[aria-selected=true]:before {
  display: none !important;
  /* content: "" !important; */
}
.select-icon  .select2-search--dropdown {
  display: none;
}
  </style>
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
                                            <div class="row">
                                                <div class="col-md-4">   
                                                    <div class="table-responsive">
                                                        <table class="table dts-table table-striped table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <div style="text-align : center;">
                                                                    <span style="background: #286ea1; color: #fff; text-align: center; border: 3px solid #286ea1; border-radius: 68%; width: 22%; height: 70px; padding: 24px; display: block;">
                                                                        <></span>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <td><?= $customerDetails->lead_id; ?></td>

                                                                    <th>Customer Id</th>
                                                                    <td><?= $customerDetails->customer_id; ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Email</th>
                                                                    <td><?= $customerDetails->email; ?></td>

                                                                    <th>Mobile</th>
                                                                    <td><?= $customerDetails->mobile; ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                        		    <h4>Dashboard Menu Permission</h4>
                                        		    
                                        			<select class="js-select2 form-control" multiple="multiple" id="dashboardMenuPermission" onchange='dashboardMenuPermission(this)'>
                                            			<?php foreach($menu_list->result() as $menu) : ?>
                                            			<option value="<?= $menu->id ?>"><?= $menu->menu_name ?></option>
                                            			<?php endforeach; ?>
                                        			</select>
                                        			<button class="btn btn-control btn-primaty" id="btnSubmit">Submit</button>
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
<?php $this->load->view('Admin/main_js.php') ?>
<script>
    // $(document)
    	$(".js-select2").select2({
			closeOnSelect : false,
			placeholder : "Placeholder",
// 			allowHtml: true,
			allowClear: true,
			tags: true
		});
</script>




