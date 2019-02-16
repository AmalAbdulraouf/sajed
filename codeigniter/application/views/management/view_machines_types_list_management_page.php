<script src='<?php echo base_url() . 'resources/jquery.min.js' ?>'></script>
<script src='<?php echo base_url() . 'resources/jquery-ui.js' ?>'></script>
<link rel="stylesheet" href='<?php echo base_url() . 'resources/jquery-ui.css' ?>'>
<script src='<?php echo base_url() . 'resources/jquery-ui.css' ?>'></script>
<script>
    $(document).ready(function() {
        $(".change_language").click(function() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    location.reload(true);
                }
            }

            var link = "<?php echo base_url(); ?>" + "index.php/language/change_language?language=" + $(this).attr('id');
            xmlhttp.open("GET", link, true);
            xmlhttp.send();
        });
    });
</script>


<title>حاسبات الخليج</title>

<script src='<?php echo base_url() . 'resources/jquery.min.js' ?>'></script>
<script src='<?php echo base_url() . 'resources/jquery-ui.js' ?>'></script>
<link rel="stylesheet" href='<?php echo base_url() . 'resources/jquery-ui.css' ?>'>
<script src='<?php echo base_url() . 'resources/jquery-1.10.2.js' ?>'></script>
<script src='<?php echo base_url() . 'resources/jquery-ui.css' ?>'></script>

<script>

    $(document).on('click', ".delete_item", function() {
        item = $(this).parent();
        $("#dialog_confirm_delete").dialog("open");
    });
    $(document).on('click', ".edit_item_name", function() {
        item = $(this).parent();
        $("#dialog_edit_item_name").dialog("open");
    });
    $(document).on('click', "#confirm_add_new", function() {
        if ($("#name_for_new_item").val() == "")
        {
            alert("Please enter a name  for the new item !");
        }
        else
        {
            add_new_item($("#name_for_new_item").val());
        }
    });

</script>
<script>
    $(function() {
        edit_dialog = $("#dialog_edit_item_name").dialog({
            autoOpen: false,
            resizable: false,
            width: 400,
            modal: true,
            buttons: {
                "Confirm Changes": function() {
                    var new_name = (edit_dialog.find("#new_name_edit").val());
                    if (new_name == "")
                    {
                        alert('Please, enter a name !!');
                    }
                    else if (new_name == item.children(".list_item_name").html())
                    {
                        //alert ("New name is same like an already exist one");
                        //edit_dialog.find("#new_name_edit").val('');
                        $(this).dialog("close");
                    }
                    else
                    {
                        update_item_name(item, new_name);
                        edit_dialog.find("#new_name_edit").val('');
                        $(this).dialog("close");
                    }
                },
                Cancel: function() {
                    edit_dialog.find("#new_name_edit").val('');
                    $(this).dialog("close");
                }
            }
        });
    });

    $(function() {
        $("#dialog_confirm_delete").dialog({
            autoOpen: false,
            resizable: false,
            width: 400,
            modal: true,
            buttons: {
                "Delete Item": function() {
                    delete_item(item);
                    $(this).dialog("close");
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            }
        });
    });


    function delete_item(item)
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {

                item.fadeOut("slow");

            }
        }
        var link = "<?php echo base_url(); ?>" + "index.php/management/delete_machine_type_by_id?machine_type_id=" + item.attr('value');

        xmlhttp.open("GET", link, true);
        xmlhttp.send();
    }

    function update_item_name(item, new_name)
    {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                item.children(".list_item_name").html(new_name);
                item.fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);

            }
            else if (xmlhttp.readyState == 4)
            {
                alert("an error happened .. try later please !");
            }
        }
        var link = "<?php echo base_url(); ?>" + "index.php/management/update_machine_type_name_by_id?machine_type_id=" + item.attr('value') + "&new_name=" + new_name;
        xmlhttp.open("GET", link, true);
        xmlhttp.send();
    }

    function add_new_item(new_name)
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                if (xmlhttp.responseText == 'error happened')
                {
                    alert("an error happened .. try later please !");
                }
                else
                {
                    html =
                            '<div class="list_item" tag="$machine_type->name" >' +
                            '<div class="list_item_name">' + new_name +
                            '</div>' +
                            '<div class="edit_item_name"><img width="64" src=<?php echo base_url() . 'resources/images/edit-6-48.png' ?>' + '></div>' +
                            '<div class="delete_item"><img width="64" src=<?php echo base_url() . 'resources/images/delete-48.png'; ?>' +
                            '></div></div><br>';
                    $("#list_item_container").append(html);
                    $("html, body").animate({scrollTop: $(document).height()}, 1000);
                    $('.list_item').last().fadeOut(100).fadeIn(100).fadeOut(800).fadeIn(200).fadeOut(200).fadeIn(200);
                    $('#name_for_new_item').val('');
                }
            }
            else if (xmlhttp.readyState == 4)
            {
                alert("an error happened .. try later please !");
            }
        }
        var link = "<?php echo base_url(); ?>" + "index.php/management/update_machines_types_insert_new?new_name=" + new_name;
        xmlhttp.open("GET", link, true);
        xmlhttp.send();
    }

</script>
<body>
    <div style="margin-top: 2%" class="container">
        <div align="center" class="panel panel-default">
            <div align="center" class="panel-body">
                <div class="page-header">
                    <?php $this->load->view('app_title') ?>
                    <div style="text-align:center">
                        <img src='<?php echo base_url() ?>resources/images/logo2.jpg'/>
                    </div>
                </div>

                <div class="row">
                    <div align="center" class="list_item_add col">
                        <div class="list_item_name"><input  type="text" name="name" id="name_for_new_item" /></div>
                        <div id = "confirm_add_new" class="col add_item_name"><img  src='<?php echo base_url() . 'resources/images/add-column-48.png' ?>'></div>
                    </div>

                    <div align="center" id="list_item_container" class="list_item_container col">

                        <?php
                        foreach ($machines_types as $machine_type) {
                            add_machine_type_div($machine_type);
                            //$machines_array[$machine->id] = $machine->name;		
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<div id="dialog_confirm_delete" title="Confirm Deletion .. ">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo lang('confirm_delete_msg') ?> </p>
</div>

<div id="dialog_edit_item_name" title="Edit Item Name">
    <div ><?php echo lang('enter_new_name_msg') ?> ...</p>

        <form>
            <label for="name"><?php echo lang('new_name') ?></label>
            <input type="text" name="name" id="new_name_edit" class="text ui-widget-content ui-corner-all">
        </form>

    </div>
</html>

<?php

function add_machine_type_div($machine_type) {
    echo '<div class="row list_item" value="' . $machine_type->id . '">';
    echo '<div class="col list_item_name">';
    echo $machine_type->name;
    echo '</div>';
    echo '<div class="edit_item_name "><img width="64" src=' . base_url() . 'resources/images/edit-6-48.png></div>';
    echo '<div class="delete_item "><img width="64" src=' . base_url() . 'resources/images/delete-48.png></div>';
    echo '</div>';
}
?>
