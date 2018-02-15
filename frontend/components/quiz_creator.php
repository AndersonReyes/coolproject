<div class="editor-content" id="question-editor">
    <h1>Quiz Editor</h1>
    <h3>Quiz name</h3>
    <input class="text-input" type="text" placeholder="quiz name" id="quiz-creator-name"><br>

    <h3>Quiz Questions</h3>
    <ul class="question-list" id="quiz-questions-to-use">
    </ul>

    <div class="horizontal-btn-group">
        <button >Create</button>
        <button onclick="reset_question_list('quiz-questions-to-use', 'quiz-question-list')">Reset</button>
    </div>

    <h3>Created Quiz List</h3>
    <ul class="question-list" id="quiz-list">
        <!-- TODO: Use php loop herere to retrieve created quizzes -->
    </ul>
</div>