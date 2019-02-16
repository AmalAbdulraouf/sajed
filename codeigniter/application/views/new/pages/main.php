<?php $user_permissions = $this->session->userdata('user_permissions'); ?>

<div class="row">
    <?php if (permission_included($user_permissions, 'Receive an order')) { ?>
        <div class = "font-icon-list col-lg-3 col-md-3 col-sm-4 col-xs-6 col-xs-6">
            <div class = "font-icon-detail"onclick="location.href = '<?php echo base_url() . 'index.php/order/add_new_order' ?>'">
                <i class = "now-ui-icons education_paper"></i>
                <p><?php echo lang('receive_a_new_order') ?></p>
            </div>
        </div>
    <?php } ?>
    <div class="font-icon-list col-lg-3 col-md-3 col-sm-4 col-xs-6 col-xs-6">
        <div class="font-icon-detail"  onclick="location.href = '<?php echo base_url() . 'index.php/order/load_search_orders' ?>'">
            <i class="now-ui-icons ui-1_zoom-bold"></i>
            <p><?php echo lang('search_orders') ?></p>
        </div>
    </div>
    <?php if (permission_included($user_permissions, 'Perform Repair Action')) { ?>
        <div class="font-icon-list col-lg-3 col-md-3 col-sm-4 col-xs-6 col-xs-6">
            <div class="font-icon-detail" onclick="location.href = '<?php echo base_url() . 'index.php/technician_tasks' ?>'">
                <i class="now-ui-icons files_single-copy-04"></i>
                <p><?php echo lang('orders_assigned_to_me') ?></p>
            </div>
        </div>
    <?php } ?>
    <?php if (permission_included($user_permissions, 'View Reports')) { ?>
        <div class="font-icon-list col-lg-3 col-md-3 col-sm-4 col-xs-6 col-xs-6">
            <div class="font-icon-detail" onclick="location.href = '<?php echo base_url() . 'index.php/reports' ?>'">
                <i class="now-ui-icons business_chart-bar-32"></i>
                <p><?php echo lang('reports') ?></p>
            </div>
        </div>
    <?php } ?>
    <?php if (permission_included($user_permissions, 'Users Management')) { ?>
        <div class="font-icon-list col-lg-3 col-md-3 col-sm-4 col-xs-6 col-xs-6">
            <div class="font-icon-detail">
                <i class="now-ui-icons users_single-02"></i>
                <p><?php echo lang('users_management') ?></p>
            </div>
        </div>
    <?php } ?>
    <?php if (permission_included($user_permissions, 'Manage Lists')) { ?>
        <div class="font-icon-list col-lg-3 col-md-3 col-sm-4 col-xs-6 col-xs-6">
            <div class="font-icon-detail">
                <i class="now-ui-icons ui-1_settings-gear-63"></i>
                <p><?php echo lang('manage_system') ?></p>
            </div>
        </div>
    <?php } ?>
    <div class="font-icon-list col-lg-3 col-md-3 col-sm-4 col-xs-6 col-xs-6">
        <div class="font-icon-detail" >
            <i class="now-ui-icons objects_globe"></i>
            <p><?php echo lang('o_l_name') ?></p>
        </div>
    </div>
    <div class="font-icon-list col-lg-3 col-md-3 col-sm-4 col-xs-6 col-xs-6">
        <div class="font-icon-detail" onclick="location.href = '<?php echo base_url() . 'index.php/main/logout' ?>'">
            <i class="now-ui-icons ui-1_lock-circle-open"></i>
            <p><?php echo lang('logout') ?></p>
        </div>
    </div>
</div>
