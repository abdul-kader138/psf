<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('update_status'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open_multipart("farmer_analysis/update_status/" . $analysis->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= lang('Verify_Visit'); ?>
                </div>
                <div class="panel-body">
                    <table class="table table-condensed table-striped table-borderless" style="margin-bottom:0;">
                        <tbody>
                            <tr>
                                <td><?= lang('Farmer_Name'); ?></td>
                                <td><?= $analysis->name; ?></td>
                            </tr>
                            <tr>
                                <td><?= lang('Farmer_Mobile'); ?></td>
                                <td><?= $analysis->mobile_no; ?></td>
                            </tr>
                            <tr>
                                <td><?= lang('Type_Of_Bird'); ?></td>
                                <td><?= $analysis->type_of_bird; ?></td>
                            </tr>
                            <tr>
                                <td><?= lang('Visit_Date'); ?></td>
                                <td><strong><?= $analysis->visit_date; ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if ($returned) { ?>
                <h4><?= lang('sale_x_action'); ?></h4>
            <?php } else { ?>
            <div class="form-group">
                <?= lang('status', 'status'); ?>
                <?php
                $opts = array('1' => lang('Verified'), '0' => lang('Not Verified'));
                ?>
                <?= form_dropdown('status', $opts, $analysis->verified_status, 'class="form-control" id="status" required="required" style="width:100%;"'); ?>
            </div>

            <div class="form-group">
                <?= lang("note", "note"); ?>
                <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : $this->sma->decode_html($analysis->verified_note)), 'class="form-control" id="note"'); ?>
            </div>
            <?php } ?>

        </div>
        <?php if ($analysis->verified_status ==0) { ?>
        <div class="modal-footer">
            <?php echo form_submit('update', lang('update'), 'class="btn btn-primary"'); ?>
        </div>
        <?php } ?>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
