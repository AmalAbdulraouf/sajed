<link rel="stylesheet" type="text/css" href='<?php echo base_url(); ?>resources/datatables.min.css'/>
<script type="text/javascript" src='<?php echo base_url(); ?>resources/datatables.min.js'></script>
<link rel="stylesheet" type="text/css" href='<?php echo base_url() . 'resources/search_contacts.css' ?>'>
<link rel="stylesheet" href="<?php echo base_url()?>assets/buttons.dataTables.css">
<script src="<?php echo base_url()?>assets/dataTables.buttons.js"></script>
<script src="<?php echo base_url()?>assets/jszip.js"></script>
<script src="<?php echo base_url()?>assets/buttons.html5.js"></script>
<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center" >
        <h3 align="center"><?php echo lang('ready_not_delivered') ?></h3>
    </div>
    <div class="panel-body"  >
        <div  class="row" style="text-align: center">
            <div style="margin-bottom:40px; display:inline;">                   
                <label class="date_label" style="color:#2f434c;direction: rtl"> <?php echo $this->lang->line('from_date') ?></label> <input class="theme date_label" type="text" id="from_date"/>
                <label class="date_label" style="color:#2f434c;direction: rtl;"><?php echo $this->lang->line('to_date') ?></label><input class="theme date_label" type="text" id="to_date"  />

            </div>

            <table id="report" class="display reports" cellspacing="0" width="100%" style="direction: rtl">
                <thead>
                    <tr>
                        <?php
                        echo
                        '<th>' . lang('order_number') . '</th>'
                        . '<th>' . lang('service') . '</th>'
                        . '<th>' . lang('customer_name') . '</th>'
                        . '<th>' . lang('phone') . '</th><th>' . lang('total') . '</th>'
                        . '<th>' . lang('ready since') . '</th>'
                        . '<th>' . lang('place') . '</th>';
                        ?>
                    </tr>
                </thead>
                <tfoot>
                    <tr>                    
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
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
        "searching": true,
        "bSearchable": true,
        "bProcessing": true,
        "dom": 'Bfrtip',
        "buttons": [
            'excel'
        ],
        //                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "emptyTable": "لا يوجد معلومات",
        "bServerSide": true,
        "sAjaxSource": base_url + '/reports/delivered_orders/format/json',
        "fnServerParams": function (aoData) {
            aoData.push({"name": "start_date", "value": $("#from_date").val()},
                    {"name": "end_date", "value": $("#to_date").val()}
            );
        },
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
        "columnDefs": [
            //                {
            //                    "targets": [0],
            //                    "visible": false
            //                }

        ]

    });

    jQuery(function ($) {
        $(this).datepicker($.extend({}, $.datepicker.regional['ar'], {
            changeMonth: true,
            changeYear: true
        }));
    });
    $("#from_date").datepicker(
            {
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                changeMonth: true,
                onSelect: function (selected, evnt) {
                    var from;
                    from = $(this).val();
                    table.ajax.url(base_url + '/reports/ready_not_delivered/format/json?start_date='
                            + $("#from_date").val()
                            + '&end_date='
                            + $("#to_date").val()).load();
                }
            });
    $("#to_date").datepicker(
            {
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                changeMonth: true,
                onSelect: function (selected, evnt) {
                    table.ajax.url(base_url + '/reports/ready_not_delivered/format/json?start_date='
                            + $("#from_date").val()
                            + '&end_date='
                            + $("#to_date").val()).load();
                }
            });
    $(".hasDatepicker").datepicker('setDate', new Date());
    table.ajax.url(base_url + '/reports/ready_not_delivered/format/json?start_date='
            + $("#from_date").val()
            + '&end_date='
            + $("#to_date").val()).load();
    $('#report tbody').css("cursor", "pointer");
    $('#report tbody').on('click', 'tr', function () {
        location.href = base_url + "/order/view_order?order_id=" + $(this).find("td:first").text();
    });
</script>
