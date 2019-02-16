<?php

if($this->session->userdata('language') == 'Arabic')
{
	$this->lang->load('website', 'arabic');
}
else
{
	$this->lang->load('website', 'english');
}

?>

<div class ="table-responsive">
    <table id="results_2" class="display">
        <thead>
        <th></th>
        <th></th>
        </thead>
        <tbody>
            <tr>
                <td style="width:50%"><?php echo lang('new_orders_received')?></td>
                <td><?php echo $received_count;?></td>
            </tr>

            <tr>
                <td><?php echo lang('orders_delivered_to_customer')?></td>
                <td><?php echo $delivered_count;?></td>
            </tr>

            <tr>
                <td><?php echo lang('orders_repaired')?></td>
                <td><?php echo $repaired_count;?></td>
            </tr>

            <tr>
                <td><?php echo lang('orders_cancelled')?></td>
                <td><?php echo $cancelled_count;?></td>
            </tr>
        </tbody>
    </table>
</div >
<h3><br><?php echo lang('cash_per_employee')?><br></h3>
<div>
    <div class ="table-responsive">
        <table id="results_1" class="display">
            <thead>
            <th><?php echo lang('user_name')?></th>
            <th><?php echo lang('orders_count')?></th>
            <th><?php echo lang('repair_cost')?></th>
            <th><?php echo lang('spare_parts_cost')?></th>
            <th><?php echo lang('examining_cost')?></th>
            <th><?php echo lang('money')?></th>
            </thead> 
            <tbody>
	<?php
	foreach ($cash_details as $cd) {
		$u = $cd->user_name;
		echo '<tr>';
			echo "<td>$cd->user_name</td>";
			echo "<td>$cd->orders_count</td>";
			echo "<td>$cd->repair_cost</td>";
			echo "<td>$cd->spare_cost</td>";
			echo "<td>$cd->examine_cost</td>";
			echo "<td>$cd->cash</td>";

		echo '</tr>';
	}

	?>
            </tbody>
        </table>
    </div>
</div>
<h3><br><?php echo lang('total')?></br></h3>
<div>
    <div class ="table-responsive">
        <table id="results_3" class="display">
            <thead>
            <th></th>
            <th></th>
            </thead>
            <tbody>

                <tr>
                    <td><?php echo lang('total_count')?>:</td> 
                    <td><?php echo $total_cash->orders_count?></td>

                </tr>

                <tr>
                    <td><?php echo lang('total_cash')?>:</td> 
                    <td><?php echo $total_cash->cash?></td>
                </tr>
                <tr>
                    <td><?php echo lang('total_examining_cost')?>:</td> 
                    <td><?php echo $total_cash->examine_cost?></td>
                </tr>
                <tr>
                    <td><?php echo lang('total_repair_cost')?>:</td> 
                    <td><?php echo $total_cash->repair_cost?></td>
                </tr>
                <tr>
                    <td><?php echo lang('total_spare_cost')?>:</td> 
                    <td><?php echo $total_cash->spare_cost?></td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<?php 
function get_user_average($user, $average)
{
	foreach ($average as $ave) 
	{
		if($ave->technician == $user)
			return $ave->average_time;
	}
}
?>
