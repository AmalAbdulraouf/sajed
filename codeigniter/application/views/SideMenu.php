<?php $user_permissions = $this->session->userdata('user_permissions'); ?>
<script type="text/javascript">
    var site_url = "<?php echo site_url() ?>";
    function openNav() {
        document.getElementById("mySidenav").style.width = "200px";
    }

    /* Set the width of the side navigation to 0 */
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>
<div id="mySidenav" class="sidenav">
    <ul class="navbar overflow-hidden">
        <li href="javascript:void(0)" onclick="closeNav();"
            class="closebtn icon-align-justify ui-tabs-active ui-state-active" 
            style="    
            color: #337ab7;
            font-size: 30px;
            display: inline;
            z-index: 140000;
            margin-left: 16px;
            cursor:pointer;
            position: absolute;
            top:16px
            "
            > </li>
        <br><br>
        <br>
        <li>
            <a>
            <span data-toggle="tooltip"
                title="<?php echo $this->session->userdata('user_name')?>"
                data-placement="bottom" 
                style="font-size: 24px;" class="glyphicon glyphicon-user"></span>
                <?php echo $this->session->userdata('user_name')?>
            </a>
        </li>
        <hr>
        <li onclick="location.href = site_url + '/order/add_new_order';">
            <a href="#tabs-1">
                <?php echo lang('receive_a_new_order') ?>
            </a>
        </li>
        <li onclick="location.href = site_url + '/reports/orders_report_view';">
            <a href="#tabs-1">
                <?php echo lang('search_orders') ?>
            </a>
        </li>
        <li onclick="location.href = site_url + '/order/technician_tasks';">
            <a href="#tabs-1">
                <?php echo lang('orders_assigned_to_me') ?>
            </a>
        </li>
        <hr>
        <li onclick="location.href = site_url + '/reports';">
            <a href="#tabs-1">
                <?php echo lang('reports') ?>
            </a>
        </li>
        <hr>
        <?php if (permission_included($user_permissions, 'Manage Lists')) {
            ?>
            <li onclick="location.href = site_url + '/management';">
                <a href="#tabs-1">
                    <?php echo lang('manage_system') ?>
                </a>
            </li>
        <?php } ?>
        <?php if (permission_included($user_permissions, 'Users Management')) {
            ?>
            <li onclick="location.href = site_url + '/users_manager/';">
                <a href="#tabs-1">
                    <?php echo lang('users_management') ?>
                </a>
            </li>

        <?php } ?>
        <hr>
        <?php
        echo '<li id="Arabic" class="change_language"><a>';
        echo lang('o_l_name');
        echo '</a></li>';
        echo '<li id="English" class="change_language"><a>';
        echo  lang('o_l_name') . '</a></li>';
        ?>
        <li onclick="location.href = site_url + '/main/logout';">
            <a href="#tabs-1">
                <?php echo lang('logout') ?>
            </a>
        </li>
    </ul>
</div>
<li class="icon-align-justify" 
    style="    
    color: #337ab7;
    font-size: 30px;
    display: inline;
    z-index: 130;
    margin-left: 16px;
    position: absolute;
    cursor:pointer;
    top: 16px;
    " 
    onclick="openNav();">
</li>
<?php

function permission_included($user_permissions_array, $permission) {
    foreach ($user_permissions_array as $per) {
        if ($per->name == $permission)
            return true;
    }
    return false;
}
?>