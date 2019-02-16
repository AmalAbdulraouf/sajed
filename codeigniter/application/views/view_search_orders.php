<link rel="stylesheet" type="text/css" href='<?php echo base_url(); ?>resources/datatables.min.css'/>
<script type="text/javascript" src='<?php echo base_url(); ?>resources/datatables.min.js'></script>
<link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/search_contacts.css' ?>'>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/search_contacts.css' ?>'>

<script>

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
    });
</script>

<script>
    $(document).ready(function() {
        $(".row_order").click(function() {
            var href = '<?php echo base_url() . 'index.php/order/view_order?order_id=' ?>';
            href += $(this).attr("value");
            window.open(href, "_self");
        });
    });


</script>
<script>
    $(document).ready(function() {
        $(".open_customer_info").hide();
        $("#open_customer").click(function() {
            $(".add_customer_info").hide();
            $(".open_customer_info").show();
        });
    });

    $(document).ready(function() {
        $("#search_by").change(function() {
            if ($(this).val() == "1")
            {
                $("#search_by_order_id").show();
                $("#search_filters").hide();
            }
            else
            {
                $("#search_by_order_id").hide();
                $("#search_filters").show();
            }
        });
    });

    $(document).ready(function() {
        $("#button_search").click(function() {
            if ($("#search_by").val() == "1")
            {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        $("#_table_div_").html(xmlhttp.responseText);
                        //$('#orders_table').empty();
                        //$('#orders_table').append(xmlhttp.responseText);
                        $('#orders_table').dataTable();
                    }
                }
                var link = "<?php echo base_url() . 'index.php/order/search_orders_by_id?order_id=' ?>" + $("#order_id").val();
                xmlhttp.open("GET", link, true);
                xmlhttp.send();
            }
            else
            {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        $("#_table_div_").html(xmlhttp.responseText);
                        $('#orders_table').dataTable();
                    }
                }
                var link = "<?php echo base_url() . 'index.php/order/search_orders_by_filters?customer_id=' ?>" + $("#customer_id").val();
                link += "&date_from=" + $("#from_date").val();
                link += "&date_to=" + $("#to_date").val();
                link += "&delivered_or_not=" + $("#search_in_delivered_undelivered").val();
                xmlhttp.open("GET", link, true);
                xmlhttp.send();
            }
            $(".search_results").show();
        });
    });

    $(document).ready(function() {
        $("#add_customer").click(function() {
            $(".add_customer_info").show();
            $(".open_customer_info").hide();
            $("#customer_id").val("");
        });
    });

    $(document).ready(function() {
        $("#change_customer").click(function() {
            $("#selected_contact").hide();
            $(".search").show();
            $(this).hide();
            $(".search").focus();
        });
    });

</script>


<script type="text/javascript">
    $(document).ready(function()
    {
        $(".search").keyup(function()
        {
            var searchbox = $(this).val();
            var dataString = 'searchword=' + searchbox;

            if (searchbox == '')
            {
                $("#display").hide();
            }
            else
            {
                $("#display").show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'index.php/order/search_contacts' ?>",
                    data: dataString,
                    cache: false,
                    success: function(html)
                    {
                        $("#display").html(html).show();
                        $('#display').css({top: '800px'});

                        $(".display_box").click(function() {
                            var html = "#" + $(this).find('#id').html() + "<br>";
                            html += "<b>" + $(this).find('#name').text() + "</b><br>";
                            html += $(this).find('#phone').html() + "<br>";
                            html += $(this).find('#address').html() + "<br>";
                            $("#display").hide();
                            $("#selected_contact").html(html);
                            $("#customer_id").val($(this).find('#id').html());

                            $("#display").hide();
                            $("#selected_contact").html(html);
                            $("#customer_id").val($(this).find('#id').html());

                            $("#selected_contact").show();
                            $(".search").hide();
                            $("#change_customer").show();

                        });

                    }});
            }
            return false;
        });
    });

    jQuery(function($) {
        $("#searchbox").Watermark("Search By Name, Phone, Or ID");
    });
</script>

<script>
    $(function() {
        $(".datepicker").datepicker();
    });
</script>

<body>
    <div style="margin-top: 2%" class="container">

        <div  align="center" class="panel panel-default ">
            <div align="center" class="panel-body">
                <div class="page-header">
                    <div class= "app-title">

                        <div id="barcodeDiv" class="forFloat" >
                            <form  id="ba" method="post" action="<?php echo base_url(); ?>index.php/order/search_order_barcode">
                                <td><input style="width: 100%; display:inline" type="text" placeholder="Barcode" name="BarCode" id="BarCode"  onmouseover="this.focus();" />
                                    <button style="display: inline" id="subBar">OK</button></td>
                            </form>
                        </div>
                        <div style="clear: both"></div>
                        <img src='<?php echo base_url() ?>resources/images/logo2.jpg'/><br>
                    </div>
                </div>
                <div  class="row">
                    <div  class="col">
                        <h2><?php echo lang('search_filters'); ?></h2>
                        <table>
                            <td><?php echo lang('search_by'); ?>:
                                <select id="search_by">
                                    <option value="1" selected="selected"><?php echo lang('order_number'); ?></option>
                                    <option value="2"><?php echo lang('other_filters'); ?></option>
                                </select>
                            </td>
                        </table>
                        <br>
                        <table id= "search_by_order_id">
                            <tr>
                                <td>
                                    <label class='label'><?php echo lang('order_number'); ?>:</label>
                                </td>
                                <td>
                                    <input style="margin-bottom: 8px" type="text" class='input' id = "order_id" name="order_id"></input>				
                                </td>
                                <td >				
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div  class="row">
                    <div  class="col">
                        <table id= "search_filters" style="display:none;">
                            <tr>
                                <td><?php echo lang('customer'); ?>: 
                                    <div style=""><input type="text" autocomplete = "off" class="search" id="searchbox" /></div>
                                </td>
                            </tr>
                            <tr>
                                <td id = "select_contact">
                                    <div id="display"></div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" id = "selected_contact"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button style="display: none" id="change_customer" value="Change" type="button" class="btn"><?php echo lang('change'); ?></button>
                                    <br>
                                </td>
                            </tr>
                    </div>
                </div>
                <div  class="row">
                    <div  class="col">
                        <tr>
                            <td>
                                <?php echo lang('from_date'); ?>:
                                <input type="text" style="margin-bottom: 8px" class="datepicker" id="from_date" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo lang('to_date'); ?>:
                                <input type="text" style="margin-bottom: 8px" class="datepicker" id="to_date" />
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <?php echo lang('search_in') ?>
                                <select style="margin-bottom: 10px" name = "search_in_delivered_undelivered" id="search_in_delivered_undelivered">
                                    <option value="search_all"><?php echo lang('search_all') ?></option>
                                    <option value="search_delivered"><?php echo lang('search_delivered') ?></option>
                                    <option value="search_undelivered"><?php echo lang('search_undelivered') ?></option>
                                </select>
                            </td>
                        </tr>
                        </table>
                        <button class = "submit_btn" type="button" id="button_search"><?php echo lang('search'); ?></button>

                    </div>
                </div>
            </div>
            <div  class="search_results">	


                <div id="_table_div_" class="_table_div_">
                </div>
            </div>
        </div>
        <div id = "customer_id" value=""></div>

    </div>


</body>