<body>
    <div style="margin-top: 12%" class="container">

        <div  align="center" class="panel panel-default ">
            <div align="center" class="panel-body">
                <div class="page-header">
                    <div class= "app-title">

                        <div id="barcodeDiv" class="forFloat" >
                            <form  id="ba" method="post" action="<?php echo base_url();?>index.php/order/search_order_barcode">
                                <td><input style="width: 100%; display:inline" type="text" placeholder="Barcode" name="BarCode" id="BarCode"  onmouseover="this.focus();" />
                                    <button style="display: inline" id="subBar">OK</button></td>
                            </form>
                        </div>
                        <div style="clear: both"></div>
                        <img style="max-width: 90%" src='<?php echo base_url()?>resources/images/logo2.bmp'/><br>
                    </div>
                </div>
                <div  class="row">
                    <div  class="col">
								<?php 
									{
										echo '<button class="report_menu_item" type="button" 
										onClick="location.href=\''.base_url().'index.php/management/load_lists_management_page\'">'.lang('manage_lists').'</button><br>';
									}
								?>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
								<?php 
								{
									echo '<button class="report_menu_item" type="button" 
									onClick="location.href=\''.base_url().'index.php/management/export_customers_to_excel\'">'.lang('export_customers_to_excel').'</button><br>';
								}
									?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
								<?php 
								{
									echo '<button class="report_menu_item" type="button" 
									onClick="location.href=\''.base_url().'index.php/options/SMS_options\'">'.lang('SMS_options').'</button><br>';
								}
				
								?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
								<?php 
								{
									echo '<button class="report_menu_item" type="button" 
									onClick="location.href=\''.base_url().'index.php/options/email_options\'">'.lang('email_options').'</button><br>';
								}
								?>
                    </div>
                </div>
            </div>
        </div>	
    </div>
</div>
</body>