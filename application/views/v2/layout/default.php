<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo STATIC_SERVER; ?>/img/favicon.ico">

    <title><?php echo isset($title_for_layout) ? $title_for_layout : 'Strikeforce';?></title>
    <link href="<?php echo STATIC_SERVER; ?>/css/font_Open_Sans_googleapis.css" rel="stylesheet" type="text/css">
    <link href="<?php echo STATIC_SERVER; ?>/css/font_Raleway_googleapis.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_SERVER; ?>/js/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_SERVER; ?>/js/jquery.gritter/css/jquery.gritter.css" />

    <link rel="stylesheet" href="<?php echo STATIC_SERVER; ?>/fonts/font-awesome-4/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="../../assets/js/html5shiv.js"></script>
    <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_SERVER; ?>/js/jquery.nanoscroller/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_SERVER; ?>/js/jquery.easypiechart/jquery.easy-pie-chart.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_SERVER; ?>/js/bootstrap.switch/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_SERVER; ?>/js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_SERVER; ?>/js/jquery.select2/select2.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_SERVER; ?>/js/bootstrap.slider/css/slider.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_SERVER; ?>/js/jquery.datatables/bootstrap-adapter/css/datatables.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_SERVER; ?>/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_SERVER; ?>/css/csm_style.css" rel="stylesheet" />

    <script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/jquery.js"></script>

    <!--Lib JS-->
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


<!--    <script src="--><?php //echo STATIC_SERVER; ?><!--/lib/jquery-1.11.1/jquery.min.js"></script>-->

<!--    <script src="--><?php //echo STATIC_SERVER; ?><!--/lib/jquery-ui-1.11.0/jquery-ui.min.js"></script>-->

<!--    <script src="--><?php //echo STATIC_SERVER; ?><!--/lib/bootstrap-3.3.4/js/bootstrap.min.js"></script>-->

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

    <script src="<?php echo STATIC_SERVER; ?>/js/common.js"></script>
    <script src="<?php echo STATIC_SERVER; ?>/js/checklist.js"></script>
    <script src="<?php echo STATIC_SERVER; ?>/js/dashboard.js"></script>

    <script src="<?php echo STATIC_SERVER; ?>/js/dms-0.1.js?v=<?php echo STATIC_VERSION;?>"></script>

    <script src="<?php echo STATIC_SERVER; ?>/lib/highcharts.js"></script>
    <script src="<?php echo STATIC_SERVER; ?>/lib/highcharts-ng.js"></script>
    <!--Lig JS - END-->
</head>

<body <?php echo $body_attr;?>>

<!-- Fixed navbar -->
<div id="head-nav" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="fa fa-gear"></span>
            </button>
            <a class="navbar-brand" href="/"><img class="logo-company" src="<?php echo STATIC_SERVER;?>/img/<?php echo CLIENT_LOGO_DEFAULT;?>" /></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right user-nav">
                <li class="dropdown profile_menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img alt="Avatar" src="<?php echo STATIC_SERVER; ?>/images/avatar2.jpg" /><?php echo $profile['last_name'] .' '. $profile['first_name'];?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a ng-click="$parent.model.hidden.changePassword = true">Change password</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo site_url('Logout');?>">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!--/.nav-collapse -->
</div>

<div id="cl-wrapper">
    <div class="cl-sidebar">
        <div class="cl-toggle"><i class="fa fa-bars"></i></div>
        <div class="cl-navblock">
            <div class="menu-space">
                <div class="content">
                    <ul class="cl-vnavigation">
                        <?php echo $header_html;?>
                    </ul>
                </div>
            </div>
            <div class="text-right collapse-button" style="padding:7px 9px;">
                <!--<input type="text" class="form-control search" placeholder="Search..." />-->
                <button id="sidebar-collapse" class="btn btn-default" style=""><i style="color:#fff;" class="fa fa-angle-left"></i></button>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="pcont">

        <!--Content - Begin-->
        <?php echo $content_for_layout?>
        <!--Content - End-->

    </div>

</div>

<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/my_app.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/jquery.sparkline/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/jquery.easypiechart/jquery.easy-pie-chart.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/jquery.ui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/jquery.nestable/jquery.nestable.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/bootstrap.switch/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/jquery.select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/bootstrap.slider/js/bootstrap-slider.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/jquery.gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="<?php echo STATIC_SERVER; ?>/js/behaviour/general.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        //initialize the javascript
        App.init();
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