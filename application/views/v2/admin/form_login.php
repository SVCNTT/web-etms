<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo STATIC_SERVER; ?>/img/favicon.ico">

    <title><?php echo AUT0100_TITLE;?></title>
    <link href="<?php echo STATIC_SERVER; ?>/css/font_Open_Sans_googleapis" rel="stylesheet" type="text/css">
    <link href="<?php echo STATIC_SERVER; ?>/css/font_Raleway_googleapis" rel="stylesheet" type="text/css">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo STATIC_SERVER; ?>/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo STATIC_SERVER; ?>/fonts/font-awesome-4/css/font-awesome.min.css">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_SERVER; ?>/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_SERVER; ?>/css/csm_style.css" rel="stylesheet" />
</head>

<body class="texture">
<div id="cl-wrapper" class="login-container">

    <div class="middle-login">
        <div class="block-flat">
            <div class="header">
                <h3 class="text-center">
                    <i class="fa fa-lock"></i> <?php echo AUT0100_FORM_TITLE;?>
                </h3>
            </div>
            <div>
                <form action="<?php echo site_url('login');?>" method="post" class="form-signin form-horizontal" role="form" id="loginForm" style="margin-bottom: 0px !important;">
                    <div class="content">
<!--                        <h4 class="title">Login Access</h4>-->
                        <div style="color:red;text-align:center;"><?php echo isset($message) ? $message : '';?></div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" placeholder="<?php echo AUT0100_LABEL_USERNAME;?>" id="username" name="username" value="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="password" placeholder="<?php echo AUT0100_LABEL_PASSWORD;?>" id="password" name="password" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="foot">
                        <button class="btn btn-primary" data-dismiss="modal" type="submit"><i class="fa fa-sign-in"></i> <?php echo AUT0100_BUTTON_LOGIN;?></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center out-links"><a href="#">&copy; 2015</a></div>
    </div>
</div>

<script src="<?php echo STATIC_SERVER; ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/behaviour/general.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#username").focus();
    });
</script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/behaviour/voice-commands.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/jquery.flot/jquery.flot.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/jquery.flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/jquery.flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/jquery.flot/jquery.flot.labels.js"></script>
</body>
</html>
