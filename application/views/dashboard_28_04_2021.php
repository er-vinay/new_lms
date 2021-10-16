<?php $this->load->view('Layouts/header') ?>
<?php
    include('../models/Task_Model.php');
    $task_Model = new Task_Model();
    $getLeadDetails = $task_Model->getLeadDetails();
    $getApplicationinProcess = $task_Model->applicationinprocess();
    $getapplicationHold = $task_Model->applicationHold();
    $getleadsforSanction = $task_Model->getleadsforSanction();
    $rejectedTask = $task_Model->rejectedTask();
    $inProcess = $task_Model->inProcess();
    $recommend = $task_Model->recommend();
    $sendBack = $task_Model->leadSendBack();
    $leadSanctioned = $task_Model->leadSanctioned();
    $leadDisbursed = $task_Model->leadDisbursed();
    $HoldSanction = $task_Model->sanctionHold(); ;
?>
<style type="text/css">
    .dashboardBox{border-radius: 5px;margin-top: 17px;}
    .dashboardMargin{margin-top: 130px !important;}
</style>
<section>
    <div class="container dashboard-wid">
        <div class="taskPageSizeDashboard dashboardMargin" style="margin-top: 53px !important;">
            <div class="row">
                <?php if($_SESSION['isUserSession']['role'] == "Sanction Head" || $_SESSION['isUserSession']['role'] == "Tellecaller" || $_SESSION['isUserSession']['role'] == "Client Admin") { ?>
                <div class="col-md-2 col-sm-6 col-xs-6 col-md-2-me">
                    <a href="<?= base_url('GetLeadTaskList') ?>">
                        <div class="lead-box text-center dashboardBox" style="background:#10302a">
                            <div class="row">
                                <div class="col-md-6"><div class="text-center">
                                <i class="fa fa-paper-plane-o"></i>
                            </div></div>
                                <div class="col-md-6"> <strong class="counter"><?= $getLeadDetails->num_rows(); ?></strong></div>
                                <div class="col-md-12"><span>Applications <br />New</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-2 col-sm-6 col-xs-6 col-md-2-me">
                    <a href="<?= base_url('applicationHold') ?>">
                        <div class="lead-box text-center dashboardBox" style="background:#187362">
                            <div class="row">
                                <div class="col-md-6"><div class="text-center">
                                 <i class="fa fa fa-folder-o"></i>
                            </div></div>
                                <div class="col-md-6">  <strong class="counter"><?= $getapplicationHold->num_rows(); ?></strong></div>
                                <div class="col-md-12"><span>Applications <br />Hold</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-2 col-sm-6 col-xs-6 col-md-2-me">
                    <a href="<?= base_url('applicationinprocess') ?>">
                        <div class="lead-box text-center dashboardBox" style="background:#17a98d">
                        <div class="row">
                                <div class="col-md-6"><div class="text-center">
                                 <i class="fa fa-crosshairs"></i>
                            </div></div>
                                <div class="col-md-6"> <strong class="counter"><?= $getApplicationinProcess->num_rows(); ?></strong></div>
                                <div class="col-md-12"><span>Applications <br />In Process</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php } ?>
                <?php if($_SESSION['isUserSession']['role'] == "Sanction Head" || $_SESSION['isUserSession']['role'] == "Sanction & Telecaller" || $_SESSION['isUserSession']['role'] == "Client Admin"){  ?>
                <div class="col-md-2 col-sm-6 col-xs-6 col-md-2-me">
                    <a href="<?= base_url('screeninLeads') ?>">
                        <div class="lead-box text-center dashboardBox">
                        <div class="row">
                                <div class="col-md-6"><div class="text-center">
                                 <i class="fa fa-leanpub"></i>
                            </div></div>
                                <div class="col-md-6"> <strong class="counter"><?= $getleadsforSanction->num_rows(); ?></strong></div>
                                <div class="col-md-12"><span>Leads <br />New</span></div>
                            </div>
                        </div>
                    </a>
                </div> 
                
                <div class="col-md-2 col-sm-6 col-xs-6 col-md-2-me">
                    <a href="<?= base_url('sanctionHold') ?>">
                        <div class="lead-box text-center dashboardBox" style="background: #0a516f">
                        <div class="row">
                                <div class="col-md-6"><div class="text-center">
                                 <i class="fa fa-pause"></i>
                            </div></div>
                                <div class="col-md-6"><strong class="counter"><?= $HoldSanction->num_rows(); ?></strong></div>
                                <div class="col-md-12"><span>Leads <br />Hold</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-2 col-sm-6 col-xs-6 col-md-2-me">
                    <a href="<?= base_url('inProcess') ?>">
                        <div class="lead-box text-center dashboardBox" style="background: #06668e;">
                        <div class="row">
                                <div class="col-md-6"><div class="text-center">
                                 <i class="fa fa-cogs"></i>
                            </div></div>
                                <div class="col-md-6"><strong class="counter"><?= $inProcess->num_rows(); ?></strong></div>
                                <div class="col-md-12"><span>Leads <br />In Process</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-2 col-sm-6 col-xs-6 col-md-2-me">
                    <a href="<?= base_url('leadRecommend') ?>">
                        <div class="lead-box text-center dashboardBox" style="background: #067fb1;">
                        <div class="row">
                                <div class="col-md-6"><div class="text-center">
                                 <i class="fa fa-external-link"></i>
                            </div></div>
                                <div class="col-md-6"><strong class="counter"><?= $recommend->num_rows(); ?></strong></div>
                                <div class="col-md-12"><span>Leads <br />Recommended</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-2 col-sm-6 col-xs-6 col-md-2-me">
                    <a href="<?= base_url('leadSendBack') ?>">
                        <div class="lead-box text-center dashboardBox" style="background: #0596ad;">
                            <div class="row">
                                <div class="col-md-6"><div class="text-center">
                                 <i class="fa fa-reply"></i>
                            </div></div>
                                <div class="col-md-6">   <strong class="counter"><?= $sendBack->num_rows(); ?></strong></div>
                                <?php if($_SESSION['isUserSession']['role'] == "Sanction & Telecaller") { ?>
                                <span>Queried</span>
                                <?php } else { ?>
                                <div class="col-md-12"> <span>Leads <br />Sent Back</span></div>
                                <?php } ?>
                            </div>  
                        </div>
                    </a>
                </div>
                
                <div class="col-md-2 col-sm-6 col-xs-6  col-md-2-me">
                    <a href="<?= base_url('leadSanctioned') ?>">
                        <div class="lead-box text-center dashboardBox" style="background: #8c8e05;">
                        <div class="row">
                                <div class="col-md-6"><div class="text-center">
                                 <i class="fa fa-thumbs-o-up"></i>
                            </div></div>
                                <div class="col-md-6"><strong class="counter"><?= $leadSanctioned->num_rows(); ?></strong></div>
                                <div class="col-md-12"><span class="singal-box-text">Sanctioned</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-2 col-sm-6 col-xs-6 col-md-2-me">
                    <a href="<?= base_url('rejectedTaskList') ?>">
                        <div class="lead-box text-center dashboardBox" style="background: #880404;">
                        <div class="row">
                                <div class="col-md-6"><div class="text-center">
                                   <i class="fa fa-thumbs-o-down"></i>
                            </div></div>
                                <div class="col-md-6"><strong class="counter"><?= $rejectedTask->num_rows(); ?></strong></div>
                                <div class="col-md-12"><span class="singal-box-text">Rejected</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <?php }  ?>
                <?php if($_SESSION['isUserSession']['role'] == "Disbursal" || $_SESSION['isUserSession']['role'] == "Sanction Head" || $_SESSION['isUserSession']['role'] == "Client Admin")  {?>
                <div class="col-md-2 col-sm-6 col-xs-6  col-md-2-me">
                    <a href="<?= base_url('leadDisbursed') ?>">
                        <div class="lead-box text-center dashboardBox" style="background: #08795f;">
                        <div class="row">
                                <div class="col-md-6"><div class="text-center">
                                   <i class="fa fa-university"></i>
                            </div></div>
                                <div class="col-md-6"><strong class="counter"><?= $leadDisbursed->num_rows(); ?></strong></div>
                                <div class="col-md-12"><span class="singal-box-text">Disbursed</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php } ?> 
                
               <?php if($_SESSION['isUserSession']['role'] == "Collection" || $_SESSION['isUserSession']['role'] == "Sanction Head" || $_SESSION['isUserSession']['role'] == "Recovery" || $_SESSION['isUserSession']['role'] == "Client Admin")  {?>
                <div class="col-md-2 col-sm-6 col-xs-6  col-md-2-me">
                    <a href="<?= base_url('Collection') ?>">
                        <div class="lead-box text-center dashboardBox" style="background: #5772be;">
                        <div class="row">
                                <div class="col-md-6"><div class="text-center">
                                  <i class="fa fa-money"></i>
                            </div></div>
                                <div class="col-md-6"><strong class="counter"></strong></div>
                                <div class="col-md-12"><span class="singal-box-text">Repayment</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php } ?>

                <?php if($role == "Account and MIS") { ?>
                <div class="col-md-2 col-sm-6 col-xs-6  col-md-2-me">
                    <a href="<?= base_url('MIS') ?>">
                        <div class="lead-box text-center dashboardBox" style="background: #578ebe;">
                        <div class="row">
                                <div class="col-md-6"><div class="text-center">
                                <i class="fa fa-money"></i>
                            </div></div>
                                <div class="col-md-6"><strong class="counter"></strong></div>
                                <div class="col-md-12"><span>MIS <br />Collection</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php } ?>
                
                <?php if($_SESSION['isUserSession']['role'] == "") { ?>
                <div class="col-md-2 col-sm-6 col-xs-6  col-md-2-me">
                    <a href="<?= base_url('MIS') ?>">
                        <div class="lead-box text-center dashboardBox" style="background: #acb5b4;">
                        <div class="row">
                                <div class="col-md-6"><div class="text-center">
                               <i class="fa fa-inr"></i>
                            </div></div>
                                <div class="col-md-6"><strong class="counter"></strong></div>
                                <div class="col-md-12"><span class="singal-box-text">Accounts</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                 
                <div class="col-md-2 col-sm-6 col-xs-6  col-md-2-me">
                    <a href="<?= base_url('MIS') ?>">
                        <div class="lead-box text-center dashboardBox" style="background: #acb5b4;">
                        <div class="row">
                                <div class="col-md-6"><div class="text-center">
                               <i class="fa fa-times-circle"></i>
                            </div></div>
                                <div class="col-md-6"> <strong class="counter"></strong></div>
                                <div class="col-md-12"><span class="singal-box-text">Closure</span></div>
                            </div>
                        </div>
                    </a>
                </div> 
                <?php } ?>
                
                <?php if($_SESSION['isUserSession']['role'] == "Collection" 
                        || $_SESSION['isUserSession']['role'] == "Client Admin" 
                        || $_SESSION['isUserSession']['role'] == "Account and MIS"){ ?>
                <div class="col-md-2 col-sm-6 col-xs-6  col-md-2-me">
                    <a href="<?= base_url('exportData/') ?>">
                        <div class="lead-box text-center dashboardBox" style="background:#81c994">
                        <div class="row">
                                <div class="col-md-6"><div class="text-center">
                                <i class="fa fa-paper-plane-o"></i>
                            </div></div>
                                <div class="col-md-6"> <strong class="counter"></strong></div>
                                <div class="col-md-12"><span class="singal-box-text">Reports</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('Layouts/footer') ?>