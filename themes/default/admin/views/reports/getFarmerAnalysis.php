<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php

$v = "";
if ($this->input->post('zone')) {
    $v .= "&zone=" . $this->input->post('zone');
}
if ($this->input->post('user')) {
    $v .= "&user=" . $this->input->post('user');
}

if ($this->input->post('visit_date_start')) {
    $v .= "&visit_date_start=" . $this->input->post('visit_date_start');
}
if ($this->input->post('visit_date_end')) {
    $v .= "&visit_date_end=" . $this->input->post('visit_date_end');
}
if ($this->input->post('type_of_bird')) {
    $v .= "&type_of_bird=" . $this->input->post('type_of_bird');
}

?>

<script>
    $(document).ready(function () {
        oTable = $('#SlRData').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('reports/getFarmerAnalysis/?v=1' . $v) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                // nRow.id = aData[9];
                // nRow.className = (aData[5] > 0) ? "invoice_link2" : "invoice_link2 warning";
                // return nRow;
            },
            "aoColumns": [null, null, null, null, null,null, null, null,null,null,null,null],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
            }
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 0, filter_default_label: "[<?=lang('Type_Of_Bird');?>]", filter_type: "text", data: []},
            {column_number: 1, filter_default_label: "[<?=lang('Farmer');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('Mobile');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('Visitor');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('Visit_Date');?>]", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?=lang('Zone');?>]", filter_type: "text", data: []},
            {column_number: 6, filter_default_label: "[<?=lang('Hatch_date');?>]", filter_type: "text", data: []},
            {column_number: 7, filter_default_label: "[<?=lang('Initial_Quantity');?>]", filter_type: "text", data: []},
            {column_number: 8, filter_default_label: "[<?=lang('Mortality');?>]", filter_type: "text", data: []},
            {column_number: 9, filter_default_label: "[<?=lang('%');?>]", filter_type: "text", data: []},
            {column_number: 10, filter_default_label: "[<?=lang('FCR');?>]", filter_type: "text", data: []},
            {column_number: 11, filter_default_label: "[<?=lang('Weight');?>]", filter_type: "text", data: []},
        ], "footer");
    });
</script>
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
</script>


<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-heart"></i><?= lang('Farmer_Analysis_Report'); ?> </h2>

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
        <div class="box-icon">
            <ul class="btn-tasks">
<!--                <li class="dropdown">-->
<!--                    <a href="#" id="pdf" class="tip" title="--><?//= lang('download_pdf') ?><!--">-->
<!--                        <i class="icon fa fa-file-pdf-o"></i>-->
<!--                    </a>-->
<!--                </li>-->
                <li class="dropdown">
                    <a href="#" id="xls" class="tip" title="<?= lang('download_xls') ?>">
                        <i class="icon fa fa-file-excel-o"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" id="image" class="tip" title="<?= lang('save_image') ?>">
                        <i class="icon fa fa-file-picture-o"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('customize_report'); ?></p>

                <div id="form">

                    <?php echo admin_form_open("reports/farmerAnalysisReport"); ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="user"><?= lang("Visited_By"); ?></label>
                                <?php
                                $us[""] = lang('select').' '.lang('Visitor');
                                foreach ($users as $user) {
                                    $us[$user->id] = $user->first_name . " " . $user->last_name;
                                }
                                echo form_dropdown('user', $us, (isset($_POST['user']) ? $_POST['user'] : ""), 'class="form-control" id="user" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("user") . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="biller"><?= lang("Zones"); ?></label>
                                <?php
                                $bl[""] = lang('select').' '.lang('zone');
                                foreach ($zones as $zone) {
                                    $bl[$zone->id] = $zone->name;
                                }
                                echo form_dropdown('zone', $bl, (isset($_POST['zone']) ? $_POST['zone'] : ""), 'class="form-control" id="zone" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("Zone") . '"');
                                ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Type_Of_Bird", "Type_Of_Bird"); ?>
                                <?php
                                $opt = array('None'=>'Select Type','Broiler' => "Broiler", "Layer" => "Layer", "Sonali" => "Sonali");
                                echo form_dropdown('type_of_bird', $opt, (isset($_POST['type_of_bird']) ? $_POST['type_of_bird'] : ''), 'id="type_of_bird" required="required" class="form-control input-tip select" style="width:100%;"');
                                ?>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("Visit_Date_From", "Visit_Date_From"); ?>
                                <?php echo form_input('visit_date_start', (isset($_POST['visit_date_start']) ? $_POST['visit_date_start'] : ""), 'class="form-control date" id="visit_date_start"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("Visit_Date_TO", "Visit_Date_TO"); ?>
                                <?php echo form_input('visit_date_end', (isset($_POST['visit_date_end']) ? $_POST['visit_date_end'] : ""), 'class="form-control date" id="visit_date_end"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div
                            class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
                <div class="clearfix"></div>

                <div class="table-responsive">
                    <table id="SlRData"
                           class="table table-bordered table-hover table-striped table-condensed reports-table">
                        <thead>
                        <tr>
                            <th><?= lang("Type_Of_Bird"); ?></th>
                            <th><?= lang("Farmer"); ?></th>
                            <th><?= lang("Farmer_Mobile"); ?></th>
                            <th><?= lang("Visitor"); ?></th>
                            <th><?= lang("Visit_Date"); ?></th>
                            <th><?= lang("Zones"); ?></th>
                            <th><?= lang("Hatch_Date"); ?></th>
                            <th><?= lang("Initial_Quantity"); ?></th>
                            <th><?= lang("Mortality"); ?></th>
                            <th><?= lang("Mortality(%)"); ?></th>
                            <th><?= lang("FCR"); ?></th>
                            <th><?= lang("Body_Weight"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="9" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#pdf').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/getFarmerAnalysis/pdf/?v=1'.$v)?>";
            return false;
        });
        $('#xls').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/getFarmerAnalysis/0/xls/?v=1'.$v)?>";
            return false;
        });
        $('#image').click(function (event) {
            event.preventDefault();
            html2canvas($('.box'), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL();
                    window.open(img);
                }
            });
            return false;
        });
    });
</script>