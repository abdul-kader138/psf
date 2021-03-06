<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $z_name = "text: 'All Category (" . $zone->name . " Zone)'"; ?>
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

            $('#m4bschart').highcharts({
                // Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                     <?php echo $z_name; ?>

                }, credits: {enabled: false},
                xAxis: {
                    //categories: [<?php
                    //    foreach ($m2bs as $r) {
                    //        if ($r->target_quantity > 0) {
                    //            echo "['" . $r->first_name . " " . $r->last_name . "',";
                    //        }
                    //    }
                    //    ?>//]
                    categories: <?php echo $officer_array; ?>
                },

                yAxis: {
                    min: 0,
                    title: {
                        text: <?php echo "'Target Quantity ( TON )'"; ?>
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                        }
                    }
                },
                legend: {
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                    floating: true,
                    backgroundColor: 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: [<?php echo $allOfficerTarget; ?>]
            });

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
                        <?php echo admin_form_open("reports/sales_officer_zone"); ?>
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
                                    $opt = array(2018 => "2018", 2019 => "2019", 2020 => "2020", 2021 => "2021", 2022 => "2022", 2023 => "2023", 2024 => "2024", 2025 => "2025", 2026 => "2026", 2027 => "2027", 2028 => "2028", 2029 => "2029", 2030 => "2030");
                                    echo form_dropdown('year', $opt, (isset($_POST['year']) ? $_POST['year'] : ''), 'id="year" required="required" class="form-control input-tip select" style="width:100%;"');
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("Zone_Name", "Zone_Name"); ?>
                                    <?php
                                    $b3[""] = "";
                                    foreach ($zones as $zone) {
                                        $b3[$zone->id] = $zone->name;
                                    }
                                    echo form_dropdown('zone_id', $b3, (isset($_POST['zone_id']) ? $_POST['zone_id'] : ''), ' data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("Zone_Name") . '" required="required" id="zone_id" class="form-control input-tip select" style="width:100%;"');
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

<?php if ($m5bs) { ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><?= $m1; ?>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="m4bschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>