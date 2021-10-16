<?php $this->load->view('common_front/header');?>
	
	<!-- Banners -->
<div class="page-banner about-us">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4>Login</h4>
                <p><a href="index.html">Home</a> &nbsp; | &nbsp; <span>Login</span></p>
            </div>
           
        </div>
    </div>
</div>


<!-- section 1 -->
    <div class="section" >
    <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="login_box">
                          <p>
                                <a href="index.html">
                                        <img src="<?= base_url('public/front/')?>images/logo.png" alt="" class="img-responsive center-block">
                                    </a>
                          </p>
                          <p class="para text-center">Login with</p>
                            <p class="text-center"><a href="#" class="facebok-link"><i class="fa fa-facebook-f"></i> &nbsp; FACEBOOK</a> <a href="#" class="google-link"><i class="fa fa-google"></i> &nbsp; GOOGLE</a></p>
                            <P class="or-line"><span>OR</span></P>
                        <form action="">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" placeholder="Email Id" class="form-control">
                            </div>
                            <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="text" placeholder="Password" class="form-control">
                            </div>
                            <div class="form-group">
                                    <p class="para">Forget password ? <a href="forget-pass.html" class="text-danger"><small>Reset Password</small></a></p>
                            </div>
                           <div class="row">
                                <div class="col-sm-12 text-center"> 
                                    <a href="user-dashboard/dashboard.html" class="btn btn-success">Login</a> OR
                                 <a href="register.html" class="btn btn-md btn-primary">Register Now</a>
                            </div>
                        </div>
                            
                        </form>
                    </div>
                </div>
            </div>
    </div>
    </div>


<?php $this->load->view('common_front/footer');?>