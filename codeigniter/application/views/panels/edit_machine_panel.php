<div class="panel panel-default">
    <div class="panel-heading"><?php echo lang('machine_info'); ?></div>
    <div class="panel-body add_customer_info" name="add_customer_info" id="add_customer_info">
        <div class="row">
            <div class="col-md-6">

                <?php echo form_hidden('machine_id', $order_info['order_basic_info'][0]->machines_id); ?>
                <div class="row">
                    <div class="col-md-3">		
                        <?php echo lang('machine_type'); ?>
                    </div>
                    <div class="col-md-9">
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
                        <?php echo form_dropdown('brands', $brands, set_value('machine_type'), 'class="form-control input-md-3" id="brands_drop_down_list" style="width:50%" required');
                        ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <?php echo lang('models'); ?>
                    </div>
                    <div class="col-md-9">
                        <?php
                        $model_input_data = array(
                            'name' => 'models',
                            'id' => 'models',
                            'value' => $order_info['order_basic_info'][0]->model_name,
                            'class' => 'form-control input-md-3',
                            'placeholder' => lang('models'),
                            'style' => 'width: 50%',
                            'required' => '',
                            'data-index' => "$counter"
                        );
                        $counter++;
                        echo form_input($model_input_data);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3"><?php echo lang('serial_no'); ?></div>
                    <div class="col-md-9">
                        <?php
                        $serial_no_data = array(
                            'name' => 'serial_number',
                            'value' => $order_info['order_basic_info'][0]->serial_number,
                            'id' => 'serial_number',
                            'class' => 'form-control input-md-3',
                            'placeholder' => lang('serial_no'),
                            'required' => '',
                            'style' => 'width: 50%',
                            'data-index' => "$counter"
                        );
                        $counter++;
                        echo form_input($serial_no_data);
                        ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3"><?php echo lang('color'); ?></div>
                    <div class="col-md-9">
                        <?php
                        echo form_dropdown('colors', $colors, set_value('colors'), 'class="form-control input-md-3" id="brands_drop_down_list" style="width:50%" required');

                        if ($order_info['order_basic_info'][0]->image != "") {
                            ?>
                            <br><img width="200px" height="200px" src="<?php echo base_url() ?>resources/machines/<?php echo $order_info['order_basic_info'][0]->image ?>" /><br>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
