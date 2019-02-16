
<link rel="stylesheet" type="text/css" href='<?php echo base_url();?>resources/datatables.min.css'/>
<script type="text/javascript" src='<?php echo base_url();?>resources/datatables.min.js'></script>
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
			
			echo '<div class ="table-responsive">
				<table id="orders_table" class="display" >
					<thead>
						<th>#'.lang('order_number').'</th>
						<th>'.lang('technician').'</th>
						<th>'.lang('excuse').'</th>
						<th>'.lang('date').'</th>
					</thead>
					<tbody>
					';
					
					foreach ($orders_result as $order) 
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
				</table></div>';?>
			
