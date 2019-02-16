
<?php
	if($this->session->userdata('language') == 'Arabic')
	{
		$this->lang->load('website', 'arabic');
	}
	else
	{
		$this->lang->load('website', 'english');
	}
	
	if(count($report_results) > 0)
	{
		echo'<div class ="table-responsive"><table id="orders_table" class="display">';
		echo'
		<thead>
			<th>'.lang('machine_type').'</th>
			<th>'.lang('orders_received_count').'</th>
			<th>'.lang('orders_delivered_count').'</th>
			<th>'.lang('orders_done_count').'</th>
			<th>'.lang('orders_cancelled_count').'</th>
		</thead><tbody>
		';
	
	
		foreach($report_results as $row)
		{
			echo '<tr>';
				echo "<td>$row->machine_type</td>";
				echo "<td>$row->recieved_count</td>";
				echo "<td>$row->delivered_count</td>";
				echo "<td>$row->repaired_count</td>";
				echo "<td>$row->cancelled_count</td>";
			echo '</tr>';
		}
		echo'</tbody></table></div >';
	}
	else
	{
		echo '<error>No Data Is Returned !</error>';
	}				
?>