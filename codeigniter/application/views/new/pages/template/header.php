

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() . 'new/assets/img/apple-icon.png' ?>">
    <link rel="icon" type="image/png" href="<?php echo base_url() . 'new/assets/img/favicon.png' ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Now UI Dashboard by Creative Tim
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="<?php echo base_url() . 'new/assets/css/bootstrap.min.css' ?>" rel="stylesheet" />
    <link href="<?php echo base_url() . 'new/assets/css/now-ui-dashboard.css?v=1.2.0' ?>" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="<?php echo base_url() . 'new/assets/demo/demo.css' ?>" rel="stylesheet" />
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
</head>
