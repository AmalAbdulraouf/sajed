<link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/jquery-ui.css' ?>'>
<link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/search_contacts.css' ?>'>

<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/holdOn/HoldOn.min.css" />
<script src="<?php echo base_url() ?>assets/holdOn/HoldOn.min.js"></script>
<?php
$at = array('method' => 'POST', 'class' => 'editForm', 'id' => 'editForm');
echo form_open('order/edit_order', $at);
echo "<div id='err' style='color: red'>" . validation_errors() . "</div>";?>
<?php $this->load->view('panels/edit_customer_panel') ?>
<?php $this->load->view('panels/edit_machine_panel') ?>
<?php $this->load->view('panels/edit_service_panel') ?>
<?php echo form_hidden('order_id', $order_info['order_basic_info'][0]->id);
$input_data = array
    (
    'name' => 'customer_id',
    'id' => 'customer_id',
    'value' => $order_info['order_basic_info'][0]->customer_id,
    'type' => "hidden"
);
echo form_input($input_data, set_value('customer_id'));
?>

<?php
$sub = array(
    'name' => 'submit changes',
    'value' => lang('submit'),
    'class' => 'submit_btn'
);
echo form_submit($sub);
?>
<script type="text/javascript" src='<?php echo base_url(); ?>resources/js/edit_order.js'></script>


