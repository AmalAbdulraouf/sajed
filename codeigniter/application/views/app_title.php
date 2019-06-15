<style type="text/css">

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;
        float: right
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f6f6f6;
        min-width: 450px;
        border: 1px solid #ddd;
        z-index: 1;
    }


    /* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
    .show {display:block;}   

    input[name=BarCode],select[name=BarCode] {
        text-align: center;
        background-color: #FBFBFB;
        font-size: 16px;
        font-weight: 200;
        padding: 10px 0;
        border-radius: 4px !important;
        width: 45% !important;
        border: 1px solid #ddd !important;
        margin-bottom:0px;
        outline: none;
        height: 46px !important; 
    }
</style>
<div class= "app-title">
    <div id="barcodeDiv" class=" row" >
        <div class="col-md-6 pull-left">
            <img onclick="location.href = '<?php echo site_url() ?>';" style="max-width: 90%;height: 45px;margin-left: 50px;float:left;cursor:pointer" src='<?php echo base_url() ?>resources/images/logo2.jpg'/>
        </div>

        <div class="col-md-4 pull-right">
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
            <div class="item" onclick="openNavWarranty();">
                <a href="<?php echo site_url().'/order/call_center_view' ?>">
                    <img  src="<?php echo base_url() ?>/resources/images/call-center-worker-with-headset.png" width="35px" height="35px"  alt="" />
                </a>
            </div>

            <input style="display:inline" type="text" placeholder="Barcode" name="" id="BarCode"  onmouseover="this.focus();" />
            <button class="btn btn-primary" style="display: inline" 
                    id="subByBarcode"><?php echo $this->lang->line('search'); ?></button>
        </div>
        <div class="col-md-1">
<!--            <input style=" display:inline" type="text"
                   placeholder="<?php echo $this->lang->line('search_by_phone'); ?>"
                   name="BarCode" 
            <?php
            if (isset($_GET['phone']) && $_GET['phone'] != "") {
                echo 'value="' . $_GET['phone'] . '"';
            }
            ?>
                   id="byPhone"  onmouseover="this.focus();" />-->

            <div class="dropdown">
                <button onclick="myFunction()" 
                        style="font-size: 16px;
                        height: 37px;
                        margin-top: 3px;"
                        class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                <div id="myDropdown" class="dropdown-content">
                    <br><br>
                    <input style=" display:inline" type="text"
                           placeholder="<?php echo $this->lang->line('order_number'); ?>"
                           name="BarCode" 
                           id="byOrderNum"  onmouseover="this.focus();" />
                    <br><br>
                    <input style=" display:inline" type="text"
                           placeholder="<?php echo $this->lang->line('full_name'); ?>"
                           name="BarCode" 
                           id="byFullname"  onmouseover="this.focus();" />
                    <input style=" display:inline" type="text"
                           placeholder="<?php echo $this->lang->line('phone'); ?>"
                           name="BarCode" 
                           id="byPhone"  onmouseover="this.focus();" />
                    <br><br>
                    <input style=" display:inline" type="text"
                           placeholder="<?php echo $this->lang->line('serial_no'); ?>"
                           name="BarCode" 
                           id="bySerNo"  onmouseover="this.focus();" />
                    <br><br>
                    <select
                        style=" display:inline" type="text"
                        name="BarCode" 
                        id="byType" class="form-control input-md"
                        >
                        <option value="0"><?php echo $this->lang->line('machine_type'); ?></option>
                    </select>
                    <select
                        style=" display:inline" type="text"
                        name="BarCode" 
                        id="byBrand" class="form-control input-md"
                        >
                        <option value="0"><?php echo $this->lang->line('brand'); ?></option>
                    </select>
<!--                    <input style=" display:inline" type="text"
                           placeholder="<?php echo $this->lang->line('machine_type'); ?>"
                           name="BarCode" 
                           id="byType"  onmouseover="this.focus();" />
                    <input style=" display:inline" type="text"
                           placeholder="<?php echo $this->lang->line('brand'); ?>"
                           name="BarCode" 
                           id="byBrand"  onmouseover="this.focus();" />-->
                    <br><br>
                    <select
                        style=" display:inline" type="text"
                        name="BarCode" 
                        id="byModel" class="form-control input-md"
                        >
                        <option value="0"><?php echo $this->lang->line('model'); ?></option>
                    </select>
                    <select
                        style=" display:inline" type="text"
                        name="BarCode" 
                        id="byColor" class="form-control input-md"
                        >
                        <option value="0"><?php echo $this->lang->line('color'); ?></option>
                    </select>
<!--                    <input style=" display:inline" type="text"
                           placeholder="<?php echo $this->lang->line('model'); ?>"
                           name="BarCode" 
                           id="byModel"  onmouseover="this.focus();" />
                    <input style=" display:inline" type="text"
                           placeholder="<?php echo $this->lang->line('color'); ?>"
                           name="BarCode" 
                           id="byColor"  onmouseover="this.focus();" />-->
                    <br><br>
                    <button class="btn btn-primary" style="display: inline" 
                            id="subByPhone"><?php echo $this->lang->line('search'); ?></button>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="clear: both"></div>

<script type="text/javascript">
    var site_url = "<?php echo site_url() ?>";
    $('#subByPhone').click(function () {
        location.href = site_url + '/order/search_order_by_phone?phone=' + $('#byPhone').val() +
                '&name=' + $('#byFullname').val() +
                '&number=' + $('#byOrderNum').val() +
                '&serial_num=' + $('#bySerNo').val() +
                '&brand=' + $('#byBrand').val() +
                '&model=' + $('#byModel').val() +
                '&type=' + $('#byType').val() +
                '&color=' + $('#byColor').val();
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
    /* When the user clicks on the button,
     toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }
    $(document).ready(function () {
        $.ajax({
            type: "GET",
            url: site_url + "/main/get_data/format/json",
            dataType: "json",
            success: function (data) {
                console.log(data);
                var types = data.data.machines_types;
                data = data.data;
                console.log(types.length);
                $.each(types, function (i, val) {
                    if (i != 0)
                        $('#byType').append("<option value='" + i + "'>" + val + "</option>");
                });
                $.each(data.brands, function (i, val) {
                    if (i != 0)
                        $('#byBrand').append("<option value='" + i + "'>" + val + "</option>");
                });
                $.each(data.colors, function (i, val) {
                    if (i != 0)
                        $('#byColor').append("<option value='" + i + "'>" + val + "</option>");
                });
                $.each(data.colors, function (i, val) {
                    if (i != 0)
                        $('#byColor').append("<option value='" + i + "'>" + val + "</option>");
                });
            },
            error: function (response) {
            }
        });
    });
</script>