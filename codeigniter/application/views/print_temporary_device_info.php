<div id="temporary_device_print" style="display: none">
    <div  class="main_screen" id="main_screen">	
        <div  id="print_area">
            <div class= "header_column_print">
                <h4><?php echo lang('voucher'); ?> <br><br><?php echo $order_info['order_basic_info'][0]->id; ?></h4><br>
                <?php
                if ($just_received != 1) {
                    echo "<h4>" . lang($order_info['current_status']->name);
                }
                ?></h4>

            </div>
            
            <h4><?php echo lang('temporary_device_given') ?></h4><br><br>
            <table class="temporary_device_given">
                <tr style="margin: 6px;">
                    
                    <td><?php echo lang('machine_type'); ?>:</td>
                    <td id="machine_type">
                    </td>
                    
                    <td ><?php echo lang('brand'); ?>:</td>
                    <td id="brand">
                    </td>
                    
                    <td ><?php echo lang('model'); ?>:</td>
                    <td id="model">
                    </td>
                    
                </tr>
                <tr style="margin: 6px;">
                    
                    <td ><?php echo lang('color'); ?>:</td>
                    <td id="color">
                    </td>

                    <td><?php echo lang('serial_no'); ?>:</td>
                    <td id="serial_no">
                    </td>
                </tr>
                <tr style="margin: 6px;">
                    <td><?php echo lang('faults'); ?>:</td>
                    <td id="faults">
                    </td>

                    <td><?php echo lang('accessories'); ?>:</td>
                    <td id="accessories">
                    </td>
                </tr>
                <tr style="margin: 6px;">
                    <td><?php echo lang('customer_name'); ?>:</td>
                    <td id="customer_name">
                    </td>

                    <td><?php echo lang('phone'); ?>:</td>
                    <td id="phone">
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

