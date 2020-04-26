<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .analysis_link {
        cursor: pointer;
    }
</style>
<script>
    $(document).ready(function () {
        oTable = $('#CategoryTable').dataTable({
            "aaSorting": [[1, "asc"], [5, 'asc']],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('farmer_analysis/getAnalysis') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            }, "fnRowCallback": function (nRow, aData, iStart, iEnd, aiDisplay) {
                nRow.id = aData[0];
                nRow.className = "analysis_link";
                return nRow;
            },
            "aoColumns": [{
                "bSortable": false,
                "mRender": checkbox
            },
                null, null, null, null, {"mRender": fsd}, null, null,
                null, null, null,
                null, null, {"mRender": verified_div},
                {"bSortable": false}]
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 1, filter_default_label: "[<?=lang('Bird_Type');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('Farmer_Name');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('Visitor');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('Visitor');?>]", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?=lang('Visit_Date');?>]", filter_type: "text", data: []},
            {column_number: 6, filter_default_label: "[<?=lang('Zone');?>]", filter_type: "text", data: []},
            {column_number: 7, filter_default_label: "[<?=lang('Initial_Qty');?>]", filter_type: "text", data: []},
            {column_number: 8, filter_default_label: "[<?=lang('Mortality');?>]", filter_type: "text", data: []},
            {column_number: 9, filter_default_label: "[<?=lang('%');?>]", filter_type: "text", data: []},
            {column_number: 10, filter_default_label: "[<?=lang('Feed_Intake');?>]", filter_type: "text", data: []},
            {column_number: 11, filter_default_label: "[<?=lang('Body_Weight');?>]", filter_type: "text", data: []},
            {column_number: 12, filter_default_label: "[<?=lang('Egg_Production');?>]", filter_type: "text", data: []},
            {column_number: 13, filter_default_label: "[<?=lang('Verified_Status');?>]", filter_type: "text", data: []},
        ], "footer");
    });

    function verified_div(x) {
        if (x == null) {
            return '';
        } else if (x == 0) {
            return '<div class="text-center"><span class="label label-warning">Unverified</span></div>';
        } else {
            return '<div class="text-center"><span class="label label-success">Verified</span></div>';
        }
    }
</script>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-folder-open"></i><?= lang('Farmer_Analysis'); ?></h2>
        <ul class="btn-tasks" style="margin-right: 5px;margin-top: 2px;">
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip"
                                                                              data-placement="left"
                                                                              title="<?= lang("actions") ?>"></i></a>
                <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                    <li><a href="<?= admin_url('farmer_analysis/add'); ?>"><i
                                    class="fa fa-plus-circle"></i> <?= lang("Add"); ?></a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table id="CategoryTable" class="table table-bordered table-hover table-striped reports-table">
                        <thead>
                        <tr>
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
                            <th><?= lang("Bird_Type"); ?></th>
                            <th><?= lang("Farmer_Name"); ?></th>
                            <th><?= lang("Farmer_Mobile"); ?></th>
                            <th><?= lang("Visitor"); ?></th>
                            <th><?= lang("Visit_Date"); ?></th>
                            <th><?= lang("Zone"); ?></th>
                            <th><?= lang("Initial_Bird"); ?></th>
                            <th><?= lang("FCR"); ?></th>
                            <th><?= lang("Mortality"); ?></th>
                            <th><?= lang("Feed_Intake"); ?></th>
                            <th><?= lang("Body_weight"); ?></th>
                            <th><?= lang("Egg_Production"); ?></th>
                            <th><?= lang("Verified_Status"); ?></th>
                            <th style="width:100px;"><?= lang("actions"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="17" class="dataTables_empty">
                                <?= lang('loading_data_from_server') ?>
                            </td>
                        </tr>
                        </tbody>

                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th style="min-width:30px; width: 30px; text-align: center;">
                            </th>
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
                            <th></th>
                            <th style="width:85px;"><?= lang("actions"); ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
