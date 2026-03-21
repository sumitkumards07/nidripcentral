$(document).ready(function(){

    //Login Scripts..
    $("#login_form").on("submit",function(){        
        var user_email = $("#user_email");
        var user_password = $("#user_password");
        var status = false;

        if(user_email.val() === ""){
            $("#user_email").css("border-color","#DD4B39");
            $(".user_email").css("border-color","#DD4B39");
            $(".user_email").css("background-color","#F5B7B1");
            $(".user_email").css("color","#DD4B39");
            $(".user_email_error").html("<small class='form-text text-danger' style='color: #DD4B39;'>Enter username</small>");
            status = false;
        }else{
            $("#user_email").css("border-color","#19940C");
            $(".user_email").css("border-color","#19940C");
            $(".user_email").css("background-color","#B6E5B1");
            $(".user_email").css("color","#19940C");
            $(".user_email_error").html("<small class='form-text text-success' style='color: #19940C;'>Seems Good</small>");
            status = true;
        }

        if(user_password.val() === ""){
            $("#user_password").css("border-color","#DD4B39");
            $(".user_password").css("border-color","#DD4B39");
            $(".user_password").css("background-color","#F5B7B1");
            $(".user_password").css("color","#DD4B39");
            $(".user_password_error").html("<small class='form-text text-danger' style='color: #DD4B39;'>Enter Password</small>");
            status = false;
        }else{
            $("#user_password").css("border-color","#19940C");
            $(".user_password").css("border-color","#19940C");
            $(".user_password").css("background-color","#B6E5B1");
            $(".user_password").css("color","#19940C");
            $(".user_password_error").html("<small class='form-text text-success' style='color: #19940C;'>Seems Good</small>");
            status = true;
        }

        if(status){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                method: "POST",
                data: $("#login_form").serialize(),
                success: function(data){
                    if(data == "User Not Registered!"){
                        $("#msg").html("<div class='alert alert-info alert-block'>"+data+"</div>");                                    
                        $("#user_email").css("border-color","#DD4B39");
                        $(".user_email").css("border-color","#DD4B39");
                        $(".user_email").css("background-color","#F5B7B1");
                        $(".user_email").css("color","#DD4B39");
                        $("#user_email_error").html("<small class='form-text text-danger' style='color: #DD4B39;'>User Email Not Registered! </small>"); 
                    }else if(data == "Password doesn't match!"){
                        $("#msg").html("<div class='alert alert-danger'>"+data+"</div>");
                        $("#user_password").css("border-color","#DD4B39");
                        $(".user_password").css("border-color","#DD4B39");
                        $(".user_password").css("background-color","#F5B7B1");
                        $(".user_password").css("color","#DD4B39");
                        $(".user_password_error").html("<small class='form-text text-danger' style='color: #DD4B39;'>Password doesn't match! </small>");          
                    }else if(data == "Admin Logged In Successfully!"){
                        $("#msg").html("<div class='alert alert-success'> Redirecting.. </div>");
                        $("#btn_login").html("<img src='https://nidrip.mraalionline.com/cms/assets/img/loading.gif' width='20'/> &nbsp; Signing in..");
                        setTimeout('window.location.href = "https://nidrip.mraalionline.com/cms/admin/temp/?_rdct=Welcome";', 2000);          
                    }else if(data == "Super Admin Logged In Successfully!"){
                        $("#msg").html("<div class='alert alert-success'> Redirecting.. </div>");
                        $("#btn_login").html("<img src='https://nidrip.mraalionline.com/cms/assets/img/loading.gif' width='20'/> &nbsp; Signing in..");
                        setTimeout('window.location.href = "https://nidrip.mraalionline.com/cms/admin/temp/?_rdct=Welcome";', 2000);          
                    }
                }
            })
        }
    })
    
    
    
    
    
    
    
    
    
    
    
     
    
    $("#register_form").on("submit",function(){
        var reg_fname = $("#reg_fname");
        var reg_lname = $("#reg_lname");
        var reg_username = $("#reg_username");
        var reg_mobile = $("#reg_mobile");
        var reg_image = $("#reg_image");
        var reg_email = $("#reg_email");
        var reg_password = $("#reg_password");
        var reg_passcode = $("#reg_passcode");
        var email_pattern = new RegExp(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{3,4})$/);
        var status = false;

        if(reg_fname.val() === ""){
            $("#reg_fname").css("border-color","#DD4B39");
            $(".reg_fname").css("border-color","#DD4B39");
            $(".reg_fname").css("background-color","#F5B7B1");
            $(".reg_fname").css("color","#DD4B39");
            $(".reg_fname_error").html("<small class='form-text text-danger' style='color: #DD4B39;'>Enter Full Name</small>");
            status = false;
        }else{
            $("#reg_fname").css("border-color","#19940C");
            $(".reg_fname").css("border-color","#19940C");
            $(".reg_fname").css("background-color","#B6E5B1");
            $(".reg_fname").css("color","#19940C");
            $(".reg_fname_error").html("<small class='form-text text-success' style='color: #19940C;'>Seems Good</small>");
            status = true;
        }
        if(reg_lname.val() === ""){
            $("#reg_lname").css("border-color","#DD4B39");
            $(".reg_lname").css("border-color","#DD4B39");
            $(".reg_lname").css("background-color","#F5B7B1");
            $(".reg_lname").css("color","#DD4B39");
            $(".reg_lname_error").html("<small class='form-text text-danger' style='color: #DD4B39;'>Enter Last Name</small>");
            status = false;
        }else{
            $("#reg_lname").css("border-color","#19940C");
            $(".reg_lname").css("border-color","#19940C");
            $(".reg_lname").css("background-color","#B6E5B1");
            $(".reg_lname").css("color","#19940C");
            $(".reg_lname_error").html("<small class='form-text text-success' style='color: #19940C;'>Seems Good</small>");
            status = true;
        }
        if(reg_mobile.val() === ""){
            $("#reg_mobile").css("border-color","#DD4B39");
            $(".reg_mobile").css("border-color","#DD4B39");
            $(".reg_mobile").css("background-color","#F5B7B1");
            $(".reg_mobile").css("color","#DD4B39");
            $(".reg_mobile_error").html("<small class='form-text text-danger' style='color: #DD4B39;'>Enter Mobile Number</small>");
            status = false;
        }else{
            $("#reg_mobile").css("border-color","#19940C");
            $(".reg_mobile").css("border-color","#19940C");
            $(".reg_mobile").css("background-color","#B6E5B1");
            $(".reg_mobile").css("color","#19940C");
            $(".reg_mobile_error").html("<small class='form-text text-success' style='color: #19940C;'>Seems Good</small>");
            status = true;
        }
        if(reg_image.val() === ""){
            $("#reg_image").css("border-color","#DD4B39");
            $(".reg_image").css("border-color","#DD4B39");
            $(".reg_image").css("background-color","#F5B7B1");
            $(".reg_image").css("color","#DD4B39");
            $(".reg_image_error").html("<small class='form-text text-danger' style='color: #DD4B39;'>Choose Image</small>");
            status = false;
        }else{
            $("#reg_image").css("border-color","#19940C");
            $(".reg_image").css("border-color","#19940C");
            $(".reg_image").css("background-color","#B6E5B1");
            $(".reg_image").css("color","#19940C");
            $(".reg_image_error").html("<small class='form-text text-success' style='color: #19940C;'>Seems Good</small>");
            status = true;
        }
        if(reg_username.val() === ""){
            $("#reg_username").css("border-color","#DD4B39");
            $(".reg_username").css("border-color","#DD4B39");
            $(".reg_username").css("background-color","#F5B7B1");
            $(".reg_username").css("color","#DD4B39");
            $(".reg_username_error").html("<small class='form-text text-danger' style='color: #DD4B39;'>Enter Userame</small>");
            status = false;
        }else{
            $("#reg_username").css("border-color","#19940C");
            $(".reg_username").css("border-color","#19940C");
            $(".reg_username").css("background-color","#B6E5B1");
            $(".reg_username").css("color","#19940C");
            $(".reg_username_error").html("<small class='form-text text-success' style='color: #19940C;'>Seems Good</small>");
            status = true;
        }
        if(reg_email.val() === "" || !email_pattern.test(reg_email.val())){
            $("#reg_email").css("border-color","#DD4B39");
            $(".reg_email").css("border-color","#DD4B39");
            $(".reg_email").css("background-color","#F5B7B1");
            $(".reg_email").css("color","#DD4B39");
            $(".reg_email_error").html("<small class='form-text text-danger' style='color: #DD4B39;'>Enter Valid Email LIKE <b>abc@xyz.com</b></small>");
            status = false;
        }else{
            $("#reg_email").css("border-color","#19940C");
            $(".reg_email").css("border-color","#19940C");
            $(".reg_email").css("background-color","#B6E5B1");
            $(".reg_email").css("color","#19940C");
            $(".reg_email_error").html("<small class='form-text text-success' style='color: #19940C;'>Seems Good</small>");
            status = true;
        }
        if(reg_password.val() === ""){
            $("#reg_password").css("border-color","#DD4B39");
            $(".reg_password").css("border-color","#DD4B39");
            $(".reg_password").css("background-color","#F5B7B1");
            $(".reg_password").css("color","#DD4B39");
            $(".reg_password_error").html("<small class='form-text text-danger' style='color: #DD4B39;'>Enter Password</small>");
            status = false;
        }else{
            $("#reg_password").css("border-color","#19940C");
            $(".reg_password").css("border-color","#19940C");
            $(".reg_password").css("background-color","#B6E5B1");
            $(".reg_password").css("color","#19940C");
            $(".reg_password_error").html("<small class='form-text text-success' style='color: #19940C;'>Seems Good</small>");
            status = true;
        }
        
        if(reg_passcode.val() === reg_password.val() && reg_passcode.val() != ""){
            $("#reg_passcode").css("border-color","#19940C");
            $(".reg_passcode").css("border-color","#19940C");
            $(".reg_passcode").css("background-color","#B6E5B1");
            $(".reg_passcode").css("color","#19940C");
            $(".reg_passcode_error").html("<small class='form-text text-success' style='color: #19940C;'>Seems Good</small>");
            status = true;
        }else{
            $("#reg_passcode").css("border-color","#DD4B39");
            $(".reg_passcode").css("border-color","#DD4B39");
            $(".reg_passcode").css("background-color","#F5B7B1");
            $(".reg_passcode").css("color","#DD4B39");
            $(".reg_passcode_error").html("<small class='form-text text-danger' style='color: #DD4B39;'>Password doesn't match</small>");
            status = false;
        }

        if(status){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    if(data=="Invalid Format!"){
                        $("#reg_image").css("border-color","#DD4B39");
                        $(".reg_image").css("color","#DD4B39");
                        $("#reg_image_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Invalid Format! </span>");
                    }else if(data == "User already exists!"){
                        $("#msg").html("<div class='alert alert-warning alert-block'>"+data+"</div>");                                    
                        $("#reg_email").css("border-color","#DD4B39");
                        $(".reg_email").css("border-color","#DD4B39");
                        $(".reg_email").css("background-color","#F5B7B1");
                        $(".reg_email").css("color","#DD4B39");
                        $("#reg_email_error").html("<small class='form-text text-danger' style='color: #DD4B39;'>User already exists! </small>"); 
                    }else if(data =="Registered Successfully!"){
                        $("#msg").html("<div class='alert alert-primary alert-block'> Redirecting.. </div>");
                        $("#btn_register").html("<img src='https://nidrip.mraalionline.com/cms/assets/img/loading.gif' width='20'/> &nbsp; Registering..");
                        setTimeout('window.location.href = "https://nidrip.mraalionline.com/cms/?login";',2000);          
                    }else{
                        $("#msg").html("<div class='alert alert-danger'> Something went wrong! </div>");
                    }
                }
            })
        }

    })











    

    


})