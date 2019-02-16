<?php
$warranty_orders = array();
$receipt_employees = array();

$this->load->model('model_order');
$warranty_orders = $this->model_order->get_employee_warranty_orders($this->session->userdata('user_name'));
$receipt_employees = $this->model_users->get_receipt_employees();
?>
<link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'assets/card.css' ?>'>
<link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'assets/warranty_following.css' ?>'>
<script type="text/javascript">
    function openNavWarranty() {
        if (parseInt($('#badge').html()) > 0)
            document.getElementById("incoming_booking_Sidenav").style.width = "300px";
    }

    /* Set the width of the side navigation to 0 */
    function closeNavWarranty() {
        document.getElementById("incoming_booking_Sidenav").style.width = "0";
    }

    function open_order(obj) {
        var order = JSON.parse($(obj).attr("order"));
        $('#dialog-' + order.id).modal('show');
        var order_area = $('div[order-id=' + order.id + ']');
        order_area.find('input[name=shipping_company]').val(order.shipping_company);
        order_area.find('input[name=bill_of_lading]').val(order.bill_of_lading);
        order_area.find('input[name=agent_name]').val(order.agent_name);
        order_area.find('input[name=received_date]').val(order.received_date);
        order_area.find('input[name=arrived_receipt_number]').val(order.arrived_receipt_number);
        order_area.find('select[name=receipt_employee]').val(order.receipt_employee_id);
    }

    function order_sent(id) {
        var order_area = $('div[order-id=' + id + ']');
        order_area.find('.error').html("");
        var errors = "";

        var company = order_area.find('input[name=shipping_company]').val();
        var bill = order_area.find('input[name=bill_of_lading]').val();
        var agent = order_area.find('input[name=agent_name]').val();
        var received_date = order_area.find('input[name=received_date]').val();
        var receipt = order_area.find('input[name=arrived_receipt_number]').val();
        var employee = order_area.find('select[name=receipt_employee]').val();
        if (company == "")
            errors += "<p><?php echo lang('shipping_company') . " " . lang('required') ?></p>";
        if (bill == "")
            errors += "<p><?php echo lang('bill_of_lading') . " " . lang('required') ?></p>";
        if (agent == "")
            errors += "<p><?php echo lang('agent_name') . " " . lang('required') ?></p>";
        if (received_date == "")
            errors += "<p><?php echo lang('received_date') . " " . lang('required') ?></p>";
        if (receipt == "")
            errors += "<p><?php echo lang('arrived_receipt_number') . " " . lang('required') ?></p>";
        if (employee == "")
            errors += "<p><?php echo lang('receipt_employee') . " " . lang('required') ?></p>";
//        order_area.find('.error').html(errors);
//        if (errors == "") {
        $.ajax({
            type: "POST",
            url: site_url + "/order/set_receipt_info",
            dataType: "json",
            data: {
                order_id: id,
                shipping_company: company,
                bill_of_lading: bill,
                agent_name: agent,
                received_date: received_date == "" ? null : received_date,
                arrived_receipt_number: receipt,
                receipt_employee: employee == "" ? null : employee
            },
            success: function (data) {
                console.log(data);
//                $('#dialog-' + id).dialog("close");
                $('#booking_' + id).attr("order", JSON.stringify(data));
            },
            error: function (response) {

            }
        });
        if (errors == "") {
            $('#badge').html(parseInt($('#badge').html()) - 1);
            if (parseInt($('#badge').html()) <= 0)
                closeNavWarranty();
            $('#booking_' + id).remove();
        } else {
            $('#booking_' + id).find('.circle').attr('style', 'background:#d58512');
        }
        $('#dialog-' + id).modal("hide");
        $("#ui-datepicker-div").css("z-index", "9999");
//        }
    }

    $(document).ready(function () {
        //            $('.warranty_reminder').dialog({
        //                height: 280,
        //                width: 250,
        //            });
        $('.datepicker').datepicker();
    });
</script>
<?php
$user_permissions = $this->session->userdata('user_permissions');
if (permission_included($user_permissions, 'Receive an order')) {
    ?>
    <div id="incoming_booking_Sidenav" class="sidenavW" >

        <button type="button" class="close close_pending" onclick="closeNavWarranty();" >&times</button>
        <div style="clear: both"></div>
        <div id="pending_bookings_list">
            <?php
            foreach ($warranty_orders as $order) {
                ?>
                <div  class="modal warranty_reminder" id="dialog-<?php echo $order->id ?>" data-backdrop="false">
                    <div class="modal-dialog" style="width: 30%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" >&times</button>
                                <h4><?php echo lang('order_number') . ": #" . $order->id ?></h4>
                            </div>
                            <div class="modal-body" >
                                <div class="row" style="width:100%" order-id="<?php echo $order->id ?>">
                                    <div  class="col">
                                        <input class="form-control" type="text" name="shipping_company" placeholder="<?php echo lang('shipping_company') ?>" />
                                        <br><input class="form-control" type="text" name="bill_of_lading" placeholder="<?php echo lang('bill_of_lading') ?>" />
                                        <br><input class="form-control" type="text" name="agent_name" placeholder="<?php echo lang('agent_name') ?>" />
                                        <br><input class="form-control datepicker" type="text" name="received_date" placeholder="<?php echo lang('received_date') ?>" />
                                        <br><input class="form-control" type="text" name="arrived_receipt_number" placeholder="<?php echo lang('arrived_receipt_number') ?>" />
                                        <?php echo lang('receipt_employee') ?>
                                        <select class="form-control" name="receipt_employee" style="margin-top:5px">
                                            <?php foreach ($receipt_employees as $value) { ?>
                                                <option value="<?php echo $value->receipt_employee_id ?>">
                                                    <?php echo $value->name ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <br>
                                        <input class="btn btn-primary" type="button" value="<?php echo lang('save') ?>" onclick="order_sent('<?php echo $order->id ?>')" />
                                        <div class="error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m3" id="booking_<?php echo $order->id ?>" 
                     onclick="open_order(this)" 
                     order='<?php echo json_encode($order) ?>'>
                    <div class="card horizontal">
                        <span>
                            <?php echo lang('order_number') . ": #" . $order->id ?> 
                        </span>

                        <div 
                        <?php
                                        
                        if ($order->shipping_company == "" || $order->bill_of_lading == "") {
                            echo 'style=background:#ca0f14';
                        } else if ($order->received_date == "" || $order->arrived_receipt_number == "" ||
                                $order->agent_name == "" || $order->receipt_employee_id == null) {
                            echo 'style=background:#d58512';
                        } else {
                            if ($order->current_status_id == 5)
                                echo 'style=background:#337ab7';
                            else
                                echo 'style=background:#5cb85c';
                        }
                        ?>
                            class="circle"></div>

                    </div>
                </div>
            <?php }
            ?>
        </div>
    </div>

    <div style="clear: both"></div>
    <?php
}
?>
