<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('Update_Repair_status'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open_multipart("sales/repair_status/" . $inv->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= lang('Repair_Details'); ?>
                </div>
                <div class="panel-body">
                    <table class="table table-condensed table-striped table-borderless" style="margin-bottom:0;">
                        <tbody>
                        <tr>
                            <td><?= lang('reference_no'); ?></td>
                            <td><?= $inv->reference_no; ?></td>
                        </tr>
                        <tr>
                            <td><?= lang('biller'); ?></td>
                            <td><?= $inv->biller; ?></td>
                        </tr>
                        <tr>
                            <td><?= lang('customer'); ?></td>
                            <td><?= $inv->nam; ?></td>
                        </tr>
                        <tr>
                            <td><?= lang('Repair_Status'); ?></td>
                            <td><strong><?= lang($inv->type_detail); ?></strong></td>
                        </tr>
                        <tr>
                            <td><?= lang('payment_status'); ?></td>
                            <td><?= lang($inv->payment_status); ?></td>
                        </tr>
                        <tr>
                            <td><?= lang('Technician'); ?></td>
                            <td><?= ($user->first_name." ".$user->last_name); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if ($returned) { ?>
                <h4><?= lang('sale_x_action'); ?></h4>
            <?php } else { ?>
                <div class="form-group">
                    <?= lang('Repair_Status', 'Repair_Status'); ?>
                    <?php
                    $opts = array('In Progress' => lang('In Progress'),
                        'Waiting for Parts' => lang('Waiting for Parts'),
                        'Ready' => lang('Ready'),
                        'Return/Not Fixable' => lang('Return/Not Fixable'),
                        'Item Returned' => lang('Item Returned'),
                        'Delivered' => lang('Delivered'));
                    ?>
                    <?= form_dropdown('status', $opts, $inv->type_detail, 'class="form-control" id="status" required="required" style="width:100%;"'); ?>
                </div>

                <div class="form-group">
                    <?= lang("Repair_Note", "Repair_Note"); ?>
                    <?php echo form_textarea('repair_note', (isset($_POST['repair_note']) ? $_POST['repair_note'] : $this->sma->decode_html($inv->repair_note)), 'class="form-control" id="repair_note"'); ?>
                </div>
            <?php } ?>

        </div>
        <?php if ( ! $returned) { ?>
            <div class="modal-footer">
                <?php echo form_submit('update', lang('update'), 'class="btn btn-primary"'); ?>
            </div>
        <?php } ?>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
