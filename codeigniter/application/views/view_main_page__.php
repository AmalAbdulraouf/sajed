<html>
    <head>		
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <title>حاسبات الخليج</title>	
        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/jquery-ui.css' ?>'>
        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/css/bootstrap.min.css' ?>'>
        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/styles.css' ?>'>
        <style type="text/css">
            .no-close .ui-dialog-titlebar-close {
                display: none !important;
            }
            .no-close {
                /*position: relative !important*/
            }
            .no-close input {
                margin-top:5px;
                padding-right: 3px;
                padding-left: 3px;
                font-size: 14px
            }
            .error{
                color: red
            }
        </style>
        <?php
        if ($this->session->userdata('language') == 'Arabic') {
            $this->lang->load('website', 'arabic');
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/style-ar.css">';
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/search_contacts-ar.css">';
        } else {
            $this->lang->load('website', 'english');
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/style-en.css">';
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/search_contacts-en.css">';
        }
        ?>
        <script src='<?php echo base_url() . 'resources/jquery-1.11.1.min.js' ?>'></script>
        <script src='<?php echo base_url() . 'resources/jquery-1.10.2.min.js' ?>'></script>
        <script src='<?php echo base_url() . 'resources/jquery-ui.js' ?>'></script>
        <script src='<?php echo base_url() . 'resources/jquery.watermarkinput.js' ?>'></script>
        <script src='<?php echo base_url() . 'resources/js/bootstrap.js' ?>'></script>
        <script>
            var site_url = "<?php echo site_url() ?>";
            $(document).ready(function() {
                $('.loader').hide();
                var attention = <?php echo $this->session->userdata('give_attention'); ?>;
                if (attention != 1 && attention != 0)
                {
                    $('.loader').show();
                    $('#forHide').hide();
                    var b_url = "<?php echo base_url(); ?>";
                    window.location.href = b_url + "index.php/order/give_attentions";
                }
            });
            $(document).ready(function() {
                $(".change_language").click(function() {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function()
                    {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                        {
                            location.reload(true);
                        }
                    }

                    var link = "<?php echo base_url(); ?>" + "index.php/language/change_language?language=" + $(this).attr('id');
                    xmlhttp.open("GET", link, true);
                    xmlhttp.send();
                });

                $('#subBar').click(function() {
                    $('#ba').submit();
                });
                $('.warranty_reminder').dialog({
                    dialogClass: "no-close",
                    height: 280,
                    width: 250,
                    position: {my: " top", at: "left bottom", of: $('.warranty_reminder').last()}
                });
                $('.datepicker').datepicker();
            });
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
                order_area.find('.error').html(errors);
                if (errors == "") {
                    $.ajax({
                        type: "POST",
                        url: site_url + "/order/set_receipt_info",
                        dataType: "json",
                        data: {
                            order_id: id,
                            shipping_company: company,
                            bill_of_lading: bill,
                            agent_name: agent,
                            received_date: received_date,
                            arrived_receipt_number: receipt,
                            receipt_employee: employee
                        },
                        success: function(data) {
                            $('#dialog-' + id).dialog("close");
                        },
                        error: function(response) {

                        }
                    });
                    $('#dialog-' + id).dialog("close");
                }
            }
        </script>
    </head>
    <body>
        <div class="container">
            <?php
            $user_permissions = $this->session->userdata('user_permissions');
            if (permission_included($user_permissions, 'Receive an order')) {
                foreach ($warranty_orders as $order) {
                    ?>
                    <div class="warranty_reminder" title="<?php echo lang('order_number') . ": #" . $order->id ?>" id="dialog-<?php echo $order->id ?>">
                        <div class="row" style="max-width: 100%;font-size:13px"  order-id="<?php echo $order->id ?>"> 
                            <input type="text" name="shipping_company" placeholder="<?php echo lang('shipping_company') ?>" />
                            <input type="text" name="bill_of_lading" placeholder="<?php echo lang('bill_of_lading') ?>" />
                            <input type="text" name="agent_name" placeholder="<?php echo lang('agent_name') ?>" />
                            <input type="text" class="datepicker" name="received_date" placeholder="<?php echo lang('received_date') ?>" />
                            <input type="text" name="arrived_receipt_number" placeholder="<?php echo lang('arrived_receipt_number') ?>" />
                            <br><?php echo lang('receipt_employee') ?>
                            <select name="receipt_employee" style="margin-top:5px">
                                <?php foreach ($receipt_employees as $value) { ?>
                                    <option value="<?php echo $value->receipt_employee_id ?>">
                                        <?php echo $value->name ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <br>
                            <input type="button" value="<?php echo lang('received') ?>" onclick="order_sent('<?php echo $order->id ?>')" />
                            <div class="error"></div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="row">
                <div class="panel panel-default ">
                    <div align="center" class="panel-body">
                        <div class="page-header">
                            <?php $this->load->view('app_title') ?>
                            <img style="max-width: 90%" src='<?php echo base_url() ?>resources/images/logo2.jpg'/>
                        </div>
                        <div class='loader'>Loading...</div>
                        <div  id="forHide" class="options_holder">
                            <?php
// reports
                            if (permission_included($user_permissions, 'View Reports')) {
                                ?>
                                <div class="col-md-3">
                                    <?php
                                    echo '<a href = ' . base_url() . 'index.php/reports>';
                                    echo '<img src=' . base_url() . 'resources/images/reports-128.png>';
                                    echo '<br>' . lang('reports') . '</a><br><br><br>';
                                    ?>
                                </div>

                                <?php
                            }




                            if (permission_included($user_permissions, 'Perform Repair Action')) {
                                ?>
                                <div class="col-md-3">
                                    <?php
                                    echo '<a href = ' . base_url() . 'index.php/order/technician_tasks>';
                                    echo '<img src=' . base_url() . 'resources/images/orders-128.png>';
                                    echo '<br>' . lang('orders_assigned_to_me') . '</a><br><br><br>';
                                    ?>
                                </div>

                                <?php
                            }



// search orders
                            {
                                ?>
                                <!--                                <div class="col-md-3">
                                <?php
                                echo '<a href = ' . base_url() . 'index.php/order/load_search_orders>';
                                echo '<img src=' . base_url() . 'resources/images/search-128.png>';
                                echo '<br>' . lang('search_orders') . '</a><br><br><br>';
                                ?>
                                                                </div>-->

                                <div class="col-md-3">
                                    <?php
                                    echo '<a href = ' . base_url() . 'index.php/reports/orders_report_view>';
                                    echo '<img src=' . base_url() . 'resources/images/search-128.png>';
                                    echo '<br>' . lang('search_orders') . '</a><br><br><br>';
                                    ?>
                                </div>

                                <?php
                            }

                            if (permission_included($user_permissions, 'Receive an order')) {
                                ?>
                                <div class="col-md-3">
                                    <?php
                                    echo '<a href = ' . base_url() . 'index.php/order/add_new_order>';
                                    echo '<img src=' . base_url() . 'resources/images/receive_an_order-128.png>';
                                    echo '<br>' . lang('receive_a_new_order') . '</a><br><br><br>';
                                    ?>
                                </div>

                                <?php
                            }

                            // logout
                            {
                                ?>
                                <div class="col-md-3">
                                    <?php
                                    echo '<a href = ' . base_url() . 'index.php/main/logout>';
                                    echo '<img src= ' . base_url() . 'resources/images/logout-128.png>';
                                    echo '<br>' . lang('logout') . '</a><br><br><br>';
                                    ?>
                                </div>

                                <?php
                            }

                            // Language
                            {
                                ?>
                                <div class="col-md-3">
                                    <?php
                                    echo '<div id="Arabic" class="change_language"><a><img style="border:0;" src= ' . base_url() . 'resources/images/arabic.png>';
                                    echo '<br>' . lang('o_l_name');
                                    echo '</a></div>';
                                    echo '<div id="English" class="change_language"><a><img width="128" height="128" style="border:0" src= ' . base_url() . 'resources/images/english.png>';
                                    echo '<br>' . lang('o_l_name') . '</a></div><br><br><br>';
                                    ?>
                                </div>

                                <?php
                            }

                            if (permission_included($user_permissions, 'Manage Lists')) {
                                ?>
                                <div class="col-md-3">
                                    <?php
                                    echo '<a href = ' . base_url() . 'index.php/management>';
                                    echo '<img src=' . base_url() . 'resources/images/management-128.png>';
                                    echo '<br>' . lang('manage_system') . '</a><br><br><br>';
                                    ?>
                                </div>

                                <?php
                            }

                            if (permission_included($user_permissions, 'Users Management')) {
                                ?>
                                <div class="col-md-3">
                                    <?php
                                    echo '<a href = ' . base_url() . 'index.php/users_manager>';
                                    echo '<img src=' . base_url() . 'resources/images/users_management-128.png>';
                                    echo '<br>' . lang('users_management') . '</a><br><br><br>';
                                    ?>
                                </div>

                            <?php } ?>




                        </div>
                    </div>
                </div>	
            </div>
        </div>
    </body>
</html>


<?php

function permission_included($user_permissions_array, $permission) {
    foreach ($user_permissions_array as $per) {
        if ($per->name == $permission)
            return true;
    }
    return false;
}
?>