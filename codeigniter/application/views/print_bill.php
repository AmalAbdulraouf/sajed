<div id="forPrintBill">

    <div  class="main_screen" id="main_screen">	
        <div  id="print_area">
            <div class= "header_column_print">
                <h4>
                    <?php echo lang('bill_num'); ?> <?php echo $order_info['order_basic_info'][0]->id; ?>
                </h4>

            </div>
            <hr>
            <h4 style="float: right"><?php echo lang('customer_info'); ?></h4>
            <div style="clear: both"></div>

            <table class="customer_info_table">
                <tr>
                    <td><?php echo lang('customer_name'); ?>:</td>
                    <td>
                        <?php echo $order_info['order_basic_info'][0]->contact_fname . " " . $order_info['order_basic_info'][0]->contact_lname; ?>
                    </td>
                </tr>

                <tr>
                    <td ><?php echo lang('phone'); ?>:</td>
                    <td>
                        <?php
                        echo '9665' . $order_info['order_basic_info'][0]->contact_phone;
                        ?>
                    </td>
                </tr>
            </table>
            <hr>
            <h4 style="float: right"><?php echo lang('date') . ": " . $order_info['actions'][0]->date; ?></h4>
            <div style="clear: both"></div>
            <hr>
            <!--<h4><?php echo lang('machine_info'); ?></h4>-->
            <h4 style="float: right"><?php echo lang('machine_info'); ?></h4>
            <div style="clear: both"></div>

            <table class="machine_info_table">
                <tr>
                    <td><?php echo lang('machine_type'); ?>:</td>
                    <td>
                        <?php echo $order_info['order_basic_info'][0]->machine_type; ?>
                    </td>
                </tr>
                <tr>
                    <td ><?php echo lang('brand'); ?>:</td>
                    <td>
                        <?php
                        echo $order_info['order_basic_info'][0]->brand_name;
                        ?>
                    </td>

                    <td ><?php echo lang('model'); ?>:</td>
                    <td>
                        <?php echo $order_info['order_basic_info'][0]->model_name; ?>
                    </td>
                    <?php if ($order_info['order_basic_info'][0]->faults != "") { ?>
                        <td ><?php echo lang('faults'); ?>:</td>
                        <td>
                            <?php echo $order_info['order_basic_info'][0]->faults; ?>
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td><?php echo lang('serial_no'); ?>:</td>
                    <td>
                        <?php
                        echo $order_info['order_basic_info'][0]->serial_number;
                        ?>
                    </td>
                    <td><?php echo lang('color'); ?>:</td>
                    <td><?php echo $order_info['order_basic_info'][0]->color_name; ?></td>
                </tr>

                <tr>
                    <td ><?php echo lang('under_waranty'); ?>:</td>
                    <td>
                        <?php
                        if ($order_info['order_basic_info'][0]->under_warranty == 1) {

                            if ($order_info['order_basic_info'][0]->billNumber != null) {
                                ?>
                        </tr>
                        <tr>
                            <td ><?php echo lang('billNumber') . " :<td>" . $order_info['order_basic_info'][0]->billNumber . "</td>"; ?></td>
                            <?php
                        }
                        if ($order_info['order_basic_info'][0]->billDate != null) {
                            ?>
                            <td ><?php echo lang('billDate') . " :<td>" . $order_info['order_basic_info'][0]->billDate . "</td>"; ?></td>
                            <?php
                        }
                        echo "<td >" . lang('warranty_period') . " :<td>" . $order_info['order_basic_info'][0]->warranty_period . " " . lang('year') . "</td></td>";
                        echo "<td >" . lang('warranty_times') . " :<td>" . $order_info['order_basic_info'][0]->warranty_times . "</td></td>";
                        echo "</tr>";

                        if ($order_info['order_basic_info'][0]->temporary_device) {
                            $device = $order_info['order_basic_info'][0]->temporary_device;
                            ?>
                        <tr>   
                            <td><?php echo lang('temporary_device_given') ?></td>

                            <td>
                                <?php echo lang('machine_type'); ?>
                            </td>
                            <td>
                                <?php echo $device->machine_type ?>
                            </td>
                            <td>
                                <?php echo lang('brand'); ?>
                            </td>
                            <td>
                                <?php echo $device->brand; ?>
                            </td>
                            <td>
                                <?php echo lang('model'); ?>
                            </td>
                            <td>
                                <?php echo $device->model; ?>	
                            </td>
                            <td>
                                <?php echo lang('color'); ?>
                            </td>
                            <td>
                                <?php echo $device->color; ?>	
                            </td>
                            <td>
                                <?php echo lang('serial_no'); ?>
                            </td>
                            <td>
                                <?php echo $device->serial_number; ?>	
                            </td>
                            <?php if ($device->faults != "") { ?>
                                <td>
                                    <?php echo lang('faults'); ?>
                                </td>
                                <td>
                                    <?php echo $device->faults; ?>	
                                <td>
                                <?php } ?>
                                <?php if ($device->accessories != "") { ?>
                                <td>
                                    <?php echo lang('accessories'); ?>
                                </td>
                                <td>
                                    <?php echo $device->accessories; ?>	
                                <td>
                                <?php } ?>
                        </tr>
                        <?php
                    }
                } else {
                    echo lang('NO');
                }
                ?>




            </table>
            <hr>

            <div class="table_div_" <?php
            if ($just_received == 1) {
                echo 'style="display:none;"';
            }
            ?>>
                <div style="clear: both"></div>
                <table style="width: 100%" id="order_history" class="display table">
                    <thead style="text-align: right">
                    <th style="text-align: right"><?php echo lang('service'); ?></th>
                    <th style="text-align: right"><?php echo lang('cost'); ?></th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($order_info['actions'] as $action) {
                            if ($action->name == 'Delivered' || $action->name == 'Set Ready' || $action->name == 'Recieved' || $action->name == 'Assigned To Technician' || $action->name == 'Edited' || $action->name == 'Cancelled' || $action->categories_id == 9 || $action->categories_id == 10 || $action->categories_id == 11 || $action->categories_id == 12 || $action->categories_id == 13) {
                                
                            } else {
                                echo "<tr><td>" . $action->description . "</td><td class = 'cost'>" . ($action->spare_parts_cost + $action->repair_cost) . "</td>";
                            }
                        }
                        echo "<tr><td></td><td>" . lang('total_cost_spare') . ": " . ($order_info["order_basic_info"][0]->spare_parts_cost + $order_info['order_basic_info'][0]->repair_cost) . "</td></tr>";
                        $sum = ($order_info["order_basic_info"][0]->spare_parts_cost + $order_info['order_basic_info'][0]->repair_cost);

                        if ($order_info['order_basic_info'][0]->discount != 0) {
                            $sum = $sum -  $order_info['order_basic_info'][0]->discount;

                            echo '<tr><td></td><td>';
                            echo lang('discount');
                            echo ': ';
                            echo $order_info['order_basic_info'][0]->discount . " ر.س";
                            echo '</td></tr>';
                        }
                        if ($order_info['order_basic_info'][0]->company == 1) {
                            if ($order_info['order_basic_info'][0]->company_discount != 0) {
                                echo '<tr><td></td><td>';
                                echo lang('company_discount');
                                echo ': ';
                                echo $order_info['order_basic_info'][0]->company_discount . "%";
                                echo '</td></tr>';
                            }
                        } else if ($order_info['order_basic_info'][0]->company == 0) {
                            if ($order_info['order_basic_info'][0]->contact_discount != 0) {
                                echo '<tr><td></td><td>';
                                echo lang('customer_discount');
                                echo ': ';
                                echo $order_info['order_basic_info'][0]->contact_discount . "%";
                                echo '</td></tr>';
                            }
                        }
                        echo "<tr><td></td><td>" . lang('total_cost') . ": ";
                        if ($order_info['order_basic_info'][0]->company == "1") {
                            if ($order_info['order_basic_info'][0]->company_discount != "0") {
                                $sum = $sum - ($sum * $order_info['order_basic_info'][0]->company_discount ) / 100;
                            }
                        } else if ($order_info['order_basic_info'][0]->company == "0") {
                            if ($order_info['order_basic_info'][0]->contact_discount != "0") {
                                $sum = $sum - ($sum * $order_info['order_basic_info'][0]->contact_discount) / 100;
                            }
                        }
                        echo $sum . "</td></tr>";
                        ?>	
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
