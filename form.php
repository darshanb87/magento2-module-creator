<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Module Creator - Magento2</title>
        <link type="text/css" rel="stylesheet" href="main.css" />
        <script src="js/jquery.js"></script>
        <script src="js/jquery.validate.js"></script>
        <script type="text/javascript" language="javascript">
            $().ready(function() {
                // validate signup form on keyup and submit
                $("#newmodule").validate({
                    rules: {
                        namespace: "required",
                        module: "required"
                    },
                    messages: {
                        namespace: "Please enter Namespace",
                        module: "Please enter Module"
                    }
                });
            });
        </script>
    </head>
<?php 
$form = '<form name="newmodule" id="newmodule" class="cmxform" method="POST" action="" />
                    <div class="first">Namespace Name:</div> <input type="text" name="namespace" value="'.$ns.'" class="name"><br/><br/>
                    <div class="second">Module Name:</div> <input type="text" name="module" value="'.$mod.'" class="module"><br/>
                    <div class="button"><input type="submit" value="Create" name="create" id="create" class="submit"></div><br/><br/>
                </form>';
?>
    <body>
        <div class="wrapper">
            <div class="container">
                <!--<div class="logo"><img src="images/logo.jpg"></div>-->
                <div class="header"><h1>Module Creator - Magento 2</h1></div>
				<div class="messagestyle">
                <?php echo $message; ?>
                </div>
                <div class="form">
                    <?php echo $form; ?>
                </div>
            </div>
        </div>
    </body>
</html>
