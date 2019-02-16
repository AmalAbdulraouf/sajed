<link rel="stylesheet" type="text/css" href='<?php echo base_url(); ?>resources/datatables.min.css'/>
<script type="text/javascript">
    var service_type = "<?php echo $this->input->post("services") ?>";
    var customer_id =
<?php
$current_customer_id = set_value('customer_id', -1);
echo $current_customer_id;
?>;
</script>
<script src='<?php echo base_url() . 'resources/jquery-1.11.1.min.js' ?>'></script>
    <script src='<?php echo base_url() . 'resources/jquery-1.10.2.min.js' ?>'></script>
<script type="text/javascript" src='<?php echo base_url(); ?>resources/datatables.min.js'></script>
<script type="text/javascript" src='<?php echo base_url(); ?>resources/js/bootstrap.min.js'></script>
<script type="text/javascript" src='<?php echo base_url(); ?>resources/moments.js'></script>

<link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/jquery-ui.css' ?>'>
<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/holdOn/HoldOn.min.css" />
<script src="<?php echo base_url() ?>assets/holdOn/HoldOn.min.js"></script>

<?php
echo form_open_multipart('order/save_new_order', array('class' => 'addForm'));

echo '<div class="alert alert-danger" role="alert" id="error">';
echo validation_errors();
echo "</div>";
?>
<?php $this->load->view('panels/add_customer_panel') ?>
<?php $this->load->view('panels/add_machine_panel') ?>
<?php $this->load->view('panels/add_service_panel') ?>

<?php
$input_data = array
    (
    'name' => 'customer_id',
    'id' => 'customer_id',
    'value' => "",
    'type' => "hidden"
);
echo form_input($input_data, set_value('customer_id'));

$sub = array(
    'name' => 'submit changes',
    'value' => lang('submit'),
    'class' => 'submit_btn'
);
echo form_submit($sub);
?>

<?php $this->load->view('modals/add_order_modals') ?>
<script type="text/javascript" src='<?php echo base_url(); ?>resources/js/add_new_order.js'></script>
