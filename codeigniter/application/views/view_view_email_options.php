<script>
    $(document).ready(function() {
        $(".change_language").click(function() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
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
    });
</script>


<title>حاسبات الخليج</title>
<body>
    <div class="container" style="margin-top: 2%">
        <div align="center" class="panel panel-default">
            <div align="center" class="panel-body">
                <div class="panel-header">
                    <?php $this->load->view('app_title') ?>
                </div>
                <div style="text-align:center">
                    <img src='<?php echo base_url() ?>resources/images/logo2.jpg'/>
                </div>
                <div class="col-md-4">
                    <?php
                    echo '<button class="report_menu_item" type="button" 
							onClick="location.href=\'' . base_url() . 'index.php/options/get_sms/send_email_on_receive\'">' . lang('send_email_on_receive') . '</button><br>';
                    //echo "<a class='sms_a' href='".base_url()."index.php/options/get_sms/send_sms_on_receive'>".lang('send_sms_on_receive')."</label><br><br>";
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                    echo '<button class="report_menu_item" type="button" 
							onClick="location.href=\'' . base_url() . 'index.php/options/get_sms/send_email_on_done\'">' . lang('send_email_on_done') . '</button><br>';
                    //echo "<a class='sms_a' href='".base_url()."index.php/options/get_sms/send_sms_on_done'>".lang('send_sms_on_done')."</label><br><br>";
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                    echo '<button class="report_menu_item" type="button" 
							onClick="location.href=\'' . base_url() . 'index.php/options/get_sms/send_email_on_deliver\'">' . lang('send_email_on_deliver') . '</button><br>';
                    //echo "<a class='sms_a' href='".base_url()."index.php/options/get_sms/send_sms_on_deliver'>".lang('send_sms_on_deliver')."</label><br><br>";
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                    echo '<button class="report_menu_item" type="button" 
							onClick="location.href=\'' . base_url() . 'index.php/options/get_sms/send_email_on_cancelled\'">' . lang('send_email_on_cancelled') . '</button><br>';
                    //echo "<a class='sms_a' href='".base_url()."index.php/options/get_sms/send_sms_on_cancelled'>".lang('send_sms_on_cancelled')."</label><br><br>";
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

<?php

function get_option_value($opt_name, $options) {
    foreach ($options as $opt) {
        if ($opt->option_name == $opt_name) {
            return $opt->option_value;
        }
    }
}

function get_option_text($opt_name, $options, $lang) {
    foreach ($options as $opt) {
        if ($opt->option_name == $opt_name && $opt->option_lang == $lang) {
            return $opt->option_text;
        }
    }
}
?>