<style>
/********* SIDE NAV BAR ***********/
.drop-me {
    
}

.drop-me .panel-default>.panel-heading {
	background-color: #286ea1 !important;
	border-color: #ddd !important;
	padding: 13px;
}
.panel-default>.panel-heading {
	background-color: #00436a;
	border-color: #ddd;
}
.panel-group .panel+.panel {
	margin-top: 0px;
}
.panel-group {
	margin-top:0px;
	height: 400px !important;
    background: #fff !important;
    border-radius: 3px !important;
}
.panel-collapse {
	background-color:rgba(220, 213, 172, 0.5);
}
.glyphicon {
	margin-right:10px;
}
ul.list-group {
	margin:0px;
}
ul.bulletlist li {
	list-style:disc;
}
ul.list-group li a {
	display: block;
	padding: 11px 15px;
	text-decoration: none;
	background: #fff !important;
	color: #000 !important;
}
ul.list-group li {
	border-bottom: 1px dotted rgba(0, 0, 0, 0.2);
}

ul.list-group li a:hover
{color:#286ea1 !important;}


ul.list-group li a:hover, ul li a:focus {
	color:#000;
	background-color: #00436a;
}
.panel-title a:hover, .panel-title a:active, .panel-title a:focus, .panel-title .open a:hover, .panel-title .open a:active, .panel-title .open a:focus {
	text-decoration:none;
	color:#fff !important;
}
.panel-title>.small, .panel-title>.small>a, .panel-title>a, .panel-title>small, .panel-title>small>a {
	display: block;
	color: #fff;
}
.panel-title a:hover {
	color: #fff !important;
}

.panel-title a:visited {
	color: #fff !important;
}

.panel-title a:active {
	color: #fff !important;
}




.menu-hide {
	display: none !important;
}
@media (min-width: 768px) {
.navbar-collapse.collapse {
display: block!important;
height: auto!important;
padding-bottom: 0;
overflow: visible!important;
padding-left:0px;
}
}
@media only screen and (min-width: 320px) and (max-width:680px) {
}
.menu-hide .panel-default>.panel-heading {
	color: #fff;
	background-color: #8e8c8c;
	border-color: #ddd;
}/********** END SIDEBAR *************//********** NAVBAR TOGGLE *************/
.navbar-toggle .icon-bar {
	background-color: #fff;
}
.navbar-toggle {
	padding: 11px 10px;
	margin-top: 8px;
	margin-right: 15px;
	margin-bottom: 8px;
	background-color: #a32638;
	border-radius: 0px;
}/********** END NAVBAR TOGGLE *************/
</style>
<div id="sidenav1">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#sideNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>
    <div class="collapse navbar-collapse" id="sideNavbar" style="background:#fff !important; padding: 0px !important;">
    <div class="panel-group" id="accordion">
        
        <div class="panel panel-default"> <div class="panel-heading"> 
            <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"> <i class="fa fa-sign-in"></i>
             Users<span class="caret"></span></a> </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse"> 
                <ul class="list-group"> 
                    <li class="navlink2"><a href="<?= base_url('adminAddUser') ?>"><i class="fa fa-angle-right"></i> Add User</a></li>
                    <li class="navlink2"><a href="<?= base_url('adminViewUser') ?>"><i class="fa fa-angle-right"></i> View User</a></li>
                </ul>
            </div>
        </div>
    
        <div class="panel panel-default" style="border: solid 1px #ddd;">
            <div class="panel-heading">
              <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><i class="fa fa-table"></i> Add Bank Details<span class="caret"></span></a> </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <ul class="list-group">
                    <li><a href="<?= base_url('addBankDetails') ?>" class="navlink"><i class="fa fa-angle-right"></i> Add Bank Lists</a></li>
                    <li><a href="<?php echo base_url() ?>viewBankDetailsview" class="navlink"><i class="fa fa-angle-right"></i> View Bank Lists</a></li>
                </ul>
            </div>
        </div>
        <?php //if($_SESSION['isUserSession']['email'] == "admin@gmail.com") { ?>
        <div class="panel panel-default" style="border: solid 1px #ddd;">
            <div class="panel-heading">
              <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><i class="fa fa-table"></i>&nbsp;Client Company Details<span class="caret"></span></a> </h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
                <ul class="list-group">
                    <li><a href="<?= base_url('addCompanyDetails'); ?>" class="navlink"><i class="fa fa-angle-right"></i>&nbsp;Company Lists</a></li>
                </ul>
            </div>
        </div>
        <div class="panel panel-default" style="border: solid 1px #ddd;">
            <div class="panel-heading">
              <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse4"><i class="fa fa-table"></i>&nbsp;Dashboard<span class="caret"></span></a> </h4>
            </div>
            <div id="collapse4" class="panel-collapse collapse">
                <ul class="list-group">
                    <li><a href="<?= base_url('adminViewDashboard'); ?>" class="navlink"><i class="fa fa-angle-right"></i>&nbsp;Add Menus</a></li>
                </ul>
            </div>
        </div>
        <?php //} ?>
      
 
     
      <div class="menu-hide">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
                <a href=""><span class="glyphicon glyphicon-new-window"></span>Add Company</a> 
            </h4>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"><a href=""><span class="glyphicon glyphicon-new-window"></span>External Link</a> </h4>
          </div>
        </div>
      </div>
      <!-- end hidden Menu items --> </div>
  </div>
</div>
