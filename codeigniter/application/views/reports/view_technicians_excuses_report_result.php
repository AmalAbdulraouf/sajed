<link rel="stylesheet" type="text/css" href='<?php echo base_url();?>resources/datatables.min.css'/>
<script type="text/javascript" src='<?php echo base_url();?>resources/datatables.min.js'></script>
<script type="text/javascript">
        function get_all(id)
        {
                var xmlhttp=new XMLHttpRequest();
                xmlhttp.onreadystatechange=function()
                {
                        if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    {
                        $("#_table_div_").html(xmlhttp.responseText);
                                //$('#orders_table').empty();
                                //$('#orders_table').append(xmlhttp.responseText);
                                $('#orders_table').dataTable();
                    }
                }
                var link = "<?php echo base_url().'index.php/reports/all_order_excuses?order_id=' ?>"+id;
                xmlhttp.open("GET", link, true);
                xmlhttp.send();
        }
</script>
<h2><br><?php echo lang('search_results');?></h1>
<?php
	if($this->session->userdata('language') == 'Arabic')
	{
		$this->lang->load('website', 'arabic');
	}
	else
	{
		$this->lang->load('website', 'english');
	}
	
	echo '<div class ="table-responsive">
		<table id="orders_table" class="display" >
			<thead>
				<th>#'.lang('order_number').'</th>
				<th>'.lang('technician').'</th>
				<th>'.lang('excuse').'</th>
				<th>'.lang('date').'</th>
				<th></th>
			</thead>
			<tbody>
			';
			
			foreach ($orders as $order) 
			{
					$ID = $order->order_id;
					echo "<tr name=\"row_$ID\" id=\"row_$ID\">";
					echo '<td >'.$order->order_id.'</td>';
					echo '<td >'.$order->user_name.'</td>';
					echo '<td >'.$order->excuse.'</td>';
					echo '<td >'.$order->date.'</td>';
					$href = base_url().'index.php/reports/all_order_excuses?order_id='.$ID;
					echo "<td style='cursor:pointer' onclick='get_all(".$ID.");'>".lang('more')."</td></tr>"; 
	
									
			}
		echo '
			</tbody>
		</table></div>';
