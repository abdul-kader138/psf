<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('Add_Sales_Officer'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open_multipart("system_settings/add_sales_officer", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>


            <div class="form-group">
                <?= lang("Sales_Officer", "Sales_Officer") ?>
                <?php
                $cat1[''] = lang('select').' '.lang('Sales_Officer');
                foreach ($users as $user) {
                    $cat1[$user->id] = $user->first_name.' '.$user->last_name;
                }
                echo form_dropdown('user_id', $cat1, (isset($_POST['user_id']) ? $_POST['user_id'] : ''), 'class="form-control select" id="user_id" style="width:100%"')
                ?>
            </div>


            <div class="form-group">
                <?= lang("Zones", "Zones") ?>
                <?php
                $cat[''] = lang('select').' '.lang('Zone');
                foreach ($zones as $pcat) {
                    $cat[$pcat->id] = $pcat->name;
                }
                echo form_dropdown('zone_id', $cat, (isset($_POST['zone_id']) ? $_POST['zone_id'] : ''), 'class="form-control select" id="zone_id" style="width:100%"')
                ?>
            </div>

            <div class="form-group">
                <?= lang('Code', 'code'); ?>
                <?= form_input('code', set_value('code'), 'class="form-control" id="code" required="required"'); ?>
            </div>

            <div class="form-group">
                <?= lang('Name', 'name'); ?>
                <?= form_input('name', set_value('name'), 'class="form-control gen_slug" id="name" required="required"'); ?>
            </div>

            <div class="form-group all">
                <?= lang('No_Of_Dealer', 'No_Of_Dealer'); ?>
                <?php $att = array('name' => 'dealer', 'type' => 'number');?>
                <?= form_input($att, set_value('dealer'), 'class="form-control tip" id="dealer" required="required"'); ?>
            </div>

            <div class="form-group all">
                <?= lang('description', 'description'); ?>
                <?= form_input('description', set_value('description'), 'class="form-control tip" id="description" required="required"'); ?>
            </div>


        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_sales_officer', lang('Add_Sales_Officer'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?= $modal_js ?>
<script>
    $(document).ready(function() {
        $('.gen_slug').change(function(e) {
            getSlug($(this).val(), 'category');
        });
    });
</script>
