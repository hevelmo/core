$(document).ready(function() {
    $.fn.serializeFormJSON = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    $('input.input-sign-in').on('keyup', formLoginMethod.keyupInput);
    $('input.validate-required').on('focusout', validateMethods.validate_input);
    //$('input.validate-email').on('blur', validateFieldsMethod.validInputEmail);
    //$('input.validate-input').on('blur', validateFieldsMethod.validInput);
    $('button#goF').on('click', formLoginMethod.clickGo);
});
    /* ------------------------------------------------------ *\
$(document).ready(function() {
        EVENT CONTROL
        $('input.validate-email').on('blur', validateFieldsMethod.validInputEmail);
        $('input.validate-input').on('blur', validateFieldsMethod.validInput);

        $email.on('focusout', function () {
            $.validate_input($email);
        });
        $password.on('focusout', function () {
            $.validate_input($password);
        });
});
    \* ------------------------------------------------------ */