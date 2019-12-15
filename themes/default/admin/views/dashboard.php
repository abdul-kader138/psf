<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-12">
        <div class="col-sm-4">
            <div class="small-box padding1010" style="background-color: #FE9C96">
                <h4 class="bold"><?= lang('Zone') ?></h4>
                <i class="icon fa fa-star"></i>
                <h3 class="bold"><?= $total_zones->total ?></h3>
                <p>&nbsp;</p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="small-box padding1010" style="background-color: #4AA4EC">
                <h4 class="bold"><?= lang('Categories') ?></h4>
                <i class="icon fa fa-plus-circle"></i>

                <h3 class="bold"><?= $total_cate->total ?></h3>
                <p>&nbsp;</p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="small-box padding1010" style="background-color: #38D2BC">
                <h4 class="bold"><?= lang('Sales_Officer') ?></h4>
                <i class="icon fa fa-user-plus"></i>

                <h3 class="bold"><?= $total_users->total ?></h3>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>

</div>

<?php if ($createYearTarget) { ?>

    <div class="row" style="margin-bottom: 15px;">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><i
                                class="fa-fw fa fa-line-chart"></i>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="bschart1" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($chatData || $createYearTarget) { ?>
    <style type="text/css" media="screen">
        .tooltip-inner {
            max-width: 700px;
        }
    </style>
    <script src="<?= $assets; ?>js/hc/highcharts.js"></script>
    <script type="text/javascript">
        $(function () {
            Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
                return {
                    radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
                    stops: [[0, color], [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]]
                };
            });


            $('#bschart1').highcharts({
                chart: {
                    type: 'spline',
                },
                title: {
                    text: 'Feed\'s Yearly Sales Analysis - <?php echo date('Y');?>'
                },
                credits: {enabled: false},
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: ['January', 'February', 'March', 'April', 'May', 'June',
                        'July', 'August', 'September', 'October', 'November', 'December']
                },
                yAxis: {
                    title: {
                        text: 'Quantity (TON)'
                    },
                    labels: {
                        formatter: function () {
                            return this.value + ' ';
                        }
                    }
                },
                tooltip: {
                    crosshairs: true,
                    shared: true
                },
                plotOptions: {
                    spline: {
                        marker: {
                            radius: 4,
                            lineColor: '#666666',
                            lineWidth: 1
                        }
                    }
                },
                series: [{
                    name: 'Target',
                    marker: {
                        symbol: 'square'
                    },
                    data: <?php echo $createYearTarget; ?>

                }, {
                    name: 'Achievement',
                    marker: {
                        symbol: 'diamond'
                    },
                    data:<?php echo $createYearSales; ?>
                }]
            });

        });
    </script>
<?php } ?>

<?php if ($Owner || $Admin) { ?>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><i class="fa fa-th"></i><span class="break"></span><?= lang('quick_links') ?></h2>
                </div>
                <div class="box-content">

                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="bred white quick-button small" href="<?= admin_url('sales_target/zones') ?>">
                            <i class="fa fa-plus"></i>

                            <p><?= lang('Target') ?></p>
                        </a>
                    </div>
                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="bblue white quick-button small"
                           href="<?= admin_url('sales_achievement/sales_officer') ?>">
                            <i class="fa fa-dollar"></i>

                            <p><?= lang('Achievement') ?></p>
                        </a>
                    </div>

                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="bdarkGreen white quick-button small" href="<?= admin_url('purchases/expenses') ?>">
                            <i class="fa fa-heart"></i>

                            <p><?= lang('Depot') ?></p>
                        </a>
                    </div>
                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="blightOrange white quick-button small" href="<?= admin_url('calendar') ?>">
                            <i class="fa fa-calendar"></i>

                            <p><?= lang('Events') ?></p>
                        </a>
                    </div>

                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="blightBlue white quick-button small" href="<?= admin_url('notifications') ?>">
                            <i class="fa fa-comments"></i>
                            <p><?= lang('notifications') ?></p>
                        </a>
                    </div>

                    <?php if ($Owner) { ?>
                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="bpink white quick-button small" href="<?= admin_url('auth/users') ?>">
                                <i class="fa fa-group"></i>
                                <p><?= lang('users') ?></p>
                            </a>
                        </div>
                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="bblue white quick-button small" href="<?= admin_url('system_settings') ?>">
                                <i class="fa fa-cogs"></i>

                                <p><?= lang('settings') ?></p>
                            </a>
                        </div>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><i class="fa fa-th"></i><span class="break"></span><?= lang('quick_links') ?></h2>
                </div>
                <div class="box-content">
                    <?php if ($GP['sales_target-zones'] || $GP['sales_target-zone_add'] || $GP['sales_target-sales_officer'] || $GP['sales_target-sales_officer_add']) { ?>
                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="bred white quick-button small" href="<?= admin_url('sales_target/zones') ?>">
                                <i class="fa fa-plus"></i>

                                <p><?= lang('Target') ?></p>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if ($GP['sales_achievement-sales_officer'] || $GP['sales_achievement-sales_officer_add']) { ?>

                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="bblue white quick-button small"
                               href="<?= admin_url('sales_achievement/sales_officer') ?>">
                                <i class="fa fa-dollar"></i>

                                <p><?= lang('Achievement') ?></p>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if ($GP['purchases-expenses'] || $GP['purchases-add_expense'] || $GP['purchases-depot_sales'] || $GP['purchases-add_sale']) { ?>

                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="bdarkGreen white quick-button small"
                               href="<?= admin_url('purchases/expenses') ?>">
                                <i class="fa fa-heart"></i>

                                <p><?= lang('Depot') ?></p>
                            </a>
                        </div>
                    <?php }
                    if ($GP['document-doc_movement_list']) { ?>
                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="bred white quick-button small"
                               href="<?= site_url('document/doc_movement_list') ?>">
                                <i class="fa fa-star"></i>
                                <p><?= lang('Doc_Mov.') ?></p>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if ($GP['calendar-index'] || $GP['calendar-add']) { ?>
                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="blightOrange white quick-button small" href="<?= admin_url('calendar') ?>">
                                <i class="fa fa-calendar"></i>

                                <p><?= lang('Events') ?></p>
                            </a>
                        </div>

                    <?php } ?>
                    <?php if ($GP['notifications-index'] || $GP['notifications-add']) { ?>
                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="blightBlue white quick-button small" href="<?= admin_url('notifications') ?>">
                                <i class="fa fa-comments"></i>
                                <p><?= lang('notifications') ?></p>
                            </a>
                        </div>
                    <?php } ?>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
