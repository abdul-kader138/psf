<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if ($m5bs) {
    $array_field = "[";
    $array_field_c = "[";
    $array_length = count($m5bs);
    $init = 0;
    foreach ($m5bs as $r) {
        $init = $init + 1;
        if ($r->target_quantity > 0) {
            $array_field .= ("'" . $r->zone_name. "<br>(Total Dealer-" . $r->dealer . ")"."'");

        }
        $array_field_c .= 0;
        if ($init < $array_length) {
            $array_field .= ",";
            $array_field_c .= ",";
        }

    }
    $array_field .= "]";
    $array_field_c .= "]";
}
if ($m3bs) {
    $array_field3 = "[";
    $array_length3 = count($m5bs);
    $init3 = 0;
    foreach ($m3bs as $r) {
        $init3 = $init3 + 1;
        if ($r->target_quantity > 0) {
            $array_field3 .= $r->target_quantity;
        } else {
            $array_field3 .= 0;
        }
        if ($init3 < $array_length3) $array_field3 .= ",";
    }
    $array_field3 .= "]";
} else $array_field3 = $array_field_c;


if ($m2bs) {
    $array_field2 = "[";
    $array_length2 = count($m5bs);
    $init2 = 0;
    foreach ($m2bs as $r) {
        $init2 = $init2 + 1;
        if ($r->target_quantity > 0) {
            $array_field2 .= $r->target_quantity;
        } else {
            $array_field2 .= 0;
        }
        if ($init2 < $array_length2) $array_field2 .= ",";
    }
    $array_field2 .= "]";
} else $array_field2 = $array_field_c;

if ($m1bs) {
    $array_field1 = "[";
    $array_length1 = count($m5bs);
    $init1 = 0;
    foreach ($m1bs as $r) {
        $init1 = $init1 + 1;
        if ($r->target_quantity > 0) {
            $array_field1 .= $r->target_quantity;
        } else {
            $array_field1 .= 0;
        }
        if ($init1 < $array_length1) $array_field1 .= ",";
    }
    $array_field1 .= "]";
} else $array_field1 = $array_field_c;

?>
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
        $('#m7bschart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Zone Wise Target(Category)'
            }, credits: {enabled: false},
            xAxis: {
                categories: <?php echo $array_field; ?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: <?php echo "'Target Quantity (" . $um . ")'"; ?>
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        //color: ( // theme
                        //    Highcharts.defaultOptions.title.style &&
                        //     Highcharts.defaultOptions.title.style.color
                        // ) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: 45,
                floating: true,
                backgroundColor:
                    'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: true
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: false
                    }
                }
            },
            series: [{
                color:'#3c9d9b',
                name: 'Poultry',
                data: <?php echo $array_field1; ?>
            }, {
                color:'#ed5107',
                name: 'Fish',
                data: <?php echo $array_field2; ?>
            }, {
                color:'#241663',
                name: 'Cattle',
                data: <?php echo $array_field3; ?>
            }]
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
                    <?php echo admin_form_open("reports/target_zone_wise"); ?>
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
                        <h2 class="blue"><?= $m3; ?>
                        </h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="m7bschart" style="width:100%; height:450px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php }?>