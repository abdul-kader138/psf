<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
            <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>
            <h2 class="modal-title" id="myModalLabel" style="color: #00A0C6; text-align:center">Visitor :  <?= $user->first_name; ?> </h2>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-12">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table">

                            <tbody>
                            <tr>
                                <td>Farmer Name :</td>
                                <td><?=$analysis->name?></td>
                                <td>|</td>
                                <td>Visit Date :</td>
                                <td><?=$this->sma->hrsd($analysis->visit_date)?></td>
                            </tr>
                            <tr>
                                <td>Zone :</td>
                                <td><?=$zone->name?></td>
                                <td>|</td>
                                <td>Area :</td>
                                <td><?=$analysis->area?></td>
                            </tr>
                            <tr>
                                <td>Hatch Date :</td>
                                <td><?=$this->sma->hrsd($analysis->hatch_date)?></td>
                                <td>|</td>
                                <td>Age :</td>
                                <td><?=$analysis->age?> (<?=$analysis->age_type?>)</td>
                            </tr>
                            <tr>
                                <td>Initial Bird :</td>
                                <td><?=$analysis->initial_qty?></td>
                                <td>|</td>
                                <td>Hatchery :</td>
                                <td><?=$analysis->hatchery?></td>
                            </tr>
                            <tr>
                                <td>Mortality :</td>
                                <td><?=$analysis->mortality?></td>
                                <td>|</td>
                                <td>Mortality(%) :</td>
                                <td><?=$analysis->mortality_per?></td>
                            </tr>
                            <tr>
                                <td>Feed Intake :</td>
                                <td><?=$analysis->feed_intake?></td>
                                <td>|</td>
                                <td>Body Weight :</td>
                                <td><?=$analysis->body_weight?></td>
                            </tr>
                            <tr>
                                <td>FCR :</td>
                                <td><?=$analysis->fcr?></td>
                                <td>|</td>
                                <td>Breed</td>
                                <td><?=$analysis->breed?></td>
                            </tr>
                            <tr>
                                <td>Feed Brand :</td>
                                <td><?=$analysis->feed_brand?></td>
                                <td>|</td>
                                <td>Feed Mill :</td>
                                <td><?=$analysis->feed_mill?></td>
                            </tr>
                            <tr>
                                <td>Egg Production :</td>
                                <td><?=$analysis->egg_production?></td>
                                <td>|</td>
                                <td>Type Of Bird :</td>
                                <td><?=$analysis->type_of_bird?></td>
                            </tr>
                            <tr>
                                <td>Farmer Mobile No :</td>
                                <td><?=$analysis->mobile_no?></td>
                                <td>|</td>
                                <td>Attched File :</td>
                                <td>
                                    <a href="<?= base_url("/assets/uploads/farmer_document/" . $analysis->file_path); ?>"
                                       download><?= $analysis->file_path; ?></a></td>
                            </tr>
                            <tr>
                                <td>Verified Status :</td>
                                <td><?=($analysis->verified_status==1 ?'Verified':'Not Verified')?></td>
                                <td>|</td>
                                <td>Comment (Verified Status ) :</td>
                                <td><?=($this->sma->decode_html($analysis->verified_note))?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
                <div class="clearfix"></div>
                <?php if($analysis->comment){ ?>
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <th>Comment</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?= $analysis->comment;?></td>
                            </tr>
                            </tbody>
                        </table></div>
                </div>
                <div class="clearfix"></div>
                <?php }?>

                <div class="col-xs-12">

                    <?= $product->details ? '<div class="panel panel-success"><div class="panel-heading">' . lang('product_details_for_invoice') . '</div><div class="panel-body">' . $product->details . '</div></div>' : ''; ?>
                    <?= $product->product_details ? '<div class="panel panel-primary"><div class="panel-heading">' . lang('product_details') . '</div><div class="panel-body">' . $product->product_details . '</div></div>' : ''; ?>

                </div>
            </div>
                <div class="buttons">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            <a href="#" class="tip btn btn-danger bpo" title="<b><?= lang("Delete_Document") ?></b>"
                               data-content="<div style='width:150px;'><p><?= lang('r_u_sure') ?></p><a class='btn btn-danger' href='<?= site_url('document/delete/' . $document->id) ?>'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button></div>"
                               data-html="true" data-placement="top">
                                <i class="fa fa-trash-o"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('delete') ?></span>
                            </a>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('.tip').tooltip();
                    });
                </script>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.change_img').click(function(event) {
            event.preventDefault();
            var img_src = $(this).attr('href');
            $('#pr-image').attr('src', img_src);
            return false;
        });
    });
</script>
