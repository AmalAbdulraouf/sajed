<!DOCTYPE html>
<html lang="en" style="height: 100%;">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/styles.css' ?>'>
        <link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/style-en.css' ?>'>
        <title>Access Denied</title>
    </head>
    <body style="height: 100%;">
        <div class="container">
            <div class="row">
                <div class="panel panel-default ">
                    <div align="center" class="panel-body">
                        <div class="main_screen">
                            <div class="app-title">حاسبات الخليج</div>

                            <p>

                                <img style="border:0;" src= '<?php echo base_url() ?>/resources/images/padlock-3-256.png'/>

                                <br>


                                You have no permission to access this page

                            </p>

                            <br>
                            <br>

                            <button class="submit_btn" onclick="location.href = '<?php echo base_url() . 'index.php' ?>'">Go To Log In Page</button>
                        </div>
                    </div>
                </div>	
            </div>
        </div>
    </body>
</html>