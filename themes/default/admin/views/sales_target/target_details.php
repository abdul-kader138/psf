<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-file"></i><?= lang("Ref_No") . ' : ' . $id; ?></h2>

    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <?php if (!empty($inv->return_purchase_ref) && $inv->return_id) {
                    echo '<div class="alert alert-info no-print"><p>' . lang("purchase_is_returned") . ': ' . $inv->return_purchase_ref;
                    echo ' <a data-target="#myModal2" data-toggle="modal" href="' . site_url('purchases/modal_view/' . $inv->return_id) . '"><i class="fa fa-external-link no-print"></i></a><br>';
                    echo '</p></div>';
                } ?>
                <div class="clearfix"></div>
                <div class="print-only col-xs-12">
                    <img src="<?= base_url() . 'assets/uploads/logos/' . $Settings->logo; ?>"
                         alt="<?= $Settings->site_name; ?>">
                </div>
                <div class="well well-sm" style="border-style: solid;background-color: #9faab7;">

                    <div class="col-xs-5 border-right">
                        <div class="col-xs-10">
                            <h2 class=""><?= $Settings->site_name; ?></h2>
                            <?= $warehouse->name ?>

                            <?php
                            echo '5,Mohakhali C/A' . "<br>";
                            echo 'Dhaka,Bangladesh' . "<br>";
                            echo lang("Phone") . ": " . '8802 9882107-08' . "<br>" . ($warehouse->email ? lang("email") . ": " . $warehouse->email : '');
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="col-xs-5">
                        <div class="col-xs-11">
                            <h2 class="">Business Unit : <?= $rows[0]->business_unit; ?></h2>
                            <?php
                            echo lang("Caterogy") . " : " . $rows[0]->nam . "<br />";
                            echo lang("Month") . " : " . $rows[0]->month . "<br />";
                            echo lang("Year") . " : " . $rows[0]->year . "<br />";
                            ?>
                        </div>
                        <div class="clearfix"></div>

                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped print-table order-table">
                        <thead>
                        <tr>
                            <th><?= lang("SL"); ?></th>
                            <th><?= lang("Zone_name"); ?></th>
                            <th><?= lang("UM"); ?></th>
                            <th><?= lang("Target_Quantity"); ?></th>
                            <th><?= lang("No_Of_Dealer"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $r = 1;
                        $col = 4;
                        $total = 0;
                        $dealers = 0;
                        foreach ($rows as $row):
                            $row_dues = 0;
                            ?>
                            <tr>
                                <td class="col-sm-1"
                                    style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                                <td class="col-sm-7" style="vertical-align:middle;">  <?= $row->zone_name; ?></td>
                                <td class="col-sm-1"
                                    style="vertical-align:middle;text-align: center">   <?= $row->um; ?></td>
                                <td class="col-sm-2"
                                    style="vertical-align:middle;text-align: center">   <?= $row->target_quantity; ?></td>
                                <td class="col-sm-1"
                                    style="vertical-align:middle;text-align: center">   <?= $row->dealer; ?></td>
                            </tr>
                            <?php
                            $total = $total + $row->target_quantity;
                            $dealers = $dealers + $row->dealer;
                            $r++;
                        endforeach;
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:right; font-weight:bold;"><?= lang("Total_Target_Quantity"); ?>
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;">
                                <?= $this->sma->formatMoney($total); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:right; font-weight:bold;"><?= lang("Total_Dealers"); ?>
                            </td>
                            <td style="text-align:right; font-weight:bold;">
                                <?= $dealers; ?>
                            </td>
                        </tr>

                        </tfoot>
                    </table>

                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="well well-sm">
                            <div>Created By : <?php echo $rows[0]->first_name . " " . $rows[0]->last_name ?></b></div>
                            <div>Created Date : <?php echo $rows[0]->created_date ?></b></div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
