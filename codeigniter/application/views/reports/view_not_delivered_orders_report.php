<link rel="stylesheet" type="text/css" href='<?php echo base_url(); ?>resources/datatables.min.css'/>
<script type="text/javascript" src='<?php echo base_url(); ?>resources/datatables.min.js'></script>
<link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/search_contacts.css' ?>'>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script>
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
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    $("#search_results").html(xmlhttp.responseText);
                    $("#orders_table").dataTable({
                        bFilter: false,
                        bInfo: false,
                        bPaginate: true
                    });
                }
            }

            var link = "<?php echo base_url() . 'index.php/reports/load_non_delivered_orders?'; ?>";
            link += "date_from=" + $("#from_date").val();
            xmlhttp.open("GET", link, true);
            xmlhttp.send();
            $(".search_results").show();
        });
    });

    $(document).ready(function() {
        $("#from_date").val("01/01/2000");
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
</script>

<script>
    $(function() {
        $(".datepicker").datepicker({defaultDate: '01/01/01'});
    });
</script>
<body>
    <div style="margin-top: 2%" class="container">

        <div  align="center" class="panel panel-default ">
            <div align="center" class="panel-body">
                <div class="page-header">
                    <?php $this->load->view('app_title') ?>
                </div>
                <div style="text-align:center">
                    <img src='<?php echo base_url() ?>resources/images/logo2.jpg'/>
                </div>
                <div  class="row">
                    <div  class="col">
                        <h2><?php echo lang('search_filters') ?></h2>
                        <table id= "search_filters" >				
                            <tr>
                                <td><div><input type="text" class="datepicker" id="from_date" /></div></td>
                                <td><?php echo lang('from_date') ?>: </td>

                            </tr>			
                        </table>
                        <br>
                        <button class = "submit_btn" type="button" id="button_search"><?php echo lang('search') ?></button>
                    </div>
                    <div  class="search_results" style="display: none">	

                        <h2><br><?php echo lang('search_results') ?></h2>
                        <div id="search_results">

                            <div id="_table_div_" class="_table_div_">
                            </div>
                        </div>
                    </div>
                </div>

                <div id = "customer_id" value=""></div>
            </div>

        </div>
    </div>	
</div>
</div>
</body>