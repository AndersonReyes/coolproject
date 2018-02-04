
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

                if (result.dbresult === "true") {
                    db_text.innerHTML = "Welcome to database services<br>";
                } else {
                    db_text.innerHTML = "No database services<br>";
                }

                if (result.njitresult === "true") {
                    njit_text.innerHTML = "Welcome to njit services<br>";
                } else {
                    njit_text.innerHTML = "No njit services<br>";
                }
                
            } else {
                db_text.innerHTML = post.responseText;
            }

        }
    };

    post.open("POST", form.getAttribute("action"), true);
    post.send(form_data);
}