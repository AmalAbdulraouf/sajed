<?php $this->load->view('view_header'); ?>
<body>
    
    <div class="container">
        <?php $this->load->view('SideMenu'); ?>
        <div class="panel panel-default main-panel">
            <div class="panel-heading">
                <?php $this->load->view('app_title') ?>
                <?php $this->load->view('warranty_following')?>
            </div>
            <div class="panel-body">
                <?php $this->load->view($name, $data); ?>
            </div>
        </div>       
    </div>
    
    <?php
    if ($name == "view_view_order") {
        $this->load->view('print_view');
        $this->load->view('print_bill');
        $this->load->view('print_sticker');
        $this->load->view('print_temporary_device_info');
    }
    ?>
</body>
