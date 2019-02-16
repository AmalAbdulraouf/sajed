<body>
    <div style="margin-top: 2%" class="container">
        <div align="center" class="panel panel-default">
            <div align="center" class="panel-body">
                <div class="page-header">
             
                    <div style="text-align:center">
                        <img src='<?php echo base_url() ?>resources/images/logo2.jpg'/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <?php {
                            echo '<button class="report_menu_item" type="button" 
                            onClick="location.href=\'' . base_url() . 'index.php/management/colors_management\'">' . lang('colors') . '</button><br>';
                        }
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php {
                            echo '<button class="report_menu_item" type="button" 
                            onClick="location.href=\'' . base_url() . 'index.php/management/load_machines_types_list_management_page\'">' . lang('machine_types') . '</button><br>';
                        }
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php {
                            echo '<button class="report_menu_item" type="button" 
                            onClick="location.href=\'' . base_url() . 'index.php/management/load_brands_list_management_page\'">' . lang('brands') . '</button><br>';
                        }
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php {
                            echo '<button class="report_menu_item" type="button" 
                            onClick="location.href=\'' . base_url() . 'index.php/management/load_models_list_management_page\'">' . lang('models') . '</button><br>';
                        }
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php {
                            echo '<button class="report_menu_item" type="button" 
                            onClick="location.href=\'' . base_url() . 'index.php/management/places_management\'">' . lang('places') . '</button><br>';
                        }
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php {
                            echo '<button class="report_menu_item" type="button" 
                            onClick="location.href=\'' . base_url() . 'index.php/management/reasons_management\'">' . lang('reasons') . '</button><br>';
                        }
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php {
                            echo '<button class="report_menu_item" type="button" 
                            onClick="location.href=\'' . base_url() . 'index.php/management/receipt_employee_management\'">' . lang('receipt_employee') . '</button><br>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>