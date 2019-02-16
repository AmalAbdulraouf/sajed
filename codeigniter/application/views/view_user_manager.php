<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>حاسبات الخليج</title>

        <?php
        if ($this->session->userdata('language') == 'Arabic') {
            $this->lang->load('website', 'arabic');
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/style-ar.css">';
        } else {
            $this->lang->load('website', 'english');
            echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/style-en.css">';
        }
        ?>
        <script src='<?php echo base_url() . 'resources/jquery.min.js' ?>'></script>
        <script src='<?php echo base_url() . 'resources/jquery-ui.js' ?>'></script>

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


        <script>

            $(document).ready(function() {
                $(".user_name").click(function() {
                    $(".user_name").css("color", "black");


                    $(this).css("color", "#2980B9");

                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function()
                    {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                        {
                            $("#edituserframe").html(xmlhttp.responseText);
                        }
                    }
                    var link;
                    if ($(this).text() != "+")
                    {
                        link = "<?php echo base_url() . 'index.php/users_manager/load_edit_user?user_name=' ?>" + $(this).text();
                    }
                    else
                    {
                        link = "<?php echo base_url() . 'index.php/users_manager/load_edit_user' ?>";
                    }
                    xmlhttp.open("GET", link, true);
                    xmlhttp.send();

                });
            });

        </script>

    </head>

    <body id="user_mng">

        <div style="margin-top: 2%" class="container">
            <div  align="center" class="panel panel-default ">
                <div class="panel-heading"><h4><?php echo lang('users_management')?></h4></div>
                <div align="center" class="panel-body">
                    
                    <div class="row">
                        <div class = "main_screen">					
                            <?php
                            if ($message != "Changes Successfully Performed") {
                                echo "<div class= 'message'><error>$message</error></div>";
                            } else {
                                echo "<div class= 'message'><div class='validated'>$message</div></div>";
                            }
                            $message = "";
                            ?>
                        </div>
                        <div id="rightcolumn" class="rightcolumn">
                            <div id='forFloat'>
                                <?php
                                echo '<div class="user_name"><br>+<br></div>';
                                foreach ($users_list as $usr) {
                                    if ($usr->user_name == $this->session->userdata('user_name'))
                                        echo '<div class="user_name"><br>' . $usr->user_name . '<br></div>';
                                    else {
                                        echo '<div class="user_name"><br>' . $usr->user_name . '<br></div>';
                                    }
                                }
                                ?>
                            </div>	
                            <div class="edituserframe" id = "edituserframe" name = "edituserframe" src='<?php echo base_url() . 'index.php/users_manager/load_edit_user' ?>' width = "100%" height = "100%"/>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>



