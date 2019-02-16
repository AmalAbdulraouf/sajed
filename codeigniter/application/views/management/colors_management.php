<body>
    <style>
        .form-display-as-box, .form-input-box, .form-title-left, div.form-button-box {
            float: none !important
        }

        div.form-button-box {
            display: inline
        }
        .ui-corner-all {
        }
        .dataTables_wrapper {
            margin-top: 0% !important
        }

        .ui-multiselect li a.action {
            left: 2px !important;
            right: 90% !important
        }

        .groceryCrudTable tfoot tr th input[type=text], .datatables div.form-div input[type=text], .datatables div.form-div select, .datatables div.form-div textarea {
            width: 40% !important
        }
        .readonly_label, .form-display-as-box, .form-input-box {
            display: inline !important;
        }

    </style>
    <?php
    foreach ($css_files as $file):
        ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>
    <?php foreach ($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
    <div class = "container" style = "direction: rtl">        
        <div style = "width:90%; margin-right: 5%">
            <h1 style="margin-bottom: 0%;color: white"><?php echo $this->lang->line('colors')?>:</h1>

            <div style="clear: both"></div>
            <?php echo $output;
            ?>
        </div>
        <br><br>
    </div>
    
</body>

