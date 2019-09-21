<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .table td:first-child {
        font-weight: bold;
    }

    label {
        margin-right: 10px;
    }
</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-folder-open"></i><?= lang('group_permissions'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang("set_permissions"); ?></p>

                <?php if (!empty($p)) {
                    if ($p->group_id != 1) {

                        echo admin_form_open("system_settings/permissions/" . $id); ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped reports-table">

                                <thead>
                                <tr>
                                    <th colspan="6"
                                        class="text-center"><?php echo $group->description . ' ( ' . $group->name . ' ) ' . $this->lang->line("group_permissions"); ?></th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="text-center"><?= lang("module_name"); ?>
                                    </th>
                                    <th colspan="5" class="text-center"><?= lang("permissions"); ?></th>
                                </tr>
                                <tr>
                                    <th class="text-center"><?= lang("view"); ?></th>
                                    <th class="text-center"><?= lang("add"); ?></th>
                                    <th class="text-center"><?= lang("edit"); ?></th>
                                    <th class="text-center"><?= lang("delete"); ?></th>
                                    <th class="text-center"><?= lang("misc"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= lang("Calendar"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="calendar-index" <?php echo $p->{'calendar-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="calendar-add" <?php echo $p->{'calendar-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="calendar-edit" <?php echo $p->{'calendar-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="calendar-delete" <?php echo $p->{'calendar-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("Notifications"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="notifications-index" <?php echo $p->{'notifications-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="notifications-add" <?php echo $p->{'notifications-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="notifications-edit" <?php echo $p->{'notifications-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="notifications-delete" <?php echo $p->{'notifications-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("Sales_Target_Zones"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales_target-zones" <?php echo $p->{'sales_target-zones'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales_target-zone_add" <?php echo $p->{'sales_target-zone_add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales_target-delete_zone_target" <?php echo $p->{'sales_target-delete_zone_target'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("Sales_Target_Officers"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales_target-sales_officer" <?php echo $p->{'sales_target-sales_officer'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales_target-sales_officer_add" <?php echo $p->{'sales_target-sales_officer_add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales_target-delete_sales_officer_target" <?php echo $p->{'sales_target-delete_sales_officer_target'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                    </td>
                                </tr>


                                <tr>
                                    <td><?= lang("Sales_Achievement"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales_achievement-sales_officer" <?php echo $p->{'sales_achievement-sales_officer'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales_achievement-sales_officer_add" <?php echo $p->{'sales_achievement-sales_officer_add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales_achievement-delete_sales_officer" <?php echo $p->{'sales_achievement-delete_sales_officer'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                    </td>
                                </tr>




                                <tr>
                                    <td><?= lang("reports"); ?></td>
                                    <td colspan="5">
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="product_quantity_alerts" name="reports-sales_officer_zone" <?php echo $p->{'reports-sales_officer_zone'} ? "checked" : ''; ?>>
                                            <label for="reports_sales_officer_zone" class="padding05"><?= lang('Sales_Officer_Target') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="Product_expiry_alerts" name="reports-target_zone_wise" <?php echo $p->{'reports-target_zone_wise'} ? "checked" : ''; ?>>
                                            <label for="reports_target_zone_wise" class="padding05"><?= lang('Zone_Target_(Category Wise)') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="reports_target_zone"
                                            name="reports-target_zone" <?php echo $p->{'reports-target_zone'} ? "checked" : ''; ?>><label for="reports_target_zone" class="padding05"><?= lang('Zone_Target') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="reports_achievement_zone_wise"
                                                   name="reports-achievement_zone_wise" <?php echo $p->{'reports-achievement_zone_wise'} ? "checked" : ''; ?>><label for="reports-achievement_zone_wise" class="padding05"><?= lang('Achievement_Zone_(Category_Wise)') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="reports_achievement_zone"
                                                   name="reports-achievement_zone" <?php echo $p->{'reports-achievement_zone'} ? "checked" : ''; ?>><label for="reports-achievement_zone" class="padding05"><?= lang('Achievement_Zone_Wise') ?></label>
                                        </span>

                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="reports_achievement_sales_officer"
                                                   name="reports-achievement_sales_officer" <?php echo $p->{'reports-achievement_sales_officer'} ? "checked" : ''; ?>><label for="reports-achievement_sales_officer" class="padding05"><?= lang('Achievement_Sales_Officer') ?></label>
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("misc"); ?></td>
                                    <td colspan="5">
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="bulk_actions"
                                            name="bulk_actions" <?php echo $p->bulk_actions ? "checked" : ''; ?>>
                                            <label for="bulk_actions" class="padding05"><?= lang('bulk_actions') ?></label>
                                        </span>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><?=lang('update')?></button>
                        </div>
                        <?php echo form_close();
                    } else {
                        echo $this->lang->line("group_x_allowed");
                    }
                } else {
                    echo $this->lang->line("group_x_allowed");
                } ?>


            </div>
        </div>
    </div>
</div>
