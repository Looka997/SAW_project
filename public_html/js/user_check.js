let username = document.getElementById("username");
let email = document.getElementById("email");
let submit = document.getElementById("submit");
let form = document.getElementById("registerForm");


let fetch_post = (value, callback) => {
    fetch("api/user_check.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: value
    })
    .then(response => response.json())
    .then(data => {
        callback(data)
    });
};


// email e username sono true quando non sono unici
let valid = (data) => {
    return !(data.email || data.username);
};

email.addEventListener("blur", () => {
    let value = "email=" + email.value;
    fetch_post(value, (data) => {
        submit.disabled = !valid(data);
    });
});

username.addEventListener("blur", () => {
    let value = "username=" + username.value;
    fetch_post(value, (data) => {
        submit.disabled = !valid(data);
    });
});

form.addEventListener("submit",(event) => {
    event.preventDefault();
    let value = "email=" + email.value + "&" + "username=" + username.value;
    fetch_post(value, (data) => {
        submit.disabled = !valid(data);
    });
})

