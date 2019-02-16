$(document).ready(function () {
    $('#forPrint').hide();
    $('#forPrintBill').hide();

    $("#barcodee").JsBarcode(code, {displayValue: true, fontSize: 20});
    $("#barcodee").hide();
    $("#barcodeSticker").JsBarcode(code, {displayValue: true, fontSize: 20});
    $('#order_history').dataTable({
        bFilter: false,
        bInfo: false,
        bPaginate: false
    });
    $("#rep_cost").keyup(function ()
    {
        if ($(this).val() != "")
        {
            if ($("#parts_cost").val() != "")
                $("#tot").val(parseInt($(this).val()) + parseInt($("#parts_cost").val()));
            else
                $("#tot").val(parseInt($(this).val()));
        } else
        {
            if ($("#parts_cost").val() != "")
                $("#tot").val(0 - parseInt($("#parts_cost").val()));
        }
    });
    $("#parts_cost").keyup(function ()
    {
        if ($(this).val() != "")
        {
            if ($("#rep_cost").val() != "")
                $("#tot").val(parseInt($(this).val()) + parseInt($("#rep_cost").val()));
            else
                $("#tot").val(parseInt($(this).val()));
        } else
        {
            if ($("#rep_cost").val() != "")
                $("#tot").val(0 - parseInt($("#rep_cost").val()));
        }
    });
    $("#cash").keyup(function ()
    {
        if ($(this).val() != "")
        {
            $("#remaining").val(parseInt($(this).val()) - parseInt($("#total_cost h3 b").html()));
        } else
        {
            $("#remaining").val(parseInt($("#total_cost h3 b").html()));
        }
    });

    $("#discount").keyup(function ()
    {
        if ($(this).val() != "")
        {
            $("#total_cost h3 b").html(parseInt($("#total_cost").val()) - parseInt($(this).val()));
            $("#total_cost h3").val(parseInt($("#total_cost").val()) - parseInt($(this).val()));
            $("#total_cost h3").attr("value", parseInt($("#total_cost").val()) - parseInt($(this).val()));
        } else
        {
            $("#total_cost h3 b").html(parseInt($("#total_cost").val()()));
            $("#total_cost h3").val(parseInt($("#total_cost").val()()));
            $("#total_cost h3").attr("value", parseInt($("#total_cost").val()()));
        }
    });


    $("#payButton").click(function ()
    {

    });
    $("#description").keydown(function () {
        $('#ready').attr('disabled', true);
    });


    $("#description").keyup(function () {
        if ($(this).val() != '')
            $('#ready').attr('disabled', true);
        else
            $('#ready').attr('disabled', false);
    });
    $('#noReceipt').on('change', function () {
        if (this.checked)
        {
            $('#IDnum').attr('disabled', false);
            $('#receipt').attr('disabled', false);
        } else
        {
            $('#IDnum').attr('disabled', true);
            $('#receipt').attr('disabled', true);
        }
    });
    $(".numeric_input").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A
                        (e.keyCode == 65 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right
                                (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
});

$(document).on('click', ".change_language", function () {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            location.reload(true);
        }
    }

    var link = "<?php echo base_url();?>" + "index.php/language/change_language?language=" + $(this).attr('id');
    xmlhttp.open("GET", link, true);
    xmlhttp.send();
});
function print_sticker() {
    $(".container").hide();
    $("#sticker").show();

    window.print();
//    location.reload();
    $("#sticker").hide();
    $(".container").show();
//    $('#forPrintShow').show();
//    $('#forPrint').hide();

}

function print_paper() {
//    $(document).ready(function() {
    $("#barcodee").show();
    $('#forPrintShow').hide();
    $(".container").hide();
    $('#forPrint').show();
//        $('#forPrintShow').hide();
    window.print();
    $("#barcodee").hide();
    $(".container").show();
    //$('#forPrintShow').show();
    $('#forPrintShow').show();
    $('#forPrint').hide();
    $('#forPrintBill').hide();
    print_sticker();
//    });
}

function print_bill() {
//    $(document).ready(function() {
    $("#barcodee").show();
    $('#forPrintShow').hide();
    $(".container").hide();
    $('#forPrint').hide();
    $('#forPrintBill').show();
//        $('#forPrintShow').hide();
    window.print();
    $("#barcodee").hide();
    $(".container").show();
    //$('#forPrintShow').show();
    $('#forPrintShow').show();
    $('#forPrint').hide();
    $('#forPrintBill').hide();
    location.reload();
//    });
}

function print_temporary(data) {
    var div = $('#temporary_device_print');
    div.find('#machine_type').html(data.machine_type_name);
    div.find('#brand').html(data.brand_name);
    div.find('#model').html(data.models);
    div.find('#color').html(data.color_name);
    div.find('#serial_no').html(data.serial_number);
    div.find('#faults').html(data.faults);
    div.find('#accessories').html(data.accessories);
    div.find('#customer_name').html(data.customer_name);
    div.find('#phone').html(data.mobile);
    $('#temporary_device_modal').modal("hide");
    $("#barcodee").hide();
    $('#forPrintShow').hide();
    $('#forPrintBill').hide();
    $(".container").hide();
    $('#forPrint').hide();
    $('#temporary_device_print').show();
    window.print();
    $("#barcodee").hide();
    $('#forPrintShow').hide();
    $(".container").show();
    $('#forPrint').hide();
    $('#temporary_device_print').hide();
    location.reload();
}

