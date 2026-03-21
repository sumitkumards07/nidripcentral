<?php include("config/defines.php"); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Login | <?php echo $company_name ?></title>
        <?php include($AaliLINK_IN."/functions/HTML/login-css.php"); ?>
    </head>
    
    <body>
<div id="app">
            <?php include($AaliLINK_IN."/functions/HTML/login.php"); ?>
        </div>
        <?php include($AaliLINK_IN."/functions/HTML/login-js.php"); ?>
    </body>
</html>

