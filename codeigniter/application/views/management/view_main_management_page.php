<div  align="center" class="panel panel-default ">
    <div class="panel-heading">
        <h3> <?php echo lang('manage_system') ?></h3>
    </div>
    <div align="center" class="panel-body">
        <div  class="row">
            <div  class="col-md-4">
                <?php {
                    echo '<button class="report_menu_item" type="button" 
                            onClick="location.href=\'' . base_url() . 'index.php/contacts/contacts_management\'">' . lang('customers') . '</button><br>';
                }
                ?>
            </div>
            <div  class="col-md-4">
                <?php {
                    echo '<button class="report_menu_item" type="button" 
                            onClick="location.href=\'' . base_url() . 'index.php/companies/companies_management\'">' . lang('companies') . '</button><br>';
                }
                ?>
            </div>
            <div  class="col-md-4">
                <?php {
                    echo '<button class="report_menu_item" type="button" 
                            onClick="location.href=\'' . base_url() . 'index.php/management/load_lists_management_page\'">' . lang('manage_lists') . '</button><br>';
                }
                ?>
            </div>
            <div  class="col-md-4">
                <?php {
                    echo '<button class="report_menu_item" type="button" 
                            onClick="location.href=\'' . base_url() . 'index.php/management/export_customers_to_excel\'">' . lang('export_customers_to_excel') . '</button><br>';
                }
                ?>
            </div>
            <div  class="col-md-4">
                <?php {
                    echo '<button class="report_menu_item" type="button" 
                            onClick="location.href=\'' . base_url() . 'index.php/options/SMS_options\'">' . lang('SMS_options') . '</button><br>';
                }
                ?>
            </div>
            <div  class="col-md-4">
                <?php {
                    echo '<button class="report_menu_item" type="button" 
                                                                                                onClick="location.href=\'' . base_url() . 'index.php/options/email_options\'">' . lang('email_options') . '</button><br>';
                }
                ?>
            </div>
            <div  class="col-md-4">
                <?php {
                    echo '<button class="report_menu_item" type="button" 
                                                                                                onClick="location.href=\'' . base_url() . 'index.php/contacts/send_notification_view\'">' . lang('send_notification') . '</button><br>';
                }
                ?>
            </div>
        </div>
    </div>
</div>	
