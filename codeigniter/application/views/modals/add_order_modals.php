<div id="customer_history" class="modal fade" role="dialog">
    <div class="modal-dialog " style="width:80%;direction: rtl">
        <div class="modal-content">
            <div class="modal-header"> 
                <button type="button" class="close pull-left " data-dismiss="modal" aria-hidden="true">x</button>
                <h4><?php echo $this->lang->line('not_delivered_machines') ?></h4>
                <br>
            </div>
            <div class="modal-body" style="text-align: center">
                <div style="text-align: right" class ="table-responsive">
                    <table id="customer_history_table" class="display" style="direction: rtl;text-align: right">
                        <thead>
                        <th><?php echo lang('order_number'); ?></th>
                        <th><?php echo lang('customer_name'); ?></th>
                        <th><?php echo lang('machine_brand'); ?></th>
                        <th><?php echo lang('machine_model'); ?></th>
                        <th><?php echo lang('fault_description'); ?></th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="customer_machines" class="modal fade" role="dialog">
    <div class="modal-dialog " style="width:80%;direction: rtl">
        <div class="modal-content">
            <div class="modal-header"> 
                <button type="button" class="close pull-left " data-dismiss="modal" aria-hidden="true">x</button>
                <h4><?php echo $this->lang->line('prev_machines') ?></h4>
                <br>
            </div>
            <div class="modal-body" style="text-align: center">
                <div style="text-align: right" class ="table-responsive">
                    <table id="customer_machines_table" class="display" style="direction: rtl;text-align: right">
                        <thead>
                        <th><?php echo lang('serial_no'); ?></th>
                        <th><?php echo lang('machine_brand'); ?></th>
                        <th><?php echo lang('machine_model'); ?></th>
                        <th><?php echo lang('fault_description'); ?></th>
                        <th><?php echo $this->lang->line('machine_img') ?></th>
                        <th></th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>