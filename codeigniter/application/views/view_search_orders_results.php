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
	<table id="orders_table" class="display">
	<thead>
		<th>'.lang('order_number').'</th>
		<th>'.lang('customer').'</th>
		<th>'.lang('machine_brand').'</th>
		<th>'.lang('machine_model').'</th>
		<th>'.lang('fault_description').'</th>
		<th>'.lang('details').'</th>
	</thead>
	<tbody>';
	foreach ($orders as $order) 
	{
		echo "<tr name=\"row_$order->id\" id=\"row_$order->id\" value=\"$order->id\">";
		echo '<td>'.$order->id.'</td>';
		echo '<td>'."$order->first_name $order->last_name".'</td>';
		echo '<td>'.$order->name.'</td>';
		echo '<td>'.$order->model.'</td>';
		echo '<td>'.$order->fault_description.'</td>';
		$href = base_url().'index.php/order/view_order?order_id='.$order->id;
		echo "<td><a href=\"$href\">Details</a></td></tr>";
	}
	echo '</tbody></table></div>';
?>