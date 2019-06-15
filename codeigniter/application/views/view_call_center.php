
<style type="text/css">
    th {
        text-align: right
    }
</style>
<link rel="stylesheet" type="text/css" href='<?php echo base_url(); ?>resources/datatables.min.css'/>
<script type="text/javascript" src='<?php echo base_url(); ?>resources/datatables.min.js'></script>
<link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/search_contacts.css' ?>'>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/buttons.dataTables.css">
<script src="<?php echo base_url() ?>assets/dataTables.buttons.js"></script>
<script src="<?php echo base_url() ?>assets/jszip.js"></script>
<script src="<?php echo base_url() ?>assets/buttons.html5.js"></script>
<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center" >
        <h3 align="center"><?php echo lang('delivered_orders') ?>
            <br><br>
            <?php echo date('Y-m-d') ?>
        </h3>
    </div>
    <div class="panel-body"  >
        <div  class="row" style="text-align: center">

            <?php // var_dump($orders);?>
            <table id="report" class="table table-bordered table-striped" cellspacing="0" width="100%" style="direction: rtl">
                <thead>
                    <tr>
                        <?php
                        echo '<th>' . lang('order_number') . '</th>
                            
                                    <th>' . lang('service') . '</th>'.
                                '<th>' . lang('customer_name') . '</th>'.
                                '<th>' . lang('phone') . '</th>'.
                                '<th>' . lang('total') . '</th><th></th>';
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($orders as $order) {
//                        var_dump($order);die();
                        $services = array();
                        if ($order->software != 0)
                            $services[] = "software";
                        if ($order->electronic != 0)
                            $services[] = "electronic";
                        if ($order->external_repair != 0)
                            $services[] = "external";
                        if ($order->under_warranty != 0)
                            $services[] = "warranty";
                        if ($order->new_software != 0)
                            $services[] = "برمجة جهاز جديد";
                        echo '<tr>' .
                        '<td><a href="'.site_url().'/order/view_order?order_id='.$order->order_id.'" target="_blank">' . $order->order_id . '</a></td>' .
                        '<td>' . implode(", ", $services) . '</td>' .
                        '<td>' . $order->contact_name . '</td>' .
                                '<td>' . $order->phone . '</td>' .
                        '<td>' . $order->total . '</td>' .
                        '<td><a href="#" onclick="sms_modal('.$order->customer_id.')"><img width="35px" src="' . base_url() . 'resources/images/mail.png' . '"/></a></td>' .
                        '</tr>';
                    }
                    ?>
                </tbody>
                
            </table>
        </div>

        <div id = "customer_id" value=""></div>
    </div>

</div>
<script>
    var base_url = "<?php echo site_url() ?>";
    var table = $('#report').DataTable({
        "ordering": true,
        "destroy": true,
        "bInfo": false,
        "bPaginate": true,
        "bLengthChange": true,
        "bSearchable": true,
        "emptyTable": "لا يوجد معلومات",
        
        "language": {
            "sProcessing": "جاري التحميل...",
            "sLengthMenu": "أظهر مُدخلات _MENU_",
            "sZeroRecords": "لم يُعثر على أية سجلات",
            "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مُدخل",
            "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجلّ",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sInfoPostFix": "",
            "sSearch": "ابحث:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "الأول",
                "sPrevious": "السابق",
                "sNext": "التالي",
                "sLast": "الأخير"
            },
            "lengthMenu": "Display _MENU_ records per page",
            "zeroRecords": "لم يتم العثور على نتائج",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "لا يوجد معلومات",
            "next": "التالي",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },
    });

    function sms_modal(customer_id){
        var msg = window.prompt('ادخل نص الرسالة  Please enter the sms text');
        if(msg != null) {
            if(msg != ''){
                $.ajax({
                        type: "POST",
                        url: site_url + "/contacts/send_ntf_to_customer",
                        dataType: "json",
                        data: {
                            "msg": msg,
                            "contact_id": customer_id
                        },
                        success: function(data) {
                            $('textarea[name=new_sms]').val("");
                            $('textarea[name=new_sms]').text("");
                            $('.error').html("");
                            $('#new_sms').modal("hide");
                        },
                        error: function(response) {
                        }
                    });
            } else {
                console.log('empty');
            }
        } else
            console.log('cancel');
        
    }
</script>
