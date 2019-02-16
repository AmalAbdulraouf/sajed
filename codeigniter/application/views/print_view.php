<div id="forPrint">

    <div  class="main_screen" id="main_screen">	
        <div  id="print_area">
            <div class= "header_column_print">
                <h4><?php echo lang('voucher'); ?> <br><br><?php echo $order_info['order_basic_info'][0]->id; ?><br><img align="center"  id="barcodee" height="3%" width="23%"/><br></h4><br>
                <?php
                if ($just_received != 1) {
                    echo "<h4>" . lang($order_info['current_status']->name);
                }
                ?></h4>

            </div>

            <h4 style="text-align: right"><?php echo lang('customer_info'); ?></h4>
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
                        echo '966' . $order_info['order_basic_info'][0]->contact_phone;
                        ?>
                    </td>
                    <?php if ($order_info['order_basic_info'][0]->contact_email != "") {
                        ?>
                        <td ><?php echo lang('email'); ?>:</td>
                        <td>
                            <?php echo $order_info['order_basic_info'][0]->contact_email; ?>
                        </td>
                    <?php } ?>
                    <?php if ($order_info['order_basic_info'][0]->contact_address != "") {
                        ?>
                        <td ><?php echo lang('address'); ?>:</td>
                        <td>
                            <?php echo $order_info['order_basic_info'][0]->contact_address; ?>
                        </td>
                    <?php } ?>

                </tr>


                <tr class= "address_row">
                    <td><?php echo lang('address'); ?>:</td>
                    <td>
                        <?php echo $order_info['order_basic_info'][0]->contact_address; ?>
                    </td>
                </tr>
                <?php
                if ($just_received == 1) {

                    echo'<tr>
                                    <td>' . lang('date') . ':</td>
                                    <td>' . $order_info['actions'][0]->date . '</td>
                            </tr>';
                }
                ?>
            </table>
            <br>
            <h4><?php echo lang('machine_info'); ?></h4>
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
            <br>
            <table class="fault_description_table">	
                <h4><?php echo lang('fault_description'); ?></h4>


                            <tr><td><?php echo lang('fault_description'); ?>: </td><td><?php echo $order_info['order_basic_info'][0]->fault_description; ?></td></tr>
                <tr>
                    <td><?php echo lang('service'); ?>: </td>
                    <td>
                        <?php
                        if ($order_info['order_basic_info'][0]->software == 1)
                            echo "<br> software برامج";
                        if ($order_info['order_basic_info'][0]->electronic == 1)
                            echo "<br>electronic الكترونيات";
                        if ($order_info['order_basic_info'][0]->external_repair == 1)
                            echo "<br>external صيانة خارجية";
                        if ($order_info['order_basic_info'][0]->under_warranty == 1)
                            echo "<br>warranty ضمان";
                        ?>
                    </td>
                </tr>
                <?php
                if ($order_info['current_status']->status_id == 5 || $order_info['current_status']->status_id == 6) {
                    if ($order_info['order_basic_info'][0]->under_warranty == 0) {
                        if ($order_info['order_basic_info'][0]->spare_parts_cost + $order_info['order_basic_info'][0]->repair_cost == 0) {
                            ?>
                            <tr><td><?php echo lang('examining_cost'); ?>: </td><td><?php echo $order_info['order_basic_info'][0]->examine_cost ?></td></tr>

                        <?php } else { ?>
                            <tr>
                                <td><?php echo lang('repair_cost'); ?>: </td>
                                <td><?php echo $order_info['order_basic_info'][0]->repair_cost ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('spare_parts_cost'); ?>: </td>
                                <td><?php echo $order_info['order_basic_info'][0]->spare_parts_cost ?></td>
                                <td><?php echo lang('total_cost'); ?>: </td>
                                <td><?php echo $order_info['order_basic_info'][0]->spare_parts_cost + $order_info['order_basic_info'][0]->repair_cost ?></td>

                                <?php
                                if ($order_info['order_basic_info'][0]->discount != 0) {
                                    echo '<td>';
                                    echo lang('discount');
                                    echo ': </td><td>';
                                    echo $order_info['order_basic_info'][0]->discount . " ر.س";
                                    echo '</td>';
                                }
                                if ($order_info['order_basic_info'][0]->company == 1) {
                                    if ($order_info['order_basic_info'][0]->company_discount != 0) {
                                        echo '<td>';
                                        echo lang('company_discount');
                                        echo ': </td><td>';
                                        echo $order_info['order_basic_info'][0]->company_discount . "%";
                                        echo '</td>';
                                    }
                                } else if ($order_info['order_basic_info'][0]->company == 0) {
                                    if ($order_info['order_basic_info'][0]->contact_discount != 0) {
                                        echo '<td>';
                                        echo lang('customer_discount');
                                        echo ': </td><td>';
                                        echo $order_info['order_basic_info'][0]->contact_discount . "%";
                                        echo '</td>';
                                    }
                                }
                                echo '</tr>';
                            }
                        }
                    }

                    if ($order_info['order_basic_info'][0]->examine_date == 0 && $order_info['order_basic_info'][0]->status_id != 5 && $order_info['order_basic_info'][0]->status_id != 6 && $order_info['order_basic_info'][0]->status_id != 4) {
                        if ($order_info['order_basic_info'][0]->under_warranty != 1) {
                            ?>
                        <tr>
                            <td><?php echo lang('delivery_date'); ?>: </td>
                            <td><?php echo lang('during') . " " . $order_info['order_basic_info'][0]->delivery_date . " " . lang('work_day'); ?></td>

                            <td><?php echo lang('cost_estimation'); ?>: </td>
                            <td><?php echo $order_info['order_basic_info'][0]->estimated_cost ?></td>
                        </tr>

                        <?php
                    }
                } else if ($order_info['order_basic_info'][0]->delivery_date == 0 && $order_info['order_basic_info'][0]->status_id != 5 && $order_info['order_basic_info'][0]->status_id != 6 && $order_info['order_basic_info'][0]->status_id != 4) {
                    if ($order_info['order_basic_info'][0]->under_warranty != 1) {
                        ?>
                        <tr>
                            <td><?php echo lang('examine_date'); ?>: </td>
                            <td><?php echo lang('during') . " " . $order_info['order_basic_info'][0]->examine_date . " " . lang('day'); ?></td>

                            <td><?php echo lang('examining_cost'); ?>: </td>
                            <td><?php echo $order_info['order_basic_info'][0]->examine_cost; ?></td>
                        </tr>
                        <?php
                    }
                }

                if ($order_info['order_basic_info'][0]->external_repair != 0) {
                    ?>
                    <tr><td><?php echo lang('external_repair'); ?> </td></tr>

                <?php } ?>


            </table>
            <br>
            <?php
            if ($order_info['accessories']->notes != "") {
                echo '<h4>' . lang("accessories") . '</h4><br>';

                echo '<td>' . $order_info['accessories']->notes . '</td>';
            }
//                else {
//                    echo '<h4>' . lang("accessories") . '</h4><br>';
//
//                    echo lang('not_exist');
//                }
            ?>
            <table class="order_notes">
                <tr>
                    <td><?php echo lang('notes'); ?>: </td>
                    <td><br>
                        <?php
                        if ($order_info['order_basic_info'][0]->notes != '')
                            echo $order_info['order_basic_info'][0]->notes . "<br>";
                        else if ($order_info['order_basic_info'][0]->notes == '' && $order_info['order_basic_info'][0]->Receipt == 1)
                            echo lang('not_exist');
                        if ($order_info['order_basic_info'][0]->Receipt != 1) {// && $just_received)
                            echo lang('No Receipt') . "<br>" . lang('ID') . $order_info['order_basic_info'][0]->IDnum . "<br>";
                        }
                        ?>
                    </td>
                </tr>
                <?php
                if ($order_info['order_basic_info'][0]->allow_losing_data == 1) {
                    echo '<tr><td>';
                    echo lang('allow_losing_data');
                    echo ': </td><td>';
                    echo lang('YES');
                    echo '</td></tr>';
                } else {
                    
                }
                if ($order_info['order_basic_info'][0]->discount != 0) {
                    echo '<tr><td>';
                    echo lang('discount');
                    echo ': </td><td>';
                    echo $order_info['order_basic_info'][0]->discount;
                    echo '</td></tr>';
                } else {
                    
                }
                if ($just_received == 1 || $order_info['order_basic_info'][0]->under_warranty == 1) {

                    echo '<tr><td><br><br>*  ';
                    echo lang('order_received_by');
                    echo ': </td><td><br><br>';
                    echo $order_info['actions'][0]->user_name;
                    echo '</td></tr>';
                }

                if ($order_info['current_status']->status_id != 5 && $order_info['current_status']->status_id != 6 && $order_info['order_basic_info'][0]->ynder_warranty != 1) {
                    echo '<tr><td>  ';
                    echo lang('order_tech');
                    echo ': </td><td>';
                    echo $order_technician;
                    echo '</td></tr>';
                }
                ?>




            </table>

            <h4 <?php
            if ($just_received == 1) {
                echo 'style="display:none;"';
            }
            ?>><?php echo lang('order_history'); ?></h4>
            <div class="table_div_" <?php
            if ($just_received == 1) {
                echo 'style="display:none;"';
            }
            ?>>
                <table id="order_history" class="display">
                    <thead>
                    <th><?php echo lang('date'); ?></th>
                    <th><?php echo lang('user'); ?></th>
                    <th><?php echo lang('action'); ?></th>
                    <th><?php echo lang('description'); ?></th>
                    <th><?php echo lang('repair_cost'); ?></th>
                    <th><?php echo lang('spare_parts_cost'); ?></th>
                    <th><?php echo lang('total_cost'); ?></th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($order_info['actions'] as $action) {
                            if ($action->name == 'Delivered' || $action->name == 'Set Ready' || $action->name == 'Recieved' || $action->name == 'Assigned To Technician' || $action->name == 'Edited' || $action->name == 'Cancelled' || $action->categories_id == 9 || $action->categories_id == 10 || $action->categories_id == 11 || $action->categories_id == 12 || $action->categories_id == 13) {
                                if ($action->description == 'Examined')
                                    echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang('Examined') . "</td><td></td>";
                                else if ($action->categories_id == 10)
                                    echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang($action->name) . "</td><td>" . lang('message') . " : " . $action->description . "</td><td></td>";
                                else if ($action->name == 'Cancelled' || $action->name == 'Set Ready')
                                    echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang($action->name) . "</td><td>" . lang('place') . " : " . $action->description . "</td><td></td>";
                                else if ($action->categories_id == 5) {
                                    if ($order_info['order_basic_info'][0]->Receipt != 1) {
                                        echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang($action->name) . "</td><td>" . lang('ID') . $order_info['order_basic_info'][0]->IDnum . "</td>";
                                    } else {
                                        echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang($action->name) . "</td><td>" . $action->description . "</td>";
                                    }
                                } else if ($action->categories_id == 11) {
                                    echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang($action->name) . "</td><td>" . lang('agreed') . ": " . $action->description . "</td><td></td>";
                                } else
                                    echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang($action->name) . "</td><td>" . $action->description . "</td>";
// else
//                                        echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang($action->name) . "</td><td>" . $action->description . "</td>";

                                echo "<td class = 'cost'></td><td class = 'cost'>";
                                echo "</td><td ></td>";
                            }
                            else {
                                echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang($action->name) . "</td><td>" . $action->description . "</td><td class = 'cost'>" . $action->repair_cost . "</td><td class = 'cost'>";
                                echo $action->spare_parts_cost . "</td><td >" . ($action->spare_parts_cost + $action->repair_cost) . "</td>";
                            }
                        }
                        ?>	
                    </tbody>
                </table>
            </div>


        </div>
        <div id= "perform_reoair_action">

            <?php
            $uname = trim($this->session->userdata('user_name'));
            $order_technician = trim($order_technician);

            if (permission_included($user_permissions, 'Perform Repair Action')
                    // and ($order_technician == $uname)
                    and $order_info['current_status']->status_id == 2) {
                if ($order_info['current_status']->categories_id == 9) {
                    echo '<h2><br>' . lang('examining_result') . '</h2>';
                    echo '<table class="perform_repair_action">';
                    echo '<tr><td>' . lang('fault_description') . ': </td>';
                    echo '<td><textarea rows = "3" cols="40" name="description" id="result_fault_description"></textarea></td></tr>';
                    echo '<tr><td>' . lang('cost_estimation') . ': </td>';
                    echo '<td><input type="text" name="cost" id="result_estimated_cost" class="numeric_input" min=0/></td></tr>';
                    echo '<tr><td>' . lang('delivery_date') . ': </td><td>';
                    $options = array();
                    for ($i = 1; $i <= 100; $i++) {
                        $options[$i] = $i;
                    }
                    echo lang('during') . " " . form_dropdown('result_expected_examine_date', $options, '', 'id="result_delivery_date"') . " " . lang('work_day');
                    echo '</td></tr><tr align=><td></td><td><input  class="submit_btn3" type="submit" name="submit" id="submit_results" value="' . lang('submit') . '" status_id="2" categories_id="3" action_name="Repair Action Performed" /><br>';
                    echo '</td><tr><td></td><td><input class="submit_btn" type="submit" name="submit" id="submit" value="' . lang('set_order_status_to_cancelled') . '!" status_id="4" categories_id="4" action_name="Cancelled" status_name="Cancelled"/><br>';

                    echo "</td></tr>";
                } else {
                    echo '<h4><br>' . lang('perform_repair_action') . '</h4>';
                    echo '<table class="perform_repair_action">';
                    echo '<tr><td>' . lang('description') . ': </td>';
                    echo '<td><textarea rows = "3" cols="40" name="description" id="description"></textarea></td></tr>';
                    echo '<tr><td>' . lang('repair_cost') . ': </td>';
                    echo '<td><input type="text" name="cost" id="rep_cost" value="0" class="numeric_input" min=0/></td></tr>';
                    echo '<tr><td>' . lang('spare_parts_cost') . ': </td>';

                    echo '<td><input type="text" name="cost" id="parts_cost" value="0" class="numeric_input" min=0/></td></tr>';
                    echo '<tr><td>' . lang('total') . ': </td>';
                    echo '<td><input type="text" id="tot" value="0" class="numeric_input" readonly = "readonly"/></td></tr>';
                    echo '</table>';

                    echo '<br>';

                    echo '<input class="submit_btn" type="submit" name="submit" id="submit" value="' . lang('save_action') . '!" status_id="2" categories_id="3" action_name="Repair Action Performed" /><br>';
                    echo '<input class="submit_btn" type="submit" name="submit" id="ready" value="' . lang('set_order_status_to_done') . '" status_id="5" categories_id="7" action_name="Changed Status" status_name="Ready"/><br></div>';
                    echo '<input class="submit_btn" type="submit" name="submit" id="cancel" value="' . lang('set_order_status_to_cancelled') . '!" status_id="4" categories_id="4" action_name="Cancelled" status_name="Cancelled"/><br>';
                    echo '<a id="send" class="submit_btn" href="' . base_url() . 'index.php/order/load_message_page/' . $order_info['order_basic_info'][0]->id . '/';
                    echo $order_info['order_basic_info'][0]->contact_phone . '">' . lang('send_message_to_customer') . '</a><br>';
                    echo '<div id="create_message" style="display: none">';

                    echo form_open('order/send_message_to_customer/' . $order_id . '/' . $order_info['order_basic_info'][0]->contact_phone, array('class' => 'addForm'));
                    echo form_textarea('message_text') . '</div>';
                }
            }
            ?>

        </div>
        <div id= "deliver_to_customer">
            <?php
            if (permission_included($user_permissions, 'Receive an order')
                    and ( $order_info['current_status']->status_id == 4 or $order_info['current_status']->status_id == 5)) {
                echo '<br>';
                echo '<h2>' . lang('deliver_to_customer') . '</h2>';
                echo '<table class="deliver_order">';
                if ($order_info['current_status']->status_id == 4) {
                    echo '<tr><td id="total_cost2" colspan=2><h3>' . lang('total_cost') . " (" . lang('examining_cost') . ")" . $order_info['order_basic_info'][0]->examine_cost . '</h3></td></tr>';
                    echo '<tr><td>' . lang('cash') . ': </td>';
                    echo '<td><input type="text" id="cash2" id="cash2" class="numeric_input" min=0.0/></td></tr>';
                } else {
                    echo '<tr><td id="total_cost" colspan=2><h3></h3></td></tr>';
                    echo '<tr><td>' . lang('cash') . ': </td>';
                    echo '<td><input type="text" id="cash" id="cash" class="numeric_input" min=0.0/></td></tr>';
                }
                echo '<tr><td>' . lang('discount') . ': </td>';
                echo '<td><input type="text" id="discount" class="numeric_input" /></td></tr>';
                echo '<tr><td>' . lang('remaining') . ': </td>';
                echo '<td><input type="text" id="remaining" class="numeric_input" readonly = "readonly"/></td></tr>';
                echo '<td><input type="text" id="remaining" class="numeric_input" readonly = "readonly"/></td></tr>';
                echo '<tr><td><input type="checkbox" id="noReceipt" value="1"/>';
                echo lang('No Receipt') . '</td></tr>';
                echo '<tr id="ID"><td>' . lang("ID") . ' :</td><td><input type="text" id="IDnum" disabled="1"  class="numeric_input" min=0.0/></td></tr>';
                echo '</table>';

                echo '<table class="submit">';
                echo '<tr></tr></table>';
                echo '<div ><input class="submit_btn" type="submit" name="submit" id="PayButton" value="' . lang('pay') . ' ! " status_id="6" categories_id="5" action_name="Close" status_name="Closed"/><br></div>';
            }
            ?>
        </div>
    </div>
</div>