<link rel="stylesheet" type="text/css" href='<?php echo base_url().'resources/jquery-ui.css' ?>'>
<link rel="stylesheet" type="text/css" href='<?php echo base_url().'resources/search_contacts.css' ?>'>
<script>
  $(function() {
    $( ".datepicker" ).datepicker();
  });
</script>
<script>
        $(document).ready(function(){
                $('#subBar').click(function(){
                        $('#ba').submit();
                });
        if( $('#examine_date').is(':checked')==false)
        {
                $('#delivery_date').attr('checked',true);
                $('#examine_cost').attr('disabled', true);
                $('#expected_examine_date').attr('disabled', true);
                $('#estimated_cost').attr('disabled', false);
                $('#expected_delivery_date').attr('disabled', false);
        }
        else
        {
                 $('#delivery_date').attr('checked',true);
                 $('#delivery_date').attr('checked',false); // ...meaning that we can use its value to set the 'disabled' attribute 
                 $('#estimated_cost').attr('disabled', true);
                 $('#expected_delivery_date').attr('disabled', true);
                 $('#examine_cost').attr('disabled', false);
                 $('#expected_examine_date').attr('disabled', false);
        }
	
        $('#delivery_date').click(function() {
                 $('#examine_date').attr('checked',false); // ...meaning that we can use its value to set the 'disabled' attribute 
                 $('#examine_cost').attr('disabled', true);
                 $('#expected_examine_date').attr('disabled', true);
                 $('#estimated_cost').attr('disabled', false);
                 $('#expected_delivery_date').attr('disabled', false);
        });
	
        $('#examine_date').click(function() {
                 $('#delivery_date').attr('checked',false); // ...meaning that we can use its value to set the 'disabled' attribute 
                 $('#estimated_cost').attr('disabled', true);
                 $('#expected_delivery_date').attr('disabled', true);
                 $('#examine_cost').attr('disabled', false);
                 $('#expected_examine_date').attr('disabled', false);
        });
        });
	
</script>

<script>
        $(document).ready(function() {
    $(".numeric_input").keydown(function (e) {
        var fieldLength = document.getElementById('phone').value.length;
        if(fieldLength >= 9)
        {
                var str = document.getElementById('phone').value;
                str = str.substring(0, str.length  - 1);
                document.getElementById('phone').value = str;
        }
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
        if($('#under_warranty').is(':checked'))
        {
                $('#billNumber').attr('disabled', false);
                $('#billDate').attr('disabled', false);
        }	
        else
        {
                $('#billNumber').attr('disabled', true);
                $('#billDate').attr('disabled', true);
        }
	
        $('#under_warranty').on('change', function(){
                if($(this).is(':checked'))
                {
                        $('#billNumber').attr('disabled', false);
                        $('#billDate').attr('disabled', false);
                }
                else
                {
                        $('#billNumber').attr('disabled', true);
                        $('#billDate').attr('disabled', true);
                }
        });
});

</script>

<script>
function changeFun()
{
        document.attr('checked',!document.prop('checked')); 
}


$(document).ready(function(){
	

$('#examine_date').change (function(){
                $('#delivery_date').attr('checked',!$(this).prop('checked')); 
});

$('.editForm').on('keydown', 'input', function (event) {
    if (event.which == 13) {
        event.preventDefault();
        var $this = $(event.target);
        var index = parseFloat($this.attr('data-index'));
        $('[data-index="' + (index + 1).toString() + '"]').focus();
    }
        });
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

<script>


$(document).on('change', "#brands_drop_down_list",function () {
        brand_id = $(this).val();
        update_models_by_brand(brand_id);
});

$(document).on('change', "#models",function () {
        source: "<?php echo base_url();?>"+"index.php/management/get_list_of_models_by_brand_id_model_name?brand_id="+ $("#brands_drop_down_list").val()
});

$(document).ready(function(){
        document.getElementById("models").onkeydown = function myFunction(e){
                if(e.ctrlKey){
                        return;
                }
                var characters = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
                var keyCode = (window.event) ? e.which : e.keyCode;
                if (keyCode >= 65 && keyCode <= 90){
                        this.value += characters[keyCode - 65];
                        return false;
                }
                else if ((keyCode < 8 || keyCode > 105)){
                        this.value +='';
                        return false;
                }
        };
});



$(document).ready(function(){
        document.getElementById("serial_number").onkeydown = function myFunction(e){
                if(e.ctrlKey){
                        return;
                }
                var characters = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
                var keyCode = (window.event) ? e.which : e.keyCode;
                if (keyCode >= 65 && keyCode <= 90){
                        this.value += characters[keyCode - 65];
                        return false;
                }
                else if ((keyCode < 8 || keyCode > 105)){
                        this.value +='';
                        return false;
                }
        };
});


$(function(){
        $("#models").autocomplete({
                source: "<?php echo base_url();?>"+"index.php/management/get_list_of_models_by_brand_id_model_name?brand_id="+ $("#brands_drop_down_list").val()
        });
});	

$(function(){
  $("#colors").autocomplete({
    source: "<?php echo base_url();?>"+"index.php/management/get_list_of_colors_like_name"
  });
});

</script>


<script type="text/javascript">

function checkLength()
{
    var fieldLength = document.getElementById('phone').value.length;
    //Suppose u want 4 number of character
    if(fieldLength <= 9){
        return true;
    }
    else
    {
        var str = document.getElementById('phone').value;
        str = str.substring(0, str.length - 1);
        document.getElementById('phone').value = str;
    }
}

var source_link;
function update_models_by_brand(brand_id)
{
        $("#models").val('');
        source_link = "<?php echo base_url();?>"+"index.php/management/get_list_of_models_by_brand_id_model_name?brand_id="+ $("#brands_drop_down_list").val();
        $("#models").autocomplete( "option", "source", source_link);
}




	



</script>
<body>
	<?php 
	if($this->session->userdata('language') == 'Arabic')
	{
		echo '<div style="margin-top: 10%" align="right" class="container">';
	}
	else 
	{
		echo '<div style="margin-top: 10%" align="left" class="container">';
	}?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panel=header">
                <div class= "app-title">

                    <div id="barcodeDiv" class="forFloat" >
                        <form  id="ba" method="post" action="<?php echo base_url();?>index.php/order/search_order_barcode">
                            <td><input style="width: 100%; display:inline" type="text" placeholder="Barcode" name="BarCode" id="BarCode"  onmouseover="this.focus();" />
                                <button style="display: inline" id="subBar">OK</button></td>
                        </form>
                    </div>
                    <div style="clear: both"></div>
                    <img style="max-width: 90%" src='<?php echo base_url()?>resources/images/logo2.bmp'/><br>
                </div>
            </div>
            <div class="row">

					<?php	
					$at = array('method' => 'POST', 'class'=> 'editForm', 'id' => 'editForm');
					echo form_open('order/edit_order',$at);
					
					echo "<div id='err' style='color: red'>".validation_errors()."</div>";
					echo form_hidden('order_id', $order_info['order_basic_info'][0]->id);
					?>
                <div class="add_customer_info" name="add_customer_info" id="add_customer_info">
                    <h2><?php echo lang('customer_info');?></h2>
                    <br><br>
                    <div class="form-gruop form-inline">
						<?php
							$counter=1; 
							echo form_hidden('customer_id', $order_info['order_basic_info'][0]->customer_id);?>
							<?php echo lang('full_name');?>
							<?php 
								$attr=array(
									'name'=>'first_name',
									'value'=>$order_info['order_basic_info'][0]->contact_fname,
									'class' => 'form-control input-md-3',
									'placeholder' => lang('full_name'),
									'style' => 'width: 25%',
									'data-index'=>"$counter"
								);
								$counter++;
								echo form_input($attr); ?>

							<?php echo form_hidden('last_name', $order_info['order_basic_info'][0]->contact_lname); ?>

							<?php echo lang('phone');?>

							<?php
								$attr=array(
									'name'=>'phone',
									'id' => 'phone',
									'value'=>$order_info['order_basic_info'][0]->contact_phone,
									'class' => 'form-control input-md-3 numeric_input',
									'placeholder' => lang('phone'),
									'style' => 'width: 25%',
									'data-index'=>"$counter",
									'onInput' => "checkLength()"
								);
								$counter++;
							    echo form_input($attr); ?>
                        <font color="red">966 </font>	
							   <?php echo lang('email');?>
							    <?php
								 $attr=array(
									'name'=>'email',
									'value'=>$order_info['order_basic_info'][0]->contact_email,
									'data-index'=>"$counter",
									'class' => 'form-control input-md-3',
									'placeholder' => lang('email'),
									'style' => 'width: 25%'
								);
								$counter++;
								 echo form_input($attr); ?> 
                    </div>
                    <br><br>
								 <?php echo lang('address');?>
								 <?php 
									$address_textarea = array(
					                  'name' => 'address',
					                  'rows'  => "1",
					                  'cols' => "35",
					                  'class' => 'form-control',
									  'placeholder' => lang('address'),
									  'style' => 'width: 45%; min-width: 45%; max-width: 45%',
									  'value' => $order_info['order_basic_info'][0]->contact_address,
								  	  'data-index'=>"$counter"
					                );
									$counter++;
									echo form_textarea($address_textarea) 
									?>
                </div>
                <div id="add_machine_info">
                    <div class="form-gruop form-inline">
                        <h2><?php echo lang('machine_info');?></h2>
							<?php echo form_hidden('machine_id',$order_info['order_basic_info'][0]->machines_id);?>
                        <label for="machine_type">		
									<?php
									echo lang('machine_type');
									echo form_dropdown('machine_type', $machines_types, set_value('machine_type'), 'class="form-control input-md-3"');
									?>
                        </label>
                        <label for="brands">		
									<?php
									echo lang('brands');
									echo form_dropdown('brands',  $brands, set_value('machine_type'), 'class="form-control input-md-3" id="brands_drop_down_list"');
									?>
                        </label>

							<?php echo lang('models');?>
							<?php
								$model_input_data = array(
								  'name' => 'models',
								  'id' => 'models',
								  'value' =>$order_info['order_basic_info'][0]->model_name,
								  'class' => 'form-control input-md-3',
								  'placeholder' => lang('models'),
							      'style' => 'width: 25%',
								  'data-index'=>"$counter"
								);
								 $counter++; 
								echo form_input($model_input_data);
								?>
                    </div><br>
                    <div class="form-gruop form-inline">
							<?php echo lang('serial_no');?>
							<?php 
								$serial_no_data = array(
								  'name' => 'serial_number',
								  'value' => $order_info['order_basic_info'][0]->serial_number,
								  'id' => 'serial_number',
								  'class' => 'form-control input-md-3',
								  'placeholder' => lang('serial_no'),
							      'style' => 'width: 25%',
								  'data-index'=>"$counter"
								);
								$counter++;
								echo form_input($serial_no_data); 
								?>
							    <?php echo lang('colors');?>
								<?php
									$current_color = $order_info['order_basic_info'][0]->color_name;
									if($current_color == '')
										$current_color = lang('black');
									$color_input_data = array(
									  'name' => 'colors',
									  'value' => $current_color ,
									  'id' => 'colors',
									  'data-index'=>"$counter",
									  'class' => 'form-control input-md-3',
									  'placeholder' => lang('colors'),
								      'style' => 'width: 25%',
									  'autocomplete' => 'on'
									);
									$counter++; 
									echo form_input($color_input_data);
								?>
                    </div>

                    <div style="border: none; font-size: 130%" class="form-control">
								<?php 
								 if($order_info['order_basic_info'][0]->under_warranty == 1)
								 {
								 	echo '<h4>'.lang('is_under_waranty')." : ".lang('YES').'</h4>';
								 }
								 else 
								 {
									 echo '<h4>'.lang('is_under_waranty')." : ".lang('NO').'</h4>';
								 }?>
                        <label for="under_warranty">		
									<?php
									
									$chk_box_data = array
									(
									    'name' => 'under_warranty',
									    'id' => 'under_warranty',
									    'value' => 1,
									    'style' => 'display: none',
										'checked' => $order_info['order_basic_info'][0]->under_warranty == 1
									);
									
									
									echo form_checkbox($chk_box_data);
									?>
                        </label>
                    </div>
							<?php if($order_info['order_basic_info'][0]->under_warranty == 1)
							{?>
                    <div style="border: none; font-size: 100%" class="form-control form-inline">

									<?php 
									$billDate = array
									(
										'name' => 'billDate',
										'id' => 'billDate',
										'type' =>'text',
										'class' => 'form-control input-md datepicker',
									    'placeholder' => lang('billDate'),
								        //'style' => 'width: 45%',
										'value' => $order_info['order_basic_info'][0]->billDate
									);
									echo form_input($billDate);
									?>
									<?php 
									$bill_num = array
									(
										'name' => 'billNumber',
										'id' => 'billNumber',
										'class' => 'form-control input-md numeric_input',
									    'placeholder' => lang('billNumber'),
								        //'style' => 'width: 45%',
										'value' => $order_info['order_basic_info'][0]->billNumber
									);
									echo form_input($bill_num);
									?>
                    </div>
							<?php }?>

                </div>
                <div id="accessories">
                    <h3><?php echo lang('accessories');?></h3>

                    <div class="form-gruop form-inline">
										<?php
										$attr = array(
											'name'=>'accessories',
											'value'=>$order_info['accessories']->notes,
											'class' => 'form-control input-md-3',
									        'rows'  => "1",
							                'cols' => "35",
										  'style' => 'width: 30%; min-width: 45%; max-width: 45%',
											'data-index'=>"$counter"
										);
										echo form_textarea($attr);
										
										echo "</div><br>";
										$counter++;
							
								?>
                    </div></div>
                <div id="fault">
                    <h2><?php echo lang('fault_description');?></h2>
							<?php 
									$fault_description_textarea = array(
					                  'name' => 'fault_description',
					                  'rows'  => "6",
					                  'cols' => "35",
									  'value' => $order_info['order_basic_info'][0]->fault_description,
									  'data-index'=>"$counter",
						              'class' => 'form-control',
									  'placeholder' => lang('fault_description'),
									  'style' => 'width: 45%; min-width: 45%; max-width: 45%'
					                );
									echo form_textarea($fault_description_textarea); 
									$counter++;
								?>

                    <div style="border: none; font-size: 130%" class="form-control">
								<?php echo lang('external_repair');?>
                        <label for="external_repair">		
									<?php
									
									$data = array(
									    'name'        => 'external_repair',
									    'class'        => 'external_repair',
									    'value'       => 1,
									    'checked'     => $order_info['order_basic_info'][0]->external_repair != 0
									    );
								
									echo form_checkbox($data);
									?>
                        </label>
                    </div>
                    <br>
							<?php if($order_info['current_status']->status_id == 4 || $order_info['current_status']->status_id == 5 || $order_info['current_status']->status_id == 6)
							{
								echo form_hidden('expected_delivery_date',$order_info['order_basic_info'][0]->delivery_date);
								echo form_hidden('expected_examine_date',$order_info['order_basic_info'][0]->examine_date);
								echo form_hidden('estimated_cost',$order_info['order_basic_info'][0]->estimated_cost);
								echo form_hidden('examine_cost',$order_info['order_basic_info'][0]->examine_cost);
							}
							else
								{
							?>
							<?php if ($order_info['order_basic_info'][0]->delivery_date !=0)
								  {?>
                    <div class="form-gruop form-inline">


											<?php echo lang('delivery_date');?>		

                        <label for="delivery_date" class="radio-inline">
												<?php
												
												$data = array(
												    'name' => 'delivery_date',
												    'class' => 'delivery_date',
												    'id' => 'delivery_date',
												    'value' =>1,
												    'checked' => "checked",
												    );
											
												echo form_radio($data);
												?>

                        </label>

											<?php 
												$options=array();
									
												$options[$order_info['order_basic_info'][0]->delivery_date] = $order_info['order_basic_info'][0]->delivery_date;
										
												for($i=1; $i<=100; $i++)
														$options[$i]=$i;
												?>
                        <td class='input form-control input-md-3'><?php echo lang('during')." ".form_dropdown('expected_delivery_date', $options, set_value('machine_type'), ' id="expected_delivery_date"')." ".lang('work_day'); ?></td>
													<?php echo lang('cost_estimation');?>
													<?php 
															$data=array(
																'name'=>'cost_estimation',
																'id'=>'estimated_cost',
																'class' => ' form-control input-md-3 numeric_input',
																'placeholder' => lang('cost_estimation'),
																'value' => $order_info['order_basic_info'][0]->estimated_cost,
																'style' => 'margin:14px; width:30%',
																'data-index'=>"$counter"
															);
													echo form_input($data);
													$counter++;
													 ?>
                    </div>
										<?php } else {?>

                    <div class="form-gruop form-inline">


													<?php echo lang('examine_date');?>		

                        <label for="examine_date" class="radio-inline">
														<?php
														
														$data = array(
														    'name' => 'examine_date',
														    'class' => 'examine_date',
														    'id' => 'examine_date',
														    'value' =>1,
														    'checked' => "checked",
														    );
													
														echo form_radio($data);
														?>

                        </label>


												<?php 
														$options[$order_info['order_basic_info'][0]->examine_date] = $order_info['order_basic_info'][0]->examine_date;
												
														for($i=1; $i<=100; $i++)
																$options[$i]=$i;
													?>
                        <td class='input form-control input-md'><?php echo lang('during')." ".form_dropdown('expected_examine_date', $options, set_value('machine_type'), ' id="expected_examine_date"')." ".lang('day'); ?></td>
                        <h4><?php echo lang('examining_cost');?></h4>
														<?php 
																$data=array(
																	'name'=>'examine_cost',
																	'id'=>'examine_cost',
																	'class' => ' form-control input-md-3 numeric_input',
																	'placeholder' => lang('examining_cost'),
																	'value' =>$order_info['order_basic_info'][0]->examine_cost,
																	'style' => 'margin:14px; width:30%',
																	'data-index'=>"$counter"
																);
														echo form_input($data);
														$counter++;
														 ?>
                    </div>
											<?php }
											}?>
                </div>

                <div id="Notes">
                    <h2><?php echo lang('notes'); ?></h2>
							<?php 
								$notes_textarea = array(
					                  'name' => 'notes',
					                  'rows'  => "6",
					                  'cols' => "35",
									  'value' => $order_info['order_basic_info'][0]->notes,
									  'data-index'=>"$counter",
									  'class' => 'form-control',
									  'placeholder' => lang('notes'),
									  'style' => 'width: 45%; min-width: 45%; max-width: 45%',
					                );
								echo form_textarea($notes_textarea); 
								$counter++;
								echo "<br><br>";
						
								if($order_info['current_status']->status_id == 6 && $order_info['order_basic_info'][0]->Receipt != 1)
								{
									echo lang('No Receipt')."<br>".lang('ID')." : ";
									$attr = array
									(
										'name' => 'IDnum',
										'value' => $order_info['order_basic_info'][0]->IDnum,
										'class' => 'form-control input-md numeric_input',
									);
									echo form_input($attr);
								}
						?>
                    <div style="border: none; font-size: 130%" class="form-control">
								<?php echo lang('allow_losing_data');?>
                        <label for="allow_losing_data">		
									<?php
									
									$chk_box_data = array
									(
									    'name' => 'allow_losing_data',
									    'id' => 'allow_losing_data',
									    'value' => 1,
										'checked' => $order_info['order_basic_info'][0]->allow_losing_data ==1
									);
									
									
									echo form_checkbox($chk_box_data);
									?>
                        </label>
                    </div>
								<?php if($order_info['current_status']->status_id != 5 && $order_info['current_status']->status_id!=6 && $order_info['current_status']->status_id!=4)
								{
									echo lang('assign_to');
									$opt = 'class="technician"';
									echo form_dropdown('technician', $technicians, set_value('machine_type'), 'style="width: auto" class="form-control input-md"');
									
								}
								else
								{?>
                    <tr style="display: none">
                        <td><?php echo lang('assign_to');?>: </td>
                        <td>
										<?php
										$opt = 'class="technician"';
										echo form_dropdown('technician', $technicians);
										?>
                        </td>
                    </tr>
							<?php }?>
                </div>
						<?php
						$input_data = array
						(
						    'name' => 'customer_id',
						    'id' => 'customer_id',
						    'value' => $order_info['order_basic_info'][0]->customer_id,
						    'type' => "hidden"
						);
						echo form_input($input_data, set_value('customer_id'));
						?>
                <div class="row">
                    <div class="col">
                        <h3>
									<?php 
									$sub=array(
										'name'=>'submit changes',
										'value'=>lang('submit'),
										'class'=>'submit_btn'
										);
									echo form_submit($sub); ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>