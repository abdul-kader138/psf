<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('Add'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                echo admin_form_open_multipart("farmer_analysis/add", $attrib);
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Type_Of_Bird", "Type_Of_Bird"); ?>
                                <?php
                                $opt = array('Broiler' => "Broiler", "Layer" => "Layer", "Sonali" => "Sonali");
                                echo form_dropdown('type_of_bird', $opt, (isset($_POST['type_of_bird']) ? $_POST['type_of_bird'] : ''), 'id="type_of_bird" required="required" class="form-control input-tip select" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Zone", "Zone"); ?>
                                <?php
                                //                                $bl[''] = "";
                                foreach ($zones as $zone) {
                                    $bl[$zone->id] = $zone->name;
                                }
                                echo form_dropdown('zone_id', $bl, (isset($_POST['zone_id']) ? $_POST['zone_id'] : ''), 'id="zone_id" data-placeholder="" required class="form-control input-tip select" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Visit_Date", "Visit_Date") . '<b> *</b>'; ?>
                                <?php echo form_input('visit_date', (isset($_POST['visit_date']) ? $_POST['visit_date'] : ""), 'class="form-control input-tip date" readonly="readonly" id="visit_date" required="required"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Farmer_Name", "Farmer_Name") . '<b> *</b>'; ?>
                                <?php echo form_input('name', (isset($_POST['name']) ? $_POST['name'] : ""), 'class="form-control input-tip" id="name" required="required"'); ?>
                            </div>
                        </div>


                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Mobile_No", "Mobile_No") . '<b> *</b>'; ?>
                                <?php echo form_input('mobile_no', (isset($_POST['mobile_no']) ? $_POST['mobile_no'] : ""), 'class="form-control input-tip" id="mobile_no" required="required"'); ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Area", "Area") . '<b> *</b>'; ?>
                                <?php echo form_input('area', (isset($_POST['area']) ? $_POST['area'] : ""), 'class="form-control input-tip" id="area" required="required"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Hatch_Date", "Hatch_Date") . '<b> *</b>'; ?>
                                <?php echo form_input('hatch_date', (isset($_POST['hatch_date']) ? $_POST['hatch_date'] : ""), 'class="form-control input-tip date" readonly="readonly" id="hatch_date" required="required"'); ?>
                            </div>
                        </div>


                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Initial_Bird_Qty", "Initial_Bird_Qty") . '<b> *</b>'; ?>
                                <?php
                                $att = array('name' => 'initial_qty', 'type' => 'text');
                                echo form_input($att, (isset($_POST['initial_qty']) ? $_POST['initial_qty'] : ""), 'class="form-control input-tip" required="required" id="initial_qty" pattern="^\d*(\.\d{0,2})?$"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="age_type" id="age_type"> Age (Day)*</label>
                                <?php
                                $att = array('name' => 'age', 'type' => 'text');
                                echo form_input($att, (isset($_POST['age']) ? $_POST['age'] : ""), 'class="form-control input-tip" required="required" id="age" pattern="^\d*(\.\d{0,2})?$"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Name_Of_Hatchery", "Name_Of_Hatchery") . '<b> *</b>'; ?>
                                <?php echo form_input('hatchery', (isset($_POST['hatchery']) ? $_POST['hatchery'] : ""), 'class="form-control input-tip" id="hatchery" required="required"'); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Name_Of_Breed", "Name_Of_Breed") . '<b> *</b>'; ?>
                                <?php echo form_input('breed', (isset($_POST['breed']) ? $_POST['breed'] : ""), 'class="form-control input-tip" id="breed" required="required"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Mortality", "Mortality") . '<b> *</b>'; ?>
                                <?php
                                $att = array('name' => 'mortality', 'type' => 'number', 'min'=>'0');
                                echo form_input($att, (isset($_POST['mortality']) ? $_POST['mortality'] : ""), 'class="form-control input-tip" required="required" id="mortality" pattern="^\d*(\.\d{0,2})?$"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Feed_Intake_(gm)", "Feed_Intake_(gm)") . '<b> *</b>'; ?>
                                <?php
                                $att = array('name' => 'feed_intake', 'type' => 'number', 'min'=>'1');
                                echo form_input($att, (isset($_POST['feed_intake']) ? $_POST['feed_intake'] : ""), 'class="form-control input-tip" required="required" id="feed_intake" pattern="^\d*(\.\d{0,2})?$"'); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Body_Weight_(gm)", "Body_Weight_(gm)") . '<b> *</b>'; ?>
                                <?php
                                $att = array('name' => 'body_weight', 'type' => 'number', 'min'=>'1');
                                echo form_input($att, (isset($_POST['body_weight']) ? $_POST['body_weight'] : ""), 'class="form-control input-tip" required="required" id="body_weight" pattern="^\d*(\.\d{0,2})?$"'); ?>
                            </div>
                        </div>

                        <div class="col-md-4" id="fcr_div">
                            <div class="form-group">
                                <?= lang("FCR", "FCR") . '<b> *</b>'; ?>
                                <?php
                                $att = array('name' => 'fcr', 'type' => 'text');
                                echo form_input($att, (isset($_POST['fcr']) ? $_POST['fcr'] : ""), 'class="form-control input-tip" required="required" id="fcr" pattern="^\d*(\.\d{0,2})?$"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Feed_Mill", "Feed_Mill") . '<b> *</b>'; ?>
                                <?php echo form_input('feed_mill', (isset($_POST['feed_mill']) ? $_POST['feed_mill'] : ""), 'class="form-control input-tip" id="feed_mill" required="required"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Feed_brand", "Feed_brand") . '<b> *</b>'; ?>
                                <?php echo form_input('feed_brand', (isset($_POST['feed_brand']) ? $_POST['feed_brand'] : ""), 'class="form-control input-tip" id="feed_brand" required="required"'); ?>
                            </div>
                        </div>


                        <div class="clearfix"></div>
                        <div class="col-md-4" id="egg_production_div">
                            <div class="form-group">
                                <?= lang("Egg_Production", "Egg_Production") . '<b> *</b>'; ?>
                                <?php
                                $att = array('name' => 'egg_production', 'type' => 'text');
                                echo form_input($att, (isset($_POST['egg_production']) ? $_POST['egg_production'] : ""), 'class="form-control input-tip" required="required" id="egg_production" pattern="^\d*(\.\d{0,2})?$"'); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <?= lang("File_Upload", "File_Upload"); ?>
                                    <input type="file" data-browse-label="
                        <?= lang('browse'); ?>" name="file_path" id="file_path"
                                           data-show-upload="false" data-show-preview="false" accept="image/*"
                                           class="form-control file"/>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row" id="bt">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= lang("Comments", "Comments")."<b> *</b>"; ?>
                                        <?php echo form_textarea('comment', (isset($_POST['comment']) ? $_POST['comment'] : ""), 'class="form-control" required="required" id="comment" style="margin-top: 10px; height: 100px;"'); ?>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-12">
                            <div
                                    class="fprom-group"><?php echo form_submit('add', $this->lang->line("submit"), 'id="add" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" class="btn btn-danger" id="reset"><?= lang('reset') ?></div>
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>


<script type="application/javascript">
    $(document).ready(function () {
        $('#egg_production_div').hide();
        $('#fcr_div').show();
        $("#fcr").prop('required', true);
        $("#egg_production").prop('required', false);
        $('#type_of_bird').change(function () {
            var type = $(this).val();
            console.log(type);
            if (type == 'Layer') {
                $('#egg_production_div').show();
                $("#egg_production").prop('required', true);
                $("#fcr").prop('required', false);
                $('#fcr_div').hide();
                $('#age_type').text('Age (Weeks) *');
            } else {
                $("#egg_production").prop('required', false);
                $('#egg_production_div').hide();
                $('#fcr_div').show();
                $("#fcr").prop('required', true);
                $('#age_type').text('Age (Days) *');
            }
        });
    })

</script>
