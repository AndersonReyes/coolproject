function search_query(query, id) {
    var list_items = document.getElementById(id).getElementsByTagName("li");
    for (var item of list_items) {
        // If query is not in list then hide it other wise display it
        if (item.textContent.toLowerCase().indexOf(query) === -1) {
            item.style.display = "none";
        } else {
            item.style.display = "";
        }
    }
}


function update_quiz_questions(id, quiz_creator_id) {
    var list_items = document.getElementById(id).getElementsByTagName("input");
    var quiz_creator = document.getElementById(quiz_creator_id);
    // TODO: Figure out how to improve this as opposed to re insert all the li's each time and also make it sort all the checked items at the top then the rest
    quiz_creator.innerHTML = "";

    for (var item of list_items) {
        if (item.checked) {
            quiz_creator.innerHTML += "<li>" + item.value +  "<input type='hidden' name='questions[]' value='" + item.value + "'><input type='number' style='width: 50px; margin-left: 1em;' name='points[]' value='" + 10 + "'></li>";
        }
    } 
}

function reset_question_list(quiz_question_list_id, question_list_id) {
    // Clear question list checked for quiz
    document.getElementById(quiz_question_list_id).innerHTML = "";

    // Now reset the checkboxed boxes on the right panel (question bank) 
    var list_items = document.getElementById(question_list_id).getElementsByTagName("input");
    for (var item of list_items) {
        item.checked = false;
    }
}

function display_graded_quiz(row, dest_element_id) {
    var cols = ["student_id", "quiz_name", "grade"];
    var data = row.getElementsByTagName("td");
    var quiz_data = {}
    for (var i = 0; i < cols.length; i++) {
        var obj = {};
        quiz_data[cols[i]] = data[i].textContent;
    }

    send_post(quiz_data, "../components/grading.php", dest_element_id);
}

function send_post(data, dest_php, dest_element_id) {

    var form_data = new FormData();

    for (var data_name in data) {
        form_data.append(data_name, data[data_name]);
    }


    var post = new XMLHttpRequest();

    post.onreadystatechange = function() {
        // On ready
        if (post.readyState === 4) {

            // if failed display error
            if (post.status !== 200) {
                db_text.innerHTML = post.responseText;
            } else {
                document.getElementById(dest_element_id).innerHTML = post.responseText;
            }
        }
    };

    post.open("POST", dest_php, true);
    post.send(form_data);
}

function display_graded_quiz(elem, id) {
    console.log(elem);
}