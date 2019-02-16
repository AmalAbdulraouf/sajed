<div id="sticker" align="center" style="display:none;font-size:12px !important; margin-top: -7% !important;padding-top:0px !important">

    <?php echo lang('customer_name') . ':' . $order_info['order_basic_info'][0]->contact_fname . " " . $order_info['order_basic_info'][0]->contact_lname; ?><br>
    <?php echo lang('order'); ?> #<?php echo $order_info['order_basic_info'][0]->id ?><br>
    <?php echo lang('phone'); ?> <?php echo '9665' . $order_info['order_basic_info'][0]->contact_phone ?><br>
                <!--<img  id="barcodeSticker" height="30px" width="80px"/>-->
</div>