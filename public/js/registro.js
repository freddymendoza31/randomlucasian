$(document).ready(function () {

    $('#cedula', this).on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#password', this).on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#password2', this).on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    validate();
});

function validate() {

    $("#registro").validate({

        rules: {
            nombre: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            cedula: {
                required: true,
                maxlength: 10,
                minlength: 6
            },
            password: {
                required: true,
                minlength: 4

            },
            password2: {
                required: true,
                minlength: 4

            }
        },
        messages: {
            nombre: "Este campo es obligatorio. (Digite su nombre )",
            email: "Este campo es obligatorio. (Digite su email )",
            cedula: "Este campo es obligatorio. (minimo 6 digitos)",
            password2: "Este campo es obligatorio. (requiere 4 digitos )",
            password: "Este campo es obligatorio. (requiere 4 digitos )",
        },
        errorElement: 'span',

    });
}


$('#registro').submit(function (e) {
    e.preventDefault();
    notify();
    if ($('#password').val() === $('#password2').val()) {
        let data = [];
        data = $(this).serializeArray();

        $.ajax({
            url: '/registros',
            type: 'post',
            dataType: 'JSON',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function ({ error, msj, url }) {
            console.log(error)
            if (!error) {
                console.log('el error es falso')
                Command: toastr["success"](msj)

                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                $(location).attr('href', url);
            } else {
                console.log('el error es verdadero')

                Command: toastr["error"](msj)

                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
            }
        })

    }

});

//$(".login_btn").on("click", notify);

function notify() {
    jQuery('input').each(function () {
        if (jQuery(this).prop('value') == '') {

            return true;
            console.log('el campo esta vacio')

        }

    });

    // jQuery('input').each(function () {
    //     if (jQuery(this).prop('value') == '') {

    //         Command: toastr["warning"]("Digite su " + jQuery(this).prop('name'), "error")

    //         toastr.options = {
    //             "closeButton": false,
    //             "debug": false,
    //             "newestOnTop": false,
    //             "progressBar": false,
    //             "positionClass": "toast-top-right",
    //             "preventDuplicates": false,
    //             "onclick": null,
    //             "showDuration": "300",
    //             "hideDuration": "1000",
    //             "timeOut": "5000",
    //             "extendedTimeOut": "1000",
    //             "showEasing": "swing",
    //             "hideEasing": "linear",
    //             "showMethod": "fadeIn",
    //             "hideMethod": "fadeOut"
    //         }

    //     }

    // });


    // if ($('#password').val() !== $('#password2').val()) {
    //     Command: toastr["error"]("el campo  contraseña no coincide", "error")

    //     toastr.options = {
    //         "closeButton": false,
    //         "debug": false,
    //         "newestOnTop": false,
    //         "progressBar": false,
    //         "positionClass": "toast-top-right",
    //         "preventDuplicates": false,
    //         "onclick": null,
    //         "showDuration": "300",
    //         "hideDuration": "1000",
    //         "timeOut": "5000",
    //         "extendedTimeOut": "1000",
    //         "showEasing": "swing",
    //         "hideEasing": "linear",
    //         "showMethod": "fadeIn",
    //         "hideMethod": "fadeOut"
    //     }

    // }


}
