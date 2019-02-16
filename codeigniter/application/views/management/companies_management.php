<body>
    <style>
        .form-display-as-box, .form-input-box, .form-title-left, div.form-button-box {
            float: none !important
        }

        div.form-button-box {
            display: inline
        }
        .ui-corner-all {
            // margin-top: 20px
        }
        .dataTables_wrapper {
            margin-top: 0% !important
        }

        .ui-multiselect li a.action {
            left: 2px !important;
            right: 90% !important
        }

        .groceryCrudTable tfoot tr th input[type=text], .datatables div.form-div input[type=text], .datatables div.form-div select, .datatables div.form-div textarea {
            width: 40% !important
        }
        .readonly_label, .form-display-as-box, .form-input-box {
            display: inline !important;
        }

    </style>
    <?php
    foreach ($css_files as $file):
        ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>
    <?php foreach ($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
    <div class = "container" style = "direction: rtl">        
        <div style = "width:90%; margin-right: 5%">
            <br><br><br>
            <h1 style="margin-bottom: 0%;color: white"><?php echo $this->lang->line('companies')?>:</h1>

            <div style="clear: both"></div>
            <br><br>
            <?php echo $output;
            ?>
        </div>
        <br><br>
    </div>
    <div id="new_sms" class="modal fade" role="dialog">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header inputs-font header-background ">                
                    <div class="row">
                        <div class="col-md-12 col-sm-12 header-background">
                            <button type="button" class="close pull-left" data-dismiss="modal" aria-hidden="true">x</button>
                            <h3 id="myModalLabel1" class="modal-title" >إرسال رسالة جديدة</h3>
                        </div>
                    </div>
                </div>        
                <div id="modal-body" class="modal-body inputs-font">
                    <center>
                        <input name="new_sms" type="text" style=" display: block; direction: rtl; text-align: right;" />
                        <br>
                        <button id="send_sms_btn">إرسال</button>
                        <div class="error"></div>
                    </center>
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function () {
           // $('.fg-toolbar').hide();
           $('.dataTables_filter label:first input').attr("onmouseover", "this.focus();");
            $('th').css("text-align", "right");
            $('th:last').html("");
//            $('tr').each(function () {
//                $(this).find('.actions a:last span:last').html("تعديل");
//                if ($(this).find('td:nth-child(3) p').html() == 'نعم') {
//                    $(this).find('.actions a:first span:last').html('تعطيل');
//                    $(this).find('.actions a:first span:first').hide();
//                }
//            });

            $('#send_sms_btn').click(function () {
                $('.error').html("");
                $.ajax({
                    type: "POST",
                    url: site_url + "/messages_c/send_new_sms",
                    dataType: "json",
                    data: {'message': $('input[name=new_sms]').val()},
                    success: function (data) {
                        console.log(data);
                        $('#new_sms').modal("hide");
                        show_message(data["result"]["done"]);
                    },
                    error: function (response) {
                        console.log(JSON.parse(response["responseText"]));
                        var res = JSON.parse(response["responseText"]);
                        $('.error').html(res["result"]["error"]);
                    }
                });
            });
        });
    </script>
</body>

