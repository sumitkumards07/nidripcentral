<section class="section">
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2 py-3">
                <h2 class="text-center" data-aos="fade-up" data-aos-duration="3000"><img src="<?php echo $company_logo; ?>" width="80" height="80" /></h2>
            </div>
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                <div class="card card-primary shadow-lg" data-aos="zoom-in" data-aos-duration="3000">
                    <div class="card-header"><h4>Register</h4></div>
                    <div class="card-body">

                        <span id="msg"></span>
                        <form method="post" enctype="multipart/form-data" onsubmit="return false" id="register_form">
                            <div class="row">
                                <div class="form-group col-4">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                          <input type="text" id="reg_fname" name="reg_fname" class="form-control valid" placeholder="First Name" autofocus="on" />
                                          <div class="input-group-append">
                                            <div class="input-group-text reg_fname">
                                              <span class="fas fa-user reg_fname"></span>
                                            </div>
                                          </div>
                                        </div>
                                        <span class="reg_fname_error text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group col-4">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                          <input type="text" id="reg_lname" name="reg_lname" class="form-control valid" placeholder="Last Name" />
                                          <div class="input-group-append">
                                            <div class="input-group-text reg_lname">
                                              <span class="fas fa-user reg_lname"></span>
                                            </div>
                                          </div>
                                        </div>
                                        <span class="reg_lname_error text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group col-4">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                          <input type="text" id="reg_mobile" name="reg_mobile" class="form-control valid" placeholder="Enter Mobile" />
                                          <div class="input-group-append">
                                            <div class="input-group-text reg_mobile">
                                              <span class="fas fa-mobile reg_mobile"></span>
                                            </div>
                                          </div>
                                        </div>
                                        <span class="reg_mobile_error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <input type="file" id="reg_image" name="reg_image" class="form-control valid" value="../uploads/users/dummy.png">
                                            <div class="input-group-append">
                                                <div class="input-group-text reg_image">
                                                    <span class="fas fa-image reg_image"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="reg_image_error text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <input type="text" id="reg_username" name="reg_username" class="form-control valid" placeholder="Username">
                                            <div class="input-group-append">
                                                <div class="input-group-text reg_username">
                                                    <span class="fas fa-info reg_username"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="reg_username_error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <input type="email" id="reg_email" name="reg_email" class="form-control valid" placeholder="User email">
                                        <div class="input-group-append">
                                            <div class="input-group-text reg_email">
                                                <span class="fas fa-envelope reg_email"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="reg_email_error text-danger"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                          <input type="password" id="reg_password" name="reg_password" class="form-control valid" placeholder="Enter Password">
                                          <div class="input-group-append">
                                            <div class="input-group-text reg_password">
                                              <span class="fas fa-lock reg_password"></span>
                                            </div>
                                          </div>
                                        </div>
                                        <span class="reg_password_error text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                          <input type="password" id="reg_passcode" name="reg_passcode" class="form-control valid" placeholder="Confirm Password">
                                          <div class="input-group-append">
                                            <div class="input-group-text reg_passcode">
                                              <span class="fas fa-lock reg_passcode"></span>
                                            </div>
                                          </div>
                                        </div>
                                        <span class="reg_passcode_error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="reg_type" value="User" >
                            <input type="hidden" name="reg_status" value="Pending" >
                          <div class="form-group">
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                              <label class="custom-control-label" for="agree">I agree with the <a href="#">terms and conditions</a></label>
                            </div>
                          </div>
                          <div class="form-group">
                            <input type="submit" name="btn_register" id="btn_register" class="btn btn-primary btn-lg btn-block" value="Register">
                          </div>
                        </form>
                        
                    </div>
                    <div class="mb-0 text-muted text-center">
                        Already Registered? <a href="<?php echo $AaliLINK; ?>">Sign In</a>
                    </div>
                    <div class="mb-2 text-muted text-center">
                        Developed by: <b><a href="https://mraalionline.com/" target="_blank">mraalionline.com</a></b>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>