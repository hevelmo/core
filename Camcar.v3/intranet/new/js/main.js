$(document).ready(function() {
    /* ------------------------------------------------------ *\
        EVENT CONTROL
    \* ------------------------------------------------------ */
        //$('input.validate-required').on('focusout', validateMethods.validate_input);
        //$('input.validate-email').on('blur', validateFieldsMethod.validInputEmail);

        $recovery_email.on('focusout', function () {
            $.validate_input($recovery_email);
        });
});