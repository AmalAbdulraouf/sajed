
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حاسبات الخليج</title>
    <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/jquery-ui.css' ?>'>
    <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/css/bootstrap.min.css' ?>'>
    <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/styles.css' ?>'>
    <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/css/sideMenu.css' ?>'>
    <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/css/font-awesome.min.css' ?>'>
    <script src='<?php echo base_url() . 'resources/jquery-1.11.1.min.js' ?>'></script>
    <script src='<?php echo base_url() . 'resources/jquery-1.10.2.min.js' ?>'></script>
    <script src='<?php echo base_url() . 'resources/jquery-ui.js' ?>'></script>
    <script src='<?php echo base_url() . 'resources/jquery.watermarkinput.js' ?>'></script>
    <script src='<?php echo base_url() . 'resources/js/bootstrap.js' ?>'></script>

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

    <style type="text/css">
        .face {
            opacity: 0.5;
            cursor: pointer
        }
        .selected-face {
            opacity: 1;
            cursor: pointer
        }
    </style>

    <script>
        var language = {
            company: "<?php echo $this->lang->line('company') ?>",
            customer_points: "<?php echo $this->lang->line('customer_points') ?>",
            customer_discount: "<?php echo $this->lang->line('customer_discount') ?>",
            not_delivered: "<?php echo $this->lang->line('not_delivered_machines') ?>",
            previous_machines: "<?php echo $this->lang->line('prev_machines') ?>",
            company_delegate: "<?php echo $this->lang->line('delegate_name') ?>",
            name: "<?php echo $this->lang->line('full_name') ?>",
            choose: "<?php echo $this->lang->line('choose') ?>",
            warranty_over: "<?php echo lang('warranty_is_over') ?>",
            day: "<?php echo lang('day') ?>",
            confirm_delete: "<?php echo lang('confirm_delete_msg') ?>"
        };

        var site_url = "<?php echo site_url() ?>";
        var base_url = "<?php echo base_url(); ?>";
        $(document).ready(function () {
            $('#subBar').click(function () {
                $('#ba').submit();
            });
            $("#English").click(function () {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function ()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        location.reload(true);
                    }
                }

                var link = "<?php echo base_url(); ?>" + "index.php/language/change_language?language=English";
                xmlhttp.open("GET", link, true);
                xmlhttp.send();
            });
            $("#Arabic").click(function () {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function ()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        location.reload(true);
                    }
                }

                var link = "<?php echo base_url(); ?>" + "index.php/language/change_language?language=Arabic";
                xmlhttp.open("GET", link, true);
                xmlhttp.send();
            });
            $('.face,.selected-face').click(function () {
//                if ($(this).hasClass('face')) {
                    $(this).removeClass('face');
                    $('.selected-face').addClass('face');
                    $('.selected-face').removeClass('selected-face');
                    $(this).addClass('selected-face');
//                } else {
//                    $(this).addClass('face');
//                    $(this).removeClass('selected-face');
//                }
            });
        });

    </script>
</head>
