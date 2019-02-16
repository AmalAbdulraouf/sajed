<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo lang('machine_info'); ?>
        <a style="cursor: pointer;margin: 10px;font-size: 16px" onclick="prev_machines()" id="prev-machines"></a>
    </div>
    <div class="panel-body" id="add_machine_info">
        <div class="row">
            <div class="col-md-6">
                <div class="row">		
                    <div class="col-md-3">
                        <?php echo lang('machine_type'); ?>
                    </div>
                    <div class="col-md-9">
                        <?php echo form_hidden('machine_id', set_value('machine_id')); ?>
                        <?php echo form_dropdown('machine_type', $machines_types, set_value('machine_type'), 'class="form-control input-md-3" style="width:50%" required');
                        ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <?php echo lang('brands'); ?>
                    </div>
                    <div class="col-md-9">
                        <?php echo form_dropdown('brands', $brands, set_value('brands'), 'class="form-control input-md-3" id="brands_drop_down_list" style="width:50%" required');
                        ?>
                    </div>
                </div>
                <br>
                <div class="row pull-half">
                    <div class="col-md-3">
                        <?php echo lang('models'); ?>
                    </div>
                    <div class="col-md-9">
                        <?php
                        $model_input_data = array(
                            'name' => 'models',
                            'id' => 'models',
                            'value' => set_value('models'),
                            'class' => 'form-control input-md',
                            'placeholder' => lang('models'),
                            'style' => 'width: 50%',
                            'required' =>'',
                            'data-index' => '5'
                        );

                        echo form_input($model_input_data);
                        ?>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <?php echo lang('serial_no'); ?>
                    </div>
                    <div class="col-md-9">
                        <?php
                        $serial_no_data = array(
                            'name' => 'serial_number',
                            'value' => set_value('serial_number'),
                            'id' => 'serial_number',
                            'class' => 'form-control input-md-3',
                            'placeholder' => lang('serial_no'),
                            'style' => 'width: 50%',
                            'required' => '',
                            'data-index' => '6'
                        );
                        echo form_input($serial_no_data);
                        ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <?php echo lang('color'); ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        echo form_dropdown('colors', $colors, set_value('colors'), 'class="form-control input-md-3" style="" required');
//                            $current_color = set_value('colors');
//                            if ($current_color == '')
//                                $current_color = lang('black');
//                            $color_input_data = array(
//                                'name' => 'colors',
//                                'value' => $current_color,
//                                'id' => 'colors',
//                                'data-index' => '7',
//                                'class' => 'form-control input-md-3',
//                                'placeholder' => lang('colors'),
//                                'style' => 'width: 50%',
//                                'autocomplete' => 'on'
//                            );
//
//                            echo form_input($color_input_data);
                        ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <?php echo lang('machine_img'); ?>
                    </div>
                    <div class="col-md-9">
                        <?php
                        $image_input_data = array(
                            'name' => 'userfile',
                            'id' => 'image',
                            'value' => set_value('userfile'),
                            'style' => 'width: 50%',
                            'type' => 'file'
                        );

                        echo form_input($image_input_data);
                        ?>
                        <?php echo form_hidden('image_name', set_value('image_name')); ?>
                        <img height="100px" width="100px" id="image_box" src="" style="display: none"/>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6" id="accessories">
                <div class="row">
                    <div class="col-md-3">
                        <?php echo lang('accessories'); ?>
                    </div>
                    <div class="col-md-9">
                        <?php
                        $counter = 8;

                        $attr = array(
                            'name' => 'accessories',
                            'value' => set_value('accessories'),
                            'class' => 'form-control input-md-3',
                            'placeholder' => $this->lang->line('accessories'),
                            'rows' => "6",
                            'cols' => "45",
                            'style' => 'width: 70%; min-width: 45%; max-width: 70%',
                            'data-index' => "$counter"
                        );
                        echo form_textarea($attr);
                        $counter++;
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <?php echo lang('faults'); ?>
                    </div>
                    <div class="col-md-9">
                        <?php
                        $faults_textarea = array(
                            'name' => 'faults',
                            'rows' => "6",
                            'cols' => "35",
                            'placeholder' => lang('faults'),
                            'value' => set_value('faults'),
                            'data-index' => "$counter",
                            'class' => 'form-control',
//                            'required' => '',
                            'style' => 'width: 70%; min-width: 45%; max-width: 70%'
                        );
                        echo form_textarea($faults_textarea);
                        $counter++;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
