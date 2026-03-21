<section class="section" style="width:100%;height:100%;background: linear-gradient(to bottom, #ff2b8a, #6ee28e);">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 py-3">
                <h2 class="text-center" data-aos="fade-up" data-aos-duration="3000"><img src="<?php echo $AaliLINK; ?>/uploads/logos/<?php echo $company_logo; ?>" height="80" /></h2>
            </div>
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4" style="min-height: 89vh;">
                <div class="card card-primary shadow-lg" data-aos="zoom-in" data-aos-duration="3000">
                    <div class="card-header">
                        <h4 class="text-center">Login</h4>
                    </div>
                    <div class="card-body">
                        <span id="msg"></span>
                        <form method="post" id="login_form" onsubmit="return false">
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <input type="text" id="user_email" name="user_email" class="form-control valid" placeholder="Enter username">
                                    <div class="input-group-append">
                                        <div class="input-group-text user_email">
                                            <span class="fas fa-envelope user_email"></span>
                                        </div>
                                    </div>
                                </div>
                                <span class="user_email_error"></span>
                            </div>
                            <div class="form-group mb-3">
                                <div class="d-block">
                                  <label for="password" class="control-label">Password</label>
                                  <div class="float-right">
                                    <a href="#" class="text-small">
                                      Forgot Password?
                                    </a>
                                  </div>
                                </div>
                              <div class="input-group">
                                <input type="password" id="user_password" name="user_password" class="form-control valid" placeholder="Enter Password">
                                <div class="input-group-append">
                                  <div class="input-group-text user_password">
                                    <span class="fas fa-lock user_password"></span>
                                  </div>
                                </div>
                              </div>
                              <span class="user_password_error"></span>
                            </div>
                          <div class="form-group">
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                              <label class="custom-control-label" for="remember-me">Remember Me</label>
                            </div>
                          </div>
                          <div class="form-group">
                            <input type="submit" id="btn_login" class="btn btn-primary btn-lg btn-block" tabindex="4" value="Sign In" style="background: linear-gradient(to top, #ff2b8a, #6ee28e);">
                          </div>
                        </form>
                    
                    </div>
                </div>
                <div class="mt-0 text-muted text-center">
                  Developed by: <b><a href="https://mraalionline.com" target="_blank">mraalionline.com</a></b>
                </div>
            </div>
        </div>
    </div>
</section>