	
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
	
	echo '
		<table id="orders_table" class="display" >
			<thead>
				<th>#'.lang('order_number').'</th>
				<th>'.lang('technician').'</th>
				<th>'.lang('excuse').'</th>
				<th>'.lang('date').'</th>
			</thead>
			<tbody>
			';
			
			foreach ($excuses as $order) 
			{
					$ID = $order->order_id;
					echo "<tr name=\"row_$ID\" id=\"row_$ID\">";
					echo '<td >'.$order->order_id.'</td>';
					echo '<td >'.$order->user_name.'</td>';
					echo '<td >'.$order->excuse.'</td>';
					echo '<td >'.$order->date.'</td>';
	
									
			}
		echo '
			</tbody>
		</table>';
