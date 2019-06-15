<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>PC-Maintenance :: Assign Tasks To Technicians</title>

        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/users_management.css' ?>'>
        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/dataTables.jqueryui.css' ?>'>

        <?php
        if ($this->session->userdata('language') == 'Arabic') {
            $this->lang->load('website', 'arabic');
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/style-ar.css">';
        } else {
            $this->lang->load('website', 'english');
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/style-en.css">';
        }


        if (sizeof($orders) == 0) {
            if ($status == "del") {
                redirect("users_manager/deactivate_user/" . $tech_id);
            } else if ($status == "abs") {
                redirect("users_manager/Absence/" . $tech_id . "/1");
            }
        } else {
            $orders_count = sizeof($orders);
        }
        ?>

        <script src='<?php echo base_url() . 'resources/jquery-1.11.1.min.js' ?>'></script>
        <script src='<?php echo base_url() . 'resources/dataTables.jqueryui.js' ?>'></script>
        <script src='<?php echo base_url() . 'resources/jquery.dataTables.js' ?>'></script>

        <script>
            $(document).ready(function () {
                $('#orders_table').dataTable();
                $('.loader').hide();

            });

            $(document).ready(function () {
                $(".change_language").click(function () {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function ()
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
            });
        </script>

        <script>

            $(document).ready(function () {

                $('#OKK').click(function () {

                    var id = <?php echo json_encode($tech_id); ?>;
                    var b_url = "<?php echo base_url(); ?>";
                    var alter = parseInt($("#technician2").val());
                    var status = "<?php echo $status; ?>";
                    if (alter == 0)
                    {
                        alert("<?php echo lang('select'); ?>");
                    } else
                    {
                        $('.loader').show();
                        $('.OK').hide();
                        $('#Done').hide();
                        $.ajax({
                            url: b_url + "index.php/users_manager/assign_all/" + status + "/" + id + "/" + alter,
                            //type: "POST",
                            error: function () {},
                            success: function (respons)
                            {
                                window.location.href = b_url + "index.php/users_manager";
                            }
                        });
                    }


                });
            });

            $(document).on('click', ".assignToButton", function () {
                $(this).parent().html("Assigned to " + $(this).parent().children("select").children(":selected").text());
            });

        </script>
        <script>
            var done = 0;
            function assign_order(str)
            {
                done++;
                var id = "row_" + str;
                var doc = document.getElementById(id);
                var assign_to = null;
                for (var i = 0; i < doc.childNodes.length; i++) {
                    if (doc.childNodes[i].className == "td_assign_to") {
                        assign_to = doc.childNodes[i];
                        break;
                    }
                }

                var technician = null;
                for (var i = 0; i < assign_to.childNodes.length; i++) {
                    if (assign_to.childNodes[i].className == "technician") {
                        technician = assign_to.childNodes[i].value;
                        break;
                    }
                }

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function ()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        assign_to.addChildNode('Assigned');
                    }
                }
                var link = "<?php echo base_url(); ?>" + "index.php/order/assign_order_to_tech?technician=" + technician + "&order_id=" + str;
                xmlhttp.open("GET", "<?php echo base_url(); ?>" + "index.php/order/assign_order_to_tech?technician=" + technician + "&order_id=" + str, true);
                xmlhttp.send();
                var count = <?php echo $orders_count; ?>;
                if (done == count)
                {
                    var status = "<?php echo $status; ?>";
                    var id = <?php echo $tech_id; ?>;
                    var b_url = "<?php echo base_url(); ?>";
                    if (status == "del")
                    {
                        window.location.href = b_url + "index.php/users_manager/deactivate_user/" + id;
                    } else if (status == "abs")
                    {
                        window.location.href = b_url + "index.php/users_manager/Absence/" + id + "/1";
                    }
                }
            }


            $(document).ready(function () {
                $('#Done').click(function () {
                    var count = <?php echo $orders_count; ?>;
                    if (done < count)
                    {
                        alert("<?php echo lang('not done'); ?> ");
                    } else
                    {
                        var status = "<?php echo $status; ?>";
                        var id = <?php echo $tech_id; ?>;
                        var b_url = "<?php echo base_url(); ?>";
                        if (status == "del")
                        {
                            window.location.href = b_url + "index.php/users_manager/deactivate_user/" + id;
                        } else if (status == "abs")
                        {
                            window.location.href = b_url + "index.php/users_manager/Absence/" + id + "/1";
                        }
                    }
                });
                $('#subBar').click(function () {
                    $('#ba').submit();
                });
            });

        </script>


    </head>

    <body>

        <div id = "page">
            <div class="logout_div">
                <div class="logout_div_item">
                    <a href = '<?php echo base_url() . 'index.php/main/logout' ?>'>
                        <img style="border:0;" <?php echo 'src="' . base_url() . 'resources/images/logout-64.png"' ?>/>
                    </a>
                </div>

                <div class="logout_div_item">
                    <a href = '<?php echo base_url() . 'index.php/main_page' ?>'>
                        <img style="border:0;" <?php echo 'src="' . base_url() . 'resources/images/home-4-64.png"' ?>/>
                    </a>
                </div>

                <div class="logout_div_item">
                    <img class='change_language' id='Arabic' src='<?php echo base_url() ?>resources/images/arabic.png'/>
                    <img class='change_language' id='English' src='<?php echo base_url() ?>resources/images/english.png'/>
                </div>
            </div>

            <div class="main_screen" id="main_screen">
                <div class= "app-title">

                    <div id="barcodeDiv" class="forFloat" >
                        <form  id="ba" method="post" action="<?php echo base_url(); ?>index.php/order/search_order_barcode">
                            <td><input style="width: 100%; display:inline" type="text" placeholder="Barcode" name="BarCode" id="BarCode"  onmouseover="this.focus();" />
                                <button style="display: inline" id="subBar">OK</button></td>
                        </form>
                    </div>
                    <div style="clear: both"></div>
                    <img src='<?php echo base_url() ?>resources/images/logo2.bmp'/><br>
                </div>
                <div class="table_div_">
                    <table id="orders_table" class="display" >
                        <thead>
                        <th>#</th>
                        <th><?php echo lang('customer_name'); ?></th>
                        <th><?php echo lang('machine_brand'); ?></th>
                        <th><?php echo lang('machine_model'); ?></th>
                        <th><?php echo lang('fault_description'); ?></th>
                        <th><?php echo lang('assign_to'); ?></th>
                        <th><?php echo lang('details'); ?></th>
                        </thead>
                        <tbody>
                            <?php
                            echo "<br><br><br><div class='OK' id='forFloat'>";
                            echo lang('assign_all') . "  :  ";
                            echo form_dropdown('technician', $technicians, set_value('technician'), 'id="technician2"');
                            echo "<button value= \"$order->id\" id='OKK'>OK</button></div>";
                            echo "<div class='loader'>Loading...</div>";

                            echo "<button id='Done'>" . lang("Done") . "</button>";
                            echo "<div style='clear:both'></div>";
                            foreach ($orders as $order) {
                                echo "<tr name=\"row_$order->id\" id=\"row_$order->id\">";
                                echo '<td >' . $order->id . '</td>';
                                echo '<td >' . "$order->first_name $order->last_name" . '</td>';
                                echo '<td >' . $order->name . '</td>';
                                echo '<td >' . $order->model . '</td>';
                                echo '<td >' . $order->fault_description . '</td>';
                                echo "<td class=\"td_assign_to\">";
                                $opt = 'class="technician"';
                                echo '<select style="width: auto" class="form-control  input-md">';
                                foreach ($technicians_array as $tech) {
                                    if (($tech->software && $order->software) ||
                                            ($tech->electronic && $order->electronic) ||
                                            ($tech->external_repair && $order->external) ||
                                            ($tech->new_software && $order->software) )
                                        echo '<option  value="' . $tech->id . '">' . $tech->user_name . '</option>';
                                }
                                echo '</select>';
//                                echo form_dropdown('technician', $technicians, 1, $opt);
                                echo "<button class=\"assignToButton\" value= \"$order->id\" onclick =\"assign_order(this.value)\">OK</button>";
                                echo '</td>';
                                $href = base_url() . 'index.php/order/view_order?order_id=' . $order->id;
                                echo "<td class=\"td_view_details\"><a href=\"$href\">Details</a></td>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <div>
                    </div>
                </div>
                <?php

                function is_user_in_group($group_id, $user_groups) {
                    echo "amal333333";
                    foreach ($user_groups as $usr_group) {
                        if ($usr_group == $group_id) {
                            return true;
                        }
                    }
                    return false;
                }
                ?>
                </body>
                </html>