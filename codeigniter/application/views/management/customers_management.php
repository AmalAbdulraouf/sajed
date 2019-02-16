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
    <script src='<?php echo base_url() . 'resources/js/bootstrap.js' ?>'></script>
<!--<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>-->
    <div class = "container" style = "direction: rtl">        
        <div style = "width:90%; margin-right: 5%">
            <h1 style="margin-bottom: 0%;color: white"><?php echo $this->lang->line('customers') ?>:</h1>

            <div style="clear: both"></div>
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
                        </div>
                    </div>
                </div>        
                <div id="modal-body" class="modal-body inputs-font">
                    <center>
                        <textarea name="new_sms" placeholder="<?php echo lang('message') ?>" required=""
                                  type="text" style=" display: block; direction: rtl; text-align: right;" ></textarea>
                        <br>
                        <button  id="132" class="sub_send ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-button-text">
                            <span class="ui-button-text">
                                <?php echo lang('submit') ?> 
                            </span>
                        </button>
                        <div class="error"></div>
                    </center>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
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

            var id;
            $('.send_ntf').click(function() {
                id = $(this).attr("id");

                $('textarea[name=new_sms]').val("");
                $('textarea[name=new_sms]').text("");
                $('.error').html("");
                $('#new_sms').modal("show");
            });
            var site_url = "<?php echo site_url() ?>";
            $('.sub_send').click(function() {
                $('.error').html("");
                var msg = $('textarea[name=new_sms]').val();
                if (msg.length == 0)
                    $('.error').html("ادخل نص الرسالة");
                else {
                    $.ajax({
                        type: "POST",
                        url: site_url + "/contacts/send_ntf_to_customer",
                        dataType: "json",
                        data: {
                            "msg": msg,
                            "contact_id": id
                        },
                        success: function(data) {
                            $('textarea[name=new_sms]').val("");
                            $('textarea[name=new_sms]').text("");
                            $('.error').html("");
                            $('#new_sms').modal("hide");
                        },
                        error: function(response) {
                        }
                    });
                }
            });
        });


    </script>
</body>

