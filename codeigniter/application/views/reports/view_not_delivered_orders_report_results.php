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
		echo'<div class ="table-responsive"><table id = "orders_table" class= "display">';
		echo'
		<thead>
			<th>'.lang('order_number').'</th>
			<th>'.lang('fault_description').'</th>
			<th>'.lang('ready since').'</th>
			<th>'.lang('details').'</th>
		</thead>
		<tbody>
		';
	
	
		foreach($report_results as $row)
		{
			echo '<tr>';
				echo "<td>$row->id</td>";
				echo "<td>$row->fault_description</td>";
				echo "<td>".$row->date."</td>";
				$href = base_url().'index.php/order/view_order?order_id='.$row->id;
				echo "<td><a href=\"$href\">Details</a></td></tr>";
			echo '</tr>';
		}
		echo'</tbody></table></div >';
	}
	else
	{
		echo '<error>No Data Is Returned !</error>';
	}				
?>