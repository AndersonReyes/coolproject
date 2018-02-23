
function post_form() {
    var form = document.getElementById("login-form");
    var db_text = document.getElementById("db-text");
    var njit_text = document.getElementById("njit-text");
    var user = document.getElementsByName("user")[0];
    var pass = document.getElementsByName("pass")[0];
    var form_data = new FormData();

    form_data.append(user.name, user.value);
    form_data.append(pass.name, pass.value);

    var post = new XMLHttpRequest();

    post.onreadystatechange = function() {
        // On ready
        if (post.readyState === 4) {

            // success
            if (post.status === 200) {
                var result = JSON.parse(post.responseText);

            } else {
                db_text.innerHTML = post.responseText;
            }

            form.reset();

        }
    };

    post.open("POST", form.getAttribute("action"), true);
    post.send(form_data);
}

