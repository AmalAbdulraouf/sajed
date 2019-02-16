<div  class="modal" id="temporary_device_modal" >
    <div class="modal-dialog" style="width: 80%;direction: rtl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >&times</button>
                <h4><?php echo lang('machine_info'); ?></h4>
            </div>
            <div class="modal-body" >
                <div id="loader" style="display: none" class="loader">Loading...</div>
                <div id="body" style="direction: rtl" class="row  pull-half">
                    <div  class="col">
                        <form id="add_category_form">
                            <div class="error"  id="temporary_device_form_errors"></div>
                            <br>
                            <div class="row" style="direction: rtl">		
                                <div class="col-md-1  pull-right">
                                    <?php echo lang('machine_type'); ?>
                                </div>
                                <div class="col-md-2  pull-right">
                                    <?php echo form_hidden('machine_id', set_value('machine_id')); ?>
                                    <?php echo form_dropdown('machine_type', $machines_types, set_value('machine_type'), 'class="form-control input-md-3" style="width:100%"');
                                    ?>
                                </div>


                                <div class="col-md-1  pull-right">
                                    <?php echo lang('brands'); ?>
                                </div>
                                <div class="col-md-2  pull-right">
                                    <?php echo form_dropdown('brands', $brands, '0', 'class="form-control input-md-3" id="brands_drop_down_list" style="width:100%"');
                                    ?>
                                </div>

                                <div class="col-md-1  pull-right">
                                    <?php echo lang('models'); ?>
                                </div>
                                <div class="col-md-2  pull-right">
                                    <?php
                                    $model_input_data = array(
                                        'name' => 'models',
                                        'id' => 'models',
                                        'value' => set_value('models'),
                                        'class' => 'form-control',
                                        'placeholder' => lang('models'),
                                        'style' => 'width: 100%',
                                        'data-index' => '5'
                                    );

                                    echo form_input($model_input_data);
                                    ?>
                                </div>

                                <div class="col-md-1  pull-right">
                                    <?php echo lang('serial_no'); ?>
                                </div>

                                <div class="col-md-2  pull-right">

                                    <?php
                                    $serial_no_data = array(
                                        'name' => 'serial_number',
                                        'value' => set_value('serial_number'),
                                        'id' => 'serial_number',
                                        'class' => 'form-control',
                                        'placeholder' => lang('serial_no'),
                                        'style' => 'width:100%',
                                        'data-index' => '6'
                                    );
                                    echo form_input($serial_no_data);
                                    ?>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-1  pull-right">
                                    <?php echo lang('color'); ?>
                                </div>
                                <div class="col-md-2  pull-right">
                                    <?php
                                    echo form_dropdown('colors', $colors, set_value('colors'), 'class="form-control input-md-3" style="width:100%"');
                                    ?>
                                </div>

                                <div class="col-md-1  pull-right">
                                    <?php echo lang('accessories'); ?>
                                </div>
                                <div class="col-md-2  pull-right">
                                    <div id="accessories">
                                        <?php
                                        $counter = 8;

                                        $attr = array(
                                            'name' => 'accessories',
                                            'value' => set_value('accessories'),
                                            'class' => 'form-control input-md-3',
                                            'placeholder' => $this->lang->line('accessories'),
                                            'rows' => "6",
                                            'cols' => "45",
                                            'style' => 'width: 100%; max-width: 100%',
                                            'data-index' => "$counter"
                                        );
                                        echo form_textarea($attr);

                                        $counter++;
                                        ?>

                                        <?php ?>
                                    </div>
                                </div>
                                <div class="col-md-1  pull-right">
                                    <?php echo lang('faults'); ?>
                                </div>
                                <div class="col-md-2   pull-right">
                                    <?php
                                    $faults_textarea = array(
                                        'name' => 'faults',
                                        'rows' => "6",
                                        'cols' => "35",
                                        'value' => set_value('faults'),
                                        'placeholder' => lang('faults'),
                                        'data-index' => "$counter",
                                        'class' => 'form-control',
                                        'style' => 'width:100%; min-width: 45%; max-width: 100%'
                                    );
                                    echo form_textarea($faults_textarea);
                                    $counter++;
                                    ?>
                                </div>
                            </div>
                            <br>
                            <input class="btn btn-style" type="submit" style="float: left;width: auto;height: auto" 
                                   id="save_temporary_device"
                                   name="add" value="<?php echo lang('save') ?>" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div  class="modal" id="place_modal" >
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >&times</button>
            </div>
            <div class="modal-body" >
                <div id="loader" style="display: none" class="loader">Loading...</div>
                <div id="body" style="" class="row">
                    <div  class="col">
                        <form id="add_category_form">
                            <div class="error"></div>
                          
                            <input id="cancel_reason" class="form-control" type="text"  placeholder="<?php echo lang('cancel_reason')?>"/>
                            <br>
                            <label for="name" style="width: 25%;">
                                <?php echo lang('place') ?> :
                            </label>
                            <select name="store_place" class="form-control" >
                                <?php
                                foreach ($places as $place) {
                                    echo "<option value='$place->place_id'>$place->name</option>";
                                }
                                ?>
                            </select>
                            <br><br>
                            <input class="btn btn-style" type="submit" style="float: left" 
                                   id="save_place"
                                   name="add" value="<?php echo lang('save') ?>" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div  class="modal" id="place_warranty_modal" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >&times</button>
            </div>
            <div class="modal-body" >
                <div id="loader" style="display: none" class="loader">Loading...</div>
                <div id="body" style="" class="row">
                    <div  class="col">
                        <form id="add_category_form">
                            <div class="error"></div>
                            <label for="name" style="width: 25%;">
                                <?php echo lang('place') ?> :
                            </label>
                            <select name="store_place_warranty">
                                <?php
                                foreach ($places as $place) {
                                    echo "<option value='$place->place_id'>$place->name</option>";
                                }
                                ?>
                            </select>
                            <br><br>
                            <input class="btn btn-style" type="submit" style="float: left" 
                                   id="save_place_warranty"
                                   name="add" value="<?php echo lang('save') ?>" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div  class="modal" id="call_modal" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >&times</button>
            </div>
            <div class="modal-body" >
                <div id="loader" style="display: none" class="loader">Loading...</div>
                <div id="body" style="" class="row">
                    <div  class="col">
                        <form id="add_category_form">
                            <div class="error"></div>
                            <label for="name" style="width: 25%;">
                                 <input type="checkbox" id="no_answer" value="1"/>
                                <?php echo lang('no_answer') ?> 
                            </label>
                            <br>
                            <label for="name" style="width: 25%;">
                                <?php echo lang('agreed') ?> :
                            </label>
                            <input type="text" id="agreed" class="form-control input-md" 
                                   name="text" required="" 
                                   style="width: 60%;display: inline" />                            
                            <br><br>
                            <label for="price"  style="width: 25%;"><?php echo lang('date') ?>:</label>
                            <input type="text" 
                                   class="form-control input-md numeric_input datetimepicker" 
                                   name="call_date" 
                                   style="width: 60%;display: inline" />

                            <input type="hidden" name="order_id" />
                            <br><br>
                            <input class="btn btn-style" type="submit" style="float: left" 
                                   id="save_call_action"
                                   name="add" value="<?php echo lang('save') ?>" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>