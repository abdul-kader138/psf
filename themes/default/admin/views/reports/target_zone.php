<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?= $assets; ?>js/hc/highcharts.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#form').hide();
        $('.toggle_down').click(function () {
            $("#form").slideDown();
            return false;
        });
        $('.toggle_up').click(function () {
            $("#form").slideUp();
            return false;
        });
    });
    $(function () {
        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
                stops: [[0, color], [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]]
            };
        });
        <?php if ($m5bs) { ?>
        $('#m1bschart').highcharts({
            chart: {type: 'column'},
            title: {text: "All Category"},
            credits: {enabled: false},
            xAxis: {
                type: 'category',
                labels: {rotation: -45, style: {fontSize: '14px', fontFamily: 'Verdana, sans-serif'}}
            },
            yAxis: {min: 0, title: {text: <?php echo "'Target Quantity (" . $um . ")'"; ?>}},
            legend: {enabled: false},
            series: [{
                name: '<?=lang('Target_Quantity');?>',
                color:'#35b0ab',
                data: [<?php
                    foreach ($m5bs as $r) {
                        if ($r->target_quantity > 0) {
                            echo "['" . $r->zone_name . "<br>(Total Dealer-" . $r->dealer . ")', " . $r->target_quantity . "],";
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

        <?php if ($totals) { ?>
        $('#chart').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {text: 'Category Wise Target'},
            credits: {enabled: false},
            tooltip: {
                formatter: function () {
                    return '<div class="tooltip-inner hc-tip" style="margin-bottom:0;">' + this.key + '<br><strong>' + currencyFormat(this.y) + '</strong> (' + formatNumber(this.percentage) + '%)';
                },
                followPointer: true,
                useHTML: true,
                borderWidth: 0,
                shadow: false,
                valueDecimals: site.settings.decimals,
                style: {fontSize: '14px', padding: '0', color: '#000000'}
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        formatter: function () {
                            return '<h3 style="margin:-15px 0 0 0;"><b>' + this.point.name + '</b>:<br><b> ' + currencyFormat(this.y) + '</b></h3>';
                        },
                        useHTML: true
                    }
                }
            },
            series: [{
                type: 'pie',
                name: '<?php echo $this->lang->line("Target_Quantity")." ".$um; ?>',
                data: [<?php
                        foreach ($totals as $r1) {
                            if ($r->target_quantity > 0) {
                                echo "['" . $r1->name . "', " . $r1->target_quantity . "],";
                            }
                        }
                        ?>]

            }]
        });
        <?php } ?>
    });
</script>
<div class="box">
    <div class="box-header">
        <h2 style="color: #0e90d2; text-align: center">Sales Target- Zone Wise</h2>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>">
                        <i class="icon fa fa-toggle-up"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>">
                        <i class="icon fa fa-toggle-down"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <div id="form">
                    <?php echo admin_form_open("reports/target_zone"); ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("month", "month"); ?>
                                <?php
                                $opt = array("January" => "January", "February" => "February", "March" => "March", "April" => "April", "May" => "May", "June" => "June", "July" => "July", "August" => "August", "September" => "September", "October" => "October", "November" => "November", "December" => "December");
                                echo form_dropdown('month', $opt, (isset($_POST['month']) ? $_POST['month'] : ''), 'id="month"  required="required" class="form-control input-tip select" style="width:100%;"');
                                ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("year", "year"); ?>
                                <?php
                                $opt = array( 2018 => "2018", 2019 => "2019", 2020 => "2020", 2021 => "2021", 2022 => "2022", 2023 => "2023", 2024 => "2024", 2025 => "2025", 2026 => "2026", 2027 => "2027", 2028 => "2028", 2029 => "2029", 2030 => "2030");
                                echo form_dropdown('year', $opt, (isset($_POST['year']) ? $_POST['year'] : ''), 'id="year" required="required" class="form-control input-tip select" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div
                            class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-content">
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-sm-12">
                <div class="box">
                    <div class="box-header">
                        <h2 class="blue"><?= $m1; ?>
                        </h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="m1bschart" style="width:100%; height:450px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="box" style="margin-top: 15px;">
            <div class="box-header">
                    <h2 class="blue"><?= $m1; ?>
                    </h2>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($totals) { ?>
                            <div class="small-box padding1010 col-sm-12" style="background-color: #83b582">
                                <div class="inner clearfix">
                                        <p style="color: black;font-size: 20px;"><b>Total Target Quantity : <?= $this->sma->formatQuantity($totals_qty->target_quantity) ?></b></p>
                                </div>
                            </div>
                            <div class="clearfix" style="margin-top:20px;"></div>
                        <?php } ?>
                        <div id="chart" style="width:100%; height:450px;"></div>
                    </div>
                </div>
            </div>
        </div>
