
<div class= "app-title">
    <div id="barcodeDiv" class=" row" >
        <div class="col-md-6 pull-left">
            <img onclick="location.href = '<?php echo site_url() ?>';" style="max-width: 90%;height: 45px;margin-left: 50px;float:left;cursor:pointer" src='<?php echo base_url() ?>resources/images/logo2.jpg'/>
        </div>
        <div class="col-md-3">
            <?php
            $warranty_orders = array();
            $receipt_employees = array();
            $this->load->model('model_order');
            $warranty_orders = $this->model_order->get_employee_warranty_orders($this->session->userdata('user_name'));
            ?>

            <div class="item" onclick="openNavWarranty();">
                <a href="#">
                    <?php if (count($warranty_orders) != 0) { ?>
                        <span class="badge" id="badge"><?php echo count($warranty_orders) ?></span>
                    <?php } ?>
                    <img  style="opacity: <?php echo (count($warranty_orders) != 0) ? 0.6 : 0.3 ?>" src="<?php echo base_url() ?>/resources/images/warranty.png" width="35px" height="35px"  alt="" />
                </a>
            </div>

            <input style="display:inline" type="text" placeholder="Barcode" name="" id="BarCode"  onmouseover="this.focus();" />
            <button class="btn btn-primary" style="display: inline" 
                    id="subByBarcode"><?php echo $this->lang->line('search'); ?></button>
        </div>
        <div class="col-md-3">
            <input style=" display:inline" type="text"
                   placeholder="<?php echo $this->lang->line('search_by_phone'); ?>"
                   name="BarCode" 
                   <?php
                   if (isset($_GET['phone']) && $_GET['phone'] != "") {
                       echo 'value="' . $_GET['phone'] . '"';
                   }
                   ?>
                   id="byPhone"  onmouseover="this.focus();" />
            <button class="btn btn-primary" style="display: inline" 
                    id="subByPhone"><?php echo $this->lang->line('search'); ?></button>
        </div>
    </div>
</div>
<div style="clear: both"></div>

<script type="text/javascript">
    var site_url = "<?php echo site_url() ?>";
    $('#subByPhone').click(function () {
        location.href = site_url + '/order/search_order_by_phone?phone=' + $('#byPhone').val();
    });
    $("#BarCode").autocomplete({
        autoFocus: true,
        source: function (req, add) {
            $.getJSON(site_url + "/order/search_order_barcode?BarCode=" + $('#BarCode').val(), req, function (data) {
                var suggestions = [];
                $.each(data, function (i, val) {
                    suggestions.push({
                        label: val.order_id,
                        id: val.order_id
                    }); //not val.name
                });
                add(suggestions);
            });
        },
        //select
        select: function (e, ui) {
            location.href = site_url + "/order/view_order?order_id=" + ui.item.id;
        }
    });
    $("#BarCode").autocomplete("option", "disabled", true);
    $('#subByBarcode').click(function () {
        $("#BarCode").autocomplete("option", "disabled", false);
        $('#BarCode').autocomplete('option', 'minLength', 0);
        $('#BarCode').autocomplete('search', $('#BarCode').val());
    });
</script>