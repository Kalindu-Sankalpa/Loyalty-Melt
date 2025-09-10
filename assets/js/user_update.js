let update_form = document.getElementById('update-form');


update_form.addEventListener('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(update_form);

    fetch('edit_process.php', {
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
                alert("Server error: Invalid response");
                return;
            }
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
});