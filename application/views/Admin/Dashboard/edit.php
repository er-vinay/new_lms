<?php $this->load->view('Layouts/header') ?>
<?php
    // echo "<pre>"; print_r($menu); exit;
?>
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
                                                    <h4>Edit Menu</h4>
                                                </div>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <form action="<?= base_url('adminUpdateDashboardMenu/'. $this->encrypt->encode($menu->id)) ?>" method="post" enctype="multipart/form-data">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>" readonly/>
                                                            <input type="hidden" name="menu_id" value="<?= $menu->id ?>" readonly/>
                                                        
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label><span class="span">*</span> Company</label>
                                                                    <select id="company_id" class="form-control" name="company_id" class="form-control" required>
                                                                        <option value="">Select Company</option>
                                                                        <?php foreach($company->result() as $row) : 
                                                                            $s = '';
                                                                            if($row->company_id == $menu->company_id) 
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
                                                                            if($row->product_id == $menu->product_id) 
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
                                                                    <input type="text" class="form-control" name="menu_name" id="menu_name" value="<?= $menu->menu_name ?>" required>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label><span class="span">*</span> Route Link</label>
                                                                    <input type="text" class="form-control" name="route_link" id="route_link" value="<?= $menu->route_link ?>" required>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label><span class="span">*</span> Menu Order By</label>
                                                                    <input type="text" class="form-control" name="menu_order" id="menu_order" value="<?= $menu->menu_order ?>" required>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label><span class="span">*</span> Icon</label>
                                                                    <input type="text" class="form-control" name="icon" id="icon" value="<?= $menu->icon ?>" required>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label><span class="span">*</span> Box Background Color</label>
                                                                    <input type="text" class="form-control" name="box_bg_color" id="box_bg_color" value="<?= $menu->box_bg_color ?>" required>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label><span class="span">*</span> Is Active</label>
                                                                    <select class="form-control" name="is_active" id="is_active" required>
                                                                        <option value="">Select</option>
                                                                        <option value="1" <?php if($menu->is_active == 1) { echo "selected"; } ?>>Active</option>
                                                                        <option value="0" <?php if($menu->is_active == 0) { echo "selected"; } ?>>In Active</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <button class="button-add btn btn-ifo">Update</button>
                                                                </div>

                                                            </div>
                                                        </form>

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