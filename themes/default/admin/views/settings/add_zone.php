<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('Add_Zone'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open_multipart("system_settings/add_zone", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
            <div class="form-group">
                <?= lang("Business_Unit", "Business_Unit"); ?>
                <?php
                $b4[""] = lang('select') . ' ' . lang('package');
                $opt = array("Poultry" => "Poultry", "Feed" => "Feed", "Paragon Agro" => "Paragon Agro");
                echo form_dropdown('bu', $opt, (isset($_POST['bu']) ? $_POST['bu'] : ''), 'id="bu"  required="required" class="form-control input-tip select" style="width:100%;"');
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
                <?= lang('Latitude', 'Latitude'); ?>
                <?php $att = array('name' => 'latitude', 'type' => 'test');?>
                <?= form_input($att, set_value('latitude'), 'class="form-control tip" id="latitude" required="required"'); ?>
            </div>
            <div class="form-group all">
                <?= lang('Longitude', 'Longitude'); ?>
                <?php $att = array('name' => 'longitude', 'type' => 'test');?>
                <?= form_input($att, set_value('longitude'), 'class="form-control tip" id="longitude" required="required"'); ?>
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


            <div class="form-group">
                <?= lang("Parent_Zone", "parent") ?>
                <?php
                $cat[''] = lang('select').' '.lang('parent_zone');
                foreach ($zones as $pcat) {
                    $cat[$pcat->id] = $pcat->name;
                }
                echo form_dropdown('parent', $cat, (isset($_POST['parent']) ? $_POST['parent'] : ''), 'class="form-control select" id="parent" style="width:100%"')
                ?>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_zone', lang('Add_Zone'), 'class="btn btn-primary"'); ?>
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
