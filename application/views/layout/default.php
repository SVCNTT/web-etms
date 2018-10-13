<!DOCTYPE html>
<html <?php echo $html_attr;?>>
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

    <title><?php echo isset($title_for_layout) ? $title_for_layout : 'Strikeforce';?></title>

    <!--Bootstrap material - Begin-->
    <link href="<?php echo STATIC_SERVER; ?>/lib/bootstrap_material/css/roboto.min.css" rel="stylesheet">
    <link href="<?php echo STATIC_SERVER; ?>/lib/bootstrap_material/css/material.min.css" rel="stylesheet">
    <link href="<?php echo STATIC_SERVER; ?>/lib/bootstrap_material/css/ripples.min.css" rel="stylesheet">
    <!--Bootstrap material - End-->

    <link href="<?php echo STATIC_SERVER; ?>/lib/jquery-ui-1.11.0/jquery-ui.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/bootstrap-3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo STATIC_SERVER; ?>/lib/bootstrap-3.3.4/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/chosen-1.1.0/chosen.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/angularJS-toaster-master/toaster.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/ui-calendar-master/src/fullcalendar.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/lightbox/css/lightbox.min.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/lib/slidebox-master/css/slidebox.css" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/css/dms-style.css?v=<?php echo STATIC_VERSION;?>" rel="stylesheet" media="screen">

    <link href="<?php echo STATIC_SERVER; ?>/css/custom.css?v=<?php echo STATIC_VERSION;?>" rel="stylesheet" media="screen">

    <script type="text/javascript">
        var getContextPath = function () {
            return '';
        };
        var getContextPathImageDefault = function () {
            return "<?php echo STATIC_SERVER; ?>";
        };
    </script>
    <!--[if lt IE 9]>
    <script src="<?php echo STATIC_SERVER;?>/lib/html5shiv-3.7.2/html5shiv.min.js"></script>

    <script src="<?php echo STATIC_SERVER;?>/lib/respond-1.4.2/respond.min.js"></script>
    <![endif]-->


    <script src="<?php echo STATIC_SERVER; ?>/lib/jquery-1.11.1/jquery.min.js"></script>

    <script src="<?php echo STATIC_SERVER; ?>/lib/jquery-ui-1.11.0/jquery-ui.min.js"></script>

    <script src="<?php echo STATIC_SERVER; ?>/lib/bootstrap-3.3.4/js/bootstrap.min.js"></script>

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
    <script src="<?php echo STATIC_SERVER; ?>/lib/bootstrap-3.3.4/js/bootstrap-datetimepicker.min.js"></script>


    <script src="<?php echo STATIC_SERVER; ?>/lib/slidebox-master/js/slidebox.js"></script>


    <script src="<?php echo STATIC_SERVER; ?>/js/common.js?v=<?php echo STATIC_VERSION;?>"></script>
    <script src="<?php echo STATIC_SERVER; ?>/js/dashboard.js?v=<?php echo STATIC_VERSION;?>"></script>
    <script src="<?php echo STATIC_SERVER; ?>/js/client.js?v=<?php echo STATIC_VERSION;?>"></script>
    <script src="<?php echo STATIC_SERVER; ?>/js/product.js?v=<?php echo STATIC_VERSION;?>"></script>
    <script src="<?php echo STATIC_SERVER; ?>/js/store.js?v=<?php echo STATIC_VERSION;?>"></script>
    <script src="<?php echo STATIC_SERVER; ?>/js/inventory.js?v=<?php echo STATIC_VERSION;?>"></script>
    <script src="<?php echo STATIC_SERVER; ?>/js/doctor.js?v=<?php echo STATIC_VERSION;?>"></script>
    <script src="<?php echo STATIC_SERVER; ?>/js/saleman.js?v=<?php echo STATIC_VERSION;?>"></script>
    <script src="<?php echo STATIC_SERVER; ?>/js/coaching.js?v=<?php echo STATIC_VERSION;?>"></script>
    <script src="<?php echo STATIC_SERVER; ?>/js/checklist.js?v=<?php echo STATIC_VERSION;?>"></script>
    <script src="<?php echo STATIC_SERVER; ?>/js/kpi.js?v=<?php echo STATIC_VERSION;?>"></script>
    <script src="<?php echo STATIC_SERVER; ?>/js/user.js?v=<?php echo STATIC_VERSION;?>"></script>
    <script src="<?php echo STATIC_SERVER; ?>/js/call_record.js?v=<?php echo STATIC_VERSION;?>"></script>

    <script src="<?php echo STATIC_SERVER; ?>/js/dms-0.1.js?v=<?php echo STATIC_VERSION;?>"></script>

    <script src="<?php echo STATIC_SERVER; ?>/lib/highcharts.js?v=<?php echo STATIC_VERSION;?>"></script>
    <script src="<?php echo STATIC_SERVER; ?>/lib/highcharts-ng.js?v=<?php echo STATIC_VERSION;?>"></script>

</head>
<body <?php echo $body_attr;?>>
    <toaster-container toaster-options="{'time-out': 5000, 'close-button':true,'position-class':'toast-top-right', 'progressBar': true}"></toaster-container>
    <span class ="ng-hide" us-spinner="{radius:30, width:8, length: 16}">
        <div id="processingIcon"><img src="<?php echo STATIC_SERVER; ?>/img/loading.gif" alt="loading"> Processing...</div>
        <div id="processingBackground" style=""></div>
    </span>

    <div class="wrapper">
        <?php echo $header_html;?>

        <!--Content - Begin-->
        <?php echo $content_for_layout?>
        <!--Content - End-->

        <div ng-if="$parent.model.hidden.monthlyReport == true" ng-include="'/MRPT0200'"  ng-controller="MRPT0200Ctrl" ng-init="init()" > </div>

        <div ng-if="$parent.model.hidden.changePassword == true" ng-include="'/AUT0200'"  ng-controller="AUT0200Ctrl" ng-init="init()" > </div>

        <?php //echo $footer_html;?>
    </div>
</body>

<script src="<?php echo STATIC_SERVER; ?>/lib/bootstrap_material/js/ripples.min.js"></script>
<script src="<?php echo STATIC_SERVER; ?>/lib/bootstrap_material/js/material.min.js"></script>
<script>
    $(document).ready(function() {
        // This command is used to initialize some elements and make them work properly
        $.material.init();
    });
</script>

</html>
