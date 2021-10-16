<?php if(!empty($_SESSION['isUserSession']['user_id'])){ ?>
    <?php $this->load->view('Layouts/header') ?>
<?php }else{ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Log In</title>
        <link rel="icon" href="<?= base_url('public/front'); ?>/images/fav.png" type="image/*" />
        <link rel="stylesheet preload" href="<?= base_url('public/front'); ?>/css/bootstrap.min.css">
        <link rel="stylesheet preload" href="<?= base_url('public/front'); ?>/css/bootstrap.css">
        <link rel="stylesheet preload" href="<?= base_url('public/front'); ?>/css/font-awesome.min.css">
        <link rel="stylesheet preload" href="<?= base_url('public/front'); ?>/css/style.css">
        <script src="<?= base_url('public/front'); ?>/js/jquery.3.5.1.min.js"></script>
        <style>
            body{
                background-image: url('<?= base_url('public/front'); ?>/../images/login_background_img.jpg');
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                background-color: #464646;
            }
            .form{
                background: #fff;
                border: 1px solid #fff;
                padding: 20px;
                margin: 18%;
                box-shadow: 0px 0px 5px gray;
                border-radius: 0px 50px;
            }
            input[type="text"], input[type="password"]{
                height: 45px;
                border-top:0;
                border-left:0;
                border-right:0;
                border-radius: 0;
                text-align: center;
            }
            button[id="userSigin"]{
                width: 50%;
                margin-left: 25%;
                height: 45px;
                border-top:0;
                border-left:0;
                border-right:0;
                border-radius: 0;
                text-align: center;
                background-color: #0d7ec0;
                color: #fff;
            }
            button[id="userSigin"]:hover {
                background-color: #005d86;
                color: #fff;
            }
            h1{
                color: #0d7ec0;
                font-size: 20px;
            }
            p{
                margin-bottom: 40px;
            }
            @media all and (max-width: 320px), (max-width: 375px), (max-width: 384px), (max-width: 414px), (max-device-width: 450px), (max-device-width: 480px), (max-device-width: 540px), (max-device-width: 590px), (max-device-width: 620px), (max-device-width: 680px)
            {
                .form{
                    background: #fff;
                    border: 1px solid #fff;
                    padding: 20px;
                    margin: 0%;
                    box-shadow: 0px 0px 5px gray;
                    border-radius: 0px 50px;
                    margin-top: 30%;
                }
            }
        </style>
    </head>
    <body>
<?php } ?>

<!-- section start -->
<section>
    <div class="container-fluid">
        <div class="taskPageSize" style="height: 555px;">
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
                <div class="col-md-6 col-md-offset-3">
                    <div class="page-container list-menu-view">
                        <div class="page-content">
                            <div class="main-container">
                                <div class="container-fluid">
                                    <div class="col-md-12">
                                        <div class="login-formmea">
                                            <div class="box-widget widget-module">
                                                <div class="widget-head clearfix">
                                                    <span class="h-icon"><i class="fa fa-th"></i></span>
                                                    <h4>Change Password</h4>
                                                </div>
                                                <?php  if($this->session->flashdata('msg')!=''){ ?>
                                                    <p class="alert alert-success alert-dismissible">
                                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                        <strong><?= $this->session->flashdata('msg'); ?></strong> 
                                                    </p>
                                                <?php } if($this->session->flashdata('err')!=''){ ?>
                                                    <p class="alert alert-danger alert-dismissible">
                                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                        <strong>'<?= $this->session->flashdata('err'); ?></strong> 
                                                    </p>
                                                <?php } ?>
                                                <div class="widget-container">
                                                    <div class=" widget-block">
                                                        <form action="<?= base_url('generatePassword') ?>" method="post" enctype="multipart/form-data">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label><span class="span">*</span> New Password</label>
                                                                    <input type="text" class="form-control" name="password" id="password" required>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top : 20px;">
                                                                    <button type="submit" class="btn btn-control btn-primary">Create</button>
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
<?php if(!empty($_SESSION['isUserSession']['user_id'])){ ?>
<?php $this->load->view('Layouts/footer') ?>
<?php }else{ ?>
        <script src="<?= base_url('public/front'); ?>/js/jquery.3.5.1.min.js"></script>
    </body>
</html>
<?php } ?>