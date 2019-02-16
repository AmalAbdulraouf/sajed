<div class="card">
    <h4 class="card-header"><?php echo lang('customer_info'); ?></h4>
    <div class="card-body add_customer_info" name="add_customer_info" id="add_customer_info">

        <div class="row">
            <input type="hidden" name="contact_rate" value="0"/>
            <div class="col-md-6">
                <input type="checkbox" name="company" onchange="select_company(this)"/>
                <label for="company"><?php echo $this->lang->line('company') ?></label>
            </div>
            <div class="col-md-3">
                <!--<div class="col-md-4">-->
                    <img rate="1" class="face" width="55px" height="50px" src="<?php echo base_url() ?>resources/images/sad.png" />
<!--                </div>
                <div class="col-md-4">-->
                    <img  rate="2" class="face" style="margin-top: -4px;" width="60px" height="55px" src="<?php echo base_url() ?>resources/images/normal.png" />
<!--                </div>
                <div class="col-md-4">-->
                    <img   rate="3" class="face" width="55px" height="50px" src="<?php echo base_url() ?>resources/images/happy.png" />
                <!--</div>-->
            </div>
        </div>
        <div class="row" id="company_info" style="display: none">
            <input type="hidden" name="company_used" value="0" />
            <div class="col-md-6  pull-right" >
                <?php
                $attr = array(
                    'name' => 'company_name',
                    'value' => set_value('company_name'),
                    'class' => 'form-control form-inline input-md-3',
                    'placeholder' => lang('company_name'),
                    'style' => 'width: 50%',
                    'id' => 'company_name',
                    'data-index' => '1'
                );
                echo form_input($attr);
                ?>
            </div>
            <div class="col-md-6  pull-right" >
                <?php
                $attr = array(
                    'name' => 'company_email',
                    'value' => set_value('company_email'),
                    'class' => 'form-control form-inline input-md-3',
                    'placeholder' => lang('email'),
                    'style' => 'width: 50%',
                    'id' => 'company_email',
                    'data-index' => '1'
                );
                echo form_input($attr);
                ?>
                <?php
                $attr = array(
                    'name' => 'company_id',
                    'value' => set_value('company_id'),
                    'class' => 'form-control form-inline input-md-3',
                    'placeholder' => lang('email'),
                    'style' => 'width: 50%',
                    'id' => 'company_id',
                    'type' => 'hidden',
                    'data-index' => '1'
                );
                echo form_input($attr);
                ?>
            </div>
            <br>
            <br>
        </div>

        <div class="row pull-half">


            <div class="col-md-6">
                <div class="row">

                    <?php
                    $attr = array(
                        'name' => 'phone',
                        'id' => 'phone',
                        'value' => set_value('phone'),
                        'class' => 'form-control input-md-3 numeric_input searchbox',
                        'placeholder' => lang('phone'),
                        'required' => '',
                        'style' => 'width: 50%; display:inline',
                        'data-index' => '2',
                        'onInput' => "checkLength()"
                    );
                    echo form_input($attr);
                    ?>
                    <font color="red">966 </font>	
                </div>
                <br>
                <div class="row">
                    <?php
                    $attr = array(
                        'name' => 'first_name',
                        'value' => set_value('first_name'),
                        'class' => 'form-control form-inline input-md-3',
                        'placeholder' => lang('full_name'),
                        'required' => '',
                        'style' => 'width: 50%',
                        'id' => 'full_name',
                        'data-index' => '1'
                    );
                    echo form_input($attr);
                    ?>
                </div>
                <br>
                <?php echo form_hidden('last_name', set_value('last_name')); ?>


                <div class="row">
                    <?php
                    $attr = array(
                        'name' => 'email',
                        'value' => set_value('email'),
                        'class' => 'form-control input-md-3',
                        'placeholder' => lang('email'),
                        'style' => 'width: 50%',
                        'data-index' => '3'
                    );
                    echo form_input($attr);
                    ?> 
                </div>
            </div>
            <div class="col-md-6">
                <?php
                $address_textarea = array(
                    'name' => 'address',
                    'rows' => "6",
                    'cols' => "45",
                    'class' => 'form-control',
                    'placeholder' => lang('address'),
                    'value' => set_value('address'),
                    'style' => 'width: 30%; min-width: 45%; max-width: 45%',
                    'data-index' => '4'
                );

                echo form_textarea($address_textarea)
                ?>
            </div>
            <br>
            <a id="not_delivered_machines" style="display: none" onclick="$('#customer_history').modal('show');"><?php echo $this->lang->line('not_delivered_machines') ?></a>
        </div>
    </div>
    <div class="panel-body open_customer_info" name="open_customer_info" id="open_customer_info">
        <button id="add_customer" value="add_customer" type="button" class="btn btn-primary"><?php echo lang('or_add_a_new_customer'); ?></button>
        <br>
        <input  type="text" class="search form-control searchbox" id="searchbox" />
        <div id="display"></div>
        <div id = "selected_contact" ></div>
        <div id = "select_contact" >
            <button style="display: none" id="change_customer" value="Change" type="button" class="btn"><?php echo lang('change'); ?></button>
        </div>
    </div>
</div>