$(document).ready(function(){

//Count Users..
    countedUser();
    function countedUser(){
        $.ajax({
            url : "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method : "POST",
            data : {countUsers:1},
            success : function(data){
                $(".count_users").html(data);
            }
        })
    }

    
//View Users..
    getUsers();
    function getUsers(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {viewUsers:1},
            success: function(data){
                $("#view_users").html(data);
            }
        })
    }
    
    
    
    
    
    
    
    
//Add Brand..
    $("#brand_form").on("submit",function(){
        var status = false;
        var brand_name = $("#brand_name").val();
        var brand_image = $("#customFile").val();

        if(brand_name === ""){
            $(".brand_name").css("border-color","#DD4B39");
            $(".brand_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter brand name </span>");
            status = false;
        }else{ status = true; }
        if(brand_image === ""){
            $(".brand_image").css("border-color","#DD4B39");
            $(".brand_image_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Upload brand logo </span>");
            status = false;
        }else{ status = true; }

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
                        $("#msg").html("<div class='alert alert-warning'>"+data+"</div>");
                        $(".brand_image").css("border-color","#DD4B39");
                        $(".brand_image_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Invalid Format! </span>");
                    }else if(data == "Brand already exists!"){
                        $("#msg").html("<div class='alert alert-info'>"+data+"</div>");
                        $(".brand_name").css("border-color","#DD4B39");
                        $(".brand_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Brand already exists! </span>");
                    }else if(data == "Brand Added!"){
                        $("#msg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){ 
                            $("#brand_form").trigger("reset");
                            $("#brand_view").fadeIn(1500).show();
                            getBrand();
                        })
                        $("#btn_brand").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Adding Brand..");
                    }else{
                        $("#msg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                        $("#brand_form").trigger("reset"); 
                    }
                }
            })
        }
    })
    
//Count Brands..
    countBrand();
    function countBrand(){
        $.ajax({
            url : "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method : "POST",
            data : {count_brand:1},
            success : function(data){
                $(".count_brand").html(data);
            }
        })
    }
    
//Brand for option..
    optionBrand();
    function optionBrand(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {fetchBrand:1},
            success: function(data){
                var root = "<option value='0'>Select Brand</option>";
                var choose = "<option value='0'>Choose Brand</option>";
                $(".product_brand").html(root+data);
                $(".update_product_brand").html(root+data);
            }
        })
    }
    
//View Brand..
    getBrand();
    function getBrand(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {viewBrand:1},
            success: function(data){
                $("#brand_view").html(data);
            }
        })
    }
    
//Show Brand Data In Form..
    $("body").delegate(".update_brand","click",function(){
        var uid = $(this).attr("uid");
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            dataType: "json",
            data: {updateBrand:1,id:uid},
            success: function(data){
                
                $("#update_brand_id").val(data['brand_id']);
                $("#udpate_brand_name").val(data['brand_name']);   
                $("#udpate_brand_image").val(data['brand_image']); 
            }
        })
    })
//Update Brand Data..
    $("#update_brand_form").on("submit",function(){
        var status = false;
        var update_brand_id = $("#update_brand_id").val();
        var update_brand_name = $("#update_brand_name").val();
        var update_brand_image = $("#update_brand_image").val();

        if(update_brand_name === ""){
            $(".update_brand_name").css("border-color","#DD4B39");
            $(".update_brand_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Brand Name </span>");
            status = false;
        }else{status = true;}

        if(update_brand_name !== "" && status === true){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    if(data=="Invalid File Format!"){
                        $(".update_brand_image").css("border-color","#DD4B39");
                        $(".update_brand_image_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Invalid File Format! </span>");
                    }else if(data == "Updated"){
                        $("#umsg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){ 
                            $("#update_brand").modal().fadeOut(1500).hide();
                            $("#brand_view").fadeIn(1500).show();
                            getBrand();
                        })
                        $("#btn_update_brand").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Updating Brand..");
                    }else{
                        $("#umsg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                    }
                }
            })
        }else if(update_brand_image.val() === "" && status === true){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                type: "POST",
                data: $("#update_brand_form").serialize(),
                success: function(data){
                    if(data == "Updated"){
                        $("#umsg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){ 
                            $("#update_brand").modal().fadeOut(1500).hide();
                            $("#brand_view").fadeIn(1500).show();
                            getBrand();
                        })
                        $("#btn_update_brand").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Updating Brand..");
                    }else{
                        $("#umsg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                    }
                }
            })
        }            
    })
    
//Delete Brand..
    $("body").delegate(".delete_brand","click",function(){
        var did = $(this).attr("did");
        if(confirm("Do you want to delete BRAND?")){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                method: "POST",
                data: {deleteBrand:1,id:did},
                success: function(data){
                    if(data == "Brand Deleted"){
                        $("#umsg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){
                            getBrand();
                        })
                    }else{
                        $("#umsg").html("<span class='alert alert-warning'>"+data+"</span>");
                    }
                }
            })
        }
    })
    
    









//Add Banner..
    $("#banner_form").on("submit", function () {
        var status = false;
        var banner_size = $("#banner_size").val();
        var banner_image = $("#customFile").val();

        if (banner_size === "0") {
            $(".banner_size").css("border-color", "#DD4B39");
            $(".banner_size_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Choose Size </span>");
            status = false;
        } else { status = true; }
        if (banner_image === "") {
            $(".banner_image").css("border-color", "#DD4B39");
            $(".banner_image_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Upload banner image </span>");
            status = false;
        } else { status = true; }

        if (status) {
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data == "Invalid Format!") {
                        $("#msg").html("<div class='alert alert-warning'>" + data + "</div>");
                        $(".banner_image").css("border-color", "#DD4B39");
                        $(".banner_image_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Invalid Format! </span>");
                    } else if (data == "Choose Banner Size") {
                        $("#msg").html("<div class='alert alert-info'>" + data + "</div>");
                        $(".banner_size").css("border-color", "#DD4B39");
                        $(".banner_size_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Choose Size! </span>");
                    } else if (data == "Banner Added!") {
                        $("#msg").html("<div class='alert alert-success'>" + data + "</div>").fadeToggle(2000, function () {
                            $("#banner_form").trigger("reset");
                            $("#banner_view").fadeIn(1500).show();
                            getBanner();
                        })
                        $("#btn_banner").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Adding Banner..");
                    } else {
                        $("#msg").html("<span class='alert alert-danger alert-block'>" + data + "</span>");
                        $("#banner_form").trigger("reset");
                    }
                }
            })
        }
    })

//View Banner..
    getBanner();
    function getBanner() {
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: { viewBanner: 1 },
            success: function (data) {
                $("#banner_view").html(data);
            }
        })
    }
    
    
    
    
    
    
    
    
    
    
    
    
//Add Catalogue..
    $("#catalogue_form").on("submit",function(){
        var status = false;
        var catalogue_name = $("#catalogue_name").val();
        var catalogue_image = $("#customFile").val();

        if(catalogue_name === ""){
            $(".catalogue_name").css("border-color","#DD4B39");
            $(".catalogue_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Catalogue name </span>");
            status = false;
        }else{ status = true; }
        if(catalogue_image === ""){
            $(".catalogue_image").css("border-color","#DD4B39");
            $(".catalogue_image_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Upload Catalogue logo </span>");
            status = false;
        }else{ status = true; }

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
                        $("#msg").html("<div class='alert alert-warning'>"+data+"</div>");
                        $(".catalogue_image").css("border-color","#DD4B39");
                        $(".catalogue_image_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Invalid Format! </span>");
                    }else if(data == "Catalogue already exists!"){
                        $("#msg").html("<div class='alert alert-info'>"+data+"</div>");
                        $(".catalogue_name").css("border-color","#DD4B39");
                        $(".catalogue_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Catalogue already exists! </span>");
                    }else if(data == "Catalogue Added!"){
                        $("#msg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){ 
                            $("#catalogue_form").trigger("reset");
                            $("#catalogue_view").fadeIn(1500).show();
                            getCatalogue();
                        })
                        $("#btn_catalogue").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Adding Catalogue..");
                    }else{
                        $("#msg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                        $("#catalogue_form").trigger("reset"); 
                    }
                }
            })
        }
    })
    
//Count Catalogues..
    countCatalogue();
    function countCatalogue(){
        $.ajax({
            url : "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method : "POST",
            data : {count_catalogue:1},
            success : function(data){
                $(".count_catalogue").html(data);
            }
        })
    }
    
//Catalogue for option..
    optionCatalogue();
    function optionCatalogue(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {fetchCatalogue:1},
            success: function(data){
                var root = "<option value='0'>Select Catalogue</option>";
                var choose = "<option value='0'>Choose Catalogue</option>";
                $(".catalogue_id").html(root+data);
                $(".update_catalogue_id").html(root+data);
            }
        })
    }
    
//View Catalogue..
    getCatalogue();
    function getCatalogue(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {viewCatalogue:1},
            success: function(data){
                $("#catalogue_view").html(data);
            }
        })
    }
    
//Show Catalogue Data In Form..
    $("body").delegate(".update_catalogue","click",function(){
        var uid = $(this).attr("uid");
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            dataType: "json",
            data: {updateCatalogue:1,id:uid},
            success: function(data){
                
                $("#update_catalogue_id").val(data['catalogue_id']);
                $("#udpate_catalogue_name").val(data['catalogue_name']);   
                $("#udpate_catalogue_image").val(data['catalogue_image']); 
            }
        })
    })
//Update Catalogue Data..
    $("#update_catalogue_form").on("submit",function(){
        var status = false;
        var update_catalogue_id = $("#update_catalogue_id").val();
        var update_catalogue_name = $("#update_catalogue_name").val();
        var update_catalogue_image = $("#update_catalogue_image").val();

        if(update_catalogue_name === ""){
            $(".update_catalogue_name").css("border-color","#DD4B39");
            $(".update_catalogue_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Catalogue Name </span>");
            status = false;
        }else{status = true;}

        if(update_catalogue_name !== "" && status === true){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    if(data=="Invalid File Format!"){
                        $(".update_catalogue_image").css("border-color","#DD4B39");
                        $(".update_catalogue_image_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Invalid File Format! </span>");
                    }else if(data == "Updated"){
                        $("#umsg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){ 
                            $("#update_catalogue").modal().fadeOut(1500).hide();
                            $("#catalogue_view").fadeIn(1500).show();
                            getCatalogue();
                        })
                        $("#btn_update_catalogue").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Updating Catalogue..");
                    }else{
                        $("#umsg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                    }
                }
            })
        }else if(update_catalogue_image.val() === "" && status === true){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                type: "POST",
                data: $("#update_catalogue_form").serialize(),
                success: function(data){
                    if(data == "Updated"){
                        $("#umsg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){ 
                            $("#update_catalogue").modal().fadeOut(1500).hide();
                            $("#catalogue_view").fadeIn(1500).show();
                            getCatalogue();
                        })
                        $("#btn_update_catalogue").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Updating Catalogue..");
                    }else{
                        $("#umsg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                    }
                }
            })
        }            
    })
    
//Delete Catalogue..
    $("body").delegate(".delete_catalogue","click",function(){
        var did = $(this).attr("did");
        if(confirm("Do you want to delete Catalogue?")){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                method: "POST",
                data: {deleteCatalogue:1,id:did},
                success: function(data){
                    if(data == "Catalogue Deleted"){
                        $("#umsg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){
                            getCatalogue();
                        })
                    }else{
                        $("#umsg").html("<span class='alert alert-warning'>"+data+"</span>");
                    }
                }
            })
        }
    })
    
    
    
    
    
    
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
//Add Category..
    $("#category_form").on("submit",function(){
        var status = false;
        var category_name = $("#category_name").val();

        if(category_name === ""){
            $(".category_name").css("border-color","#DD4B39");
            $(".category_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Category name </span>");
            status = false;
        }else{ status = true; }

        if(status){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                type: "POST",
                data: $("#category_form").serialize(),
                success: function(data){
                    if(data == "Category already exists!"){
                        $("#msg").html("<div class='alert alert-info'>"+data+"</div>");
                        $(".category_name").css("border-color","#DD4B39");
                        $(".category_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Category already exists! </span>");
                    }else if(data == "Category Added!"){
                        $("#btn_category").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Adding Category..");
                        $("#msg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){ 
                            $("#category_form").trigger("reset");
                            $("#category_view").fadeIn(1500).show();
                            getCategory();
                        })
                    }else{
                        $("#msg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                        $("#category_form").trigger("reset"); 
                    }
                }
            })
        }
    })
    
//Count Categories..
    countCategory();
    function countCategory(){
        $.ajax({
            url : "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method : "POST",
            data : {count_category:1},
            success : function(data){
                $(".count_category").html(data);
            }
        })
    }
    
//Categories for option..
    optionCategory();
    function optionCategory(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {fetchCategory:1},
            success: function(data){
                var root = "<option value='0'>Select Category</option>";
                var choose = "<option value='0'>Choose Category</option>";
                $("#category_id").html(root+data);
                $("#update_categor_id").html(root+data);
            }
        })
    }
    
//View Category..
    getCategory();
    function getCategory(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {viewCategory:1},
            success: function(data){
                $("#category_view").html(data);
            }
        })
    }  
    
//Show Category Data In Form..
    $("body").delegate(".update_catalogue","click",function(){
        var uid = $(this).attr("uid");
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            dataType: "json",
            data: {updateCatalogue:1,id:uid},
            success: function(data){
                $("#update_catalogue_id").val(data['catalogue_id']);
                $("#update_catalogue_name").val(data['catalogue_name']);
            }
        })
    })
//Update Category Data..
    $("#update_category_form").on("submit",function(){
        var status = false;
        var update_category_id = $("#update_category_id").val();
        var update_category_name = $("#update_category_name").val();

        if(update_category_name === ""){
            $(".update_category_name").css("border-color","#DD4B39");
            $(".update_category_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Category Name </span>");
            status = false;
        }else{status = true;}

        if(status){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                type: "POST",
                data: $("#update_category_form").serialize(),
                success: function(data){
                    if(data == "Updated"){
                        $("#umsg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){ 
                            $("#update_category").modal().fadeOut(1500).hide();
                            $("#category_view").fadeIn(1500).show();
                            getCategory();
                        })
                        $("#btn_update_category").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Updating Category..");
                    }else{
                        $("#umsg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                    }
                }
            })
        }            
    })
    
//Delete Category..
    $("body").delegate(".delete_category","click",function(){
        var did = $(this).attr("did");
        if(confirm("Do you want to delete Category?")){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                method: "POST",
                data: {deleteCategory:1,id:did},
                success: function(data){
                    if(data == "Category Deleted"){
                        $("#umsg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){
                            getCategory();
                        })
                    }else{
                        $("#umsg").html("<span class='alert alert-warning'>"+data+"</span>");
                    }
                }
            })
        }
    }) 
    
    
    
    
    
    
    
    
    
    
    
    
    
   
   
//Add Sub Category..
    $("#sub_category_form").on("submit",function(){
        var status = false;
        var sub_category_name = $("#sub_category_name").val();
        var category_id = $("#category_id").val();

        if(sub_category_name === ""){
            $(".sub_category_name").css("border-color","#DD4B39");
            $(".sub_category_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Sub Category name </span>");
            status = false;
        }else{ status = true; }
        
        if(category_id === "0"){
            $(".category_id").css("border-color","#DD4B39");
            $(".category_id_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Choose Category Name </span>");
            status = false;
        }else{status = true;}

        if(status){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                type: "POST",
                data: $("#sub_category_form").serialize(),
                success: function(data){
                    if(data == "Sub Category already exists!"){
                        $("#msg").html("<div class='alert alert-info'>"+data+"</div>");
                        $(".sub_category_name").css("border-color","#DD4B39");
                        $(".sub_category_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Sub Category already exists! </span>");
                    }else if(data == "Sub Category Added!"){
                        $("#btn_sub_category").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Adding Sub Category..");
                        $("#msg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){ 
                            $("#sub_category_form").trigger("reset");
                            $("#sub_category_view").fadeIn(1500).show();
                            getSubCategory();
                        })
                    }else{
                        $("#msg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                        $("#sub_category_form").trigger("reset"); 
                    }
                }
            })
        }
    })
    
//Count Sub Categories..
    countSubCategory();
    function countSubCategory(){
        $.ajax({
            url : "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method : "POST",
            data : {count_sub_category:1},
            success : function(data){
                $(".count_sub_category").html(data);
            }
        })
    }
    
//Sub Categories for option..
    optionSubCategory();
    function optionSubCategory(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {fetchSubCategory:1},
            success: function(data){
                var root = "<option value='0'>Select Sub Category</option>";
                var choose = "<option value='0'>Choose Sub Category</option>";
                $(".subcategory_id").html(root+data);
                $(".update_subcategory_id").html(root+data);
            }
        })
    }
    
//View Sub Category..
    getSubCategory();
    function getSubCategory(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {viewSubCategory:1},
            success: function(data){
                $("#sub_category_view").html(data);
            }
        })
    }  
    
//Show Sub Category Data In Form..
    $("body").delegate(".update_sub_category","click",function(){
        var uid = $(this).attr("uid");
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            dataType: "json",
            data: {updateSubCategory:1,id:uid},
            success: function(data){
                $("#update_sub_category_id").val(data['sub_category_id']);
                $("#udpate_sub_category_name").val(data['sub_category_name']);
                $("#update_category_id").val(data['category_id']);
            }
        })
    })
//Update Sub Category Data..
    $("#update_sub_category_form").on("submit",function(){
        var status = false;
        var update_sub_category_id = $("#update_sub_category_id").val();
        var update_category_name = $("#update_category_name").val();
        var update_category_id = $("#update_category_id").val();

        if(update_sub_category_name === ""){
            $(".update_sub_category_name").css("border-color","#DD4B39");
            $(".update_sub_category_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Sub Category Name </span>");
            status = false;
        }else{status = true;}
        
        if(update_category_id === "0"){
            $(".update_category_id").css("border-color","#DD4B39");
            $(".update_category_id_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Choose Category Name </span>");
            status = false;
        }else{status = true;}

        if(status){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                type: "POST",
                data: $("#update_sub_category_form").serialize(),
                success: function(data){
                    if(data == "Updated"){
                        $("#umsg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){ 
                            $("#update_sub_category").modal().fadeOut(1500).hide();
                            $("#sub_category_view").fadeIn(1500).show();
                            getSubCategory();
                        })
                        $("#btn_update_sub_category").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Updating Sub Category..");
                    }else{
                        $("#umsg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                    }
                }
            })
        }            
    })
    
//Delete Sub Category..
    $("body").delegate(".delete_sub_category","click",function(){
        var did = $(this).attr("did");
        if(confirm("Do you want to delete Sub Category?")){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                method: "POST",
                data: {deleteSubCategory:1,id:did},
                success: function(data){
                    if(data == "Sub Category Deleted"){
                        $("#umsg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){
                            getSubCategory();
                        })
                    }else{
                        $("#umsg").html("<span class='alert alert-warning'>"+data+"</span>");
                    }
                }
            })
        }
    })  
    
    
    
    
    
    
    
    
    
    
    
  
  
  
  
  
    
    
    
    
    
    
    
    
    
//Add Unit..
    $("#unit_form").on("submit",function(){
        var status = false;
        var unit_name = $("#unit_name").val();

        if(unit_name === ""){
            $(".unit_name").css("border-color","#DD4B39");
            $(".unit_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Unit name </span>");
            status = false;
        }else{ status = true; }

        if(status){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                type: "POST",
                data: $("#unit_form").serialize(),
                success: function(data){
                    if(data == "Unit already exists!"){
                        $("#msg").html("<div class='alert alert-info'>"+data+"</div>");
                        $(".unit_name").css("border-color","#DD4B39");
                        $(".unit_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Unit already exists! </span>");
                    }else if(data == "Unit Added!"){
                        $("#btn_unit").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Adding Unit..");
                        $("#msg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){ 
                            $("#unit_form").trigger("reset");
                            $("#unit_view").fadeIn(1500).show();
                            getUnit();
                        })
                    }else{
                        $("#msg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                        $("#unit_form").trigger("reset"); 
                    }
                }
            })
        }
    })
    
//Count Units..
    countUnit();
    function countUnit(){
        $.ajax({
            url : "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method : "POST",
            data : {count_unit:1},
            success : function(data){
                $(".count_unit").html(data);
            }
        })
    }
    
//Units for option..
    optionUnit();
    function optionUnit(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {fetchUnit:1},
            success: function(data){
                var root = "<option value='0'>Select Unit</option>";
                var choose = "<option value='0'>Choose Unit</option>";
                $(".product_unit").html(root+data);
                $(".update_product_unit").html(root+data);
            }
        })
    }
    
//View Unit..
    getUnit();
    function getUnit(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {viewUnit:1},
            success: function(data){
                $("#unit_view").html(data);
            }
        })
    }  
    
//Show Unit Data In Form..
    $("body").delegate(".update_unit","click",function(){
        var uid = $(this).attr("uid");
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            dataType: "json",
            data: {updateUnit:1,id:uid},
            success: function(data){
                $("#update_unit_id").val(data['unit_id']);
                $("#update_unit_name").val(data['unit_name']);
            }
        })
    })
//Update Unit Data..
    $("#update_unit_form").on("submit",function(){
        var status = false;
        var update_unit_id = $("#update_unit_id");
        var update_unit_name = $("#update_unit_name");

        if(update_unit_name.val() === ""){
            $(".update_unit_name").css("border-color","#DD4B39");
            $(".update_unit_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Unit Name </span>");
            status = false;
        }else{status = true;}

        if(status){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                type: "POST",
                data: $("#update_unit_form").serialize(),
                success: function(data){
                    if(data == "Updated"){
                        $("#umsg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){ 
                            $("#update_unit").modal().fadeOut(1500).hide();
                            $("#unit_view").fadeIn(1500).show();
                            getUnit();
                        })
                        $("#btn_update_unit").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Updating Unit..");
                      			window.location.href='https://nidrip.mraalionline.com/cms/admin/add-unit/?aut#';
                    }else{
                        $("#umsg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                    }
                }
            })
        }            
    })
    
//Delete Unit..
    $("body").delegate(".delete_unit","click",function(){
        var did = $(this).attr("did");
        if(confirm("Do you want to delete Unit?")){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                method: "POST",
                data: {deleteUnit:1,id:did},
                success: function(data){
                    if(data == "Unit Deleted"){
                        $("#umsg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){
                            getUnit();
                        })
                    }else{
                        $("#umsg").html("<span class='alert alert-warning'>"+data+"</span>");
                    }
                }
            })
        }
    }) 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
//Add Products..
    $("#product_form").on("submit",function(){
        var status = false;
        var product_name = $("#product_name").val();
        var category_id = $("#category_id").val();
        //var brand_id = $("#brand_id").val();
        var unit_id = $("#unit_id").val();
        var product_price = $("#product_price").val();
        //var product_type = $("#product_type").val();
        var product_old_price = $("#product_old_price").val();
        var product_discount = $("#product_discount").val();
        var product_keywords = $("#product_keywords").val();
        //var product_download = $("#product_download").val();

        if(product_name === ""){
            $(".product_name").css("border-color","#DD4B39");
            $(".product_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Product Name </span>");
            status = false;
        }else{status = true;}
        
        if(category_id === "0"){
            $(".category_id").css("border-color","#DD4B39");
            $(".category_id_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Select Category </span>");
            status = false;
        }else{status = true;}
      
        //if(product_type === "0"){
            //$(".product_type").css("border-color","#DD4B39");
            //$(".product_type_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Select Product Type </span>");
            //status = false;
        //}else{status = true;}
        
        //if(brand_id === "0"){
            //$(".brand_id").css("border-color","#DD4B39");
            //$(".brand_id_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Select Brand </span>");
            //status = false;
        //}else{status = true;}
        
        if(unit_id === "0"){
            $(".unit_id").css("border-color","#DD4B39");
            $(".unit_id_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Select Unit </span>");
            status = false;
        }else{status = true;}
            
        if(product_price === ""){
            $(".product_price").css("border-color","#DD4B39");
            $(".product_price_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Price </span>");
            status = false;
        }else{status = true;}
        
        if(product_old_price === ""){
            $(".product_old_price").css("border-color","#DD4B39");
            $(".product_old_price_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Old Price </span>");
            status = false;
        }else{status = true;}
        
        if(product_discount === ""){
            $(".product_discount").css("border-color","#DD4B39");
            $(".product_discount_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Product Discount </span>");
            status = false;
        }else{status = true;}
        
        if(product_keywords === ""){
            $(".product_keywords").css("border-color","#DD4B39");
            $(".product_keywords_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Product Keywords </span>");
            status = false;
        }else{status = true;}
      
        //if(product_download === ""){
            //$(".product_download").css("border-color","#DD4B39");
            //$(".product_download_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Product Download URL </span>");
            //status = false;
        //}else{status = true;}

        if(status){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    if(data == "Invalid Format!"){
                        $(".product_image").css("border-color","#DD4B39");
                        $(".product_image_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Image Invalid Format! </span>");
                        //$(".product_video").css("border-color","#DD4B39");
                        //$(".product_video_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Video Invalid Format! </span>");
                    }else if(data == "Product Added!"){
                        $("#btn_product").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Adding Product..");
                        $("#msg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){ 
                            setTimeout('window.location.href = "https://nidrip.mraalionline.com/cms/admin/view-product/?vp#";',2000);
                        })
                    }else if(data == "Product already exists!"){
                        $(".product_name").css("border-color","#DD4B39");
                        $(".product_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Product already exists! </span>");
                    }else if(data == "Something went wrong!"){
                        $("#msg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                        $("#product_form").trigger("reset");
                    }
                }

            })
        }
    }) 
    
//Count Products..
    countProduct();
    function countProduct(){
        $.ajax({
            url : "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method : "POST",
            data : {count_product:1},
            success : function(data){
                $(".count_product").html(data);
            }
        })
    }
    
//product for option..
    optionProduct();
    function optionProduct(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {fetchProduct:1},
            success: function(data){
                var root = "<option value='0'>Select Product</option>";
                var choose = "<option value='0'>Choose Product</option>";
                $("#product_id").html(root+data);
                $("#update_product_id").html(root+data);
            }
        })
    }
//Show Product Data In Form..
    $("body").delegate(".update_product","click",function(){
        var uid = $(this).attr("uid");
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            dataType: "json",
            data: {updateProduct:1,id:uid},
            success: function(data){
                $("#update_product_id").val(data['product_id']);
                $("#update_product_name").val(data['product_name']);   
                $("#update_catalogue_id").val(data['catalogue_id']);   
                $("#update_unit_id").val(data['unit_id']);   
                $("#update_product_old_price").val(data['product_old_price']);   
                $("#update_product_price").val(data['product_price']);   
                $("#update_product_discount").val(data['product_discount']);
                $("#update_product_keywords").val(data['product_keywords']); 
                $("#update_product_download").val(data['product_download']); 
                $("#update_product_desc").val(data['product_desc']); 
            }
        })
    })

//View Prpduct..
    getProduct();
    function getProduct(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {viewProduct:1},
            success: function(data){
                $("#product_view").html(data);
            }
        })
    }
  //Update product..
    $("#update_product_form").on("submit",function(){
        var status = false;
        var update_product_id = $("#update_product_id");
        var update_product_name = $("#update_product_name");
        var update_product_price = $("#update_product_price");
        var update_product_discount = $("#update_product_discount");
        var product_image = $("#update_product_image");
        var product_old_price = $("#update_product_old_price");
        var catalogue_id = $("#update_catalogue_id");
        var unit_id = $("#update_unit_id");
        var product_keywords = $("#update_product_keywords");
        var product_desc = $("#update_product_desc");

        if(update_product_name.val() == ""){
            $("#update_product_name").css("border-color","#DD4B39");
            $("#update_product_name").css("background-color","#F5B7B1");
            $(".fa-tag").css("color","#DD4B39");
            $("#update_product_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Brand Name </span>");
            status = false;
        }else{
            $("#update_product_name_error").html("");
            status = true;
        }
        if(update_product_price.val() == ""){
            $("#update_product_price").css("border-color","#DD4B39");
            $("#update_product_price").css("background-color","#F5B7B1");
            $(".fa-tag").css("color","#DD4B39");
            $("#update_product_price_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Brand Name </span>");
            status = false;
        }else{
            $("#update_product_price_error").html("");
            status = true;
        }
        if(update_product_discount.val() == ""){
            $("#update_product_discount").css("border-color","#DD4B39");
            $("#update_product_discount").css("background-color","#F5B7B1");
            $(".fa-tag").css("color","#DD4B39");
            $("#update_product_discount_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Enter Brand Name </span>");
            status = false;
        }else{
            $("#update_product_discount_error").html("");
            status = true;
        }
        if(status){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php", 
                type: "POST",
                data: $("#update_product_form").serialize(),
                success: function(data){
                    if(data == "Updated"){
                        $("#umsg").html("<span class='alert alert-success alert-block'>"+data+"</span>");
                        $("#btn_update_product").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Updating..");
                        setTimeout('window.location.href = "https://nidrip.mraalionline.com/cms/admin/view-product/?vp#";',2000);
                    }else{
                        $("#umsg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                    }
                }
            })
        }            
    }) 
    
//Delete Product..
    $("body").delegate(".delete_product","click",function(){
        var did = $(this).attr("did");
        if(confirm("Do you want to delete Product?")){
            $.ajax({
                url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
                method: "POST",
                data: {deleteProduct:1,id:did},
                success: function(data){
                    if(data == "Product Deleted"){
                        $("#umsg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){
                            getProduct();
                        })
                    }else{
                        $("#umsg").html("<span class='alert alert-warning'>"+data+"</span>");
                    }
                }
            })
        }
    }) 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
//Add Product Image..
    $("#image_form").on("submit",function(){
        var status = false;
        var product_name = $("#product_id").val();
        var product_image = $(".product_image").val();

        if(product_name === "0"){
            $(".product_name").css("border-color","#DD4B39");
            $(".product_name_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Select product name </span>");
            status = false;
        }else{ status = true; }

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
                        $("#msg").html("<div class='alert alert-warning'>"+data+"</div>");
                        $(".product_image").css("border-color","#DD4B39");
                        $(".product_image_error").html("<span class='text-danger' style='color: #DD4B39; font-size: 1.3em;'>Invalid Format! </span>");
                    }else if(data == "Image Added!"){
                        $("#msg").html("<div class='alert alert-success'>"+data+"</div>").fadeToggle(2000,function(){ 
                            $("#image_form").trigger("reset");
                            $("#image_view").fadeIn(1500).show();
                            getImage();
                        })
                        $("#btn_image").html("<img src='https://nidrip.mraalionline.com/cms/assets/images/loader.gif' width='20'/> &nbsp; Adding Image..");
                    }else{
                        $("#msg").html("<span class='alert alert-danger alert-block'>"+data+"</span>");
                        $("#image_form").trigger("reset"); 
                    }
                }
            })
        }
    })
    
    
//View Image..
    getImage();
    function getImage(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {viewProductImage:1},
            success: function(data){
                $("#image_view").html(data);
            }
        })
    }     
    
    
    
    
    
    
    
//Count Orders Cart..
    countOrderCart();
    function countOrderCart(){
        $.ajax({
            url : "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method : "POST",
            data : {count_order_cart:1},
            success : function(data){
                $(".order_cart").html(data);
            }
        })
    }  
//Count Orders Processed..
    countOrderProcessed();
    function countOrderProcessed(){
        $.ajax({
            url : "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method : "POST",
            data : {count_order_processed:1},
            success : function(data){
                $(".orders_processed").html(data);
            }
        })
    }  
  
//Count Orders Processing..
    countOrderProcessing();
    function countOrderProcessing(){
        $.ajax({
            url : "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method : "POST",
            data : {count_order_processing:1},
            success : function(data){
                $(".orders_processing").html(data);
            }
        })
    } 

    
    
    
    
    
//View Product Cart..
    getOrderCart();
    function getOrderCart(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {view_cart:1},
            success: function(data){
                $(".view_order_cart").html(data);
            }
        })
    }  
    
//View Product Order_processing..
    getOrderProcesing();
    function getOrderProcesing(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {view_order_processing:1},
            success: function(data){
                $(".view_order_processing").html(data);
            }
        })
    }     
    
//View Product Order_processing..
    getOrderProcesed();
    function getOrderProcesed(){
        $.ajax({
            url: "https://nidrip.mraalionline.com/cms/functions/PHP/process.php",
            method: "POST",
            data: {view_order_processed:1},
            success: function(data){
                $(".view_order_processed").html(data);
            }
        })
    }    
    
    
    
    
    
    
    
    
    
})