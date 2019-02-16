$('#voidBtn').hide();
$(document).ready(function () {
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
    $('#under_warranty').on('change', function () {
        if ($(this).is(':checked'))
        {
            $('#billNumber').attr('disabled', false);
            $('#billDate').attr('disabled', false);
        } else
        {
            $('#billNumber').attr('disabled', true);
            $('#billDate').attr('disabled', true);
        }
    });
    if ($('#delivery_date').is(':checked') == false && $('#examine_date').is(':checked') == false)
    {
        $('#delivery_date').attr('checked', true);
        $('#examine_cost').attr('disabled', true);
        $('#expected_examine_date').attr('disabled', true);
        $('#estimated_cost').attr('disabled', false);
        $('#expected_delivery_date').attr('disabled', false);
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

    $('.addForm').on('keydown', 'input', function (event) {
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
    $(".open_customer_info").hide();
    $("#open_customer").click(function () {
        $(".add_customer_info").hide();
        $(".open_customer_info").show();
        $('#searchbox').focus();
    });
    $("#add_customer").click(function () {
        $(".add_customer_info").show();
        $(".open_customer_info").hide();
        $('#prev-machines').text("");
        $("#customer_id").val("");
    });
    $("#change_customer").click(function () {
        $("#selected_contact").hide();
        $(".search").show();
        $(this).hide();
        $(".search").focus();
    });
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
    $("#models").autocomplete({
        source: base_url + "index.php/management/get_list_of_models_by_brand_id_model_name?brand_id=" + $("#brands_drop_down_list").val()
    });
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
    $('.select, .select')
    $(".searchbox").autocomplete({

        autoFocus: true,
        source: function (req, add) {
            $.getJSON(site_url + "/contacts/search?key=" + $(".searchbox").val(), req, function (data) {
                var suggestions = [];
                $.each(data["data"], function (i, val) {
                    suggestions.push({
                        label: val.first_name + " " + val.last_name,
                        id: val.id,
                        phone: val.phone,
                        company_id: null,
                        first_name: val.first_name,
                        last_name: val.last_name,
                        email: val.email,
                        address: val.address,
                        points: val.points,
                        discount: val.discount,
                        rate: val.rate
                    }); //not val.name
                    if (val.company_delegate_id != null)
                        suggestions.push({
                            label: language.company + ": " + val.first_name + " " + val.last_name,
                            id: val.id,
                            phone: val.phone,
                            first_name: val.first_name,
                            last_name: val.last_name,
                            company_id: val.company_id,
                            company_name: val.company_name,
                            company: val.company_delegate_id,
                            email: val.email,
                            address: val.address,
                            rate: val.rate
                        }); //not val.name
                });
                add(suggestions);
            });
        },
        //select
        select: function (e, ui) {
            e.preventDefault();
            var html = "#" + ui.item.id + "<br>";
            html += "<b>" + ui.item.first_name + " " + ui.item.last_name + "</b><br>";
            html += ui.item.phone + "<br>";
            html += ui.item.address + "<br>";
            html += language.customer_points + ": " + ui.item.points + "<br>";
            html += language.customer_discount + ": " + ui.item.discount + " %<br>";
            html += "<a onclick=\"$(\'#customer_history\').modal(\'show\');\">" + language.not_delivered + "</a>";
            $("#display").hide();
            $("#selected_contact").html(html);
            $("#customer_id").val(ui.item.id);
            $('#phone').val(ui.item.phone);
            console.log(ui.item.email);
            $('input[name=email]').val(ui.item.email);
            $('input[name=phone]').val(ui.item.phone);
            $('textarea[name=address]').val(ui.item.address);
            $('input[name=first_name]').val(ui.item.first_name + " " + ui.item.last_name);
            $('#prev-machines').text(language.previous_machines);
            $('#not_delivered_machines').show();
            $('[rate]').removeClass("selected-face");
            $('[rate]').addClass("face");
            $('[rate=' + ui.item.rate + "]").addClass("selected-face");
            $('[rate=' + ui.item.rate + "]").removeClass("face");
            if (ui.item.company_id != null) {

                $('input[name=company]').prop("checked", true);
                $('#prev-machines').attr("onclick", "prev_machines(" + ui.item.company_id + "," + true + ")");
                $('input[name=company_used]').val(1);
                $.ajax({
                    type: "GET",
                    url: site_url + "/companies/get_not_delivered/format/json?company_id=" + ui.item.company_id,
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        computers = data['data'];
                        render_computers(computers, ui.item.company_name);

                    },
                    error: function (response) {
                    }
                });
            } else {

                $('#prev-machines').attr("onclick", "prev_machines(" + ui.item.id + "," + false + ")");
                $('input[name=company_used]').val(0);
                $.ajax({
                    type: "GET",
                    url: site_url + "/contacts/get_not_delivered/format/json?contact_id=" + ui.item.id,
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        computers = data['data'];
                        render_computers(computers, false);

                    },
                    error: function (response) {

                    }
                });
            }
            $("#selected_contact").show();
            $('input[name=phone]').val(ui.item.phone);
        }
    });

    $("#company_name").autocomplete({
        autoFocus: true,
        source: function (req, add) {
            $.getJSON(site_url + "/companies/search?key=" + $('#company_name').val(), req, function (data) {
                console.log(data);
                var suggestions = [];
                $.each(data["data"], function (i, val) {
                    suggestions.push({
                        label: val.name,
                        id: val.company_id,
                        email: val.email,
                        address: val.address
                    }); //not val.name
                });
                add(suggestions);
            });
        },
        //select
        select: function (e, ui) {
            $("#company_id").val(ui.item.id);
            $("#company_email").val(ui.item.email);
        }
    });
});
$(document).on('change', "#brands_drop_down_list", function () {
    brand_id = $(this).val();
    update_models_by_brand(brand_id);
});

$(document).on('change', "#models", function () {
    source: base_url + "index.php/management/get_list_of_models_by_brand_id_model_name?brand_id=" + $("#brands_drop_down_list").val()
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
if (customer_id > -1) {
    $(".open_customer_info").show();
    $(".add_customer_info").hide();

    var dataString = 'searchword=' + customer_id;
    $.post(base_url + "index.php/order/search_contacts",
            {searchword: customer_id},
            function (data, status) {
                $("#selected_contact").html(data);
                var html = "#" + $("#selected_contact").find('#id').html() + "<br>";
                html += "<b>" + $("#selected_contact").find('#name').text() + "</b><br>";
                html += $("#selected_contact").find('#phone').html() + "<br>";
                html += $("#selected_contact").find('#address').html() + "<br>";
                $("#display").hide();
                $("#customer_id").val($("#selected_contact").find('#id').html());
                $("#selected_contact").html(html);

                $("#selected_contact").show();
                $(".search").hide();
                $("#change_customer").show();
            }
    );
}
jQuery(function ($) {
    $("#searchbox").Watermark("Search By Name, Phone, Or ID");
});

$.datepicker.setDefaults($.datepicker.regional[ "ar" ]);
$(function () {
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true
    });
    $('#subBar').click(function () {
        $('#ba').submit();
    });
    $.extend($.datepicker.regional["fr"], {dateFormat: "d MM, y"});
});

select_service_input(service_type);

function select_company(ob) {
    if ($(ob).prop("checked") == true) {
        $('#company_info').show();
        $('#full_name').attr("placeholder", language.company_delegate);
    } else {
        $('#company_info').hide();
        $('#full_name').attr("placeholder", language.name);
    }
}
function render_computers(computers, company) {

    if (computers.length != 0) {
        $('#customer_history_table tbody').html("");
        for (var i = 0; i < computers.length; i++) {
            var customer = "";
            if (company == false)
                customer = computers[i]['first_name'] + " " + computers[i]['last_name'];
            else
                customer = language.company + ": " + company + " " + computers[i]['first_name'] + " " + computers[i]['last_name'];
            $('#customer_history_table').append(
                    "<tr><td>" + computers[i]['id'] +
                    "</td><td>" + customer +
                    "</td><td>" + computers[i]['name'] +
                    "</td><td>" + computers[i]['model'] +
                    "</td><td>" + computers[i]['fault_description'] + "</td></tr>"
                    );
        }
        $('#customer_history_table').dataTable();
        $('#customer_history').modal("show");
    }
}
function prev_machines(id, company) {
    if (company == true) {
        $.ajax({
            type: "GET",
            url: site_url + "/companies/get_prev_machines/format/json?company_id=" + id,
            dataType: "json",
            success: function (data) {
                console.log(data);
                computers = data['data'];
                render_machines(computers);

            },
            error: function (response) {

            }
        });
    } else if (company == false) {
        $.ajax({
            type: "GET",
            url: site_url + "/contacts/get_prev_machines/format/json?contact_id=" + id,
            dataType: "json",
            success: function (data) {
                console.log(data);
                computers = data['data'];
                render_machines(computers);

            },
            error: function (response) {

            }
        });
    }
}
function render_machines(computers) {

    if (computers.length != 0) {
        $('#customer_machines_table tbody').html("");
        for (var i = 0; i < computers.length; i++) {
            var customer = "";

            customer = computers[i]['first_name'] + " " + computers[i]['last_name'];
            var image = "</td><td>";
            if (computers[i]['image'] != '')
                image = "</td><td><img width='100px' height='100px' src='" + base_url + "resources/machines/" + computers[i]['image'] + "' />";
            $('#customer_machines_table').append(
                    "<tr><td>" + computers[i]['serial_number'] +
                    "</td><td>" + computers[i]['name'] +
                    "</td><td>" + computers[i]['model'] +
                    "</td><td>" + computers[i]['fault_description'] +
                    image +
                    '</td><td><button data-computer=\'' + JSON.stringify(computers[i]) + '\' onclick="choose(this);return false;" class="btn btn-primary">' + language.choose + '</button></td></tr>'
                    );
        }
        $('#customer_machines_table').dataTable();
        $('#customer_machines').modal("show");
    }
}
function choose(ob) {
    var machine = JSON.parse($(ob).attr("data-computer"));
    $('select[name=machine_type]').val(machine['machines_types_id']);
    $('select[name=brands]').val(machine['brand_id']);
    $('input[name=models]').val(machine['model']);
    $('input[name=machine_id]').val(machine['id']);
    $('input[name=image_name]').val(machine['image']);
    if (machine['image'] != "") {
        $('#image_box').show();
        $('#image_box').attr("src", base_url + 'resources/machines/' + machine['image']);
    } else {
        $('#image_box').hide();
        $('#image_box').attr("src", "");
    }
    $('textarea[name=faults]').val(machine['faults']);
    $('textarea[name=faults]').text(machine['faults']);
    $('input[name=serial_number]').attr("value", machine['serial_number']);
    $('select[name=colors]').val(machine['color_id']);
    if (machine['under_warranty'] == 1) {
        $('input[name=under_warranty]').prop("checked", true);
        $('input[name=billDate]').prop("disabled", false);
        $('input[name=billNumber]').prop("disabled", false);
        $('input[name=billDate]').val(machine['billDate']);
        $('input[name=billNumber]').val(machine['billNumber']);
        $('input[name=accessories]').val(machine['Notes']);
    } else {
        $('input[name=under_warranty]').prop("checked", false);
        $('input[name=billDate]').prop("disabled", true);
        $('input[name=billNumber]').prop("disabled", true);
        $('input[name=billDate]').val("");
        $('input[name=billNumber]').val("");
        $('input[name=accessories]').val("");
    }
    $('#customer_machines').modal("hide");
}
$('.addForm').submit(function (e) {
    e.preventDefault();
    $('input[name=contact_rate]').val($('.selected-face').attr("rate"));
    if ($('.selected-face').length == 0)
        $('input[name=contact_rate]').val(0);
    var data = $(this).serialize();
    HoldOn.open({
        theme: "sk-bounce"
    });
    $.ajax({
        type: "post",
        url: site_url + "/order/save_new_order/format/json",
        dataType: "json",
        data: data,
        success: function (data) {
            HoldOn.close();
            if (data.status == false)
                alert(data.data);
            else {
                alert("done");
                location.href = site_url + '/order/view_order?order_id=' + data.data + '&just_received=1';
            }
        },
        error: function (response) {
            HoldOn.close();
        }
    });

});
function select_service(ob) {
    select_service_input($(ob).val());
}
function select_service_input(val) {
    $('#time_remaining').html("");
    $('#after_service').hide();
    $('#warranty_area').hide();
    $('#formating').hide();
    $('#visite_date').hide();
    $('#dates').hide();
    $('#billNumber').attr('disabled', true);
    $('#billDate').attr('disabled', true);
    if (val == 0) {
        $('#after_service').hide();
    } else if (val == 1) {
        $('#after_service').show();
        $('#formating').show();
        $('#dates').show();
    } else if (val == 2) {
        $('#after_service').show();
        $('#dates').show();
    } else if (val == 3) {
        $('#after_service').show();
        $('#visite_date').show();
    } else if (val == 4) {
        $('#after_service').show();
        $('#warranty_area').show();
        $('#billNumber').attr('disabled', false);
        $('#billDate').attr('disabled', false);
    }
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
            } else {
                $('input[name=warranty]').val(0);
                $('#warranty_area').hide();
                $('#billNumber').attr('disabled', false);
                $('#billDate').attr('disabled', false);
                $('#time_remaining').html("");
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
        } else {
            $('input[name=warranty]').val(1);
            $('#warranty_area').show();
            $('#billNumber').attr('disabled', false);
            $('#billDate').attr('disabled', false);
        }
    }
});