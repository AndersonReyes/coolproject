<div class="editor-content" id="question-editor">
    <h1>Quiz Editor</h1>
    <h3>Quiz name</h3>
    <input class="text-input" type="text" placeholder="quiz name" id="quiz-creator-name"><br>

    <h3>Quiz Questions</h3>
    <ul class="question-list" id="quiz-questions-to-use">
    </ul>

    <div class="horizontal-btn-group">
        <button>Create</button>
        <button onclick="reset_question_list('quiz-questions-to-use', 'quiz-question-list')">Reset</button>
    </div>

    <h3>Created Quizzes</h3>
    <table class="table">
        <tr>
            <th>Quiz id</th>
            <th>Quiz name</th>
            <th>Max Points</th>
            <th>Difficulty</th>
        </tr>

        <tr>
            <td>00001</td>
            <td>Test Quiz1</td>
            <td>100</td>
            <td><input type="checkbox"></td>
            
        </tr>
    </table>
</div>