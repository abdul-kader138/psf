<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    $(document).ready(function () {
        oTable = $('#CategoryTable').dataTable({
            "aaSorting": [[2, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('sales_achievement/getSalesOfficer') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            }, "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var gtotal = 0;
                var total = 0;
                for (var i = 0; i < (aaData.length); i++) {
                    // if(aaData[aiDisplay[i]][4])  gtotal += parseFloat(aaData[aiDisplay[i]][4]);
                    if (aaData[aiDisplay[i]][5]) total += parseFloat(aaData[aiDisplay[i]][5]);
                    if (aaData[aiDisplay[i]][6]) gtotal += parseFloat(aaData[aiDisplay[i]][6]);
                }
                var nCells = nRow.getElementsByTagName('th');
                // nCells[4].innerHTML = parseFloat(gtotal);
                nCells[5].innerHTML = parseFloat(total);
                nCells[6].innerHTML = parseFloat(gtotal);
            },
            "aoColumns": [{
                "bSortable": false,
                "mRender": checkbox
            }, {"bSortable": true}, null, null, null, null, null, null, null, {"bSortable": false}]
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 1, filter_default_label: "[<?=lang('Business_Unit');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('Category');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('Zone');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('No_Of_Dealer');?>]", filter_type: "text", data: []},
            {column_number: 7, filter_default_label: "[<?=lang('Month');?>]", filter_type: "text", data: []},
            {column_number: 8, filter_default_label: "[<?=lang('Year');?>]", filter_type: "text", data: []},
        ], "footer");
    })
</script>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-folder-open"></i><?= lang('Sales_Officer_Achievement'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('list_results'); ?></p>
                <div class="table-responsive">
                    <table id="CategoryTable" class="table table-bordered table-hover table-striped reports-table">
                        <thead>
                        <tr>
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
                            <th><?= lang("Business_Unit"); ?></th>
                            <th><?= lang("Category"); ?></th>
                            <th><?= lang("Zone"); ?></th>
                            <th><?= lang("No_Of_Dealer"); ?></th>
                            <th><?= lang("Quantity"); ?></th>
                            <th><?= lang("Credit_Amount"); ?></th>
                            <th><?= lang("Month"); ?></th>
                            <th><?= lang("Year"); ?></th>
                            <th style="width:100px;"><?= lang("actions"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="9" class="dataTables_empty">
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
                            <th style="width:85px;"><?= lang("actions"); ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

