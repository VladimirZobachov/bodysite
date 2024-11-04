function openOrderCallForm() {
    document.getElementById('order-call-modal').style.display = 'block';
}

function closeOrderCallForm() {
    document.getElementById('order-call-modal').style.display = 'none';
}

function submitOrderCallForm() {
    var name = document.getElementById('name').value;
    var phone = document.getElementById('phone').value;
    var email = document.getElementById('email').value;
    var time = document.getElementById('time').value;

    if (!name || !phone || !email || !time) {
        alert('All fields are required.');
        return;
    }

    fetch('/ordercall/ajaxOrderCall/', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name: name, phone: phone, email: email, time: time }),
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            closeOrderCallForm();
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

