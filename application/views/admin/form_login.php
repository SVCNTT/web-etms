<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        @charset "UTF-8";
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak, .ng-hide:not(.ng-animate) {
            display: none !important;
        }

        ng\:form {
            display: block;
        }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html;charset=Utf-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?php echo STATIC_SERVER; ?>/img/favicon.ico">

    <title><?php echo AUT0100_TITLE;?></title>


    <link href="<?php echo STATIC_SERVER; ?>/lib/jquery-ui-1.11.0/jquery-ui.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/bootstrap-3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/chosen-1.1.0/chosen.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/angularJS-toaster-master/toaster.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/ui-calendar-master/src/fullcalendar.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/lightbox/css/lightbox.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/slidebox-master/css/slidebox.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/css/dms-style.css" rel="stylesheet" media="screen">

    <script type="text/javascript">
        var getContextPath = function () {
            return '';
        };
    </script>
    <!--[if lt IE 9]>
    <script src="<?php echo STATIC_SERVER;?>/lib/html5shiv-3.7.2/html5shiv.min.js"></script>

    <script src="<?php echo STATIC_SERVER;?>/lib/respond-1.4.2/respond.min.js"></script>
    <![endif]-->


    <script src="<?php echo STATIC_SERVER; ?>/lib/jquery-1.11.1/jquery.min.js"></script>

    <script src="<?php echo STATIC_SERVER; ?>/lib/jquery-ui-1.11.0/jquery-ui.min.js"></script>

    <script src="<?php echo STATIC_SERVER; ?>/lib/bootstrap-3.2.0/js/bootstrap.min.js"></script>

    <script src="<?php echo STATIC_SERVER; ?>/lib/angular-1.3.0/angular.min.js"></script>

    <script src="<?php echo STATIC_SERVER; ?>/lib/angular-1.3.0/angular-animate.min.js"></script>

    <script src="<?php echo STATIC_SERVER; ?>/lib/angular-1.3.0/angular-route.min.js"></script>

    <script src="<?php echo STATIC_SERVER; ?>/lib/angular-1.3.0/once.js"></script>

    <script src="<?php echo STATIC_SERVER; ?>/lib/screenfull-1.2.0/screenfull.min.js"></script>

    <script src="<?php echo STATIC_SERVER; ?>/lib/chosen-1.1.0/chosen.jquery.min.js"></script>

    <script src="<?php echo STATIC_SERVER; ?>/lib/ckeditor-4.4.4/ckeditor.js"></script>
    <style>
        .cke {
            visibility: hidden;
        }
    </style>


    <script src="<?php echo STATIC_SERVER; ?>/lib/angular-fcsa-number-master/src/fcsaNumber.min.js"></script>


    <script src="<?php echo STATIC_SERVER; ?>/lib/angularJS-toaster-master/toaster.js"></script>


    <script src="<?php echo STATIC_SERVER; ?>/lib/ui-calendar-master/src/moment.min.js"></script>


    <script src="<?php echo STATIC_SERVER; ?>/lib/ui-calendar-master/src/calendar.js"></script>


    <script src="<?php echo STATIC_SERVER; ?>/lib/ui-calendar-master/src/fullcalendar.js"></script>


    <script src="<?php echo STATIC_SERVER; ?>/lib/ui-calendar-master/src/gcal.js"></script>


    <script src="<?php echo STATIC_SERVER; ?>/lib/angular-google-maps/lodash.min.js"></script>


    <script src="<?php echo STATIC_SERVER; ?>/lib/angular-google-maps/bluebird.js"></script>


    <script src="<?php echo STATIC_SERVER; ?>/lib/angular-google-maps/angular-google-maps.js"></script>


    <script src="<?php echo STATIC_SERVER; ?>/lib/lightbox/js/lightbox.js"></script>


    <script src="<?php echo STATIC_SERVER; ?>/lib/slidebox-master/js/slidebox.js"></script>


    <script src="<?php echo STATIC_SERVER; ?>/js/dms-0.1.js"></script>

</head>
<body class="AUT0100">

<!--login modal-->
<form action="<?php echo site_url('login');?>" method="post" class="form-signin" role="form" id="loginForm">

<div id="loginModal" class="modal show" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="text-center" style="color: #999">
                    <span style="color: #999; font-size: 30px;" class="icon-lock"></span>
                    <?php echo AUT0100_FORM_TITLE;?>
                </h1>
            </div>

            <?php if (isset($message) && !empty($message)) {?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span><span class="sr-only"></span>
                    </button>
                    <?php echo $message;?>
                </div>
            <?php }?>

            <div class="modal-body">

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon icon-user" title="<?php echo AUT0100_LABEL_USERNAME;?>"></div>
                        <input type="text" class="form-control"
                               placeholder="<?php echo AUT0100_LABEL_USERNAME;?>"
                               name='username' required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon icon-key" title="<?php echo AUT0100_LABEL_PASSWORD;?>"></div>
                        <input type="password" class="form-control"
                               placeholder="<?php echo AUT0100_LABEL_PASSWORD;?>"
                               name='password' required>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="form-group" style="margin-bottom: 0px;">
                    <button id="btnLogin" class="btn btn-primary btn-lg btn-block">
                        <span class="icon-login" > </span>
                        <?php echo AUT0100_BUTTON_LOGIN;?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<!--<div class="footer">-->
<!--    <div class="copyright">--><?php //echo COM0000_COPYRIGHT;?><!--</div>-->
<!--</div>-->


<script src="<?php echo STATIC_SERVER; ?>/lib/bootstrap_material/js/ripples.min.js"></script>
<script src="<?php echo STATIC_SERVER; ?>/lib/bootstrap_material/js/material.min.js"></script>

<script type="text/javascript">
    $(function(){
        Messages.clearMessage();
    })
</script>
<script>
    $(document).ready(function() {
        // This command is used to initialize some elements and make them work properly
        $.material.init();
    });
</script>

</body>
</html>