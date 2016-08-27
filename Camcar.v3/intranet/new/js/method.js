/* ------------------------------------------------------ *\
    [Variables] var
\* ------------------------------------------------------ */
    var $recovery_email, $btnSend;

    $recovery_email = $('#inputEmail');

    $btnSend = $('.enviar.button.blue');
/* ------------------------------------------------------ *\
    [onSubmit function] $.submit_new_form
\* ------------------------------------------------------ */
    $.submit_new_form = function() {
        form_errors = 0;
        if (!$.validate_input($recovery_email)) {
            form_errors++;
            $('#inputEmail').focus();
            swal({   title: "Oops...",   text: "Es necesario tu correo para crear una nueva contraseña",   type: "error",   timer: 1500,   showConfirmButton: false });
        }
        if (form_errors == 0) {
            //setTimeout(function() {
                //swal({   title: "Genial...",   text: 'Los datos son correctos... Espera un momento....',   type: "success",   timer: 1500,   showConfirmButton: false });
                setTimeout(function() {
                    var data = {
                        email       : $('#inputEmail').val()
                    }
                    var service_url = 'process_new.php';
                    $.ajax({
                        cache: false,
                        data: data,
                        dataType: 'html',
                        method: 'POST',
                        success: function (data) {
                            if (data) {
                                setTimeout(function() {
                                    swal({   title: "Genial...",   text: "Te hemos enviado un enlace para crear tu nueva contraseña a tu correo.",   type: "success",   showConfirmButton: true });
                                    setTimeout(function() {
                                        window.location = '../login';
                                    }, 1250);
                                }, 1200);
                            } else {
                                setTimeout(function() {
                                    swal({   title: "OoO!!!",   text: 'Ha ocurrido un error, por favor, Intentalo nuevamente',   type: "error",   showConfirmButton: true });
                                }, 1200);
                            }
                        },
                        error: function (x, t, m) {
                            setTimeout(function() {
                                swal({   title: "Oops...",   text: "Ha ocurrido un error, por favor, inténtalo nuevamente.",   type: "error",   showConfirmButton: true });
                            }, 1200);
                        },
                        url: service_url
                    });
                }, 1000);
            //}, 1300);
        }
    }