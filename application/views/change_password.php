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
        <?php $csrf = array(
                            'name' => $this->security->get_csrf_token_name(),
                            'hash' => $this->security->get_csrf_hash()
                            ); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form">
                        <form method="post" action="<?= base_url('verifyUser');?>" id="formData" autocomplete="off">
                            <p class="text-center">
                                <img src="<?= base_url('public/front'); ?>/images/logo.png" width="90" height="90" alt="logo">
                            </p>
                            <p class="text-center mb-4">
                                <div class="titleSignin text-center">#1 cloud based solution for Lending Business</div>
                            </p>
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
                            <div class="form-group">
                                <p class="text-center">
                                    <span style="color : red; font-size : 20px;">*</span>Your Email
                                </p>
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <input type="text" name="email" class="form-control" placeholder="Username" title="Username" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="form-control" id="userSigin" title="Verify Email">Verify Email</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer -->
        <script src="<?= base_url('public/front'); ?>/js/jquery.3.5.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                // $("#div-error-message").hide();
                // $("#userSigin").click(function(){
                //  var formData = $("#formData").serialize();
                //  $.ajax({
                //      url : "",
                //      type : "POST",
                //      data : formData,
                //      dataType : "json",
    //                  async: false,
                //      success : function(response){
                //          alert(response);
                //      },
                //      error: function(XMLHttpRequest, textStatus, errorThrown) { 
                //          $("#div-error-message").show();
                //          $("#div-error-message a").html(textStatus +" : "+ errorThrown);
                //          return false;
                //      }
                //  });
                // });

            });
        </script>
    </body>
</html>