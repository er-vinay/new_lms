<?php $this->load->view('common_front/header');?>
	
	<!-- Banners -->
<div class="page-banner about-us">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4>Register</h4>
                <p><a href="index.html">Home</a> &nbsp; | &nbsp; <span>Register</span></p>
            </div>
           
        </div>
    </div>
</div>


<!-- section 1 -->
    <div class="section" >
    <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                        <p class="para">Fill all details**</p>
                    <div class="login_box">
                                <p>
                                <a href="<?= base_url()?>">
                                        <img src="<?= base_url('public/front/')?>images/logo.png" alt="" class="img-responsive center-block">
                                        </a>
                                </p>
                      <div class="row">
                            <form action="<?= base_url('signup')?>" method="post" enctype="multipart/form-data">
                                <div class="col-sm-12">
                                        <div class="form-group">
                                                <label for="">Title*</label>
                                                <select name="title" id="" class="form-control" required>
                                                    <option value="">Title</option>
                                                    <option value="Mr">Mr</option>
                                                    <option value="Mrs">Mrs</option>
                                                    <option value="Miss">Miss</option>
                                                </select>
                                            </div>
                                </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="">First Name</label>
                                                <input type="text" value="<?= set_value('first_name')?>" placeholder="First Name" name="first_name" class="form-control">
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="">Last Name</label>
                                                <input type="text" value="<?= set_value('last_name')?>" placeholder="Last Name" name="last_name" class="form-control">
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" value="<?= set_value('email')?>" placeholder="Last Name" name="email" class="form-control">
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="">Phone</label>
                                                <input type="text" value="<?= set_value('phone')?>" name="phone" placeholder="Phone" class="form-control">
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="">Address 1</label>
                                                <input type="text" value="<?= set_value('address')?>" name="address" placeholder="Address Line 1" class="form-control">
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="">Address 2</label>
                                                <input type="text" value="<?= set_value('address2')?>" name="address2" placeholder="Address Line 2" class="form-control">
                                        </div>
                                   </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="">Country</label>
                                                <input type="text" value="<?= set_value('country')?>" placeholder="Country" name="country" class="form-control">
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="">State</label>
                                                <input type="text" value="<?= set_value('state')?>" placeholder="State" name="state" class="form-control">
                                        </div>
                                   </div>

                                   <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="">City</label>
                                                <input type="text" value="<?= set_value('city')?>" placeholder="City" name="city" class="form-control">
                                        </div>
                                   </div>
                                   
                                  
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="">Pin Code</label>
                                                <input type="text" value="<?= set_value('pincode')?>" placeholder="Pin Code" name="pincode" class="form-control">
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="">Password</label>
                                                <input type="password"  placeholder="Password" name="password" class="form-control">
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="">Confirm Password</label>
                                                <input type="password"  placeholder="Confirm Password" name="confirm_password" class="form-control">
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="">Nationality</label>
                                                <input type="text" value="<?= set_value('nationality')?>" placeholder="Nationality" name="nationality" class="form-control">
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="">Profile Image</label>
                                                <input type="file"  placeholder="" name="profile" class="form-control">
                                        </div>
                                   </div>
                                 <div class="space"></div>
                                 
                                        <div class="col-sm-12 text-center"> 
                                            <input type="submit" class="btn btn-success" value="Register">OR 
                                            <a href="<?= base_url('signin')?>" class="btn btn-md btn-primary">Login</a>
                                    </div>
                                </form>
                      </div>
                    </div>
                </div>
            </div>
    </div>
    </div>


<?php $this->load->view('common_front/footer');?>