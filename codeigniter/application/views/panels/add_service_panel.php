<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-1">
                <?php echo lang('service'); ?>
            </div>
            <div class="col-md-1">
                <img id="select_software" data-toggle="tooltip" title="software برامج" height="50px" width="50px" class="service" src="<?php echo base_url() ?>/resources/images/software.png"/>
                <input name="software" type="hidden" value="0"/>
            </div>
            <div class="col-md-1">
                <img id="select_electronic" data-toggle="tooltip" title="electronic الكترونيات"  height="50px" width="50px" class="service" src="<?php echo base_url() ?>/resources/images/electronic.png"/>
                <input name="electronic" type="hidden" value="0"/>
            </div>
            <div class="col-md-1">
                <img id="select_external" data-toggle="tooltip" title="external صيانة خارجية"  height="50px" width="50px" class="service" src="<?php echo base_url() ?>/resources/images/external.png"/>
                <input name="external" type="hidden" value="0"/>
            </div>
            <div class="col-md-1">
                <img id="select_warranty" data-toggle="tooltip" title="warranty ضمان"  height="50px" width="50px" class="service" src="<?php echo base_url() ?>/resources/images/warranty.png"/>
                <input name="warranty" type="hidden" value="0"/>
            </div>
            <input name="services" type="hidden" value="0" />
        </div>
    </div>
    <div class="panel-body" id="add_machine_info">
        <div id="after_service" style="display: none">
            <div id="fault">
                <div id="warranty_area" style="border: none;display: none" class="form-group form-inline ">
                    <div class="row">
                        <br>
                        <div class="col-md-3">
                            <?php
                            echo lang('billDate');
                            $billDate = array
                                (
                                'name' => 'billDate',
                                'id' => 'billDate',
                                'type' => 'text',
                                'class' => 'form-control input-md-3 datepicker',
                                'placeholder' => lang('billDate'),
                                'style' => 'width: 70%',
                                'value' => set_value('billDate')
                            );
                            echo form_input($billDate);
                            ?>
                        </div>
                        <div class="col-md-3 ">
                            <?php
                            echo lang('billNumber');
                            $bill_num = array
                                (
                                'name' => 'billNumber',
                                'id' => 'billNumber',
                                'class' => 'form-control input-md-3 numeric_input',
                                'placeholder' => lang('billNumber'),
                                'style' => 'width: 70%',
                                'value' => set_value('billNumber')
                            );
                            echo form_input($bill_num);
                            ?>
                        </div>
                        <div class="col-md-3 ">
                            <?php
                            echo lang('warranty_period');
                            echo form_dropdown('warranty_period', array("1" => lang("year"), "2" => lang("two_years")), set_value('warranty_period'), 'style="width: auto" class="form-control input-md"');
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?php echo lang('time_remaining') ?>
                            <p id="time_remaining"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <br>
                    <div id="dates" style="display: none">
                        <div style="border: none; " class="form-group form-inline">
                            <?php echo lang('delivery_date'); ?>		
                            <label for="delivery_date" class="radio-inline">
                                <?php
                                $data = array(
                                    'name' => 'delivery_date',
                                    'class' => 'delivery_date form-control input-md-3',
                                    'id' => 'delivery_date',
                                    'value' => 1,
                                    'checked' => !empty($_POST['delivery_date']) and $_POST['delivery_date'] != false,
                                );
                                echo form_radio($data);
                                ?>
                            </label>
                            <?php
                            $options = array();
                            for ($i = 1; $i <= 100; $i++)
                                $options[$i] = $i;
                            ?>
                            <td class='input form-control input-md-3'><?php echo lang('during') . " " . form_dropdown('expected_delivery_date', $options, 1, 'style="width:15%" id="expected_delivery_date"') . " " . lang('work_day'); ?></td>
                            <?php
                            $data = array(
                                'name' => 'cost_estimation',
                                'id' => 'estimated_cost',
                                'class' => ' form-control input-md-3 numeric_input',
                                'placeholder' => lang('cost_estimation'),
                                'value' => set_value('cost_estimation'),
                                'style' => 'margin:14px; width:30%',
                                'data-index' => "$counter"
                            );
                            echo form_input($data);
                            $counter++;
                            ?>
                        </div>
                        <div style="border: none;" class="form-group form-inline">
                            <?php echo lang('examine_date'); ?>
                            <label for="examine_date" class="radio-inline">
                                <?php
                                $data = array(
                                    'name' => 'examine_date',
                                    'class' => 'examine_date form-control input-md-3',
                                    'id' => 'examine_date',
                                    'value' => 1,
                                    'checked' => !empty($_POST['examine_date']) and $_POST['examine_date'] != false,
                                );

                                echo form_radio($data);
                                ?>

                            </label>

                            <?php
                            $options = array();
                            for ($i = 1; $i <= 100; $i++)
                                $options[$i] = $i;
                            ?>
                            <td class='input form-control input-md-3'><?php echo lang('during') . " " . form_dropdown('expected_examine_date', $options, 1, 'style="width:15%"  " id="expected_examine_date"') . " " . lang('work_day'); ?></td>
                            <?php
                            $data = array(
                                'name' => 'examine_cost',
                                'id' => 'examine_cost',
                                'class' => ' form-control input-md-3 numeric_input',
                                'placeholder' => lang('examining_cost'),
                                'value' => set_value('examine_cost'),
                                'style' => 'margin:14px; width:30%',
                                'data-index' => "$counter"
                            );
                            echo form_input($data);
                            $counter++;
                            ?>
                        </div>

                    </div>
                    <div id="assign_tech">
                        <?php
                        echo lang('assign_to');
                        $opt = 'class="technician"';
                        echo form_dropdown('technician', $technicians, set_value('technician'), 'style="width: auto" class="form-control input-md" ');
                        ?>
                    </div>
                    <div id="visite_date" style="border: none;display: none" class="form-group form-inline">
                        <?php
                        echo lang('visite_date');
                        $date = array
                            (
                            'name' => 'visite_date',
                            'type' => 'text',
                            'class' => 'form-control input-md-3 datepicker',
                            'style' => 'width: 15%',
                            'value' => set_value('visite_date')
                        );
                        echo form_input($date);
                        $data = array(
                            'name' => 'visite_cost',
                            'id' => 'visite_cost',
                            'class' => ' form-control input-md-3 numeric_input',
                            'placeholder' => lang('visite_cost'),
                            'value' => set_value('visite_cost'),
                            'style' => 'margin:14px; width:20%',
                            'data-index' => "$counter"
                        );
                        echo form_input($data);
                        $counter++;
                        $data = array(
                            'name' => 'external_cost_estimation',
                            'id' => 'cost_estimation',
                            'class' => ' form-control input-md-3 numeric_input',
                            'placeholder' => lang('cost_estimation'),
                            'value' => set_value('external_cost_estimation'),
                            'style' => 'margin:14px; width:20%',
                            'data-index' => "$counter"
                        );
                        echo form_input($data);
                        $counter++;
//                        echo lang('assign_to');
//                        $opt = 'class="technician"';
//                        echo form_dropdown('external_technician', $technicians, set_value('external_technician'), 'style="width: auto" class="form-control input-md"');
                        ?>
                    </div>
                </div>
                <br>

            </div>
        </div>
        <br>

        <div id="Notes">
            <div class="col-md-6" id="fault_desc">
                <div class="col-md-1">
                    <?php echo lang('fault_description'); ?>
                </div>
                <div class="col-md-9">
                    <?php
                    $fault_description_textarea = array(
                        'name' => 'fault_description',
                        'rows' => "6",
                        'cols' => "35",
                        'value' => set_value('fault_description'),
                        'data-index' => "$counter",
                        'class' => 'form-control',
                        'required' => '',
                        'style' => 'width: 70%; min-width: 45%; max-width: 70%'
                    );
                    echo form_textarea($fault_description_textarea);
                    $counter++;
                    ?>
                </div>
                <div style="border: none; " id="formating" class="form-control col-md-3">
                    <?php echo lang('allow_losing_data'); ?>
                    <label for="allow_losing_data">		
                        <?php
                        $chk_box_data = array
                            (
                            'name' => 'allow_losing_data',
                            'id' => 'allow_losing_data',
                            'value' => 1,
                            'checked' => !empty($_POST['allow_losing_data']) and $_POST['allow_losing_data'] != false
                        );
                        echo form_checkbox($chk_box_data);
                        ?>
                    </label>
                </div>
                <div style="border: none !important;display: none" class="form-control">
                    <?php echo lang('external_repair'); ?>
                    <label for="external_repair">		
                        <?php
                        $data = array(
                            'name' => 'external_repair',
                            'class' => 'external_repair',
                            'value' => 1,
                            'checked' => !empty($_POST['external_repair']) and $_POST['external_repair'] != false,
                        );

                        echo form_checkbox($data);
                        ?>
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-1">
                    <?php echo lang('notes'); ?>
                </div>
                <div class="col-md-9">
                    <?php
                    $notes_textarea = array(
                        'name' => 'notes',
                        'rows' => "6",
                        'cols' => "35",
                        'value' => set_value('notes'),
                        'data-index' => "$counter",
                        'class' => 'form-control',
                        'placeholder' => lang('notes'),
                        'style' => 'width: 70%; min-width: 45%; max-width: 70%',
                    );
                    echo form_textarea($notes_textarea);
                    $counter++;
                    ?>
                </div>
            </div>
            <br>               
        </div>
    </div>
</div>
