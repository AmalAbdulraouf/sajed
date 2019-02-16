<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <?php
        if ($this->session->userdata('language') == 'Arabic') {
            $this->lang->load('website', 'arabic');
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/style-ar.css">';
        } else {
            $this->lang->load('website', 'english');
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/style-en.css">';
        }
        ?>

        <script src='<?php echo base_url() . 'resources/jquery-1.10.2.min.js' ?>'></script>
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
    </head>
    <body>
        <div class="container" style="margin-top: 2%">
            <div align="center" class="panel panel-default small-container">
                <div align="center" class="panel-body">
                    <div class="panel-header">
                        <?php $this->load->view('app_title') ?>
                    </div>
                    <div style="text-align:center">
                        <img src='<?php echo base_url() ?>resources/images/logo2.jpg'/>
                    </div>
                    <div class="">
                        <?php
                        $opt_value = get_option_value($option, $options);
                        echo form_open('options/update_email_option/' . $option);
                        $chk_box_data = array
                            (
                            'name' => $option,
                            'id' => $option,
                            'value' => 1,
                            'checked' => $opt_value == '1',
                        );
                        echo form_checkbox($chk_box_data);
                        echo "<label for=\"$option\">" . lang($option) . "</label> <br><br><br>";
                        echo "<label class='forFloat' for=\"ar_text\">" . lang('arabic_text') . ":</label> <br><br><br>";
                        $text1 = array(
                            'name' => "ar_text",
                            'value' => get_option_text($option, $options, "ar"),
                            'class' => 'forFloat',
                            'rows' => '3'
                        );
                        echo form_textarea($text1);
                        echo "<div style='clear: both'></div>";

                        echo "<br><br><label class='forFloat' for=\"en_text\">" . lang('english_text') . ":</label> <br><br><br>";
                        $text1 = array(
                            'name' => "en_text",
                            'value' => get_option_text($option, $options, "en"),
                            'class' => 'forFloat',
                            'rows' => '3'
                        );
                        echo form_textarea($text1) . "<br><br>";
                        echo "<div style='clear: both'></div>";


                        echo "<br><br><label class='forFloat' >" . lang('additions') . ":</label> <br><br><br>";
                        foreach ($additions as $add) {
                            $attr = array
                                (
                                'name' => $add->name,
                                'value' => 1,
                                'class' => 'forFloat',
                                'checked' => $add->value == 1
                            );
                            echo form_checkbox($attr);
                            echo "<label for='" . lang($add->name) . "' class='forFloat' >" . lang($add->name) . "</label><br><br>";
                        }
                        ?>
                        <h3>
                            <?php echo form_submit('submit changes', lang('submit'), "class='submit_btn'"); ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>

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

function get_option_addition_value($opt_name, $add_name, $additions) {
    if ($opt_name == 'send_sms_on_receive') {
        foreach ($additions as $add) {
            if ($add == $add_name)
                return $add->send_sms_on_receive;
        }
    }
    else if ($opt_name == 'send_sms_on_done') {
        foreach ($additions as $add) {
            if ($add == $add_name)
                return $add->send_sms_on_done;
        }
    }
    else if ($opt_name == 'send_sms_on_deliver') {
        foreach ($additions as $add) {
            if ($add == $add_name)
                return $add->send_sms_on_deliver;
        }
    }
}
?>