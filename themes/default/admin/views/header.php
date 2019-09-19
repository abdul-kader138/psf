<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <base href="<?= site_url() ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?> - <?= $Settings->site_name ?></title>
    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
    <link href="<?= $assets ?>styles/theme.css" rel="stylesheet"/>
    <link href="<?= $assets ?>styles/style.css" rel="stylesheet"/>
    <script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="<?= $assets ?>js/jquery-migrate-1.2.1.min.js"></script>
    <!--[if lt IE 9]>
    <script src="<?= $assets ?>js/jquery.js"></script>
    <![endif]-->
    <noscript>
        <style type="text/css">#loading {
                display: none;
            }</style>
    </noscript>
    <?php if ($Settings->user_rtl) { ?>
        <link href="<?= $assets ?>styles/helpers/bootstrap-rtl.min.css" rel="stylesheet"/>
        <link href="<?= $assets ?>styles/style-rtl.css" rel="stylesheet"/>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.pull-right, .pull-left').addClass('flip');
            });
        </script>
    <?php } ?>
    <script type="text/javascript">
        $(window).load(function () {
            $("#loading").fadeOut("slow");
        });
    </script>
</head>

<body>
<noscript>
    <div class="global-site-notice noscript">
        <div class="notice-inner">
            <p><strong>JavaScript seems to be disabled in your browser.</strong><br>You must have JavaScript enabled in
                your browser to utilize the functionality of this website.</p>
        </div>
    </div>
</noscript>
<div id="loading"></div>
<div id="app_wrapper">
    <header id="header" class="navbar">
        <div class="container">
            <a class="navbar-brand" href="<?= admin_url() ?>"><span class="logo"><?= $Settings->site_name ?></span></a>

            <div class="btn-group visible-xs pull-right btn-visible-sm">
                <button class="navbar-toggle btn" type="button" data-toggle="collapse" data-target="#sidebar_menu">
                    <span class="fa fa-bars"></span>
                </button>
                <?php if (SHOP) { ?>
                    <a href="<?= site_url('/') ?>" class="btn">
                        <span class="fa fa-shopping-cart"></span>
                    </a>
                <?php } ?>
                <a href="<?= admin_url('calendar') ?>" class="btn">
                    <span class="fa fa-calendar"></span>
                </a>
                <a href="<?= admin_url('users/profile/' . $this->session->userdata('user_id')); ?>" class="btn">
                    <span class="fa fa-user"></span>
                </a>
                <a href="<?= admin_url('logout'); ?>" class="btn">
                    <span class="fa fa-sign-out"></span>
                </a>
            </div>
            <div class="header-nav">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown">
                        <a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
                            <img alt=""
                                 src="<?= $this->session->userdata('avatar') ? base_url() . 'assets/uploads/avatars/thumbs/' . $this->session->userdata('avatar') : base_url('assets/images/' . $this->session->userdata('gender') . '.png'); ?>"
                                 class="mini_avatar img-rounded">

                            <div class="user">
                                <span><?= lang('welcome') ?> <?= $this->session->userdata('username'); ?></span>
                            </div>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="<?= admin_url('users/profile/' . $this->session->userdata('user_id')); ?>">
                                    <i class="fa fa-user"></i> <?= lang('profile'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?= admin_url('users/profile/' . $this->session->userdata('user_id') . '/#cpassword'); ?>"><i
                                            class="fa fa-key"></i> <?= lang('change_password'); ?>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?= admin_url('logout'); ?>">
                                    <i class="fa fa-sign-out"></i> <?= lang('logout'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown hidden-xs"><a class="btn tip" title="<?= lang('dashboard') ?>"
                                                      data-placement="bottom" href="<?= admin_url('welcome') ?>"><i
                                    class="fa fa-dashboard"></i></a></li>
                    <?php if ($Owner) { ?>
                        <li class="dropdown hidden-sm">
                            <a class="btn tip" title="<?= lang('settings') ?>" data-placement="bottom"
                               href="<?= admin_url('system_settings') ?>">
                                <i class="fa fa-cogs"></i>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="dropdown hidden-xs">
                        <a class="btn tip" title="<?= lang('calculator') ?>" data-placement="bottom" href="#"
                           data-toggle="dropdown">
                            <i class="fa fa-calculator"></i>
                        </a>

                        <ul class="dropdown-menu pull-right calc">
                            <li class="dropdown-content">
                                <span id="inlineCalc"></span>
                            </li>
                        </ul>
                    </li>
                    <?php if ($info) { ?>
                        <li class="dropdown hidden-sm">
                            <a class="btn tip" title="<?= lang('notifications') ?>" data-placement="bottom" href="#"
                               data-toggle="dropdown">
                                <i class="fa fa-info-circle"></i>
                                <span class="number blightOrange black"><?= sizeof($info) ?></span>
                            </a>
                            <ul class="dropdown-menu pull-right content-scroll">
                                <li class="dropdown-header"><i
                                            class="fa fa-info-circle"></i> <?= lang('notifications'); ?></li>
                                <li class="dropdown-content">
                                    <div class="scroll-div">
                                        <div class="top-menu-scroll">
                                            <ol class="oe">
                                                <?php foreach ($info as $n) {
                                                    echo '<li>' . $n->comment . '</li>';
                                                } ?>
                                            </ol>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if ($events) { ?>
                        <li class="dropdown hidden-xs">
                            <a class="btn tip" title="<?= lang('calendar') ?>" data-placement="bottom" href="#"
                               data-toggle="dropdown">
                                <i class="fa fa-calendar"></i>
                                <span class="number blightOrange black"><?= sizeof($events) ?></span>
                            </a>
                            <ul class="dropdown-menu pull-right content-scroll">
                                <li class="dropdown-header">
                                    <i class="fa fa-calendar"></i> <?= lang('upcoming_events'); ?>
                                </li>
                                <li class="dropdown-content">
                                    <div class="top-menu-scroll">
                                        <ol class="oe">
                                            <?php foreach ($events as $event) {
                                                echo '<li>' . date($dateFormats['php_ldate'], strtotime($event->start)) . ' <strong>' . $event->title . '</strong><br>' . $event->description . '</li>';
                                            } ?>
                                        </ol>
                                    </div>
                                </li>
                                <li class="dropdown-footer">
                                    <a href="<?= admin_url('calendar') ?>" class="btn-block link">
                                        <i class="fa fa-calendar"></i> <?= lang('calendar') ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="dropdown hidden-xs">
                            <a class="btn tip" title="<?= lang('calendar') ?>" data-placement="bottom"
                               href="<?= admin_url('calendar') ?>">
                                <i class="fa fa-calendar"></i>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="dropdown hidden-sm">
                        <a class="btn tip" title="<?= lang('styles') ?>" data-placement="bottom" data-toggle="dropdown"
                           href="#">
                            <i class="fa fa-css3"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li class="bwhite noPadding">
                                <a href="#" id="fixed" class="">
                                    <i class="fa fa-angle-double-left"></i>
                                    <span id="fixedText">Fixed</span>
                                </a>
                                <a href="#" id="cssLight" class="grey">
                                    <i class="fa fa-stop"></i> Grey
                                </a>
                                <a href="#" id="cssBlue" class="blue">
                                    <i class="fa fa-stop"></i> Blue
                                </a>
                                <a href="#" id="cssBlack" class="black">
                                    <i class="fa fa-stop"></i> Black
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container" id="container">
        <div class="row" id="main-con">
            <table class="lt">
                <tr>
                    <td class="sidebar-con">
                        <div id="sidebar-left">
                            <div class="sidebar-nav nav-collapse collapse navbar-collapse" id="sidebar_menu">
                                <ul class="nav main-menu">
                                    <li class="mm_welcome">
                                        <a href="<?= admin_url() ?>">
                                            <i class="fa fa-dashboard"></i>
                                            <span class="text"> <?= lang('dashboard'); ?></span>
                                        </a>
                                    </li>

                                    <?php
                                    if ($Owner || $Admin) {
                                        ?>

                                        <li class="mm_auth mm_customers mm_suppliers mm_billers">
                                            <a class="dropmenu" href="#">
                                                <i class="fa fa-users"></i>
                                                <span class="text"> <?= lang('people'); ?> </span>
                                                <span class="chevron closed"></span>
                                            </a>
                                            <ul>
                                                <?php if ($Owner) { ?>
                                                    <li id="auth_users">
                                                        <a class="submenu" href="<?= admin_url('users'); ?>">
                                                            <i class="fa fa-users"></i><span
                                                                    class="text"> <?= lang('list_users'); ?></span>
                                                        </a>
                                                    </li>
                                                    <li id="auth_create_user">
                                                        <a class="submenu"
                                                           href="<?= admin_url('users/create_user'); ?>">
                                                            <i class="fa fa-user-plus"></i><span
                                                                    class="text"> <?= lang('new_user'); ?></span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                        <li class="mm_notifications">
                                            <a class="submenu" href="<?= admin_url('notifications'); ?>">
                                                <i class="fa fa-info-circle"></i><span
                                                        class="text"> <?= lang('notifications'); ?></span>
                                            </a>
                                        </li>
                                        <li class="mm_calendar">
                                            <a class="submenu" href="<?= admin_url('calendar'); ?>">
                                                <i class="fa fa-calendar"></i><span
                                                        class="text"> <?= lang('calendar'); ?></span>
                                            </a>
                                        </li>

                                        <li class="mm_sales_target">
                                            <a class="dropmenu" href="#">
                                                <i class="fa fa-random"></i>
                                                <span class="text"> <?= lang('Sales_Target'); ?> </span>
                                                <span class="chevron closed"></span>
                                            </a>
                                            <ul>
                                                <li id="sales_target_zones">
                                                    <a class="submenu" href="<?= admin_url('sales_target/zones'); ?>">
                                                        <i class="fa fa-heart-o"></i>
                                                        <span class="text"> <?= lang('Zones_Target'); ?></span>
                                                    </a>
                                                </li>
                                                <li id="sales_target_zone_add">
                                                    <a class="submenu"
                                                       href="<?= admin_url('sales_target/zone_add'); ?>">
                                                        <i class="fa fa-plus-circle"></i>
                                                        <span class="text"> <?= lang('Add_Zone_Target'); ?></span>
                                                    </a>
                                                </li>
                                                <li id="sales_target_sales_officer">
                                                    <a class="submenu"
                                                       href="<?= admin_url('sales_target/sales_officer'); ?>">
                                                        <i class="fa fa-heart-o"></i>
                                                        <span class="text"> <?= lang('Sales_Officer_Target'); ?></span>
                                                    </a>
                                                </li>
                                                <li id="sales_target_sales_officer_add">
                                                    <a class="submenu"
                                                       href="<?= admin_url('sales_target/sales_officer_add'); ?>">
                                                        <i class="fa fa-plus-circle"></i>
                                                        <span class="text"> <?= lang('Add_Sales_Officer_Target'); ?></span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li class="mm_sales_achievement">
                                            <a class="dropmenu" href="#">
                                                <i class="fa fa-random"></i>
                                                <span class="text"> <?= lang('Sales_Achievement'); ?> </span>
                                                <span class="chevron closed"></span>
                                            </a>
                                            <ul>
                                                <li id="sales_achievement_sales_officer">
                                                    <a class="submenu"
                                                       href="<?= admin_url('sales_achievement/sales_officer'); ?>">
                                                        <i class="fa fa-heart-o"></i>
                                                        <span class="text"> <?= lang('Sales_Officer_Achievement'); ?></span>
                                                    </a>
                                                </li>
                                                <li id="sales_achievement_sales_officer_add">
                                                    <a class="submenu"
                                                       href="<?= admin_url('sales_achievement/sales_officer_add'); ?>">
                                                        <i class="fa fa-plus-circle"></i>
                                                        <span class="text"> <?= lang('Add_Sales__Achievement'); ?></span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>
                                        <?php if ($Owner) { ?>
                                            <li class="mm_system_settings <?= strtolower($this->router->fetch_method()) == 'sales' ? '' : 'mm_pos' ?>">
                                                <a class="dropmenu" href="#">
                                                    <i class="fa fa-cog"></i><span
                                                            class="text"> <?= lang('settings'); ?> </span>
                                                    <span class="chevron closed"></span>
                                                </a>
                                                <ul>
                                                    <li id="system_settings_index">
                                                        <a href="<?= admin_url('system_settings') ?>">
                                                            <i class="fa fa-cogs"></i><span
                                                                    class="text"> <?= lang('system_settings'); ?></span>
                                                        </a>
                                                    </li>
                                                    <li id="system_settings_change_logo">
                                                        <a href="<?= admin_url('system_settings/change_logo') ?>"
                                                           data-toggle="modal" data-target="#myModal">
                                                            <i class="fa fa-upload"></i><span
                                                                    class="text"> <?= lang('change_logo'); ?></span>
                                                        </a>
                                                    </li>
                                                    <li id="system_settings_currencies">
                                                        <a href="<?= admin_url('system_settings/currencies') ?>">
                                                            <i class="fa fa-money"></i><span
                                                                    class="text"> <?= lang('currencies'); ?></span>
                                                        </a>
                                                    </li>
                                                    <li id="system_settings_categories">
                                                        <a href="<?= admin_url('system_settings/categories') ?>">
                                                            <i class="fa fa-folder-open"></i><span
                                                                    class="text"> <?= lang('categories'); ?></span>
                                                        </a>
                                                    </li>

                                                    <li id="system_settings_zones">
                                                        <a href="<?= admin_url('system_settings/zones') ?>">
                                                            <i class="fa fa-folder-open"></i><span
                                                                    class="text"> <?= lang('Zones'); ?></span>
                                                        </a>
                                                    </li>

                                                    <li id="system_settings_sales_officer">
                                                        <a href="<?= admin_url('system_settings/sales_officer') ?>">
                                                            <i class="fa fa-folder-open"></i><span
                                                                    class="text"> <?= lang('Sales_Officer'); ?></span>
                                                        </a>
                                                    </li>

                                                    <li id="system_settings_units">
                                                        <a href="<?= admin_url('system_settings/units') ?>">
                                                            <i class="fa fa-wrench"></i><span
                                                                    class="text"> <?= lang('units'); ?></span>
                                                        </a>
                                                    </li>
                                                    <li id="system_settings_user_groups">
                                                        <a href="<?= admin_url('system_settings/user_groups') ?>">
                                                            <i class="fa fa-key"></i><span
                                                                    class="text"> <?= lang('group_permissions'); ?></span>
                                                        </a>
                                                    </li>
                                                    <li id="system_settings_backups">
                                                        <a href="<?= admin_url('system_settings/backups') ?>">
                                                            <i class="fa fa-database"></i><span
                                                                    class="text"> <?= lang('backups'); ?></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                        <li class="mm_reports">
                                            <a class="dropmenu" href="#">
                                                <i class="fa fa-bar-chart-o"></i>
                                                <span class="text"> <?= lang('reports'); ?> </span>
                                                <span class="chevron closed"></span>
                                            </a>
                                            <ul>
                                                <li id="reports_target_zone_wise">
                                                    <a href="<?= admin_url('reports/target_zone_wise') ?>">
                                                        <i class="fa fa-line-chart"></i><span
                                                                class="text"> <?= lang('Zone_Wise_Target_(Category)'); ?></span>
                                                    </a>
                                                </li>


                                                <li id="reports_target_zone">
                                                    <a href="<?= admin_url('reports/target_zone') ?>">
                                                        <i class="fa fa-line-chart"></i><span
                                                                class="text"> <?= lang('Zone_Wise_Target'); ?></span>
                                                    </a>
                                                </li>

                                                <li id="reports_sales_officer_zone">
                                                    <a href="<?= admin_url('reports/sales_officer_zone') ?>">
                                                        <i class="fa fa-line-chart"></i><span
                                                                class="text"> <?= lang('Sales_Officer_Target_(Zone)'); ?></span>
                                                    </a>
                                                </li>

                                                <li id="reports_achievement_zone_wise">
                                                    <a href="<?= admin_url('reports/achievement_zone_wise') ?>">
                                                        <i class="fa fa-line-chart"></i><span
                                                                class="text"> <?= lang('Zone_Achievement_(Category)'); ?></span>
                                                    </a>
                                                </li>

                                                <li id="reports_achievement_zone">
                                                    <a href="<?= admin_url('reports/achievement_zone') ?>">
                                                        <i class="fa fa-line-chart"></i><span
                                                                class="text"> <?= lang('Zone_Wise_Achievement'); ?></span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>
                                        <?php
                                    } else { // not owner and not admin
                                        ?>

                                        <?php if ($GP['sales_target-zones'] || $GP['sales_target-zone_add'] || $GP['sales_target-sales_officer'] || $GP['sales_target-sales_officer_add']) { ?>
                                            <li class="mm_sales_target">
                                                <a class="dropmenu" href="#">
                                                    <i class="fa fa-star-o"></i>
                                                    <span class="text"> <?= lang('Sales_Target'); ?> </span>
                                                    <span class="chevron closed"></span>
                                                </a>
                                                <ul>
                                                    <?php if ($GP['sales_target-zones']) { ?>
                                                        <li id="sales_target_zones">
                                                            <a class="submenu" href="<?= admin_url('sales_target/zones'); ?>">
                                                                <i class="fa fa-heart-o"></i><span
                                                                        class="text"> <?= lang('Zones_Target'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($GP['sales_target-zone_add']) { ?>
                                                        <li id="sales_target_zone_add">
                                                            <a class="submenu"
                                                               href="<?= admin_url('sales_target/zone_add'); ?>">
                                                                <i class="fa fa-plus-circle"></i><span
                                                                        class="text"> <?= lang('Add_Zones_Target'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php } ?>

                                                    <?php if ($GP['sales_target-sales_officer']) { ?>
                                                    <li id="sales_target_sales_officer">
                                                        <a class="submenu" href="<?= admin_url('sales_target/sales_officer'); ?>">
                                                            <i class="fa fa-heart-o"></i><span
                                                                    class="text"> <?= lang('Sales_Officer_Target'); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                    <?php if ($GP['sales_target-sales_officer_add']) { ?>
                                                        <li id="sales_target_sales_officer_add">
                                                            <a class="submenu"
                                                               href="<?= admin_url('sales_target/sales_officer_add'); ?>">
                                                                <i class="fa fa-plus-circle"></i><span
                                                                        class="text"> <?= lang('Add_Sales_Officer_Target'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>


                                        <?php if ($GP['sales_achievement-sales_officer'] || $GP['sales_achievement-sales_officer_add']) { ?>
                                            <li class="mm_sales_achievement">
                                                <a class="dropmenu" href="#">
                                                    <i class="fa fa-star-o"></i>
                                                    <span class="text"> <?= lang('Sales_Achievement'); ?> </span>
                                                    <span class="chevron closed"></span>
                                                </a>
                                                <ul>

                                                    <?php if ($GP['sales_achievement-sales_officer']) { ?>
                                                        <li id="sales_achievement_sales_officer">
                                                            <a class="submenu" href="<?= admin_url('sales_achievement/sales_officer'); ?>">
                                                                <i class="fa fa-heart-o"></i><span
                                                                        class="text"> <?= lang('Sales_Officer_Achievement'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($GP['sales_achievement-sales_officer_add']) { ?>
                                                        <li id="sales_achievement_sales_officer_add">
                                                            <a class="submenu"
                                                               href="<?= admin_url('sales_achievement/sales_officer_add'); ?>">
                                                                <i class="fa fa-plus-circle"></i><span
                                                                        class="text"> <?= lang('Add_Achievement'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>

                                        <?php if ($GP['calendar-index'] || $GP['calendar-add']) { ?>
                                            <li class="mm_calendar">
                                                <a class="submenu" href="<?= admin_url('calendar'); ?>">
                                                    <i class="fa fa-calendar"></i><span
                                                            class="text"> <?= lang('Calendar'); ?></span>
                                                </a>
                                            </li>
                                        <?php } ?>

                                        <?php if ($GP['notifications-index'] || $GP['notifications-add']) { ?>
                                            <li class="mm_notifications">
                                                <a class="submenu" href="<?= admin_url('notifications'); ?>">
                                                    <i class="fa fa-info-circle"></i><span
                                                            class="text"> <?= lang('Notifications'); ?></span>
                                                </a>
                                            </li>
                                        <?php } ?>

                                        <?php if ($GP['reports-sales_officer_zone'] || $GP['reports-target_zone'] || $GP['reports-target_zone_wise'] ) { ?>
                                            <li class="mm_reports">
                                                <a class="dropmenu" href="#">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                    <span class="text"> <?= lang('reports'); ?> </span>
                                                    <span class="chevron closed"></span>
                                                </a>
                                                <ul>
                                                    <?php if ($GP['reports-target_zone_wise']) { ?>
                                                        <li id="reports_target_zone_wise">
                                                            <a href="<?= admin_url('reports/target_zone_wise') ?>">
                                                                <i class="fa fa-line-chart"></i><span
                                                                        class="text"> <?= lang('Zone_Wise_Target_(Category)'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                    if ($GP['reports-target_zone']) { ?>
                                                            <li id="reports_target_zone">
                                                                <a href="<?= admin_url('reports/target_zone') ?>">
                                                                    <i class="fa fa-line-chart"></i><span
                                                                            class="text"> <?= lang('Zone_Wise_Target'); ?></span>
                                                                </a>
                                                            </li>
                                                    <?php }
                                                    if ($GP['reports-sales_officer_zone']) { ?>
                                                        <li id="reports_sales_officer_zone">
                                                            <a href="<?= admin_url('reports/sales_officer_zone') ?>">
                                                                <i class="fa fa-line-chart"></i><span
                                                                        class="text"> <?= lang('Sales_Officer_Target_(Zone)'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                    if ($GP['reports-daily_sales']) { ?>
                                                        <li id="reports_daily_sales">
                                                            <a href="<?= admin_url('reports/daily_sales') ?>">
                                                                <i class="fa fa-calendar-o"></i><span
                                                                        class="text"> <?= lang('daily_sales'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                    if ($GP['reports-monthly_sales']) { ?>
                                                        <li id="reports_monthly_sales">
                                                            <a href="<?= admin_url('reports/monthly_sales') ?>">
                                                                <i class="fa fa-calendar-o"></i><span
                                                                        class="text"> <?= lang('monthly_sales'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                    if ($GP['reports-sales']) { ?>
                                                        <li id="reports_sales">
                                                            <a href="<?= admin_url('reports/sales') ?>">
                                                                <i class="fa fa-heart"></i><span
                                                                        class="text"> <?= lang('sales_report'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                    if ($GP['reports-payments']) { ?>
                                                        <li id="reports_payments">
                                                            <a href="<?= admin_url('reports/payments') ?>">
                                                                <i class="fa fa-money"></i><span
                                                                        class="text"> <?= lang('payments_report'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                    if ($GP['reports-tax']) { ?>
                                                        <li id="reports_tax">
                                                            <a href="<?= admin_url('reports/tax') ?>">
                                                                <i class="fa fa-area-chart"></i><span
                                                                        class="text"> <?= lang('tax_report'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                    if ($GP['reports-daily_purchases']) { ?>
                                                        <li id="reports_daily_purchases">
                                                            <a href="<?= admin_url('reports/daily_purchases') ?>">
                                                                <i class="fa fa-calendar-o"></i><span
                                                                        class="text"> <?= lang('daily_purchases'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                    if ($GP['reports-monthly_purchases']) { ?>
                                                        <li id="reports_monthly_purchases">
                                                            <a href="<?= admin_url('reports/monthly_purchases') ?>">
                                                                <i class="fa fa-calendar-o"></i><span
                                                                        class="text"> <?= lang('monthly_purchases'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                    if ($GP['reports-purchases']) { ?>
                                                        <li id="reports_purchases">
                                                            <a href="<?= admin_url('reports/purchases') ?>">
                                                                <i class="fa fa-star"></i><span
                                                                        class="text"> <?= lang('purchases_report'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                    if ($GP['reports-expenses']) { ?>
                                                        <li id="reports_expenses">
                                                            <a href="<?= admin_url('reports/expenses') ?>">
                                                                <i class="fa fa-star"></i><span
                                                                        class="text"> <?= lang('expenses_report'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                    if ($GP['reports-customers']) { ?>
                                                        <li id="reports_customer_report">
                                                            <a href="<?= admin_url('reports/customers') ?>">
                                                                <i class="fa fa-users"></i><span
                                                                        class="text"> <?= lang('customers_report'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                    if ($GP['reports-suppliers']) { ?>
                                                        <li id="reports_supplier_report">
                                                            <a href="<?= admin_url('reports/suppliers') ?>">
                                                                <i class="fa fa-users"></i><span
                                                                        class="text"> <?= lang('suppliers_report'); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>

                                    <?php } ?>
                                </ul>
                            </div>
                            <a href="#" id="main-menu-act" class="full visible-md visible-lg">
                                <i class="fa fa-angle-double-left"></i>
                            </a>
                        </div>
                    </td>
                    <td class="content-con">
                        <div id="content">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <ul class="breadcrumb">
                                        <?php
                                        foreach ($bc as $b) {
                                            if ($b['link'] === '#') {
                                                echo '<li class="active">' . $b['page'] . '</li>';
                                            } else {
                                                echo '<li><a href="' . $b['link'] . '">' . $b['page'] . '</a></li>';
                                            }
                                        }
                                        ?>
                                        <li class="right_log hidden-xs">
                                            <?= lang('your_ip') . ' ' . $ip_address . " <span class='hidden-sm'>( " . lang('last_login_at') . ": " . date($dateFormats['php_ldate'], $this->session->userdata('old_last_login')) . " " . ($this->session->userdata('last_ip') != $ip_address ? lang('ip:') . ' ' . $this->session->userdata('last_ip') : '') . " )</span>" ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php if ($message) { ?>
                                        <div class="alert alert-success">
                                            <button data-dismiss="alert" class="close" type="button">×</button>
                                            <?= $message; ?>
                                        </div>
                                    <?php } ?>
                                    <?php if ($error) { ?>
                                        <div class="alert alert-danger">
                                            <button data-dismiss="alert" class="close" type="button">×</button>
                                            <?= $error; ?>
                                        </div>
                                    <?php } ?>
                                    <?php if ($warning) { ?>
                                        <div class="alert alert-warning">
                                            <button data-dismiss="alert" class="close" type="button">×</button>
                                            <?= $warning; ?>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if ($info) {
                                        foreach ($info as $n) {
                                            if (!$this->session->userdata('hidden' . $n->id)) {
                                                ?>
                                                <div class="alert alert-info">
                                                    <a href="#" id="<?= $n->id ?>" class="close hideComment external"
                                                       data-dismiss="alert">&times;</a>
                                                    <?= $n->comment; ?>
                                                </div>
                                            <?php }
                                        }
                                    } ?>
                                    <div class="alerts-con"></div>
