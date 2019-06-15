<link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/users_management.css' ?>' media="screen">
<script src='<?php echo base_url() . 'resources/JsBarcode.js' ?>'></script>
<script src='<?php echo base_url() . 'resources/CODE128.js' ?>'></script>
<script src='<?php echo base_url() . 'resources/js/view_order.js' ?>'></script>
<link rel="stylesheet" type="text/css" href='<?php echo base_url(); ?>resources/datatables.min.css'/>
<script type="text/javascript" src='<?php echo base_url(); ?>resources/datatables.min.js'></script>
<script type="text/javascript" src='<?php echo base_url(); ?>resources/bs-custom-file-input.min.js'></script>
<link rel="stylesheet" type="text/css" href='<?php // echo base_url() . 'resources/search_contacts.css'                                                   ?>'>
<link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/jquery-ui.css' ?>'>
<link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/print_style.css' ?>' media="print">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/bootstrap-datetimepicker.min.css" /> 
<script src="<?php echo base_url() ?>assets/bootstrap-datetimepicker.min.js"></script>
<style type="text/css">
    .ui-autocomplete {
        z-index:3000
    }
</style>
<script>
    var code = "<?php echo $order_info['order_basic_info'][0]->id; ?>";
    var points = 0;
    var order_id = <?php echo $order_info['order_basic_info'][0]->id; ?>;
    var customer_id = "<?php echo $order_info['order_basic_info'][0]->customer_id; ?>";

    $(document).ready(function () {

        $("#models").autocomplete({
            source: function (req, add) {
                $.getJSON(base_url + "index.php/management/get_list_of_models_by_brand_id_model_name?brand_id=" + $("#brands_drop_down_list").val(), req, function (data) {
                    var suggestions = [];
                    $.each(data, function (i, val) {
                        console.log(val);
                        suggestions.push({
                            label: val
                        }); //not val.name
                    });
                    add(suggestions);
                });
            }
        });
        $('#submit_results').click(function () {
            var fault = $('#result_fault_description').val();
            var date = $('#result_delivery_date').val();
            var exp_cost = 0;
            var msg = "";
            var warranty = <?php echo $order_info['order_basic_info'][0]->under_warranty; ?>;
            if (fault == "")
            {
                msg += "\n<?php echo lang('fault required'); ?>";
            }

            if (warranty == 0)
            {
                if ($('#result_estimated_cost').val() == "")
                {
                    msg += "\n<?php echo lang('cost required'); ?>";
                } else
                {
                    exp_cost = parseInt($('#result_estimated_cost').val());
                }
            }

            if (msg != "")
            {
                alert(msg);
            } else
            {
                var base = "<?php echo base_url(); ?>";
                var order = "<?php echo $order_info['order_basic_info'][0]->id; ?>";
                $.ajax({
                    url: base + "index.php/order/order_examined/" + order + "/" + fault + "/" + date + "/" + exp_cost,
                    error: function () {
                    },
                    success: function (respons)
                    {
                        window.location.href = base + "index.php/order/view_order?order_id=" + order;
                    }
                });
            }
        });
        $("#cash2").keyup(function ()
        {
            if ($(this).val() != "")
            {
                $("#remaining").val(parseInt($(this).val()) - <?php echo $order_info['order_basic_info'][0]->examine_cost == null ? 0 : $order_info['order_basic_info'][0]->examine_cost; ?>);
            } else
            {
                $("#remaining").val(0 - <?php echo $order_info['order_basic_info'][0]->examine_cost == null ? 0 : $order_info['order_basic_info'][0]->examine_cost; ?>);
            }
        });
        var sum = 0;
        var cost_column = $('.final_total')
        jQuery.each(cost_column, function (number) {
            if ($(this).text() != "" && $(this).text() != "___")
            {
                sum += parseInt($(this).text());
            }
        });
        var site_url = "<?php echo site_url() ?>";
        $(".replace_points").on("click", function (event) {
            points = parseInt($(this).attr("points"));
            if (points == 50) {
                var cost = parseFloat($("#total_cost b").html());
                $("#total_cost").val(cost - points);
                $("#total_cost b").html(cost - points);
                $('#points').val(parseInt($('#points').val()) - points);
                $("#cost").val(cost - points);
            } else {
                $("#total_cost").val(0);
                $("#total_cost b").html(0);
                $('#points').val(0);
                $("#cost").val(0);
            }
            $('.replace_points').hide();
//            var url = site_url + "/order/replace_points";
//            $.ajax({
//                type: "POST",
//                url: url,
//                dataType: "json",
//                data: {
//                    "order_id": order_id,
//                    "points": phone
//                },
//                success: function (data) {
//                    $('#agreed').val("");
//                    $("input[name=call_date]").val("");
//                    $('#call_modal').modal("hide");
//                },
//                error: function (response) {
//                }
//            });
        });
        $("#save_call_action").on("click", function (event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            var no_answer = 0;

            if ($("#no_answer").prop("checked"))
                no_answer = 1;
            var agreed = $("#agreed").val();
            var datetime = $("input[name=call_date]").val();
            var order_id = <?php echo $order_info['order_basic_info'][0]->id; ?>;
            var phone = "<?php echo $order_info['order_basic_info'][0]->contact_phone; ?>";
            var email = "<?php echo $order_info['order_basic_info'][0]->contact_email; ?>";
            var url = site_url + "/order/save_call_action";
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    "agreed": agreed,
                    "date_time": datetime,
                    "order_id": order_id,
                    "phone": phone,
                    "email": email,
                    "no_answer": no_answer
                },
                success: function (data) {
                    location.reload();
                },
                error: function (response) {
                }
            });
            var html = "<tr><td>" + datetime + "</td><td><?php echo $this->session->userdata('user_name') . "</td><td>" . lang('customer called') . "</td><td>" . lang('agreed') . ": " ?>" + agreed + "</td><td></td><td class='cost'></td><td class='cost'></td>";
            $('#order_history').append(html);
            $('#agreed').val("");
            $("input[name=call_date]").val("");
            $('#call_modal').modal("hide");
        });
        if ("<?php echo $order_info['order_basic_info'][0]->company ?>" == "1") {
            if ("<?php echo $order_info['order_basic_info'][0]->company_discount ?>" != "0") {
                sum = sum - ((sum * parseInt("<?php echo $order_info['order_basic_info'][0]->company_discount ?>")) / 100);
            }
        } else if ("<?php echo $order_info['order_basic_info'][0]->company ?>" == "0") {
            if ("<?php echo $order_info['order_basic_info'][0]->contact_discount ?>" != "0") {
                sum = sum - ((sum * parseInt("<?php echo $order_info['order_basic_info'][0]->contact_discount ?>")) / 100);
            }
        }
        $("#total_cost").val(sum);
        $("#total_cost").attr("value", sum);
        $("#total_cost").html("<h3><?php echo lang('total_cost'); ?>: <b>" + sum + "</h3>");
        var s, c;
        $(".submit_btn").click(function () {
            if ($(this).attr("categories_id") == "11") {
                $('#call_modal').modal("show");
            } else {
                var status = $(this).attr("status_id");
                if (status != "6")
                {
                    var rep_cost = 0;
                    if ($("#rep_cost").val() != '')
                        rep_cost = $("#rep_cost").val();
                    var parts_cost = 0;
                    if ($("#parts_cost").val() != '')
                        parts_cost = $("#parts_cost").val();
                    var description = $("#description").val();
                    var category = $(this).attr("categories_id");
                    var action_name = $(this).attr("action_name");
                    var order_id = <?php echo $order_info['order_basic_info'][0]->id; ?>;
                    var customer_mobile = "<?php echo $order_info['order_basic_info'][0]->contact_phone; ?>";
                    var email = "<?php echo $order_info['order_basic_info'][0]->contact_email; ?>";
                    var place = "";
                    var warranty = <?php echo $order_info['order_basic_info'][0]->under_warranty; ?>;
                    if (warranty != 0)
                    {
                        rep_cost = 0;
                        parts_cost = 0;
                    }
                    if (status == "2" && !(rep_cost != '' && parts_cost != '' && description != '') && warranty == 0)
                    {
                        alert("<?php echo lang('action inputs'); ?>");
                    } else
                    {

                        if ((status == "4" || status == "5") && place == '' && "<?php echo $order_info['order_basic_info'][0]->external_repair ?>" != "1")
                        {

//                            place = window.prompt("<?php echo lang('enter place'); ?>", "");
//                            while (place == '')
//                            {
//                                place = window.prompt("<?php echo lang('enter place'); ?>", "");
//                            }
                            s = status;
                            c = category;
                            if (status == 4)
                                $('#cancel_reason').show();
                            else
                                $('#cancel_reason').hide();
                            $('#place_modal').modal("show");
                        } else {
                            if ((status == "4" || status == "5") && place == null)
                                return;
                            $(this).hide();
                            var xmlhttp = new XMLHttpRequest();
                            xmlhttp.onreadystatechange = function ()
                            {
                                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                                {
                                    var html = '<tr>' + xmlhttp.responseText;
                                    html += '<td>' + action_name + '</td><td>' + $("#description").val() + '</td><td>' + $("#rep_cost").val() + '</td><td>' + $("#parts_cost").val() + '</td><td>' + (parseInt($("#parts_cost").val()) + parseInt($("#rep_cost").val())) + '</td></tr>';
                                    $("#order_history").append(html);
                                    $("#rep_cost").val('');
                                    $("#parts_cost").val('');
                                    $("#description").val('');
                                    if (status == "5")
                                    {

                                        $("#perform_reoair_action").fadeOut(100);
                                        $("#perform_reoair_action").html('<div class="validated"><br> <br> Order is set to Done </div>');
                                        $("#perform_reoair_action").fadeIn(100);
                                    }
                                    if (status == "4")
                                    {
                                        $("#perform_reoair_action").fadeOut(100);
                                        $("#perform_reoair_action").html('<div class="validated"><br> <br>  Order is set to Cancelled </div>');
                                        $("#perform_reoair_action").fadeIn(100);
                                    }
                                }
                            }

                            var link = "<?php echo base_url(); ?>" + "index.php/order/perform_repair_action?rep_cost=" + $("#rep_cost").val() + "&parts_cost=" + $("#parts_cost").val() + "&description=" + description + "&categories_id=" + category + "&status_id=";
                            link += status + "&order_id=" + order_id + "&customer_mobile=" + customer_mobile + "&email=" + email + "&place=" + place;
                            console.log(link);
                            xmlhttp.open("GET", link, true);
                            xmlhttp.send();
                            location.reload();
                        }
                    }
                }
            }
        });
        $('#set_back_and_ready').on("click", function (event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            $('#place_warranty_modal').modal("show");
        });
        $('#save_place_warranty').on("click", function (event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            var place = $('select[name=store_place_warranty] option:selected').html();
            var select = $('select[name=machine_back]').val();
            var date = $('input[name=back_from_warranty_date]').val();
            var reason = "";
            var serial = "";
            if (select == "2")
                reason = $('input[name=out_of_warranty]').val();
            else if (select == "3")
                serial = $('input[name=new_serial_number]').val();
            $.ajax({
                type: "POST",
                url: site_url + "/order/set_to_ready_under_warranty",
                dataType: "json",
                data: {
                    order_id: "<?php echo $order_info['order_basic_info'][0]->id; ?>",
                    state: select,
                    reason: reason,
                    serial: serial,
                    place: place,
                    date: date,
                    email: "<?php echo $order_info['order_basic_info'][0]->contact_email; ?>",
                    mobile: "<?php echo $order_info['order_basic_info'][0]->contact_phone; ?>"
                },
                success: function (data) {
//                    location.href = "<?php echo site_url() ?>";
                },
                error: function (response) {

                }
            });
            location.reload();
        });
        $('#temporary_device').on("click", function (event) {
            $('#temporary_device_modal').modal("show");
        });
        $('#save_temporary_device').on("click", function (event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            var faults = $('textarea[name=faults]').val();
            var machine_type = $('select[name=machine_type]').val();
            var brands = $('select[name=brands]').val();
            var models = $('input[name=models]').val();
            var serial_number = $('input[name=serial_number]').val();
            var colors = $('select[name=colors]').val();
            var accessories = $('textarea[name=accessories]').val();
            var msg = "";
            $('#temporary_device_form_errors').html("");
            if (machine_type == 0)
            {
                msg += "<br><?php echo lang('machine type required'); ?>";
            }
            if (brands == 0)
            {
                msg += "<br><?php echo lang('brand required'); ?>";
            }
            if (models == "")
            {
                msg += "<br><?php echo lang('model required'); ?>";
            }
            if (colors == 0)
            {
                msg += "<br><?php echo lang('color') . " " . lang('required'); ?>";
            }
            if (serial_number == "")
            {
                msg += "<br><?php echo lang('serial number required'); ?>";
            }
            if (msg != "")
            {
                $('#temporary_device_form_errors').html(msg);
            } else
            {
                var data = {
                    order_id: "<?php echo $order_info['order_basic_info'][0]->id; ?>",
                    machine_type: machine_type,
                    machine_type_name: $('select[name=machine_type] option:selected').html(),
                    brands: brands,
                    brand_name: $('select[name=brands] option:selected').html(),
                    models: models,
                    colors: colors,
                    color_name: $('select[name=colors] option:selected').html(),
                    serial_number: serial_number,
                    faults: faults,
                    accessories: accessories,
                    email: "<?php echo $order_info['order_basic_info'][0]->contact_email; ?>",
                    mobile: "<?php echo $order_info['order_basic_info'][0]->contact_phone; ?>",
                    customer_name: "<?php echo $order_info['order_basic_info'][0]->contact_fname . " " . $order_info['order_basic_info'][0]->contact_lname ?>"
                };
                $.ajax({
                    type: "POST",
                    url: site_url + "/order/save_temporary_device",
                    dataType: "json",
                    data: data,
                    error: function () {
                    },
                    success: function (respons)
                    {
                        alert("fdgfdg");
                    }
                });
                print_temporary(data);
            }
        });
        $('#save_place').on("click", function (event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            var rep_cost = 0;
            if ($("#rep_cost").val() != '')
                rep_cost = $("#rep_cost").val();
            var parts_cost = 0;
            if ($("#parts_cost").val() != '')
                parts_cost = $("#parts_cost").val();
            var description = $("#description").val();
            var category = c;
            var status = s;
            var action_name = "Changed Status";
            var order_id = <?php echo $order_info['order_basic_info'][0]->id; ?>;
            var customer_mobile = "<?php echo $order_info['order_basic_info'][0]->contact_phone; ?>";
            var email = "<?php echo $order_info['order_basic_info'][0]->contact_email; ?>";
            var place = "";
            var reason = $('#cancel_reason').val();
            var warranty = <?php echo $order_info['order_basic_info'][0]->under_warranty; ?>;
            if (warranty != 0)
            {
                rep_cost = 0;
                parts_cost = 0;
            }
            var place = $('select[name=store_place] option:selected').html();
            if ((status == "4" || status == "5") && place == null)
                return;
            $(this).hide();
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function ()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    var html = '<tr>' + xmlhttp.responseText;
                    html += '<td>' + action_name + '</td><td>' + $("#description").val() + '</td><td>' + $("#rep_cost").val() + '</td><td>' + $("#parts_cost").val() + '</td><td>' + (parseInt($("#parts_cost").val()) + parseInt($("#rep_cost").val())) + '</td></tr>';
                    $("#order_history").append(html);
                    $("#rep_cost").val('');
                    $("#parts_cost").val('');
                    $("#description").val('');
                    if (status == "5")
                    {

                        $("#perform_reoair_action").fadeOut(100);
                        $("#perform_reoair_action").html('<div class="validated"><br> <br> Order is set to Done </div>');
                        $("#perform_reoair_action").fadeIn(100);
                    }
                    if (status == "4")
                    {
                        $("#perform_reoair_action").fadeOut(100);
                        $("#perform_reoair_action").html('<div class="validated"><br> <br>  Order is set to Cancelled </div>');
                        $("#perform_reoair_action").fadeIn(100);
                    }
                }
            }

            var link = "<?php echo base_url(); ?>" + "index.php/order/perform_repair_action?rep_cost=" + rep_cost + "&parts_cost=" + parts_cost + "&description=" + description + "&categories_id=" + category + "&status_id=";
            link += status + "&order_id=" + order_id + "&customer_mobile=" + customer_mobile + "&email=" + email + "&place=" + place + "&reason=" + reason;
            console.log(link);
            xmlhttp.open("GET", link, true);
            xmlhttp.send();
            location.reload();
        });
    }
    );
    $(document).ready(function () {
        $("#serial_number, #models").on("keydown", function (e) {
//            if (e.ctrlKey) {
//                return;
//            }
            var characters = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "-", "_"];
            var keyCode = (window.event) ? e.which : e.keyCode;
//            alert( e.which);
            if (keyCode >= 65 && keyCode <= 90) {
                this.value += characters[keyCode - 65];
                return false;
            } else if ((keyCode < 8 || keyCode > 105) && keyCode != 189 && keyCode != 109) {
                this.value += '';
                return false;
            }
        });
        $("#PayButton").click(function () {
            var Receipt = 1;
            var IDnum = null;
            var done = true;
            var receipt_name = "";
            if ($('#noReceipt').is(':checked'))
            {
                if ($('#IDnum').val() == '')
                {
                    alert("<?php echo lang('required_id'); ?>");
                    done = false;
                }
                if ($('#receipt').val() == '')
                {
                    alert("<?php echo lang('receipt_required'); ?>");
                    done = false;
                } else
                {
                    Receipt = 0;
                    IDnum = parseInt($('#IDnum').val());
                    receipt_name = $('#receipt').val();
                }
            }

            var cash_val = 0;
            if ($("#cash").val() != "")
            {
                cash_val = $("#cash").val();
            }

            if (parseInt(cash_val) < parseInt($("#total_cost").val()) || parseInt(cash_val) > parseInt($("#total_cost").val()))
            {
                done = false;
                alert("<?php echo lang('cash_error'); ?>" + $("#total_cost").val());
            }


            if (done == true)
            {
                $(this).hide();
                var cost = $("#cost").val();
                var description = $("#description").val();
                var category = $(this).attr("categories_id");
                var status = $(this).attr("status_id");
                var action_name = $(this).attr("action_name");
                var discount = $("#discount").val();
                var order_id = <?php echo $order_info['order_basic_info'][0]->id; ?>;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function ()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
//                        location.reload();
                        print_bill();
                        $("#perform_reoair_action").fadeOut(100);
                        $("#deliver_to_customer").fadeOut(100);
                        $("#deliver_to_customer").html('<div class="validated"><br> <br>  Order is set to Closed </div>');
                        $("#deliver_to_customer").fadeIn(100);
                    }
                }
                var email = "<?php echo $order_info['order_basic_info'][0]->contact_email; ?>";
                var link = "<?php echo base_url(); ?>" + "index.php/order/set_order_closed?order_id=" + order_id + "&cost=" + $("#cash").val() + "&Receipt=" + Receipt + "&ID=" + IDnum + "&receipt_name=" + receipt_name + "&email=" + email + "&phone=" + "<?php echo $order_info['order_basic_info'][0]->contact_phone; ?>" + "&discount=" + discount + "&points=" + points;
                xmlhttp.open("GET", link, true);
                xmlhttp.send();
            }
        });
        $("#DistructedButton").click(function () {
            $(this).hide();
            var order_id = <?php echo $order_info['order_basic_info'][0]->id; ?>;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function ()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    location.reload();
                    $("#perform_reoair_action").fadeOut(100);
                    $("#deliver_to_customer").fadeOut(100);
                    $("#deliver_to_customer").html('<div class="validated"><br> <br>  Order is set to distructed </div>');
                    $("#deliver_to_customer").fadeIn(100);
                }
            }
            var email = "<?php echo $order_info['order_basic_info'][0]->contact_email; ?>";
            var link = "<?php echo base_url(); ?>" + "index.php/order/set_distructed?order_id=" + order_id + "&email=" + email + "&phone=" + "<?php echo $order_info['order_basic_info'][0]->contact_phone; ?>";
            xmlhttp.open("GET", link, true);
            xmlhttp.send();
        });
        $(".datetimepicker").datetimepicker({format: 'yyyy-mm-dd hh:ii:00'});

    });
    function machine_back(ob) {
        if ($(ob).val() == "1")
        {
            $('input[name=out_of_warranty]').hide();
            $('input[name=new_serial_number]').hide();
        } else if ($(ob).val() == "2")
        {
            $('input[name=out_of_warranty]').show();
            $('input[name=new_serial_number]').hide();
        } else if ($(ob).val() == "3")
        {
            $('input[name=out_of_warranty]').hide();
            $('input[name=new_serial_number]').show();
        }
    }

</script>
<?php
if ($order_info['order_basic_info'][0]->canceled == 1) {
    echo '<div class="panel panel-danger" id="containerforhide">';
} else {
    echo '<div class="panel panel-default" id="containerforhide">';
}
?>

<div class="panel-heading clearfix" style="text-align: center" >
            <?php $user_permissions = $this->session->userdata('user_permissions'); ?>
    <div class="row">
        <div id="edit_order" class="col-md-4 btn-group pull-left main_menu_item">
<?php if (permission_included($user_permissions, 'Modify an order')) { ?>
                <button onclick = "location.href = '<?php echo base_url() ?>index.php/order/edit_order_page/<?php echo $order_info['order_basic_info'][0]->id ?>';"
                        class="btn btn-success btn-sm">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
    <?php echo lang('change') ?>
                </button>
                <button id="deletion"
                        class="btn btn-danger btn-sm">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                <?php echo lang('delete') ?>
                </button>
                <?php
            }
            $id = $order_info['order_basic_info'][0]->id;
            ?>
            <button onclick="print_paper();"
                    class="btn btn-info btn-sm">
                <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
<?php echo lang('print') ?>
            </button>
            <!--                <button onclick="print_sticker();"
                                    class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
<?php echo lang('print_sticker') ?>
                            </button>-->
        </div>
        <div class="col-md-4">
            <h2 style="display: inline">
                <?php echo lang('order'); ?> #<?php echo $order_info['order_basic_info'][0]->id ?>
                <?php
                if ($just_received != 1) {
                    echo "<h3 style='margin-top:5px; margin-bottom: 5px'>" . lang($order_info['current_status']->name) . "</h3>";
                }
                if ($order_info['order_basic_info'][0]->distructed == 1)
                    echo "<h4 style='margin-top:5px; margin-bottom: 5px;color:#a94442;'>" . lang('distructed') . "</h4>";
                if ($order_info['order_basic_info'][0]->canceled == 1) {
                    echo '<br><h4>الطلب ملغي</h4>';
                }
                ?>
            </h2>
        </div>
    </div>
</div>
<div class="panel-body"  >
    <script>
        $(document).ready(function () {
            var msg = <?php echo json_encode(lang("confirm_delete_msg")); ?>;
            $('#deletion').click(function () {
                var conf = confirm(language.confirm_delete);
                if (conf == true)
                {
                    var id = <?php echo json_encode($id); ?>;
                    var b_url = "<?php echo base_url(); ?>";
                    $.ajax({
                        url: base_url + "index.php/order/delete_order/" + id,
                        //type: "POST",
                        error: function () {
                        },
                        success: function () {
                            window.location.href = base_url + "/index.php/order/header";
                        }
                    });
                }
            });
        });
    </script>

    <h2 align="center">
        <?php
        echo lang('customer_info') . "<br>";
//            if ($order_info['order_basic_info'][0]->contact_rate != '0') {
        if ($order_info['order_basic_info'][0]->contact_rate == '1') {
            $class = "selected-face";
        } else
            $class = "face";
        ?>
        <img rate="1" class="<?php echo $class ?>" width="45px" height="40px" src="<?php echo base_url() ?>resources/images/sad.png" />
        <?php
        if ($order_info['order_basic_info'][0]->contact_rate == '2') {
            $class = "selected-face";
        } else
            $class = "face";
        ?>
        <img  rate="2" class="<?php echo $class ?>" style="margin-top: -4px;" width="50px" height="43px" src="<?php echo base_url() ?>resources/images/normal.png" />
        <?php
        if ($order_info['order_basic_info'][0]->contact_rate == '3') {
            $class = "selected-face";
        } else
            $class = "face";
        ?>
        <img   rate="3" class="<?php echo $class ?>" width="45px" height="40px" src="<?php echo base_url() ?>resources/images/happy.png" />
        <?php
//            }
        ?>
    </h2>
    <div class = "row cont-inf">
        <?php if ($order_info['order_basic_info'][0]->company != "0") {
            ?>
                <?php if ($order_info['order_basic_info'][0]->company_name != "") { ?>
                <div class="col-md-3">
                    <h4><?php echo lang('company_name'); ?></h4>
                <?php echo $order_info['order_basic_info'][0]->company_name;
                ?>
                </div>
    <?php } ?>
            <?php } ?>
        <div class="col-md-3">
            <h4><?php echo lang('customer_name'); ?></h4>
<?php echo $order_info['order_basic_info'][0]->contact_fname . " " . $order_info['order_basic_info'][0]->contact_lname; ?>
        </div>
        <div class="col-md-3">
            <h4><?php echo lang('phone'); ?></h4>
        <?php echo '966' . $order_info['order_basic_info'][0]->contact_phone;
        ?>
        </div>
<?php if ($order_info['order_basic_info'][0]->contact_address != '') {
    ?>
            <div class="col-md-3">
                <h4><?php echo lang('address'); ?></h4>
            <?php echo $order_info['order_basic_info'][0]->contact_address; ?>
            </div>
        <?php } ?>
<?php if ($order_info['order_basic_info'][0]->contact_email != '') {
    ?>
            <div class="col-md-3">
                <h4><?php echo lang('email'); ?></h4>
            <?php echo $order_info['order_basic_info'][0]->contact_email; ?>
            </div>
            <?php } ?>
        <div class="col-md-3">
            <h4><?php echo lang('customer_points'); ?></h4>
<?php echo $order_info['order_basic_info'][0]->customer_points ?>
        </div>
        <div class="col-md-3">
            <h4><?php echo lang('customer_discount'); ?></h4>
        <?php echo $order_info['order_basic_info'][0]->contact_discount . " %" ?>
        </div>
            <?php if ($just_received == 1) { ?>
            <div class="col">
                <h4><?php echo lang('date'); ?></h4>
            <?php echo $order_info['actions'][0]->date; ?>
            </div>
<?php }
?>
    </div>
    <div class="row cont-inf2">
        <h2 align="center"><?php echo lang('machine_info'); ?></h2>
        <div class="col-md-3">
            <h4><?php echo lang('serial_no'); ?></h4>
            <?php
            echo $order_info['order_basic_info'][0]->serial_number;
            ?>
        </div>

        <div class="col-md-3">
            <h4><?php echo lang('model'); ?></h4>
<?php echo $order_info['order_basic_info'][0]->model_name; ?>
        </div>
        <div class="col-md-3">
            <h4><?php echo lang('brand'); ?></h4>
<?php echo $order_info['order_basic_info'][0]->brand_name; ?>
        </div>


        <div class="col-md-3">
            <h4><?php echo lang('machine_type'); ?></h4>
<?php echo $order_info['order_basic_info'][0]->machine_type; ?>
        </div>
        <br><br><br><br>
        <div class="col mach">
            <div class="col-md-3">
                <h4><?php echo lang('color'); ?></h4>
<?php echo $order_info['order_basic_info'][0]->color_name; ?>
            </div>
            <!--                    <div class="col-md-3">
                                    <h4><?php echo lang('under_waranty'); ?></h4>
            <?php
            if ($order_info['order_basic_info'][0]->under_warranty == 1) {
                echo lang('YES') . "</div>";
                ?>
                                                                                                                                                                                                            
    <?php if ($order_info['order_basic_info'][0]->billNumber != null) {
        ?>
                                                                                                                                                                                                                <div class="col">
                                                                                                                                                                                                                <h4><?php echo lang('billNumber'); ?></h4>
                    <?php echo $order_info['order_basic_info'][0]->billNumber; ?>
                                                                                                                                                                                                                </div>
                    <?php
                }
                if ($order_info['order_basic_info'][0]->billDate != null) {
                    ?>
                                                                                                                                                                                                                <div class="col">
                                                                                                                                                                                                                <h4><?php echo lang('billDate'); ?></h4>
                    <?php echo $order_info['order_basic_info'][0]->billDate; ?>
                                                                                                                                                                                                                </div>
                    <?php
                }
            } else {
                echo lang('NO') . "</div>";
            }
            ?>
                                </div>-->
            <div class="col-md-3 pull-right">
                <h4><?php echo lang('faults'); ?></h4>
                <?php
                if ($order_info['order_basic_info'][0]->faults != "") {
                    echo $order_info['order_basic_info'][0]->faults . "</div>";
                } else {
                    echo lang('not_exist') . "</div>";
                }
                ?>
<?php if ($order_info['order_basic_info'][0]->image != "") { ?>
                    <div class="col-md-3 pull-right">
                        <img width="200px" height="200px" src="<?php echo base_url() . "resources/machines/" . $order_info['order_basic_info'][0]->image ?>"/>
                    </div>
<?php } ?>
            </div>

        </div>

        <div class="row cont-inf">

            <div class="col cont-inf">

                <h4><?php echo lang('service'); ?>:

                </h4>  

                <?php
                if ($order_info['order_basic_info'][0]->software == 1)
                    echo " <img width='30px' height='30px' src='" . base_url() . "resources/images/software.png'/> software برامج ";
                if ($order_info['order_basic_info'][0]->new_software == 1)
                    echo " <img width='30px' height='30px' src='" . base_url() . "resources/images/sw_pack.png'/> new device software برمجة جهاز جديد";
                if ($order_info['order_basic_info'][0]->electronic == 1)
                    echo "  <img width='30px' height='30px' src='" . base_url() . "resources/images/electronic.png'/> electronic الكترونيات  ";
                if ($order_info['order_basic_info'][0]->external_repair == 1)
                    echo "  <img width='30px' height='30px' src='" . base_url() . "resources/images/external.png'/> external صيانة خارجية  ";
                if ($order_info['order_basic_info'][0]->under_warranty == 1)
                    echo "  <img width='30px' height='30px' src='" . base_url() . "resources/images/warranty.png'/> warranty ضمان";
                ?>

                <h4 align="">
<?php echo lang('fault_description'); ?>
            <?php echo $order_info['order_basic_info'][0]->fault_description; ?> 
                </h4>
            </div>
            <?php
            if ($order_info['current_status']->status_id == 5 || $order_info['current_status']->status_id == 6) {
                if ($order_info['order_basic_info'][0]->under_warranty != 1) {
                    if ($order_info['order_basic_info'][0]->spare_parts_cost + $order_info['order_basic_info'][0]->repair_cost == 0) {
                        ?>
                        <div class="col-md-3">
                            <h4><?php echo lang('examining_cost'); ?></h4>
                        <?php echo $order_info['order_basic_info'][0]->examine_cost ?>
                        </div>
        <?php } else {
            ?>
                        <div class="col-md-3">
                            <h4><?php echo lang('repair_cost'); ?></h4>
            <?php echo $order_info['order_basic_info'][0]->repair_cost ?>
                        </div>
                        <div class="col-md-3">
                            <h4><?php echo lang('spare_parts_cost'); ?></h4>
            <?php echo $order_info['order_basic_info'][0]->spare_parts_cost ?>
                        </div>
                        <div class="col-md-3">
                            <h4><?php echo lang('total_cost'); ?></h4>
                        <?php echo $order_info['order_basic_info'][0]->spare_parts_cost + $order_info['order_basic_info'][0]->repair_cost ?>
                        </div>							
                        <?php
                        if ($order_info['order_basic_info'][0]->discount != 0) {
                            echo '<div class="col-md-3"><h4>';
                            echo lang('discount');
                            echo ': ';
                            echo $order_info['order_basic_info'][0]->discount . " ر.س";
                            echo '</h4></div>';
                        }
                        if ($order_info['order_basic_info'][0]->company == 1) {
                            if ($order_info['order_basic_info'][0]->company_discount != 0) {
                                echo '<div class="col-md-3"><h4>';
                                echo lang('company_discount');
                                echo ': ';
                                echo $order_info['order_basic_info'][0]->company_discount . "%";
                                echo '</h4></div>';
                            }
                        } else if ($order_info['order_basic_info'][0]->company == 0) {
                            if ($order_info['order_basic_info'][0]->contact_discount != 0) {
                                echo '<div class="col-md-3"><h4>';
                                echo lang('customer_discount');
                                echo ': ';
                                echo $order_info['order_basic_info'][0]->contact_discount . "%";
                                echo '</h4></div>';
                            }
                        }
                    }
                }
            }
            if ($order_info['order_basic_info'][0]->external_repair == 1) {
                if ($order_info['order_basic_info'][0]->status_id != 5 && $order_info['order_basic_info'][0]->status_id != 6 && $order_info['order_basic_info'][0]->status_id != 4) {
                    ?>
                    <div class = "col-md-3">
                        <h4><?php echo lang('visite_date');
                    ?></h4>
        <?php echo $order_info['order_basic_info'][0]->visite_date ?>
                    </div>
                    <div class="col-md-3">
                        <h4><?php echo lang('visite_cost'); ?></h4>
        <?php echo $order_info['order_basic_info'][0]->visite_cost; ?>
                    </div>
                    <div class="col-md-3">
                        <h4><?php echo lang('cost_estimation'); ?></h4>
                    <?php echo $order_info['order_basic_info'][0]->estimated_cost; ?>	
                    </div>
                    <?php
                }
            }
            if ($order_info['order_basic_info'][0]->under_warranty != 1) {
                if ($order_info['order_basic_info'][0]->examine_date == 0 && $order_info['order_basic_info'][0]->status_id != 5 && $order_info['order_basic_info'][0]->status_id != 6 && $order_info['order_basic_info'][0]->status_id != 4) {
                    ?>
                    <div class="col-md-3">
                        <h4><?php echo lang('total_cost'); ?></h4>
        <?php echo $order_info['order_basic_info'][0]->spare_parts_cost + $order_info['order_basic_info'][0]->repair_cost ?>
                    </div>
                    <div class="col-md-3">
                        <h4><?php echo lang('delivery_date'); ?></h4>
                    <?php echo lang('during') . " " . $order_info['order_basic_info'][0]->delivery_date . " " . lang('work_day'); ?>
                    </div>
        <?php if ($order_info['order_basic_info'][0]->under_warranty != 1) {
            ?>
                        <div class="col-md-3">
                            <h4><?php echo lang('cost_estimation'); ?></h4>
                        <?php echo $order_info['order_basic_info'][0]->estimated_cost; ?>	
                        </div>
                        <?php
                    }
                } else if ($order_info['order_basic_info'][0]->delivery_date == 0 && $order_info['order_basic_info'][0]->status_id != 5 && $order_info['order_basic_info'][0]->status_id != 6 && $order_info['order_basic_info'][0]->status_id != 4) {
                    ?>
                    <div class="col-md-3">
                        <h4><?php echo lang('examine_date'); ?></h4>
                    <?php echo lang('during') . " " . $order_info['order_basic_info'][0]->examine_date . " " . lang('day'); ?>
                    </div>
        <?php if ($order_info['order_basic_info'][0]->under_warranty != 1) {
            ?>
                        <div class="col-md-3">
                            <h4><?php echo lang('examining_cost'); ?></h4>
                        <?php echo $order_info['order_basic_info'][0]->examine_cost; ?>
                        </div>
                        <?php
                    }
                }
            }
            if ($order_info['order_basic_info'][0]->new_software == 1) {
                ?>
                <div class="col-md-3">
                    <h4><?php echo lang('billNumber'); ?></h4>
    <?php echo $order_info['order_basic_info'][0]->billNumber ?>
                </div>
                <div class="col-md-3">
                    <h4><?php echo lang('billDate'); ?></h4>
                <?php echo $order_info['order_basic_info'][0]->billDate; ?>
                </div>
                <?php
            }
            if ($order_info['order_basic_info'][0]->under_warranty == 1) {
                ?>
                <div class="col-md-3">
                    <h4><?php echo lang('billNumber'); ?></h4>
    <?php echo $order_info['order_basic_info'][0]->billNumber ?>
                </div>
                <div class="col-md-3">
                    <h4><?php echo lang('billDate'); ?></h4>
    <?php echo $order_info['order_basic_info'][0]->billDate; ?>
                </div>
                <div class="col-md-3">
                    <h4><?php echo lang('warranty_period'); ?></h4>
    <?php echo $order_info['order_basic_info'][0]->warranty_period . " " . lang('year'); ?>	
                </div>
                <div class="col-md-3">
                    <h4><?php echo lang('warranty_times'); ?></h4>
                <?php echo ($order_info['order_basic_info'][0]->warranty_times != 0) ? $order_info['order_basic_info'][0]->warranty_times : lang('not_exist'); ?>	
                </div>
    <?php if ($order_info['order_basic_info'][0]->sent != 0) { ?>
                    <div class="row">        
                        <!--                            <div class="col-md-3">
                                                        <h4><?php echo lang('received'); ?></h4>
                                                    </div>-->
                        <div class="col-md-3">
                            <h4><?php echo lang('shipping_company'); ?></h4>
        <?php echo $order_info['order_basic_info'][0]->shipping_company ?>
                        </div>
                        <div class="col-md-3">
                            <h4><?php echo lang('bill_of_lading'); ?></h4>
        <?php echo $order_info['order_basic_info'][0]->bill_of_lading; ?>
                        </div>
                        <div class="col-md-3">
                            <h4><?php echo lang('agent_name'); ?></h4>
        <?php echo $order_info['order_basic_info'][0]->agent_name; ?>	
                        </div>
                        <div class="col-md-3">
                            <h4><?php echo lang('received_date'); ?></h4>
        <?php echo $order_info['order_basic_info'][0]->received_date; ?>	
                        </div>
                        <div class="col-md-3">
                            <h4><?php echo lang('arrived_receipt_number'); ?></h4>
        <?php echo $order_info['order_basic_info'][0]->arrived_receipt_number ?>
                        </div>
                        <div class="col-md-3">
                            <h4><?php echo lang('receipt_employee'); ?></h4>
                    <?php echo $order_info['order_basic_info'][0]->receipt_employee_name; ?>
                        </div>
                    </div>
                    <?php
                }
            }

            if ($order_info['order_basic_info'][0]->external_repair != 0) {
                ?>
                <!--                        <div class="col-md-3">
                                            <h4><?php echo lang('external_repair'); ?></h4>
                                        </div>-->
        <?php } ?>
        </div>
        <?php
        if ($order_info['order_basic_info'][0]->temporary_device) {
            $device = $order_info['order_basic_info'][0]->temporary_device;
            ?>
            <div class="row cont-inf2">   
                <h4><?php echo lang('temporary_device_given') ?></h4>

                <div class="col-md-3">
                    <h4><?php echo lang('machine_type'); ?></h4>
    <?php echo $device->machine_type ?>
                </div>
                <div class="col-md-3">
                    <h4><?php echo lang('brand'); ?></h4>
    <?php echo $device->brand; ?>
                </div>
                <div class="col-md-3">
                    <h4><?php echo lang('model'); ?></h4>
    <?php echo $device->model; ?>	
                </div>
                <div class="col-md-3">
                    <h4><?php echo lang('color'); ?></h4>
    <?php echo $device->color; ?>	
                </div>
                <div class="col-md-3">
                    <h4><?php echo lang('serial_no'); ?></h4>
                <?php echo $device->serial_number; ?>	
                </div>
                    <?php if ($device->faults != "") { ?>
                    <div class="col-md-3">
                        <h4><?php echo lang('faults'); ?></h4>
                    <?php echo $device->faults; ?>	
                    </div>
    <?php } ?>
                    <?php if ($device->accessories != "") { ?>
                    <div class="col-md-3">
                        <h4><?php echo lang('accessories'); ?></h4>
                    <?php echo $device->accessories; ?>	
                    </div>
            <?php } ?>
            </div>
            <?php } ?>
        <div class="row cont-inf2">
            <?php
            if ($order_info['accessories']->notes != "") {
                echo '<h3>' . lang("accessories") . '</h3>';

                echo '<td>' . $order_info['accessories']->notes . '</td>';
            } else {
                echo '<h3>' . lang("accessories") . '</h3>';

                echo lang('not_exist');
            }
            ?>
        </div>
        <div class="row cont-inf2">
            <h2 align="center"><?php echo lang('notes'); ?> </h2>
            <?php
            if ($order_info['order_basic_info'][0]->notes != '')
                echo $order_info['order_basic_info'][0]->notes . "<br>";
            else if ($order_info['order_basic_info'][0]->notes == '' && $order_info['order_basic_info'][0]->Receipt == 1)
                echo lang('not_exist');
            if ($order_info['order_basic_info'][0]->Receipt != 1) {// && $just_received)
                echo "<h4>" . lang('No Receipt') . "<br>" . lang('ID') . "</h4>" . $order_info['order_basic_info'][0]->receipt_name . " " . $order_info['order_basic_info'][0]->IDnum . "<br>";
            }
            ?>
            <?php
            if ($order_info['current_status']->status_id != 5 && $order_info['current_status']->status_id != 6 && $order_info['order_basic_info'][0]->under_warranty != 1) {
                echo "<br><br>" . lang('order_tech') . " : ";
                echo $order_technician;
            }
            if ($order_info['order_basic_info'][0]->under_warranty == 1) {
                echo '<h4>';
                echo lang('order_received_by');
                echo ': ';
                echo $order_info['actions'][0]->user_name;
                echo '</h4>';
            }
            if ($order_info['order_basic_info'][0]->allow_losing_data == 1) {
                echo '<h4>';
                echo lang('allow_losing_data');
                echo ': ';
                echo lang('YES');
                echo '</h4>';
            } else {
                
            }
            ?>
        </div>
        <div class="row">
            <h2 align="center" <?php
            if ($just_received == 1) {
                echo 'style="display:none;"';
            }
            ?>><?php echo lang('order_history'); ?></h2>
            <div class="table_div_" <?php
            if ($just_received == 1) {
                echo 'style="display:none;"';
            }
            ?>>
                <div style="text-align: right" class ="table-responsive">
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
                                        echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang($action->name) . "</td><td>" . (($order_info['order_basic_info'][0]->external_repair != 1 and $order_info['order_basic_info'][0]->canceled == 0) ? lang('place') . " :" : "") . $action->description . "</td><td></td>";
                                    else if ($action->categories_id == 5) {
                                        if ($order_info['order_basic_info'][0]->Receipt != 1) {
                                            echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang($action->name) . "</td><td>" . lang('ID') . $order_info['order_basic_info'][0]->receipt_name . " " . $order_info['order_basic_info'][0]->IDnum . "</td>";
                                        } else {
                                            echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang($action->name) . "</td><td>" . $action->description . "</td>";
                                        }
                                    } else if ($action->categories_id == 11) {
                                        echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang($action->name) . "</td><td>" . lang('agreed') . ": " . $action->description . "</td><td></td>";
                                    } else if ($action->categories_id == 13) {
                                        echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang('machine_back') . " " . $action->description . "</td><td>" . lang($action->description) . " ";
                                        if ($order_info['order_basic_info'][0]->state_after_repairing == 1)
                                            echo lang('repaired');
                                        else if ($order_info['order_basic_info'][0]->state_after_repairing == 2) {
                                            echo lang('out_of_warranty') . ", " . lang('reason_out_of_warranty') . ": " . $order_info['order_basic_info'][0]->out_of_warranty_reason;
                                        } else if ($order_info['order_basic_info'][0]->state_after_repairing == 3)
                                            echo lang('replaced') . " " . lang('serial_no') . ": " . $order_info['order_basic_info'][0]->new_machine_serial_number;
                                        echo "</td><td></td>";
                                    } else
                                        echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang($action->name) . "</td><td>" . $action->description . "</td>";

                                    echo "<td class = 'cost'></td><td class = 'cost'>";
                                    echo "</td><td ></td>";
                                }
                                else {
                                    echo "<tr><td>" . $action->date . "</td><td>" . $action->user_name . "</td><td>" . lang($action->name) . "</td><td>" . $action->description . "</td><td class = 'cost'>" . $action->repair_cost . "</td><td class = 'cost'>";
                                    echo $action->spare_parts_cost . "</td><td class='final_total' >" . ($action->spare_parts_cost + $action->repair_cost) . "</td>";
                                }
                            }
                            ?>	
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        if ($order_info['order_basic_info'][0]->under_warranty == 1 and ! ( $order_info['current_status']->status_id == 4 or $order_info['current_status']->status_id == 5)) {
            ?>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <h2 align="center"><br><?php echo lang('machine_back') ?></h2>
                    <br>
                    <select class="form-control" name="machine_back" onchange="machine_back(this)">
                        <option value="1"><?php echo lang('repaired') ?></option>
                        <option value="2"><?php echo lang('out_of_warranty') ?></option>
                        <option value="3"><?php echo lang('replaced') ?></option>
                    </select> <br>
                    <input type="text" class="form-control datepicker" name="back_from_warranty_date" />
                    <br>
                    <input style="display: none" class="form-control" type="text" name="out_of_warranty" placeholder="<?php echo lang('reason_out_of_warranty') ?>" />

                    <input style="display: none" class="form-control" type="text" name="new_serial_number" placeholder="<?php echo lang('serial_no') ?>" />
                    <br>
                    <input class="btn btn-primary" style="width:auto !important" id="set_back_and_ready" type="submit" value="<?php echo lang('set_order_status_to_done') ?>" /><br>
                    <?php if (!$order_info['order_basic_info'][0]->temporary_device) { ?>
                        <input class="btn btn-primary" style="width:auto !important" id="temporary_device" type="submit" value="<?php echo lang('temporary_device') ?>" />
    <?php } ?>
                </div>
                <div class="col-md-4"></div>
            </div>
            <?php } else {
                ?>
            <div class="row" id= "perform_reoair_action">
                <?php
                $uname = trim($this->session->userdata('user_name'));
                $order_technician = trim($order_technician);

                if (permission_included($user_permissions, 'Perform Repair Action')
                        // and ($order_technician == $uname)
                        and $order_info['current_status']->status_id == 2) {
                    if ($order_info['current_status']->categories_id == 9) {
                        echo '<h2 align="center"><br>' . lang('examining_result') . '</h2>';
                        echo '<h4>' . lang('fault_description') . '</h4>';
                        echo '<textarea rows = "3" cols="40" style="width: 45%; min-width: 45%; max-width: 45%" class="form-control" name="description" id="result_fault_description"></textarea>';
                        echo '<h4>' . lang('cost_estimation') . '</h4>';
                        echo '<input style="width: 30%" type="text" name="cost" id="result_estimated_cost" class="form-control input-md numeric_input" min=0/>';
                        echo '<h4>' . lang('delivery_date') . '</h4>';
                        $options = array();
                        for ($i = 1; $i <= 100; $i++) {
                            $options[$i] = $i;
                        }
                        echo lang('during') . " " . form_dropdown('result_expected_examine_date', $options, '', 'id="result_delivery_date"') . " " . lang('work_day');
                        echo '<input  class="submit_btn3" type="submit" name="submit" id="submit_results" value="' . lang('submit') . '" status_id="2" categories_id="3" action_name="Repair Action Performed" /><br>';
                        echo '<input class="submit_btn" type="submit" name="submit" id="submit" value="' . lang('set_order_status_to_cancelled') . '!" status_id="4" categories_id="4" action_name="Cancelled" status_name="Cancelled"/><br>';
                    } else {
                        echo '<div class="row">';
                        echo '<div class="col">';
                        echo '<h2 align="center"><br>' . lang('perform_repair_action') . '</h2>';
                        echo '<h4>' . lang('description') . ' </h4>';
                        echo '<textarea rows = "3" cols="40" name="description" style="width: 45%; min-width: 45%; max-width: 45%" class="form-control" id="description"></textarea>';
                        echo '<h4>' . lang('repair_cost') . '</h4>';
                        echo '<input type="text" style="width: 30%" name="cost" id="rep_cost" value="0" class="form-control input-md numeric_input" min=0/>';
                        if ($order_info['order_basic_info'][0]->electronic == 1 ||
                                $order_info['order_basic_info'][0]->external_repair == 1
                        ) {
                            echo '<h4>' . lang('spare_parts_cost') . '</h4>';

                            echo '<input type="text" style="width: 30%" name="cost" id="parts_cost" value="0" class="form-control input-md numeric_input" min=0/>';
                        }
                        ?>
                        <div class="input-group mt-3">
                            <!--<br>-->
                            <h4><?php echo lang('replace_image') ?></h4>
                            <div class="custom-file">
                                <input id="inputGroupFile01" name="replace_image" type="file" class="custom-file-input">
                                <label class="custom-file-label" for="inputGroupFile01"></label>
                            </div>
                        </div>
                        <?php
                        echo '<h4>' . lang('total') . ': </h4>';
                        echo '<input type="text" style="width: 30%" id="tot" value="0" class="form-control input-md numeric_input" readonly = "readonly"/>';

                        echo '<br>';

                        echo '<input class="submit_btn sub_btn" type="submit" name="submit" id="submit" value="' . lang('save_action') . '!" status_id="2" categories_id="3" action_name="Repair Action Performed" /><br>';

                        if ($order_info['order_basic_info'][0]->external == 1)
                            echo '<input class="submit_btn" type="submit" name="submit" id="ready" value="' . lang('set_to_ready_external') . '" status_id="5" categories_id="7" action_name="Changed Status" status_name="Ready"/><br></div>';
                        else {

                            echo '<input class="submit_btn" type="submit" name="submit" id="ready" value="' . lang('set_order_status_to_done') . '" status_id="5" categories_id="7" action_name="Changed Status" status_name="Ready"/><br></div>';
                        }
                        echo '<input class="submit_btn" type="submit" name="submit" id="customer_call" value="' . lang('customer_call') . '" status_id="4" categories_id="11" action_name="customer called" status_name="Ready"/><br>';
                        echo '<input class="submit_btn" type="submit" name="submit" id="cancel" value="' . lang('set_order_status_to_cancelled') . '!" status_id="4" categories_id="4" action_name="Cancelled" status_name="Cancelled"/><br>';
                        echo '<a id="send" class="submit_btn" href="' . base_url() . 'index.php/order/load_message_page/' . $order_info['order_basic_info'][0]->id . '/';
                        echo $order_info['order_basic_info'][0]->contact_phone . '">' . lang('send_message_to_customer') . '</a><br>';
                        echo '</div></div>';
                    }
                }
                ?>

            </div>
            <?php } ?>
        <div id= "deliver_to_customer" class="row">
            <?php
            if (permission_included($user_permissions, 'Receive an order')
                    and ( $order_info['current_status']->status_id == 4 or $order_info['current_status']->status_id == 5) and $order_info['order_basic_info'][0]->canceled == 0) {
                echo '<br>';
                if ($order_info['order_basic_info'][0]->external_repair != 1)
                    echo '<h2 align="center">' . lang('deliver_to_customer') . '</h2>';
                else
                    echo '<h2 align="center">' . lang('export_bill') . '</h2>';
                if ($order_info['order_basic_info'][0]->under_warranty == 1)
                    $btn = lang('deliver_to_customer');
                else
                    $btn = lang('pay');
                if ($order_info['order_basic_info'][0]->under_warranty != 1) {
                    if ($order_info['current_status']->status_id == 4) {
                        echo '<h4>' . lang('total_cost') . " (" . lang('examining_cost') . ")" . $order_info['order_basic_info'][0]->examine_cost . '</h4>';
                        echo '<h4>' . lang('cash') . '</h4>';
                        echo '<input type="text" id="cash2" id="cash2" style="width: 30%" class="form-control input-md numeric_input" min=0.0/>';
                    } else {
                        echo '<h4 id="total_cost" colspan=2></h4>';
                        echo '<h4>' . lang('cash') . '</h4>';
                        echo '<input type="text" id="cash" id="cash" style="width: 30%" class="form-control input-md numeric_input" class="numeric_input" min=0.0/>';
                    }
                    echo '<h4>' . lang('discount') . ': </h4>';
                    echo '<input type="text" id="discount" style="width: 30%" class="form-control input-md numeric_input" value="0"  />';
                    if (
                            $order_info['order_basic_info'][0]->company == 1 &&
                            $order_info['order_basic_info'][0]->company_discount != 0
                    ) {
                        echo '<h4>' . lang('company_discount') . ': </h4>';
                        echo '<input type="text" id="discount" style="width: 30%" class="form-control input-md numeric_input" disabled value="' . $order_info['order_basic_info'][0]->company_discount . '%"  />';
                    } else if (
                            $order_info['order_basic_info'][0]->company == 0 &&
                            $order_info['order_basic_info'][0]->contact_discount != 0
                    ) {
                        echo '<h4>' . lang('customer_discount') . ': </h4>';
                        echo '<input type="text" id="discount" style="width: 30%" class="form-control input-md numeric_input" disabled value="' . $order_info['order_basic_info'][0]->contact_discount . '%"  />';
                    }
                    echo '<h4>' . lang('customer_points') . ': </h4>';
                    echo '<input type="text" id="points" style="width: 30%;display:inline; margin-left:5px" class="form-control input-md numeric_input" disabled value="' . $order_info['order_basic_info'][0]->customer_points . '"  />';
                    if ($order_info['order_basic_info'][0]->customer_points >= 100) {
                        echo '<input class="btn btn-primary replace_points" points="50" type="submit" style="display:inline" name="submit" value="' . lang('replace_points') . ' 50 "/>';
                        echo '<input class="btn btn-primary replace_points" points="100" type="submit" style="margin:5px;display:inline" name="submit" value="' . lang('replace_points') . ' 100"/>';
                    }
                    echo '<h4>' . lang('remaining') . '</h4>';
                    echo '<input type="text" style="width: 30%" class="form-control input-md numeric_input" id="remaining" class="numeric_input" readonly = "readonly"/>';
                }
                echo '<h4><input type="checkbox" id="noReceipt" value="1"/>' . lang('No Receipt') . '</h4>';
                echo '<h4>' . lang("ID") . '</h4>';
                echo '<input type="text" style="width: 30%" class="form-control input-md numeric_input" id="IDnum" disabled="1"  class="numeric_input" min=0.0/></td></tr>';
                echo '<h4>' . lang("recipient") . '</h4>';
                echo '<input type="text" style="width: 30%" class="form-control input-md " id="receipt" disabled="1" /></td></tr>';
                if ($order_info['order_basic_info'][0]->temporary_device) {
                    echo '<p align="center" style="color:#a94442;font-size:16px">' . lang('temporary_device_given') . '</p>';
                }
                echo '<div ><input class="submit_btn btn btn-primary" type="submit" name="submit" id="PayButton" value="' . $btn . ' ! " status_id="6" categories_id="5" action_name="Close" status_name="Closed"/><br></div>';
                echo '<a id="DistructedButton" style="color:#a94442;cursor:pointer">' . lang('distructed') . '</a><br></div>';
            }
            ?>


        </div>
        <?php
        if (permission_included($user_permissions, 'Perform Repair Action')
                and $order_info['current_status']->status_id == 6 and $order_info['order_basic_info'][0]->canceled == 0) {
            echo '<br><br><input class="submit_btn btn btn-danger" type="submit" name="" order_id="" id="cancelButton" value="' . lang('cancel_order') . '" status_id="6" categories_id="5" action_name="Close" status_name="Closed"/><br>';
        }
        ?>
    </div>
</div>
</div>

<?php $this->load->view('modals/view_modals') ?>
<script type="text/javascript">
    $('.face,.selected-face').click(function () {
//        if ($(this).hasClass('face')) {
        $(this).removeClass('face');
        $('.selected-face').addClass('face');
        $('.selected-face').removeClass('selected-face');
        $(this).addClass('selected-face');
//        } else {
//            $(this).addClass('face');
//            $(this).removeClass('selected-face');
//        }
        $.ajax({
            type: "get",
            url: site_url + "/contacts/contact_rating/format/json?customer_id=" + customer_id + "&rate=" + $('.selected-face').attr('rate'),
            success: function (data) {

            },
            error: function (response) {

            }
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        bsCustomFileInput.init()
    });
    $('#cancelButton').click(function () {
        var con = window.prompt("<?php echo lang('cancel_order_reason') ?>");
        if (con != null) {
            if (con != '') {
                $.ajax({
                    type: "get",
                    url: site_url + "/order/cancel_order/format/json?order_id=" + order_id + "&reason=" + con,
                    success: function (data) {
                        location.reload();
                    },
                    error: function (response) {

                    }
                });
            } else {
                window.alert("<?php echo lang('enter_reason') ?>");
            }
        }
    });
</script>