<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="">
        <meta name="description" content="">
        <meta name="keywords" content=""> 
        <title> designhost.in </title>
        <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/login_css/');?>bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/login_css/');?>my-css.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/login_css/');?>font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/login_css/');?>color.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/login_css/');?>responcive.css">
    </head>
    <body>
        <div id="wrapper">
            <div id="login-form"> 
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-md-offset-4">
                            <div class="login-form-border">
                                <form method="post" action="<?= base_url('client-login');?>">
                                    <img src="<?= base_url('public/images/login_page_images/');?>logo.png" width="100" height="50" style="margin:0 auto;" class="img-responsive" alt="logo">
                                    <h3> Generate Password </h3>
                                    <?php if($this->session->flashdata('msg')!=''){ ?>
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

                                    <div class="form-group">
                                        <input type="text" name="agent_code" id="agent_code" title="Agent Code" placeholder="Agent Code" class="form-control input" required=""> 
                                    </div>

                                    <div class="form-group" id="password">
                                        <input type="password" name="password" id="password" title="New Password" placeholder="New Password" class="form-control input"> 
                                    </div>

                                    <div class="row row-top">
                                        <div class="col-md-9 col-xs-6">
                                            <!-- <p class="text2">
                                                <a href="#" style="color:#1a73e8;"> Forgot email ?</a>
                                            </p> -->
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <p class="login-top">
                                                <input type="submit" id="generate_password" title="Generate Password" class="btn btn-primary" value="Generate Password" >
                                            </p>
                                        </div> 
                                    </div>
                                    <!-- <p class="text3"> Check Order? If you need any information goto below link. <a href="https://www.designhost.in/">designhost.in</a></p>  -->
                                    <p class="alert alert-dismissible alert-success" id="success" style="display: none; width: 100%; float: right;"></p>
                                    <p class="alert alert-dismissible alert-danger" id="error" style="display: none; width: 100%; float: right;"></p>
                                </form>
                            </div> 
                        </div> 
                    </div> 
                </div>
            </div>
        </div> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("body").bind("cut copy paste",function (e) {
                    e.preventDefault();
                });
                  
                $("body").on("contextmenu",function(e){
                    return false;
                });
                
                $('#generate_password').on('click', function() {
                    $('#error').empty();
                    $('#success').empty();
                    var agent_code = $('#agent_code').val();
                    var password = $('#password').val();
                    if(agent_code == ''){
                        $('#error').append('Please Fill Agent Code!').show().css({'color' : 'red'}).fadeOut();
                        return false;
                    }else if(password == ''){
                        $('#error').append('Please Fill Password!').show().css({'color' : 'red'}).fadeOut();
                        return false;
                    }else{}
                });
            });
        </script>

    </body>
</html>
