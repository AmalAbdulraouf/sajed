<html>
    <head>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <title>حاسبات الخليج</title>


        <link rel="stylesheet" type="text/css" href='<?php echo base_url().'resources/jquery-ui.css' ?>'>
        <link rel="stylesheet" type="text/css" href='<?php echo base_url().'resources/css/bootstrap.min.css' ?>'>

		<?php
			if($this->session->userdata('language') == 'Arabic')
			{
				$this->lang->load('website', 'arabic');
				echo '<link rel="stylesheet" type="text/css" href="'.base_url().'resources/style-ar.css">';
				echo '<link rel="stylesheet" type="text/css" href="'.base_url().'resources/search_contacts-ar.css">';
			}
			else
			{
				$this->lang->load('website', 'english');
				echo '<link rel="stylesheet" type="text/css" href="'.base_url().'resources/style-en.css">';
				echo '<link rel="stylesheet" type="text/css" href="'.base_url().'resources/search_contacts-en.css">';
			}
		?>


        <script src='<?php echo base_url().'resources/jquery-1.11.1.min.js' ?>'></script>
        <script src='<?php echo base_url().'resources/jquery-1.10.2.min.js' ?>'></script>

        <script>
		
		
		
                $(document).ready(function(){
				
                        $('.loader').hide();
	
                        //$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';
                        $('#Password').attr("autocomplete", "off");
                        setTimeout('$("#Password").val("");', 2000);
                  $(".change_language").click(function () {
                                var xmlhttp=new XMLHttpRequest();
                                xmlhttp.onreadystatechange=function()
                                {
                                        if (xmlhttp.readyState==4 && xmlhttp.status==200)
                                        {			
                                                location.reload(true);
                                        }
                                }
					
                                var link = "<?php echo base_url();?>"+"index.php/language/change_language?language="+ $(this).attr('id'); 
                                xmlhttp.open("GET", link, true);
                                xmlhttp.send();
                  });
			  
			 
                });
        </script>

        <title>حاسبات الخليج</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div align="center" class="login-screen">

                    <div class="page-header">
                        <div class= "app-title">

                            <img src='<?php echo base_url()?>resources/images/logo2.bmp'/><br>
                        </div>
                    </div>
                    <div id="forHide" class="row">

								<?php
								
								$attributes = array('class' => 'login-form', 'align' => 'center');
								echo form_open('main/login_validation', $attributes);
								echo "<error>";
								echo validation_errors();
								echo "</error>";
								?>

                        <div class="app-title">
                            <img class='change_language' id='Arabic' src='<?php echo base_url()?>resources/images/arabic.png'/>
                            <img class='change_language' id='English' src='<?php echo base_url()?>resources/images/english.png'/>
                        </div>
                        <div align="center" class="col">
									<?php 
										$attr = array(
											'name' => 'user_name',
											'id' => 'user_name',
											'class' => 'form-control input-md',
											'placeholder' => lang('user_name')
										);
									   echo form_input($attr); ?>
                            <br>
									<?php 
										$attr = array(
											'name' => 'password',
											'id' => 'Password',
											'class' => 'form-control input-md',
											'placeholder' => lang('password'),
											'style' => 'margin-top: 8px'
										);
										echo form_password($attr); ?>

                            <br>
								<?php echo form_submit('login_submit', lang('signin'), "class='submit_btn'"); ?>
                        </div>
                    </div>
                </div>	
            </div>
        </div>
    </body>
</html>