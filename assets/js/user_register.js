let register_form = document.getElementById('register-form');
let error_message = document.querySelector('.form .error-message');
let name_field = document.querySelector('.form [name="name"]');
let email_field = document.querySelector('.form [name="email"]');
let pass_field = document.querySelector('.form [name="password"]');
let confirm_pass_field = document.querySelector('.form [name="confirm_password"]');

name_field.addEventListener('keyup', function () {
    if (name_field.value !== '') {
        name_field.classList.add('valid');
    } else {
        name_field.classList.remove('valid');
    }
});

email_field.addEventListener('keyup', function () {
    if (email_field.value !== '') {
        email_field.classList.add('valid');
    } else {
        email_field.classList.remove('valid');
    }
});

pass_field.addEventListener('input', function () {
    if (pass_field.value !== '') {
        pass_field.classList.add('valid');
    } else {
        pass_field.classList.remove('valid');
    }
});

confirm_pass_field.addEventListener('input', function () {
    if (confirm_pass_field.value !== '') {
        confirm_pass_field.classList.add('valid');
    } else {
        confirm_pass_field.classList.remove('valid');
    }
});

register_form.addEventListener('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(register_form);
    error_message.classList.remove('show');
    error_message.classList.remove('success');

    fetch('register_process.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(text => {
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                console.log(e);
                error_message.innerHTML = "Server error: Invalid response";
                error_message.classList.add('show');
                error_message.classList.remove('success');
                return;
            }
            if (data.success) {
                error_message.classList.remove('show');
                error_message.classList.add('success');
                error_message.innerHTML = "Registration Success";

                setTimeout(() => {
                    window.location.href = "login.php";
                }, 2000);
            } else {
                error_message.innerHTML = data.message;
                error_message.classList.add('show');
                error_message.classList.remove('success');
            }
        })
        .catch(error => console.error('Error:', error));
});