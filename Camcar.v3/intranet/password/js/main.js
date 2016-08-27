$(document).ready(function() {
    /* ------------------------------------------------------ *\
        EVENT CONTROL
    \* ------------------------------------------------------ */
        $password.on('focusout', function () {
            $.validate_input($password);
        });
        $conf_password.on('focusout', function () {
            $.validate_input($conf_password);
        });
});