function formhash(form, password) {
    //Create a new element input, this will be our hashed password field.
    var p = document.createElement("input");
    //Add the new element to our form.
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
    //Make sure the plaintext password doesn't get sent.
    password.value = "";
    //Finally submit the form.
    form.submit();
}

function pass_formhash(form, iur, email, password, conf) {
    //Check each field has a value
    if(iur.value == '' || email.value == '' || password.value == '' || conf.value == '') {
        alert('Todos los datos son requeridos');
        return false;
    }
    //Check that the password is sufficiently long (min 8 chars)
    //The check is duplicated below, but this is included to give more
    //specific guidance to the user
    //after 8
    if(password.value.length < 8) {
        alert('El password debe tener una longitud mínima de 8 caracteres');
        form.password.focus();
        return false;
    }
    //At least one number, one lowercase and one uppercase letter
    //At least six characters
    //After var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
    //var re = /(?=.*\d)/;
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/
    if(!re.test(password.value)) {
        alert('Tu contaseña debe contener mayúsculas minúsculas y al menos un número');
        return false;
    }
    //Check password and confirmation are the same
    if(password.value != conf.value) {
        alert('La nueva contraseña y la confirmación no coinciden');
        form.password.focus();
        return false;
    }
    //Create a new element input, this will be our hashed password field.
    var p = document.createElement("input");
    //Add the new element to our form.
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
    //Make sure the plaintext password doesn't get sent.
    password.value = "";
    conf.value = "";
    //Finally submit the form.
    form.submit();
    return true;
}