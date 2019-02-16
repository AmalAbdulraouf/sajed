<html>
    <head>


        <link rel="stylesheet" type="text/css" href='<?php echo base_url(); ?>resources/datatables.min.css'/>

        <script type="text/javascript" src='<?php echo base_url(); ?>resources/datatables.min.js'></script>
        <script>
            $(document).ready(function () {
                var table = $('#orders_table').dataTable();
            });

            $(document).ready(function () {
                $('#orders_table').on('draw.dt', function () {
                    $(".row_order").click(function () {
                        var href = '<?php echo base_url() . 'index.php/order/view_order?order_id=' ?>';
                        href += $(this).attr("value");
                        window.open(href, "_self");
                    });
                });
            });

        </script>
        <script>
            $(document).ready(function () {
                $('#Done').hide();
                var count = <?php echo $this->session->userdata('give_attention'); ?>;
                if (count == 0)
                {

                    var b_url = "<?php echo base_url(); ?>";
                    window.location.href = b_url + "index.php/main_page";
                }
                $('#Done').click(function () {
                    //alert("hey");
                    var b_url = "<?php echo base_url(); ?>";
                    window.location.href = b_url + "index.php/main_page";
                });

            });
        </script>

        <script type="text/javascript">
            var done = 0;
            var last = '';
            function Excuse_fun(str)
            {
                done++;
                var id = "row_" + str;
                var doc = document.getElementById(id);
                var excuse = null;
                for (var i = 0; i < doc.childNodes.length; i++) {
                    if (doc.childNodes[i].className == "td_excuse") {
                        excuse = doc.childNodes[i];
                        break;
                    }
                }

                var exc = "";

                var val = $("#" + id).find(".td_excuse").find("select").val();
                console.log(val);
                if (val != 0) {
                    exc = $("#" + id).find(".td_excuse").find("select option:selected").html();
                } else {
//                for (var i = 0; i < excuse.childNodes.length; i++) {
//
//                    if (excuse.childNodes[i].className == "excuse") {

                    exc = $("#" + id).find(".excuse").val();
//                        break;
//                    }
//                }
                }

                last = exc;
                if (exc == '')
                {
                    alert("<?php echo lang('set excuse'); ?>");
                } else
                {

                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function ()
                    {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                        {
                            excuse.addChildNode(exc);
                        }
                    }
                    var link = "<?php echo base_url(); ?>" + "index.php/order/give_excuse/" + exc + "/" + str;
                    xmlhttp.open("GET", "<?php echo base_url(); ?>" + "index.php/order/give_excuse/" + exc + "/" + str, true);
                    xmlhttp.send();
                    var count = <?php echo $this->session->userdata('give_attention'); ?>;
                    var b_url = "<?php echo base_url(); ?>";
                    if (count == done)
                    {
                        $('#Done').show();
                        var b_url = "<?php echo base_url(); ?>";
                        window.location.href = b_url + "index.php/main_page/transfer_to_main";
                        //window.location.href = b_url+"index.php/main_page;
                    }

                }
            }

            $(document).on('click', ".giveExcuse", function () {

                if (last != '')
                    $(this).parent().html(last);
            });
        </script>


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
    </head>

    <div class="panel panel-default ">
        <div class="panel-heading">
            <h3><?php echo lang('give excuses'); ?></h3>
        </div>
        <div class="panel-body">

            <div align="center" class ="table-responsive">
                <br>
                <div  class="table_div_">
                    <table id="orders_table"  class="display">
                        <thead>
                        <th>#<?php echo lang('order_number'); ?></th>
                        <th><?php echo lang('fault_description'); ?></th>
                        <th><?php echo lang('excuse'); ?></th>
                        <th><?php echo lang('details'); ?></th>
                        </thead>
                        <tbody>
                            <?php
                            echo "<div style='clear:both'></div>";
                            foreach ($orders as $order) {
                                $ID = $order['id'];
                                echo "<tr name=\"row_$ID\" id=\"row_$ID\">";
                                echo '<td >' . $order['id'] . '</td>';
                                echo '<td >' . $order['fault'] . '</td>';
                                echo "<td class=\"td_excuse\">";
                                echo "<select name='reasons'>";
                                echo "<option value='0'>" . lang('not_selected') . "</option>";
                                foreach ($reasons as $reason) {
                                    echo "<option value='$reason->reason_id'>" . $reason->text . "</option>";
                                }
                                echo '</select><br>' . lang('other');
                                $area = array
                                    (
                                    'rows' => '3',
                                    'cols' => '30',
                                    'name' => 'excuse',
                                    'class' => 'excuse'
                                );
                                echo form_textarea($area);

                                echo "<button class=\"giveExcuse\" value= \"$ID\" onclick =\"Excuse_fun(this.value)\">OK</button>";
                                echo '</td>';
                                $href = base_url() . 'index.php/order/view_order?order_id=' . $ID;
                                echo "<td class=\"td_view_details\"><a href=\"$href\">Details</a></td>";
                            }
                            ?>

                        </tbody>
                    </table>

                </div>
            </div>			
        </div>
    </div>


