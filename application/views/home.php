<?php $this->load->view('Layouts/header');?>
<style type="text/css">
    .dashboardBox{border-radius: 5px;margin-top: 17px;}
    .dashboardMargin{margin-top: 130px !important;}
</style>
<section>
    <div class="container dashboard-wid">
        <div class="taskPageSizeDashboard dashboardMargin" style="margin-top: 53px !important;">
            <div class="row">
                <?php //echo "<pre>";print_r($menusList->result());
                 $i = 0; foreach($menusList->result() as $menu) : ?>
                <div class="col-md-2 col-sm-6 col-xs-6 col-md-2-me">
                    <a href="<?= base_url($menu->route_link . "/" . $menu->stage) ?>">
                        <div class="lead-box text-center dashboardBox" style="background:<?= $menu->box_bg_color ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <i class="<?= $menu->icon ?>"></i>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6"> <strong class="counter"><?= $totalCounts[$i] ?></strong></div> -->
                                <div class="col-md-6"><strong class="counter"><?= $leadcount[$i] ?></strong></div>
                                <div class="col-md-12"><span><?= $menu->menu_name ?></span></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php $i++; endforeach; ?>
                
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('Layouts/footer') ?>