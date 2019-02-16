<html>
    <head>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <title>حاسبات الخليج</title>
        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/jquery-ui.css' ?>'>
        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/css/bootstrap.min.css' ?>'>
        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/styles.css' ?>'>
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
        <script>
            $(document).ready(function() {
                $('.loader').hide();
                $('#Password').attr("autocomplete", "off");
                setTimeout('$("#Password").val("");', 100);
                setTimeout('$("#Password").attr("value","");', 100);
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
    </head>
    <body>
        <div class="container" >
            <div align="center"  class="login-screen">
                <div class="login-area">
                    <div id="forHide" class="form-holder">
                        <div class="">
                            <div class= "app-title">
                                <img width="300" height="100" src='<?php echo base_url() ?>resources/images/logo2.png'/><br>
                            </div>
                        </div>
                        <?php
                        $attributes = array('class' => 'login-form', 'align' => 'center');
                        echo form_open('main/login_validation', $attributes);
                        echo "<error>";
                        echo validation_errors();
                        echo "</error>";
                        ?>
                        <br>
                        <div align="center" class="col">
                            <?php
                            $attr = array(
                                'name' => 'user_name',
                                'id' => 'user_name',
                                'class' => 'form-control input-md',
                                'placeholder' => lang('user_name'),
                                'style' => 'border-bottom: 1px solid #ddd;'
                            );
                            echo form_input($attr);
                            ?>
                            <br>
                            <?php
                            $attr = array(
                                'name' => 'password',
                                'id' => 'Password',
                                'class' => 'form-control input-md',
                                'placeholder' => lang('password')
                            );
                            echo form_password($attr);
                            ?>
                            <br>
                            <?php echo form_submit('login_submit', lang('signin'), "class='submit_btn'"); ?>
                        </div>
                    </div>
                </div>                                   
            </div>	
        </div>
    </body>
</html>