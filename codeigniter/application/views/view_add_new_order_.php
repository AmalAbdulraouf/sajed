<link rel="stylesheet" type="text/css" href='<?php echo base_url(); ?>resources/datatables.min.css'/>
<script type="text/javascript" src='<?php echo base_url(); ?>resources/datatables.min.js'></script>
<script type="text/javascript" src='<?php echo base_url(); ?>resources/moments.js'></script>
<link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/jquery-ui.css' ?>'>
<script>

    $('#voidBtn').hide();
    $(document).ready(function () {

//        if ($('#under_warranty').is(':checked'))
//        {
//            $('#billNumber').attr('disabled', false);
//            $('#billDate').attr('disabled', false);
//        }
//        else
//        {
//            $('#billNumber').attr('disabled', true);
//            $('#billDate').attr('disabled', true);
//        }


        $(".numeric_input").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A
                            (e.keyCode == 65 && e.ctrlKey === true) ||
                            // Allow: home, end, left, right
                                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
    });

</script>
<script>

    $(document).ready(function () {
        $('#under_warranty').on('change', function () {
            if ($(this).is(':checked'))
            {
                $('#billNumber').attr('disabled', false);
                $('#billDate').attr('disabled', false);
            } else
            {
                $('#billNumber').attr('disabled', true);
                $('#billDate').attr('disabled', true);
            }
        });
    });

    $(document).ready(function () {
        if ($('#delivery_date').is(':checked') == false && $('#examine_date').is(':checked') == false)
        {
            $('#delivery_date').attr('checked', true);
            $('#examine_cost').attr('disabled', true);
            $('#expected_examine_date').attr('disabled', true);
            $('#estimated_cost').attr('disabled', false);
            $('#expected_delivery_date').attr('disabled', false);
        }

        $('#delivery_date').click(function () {
            $('#examine_date').attr('checked', false); // ...meaning that we can use its value to set the 'disabled' attribute 
            $('#examine_cost').attr('disabled', true);
            $('#expected_examine_date').attr('disabled', true);
            $('#estimated_cost').attr('disabled', false);
            $('#expected_delivery_date').attr('disabled', false);
        });

        $('#examine_date').click(function () {
            $('#delivery_date').attr('checked', false); // ...meaning that we can use its value to set the 'disabled' attribute 
            $('#estimated_cost').attr('disabled', true);
            $('#expected_delivery_date').attr('disabled', true);
            $('#examine_cost').attr('disabled', false);
            $('#expected_examine_date').attr('disabled', false);
        });

        $('.addForm').on('keydown', 'input', function (event) {
            if (event.which == 13) {
                event.preventDefault();
                var $this = $(event.target);
                var index = parseFloat($this.attr('data-index'));
                $('[data-index="' + (index + 1).toString() + '"]').focus();
            }
        });
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
        $(".open_customer_info").hide();
        $("#open_customer").click(function () {
            $(".add_customer_info").hide();
            $(".open_customer_info").show();
            $('#searchbox').focus();
        });
    });

    $(document).ready(function () {
        $("#add_customer").click(function () {
            $(".add_customer_info").show();
            $(".open_customer_info").hide();
            $('#prev-machines').text("");
            $("#customer_id").val("");
        });
    });

    $(document).ready(function () {
        $("#change_customer").click(function () {
            $("#selected_contact").hide();
            $(".search").show();
            $(this).hide();
            $(".search").focus();
        });
    });

    $(document).on('change', "#brands_drop_down_list", function () {
        brand_id = $(this).val();
        update_models_by_brand(brand_id);
    });

    $(document).on('change', "#models", function () {
        source: "<?php echo base_url(); ?>" + "index.php/management/get_list_of_models_by_brand_id_model_name?brand_id=" + $("#brands_drop_down_list").val()
    });

    $(document).ready(function () {
        document.getElementById("models").onkeydown = function myFunction(e) {
            if (e.ctrlKey) {
                return;
            }
            var characters = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
            var keyCode = (window.event) ? e.which : e.keyCode;
            if (keyCode >= 65 && keyCode <= 90) {
                this.value += characters[keyCode - 65];
                return false;
            } else if ((keyCode < 8 || keyCode > 105)) {
                this.value += '';
                return false;
            }
        };
    });



    $(document).ready(function () {
        document.getElementById("serial_number").onkeydown = function myFunction(e) {
            if (e.ctrlKey) {
                return;
            }
            var characters = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
            var keyCode = (window.event) ? e.which : e.keyCode;
            if (keyCode >= 65 && keyCode <= 90) {
                this.value += characters[keyCode - 65];
                return false;
            } else if ((keyCode < 8 || keyCode > 105)) {
                this.value += '';
                return false;
            }
        };
    });


    $(document).ready(function () {
        $("#models").autocomplete({
            source: "<?php echo base_url(); ?>" + "index.php/management/get_list_of_models_by_brand_id_model_name?brand_id=" + $("#brands_drop_down_list").val()
        });
    });

//    $(document).ready(function() {
//        $("#colors").autocomplete({
//            source: "<?php echo base_url(); ?>" + "index.php/management/get_list_of_colors_like_name"
//        });
//    });

</script>


<script type="text/javascript">

    function checkLength()
    {
        var fieldLength = document.getElementById('phone').value.length;
        //Suppose u want 4 number of character
        if (fieldLength <= 9) {
            return true;
        } else
        {
            var str = document.getElementById('phone').value;
            str = str.substring(0, str.length - 1);
            document.getElementById('phone').value = str;
        }
    }

    var source_link;
    function update_models_by_brand(brand_id)
    {
        $("#models").val('');
        source_link = "<?php echo base_url(); ?>" + "index.php/management/get_list_of_models_by_brand_id_model_name?brand_id=" + $("#brands_drop_down_list").val();
        $("#models").autocomplete("option", "source", source_link);
    }



    $(document).ready(function () {
        var customer_id =
<?php
$current_customer_id = set_value('customer_id', -1);
echo $current_customer_id;
?>;
        if (customer_id > -1) {
            $(".open_customer_info").show();
            $(".add_customer_info").hide();

            var dataString = 'searchword=' + customer_id;
            $.post("<?php echo base_url() . 'index.php/order/search_contacts' ?>",
                    {searchword: customer_id},
                    function (data, status) {
                        $("#selected_contact").html(data);
                        var html = "#" + $("#selected_contact").find('#id').html() + "<br>";
                        html += "<b>" + $("#selected_contact").find('#name').text() + "</b><br>";
                        html += $("#selected_contact").find('#phone').html() + "<br>";
                        html += $("#selected_contact").find('#address').html() + "<br>";
                        $("#display").hide();
                        $("#customer_id").val($("#selected_contact").find('#id').html());
                        $("#selected_contact").html(html);

                        $("#selected_contact").show();
                        $(".search").hide();
                        $("#change_customer").show();
                    }
            );
        }
    });


//    $(document).ready(function()
//    {
//        $(".search").keyup(function()
//        {
//            var searchbox = $(this).val();
//            var dataString = 'searchword=' + searchbox;
//
//            if (searchbox == '')
//            {
//                $("#display").hide();
//            }
//            else
//            {
//                $("#display").show();
//                $.ajax({
//                    type: "POST",
//                    url: "<?php echo base_url() . 'index.php/order/search_contacts' ?>",
//                    data: dataString,
//                    cache: false,
//                    success: function(html)
//                    {
//                        $("#display").html(html).show();
//                        $('#display').css({top: '800px'});
//
//                        $(".display_box").click(function() {
//                            var html = "#" + $(this).find('#id').html() + "<br>";
//                            html += "<b>" + $(this).find('#name').text() + "</b><br>";
//                            html += $(this).find('#phone').html() + "<br>";
//                            html += $(this).find('#address').html() + "<br>";
//                            $("#display").hide();
//                            $("#selected_contact").html(html);
//                            $("#customer_id").val($(this).find('#id').html());
//
//                            $("#selected_contact").show();
//                            $(".search").hide();
//                            $("#change_customer").show();
//                        });
//
//                    }});
//            }
//            return false;
//        });
//    });

    jQuery(function ($) {
        $("#searchbox").Watermark("Search By Name, Phone, Or ID");
    });

</script>

<script>
    $(function () {
        $(".datepicker").datepicker();
        $('#subBar').click(function () {
            $('#ba').submit();
        });
    });
</script>

<body>
<?php
if ($this->session->userdata('language') == 'Arabic') {
    echo '<div align="right" class="container">';
} else {
    echo '<div align="left" class="container">';
}
?>
    <div class="panel panel-default ">
        <div class="panel-body">
            <div class="page-header">
    <?php $this->load->view('app_title') ?>
                <div style="text-align: center">
                    <img  style="max-width: 90%" src='<?php echo base_url() ?>resources/images/logo2.jpg'/>
                </div>
            </div>

<?php
echo form_open_multipart('order/save_new_order', array('class' => 'addForm'));

echo "<error>";
echo validation_errors();
echo "</error>";
?>
            <div  class="add_customer_info cont-inf" name="add_customer_info" id="add_customer_info">
                <h2><?php echo lang('customer_info'); ?></h2>
                <button id="open_customer" value="open_customer" type="button" class="btn btn-style"><?php echo lang('or_open_from_contacts'); ?></button>
                <br><br>

                <input type="checkbox" name="company" onchange="select_company(this)"/>
                <label for="company"><?php echo $this->lang->line('company') ?></label>
                <div class="row" id="company_info" style="display: none">
                    <input type="hidden" name="company_used" value="0" />
                    <div class="col-md-6  pull-right" >
<?php
$attr = array(
    'name' => 'company_name',
    'value' => set_value('company_name'),
    'class' => 'form-control form-inline input-md-3',
    'placeholder' => lang('company_name'),
    'style' => 'width: 50%',
    'id' => 'company_name',
    'data-index' => '1'
);
echo form_input($attr);
?>
                    </div>
                    <div class="col-md-6  pull-right" >
                        <?php
                        $attr = array(
                            'name' => 'company_email',
                            'value' => set_value('company_email'),
                            'class' => 'form-control form-inline input-md-3',
                            'placeholder' => lang('email'),
                            'style' => 'width: 50%',
                            'id' => 'company_email',
                            'data-index' => '1'
                        );
                        echo form_input($attr);
                        ?>
                        <?php
                        $attr = array(
                            'name' => 'company_id',
                            'value' => set_value('company_id'),
                            'class' => 'form-control form-inline input-md-3',
                            'placeholder' => lang('email'),
                            'style' => 'width: 50%',
                            'id' => 'company_id',
                            'type' => 'hidden',
                            'data-index' => '1'
                        );
                        echo form_input($attr);
                        ?>
                    </div>
                </div>
                <br><br>
                <div class="row pull-half">


                    <div class="col-md-6">

                        <div class="row">
<?php
$attr = array(
    'name' => 'first_name',
    'value' => set_value('first_name'),
    'class' => 'form-control form-inline input-md-3',
    'placeholder' => lang('full_name'),
    'style' => 'width: 50%',
    'id' => 'full_name',
    'data-index' => '1'
);
echo form_input($attr);
?>
                        </div>
                        <br>
                            <?php echo form_hidden('last_name', set_value('last_name')); ?>

                        <div class="row">

                        <?php
                        $attr = array(
                            'name' => 'phone',
                            'id' => 'phone',
                            'value' => set_value('phone'),
                            'class' => 'form-control input-md-3 numeric_input',
                            'placeholder' => lang('phone'),
                            'style' => 'width: 50%; display:inline',
                            'data-index' => '2',
                            'onInput' => "checkLength()"
                        );
                        echo form_input($attr);
                        ?>
                            <font color="red">9665 </font>	
                        </div>
                        <br>
                        <div class="row">
<?php
$attr = array(
    'name' => 'email',
    'value' => set_value('email'),
    'class' => 'form-control input-md-3',
    'placeholder' => lang('email'),
    'style' => 'width: 50%',
    'data-index' => '3'
);
echo form_input($attr);
?> 
                        </div>
                    </div>
                    <div class="col-md-6">
                            <?php
                            $address_textarea = array(
                                'name' => 'address',
                                'rows' => "6",
                                'cols' => "45",
                                'class' => 'form-control',
                                'placeholder' => lang('address'),
                                'value' => set_value('address'),
                                'style' => 'width: 30%; min-width: 45%; max-width: 45%',
                                'data-index' => '4'
                            );

                            echo form_textarea($address_textarea)
                            ?>
                    </div>

                </div>
            </div>
            <div class="open_customer_info cont-inf" name="open_customer_info" id="open_customer_info">
                <h2><?php echo lang('customer_info'); ?></h2>
                <button id="add_customer" value="add_customer" type="button" class="btn btn-style"><?php echo lang('or_add_a_new_customer'); ?></button>
                <br>
                <input  type="text" class="search" id="searchbox" />
                <div id="display"></div>
                <div id = "selected_contact" ></div>
                <div id = "select_contact" >
                    <button style="display: none" id="change_customer" value="Change" type="button" class="btn"><?php echo lang('change'); ?></button>
                </div>
            </div>
            <div id="add_machine_info" class="cont-inf">

                <div class="row pull-half">
                    <h2><?php echo lang('machine_info'); ?><a style="cursor: pointer;margin: 10px;font-size: 16px" onclick="prev_machines()" id="prev-machines"></a></h2>
                    <div class="col-md-6">
                        <div class="row">		
                            <div class="col-md-3">
<?php echo lang('machine_type'); ?>
                            </div>
                            <div class="col-md-9">
                                <?php echo form_hidden('machine_id', set_value('machine_id')); ?>
                                <?php echo form_dropdown('machine_type', $machines_types, set_value('machine_type'), 'class="form-control input-md-3" style="width:50%"');
                                ?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
<?php echo lang('brands'); ?>
                            </div>
                            <div class="col-md-9">
                                <?php echo form_dropdown('brands', $brands, set_value('brands'), 'class="form-control input-md-3" id="brands_drop_down_list" style="width:50%"');
                                ?>
                            </div>
                        </div>
                        <br>
                        <div class="row pull-half">
                            <div class="col-md-3">
<?php echo lang('models'); ?>
                            </div>
                            <div class="col-md-9">
                                <?php
                                $model_input_data = array(
                                    'name' => 'models',
                                    'id' => 'models',
                                    'value' => set_value('models'),
                                    'class' => 'form-control input-md',
                                    'placeholder' => lang('models'),
                                    'style' => 'width: 50%',
                                    'data-index' => '5'
                                );

                                echo form_input($model_input_data);
                                ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="row">
<?php
$serial_no_data = array(
    'name' => 'serial_number',
    'value' => set_value('serial_number'),
    'id' => 'serial_number',
    'class' => 'form-control input-md-3',
    'placeholder' => lang('serial_no'),
    'style' => 'width: 50%',
    'data-index' => '6'
);
echo form_input($serial_no_data);
?>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
<?php echo lang('color'); ?>
                            </div>
                            <div class="col-md-3">
                                <?php
                                echo form_dropdown('colors', $colors, set_value('colors'), 'class="form-control input-md-3" style="width:100%"');
//                            $current_color = set_value('colors');
//                            if ($current_color == '')
//                                $current_color = lang('black');
//                            $color_input_data = array(
//                                'name' => 'colors',
//                                'value' => $current_color,
//                                'id' => 'colors',
//                                'data-index' => '7',
//                                'class' => 'form-control input-md-3',
//                                'placeholder' => lang('colors'),
//                                'style' => 'width: 50%',
//                                'autocomplete' => 'on'
//                            );
//
//                            echo form_input($color_input_data);
                                ?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
<?php echo lang('machine_img'); ?>
                            </div>
                            <div class="col-md-9">
                                <?php
                                $image_input_data = array(
                                    'name' => 'userfile',
                                    'id' => 'image',
                                    'value' => set_value('userfile'),
                                    'style' => 'width: 50%',
                                    'type' => 'file'
                                );

                                echo form_input($image_input_data);
                                ?>
                                <?php echo form_hidden('image_name', set_value('image_name')); ?>
                                <img height="100px" width="100px" id="image_box" src="" style="display: none"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row cont-inf pull-half">
                <br><br>
                <div class="col-md-6 pull-right">
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
    'style' => 'width: 30%; min-width: 45%; max-width: 45%',
    'data-index' => "$counter"
);
echo form_textarea($attr);

echo "</td></div><br>";
$counter++;
?>

                        <?php ?>
                    </div>
                </div>

            </div>

            <div id="" >
                <div class="row cont-inf">

                    <div class="col-md-6 pull-right">
                        <h3><?php echo lang('faults'); ?></h3>
<?php
$faults_textarea = array(
    'name' => 'faults',
    'rows' => "6",
    'cols' => "35",
    'value' => set_value('faults'),
    'data-index' => "$counter",
    'class' => 'form-control',
    'style' => 'width: 70%; min-width: 45%; max-width: 70%'
);
echo form_textarea($faults_textarea);
$counter++;
?>
                    </div>
                </div>
            </div>

            <div id="" >
                <div class="row cont-inf">
                    <br>
                    <div class="col-md-3">
<?php echo lang('service') ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        $services = array(lang('not_selected'), 'software برامج', 'electronic الكترونيات', 'external صيانة خارجية', 'warranty ضمان');
                        echo form_dropdown('services', $services, set_value('services'), 'onclick="select_service(this)" class="form-control input-md-3" style="width:100%"');
                        ?>
                    </div>
                </div>
            </div>
            <div id="after_service" style="display: none">
                <div id="fault" >
                    <div class="row cont-inf" id="fault_desc">

                        <div class="col-md-6 pull-right">
                            <h3><?php echo lang('fault_description'); ?></h3>
<?php
$fault_description_textarea = array(
    'name' => 'fault_description',
    'rows' => "6",
    'cols' => "35",
    'value' => set_value('fault_description'),
    'data-index' => "$counter",
    'class' => 'form-control',
    'style' => 'width: 70%; min-width: 45%; max-width: 70%'
);
echo form_textarea($fault_description_textarea);
$counter++;
?>
                            <div style="border: none; font-size: 130%" id="formating" class="form-control">
                            <?php echo lang('allow_losing_data'); ?>
                                <label for="allow_losing_data">		
                            <?php
                            $chk_box_data = array
                                (
                                'name' => 'allow_losing_data',
                                'id' => 'allow_losing_data',
                                'value' => 1,
                                'checked' => !empty($_POST['allow_losing_data']) and $_POST['allow_losing_data'] != false
                            );


                            echo form_checkbox($chk_box_data);
                            ?>
                                </label>
                            </div>
                            <div style="border: none !important; font-size: 130%; display: none" class="form-control">
                                    <?php echo lang('external_repair'); ?>
                                <label for="external_repair">		
<?php
$data = array(
    'name' => 'external_repair',
    'class' => 'external_repair',
    'value' => 1,
    'checked' => !empty($_POST['external_repair']) and $_POST['external_repair'] != false,
);

echo form_checkbox($data);
?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id="warranty_area" style="border: none; font-size: 130%; display: none" class="form-group form-inline ">
                        <div class="row">
                            <br>
                            <div class="col-md-3 pull-right">
                                <h4><?php echo lang('billDate') ?></h4>
<?php
$billDate = array
    (
    'name' => 'billDate',
    'id' => 'billDate',
    'type' => 'text',
    'class' => 'form-control input-md-3 datepicker',
    'placeholder' => lang('billDate'),
    'style' => 'width: 70%',
    'value' => set_value('billDate')
);
echo form_input($billDate);
?>
                            </div>
                            <div class="col-md-3 pull-right">
                                <h4><?php echo lang('billNumber') ?></h4>
                                <?php
                                $bill_num = array
                                    (
                                    'name' => 'billNumber',
                                    'id' => 'billNumber',
                                    'class' => 'form-control input-md-3 numeric_input',
                                    'placeholder' => lang('billNumber'),
                                    'style' => 'width: 70%',
                                    'value' => set_value('billNumber')
                                );
                                echo form_input($bill_num);
                                ?>
                            </div>
                            <div class="col-md-3 pull-right">
                                <h4><?php echo lang('warranty_period') ?></h4>
                                <?php
                                echo form_dropdown('warranty_period', array("1" => lang("year"), "2" => lang("two_years")), set_value('warranty_period'), 'style="width: auto" class="form-control input-md"');
                                ?>
                            </div>
                            <div class="col-md-3 pull-right">
                                <h4><?php echo lang('time_remaining') ?></h4>
                                <p id="time_remaining"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row cont-inf">
                        <br>
                        <div id="dates" style="display: none">
                            <div style="border: none; font-size: 130%" class="form-group form-inline">


<?php echo lang('delivery_date'); ?>		

                                <label for="delivery_date" class="radio-inline">
                                <?php
                                $data = array(
                                    'name' => 'delivery_date',
                                    'class' => 'delivery_date form-control input-md-3',
                                    'id' => 'delivery_date',
                                    'value' => 1,
                                    'checked' => !empty($_POST['delivery_date']) and $_POST['delivery_date'] != false,
                                );

                                echo form_radio($data);
                                ?>

                                </label>

                                    <?php
                                    $options = array();
                                    for ($i = 1; $i <= 100; $i++)
                                        $options[$i] = $i;
                                    ?>
                                <td class='input form-control input-md-3'><?php echo lang('during') . " " . form_dropdown('expected_delivery_date', $options, 1, 'style="width:15%" id="expected_delivery_date"') . " " . lang('work_day'); ?></td>

                                <?php
                                $data = array(
                                    'name' => 'cost_estimation',
                                    'id' => 'estimated_cost',
                                    'class' => ' form-control input-md-3 numeric_input',
                                    'placeholder' => lang('cost_estimation'),
                                    'value' => set_value('cost_estimation'),
                                    'style' => 'margin:14px; width:30%',
                                    'data-index' => "$counter"
                                );
                                echo form_input($data);
                                $counter++;
                                ?>


                            </div>
                            <div style="border: none; font-size: 130%" class="form-group form-inline">

<?php echo lang('examine_date'); ?>
                                <label for="examine_date" class="radio-inline">
<?php
$data = array(
    'name' => 'examine_date',
    'class' => 'examine_date form-control input-md-3',
    'id' => 'examine_date',
    'value' => 1,
    'checked' => !empty($_POST['examine_date']) and $_POST['examine_date'] != false,
);

echo form_radio($data);
?>

                                </label>

                                    <?php
                                    $options = array();
                                    for ($i = 1; $i <= 100; $i++)
                                        $options[$i] = $i;
                                    ?>
                                <td class='input form-control input-md-3'><?php echo lang('during') . " " . form_dropdown('expected_examine_date', $options, 1, 'style="width:15%"  " id="expected_examine_date"') . " " . lang('work_day'); ?></td>

                                <?php
                                $data = array(
                                    'name' => 'examine_cost',
                                    'id' => 'examine_cost',
                                    'class' => ' form-control input-md-3 numeric_input',
                                    'placeholder' => lang('examining_cost'),
                                    'value' => set_value('examine_cost'),
                                    'style' => 'margin:14px; width:30%',
                                    'data-index' => "$counter"
                                );
                                echo form_input($data);
                                $counter++;
                                ?>
                            </div>
                                <?php echo lang('assign_to'); ?>
                                <?php
                                $opt = 'class="technician"';
                                echo form_dropdown('technician', $technicians, set_value('technician'), 'style="width: auto" class="form-control input-md"');
                                ?>
                        </div>

                        <div id="visite_date" style="border: none; font-size: 130%;display: none" class="form-group form-inline">


<?php echo lang('visite_date'); ?>		
<?php
$date = array
    (
    'name' => 'visite_date',
    'type' => 'text',
    'class' => 'form-control input-md-3 datepicker',
    'style' => 'width: 15%',
    'value' => set_value('visite_date')
);
echo form_input($date);
?>

                            <?php
                            $data = array(
                                'name' => 'visite_cost',
                                'id' => 'visite_cost',
                                'class' => ' form-control input-md-3 numeric_input',
                                'placeholder' => lang('visite_cost'),
                                'value' => set_value('visite_cost'),
                                'style' => 'margin:14px; width:20%',
                                'data-index' => "$counter"
                            );
                            echo form_input($data);
                            $counter++;
                            ?>
                            <?php
                            $data = array(
                                'name' => 'external_cost_estimation',
                                'id' => 'cost_estimation',
                                'class' => ' form-control input-md-3 numeric_input',
                                'placeholder' => lang('cost_estimation'),
                                'value' => set_value('external_cost_estimation'),
                                'style' => 'margin:14px; width:20%',
                                'data-index' => "$counter"
                            );
                            echo form_input($data);
                            $counter++;
                            ?>

                            <?php echo lang('assign_to'); ?>
                            <?php
                            $opt = 'class="technician"';
                            echo form_dropdown('external_technician', $technicians, set_value('external_technician'), 'style="width: auto" class="form-control input-md"');
                            ?>
                        </div>

                    </div>
                </div>
            </div>
            <br>
            <div id="Notes">
                <div  class="cont-inf">
                    <h2><?php echo lang('notes'); ?></h2>
<?php
$notes_textarea = array(
    'name' => 'notes',
    'rows' => "6",
    'cols' => "35",
    'value' => set_value('notes'),
    'data-index' => "$counter",
    'class' => 'form-control',
    'placeholder' => lang('notes'),
    'style' => 'width: 45%; min-width: 45%; max-width: 45%',
);
echo form_textarea($notes_textarea);
$counter++;
?>
                    <br>
                </div>
                <br>               
            </div>
<?php
$input_data = array
    (
    'name' => 'customer_id',
    'id' => 'customer_id',
    'value' => "",
    'type' => "hidden"
);
echo form_input($input_data, set_value('customer_id'));
?>

            <h3>
            <?php
            $sub = array(
                'name' => 'submit changes',
                'value' => lang('submit'),
                'class' => 'submit_btn'
            );
            echo form_submit($sub);
            ?>
            </h3>
        </div>
    </div>
</div>
<div id="customer_history" class="modal fade" role="dialog">
    <div class="modal-dialog " style="width:80%;direction: rtl">
        <div class="modal-content">
            <div class="modal-header"> 
                <button type="button" class="close pull-left " data-dismiss="modal" aria-hidden="true">x</button>
                <h4><?php echo $this->lang->line('not_delivered_machines') ?></h4>
                <br>
            </div>
            <div class="modal-body" style="text-align: center">
                <div style="text-align: right" class ="table-responsive">
                    <table id="customer_history_table" class="display" style="direction: rtl;text-align: right">
                        <thead>
                        <th><?php echo lang('order_number'); ?></th>
                        <th><?php echo lang('customer_name'); ?></th>
                        <th><?php echo lang('machine_brand'); ?></th>
                        <th><?php echo lang('machine_model'); ?></th>
                        <th><?php echo lang('fault_description'); ?></th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="customer_machines" class="modal fade" role="dialog">
    <div class="modal-dialog " style="width:80%;direction: rtl">
        <div class="modal-content">
            <div class="modal-header"> 
                <button type="button" class="close pull-left " data-dismiss="modal" aria-hidden="true">x</button>
                <h4><?php echo $this->lang->line('prev_machines') ?></h4>
                <br>
            </div>
            <div class="modal-body" style="text-align: center">
                <div style="text-align: right" class ="table-responsive">
                    <table id="customer_machines_table" class="display" style="direction: rtl;text-align: right">
                        <thead>
                        <th><?php echo lang('serial_no'); ?></th>
                        <th><?php echo lang('machine_brand'); ?></th>
                        <th><?php echo lang('machine_model'); ?></th>
                        <th><?php echo lang('fault_description'); ?></th>
                        <th><?php echo $this->lang->line('machine_img') ?></th>
                        <th></th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var site_url = "<?php echo site_url() ?>";
    var base_url = "<?php echo base_url() ?>";

    select_service_input("<?php echo $this->input->post("services") ?>");
    $("#searchbox").autocomplete({
        autoFocus: true,
        source: function (req, add) {
            $.getJSON(site_url + "/contacts/search?key=" + $('#searchbox').val(), req, function (data) {
                var suggestions = [];
                $.each(data["data"], function (i, val) {
                    suggestions.push({
                        label: val.first_name,
                        id: val.id,
                        phone: val.phone,
                        company_id: null,
                        last_name: val.last_name,
                        address: val.address,
                        points: val.points,
                        discount: val.discount
                    }); //not val.name
                    if (val.company_delegate_id != null)
                        suggestions.push({
                            label: "<?php echo $this->lang->line('company') ?>: " + val.company_name + " " + val.first_name,
                            id: val.id,
                            phone: val.phone,
                            last_name: val.last_name,
                            company_id: val.company_id,
                            company_name: val.company_name,
                            company: val.company_delegate_id,
                            address: val.address
                        }); //not val.name
                });
                add(suggestions);
            });
        },
        //select
        select: function (e, ui) {
            var html = "#" + ui.item.id + "<br>";
            html += "<b>" + ui.item.label + " " + ui.item.last_name + "</b><br>";
            html += ui.item.phone + "<br>";
            html += ui.item.address + "<br>";
            html += "<?php echo $this->lang->line('customer_points')?>: " + ui.item.points + "<br>";
            html += "<?php echo $this->lang->line('customer_discount')?>: " + ui.item.discount + " %<br>";
            html += "<a onclick=\"$(\'#customer_history\').modal(\'show\');\"><?php echo $this->lang->line('not_delivered_machines') ?></a>";
            $("#display").hide();
            $("#selected_contact").html(html);
            $("#customer_id").val(ui.item.id);
            $('#prev-machines').text("<?php echo $this->lang->line('prev_machines') ?>");

            if (ui.item.company_id != null) {
                $('#prev-machines').attr("onclick", "prev_machines(" + ui.item.company_id + "," + true + ")");
                $('input[name=company_used]').val(1);
                $.ajax({
                    type: "GET",
                    url: site_url + "/companies/get_not_delivered/format/json?company_id=" + ui.item.company_id,
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        computers = data['data'];
                        render_computers(computers, ui.item.company_name);

                    },
                    error: function (response) {
                    }
                });
            } else {
                $('#prev-machines').attr("onclick", "prev_machines(" + ui.item.id + "," + false + ")");
                $('input[name=company_used]').val(0);
                $.ajax({
                    type: "GET",
                    url: site_url + "/contacts/get_not_delivered/format/json?contact_id=" + ui.item.id,
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        computers = data['data'];
                        render_computers(computers, false);

                    },
                    error: function (response) {

                    }
                });
            }
            $("#selected_contact").show();


        }
    });

    $("#company_name").autocomplete({
        autoFocus: true,
        source: function (req, add) {
            $.getJSON(site_url + "/companies/search?key=" + $('#company_name').val(), req, function (data) {
                console.log(data);
                var suggestions = [];
                $.each(data["data"], function (i, val) {
                    suggestions.push({
                        label: val.name,
                        id: val.company_id,
                        email: val.email,
                        address: val.address
                    }); //not val.name
                });
                add(suggestions);
            });
        },
        //select
        select: function (e, ui) {
            $("#company_id").val(ui.item.id);
            $("#company_email").val(ui.item.email);
        }
    });

    function select_company(ob) {
        if ($(ob).prop("checked") == true) {
            $('#company_info').show();
            $('#full_name').attr("placeholder", "<?php echo $this->lang->line('delegate_name') ?>");
        } else {
            $('#company_info').hide();
            $('#full_name').attr("placeholder", "<?php echo $this->lang->line('full_name') ?>");
        }
    }

    function render_computers(computers, company) {

        if (computers.length != 0) {
            $('#customer_history_table tbody').html("");
            for (var i = 0; i < computers.length; i++) {
                var customer = "";
                if (company == false)
                    customer = computers[i]['first_name'] + " " + computers[i]['last_name'];
                else
                    customer = "<?php echo $this->lang->line('company') ?>: " + company + " " + computers[i]['first_name'] + " " + computers[i]['last_name'];
                $('#customer_history_table').append(
                        "<tr><td>" + computers[i]['id'] +
                        "</td><td>" + customer +
                        "</td><td>" + computers[i]['name'] +
                        "</td><td>" + computers[i]['model'] +
                        "</td><td>" + computers[i]['fault_description'] + "</td></tr>"
                        );
            }
            $('#customer_history_table').dataTable();
            $('#customer_history').modal("show");
        }
    }

    function prev_machines(id, company) {
        if (company == true) {
            $.ajax({
                type: "GET",
                url: site_url + "/companies/get_prev_machines/format/json?company_id=" + id,
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    computers = data['data'];
                    render_machines(computers);

                },
                error: function (response) {

                }
            });
        } else if (company == false) {
            $.ajax({
                type: "GET",
                url: site_url + "/contacts/get_prev_machines/format/json?contact_id=" + id,
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    computers = data['data'];
                    render_machines(computers);

                },
                error: function (response) {

                }
            });
        }
    }

    function render_machines(computers) {

        if (computers.length != 0) {
            $('#customer_machines_table tbody').html("");
            for (var i = 0; i < computers.length; i++) {
                var customer = "";

                customer = computers[i]['first_name'] + " " + computers[i]['last_name'];
                var image = "</td><td>";
                if (computers[i]['image'] != '')
                    image = "</td><td><img width='100px' height='100px' src='" + base_url + "resources/machines/" + computers[i]['image'] + "' />";
                $('#customer_machines_table').append(
                        "<tr><td>" + computers[i]['serial_number'] +
                        "</td><td>" + computers[i]['name'] +
                        "</td><td>" + computers[i]['model'] +
                        "</td><td>" + computers[i]['fault_description'] +
                        image +
                        '</td><td><button data-computer=\'' + JSON.stringify(computers[i]) + '\' onclick="choose(this)"><?php echo $this->lang->line('choose') ?></button></td></tr>'
                        );
            }
            $('#customer_machines_table').dataTable();
            $('#customer_machines').modal("show");
        }
    }

    function choose(ob) {
        console.log(JSON.parse($(ob).attr("data-computer")));
        var machine = JSON.parse($(ob).attr("data-computer"));
        $('select[name=machine_type]').val(machine['machines_types_id']);
        $('select[name=brands]').val(machine['brand_id']);
        $('input[name=models]').val(machine['model']);
        $('input[name=machine_id]').val(machine['id']);
        $('input[name=image_name]').val(machine['image']);
        if (machine['image'] != "") {
            $('#image_box').show();
            $('#image_box').attr("src", base_url + 'resources/machines/' + machine['image']);
        } else {
            $('#image_box').hide();
            $('#image_box').attr("src", "");
        }
        $('textarea[name=faults]').val(machine['faults']);
        $('textarea[name=faults]').text(machine['faults']);
        $('input[name=serial_number]').attr("value", machine['serial_number']);
        $('select[name=colors]').val(machine['color_id']);
        if (machine['under_warranty'] == 1) {
            $('input[name=under_warranty]').prop("checked", true);
            $('input[name=billDate]').prop("disabled", false);
            $('input[name=billNumber]').prop("disabled", false);
            $('input[name=billDate]').val(machine['billDate']);
            $('input[name=billNumber]').val(machine['billNumber']);
            $('input[name=accessories]').val(machine['Notes']);
        } else {
            $('input[name=under_warranty]').prop("checked", false);
            $('input[name=billDate]').prop("disabled", true);
            $('input[name=billNumber]').prop("disabled", true);
            $('input[name=billDate]').val("");
            $('input[name=billNumber]').val("");
            $('input[name=accessories]').val("");
        }
        $('#customer_machines').modal("hide");
    }

    function select_service(ob) {
        select_service_input($(ob).val());
    }

    function select_service_input(val) {
        $('#time_remaining').html("");
        $('#after_service').hide();
        $('#warranty_area').hide();
        $('#formating').hide();
        $('#fault_desc').hide();
        $('#visite_date').hide();
        $('#dates').hide();
        $('#billNumber').attr('disabled', true);
        $('#billDate').attr('disabled', true);
        if (val == 0) {
            $('#after_service').hide();
        } else if (val == 1) {
            $('#after_service').show();
            $('#formating').show();
            $('#fault_desc').show();
            $('#dates').show();
        } else if (val == 2) {
            $('#after_service').show();
            $('#fault_desc').show();
            $('#dates').show();
        } else if (val == 3) {
            $('#after_service').show();
            $('#fault_desc').show();
            $('#visite_date').show();
        } else if (val == 4) {
            $('#after_service').show();
            $('#warranty_area').show();
            $('#fault_desc').show();
            $('#billNumber').attr('disabled', false);
            $('#billDate').attr('disabled', false);
        }
    }

    $('select[name=warranty_period], input[name=billDate]').change(function () {
        var billdate = new Date($('input[name=billDate]').val());
        var today = new Date();
        var diffDays = parseInt((today - billdate) / (1000 * 60 * 60 * 24));
        var period = $('select[name=warranty_period]').val();
        if (period == "1") {
            if (diffDays >= 365)
                $('#time_remaining').html("<?php echo lang('warranty_is_over') ?>");
            else
                $('#time_remaining').html((365 - diffDays) + " " + "<?php echo lang('day') ?>");
        } else if (period == "2") {
            if (diffDays >= 365 * 2)
                $('#time_remaining').html("<?php echo lang('warranty_is_over') ?>");
            else
                $('#time_remaining').html((365 * 2 - diffDays) + " " + "<?php echo lang('day') ?>");
        }
    });

</script>
</body>