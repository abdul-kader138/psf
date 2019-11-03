<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
function row_status($x)
{
    if ($x == null) {
        return '';
    } elseif ($x == 'pending') {
        return '<div class="text-center"><span class="label label-warning">' . lang($x) . '</span></div>';
    } elseif ($x == 'completed' || $x == 'paid' || $x == 'sent' || $x == 'received') {
        return '<div class="text-center"><span class="label label-success">' . lang($x) . '</span></div>';
    } elseif ($x == 'partial' || $x == 'transferring') {
        return '<div class="text-center"><span class="label label-info">' . lang($x) . '</span></div>';
    } elseif ($x == 'due') {
        return '<div class="text-center"><span class="label label-danger">' . lang($x) . '</span></div>';
    } else {
        return '<div class="text-center"><span class="label label-default">' . lang($x) . '</span></div>';
    }
}

?>
<?php if (($Owner || $Admin) && $chatData) {
    foreach ($chatData as $month_sale) {
        $months[] = date('M-Y', strtotime($month_sale->month));
        $msales[] = $month_sale->sales;
        $mtax1[] = $month_sale->tax1;
        $mtax2[] = $month_sale->tax2;
        $mpurchases[] = $month_sale->purchases;
        $mtax3[] = $month_sale->ptax;
    }
    ?>

    <div class="row" style="margin-bottom: 15px;">
        <div class="col-sm-12">
            <div class="col-sm-4">
                <div class="small-box padding1010 borange">
                    <h4 class="bold"><?= lang('Zone') ?></h4>
                    <i class="icon fa fa-star"></i>
                    <h3 class="bold"><?= $total_zones->total?></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box padding1010 bdarkGreen">
                    <h4 class="bold"><?= lang('Categories') ?></h4>
                    <i class="icon fa fa-heart"></i>

                    <h3 class="bold"><?= $total_cate->total?></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box padding1010 bpurple">
                    <h4 class="bold"><?= lang('Sales_Officer') ?></h4>
                    <i class="icon fa fa-usd"></i>

                    <h3 class="bold"><?= $total_users->total?></h3>
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>

    </div>
<!--    <div class="box" style="margin-bottom: 15px;">-->
<!--        <div class="box-header">-->
<!--            <h2 class="blue"><i class="fa-fw fa fa-bar-chart-o"></i>--><?//= lang('overview_chart'); ?><!--</h2>-->
<!--        </div>-->
<!--        <div class="box-content">-->
<!--            <div class="row">-->
<!--                <div class="col-md-12">-->
<!--                    <p class="introtext">--><?php //echo lang('overview_chart_heading'); ?><!--</p>-->
<!---->
<!--                    <div id="ov-chart" style="width:100%; height:450px;"></div>-->
<!--                    <p class="text-center">--><?//= lang("chart_lable_toggle"); ?><!--</p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<?php } ?>

<?php if ($createYearTarget) {?>

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



<script type="text/javascript">
    $(document).ready(function () {
        $('.order').click(function () {
            window.location.href = '<?=admin_url()?>orders/view/' + $(this).attr('id') + '#comments';
        });
        $('.invoice').click(function () {
            window.location.href = '<?=admin_url()?>orders/view/' + $(this).attr('id');
        });
        $('.quote').click(function () {
            window.location.href = '<?=admin_url()?>quotes/view/' + $(this).attr('id');
        });
    });
</script>

<?php if ($chatData || $createYearTarget) { ?>
    <style type="text/css" media="screen">
        .tooltip-inner {
            max-width: 500px;
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
                    type: 'spline'
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
                        text: 'Quantity'
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

            $('#ov-chart').highcharts({
                chart: {},
                credits: {enabled: false},
                title: {text: ''},
                xAxis: {categories: <?= json_encode($months); ?>},
                yAxis: {min: 0, title: ""},
                tooltip: {
                    shared: true,
                    followPointer: true,
                    formatter: function () {
                        if (this.key) {
                            return '<div class="tooltip-inner hc-tip" style="margin-bottom:0;">' + this.key + '<br><strong>' + currencyFormat(this.y) + '</strong> (' + formatNumber(this.percentage) + '%)';
                        } else {
                            var s = '<div class="well well-sm hc-tip" style="margin-bottom:0;"><h2 style="margin-top:0;">' + this.x + '</h2><table class="table table-striped"  style="margin-bottom:0;">';
                            $.each(this.points, function () {
                                s += '<tr><td style="color:{series.color};padding:0">' + this.series.name + ': </td><td style="color:{series.color};padding:0;text-align:right;"> <b>' +
                                    currencyFormat(this.y) + '</b></td></tr>';
                            });
                            s += '</table></div>';
                            return s;
                        }
                    },
                    useHTML: true, borderWidth: 0, shadow: false, valueDecimals: site.settings.decimals,
                    style: {fontSize: '14px', padding: '0', color: '#000000'}
                },
                series: [{
                    type: 'column',
                    name: '<?= lang("sp_tax"); ?>',
                    data: [<?php
                        echo implode(', ', $mtax1);
                        ?>]
                },
                    {
                        type: 'column',
                        name: '<?= lang("order_tax"); ?>',
                        data: [<?php
                            echo implode(', ', $mtax2);
                            ?>]
                    },
                    {
                        type: 'column',
                        name: '<?= lang("sales"); ?>',
                        data: [<?php
                            echo implode(', ', $msales);
                            ?>]
                    }, {
                        type: 'spline',
                        name: '<?= lang("purchases"); ?>',
                        data: [<?php
                            echo implode(', ', $mpurchases);
                            ?>],
                        marker: {
                            lineWidth: 2,
                            states: {
                                hover: {
                                    lineWidth: 4
                                }
                            },
                            lineColor: Highcharts.getOptions().colors[3],
                            fillColor: 'white'
                        }
                    }, {
                        type: 'spline',
                        name: '<?= lang("pp_tax"); ?>',
                        data: [<?php
                            echo implode(', ', $mtax3);
                            ?>],
                        marker: {
                            lineWidth: 2,
                            states: {
                                hover: {
                                    lineWidth: 4
                                }
                            },
                            lineColor: Highcharts.getOptions().colors[3],
                            fillColor: 'white'
                        }
                    }, {
                        type: 'pie',
                        name: '<?= lang("stock_value"); ?>',
                        data: [
                            ['', 0],
                            ['', 0],
                            ['<?= lang("stock_value_by_price"); ?>', <?php echo $stock->stock_by_price; ?>],
                            ['<?= lang("stock_value_by_cost"); ?>', <?php echo $stock->stock_by_cost; ?>],
                        ],
                        center: [80, 42],
                        size: 80,
                        showInLegend: false,
                        dataLabels: {
                            enabled: false
                        }
                    }]
            });
        });
    </script>

    <script type="text/javascript">
        $(function () {
            <?php if ($lmbs) { ?>
            $('#lmbschart').highcharts({
                chart: {type: 'column'},
                title: {text: ''},
                credits: {enabled: false},
                xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
                yAxis: {min: 0, title: {text: ''}},
                legend: {enabled: false},
                series: [{
                    name: '<?=lang('sold');?>',
                    data: [<?php
                        foreach ($lmbs as $r) {
                            if ($r->quantity > 0) {
                                echo "['" . $r->product_name . "<br>(" . $r->product_code . ")', " . $r->quantity . "],";
                            }
                        }
                        ?>],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#000',
                        align: 'right',
                        y: -25,
                        style: {fontSize: '12px'}
                    }
                }]
            });
            <?php } if ($bs) { ?>
            $('#bschart').highcharts({
                chart: {type: 'column'},
                title: {text: ''},
                credits: {enabled: false},
                xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
                yAxis: {min: 0, title: {text: ''}},
                legend: {enabled: false},
                series: [{
                    name: '<?=lang('sold');?>',
                    data: [<?php
                        foreach ($bs as $r) {
                            if ($r->quantity > 0) {
                                echo "['" . $r->product_name . "<br>(" . $r->product_code . ")', " . $r->quantity . "],";
                            }
                        }
                        ?>],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#000',
                        align: 'right',
                        y: -25,
                        style: {fontSize: '12px'}
                    }
                }]
            });
            <?php } ?>
        });
    </script>


<?php } ?>
