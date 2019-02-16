<!DOCTYPE html>
<script type="text/javascript">
    function checkLength()
    {
        var fieldLength = document.getElementById('phone').value.length;
        //Suppose u want 4 number of character
        if (fieldLength <= 9) {
            return true;
        }
        else
        {
            var str = document.getElementById('phone').value;
            str = str.substring(0, str.length - 1);
            document.getElementById('phone').value = str;
        }
    }
</script>

<script>
    $(document).ready(function()
    {
        $('#presence').click(function() {
            var b_url = "<?php echo base_url(); ?>";
            var i = <?php echo $user_info->id; ?>;

            $.ajax({
                url: b_url + "index.php/users_manager/Absence/" + i + "/0",
                error: function() {
                },
                success: function() {
                    $('#presence').hide();
                    $('#absence').show();
                }

            });
        });
    }
    );

</script>
<?php
if ($this->session->userdata('language') == 'Arabic') {
    $this->lang->load('website', 'arabic');
    echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/style-ar.css">';
} else {
    $this->lang->load('website', 'english');
    echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'resources/style-en.css">';
}

echo '<h1>';
echo $user_info->user_name;
if (is_user_in_group(3, $user_groups)) {
    if ($user_info->Absent == 0)
        echo "<button class='btn-style' style='margin: 15px' id='absence'><a class='sms_a' href='" . site_url() . "/order/transfer_to_another_tech/abs/" . $user_info->id . "' >" . lang('absence') . "</a></button>";
    else if ($user_info->Absent == 1)
        echo "<button class='btn-style' style='margin: 15px' id='presence'><a class='sms_a' id='presence'>" . lang('presence') . "</a></button>";
}
if ($user_info->user_name != $this->session->userdata('user_name')) {

    echo "<button class='btn-style'style='font-size: 16px;' id='Deletion' class='sms_a' >" . lang('delete') . " </button>";
    $t = is_user_in_group(3, $user_groups);
    if ($t == true) {
        $t = "yes";
    } else {
        $t = "no";
    }
}
echo '</h1>';
echo form_open('users_manager/submit_user_changes');
echo "<error>";
echo validation_errors();
echo "</error>";

$data = array(
    'name' => 'user_name',
    'value' => $user_info->user_name,
    'style' => "visibility:hidden; height:0px");
echo form_input($data);

echo "<table class='forMargin'>";
echo "<tr><td colspan='2'><input type='checkbox' onclick='handleClick(this);'>" . lang('change_password') . "</input></td></tr>";

echo "<tr class='password_row' id='password_row' style='display: none;'><td class='label'>" . lang('password') . ":</td><td>";
echo form_password('password');
echo "</td></tr>";

echo "<tr class='password_row' id='confirm_password_row' style='display: none;'><td class='label'>" . lang('confirm_password') . ":</td><td class='input'>";
echo form_password('passwordConfirmation');
echo "</td></tr>";

echo "<tr><td class='label'>" . lang('first_name') . ":</td><td class='input'>";
echo form_input('first_name', $user_info->first_name);
echo "</td></tr>";

echo "<tr><td class='label'>" . lang('last_name') . ":</td><td class='input'>";
echo form_input('last_name', $user_info->last_name);
echo "</td></tr>";

echo "<tr><td class='label'>" . lang('phone') . ":</td><td class='input'>";
$attr = array(
    'name' => ' phone',
    'id' => 'phone',
    'value' => $user_info->phone,
    'onInput' => "checkLength()"
);
echo form_input($attr);
echo "</td></tr>";

echo "<tr><td class='label'>" . lang('email') . ":</td><td class='input'>";
echo form_input('email', $user_info->email);
echo "</td></tr>";

echo "<tr><td class='label'>" . lang('address') . ":</td><td class='input'>";
$address_textarea = array(
    'name' => 'address',
    'rows' => "6",
    'cols' => "23",
    'value' => $user_info->address
);
echo form_textarea($address_textarea);
echo "</td></tr>";
$checked = $user_info->warranty_follower == 1?" checked":"";
echo "<tr><td colspan='2'><input type='checkbox' name='warranty_follower' ".$checked.">" . lang('warranty_follower') . "</input></td></tr>";

echo '<tr><td colspan=2><h3>' . lang('groups') . '</h3></td></tr>';
foreach ($list_groups as $group) {
    echo '<tr><td colspan=2>';

    if (is_user_in_group($group->id, $user_groups)) {
        $chk_box_data = array(
            'name' => 'user_groups[]',
            'id' => $group->name,
            'value' => $group->id,
            'content' => $group->name,
            'checked' => "checked"
        );
        echo form_checkbox($chk_box_data);
        //echo form_checkbox(trim($group->name, " "), trim($group->name, " "), TRUE);
    } else {
        $chk_box_data = array(
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
echo "</table><br><br>";


echo "<h3>";
echo form_submit('login_submit', lang('submit'), 'class="submit_btn"');
echo "</h3>";
echo form_close();
?>



<script>
    $(document).ready(function() {
        var msg = <?php echo json_encode(lang("confirm_deactivate_msg")); ?>;

        $('#Deletion').click(function() {
            var conf = confirm(msg);
            if (conf == true)
            {
                var id = <?php echo $user_info->id; ?>;
                var b_url = "<?php echo base_url(); ?>";
                window.location.href = b_url + "index.php/users_manager/deactivate_user/" + id;
            }
        });
    });
</script>
<?php

function is_user_in_group($group_id, $user_groups) {
    foreach ($user_groups as $usr_group) {
        if ($usr_group == $group_id) {
            return true;
        }
    }
    return false;
}
?>
<script>
    function handleClick(cb) {
        if (cb.checked) {
            document.getElementById('password_row').style.display = "";
            document.getElementById('confirm_password_row').style.display = "";
        }
        else {
            document.getElementById('password_row').style.display = "none";
            document.getElementById('confirm_password_row').style.display = "none";
        }
    }
</script>