<div class="panel panel-default">
    <div class="panel-heading"><?php echo lang('customer_info'); ?></div>
    <div class="panel-body add_customer_info" name="add_customer_info" id="add_customer_info">
        <div class="add_customer_info " name="add_customer_info" id="add_customer_info">
            <?php if ($order_info['order_basic_info'][0]->company != "0") { ?>
                <div class="row">
                    <?php if ($order_info['order_basic_info'][0]->company_name != "") { ?>
                        <div class="col-md-3"><h4><?php echo lang('company_name'); ?></h4></div>
                        <div class="col-md-9">
                            <?php echo $order_info['order_basic_info'][0]->company_name;
                            ?>
                        </div>
                    <?php } ?>
                </div><br>
            <?php } ?> 
            <div class="row">
                <div class="col-md-6">
                    <div class="row mach">
                        <?php
                        $counter = 1;
                        echo form_hidden('customer_id', $order_info['order_basic_info'][0]->customer_id);
                        ?>
                        <div class="col-md-3"><?php echo lang('full_name'); ?></div>
                        <div class="col-md-9">
                            <?php
                            $attr = array(
                                'name' => 'first_name',
                                'value' => $order_info['order_basic_info'][0]->contact_fname,
                                'class' => 'form-control input-md-3',
                                'placeholder' => lang('full_name'),
                                'required' => '',
                                'style' => 'width: 50%;display:inline',
                                'data-index' => "$counter"
                            );
                            $counter++;
                            echo form_input($attr);
                            ?>
                        </div>
                    </div>
                    <br>
                    <div class="row mach">
                        <?php echo form_hidden('last_name', $order_info['order_basic_info'][0]->contact_lname); ?>

                        <div class="col-md-3"><?php echo lang('phone'); ?></div>
                        <div class="col-md-9">
                            <?php
                            $attr = array(
                                'name' => 'phone',
                                'id' => 'phone',
                                'required' => '',
                                'value' => $order_info['order_basic_info'][0]->contact_phone,
                                'class' => 'form-control input-md-3 numeric_input',
                                'placeholder' => lang('phone'),
                                'style' => 'width: 50%;display:inline',
                                'data-index' => "$counter",
                                'onInput' => "checkLength()"
                            );
                            $counter++;
                            echo form_input($attr);
                            ?>
                            <font color="red">966 </font>
                        </div>
                    </div>
                    <br>
                    <div class="row mach">
                        <div class="col-md-3"><?php echo lang('email'); ?></div>
                        <div class="col-md-9">
                            <?php
                            $attr = array(
                                'name' => 'email',
                                'value' => $order_info['order_basic_info'][0]->contact_email,
                                'data-index' => "$counter",
                                'class' => 'form-control input-md-3',
                                'placeholder' => lang('email'),
                                'style' => 'width: 50%;display:inline'
                            );
                            $counter++;
                            echo form_input($attr);
                            ?> 
                        </div>
                    </div>
                    <br>
                    <div class="row mach">
                        <div class="col-md-3"><?php echo lang('customer_points'); ?></div>
                        <div class="col-md-9">
                            <?php
                            $attr = array(
                                'name' => 'customer_points',
                                'value' => $order_info['order_basic_info'][0]->customer_points,
                                'data-index' => "$counter",
                                'class' => 'form-control input-md-3',
                                'placeholder' => lang('customer_points'),
                                'style' => 'width: 50%;display:inline'
                            );
                            $counter++;
                            echo form_input($attr);
                            ?> 
                        </div>
                    </div>
                    <br>
                    <div class="row mach">
                        <div class="col-md-3"><?php echo lang('customer_discount'); ?></div>
                        <div class="col-md-9">
                            <?php
                            $attr = array(
                                'name' => 'customer_discount',
                                'value' => $order_info['order_basic_info'][0]->contact_discount,
                                'data-index' => "$counter",
                                'class' => 'form-control input-md-3',
                                'placeholder' => lang('customer_discount'),
                                'style' => 'width: 50%;display:inline'
                            );
                            $counter++;
                            echo form_input($attr);
                            ?> %
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php echo lang('address'); ?>
                    <?php
                    $address_textarea = array(
                        'name' => 'address',
                        'rows' => "5",
                        'cols' => "45",
                        'class' => 'form-control',
                        'placeholder' => lang('address'),
                        'style' => 'width: 50%; min-width: 50%; max-width: 50%',
                        'value' => $order_info['order_basic_info'][0]->contact_address,
                        'data-index' => "$counter"
                    );
                    $counter++;
                    echo form_textarea($address_textarea)
                    ?>
                </div>
                <div style="margin-top: 40px" class="col-md-3">
                    <input type="hidden" name="contact_rate" value="<?php echo $order_info['order_basic_info'][0]->contact_rate ?>"/>
                    <div class="col-md-4">
                        <img rate="1"
                             class="<?php echo ($order_info['order_basic_info'][0]->contact_rate == 1) ? 'selected-face' : 'face' ?>" 
                             width="55px" height="50px" src="<?php echo base_url() ?>resources/images/sad.png" />
                    </div>
                    <div class="col-md-4">
                        <img  rate="2" class="<?php echo ($order_info['order_basic_info'][0]->contact_rate == 2) ? 'selected-face' : 'face' ?>" style="margin-top: -4px;" width="60px" height="55px" src="<?php echo base_url() ?>resources/images/normal.png" />
                    </div>
                    <div class="col-md-4">
                        <img   rate="3" class="<?php echo ($order_info['order_basic_info'][0]->contact_rate == 3) ? 'selected-face' : 'face' ?>" width="55px" height="50px" src="<?php echo base_url() ?>resources/images/happy.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
