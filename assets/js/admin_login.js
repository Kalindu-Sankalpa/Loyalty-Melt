// Ajax for admin login
let admin_form = document.getElementById('admin-form');
let admin_error_message = document.querySelector('.form .error-message');
let admin_username_field = document.querySelector('.form [name="username"]');
let admin_password_field = document.querySelector('.form [name="password"]');

admin_username_field.addEventListener('keyup', function () {
    if (admin_username_field.value !== '') {
        admin_username_field.classList.add('valid');
    } else {
        admin_username_field.classList.remove('valid');
    }
});

admin_password_field.addEventListener('input', function () {
    if (admin_password_field.value !== '') {
        admin_password_field.classList.add('valid');
    } else {
        admin_password_field.classList.remove('valid');
    }
});

admin_form.addEventListener('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(admin_form);
    admin_error_message.classList.remove('show');
    admin_error_message.classList.remove('success');

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
                admin_error_message.innerHTML = "Server error: Invalid response";
                admin_error_message.classList.add('show');
                admin_error_message.classList.remove('success');
                return;
            }
            if (data.success) {
                admin_error_message.classList.remove('show');
                admin_error_message.classList.add('success');
                admin_error_message.innerHTML = "Login Success";

                setTimeout(() => {
                    window.location.href = "dashboard.php";
                }, 2000);
            } else {
                admin_error_message.innerHTML = data.message;
                admin_error_message.classList.add('show');
                admin_error_message.classList.remove('success');
            }
        })
        .catch(error => console.error('Error:', error));
});
