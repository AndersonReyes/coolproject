function search_questions(i) {
    var query = document.getElementById("question-list-seach-box").value.toLowerCase();
    var diff = document.getElementById("difficulty_search").value;
    // Grap from list itemm 1 to n because first row is header
    var mult_queries = query.split(", ");
    var list_items = Array.from(document.getElementById("creator-question-list").getElementsByTagName("tr"));
    var list_items = list_items.slice(1);
    for (var item of list_items){


        // topics
        var topics_index = 2;
        var diff_index = 1;
        if (document.title === "quiz Bank") {
            topics_index = 3;
            diff_index = 2;
        }
        var topics = item.cells[topics_index].innerHTML;
        var item_diff = item.cells[diff_index].innerHTML;
        // If query is not in list then hide it other wise display i
        var has_topics = mult_queries.some(function(elem, index, array) {
            return topics.indexOf(elem) >= 0;
        });

        if (has_topics && (diff === "all" || item_diff === diff)) {
            item.style.display = "";
        } else {
            item.style.display = "none";
        }
    }
}

function search_difficulty(diff, id) {
    console.log(diff);
    var list_items = Array.from(document.getElementById(id).getElementsByTagName("tr"));
    var list_items = list_items.slice(1);
    for (var item of list_items) {
        // If item is already hidden by previous search skip it.
        if (item.style.display === "none") {
            continue;
        }

        var difficulty = item.cells[1].innerHTML;
        if (diff === difficulty|| diff === "all") {
            item.style.display = "";
        } else {
            item.style.display = "none";
        }
    }
}


function add_quiz_questions() {
    var list_items = document.getElementById("creator-question-list").getElementsByTagName("input");
    var quiz_creator = document.getElementById("quiz-questions-to-use");
    // TODO: Figure out how to improve this as opposed to re insert all the li's each time and also make it sort all the checked items at the top then the rest
    quiz_creator.innerHTML = "";

    for (var item of list_items) {
        if (item.checked) {
            quiz_creator.innerHTML += "<li>" + item.value +  "<input type='hidden' name='questions[]' value='" + item.value + "'><input type='number' style='width: 50px; margin-left: 1em;' name='max_points[]' value='" + 10 + "'></li>";
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


function fill_question_for_update(table_row) {
    var question_info = table_row.getElementsByTagName("input");
    var question_name = question_info.old_question_name.value;
    var difficulty = question_info.old_difficulty.value;
    var topics = question_info.old_topics.value;
    var testcases = question_info.old_testcases.value;
    testcases = testcases.split(";").join("\n");
    // add the old question name to find in db
    var form = document.getElementById("add-q-form");
    var old_question_name_tag = form.getElementsByTagName("input").old_question_name;

    if (old_question_name_tag) {
        old_question_name_tag.value = question_name;
    } else {
        form.append(question_info.old_question_name);
    }

    document.getElementById("question-description").innerHTML = question_name;
    document.getElementById("difficulty-select").value = difficulty;
    document.getElementById("topics-input").value = topics;
    document.getElementById("testcases-input").value = testcases;

    // Set the type of php curl to update
    document.getElementsByName("type")[0].value = "update_q";
    document.getElementById("submit_btn").value = "Update";

}
