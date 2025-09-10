// Ajax for user login
let login_form = document.getElementById('login-form');
let error_message = document.querySelector('.form .error-message');
let email_field = document.querySelector('.form [name="email"]');
let pass_field = document.querySelector('.form [name="password"]');

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

login_form.addEventListener('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(login_form);
    error_message.classList.remove('show');
    error_message.classList.remove('success');

    fetch('login_process.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(text => {
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                error_message.innerHTML = "Server error: Invalid response";
                error_message.classList.add('show');
                error_message.classList.remove('success');
                return;
            }
            if (data.success) {
                error_message.classList.remove('show');
                error_message.classList.add('success');
                error_message.innerHTML = "Login Success";

                setTimeout(() => {
                    window.location.href = "dashboard.php";
                }, 2000);
            } else {
                error_message.innerHTML = data.message;
                error_message.classList.add('show');
                error_message.classList.remove('success');
            }
        })
        .catch(error => console.error('Error:', error));
});