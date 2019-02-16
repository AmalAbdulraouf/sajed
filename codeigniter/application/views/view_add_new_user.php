<!DOCTYPE html>
<?php

if($this->session->userdata('language') == 'Arabic')
{
	$this->lang->load('website', 'arabic');
}
else
{
	$this->lang->load('website', 'english');
}

if(empty($user_info))
{		
	echo '<h1>'.lang('create_a_new_user').'</h1>';
	echo form_open('users_manager/save_new_user');
	
	echo "<error>";
	echo validation_errors();
	echo "</error>";
	
	echo "<table>";
	
	echo '<tr><td colspan="2"><h3>'.lang('account_info').'</h3></td></tr>';
	
	echo "<tr><td class='label'>".lang('user_name').":</td><td>";
	echo form_input('user_name');
	echo "</td></tr>";
	
	echo "<tr><td class='label'>".lang('password').":</td><td>";
	echo form_password('password');
	echo "</td></tr>";
	
	echo "<tr><td class='label'>".lang('confirm_password').":</td><td class='input'>";
	echo form_password('passwordConfirmation');
	echo "</td></tr>";
	
	echo '<tr><td colspan="2"><h3>'.lang('personal_info').'</h3></td></tr>';
	
	echo "<tr><td class='label'>".lang('first_name').":</td><td class='input'>";
	echo form_input('first_name');
	echo "</td></tr>";
	
	echo "<tr><td class='label'>".lang('last_name').":</td><td class='input'>";
	echo form_input('last_name');
	echo "</td></tr>";
	
	echo "<tr><td class='label'>".lang('phone').":</td><td class='input'>";
	echo form_input('phone');
	echo "</td></tr>";
	
	echo "<tr><td class='label'>".lang('email').":</td><td class='input'>";
	echo form_input('email');
	echo "</td></tr>";
	
	echo "<tr><td class='label'>".lang('address').":</td><td class='input'>";
	$address_textarea = array(
		                  'name' => 'address',
		                  'rows'  => "6",
		                  'cols' => "23"
		                );
	echo form_textarea($address_textarea);
        echo "<tr><td colspan='2'><input type='checkbox' name='warranty_follower' ".$checked.">" . lang('warranty_follower') . "</input></td></tr>";

	echo "</td></tr>";
	
	echo '<tr><td colspan=2><h3>'.lang('groups').'</h3></td></tr>';
	
	echo '<br>';
	
	foreach($list_groups as $group)
	{
		$chk_box_data = array
		(
		    'name' => 'user_groups[]',
		    'id' => $group->name,
		    'value' => $group->id
		);
		
		echo '<tr><td colspan=2>';
		echo form_checkbox($chk_box_data);
		echo "<label for=\"$group->name\">$group->name</label>";
		echo '</td></tr>';
	}
	echo "</table>";
	
	echo "<h3>";
	echo form_submit('submit changes', lang('submit'), 'class="submit_btn"');
	echo "</h3>";
	
}

else
{
	echo '<h1>Create a New User</h1>';
	echo form_open('users_manager/save_new_user');
	
	echo "<error>";
	echo validation_errors();
	echo "</error>";
	
	echo "<table>";
	echo "<tr><td class='label'>".lang('user_name').":</td><td>";
	echo form_input('user_name', $user_info['user_name']);
	echo "</td></tr>";
	
	echo "<tr><td class='label'>".lang('password').":</td><td>";
	echo form_password('password');
	echo "</td>";
	
	echo "<td class='label'>".lang('confirm_password').":</td><td class='input'>";
	echo form_password('passwordConfirmation');
	echo "</td></tr>";
	
	echo "<tr><td class='label'>".lang('first_name').":</td><td class='input'>";
	echo form_input('first_name', $user_info['first_name']);
	echo "</td>";
	
	echo "<td class='label'>".lang('last_name').":</td><td class='input'>";
	echo form_input('last_name', $user_info['last_name']);
	echo "</td></tr>";
	
	echo "<tr><td class='label'>".lang('phone').":</td><td class='input'>";
	echo form_input('phone', $user_info['phone']);
	echo "</td></tr>";
	
	echo "<tr><td class='label'>".lang('email').":</td><td class='input'>";
	echo form_input('email', $user_info['email']);
	echo "</td></tr>";
	
	echo "<tr><td class='label'>".lang('address').":</td><td class='input'>";
	$address_textarea = array(
		                  'name' => 'address',
		                  'rows'  => "6",
		                  'cols' => "23",
						  'value' => $user_info->address
		                );
	echo form_textarea($address_textarea);
	echo "</td></tr>";
	
	echo '<tr><td colspan=2><h3>'.lang('groups').'</h3></td></tr>';
	
	//echo '<br>';
	//print_r($user_groups);
	//echo '<br>';
	//print_r($list_groups);

	foreach($list_groups as $group)
	{			
		echo '<tr><td colspan=2>';
		
		if(is_user_in_group($group->id, $user_groups))
		{
			$chk_box_data = array(
			    'name' => 'user_groups[]',
			    'id' => $group->name,
			    'value' => $group->id,
			    'content' => $group->name,
			    'checked' => "checked"
			);
			echo form_checkbox($chk_box_data);
			//echo form_checkbox(trim($group->name, " "), trim($group->name, " "), TRUE);
		}
		else
		{
			$chk_box_data = 
			array(
			    'name' => 'user_groups[]',
			    'id' => $group->name,
			    'value' => $group->id,
			    'content' => $group->name
			);
			echo form_checkbox($chk_box_data);
			//echo form_checkbox(trim($group->name, " "), trim($group->name, " "), FALSE);
		}
		echo "<label for=\"$group->name\">$group->name</label>";
		echo '</tr></td>';
	}
	echo "<tr><td colspan=2><h3>";
	echo form_submit('submit changes', 'Submit');
	echo "</h3></td></tr>";
	echo "</table>";
}

function is_user_in_group($group_id, $user_groups)
{
	foreach($user_groups as $usr_group)
	{
		if($usr_group == $group_id)
		{
			return true;
		}
	}
	return false;
}

?>
</script>