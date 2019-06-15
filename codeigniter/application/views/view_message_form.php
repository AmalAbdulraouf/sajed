<body>
    <div style="margin-top: 10%" class="container">
        <div align="center" class="panel panel-default">
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
                        <img style="max-width: 90%" src='<?php echo base_url() ?>resources/images/logo2.jpg'/><br>
                    </div>
                </div>
                <div class="row" id="create_message">
                    <?php
                    echo form_open('order/send_message_to_customer/' . $order_id . '/' . $customer_phone, array('class' => 'addForm'));

                    echo "<error>";
                    echo validation_errors();
                    echo "</error>";
                    if($customer_phone!='')
                        echo lang('phone').": ".$customer_phone . '<br>';
                    echo form_textarea('message_text', $message, 'class = "form-control" style="width:65%; max-width: 65%; min-width: 65%" placeholder="' . lang('message') . '"');
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
    </div>
</body>