
<link rel="stylesheet" type="text/css" href='<?php echo base_url(); ?>resources/datatables.min.css'/>
<script type="text/javascript" src='<?php echo base_url(); ?>resources/datatables.min.js'></script>
<script>
    $(document).ready(function () {
        var table = $('#orders_table').dataTable();
        $('#orders_table').on('draw.dt', function () {
            $(".row_order").click(function () {
                var href = '<?php echo base_url() . 'index.php/order/view_order?order_id=' ?>';
                href += $(this).attr("value");
                window.open(href, "_self");
            });
        });
        $('.loader').hide();
        var attention = <?php echo $this->session->userdata('give_attention'); ?>;
        if (attention != 1 && attention != 0)
        {
            $('.loader').show();
            $('#forHide').hide();
            var b_url = "<?php echo base_url(); ?>";
            window.location.href = b_url + "index.php/order/give_attentions";
        }
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
        $(".row_order").click(function () {
            var href = '<?php echo base_url() . 'index.php/order/view_order?order_id=' ?>';
            href += $(this).attr("value");
            window.open(href, "_self");
        });
    });
</script>

<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center" >
        <h3 align="center"><?php echo lang('search_results') ?></h3>
    </div>
    <div class="panel-body"  >
        <div  class="row" style="text-align: center">

            <div class ="table-responsive">
                <!--<br><br><br><br><br><br>-->
                <?php
                if ($this->session->userdata('language') == 'Arabic') {
                    ?>
                    <table   id="orders_table" class="display">
                        <thead style="direction: rtl">
                        <th><?php echo lang('order_number'); ?></th>
                        <th><?php echo lang('customer_name'); ?></th>
                        <th><?php echo lang('machine_brand'); ?></th>
                        <th><?php echo lang('machine_model'); ?></th>
                        <th><?php echo lang('fault_description'); ?></th>
                        <th><?php echo lang('status'); ?></th>
                        <th><?php echo lang('place'); ?></th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($orders as $order) {
                                echo "<tr class='row_order' name=\"row_$order->id\" id=\"row_$order->id\" value=\"$order->id\">";
                                echo '<td>' . $order->id . '</td>';
                                echo '<td>' . "$order->first_name $order->last_name" . '</td>';
                                echo '<td>' . $order->name . '</td>';
                                echo '<td>' . $order->model . '</td>';
                                echo '<td>' . $order->fault_description . '</td>';
                                echo '<td>' . lang($order->state) . '</td>';
                                if ($order->current_status_id == 4 || $order->current_status_id == 5)
                                    echo '<td>' . $order->place . '</td>';
                                else
                                    echo '<td></td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    ?>
                    <table  id="orders_table" >
                        <thead>
                        <th><?php echo lang('order_number'); ?></th>
                        <th><?php echo lang('customer_name'); ?></th>
                        <th><?php echo lang('machine_brand'); ?></th>
                        <th><?php echo lang('machine_model'); ?></th>
                        <th><?php echo lang('fault_description'); ?></th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($orders as $order) {
                                echo "<tr class='row_order' name=\"row_$order->id\" id=\"row_$order->id\" value=\"$order->id\">";
                                echo '<td>' . $order->id . '</td>';
                                echo '<td>' . "$order->first_name $order->last_name" . '</td>';
                                echo '<td>' . $order->name . '</td>';
                                echo '<td>' . $order->model . '</td>';
                                echo '<td>' . $order->fault_description . '</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } ?>

            </div>			
        </div>
    </div>
</div>
