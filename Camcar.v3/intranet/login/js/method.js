/* ------------------------------------------------------ *\
    [functions] formLoginMethod
\* ------------------------------------------------------ */
	var formLoginMethod = {
		fillingControl: function() {
			var validFieldName, perFormData, isFull;
			validFieldName = [
				'email',
				'password'
			];
			perFormData = $('form.login-form').serializeFormJSON();
			//isFull = CAMIN.validFormFull(perFormData, validFieldName);
			//$('button#goF').attr('disabled', !isFull);
		},
		keyupInput: function(event) {
			formLoginMethod.fillingControl();
		},
		clickGo: function(event) {
            formLoginMethod.fillingControl();
		}
	}
/* ------------------------------------------------------ *\
    [Variables] var
\* ------------------------------------------------------ */
/*
    var $password, $email, $btnSend, full, logged;
    logged = false;
    full = false;
    $email = $('#inputEmail');
    $password = $('#inputPassword');

    $btnSend = $('.enviar.button.blue');
    full = ($email.val(), $password.val()) ? true : false;
*/
/* ------------------------------------------------------ *\
    [onSubmit function] $.submit_login_form
\* ------------------------------------------------------ */
/*
    $.submit_login_form = function() {
        form_errors = 0;
        if(!full) {
	        if (!$.validate_input($email) || !$.validate_input($password)) {
	            form_errors++;
	            $('#inputEmail').focus();
        		$('#inputPassword').val('');
	            swal({   title: "Oops...",   text: "Los datos son requeridos",   type: "error",   timer: 1500,   showConfirmButton: false });
	        }
        }


        if (form_errors == 0) {
            setTimeout(function() {
                swal({   title: "Genial...",   text: 'Los datos son correctos... Espera un momento...',   type: "success",   timer: 1500,   showConfirmButton: false });
                setTimeout(function() {
                    var data = {
                        email       : $('#inputEmail').val(),
                        p           : hex_sha512($password.val())
                    }
                    var service_url = 'process_login.php';
                    $.ajax({
                        cache: false,
                        data: data,
                        dataType: 'html',
                        method: 'POST',
                        success: function (data) {
                            if (data) {
                                setTimeout(function() {
                                    swal({   title: "Genial...",   text: "Bienvenido.",   type: "success",   showConfirmButton: true });
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
            }, 1300);
        }
    }
*/