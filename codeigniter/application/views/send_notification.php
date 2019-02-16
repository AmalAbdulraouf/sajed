<div align="center" class="panel panel-default">
    <div class="panel-heading" style="text-align: center" >
        <h3 align="center"><?php echo lang('send_notification') ?></h3>
    </div>
    <div align="center" class="panel-body">

        <div class="row" id="create_message">
            <?php
            echo form_open('contacts/send_notification', array('class' => 'addForm', 'method' => 'post'));

            echo "<error>";
            echo validation_errors();
            echo "</error>";
            echo form_textarea('message_text', $message, 'class = "form-control" style="width:65%; max-width: 65%; min-width: 65%" placeholder="' . lang('message') . '"');
            echo form_textarea('message_text', $message, 'class = "form-control" style="width:65%; max-width: 65%; min-width: 65%" placeholder="' . lang('message') . '"');
            ?>

            <h3>
                <?php
                $sub = array(
                    'name' => 'submit changes',
                    'value' => lang('submit'),
                    'class' => 'submit_btn'
                );
                echo form_submit($sub);
                ?>
            </h3>
        </div>
    </div>
</div>
