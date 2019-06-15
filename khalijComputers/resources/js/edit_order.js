
$(function () {
    $(".datepicker").datepicker();
});
$(document).ready(function () {
    $('#subBar').click(function () {
        $('#ba').submit();
    });
    if ($('#examine_date').is(':checked') == false)
    {
        $('#delivery_date').attr('checked', true);
        $('#examine_cost').attr('disabled', true);
        $('#expected_examine_date').attr('disabled', true);
        $('#estimated_cost').attr('disabled', false);
        $('#expected_delivery_date').attr('disabled', false);
    } else
    {
        $('#delivery_date').attr('checked', true);
        $('#delivery_date').attr('checked', false); // ...meaning that we can use its value to set the 'disabled' attribute 
        $('#estimated_cost').attr('disabled', true);
        $('#expected_delivery_date').attr('disabled', true);
        $('#examine_cost').attr('disabled', false);
        $('#expected_examine_date').attr('disabled', false);
    }

    $('#delivery_date').click(function () {
        $('#examine_date').attr('checked', false); // ...meaning that we can use its value to set the 'disabled' attribute 
        $('#examine_cost').attr('disabled', true);
        $('#expected_examine_date').attr('disabled', true);
        $('#estimated_cost').attr('disabled', false);
        $('#expected_delivery_date').attr('disabled', false);
    });
    $('#examine_date').click(function () {
        $('#delivery_date').attr('checked', false); // ...meaning that we can use its value to set the 'disabled' attribute 
        $('#estimated_cost').attr('disabled', true);
        $('#expected_delivery_date').attr('disabled', true);
        $('#examine_cost').attr('disabled', false);
        $('#expected_examine_date').attr('disabled', false);
    });
});

$(document).ready(function () {
    $(".numeric_input").keydown(function (e) {
        var fieldLength = document.getElementById('phone').value.length;
        if (fieldLength >= 9)
        {
            var str = document.getElementById('phone').value;
            str = str.substring(0, str.length - 1);
            document.getElementById('phone').value = str;
        }
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
//        if ($('#under_warranty').is(':checked'))
//        {
//            $('#billNumber').attr('disabled', false);
//            $('#billDate').attr('disabled', false);
//        }
//        else
//        {
//            $('#billNumber').attr('disabled', true);
//            $('#billDate').attr('disabled', true);
//        }
//
//        $('#under_warranty').on('change', function() {
//            if ($(this).is(':checked'))
//            {
//                $('#billNumber').attr('disabled', false);
//                $('#billDate').attr('disabled', false);
//            }
//            else
//            {
//                $('#billNumber').attr('disabled', true);
//                $('#billDate').attr('disabled', true);
//            }
//        });
});

function changeFun()
{
    document.attr('checked', !document.prop('checked'));
}


$(document).ready(function () {


    $('#examine_date').change(function () {
        $('#delivery_date').attr('checked', !$(this).prop('checked'));
    });
    $('.editForm').on('keydown', 'input', function (event) {
        if (event.which == 13) {
            event.preventDefault();
            var $this = $(event.target);
            var index = parseFloat($this.attr('data-index'));
            $('[data-index="' + (index + 1).toString() + '"]').focus();
        }
    });
    $(".change_language").click(function () {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                location.reload(true);
            }
        }

        var link = base_url + "index.php/language/change_language?language=" + $(this).attr('id');
        xmlhttp.open("GET", link, true);
        xmlhttp.send();
    });
});
$(document).on('change', "#brands_drop_down_list", function () {
    brand_id = $(this).val();
    update_models_by_brand(brand_id);
});
$(document).on('change', "#models", function () {
    source: base_url + "index.php/management/get_list_of_models_by_brand_id_model_name?brand_id=" + $("#brands_drop_down_list").val()
});
$(document).ready(function () {
    document.getElementById("models").onkeydown = function myFunction(e) {
        if (e.ctrlKey) {
            return;
        }
        var characters = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
        var keyCode = (window.event) ? e.which : e.keyCode;
        if (keyCode >= 65 && keyCode <= 90) {
            this.value += characters[keyCode - 65];
            return false;
        } else if ((keyCode < 8 || keyCode > 105)) {
            this.value += '';
            return false;
        }
    };
});
$(document).ready(function () {
    document.getElementById("serial_number").onkeydown = function myFunction(e) {
        if (e.ctrlKey) {
            return;
        }
        var characters = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
        var keyCode = (window.event) ? e.which : e.keyCode;
        if (keyCode >= 65 && keyCode <= 90) {
            this.value += characters[keyCode - 65];
            return false;
        } else if ((keyCode < 8 || keyCode > 105)) {
            this.value += '';
            return false;
        }
    };
    var billdate = new Date($('input[name=billDate]').val());
    var today = new Date();
    var diffDays = parseInt((today - billdate) / (1000 * 60 * 60 * 24));
    var period = $('select[name=warranty_period]').val();
    if (period == "1") {
        if (diffDays >= 365)
            $('#time_remaining').html(language.warranty_over);
        else
            $('#time_remaining').html((365 - diffDays) + " " + language.day);
    } else if (period == "2") {
        if (diffDays >= 365 * 2)
            $('#time_remaining').html(language.warranty_over);
        else
            $('#time_remaining').html((365 * 2 - diffDays) + " " + language.day);
    }

    $('select[name=warranty_period], input[name=billDate]').change(function () {
        var billdate = new Date($('input[name=billDate]').val());
        var today = new Date();
        var diffDays = parseInt((today - billdate) / (1000 * 60 * 60 * 24));
        var period = $('select[name=warranty_period]').val();
        if (period == "1") {
            if (diffDays >= 365)
                $('#time_remaining').html(language.warranty_over);
            else
                $('#time_remaining').html((365 - diffDays) + " " + language.day);
        } else if (period == "2") {
            if (diffDays >= 365 * 2)
                $('#time_remaining').html(language.warranty_over);
            else
                $('#time_remaining').html((365 * 2 - diffDays) + " " + language.day);
        }
    });
});
$(function () {
    $("#models").autocomplete({
        source: base_url + "index.php/management/get_list_of_models_by_brand_id_model_name?brand_id=" + $("#brands_drop_down_list").val()
    });
});
$(function () {
    $("#colors").autocomplete({
        source: base_url + "index.php/management/get_list_of_colors_like_name"
    });
});

function checkLength()
{
    var fieldLength = document.getElementById('phone').value.length;
    //Suppose u want 4 number of character
    if (fieldLength <= 9) {
        return true;
    } else
    {
        var str = document.getElementById('phone').value;
        str = str.substring(0, str.length - 1);
        document.getElementById('phone').value = str;
    }
}

var source_link;
function update_models_by_brand(brand_id)
{
    $("#models").val('');
    source_link = base_url + "index.php/management/get_list_of_models_by_brand_id_model_name?brand_id=" + $("#brands_drop_down_list").val();
    $("#models").autocomplete("option", "source", source_link);
}
$('[data-toggle="tooltip"]').tooltip();
$(".service, .service-selected").click(function () {
    if ($(this).hasClass("service-selected"))
    {
        $(this).removeClass("service-selected");
        $(this).addClass("service");
        if ($(".service-selected").length == 0) {
            $('input[name=services]').val(0);
            $('#time_remaining').html("");
            $('#after_service').hide();
            $('#warranty_area').hide();
            $('#formating').hide();
            $('#visite_date').hide();
            $('#dates').hide();
            $('#billNumber').attr('disabled', true);
            $('#billDate').attr('disabled', true);
            $('#assign_tech').hide();
        } else {
            $('input[name=service]').val(1);
            if ($(this).attr("id") == "select_software") {
                $('input[name=software]').val(0);
                $('#formating').hide();
//                $('#dates').hide();
            } else if ($(this).attr("id") == "select_electronic") {
                $('input[name=electronic]').val(0);
//                $('#dates').hide();
            } else if ($(this).attr("id") == "select_external") {
                $('input[name=external]').val(0);
                $('#visite_date').hide();
            } else if ($(this).attr("id") == "select_warranty"){
                $('input[name=warranty]').val(0);
                $('#warranty_area').hide();
                $('#billNumber').attr('disabled', false);
                $('#billDate').attr('disabled', false);
                $('#time_remaining').html("");
            } else {
                $('input[name=new_software]').val(0);
                $('#new_software_area').hide();
                $('#billNumber2').attr('disabled', false);
                $('#billDate2').attr('disabled', false);
            }
            if (!$('#select_software').hasClass("service-selected") && !$('#select_electronic').hasClass("service-selected"))
                $('#dates').hide();
            if ($('#select_warranty').hasClass("service-selected") && $(".service-selected").length == 1)
                $('#assign_tech').hide();
        }
    } else {
        $('input[name=services]').val(1);
        $('#after_service').show();
        $(this).removeClass("service");
        $(this).addClass("service-selected");
        if ($(this).attr("id") == "select_software") {
            $('#assign_tech').show();
            $('input[name=software]').val(1);
            $('#formating').show();
            $('#dates').show();
        } else if ($(this).attr("id") == "select_electronic") {
            $('#assign_tech').show();
            $('input[name=electronic]').val(1);
            $('#dates').show();
        } else if ($(this).attr("id") == "select_external") {
            $('#assign_tech').show();
            $('input[name=external]').val(1);
            $('#visite_date').show();
        } else if ($(this).attr("id") == "select_warranty"){
            $('input[name=warranty]').val(1);
            $('#warranty_area').show();
            $('#billNumber').attr('disabled', false);
            $('#billDate').attr('disabled', false);
        } else {
            $('input[name=new_software]').val(1);
            $('#new_software_area').show();
            $('#billNumber2').attr('disabled', false);
            $('#billDate2').attr('disabled', false);
        }
    }
});

$(".service-selected").each(function () {
    $('input[name=services]').val(1);
    $('#after_service').show();
    $(this).removeClass("service");
    $(this).addClass("service-selected");
    if ($(this).attr("id") == "select_software") {
        $('#assign_tech').show();
        $('input[name=software]').val(1);
        $('#formating').show();
        $('#dates').show();
    } else if ($(this).attr("id") == "select_electronic") {
        $('#assign_tech').show();
        $('input[name=electronic]').val(1);
        $('#dates').show();
    } else if ($(this).attr("id") == "select_external") {
        $('#assign_tech').show();
        $('input[name=external]').val(1);
        $('#visite_date').show();
    } else if ($(this).attr("id") == "select_warranty") {
        $('input[name=warranty]').val(1);
        $('#warranty_area').show();
        $('#billNumber').attr('disabled', false);
        $('#billDate').attr('disabled', false);
    } else {
        $('input[name=new_software]').val(1);
        $('#new_software_area').show();
        $('#billNumber2').attr('disabled', false);
        $('#billDate2').attr('disabled', false);
    }
});

$('.editForm').submit(function (e) {
    e.preventDefault();
    $('input[name=contact_rate]').val($('.selected-face').attr("rate"));
    if ($('.selected-face').length == 0)
        $('input[name=contact_rate]').val(0);
    var data = $(this).serialize();
    HoldOn.close();
    $.ajax({
        type: "post",
        url: site_url + "/order/edit_order/format/json",
        dataType: "json",
        data: data,
        success: function (data) {
            HoldOn.close();
            if (data.status == false)
                alert(data.data);
            else {
                location.href = site_url + '/order/view_order?order_id=' + data.data + '&just_received=1';
            }
        },
        error: function (response) {
            HoldOn.close();
        }
    });

});