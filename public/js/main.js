$(document).ready(function () {

    $('[data-toggle="popover"]').popover();
    $('[data-toggle="tooltip"]').tooltip();

    var MaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(MaskBehavior.apply({}, arguments), options);
            }
        };

    $(".validar").ValidateMe({
        shake: false
    });

    $('.datepicker').datepicker({
        autoclose: true,
        format: "dd/mm/yyyy",
        language: 'pt-BR'
    });

    $('.maskphone').mask(MaskBehavior, spOptions);
    $('.masktime, .maskhour').mask('00:00');
    $('.maskdate').mask('00/00/0000');
    $('.maskzipcode').mask('00000-000');
    $('.maskcpf').mask('000.000.000-00', {
        reverse: true
    });
    $('.maskcnpj').mask('00.000.000/0000-00', {
        reverse: true
    });
    $('.maskmoney').mask('000.000.000.000.000,00', {
        reverse: true
    });
    $('.maskmoney4').mask('000.000.000.000.000,0000', {
        reverse: true
    });
    $('.maskplaque').mask('AAA-0000');

    $('#printpage').click(function (e) {
        e.preventDefault();
        window.print();
    });

    $(".goto").click(function (e) {
        e.preventDefault();
        var l = $(this).attr("href");
        $('html,body').animate({
            scrollTop: $(l).offset().top - 50
        }, 1000);
    });

    $(".confirmdelete").click(function (e) {
        e.preventDefault();
        var url = $(this).attr("href");
        res = confirm("Confirm delete?");
        if (res)
            window.location.href = url;
    });

    $(".showsearch").click(function () {
        $(this).fadeOut('fast');
        $('#searchform').fadeIn("fast", function () {
            $(this).find(".focus").focus();
        });
    });
})