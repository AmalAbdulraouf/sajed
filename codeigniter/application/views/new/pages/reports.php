<style type="text/css">
    .btn {
        width: 85%;
        /* height: 90%; */
        height: 90px;
        font-size: 20px;
    }
</style>
<div  class="row" style="direction: rtl !important">
    <div  class="col-md-4">
        <?php {
            echo '<button class="btn btn-default btn-lg" type="button" 
										onClick="location.href=\'' . base_url() . 'index.php/reports/orders_report_view\'">' . lang('orders') . '</button><br>';
        }
        ?>
    </div>
    <div  class="col-md-4">
        <?php {
            echo '<button class="btn btn-default btn-lg" type="button" 
										onClick="location.href=\'' . base_url() . 'index.php/reports/load_cash_summery_report\'">' . lang('summery_reports') . '</button><br>';
        }
        ?>
    </div>
    <div class="col-md-4">
        <?php {
            echo '<button class="btn btn-default btn-lg" type="button" 
										onClick="location.href=\'' . base_url() . 'index.php/reports/load_technicians_accomplishment\'">' . lang('technicians_accomplishment_reports') . '</button><br>';
        }
        ?>
    </div>

    <div class="col-md-4">
        <?php {
            echo '<button class="btn btn-default btn-lg" type="button" 
										onClick="location.href=\'' . base_url() . 'index.php/reports/load_data_done_work_by_machine_type\'">' . lang('done_work_filtered_by_machine_type_reports') . '</button><br>';
        }
        ?>
    </div>

    <!--                    <div class="col-md-4">
    <?php {
        echo '<button class="btn btn-default btn-lg" type="button" 
									onClick="location.href=\'' . base_url() . 'index.php/reports/load_non_delivered_orders_page\'">' . lang('non_delivered_report') . '</button><br>';
    }
    ?>
                        </div>-->

    <div class="col-md-4">
        <?php {
            echo '<button class="btn btn-default btn-lg" type="button" 
									onClick="location.href=\'' . base_url() . 'index.php/reports/technicians_excuses\'">' . lang('technicians_excuses') . '</button><br>';
        }
        ?>
    </div>

    <div class="col-md-4">
        <?php {
            echo '<button class="btn btn-default btn-lg" type="button" 
									onClick="location.href=\'' . base_url() . 'index.php/reports/delivered_orders_view\'">' . lang('delivered_orders') . '</button><br>';
        }
        ?>
    </div>

    <div class="col-md-4">
        <?php {
            echo '<button class="btn btn-default btn-lg" type="button" '
            . 'onClick="location.href=\'' . base_url() . 'index.php/reports/report_view/ready_not_delivered\'">'
            . lang('ready_not_delivered') . '</button><br>';
        }
        ?>
    </div>
    <div class="col-md-4">
        <?php {
            echo '<button class="btn btn-default btn-lg" type="button" '
            . 'onClick="location.href=\'' . base_url() . 'index.php/reports/report_view/cancelled_not_delivered\'">'
            . lang('cancelled_not_delivered') . '</button><br>';
        }
        ?>
    </div>
    <div class="col-md-4">
        <?php {
            echo '<button class="btn btn-default btn-lg" type="button" '
            . 'onClick="location.href=\'' . base_url() . 'index.php/reports/report_view/warranty_sent_machines\'">'
            . lang('warranty_sent_machines') . '</button><br>';
        }
        ?>
    </div>
    <div class="col-md-4">
        <?php {
            echo '<button class="btn btn-default btn-lg" type="button" '
            . 'onClick="location.href=\'' . base_url() . 'index.php/reports/report_view/warranty_not_delivered\'">'
            . lang('warranty_not_delivered') . '</button><br>';
        }
        ?>
    </div>
    <div class="col-md-4">
        <?php {
            echo '<button class="btn btn-default btn-lg" type="button" 
                                onClick="location.href=\'' . base_url() . 'index.php/reports/services_report_view\'">'
            . lang('services_report') . '</button><br>';
        }
        ?>
    </div>
</div>