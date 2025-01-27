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
			<th>'.lang('user_name').'</th>
			<th>'.lang('done_orders').'</th>
			<th>'.lang('cancelled_orders').'</th>
			<th>'.lang('repair_actions').'</th>
			<th>'.lang('repair_cost').'</th>
			<th>'.lang('spare_parts_cost').'</th>
			<th>'.lang('examining_cost').'</th>
			<th>'.lang('money').'</th>
			<th>'.lang('final_repair').'</th>
			<th>'.lang('final_spare').'</th>
			<th>'.lang('final_cash').'</th>
			<th>'.lang('average').'</th>
		</thead>
		<tbody>
		';
	
		$user = $report_results[0]->user_name;
		$id = $report_results[0]->users_id;
		$done = 0;
		$cancelled = 0;
		$actions = 0;
		$repair = 0;
		$spare = 0;
		$examine = 0;
		$cash = 0;
		
		foreach($report_results as $row)
		{
			if($row->user_name == $user)
			{
				$repair = $repair + $row->repair_cost;
				$spare = $spare + $row->spare_cost;
				$examine = $examine + $row->examine_cost;
				$cash = $cash + $row->cash;
				if($row->status_id == 2)
					$actions = $row->Count;
				else if ($row->status_id == 4)
					$cancelled = $row->Count;
				else if ($row->status_id == 5)
					$done = $row->Count;
			}
			else 
			{
				echo '<tr>';
					echo "<td>$user</td>";
					echo "<td>$done</td>";
					echo "<td>$cancelled</td>";
					echo "<td>$actions</td>";
					echo "<td>$repair</td>";
					echo "<td>$spare</td>";
					echo "<td>$examine</td>";
					echo "<td>$cash</td>";
					$final = get_user_final($id, $final_result);
					echo "<td>".$final->repair_cost."</td>";
					echo "<td>".$final->spare_cost."</td>";
					echo "<td>".$final->cash."</td>";
					$av = get_user_average($id, $average);
					$hours = round($av/60, 2);
					$mins = strstr ( $hours, '.' );
					$mins = substr($mins, 1);			
					$hours =  before('.',$hours);
					//$av = round($av/60, 2);
					if($hours == 0)
					{
						if($mins == '')
							echo "<td>0 ".lang('min')."</td>";
						else {
							echo "<td>".$mins." ".lang('min')."</td>";
						}
						
					}
					else {
						
						echo "<td>$mins : $hours </td>";
					}
					
				echo '</tr>';
				$user = $row->user_name;
				$id = $row->users_id;
				if($row->status_id == 2)
				{
					$actions = $row->Count;
					$cancelled = 0;
					$done = 0;
				}
				else if ($row->status_id == 4)
				{
					$cancelled = $row->Count;
					$done = 0;
					$actions = 0;
				}
				else if ($row->status_id == 5)
				{
					$done = $row->Count;
					$cancelled = 0;
					$actions = 0;
				}
				$repair = $row->repair_cost;
				$spare = $row->spare_cost;
				$examine = $row->examine_cost;
				$cash = $row->cash;
			}
			
		}
		echo '<tr>';
			echo "<td>$user</td>";
			echo "<td>$done</td>";
			echo "<td>$cancelled</td>";
			echo "<td>$actions</td>";
			echo "<td>$repair</td>";
			echo "<td>$spare</td>";
			echo "<td>$examine</td>";
			echo "<td>$cash</td>";
			$final = get_user_final($id, $final_result);
			echo "<td>".$final->repair_cost."</td>";
			echo "<td>".$final->spare_cost."</td>";
			echo "<td>".$final->cash."</td>";
			$av = get_user_average($id, $average);
			$hours = round($av/60, 2);
			$mins = strstr ( $hours, '.' );
			$mins = substr($mins, 1);
			$hours =  before('.',$hours);
			if($hours == 0)
			{
				echo "<td>".$mins." ".lang('min')."</td>";
			}
			else {
				echo "<td>$mins : $hours </td>";
			}
					
		echo '</tr>';
		echo'</tbody></table></div >';
	}
	else
	{
		echo '<error>No Data Is Returned !</error>';
	}				
?>

<?php 
function get_user_average($user, $average)
{
	foreach ($average as $ave) 
	{
            if($ave->technician == $user)
                return $ave->average_time;
	}
}
function get_user_final($user, $final)
{
	foreach ($final as $fin) 
	{
            if($fin->users_id == $user)
                return $fin;
	}
}
 function before ($this, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $this));
    };
	?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  