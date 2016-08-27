/* ------------------------------------------------------ *\
    [Variables] var
\* ------------------------------------------------------ */
    var $password, $confPassword, $name, $email, p, $btnSend;

    $password = $('#inputPassword');
    $conf_password =  $('#inputPasswordNewConfirm');
    $cryptId = $('#cryptId');
    $email = $('#email');
    $name = $('#name');

    $btnSend = $('.enviar.button.blue');
/* ------------------------------------------------------ *\
    [onSubmit function] $.submit_password_form
\* ------------------------------------------------------ */
    $.submit_password_form = function() {
        form_errors = 0;
        if (!$.validate_input($password) || !$.validate_input($conf_password)) {
            form_errors++;
            $('#inputPassword').focus();
            swal({   title: "Oops...",   text: "Los datos son requeridos",   type: "error",   timer: 1500,   showConfirmButton: false });
        }
        if ( $password.val() != $conf_password.val() ) {
            form_errors++;
            $conf_password.focus();
            $conf_password.val('');
            swal({   title: "Oops...",   text: "La nueva contraseña y la confirmación no coinciden",   type: "error",   timer: 1500,   showConfirmButton: false });
            return false;
        } else {
            if (form_errors == 0) {
                //setTimeout(function() {
                    //swal({   title: "Genial...",   text: 'Los datos son correctos... Espera un momento...',   type: "success",   timer: 1500,   showConfirmButton: false });
                    setTimeout(function() {
                        var data = {
                            p           : hex_sha512($password.val()),
                            name        : $('#name').val(),
                            email       : $('#email').val(),
                            crypt_id    : $('#cryptId').val()
                        }
                        var service_url = 'process_password.php';
                        $.ajax({
                            cache: false,
                            data: data,
                            dataType: 'html',
                            method: 'POST',
                            success: function (data) {
                                if (data) {
                                    setTimeout(function() {
                                        swal({   title: "Bienvenido...",   text: "Tu Contraseña ha sido cambiada con exito.",   type: "success",   showConfirmButton: true });
                                        setTimeout(function() {
                                            window.location = '../welcome';
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
    }