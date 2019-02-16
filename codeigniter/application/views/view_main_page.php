<html>
    <head>		
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <title>حاسبات الخليج</title>	
        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/jquery-ui.css' ?>'>
        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/css/bootstrap.min.css' ?>'>
        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/styles.css' ?>'>
        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/css/sideMenu.css' ?>'>
        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/css/font-awesome.min.css' ?>'>
        <style type="text/css">
            .no-close .ui-dialog-titlebar-close {
                display: none !important;
            }
            .no-close {
                /*position: relative !important*/
            }
            .no-close input {
                margin-top:5px;
                padding-right: 3px;
                padding-left: 3px;
                font-size: 14px
            }
            .error{
                color: red
            }
        </style>
        <?php
        if ($this->session->userdata('language') == 'Arabic') {
            $this->lang->load('website', 'arabic');
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/style-ar.css">';
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/search_contacts-ar.css">';
        } else {
            $this->lang->load('website', 'english');
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/style-en.css">';
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/search_contacts-en.css">';
        }
        ?>
        <script src='<?php echo base_url() . 'resources/jquery-1.11.1.min.js' ?>'></script>
        <script src='<?php echo base_url() . 'resources/jquery-1.10.2.min.js' ?>'></script>
        <script src='<?php echo base_url() . 'resources/jquery-ui.js' ?>'></script>
        <script src='<?php echo base_url() . 'resources/jquery.watermarkinput.js' ?>'></script>
        <script src='<?php echo base_url() . 'resources/js/bootstrap.js' ?>'></script>
        <script>


            $(document).ready(function () {
                $('.loader').hide();
                var attention = <?php echo $this->session->userdata('give_attention'); ?>;
//                alert(attention);
                if (attention != 1 && attention != 0)
                {
                    $('.loader').show();
                    $('#forHide').hide();
                    var b_url = "<?php echo base_url(); ?>";
                    window.location.href = b_url + "index.php/order/give_attentions";
                }
            });
            $(document).ready(function () {
                $(".change_language").click(function () {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function ()
                    {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                        {
                            location.reload(true);
                        }
                    }

                    var link = "<?php echo base_url(); ?>" + "index.php/language/change_language?language=" + $(this).attr('id');
                    xmlhttp.open("GET", link, true);
                    xmlhttp.send();
                });

                $('#subBar').click(function () {
                    $('#ba').submit();
                });
            });

        </script>
    </head>

    <body>

        <div class="container">            
            <?php
            $user_permissions = $this->session->userdata('user_permissions');
            $this->load->view('SideMenu');
            ?>
            <div class="row">
                <div class="panel panel-default ">
                    <div align="center" class="panel-body">
                        <div class="page-header">
                            <?php $this->load->view('app_title') ?>
                            <?php $this->load->view('warranty_following')?>
                        </div>
                        <div class='loader'>Loading...</div>
                        <div  id="forHide" class="options_holder">
                            <?php
// reports
                            if (permission_included($user_permissions, 'View Reports')) {
                                ?>
                                <div class="col-md-3">
                                    <?php
                                    echo '<a href = ' . base_url() . 'index.php/reports>';
                                    echo '<img src=' . base_url() . 'resources/images/reports-128.png>';
                                    echo '<br>' . lang('reports') . '</a><br><br><br>';
                                    ?>
                                </div>

                                <?php
                            }




                            if (permission_included($user_permissions, 'Perform Repair Action')) {
                                ?>
                                <div class="col-md-3">
                                    <?php
                                    echo '<a href = ' . base_url() . 'index.php/order/technician_tasks>';
                                    echo '<img src=' . base_url() . 'resources/images/orders-128.png>';
                                    echo '<br>' . lang('orders_assigned_to_me') . '</a><br><br><br>';
                                    ?>
                                </div>

                                <?php
                            }



// search orders
                            {
                                ?>
                                <!--                                <div class="col-md-3">
                                <?php
                                echo '<a href = ' . base_url() . 'index.php/order/load_search_orders>';
                                echo '<img src=' . base_url() . 'resources/images/search-128.png>';
                                echo '<br>' . lang('search_orders') . '</a><br><br><br>';
                                ?>
                                                                </div>-->

                                <div class="col-md-3">
                                    <?php
                                    echo '<a href = ' . base_url() . 'index.php/reports/orders_report_view>';
                                    echo '<img src=' . base_url() . 'resources/images/search-128.png>';
                                    echo '<br>' . lang('search_orders') . '</a><br><br><br>';
                                    ?>
                                </div>

                                <?php
                            }

                            if (permission_included($user_permissions, 'Receive an order')) {
                                ?>
                                <div class="col-md-3">
                                    <?php
                                    echo '<a href = ' . base_url() . 'index.php/order/add_new_order>';
                                    echo '<img src=' . base_url() . 'resources/images/receive_an_order-128.png>';
                                    echo '<br>' . lang('receive_a_new_order') . '</a><br><br><br>';
                                    ?>
                                </div>

                                <?php
                            }

                            // logout
                            {
                                ?>
                                <div class="col-md-3">
                                    <?php
                                    echo '<a href = ' . base_url() . 'index.php/main/logout>';
                                    echo '<img src= ' . base_url() . 'resources/images/logout-128.png>';
                                    echo '<br>' . lang('logout') . '</a><br><br><br>';
                                    ?>
                                </div>

                                <?php
                            }

                            // Language
                            {
                                ?>
                                <div class="col-md-3">
                                    <?php
                                    echo '<div id="Arabic" class="change_language"><a><img style="border:0;" src= ' . base_url() . 'resources/images/arabic.png>';
                                    echo '<br>' . lang('o_l_name');
                                    echo '</a></div>';
                                    echo '<div id="English" class="change_language"><a><img width="128" height="128" style="border:0" src= ' . base_url() . 'resources/images/english.png>';
                                    echo '<br>' . lang('o_l_name') . '</a></div><br><br><br>';
                                    ?>
                                </div>

                                <?php
                            }

                            if (permission_included($user_permissions, 'Manage Lists')) {
                                ?>
                                <div class="col-md-3">
                                    <?php
                                    echo '<a href = ' . base_url() . 'index.php/management>';
                                    echo '<img src=' . base_url() . 'resources/images/management-128.png>';
                                    echo '<br>' . lang('manage_system') . '</a><br><br><br>';
                                    ?>
                                </div>

                                <?php
                            }

                            if (permission_included($user_permissions, 'Users Management')) {
                                ?>
                                <div class="col-md-3">
                                    <?php
                                    echo '<a href = ' . base_url() . 'index.php/users_manager>';
                                    echo '<img src=' . base_url() . 'resources/images/users_management-128.png>';
                                    echo '<br>' . lang('users_management') . '</a><br><br><br>';
                                    ?>
                                </div>

                            <?php } ?>




                        </div>
                    </div>
                </div>	
            </div>
        </div>

    </body>
</html>


