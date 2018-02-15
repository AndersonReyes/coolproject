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
    // TODO: Figure out how to improve this as opposed to re insert all the li's each time
    quiz_creator.innerHTML = "";

    for (var item of list_items) {
        if (item.checked) {
            quiz_creator.innerHTML += "<li>" + item.value +  "</li>";
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