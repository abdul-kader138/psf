<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('Sales_Officer_Target_Upload'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                echo admin_form_open_multipart("sales_target/sales_officer_add", $attrib);

                ?>
                <div class="row">
                    <div class="col-lg-12">
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
                                <?= lang("Category_Name", "Category_Name"); ?>
                                <?php
                                $b2[""] = "";
                                foreach ($categories as $zone) {
                                    $b2[$zone->id] = $zone->name;
                                }
                                echo form_dropdown('category_id', $b2, (isset($_POST['category_id']) ? $_POST['category_id'] : ''), ' data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("Category_Name") . '" required="required" id="category_id" class="form-control input-tip select" style="width:100%;"');
                                ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Zone_Name", "Zone_Name"); ?>
                                <?php
                                $b3[""] = "";
                                foreach ($zones as $zone) {
                                    $b3[$zone->id] = $zone->name;
                                }
                                echo form_dropdown('zone_id', $b3, (isset($_POST['zone_id']) ? $_POST['zone_id'] : ''), ' data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("Zone_Name") . '" required="required" id="zone_id" class="form-control input-tip select" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("UM", "UM"); ?>
                                <?php
                                $b4[""] = "";
                                foreach ($units as $unit) {
                                    $b4[$unit->name] = $unit->name;
                                }
                                echo form_dropdown('um', $b4, (isset($_POST['um']) ? $_POST['um'] : ''), ' data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("UM") . '" required="required" id="um" class="form-control input-tip select" style="width:100%;"');
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
                                $opt = array( 2018 => "2018", 2019 => "2019", 2020 => "2020", 2021 => "2021", 2022 => "2022", 2023 => "2023", 2024 => "2024", 2025 => "2025", 2026 => "2026", 2027 => "2027", 2028 => "2028", 2029 => "2029", 2030 => "2030");
                                echo form_dropdown('year', $opt, (isset($_POST['year']) ? $_POST['year'] : ''), 'id="year" required="required" class="form-control input-tip select" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="clearfix"></div>
                        <div class="well well-sm">
                            <a href="<?php echo $this->config->base_url(); ?>assets/csv/sample_sales_officer_target.csv"
                               class="btn btn-primary pull-right"><i class="fa fa-download"></i> Download Sample
                                File</a>
                            <span class="text-warning"><?php echo $this->lang->line("csv1"); ?></span><br>
                            <?php echo $this->lang->line("csv2"); ?> <span
                                class="text-info">( <?= lang("Employee_Code") . ', '. lang("Target_Quantity"). ', '. lang("No_Of_Visit"); ?>
                                )</span> <?php echo $this->lang->line("csv3"); ?><br>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= lang("csv_file", "csv_file") ?>
                            <input id="csv_file" type="file" data-browse-label="<?= lang('browse'); ?>" name="userfile"
                                   required="required"
                                   data-show-upload="false" data-show-preview="false" class="form-control file">
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-12">
                        <div
                            class="fprom-group"><?php echo form_submit('add_sale', $this->lang->line("submit"), 'id="add_sale" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                            <button type="button" class="btn btn-danger" id="reset"><?= lang('reset') ?></div>
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>

