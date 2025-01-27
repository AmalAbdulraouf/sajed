<div class="sidebar" data-color="red">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
    <div class="logo">
        <a href="<?php echo site_url() ?>'" class="simple-text logo-normal">
            <img
                 src='<?php echo base_url() ?>resources/images/logo2.png'/>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li>
                <a href="./dashboard.html">
                    <i class="now-ui-icons design_app"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="active ">
                <a href="./icons.html">
                    <i class="now-ui-icons education_atom"></i>
                    <p>Icons</p>
                </a>
            </li>
            <li>
                <a href="./map.html">
                    <i class="now-ui-icons location_map-big"></i>
                    <p>Maps</p>
                </a>
            </li>
            <li>
                <a href="./notifications.html">
                    <i class="now-ui-icons ui-1_bell-53"></i>
                    <p>Notifications</p>
                </a>
            </li>
            <li>
                <a href="./user.html">
                    <i class="now-ui-icons users_single-02"></i>
                    <p>User Profile</p>
                </a>
            </li>
            <li>
                <a href="./tables.html">
                    <i class="now-ui-icons design_bullet-list-67"></i>
                    <p>Table List</p>
                </a>
            </li>
            <li>
                <a href="./typography.html">
                    <i class="now-ui-icons text_caps-small"></i>
                    <p>Typography</p>
                </a>
            </li>
            <li class="active-pro">
                <a href="./upgrade.html">
                    <i class="now-ui-icons arrows-1_cloud-download-93"></i>
                    <p>Upgrade to PRO</p>
                </a>
            </li>
        </ul>
    </div>
</div>
<?php

function permission_included($user_permissions_array, $permission) {
    foreach ($user_permissions_array as $per) {
        if ($per->name == $permission)
            return true;
    }
    return false;
}
?>