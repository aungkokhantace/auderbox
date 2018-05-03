<?php
$user_info = \App\Core\Check::getInfo();
$companyName = \App\Core\Check::companyName();
$companyLogo = \App\Core\Check::companyLogo();
?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8">
<![endif]-->
<!--[if !IE]><!-->
<html lang="en"  ng-app="aceplusApp">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />

    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <title>{{$companyName}} - @yield('title')</title>

    <link href="/assets/css/AdminLTE.css" rel="stylesheet">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/js/datepicker/datepicker3.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/fullcalendar.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/sweetalert.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/multiple-select.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/jktCuteDropdown.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/style.css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/animate.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/style.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/style-custom.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/plugin-prism.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/style-responsive.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/theme/default.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/ionicons/css/ionicons.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/DataTables/css/data-table.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/gritter/css/jquery.gritter.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/footable/footable.core.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/footable/footable.metro.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/switchery/switchery.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/powerange/powerange.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/jasny/css/jasny-bootstrap.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/custom.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/style-edit-navbar.css">

    {{--For summernote editor--}}
    <link rel="stylesheet" href="/assets/plugins/summernote/summernote.css" type="text/css" media="all" />

    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/apps.min.js"></script>
    <script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
    <script src="/assets/js/search.js"></script>
    <script src="/assets/js/jquery-2.1.3.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    {{--<script src="/assets/plugins/pace/pace.min.js"></script>--}}
    <script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
    <script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
    <script src="/assets/plugins/DataTables/js/jquery.dataTables.js"></script>
    <script src="/assets/plugins/DataTables/js/dataTables.tableTools.js"></script>
    <script src="/assets/plugins/DataTables/js/dataTables.fixedHeader.js"></script>
    <script src="/assets/js/table-manage-tabletools.demo.min.js"></script>
    <script src="/assets/plugins/gritter/js/jquery.gritter.js"></script>
    <script src="/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/assets/plugins/jasny/js/jasny-bootstrap.js"></script>
    <script src="/assets/plugins/footable/footable.all.min.js"></script>
    <script src="/assets/plugins/switchery/switchery.min.js"></script>
    <script src="/assets/plugins/switchery/switchery_function.js"></script>

    {{--For summernote editor--}}
    <script src="/assets/plugins/summernote/summernote.min.js"></script>

    <script>
        $(document).ready(function() {
            App.init();
            TableManageTableTools.init();
        });
    </script>

</head>

<body>

<!-- begin #page-container -->
<div id="page-container" class="page-sidebar-fixed page-header-fixed">

    <!-- begin #header -->
    <div id="header" class="header navbar navbar-default navbar-fixed-top">
        <!-- begin container-fluid -->
        <div class="container-fluid">
            <!-- begin mobile sidebar expand / collapse button -->
            <div class="navbar-header center">
                <a href="#" class="navbar-brand overflow-hidden"><img src="{{$companyLogo}}" class="pull-left height-full m-r-5">{{$companyName}}</a>
                <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- end mobile sidebar expand / collapse button -->

            <!-- begin header navigation right -->
            <ul class="nav navbar-nav navbar-right center">

                <li class="dropdown navbar-user">
                    <a href="javascript:;" class="dropdown" data-toggle="dropdown">
                        <img src="/images/user_logo.png" alt="" />
                        <p style="color:#ff996"></p>
                    </a>
                    <ul class="dropdown-menu animated fadeInLeft">
                        <li class="arrow"></li>
                        <li nav-id="profile-edit"><a href="/backend/user/profile/{{isset($user_info['userId']) ? $user_info['userId'] : '' }}">Edit Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="/backend/logout">Log Out</a></li>
                    </ul>
                </li>
            </ul>
            <!-- end header navigation right -->
        </div>
        <!-- end container-fluid -->
    </div>