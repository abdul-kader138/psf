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
        $('#m1bschart').highcharts({
            chart: {type: 'column'},
            title: {text: "All Depot"},
            credits: {enabled: false},
            xAxis: {
                type: 'category',
                labels: {rotation: -45, style: {fontSize: '14px', fontFamily: 'Verdana, sans-serif'}}
            },
            yAxis: {min: 0, title: {text: <?php echo "'Per KG Cost (TK)'"; ?>}},
            legend: {enabled: false},
            series: [{
                name: '<?=lang('Per KG Cost');?>',
                // color: '#90ca70',
                data: [
                    <?php
                    foreach ($m5bs as $r) {
                        if ($r['cost'] > 0) {
                            echo "['" . $r['name'] . "<br>', " . $r['cost'] . "],";
                        }
                    }
                    ?>
                ],
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


    });
</script>
<div class="box">
    <div class="box-header">
        <h2 style="color: #0e90d2; text-align: center">Depot Costing</h2>
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
                    <?php echo admin_form_open("reports/depot_costing"); ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Business_Unit", "Business_Unit"); ?>
                                <?php
                                $b4[""] = lang('select') . ' ' . lang('package');
                                $opt = array("Poultry" => "Poultry", "Feed" => "Feed", "Paragon Agro" => "Paragon Agro");
                                echo form_dropdown('bu', $opt, (isset($_POST['bu']) ? $_POST['bu'] : ''), 'id="bu"  required="required" class="form-control input-tip select" style="width:100%;"');
                                ?>
                            </div>
                        </div>
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
        </div>
    </div>
<?php } ?>

